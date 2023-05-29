<?php
include ('base.php');
$query = "SELECT * FROM fic WHERE CONCAT(numfic,nomfic,dt) ORDER BY numfic DESC LIMIT 0,5 ";
$req = $bd->prepare($query);
$req->execute();
$res = $req->fetchall();
$count = $req->rowCount();
$req->closeCursor();

if($count > 0)
{
    ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>ID du fichier</th>
                <th>Nom du fichier</th>
                <th>Date du fichier</th>
                <th></th>
            </tr>
    <?php    
    foreach($res as $items)
    {
        ?>
        <tr>
            <td><?= $items['numfic']; ?></td>
            <td><?= $items['nomfic']; ?></td>
            <td><?= $items['dt']; ?></td>
            <td>
            <form action="affiche.php" method="GET">
                <div class="input-group mb-3">
                    <input type="hidden" name="page" value="1">
                    <button type="submit" class="btn btn-primary button" name="numfic" value="<?php if(isset($items['numfic'])){echo $items['numfic']; } ?>">Voir fichier</button>
                </div>
            </form>
            <form action="supprfic.php" method="GET">
                <div class="input-group mb-3">
                    <input type="hidden" name="numfic" value="<?php if(isset($items['numfic'])){echo $items['numfic']; } ?>">
                    <input type="hidden" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>">
                    <button type="submit" id="deleteform" class="btn button-danger confirm">Supprimer fichier</button>
                </div>
            </form>
            </td>
        </tr>
        <?php
    }
}
else
{
    ?>  
    <tr>
        <td colspan="4">Aucun résultat</td>
    </tr>
    <?php
}
?>