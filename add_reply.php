<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment_id = (int)$_POST['comment_id'];
    $content = trim($_POST['content']);

    if (!empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO comment_replies (user_id, comment_id, content) VALUES (:user_id, :comment_id, :content)");
        $stmt->execute([
            'user_id' => $_SESSION['user_id'],
            'comment_id' => $comment_id,
            'content' => $content
        ]);
    }
    $stmt = $pdo->prepare("SELECT phishing_type_id FROM comments WHERE id = :comment_id");
    $stmt->execute(['comment_id' => $comment_id]);
    $phishing_type_id = $stmt->fetchColumn();
    header('Location: type.php?id=' . $phishing_type_id);
    exit;
}
?>