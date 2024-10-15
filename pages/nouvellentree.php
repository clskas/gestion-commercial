<?php
require_once('identifier.php');
require_once('connexiondb.php');

/*$requeteF="SELECT idf,CONCAT( nom,' ', prenom ) AS fournisseurs FROM fournisseur";
$resultatF=$pdo->query($requeteF);

$requeteP="SELECT * FROM produits ORDER BY ref_produit DESC";
$resultatP=$pdo->QUERY($requeteP);*/
?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Nouvel approvisionnement</title>
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
        <div class="panel-heading bg-primary">
            Nouvelle Entrée stock
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline" id="approvisionnement" >

                <div class="form-group largeur100">
                    <div>
                        <label for="idFournisseur">Fournisseur</label>
                        <select name="idFournisseur" class="form-control" id="idFournisseur"
                        onfocus="document.getElementById('param').value='recuperer_fournisseur';
                        chargementapprovisionnement();">
                    <option value="0">Choisissez le fournisseur</option> 
                        </select>
                    </div>
                    <div>
                        <input type="text" id="param" name="param" style="visibility:hidden;" />
                    </div>
                </div>
                
                <div class="form-group largeur100">
                    <div>
                        <label for="idproduit">Produit</label>
                       
                        <select name="idproduit" class="form-control" id="idproduit" 
                        onfocus="document.getElementById('param').value='recuperer_produit';
                        chargementapprovisionnement();"
                        onchange="document.getElementById('param').value='recupererqte';chargementapprovisionnement();">  
                        <option value="0">Choisissez le produit</option>                  
                        </select>
                    </div>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp   <!--Pour espacement-->
                    <div>
                        <label for="qteenstock">Quanité disponible en stock</label>                       
                        <input type="text" name="qteenstock" id="qteenstock" class="form-control" disabled/> 
                    </div>
                </div>
                <div class="form-group largeur100">
                    <div>
                        <label for="quantiteentre">Quantité</label>                      
                        <input type="number" name="quantiteentre" id="quantiteentre" class="form-control" />
                    </div>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <div>
                        <label for="iduniteentre">Unités</label>
                        <select name="iduniteentre" class="form-control" id="iduniteentre" 
                        onfocus="document.getElementById('param').value='recuperer_unite';
                        chargementapprovisionnement();">  <option value="0">Choisissez unité</option>                  
                        </select>
                    </div>   
                </div>

                <div class="form-group largeur100">
                    <div>
                        <label for="puht">Prix unitaire</label>
                        <input type="text" name="puht" id="puht" class="form-control" onblur="verifprix(this)" />
                        &nbsp  &nbsp <!--Pour espacement-->
                    </div>
                    
                        <input type="radio" id="approfc" name="appromonnaie" value="FC"/>                     
                        <label for="approfc">Fc</label>
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->                              
                        <input type="radio" id="approdollar" name="appromonnaie" value="$"/>                      
                        <label for="approdollar">$</label>  
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement--> 
                     
                </div>  

                <div class="form-group largeur100">
                    <div> 
                        <label for="numerofacture">Numero facture achat</label>
                        <input type="text" name="numerofacture" id="numerofacture" class="form-control"/> 
                    </div> 
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <div>
                        <label for="observation">Observation</label>
                        <input type="text" name="observation" id="observation" class="form-control" />
                    </div>                 
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary stron" id="enregistrer" name="enregistrer" value="Enregistrer" style="margin-top:10px;" onclick="document.getElementById('param').value='inserer';verifiermonnaieapprovisionnement();">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>                               
                </div>                                                  
            </form>
        </div>
    </div>

</div>
</body>
</html>

