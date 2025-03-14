<?php
include '../config/db.php';
if (isset($_GET['id'])) {
    $stmts = $pdo->prepare("SELECT * FROM phishing_types WHERE id = :id");
    $stmts->execute(['id' => $id]);
    $type = $stmts->fetch();

    $id = $_GET['id'];
    $stmt = $pdo->prepare("UPDATE phishing_types SET active = 0 WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();


    $user_id = $_SESSION['user_id'] ?? null;
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $descriptionLog = "Desactivation du type de phishing : " . $type['title'];
    $stmt = $pdo->prepare("INSERT INTO logs (user_id, action_type, table_name, record_id, description, ip_address) VALUES (?, 'DELETE', 'phishing_types', ?, ?, ?)");
    $stmt->execute([$user_id, $id, $descriptionLog, $ip_address]);

    $_SESSION['success'] = "Type de phishing desactivé avec succès";
}
header("Location: types.php");
exit();
?>