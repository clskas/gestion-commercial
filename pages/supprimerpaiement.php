<?php

session_start();
if(isset($_SESSION['user']))
{
    require_once('connexiondb.php');
    $idpaiement=isset($_GET['idpaiement'])?$_GET['idpaiement']:0;
    $requete="DELETE FROM paiement WHERE id_paiement=?";
    $params=array($idpaiement);
    $resultat= $pdo->prepare($requete);
    $resultat->execute($params);
    header('location:paiement.php');
}
else
{
    header('location:login.php');
}

?>




