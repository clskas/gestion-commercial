<?php
    //require_once('identifier.php');  
?>

<! DOCTYPE HTML>
<html>
    <head>
        <title> Nouvel utilisateur </title>
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
        <div class="container col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary margetop">
                <div class="panel-heading bg-primary text-white stron">
                    Création d'un nouveau compte utilisateur
                </div>
                <div class="panel-body">
                <form method="POST" id="editformuser" class="form">
                    <div class="form-group">
                        <input type="text"
                                required
                                minlength="4"
                                title="Le login doit avoir au moins 4 caractères"
                                name="login"
                                id="login"
                                placeholder="Taper votre nom utilisateur"
                                autocomplete="off"
                                class="form-control largeur100 stron"/>
                        <input type="text" id="param" name="param" style="visibility:hidden;" /> 

                    </div>

                    <div class="form-group">
                    <input type="password"
                            required
                            minlength="3"
                            title="Le mot de passe doit avoir au moins 3 caractères"
                            name="pwd1"
                            id="pwd1"
                            placeholder="Taper votre mot de passe"
                            autocomplete="old-password"
                            class="form-control stron"/>
                    </div>
                    <div class="form-group">
                    <input type="password"
                            required
                            minlength="3"
                            name="pwd2"
                            id="pwd2"
                            placeholder="Retaper votre mot de passe pour le confirmer"
                            autocomplete="new-password"
                            class="form-control stron"/>
                    </div>
                    <div class="form-group">
                    <input type="text" name="usernumber" id="usernumber"
                            placeholder="Veuillez saisir votre numéro de téléphone"
                            class="form-control stron"/>
                    </div>
                    <input type="text" name="userresosicio" id="userresosicio"
                            placeholder=" Entrer les coordonnées des reseaux sociaux"
                            class="form-control stron"/>
                    </div>
                    <div class="form-group">                   
                    <input type="email"
                            name="email"
                            id="email"
                            placeholder="Taper votre email"
                            autocomplete="off"
                            class="form-control stron"/>
                    </div>
                    <div class="form-group">                   
                    <input type="text" name="useradresse" id="useradresse"
                            placeholder="Veuillez saisir votre adresse"
                            class="form-control stron"/>
                    </div>
                    <div class="form-group">                   
                    <input type="text"
                            required
                            name="fonctionn"
                            id="fonctionn"
                            placeholder="Veuillez saisir la fonction de l'utilisateur"
                            class="form-control stron"/>               
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-primary stron" id="enregistreru" name="enregistreru" value="Enregistrer" style="margin-top:10px;" onclick="document.getElementById('param').value='inserer';chargementutilisateurs();">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>                               
                    </div>
                </form>
                <br>
                <?php
                    if(isset($validationErrors) && !empty($validationErrors)){
                        foreach($validationErrors as $error)
                        {
                            echo '<div class="alert alert-danger" >'.$error.'</div>';
                        }
                    }
                ?>
                </div>
            </div>      
        </div>
    </body>
</html>
