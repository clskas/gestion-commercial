<?php
require_once('identifier.php');
?>
<! DOCTYPE HTML>
<html>
<head>
    <title>Nouvelle dépense</title>
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
            Veuillez saisir les données de la nouvelle dépense
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline" onsubmit="return verifForm(this)">

                <div class="form-group largeur100">
                    <label for="motif" class="stron">Motif de dépense</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    
                    <input type="text" name="motif"  id="motif"  class="form-control" onblur="champnovide(this)"/>
                    <input type="text" id="param" name="param" style="visibility:hidden;" />
                </div>

                <div class="form-group largeur100">
                    <label for="montant" class="stron">Montant</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <input type="text" name="montant" id="montant"  class="form-control" onblur="champnovide(this);verifprix(this)"/>
                    &nbsp  &nbsp <!--Pour espacement-->
                    <input type="radio" id="fc" name="monnaie" value="FC"/> 
                    &nbsp  &nbsp <!--Pour espacement-->                    
                    <label for="fc">Fc</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->                  
                    <input type="radio" id="dollar" name="monnaie" value="$"/>                      
                    <label for="dollar">$</label>  
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->  
                </div>
                 
                <div class="form-group">
                    <button type="button" class="btn btn-primary stron" id="enregistrer" name="enregistrer" value="Enregistrer" style="margin-top:10px;" onclick="document.getElementById('param').value='inserer';verifiermonnaiedepense();">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>                               
                </div>
            </form>
        </div>
    </div>

</div>
</body>
</html>
