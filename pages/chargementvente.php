<?php
require_once('identifier.php');
require_once('connexiondb.php');
$utilisateur=$_SESSION['user']['roles'];
$idproduit= isset($_GET['designation'])?$_GET['designation']:"";
$nomprenom= isset($_GET['client'])?$_GET['client']:1;
$dateentre= isset($_GET['pdate'])?$_GET['pdate']:"";
$datedebut= isset($_GET['datedebut'])?$_GET['datedebut']:"";
$datefin= isset($_GET['datefin'])?$_GET['datefin']:"";

   if(isset($_GET["param"]))
    {
        switch($_GET["param"])
        {
            case "tous":
                $selectionnertout="SELECT Detail_num,Detail_com,com_monnaie,Detail_ref,Detail_qte,puht,
                Article_designation,CONCAT( Client_nom,' ', Client_prenom ) AS client,
                Com_client,Com_date,Com_montant,unitevent FROM detail AS det,clients AS cl,articles AS a,
                commandes AS c WHERE det.Detail_ref=a.Article_code AND det.Detail_com=c.Com_num
                 AND c.Com_client=cl.Client_num ORDER BY Detail_com DESC";
                $resultate = $pdo->query($selectionnertout);

                $montantvenduendollar="SELECT SUM(Detail_qte*puht) AS montantvenduendollar FROM detail AS det,clients AS cl,
                articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
                 AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='$'";
                $resultatemontantvenduendolar = $pdo->query($montantvenduendollar);
                $retourvenduendollar = $resultatemontantvenduendolar->fetch();
                $montanttotalvenduendollar = $retourvenduendollar["montantvenduendollar"];

                $montantvenduenfc="SELECT SUM(Detail_qte*puht) AS montantvenduenfc FROM detail AS det,clients AS cl,
                articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
                 AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='FC'";
                $resultatemontantvenduenfc = $pdo->query($montantvenduenfc);
                $retourvenduenfc = $resultatemontantvenduenfc->fetch();
                $montanttotalvenduenfc = $retourvenduenfc["montantvenduenfc"];

                $vente = array();
                 //Récupérer les lignes SUM(puht)
                while($retour = $resultate->fetch()){
                   array_push($vente,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("historiquevente"=>($vente),"montantvenduendollar"=>$montanttotalvenduendollar,
                "montantvenduenfc"=>$montanttotalvenduenfc,"user"=>$utilisateur));             
          
                break;
            case "pardate":
                $selectionnertout="SELECT Detail_num,Detail_com,com_monnaie,Detail_ref,Detail_qte,puht,Article_designation,
                CONCAT( Client_nom,' ', Client_prenom ) AS client,Com_client,Com_date,Com_montant,unitevent 
                FROM detail AS det,clients AS cl,articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code 
                AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.Com_date = '$dateentre'
                ORDER BY Detail_com DESC ";
                $resultate=$pdo->query($selectionnertout);
                
                $montantvenduendollar="SELECT SUM(Detail_qte*puht) AS montantvenduendollar FROM detail AS det,clients AS cl,
                articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
                 AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='$'
                 AND c.Com_date = '$dateentre'";
                $resultatemontantvenduendolar = $pdo->query($montantvenduendollar);
                $retourvenduendollar = $resultatemontantvenduendolar->fetch();
                $montanttotalvenduendollar = $retourvenduendollar["montantvenduendollar"];

                $montantvenduenfc="SELECT SUM(Detail_qte*puht) AS montantvenduenfc FROM detail AS det,clients AS cl,
                articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
                 AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='FC'
                 AND c.Com_date = '$dateentre'";
                $resultatemontantvenduenfc = $pdo->query($montantvenduenfc);
                $retourvenduenfc = $resultatemontantvenduenfc->fetch();
                $montanttotalvenduenfc = $retourvenduenfc["montantvenduenfc"];

                 $vente = array();
                 //Récupérer les lignes
                while($retour = $resultate->fetch()){
                   array_push($vente,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("historiquevente"=>($vente),"montantvenduendollar"=>$montanttotalvenduendollar,
                "montantvenduenfc"=>$montanttotalvenduenfc,"user"=>$utilisateur));  
                break;
        case "datedebut":
            if(isset($_GET['datefin']))
            {
                $selectionnerparperiode="SELECT Detail_num,Detail_com,com_monnaie,Detail_ref,Detail_qte,puht,Article_designation,
                CONCAT( Client_nom,' ', Client_prenom ) AS client,Com_client,Com_date,Com_montant,unitevent 
                FROM detail AS det,clients AS cl,articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code 
                AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND 
                (c.Com_date BETWEEN '$datedebut' AND '$datefin') ORDER BY Detail_com DESC";
                $resultate=$pdo->query($selectionnerparperiode);
                
                $montantvenduendollar="SELECT SUM(Detail_qte*puht) AS montantvenduendollar FROM detail AS det,clients AS cl,
                articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
                 AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='$'
                 AND (c.Com_date BETWEEN '$datedebut' AND '$datefin')";
                $resultatemontantvenduendolar = $pdo->query($montantvenduendollar);
                $retourvenduendollar = $resultatemontantvenduendolar->fetch();
                $montanttotalvenduendollar = $retourvenduendollar["montantvenduendollar"];

                $montantvenduenfc="SELECT SUM(Detail_qte*puht) AS montantvenduenfc FROM detail AS det,clients AS cl,
                articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
                 AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='FC'
                 AND (c.Com_date BETWEEN '$datedebut' AND '$datefin')";
                $resultatemontantvenduenfc = $pdo->query($montantvenduenfc);
                $retourvenduenfc = $resultatemontantvenduenfc->fetch();
                $montanttotalvenduenfc = $retourvenduenfc["montantvenduenfc"];

                $vente = array();
                //Récupérer les lignes
               while($retour = $resultate->fetch()){
                  array_push($vente,$retour);
               }
               //Afficher le tableau au format JSON              
               echo json_encode(array("historiquevente"=>($vente),"montantvenduendollar"=>$montanttotalvenduendollar,
                "montantvenduenfc"=>$montanttotalvenduenfc,"user"=>$utilisateur));   
            }              
                break;
        case "parproduit":
            $selectionnertout="SELECT Detail_num,Detail_com,com_monnaie,Detail_ref,Detail_qte,puht,Article_designation,
            CONCAT( Client_nom,' ', Client_prenom ) AS client,Com_client,Com_date,Com_montant,unitevent 
            FROM detail AS det,clients AS cl,articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code 
            AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND a.Article_designation = '$idproduit' ORDER BY Detail_com DESC";
            $resultate=$pdo->query($selectionnertout);
             
            $montantvenduendollar="SELECT SUM(Detail_qte*puht) AS montantvenduendollar FROM detail AS det,clients AS cl,
            articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
             AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='$'
             AND a.Article_designation = '$idproduit'";
            $resultatemontantvenduendolar = $pdo->query($montantvenduendollar);
            $retourvenduendollar = $resultatemontantvenduendolar->fetch();
            $montanttotalvenduendollar = $retourvenduendollar["montantvenduendollar"];

            $montantvenduenfc="SELECT SUM(Detail_qte*puht) AS montantvenduenfc FROM detail AS det,clients AS cl,
            articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
             AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='FC'
             AND a.Article_designation = '$idproduit'";
            $resultatemontantvenduenfc = $pdo->query($montantvenduenfc);
            $retourvenduenfc = $resultatemontantvenduenfc->fetch();
            $montanttotalvenduenfc = $retourvenduenfc["montantvenduenfc"];

            $vente = array();
                 //Récupérer les lignes
                while($retour = $resultate->fetch()){
                   array_push($vente,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("historiquevente"=>($vente),"montantvenduendollar"=>$montanttotalvenduendollar,
                "montantvenduenfc"=>$montanttotalvenduenfc,"user"=>$utilisateur));   
            break;

        case "produitpardate":   
            if(isset($_GET['pdate']))
            {
                $selectionnertout="SELECT Detail_num,Detail_com,com_monnaie,Detail_ref,Detail_qte,puht,Article_designation,
                CONCAT( Client_nom,' ', Client_prenom ) AS client,Com_client,Com_date,Com_montant,unitevent 
                FROM detail AS det,clients AS cl,articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code 
                AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND a.Article_designation = '$idproduit' AND c.Com_date = '$dateentre'
                ORDER BY Detail_com DESC";
                $resultate=$pdo->query($selectionnertout);  

                $montantvenduendollar="SELECT SUM(Detail_qte*puht) AS montantvenduendollar FROM detail AS det,clients AS cl,
                articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
                 AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='$'
                 AND a.Article_designation = '$idproduit' AND c.Com_date = '$dateentre'";
                $resultatemontantvenduendolar = $pdo->query($montantvenduendollar);
                $retourvenduendollar = $resultatemontantvenduendolar->fetch();
                $montanttotalvenduendollar = $retourvenduendollar["montantvenduendollar"];
    
                $montantvenduenfc="SELECT SUM(Detail_qte*puht) AS montantvenduenfc FROM detail AS det,clients AS cl,
                articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
                 AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='FC'
                 AND a.Article_designation = '$idproduit' AND c.Com_date = '$dateentre'";
                $resultatemontantvenduenfc = $pdo->query($montantvenduenfc);
                $retourvenduenfc = $resultatemontantvenduenfc->fetch();
                $montanttotalvenduenfc = $retourvenduenfc["montantvenduenfc"];

                $vente = array();
                //Récupérer les lignes  
               while($retour = $resultate->fetch()){
                  array_push($vente,$retour);
               }
               //Afficher le tableau au format JSON              
               echo json_encode(array("historiquevente"=>($vente),"montantvenduendollar"=>$montanttotalvenduendollar,
               "montantvenduenfc"=>$montanttotalvenduenfc,"user"=>$utilisateur));  
            }            
                           
            break;

        case "parclient":               
                $selectionnertout="SELECT Detail_num,Detail_com,com_monnaie,Detail_ref,Detail_qte,puht,Article_designation,
                CONCAT( Client_nom,' ', Client_prenom ) AS client,Com_client,Com_date,Com_montant,unitevent 
                FROM detail AS det,clients AS cl,articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code 
                AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num 
                AND (cl.Client_nom LIKE '%$nomprenom%' OR cl.Client_prenom  LIKE '%$nomprenom%') 
                ORDER BY Detail_com DESC";
                $resultate=$pdo->query($selectionnertout); 

                $montantvenduendollar="SELECT SUM(Detail_qte*puht) AS montantvenduendollar FROM detail AS det,clients AS cl,
                articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
                 AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='$'
                 AND (cl.Client_nom LIKE '%$nomprenom%' OR cl.Client_prenom  LIKE '%$nomprenom%')";
                $resultatemontantvenduendolar = $pdo->query($montantvenduendollar);
                $retourvenduendollar = $resultatemontantvenduendolar->fetch();
                $montanttotalvenduendollar = $retourvenduendollar["montantvenduendollar"];
    
                $montantvenduenfc="SELECT SUM(Detail_qte*puht) AS montantvenduenfc FROM detail AS det,clients AS cl,
                articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code
                 AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num AND c.com_monnaie='FC'
                 AND (cl.Client_nom LIKE '%$nomprenom%' OR cl.Client_prenom  LIKE '%$nomprenom%')";
                $resultatemontantvenduenfc = $pdo->query($montantvenduenfc);
                $retourvenduenfc = $resultatemontantvenduenfc->fetch();
                $montanttotalvenduenfc = $retourvenduenfc["montantvenduenfc"];

                $vente = array();
                 //Récupérer les lignes
                while($retour = $resultate->fetch()){
                   array_push($vente,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("historiquevente"=>($vente),"montantvenduendollar"=>$montanttotalvenduendollar,
                "montantvenduenfc"=>$montanttotalvenduenfc,"user"=>$utilisateur));         
            break;
        
        case "suppression":               
            $iddetail=isset($_GET['iddetail'])?$_GET['iddetail']:0;
            $ancienproduit=isset($_GET['ancienproduit'])?$_GET['ancienproduit']:0;
            $ancienneqte=isset($_GET['ancienqte'])?$_GET['ancienqte']:0;
            $anciennefacture=isset($_GET['anciennefacture'])?$_GET['anciennefacture']:0;
            $ancienmontant=isset($_GET['ancienmontant'])?$_GET['ancienmontant']:0;
        
            $requete="DELETE FROM detail WHERE Detail_num=?";
            $params=array($iddetail);
            $resultat= $pdo->prepare($requete);
            $resultat->execute($params);
        
            if($resultat)
            {
                $requeteP="SELECT Article_Qte FROM articles WHERE Article_code = $ancienproduit";
                $resultatP=$pdo->QUERY($requeteP);
                $retourp = $resultatP->fetch();
                $quaniteanci=$retourp["Article_Qte"];

                $qutite =  $quaniteanci+$ancienneqte;

                $requete = "UPDATE articles SET Article_Qte = $qutite WHERE Article_code = $ancienproduit";
                $retoura = $pdo->query($requete);
               
                $requetecom ="SELECT * FROM commandes WHERE Com_num = $anciennefacture";
                $resultatc=$pdo->QUERY($requetecom);
                $retour = $resultatc->fetch();
                $ancienmonta=$retour["Com_montant"];
             
                $requetecomm = "UPDATE commandes SET Com_montant = $ancienmonta-$ancienmontant WHERE 
                Com_num=$anciennefacture";
                $retourscom = $pdo->query($requetecomm);
                if($retourscom )
                { 
                    $requetecomv ="SELECT * FROM commandes WHERE Com_num = $anciennefacture";
                    $resultatcv=$pdo->QUERY($requetecomv);
                    $retourv = $resultatcv->fetch();
                    $ancienmontav=$retourv["Com_montant"];
                    if($ancienmontav==0)
                    {
                        $requetedeletecom="DELETE FROM commandes WHERE Com_num=?";
                        $paramsdeletecom=array($anciennefacture);
                        $resultatdeletecom= $pdo->prepare($requetedeletecom);
                        $resultatdeletecom->execute($paramsdeletecom);                       
                    }
                    else
                    {
                        $selectionmontant = "SELECT Com_montant FROM commandes WHERE Com_num = $anciennefacture";
                        $retoursselection=$pdo->query($selectionmontant);
                        $retourselection =$retoursselection->fetch();
                        $montantselect=$retourselection["Com_montant"];

                        $modifierrmontantapayer = "UPDATE paiement SET montant_a_paye=$montantselect WHERE numerofacture = $anciennefacture";
                        $updateapayer = $pdo->query($modifierrmontantapayer);
                        if($updateapayer )
                        {
                            $selectionidpaiementparfacture = "SELECT * FROM paiement WHERE numerofacture = $anciennefacture";
                            $resultattouslesidpaiement = $pdo->query($selectionidpaiementparfacture);                   
                            while($idpaie = $resultattouslesidpaiement->fetch())
                            {
                                $idpaieprecedemment = $idpaie["id_paiement"];
                                $sommepayeprecedemment = "SELECT SUM(montant_paye) AS montantp 
                                FROM paiement WHERE numerofacture = $anciennefacture AND id_paiement<=$idpaieprecedemment";
                                $resultatsommepayeprecedemment = $pdo->query($sommepayeprecedemment);
                                $retoursommepayeprecedemment = $resultatsommepayeprecedemment->fetch();
                                $montantpaiyeprecedemment = $retoursommepayeprecedemment['montantp'];                      
                                $resteupdate = number_format($ancienmontav-$montantpaiyeprecedemment,6,'.','');                       
                                $updatereste = "UPDATE paiement SET reste=? WHERE id_paiement=?";
                                $paramss = array($resteupdate,$idpaieprecedemment);
                                $resultatreste = $pdo->prepare($updatereste);
                                $resultatreste->execute($paramss);
                            }
                        }                          
                    }
                }
                
            }           
        break;

        case "modifier":          
            $iddetail=isset($_GET['iddetail'])?$_GET['iddetail']:0;
            $idancienproduit=isset($_GET['ancienproduit'])?$_GET['ancienproduit']:0;
            $ancienneqte=isset($_GET['ancienqte'])?$_GET['ancienqte']:0;
            $anciennefacture=isset($_GET['anciennefacture'])?$_GET['anciennefacture']:0;
            $ancienmontant=isset($_GET['ancienmontant'])?$_GET['ancienmontant']:0;

            $idclient= isset($_GET['idclient'])?$_GET['idclient']:1;
            $produit = isset($_GET['idarticle'])?$_GET['idarticle']:1;
            $numerofacture = isset($_GET['numerocommande'])?$_GET['numerocommande']:"";
            $qte = isset($_GET['qte'])?$_GET['qte']:0;
            $puht = isset($_GET['puht'])?$_GET['puht']:0;
            $datevente = isset($_GET['datevente'])?$_GET['datevente']:"";
            
            $requete="UPDATE detail SET Detail_com=?,Detail_ref=?,Detail_qte=?,puht=? WHERE Detail_num=?";
            $params=array($numerofacture,$produit,$qte,$puht,$iddetail);
            $resultat= $pdo->prepare($requete);
            $resultat->execute($params);
            if($resultat)
            {
                
                if($produit==$idancienproduit)
                {
                    $requeteentre = "SELECT SUM(quantite_entre) AS qte FROM entre_stock WHERE id_article=$produit";
                    $retours=$pdo->query($requeteentre);
                    $retour =$retours->fetch();
                    $quantite=$retour["qte"];

                    $requetevente = "SELECT SUM(Detail_qte) AS qtevendu FROM detail WHERE Detail_ref=$produit";
                    $retoursqtevente=$pdo->query($requetevente);
                    $retourvente =$retoursqtevente->fetch();
                    $quantitevendue=$retourvente["qtevendu"];
    
                    $requete = "UPDATE articles SET Article_Qte = $quantite-$quantitevendue WHERE Article_code = $produit";
                    $retours = $pdo->query($requete);
                }
                else
                {
                    $requeteP="SELECT SUM(quantite_entre) AS qte FROM entre_stock WHERE id_article=$idancienproduit";
                    $resultatP=$pdo->QUERY($requeteP);
                    $retour = $resultatP->fetch();
                    $quaniteanci=$retour["qte"];

                    $requeteventeancien = "SELECT SUM(Detail_qte) AS qtevendu FROM detail WHERE Detail_ref=$idancienproduit";
                    $retoursqteventeanc=$pdo->query($requeteventeancien);
                    $retourventeanc =$retoursqteventeanc->fetch();
                    $quantitevendueanc=$retourventeanc["qtevendu"];

                    $qutite =  $quaniteanci-$quantitevendueanc;

                    $requete = "UPDATE articles SET Article_Qte = $qutite WHERE Article_code = $idancienproduit";
                    $retoura = $pdo->query($requete);

                   
                    $requetenouveauarticle = "SELECT Article_Qte FROM articles WHERE Article_code = $produit";
                    $retours=$pdo->query($requetenouveauarticle);
                    $retour =$retours->fetch();
                    $quantitenouvelle=$retour["Article_Qte"];
    
                    $requete = "UPDATE articles SET Article_Qte = $quantitenouvelle-$qte WHERE Article_code = $produit";
                    $retours = $pdo->query($requete);                      
                }
                if($numerofacture==$anciennefacture)
                {
                    $requete = "SELECT SUM(Detail_qte*puht) AS Com_montant FROM detail WHERE Detail_com = $anciennefacture";
                    $retours=$pdo->query($requete);
                    $retour =$retours->fetch();
                    $montant=$retour["Com_montant"];
                    $requeteupdate = "UPDATE commandes SET Com_client=?,Com_date=?,
                    Com_montant= ? WHERE Com_num = $anciennefacture";
                    $params=array($idclient,$datevente,$montant);
                    $resultat= $pdo->prepare($requeteupdate);
                    $resultat->execute($params);
                    if( $resultat)
                    {
                        $selectionmontant = "SELECT Com_montant FROM commandes WHERE Com_num = $anciennefacture";
                        $retoursselection=$pdo->query($selectionmontant);
                        $retourselection =$retoursselection->fetch();
                        $montantselect=$retourselection["Com_montant"];

                        $modifierrmontantapayer = "UPDATE paiement SET montant_a_paye=$montantselect WHERE numerofacture = $anciennefacture";
                        $updateapayer = $pdo->query($modifierrmontantapayer);

                        if($updateapayer)
                        {
                            $selectionidpaiementparfacture = "SELECT * FROM paiement WHERE numerofacture = $anciennefacture";
                            $resultattouslesidpaiement = $pdo->query($selectionidpaiementparfacture);                   
                            while($idpaie = $resultattouslesidpaiement->fetch())
                            {
                                $idpaieprecedemment = $idpaie["id_paiement"];
                                $sommepayeprecedemment = "SELECT SUM(montant_paye) AS montantp 
                                FROM paiement WHERE numerofacture = $anciennefacture AND id_paiement<=$idpaieprecedemment";
                                $resultatsommepayeprecedemment = $pdo->query($sommepayeprecedemment);
                                $retoursommepayeprecedemment = $resultatsommepayeprecedemment->fetch();
                                $montantpaiyeprecedemment = $retoursommepayeprecedemment['montantp'];                      
                                $resteupdate = number_format($montantselect-$montantpaiyeprecedemment,6,'.','');                       
                                $updatereste = "UPDATE paiement SET reste=? WHERE id_paiement=?";
                                $paramss = array($resteupdate,$idpaieprecedemment);
                                $resultatreste = $pdo->prepare($updatereste);
                                $resultatreste->execute($paramss);
                            }
                        } 
                    }
                }
                else
                {
                    
                    $requete = "SELECT SUM(Detail_qte*puht) AS Com_montant FROM detail WHERE Detail_com = $anciennefacture";
                    $retours=$pdo->query($requete);
                    $retour =$retours->fetch();
                    $montant=$retour["Com_montant"];

                    $requeteancicom = "UPDATE commandes SET Com_client=?,Com_date=?,
                    Com_montant= ? WHERE Com_num = $anciennefacture";
                    $params=array($idclient,$datevente,$montant);
                    $resultatan= $pdo->prepare($requeteancicom);
                    $resultatan->execute($params); 
                    if($resultatan)
                    {
                        $selectionmontant = "SELECT Com_montant FROM commandes WHERE Com_num = $anciennefacture";
                        $retoursselection=$pdo->query($selectionmontant);
                        $retourselection =$retoursselection->fetch();
                        $montantselect=$retourselection["Com_montant"];

                        $modifierrmontantapayer = "UPDATE paiement SET montant_a_paye=$montantselect WHERE numerofacture = $anciennefacture";
                        $updateapayer = $pdo->query($modifierrmontantapayer);

                        if($updateapayer)
                        {
                            $selectionidpaiementparfacture = "SELECT * FROM paiement WHERE numerofacture = $anciennefacture";
                            $resultattouslesidpaiement = $pdo->query($selectionidpaiementparfacture);                   
                            while($idpaie = $resultattouslesidpaiement->fetch())
                            {
                                $idpaieprecedemment = $idpaie["id_paiement"];
                                $sommepayeprecedemment = "SELECT SUM(montant_paye) AS montantp 
                                FROM paiement WHERE numerofacture = $anciennefacture AND id_paiement<=$idpaieprecedemment";
                                $resultatsommepayeprecedemment = $pdo->query($sommepayeprecedemment);
                                $retoursommepayeprecedemment = $resultatsommepayeprecedemment->fetch();
                                $montantpaiyeprecedemment = $retoursommepayeprecedemment['montantp'];                      
                                $resteupdate = number_format($montantselect-$montantpaiyeprecedemment,6,'.','');                       
                                $updatereste = "UPDATE paiement SET reste=? WHERE id_paiement=?";
                                $paramss = array($resteupdate,$idpaieprecedemment);
                                $resultatreste = $pdo->prepare($updatereste);
                                $resultatreste->execute($paramss);
                            }
                        } 


                        $requet = "SELECT SUM(Detail_qte*puht) AS Com_montant FROM detail WHERE Detail_com = $numerofacture";
                        $retours=$pdo->query($requet);
                        $retour =$retours->fetch();
                        $montant=$retour["Com_montant"];
                        $requeteupdate = "UPDATE commandes SET Com_client=?,Com_date=?,
                        Com_montant= ? WHERE Com_num = $numerofacture";
                        $params=array($idclient,$datevente,$montant);
                        $resultat= $pdo->prepare($requeteupdate);
                        $resultat->execute($params);
                        if( $resultat)
                        {
                            $selectionmontantnew = "SELECT Com_montant FROM commandes WHERE Com_num = $numerofacture";
                            $retoursselectionnew=$pdo->query($selectionmontantnew);
                            $retourselectionnew =$retoursselectionnew->fetch();
                            $montantselecte=$retourselectionnew["Com_montant"];

                            $modifierrmontantapayern = "UPDATE paiement SET montant_a_paye=$montantselecte WHERE numerofacture = $numerofacture";
                            $updateapayern = $pdo->query($modifierrmontantapayern);

                            if($updateapayern)
                            {
                                $selectionidpaiementparfacturen = "SELECT * FROM paiement WHERE numerofacture = $numerofacture";
                                $resultattouslesidpaiementn = $pdo->query($selectionidpaiementparfacturen);                   
                                while($idpaien = $resultattouslesidpaiementn->fetch())
                                {
                                    $idpaieprecedemmentn = $idpaien["id_paiement"];
                                    $sommepayeprecedemment = "SELECT SUM(montant_paye) AS montantp 
                                    FROM paiement WHERE numerofacture = $numerofacture AND id_paiement<=$idpaieprecedemmentn";
                                    $resultatsommepayeprecedemment = $pdo->query($sommepayeprecedemment);
                                    $retoursommepayeprecedemment = $resultatsommepayeprecedemment->fetch();
                                    $montantpaiyeprecedemment = $retoursommepayeprecedemment['montantp'];                      
                                    $resteupdate = number_format($montantselecte-$montantpaiyeprecedemment,6,'.','');                       
                                    $updatereste = "UPDATE paiement SET reste=? WHERE id_paiement=?";
                                    $paramss = array($resteupdate,$idpaieprecedemmentn);
                                    $resultatreste = $pdo->prepare($updatereste);
                                    $resultatreste->execute($paramss);
                                }
                            } 
                        }
                    }                    
                }
            }         
            break;

            case "chargerchampmodifier":
            $iddetail=isset($_GET['iddetail'])?$_GET['iddetail']:0;
            $anciennefacture=isset($_GET['anciennefacture'])?$_GET['anciennefacture']:0;
            $ancienneqte=isset($_GET['ancienqte'])?$_GET['ancienqte']:0;
            $selectionnertout="SELECT Detail_num,Detail_com,Detail_ref,Detail_qte,puht,
            Article_designation,CONCAT( Client_nom,' ', Client_prenom ) AS client,Client_num,
            Com_client,Com_date,Com_montant FROM detail AS det,clients AS cl,articles AS a,
            commandes AS c WHERE det.Detail_ref=a.Article_code AND det.Detail_com=c.Com_num
             AND c.Com_client=cl.Client_num AND det.Detail_num=$iddetail";

            $resultatdetail=$pdo->query($selectionnertout);
            $detail=$resultatdetail->fetch();
            $numerofacture=$detail['Detail_com'];
            $idarticle=$detail['Detail_ref'];
            $detailqte=$detail['Detail_qte'];           
            $puht=$detail['puht'];
            $clientnum=$detail['Client_num'];
            $datecom=$detail['Com_date'];
          
            $requetecommande="SELECT * FROM commandes";
            $resultatcommande=$pdo->query($requetecommande);
           
            $commades = array();
            //Récupérer les lignes
            while($retour = $resultatcommande->fetch()){
                array_push($commades,$retour);
            }

            $requeteclient="SELECT Client_num,CONCAT( Client_nom,' ', Client_prenom ) AS client FROM clients";
            $resultatclient=$pdo->query($requeteclient);
          
            $clients = array();
            //Récupérer les lignes
            while($retour = $resultatclient->fetch()){
                array_push($clients,$retour);
            }
                      
            $requeteP="SELECT * FROM articles";
            $resultatP=$pdo->query($requeteP);
           
            $produits = array();
            //Récupérer les lignes
            while($retour = $resultatP->fetch()){
                array_push($produits,$retour);
            }
       
             echo json_encode(array("idarticle"=>$idarticle,"numerofacture"=>$numerofacture,
             "quantitedetail"=>$detailqte,"puht"=>$puht, "clientnum"=>$clientnum,"datecommande"=>$datecom,          
            "designationproduit"=>($produits),"client"=>($clients),"commande"=>($commades)));                           
            break;        
      }      
    }

?>