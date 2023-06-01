<?php
session_start();
if (empty($_SESSION['page'])){
    $_SESSION['page']=1;
}
if (isset($_GET["page"])) { 
    $page  = $_GET["page"];
} else { 
    $page=1; 
}
if (isset($_GET["numfic"])) { 
    $_SESSION['numfic']  = $_GET['numfic'];
}
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    </head>
    <body>

        <header>
            <p>TEST</p>
        </header>
        <?php
        include ("base.php");
        $totalrec = "50";
        $debut = $page - 1;
        $debut = $debut * $totalrec;
        $query = "SELECT field1,numfic,date FROM trame800 WHERE trame800.numfic=:numfic UNION SELECT field1,numfic,date FROM trame806 WHERE trame806.numfic=:numfic";
        $req = $bd->prepare($query);
        $req->bindValue(':numfic', $_GET['numfic']);
        $req->execute();
        $count = $req->rowCount();
        $req->closeCursor();
        $totalpage = ceil($count / $totalrec);
        ?>
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
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" id="search" class="form-control" placeholder="Recherche">
                                    </div>
                                    </form> 
                                    <form method="GET" action="">
                                        <select id="selec_page" name="page" class="btn btn-primary" onchange="this.form.submit();">  
                                            <option value="Select">Page <?php if(isset($_GET['page'])){echo $_GET['page'];} ?></option> 
                                            <?php
                                            if ($totalpage > 1) {
                                                for ($i = 1; $i <= $totalpage; $i++) {
                                                    echo '<option value="'.$i.'">'.$i.'</a>';
                                                }
                                            }
                                            ?> 
                                        <input type="hidden" name="numfic" value="<?php echo $_GET['numfic']; ?>">
                                        </select>   
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <table id="result" class="table table-bordered">
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <table class="table table-bordered">
                                    <tr>
                                        <th>Numéro de la trame</th>
                                        <th>Type de trame</th>
                                        <th>ID du fichier</th>
                                        <th>Date de la trame</th>
                                    </tr>
                                    <?php 
                                        if(isset($_GET['numfic']))
                                        {
                                            $filtre = $_GET['numfic'];
                                            $query = "SELECT numtrame,field1,numfic,date FROM trame800 WHERE trame800.numfic=:numfic UNION SELECT numtrame,field1,numfic,date FROM trame806 WHERE trame806.numfic=:numfic ORDER BY date LIMIT $debut,$totalrec";
                                            $req = $bd->prepare($query);
                                            $req->bindValue(':numfic', $_GET['numfic']);
                                            $req->execute();
                                            $res = $req->fetchall();
                                            $req->closeCursor();

                                            if($count > 0)
                                            {
                                                foreach($res as $items)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?= $items['numtrame']; ?></td>
                                                        <td>0x<?= $items['field1'];
                                                            if ($items['field1'] == 800){
                                                                echo "&nbsp(UDP)";
                                                                $typetrame = "trame800";
                                                            }
                                                            elseif ($items['field1'] == 806){
                                                                echo "&nbsp(ARP)";
                                                                $typetrame = "trame806";
                                                            }
                                                            ?></td>
                                                        <td><?= $items['numfic']; ?></td>
                                                        <td><?= $items['date']; ?></td>
                                                        <td>
                                                        <form action="trame.php" method="GET">
                                                            <div class="input-group mb-3">
                                                                <input type="hidden" name="typetrame" value=<?php echo $typetrame; ?>>
                                                                <button type="submit" class="btn btn-primary button" name="numtrame" value="<?php if(isset($items['numtrame'])){echo $items['numtrame']; } ?>">Voir trame</button>
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
        </footer>
    </body>
</html>
<script>
    $(document).ready(function(){
        $('#search').keyup(function(){
            var txt = $(this).val();
            if(txt != '')
            {
                $.ajax({
                    url:"fetchtrame.php",
                    method:"post",
                    data:{search:txt},
                    dataType:"text",
                    success:function(data)
                    {
                        $('#result').html(data);
                    }
                });
            }
            else
            {
                $('#result').html('');
            }
        });
    });
</script>