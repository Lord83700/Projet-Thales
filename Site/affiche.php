<?php
session_start();

// Vérifie si le paramètre "page" est défini dans la requête GET
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1; // Valeur par défaut si le paramètre "page" n'est pas défini
}

// Vérifie si le cookie "totalrec" est défini
if (isset($_COOKIE["totalrec"])) {
    $totalrec = $_COOKIE["totalrec"];
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
    <?php
    include("base.php");

    // Calcule la valeur de début pour la pagination
    $debut = $page - 1;
    $debut = $debut * $totalrec;

    // Effectue la requête pour récupérer les données de trame800 et trame806
    $query = "SELECT field1,numfic,date FROM trame800 WHERE trame800.numfic=:numfic UNION SELECT field1,numfic,date FROM trame806 WHERE trame806.numfic=:numfic";
    $req = $bd->prepare($query);
    $req->bindValue(':numfic', $_GET['numfic']);
    $req->execute();

    // Compte le nombre de lignes retournées par la requête
    $count = $req->rowCount();
    $req->closeCursor();

    // Calcule le nombre total de pages en fonction du nombre de lignes et du nombre d'enregistrements par page
    $totalpage = ceil($count / $totalrec);
    ?>

    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand">
            <img src="Thales_Alenia_Space_Logo.svg.png" width="150" height="60" class="d-inline-block align-top" alt="">
        </a>
        <a class="navbar-brand ml-auto">
            <img src="Logo-couple-IUT-horizontal-CMJN-05-07-1-1024x415.jpg" width="150" height="60" class="align-top" alt="">
        </a>
    </nav>

    <nav class="nav nav-pills nav-justified">
        <a class="nav-item nav-link unactive-link" href="index.php">Accueil</a>
        <a class="nav-item nav-link unactive-link" href="conf.php">Configuration</a>
    </nav>

    <button id="scrollToTopBtn" class="btn">Retourne en haut</button>

    <div class="col-md-12">
        <div class="card mt-4">
            <div class="card-body">
                <table class="table table-bordered">
                    <h4 class="text-center font">Affichage des trames du fichier <?php echo $_GET['numfic']; ?> sélectionné par page</h4>
                                    <form method="GET" action="">
                                        <select id="selec_page" name="page" class="btn btn-primary page" onchange="this.form.submit();">
                                            <option value="Select">Page <?php if(isset($_GET['page'])){echo $_GET['page'];} ?></option>
                                            <?php
                                            // Génère les options pour la sélection de page
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
                                    // Select les données de trame800 et trame806 par rapport au numéro de fichier
                                    $query = "SELECT * FROM trame800 INNER JOIN fic ON fic.numfic=trame800.numfic WHERE fic.numfic=:numfic;";
                                    $req = $bd->prepare($query);
                                    $req->bindValue(':numfic', $_GET['numfic']);
                                    $req->execute();
                                    $res800 = $req->fetchAll();
                                    $count800 = $req->rowCount();
                                    $req->closeCursor();

                                    $query = "SELECT * FROM trame806 INNER JOIN fic ON fic.numfic=trame806.numfic WHERE fic.numfic=:numfic;";
                                    $req = $bd->prepare($query);
                                    $req->bindValue(':numfic', $_GET['numfic']);
                                    $req->execute();
                                    $res806 = $req->fetchAll();
                                    $count806 = $req->rowCount();
                                    $req->closeCursor();

                                    $i = 0;
                                    $j = 0;
                                    $restotal = [];

                                    // Fusionne ces résultats dans l'ordre chronologique
                                    if ($count800 > 0 || $count806 > 0) {
                                        while ($i < $count800 && $j < $count806) {
                                            $date1 = DateTime::createFromFormat('l:d:M:m:Y:H:i:s.u', $res800[$i]['date']);
                                            $date2 = DateTime::createFromFormat('l:d:M:m:Y:H:i:s.u', $res806[$j]['date']);

                                            if ($date1 < $date2) {
                                                array_push($restotal, $res800[$i]);
                                                $i++;
                                            } elseif ($date2 < $date1) {
                                                array_push($restotal, $res806[$j]);
                                                $j++;
                                            }
                                        }

                                        // Ajoute les derniers éléments s'il en reste
                                        while ($i < $count800) {
                                            array_push($restotal, $res800[$i]);
                                            $i++;
                                        }

                                        // Ajoute les derniers éléments s'il en reste
                                        while ($j < $count806) {
                                            array_push($restotal, $res806[$j]);
                                            $j++;
                                        }

                                        // Affiche les données d'une certaine manière en fonction du type de trame
                                        for ($i = $debut; $i < min($debut + $totalrec, count($restotal)); $i++) {
                                            if ($restotal[$i]['field1'] == 800) {
                                                $typetrame = "trame800";
                                            } elseif ($restotal[$i]['field1'] == 806) {
                                                $typetrame = "trame806";
                                            }

                                            if ($typetrame == "trame800") {
                                                    ?>
                                                    <div class="col-md-12">
                                                    <div class="card mt-4">
                                                        <div class="card-body">
                                                            <table class="table table-bordered">
                                                            <h4 id="<?= $restotal[$i]['numtrame']; ?>" class="text-center font">Affichage des informations concernant la trame <?php echo $restotal[$i]['numtrame']; ?></h4>
                                                    <thead>
                                                        <tr>
                                                            <th><?php if(isset($_COOKIE['numtrame'])){echo $_COOKIE['numtrame'];}else{echo "Numéro de la trame";} ?></th>
                                                            <th><?php if(isset($_COOKIE['numfic'])){echo $_COOKIE['numfic'];}else{echo "Numéro du fichier";} ?></th>
                                                            <th><?php if(isset($_COOKIE['date'])){echo $_COOKIE['date'];}else{echo "Date de la trame";} ?></th>
                                                            <th><?php if(isset($_COOKIE['pmid'])){echo $_COOKIE['pmid'];}else{echo "PMID";} ?></th>
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
                                                            <th><?php if(isset($_COOKIE['bench3'])){echo $_COOKIE['bench3'];}else{echo "Bench3";} ?></th>
                                                            <th><?php if(isset($_COOKIE['bench5'])){echo $_COOKIE['bench5'];}else{echo "Bench5";} ?></th>
                                                            <th><?php if(isset($_COOKIE['framesize'])){echo $_COOKIE['framesize'];}else{echo "Taille de la trame";} ?></th>
                                                            <th><?php if(isset($_COOKIE['macdst'])){echo $_COOKIE['macdst'];}else{echo "MAC Destination";} ?></th>
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
                                                            <th><?php if(isset($_COOKIE['macsrc'])){echo $_COOKIE['macsrc'];}else{echo "MAC Source";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field1'])){echo $_COOKIE['field1'];}else{echo "Type de la trame";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field2'])){echo $_COOKIE['field2'];}else{echo "Field2";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field3'])){echo $_COOKIE['field3'];}else{echo "Field3";} ?></th>
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
                                                            <th><?php if(isset($_COOKIE['field4'])){echo $_COOKIE['field4'];}else{echo "Field4";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field5'])){echo $_COOKIE['field5'];}else{echo "Field5";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field6'])){echo $_COOKIE['field6'];}else{echo "Field6";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field7'])){echo $_COOKIE['field7'];}else{echo "Field7";} ?></th>
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
                                                            <th><?php if(isset($_COOKIE['ipsrc'])){echo $_COOKIE['ipsrc'];}else{echo "IP Source";} ?></th>
                                                            <th><?php if(isset($_COOKIE['ipdst'])){echo $_COOKIE['ipdst'];}else{echo "IP Destination";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field9'])){echo $_COOKIE['field9'];}else{echo "Field9";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field10'])){echo $_COOKIE['field10'];}else{echo "Field10";} ?></th>
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
                                                            <th><?php if(isset($_COOKIE['field11'])){echo $_COOKIE['field11'];}else{echo "Field11";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field14'])){echo $_COOKIE['field14'];}else{echo "Field14";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field16'])){echo $_COOKIE['field16'];}else{echo "Field16";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field17'])){echo $_COOKIE['field17'];}else{echo "Field17";} ?></th>
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
                                                            <th><?php if(isset($_COOKIE['field18'])){echo $_COOKIE['field18'];}else{echo "Field18";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field20'])){echo $_COOKIE['field20'];}else{echo "Field20";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field21'])){echo $_COOKIE['field21'];}else{echo "Field21";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field23'])){echo $_COOKIE['field23'];}else{echo "Field23";} ?></th>
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
                                                            <th><?php if(isset($_COOKIE['field25'])){echo $_COOKIE['field25'];}else{echo "Field25";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field26'])){echo $_COOKIE['field26'];}else{echo "Field26";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field28'])){echo $_COOKIE['field28'];}else{echo "Field28";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field29'])){echo $_COOKIE['field29'];}else{echo "Field29";} ?></th>
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
                                                            <th><?php if(isset($_COOKIE['field30'])){echo $_COOKIE['field30'];}else{echo "Field30";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field32'])){echo $_COOKIE['field32'];}else{echo "Field32";} ?></th>
                                                            <th><?php if(isset($_COOKIE['field333435'])){echo $_COOKIE['field333435'];}else{echo "Field333435";} ?></th>
                                                            <th><?php if(isset($_COOKIE['timepacket'])){echo $_COOKIE['timepacket'];}else{echo "Timepacket";} ?></th>
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
                                                                <th><?php if(isset($_COOKIE['numtrame'])){echo $_COOKIE['numtrame'];}else{echo "Numéro de la trame";} ?></th>
                                                                <th><?php if(isset($_COOKIE['numfic'])){echo $_COOKIE['numfic'];}else{echo "Numéro du fichier";} ?></th>
                                                                <th><?php if(isset($_COOKIE['date'])){echo $_COOKIE['date'];}else{echo "Date de la trame";} ?></th>
                                                                <th><?php if(isset($_COOKIE['bench3'])){echo $_COOKIE['bench3'];}else{echo "Bench3";} ?></th>
                                                                <th><?php if(isset($_COOKIE['bench5'])){echo $_COOKIE['bench5'];}else{echo "Bench5";} ?></th>
                                                                <th><?php if(isset($_COOKIE['framesize'])){echo $_COOKIE['framesize'];}else{echo "Taille de la trame";} ?></th>
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
                                                                <th><?php if(isset($_COOKIE['macdst'])){echo $_COOKIE['macdst'];}else{echo "MAC Destination";} ?></th>
                                                                <th><?php if(isset($_COOKIE['macsrc'])){echo $_COOKIE['macsrc'];}else{echo "MAC Source";} ?></th>
                                                                <th><?php if(isset($_COOKIE['field1'])){echo $_COOKIE['field1'];}else{echo "Type de la trame";} ?></th>
                                                                <th><?php if(isset($_COOKIE['field2'])){echo $_COOKIE['field2'];}else{echo "Field2";} ?></th>
                                                                <th><?php if(isset($_COOKIE['field3'])){echo $_COOKIE['field3'];}else{echo "Field3";} ?></th>
                                                                <th><?php if(isset($_COOKIE['field4'])){echo $_COOKIE['field4'];}else{echo "Field4";} ?></th>
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
                                                                <th><?php if(isset($_COOKIE['field5'])){echo $_COOKIE['field5'];}else{echo "Field5";} ?></th>
                                                                <th><?php if(isset($_COOKIE['field6'])){echo $_COOKIE['field6'];}else{echo "Field6";} ?></th>
                                                                <th><?php if(isset($_COOKIE['macsender'])){echo $_COOKIE['macsender'];}else{echo "MAC Sender";} ?></th>
                                                                <th><?php if(isset($_COOKIE['ipsender'])){echo $_COOKIE['ipsender'];}else{echo "IP Sender";} ?></th>
                                                                <th><?php if(isset($_COOKIE['mactarget'])){echo $_COOKIE['mactarget'];}else{echo "MAC Target";} ?></th>
                                                                <th><?php if(isset($_COOKIE['iptarget'])){echo $_COOKIE['iptarget'];}else{echo "IP Target";} ?></th>
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
                            <form method="GET" action="">
                                <select id="selec_page" name="page" class="btn btn-primary page" onchange="this.form.submit();">  
                                    <option value="Select">Page <?php if(isset($_GET['page'])){echo $_GET['page'];} ?></option> 
                                    <?php
                                    // Génère les options pour la sélection de page
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
        <footer>
        </footer>
    </body>
</html>
<script>
// Montre le bouton quand la page est descendue
window.onscroll = function() {
  showScrollButton();
};

function showScrollButton() {
  var scrollToTopBtn = document.getElementById("scrollToTopBtn");
  // Vérifie si la position de défilement de la page dépasse 20 pixels du haut
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    scrollToTopBtn.style.display = "block"; // Affiche le bouton de défilement en haut
  } else {
    scrollToTopBtn.style.display = "none"; // Masque le bouton de défilement en haut
  }
}

// Fait défiler la page en haut quand le bouton est cliqué
document.getElementById("scrollToTopBtn").onclick = function() {
  scrollToTop();
};

function scrollToTop() {
  // Fait défiler le corps de la page en haut
  document.body.scrollTop = 0;
  // Fait défiler la partie visible de la page en haut
  document.documentElement.scrollTop = 0;
}
</script>