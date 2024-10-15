<?php
header('Content-Type: application/json');
require_once('identifier.php');
require_once('connexiondb.php');

$idproduit= isset($_GET['designation'])?$_GET['designation']:"";
$nomprenom= isset($_GET['client'])?$_GET['client']:1;
$dateentre= isset($_GET['pdate'])?$_GET['pdate']:"";
$datedebut= isset($_GET['datedebut'])?$_GET['datedebut']:"";
$datefin= isset($_GET['datefin'])?$_GET['datefin']:"";

   if(isset($_GET["param"]))
    {
        switch($_GET["param"])
        {
            case "tous":
               
                $selectionnertout="SELECT Article_designation,SUM(Detail_qte) AS Detail_qte FROM detail AS det,
                clients AS cl,articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code 
                AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num GROUP BY a.Article_designation";
                $resultate = $pdo->query($selectionnertout);
                        
                $data = array();
                //Récupérer les lignes
                $data = array();
                foreach ($resultate as $row) {
                    $data[] = $row;
                }            
                echo json_encode($data);
                break;
            case "pardate":
                               
                $selectionnertout="SELECT Article_designation,SUM(Detail_qte) AS Detail_qte FROM detail AS det,
                clients AS cl,articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code 
                AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num
                AND c.Com_date = '$dateentre' GROUP BY a.Article_designation";
                $resultate = $pdo->query($selectionnertout);
                        
                $data = array();
                //Récupérer les lignes
                $data = array();
                foreach ($resultate as $row) {
                    $data[] = $row;
                }            
                echo json_encode($data);             
                break;
        case "datedebut":
            if(isset($_GET['datefin']))
            {                              
                $selectionnertout="SELECT Article_designation,SUM(Detail_qte) AS Detail_qte FROM detail AS det,
                clients AS cl,articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code 
                AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num
                AND (c.Com_date BETWEEN '$datedebut' AND '$datefin') GROUP BY a.Article_designation";
                $resultate = $pdo->query($selectionnertout);
                        
                $data = array();
                //Récupérer les lignes
                $data = array();
                foreach ($resultate as $row) {
                    $data[] = $row;
                }            
                echo json_encode($data);
            }           
                break;
        case "parproduit":          
                $selectionnertout="SELECT Article_designation,SUM(Detail_qte) AS Detail_qte FROM detail AS det,
                clients AS cl,articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code 
                AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num
                AND a.Article_designation = '$idproduit' GROUP BY a.Article_designation";
                $resultate = $pdo->query($selectionnertout);
                        
                $data = array();
                //Récupérer les lignes
                $data = array();
                foreach ($resultate as $row) {
                    $data[] = $row;
                }            
                echo json_encode($data);            
            break;

        case "produitpardate":   
            if(isset($_GET['pdate']))
            {               
                $selectionnertout="SELECT Article_designation,SUM(Detail_qte) AS Detail_qte FROM detail AS det,
                clients AS cl,articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code 
                AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num
                AND a.Article_designation = '$idproduit' AND c.Com_date = '$dateentre' 
                GROUP BY a.Article_designation";
                $resultate = $pdo->query($selectionnertout);
                        
                $data = array();
                //Récupérer les lignes
                $data = array();
                foreach ($resultate as $row) {
                    $data[] = $row;
                }            
                echo json_encode($data);             
            }            
                           
            break;

        case "parclient":                             
                $selectionnertout="SELECT Article_designation,SUM(Detail_qte) AS Detail_qte 
                FROM detail AS det,
                clients AS cl,articles AS a,commandes AS c WHERE det.Detail_ref=a.Article_code 
                AND det.Detail_com=c.Com_num AND c.Com_client=cl.Client_num
                AND (cl.Client_nom LIKE '%$nomprenom%' OR cl.Client_prenom  LIKE '%$nomprenom%') 
                GROUP BY a.Article_designation";
                $resultate = $pdo->query($selectionnertout);
                        
                $data = array();
                //Récupérer les lignes
                $data = array();
                foreach ($resultate as $row) {
                    $data[] = $row;
                }            
                echo json_encode($data);              
        break;
           
      }      
    }

?>