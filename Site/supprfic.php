<?php
session_start();
include ('base.php');

$_SESSION['supprok'] = "Fichier et ses données supprimées avec succès.";
$tab = array("trame806", "trame800", "fic");

foreach ($tab as $i)
{
    $sql_delete_query = "DELETE FROM $i WHERE numfic=:numfic";
    $req = $bd->prepare($sql_delete_query);
    $req->bindValue(':numfic', $_POST['numfic']);
    $req->execute();
}

header ('Location: index.php');
exit();
?>