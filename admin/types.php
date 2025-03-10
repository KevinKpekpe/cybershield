<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberShield - Types de Phishing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styles spécifiques pour la page des types de phishing */
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
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

        .add-button:hover {
            background: #4338ca;
        }

        .table-container {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .table-search {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .search-input {
            display: flex;
            align-items: center;
            background: #f3f4f6;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            width: 100%;
            max-width: 400px;
        }

        .search-input input {
            border: none;
            background: none;
            padding: 0.25rem 0.5rem;
            width: 100%;
            outline: none;
        }

        .phishing-table {
            width: 100%;
            border-collapse: collapse;
        }

        .phishing-table th,
        .phishing-table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .phishing-table th {
            background: #f9fafb;
            font-weight: 600;
            color: #374151;
        }

        .phishing-table tr:hover {
            background: #f9fafb;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 500;
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

        .view-btn {
            background: #dbeafe;
            color: #1e40af;
        }

        .action-button:hover {
            opacity: 0.8;
        }

        .table-footer {
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9fafb;
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
        <!-- Le sidebar reste le même -->
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

        <main class="main-content">
            <!-- Le header reste le même -->
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
                    <h1>Types de Phishing</h1>
                    <p>Gestion des différents types de phishing</p>
                </div>

                <div class="table-header">
                    <button class="add-button">
                        <i class="fas fa-plus"></i>
                        Ajouter un type
                    </button>
                </div>

                <div class="table-container">
                    <div class="table-search">
                        <div class="search-input">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Rechercher un type de phishing...">
                        </div>
                    </div>

                    <table class="phishing-table">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Date de création</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Phishing par Email</td>
                                <td>Tentatives de fraude par email imitant des institutions légitimes</td>
                                <td>01/03/2024</td>
                                <td><span class="status-badge status-active">Actif</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-button view-btn" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-button edit-btn" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-button delete-btn" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Répéter pour chaque type de phishing -->
                        </tbody>
                    </table>

                    <div class="table-footer">
                        <div class="table-info">
                            Affichage de 1 à 10 sur 25 entrées
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