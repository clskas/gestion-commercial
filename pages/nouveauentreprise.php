<?php 
     require_once('identifier.php');
     require_once('connexiondb.php');
 ?>

<! DOCTYPE HTML>
<html>
    <head>
        <title>Nouvelle entreprise</title>
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

        <!--<script src="../js/jquery.form.js"></script>
        <script src="../js/jquery.form.min.js"></script> -->

        <script src="../js/pagination/jquery.twbsPagination.min.js"></script>
    </head>
    <body>
        <?php include("menu.php"); ?>
        <div class="container">       
            <div class="panel panel-primary margetop">
                <div class="panel-heading bg-primary">
                   Ajout d'une nouvelle entreprise
                </div>
                <div class="panel-body">
                    <form method="POST" class="form-inline" enctype="multipart/form-data" id="entrepriseform">                   
                        <div class="form-group largeur100">
                            <label for="editnomentreprise">Nom entreprise</label>
                            &nbsp  &nbsp <!--Pour espacement-->                  
                            <input type="text" name="editnomentreprise" id="editnomentreprise" class="form-control"/>
                            <input type="text" id="param" name="param" style="visibility:hidden;"/>
                        </div>
                        <div class="form-group largeur100">
                            <label for="editadresseentreprise">Adresse</label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement--> 
                            &nbsp  &nbsp <!--Pour espacement-->                           
                            <input type="text" name="editadresseentreprise" id="editadresseentreprise" class="form-control"/>
                        </div> 
                        <div class="form-group largeur100">
                            <label for="editidentitenationale">Identité nationale</label>
                            
                            <input type="text" name="editidentitenationale" id="editidentitenationale" class="form-control"/>
                        </div> 
                        <div class="form-group largeur100">
                            <label for="edittelephone">Téléphone</label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement--> 
                            <input type="text" name="edittelephone" id="edittelephone" class="form-control"/>
                        </div> 
                        <div class="form-group largeur100">
                            <label for="editemailentre">Email</label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement--> 
                            &nbsp  &nbsp <!--Pour espacement--> 
                            &nbsp  &nbsp <!--Pour espacement--> 
                            <input type="text" name="editemailentre" id="editemailentre" class="form-control"/>
                        </div> 
                        <div class="form-group largeur100">
                            <label for="editreseausocio">Reseau social</label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            <input type="text" name="editreseausocio" id="editreseausocio" class="form-control" />
                        </div> 
                        <div class="form-group largeur100">
                            <label for="logo">Logo</label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement--> 
                            &nbsp  &nbsp <!--Pour espacement--> 
                            &nbsp  &nbsp <!--Pour espacement--> 
                            &nbsp  &nbsp <!--Pour espacement--> 
                            <input type="file" name="logo" id="logo"/>
                        </div>
                      
                        <div class="form-group">
                            <button type="button" class="btn btn-primary stron" id="enregistrer" name="enregistrer" value="Enregistrer" style="margin-top:10px;" onclick="document.getElementById('param').value='inserer';chargemententreprises();">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>                               
                        </div> 
                    </form>
                </div>    
            </div>
            
        </div>
    </body>
</html>
