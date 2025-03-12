<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phishing_type_id = (int)$_POST['phishing_type_id'];
    $content = trim($_POST['content']);

    if (!empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO comments (user_id, phishing_type_id, content) VALUES (:user_id, :phishing_type_id, :content)");
        $stmt->execute([
            'user_id' => $_SESSION['user_id'],
            'phishing_type_id' => $phishing_type_id,
            'content' => $content
        ]);
    }
    header('Location: type.php?id=' . $phishing_type_id);
    exit;
}
?>