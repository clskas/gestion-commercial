<?php 
    require_once('identifier.php');  
    $idus=isset($_GET['idUser'])?$_GET['idUser']:0;    
 ?>

<! DOCTYPE HTML>
<html>
    <head>
        <title>Edition utilisateur</title>
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
    <body onload="document.getElementById('param').value='chargerchampmodifier';chargementutilisateurs();">
        <?php include("menu.php"); ?>
        <div class="container">          
            <div class="panel panel-primary margetop">
                <div class="panel-heading bg-primary text-white stron">
                   Edition de l'utilisateur
                </div>
                <div class="panel-body">
                    <form method="GET" class="form-inline">
                        <div class="form-group largeur100">
                            <input type="hidden" name="idutili" id="idutili" class="form-control" value="<?php echo $idus ?>"/>
                            <input type="text" id="param" name="param" style="visibility:hidden;"/>
                        </div>
                        <div class="form-group largeur100">
                            <label for="modifierlogin" class="stron">Nom utilisateur</label>
                             &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp  <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            <input type="text" minlength="4" name="modifierlogin" id="modifierlogin" class="form-control largeur100"/>
                        </div>

                        <div class="form-group largeur100">
                            <label for="modifierpwd1" class="stron">Mot de passe</label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp  <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp  <!--Pour espacement-->
                            <input type="password" minlength="3" name="modifierpwd1" id="modifierpwd1" class="form-control"/>                                                                                                                                                                                                                        
                        </div>
                        <div class="form-group largeur100">
                            <label for="modiferpwd2" class="stron">Retaper le mot de passe</label>
                            &nbsp   <!--Pour espacement-->
                            <input type="password" minlength="3" name="modiferpwd2" id="modiferpwd2" class="form-control"/>
                        </div>
                        <div class="form-group largeur100"> 
                            <label for="usernumberedit" class="stron">Téléphone</label> 
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp  <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement--> 
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp   <!--Pour espacement-->
                            <input type="text" name="usernumberedit" id="usernumberedit" class="form-control"/>
                        </div>
                        <div class="form-group largeur100"> 
                            <label for="userresosicioedit" class="stron">Réseau social</label> 
                                &nbsp  &nbsp <!--Pour espacement-->
                                &nbsp  &nbsp <!--Pour espacement-->
                                &nbsp  &nbsp  <!--Pour espacement-->
                                &nbsp  &nbsp <!--Pour espacement--> 
                                &nbsp  &nbsp <!--Pour espacement--> 
                                &nbsp   <!--Pour espacement--> 
                            <input type="text" name="userresosicioedit" id="userresosicioedit" class="form-control"/>
                        </div>
                        <div class="form-group largeur100"> 
                            <label for="useradresseedit" class="stron">Adresse</label> 
                                &nbsp  &nbsp <!--Pour espacement-->
                                &nbsp  &nbsp <!--Pour espacement-->
                                &nbsp  &nbsp  <!--Pour espacement-->
                                &nbsp  &nbsp <!--Pour espacement--> 
                                &nbsp  &nbsp <!--Pour espacement--> 
                                &nbsp  &nbsp <!--Pour espacement--> 
                                &nbsp  &nbsp <!--Pour espacement--> 
                                &nbsp   <!--Pour espacement-->                   
                            <input type="text" name="useradresseedit" id="useradresseedit" class="form-control"/>
                        </div>
                        <div class="form-group largeur100">
                            <label for="modiferemailemail" class="stron">Email</label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp  <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp  <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp   <!--Pour espacement-->
                            <input type="email" name="modiferemailemail" id="modiferemailemail" class="form-control"/>
                        </div>

                        <div class="form-group largeur100">
                            <label for="modifierrole" class="stron">Fonction</label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp  <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp  <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            <input type="text" minlength="4" name="modifierrole" id="modifierrole"  class="form-control"/> 
                        </div> 
                        
                        <div class="form-group">
                            <button type="button" class="btn btn-primary stron" id="modifieruser" name="modifieruser" value="Modifier" style="margin-top:10px;" onclick="document.getElementById('param').value='modifier';chargementutilisateurs();">
                                <i class="fas fa-save"></i> Modifier
                            </button>                               
                        </div>
                    </form>
                </div>    
            </div>           
        </div>
    </body>
</html>