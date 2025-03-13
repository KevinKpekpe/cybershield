<?php
include 'header.php';

$userCountQuery = $pdo->query("SELECT COUNT(*) AS count FROM users");
$userCount = $userCountQuery->fetch(PDO::FETCH_ASSOC)['count'];

$typeCountQuery = $pdo->query("SELECT COUNT(*) AS count FROM phishing_types");
$typeCount = $typeCountQuery->fetch(PDO::FETCH_ASSOC)['count'];

$commentCountQuery = $pdo->query("SELECT COUNT(*) AS count FROM comments");
$commentCount = $commentCountQuery->fetch(PDO::FETCH_ASSOC)['count'];


$stmt = $pdo->query("SELECT * FROM logs ORDER BY created_at DESC LIMIT 5");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);


function time_elapsed_string($datetime, $full = false) {
    $timezone = new DateTimeZone('Europe/Paris');
    $now = new DateTime('now', $timezone);
    $ago = new DateTime($datetime, $timezone);
    $diff = $now->diff($ago);
    if ($diff->invert == 0) {
        return 'Dans le futur';
    }
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = [
        'y' => 'an',
        'm' => 'mois',
        'w' => 'semaine',
        'd' => 'jour',
        'h' => 'heure',
        'i' => 'minute',
        's' => 'seconde',
    ];
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) {
        $string = array_slice($string, 0, 1);
    }
    return $string ? 'Il y a ' . implode(', ', $string) : 'juste maintenant';
}

function getIconForAction($action_type, $table_name) {
    switch ($action_type) {
        case 'CREATE':
            if ($table_name == 'users') {
                return 'fas fa-user-plus';
            }
            return 'fas fa-plus-circle';
        case 'UPDATE':
            return 'fas fa-edit';
        case 'DELETE':
            return 'fas fa-trash';
        case 'LOGIN':
            return 'fas fa-sign-in-alt';
        case 'LOGOUT':
            return 'fas fa-sign-out-alt';
        case 'ACTIVATE':
            return 'fas fa-check';
        default:
            return 'fas fa-info-circle';
    }
} 
?>
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
                <p class="stat-number"><?php echo number_format($userCount); ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--secondary)">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="stat-details">
                <h3>Types de Phishing</h3>
                <p class="stat-number"><?php echo number_format($typeCount); ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--info)">
                <i class="fas fa-comments"></i>
            </div>
            <div class="stat-details">
                <h3>Commentaires</h3>
                <p class="stat-number"><?php echo number_format($commentCount); ?></p>
            </div>
        </div>
    </div>

    <!-- Section Activités Récentes -->
    <div class="recent-activity">
        <h2>Activités Récentes</h2>
        <div class="activity-list">
            <?php if (!empty($logs)) : ?>
                <?php foreach ($logs as $log) : ?>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="<?php echo getIconForAction($log['action_type'], $log['table_name']); ?>"></i>
                        </div>
                        <div class="activity-details">
                            <p><?php echo htmlspecialchars($log['description']); ?></p>
                            <span><?php echo time_elapsed_string($log['created_at']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune activité récente.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</main>
</div>
<script src="main.js"></script>
</body>
</html>
