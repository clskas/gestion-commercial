<?php
require_once('identifier.php');
?>
<! DOCTYPE HTML>
<html>
<head>
    <title>Nouvelle unité</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">       
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
        <div class="panel-heading bg-primary text-white">
            Veuillez saisir les données de la nouvelle unité
        </div>
        <a href="nouvellentree.php">          
            Approvisionnement
        </a>
        <div class="panel-body">
            <form method="GET" class="form-inline">

                <div class="form-group largeur100">
                    <label for="nouvellibel">Libellé</label>
                    <input type="text" name="nouvellibel"  id="nouvellibel"  class="form-control" onblur="champnovide(this)"/>
                    <input type="text" id="param" name="param" style="visibility:hidden;" />
                </div>
                <div class="form-group">
                    <input type="button" id="enregistrer" name="enregistrer" value="Enregistrer" style="margin-top:10px;" onclick="document.getElementById('param').value='inserer';chargementunitemesure();"/>
                </div>

            </form>
        </div>
    </div>

</div>
</body>
</html>
