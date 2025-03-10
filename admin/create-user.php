<?php include 'header.php'; ?>
            <div class="dashboard-content">
                <div class="page-header">
                    <h1>Ajouter un utilisateur</h1>
                    <p>Créer un nouveau compte utilisateur</p>
                </div>

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
                                <input type="text" class="form-input" name="last_name" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Prénom</label>
                                <input type="text" class="form-input" name="first_name" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Date de naissance</label>
                                <input type="date" class="form-input" name="birth_date" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nationalité</label>
                                <input type="text" class="form-input" name="nationality">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Numéro d'identité</label>
                                <input type="text" class="form-input" name="identity_number">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" name="email" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" class="form-input" name="password" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Confirmer le mot de passe</label>
                                <input type="password" class="form-input" name="password_confirm" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Rôle</label>
                                <select class="form-input" name="role" required>
                                    <option value="user">Utilisateur</option>
                                    <option value="admin">Administrateur</option>
                                </select>
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="form-group">
                            <div class="switch-container">
                                <label class="form-label">Statut du compte</label>
                                <label class="switch">
                                    <input type="checkbox" name="active" checked>
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

            // Gestion de l'upload de photo de profil
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

            // Validation du formulaire
            document.getElementById('userForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Vérification des mots de passe
                const password = this.password.value;
                const passwordConfirm = this.password_confirm.value;

                if (password !== passwordConfirm) {
                    alert('Les mots de passe ne correspondent pas');
                    return;
                }

                // Ici, ajoutez votre logique pour envoyer les données au serveur
                console.log('Formulaire soumis');
                // this.submit();
            });
        });
    </script>
</body>
</html>