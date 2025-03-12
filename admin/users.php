<?php
include 'header.php';

$where = [];
$params = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $where[] = "(last_name LIKE :search OR first_name LIKE :search OR email LIKE :search)";
    $params[':search'] = "%$search%";
}

if (isset($_GET['role']) && !empty($_GET['role'])) {
    $where[] = "role = :role";
    $params[':role'] = $_GET['role'];
}

if (isset($_GET['active']) && $_GET['active'] !== '') {
    $where[] = "active = :active";
    $params[':active'] = $_GET['active'];
}

$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $per_page;

$count_sql = "SELECT COUNT(*) FROM users";
if (!empty($where)) {
    $count_sql .= " WHERE " . implode(" AND ", $where);
}
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_users = $stmt->fetchColumn();
$total_pages = ceil($total_users / $per_page);

$sql = "SELECT * FROM users";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " LIMIT $per_page OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="dashboard-content">
    <div class="page-header">
        <h1>Gestion des Utilisateurs</h1>
        <p>Liste et gestion des utilisateurs de la plateforme</p>
    </div>

    <div class="table-header">
        <div class="table-actions">
            <button class="add-button" onclick="window.location.href='create-user.php'">
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
        <form method="get" action="users.php">
            <div class="table-filters">
                <div class="filter-group">
                    <label class="filter-label">Rechercher</label>
                    <input type="text" name="search" class="filter-input" placeholder="Nom, email..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Rôle</label>
                    <select name="role" class="filter-input">
                        <option value="">Tous les rôles</option>
                        <option value="admin" <?php echo isset($_GET['role']) && $_GET['role'] == 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                        <option value="user" <?php echo isset($_GET['role']) && $_GET['role'] == 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Statut</label>
                    <select name="active" class="filter-input">
                        <option value="">Tous les statuts</option>
                        <option value="1" <?php echo isset($_GET['active']) && $_GET['active'] == '1' ? 'selected' : ''; ?>>Actif</option>
                        <option value="0" <?php echo isset($_GET['active']) && $_GET['active'] == '0' ? 'selected' : ''; ?>>Inactif</option>
                    </select>
                    <button type="submit" class="add-button">Appliquer</button>
                </div>
                
            </div>
        </form>

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
                <?php foreach ($users as $user): ?>
                    <?php
                    $avatar = $user['profile_picture'] ? $user['profile_picture'] : "https://ui-avatars.com/api/?name=" . urlencode($user['first_name'] . " " . $user['last_name']);
                    $role = $user['role'] == 'admin' ? 'Administrateur' : 'Utilisateur';
                    $status = $user['active'] ? 'Actif' : 'Inactif';
                    $last_login = $user['last_login'] ?? 'Non disponible';
                    ?>
                    <tr>
                        <td>
                            <div class="user-info">
                                <img src="../uploads/avatar/<?php echo htmlspecialchars($avatar); ?>" alt="<?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>" class="user-avatar">
                                <div class="user-details">
                                    <span class="user-name"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span>
                                    <span class="user-email"><?php echo htmlspecialchars($user['email']); ?></span>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $role; ?></td>
                        <td><?php echo $last_login; ?></td>
                        <td>
                            <span class="status-badge status-<?php echo $user['active'] ? 'active' : 'inactive'; ?>">
                                <i class="fas fa-circle"></i>
                                <?php echo $status; ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="edit-user.php?id=<?php echo $user['id']; ?>" class="action-button edit-btn" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete-user.php?id=<?php echo $user['id']; ?>" class="action-button delete-btn" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
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
                Affichage de <?php echo min($total_users, ($page - 1) * $per_page + 1); ?> à <?php echo min($total_users, $page * $per_page); ?> sur <?php echo $total_users; ?> utilisateurs
            </div>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>&<?php echo http_build_query(array_diff_key($_GET, ['page' => ''])); ?>" class="pagination-button"><i class="fas fa-chevron-left"></i></a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&<?php echo http_build_query(array_diff_key($_GET, ['page' => ''])); ?>" class="pagination-button <?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>&<?php echo http_build_query(array_diff_key($_GET, ['page' => ''])); ?>" class="pagination-button"><i class="fas fa-chevron-right"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="main.js"></script>
</body>
</html>