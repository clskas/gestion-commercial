<?php

require_once('identifier.php');
require_once('connexiondb.php');
$utilisateur=$_SESSION['user']['roles'];
$designation= isset($_GET['designation'])?$_GET['designation']:"";

   if(isset($_GET["param"]))
    {
        switch($_GET["param"])
        {
            case "tous": 
                //$datetim = date("Y-m-d H:i:s");
                $requete= "SELECT * FROM produits";
                $resultatp=$pdo->query($requete);

                $produits = array();
                 //Récupérer les lignes
                while($retour = $resultatp->fetch()){
                   array_push($produits,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("produit"=>($produits),"user"=>$utilisateur));            
                break;
            case "pardesignation":
                $requete="SELECT * FROM produits WHERE designation_produit LIKE '%$designation%'";
                $resultatp=$pdo->query($requete);
                 
                $produits = array();
                     //Récupérer les lignes
                while($retour = $resultatp->fetch()){
                    array_push($produits,$retour);
                }
                    //Afficher le tableau au format JSON              
                    echo json_encode(array("produit"=>($produits),"user"=>$utilisateur));            
            break;  

            case "suppression":  
                $idp=isset($_GET['idp'])?$_GET['idp']:0;

                $selectinnerfacture = "SELECT DISTINCT * FROM detail WHERE Detail_ref=$idp";
                $resultatfact=$pdo->QUERY($selectinnerfacture);
                                                            
               while($retour = $resultatfact->fetch())
                {
                    $numfact = $retour['Detail_com'];
                    $requetecom ="SELECT * FROM commandes WHERE Com_num = $numfact";
                    $resultatc=$pdo->QUERY($requetecom);
                    $retours = $resultatc->fetch();
                    $montantcommande=$retours["Com_montant"];

                    $requetedetail ="SELECT Detail_qte*puht AS montant FROM detail WHERE Detail_com = $numfact";
                    $resultatdetail=$pdo->QUERY($requetedetail);
                    $retourdetail = $resultatdetail->fetch();
                    $montantdetail=$retourdetail["montant"];
                
                    $requete = "UPDATE commandes SET Com_montant = $montantcommande-$montantdetail WHERE 
                    Com_num=$numfact";
                    $retours = $pdo->query($requete);
					if($retours)
					{
						$requetecomm ="SELECT Com_montant FROM commandes WHERE Com_num = $numfact";
						$resultatcomm = $pdo->QUERY($requetecomm);
						$retourcomm = $resultatcomm->fetch();
						$montantcomm=$retourcomm["Com_montant"];
						if($montantcomm == 0)
						{
							$requetedeletecom="DELETE FROM commandes WHERE Com_num =?";
							$paramscom=array($numfact);
							$resultatcom= $pdo->prepare($requetedeletecom);
							$resultatcom->execute($paramscom);
						}	
						
					}	
                }
                
                $requete="DELETE FROM produits WHERE ref_produit=?";
                $params=array($idp);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
            
                $requetea="DELETE FROM articles WHERE Article_code=?";
                $paramsa=array($idp);
                $resultata= $pdo->prepare($requetea);
                $resultata->execute($paramsa);
                          
            break;

            case "inserer":
                $designation= isset($_GET['designation'])?$_GET['designation']:"";
                $qtemin = isset($_GET['qtemin'])?$_GET['qtemin']:0;
                //$tva = isset($_GET['tva'])?$_GET['tva']:"";
                $marque = isset($_GET['marque'])?$_GET['marque']:"";

                $requete= "INSERT INTO produits(designation_produit,qte_min,tva,marque) VALUES (?,?,?,?)";
                $params=array($designation,$qtemin,"0",$marque);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
            break;

            case "modifier":
                $idp=isset($_GET['idp'])?$_GET['idp']:0;
                           
                $designation= isset($_GET['designation'])?$_GET['designation']:"";
                $qtemin = isset($_GET['qtemin'])?$_GET['qtemin']:0;
                $tva = isset($_GET['tva'])?$_GET['tva']:"";
                $marque = isset($_GET['marque'])?$_GET['marque']:"";
    
                $requete="UPDATE produits SET designation_produit=?,qte_min=?,tva=?,marque=? WHERE ref_produit=?";
                $params=array($designation,$qtemin,"0",$marque,$idp);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
                if($resultat)
                {
                    $requeteart="UPDATE articles SET Article_designation = ?,qtemin = ? WHERE Article_code=?";
                    $paramsart=array($designation,$qtemin,$idp);
                    $resultatart= $pdo->prepare($requeteart);
                    $resultatart->execute($paramsart);
                }
                
                break;

            case "chargerchampmodifier":
                $idp=isset($_GET['idp'])?$_GET['idp']:0;
                $requete="SELECT * FROM produits WHERE ref_produit=$idp";
                $resultat=$pdo->query($requete);
                $produits=$resultat->fetch();
                $designation = $produits['designation_produit'];
                $qtemin = $produits['qte_min'];
                //$tva = $produits['tva'];
                $marque = $produits['marque'];
   
                echo json_encode(array("designationproduit"=>($designation),
                "qteminimale"=>$qtemin,"marque"=>$marque));      
                break;   
      }      
    }

?>