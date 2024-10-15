<?php

require_once('identifier.php');
require_once('connexiondb.php');

/*$utilisateur=$_SESSION['user']['roles'];
$numerofact= isset($_GET['numfacture'])?$_GET['numfacture']:0;*/
$designation= isset($_GET['designation'])?$_GET['designation']:"";

if(isset($_GET["param"]))
{
        switch($_GET["param"])
        {
            case "tous":               
                $selectionnertout="SELECT * FROM articles";
                $resultate=$pdo->query($selectionnertout);
                           
                $statestock = array();
                 //Récupérer les lignes
                while($retour = $resultate->fetch()){
                   array_push($statestock,$retour);
                }
                //Afficher le tableau au format JSON              
                //echo json_encode(array("paie"=>($paiment))); 
                echo json_encode(array("etatstocke"=>($statestock)));             
            
                break;
            case "parproduit":
               
                $selectionnertout="SELECT * FROM articles WHERE Article_designation LIKE '%$designation%' ";
                $resultate=$pdo->query($selectionnertout);
               
                $statestock = array();
                //Récupérer les lignes
               while($retour = $resultate->fetch()){
                  array_push($statestock,$retour);
               }
               //Afficher le tableau au format JSON              
               //echo json_encode(array("paie"=>($paiment))); 
               echo json_encode(array("etatstocke"=>($statestock)));              
            break;
                          
      }      
}

?>