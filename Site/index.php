<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title id="titre">THALES</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <p>TEST</p>
        </header>

        <nav>
            <a href='oui'>Accueil</a>
            <a href='oui'>Crédit</a>
            <a href='oui'>TEST</a>
            <a href='oui'>TEST</a>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Veuillez entrer la date d'exécution du fichier que vous recherchez via cette forme : yy-MM-dd HH-mm-ss <br><br>yy = Année / MM = Mois / dd = Jour / HH = Heure / mm = Minute / ss = Seconde</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">

                                    <form action="" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Recherche">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID du fichier</th>
                                        <th>Nom du fichier</th>
                                        <th>Date du fichier</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        include ("base.php");

                                        if(isset($_GET['search']))
                                        {
                                            $filtre = $_GET['search'];
                                            $query = "SELECT * FROM fic WHERE CONCAT(numfic,nomfic,dt) LIKE '%$filtre%' ";
                                            $req = $bd->prepare($query);
                                            $req->execute();
                                            $res = $req->fetchall();
                                            $count = $req->rowCount();
                                            $req->closeCursor();

                                            if($count > 0)
                                            {
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
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
        <p>Ce site a été écrit en HTML 5 et CSS 3 par Nom Prénom. Il est validé par le W3C. logos HTML5 et CSS3</p>
        </footer>
    </body>
</html>