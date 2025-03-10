<?php include 'header.php'; ?>
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