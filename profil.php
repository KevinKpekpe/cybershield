<?php include 'includes/header.php'; ?>

    <section class="hero" style="min-height: 300px;">
        <div class="hero-content">
            <h1>Mon Profil</h1>
            <p>Gérez vos informations personnelles et votre sécurité</p>
        </div>
    </section>

    <section class="profile">
        <div class="profile-container">
            <!-- Section Informations Personnelles -->
            <div class="profile-card">
                <h2 class="section-title">Informations Personnelles</h2>
                <form class="profile-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nom complet</label>
                            <input type="text" value="Jean Dupont" required>
                        </div>
                        <div class="form-group">
                            <label>Adresse email</label>
                            <input type="email" value="jean.dupont@example.com" required>
                        </div>
                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="tel" value="+33 6 12 34 56 78">
                        </div>
                        <div class="form-group">
                            <label>Adresse</label>
                            <input type="text" value="123 Rue de Paris">
                        </div>
                    </div>
                    <button type="submit" class="submit-btn">Mettre à jour</button>
                </form>
            </div>

            <!-- Section Sécurité -->
            <div class="profile-card">
                <h2 class="section-title">Sécurité du Compte</h2>
                <form class="security-form">
                    <div class="form-group">
                        <label>Mot de passe actuel</label>
                        <input type="password" required>
                    </div>
                    <div class="form-group">
                        <label>Nouveau mot de passe</label>
                        <input type="password" required>
                        <small class="password-strength"></small>
                    </div>
                    <div class="form-group">
                        <label>Confirmer le mot de passe</label>
                        <input type="password" required>
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
<?php include 'includes/footer.php'; ?>