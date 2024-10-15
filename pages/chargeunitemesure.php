<?php

require_once('identifier.php');
require_once('connexiondb.php');
$utilisateur=$_SESSION['user']['roles'];
$libelle= isset($_GET['libelle'])?$_GET['libelle']:"";

   if(isset($_GET["param"]))
    {
        switch($_GET["param"])
        {
            case "tous":               
                $selectiondetouteslesunites= "SELECT * FROM unite_mesure";
                $resultattoutesunites=$pdo->query($selectiondetouteslesunites);

                $unites = array();
                 //Récupérer les lignes
                while($retour = $resultattoutesunites->fetch()){
                   array_push($unites,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("unites"=>($unites),"user"=>$utilisateur));            
                break;
            case "parlibelle":
                $selectionparlibelle="SELECT * FROM unite_mesure WHERE libelle LIKE '%$libelle%'";
                $resultatparlibelle=$pdo->query($selectionparlibelle);
                 
                $unites = array();
                     //Récupérer les lignes
                while($retour = $resultatparlibelle->fetch()){
                    array_push($unites,$retour);
                }
                    //Afficher le tableau au format JSON              
                    echo json_encode(array("unites"=>($unites),"user"=>$utilisateur));            
                break;  

            case "suppression":  
                $idunite=isset($_GET['idunite'])?$_GET['idunite']:0;
                             
                $supprimerunite="DELETE FROM unite_mesure WHERE id_unite=?";
                $uniteparams=array($idunite);
                $resultatsupprimerunite= $pdo->prepare($supprimerunite);
                $resultatsupprimerunite->execute($uniteparams);                        
            break;

            case "inserer":
                $libelle= isset($_GET['nouvellibel'])?$_GET['nouvellibel']:"";
                
                $requete= "INSERT INTO unite_mesure(libelle) VALUES (?)";
                $params=array($libelle);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
            break;

            case "modifier":
                $idlibelle = isset($_GET['idunite'])?$_GET['idunite']:"";              
                $libel= isset($_GET['libelleedit'])?$_GET['libelleedit']:"";                
                $requete="UPDATE unite_mesure SET libelle=? WHERE  id_unite=?";
                $params=array($libel,$idlibelle);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);             
                break;

            case "chargerchampmodifier":
                $idlibelle= isset($_GET['idunite'])?$_GET['idunite']:"";
                $requete="SELECT * FROM unite_mesure WHERE id_unite=$idlibelle";
                $resultat=$pdo->query($requete);
                $unites=$resultat->fetch();
                $libelleunite = $unites['libelle']; 
                echo json_encode(array("libelleunit"=>($libelleunite)));      
            break;   
      }      
    }

?>