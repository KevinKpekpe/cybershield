<?php
include 'includes/header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<section class="hero" style="min-height: 300px;">
    <div class="hero-content">
        <h1>Mon Profil</h1>
        <p>Gérez vos informations personnelles et votre sécurité</p>
    </div>
</section>

<section class="profile">
    <div class="profile-container">
        <!-- Section Photo de profil -->
        <div class="profile-card">
            <h2 class="section-title">Photo de profil</h2>
            <form class="profile-picture-form" method="POST" action="update_profile_picture.php" enctype="multipart/form-data">
                <div class="current-profile-picture">
                    <?php if ($user['profile_picture']): ?>
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
                <button type="submit" class="submit-btn">Mettre à jour la photo</button>
            </form>
        </div>
        <!-- Section Informations Personnelles -->
        <div class="profile-card">
            <h2 class="section-title">Informations Personnelles</h2>
            <form class="profile-form" method="POST" action="update_profile.php">
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
                <button type="submit" class="submit-btn">Mettre à jour</button>
            </form>
        </div>

        <!-- Section Sécurité -->
        <div class="profile-card">
            <h2 class="section-title">Sécurité du Compte</h2>
            <form class="security-form" method="POST" action="update_password.php">
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

    // Validation du formulaire avant soumission
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