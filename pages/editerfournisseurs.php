<?php
$idf=isset($_GET['idf'])?$_GET['idf']:0;

?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Editer Fournisseurs</title>
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
<body onload="document.getElementById('param').value='chargerchampmodifier';chargementfournisseurs();">
<?php include("menu.php"); ?>

<div class="container">


    <div class="panel panel-primary margetop">
        <div class="panel-heading bg-primary text-white stron">
            Edition fournisseur :
        </div>
        <div class="panel-body">
            <form  method="GET" class="form-inline">
                <div class="form-group">
                    <input type="hidden" name="idf" id="idf" class="form-control" value="<?php echo $idf ?>"/>
                </div>
                    <!-- <option value="Monsieur" <?php //if($civilite=="Monsieur") echo "selected" ?>> Monsieur</option>
                        <option value="Madame" <?php //if($civilite=="Madame") echo "selected" ?>> Madame</option>
                        <option value="Mademoiselle" <?php //if($civilite=="Mademoiselle") echo "selected" ?>>Mademoiselle</option>
                    -->

                <div class="form-group largeur100">
                    <label for="civilité" class="stron">Civilité</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                     &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp  <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp  <!--Pour espacement-->
                    <select name="civilite" class="form-control" id="civilite">
                        
                    </select>
                    <input type="text" id="param" name="param" style="visibility:hidden;" />
                </div>

                <div class="form-group largeur100">
                    <label for="nom" class="stron">Nom du fournisseur</label>
                    &nbsp  &nbsp  <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp   <!--Pour espacement-->
                    <input type="text" name="nom" id="nom" class="form-control"/>
                </div>

                <div class="form-group largeur100">
                    <label for="prenom" class="stron">Prenom du fournisseur</label>
                    &nbsp  &nbsp  <!--Pour espacement-->
                    &nbsp  <!--Pour espacement-->
                    <input type="text" name="prenom" id="prenom"
                     class="form-control"/>
                </div>

                <div class="form-group largeur100">
                    <label for="email" class="stron">Email du fournisseur</label>
                     &nbsp  &nbsp  <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  <!--Pour espacement-->
                    <input type="email" name="email" id="email" class="form-control"/>
                </div>

                <div class="form-group largeur100">
                    <label for="reseausocial" class="stron">Réseaux sociaux</label>
                    &nbsp  &nbsp  <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp  <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  <!--Pour espacement-->
                    <input type="text" name="reseausocial" id="reseausocial" class="form-control"/>
                </div>

                <div class="form-group largeur100">
                    <label for="telephone" class="stron">Téléphone</label>
                    &nbsp  &nbsp  <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp  <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp  <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp<!--Pour espacement-->
                    <input type="telephone" name="telephone" id="telephone" class="form-control"/>
                </div>

                <div class="form-group largeur100">
                    <label for="adresse" class="stron">Adresse du fournisseur</label>
                    &nbsp  &nbsp  <!--Pour espacement-->
                    &nbsp   <!--Pour espacement-->
                    <input type="text" name="adresse" id="adresse" class="form-control"/>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary stron" id="modifier" name="modifier" value="Modifier" style="margin-top:10px;" onclick="document.getElementById('param').value='modifier';chargementfournisseurs();">
                        <i class="fas fa-save"></i> Modifier
                    </button>                               
                </div>
            </form>
        </div>
    </div>

</div>
</body>
</html>
