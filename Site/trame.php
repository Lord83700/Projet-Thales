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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <table class="table table-bordered">
                            <h4 class="text-center font">Affichage des informations concernant la trame choisi</h4>
                                    <?php 
                                        include ("base.php");

                                        if(isset($_GET['numtrame']))
                                        {
                                            $typetrame = $_GET['typetrame'];
                                            $query = "SELECT * FROM $typetrame WHERE numtrame=:numtrame";
                                            $req = $bd->prepare($query);
                                            $req->bindValue(':numtrame', $_GET['numtrame']);
                                            $req->execute();
                                            $count = $req->rowCount();
                                            $res = $req->fetchall();
                                            $req->closeCursor();

                                            if($count > 0)
                                            {
                                                if($typetrame == "trame800")
                                                {
                                                    foreach($res as $items)
                                                    {
                                                    ?>
                                                    <thead>
                                                        <tr>
                                                            <th>Numéro de la trame</th>
                                                            <th>Numéro du fichier</th>
                                                            <th>Date de la trame</th>
                                                            <th>PMID</th>
                                                            <th>Bench3</th>
                                                            <th>Bench5</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><?= $items['numtrame']; ?></td>
                                                        <td><?= $items['numfic']; ?></td>
                                                        <td><?= $items['date']; ?></td>
                                                        <td><?= $items['pmid']; ?></td>
                                                        <td><?= $items['bench3']; ?></td>
                                                        <td><?= $items['bench5']; ?></td>
                                                    </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>Taille de la trame</th>
                                                            <th>MAC Destination</th>
                                                            <th>MAC Source</th>
                                                            <th>Type de la trame</th>
                                                            <th>Field2</th>
                                                            <th>Field3</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $items['framesize']; ?></td>
                                                            <td><?= $items['macdst']; ?></td>
                                                            <td><?= $items['macsrc']; ?></td>
                                                            <td><?= $items['field1']; ?></td>
                                                            <td><?= $items['field2']; ?></td>
                                                            <td><?= $items['field3']; ?></td>                                    
                                                        </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>Field4</th>
                                                            <th>Field5</th>
                                                            <th>Field6</th>
                                                            <th>Field7</th>
                                                            <th>IP Source</th>
                                                            <th>IP Destination</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $items['field4']; ?></td>
                                                            <td><?= $items['field5']; ?></td>
                                                            <td><?= $items['field6']; ?></td>
                                                            <td><?= $items['field7']; ?></td>
                                                            <td><?= $items['ipsrc']; ?></td>
                                                            <td><?= $items['ipdst']; ?></td>                                     
                                                        </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>Field9</th>
                                                            <th>Field10</th>
                                                            <th>Field11</th>
                                                            <th>Field14</th>
                                                            <th>Field16</th>
                                                            <th>Field17</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $items['field9']; ?></td>
                                                            <td><?= $items['field10']; ?></td>  
                                                            <td><?= $items['field11']; ?></td>
                                                            <td><?= $items['field14']; ?></td>
                                                            <td><?= $items['field16']; ?></td>
                                                            <td><?= $items['field17']; ?></td>                                    
                                                        </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>Field18</th>
                                                            <th>Field20</th>
                                                            <th>Field21</th>
                                                            <th>Field23</th>
                                                            <th>Field25</th>
                                                            <th>Field26</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $items['field18']; ?></td>
                                                            <td><?= $items['field20']; ?></td>
                                                            <td><?= $items['field21']; ?></td>
                                                            <td><?= $items['field23']; ?></td>
                                                            <td><?= $items['field25']; ?></td>
                                                            <td><?= $items['field26']; ?></td>                                    
                                                        </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th>Field28</th>
                                                            <th>Field29</th>
                                                            <th>Field30</th>
                                                            <th>Field32</th>
                                                            <th>Field333435</th>
                                                            <th>Timepacket</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $items['field28']; ?></td>
                                                            <td><?= $items['field29']; ?></td>
                                                            <td><?= $items['field30']; ?></td>
                                                            <td><?= $items['field32']; ?></td>
                                                            <td><?= $items['field333435']; ?></td>
                                                            <td><?= $items['timepacket']; ?></td>                                         
                                                        </tr>
                                                    </tbody>                            
                                                    <?php
                                                    }
                                                }
                                                elseif($typetrame == "trame806")
                                                {
                                                    foreach($res as $items)
                                                    {
                                                    ?>
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
                                                        <td><?= $items['numtrame']; ?></td>
                                                        <td><?= $items['numfic']; ?></td>
                                                        <td><?= $items['date']; ?></td>
                                                        <td><?= $items['bench3']; ?></td>
                                                        <td><?= $items['bench5']; ?></td>
                                                        <td><?= $items['framesize']; ?></td>
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
                                                            <td><?= $items['macdst']; ?></td>
                                                            <td><?= $items['macsrc']; ?></td>
                                                            <td><?= $items['field1']; ?></td>
                                                            <td><?= $items['field2']; ?></td>
                                                            <td><?= $items['field3']; ?></td>
                                                            <td><?= $items['field4']; ?></td>                                    
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
                                                            <td><?= $items['field5']; ?></td>
                                                            <td><?= $items['field6']; ?></td>
                                                            <td><?= $items['macsender']; ?></td>
                                                            <td><?= $items['ipsender']; ?></td>
                                                            <td><?= $items['mactarget']; ?></td>
                                                            <td><?= $items['iptarget']; ?></td>                                     
                                                        </tr>
                                                    </tbody>
                                                    <?php
                                                    }
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
        </footer>
    </body>
</html>