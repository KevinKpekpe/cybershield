<?php
include 'header.php';

try {
    // Configuration de la pagination
    $limit = 10; // Nombre de commentaires par page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Page actuelle
    $offset = ($page - 1) * $limit; // Décalage pour la requête SQL

    // Récupérer le terme de recherche
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Requête SQL pour récupérer les commentaires et leurs réponses
    $stmt = $pdo->prepare("
        SELECT 
            c.id,
            c.content,
            c.active,
            c.created_at,
            u.last_name AS user_name,
            pt.title AS phishing_type_title,
            GROUP_CONCAT(cr.content SEPARATOR ' | ') AS replies
        FROM comments c
        LEFT JOIN users u ON c.user_id = u.id
        LEFT JOIN phishing_types pt ON c.phishing_type_id = pt.id
        LEFT JOIN comment_replies cr ON c.id = cr.comment_id AND cr.active = 1
        WHERE c.content LIKE :search OR u.last_name LIKE :search OR pt.title LIKE :search
        GROUP BY c.id, c.content, c.active, c.created_at, u.last_name, pt.title
        ORDER BY c.created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Récupérer les résultats
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Compter le nombre total de commentaires pour la pagination
    $stmtCount = $pdo->prepare("
        SELECT COUNT(*) as total
        FROM comments c
        LEFT JOIN users u ON c.user_id = u.id
        LEFT JOIN phishing_types pt ON c.phishing_type_id = pt.id
        WHERE c.content LIKE :search OR u.last_name LIKE :search OR pt.title LIKE :search
    ");
    $stmtCount->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmtCount->execute();
    $total = $stmtCount->fetchColumn();

    // Calculer le nombre total de pages
    $pages = ceil($total / $limit);
} catch (PDOException $e) {
    echo "Erreur de requête : " . $e->getMessage();
    die();
}

if(isset($_SESSION['success'])){
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                createAlert("success", "Succès", "Suppression Reussie  ! Redirection...");
            })';
    unset($_SESSION['success']);
}
?>

<div class="dashboard-content">
    <!-- En-tête de la page -->
    <div class="page-header">
        <h1>Commentaires</h1>
        <p>Gestion des commentaires sur les types de phishing</p>
    </div>

    <!-- Conteneur du tableau -->
    <div class="table-container">
        <!-- Barre de recherche -->
        <div class="table-search">
            <form method="GET" action="">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Rechercher un commentaire..." value="<?= htmlspecialchars($search) ?>">
                </div>
                <button type="submit" class="add-button">Rechercher</button>
            </form>
        </div>
        <div class="alert-container"></div>
        <!-- Tableau des commentaires -->
        <table class="phishing-table">
            <thead>
                <tr>
                    <th>Contenu</th>
                    <th>Utilisateur</th>
                    <th>Type de Phishing</th>
                    <th>Réponses</th>
                    <th>Date de création</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment) : ?>
                <tr>
                    <td><?= htmlspecialchars($comment['content']) ?></td>
                    <td><?= htmlspecialchars($comment['user_name']) ?></td>
                    <td><?= htmlspecialchars($comment['phishing_type_title']) ?></td>
                    <td><?= $comment['replies'] ? htmlspecialchars($comment['replies']) : 'Aucune réponse' ?></td>
                    <td><?= $comment['created_at'] ?></td>
                    <td>
                        <span class="status-badge <?= $comment['active'] ? 'status-active' : 'status-inactive' ?>">
                            <?= $comment['active'] ? 'Actif' : 'Inactif' ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <!-- Action de suppression uniquement -->
                            <a href="delete-comment.php?id=<?= $comment['id'] ?>" class="action-button delete-btn" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire et ses réponses ?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="table-footer">
            <div class="table-info">
                Affichage de <?= (($page - 1) * $limit + 1) ?> à <?= min($page * $limit, $total) ?> sur <?= $total ?> entrées
            </div>
            <div class="pagination">
                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                    <?php if ($i == $page) : ?>
                        <button class="pagination-button active"><?= $i ?></button>
                    <?php else : ?>
                        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><button class="pagination-button"><?= $i ?></button></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>

<script src="main.js"></script>