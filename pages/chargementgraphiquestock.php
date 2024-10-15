<?php
header('Content-Type: application/json');
require_once('identifier.php');
require_once('connexiondb.php');

//$utilisateur=$_SESSION['user']['roles'];
//$designation= isset($_GET['designation'])?$_GET['designation']:"";
$selectionnertout="SELECT * FROM articles ORDER BY Article_code";
$resultate=$pdo->query($selectionnertout);
           
$data = array();
 //Récupérer les lignes
 $data = array();
 foreach ($resultate as $row) {
     $data[] = $row;
 }
//Afficher le tableau au format JSON                          
echo json_encode($data);

?>