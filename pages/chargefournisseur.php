<?php

require_once('identifier.php');
require_once('connexiondb.php');

$utilisateur=$_SESSION['user']['roles'];
$nom = isset($_GET['nom'])?$_GET['nom']:"";
$civilite = isset($_GET['civilite'])?$_GET['civilite']:"";
$prenom = isset($_GET['prenom'])?$_GET['prenom']:"";
$email = isset($_GET['email'])?$_GET['email']:"";
$telephone= isset($_GET['telephone'])?$_GET['telephone']:"";
$adresse= isset($_GET['adresse'])?$_GET['adresse']:"";
$reseausocial= isset($_GET['reseausocial'])?$_GET['reseausocial']:"";

   if(isset($_GET["param"]))
    {
        switch($_GET["param"])
        {
            case "tous":               
                $requete= "SELECT * FROM fournisseur";
                $resultate=$pdo->query($requete);
            
                $fournisseurs = array();
                 //Récupérer les lignes
                while($retour = $resultate->fetch()){
                   array_push($fournisseurs,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("fourniss"=>($fournisseurs),"user"=>$utilisateur));             
                break;
            case "parnom":
               
                $requete= "SELECT * FROM fournisseur WHERE nom LIKE '%$nom%'  OR prenom LIKE '%$nom%'";
                $resultate=$pdo->query($requete);
                              
                $fournisseurs = array();
                 //Récupérer les lignes
                while($retour = $resultate->fetch()){
                   array_push($fournisseurs,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("fourniss"=>($fournisseurs),"user"=>$utilisateur));             
            break;  

            case "suppression":               
                $idf=isset($_GET['idf'])?$_GET['idf']:0;

                $requete="DELETE FROM fournisseur WHERE idf=?";
                $params=array($idf);
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
    
                $requete= "INSERT INTO fournisseur(civilite,nom,prenom,email,telephone,adresse,reseausocial) VALUES (?,?,?,?,?,?,?)";
                $params=array($civilite,$nom,$prenom,$email,$telephone,$adresse,$reseausocial);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
            break; 

            case "modifier":
                $idf=isset($_GET['idf'])?$_GET['idf']:0;
                $requete="select * from fournisseur where idf=$idf";
                $resultat=$pdo->query($requete);
                $fournisseur=$resultat->fetch();
                $nom=$fournisseur['nom'];
                $prenom=$fournisseur['prenom'];
                $email=$fournisseur['email'];
                $telephone=$fournisseur['telephone'];
                $adresse=$fournisseur['adresse'];
                $reseausocial=$fournisseur['reseausocial'];
                $civilite=$fournisseur['civilite'];
                 
                $nom=isset($_GET['nom'])?$_GET['nom']:"";
                $prenom=isset($_GET['prenom'])?$_GET['prenom']:"";
                $email=isset($_GET['email'])?$_GET['email']:"";
                $telephone=isset($_GET['telephone'])?$_GET['telephone']:"";
                $reseausocial=isset($_GET['reseausocial'])?$_GET['reseausocial']:"";
                $adresse=isset($_GET['adresse'])?$_GET['adresse']:"";
                $civilite=isset($_GET['civilite'])?$_GET['civilite']:"Monsieur";
    
                $requete="UPDATE fournisseur SET civilite=?,nom=?,prenom=?,email=?,telephone=?,reseausocial=?,adresse=? WHERE idf=?";
                $params=array($civilite,$nom,$prenom,$email,$telephone,$reseausocial,$adresse,$idf);
                $resultat= $pdo->PREPARE($requete);
                $resultat->execute($params);
                 echo json_encode(array("nom"=>($nom),"prenom"=>$prenom,
                 "email"=>$email,"telephone"=>$telephone,"adresse"=>$adresse,
                 "reseausocial"=>$reseausocial,"civilite"=>$civilite));             
 
                 break;

            case "chargerchampmodifier":
                $idf=isset($_GET['idf'])?$_GET['idf']:0;
                $requete="SELECT * FROM fournisseur WHERE idf=$idf";
                $resultat=$pdo->query($requete);
                $fournisseur=$resultat->fetch();
                $nom=$fournisseur['nom'];
                $prenom=$fournisseur['prenom'];
                $email=$fournisseur['email'];
                $telephone=$fournisseur['telephone'];
                $adresse=$fournisseur['adresse'];
                $reseausocial=$fournisseur['reseausocial'];
                $civilite=$fournisseur['civilite'];
       
                $requete="SELECT DISTINCT civilite FROM fournisseur";
                $resultatf=$pdo->query($requete);

                $civilites = array();
                //Récupérer les lignes
                while($retour = $resultatf->fetch()){
                    array_push($civilites,$retour);
                }
      
                echo json_encode(array("civilites"=>($civilites),"nom"=>$nom,"prenom"=>$prenom,
                "email"=>$email,"telephone"=>$telephone,"adresse"=>$adresse,
                "reseausocial"=>$reseausocial,"civilite"=>$civilite));                   
                break;     
      }      
    }

?>