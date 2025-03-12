<?php include 'header.php'; ?>
<div class="dashboard-content">
    <div class="page-header">
        <h1>Profil Utilisateur</h1>
        <p>Voir et modifier les informations du profil</p>
    </div>

    <div class="profile-container">
        <!-- Sidebar du profil -->
        <div class="profile-sidebar">
            <div class="profile-photo">
                <img src="../uploads/avatar/<?= htmlspecialchars($user['profile_picture'] ?? 'default.png') ?>"
                    alt="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>"
                    class="profile-image">
                <input type="file" id="profilePhotoInput" hidden accept="image/*">
                <button class="profile-upload-btn" onclick="document.getElementById('profilePhotoInput').click()">
                    <i class="fas fa-camera"></i>
                    Changer la photo
                </button>
            </div>

            <div class="profile-info">
                <div class="info-group">
                    <div class="info-label">Membre depuis</div>
                    <div class="info-value"><?= date('F Y', strtotime($user['created_at'])) ?></div>
                </div>
                <div class="info-group">
                    <div class="info-label">Dernière connexion</div>
                    <div class="info-value">Il y a 2 heures</div> <!-- À remplacer par une logique réelle -->
                </div>
            </div>

            <div class="profile-status">
                <div class="status-badge status-active">
                    <i class="fas fa-circle"></i>
                    <?= $user['active'] ? 'Actif' : 'Inactif' ?>
                </div>
                <div class="status-role">
                    <?= ucfirst($user['role']) ?>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="profile-main">
            <div class="tab-navigation">
                <button class="tab-button active" data-tab="info">Informations personnelles</button>
                <button class="tab-button" data-tab="security">Sécurité</button>
                <button class="tab-button" data-tab="activity">Activité récente</button>
            </div>

            <!-- Onglet Informations -->
            <div class="tab-content active" id="info">
                <form id="profileForm" action="update_profile.php" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-input" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-input" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Date de naissance</label>
                            <input type="date" class="form-input" name="birth_date" value="<?= htmlspecialchars($user['birth_date']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nationalité</label>
                            <input type="text" class="form-input" name="nationality" value="<?= htmlspecialchars($user['nationality']) ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Numéro d'identité</label>
                            <input type="text" class="form-input" name="identity_number" value="<?= htmlspecialchars($user['identity_number']) ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>

            <!-- Onglet Sécurité -->
            <div class="tab-content" id="security">
                <form id="securityForm" action="update_password.php" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Mot de passe actuel</label>
                            <input type="password" class="form-input" name="current_password" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-input" name="new_password" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-input" name="confirm_password" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-lock"></i>
                            Mettre à jour le mot de passe
                        </button>
                    </div>
                </form>
            </div>

            <!-- Onglet Activité -->
            <div class="tab-content" id="activity">
                <ul class="activity-list">
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Connexion réussie</div>
                            <div class="activity-time">Il y a 2 heures</div>
                        </div>
                    </li>
                    <!-- Ajouter d'autres activités ici -->
                </ul>
            </div>
        </div>
    </div>
</div>

</main>
</div>
<script src="main.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des onglets
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.dataset.tab;

                // Activer/désactiver les boutons
                tabButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                // Afficher/masquer les contenus
                tabContents.forEach(content => {
                    content.classList.remove('active');
                    if (content.id === tabId) {
                        content.classList.add('active');
                    }
                });
            });
        });

        // Gestion de l'upload de photo
        const profilePhotoInput = document.getElementById('profilePhotoInput');
        const profileImage = document.querySelector('.profile-image');

        profilePhotoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
</body>

</html>