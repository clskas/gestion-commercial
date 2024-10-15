<?php 
    require_once('identifier.php');
    require_once('connexiondb.php');
   
    $idUser=isset($_POST['iduser'])?$_POST['iduser']:0;
    $logins=isset($_POST['login'])?$_POST['login']:"";
    $email=isset($_POST['email'])?strtoupper($_POST['email']):"";
    //$roles=isset($_POST['role'])?$_POST['role']:"";
   
    $requete="update utilisateur set logins=?,email=? where iduser=?";
    $params=array($logins,$email,$idUser);

    $resultat= $pdo->prepare($requete);
    $resultat->execute($params);

    header('location:login.php');
 ?>