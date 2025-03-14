<?php
include 'header.php';

$errors = [];
$last_name = $first_name = $birth_date = $nationality = $identity_number = $email = $password = $password_confirm = $role = $gender = '';
$active = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $last_name         = trim($_POST['last_name'] ?? '');
    $first_name        = trim($_POST['first_name'] ?? '');
    $birth_date        = trim($_POST['birth_date'] ?? '');
    $nationality       = trim($_POST['nationality'] ?? '');
    $identity_number   = trim($_POST['identity_number'] ?? '');
    $email             = trim($_POST['email'] ?? '');
    $password          = $_POST['password'] ?? '';
    $password_confirm  = $_POST['password_confirm'] ?? '';
    $role              = $_POST['role'] ?? 'user';
    $active            = isset($_POST['active']) ? 1 : 0;
    $gender            = $_POST['gender'] ?? '';

    if (empty($last_name)) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($first_name)) {
        $errors[] = "Le prénom est requis.";
    }
    if (empty($birth_date)) {
        $errors[] = "La date de naissance est requise.";
    }
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email est invalide.";
    }
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $password)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.";
    }
    if ($password !== $password_confirm) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }
    if (empty($gender)) {
        $errors[] = "Le sexe est requis.";
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        $errors[] = "Cet email est déjà utilisé.";
    }

    if (!empty($identity_number)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE identity_number = :identity_number");
        $stmt->execute(['identity_number' => $identity_number]);
        if ($stmt->fetch()) {
            $errors[] = "Ce numéro d'identité est déjà utilisé.";
        }
    }

    $file_name = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['profile_picture']['type'], $allowed_types)) {
            $errors[] = "Le fichier doit être une image (JPEG, PNG, GIF).";
        } elseif ($_FILES['profile_picture']['size'] > 2 * 1024 * 1024) { // Limite 2MB
            $errors[] = "La taille de la photo ne doit pas dépasser 2MB.";
        } else {
            $upload_dir = '../uploads/avatar/';
            $file_name = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
            $upload_file = $upload_dir . $file_name;
            if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_file)) {
                $errors[] = "Erreur lors de l'upload de la photo de profil.";
            }
        }
    }

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users 
                (last_name, first_name, birth_date, nationality, identity_number, email, password, profile_picture, role, active, gender, created_at)
                VALUES (:last_name, :first_name, :birth_date, :nationality, :identity_number, :email, :password, :profile_picture, :role, :active, :gender, NOW())");
            $stmt->execute([
                'last_name'       => $last_name,
                'first_name'      => $first_name,
                'birth_date'      => $birth_date,
                'nationality'     => $nationality,
                'identity_number' => $identity_number,
                'email'           => $email,
                'password'        => $hashed_password,
                'profile_picture' => $file_name,
                'role'            => $role,
                'active'          => $active,
                'gender'          => $gender
            ]);

            $newUserId = $pdo->lastInsertId();

            $admin_id = $_SESSION['user_id'] ?? null;
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
            $descriptionLog = "Création de l'utilisateur : " . $email;
            $stmtLog = $pdo->prepare("INSERT INTO logs 
                (user_id, action_type, table_name, record_id, description, ip_address) 
                VALUES (:user_id, 'CREATE', 'users', :record_id, :description, :ip_address)");
            $stmtLog->execute([
                'user_id'   => $admin_id,
                'record_id' => $newUserId,
                'description' => $descriptionLog,
                'ip_address'  => $ip_address
            ]);

            $pdo->commit();

            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    createAlert("success", "Succès", "Utilisateur créé avec succès !");
                });
            </script>';
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    createAlert("error", "Erreur", "Erreur lors de la création de l\'utilisateur : ' . addslashes($e->getMessage()) . '");
                });
            </script>';
        }
    } else {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {';
        foreach ($errors as $error) {
            echo 'createAlert("error", "Erreur", "' . addslashes($error) . '");';
        }
        echo '});
        </script>';
    }
}
?>
<div class="dashboard-content">
    <div class="page-header">
        <h1>Ajouter un utilisateur</h1>
        <p>Créer un nouveau compte utilisateur</p>
    </div>
    <div class="alert-container"></div>
    <div class="form-container">
        <form id="userForm" method="POST" enctype="multipart/form-data">
            <!-- Photo de profil -->
            <div class="form-group span-3">
                <label class="form-label">Photo de profil</label>
                <div class="profile-upload" id="profileUpload">
                    <div class="profile-preview" id="profilePreview">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="upload-text">
                        <h4>Télécharger une photo</h4>
                        <p>JPG, PNG ou GIF, taille maximale 2MB</p>
                    </div>
                    <input type="file" id="profileInput" name="profile_picture" hidden accept="image/*">
                </div>
            </div>

            <!-- Informations personnelles -->
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-input" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Prénom</label>
                    <input type="text" class="form-input" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Date de naissance</label>
                    <input type="date" class="form-input" name="birth_date" value="<?= htmlspecialchars($birth_date) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nationalité</label>
                    <input type="text" class="form-input" name="nationality" value="<?= htmlspecialchars($nationality) ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Numéro d'identité</label>
                    <input type="text" class="form-input" name="identity_number" value="<?= htmlspecialchars($identity_number) ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" name="email" value="<?= htmlspecialchars($email) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" class="form-input" name="password" value="<?= htmlspecialchars($password) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-input" name="password_confirm" value="<?= htmlspecialchars($password_confirm) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Rôle</label>
                    <select class="form-input" name="role" required>
                        <option value="user" <?= $role == 'user' ? 'selected' : '' ?>>Utilisateur</option>
                        <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Administrateur</option>
                    </select>
                </div>
                <div class="form-group full-width">
                    <label>Sexe</label>
                    <div class="gender-options">
                        <label class="gender-option">
                            <input type="radio" name="gender" value="male" <?= $gender == 'male' ? 'checked' : '' ?>>
                            <span>Homme</span>
                        </label>
                        <label class="gender-option">
                            <input type="radio" name="gender" value="female" <?= $gender == 'female' ? 'checked' : '' ?>>
                            <span>Femme</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Statut -->
            <div class="form-group">
                <div class="switch-container">
                    <label class="form-label">Statut du compte</label>
                    <label class="switch">
                        <input type="checkbox" name="active" <?= $active ? 'checked' : '' ?>>
                        <span class="slider"></span>
                    </label>
                    <span>Actif</span>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <button type="button" class="cancel-btn">Annuler</button>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-user-plus"></i>
                    Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>
</main>
</div>
<script src="main.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileUpload = document.getElementById('profileUpload');
    const profileInput = document.getElementById('profileInput');
    const profilePreview = document.getElementById('profilePreview');
    profileUpload.addEventListener('click', () => profileInput.click());
    profileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
</body>
</html>