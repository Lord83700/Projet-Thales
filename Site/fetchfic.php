<?php
include ('base.php');
$output = '';
$sql = "SELECT * FROM fic WHERE CONCAT(numfic,nomfic,dt) LIKE '%".$_POST["search"]."%'";
$req = $bd->prepare($sql);
$req->execute();
$res = $req->fetchall();
$count = $req->rowCount();
$req->closeCursor();
if($count > 0)
{
    $output .= '<div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID du fichier</th>
                            <th>Nom du fichier</th>
                            <th>Date du fichier</th>
                            <th></th>
                        </tr>';
    foreach($res as $row)
    {
        $output .= '
            <tr>
                <td>'.$row["numfic"].'</td>
                <td>'.$row["nomfic"].'</td>
                <td>'.$row["dt"].'</td>
                <td>
                    <form action="affiche.php" method="GET">
                        <div class="input-group mb-3">
                            <input type="hidden" name="page" value="1">
                            <button type="submit" class="btn btn-primary button" name="numfic" value="'.$row['numfic'].'">Voir fichier</button>
                        </div>
                    </form>
                    <form action="supprfic.php" method="GET">
                        <div class="input-group mb-3">
                            <input type="hidden" name="numfic" value="'.$row['numfic'].'">
                            <input type="hidden" name="search" value="'.$_POST['search'].'">
                            <button type="submit" id="deleteform" class="btn button-danger confirm">Supprimer fichier</button>
                        </div>
                    </form>
                </td>
            </tr>
        ';
    }
    echo $output;
}
else
{
    echo '<tr>
            <td colspan="4">Aucun résultat</td>
        </tr>';
}
?>