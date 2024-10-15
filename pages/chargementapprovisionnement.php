<?php
require_once('identifier.php');
require_once('connexiondb.php');

$utilisateur=$_SESSION['user']['roles'];
$idproduit= isset($_GET['designation'])?$_GET['designation']:"";
$fournisseur= isset($_GET['fournisseur'])?$_GET['fournisseur']:1;
$dateentre= isset($_GET['pdate'])?$_GET['pdate']:"";
$datedebut= isset($_GET['datedebut'])?$_GET['datedebut']:"";
$datefin= isset($_GET['datefin'])?$_GET['datefin']:"";

   if(isset($_GET["param"]))
    {
        switch($_GET["param"])
        {
            case "tous":
                $selectionnertout="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) AS fournisseurs,
                ref_produit,designation_produit,numero_facture,quantite_entre,libelle,puht,monnaie,date_entre,
                observation,id_article FROM entre_stock AS es,fournisseur AS f,produits AS p,unite_mesure AS um 
                WHERE es.id_fournisseur=f.idf AND es.id_article=p.ref_produit AND es.unite=um.id_unite ";
                $resultate = $pdo->query($selectionnertout);

                $approvisionnement = array();
                 //Récupérer les lignes
                while($retour = $resultate->fetch()){
                   array_push($approvisionnement,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("entrestock"=>($approvisionnement),"user"=>$utilisateur));             
                break;
            case "pardate":
                $selectionnertout="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) AS fournisseurs,
                ref_produit,designation_produit,numero_facture,quantite_entre,libelle,puht,monnaie,date_entre,
                observation,id_article FROM entre_stock as es,fournisseur as f,produits as p,
                unite_mesure AS um WHERE es.id_fournisseur=f.idf AND es.id_article=p.ref_produit 
                AND es.date_entre = '$dateentre' AND es.unite=um.id_unite";
                 $resultate=$pdo->query($selectionnertout);
                
                 $approvisionnement = array();
                 //Récupérer les lignes
                while($retour = $resultate->fetch()){
                   array_push($approvisionnement,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("entrestock"=>($approvisionnement),"user"=>$utilisateur));             
                break;
        case "datedebut":
            if(isset($_GET['datefin']))
            {
                $selectionnerparperiode="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) AS fournisseurs,
                ref_produit,designation_produit,numero_facture,quantite_entre,libelle,puht,monnaie,date_entre,
                observation,id_article FROM entre_stock as es,fournisseur as f,produits as p,unite_mesure AS um WHERE
                es.id_fournisseur=f.idf AND es.id_article=p.ref_produit 
                AND (es.date_entre BETWEEN '$datedebut' AND '$datefin') AND es.unite=um.id_unite";
                $resultate=$pdo->query($selectionnerparperiode);
                
                $approvisionnement = array();
                //Récupérer les lignes
               while($retour = $resultate->fetch()){
                  array_push($approvisionnement,$retour);
               }
               //Afficher le tableau au format JSON              
               echo json_encode(array("entrestock"=>($approvisionnement),"user"=>$utilisateur));             
 
            }              
                break;
        case "parproduit":
            $selectionnertout="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) AS fournisseurs,
            ref_produit,designation_produit,numero_facture,quantite_entre,libelle,puht,monnaie,date_entre,
            observation,id_article FROM entre_stock AS es,fournisseur AS f,produits AS p,unite_mesure AS um WHERE
            es.id_fournisseur=f.idf AND es.id_article=p.ref_produit AND p.designation_produit = '$idproduit'
             AND es.unite=um.id_unite";
            $resultate=$pdo->query($selectionnertout);
             
            $approvisionnement = array();
            //Récupérer les lignes
           while($retour = $resultate->fetch()){
              array_push($approvisionnement,$retour);
           }
           //Afficher le tableau au format JSON              
           echo json_encode(array("entrestock"=>($approvisionnement),"user"=>$utilisateur));             
        break;

        case "produitpardate":
            if(isset($_GET['pdate']))
            {               
                $selectionnertout="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) AS fournisseurs,
                ref_produit,designation_produit,numero_facture,quantite_entre,libelle,puht,monnaie,date_entre,
                observation,id_article FROM entre_stock AS es,fournisseur AS f,produits AS p,unite_mesure AS um WHERE
                es.id_fournisseur=f.idf AND es.id_article=p.ref_produit 
                AND p.designation_produit = '$idproduit' AND es.date_entre = '$dateentre'
                AND es.unite=um.id_unite";
                $resultate=$pdo->query($selectionnertout);  
                $approvisionnement = array();
                //Récupérer les lignes
                while($retour = $resultate->fetch()){
                    array_push($approvisionnement,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("entrestock"=>($approvisionnement),"user"=>$utilisateur));             
            }           
        break;

            case "parfournisseur":               
                $selectionnertout="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) AS fournisseurs,
                ref_produit,designation_produit,numero_facture,quantite_entre,libelle,puht,monnaie,date_entre,
                observation,id_article FROM entre_stock AS es,fournisseur AS f,produits AS p,unite_mesure AS um WHERE
                es.id_fournisseur=f.idf AND es.id_article=p.ref_produit
                 AND (f.nom LIKE '%$fournisseur%' OR f.prenom LIKE '%$fournisseur%') 
                 AND es.unite=um.id_unite";
                $resultate=$pdo->query($selectionnertout);  
                $approvisionnement = array();
            //Récupérer les lignes
            while($retour = $resultate->fetch()){
                array_push($approvisionnement,$retour);
            }
            //Afficher le tableau au format JSON              
            echo json_encode(array("entrestock"=>($approvisionnement),"user"=>$utilisateur));             
        break;

        case "suppression":               
            $ides=isset($_GET['identrestock'])?$_GET['identrestock']:0;
            $ancienproduit=isset($_GET['ancienproduit'])?$_GET['ancienproduit']:0;
            $ancienneqte=isset($_GET['ancienqte'])?$_GET['ancienqte']:0;
        
            $requete="DELETE FROM entre_stock WHERE id_entre=?";
            $params=array($ides);
            $resultat= $pdo->prepare($requete);
            $resultat->execute($params);
        
            if($resultat)
            {
                $requeteP="SELECT * FROM articles WHERE Article_code=$ancienproduit";
                $resultatP=$pdo->QUERY($requeteP);
                $retour = $resultatP->fetch();
                $quaniteanci=$retour["Article_Qte"];
                $qte=$quaniteanci-$ancienneqte;
                $requete = "UPDATE articles SET Article_Qte = $qte WHERE Article_code = $ancienproduit";
                $retours = $pdo->query($requete); 
                if($retours)
                {
                    $verifiqte="SELECT * FROM articles WHERE Article_code=$ancienproduit";
                    $resultatverif=$pdo->QUERY($verifiqte);
                    $retourverif = $resultatverif->fetch();
                    $quaniteveri=$retourverif["Article_Qte"];

                    if( $quaniteveri==0)
                    {
                        $requetee = "SELECT * FROM entre_stock WHERE id_article=$ancienproduit";
                        $resultatee=$pdo->QUERY($requetee);
                        $retouree = $resultatee->fetch();
                        if(empty($retouree)) 
                        {
                            $reque="DELETE FROM articles WHERE Article_code = ?";
                            $paramse=array($ancienproduit);
                            $result= $pdo->prepare($reque);
                            $result->execute($paramse);
                        }
                    }
                   
                    
                }
                           
            }           
        break;
        
        case "inserer":               
        $fournisseur = isset($_GET['idFournisseur'])?$_GET['idFournisseur']:1;
        $produit = isset($_GET['idproduit'])?$_GET['idproduit']:1;
        $numerofacture = isset($_GET['numerofacture'])?$_GET['numerofacture']:"";
        $qte = isset($_GET['quantiteentre'])?$_GET['quantiteentre']:0;
        $puht = isset($_GET['puht'])?$_GET['puht']:0;
        $monnaieappr = isset($_GET['monnaieapro'])?$_GET['monnaieapro']:"";
        $unite = isset($_GET['unite'])?$_GET['unite']:"";
        $dateenre = date('Y/m/d');
        $observation = isset($_GET['observation'])?$_GET['observation']:"";

        $requete = "INSERT INTO entre_stock(id_fournisseur,id_article,numero_facture,quantite_entre,unite,
        puht,monnaie,date_entre,observation) VALUES (?,?,?,?,?,?,?,?,?)";
        $params=array($fournisseur,$produit,$numerofacture,$qte,$unite,$puht,$monnaieappr,$dateenre,$observation);
        $resultat= $pdo->prepare($requete);
        $resultat->execute($params);

        $requete = "SELECT * FROM articles WHERE Article_code = $produit";
        $retours=$pdo->query($requete);
        $retour =$retours->fetch();
        if ($retour)
        {
            $requete = "UPDATE articles SET Article_Qte = Article_Qte + $qte WHERE Article_code = $produit";
            //$requete = "UPDATE articles SET Article_Qte = Article_Qte + ".$_GET['qte_produit']." WHERE Article_code = '$idproduit'";
            $retours = $pdo->query($requete);
        }
        else
        {
            $requeteP="SELECT * FROM produits WHERE ref_produit=$produit";
            $resultatP=$pdo->QUERY($requeteP);
            $retour = $resultatP->fetch();
            $designation=$retour["designation_produit"];
            $qtemin= $retour["qte_min"];

            $requetelib="SELECT * FROM unite_mesure WHERE id_unite=$unite";
            $resultatlib=$pdo->QUERY($requetelib);
            $retourlib = $resultatlib->fetch();
            $libell=$retourlib["libelle"];
        
            $requete = "INSERT INTO articles(Article_code,Article_designation,Article_PUHT,Article_Qte,unite,qtemin) VALUES (?,?,?,?,?,?)";
            $params=array($produit,$designation,$puht,$qte,$libell,$qtemin);
            $resultat= $pdo->prepare($requete);
            $resultat->execute($params);

}
        break; 

        case "modifier":
            
            $ides=isset($_GET['idES'])?$_GET['idES']:0;
            $idancienproduit=isset($_GET['ancienproduit'])?$_GET['ancienproduit']:0;
            $ancienneqte=isset($_GET['ancienqte'])?$_GET['ancienqte']:0;
            $fournisseur= isset($_GET['idFournisseur'])?$_GET['idFournisseur']:1;
            $produit = isset($_GET['idproduit'])?$_GET['idproduit']:1;
            $numerofacture = isset($_GET['numerofacture'])?$_GET['numerofacture']:"";
            $qte = isset($_GET['quantiteentre'])?$_GET['quantiteentre']:0;
            $unite = isset($_GET['unite'])?$_GET['unite']:0;
            $puht = isset($_GET['puht'])?$_GET['puht']:0;
            $monnaieap = isset($_GET['editmonnaie'])?$_GET['editmonnaie']:0;
            $dateenre = isset($_GET['dateenre'])?$_GET['dateenre']:"";
            $observation = isset($_GET['observation'])?$_GET['observation']:"";

            $requete="UPDATE entre_stock SET id_fournisseur=?,id_article=?,numero_facture=?,quantite_entre=?,
            unite=?,puht=?,monnaie=?,date_entre=?,observation=? WHERE id_entre=?";
            $params=array($fournisseur,$produit,$numerofacture,$qte,$unite,$puht,$monnaieap,$dateenre,$observation,$ides);
            $resultat= $pdo->prepare($requete);
            $resultat->execute($params);
            if($resultat)
            {
                $requeteP="SELECT * FROM produits WHERE ref_produit=$produit";
                $resultatP=$pdo->QUERY($requeteP);
                $retour = $resultatP->fetch();
                $designation=$retour["designation_produit"];
    
                if($produit==$idancienproduit)
                {
                    $requeteentre = "SELECT Article_Qte FROM articles WHERE Article_code = $produit";
                    $retours=$pdo->query($requeteentre);
                    $retour =$retours->fetch();
                    $quantite=$retour["Article_Qte"];
    
                    $requete = "UPDATE articles SET Article_Qte = $quantite+ $qte-$ancienneqte WHERE Article_code = $produit";
                    $retours = $pdo->query($requete);
                }
                else
                {
                    $requeteP="SELECT * FROM articles WHERE Article_code=$idancienproduit";
                    $resultatP=$pdo->QUERY($requeteP);
                    $retour = $resultatP->fetch();
                    $quaniteanci=$retour["Article_Qte"];

                    $requete = "UPDATE articles SET Article_Qte = $quaniteanci-$ancienneqte WHERE Article_code = $idancienproduit";
                    $retoura = $pdo->query($requete);                
    
                    $requetenouveauid="SELECT * FROM articles WHERE Article_code= $produit";
                    $resultatnouveau=$pdo->QUERY($requetenouveauid);
                    $retournouveau = $resultatnouveau->fetch();
                    if($retournouveau)
                    {
                        $requetenouvo="SELECT * FROM articles WHERE Article_code= $produit";
                        $resultatnouvo=$pdo->QUERY($requetenouvo);
                        $retournouvo = $resultatnouvo->fetch();
                        $quantiten=$retournouvo["Article_Qte"];

                        $requete = "UPDATE articles SET Article_Qte = $quantiten+$qte WHERE Article_code = $produit";
                        $retours = $pdo->query($requete);
    
                    }
                    else
                    {
                        $requetePn="SELECT * FROM produits WHERE ref_produit=$produit";
                        $resultatPn=$pdo->QUERY($requetePn);
                        $retourPn = $resultatPn->fetch();
                        $designation=$retourPn["designation_produit"];
                        $qtemin= $retourPn["qte_min"];

                        $requetlibe="SELECT * FROM unite_mesure WHERE id_unite=$unite";
                        $resultatlib=$pdo->QUERY($requetlibe);
                        $retourlibel = $resultatlib->fetch();
                        $lbl= $retourlibel["libelle"];
                    
                        $requete = "INSERT INTO articles(Article_code,Article_designation,Article_PUHT,Article_Qte,unite,qtemin) VALUES (?,?,?,?,?,?)";
                        $params=array($produit,$designation,$puht,$qte,$lbl,$qtemin);
                        $resultat= $pdo->prepare($requete);
                        $resultat->execute($params);
                       
                    }
    
                }
            }         
            break;

            case "chargerchampmodifier":
            $idES=isset($_GET['identrestock'])?$_GET['identrestock']:0;
            $ancienproduit=isset($_GET['ancienproduit'])?$_GET['ancienproduit']:0;
            $ancienneqte=isset($_GET['ancienqte'])?$_GET['ancienqte']:0;
            $requeteES="SELECT * FROM entre_stock WHERE id_entre=$idES";
            $resultatES=$pdo->query($requeteES);
            $entrestock=$resultatES->fetch();
            $idfournisseur=$entrestock['id_fournisseur'];
            $idarticle=$entrestock['id_article'];
            $numerofacture=$entrestock['numero_facture'];
            $quantiteentre=$entrestock['quantite_entre'];
            $unitee=$entrestock['unite'];
            $puht=$entrestock['puht'];
            $monaie=$entrestock['monnaie'];
            $dateentre=$entrestock['date_entre'];
            $observation=$entrestock['observation'];
            
            $requeteF="SELECT idf,CONCAT( nom,' ', prenom ) AS fournisseurs FROM fournisseur";
            $resultatF=$pdo->query($requeteF);
           
            $fournisseurs = array();
            //Récupérer les lignes
            while($retour = $resultatF->fetch()){
                array_push($fournisseurs,$retour);
            }
            
            $requeteP="SELECT * FROM produits";
            $resultatP=$pdo->query($requeteP);
           
            $produits = array();
            //Récupérer les lignes "idf"=>$idfourn,
            while($retourproduit = $resultatP->fetch()){
                array_push($produits,$retourproduit);
            }

            $selectionunite="SELECT * FROM unite_mesure";
            $resultatunite=$pdo->query($selectionunite);
           
            $unites = array();
            //Récupérer les lignes "idf"=>$idfourn,
            while($retourunite = $resultatunite->fetch()){
                array_push($unites,$retourunite);
            }
       
             echo json_encode(array("idfournisseur"=>($idfournisseur),"idarticle"=>$idarticle,
            "numerofacture"=>$numerofacture,"quantiteentre"=>$quantiteentre,"unite"=>$unitee,
            "puht"=>$puht,"monnaie"=>$monaie,"dateentre"=>$dateentre,"observation"=>$observation,
            "designationproduit"=>$produits,"unitem"=>$unites,"fournisseurs"=>$fournisseurs));                           
            break; 

        
        case "recuperer_fournisseur":
            $requeteF="SELECT idf,CONCAT( nom,' ', prenom ) AS fournisseurs FROM fournisseur";
            $resultatF=$pdo->query($requeteF);
           
            $fournisseurs = array();
            //Récupérer les lignes
            while($retour = $resultatF->fetch()){
                array_push($fournisseurs,$retour);
            }
            //Afficher le tableau au format JSON              
            echo json_encode(array("fournisseur"=>($fournisseurs))); 
        break;

        case "recuperer_produit":                      
            $requeteP="SELECT * FROM produits ORDER BY ref_produit DESC";
            $resultatP=$pdo->query($requeteP);
            $produits = array();
            
            //Récupérer les lignes
            while($retour = $resultatP->fetch()){
                array_push($produits,$retour);              
            }
            //Afficher le tableau au format JSON              
            echo json_encode(array("produit"=>($produits)));
        break;

        case "recuperer_unite":                      
            $touteslesunites="SELECT * FROM unite_mesure";
            $resultattouteslesunites=$pdo->query($touteslesunites);
            $lesunites = array();          
            //Récupérer les lignes
            while($retour = $resultattouteslesunites->fetch()){
                array_push($lesunites,$retour);              
            }
            //Afficher le tableau au format JSON              
            echo json_encode(array("unites"=>($lesunites)));
        break;
        case "recupererqte":
            $idproduit=isset($_GET['ref_article'])?$_GET['ref_article']:"";
            $requeteqted = "SELECT * FROM articles WHERE Article_code = '$idproduit'";
            $retoursqtedis=$pdo->query($requeteqted);
            $retour =$retoursqtedis->fetch();
            if(empty($retour))
            {
                $qtedisp = 0;
            }
            else
            {
                $qtedisp = $retour["Article_Qte"];
            }
            
            echo json_encode(array("quantitedispo"=>$qtedisp)); 
        break;
           
      }      
    }

?>