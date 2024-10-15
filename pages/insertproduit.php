<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_POST["param"]))
{
    switch($_POST["param"])
    {
        case "inserer":
            $designation= isset($_POST['designation'])?$_POST['designation']:"";
            $qtemin = isset($_POST['qtemin'])?$_POST['qtemin']:0;
            $tva = isset($_POST['tva'])?$_POST['tva']:"";
            $marque = isset($_POST['marque'])?$_POST['marque']:"";

            $requete= "INSERT   INTO produits(designation_produit,qte_min,tva,marque) VALUES (?,?,?,?)";
            $params=array($designation,$qtemin,"0",$marque);
            $resultat= $pdo->prepare($requete);
            $resultat->execute($params);
            print("ok");
            break;

    }
}
//header('location:produits.php');
?>
