<?php include 'header.php'; ?>
            <div class="dashboard-content">
                <div class="page-header">
                    <h1>Ajouter un type de phishing</h1>
                    <p>Créer un nouveau type de phishing avec ses caractéristiques et protections</p>
                </div>
                <div class="form-container">
                    <form id="phishingForm">
                        <!-- Section principale -->
                        <div class="form-section">
                            <div class="form-grid">
                                <!-- Titre et Statut sur la même ligne -->
                                <div class="form-group form-grid-2">
                                    <label class="form-label">Titre</label>
                                    <input type="text" class="form-input" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Statut</label>
                                    <div class="switch-container">
                                        <label class="switch">
                                            <input type="checkbox" name="active" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>Actif</span>
                                    </div>
                                </div>

                                <!-- Description sur toute la largeur -->
                                <div class="form-group form-grid-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-input" name="description" required></textarea>
                                </div>

                                <!-- Image sur toute la largeur -->
                                <div class="form-group form-grid-3">
                                    <label class="form-label">Image</label>
                                    <div class="image-upload">
                                        <input type="file" id="imageInput" name="image" hidden accept="image/*">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p class="image-upload-text">Cliquez ou glissez une image ici</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Caractéristiques et Protections -->
                        <div class="form-section">
                            <div class="dynamic-fields-container">
                                <!-- Caractéristiques -->
                                <div class="dynamic-section">
                                    <h3 class="form-label">Caractéristiques</h3>
                                    <div id="characteristicsContainer" class="dynamic-fields">
                                        <div class="dynamic-field">
                                            <input type="text" class="form-input" name="characteristics[]"
                                                placeholder="Caractéristique" required>
                                            <button type="button" class="remove-field">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" class="add-field" id="addCharacteristic">
                                        <i class="fas fa-plus"></i>
                                        Ajouter une caractéristique
                                    </button>
                                </div>

                                <!-- Protections -->
                                <div class="dynamic-section">
                                    <h3 class="form-label">Protections</h3>
                                    <div id="protectionsContainer" class="dynamic-fields">
                                        <div class="dynamic-field">
                                            <input type="text" class="form-input" name="protections[]"
                                                placeholder="Protection" required>
                                            <button type="button" class="remove-field">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" class="add-field" id="addProtection">
                                        <i class="fas fa-plus"></i>
                                        Ajouter une protection
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="form-actions">
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-save"></i>
                                Enregistrer
                            </button>
                            <button type="button" class="cancel-btn">
                                <i class="fas fa-times"></i>
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gestion de l'upload d'image
            const imageUpload = document.querySelector('.image-upload');
            const imageInput = document.getElementById('imageInput');

            imageUpload.addEventListener('click', () => imageInput.click());
            imageUpload.addEventListener('dragover', (e) => {
                e.preventDefault();
                imageUpload.style.borderColor = getComputedStyle(document.documentElement).getPropertyValue('--primary');
            });
            imageUpload.addEventListener('dragleave', (e) => {
                e.preventDefault();
                imageUpload.style.borderColor = '#e5e7eb';
            });
            imageUpload.addEventListener('drop', (e) => {
                e.preventDefault();
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    imageInput.files = files;
                }
            });

            // Fonction pour ajouter un champ dynamique
            function addDynamicField(containerId, placeholder) {
                const container = document.getElementById(containerId);
                const field = document.createElement('div');
                field.className = 'dynamic-field';
                field.innerHTML = `
                    <input type="text" class="form-input" name="${containerId === 'characteristicsContainer' ? 'characteristics[]' : 'protections[]'}" 
                           placeholder="${placeholder}" required>
                    <button type="button" class="remove-field">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                container.appendChild(field);

                // Ajouter l'événement de suppression
                field.querySelector('.remove-field').addEventListener('click', () => {
                    field.remove();
                });
            }

            // Événements pour ajouter des champs
            document.getElementById('addCharacteristic').addEventListener('click', () => {
                addDynamicField('characteristicsContainer', 'Ajouter une caractéristique');
            });

            document.getElementById('addProtection').addEventListener('click', () => {
                addDynamicField('protectionsContainer', 'Ajouter une protection');
            });

            // Gestion des suppressions initiales
            document.querySelectorAll('.remove-field').forEach(button => {
                button.addEventListener('click', () => {
                    button.closest('.dynamic-field').remove();
                });
            });

            // Gestion du formulaire
            document.getElementById('phishingForm').addEventListener('submit', (e) => {
                e.preventDefault();
                // Ici, ajoutez votre logique pour envoyer les données au serveur
                console.log('Formulaire soumis');
            });
        });
    </script>
</body>

</html>