<?php
session_start();
// Démarre une session PHP pour utiliser les fonctionnalités de session

include('base.php');
// Inclut le fichier "base.php" qui contient la connexion à la base de données

$_SESSION['supprok'] = "Fichier et ses données supprimées avec succès.";
// Définit une variable de session "supprok" avec un message indiquant que le fichier et ses données ont été supprimés avec succès

$tab = array("trame806", "trame800", "fic");
// Crée un tableau contenant les noms des tables de la base de données à partir desquelles les données doivent être supprimées

foreach ($tab as $i) {
    // Parcourt chaque élément du tableau "$tab" et l'assigne à la variable "$i"

    $sql_delete_query = "DELETE FROM $i WHERE numfic=:numfic";
    // Construit la requête SQL pour supprimer les enregistrements de la table en utilisant le nom de la table stocké dans "$i"
    // et en supprimant uniquement les enregistrements ayant une valeur spécifique dans la colonne "numfic"

    $req = $bd->prepare($sql_delete_query);
    // Prépare la requête SQL en utilisant la connexion PDO "$bd" et la requête préparée "$sql_delete_query"

    $req->bindValue(':numfic', $_POST['numfic']);
    // Lie la valeur de la variable $_POST['numfic'] à la variable de liaison ":numfic" dans la requête préparée
    // Cela permet de supprimer les enregistrements ayant la même valeur que celle envoyée via le formulaire POST

    $req->execute();
    // Exécute la requête préparée pour effectuer la suppression des enregistrements correspondants dans la table

}

header('Location: index.php');
// Redirige l'utilisateur vers la page "index.php" après la suppression des données

exit();
// Termine l'exécution du script PHP
?>