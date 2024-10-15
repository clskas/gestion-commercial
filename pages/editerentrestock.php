<?php
require_once('identifier.php');
require_once('connexiondb.php');
$idES=isset($_GET['identrestock'])?$_GET['identrestock']:0;
$ancienproduit=isset($_GET['ancienproduit'])?$_GET['ancienproduit']:0;
$ancienneqte=isset($_GET['ancienqte'])?$_GET['ancienqte']:0;

$requeteF="SELECT idf,CONCAT( nom,' ', prenom ) AS fournisseurs FROM fournisseur";
$resultatF=$pdo->query($requeteF);

$requeteP="SELECT * FROM produits";
$resultatP=$pdo->query($requeteP);
?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Editer Entre-stock</title>
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
<body onload="document.getElementById('param').value='chargerchampmodifier';chargementapprovisionnement();">
<?php include("menu.php"); ?>

<div class="container">
    <div class="panel panel-primary margetop">
        <div class="panel-heading bg-primary text-white stron">
            Edition Approvisionnement
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline" id="modifierentre">

                <div class="form-group">
                    <input type="hidden" name="idES" id="idES" class="form-control" value="<?php echo $idES ?>"/>
                    <input type="hidden" name="ancienproduit" id="ancienproduit" class="form-control" value="<?php echo $ancienproduit ?>"/>
                    <input type="hidden" name="ancienqte" id="ancienqte" class="form-control" value="<?php echo $ancienneqte ?>"/>
                </div>

                <div class="form-group largeur100">
                    <label for="idFournisseur" class="stron">Fournisseur</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp   <!--Pour espacement-->
                    <select name="idFournisseur" class="form-control" id="idFournisseur">                                                                                  
                    </select>
                </div>

                <div class="form-group largeur100">
                    <label for="idproduit" class="stron">Produit</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <select name="idproduit" class="form-control" id="idproduit">                                       
                    </select>
                    <input type="text" id="param" name="param" style="visibility:hidden;" />
                </div>

                <div class="form-group largeur100">
                    <label for="numerofacture" class="stron">Numero facture achat</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    
                    <input type="text" name="numerofacture" id="numerofacture" class="form-control"/>
                </div>
                <div class="form-group largeur100">
                    <label for="quantiteentre" class="stron">Quantité</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  <!--Pour espacement-->
                    <input type="number" name="quantiteentre" id="quantiteentre" class="form-control"/>
                    <label for="iduniteedit" class="stron">Unités</label>
                    <select name="iduniteedit" class="form-control" id="iduniteedit">                   
                    </select> 
                </div>

                <div class="form-group largeur100">
                    <label for="puht" class="stron">Prix unitaire</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <input type="text" name="puht" id="puht" class="form-control" onblur="verifprix(this)"/>
                    &nbsp  &nbsp <!--Pour espacement-->
                    <input type="radio" id="editfc" name="editappromonnaie" value="FC"/>                                        
                    <label for="editfc">Fc</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                                
                    <input type="radio" id="editdolar" name="editappromonnaie" value="$"/>                     
                    <label for="editdolar">$</label>  
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement--> 
                </div>

                <div class="form-group largeur100">
                    <label for="dateenre" class="stron">Date entrée</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp   <!--Pour espacement-->
                    <input type="date" name="dateenre" id="dateenre"
                           class="form-control" />
                </div>

                <div class="form-group largeur100">
                    <label for="observation" class="stron">Observation</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp   <!--Pour espacement-->
                    <input type="text" name="observation" id="observation"
                           class="form-control"/>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary stron" id="modifier" name="modifier" value="Modifier" style="margin-top:10px;" onclick="document.getElementById('param').value='modifier';chargementapprovisionnement();">
                        <i class="fas fa-save"></i> Modifier
                    </button>                               
                </div>
            </form>
        </div>
    </div>

</div>
</body>
</html>
