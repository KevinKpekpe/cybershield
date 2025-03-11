<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'admin') {
        header('Location: admin/profil.php');
    } else {
        header('Location: profil.php');
    }
    exit;
}

include './config/db.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validation
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide.";
    }

    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    }

    // Si pas d'erreurs, tentative de connexion
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT id, email, password, first_name, last_name, profile_picture, role, active FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Vérifier si le compte est actif
                if (!$user['active']) {
                    $errors[] = "Votre compte est désactivé. Veuillez contacter l'administrateur.";
                } else {
                    // Stocker les informations en session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                    $_SESSION['user_profile_pic'] = $user['profile_picture'];
                    $_SESSION['user_role'] = $user['role'];

                    $success = true;
                    
                    // Redirection en fonction du rôle
                    if ($user['role'] === 'admin') {
                        header('Location: admin/profil.php');
                    } else {
                        header('Location: profil.php');
                    }
                    exit;
                }
            } else {
                $errors[] = "Email ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur de connexion à la base de données.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CyberShield</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/auth-login.css">
</head>
<body>
    <div class="alert-container"></div>
    
    <!-- Auth Container -->
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h2>Connectez-vous</h2>
                <p>Entrez vos identifiants pour accéder à votre compte</p>
            </div>
            
            <form id="loginForm" method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"  placeholder="votre@email.com" 
                        value="<?php echo htmlspecialchars($email ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="password-group">
                        <input type="password" id="password" name="password"  placeholder="••••••••">
                        <span class="password-toggle">👁️</span>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">Se connecter</button>
            </form>
            
            <div class="auth-footer">
                <p>Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
            </div>
        </div>
    </div>
    <script src="assets/main.js"></script>
    <script>
        function createAlert(type, title, message) {
            const alertContainer = document.querySelector('.alert-container');
            
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-floating`;
            
            const icon = type === 'success' 
                ? 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'
                : 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z';
            
            alert.innerHTML = `
                <svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="${icon}" clip-rule="evenodd"/>
                </svg>
                <div class="alert-content">
                    <div class="alert-title">${title}</div>
                    <div class="alert-message">${message}</div>
                </div>
                <button class="alert-close">&times;</button>
            `;
            
            alertContainer.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 5000);
            
            alert.querySelector('.alert-close').addEventListener('click', () => {
                alert.remove();
            });
        }

        // Affichage des erreurs PHP
        <?php
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "createAlert('error', 'Erreur', '" . addslashes($error) . "');\n";
            }
        }
        if ($success) {
            echo "createAlert('success', 'Succès', 'Connexion réussie ! Redirection...');\n";
        }
        ?>

        // Toggle password visibility
        document.querySelector('.password-toggle').addEventListener('click', function() {
            const input = this.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                this.textContent = '👁️‍🗨️';
            } else {
                input.type = 'password';
                this.textContent = '👁️';
            }
        });

        // Validation côté client
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            let hasError = false;

            if (!email) {
                createAlert('error', 'Erreur', 'L\'email est requis.');
                hasError = true;
            } else if (!email.includes('@')) {
                createAlert('error', 'Erreur', 'Veuillez entrer une adresse email valide.');
                hasError = true;
            }

            if (!password) {
                createAlert('error', 'Erreur', 'Le mot de passe est requis.');
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>