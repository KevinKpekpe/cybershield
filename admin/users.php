<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberShield - Utilisateurs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styles spécifiques pour la page utilisateurs */
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .table-actions {
            display: flex;
            gap: 1rem;
        }

        .add-button {
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .export-button {
            background: var(--secondary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .add-button:hover, .export-button:hover {
            opacity: 0.9;
        }

        .table-container {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .table-filters {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-label {
            font-size: 0.875rem;
            color: #374151;
            font-weight: 500;
        }

        .filter-input {
            padding: 0.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            outline: none;
            transition: var(--transition);
        }

        .filter-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
        }

        .users-table th,
        .users-table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .users-table th {
            background: #f9fafb;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            user-select: none;
        }

        .users-table th:hover {
            background: #f3f4f6;
        }

        .users-table tr:hover {
            background: #f9fafb;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 500;
            color: #111827;
        }

        .user-email {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-button {
            padding: 0.5rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .edit-btn {
            background: #e5e7eb;
            color: #374151;
        }

        .delete-btn {
            background: #fee2e2;
            color: #991b1b;
        }

        .table-footer {
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        .table-info {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
        }

        .pagination-button {
            padding: 0.5rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            background: white;
            cursor: pointer;
            transition: var(--transition);
        }

        .pagination-button:hover {
            background: #f3f4f6;
        }

        .pagination-button.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
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
                                <li><hr class="dropdown-divider"></li>
                                <li><a href="#logout" class="logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="dashboard-content">
                <div class="page-header">
                    <h1>Gestion des Utilisateurs</h1>
                    <p>Liste et gestion des utilisateurs de la plateforme</p>
                </div>

                <div class="table-header">
                    <div class="table-actions">
                        <button class="add-button">
                            <i class="fas fa-user-plus"></i>
                            Ajouter un utilisateur
                        </button>
                        <button class="export-button">
                            <i class="fas fa-file-export"></i>
                            Exporter
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <div class="table-filters">
                        <div class="filter-group">
                            <label class="filter-label">Rechercher</label>
                            <input type="text" class="filter-input" placeholder="Nom, email...">
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Rôle</label>
                            <select class="filter-input">
                                <option value="">Tous les rôles</option>
                                <option value="admin">Administrateur</option>
                                <option value="user">Utilisateur</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Statut</label>
                            <select class="filter-input">
                                <option value="">Tous les statuts</option>
                                <option value="active">Actif</option>
                                <option value="inactive">Inactif</option>
                            </select>
                        </div>
                    </div>

                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Rôle</th>
                                <th>Dernière connexion</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <img src="https://ui-avatars.com/api/?name=John+Doe" alt="John Doe" class="user-avatar">
                                        <div class="user-details">
                                            <span class="user-name">John Doe</span>
                                            <span class="user-email">john.doe@example.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Administrateur</td>
                                <td>Il y a 2 heures</td>
                                <td>
                                    <span class="status-badge status-active">
                                        <i class="fas fa-circle"></i>
                                        Actif
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-button edit-btn" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-button delete-btn" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Répéter pour chaque utilisateur -->
                        </tbody>
                    </table>

                    <div class="table-footer">
                        <div class="table-info">
                            Affichage de 1 à 10 sur 100 utilisateurs
                        </div>
                        <div class="pagination">
                            <button class="pagination-button"><i class="fas fa-chevron-left"></i></button>
                            <button class="pagination-button active">1</button>
                            <button class="pagination-button">2</button>
                            <button class="pagination-button">3</button>
                            <button class="pagination-button"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="main.js"></script>
</body>
</html>