<?php
include 'header.php';

// Traitement du formulaire de mise à jour du profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $last_name = trim($_POST['last_name']);
    $first_name = trim($_POST['first_name']);
    $birth_date = $_POST['birth_date'];
    $nationality = trim($_POST['nationality']);
    $email = trim($_POST['email']);

    // Validation des entrées
    if (empty($last_name) || empty($first_name) || empty($birth_date) || empty($email)) {
        $error_message = "Tous les champs obligatoires doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Format d'email invalide.";
    } else {
        try {
            $update_stmt = $pdo->prepare("UPDATE users SET last_name = :last_name, first_name = :first_name, birth_date = :birth_date, nationality = :nationality, email = :email WHERE id = :id");
            $update_stmt->execute([
                'last_name' => $last_name,
                'first_name' => $first_name,
                'birth_date' => $birth_date,
                'nationality' => $nationality,
                'email' => $email,
                'id' => $_SESSION['user_id']
            ]);
            $success_message = "Profil mis à jour avec succès.";
            // Rafraîchir les données de l'utilisateur
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error_message = "Erreur lors de la mise à jour du profil : " . $e->getMessage();
        }
    }
}

// Traitement du formulaire de changement de mot de passe
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation des entrées
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error_message = "Tous les champs sont requis.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "Les nouveaux mots de passe ne correspondent pas.";
    } else {
        // Vérifier le mot de passe actuel
        if (password_verify($current_password, $user['password'])) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            try {
                $update_stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
                $update_stmt->execute(['password' => $hashed_password, 'id' => $_SESSION['user_id']]);
                $success_message = "Mot de passe mis à jour avec succès.";
            } catch (PDOException $e) {
                $error_message = "Erreur lors de la mise à jour du mot de passe : " . $e->getMessage();
            }
        } else {
            $error_message = "Mot de passe actuel incorrect.";
        }
    }
}

// Récupérer l'activité récente (exemple avec une table logs)
try {
    $activity_stmt = $pdo->prepare("SELECT * FROM logs WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 5");
    $activity_stmt->execute(['user_id' => $_SESSION['user_id']]);
    $activities = $activity_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $activities = [];
}
?>
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
                                <div class="info-value"><?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Jamais' ?></div>
                            </div>
                        </div>

                        <div class="profile-status">
                            <div class="status-badge status-<?= $user['active'] ? 'active' : 'inactive' ?>">
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
                            <form id="profileForm" method="POST">
                                <input type="hidden" name="update_profile" value="1">
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
                            <form id="securityForm" method="POST">
                                <input type="hidden" name="update_password" value="1">
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
                                <?php if (!empty($activities)): ?>
                                    <?php foreach ($activities as $activity): ?>
                                        <li class="activity-item">
                                            <div class="activity-icon">
                                                <i class="fas fa-<?= $activity['action_type'] == 'LOGIN' ? 'sign-in-alt' : 'user-edit' ?>"></i>
                                            </div>
                                            <div class="activity-content">
                                                <div class="activity-title"><?= htmlspecialchars($activity['description']) ?></div>
                                                <div class="activity-time"><?= date('d/m/Y H:i', strtotime($activity['created_at'])) ?></div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="activity-item">
                                        <div class="activity-content">
                                            <div class="activity-title">Aucune activité récente</div>
                                        </div>
                                    </li>
                                <?php endif; ?>
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
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    tabContents.forEach(content => {
                        content.classList.remove('active');
                        if (content.id === tabId) {
                            content.classList.add('active');
                        }
                    });
                });
            });

            // Gestion de l'upload de photo (prévisualisation uniquement)
            const profilePhotoInput = document.getElementById('profilePhotoInput');
            const profileImage = document.querySelector('.profile-image');
            profilePhotoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profileImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</body>
</html>