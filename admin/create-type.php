<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberShield - Ajouter un type de phishing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>

        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .form-grid-2 {
            grid-column: span 2;
        }

        .form-grid-3 {
            grid-column: span 3;
        }

        .form-container {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
            padding: 2rem;
            width: 100%;
            max-width: 1400px;
            /* Augmenté pour le mode largeur */
            margin: 0 auto;
        }

        /* Ajustement pour les champs dynamiques */
        .dynamic-fields-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .dynamic-section {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 0.5rem;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        textarea.form-input {
            min-height: 120px;
            resize: vertical;
        }

        .image-upload {
            border: 2px dashed #e5e7eb;
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .image-upload:hover {
            border-color: var(--primary);
        }

        .image-upload i {
            font-size: 2rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }

        .image-upload-text {
            color: #6b7280;
        }

        .dynamic-fields {
            margin-top: 1rem;
        }

        .dynamic-field {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .dynamic-field .form-input {
            flex: 1;
        }

        .remove-field {
            background: #fee2e2;
            color: #991b1b;
            border: none;
            border-radius: 0.5rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .remove-field:hover {
            background: #fca5a5;
        }

        .add-field {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: #f3f4f6;
            border: none;
            border-radius: 0.5rem;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .add-field:hover {
            background: #e5e7eb;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .submit-btn {
            background: var(--primary);
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .cancel-btn {
            background: #f3f4f6;
            color: var(--dark);
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .submit-btn:hover {
            background: #4338ca;
        }

        .cancel-btn:hover {
            background: #e5e7eb;
        }

        .switch-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e5e7eb;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: var(--primary);
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="fas fa-shield-alt"></i>
                    <span>CyberShield</span>
                </div>
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <span class="nav-section-title">MENU PRINCIPAL</span>
                    <ul>
                        <li class="active">
                            <a href="#dashboard">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item-dropdown">
                            <a href="#users">
                                <i class="fas fa-users"></i>
                                <span>Utilisateurs</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="#all-users">Tous les utilisateurs</a></li>
                                <li><a href="#add-user">Ajouter un utilisateur</a></li>
                            </ul>
                        </li>
                        <li class="nav-item-dropdown">
                            <a href="#phishing">
                                <i class="fas fa-fish"></i>
                                <span>Types de Phishing</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="#all-types">Tous les types</a></li>
                                <li><a href="#add-type">Ajouter un type</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#analytics">
                                <i class="fas fa-chart-line"></i>
                                <span>Analytiques</span>
                            </a>
                        </li>
                        <li>
                            <a href="#settings">
                                <i class="fas fa-cog"></i>
                                <span>Paramètres</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <span class="nav-section-title">AUTRES</span>
                    <ul>
                        <li>
                            <a href="#help">
                                <i class="fas fa-question-circle"></i>
                                <span>Aide</span>
                            </a>
                        </li>
                        <li>
                            <a href="#contact">
                                <i class="fas fa-envelope"></i>
                                <span>Contact</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Rechercher...">
                </div>

                <div class="header-right">
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </div>
                    <div class="admin-profile">
                        <img src="https://ui-avatars.com/api/?name=John+Doe" alt="Admin" class="admin-avatar">
                        <div class="admin-info">
                            <span class="admin-name">John Doe</span>
                            <span class="admin-role">Administrateur</span>
                        </div>
                        <div class="profile-dropdown">
                            <ul>
                                <li><a href="#profile"><i class="fas fa-user"></i> Mon Profil</a></li>
                                <li><a href="#settings"><i class="fas fa-cog"></i> Paramètres</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a href="#logout" class="logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

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