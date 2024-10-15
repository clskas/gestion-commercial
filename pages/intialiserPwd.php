<?php
    require_once('connexiondb.php');
    require_once('../les_fonctions/fonctions.php');

    if(isset($_POST['email']))
    {
        $email=$_POST['email'];
    }
    else
    {
        $email="";
    }

    $user=rechercher_user_par_email($email);
    if($user!=null)
    {
         $id=$user['iduser'];
         $requete=$pdo->prepare("update utilisateur set pwd=MD5('0000') where iduser=$id");
         $requete->execute();

         $to=$email;
         $objet="initialisation de mot de passe";
         $content="Votre nouveau mot de passe est 0000, veuillez le modifier à la prochaine ouverture de session";
         $entetes="From : Application Gestion stagiaire". "\r\n". "cc: gestionstage2018@gmail.com";

         mail($to,$object,$content,$entetes);
    }

    else
    {
         echo 'Email incorrect';
    }


?>

<! DOCTYPE HTML>
<html>
    <head>
         <meta charset="utf-8" />
         <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
         <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
         <title>Initialiser votre mot de passe </title>
    </head>
    <body>
        <div class="container col-lg-6 col-lg-offset-3 margetop20">
            <div class="panel panel-primary">
                 <div class="panel-heading">
                    Initialiser votre mot de passe
                 </div>
                <div class="panel-body">
                    <form class="form" method="POST" action="intialiserPwd.php">
                        <div class="form-group">
                            <label class="control-label">
                                Veuillez saisir votre email de recupération
                            </label>
                            <input class="control-form largeur100" name="email" type="text">
                             <button type="submit" class="btn btn-success margetop20">
                                Initialiser le mot de passe
                             </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </body>
</html>