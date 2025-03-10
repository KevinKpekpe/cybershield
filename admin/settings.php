<?php include 'header.php'; ?>
        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Rechercher...">
                </div>
                
                <div class="header-right">
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
                                <li><hr class="dropdown-divider"></li>
                                <li><a href="#logout" class="logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="dashboard-content">
                <div class="page-header">
                    <h1>Paramètres</h1>
                    <p>Gérer les paramètres de l'application</p>
                </div>

                <div class="settings-container">
                    <nav class="settings-nav">
                        <ul class="settings-nav-list">
                            <li class="settings-nav-item active" data-tab="general">
                                <i class="fas fa-cog"></i> Général
                            </li>
                            <li class="settings-nav-item" data-tab="security">
                                <i class="fas fa-shield-alt"></i> Sécurité
                            </li>
                            <li class="settings-nav-item" data-tab="notifications">
                                <i class="fas fa-bell"></i> Notifications
                            </li>
                            <li class="settings-nav-item" data-tab="appearance">
                                <i class="fas fa-paint-brush"></i> Apparence
                            </li>
                        </ul>
                    </nav>

                    <div class="settings-content">
                        <!-- Section Général -->
                        <div class="settings-section active" id="general">
                            <h2 class="settings-section-title">Paramètres généraux</h2>
                            
                            <div class="settings-group">
                                <div class="settings-group-header">
                                    <h3 class="settings-group-title">Informations de l'application</h3>
                                </div>
                                <div class="settings-group-description">
                                    Configurez les informations de base de l'application
                                </div>

                                <div class="form-row">
                                    <div class="form-row-label">
                                        <div class="form-row-title">Nom de l'application</div>
                                        <div class="form-row-description">Le nom qui sera affiché partout dans l'application</div>
                                    </div>
                                    <div class="form-row-content">
                                        <input type="text" class="form-input" value="CyberShield">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row-label">
                                        <div class="form-row-title">Langue par défaut</div>
                                        <div class="form-row-description">La langue utilisée par défaut dans l'application</div>
                                    </div>
                                    <div class="form-row-content">
                                        <select class="form-select">
                                            <option value="fr">Français</option>
                                            <option value="en">English</option>
                                            <option value="es">Español</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="settings-group">
                                <div class="settings-group-header">
                                    <h3 class="settings-group-title">Paramètres de session</h3>
                                </div>
                                <div class="settings-group-description">
                                    Gérez les paramètres de session des utilisateurs
                                </div>

                                <div class="form-row">
                                    <div class="form-row-label">
                                        <div class="form-row-title">Durée de session</div>
                                        <div class="form-row-description">Durée avant la déconnexion automatique</div>
                                    </div>
                                    <div class="form-row-content">
                                        <select class="form-select">
                                            <option value="30">30 minutes</option>
                                            <option value="60">1 heure</option>
                                            <option value="120">2 heures</option>
                                            <option value="240">4 heures</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Sécurité -->
                        <div class="settings-section" id="security">
                            <h2 class="settings-section-title">Paramètres de sécurité</h2>
                            
                            <div class="settings-group">
                                <div class="settings-group-header">
                                    <h3 class="settings-group-title">Authentification</h3>
                                </div>

                                <div class="form-row">
                                    <div class="form-row-label">
                                        <div class="form-row-title">Double authentification</div>
                                        <div class="form-row-description">Activer la 2FA pour tous les utilisateurs</div>
                                    </div>
                                    <div class="form-row-content">
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row-label">
                                        <div class="form-row-title">Complexité du mot de passe</div>
                                        <div class="form-row-description">Niveau minimum requis pour les mots de passe</div>
                                    </div>
                                    <div class="form-row-content">
                                        <select class="form-select">
                                            <option value="low">Basique</option>
                                            <option value="medium" selected>Moyen</option>
                                            <option value="high">Élevé</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Notifications -->
                        <div class="settings-section" id="notifications">
                            <h2 class="settings-section-title">Paramètres des notifications</h2>
                            
                            <div class="settings-group">
                                <div class="settings-group-header">
                                    <h3 class="settings-group-title">Notifications par email</h3>
                                </div>

                                <div class="form-row">
                                    <div class="form-row-label">
                                        <div class="form-row-title">Nouvelles connexions</div>
                                        <div class="form-row-description">Notification lors d'une nouvelle connexion</div>
                                    </div>
                                    <div class="form-row-content">
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row-label">
                                        <div class="form-row-title">Rapports hebdomadaires</div>
                                        <div class="form-row-description">Envoi des rapports d'activité hebdomadaires</div>
                                    </div>
                                    <div class="form-row-content">
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Apparence -->
                        <div class="settings-section" id="appearance">
                            <h2 class="settings-section-title">Paramètres d'apparence</h2>
                            
                            <div class="settings-group">
                                <div class="settings-group-header">
                                    <h3 class="settings-group-title">Thème</h3>
                                </div>

                                <div class="form-row">
                                    <div class="form-row-label">
                                        <div class="form-row-title">Mode sombre</div>
                                        <div class="form-row-description">Activer le thème sombre</div>
                                    </div>
                                    <div class="form-row-content">
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row-label">
                                        <div class="form-row-title">Couleur principale</div>
                                        <div class="form-row-description">Couleur d'accent de l'interface</div>
                                    </div>
                                    <div class="form-row-content">
                                        <select class="form-select">
                                            <option value="blue">Bleu</option>
                                            <option value="green">Vert</option>
                                            <option value="purple">Violet</option>
                                            <option value="red">Rouge</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="settings-actions">
                        <button class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                            Réinitialiser
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des onglets
            const navItems = document.querySelectorAll('.settings-nav-item');
            const sections = document.querySelectorAll('.settings-section');

            navItems.forEach(item => {
                item.addEventListener('click', () => {
                    const tabId = item.dataset.tab;
                    
                    // Activer/désactiver les onglets
                    navItems.forEach(nav => nav.classList.remove('active'));
                    item.classList.add('active');
                    
                    // Afficher/masquer les sections
                    sections.forEach(section => {
                        section.classList.remove('active');
                        if (section.id === tabId) {
                            section.classList.add('active');
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>