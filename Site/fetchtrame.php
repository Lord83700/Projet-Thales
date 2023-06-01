<?php
session_start();
include ('base.php');
$output = '';
$sql = "SELECT numtrame,field1,numfic,date FROM trame800 WHERE trame800.numfic=:numfic UNION SELECT numtrame,field1,numfic,date FROM trame806 WHERE trame806.numfic=:numfic LIKE '%".$_POST["search"]."%'";
$req = $bd->prepare($sql);
$req->bindValue(':numfic', $_SESSION['numfic']);
$req->execute();
$res = $req->fetchall();
$count = $req->rowCount();
$req->closeCursor();
if($count > 0)
{
    $output .= '<div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Numéro de la trame</th>
                            <th>Type de la trame</th>
                            <th>ID du fichier</th>
                            <th>Date de la trame</th>
                            <th></th>
                        </tr>';
    foreach($res as $row)
    {
        if ($row['field1'] == 800){
            $typetrame = "trame800";
        }
        elseif ($row['field1'] == 806){
            $typetrame = "trame806";
        }
        $output .= '
            <tr>
                <td>'.$row["numtrame"].'</td>
                <td>0x'.$row['field1'].'</td>
                <td>'.$row["numfic"].'</td>
                <td>'.$row["date"].'</td>
                <td>
                    <form action="trame.php" method="GET">
                        <div class="input-group mb-3">
                            <input type="hidden" name="typetrame" value='.$typetrame.'>
                            <button type="submit" class="btn btn-primary button" name="numtrame" value="'.$row['numtrame'].'">Voir trame</button>
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