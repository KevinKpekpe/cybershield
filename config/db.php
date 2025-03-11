<?php
try {
    $host = "127.0.0.1";
    $dbname = "phishing_prevention";
    $username = "root";
    $password = "";

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    die();
}
