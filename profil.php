<?php
include 'includes/header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupération des données de l'utilisateur
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$errors = [];
$success_message = '';

// Traitement de la mise à jour de la photo de profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_picture'])) {
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['profile_pic']['type'], $allowed_types)) {
            $errors[] = "Type de fichier non autorisé. Seules les images JPG, PNG et GIF sont autorisées.";
        } else {
            $upload_dir = 'uploads/avatar/';
            $file_name = basename($_FILES['profile_pic']['name']);
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_file_name = uniqid() . '.' . $ext;
            $destination = $upload_dir . $new_file_name;
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $destination)) {
                try {
                    $update_stmt = $pdo->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");
                    $update_stmt->execute(['profile_picture' => $new_file_name, 'id' => $user_id]);
                    $success_message = "Photo de profil mise à jour avec succès.";
                    // Rafraîchir les données de l'utilisateur
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
                    $stmt->execute(['id' => $user_id]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    $errors[] = "Erreur lors de la mise à jour de la photo de profil : " . $e->getMessage();
                }
            } else {
                $errors[] = "Erreur lors du téléchargement du fichier.";
            }
        }
    } else {
        $errors[] = "Veuillez sélectionner une image à télécharger.";
    }
}

// Traitement de la mise à jour des informations personnelles
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $birth_date = $_POST['birth_date'];
    $nationality = trim($_POST['nationality']);
    $identity_number = trim($_POST['identity_number']);

    if (empty($firstname) || empty($lastname) || empty($email) || empty($birth_date)) {
        $errors[] = "Tous les champs obligatoires doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide.";
    } else {
        try {
            $update_stmt = $pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, birth_date = :birth_date, nationality = :nationality, identity_number = :identity_number WHERE id = :id");
            $update_stmt->execute([
                'first_name'      => $firstname,
                'last_name'       => $lastname,
                'email'           => $email,
                'birth_date'      => $birth_date,
                'nationality'     => $nationality,
                'identity_number' => $identity_number,
                'id'              => $user_id
            ]);
            $success_message = "Informations personnelles mises à jour avec succès.";
            // Rafraîchir les données de l'utilisateur
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de la mise à jour du profil : " . $e->getMessage();
        }
    }
}

// Traitement du changement de mot de passe
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $errors[] = "Tous les champs sont requis.";
    } elseif ($new_password !== $confirm_password) {
        $errors[] = "Les nouveaux mots de passe ne correspondent pas.";
    } else {
        if (password_verify($current_password, $user['password'])) {
            // Regex pour un mot de passe fort :
            // - Au moins 8 caractères
            // - Au moins une majuscule
            // - Au moins un chiffre
            // - Au moins un caractère spécial parmi !@#$%^&*
            $regex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])(?=.{8,})/';
            if (!preg_match($regex, $new_password)) {
                $errors[] = "Le mot de passe doit contenir au moins 8 caractères, dont une majuscule, un chiffre et un caractère spécial (!@#$%^&*).";
            } elseif (password_verify($new_password, $user['password'])) {
                $errors[] = "Le nouveau mot de passe doit être différent de l'ancien.";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                try {
                    $update_stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
                    $update_stmt->execute(['password' => $hashed_password, 'id' => $user_id]);
                    $success_message = "Mot de passe mis à jour avec succès.";
                } catch (PDOException $e) {
                    $errors[] = "Erreur lors de la mise à jour du mot de passe : " . $e->getMessage();
                }
            }
        } else {
            $errors[] = "Mot de passe actuel incorrect.";
        }
    }
}

// Affichage des erreurs et messages de succès via des alertes JavaScript
if (!empty($errors)) {
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {';
    foreach ($errors as $error) {
        echo 'createAlert("error", "Erreur", "' . addslashes($error) . '");';
    }
    echo '});
    </script>';
}

if (!empty($success_message)) {
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        createAlert("success", "Succès", "' . addslashes($success_message) . '");
    });
    </script>';
}
?>



<!-- Affichage de la page -->
<section class="hero" style="min-height: 300px;">
    <div class="hero-content">
        <h1>Mon Profil</h1>
        <p>Gérez vos informations personnelles et votre sécurité</p>
    </div>
</section>
<section class="profile">
    <div class="profile-container">
        <!-- Section Photo de profil -->
        
        <div class="alert-container"></div>
        <div class="profile-card">
            <h2 class="section-title">Photo de profil</h2>
            <form class="profile-picture-form" method="POST" enctype="multipart/form-data">
                <div class="current-profile-picture">
                    <?php if (!empty($user['profile_picture'])): ?>
                        <img src="uploads/avatar/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Photo de profil">
                    <?php else: ?>
                        <div class="profile-placeholder">
                            <?php echo strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Changer la photo de profil</label>
                    <input type="file" name="profile_pic" accept="image/*">
                </div>
                <!-- Champ caché pour identifier l'action -->
                <input type="hidden" name="update_picture" value="1">
                <button type="submit" class="submit-btn">Mettre à jour la photo</button>
            </form>
        </div>

        <!-- Section Informations Personnelles -->
        <div class="profile-card">
            <h2 class="section-title">Informations Personnelles</h2>
            <form class="profile-form" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Prénom</label>
                        <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Adresse email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Date de naissance</label>
                        <input type="date" name="birth_date" value="<?php echo htmlspecialchars($user['birth_date']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Nationalité</label>
                        <input type="text" name="nationality" value="<?php echo htmlspecialchars($user['nationality']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Numéro d'identité</label>
                        <input type="text" name="identity_number" value="<?php echo htmlspecialchars($user['identity_number']); ?>">
                    </div>
                </div>
                <!-- Champ caché pour identifier l'action -->
                <input type="hidden" name="update_profile" value="1">
                <button type="submit" class="submit-btn">Mettre à jour</button>
            </form>
        </div>

        <!-- Section Sécurité -->
        <div class="profile-card">
            <h2 class="section-title">Sécurité du Compte</h2>
            <form class="security-form" method="POST">
                <div class="form-group">
                    <label>Mot de passe actuel</label>
                    <input type="password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label>Nouveau mot de passe</label>
                    <input type="password" name="new_password" id="new_password" required>
                    <small class="password-strength"></small>
                </div>
                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="confirm_password" required>
                </div>
                <div class="form-group">
                    <div class="password-requirements">
                        <p>Le mot de passe doit contenir :</p>
                        <ul>
                            <li class="req-upper">Au moins une majuscule</li>
                            <li class="req-number">Au moins un chiffre</li>
                            <li class="req-special">Au moins un caractère spécial</li>
                            <li class="req-length">Minimum 8 caractères</li>
                        </ul>
                    </div>
                </div>
                <!-- Champ caché pour identifier l'action -->
                <input type="hidden" name="update_password" value="1">
                <button type="submit" class="submit-btn">Changer le mot de passe</button>
            </form>
        </div>
    </div>
</section>

<script>
    // Validation du mot de passe en temps réel
    document.getElementById('new_password').addEventListener('input', function() {
        const password = this.value;
        const requirements = {
            upper: /[A-Z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*]/.test(password),
            length: password.length >= 8
        };

        // Mettre à jour les indicateurs visuels
        document.querySelector('.req-upper').classList.toggle('valid', requirements.upper);
        document.querySelector('.req-number').classList.toggle('valid', requirements.number);
        document.querySelector('.req-special').classList.toggle('valid', requirements.special);
        document.querySelector('.req-length').classList.toggle('valid', requirements.length);

        // Évaluer la force du mot de passe
        let strength = 0;
        Object.values(requirements).forEach(req => {
            if (req) strength++;
        });

        const strengthIndicator = document.querySelector('.password-strength');
        switch (strength) {
            case 0:
            case 1:
                strengthIndicator.textContent = 'Faible';
                strengthIndicator.className = 'password-strength weak';
                break;
            case 2:
            case 3:
                strengthIndicator.textContent = 'Moyen';
                strengthIndicator.className = 'password-strength medium';
                break;
            case 4:
                strengthIndicator.textContent = 'Fort';
                strengthIndicator.className = 'password-strength strong';
                break;
        }
    });

    // Validation du formulaire de sécurité avant soumission
    document.querySelector('.security-form').addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = this.querySelector('input[name="confirm_password"]').value;
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('Les mots de passe ne correspondent pas.');
        }
    });
</script>

<style>
    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    .profile-card {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    .password-requirements ul {
        list-style: none;
        padding: 0;
    }
    .password-requirements li {
        margin: 0.5rem 0;
        color: #666;
    }
    .password-requirements li.valid {
        color: #10B981;
    }
    .password-requirements li::before {
        content: '❌';
        margin-right: 0.5rem;
    }
    .password-requirements li.valid::before {
        content: '✅';
    }
    .password-strength {
        display: block;
        margin-top: 0.5rem;
    }
    .password-strength.weak {
        color: #EF4444;
    }
    .password-strength.medium {
        color: #F59E0B;
    }
    .password-strength.strong {
        color: #10B981;
    }
    .current-profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 1rem;
    }
    .current-profile-picture img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-placeholder {
        width: 100%;
        height: 100%;
        background: #4F46E5;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
    }
</style>

<?php include 'includes/footer.php'; ?>
