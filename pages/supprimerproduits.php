<?php

session_start();
if(isset($_SESSION['user']))
{
    require_once('connexiondb.php');
    $idp=isset($_GET['idp'])?$_GET['idp']:0;

    $requete="DELETE FROM produits WHERE ref_produit=?";
    $params=array($idp);
    $resultat= $pdo->prepare($requete);
    $resultat->execute($params);

    $requetea="DELETE FROM articles WHERE Article_code=?";
    $paramsa=array($idp);
    $resultata= $pdo->prepare($requetea);
    $resultata->execute($paramsa);

    header('location:produits.php');
}
else
{
    header('location:login.php');
}

?>
