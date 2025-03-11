<?php
if (file_exists('config/db.php')) {
    include 'config/db.php';
} else {
    die('Fichier de configuration de la base de données non trouvé.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birth_date = $_POST['birth_date'];
    $nationality = isset($_POST['nationality']) ? $_POST['nationality'] : null;
    $identity_number = isset($_POST['identity_number']) && !empty($_POST['identity_number']) ? $_POST['identity_number'] : null;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = $_POST['gender'];
    $profile_pic = $_FILES['profile_pic'];

    $errors = [];

    if (empty($firstname)) {
        $errors[] = "Le prénom est requis.";
    }
    if (empty($lastname)) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($birth_date)) {
        $errors[] = "La date de naissance est requise.";
    }
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email est invalide.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $errors[] = "Cet email est déjà utilisé.";
        }
    }

    if (!empty($identity_number)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE identity_number = :identity_number");
        $stmt->execute(['identity_number' => $identity_number]);
        if ($stmt->fetch()) {
            $errors[] = "Ce numéro d'identité est déjà utilisé.";
        }
    }
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }
    if (empty($gender)) {
        $errors[] = "Le sexe est requis.";
    }

    $file_name = null;
    if ($profile_pic['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($profile_pic['type'], $allowed_types)) {
            $errors[] = "Le fichier doit être une image (JPEG, PNG, GIF).";
        } else {
            $upload_dir = './uploads/avatar/';
            $file_name = uniqid() . '_' . basename($profile_pic['name']);
            $upload_file = $upload_dir . $file_name;
            if (!move_uploaded_file($profile_pic['tmp_name'], $upload_file)) {
                $errors[] = "Erreur lors de l'upload de la photo de profil.";
            }
        }
    }

    if (empty($errors)) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (last_name, first_name, birth_date, nationality, identity_number, email, gender, password, profile_picture, created_at) 
                                VALUES (:lastname, :firstname, :birth_date, :nationality, :identity_number, :email, :gender, :password, :profile_picture, NOW())");
            $stmt->execute([
                'lastname' => $lastname,
                'firstname' => $firstname,
                'birth_date' => $birth_date,
                'nationality' => $nationality,
                'identity_number' => $identity_number,
                'email' => $email,
                'gender' => $gender,
                'password' => $hashed_password,
                'profile_picture' => $file_name
            ]);

            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    createAlert("success", "Succès", "Inscription réussie ! Redirection...");
                });
            </script>';
            
            header("refresh:2;url=login.php");
            exit;
        } catch (PDOException $e) {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    createAlert("error", "Erreur", "Erreur lors de l\'inscription : '.addslashes($e->getMessage()).'");
                });
            </script>';
        }
    }

    if (!empty($errors)) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {';
        foreach ($errors as $error) {
            echo 'createAlert("error", "Erreur", "'.addslashes($error).'");';
        }
        echo '});
        </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CyberShield</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/auth-register.css">
</head>
<body>
    <div class="alert-container"></div>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h2>Créez votre compte</h2>
                <p>Remplissez le formulaire ci-dessous pour vous inscrire</p>
            </div>
            
            <form id="registerForm" action="register.php" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="firstname">Prénom</label>
                        <input type="text" id="firstname" name="firstname"  placeholder="John">
                    </div>
                    
                    <div class="form-group">
                        <label for="lastname">Nom</label>
                        <input type="text" id="lastname" name="lastname" placeholder="Doe">
                    </div>

                    <div class="form-group">
                        <label for="birth_date">Date de naissance</label>
                        <input type="date" id="birth_date" name="birth_date" >
                    </div>

                    <div class="form-group">
                        <label for="nationality">Nationalité</label>
                        <input type="text" id="nationality" name="nationality" placeholder="Française">
                    </div>

                    <div class="form-group">
                        <label for="identity_number">Numéro d'identité</label>
                        <input type="text" id="identity_number" name="identity_number" placeholder="Ex : 123456789">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="john.doe@example.com">
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <div class="password-group">
                            <input type="password" name="password" id="password" placeholder="••••••••">
                            <span class="password-toggle">👁️</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirmer</label>
                        <div class="password-group">
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••">
                            <span class="password-toggle">👁️</span>
                        </div>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label>Sexe</label>
                    <div class="gender-options">
                        <label class="gender-option">
                            <input type="radio" name="gender" value="male" >
                            <span>Homme</span>
                        </label>
                        <label class="gender-option">
                            <input type="radio" name="gender" value="female">
                            <span>Femme</span>
                        </label>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label>Photo de profil</label>
                    <div class="profile-upload">
                        <div class="profile-preview">
                            <img id="preview" src="#" alt="Preview" style="display: none;">
                        </div>
                        <input type="file" name="profile_pic" id="profile_pic" accept="image/*" style="display: none;">
                        <button type="button" class="upload-btn" onclick="document.getElementById('profile_pic').click()">
                            Choisir une photo
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">S'inscrire</button>
            </form>
            
            <div class="auth-footer">
                <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
            </div>
        </div>
    </div>
    <script src="assets/main.js"></script>
</body>
</html>