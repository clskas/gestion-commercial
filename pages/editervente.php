<?php
require_once('identifier.php');
require_once('connexiondb.php');
$iddetail=isset($_GET['iddetail'])?$_GET['iddetail']:0;
$ancienproduit=isset($_GET['ancienproduit'])?$_GET['ancienproduit']:0;
$ancienneqte=isset($_GET['ancienqte'])?$_GET['ancienqte']:0;
$anciennefacture=isset($_GET['anciennefacture'])?$_GET['anciennefacture']:0;
$ancienmontant=isset($_GET['ancienmontant'])?$_GET['ancienmontant']:0;

?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Editer Vente</title>
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
<body onload="document.getElementById('param').value='chargerchampmodifier';chargementhistoriquedevente();">
<?php include("menu.php"); ?>

<div class="container">
    <div class="panel panel-primary margetop">
        <div class="panel-heading bg-primary text-white stron">
            Edition vente
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline">

                <div class="form-group">
                    <input type="hidden" name="idcommande" id="idcommande" class="form-control" value="<?php echo $iddetail ?>"/>
                    <input type="hidden" name="ancienproduit" id="ancienproduit" class="form-control" value="<?php echo $ancienproduit ?>"/>
                    <input type="hidden" name="ancienqte" id="ancienqte" class="form-control" value="<?php echo $ancienneqte ?>"/>
                    <input type="hidden" name="anciennefacture" id="anciennefacture" class="form-control" value="<?php echo $anciennefacture ?>"/>
                    <input type="hidden" name="ancienmontant" id="ancienmontant" class="form-control" value="<?php echo $ancienmontant ?>"/>
                </div>

                <div class="form-group largeur100">
                    <label for="numerocommande" class="stron">Numero facture</label>
                    &nbsp  &nbsp <!--Pour espacement-->                   
                    <select name="numerocommande" class="form-control" id="numerocommande">                                                                                  
                    </select>
                </div>

                <div class="form-group largeur100">
                    <label for="idclient" class="stron">Client</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp  <!--Pour espacement-->
                    &nbsp   <!--Pour espacement-->
                    <select name="idclient" class="form-control" id="idclient">                                                                                  
                    </select>
                </div>

                <div class="form-group largeur100">
                    <label for="idarticle" class="stron">Produit</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp  <!--Pour espacement-->
                    <select name="idarticle" class="form-control" id="idarticle">                                       
                    </select>
                    <input type="text" id="param" name="param" style="visibility:hidden;" />
                </div>
               
                <div class="form-group largeur100">
                    <label for="detailquantite" class="stron">Quantité</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp    <!--Pour espacement-->                  
                    <input type="number" name="detailquantite" id="detailquantite"
                           class="form-control"/>
                </div>

                <div class="form-group largeur100">
                    <label for="puht" class="stron">Prix unitaire </label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <input type="text" name="puht" id="puht"
                    class="form-control" onblur="verifprix(this)"/>                  
                </div>

                <div class="form-group largeur100">
                    <label for="datedetail" class="stron">Date vente</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  <!--Pour espacement-->                   
                    <input type="date" name="datedetail" id="datedetail" class="form-control" />
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary stron" id="modifier" name="modifier" value="Modifier" style="margin-top:10px;" onclick="document.getElementById('param').value='modifier';chargementhistoriquedevente();">
                        <i class="fas fa-save"></i> Modifier
                    </button>                               
                </div>
            </form>
        </div>
    </div>

</div>
</body>
</html>
