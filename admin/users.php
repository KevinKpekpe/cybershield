<?php include 'header.php'; ?>            
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