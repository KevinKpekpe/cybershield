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
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h2>Créez votre compte</h2>
                <p>Remplissez le formulaire ci-dessous pour vous inscrire</p>
            </div>
            
            <form id="registerForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="firstname">Prénom</label>
                        <input type="text" id="firstname" required placeholder="John">
                    </div>
                    
                    <div class="form-group">
                        <label for="lastname">Nom</label>
                        <input type="text" id="lastname" required placeholder="Doe">
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" required placeholder="+33 6 12 34 56 78">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" required placeholder="john.doe@example.com">
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <div class="password-group">
                            <input type="password" id="password" required placeholder="••••••••">
                            <span class="password-toggle">👁️</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirmer</label>
                        <div class="password-group">
                            <input type="password" id="confirm_password" required placeholder="••••••••">
                            <span class="password-toggle">👁️</span>
                        </div>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label>Sexe</label>
                    <div class="gender-options">
                        <label class="gender-option">
                            <input type="radio" name="gender" value="male" required>
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
                        <input type="file" id="profile_pic" accept="image/*" style="display: none;">
                        <button type="button" class="upload-btn" onclick="document.getElementById('profile_pic').click()">
                            Choisir une photo
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">S'inscrire</button>
            </form>
            
            <div class="auth-footer">
                <p>Déjà inscrit ? <a href="login.html">Se connecter</a></p>
            </div>
        </div>
    </div>
    <script src="assets/main.js"></script>
</body>
</html>