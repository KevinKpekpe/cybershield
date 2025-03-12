<?php include 
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
include '../config/db.php';
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
    <title>CyberShield - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="fas fa-shield-alt"></i>
                    <span>CyberShield</span>
                </div>
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <span class="nav-section-title">MENU PRINCIPAL</span>
                    <ul>
                        <li class="active">
                            <a href="#dashboard">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item-dropdown">
                            <a href="#users">
                                <i class="fas fa-users"></i>
                                <span>Utilisateurs</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="users.php">Tous les utilisateurs</a></li>
                                <li><a href="create-user.php">Ajouter un utilisateur</a></li>
                            </ul>
                        </li>
                        <li class="nav-item-dropdown">
                            <a href="#phishing">
                                <i class="fas fa-fish"></i>
                                <span>Types de Phishing</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="types.php">Tous les types</a></li>
                                <li><a href="create-type.php">Ajouter un type</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#analytics">
                                <i class="fas fa-chart-line"></i>
                                <span>Analytiques</span>
                            </a>
                        </li>
                        <li>
                            <a href="#settings">
                                <i class="fas fa-cog"></i>
                                <span>Paramètres</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <span class="nav-section-title">AUTRES</span>
                    <ul>
                        <li>
                            <a href="#help">
                                <i class="fas fa-question-circle"></i>
                                <span>Aide</span>
                            </a>
                        </li>
                        <li>
                            <a href="#contact">
                                <i class="fas fa-envelope"></i>
                                <span>Contact</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Rechercher...">
                </div>
                
                <div class="header-right">
                    <div class="admin-profile">
                        <img src="../uploads/avatar/<?php echo $user['profile_picture']; ?>" alt="Admin" class="admin-avatar">
                        <div class="admin-info">
                            <span class="admin-name"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></span>
                            <span class="admin-role"><?php echo $user['role']; ?></span>
                        </div>
                        <div class="profile-dropdown">
                            <ul>
                                <li><a href="profil.php"><i class="fas fa-user"></i> Mon Profil</a></li>
                                <li><a href="settings.php"><i class="fas fa-cog"></i> Paramètres</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a href="../logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>