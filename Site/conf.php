<?php
if (isset($_POST["column"])) 
{
    $selectedColumn = $_POST["column"];
    $newTitle = $_POST["newTitle"];
    setcookie($selectedColumn, $newTitle, time() + 3600 * 24 * 365);
    $_COOKIE[$selectedColumn] = $newTitle;
}

if (isset($_POST["totalrec"])) 
{
    setcookie("totalrec", $_POST["totalrec"], time() + 3600 * 24 * 365);
    $_COOKIE['totalrec'] = $_POST["totalrec"];
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
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand padding">
            <img src="Thales_Alenia_Space_Logo.svg.png" width="150" height="60" class="d-inline-block align-top" alt="">
        </a>
        <a class="navbar-brand ml-auto padding">
            <img src="Logo-couple-IUT-horizontal-CMJN-05-07-1-1024x415.jpg" width="150" height="60" class="align-top" alt="">
        </a>
        </nav>
        <nav class="nav nav-pills nav-justified">
        <a class="nav-item nav-link unactive-link" href="index.php">Accueil</a>
        <a class="nav-item nav-link active-link" href="conf.php">Configuration</a>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="text-center font">Modifiez les paramêtres concernant les différentes pages du site</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <?php
                                    if (isset($_POST['status']))
                                    {
                                        echo "Nombre de trames par page actualisé à {$_POST['totalrec']}";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="text-center font">Page d'affichage des trames (affiche.php)</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                <h2>Choix des noms des champs pour les trames</h2>
                                    <form action="" method="POST">
                                        <label for="column">Selection des champs :</label>
                                        <select name="column" class="btn conf" id="column">
                                        <option value="numtrame"><?php if (isset($_COOKIE['numtrame'])){echo $_COOKIE['numtrame'];}else{echo "Numéro de la trame";} ?></option>
                                        <option value="numfic"><?php if (isset($_COOKIE['numfic'])){echo $_COOKIE['numfic'];}else{echo "Numéro du fichier";} ?></option>
                                        <option value="date"><?php if (isset($_COOKIE['date'])){echo $_COOKIE['date'];}else{echo "Date de la trame";} ?></option>
                                        <option value="pmid"><?php if (isset($_COOKIE['pmid'])){echo $_COOKIE['pmid'];}else{echo "PMID";} ?></option>
                                        <option value="bench3"><?php if (isset($_COOKIE['bench3'])){echo $_COOKIE['bench3'];}else{echo "Bench3";} ?></option>
                                        <option value="bench5"><?php if (isset($_COOKIE['bench5'])){echo $_COOKIE['bench5'];}else{echo "Bench5";} ?></option>
                                        <option value="framesize"><?php if (isset($_COOKIE['framesize'])){echo $_COOKIE['framesize'];}else{echo "Taille de la trame";} ?></option>
                                        <option value="macdst"><?php if (isset($_COOKIE['macdst'])){echo $_COOKIE['macdst'];}else{echo "MAC Destination";} ?></option>
                                        <option value="macsrc"><?php if (isset($_COOKIE['macsrc'])){echo $_COOKIE['macsrc'];}else{echo "MAC Source";} ?></option>
                                        <option value="field1"><?php if (isset($_COOKIE['field1'])){echo $_COOKIE['field1'];}else{echo "Type de la trame";} ?></option>
                                        <option value="field2"><?php if (isset($_COOKIE['field2'])){echo $_COOKIE['field2'];}else{echo "Field2";} ?></option>
                                        <option value="field3"><?php if (isset($_COOKIE['field3'])){echo $_COOKIE['field3'];}else{echo "Field3";} ?></option>
                                        <option value="field4"><?php if (isset($_COOKIE['field4'])){echo $_COOKIE['field4'];}else{echo "Field4";} ?></option>
                                        <option value="field5"><?php if (isset($_COOKIE['field5'])){echo $_COOKIE['field5'];}else{echo "Field5";} ?></option>
                                        <option value="field6"><?php if (isset($_COOKIE['field6'])){echo $_COOKIE['field6'];}else{echo "Field6";} ?></option>
                                        <option value="field7"><?php if (isset($_COOKIE['field7'])){echo $_COOKIE['field7'];}else{echo "Field7";} ?></option>
                                        <option value="ipsrc"><?php if (isset($_COOKIE['ipsrc'])){echo $_COOKIE['ipsrc'];}else{echo "IP Source";} ?></option>
                                        <option value="ipdst"><?php if (isset($_COOKIE['ipdst'])){echo $_COOKIE['ipdst'];}else{echo "IP Destination";} ?></option>
                                        <option value="field9"><?php if (isset($_COOKIE['field9'])){echo $_COOKIE['field9'];}else{echo "Field9";} ?></option>
                                        <option value="field10"><?php if (isset($_COOKIE['field10'])){echo $_COOKIE['field10'];}else{echo "Field10";} ?></option>
                                        <option value="field11"><?php if (isset($_COOKIE['field11'])){echo $_COOKIE['field11'];}else{echo "Field11";} ?></option>
                                        <option value="field14"><?php if (isset($_COOKIE['field14'])){echo $_COOKIE['field14'];}else{echo "Field14";} ?></option>
                                        <option value="field16"><?php if (isset($_COOKIE['field16'])){echo $_COOKIE['field16'];}else{echo "Field16";} ?></option>
                                        <option value="field17"><?php if (isset($_COOKIE['field17'])){echo $_COOKIE['field17'];}else{echo "Field17";} ?></option>
                                        <option value="field18"><?php if (isset($_COOKIE['field18'])){echo $_COOKIE['field18'];}else{echo "Field18";} ?></option>
                                        <option value="field20"><?php if (isset($_COOKIE['field20'])){echo $_COOKIE['field20'];}else{echo "Field20";} ?></option>
                                        <option value="field21"><?php if (isset($_COOKIE['field21'])){echo $_COOKIE['field21'];}else{echo "Field21";} ?></option>
                                        <option value="field23"><?php if (isset($_COOKIE['field23'])){echo $_COOKIE['field23'];}else{echo "Field23";} ?></option>
                                        <option value="field25"><?php if (isset($_COOKIE['field25'])){echo $_COOKIE['field25'];}else{echo "Field25";} ?></option>
                                        <option value="field26"><?php if (isset($_COOKIE['field26'])){echo $_COOKIE['field26'];}else{echo "Field26";} ?></option>
                                        <option value="field28"><?php if (isset($_COOKIE['field28'])){echo $_COOKIE['field28'];}else{echo "Field28";} ?></option>
                                        <option value="field29"><?php if (isset($_COOKIE['field29'])){echo $_COOKIE['field29'];}else{echo "Field29";} ?></option>
                                        <option value="field30"><?php if (isset($_COOKIE['field30'])){echo $_COOKIE['field30'];}else{echo "Field30";} ?></option>
                                        <option value="field32"><?php if (isset($_COOKIE['field32'])){echo $_COOKIE['field32'];}else{echo "Field32";} ?></option>
                                        <option value="field333435"><?php if (isset($_COOKIE['field333435'])){echo $_COOKIE['field333435'];}else{echo "Field333435";} ?></option>
                                        <option value="timepacket"><?php if (isset($_COOKIE['timepacket'])){echo $_COOKIE['timepacket'];}else{echo "Timepacket";} ?></option>
                                        <option value="macsender"><?php if (isset($_COOKIE['macsender'])){echo $_COOKIE['macsender'];}else{echo "MAC Sender";} ?></option>
                                        <option value="ipsender"><?php if (isset($_COOKIE['ipsender'])){echo $_COOKIE['ipsender'];}else{echo "IP Sender";} ?></option>
                                        <option value="mactarget"><?php if (isset($_COOKIE['mactarget'])){echo $_COOKIE['mactarget'];}else{echo "MAC Target";} ?></option>
                                        <option value="iptarget"><?php if (isset($_COOKIE['iptarget'])){echo $_COOKIE['iptarget'];}else{echo "IP Target";} ?></option>
                                        </select>
                                        <label for="newTitle">Nouveau nom :</label>
                                        <input type="text" name="newTitle" id="newTitle" placeholder="Tapez le nouveau nom">
                                        <button type="submit" class="btn btn-primary";>Remplacer nom</button>
                                    </form>
                                    <br>
                                    <h2>Choix du nombre de trames affichées par page</h2>
                                    <form action="" method="POST">
                                        <label for="totalrec">Selection du nombre de trames :</label>
                                        <select name="totalrec" class="btn conf" id="totalrec">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="75">75</option>
                                        <option value="100">100</option>
                                        </select>
                                        <input type='hidden' name='status' value='ok'>
                                        <button type="submit" class="btn btn-primary";>Actualiser nombre</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="text-center font">Page d'accueil (index.php)</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                <h2>Choix des noms des champs pour les fichier</h2>
                                    <form action="" method="POST">
                                        <label for="column">Selection des champs :</label>
                                        <select name="column" class="btn conf" id="column">
                                        <option value="numfic"><?php if (isset($_COOKIE['numfic'])){echo $_COOKIE['numfic'];}else{echo "ID du fichier";} ?></option>
                                        <option value="nomfic"><?php if (isset($_COOKIE['nomfic'])){echo $_COOKIE['nomfic'];}else{echo "Nom du fichier";} ?></option>
                                        <option value="obsw"><?php if (isset($_COOKIE['obsw'])){echo $_COOKIE['obsw'];}else{echo "Type et version OBSW";} ?></option>
                                        <option value="bds"><?php if (isset($_COOKIE['bds'])){echo $_COOKIE['bds'];}else{echo "version BDS";} ?></option>
                                        <option value="tv"><?php if (isset($_COOKIE['tv'])){echo $_COOKIE['tv'];}else{echo "Type et version moyen";} ?></option>
                                        <option value="dt"><?php if (isset($_COOKIE['dt'])){echo $_COOKIE['dt'];}else{echo "Date du fichier";} ?></option>
                                        </select>
                                        <label for="newTitle">Nouveau nom :</label>
                                        <input type="text" name="newTitle" id="newTitle" placeholder="Tapez le nouveau nom">
                                        <button type="submit" class="btn btn-primary";>Remplacer nom</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
        </footer>
    </body>
</html>