<?php
    require_once('identifier.php');
?>
<! DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Nouveau client</title>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    </head>
    <body>
        <?php include("menu.php"); ?>

        <div class="container">
            

            <div class="panel panel-primary margetop60">
                <div class="panel-heading">
                   Veuillez saisir les données du nouveau client
                </div>
                <div class="panel-body">
                    <form action="insertclient.php" method="post" class="form-inline">
                        <div class="form-group largeur100">
                            <label for="civilite">Civilité</label>
                            <select name="civilite" class="form-control" id="civilite">
                                <option value="Monsieur" selected> Monsieur </option>
                                <option value="Madame"> Madame </option>
                                <option value="Mademoiselle" >Mademoiselle</option>
                            </select>
                        </div>

                        <div class="form-group largeur100">
                            <label for="nom">Nom</label>
                            <input type="text" name="nom" placeholder="Nom client" class="form-control"/>
                        </div>

                        <div class="form-group largeur100">
                            <label for="prenom">Prenom</label>
                            <input type="text" name="prenom" placeholder="Prenom du client" class="form-control"/>
                        </div>

                        <div class="form-group largeur100">
                            <label for="telephone">Numéro téléphone</label>
                            <input type="telephone" name="telephone" placeholder="Numéro de téléphone du client" class="form-control"/>
                        </div>

                        <div class="form-group largeur100">
                            <label for="email">Email</label>
                            <input type="email" name="email" placeholder="Email du client" class="form-control"/>
                        </div>

                        <div class="form-group largeur100">
                            <label for="reseausocial">Réseaux sociaux</label>
                            <input type="text" name="reseausocial" placeholder="Réseaux sociaux" class="form-control"/>
                        </div>

                        <div class="form-group largeur100">
                            <label for="adresse">Adresse du client</label>
                            <input type="text" name="adresse" placeholder="Adresse du client" class="form-control"/>
                        </div>

                        <button type="submit" class="btn btn-success margetop20">
                            <span class="glyphicon glyphicon-save"></span>
                             Enregistrer
                        </button>    
                        
                    </form>
                </div>    
            </div>
            
        </div>
    </body>
</html>