<?php
session_start();
include ('base.php');

$_SESSION['supprok'] = "Fichier et ses données supprimées avec succès.";
$tab = array("trame806", "trame800", "fic");

foreach ($tab as $i)
{
    $sql_delete_queru = "DELETE FROM $i WHERE numfic=:numfic";
    $req = $bd->prepare($sql_delete_queru);
    $req->bindValue(':numfic', $_GET['numfic']);
    $req->execute();
}

header ('Location: index.php');
exit();
?>