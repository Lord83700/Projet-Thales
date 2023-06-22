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
                <th><?php if(isset($_COOKIE['numfic'])){echo $_COOKIE['numfic'];}else{echo "ID du fichier";} ?></th>
                <th><?php if(isset($_COOKIE['nomfic'])){echo $_COOKIE['nomfic'];}else{echo "Nom du fichier";} ?></th>
                <th><?php if(isset($_COOKIE['obsw'])){echo $_COOKIE['obsw'];}else{echo "Type et version OBSW";} ?></th>
                <th><?php if(isset($_COOKIE['bds'])){echo $_COOKIE['bds'];}else{echo "version BDS";} ?></th>
                <th><?php if(isset($_COOKIE['tv'])){echo $_COOKIE['tv'];}else{echo "Type et version moyen";} ?></th>
                <th><?php if(isset($_COOKIE['dt'])){echo $_COOKIE['dt'];}else{echo "Date du fichier";} ?></th>
                <th></th>
            </tr>
    <?php    
    foreach($res as $items)
    {
        ?>
        <tr>
            <td><?= $items['numfic']; ?></td>
            <td><?= $items['nomfic']; ?></td>
            <td><?php echo !empty($items['obsw']) ? $items['obsw'] : "Non défini"; ?></td>
            <td><?php echo !empty($items['bds']) ? $items['bds'] : "Non défini"; ?></td>
            <td><?php echo !empty($items['bds']) ? $items['bds'] : "Non défini"; ?></td>
            <td><?= $items['dt']; ?></td>
            <td>
            <form action="affiche.php" method="GET">
                <div class="input-group mb-3">
                    <input type="hidden" name="page" value="1">
                    <button type="submit" class="btn btn-primary button" name="numfic" value="<?php if(isset($items['numfic'])){echo $items['numfic']; } ?>">Voir fichier</button>
                </div>
            </form>
            <form action="supprfic.php" method="POST">
                <div class="input-group mb-3">
                    <input type="hidden" name="numfic" value="<?php if(isset($items['numfic'])){echo $items['numfic']; } ?>">
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