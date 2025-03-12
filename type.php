<?php
include 'includes/header.php';


$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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
    WHERE pt.id = :id AND pt.active = 1
    GROUP BY pt.id, pt.title, pt.description, pt.image, pt.active, pt.created_at
    ORDER BY pt.created_at DESC
");
$stmt->execute(['id' => $id]);
$type = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$type) {
    echo "<p>Ce type de phishing n'existe pas ou n'est pas actif.</p>";
    include 'includes/footer.php';
    exit;
}

$comment_stmt = $pdo->prepare("
    SELECT c.id, c.content, c.created_at, u.first_name, u.last_name
    FROM comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.phishing_type_id = :id AND c.active = 1
    ORDER BY c.created_at DESC
");
$comment_stmt->execute(['id' => $id]);
$comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);

$comments_with_replies = [];
foreach ($comments as $comment) {
    $reply_stmt = $pdo->prepare("
        SELECT cr.id, cr.content, cr.created_at, u.first_name, u.last_name
        FROM comment_replies cr
        JOIN users u ON cr.user_id = u.id
        WHERE cr.comment_id = :comment_id AND cr.active = 1
        ORDER BY cr.created_at ASC
    ");
    $reply_stmt->execute(['comment_id' => $comment['id']]);
    $replies = $reply_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $comment['replies'] = $replies;
    $comments_with_replies[] = $comment;
}
?>

<section class="type-detail-hero">
    <div class="type-detail-container">
        <div class="type-header">
            <div class="type-info">
                <h1><?= htmlspecialchars($type['title']) ?></h1>
                <p><?= htmlspecialchars($type['description']) ?></p>
            </div>
        </div>
    </div>
</section>

<section class="type-content">
    <div class="type-detail-container">
        <div class="content-grid">
            <div class="main-content">
                <div class="content-section">
                    <h2>Description</h2>
                    <p><?= htmlspecialchars($type['description']) ?></p>
                </div>

                <div class="content-section">
                    <h2>Caractéristiques</h2>
                    <ul>
                        <?php if (!empty($type['characteristics'])): ?>
                            <?php foreach (explode(', ', $type['characteristics']) as $char): ?>
                                <li><?= htmlspecialchars($char) ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Aucune caractéristique disponible.</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="content-section">
                    <h2>Comment se protéger</h2>
                    <ul>
                        <?php if (!empty($type['protections'])): ?>
                            <?php foreach (explode(', ', $type['protections']) as $prot): ?>
                                <li><?= htmlspecialchars($prot) ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Aucune protection disponible.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <aside class="sidebar">
                <div class="resource-card">
                    <img src="<?= "uploads/type/" . htmlspecialchars($type['image']) ?>" alt="Image du type de phishing" class="sidebar-image">
                </div>
            </aside>
        </div>
    </div>
</section>

<section class="comments-section">
    <div class="type-detail-container">
        <h2>Commentaires et Retours d'Expérience</h2>

        <div class="comments-container">
            <div class="comment-form">
                <h3>Partagez votre expérience</h3>
                <form method="POST" action="add_comment.php">
                    <input type="hidden" name="phishing_type_id" value="<?= $id ?>">
                    <textarea name="content" placeholder="Écrivez votre commentaire ici..." required></textarea>
                    <button type="submit" class="btn-details">Publier</button>
                </form>
            </div>

            <?php foreach ($comments_with_replies as $comment): ?>
                <div class="comment-card">
                    <div class="comment-header">
                        <div class="comment-author">
                            <div class="author-avatar"><?= strtoupper(substr($comment['first_name'], 0, 1) . substr($comment['last_name'], 0, 1)) ?></div>
                            <div class="author-info">
                                <h4><?= htmlspecialchars($comment['first_name'] . ' ' . $comment['last_name']) ?></h4>
                                <span class="comment-date"><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></span>
                            </div>
                        </div>
                    </div>
                    <p><?= htmlspecialchars($comment['content']) ?></p>
                    <div class="comment-actions">
                        <button class="action-btn reply-btn" data-comment-id="<?= $comment['id'] ?>">Répondre</button>
                        <button class="action-btn like-btn" data-comment-id="<?= $comment['id'] ?>">J'aime (0)</button>
                    </div>

                    <!-- Réponses -->
                    <div class="replies">
                        <?php foreach ($comment['replies'] as $reply): ?>
                            <div class="comment-card">
                                <div class="comment-header">
                                    <div class="comment-author">
                                        <div class="author-avatar"><?= strtoupper(substr($reply['first_name'], 0, 1) . substr($reply['last_name'], 0, 1)) ?></div>
                                        <div class="author-info">
                                            <h4><?= htmlspecialchars($reply['first_name'] . ' ' . $reply['last_name']) ?></h4>
                                            <span class="comment-date"><?= date('d/m/Y H:i', strtotime($reply['created_at'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <p><?= htmlspecialchars($reply['content']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
    // Gestion des formulaires de réponse
    document.querySelectorAll('.reply-btn').forEach(button => {
        button.addEventListener('click', () => {
            const commentId = button.getAttribute('data-comment-id');
            const commentCard = button.closest('.comment-card');
            const replyForm = document.createElement('div');
            replyForm.className = 'comment-form';
            replyForm.innerHTML = `
                <form method="POST" action="add_reply.php">
                    <input type="hidden" name="comment_id" value="${commentId}">
                    <textarea name="content" placeholder="Écrivez votre réponse..." required></textarea>
                    <button type="submit" class="btn-details">Répondre</button>
                </form>
            `;
            const existingForm = commentCard.querySelector('.comment-form');
            if (!existingForm) {
                commentCard.appendChild(replyForm);
            }
        });
    });

    // Gestion des likes (exemple côté client, à implémenter côté serveur)
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', () => {
            const commentId = button.getAttribute('data-comment-id');
            fetch(`like_comment.php?comment_id=${commentId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        button.textContent = `J'aime (${data.likes})`;
                    }
                });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>