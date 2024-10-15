<?php

require_once('identifier.php');
require_once('connexiondb.php');
$utilisateur=$_SESSION['user']['roles'];
$motif= isset($_GET['motif'])?$_GET['motif']:"";
$montant = isset($_GET['montant'])?$_GET['montant']:0;
$datedepense = isset($_GET['pdate'])?$_GET['pdate']:"";
$datedebut= isset($_GET['datedebut'])?$_GET['datedebut']:"";
$datefin= isset($_GET['datefin'])?$_GET['datefin']:"";

   if(isset($_GET["param"]))
    {
        switch($_GET["param"])
        {
            case "tous":
                $requete="SELECT * FROM depense ";               
                $resultatp=$pdo->query($requete);
                
                $requetesum="SELECT SUM(montant) AS montantdepense FROM depense WHERE monnaie='FC'";
                $resultatsum= $pdo->query($requetesum);
                $retoursum =$resultatsum->fetch();
                $depensesomme=$retoursum["montantdepense"];

                $requeteendollar ="SELECT SUM(montant) AS montantdepense FROM depense WHERE monnaie='$'";
                $resultatdollar= $pdo->query($requeteendollar);
                $retourdollar =$resultatdollar->fetch();
                $depensedollar = $retourdollar["montantdepense"];

                $depenses = array();
                 //Récupérer les lignes
                while($retour = $resultatp->fetch()){
                   array_push($depenses,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("depense"=>($depenses),"sommedollar"=>$depensedollar,"sommefranc"=>$depensesomme,
                "utilisateur"=>$utilisateur));             
                break;
            case "pardate":
               
                $requete="SELECT * FROM depense WHERE date_depense = '$datedepense'"; 
                $resultatp=$pdo->query($requete);
                
                $requetesum="SELECT SUM(montant) AS montantdepense FROM depense WHERE date_depense = '$datedepense'";
                $resultatsum= $pdo->query($requetesum);
                $retoursum =$resultatsum->fetch();               
                $depensesomme=$retoursum["montantdepense"];
                
                $depenses = array();
                 //Récupérer les lignes
                while($retour = $resultatp->fetch()){
                   array_push($depenses,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("depense"=>($depenses),"somme"=>$depensesomme,"utilisateur"=>$utilisateur));             
                break;
        case "datedebut":
            if(isset($_GET['datefin']))
            {

                $requete="SELECT * FROM depense WHERE date_depense BETWEEN '$datedebut' AND '$datefin'";
                $resultatp=$pdo->query($requete);
                
                $requetesum="SELECT SUM(montant) AS montantdepense FROM depense WHERE date_depense BETWEEN '$datedebut' AND '$datefin'";
                $resultatsum= $pdo->query($requetesum);
                $retoursum =$resultatsum->fetch();
                $depensesomme=$retoursum["montantdepense"];
                
                $depenses = array();
                 //Récupérer les lignes
                while($retour = $resultatp->fetch()){
                   array_push($depenses,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("depense"=>($depenses),"somme"=>$depensesomme,"utilisateur"=>$utilisateur));             
 
            }              
                break;
        case "motif":         
            $requete="SELECT * FROM depense WHERE motif LIKE '%$motif%'";
            $resultatp=$pdo->query($requete);
             
            $requetesum="SELECT SUM(montant) AS montantdepense FROM depense WHERE motif LIKE '%$motif%'";
            $resultatsum= $pdo->query($requetesum);
            $retoursum =$resultatsum->fetch();
            $depensesomme=$retoursum["montantdepense"]; 
             
             $depenses = array();
              //Récupérer les lignes
             while($retour = $resultatp->fetch()){
                array_push($depenses,$retour);
             }
             //Afficher le tableau au format JSON              
             echo json_encode(array("depense"=>($depenses),"somme"=>$depensesomme,"utilisateur"=>$utilisateur));             
            break;

            case "suppression":               
                $iddepense = isset($_GET['iddepense'])?$_GET['iddepense']:0;
                $requete="DELETE FROM depense WHERE id_depense=?";
                $params=array($iddepense);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params); 
                //header('location:depense.php');             
            break;

            case "inserer":
                $motif= isset($_GET['motif'])?$_GET['motif']:"";
                $montant = isset($_GET['montant'])?$_GET['montant']:0;                     
                $datedepense = date('Y/m/d');
                $monnaie = isset($_GET['monnaie'])?$_GET['monnaie']:"";
            
                $requete= "INSERT INTO depense(motif,montant,date_depense,monnaie) VALUES (?,?,?,?)";
                $params=array($motif,$montant,$datedepense,$monnaie);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
                //print("ok");
            break;

            case "modifier":
               $iddepense=isset($_GET['iddepense'])?$_GET['iddepense']:0;
                $requete="SELECT * FROM depense WHERE id_depense=$iddepense";
                $resultat=$pdo->query($requete);
                $depenses=$resultat->fetch();
                $motif = $depenses['motif'];
                $montant = $depenses['montant'];
                $datedep = $depenses['date_depense'];             
                $motif= isset($_GET['motif'])?$_GET['motif']:"";
                $montant = isset($_GET['montant'])?$_GET['montant']:0;
                $datedepense = isset($_GET['datedep'])?$_GET['datedep']:date('Y/m/d');
                $monnaie = isset($_GET['monnaie'])?$_GET['monnaie']:"";
                
                $requete="UPDATE depense SET motif=?,montant=?,date_depense=?,monnaie=? WHERE id_depense=?";
                $params=array($motif,$montant,$datedepense,$monnaie,$iddepense);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
                echo json_encode(array("motif"=>($motif),"montant"=>$montant,"datedepense"=>$datedep));             

                break;

            case "chargerchampmodifier":
                $iddepense=isset($_GET['iddepense'])?$_GET['iddepense']:0;
                $requete="SELECT * FROM depense WHERE id_depense=$iddepense";
                $resultat=$pdo->query($requete);
                $depenses=$resultat->fetch();
                $motif = $depenses['motif'];
                $montant = $depenses['montant'];
                $datedep = $depenses['date_depense'];
                $monnaie=$depenses['monnaie'];
   
                echo json_encode(array("motif"=>($motif),"montant"=>$montant,"datedepense"=>$datedep,
                "monnaie"=>$monnaie));             
    
            break; 
                            
      }      
    }

?>