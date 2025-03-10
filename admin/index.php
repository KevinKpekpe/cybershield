<?php include 'header.php'; ?>
            <div class="dashboard-content">
                <div class="page-header">
                    <h1>Tableau de bord</h1>
                    <p>Vue d'ensemble des statistiques</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: var(--primary)">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Utilisateurs Total</h3>
                            <p class="stat-number">1,234</p>
                            <span class="stat-growth positive">
                                <i class="fas fa-arrow-up"></i> +12.5%
                            </span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: var(--secondary)">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Types de Phishing</h3>
                            <p class="stat-number">56</p>
                            <span class="stat-growth positive">
                                <i class="fas fa-arrow-up"></i> +5.2%
                            </span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: var(--danger)">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Alertes Actives</h3>
                            <p class="stat-number">23</p>
                            <span class="stat-growth negative">
                                <i class="fas fa-arrow-down"></i> -2.4%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="recent-activity">
                    <h2>Activités Récentes</h2>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="activity-details">
                                <p>Nouvel utilisateur enregistré</p>
                                <span>Il y a 5 minutes</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="activity-details">
                                <p>Nouvelle alerte de phishing détectée</p>
                                <span>Il y a 15 minutes</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="activity-details">
                                <p>Mise à jour du système</p>
                                <span>Il y a 1 heure</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="main.js"></script>
</body>
</html>