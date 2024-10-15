<?php

require_once('identifier.php');
require_once('connexiondb.php');

$utilisateur=$_SESSION['user']['roles'];
$nomentreprise = isset($_POST['nomentr'])?$_POST['nomentr']:"";
   if(isset($_POST["param"]))
    {
        switch($_POST["param"])
        {
            case "tous":               
                $requete= "SELECT * FROM entreprise";
                $resultate=$pdo->query($requete);
            
                $entreprises = array();
                 //Récupérer les lignes
                while($retour = $resultate->fetch()){
                   array_push($entreprises,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("entreprise"=>($entreprises),"user"=>$utilisateur));             
                break;
            case "parentreprise":              
                $requete= "SELECT * FROM entreprise WHERE nom_entreprise LIKE '%$nomentreprise%'";
                $resultate=$pdo->query($requete);                            
                $entreprises = array();
                //Récupérer les lignes
               while($retour = $resultate->fetch()){
                  array_push($entreprises,$retour);
               }
               //Afficher le tableau au format JSON              
               echo json_encode(array("entreprise"=>($entreprises),"user"=>$utilisateur));             
            break;  

            case "suppression":               
                $identreprise=isset($_POST['identreprise'])?$_POST['identreprise']:0; 
                $requete="DELETE FROM entreprise WHERE id_entreprise=?";
                $params=array($identreprise);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);            
            break;
            
            case "inserer":            
                $nomentreprise=isset($_POST['editnomentreprise'])?$_POST['editnomentreprise']:"";
                $adresse=isset($_POST['editadresseentreprise'])?$_POST['editadresseentreprise']:"";
                $identitenationale=isset($_POST['editidentitenationale'])?$_POST['editidentitenationale']:"";
                $telephone=isset($_POST['edittelephone'])?$_POST['edittelephone']:"";
                $emailentr=isset($_POST['editemailentre'])?$_POST['editemailentre']:"";
                $reseausocio=isset($_POST['editreseausocio'])?$_POST['editreseausocio']:"";
                 
               $nomPhoto=isset($_FILES['logo']['name'])?$_FILES['logo']['name']:"";
                $imageTemp=$_FILES['logo']['tmp_name'];
                move_uploaded_file($imageTemp,"../images/".$nomPhoto);
                
                $requete="INSERT INTO entreprise(nom_entreprise,adresse,identite_nationale,Telephone,emailentreprise,reseausocial,logo) values(?,?,?,?,?,?,?)";
                $params=array($nomentreprise,$adresse,$identitenationale,$telephone,$emailentr,$reseausocio,$nomPhoto);           
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params); 
            break; 

            case "modifier":
                $identreprise=isset($_POST['identreprise'])?$_POST['identreprise']:0;
                $nomentreprise=isset($_POST['nomentreprise'])?$_POST['nomentreprise']:"";
                $adresse=isset($_POST['adresseentreprise'])?$_POST['adresseentreprise']:"";
                $identitenationale=isset($_POST['identitenationale'])?$_POST['identitenationale']:"";
                $telephone=isset($_POST['telephoneeentreprise'])?$_POST['telephoneeentreprise']:"F";
                $emailentr=isset($_POST['emailentre'])?$_POST['emailentre']:"";
                $reseausocio=isset($_POST['reseausocio'])?$_POST['reseausocio']:"";
                $nomPhoto=isset($_FILES['photo']['name'])?$_FILES['photo']['name']:"";
                $imageTemp=$_FILES['photo']['tmp_name'];
                move_uploaded_file($imageTemp,"../images/".$nomPhoto);
                           
                if(!empty($nomPhoto))
                {
                    $requete="UPDATE entreprise SET nom_entreprise=?,adresse=?,identite_nationale=?,Telephone=?,emailentreprise=?,reseausocial=?,logo=? WHERE id_entreprise=?";
                    $params=array($nomentreprise,$adresse,$identitenationale,$telephone,$emailentr,$reseausocio,$nomPhoto,$identreprise);
                }
                else
                {
                    $requete="UPDATE entreprise SET nom_entreprise=?,adresse=?,identite_nationale=?,Telephone=?,emailentreprise=?,reseausocial=? WHERE id_entreprise=?";
                    $params=array($nomentreprise,$adresse,$identitenationale,$telephone,$emailentr,$reseausocio,$identreprise);
                }
                //$requete="UPDATE entreprise SET nom_entreprise=?,adresse=?,identite_nationale=?,Telephone=?,emailentreprise=?,reseausocial=?,logo=? WHERE id_entreprise=?";
               //$params=array($nomentreprise,$adresse,$identitenationale,$telephone,$emailentr,$reseausocio,$nomPhoto,$identreprise);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
                 break;

            case "chargerchampmodifier":
                $identreprise=isset($_POST['identreprise'])?$_POST['identreprise']:0;
                $requeteentreprise="SELECT * FROM entreprise WHERE id_entreprise=$identreprise";
                $resultatentreprise=$pdo->query($requeteentreprise);
                $entreprise=$resultatentreprise->fetch();
                $nomentreprise=$entreprise['nom_entreprise'];  
                $adresse=$entreprise['adresse'];
                $identitenationale=$entreprise['identite_nationale'];
                $telephone=$entreprise['Telephone'];
                $emailentreprise=$entreprise['emailentreprise'];
                $reseausocial=$entreprise['reseausocial'];
                $nomPhoto=$entreprise['logo'];
           
                echo json_encode(array("nomentreprise"=>$nomentreprise,"adresseentreprise"=>$adresse,
                "idn"=>$identitenationale,"email"=>$emailentreprise,"telephone"=>$telephone,
                "reseausocial"=>$reseausocial,"logo"=>$nomPhoto));                    
                break;     
      }      
    }

?>