<?php
require_once('identifier.php');
?>
<! DOCTYPE HTML>
<html>
<head>
    <title>Nouveau produit</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
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
            Veuillez saisir les données du nouveau produit
        </div>
        <a href="nouvellentree.php" class="stron">          
            Approvisionnement
        </a>
        <div class="panel-body">
            <form method="GET" class="form-inline" onsubmit="return verifForm(this)">

                <div class="form-group largeur100">
                    <label for="designation" class="stron">Désignation du produit</label>
                    &nbsp <!--Pour espacement-->
                    <input type="text" name="designation"  id="designation"  class="form-control" onblur="champnovide(this)"/>
                    <input type="text" id="param" name="param" style="visibility:hidden;" />
                </div>

                <div class="form-group largeur100">
                    <label for="qtemin" class="stron">Quantité minimale</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp &nbsp<!--Pour espacement-->                   
                    <input type="number" name="qtemin" id="qtemin"  class="form-control" onblur="champnovide(this);verifqte(this)"/>
                </div>

                <div class="form-group largeur100">
                    <label for="marque" class="stron">Marque du produit</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp &nbsp<!--Pour espacement-->
                    <input type="text" name="marque" id="marque" class="form-control"/>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary stron" id="enregistrer" name="enregistrer" value="Enregistrer" style="margin-top:10px;" onclick="document.getElementById('param').value='inserer';chargementproduits();">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>                               
                </div>
            </form>
        </div>
    </div>

</div>
</body>
</html>
