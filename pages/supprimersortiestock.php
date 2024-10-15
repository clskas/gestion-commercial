<?php

session_start();
if(isset($_SESSION['user']))
{
    require_once('connexiondb.php');
    $idss=isset($_GET['idsortiestock'])?$_GET['idsortiestock']:0;

    $requete="DELETE FROM sortie_stock WHERE id_sortie=?";
    $params=array($idss);
    $resultat= $pdo->prepare($requete);
    $resultat->execute($params);

    header('location:sortiestock.php');
}
else
{
    header('location:login.php');
}

?>



