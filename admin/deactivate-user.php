<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {

        $stmts = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmts->execute(['id' => $id]);
        $user = $stmts->fetch();
        $stmt = $pdo->prepare("UPDATE users SET active = 0 WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $admin_id = $_SESSION['user_id'] ?? null;
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        $descriptionLog = "Desactivation de l'utilisateur : " . $user['email'];
        $stmtLog = $pdo->prepare("INSERT INTO logs 
            (user_id, action_type, table_name, record_id, description, ip_address) 
            VALUES (:user_id, 'DELETE', 'users', :record_id, :description, :ip_address)");
        $stmtLog->execute([
            'user_id'   => $admin_id,
            'record_id' => $newUserId,
            'description' => $descriptionLog,
            'ip_address'  => $ip_address
        ]);

        header('Location: users.php'); 
        exit();
    } catch (PDOException $e) {
        echo "Erreur de requête : " . $e->getMessage();
    }
} else {
    echo "ID non spécifié.";
}
?>