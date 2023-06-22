<?php
try {
    $bd = new PDO("mysql:host=localhost;dbname=thales", "root", "adminthales");
    // Crée une nouvelle instance de la classe PDO en se connectant à la base de données MySQL
    // Remplacez "localhost" par l'adresse de votre serveur MySQL, "thales" par le nom de votre base de données,
    // "root" par le nom d'utilisateur de votre base de données et "adminthales" par le mot de passe de votre base de données
    $bd->exec('SET NAMES utf8');
    // Définit le jeu de caractères utilisé par la connexion à la base de données sur UTF-8
} catch (Exception $e) {
    die("Erreur: Connexion à la base impossible");
    // En cas d'erreur lors de la connexion à la base de données, affiche un message d'erreur et arrête l'exécution du script
}
?>
