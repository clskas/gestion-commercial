<?php 
   require_once('identifier.php'); 
   /* 
    require_once('connexiondb.php');
    $id=isset($_GET['id'])?$_GET['id']:0;
    $requete="select * from utilisateur where iduser=$id";
    $resultat=$pdo->query($requete);
    $utilisateur=$resultat->fetch();
    $login=$utilisateur['logins'];  
    $email=$utilisateur['email'];*/
    
 ?>

<! DOCTYPE HTML>
<html>
    <head>
        <title>Editer d'un utilisateur</title>
        <meta charset="utf-8" > 
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
       
        <div class="container editpwdpage">
            
            <h1 class="text-center">Changement de mot de passe</h1>
            <h2 class="text-center">Compte :&nbsp<?php echo $_SESSION['user']['logins']; ?> </h2>
                
            <form action="updatePwd.php" method="post" class="form-horizontal">
                        
                <!--<label for="id">Id utilisateur</label>-->
                <div class="input-container">
                    <input minlength=4 type="password" name="oldpwd" autocomplete="false" placeholder="Tapez votre Ancien mot de passe" class="form-control oldpwd" required/>
                    <i class="fa fa-eye fa-2x show-old-pwd clickale"></i>
                    
                </div>
                <div class="input-container">
                    <input minlength=4 type="password" name="newpwd" autocomplete="false" placeholder="Tapez votre Nouveau mot de passe" class="form-control newpwd" required/>
                    <i class="fa fa-eye fa-2x show-new-pwd clickale"></i>
                </div>
                <input type="submit" class="btn btn-primary largeur100" value="Enregistrer">
                     
            </form>
        </div>
    </body>
</html>