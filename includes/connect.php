<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = 'root';
$db_db = 'rabelaisien';

try {
    // Créer une nouvelle connexion PDO
    $db = new PDO("mysql:host=$db_host;dbname=$db_db", $db_user, $db_password);
    // Définir le mode d'erreur PDO pour lancer des exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES utf8");
    // On définit le mode "fetch" par défaut
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Fermer la connexion (optionnel, PDO fermera automatiquement à la fin du script)
    $pdo = null;
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
