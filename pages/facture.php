<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_GET["param"]))
{
    switch($_GET["param"])
    {
        case "recup_client":
            $idclient=isset($_GET['ref_client'])?$_GET['ref_client']:"";
            $requete = "SELECT * FROM clients WHERE Client_num = $idclient";
            $retours=$pdo->query($requete);
            $retour = $retours->fetch();
            $civilite = $retour["Client_civilite"];
            $nom = $retour["Client_nom"];
            $prenom = $retour["Client_prenom"];   
            echo json_encode(array("civilite"=>$civilite,"nom"=>$nom,"prenom"=>$prenom)); 
            break;
        case "recup_article":
            $idproduit=isset($_GET['ref_produit'])?$_GET['ref_produit']:"";
            $requete = "SELECT * FROM articles WHERE Article_code = '$idproduit'";
            $retours=$pdo->query($requete);
            $retour =$retours->fetch();
            $designation = $retour["Article_designation"];
            $qte = $retour["Article_Qte"];
            $unite = $retour["unite"];
            echo json_encode(array("designation"=>$designation,"quantite"=>$qte,"unite"=>$unite)); 

            //print($chaine);
            break;
            case "recup_unite":
                $idunite=isset($_GET['idunite'])?$_GET['idunite']:"";
                $requete = "SELECT * FROM unite_mesure WHERE id_unite = $idunite";
                $retours=$pdo->query($requete);
                $retour =$retours->fetch();
                //$chaine = $retour["Article_designation"]."|".$retour["Article_Qte"];
                $unitemesure = $retour["libelle"];
                //$qte = $retour["Article_Qte"];
                echo json_encode(array("unitemesu"=>$unitemesure)); 
    
                //print($chaine);
                break;

        case "facturer":
            $com_client=isset($_GET['ref_client'])?$_GET['ref_client']:1;
            $com_date = date('Y/m/d');
            $com_montant=isset($_GET['total_com'])?$_GET['total_com']:1;
            $texte_com=isset($_GET['chaine_com'])?$_GET['chaine_com']:"";
            $tab_com=explode('|',$texte_com);
            $monnaie = isset($_GET['commonnaie'])?$_GET['commonnaie']:"";
            $unitevente=isset($_GET['unitef'])?$_GET['unitef']:"";

            $requete = "INSERT INTO commandes(Com_client, Com_date, Com_montant,com_monnaie) VALUES (".$com_client.", '".$com_date."', ".$com_montant.",'".$monnaie."');";
            $retours=$pdo->query($requete);

            if($retours)
            {
                $detail_com = $pdo->lastInsertId();
                $tab_comarray = count($tab_com);
                for($ligne=0 ;$ligne<$tab_comarray ;$ligne++)
                {
                    if($tab_com[$ligne]!="")
                    {
                        $ligne_com = explode(';',$tab_com[$ligne]);
                        $requete = "INSERT INTO detail(Detail_com, Detail_ref, Detail_qte,unitevent,puht,detail_monnaie) VALUES (".$detail_com.", '".$ligne_com[0]."', ".$ligne_com[1].", '".$ligne_com[2]."', ".$ligne_com[4].",'".$monnaie."');";
                        $retours = $pdo->query($requete);
                        $requete = "UPDATE articles SET Article_Qte=Article_Qte-".$ligne_com[1]." WHERE Article_code='".$ligne_com[0]."';";
                        $retours = $pdo->query($requete);
                    }
                }
                echo json_encode(array("clientnum"=>$com_client,"detailcom"=>$detail_com)); 
             }
             else
             print("nok");
            break;

            case "charger_client":
                $requete = "SELECT Client_num,CONCAT( Client_nom,' ', Client_prenom ) AS client,email,telephone,adresse,reseausocial FROM clients ORDER BY Client_num";
                $resultatclient=$pdo->query($requete);
               
                $client = array();
                //Récupérer les lignes
                while($retour = $resultatclient->fetch()){
                    array_push($client,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("client"=>($client))); 
            break;
    
            case "charger_produit":                      
                $requete = "SELECT Article_code,Article_designation FROM articles ORDER BY Article_code;";
                $resultatP=$pdo->query($requete);
                $produits = array();
                
                //Récupérer les lignes
                while($retour = $resultatP->fetch()){
                    array_push($produits,$retour);              
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("produit"=>($produits)));
            break;
            case "charger_unite":                      
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
    }
}

?>
