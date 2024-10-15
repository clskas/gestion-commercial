<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_POST["param"]))
{
    switch($_POST["param"])
    {
        case "modifier":
            $idp=isset($_POST['idp'])?$_POST['idp']:0;
            $designation= isset($_POST['designation'])?$_POST['designation']:"";
            $qtemin = isset($_POST['qtemin'])?$_POST['qtemin']:0;
            $tva = isset($_POST['tva'])?$_POST['tva']:"";
            $marque = isset($_POST['marque'])?$_POST['marque']:"";

            $requete="UPDATE produits SET designation_produit=?,qte_min=?,tva=?,marque=? WHERE ref_produit=?";
            $params=array($designation,$qtemin,$tva,$marque,$idp);
            $resultat= $pdo->prepare($requete);
            $resultat->execute($params);
            if($resultat)
            {
                $requete="UPDATE articles SET qtemin=? WHERE Article_code=?";
                $params=array($qtemin,$idp);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
            }
            print("ok");
            break;
    }
}
//header('location:fournisseurs.php');
?>

