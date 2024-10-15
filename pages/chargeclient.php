<?php

require_once('identifier.php');
require_once('connexiondb.php');

$utilisateur=$_SESSION['user']['roles'];
$nom = isset($_GET['nom'])?$_GET['nom']:"";
$civilite = isset($_GET['Client_civilite'])?$_GET['Client_civilite']:"";
$prenom = isset($_GET['Client_prenom'])?$_GET['Client_prenom']:"";
$email = isset($_GET['email'])?$_GET['email']:"";
$telephone= isset($_GET['telephone'])?$_GET['telephone']:"";
$adresse= isset($_GET['adresse'])?$_GET['adresse']:"";
$reseausocial= isset($_GET['reseausocial'])?$_GET['reseausocial']:"";

   if(isset($_GET["param"]))
    {
        switch($_GET["param"])
        {
            case "tous":               
                $requete= "SELECT * FROM clients";
                $resultate=$pdo->query($requete);
            
                $clients = array();
                 //Récupérer les lignes
                while($retour = $resultate->fetch()){
                   array_push($clients,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("client"=>($clients),"user"=>$utilisateur));             
                break;
            case "parnom":
               
                $requete= "SELECT * FROM clients WHERE Client_nom LIKE '%$nom%' OR Client_prenom LIKE '%$nom%'";
                $resultate=$pdo->query($requete);
                              
                $clients = array();
                 //Récupérer les lignes
                while($retour = $resultate->fetch()){
                   array_push($clients,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("client"=>($clients),"user"=>$utilisateur));             
            break;  

            case "suppression":               
                $idC=isset($_GET['idC'])?$_GET['idC']:0;
      
                $requete="DELETE FROM clients WHERE Client_num=?";
                $params=array($idC);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);             
            break;
            
            case "inserer":
                $nom=isset($_GET['nom'])?$_GET['nom']:"";
                $prenom=isset($_GET['prenom'])?$_GET['prenom']:"";
                $email=isset($_GET['email'])?$_GET['email']:"";
                $telephone=isset($_GET['telephone'])?$_GET['telephone']:"";
                $reseausocial=isset($_GET['reseausocial'])?$_GET['reseausocial']:"";
                $adresse=isset($_GET['adresse'])?$_GET['adresse']:"";
                $civilite=isset($_GET['civilite'])?$_GET['civilite']:"Monsieur";

                $requete= "INSERT   INTO clients(Client_civilite,Client_nom,Client_prenom,email,telephone,adresse,reseausocial) VALUES (?,?,?,?,?,?,?)";
                $params=array($civilite,$nom,$prenom,$email,$telephone,$adresse,$reseausocial);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
            break; 

            case "modifier":
                $idc=isset($_GET['idC'])?$_GET['idC']:0;
                $requete="select * from clients where Client_num=$idc";
                $resultat=$pdo->query($requete);
                $client=$resultat->fetch();
                $nom=$client['Client_nom'];
                $prenom=$client['Client_prenom'];
                $email=$client['email'];
                $telephone=$client['telephone'];
                $adresse=$client['adresse'];
                $reseausocial=$client['reseausocial'];
                $civilite=$client['Client_civilite'];
                 
                $idC=isset($_GET['idC'])?$_GET['idC']:0;
                $nom=isset($_GET['nom'])?$_GET['nom']:"";
                $prenom=isset($_GET['prenom'])?$_GET['prenom']:"";
                $email=isset($_GET['email'])?$_GET['email']:"";
                $telephone=isset($_GET['telephone'])?$_GET['telephone']:"";
                $reseausocial=isset($_GET['reseausocial'])?$_GET['reseausocial']:"";
                $adresse=isset($_GET['adresse'])?$_GET['adresse']:"";
                $civilite=isset($_GET['civilite'])?$_GET['civilite']:"Monsieur";

                $requete="UPDATE clients SET Client_civilite=?,Client_nom=?,Client_prenom=?,email=?,telephone=?,adresse=?,reseausocial=? WHERE CLient_num=?";
                $params=array($civilite,$nom,$prenom,$email,$telephone,$adresse,$reseausocial,$idC);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
                 echo json_encode(array("nom"=>($nom),"prenom"=>$prenom,
                 "email"=>$email,"telephone"=>$telephone,"adresse"=>$adresse,
                 "reseausocial"=>$reseausocial,"civilite"=>$civilite));             
 
                 break;

            case "chargerchampmodifier":
                $idc=isset($_GET['idC'])?$_GET['idC']:0;
                $requete="SELECT * FROM clients WHERE Client_num=$idc";
                $resultat=$pdo->query($requete);
                $client=$resultat->fetch();
                $nom=$client['Client_nom'];
                $prenom=$client['Client_prenom'];
                $email=$client['email'];
                $telephone=$client['telephone'];
                $adresse=$client['adresse'];
                $reseausocial=$client['reseausocial'];
                $civilite=$client['Client_civilite'];

                $requete="SELECT DISTINCT Client_civilite FROM clients";
                $resultatc=$pdo->query($requete);

                $civilites = array();
                //Récupérer les lignes
                while($retour = $resultatc->fetch()){
                    array_push($civilites,$retour);
                }
      
                echo json_encode(array("civilites"=>($civilites),"nom"=>$nom,"prenom"=>$prenom,
                "email"=>$email,"telephone"=>$telephone,"adresse"=>$adresse,
                "reseausocial"=>$reseausocial,"civilite"=>$civilite));                    
                break;     
      }      
    }

?>