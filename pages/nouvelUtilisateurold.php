<?php
    require_once('connexiondb.php');
    require_once('../les_fonctions/fonctions.php');
    //echo  'Nombre des users 1 :'. rechercher_par_login('user1');
    //echo  'Nombre des user@gmail.com :'. rechercher_par_email('user1@gmail.com');

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $login=$_POST['login'];
        $pwd1=$_POST['pwd1'];
        $pwd2=$_POST['pwd2'];
        $email=$_POST['email'];
        $validationErrors=array();
        if(isset($login))
        {
            $filitredLogin=filter_var($login,FILTER_SANITIZE_STRING);
            if(strlen($login)<4)
            {
                $validationErrors[]="Error!!! le login doit contenir au moins 4 caractères";
            }
        }

        if(isset($pwd1) && isset($pwd2))
        {
          if(empty($pwd1))
           {
             $validationErrors[]="Error!!! le mot de passe ne doit pas être vide";
           }
           if(md5($pwd1)!==md5($pwd2))
           {
                $validationErrors[]="Erreur!!! les deux mots de passe ne sont pas identiques";
           }
        }

        if(isset($email))
        {
            $filitredEmail=filter_var($email,FILTER_SANITIZE_EMAIL);
            if($filitredEmail !=true)
            {
                $validationErrors[]="Erreur!!! Email non valide";
            }
        }

        if(empty($validationErrors))
        {
            if(rechercher_par_login($login)==0 && rechercher_par_email($email)==0)
            {
                $requete=$pdo->prepare("insert into utilisateur(logins,email,pwd,roles,etat)
                                        values(:plogin,:pemail,:ppwd,:proles,:petat)");
                $requete->execute(array('plogin'=>$login,
                                         'pemail'=>$email,
                                         'ppwd'=>md5($pwd1),
                                         'proles'=>'VISITEUR',
                                         'petat'=>0));
                $success_msg="Félicitation, votre compte est crée, mais temporairement
                                inactif jusqu'à son activation par l'administrateur";

            }
            else
            {
                 if(rechercher_par_login($login)>0)
                 {
                    $validationErrors[]="Désolé, ce login existe déjà";
                 }
                 if(rechercher_par_email($email)>0)
                 {
                   $validationErrors[]="Désolé, ce email existe déjà";
                 }
            }

        }

    }

?>

<! DOCTYPE HTML>
<html>
    <head>
         <meta charset="utf-8" />
         <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
         <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
         <title> Nouvel utilisateur </title>
    </head>
    <body>
        <div class="container col-lg-6 col-lg-offset-3">
            <h1 class="text-center"> Création d'un nouveau compte utilisateur</h1>
            <form class="form" method="POST" action="nouvelUtilisateurold.php">
                <div class="input-container">
                     <input type="text"
                                required
                                minlength="4"
                                title="Le login doit avoir au moins 4 caractères"
                                name="login"
                                placeholder="Taper votre nom utilisateur"
                                autocomplete="off"
                                class="form-control largeur100">
                </div>

                <div class="input-container">
                <input type="password"
                            required
                            minlength="3"
                            title="Le mot de passe doit avoir au moins 3 caractères"
                            name="pwd1"
                            placeholder="Taper votre mot de passe pour le confirmer"
                            autocomplete="old-password"
                            class="form-control">
                </div>
                 <div class="input-container">
                <input type="password"
                            required
                            minlength="3"
                            name="pwd2"
                            placeholder="Retaper votre mot de passe pour le confirmer"
                            autocomplete="new-password"
                            class="form-control">
                 </div>
                 <div class="input-container">
                <input type="email"
                            required
                            title="Le login doit avoir au moins 4 caractères"
                            name="email"
                            placeholder="Taper votre email"
                            autocomplete="off"
                            class="form-control">
                </div>

                <input type="submit" class="btn btn-primary" value="Enregistrer">
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
    </body>
</html>