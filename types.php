<?php include 'includes/header.php'; 

$stmt = $pdo->prepare("SELECT * FROM phishing_types WHERE active=1 ORDER BY id DESC");
$stmt->execute();
$phishingTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
    <section class="types-hero">
        <h1>Types de Phishing</h1>
        <p>Découvrez les différentes techniques de phishing et apprenez à vous en protéger efficacement.</p>
    </section>

    <section class="types-grid-full">
        <div class="types-container">
            <?php foreach ($phishingTypes as $type) : ?>
            <div class="phishing-card">
                <div class="card-image">
                    <img src="uploads/type/<?= htmlspecialchars($type['image']) ?>" alt="<?= htmlspecialchars($type['title']) ?>">
                </div>
                <div class="card-content">
                    <h3><?= htmlspecialchars($type['title']) ?></h3>
                    <p><?= htmlspecialchars(substr($type['description'], 0, 200)) ?>...</p>
                    <div class="card-actions">
                        <button onclick="window.location.href='type.php?id=<?= htmlspecialchars($type['id']) ?>'" class="btn-details">En savoir plus</button>
                        <button onclick="window.location.href='prevention.php?id=<?= htmlspecialchars($type['id']) ?>'" class="btn-prevention">Prévention</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php include 'includes/footer.php'; ?>

            