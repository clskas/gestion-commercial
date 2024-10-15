<?php
require_once('identifier.php');
require_once('connexiondb.php');
$designation = isset($_GET['designation'])?$_GET['designation']:"";
 
if(isset($_GET["param"]))
{
    switch($_GET["param"])
    {
        case "tous":
            $requete="SELECT * FROM articles";
            $resultatetatstock = $pdo->query($requete);
            $etatstoc = array();
            //Récupérer les lignes
            while($retour = $resultatetatstock->fetch()){
                array_push($etatstoc,$retour);
            }
            //Afficher le tableau au format JSON              
            echo json_encode(array("etatstocke"=>($etatstoc))); 
        break;

        case "produit":
            $requete= "SELECT * FROM articles WHERE Article_designation LIKE '%$designation%'";
            $resultatetatstock=$pdo->query($requete);
            $etatstoc = array();
            //Récupérer les lignes
            while($retour = $resultatetatstock->fetch()){
                array_push($etatstoc,$retour);
            }
            //Afficher le tableau au format JSON              
            echo json_encode(array("etatstocke"=>($etatstoc)));
        break;
    }
}

?>