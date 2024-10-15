<?php
require_once('identifier.php');
require_once('connexiondb.php');
$utilisateur=$_SESSION['user']['roles'];
$numerofact= isset($_GET['numfacture'])?$_GET['numfacture']:0;
$datepaie= isset($_GET['datepaie'])?$_GET['datepaie']:"";
   if(isset($_GET["param"]))
    {
        switch($_GET["param"])
        {
            case "tous":                                  
                $selectionnertout="SELECT id_paiement,numerofacture,date_paiement,
                montant_a_paye,montant_paye,
                reste,monnaie,com_monnaie,CONCAT( Client_nom,' ', Client_prenom ) AS client,
                Com_client,Com_date,Com_montant FROM paiement AS p,clients AS cl,
                commandes AS c WHERE p.numerofacture=c.Com_num
                AND c.Com_client=cl.Client_num ORDER BY p.id_paiement DESC";
                $resultate=$pdo->query($selectionnertout);               
                $paiment = array();
                //Récupérer les lignes
                while($retour = $resultate->fetch()){
                    array_push($paiment,$retour);
                }                                                                                                                       
                $requetesumfc="SELECT SUM(montant_paye) AS montantpaye FROM paiement AS p,clients AS cl,
                commandes AS c WHERE p.numerofacture=c.Com_num
                AND c.Com_client=cl.Client_num AND p.monnaie='FC'";  
                $resultatsumfc = $pdo->query($requetesumfc);
                $retoursumfc = $resultatsumfc->fetch();
                $montantpayefc = $retoursumfc["montantpaye"];
                $montantapayerenfc = "SELECT SUM(Com_montant) AS montant FROM commandes WHERE               
                Com_num IN (SELECT DISTINCT numerofacture FROM paiement AS p,clients AS cl,
                commandes AS c WHERE p.numerofacture=c.Com_num
                AND c.Com_client=cl.Client_num AND p.monnaie='FC') ";
                $resultatmontantapayerenfc = $pdo->QUERY($montantapayerenfc);
                $apayerenfc = $resultatmontantapayerenfc->fetch();
                $sommeapayerenfc = $apayerenfc['montant']; 
                
                $resteenfc =  $sommeapayerenfc - $montantpayefc;  

                $requetesumdolar = "SELECT SUM(montant_paye) AS montantpaye FROM paiement AS p,clients AS cl,
                commandes AS c WHERE p.numerofacture=c.Com_num
                AND c.Com_client=cl.Client_num AND p.monnaie='$'";             
                $resultatsumdolar = $pdo->query($requetesumdolar);
                $retoursumdolar = $resultatsumdolar->fetch();
                $montantpayeendollar = $retoursumdolar["montantpaye"]; 

                $montantapayerendollar = "SELECT SUM(Com_montant) AS montant FROM commandes WHERE               
                Com_num IN (SELECT DISTINCT numerofacture FROM paiement AS p,clients AS cl,
                commandes AS c WHERE p.numerofacture=c.Com_num
                AND c.Com_client=cl.Client_num AND p.monnaie='$') ";
                $resultatmontantapayerendollar = $pdo->QUERY($montantapayerendollar);
                $apayerendollar = $resultatmontantapayerendollar->fetch();
                $sommeapayerendollar = $apayerendollar['montant']; 
                
                $resteendollar =  $sommeapayerendollar - $montantpayeendollar;   
                //Afficher le tableau au format JSON              
                echo json_encode(array("paie"=>($paiment),"montantenfc"=>$montantpayefc,
                "montantendollar"=>$montantpayeendollar,"resteendollar"=>$resteendollar,
                "resteenfranc"=>$resteenfc,"user"=>$utilisateur)); 
            break;
         
            case "pardate":             
                $selectionnertout="SELECT id_paiement,numerofacture,date_paiement,
                montant_a_paye,montant_paye,
                reste,monnaie,com_monnaie,CONCAT( Client_nom,' ', Client_prenom ) AS client,
                Com_client,Com_date,Com_montant FROM paiement AS p,clients AS cl,
                commandes AS c WHERE p.numerofacture=c.Com_num
                 AND c.Com_client=cl.Client_num AND p.date_paiement='$datepaie' ORDER BY p.id_paiement DESC";
                $resultate=$pdo->query($selectionnertout);
                $paiment = array();
                //Récupérer les lignes
               while($retour = $resultate->fetch())
               {
                  array_push($paiment,$retour);
               }                
                $requetepayeenfc="SELECT SUM(montant_paye) AS montantpaye  FROM paiement AS p,clients AS cl,
                commandes AS c WHERE p.numerofacture=c.Com_num
                 AND c.Com_client=cl.Client_num AND p.date_paiement='$datepaie' AND p.monnaie='FC'";
                $resultatpayerenfc= $pdo->query($requetepayeenfc);
                $retourpayerenfc =$resultatpayerenfc->fetch();
                $montantpayeenfranc=$retourpayerenfc["montantpaye"];
                $montantapayerenfc = "SELECT SUM(Com_montant) AS montant FROM commandes WHERE               
                Com_num IN (SELECT DISTINCT numerofacture FROM paiement AS p,clients AS cl,
                commandes AS c WHERE p.numerofacture=c.Com_num
                AND c.Com_client=cl.Client_num AND p.date_paiement = '$datepaie' AND p.monnaie='FC') ";
                $resultatmontantapayerenfc = $pdo->QUERY($montantapayerenfc);
                $apayerenfc = $resultatmontantapayerenfc->fetch();
                $sommeapayerenfc = $apayerenfc['montant'];                 
                $resteenfc =  $sommeapayerenfc - $montantpayeenfranc;  
                $requetesum="SELECT SUM(montant_paye) AS montantpaye  FROM paiement AS p,clients AS cl,
                commandes AS c WHERE p.numerofacture=c.Com_num
                 AND c.Com_client=cl.Client_num AND p.date_paiement='$datepaie' AND p.monnaie='$'";
                $resultatsum= $pdo->query($requetesum);
                $retoursum =$resultatsum->fetch();
                $montantpayeendollar=$retoursum["montantpaye"];             
                $montantapayerendollar = "SELECT SUM(Com_montant) AS montant FROM commandes WHERE               
                Com_num IN (SELECT DISTINCT numerofacture FROM paiement AS p,clients AS cl,
                commandes AS c WHERE p.numerofacture=c.Com_num
                AND c.Com_client=cl.Client_num AND p.date_paiement = '$datepaie' AND p.monnaie='$') ";
                $resultatmontantapayerendollar = $pdo->QUERY($montantapayerendollar);
                $apayerendollar = $resultatmontantapayerendollar->fetch();
                $sommeapayerendollar = $apayerendollar['montant'];                
                $resteendollar =  $sommeapayerendollar - $montantpayeendollar;  
                //Afficher le tableau au format JSON              
                echo json_encode(array("paie"=>($paiment),"montantenfc"=>$montantpayeenfranc,
                "montantendollar"=>$montantpayeendollar,"resteendollar"=>$resteendollar,
                "resteenfranc"=>$resteenfc,"user"=>$utilisateur));                                              
        break;
       
        case "parfacture":         
            $selectionnertout="SELECT id_paiement,numerofacture,date_paiement,
            montant_a_paye,montant_paye,
            reste,monnaie,com_monnaie,CONCAT( Client_nom,' ', Client_prenom ) AS client,
            Com_client,Com_date,Com_montant FROM paiement AS p,clients AS cl,
            commandes AS c WHERE p.numerofacture=c.Com_num
            AND c.Com_client=cl.Client_num AND p.numerofacture=$numerofact ORDER BY p.id_paiement DESC";
            $resultate=$pdo->query($selectionnertout);          
            $paiment = array();
            //Récupérer les lignes
           while($retour = $resultate->fetch())
           {
              array_push($paiment,$retour);
           }            
            $requetesumfc="SELECT SUM(montant_paye) AS montantpaye FROM paiement AS p,clients AS cl,
            commandes AS c WHERE p.numerofacture=c.Com_num
            AND c.Com_client=cl.Client_num AND p.numerofacture=$numerofact AND
            p.monnaie='FC'";
            $resultatsumfc= $pdo->query($requetesumfc);
            $retoursumfc =$resultatsumfc->fetch();
            $montantpayefc=$retoursumfc["montantpaye"];
            $montantapayerenfc = "SELECT SUM(Com_montant) AS montant FROM commandes WHERE               
            Com_num IN (SELECT DISTINCT numerofacture FROM paiement AS p,clients AS cl,
            commandes AS c WHERE p.numerofacture=c.Com_num
            AND c.Com_client=cl.Client_num AND p.numerofacture=$numerofact AND p.monnaie='FC') ";
            $resultatmontantapayerenfc = $pdo->QUERY($montantapayerenfc);
            $apayerenfc = $resultatmontantapayerenfc->fetch();
            $sommeapayerenfc = $apayerenfc['montant'];             
            $resteenfc =  $sommeapayerenfc - $montantpayefc;  
            $requetesumdolar="SELECT SUM(montant_paye) AS montantpaye FROM paiement AS p,clients AS cl,
            commandes AS c WHERE p.numerofacture=c.Com_num
            AND c.Com_client=cl.Client_num AND p.numerofacture=$numerofact AND
            p.monnaie='$'";
            $resultatsumdolar= $pdo->query($requetesumdolar);
            $retoursumdolar =$resultatsumdolar->fetch();
            $montantpayeendollar=$retoursumdolar["montantpaye"];
            $montantapayerendollar = "SELECT SUM(Com_montant) AS montant FROM commandes WHERE               
            Com_num IN (SELECT DISTINCT numerofacture FROM paiement AS p,clients AS cl,
            commandes AS c WHERE p.numerofacture=c.Com_num
            AND c.Com_client=cl.Client_num AND p.numerofacture=$numerofact AND p.monnaie='$') ";
            $resultatmontantapayerendollar = $pdo->QUERY($montantapayerendollar);
            $apayerendollar = $resultatmontantapayerendollar->fetch();
            $sommeapayerendollar = $apayerendollar['montant'];             
            $resteendollar =  $sommeapayerendollar - $montantpayeendollar;            
            //Afficher le tableau au format JSON              
            echo json_encode(array("paie"=>($paiment),"montantenfc"=>$montantpayefc,
            "montantendollar"=>$montantpayeendollar,"resteendollar"=>$resteendollar,
            "resteenfranc"=>$resteenfc,"user"=>$utilisateur));               
             break;
            case "suppression":               
                $idpaiement=isset($_GET['idpaiement'])?$_GET['idpaiement']:0;
                $requete="DELETE FROM paiement WHERE id_paiement=?";
                $params=array($idpaiement);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);            
            break;
         
            case "inserer":
                $lasommed = isset($_GET['lasommede'])?$_GET['lasommede']:"";
                $facture = isset($_GET['numerofacture'])?$_GET['numerofacture']:1;
                $datepaie = date('Y/m/d');      
                $requete = "SELECT * FROM commandes WHERE Com_num = $facture";
                $retours=$pdo->query($requete);
                $retour =$retours->fetch();
                $montantapaye=$retour["Com_montant"];
                $montantpaye = isset($_GET['montant_paye'])?$_GET['montant_paye']:0;
                $montantreste = isset($_GET['montantreste'])?$_GET['montantreste']:0;
                $monnaie = isset($_GET['monnaie'])?$_GET['monnaie']:"";
                $requetefac = "SELECT SUM(montant_paye) AS montantp FROM paiement WHERE numerofacture = $facture";
                $retourfac=$pdo->query($requetefac);
                $retourf =$retourfac->fetch();
                $montantpaiyeprecedemment = $retourf['montantp'];  
                if($montantpaye > $montantreste)
                {
                    echo 'Le montant payé doit être inférieur ou égal au reste,
                    veuillez revoir le montant payé';
                }
                else
                {
                    if($montantpaiyeprecedemment > 0)
                    {
                        $reste = number_format($montantapaye-($montantpaiyeprecedemment+$montantpaye),6,'.','');                      
                        $requete = "INSERT INTO paiement(numerofacture,date_paiement,montant_a_paye,montant_paye,reste,monnaie,sommede) VALUES (?,?,?,?,?,?,?)";
                        $params=array($facture,$datepaie,$montantapaye,$montantpaye,$reste,$monnaie,$lasommed);
                        $resultat = $pdo->prepare($requete);
                        $resultat->execute($params);
                        if($resultat)
                        {
                            $numpaiment = $pdo->lastInsertId();
                            $selectionfacture = "SELECT * FROM paiement WHERE id_paiement= $numpaiment";
                            $resultatfac = $pdo->QUERY($selectionfacture);
                            $dernierefacture = $resultatfac->fetch();
                            $lastfacture = $dernierefacture['numerofacture']; 

                            $selectionclient = "SELECT * FROM clients WHERE               
                            Client_num IN (SELECT Com_client FROM commandes WHERE Com_num=$lastfacture) ";
                            $resultatclient = $pdo->QUERY($selectionclient);
                            $clien = $resultatclient->fetch();
                            $numero_client = $clien['Client_num']; 
                        }
                        else
                        print("nok");
                    }
                    else
                    {
                        $reste = $montantapaye-$montantpaye;
                        $requete = "INSERT INTO paiement(numerofacture,date_paiement,montant_a_paye,montant_paye,reste,monnaie,sommede) VALUES (?,?,?,?,?,?,?)";
                        $params=array($facture,$datepaie,$montantapaye,$montantpaye,$reste,$monnaie,$lasommed);
                        $resultat = $pdo->prepare($requete);
                        $resultat->execute($params);
                        if($resultat)
                        {
                            $numpaiment = $pdo->lastInsertId();
                            $selectionfacture = "SELECT * FROM paiement WHERE id_paiement= $numpaiment";
                            $resultatfac = $pdo->QUERY($selectionfacture);
                            $dernierefacture = $resultatfac->fetch();
                            $lastfacture = $dernierefacture['numerofacture']; 
                            $lastsommede = $dernierefacture['sommede']; 

                            $selectionclient = "SELECT * FROM clients WHERE               
                            Client_num IN (SELECT Com_client FROM commandes WHERE Com_num=$lastfacture)";
                            $resultatclient = $pdo->QUERY($selectionclient);
                            $clien = $resultatclient->fetch();
                            $numero_client = $clien['Client_num']; 
                        }
                        else
                        print("nok");
                    }
                }
                echo json_encode(array("lasommed"=>$lastsommede,"clientnum"=>$numero_client,"numerorecu"=>$numpaiment,"numerocommande"=>$lastfacture)); 
                //print("nok");
            break; 

            case "modifier":
                $idpaiement=isset($_GET['idpaiem'])?$_GET['idpaiem']:0;
                $numerofact= isset($_GET['numerofacture'])?$_GET['numerofacture']:1;
                $datepaie= isset($_GET['datepaie'])?$_GET['datepaie']:"";
                $requete = "SELECT * FROM commandes WHERE Com_num = $numerofact";
                $retours=$pdo->query($requete);
                $retour =$retours->fetch();
                $montantapaye=$retour["Com_montant"];
                $montantpaye=isset($_GET['montant_paye'])?$_GET['montant_paye']:0;
              
                $reste = 0;
                            
                $monnaie = isset($_GET['monnaie'])?$_GET['monnaie']:"";
                $requete="UPDATE paiement SET numerofacture=?,date_paiement=?,montant_a_paye=?,montant_paye=?,reste=?,monnaie=? WHERE id_paiement=?";
                $params=array($numerofact,$datepaie,$montantapaye,$montantpaye,$reste,$monnaie,$idpaiement);
                $resultatm= $pdo->prepare($requete);
                $resultatm->execute($params);

                if($resultatm)
                {
                    $selectionidpaiementparfacture = "SELECT * FROM paiement WHERE numerofacture = $numerofact";
                    $resultattouslesidpaiement = $pdo->query($selectionidpaiementparfacture);                   
                    while($idpaie = $resultattouslesidpaiement->fetch()){
                        $idpaieprecedemment = $idpaie["id_paiement"];
                        $sommepayeprecedemment = "SELECT SUM(montant_paye) AS montantp 
                        FROM paiement WHERE numerofacture = $numerofact AND id_paiement<=$idpaieprecedemment";
                        $resultatsommepayeprecedemment = $pdo->query($sommepayeprecedemment);
                        $retoursommepayeprecedemment = $resultatsommepayeprecedemment->fetch();
                        $montantpaiyeprecedemment = $retoursommepayeprecedemment['montantp'];                       
                        $resteupdate = number_format($montantapaye-$montantpaiyeprecedemment,6,'.','');                       
                        $updatereste = "UPDATE paiement SET reste=? WHERE id_paiement=?";
                        $paramss = array($resteupdate,$idpaieprecedemment);
                        $resultatreste = $pdo->prepare($updatereste);
                        $resultatreste->execute($paramss);

                    }
                }                            
            break;

            case "chargerchampmodifier":
                $idpaiement=isset($_GET['idpaiement'])?$_GET['idpaiement']:0;
                $requetepaiement="SELECT * FROM paiement WHERE id_paiement=$idpaiement";
                $resultatpaiement=$pdo->query($requetepaiement);
                $paiement=$resultatpaiement->fetch();
                $numerofacture=$paiement['numerofacture'];
                $datepaiement=$paiement['date_paiement'];
                $montantapayer=$paiement['montant_a_paye'];
                $montantpaye=$paiement['montant_paye'];
                $reste=$paiement['reste'];
                $monnaie=$paiement['monnaie'];

                $requetecomm="SELECT * FROM commandes";
                $resultatcomm=$pdo->QUERY($requetecomm);

                $commandes = array();
                //Récupérer les lignes
                while($retour = $resultatcomm->fetch()){
                    array_push($commandes,$retour);
                }
      
                echo json_encode(array("commandes"=>($commandes),"numerofacture"=>$numerofacture,
                "datepaiement"=>$datepaiement,
                "montantapayer"=>$montantapayer,"montantpaye"=>$montantpaye,"reste"=>$reste,
                "monnaie"=>$monnaie));                    
                break; 
            case "recup_commande":
                $facture=isset($_GET['numerofacture'])?$_GET['numerofacture']:"";             
                $requete = "SELECT * FROM commandes WHERE Com_num = $facture";
                $retours= $pdo->query($requete);
                $retour = $retours->fetch();
                $factur = $retour["Com_montant"];              
                $requetereste = "SELECT numerofacture FROM paiement 
                WHERE numerofacture IN (SELECT numerofacture FROM paiement 
                WHERE numerofacture = $facture)";
                $resultatreste = $pdo->query($requetereste);
                $retour = $resultatreste->fetch();
                $facturepaiement = $retour["numerofacture"];
               if($facturepaiement)
                {
                    $sommepayer="SELECT monnaie,SUM(montant_paye) AS montantpaye FROM paiement WHERE numerofacture=$facture";  
                    $resultatsommepayer = $pdo->query($sommepayer);
                    $retoursommepayer = $resultatsommepayer->fetch();
                    $sommepayer = $retoursommepayer["montantpaye"];
                    $monaie = $retoursommepayer['monnaie']; 

                    $montantapayer = "SELECT * FROM commandes WHERE Com_num 
                    IN (SELECT numerofacture FROM paiement WHERE numerofacture=$facture)";
                    $resultatmontantapayer= $pdo->QUERY($montantapayer);
                    $apayer = $resultatmontantapayer->fetch();
                    $commmontant = $apayer['Com_montant'];                   
                    $reste =  $commmontant - $sommepayer;              
                }
                else
                {
                    $nouveaupaiement = "SELECT * FROM commandes WHERE Com_num = $facture";
                    $retoursnouveau= $pdo->query($nouveaupaiement);
                    $retourn = $retoursnouveau->fetch();
                    $reste = $retourn["Com_montant"]; 
                    $monaie = $retourn["com_monnaie"];
                }
                                                      
                echo json_encode(array("commandes"=>$factur,"monaie"=>$monaie,"reste"=>$reste)); 
            break;
            
            case "charger_facture":                      
                $requetechargerfacture = "SELECT * FROM commandes ORDER BY Com_num DESC";
                $resultatchargerfacture=$pdo->query($requetechargerfacture);
                $touteslesfactures = array();
                
                //Récupérer les lignes
                while($retour = $resultatchargerfacture->fetch()){
                    array_push($touteslesfactures,$retour);              
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("lesfactures"=>($touteslesfactures)));
            break; 
            
      }      
    }

?>