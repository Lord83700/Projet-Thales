<?php
session_start();
if (isset($_GET["page"])) { 
    $page  = $_GET["page"];
} else { 
    $page=1; 
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

                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <h4 class="text-center font">Affichage des trames du fichier <?php echo $_GET['numfic']; ?> sélectionné par page</h4>
                                    <form method="GET" action="">
                                        <select id="selec_page" name="page" class="btn btn-primary page" onchange="this.form.submit();">  
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
                                    <?php 
                                            $query = "SELECT * FROM trame800 INNER JOIN fic ON fic.numfic=trame800.numfic WHERE fic.numfic=:numfic;";
                                            $req = $bd->prepare($query);
                                            $req->bindValue(':numfic', $_GET['numfic']);
                                            $req->execute();
                                            $res800 = $req->fetchall();
                                            $count800 = $req->rowCount();
                                            $req->closeCursor();
                                            $query = "SELECT * FROM trame806 INNER JOIN fic ON fic.numfic=trame806.numfic WHERE fic.numfic=:numfic;";
                                            $req = $bd->prepare($query);
                                            $req->bindValue(':numfic', $_GET['numfic']);
                                            $req->execute();
                                            $res806 = $req->fetchall();
                                            $count806 = $req->rowCount();
                                            $req->closeCursor();
                                            $i = 0;
                                            $j = 0;
                                            $restotal = [];

                                            if ($count800 > 0 || $count806 > 0)
                                            {
                                                while ($i < $count800 && $j < $count806)
                                                {
                                                    $date1 = DateTime::createFromFormat('l:d:M:m:Y:H:i:s.u', $res800[$i]['date']);
                                                    $date2 = DateTime::createFromFormat('l:d:M:m:Y:H:i:s.u', $res806[$j]['date']);
                                                    
                                                    if ($date1 < $date2)
                                                    {
                                                        array_push($restotal, $res800[$i]);
                                                        $i++;
                                                    }
                                                    elseif ($date2 < $date1)
                                                    { 
                                                        array_push($restotal, $res806[$j]);
                                                        $j++;
                                                    }
                                                }
                                                    
                                                while ($i < $count800)
                                                {
                                                    array_push($restotal, $res800[$i]);
                                                    $i++;
                                                }
                                                
                                                while ($j < $count806)
                                                {
                                                    array_push($restotal, $res806[$j]);
                                                    $j++;
                                                }
                                                

                                                for ($i = $debut; $i < min($debut + $totalrec, count($restotal)); $i++)
                                                {
                                                    if ($restotal[$i]['field1'] == 800)
                                                    {
                                                        $typetrame = "trame800";
                                                    }

                                                    elseif ($restotal[$i]['field1'] == 806)
                                                    {
                                                        $typetrame = "trame806";
                                                    }

                                                    if($typetrame == "trame800")
                                                    {
                                                    ?>
                                                    <div class="col-md-12">
                                                    <div class="card mt-4">
                                                        <div class="card-body">
                                                            <table class="table table-bordered">
                                                            <h4 id="<?= $restotal[$i]['numtrame']; ?>" class="text-center font">Affichage des informations concernant la trame <?php echo $restotal[$i]['numtrame']; ?></h4>
                                                    <thead>
                                                        <tr>
                                                            <th>Numéro de la trame</th>
                                                            <th>Numéro du fichier</th>
                                                            <th>Date de la trame</th>
                                                            <th>PMID</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><?= $restotal[$i]['numtrame']; ?></td>
                                                        <td><?= $restotal[$i]['numfic']; ?></td>
                                                        <td><?= $restotal[$i]['date']; ?></td>
                                                        <td><?= $restotal[$i]['pmid']; ?></td>
                                                    </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>Bench3</th>
                                                            <th>Bench5</th>
                                                            <th>Taille de la trame</th>
                                                            <th>MAC Destination</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $restotal[$i]['bench3']; ?></td>
                                                            <td><?= $restotal[$i]['bench5']; ?></td>
                                                            <td><?= $restotal[$i]['framesize']; ?></td>
                                                            <td><?= $restotal[$i]['macdst']; ?></td>                                  
                                                        </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>MAC Source</th>
                                                            <th>Type de la trame</th>
                                                            <th>Field2</th>
                                                            <th>Field3</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $restotal[$i]['macsrc']; ?></td>
                                                            <td>0x<?= $restotal[$i]['field1']; ?></td>
                                                            <td><?= $restotal[$i]['field2']; ?></td>
                                                            <td><?= $restotal[$i]['field3']; ?></td>                                     
                                                        </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>Field4</th>
                                                            <th>Field5</th>
                                                            <th>Field6</th>
                                                            <th>Field7</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $restotal[$i]['field4']; ?></td>
                                                            <td><?= $restotal[$i]['field5']; ?></td>
                                                            <td><?= $restotal[$i]['field6']; ?></td>
                                                            <td><?= $restotal[$i]['field7']; ?></td>                                  
                                                        </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>IP Source</th>
                                                            <th>IP Destination</th>
                                                            <th>Field9</th>
                                                            <th>Field10</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $restotal[$i]['ipsrc']; ?></td>
                                                            <td><?= $restotal[$i]['ipdst']; ?></td>  
                                                            <td><?= $restotal[$i]['field9']; ?></td>
                                                            <td><?= $restotal[$i]['field10']; ?></td>                                    
                                                        </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>Field11</th>
                                                            <th>Field14</th>
                                                            <th>Field16</th>
                                                            <th>Field17</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $restotal[$i]['field11']; ?></td>
                                                            <td><?= $restotal[$i]['field14']; ?></td>
                                                            <td><?= $restotal[$i]['field16']; ?></td>
                                                            <td><?= $restotal[$i]['field17']; ?></td>                                          
                                                        </tr>
                                                    </tbody>    
                                                    <thead>
                                                        <tr>
                                                            <th>Field18</th>
                                                            <th>Field20</th>
                                                            <th>Field21</th>
                                                            <th>Field23</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $restotal[$i]['field18']; ?></td>
                                                            <td><?= $restotal[$i]['field20']; ?></td>
                                                            <td><?= $restotal[$i]['field21']; ?></td>
                                                            <td><?= $restotal[$i]['field23']; ?></td>                                
                                                        </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>Field25</th>
                                                            <th>Field26</th>
                                                            <th>Field28</th>
                                                            <th>Field29</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $restotal[$i]['field25']; ?></td>
                                                            <td><?= $restotal[$i]['field26']; ?></td>  
                                                            <td><?= $restotal[$i]['field28']; ?></td>
                                                            <td><?= $restotal[$i]['field29']; ?></td>                               
                                                        </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>Field30</th>
                                                            <th>Field32</th>
                                                            <th>Field333435</th>
                                                            <th>Timepacket</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $restotal[$i]['field30']; ?></td>
                                                            <td><?= $restotal[$i]['field32']; ?></td>
                                                            <td><?= $restotal[$i]['field333435']; ?></td>
                                                            <td><?= $restotal[$i]['timepacket']; ?></td>                                    
                                                        </tr>
                                                    </tbody>                      
                                                    <?php
                                                    }
                                                    elseif($typetrame == "trame806")
                                                    {
                                                        ?>
                                                        <div class="col-md-12">
                                                        <div class="card mt-4">
                                                            <div class="card-body">
                                                                <table class="table table-bordered">
                                                                <h4 id="<?= $restotal[$i]['numtrame']; ?>" class="text-center font">Affichage des informations concernant la trame <?php echo $restotal[$i]['numtrame']; ?></h4>
                                                        <thead>
                                                            <tr>
                                                                <th>Numéro de la trame</th>
                                                                <th>Numéro du fichier</th>
                                                                <th>Date de la trame</th>
                                                                <th>Bench3</th>
                                                                <th>Bench5</th>
                                                                <th>Taille du paquet</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><?= $restotal[$i]['numtrame']; ?></td>
                                                            <td><?= $restotal[$i]['numfic']; ?></td>
                                                            <td><?= $restotal[$i]['date']; ?></td>
                                                            <td><?= $restotal[$i]['bench3']; ?></td>
                                                            <td><?= $restotal[$i]['bench5']; ?></td>
                                                            <td><?= $restotal[$i]['framesize']; ?></td>
                                                        </tr>
                                                        </tbody>
                                                        <thead>
                                                            <tr>
                                                                <th>MAC Destination</th>
                                                                <th>MAC Source</th>
                                                                <th>Type de la trame</th>
                                                                <th>Field2</th>
                                                                <th>Field3</th>
                                                                <th>Field4</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?= $restotal[$i]['macdst']; ?></td>
                                                                <td><?= $restotal[$i]['macsrc']; ?></td>
                                                                <td>0x<?= $restotal[$i]['field1']; ?></td>
                                                                <td><?= $restotal[$i]['field2']; ?></td>
                                                                <td><?= $restotal[$i]['field3']; ?></td>
                                                                <td><?= $restotal[$i]['field4']; ?></td>                                    
                                                            </tr>
                                                        </tbody>
                                                        <thead>
                                                            <tr>
                                                                <th>Field5</th>
                                                                <th>Field6</th>
                                                                <th>MAC Sender</th>
                                                                <th>IP Sender</th>
                                                                <th>MAC Target</th>
                                                                <th>IP Target</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?= $restotal[$i]['field5']; ?></td>
                                                                <td><?= $restotal[$i]['field6']; ?></td>
                                                                <td><?= $restotal[$i]['macsender']; ?></td>
                                                                <td><?= $restotal[$i]['ipsender']; ?></td>
                                                                <td><?= $restotal[$i]['mactarget']; ?></td>
                                                                <td><?= $restotal[$i]['iptarget']; ?></td>                                     
                                                            </tr>
                                                        </tbody>
                                                        <?php                                           
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