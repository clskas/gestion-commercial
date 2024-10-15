<?php 
    require_once('identifier.php'); 
    require_once('connexiondb.php');
    $identreprise=isset($_GET['identreprise'])?$_GET['identreprise']:0;

 ?>

<! DOCTYPE HTML>
<html>
    <head>
        <title>Editer entreprise</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">       
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
    <body onload="document.getElementById('param').value='chargerchampmodifier';chargemententreprises();">
        <?php include("menu.php"); ?>

        <div class="container">          
            <div class="panel panel-primary margetop60">
                <div class="panel-heading bg-primary">
                   Edition entreprise 
                </div>
                <div class="panel-body">
                    <form method="POST" class="form-inline" enctype="multipart/form-data" id="editformentre">
                        <div class="form-group">
                            <input type="hidden" name="identreprise" id="identreprise" value="<?php echo $identreprise ?>" class="form-control" />
                            <input type="text" id="param" name="param" style="visibility:hidden;" />
                        </div>
  
                        <div class="form-group largeur100">
                            <label for="nomentreprise">Nom entreprise</label>
                            <input type="text" name="nomentreprise" id="nomentreprise" class="form-control"/>
                        </div>
                        <div class="form-group largeur100">
                            <label for="adresse">Adresse</label>
                            <input type="text" name="adresseentreprise" id="adresseentreprise" class="form-control"/>
                        </div>  
                        <div class="form-group largeur100">
                            <label for="identitenationale">Identité nationale</label>
                            <input type="text" name="identitenationale" id="identitenationale" class="form-control"/>
                        </div> 
                               
                        <div class="form-group largeur100">
                            <label for="telephone">Téléphone</label>
                            <input type="text" name="telephoneeentreprise" id="telephoneeentreprise" class="form-control"/>
                        </div> 
                        <div class="form-group largeur100">
                            <label for="emailentre">Email</label>
                            <input type="text" name="emailentre" id="emailentre" class="form-control"/>
                        </div> 
                        <div class="form-group largeur100">
                            <label for="reseausocio">Reseau social</label>
                            <input type="text" name="reseausocio" id="reseausocio" class="form-control" />
                        </div> 
                        <div class="form-group largeur100">
                            <label for="photo">Logo</label>
                            <input type="file" name="photo" id="photo"/>
                            <div class='preview'>
                                <img id="img" width="50px" height="50px">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="button" id="modifier" name="modifier" value="Modifier" style="margin-top:10px;" onclick="document.getElementById('param').value='modifier';chargemententreprises();"/>
                        </div>
                    </form>
                </div>    
            </div>
            
        </div>
    </body>
</html>