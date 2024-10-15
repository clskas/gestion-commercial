<?php
require_once('identifier.php');
require_once('connexiondb.php');

$requeteP="SELECT * FROM commandes ORDER BY Com_num DESC";
$resultatP=$pdo->QUERY($requeteP);
?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Nouveau paiement</title>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">                                                       
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/fontawesome.min.css">
    <script src="../js/jquery-3.5.1.min.js"></script>              
    <script src="../js/facturationstock.js"></script>
    <script src="../js/sweetalert.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>   
    <script src="../js/pagination/jquery.twbsPagination.min.js"></script> 
</head>
<body>
<?php include("menu.php"); ?>

<div class="container">
    <div class="panel panel-primary margetop">
        <div class="panel-heading bg-primary text-white stron">
            Nouveau paiement
            <label id="reste"></label>
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline" >
                <div class="form-group largeur100">
                    <label for="numerofacture" class="stron">Numero facture</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    <select name="numerofacture" class="form-control" id="numerofacture"
                     onchange="document.getElementById('param').value='recup_commande';chargementpaiment();"
                     onfocus="document.getElementById('param').value='charger_facture';chargementpaiment();">
                        <option value="0">Choisissez numero facture</option>                   
                    </select>
                    <input type="text" id="param" name="param" style="visibility:hidden;" />
                </div>
                <div class="form-group largeur100">
                    <label for="montant_apaye" class="stron">Montant à payer</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    <input type="text" name="montant_apaye" id="montant_apaye" class="form-control" disabled/>
                    &nbsp  &nbsp <!--Pour espacement-->
                    <label for="restecom">Reste</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    <input type="text" name="restecom" id="restecom" class="form-control" disabled/>
                </div>
                <div class="form-group largeur100">
                    <label for="montant_paye" class="stron">Montant payé</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <input type="text" name="montant_paye" id="montant_paye"
                           class="form-control" onblur="verifprix(this);comparermontantapayeretmontantpaye(this);"/>
                    &nbsp  &nbsp <!--Pour espacement-->                   
                    <input type="radio" id="fc" name="monnaie" value="FC"/>  
                    <label for="fc" class="stron">Fc</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->                              
                    <input type="radio" id="dollar" name="monnaie" value="$"/>                      
                    <label for="dollar" class="stron">$</label>  
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->  
                </div>              
                <div class="form-group largeur100">
                    <label for="lasommede" class="stron">Motif paiement</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp   <!--Pour espacement-->
                    <input type="text" name="lasommede" id="lasommede" class="form-control"/>       
                </div>
                
                <div class="form-group">
                    <button type="button" class="btn btn-primary stron" id="enregistrer" name="enregistrer" value="Enregistrer" style="margin-top:10px;" onclick="document.getElementById('param').value='inserer';chargementpaiment();">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>                               
                </div> 
            </form> 
            <div id="imprimerrecupaiement"></div> 
                              
        </div>
    </div>  
</div>
</body>
</html>


