<?php
    session_start();
    if(isset($_SESSION['errorLogin']))
    {
        $erreurLogin=$_SESSION['errorLogin'];
    }
    else
    {
        $erreurLogin="";
    }
    session_destroy();   
?>

<! DOCTYPE HTML>
<HTML>
    <head>
        <title>Se connecter</title>
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
    <body>
        <div class="container col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
            <div class="panel panel-primary margetop60">
                <div class="panel-heading bg-primary">
                   Se connecter
                </div>
                <div class="panel-body">
                    <form action="seConnecter.php" method="post" class="form-inline">
                        <div class="form-group largeur100">
                            <?php if(!empty($erreurLogin)) { ?>
                                <div class="alert alert-danger">
                                    <?php echo $erreurLogin ?>
                                </div>
                            <?php } ?>
                            <div class="form-group largeur100">
                                <!--<label for="login">Login</label>-->
                                <input type="text" name="login" placeholder="Nom utilisateur" class="form-control"/>
                            </div>
                            <div class="form-group largeur100">
                                <!--<label for="pwd">Mot de passe</label>-->
                                <input type="password" name="pwd" placeholder="Entrer le mot de passe" class="form-control"/>
                            </div> 
                            <div class="form-group largeur100"> 
                                <button type="submit" class="btn btn-success margetop10">
                                    <span class="glyphicon glyphicon-log-in"></span>
                                    Se connecter
                                </button> 
                            </div>   
                                               
                            <div>
                                <ul class="nav navbar-nav largeur100">                               
                                    <li><a href="intialiserPwd.php">Mot de passe oublié</a></li>                   
                                    <li><a href="nouvelUtilisateur.php">Créer un compte</a></li>                             
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>    
            </div>
            </div>
    </body>
</HTML>