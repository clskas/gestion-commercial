<?php
require_once('identifier.php');
require_once('connexiondb.php');

$idss=isset($_POST['idSS'])?$_POST['idSS']:0;
$produit = isset($_POST['idproduit'])?$_POST['idproduit']:1;
$qte = isset($_POST['quantitesortie'])?$_POST['quantitesortie']:0;
$datesortie = isset($_POST['datesortie'])?$_POST['datesortie']:"";
$observation = isset($_POST['observation'])?$_POST['observation']:"";


$requete="UPDATE sortie_stock SET id_article=?,quantite_sortie=?,date_sortie=?,observation=? WHERE id_sortie=?";
$params=array($produit,$qte,$datesortie,$observation,$idss);
$resultat= $pdo->prepare($requete);
$resultat->execute($params);
header('location:sortiestock.php');
?>


