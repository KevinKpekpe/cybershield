<?php include 'config/db.php'; ?>
<?php
session_start();
session_destroy();
header('Location: login.php');
exit();
?>