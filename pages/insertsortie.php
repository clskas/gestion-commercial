<?php
require_once('identifier.php');
require_once('connexiondb.php');

$produit = isset($_POST['idproduit'])?$_POST['idproduit']:1;
$qte = isset($_POST['quantitesortie'])?$_POST['quantitesortie']:0;
$datesortie = isset($_POST['datesortie'])?$_POST['datesortie']:"";
$observation = isset($_POST['observation'])?$_POST['observation']:"";

$requete = "INSERT INTO sortie_stock(id_article,quantite_sortie,date_sortie,observation) VALUES (?,?,?,?)";
$params=array($produit,$qte,$datesortie,$observation);
$resultat= $pdo->prepare($requete);
$resultat->execute($params);
header('location:sortiestock.php');
?>

