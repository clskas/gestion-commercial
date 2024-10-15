<?php 
    session_start(); 
    require_once("connexiondb.php");
    $login=isset($_POST['login'])?$_POST['login']:"";
    $pwd=isset($_POST['pwd'])?$_POST['pwd']:"";

    $requete="select iduser,logins,email,roles,etat
                        from utilisateur where logins='$login'
                        and pwd='$pwd'";
    $resultat=$pdo->query($requete);

    if($user=$resultat->fetch())
    {
        if($user['etat']==1)
        {
            $_SESSION['user']=$user;
            header('location:../index.php');
        }
        else
        {
            $_SESSION['errorLogin']="<strong>Erreur!!</strong> Votre compte est desactivé.<br> Veuillez contacter l'administrateur";
            header('location:login.php');
        }
    }
    else
    {
        $_SESSION['errorLogin']="<strong>Erreur!!</strong> Login ou mot de passe incorrect!!!";
        header('location:login.php');
    }
 ?>