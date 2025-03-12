<?php
include 'header.php';
try {
    $limit = 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $stmt = $pdo->prepare("
        SELECT 
            pt.id,
            pt.title,
            pt.description,
            pt.image,
            pt.active,
            pt.created_at,
            GROUP_CONCAT(DISTINCT c.content SEPARATOR ', ') AS characteristics,
            GROUP_CONCAT(DISTINCT p.content SEPARATOR ', ') AS protections
        FROM phishing_types pt
        LEFT JOIN characteristics c ON pt.id = c.phishing_type_id AND c.active = 1
        LEFT JOIN protections p ON pt.id = p.phishing_type_id AND p.active = 1
        GROUP BY pt.id, pt.title, pt.description, pt.image, pt.active, pt.created_at
        ORDER BY pt.created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $phishingTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtCount = $pdo->prepare("
        SELECT COUNT(*) as total
        FROM phishing_types
    ");
    $stmtCount->execute();
    $total = $stmtCount->fetchColumn();

    $pages = ceil($total / $limit);
} catch(PDOException $e) {
    echo "Erreur de requête : " . $e->getMessage();
    die();
}
?>

<div class="dashboard-content">
    <div class="page-header">
        <h1>Types de Phishing</h1>
        <p>Gestion des différents types de phishing</p>
    </div>

    <div class="table-header">
        <button class="add-button">
            <i class="fas fa-plus"></i>
            <a href="add-phishing-type.php">Ajouter un type</a>
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
                    <th>Caractéristiques</th>
                    <th>Protections</th>
                    <th>Date de création</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($phishingTypes as $phishingType) : ?>
                <tr>
                    <td><?= $phishingType['title'] ?></td>
                    <td><?= $phishingType['description'] ?></td>
                    <td><?= $phishingType['characteristics'] ? $phishingType['characteristics'] : 'Aucune' ?></td>
                    <td><?= $phishingType['protections'] ? $phishingType['protections'] : 'Aucune' ?></td>
                    <td><?= $phishingType['created_at'] ?></td>
                    <td><span class="status-badge <?= $phishingType['active'] ? 'status-active' : 'status-inactive' ?>"><?= $phishingType['active'] ? 'Actif' : 'Inactif' ?></span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="view-phishing-type.php?id=<?= $phishingType['id'] ?>" class="action-button view-btn" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="edit-phishing-type.php?id=<?= $phishingType['id'] ?>" class="action-button edit-btn" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete-phishing-type.php?id=<?= $phishingType['id'] ?>" class="action-button delete-btn" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce type de phishing ?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="table-footer">
            <div class="table-info">
                Affichage de <?= (($page - 1) * $limit + 1) ?> à <?= min($page * $limit, $total) ?> sur <?= $total ?> entrées
            </div>
            <div class="pagination">
                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                <?php if ($i == $page) : ?>
                <button class="pagination-button active"><?= $i ?></button>
                <?php else : ?>
                <a href="?page=<?= $i ?>"><button class="pagination-button"><?= $i ?></button></a>
                <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>