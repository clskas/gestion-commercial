<?php
require_once('identifier.php');
require_once('connexiondb.php');
if(isset($_POST["param"]))
{
    switch($_POST["param"])
    {
        case "recup_commande":
            $facture=$_POST['numerofacture'];
            $requete = "SELECT * FROM commandes WHERE Com_num = $facture";
            $retours=$pdo->query($requete);
            $retour =$retours->fetch();
            $chaine = $retour["Com_num"]."|".$retour["Com_client"]."|".$retour["Com_date"]."|".$retour["Com_montant"];
            print($chaine);
            break;
        case "modifier":
            $idpaiement=isset($_POST['idpaiem'])?$_POST['idpaiem']:0;
            $numerofact= isset($_POST['numerofacture'])?$_POST['numerofacture']:1;
            $datepaie= isset($_POST['datepaie'])?$_POST['datepaie']:"";
            $requete = "SELECT * FROM commandes WHERE Com_num = $numerofact";
            $retours=$pdo->query($requete);
            $retour =$retours->fetch();
            $montantapaye=$retour["Com_montant"];
            $montantpaye=isset($_POST['montant_paye'])?$_POST['montant_paye']:0;
            $reste = $montantapaye-$montantpaye;

            $requete="UPDATE paiement SET numerofacture=?,date_paiement=?,montant_a_paye=?,montant_paye=?,reste=? WHERE id_paiement=?";
            $params=array($numerofact,$datepaie,$montantapaye,$montantpaye,$reste,$idpaiement);
            $resultat= $pdo->prepare($requete);
            $resultat->execute($params);
            //header('location:paiement.php');
            print("nok");

            break;
    }
}
?>



