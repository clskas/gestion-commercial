<?php
require_once('identifier.php');
require_once('connexiondb.php');


$fournisseur = isset($_POST['idFournisseur'])?$_POST['idFournisseur']:1;
$produit = isset($_POST['idproduit'])?$_POST['idproduit']:1;
$numerofacture = isset($_POST['numerofacture'])?$_POST['numerofacture']:"";
$qte = isset($_POST['quantiteentre'])?$_POST['quantiteentre']:0;
$puht = isset($_POST['puht'])?$_POST['puht']:0;
//$dateenre = isset($_POST['dateenre'])?$_POST['dateenre']:"";
$dateenre = date('Y/m/d');
$observation = isset($_POST['observation'])?$_POST['observation']:"";

$requete = "INSERT INTO entre_stock(id_fournisseur,id_article,numero_facture,quantite_entre,puht,date_entre,
    observation) VALUES (?,?,?,?,?,?,?)";
$params=array($fournisseur,$produit,$numerofacture,$qte,$puht,$dateenre,$observation);
$resultat= $pdo->prepare($requete);
$resultat->execute($params);

$requete = "SELECT * FROM articles WHERE Article_code = $produit";
$retours=$pdo->query($requete);
$retour =$retours->fetch();
if ($retour)
{
    $requete = "UPDATE articles SET Article_Qte = Article_Qte + $qte WHERE Article_code = $produit";
    //$requete = "UPDATE articles SET Article_Qte = Article_Qte + ".$_POST['qte_produit']." WHERE Article_code = '$idproduit'";
    $retours = $pdo->query($requete);
}
else
{
    $requeteP="SELECT * FROM produits WHERE ref_produit=$produit";
    $resultatP=$pdo->QUERY($requeteP);
    $retour = $resultatP->fetch();
    $designation=$retour["designation_produit"];
    $qtemin= $retour["qte_min"];

    $requete = "INSERT INTO articles(Article_code,Article_designation,Article_PUHT,Article_Qte,qtemin) VALUES (?,?,?,?,?)";
    $params=array($produit,$designation,$puht,$qte,$qtemin);
    $resultat= $pdo->prepare($requete);
    $resultat->execute($params);

    //$retours = mysqli_query($liaison2, $requete);
   /* if($retours==1)
        print("ok");
    else
        print("nok");*/
}

header('location:entrestock.php');
?>
