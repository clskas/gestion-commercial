<?php
//header('Content-Type: application/json');
require_once('identifier.php');
require_once('connexiondb.php');

$sommedepensefranc="SELECT SUM(montant) AS montantdepense FROM depense WHERE monnaie='FC'";
$resultatsommedepensefranc = $pdo->query($sommedepensefranc);
$retoursommedepensefranc =$resultatsommedepensefranc->fetch();
$depensesommefranc=$retoursommedepensefranc["montantdepense"];

$sommedepenseendollar ="SELECT SUM(montant) AS montantdepense FROM depense WHERE monnaie='$'";
$resultatdepensedollar= $pdo->query($sommedepenseendollar);
$retourdepensedollar =$resultatdepensedollar->fetch();
$depensesommedollar = $retourdepensedollar["montantdepense"];

$requetesommepaie="SELECT SUM(montant_paye) AS montantpaye FROM paiement WHERE monnaie='FC'";
$resultatsommepaie= $pdo->query($requetesommepaie);
$retoursommepaie =$resultatsommepaie->fetch();
$montantpayeenfranc = $retoursommepaie["montantpaye"];

$requetesommepaiedollar="SELECT SUM(montant_paye) AS montantpaye FROM paiement WHERE monnaie='$'";
$resultatsommepaiedollar= $pdo->query($requetesommepaiedollar);
$retoursommepaiedollar =$resultatsommepaiedollar->fetch();
$montantpayedollar = $retoursommepaiedollar["montantpaye"];

$montantdispoenfranc = $montantpayeenfranc-$depensesommefranc;
$montantdispoendollar = $montantpayedollar-$depensesommedollar;

//Debut gestion de dette en franc 
$requetesumfc="SELECT SUM(montant_paye) AS montantpaye FROM paiement WHERE monnaie='FC'";  
$resultatsumfc = $pdo->query($requetesumfc);
$retoursumfc = $resultatsumfc->fetch();
$montantpayefc = $retoursumfc["montantpaye"];

$montantnonenecoreenfranc = "SELECT SUM(Com_montant) AS montant FROM commandes WHERE com_monnaie = 'FC'";
$resultatmontantnonencorepayeenfranc = $pdo->QUERY($montantnonenecoreenfranc);
$nonencorepayerenfranc = $resultatmontantnonencorepayeenfranc->fetch();
$sommenonencorepayerenfranc = $nonencorepayerenfranc['montant'];

$resteenfc = $sommenonencorepayerenfranc-$montantpayefc;
//Fin gestion de dette en franc

//Debut gestion dette en dollar
$requetemontantpayerend="SELECT SUM(montant_paye) AS montantpaye FROM paiement WHERE monnaie='$'";  
$resultatmontantpayeend = $pdo->query($requetemontantpayerend);
$retourmntpyend = $resultatmontantpayeend->fetch();
$montantpayeendollo = $retourmntpyend["montantpaye"];

$montantnonenecoreenendolo = "SELECT SUM(Com_montant) AS montant FROM commandes WHERE com_monnaie = '$' ";
$resultatmontantnonencorepayeendolo = $pdo->QUERY($montantnonenecoreenendolo);
$nonencorepayerendolo = $resultatmontantnonencorepayeendolo->fetch();
$sommenonencorepayerendolo = $nonencorepayerendolo['montant']; 

$resteendollar = $sommenonencorepayerendolo-$montantpayeendollo;
 
//Fin gestion dette en dollar

//Afficher le tableau au format JSON                          
echo json_encode(array("montatdispoenfranc"=>$montantdispoenfranc,
"montantdispoendollar"=>$montantdispoendollar,"detteendollar"=>$resteendollar,
"detteenfc"=>$resteenfc)); 

?>