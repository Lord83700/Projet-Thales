<?php
include('base.php');
$output = '';
$sql = "SELECT * FROM fic WHERE CONCAT(numfic,nomfic,obsw,bds,tv,dt) LIKE '%" . $_POST["search"] . "%'";
$req = $bd->prepare($sql);
$req->execute();
$res = $req->fetchAll();
$count = $req->rowCount();
$req->closeCursor();
if ($count > 0) {
    $output .= '<div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>' . (isset($_COOKIE['numfic']) ? $_COOKIE['numfic'] : "ID du fichier") . '</th>
                            <th>' . (isset($_COOKIE['nomfic']) ? $_COOKIE['nomfic'] : "Nom du fichier") . '</th>
                            <th>' . (isset($_COOKIE['obsw']) ? $_COOKIE['obsw'] : "Type et version OBSW") . '</th>
                            <th>' . (isset($_COOKIE['bds']) ? $_COOKIE['bds'] : "version BDS") . '</th>
                            <th>' . (isset($_COOKIE['tv']) ? $_COOKIE['tv'] : "Type et version moyen") . '</th>
                            <th>' . (isset($_COOKIE['dt']) ? $_COOKIE['dt'] : "Date du fichier") . '</th>
                            <th></th>
                        </tr>';
    foreach ($res as $row) {
        $output .= '
            <tr>
                <td>' . $row["numfic"] . '</td>
                <td>' . $row["nomfic"] . '</td>
                <td>' . (!empty($row['obsw']) ? $row['obsw'] : "Non défini") . '</td>
                <td>' . (!empty($row['bds']) ? $row['bds'] : "Non défini") . '</td>
                <td>' . (!empty($row['tv']) ? $row['tv'] : "Non défini") . '</td>
                <td>' . $row["dt"] . '</td>
                <td>
                    <form action="affiche.php" method="GET">
                        <div class="input-group mb-3">
                            <input type="hidden" name="page" value="1">
                            <button type="submit" class="btn btn-primary button" name="numfic" value="' . $row['numfic'] . '">Voir fichier</button>
                        </div>
                    </form>
                    <form action="supprfic.php" method="POST">
                        <div class="input-group mb-3">
                            <input type="hidden" name="numfic" value="' . $row['numfic'] . '">
                            <input type="hidden" name="search" value="' . $_POST['search'] . '">
                            <button type="submit" id="deleteform" class="btn button-danger confirm">Supprimer fichier</button>
                        </div>
                    </form>
                </td>
            </tr>
        ';
    }
    $output .= '</table></div>';
    echo $output;
} else {
    echo '<tr>
            <td colspan="4">Aucun résultat</td>
        </tr>';
}
?>