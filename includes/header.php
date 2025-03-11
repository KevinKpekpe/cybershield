<?php
session_start();
// Inclure la connexion à la base de données
if (file_exists('config/db.php')) {
    include 'config/db.php';
} else {
    die('Fichier de configuration de la base de données non trouvé.');
}

// Récupérer les informations de l'utilisateur
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anti-Phishing - Sécurité en ligne</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
<header>
    <nav>
        <div class="logo">CyberShield</div>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="types.php">Types</a></li>
            <li><a href="#about">À propos</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="user-menu">
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="user-profile">
                    <img src="uploads/avatar/<?php echo $user['profile_picture']; ?>" 
                        alt="Photo de profil" 
                        class="profile-pic">
                    <span class="user-name"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></span>
                    <div class="dropdown-menu">
                        <a href="profil.php">Mon Profil</a>
                        <a href="logout.php">Déconnexion</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="auth-buttons">
                    <a href="login.php" class="login-btn">Connexion</a>
                    <a href="register.php" class="register-btn">Inscription</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>