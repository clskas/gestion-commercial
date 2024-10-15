<?php
require_once('identifier.php');
require_once('connexiondb.php');
if(isset($_POST["param"]))
{
    switch($_POST["param"])
    {
        case "recup_commande":
            $facture=$_POST['numerofacture'];
            $requete = "SELECT * FROM commandes WHERE Com_num = $facture ORDER BY Com_num ";
            $retours=$pdo->query($requete);
            $retour =$retours->fetch();
            $chaine = $retour["Com_num"]."|".$retour["Com_client"]."|".$retour["Com_date"]."|".$retour["Com_montant"];
            print($chaine);
            break;
        case "inserer":
            //$commande=isset($_POST['numerocommande'])?$_POST['numerocommande']:1;
            $facture = isset($_POST['numerofacture'])?$_POST['numerofacture']:1;
            $datepaie = date('Y/m/d');;
            
            $requete = "SELECT * FROM commandes WHERE Com_num = $facture";
            $retours=$pdo->query($requete);
            $retour =$retours->fetch();
            $montantapaye=$retour["Com_montant"];
            $montantpaye = isset($_POST['montant_paye'])?$_POST['montant_paye']:0;
            $requetefac = "SELECT SUM(montant_paye) AS montantp FROM paiement WHERE numerofacture = $facture";
            $retourfac=$pdo->query($requetefac);
            $retourf =$retourfac->fetch();
            $montantpaiyeprecedemment=$retourf['montantp'];

            if($_POST['monnaie']=='franccongolais')
            {
                $monnaie = 'FC';
            }
            elseif($_POST['monnaie']=='dolar')
            {
                $monnaie = '$';
            }

            if($montantpaye > $montantapaye)
            {
                echo 'Le montant payé doit être inférieur au montant à payer,
                 veuillez revoir le montant payé';
            }
            else
            {
                if($montantpaiyeprecedemment > 0)
                {
                    //number_format($montantapaye,2,'.',' ')-number_format($montantpaye,2,'.',' ')                $totalpaye=number_format($montantpaiyeprecedemment,2,'.',' ')+number_format($montantpaye,2,'.',' ');
                    $reste =number_format($montantapaye-($montantpaiyeprecedemment+$montantpaye),6,'.','');
                    
                    $requete = "INSERT INTO paiement(numerofacture,date_paiement,montant_a_paye,montant_paye,reste,monnaie) VALUES (?,?,?,?,?,?)";
                    $params=array($facture,$datepaie,$montantapaye,$montantpaye,$reste,$monnaie);
                    $resultat = $pdo->prepare($requete);
                    $resultat->execute($params);
                }
                else
                {
                    $reste = $montantapaye-$montantpaye;
                    $requete = "INSERT INTO paiement(numerofacture,date_paiement,montant_a_paye,montant_paye,reste,monnaie) VALUES (?,?,?,?,?,?)";
                    $params=array($facture,$datepaie,$montantapaye,$montantpaye,$reste,$monnaie);
                    $resultat = $pdo->prepare($requete);
                    $resultat->execute($params);
                }
            }

           
           
            //header('location:paiement.php');
            print("nok");
            break;

    }
}

?>

