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
    <!-- Auth Container -->
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h2>Connectez-vous</h2>
                <p>Entrez vos identifiants pour accéder à votre compte</p>
            </div>
            
            <form id="loginForm">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" required placeholder="votre@email.com">
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="password-group">
                        <input type="password" id="password" required placeholder="••••••••">
                        <span class="password-toggle">👁️</span>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">Se connecter</button>
            </form>
            
            <div class="auth-footer">
                <p>Pas encore de compte ? <a href="register.html">S'inscrire</a></p>
            </div>
        </div>
    </div>
    <script>
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
    </script>
</body>
</html>