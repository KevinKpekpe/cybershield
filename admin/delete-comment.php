<?php
session_start();
include '../config/db.php'; 

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $commentId = (int)$_GET['id'];

    try {

        $pdo->beginTransaction();

        // Supprimer les réponses associées au commentaire
        $stmtReplies = $pdo->prepare("DELETE FROM comment_replies WHERE comment_id = :id");
        $stmtReplies->bindParam(':id', $commentId, PDO::PARAM_INT);
        $stmtReplies->execute();


        $stmtComment = $pdo->prepare("DELETE FROM comments WHERE id = :id");
        $stmtComment->bindParam(':id', $commentId, PDO::PARAM_INT);
        $stmtComment->execute();


        $pdo->commit();


        $_SESSION['success'] = "Commentaire supprimé avec succès";


        header("Location: comments.php");
        exit();
    } catch (PDOException $e) {
        
        $pdo->rollBack();
        $_SESSION['error'] = "Erreur lors de la suppression : " . $e->getMessage();
        header("Location: comments.php");
        exit();
    }
} else {
    $_SESSION['error'] = "ID invalide";
    header("Location: comments.php");
    exit();
}
?>