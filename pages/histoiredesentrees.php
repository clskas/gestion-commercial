<?php
require_once('identifier.php');

require_once('connexiondb.php');

$idproduit= isset($_GET['designation'])?$_GET['designation']:"";
$idfournisseur= isset($_GET['idfournisseur'])?$_GET['idfournisseur']:1;
$dateentre= isset($_GET['pdate'])?$_GET['pdate']:date('d/m/Y');
$datedebut= isset($_GET['datedebut'])?$_GET['datedebut']:"";
$datefin= isset($_GET['datefin'])?$_GET['datefin']:"";
$quantiteentre= isset($_GET['quantiteentre'])?$_GET['quantiteentre']:0;
$observation= isset($_GET['observation'])?$_GET['observation']:"";
$numerofacture= isset($_GET['numerofacture'])?$_GET['numerofacture']:"";
$prixuht=isset($_GET['prixuht'])?$_GET['prixuht']:0;

$size=isset($_GET['size'])?$_GET['size']:6;
$page=isset($_GET['page'])?$_GET['page']:1;
$offset=($page-1)*$size;


if(isset($_POST["param"]))
{
    switch($_POST["param"])
    {
        case "tous":   
            $selectionnertout = "SELECT id_entre,idf,CONCAT( nom,' ', prenom ) AS fournisseurs,ref_produit,designation_produit,numero_facture,quantite_entre,puht,date_entre,observation FROM entre_stock AS es,fournisseur AS f,produits AS p WHERE es.id_fournisseur=f.idf AND es.id_article=p.ref_produit";
    
            //$selectionnertout="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) AS fournisseurs,ref_produit,designation_produit,numero_facture,quantite_entre,puht,date_entre,observation FROM entre_stock AS es,fournisseur AS f,produits AS p WHERE es.id_fournisseur=f.idf AND es.id_article=p.ref_produit LIMIT $size OFFSET $offset";
            $resultate = $pdo->query($selectionnertout);
            $retour = $resultate->fetch();
            $chaines = $retour["id_entre"]."|".$retour["idf"]."|".$retour["fournisseurs"]."|".$retour["ref_produit"]."|".$retour["designation_produit"]."|".$retour["numero_facture"]."|".$retour["quantite_entre"]."|".$retour["puht"]."|".$retour["date_entre"]."|".$retour["observation"];
            
            $requeteCount="SELECT COUNT(*) countep FROM entre_stock ";
            $resultatCount= $pdo->query($requeteCount);
            
            $tabCount= $resultatCount->fetch();
            $nbrenstrestock=$tabCount['countep'];

            $reste=$nbrenstrestock % $size; 
            if($reste===0)  
            {
                $nbrPage=$nbrenstrestock/$size;
            }               
            else
            {
                $nbrPage=floor($nbrenstrestock/$size)+1;
            }
            print($chaines);
           
            //print($nbrenstrestock);
            break;
        case "produit":
            $selectionnertout="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) AS fournisseurs,ref_produit,
            designation_produit,numero_facture,quantite_entre,
             puht,date_entre,observation FROM entre_stock AS es,fournisseur AS f,produits AS p WHERE
             es.id_fournisseur=f.idf AND es.id_article=p.ref_produit AND p.designation_produit LIKE '%$idproduit%' LIMIT $size OFFSET $offset";
            $resultate=$pdo->query($selectionnertout);

            $retour =$resultate->fetch();
            $chaine = $retour["id_entre"]."|".$retour["idf"]."|".$retour["fournisseurs"]
            ."|".$retour["ref_produit"]."|".$retour["designation_produit"]
            ."|".$retour["numero_facture"]."|".$retour["quantite_entre"]
            ."|".$retour["puht"]."|".$retour["date_entre"]."|".$retour["observation"];

            $requeteCount="SELECT COUNT(*) countep,designation_produit FROM entre_stock AS es,fournisseur AS f,
            produits AS p WHERE
            es.id_fournisseur=f.idf AND es.id_article=p.ref_produit AND p.designation_produit LIKE '%$idproduit%' ";
            $resultatCount= $pdo->query($requeteCount);
            
            $tabCount= $resultatCount->fetch();
            $nbrenstrestock=$tabCount['countep'];

            $reste=$nbrenstrestock % $size; 
            if($reste===0) 
            {
                $nbrPage=$nbrenstrestock/$size;
                print($nbrPage);
            }               
            else
            {
                $nbrPage=floor($nbrenstrestock/$size)+1;
                print($nbrPage);
            }
               
            print($chaine);
            
            break;
        case "pardate":
            $selectionnertoutpardate="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) as fournisseurs,ref_produit,
            designation_produit,numero_facture,quantite_entre,
             puht,date_entre,observation FROM entre_stock as es,fournisseur as f,produits as p WHERE
             es.id_fournisseur=f.idf AND es.id_article=p.ref_produit AND es.date_entre = '$dateentre' LIMIT $size OFFSET $offset";
             $resultate=$pdo->query($selectionnertoutpardate);

             $retour =$resultate->fetch();
             $chaine = $retour["id_entre"]."|".$retour["idf"]."|".$retour["fournisseurs"]
             ."|".$retour["ref_produit"]."|".$retour["designation_produit"]
             ."|".$retour["numero_facture"]."|".$retour["quantite_entre"]
             ."|".$retour["puht"]."|".$retour["date_entre"]."|".$retour["observation"];
 
             $requeteCount="SELECT COUNT(*) countep FROM entre_stock AS es,fournisseur AS f,
             produits AS p WHERE
             es.id_fournisseur=f.idf AND es.id_article=p.ref_produit AND es.date_entre = '$dateentre' ";
             $resultatCount= $pdo->query($requeteCount);
             
             $tabCount= $resultatCount->fetch();
             $nbrenstrestock=$tabCount['countep'];
 
             $reste=$nbrenstrestock % $size; 
             if($reste===0) 
             {
                 $nbrPage=$nbrenstrestock/$size;
                 print($nbrPage);
             }               
             else
             {
                 $nbrPage=floor($nbrenstrestock/$size)+1;
                 print($nbrPage);
             }
                
             print($chaine);                        
            break;
        case "parperiode":
            $selectionnerparperiode="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) as fournisseurs,ref_produit,
            designation_produit,numero_facture,quantite_entre,
             puht,date_entre,observation FROM entre_stock as es,fournisseur as f,produits as p WHERE
             es.id_fournisseur=f.idf AND es.id_article=p.ref_produit AND (es.date_entre BETWEEN '$datedebut' AND '$datefin') LIMIT $size OFFSET $offset";
                 $resultate=$pdo->query($selectionnerparperiode);
    
                 $retour =$resultate->fetch();
                 $chaine = $retour["id_entre"]."|".$retour["idf"]."|".$retour["fournisseurs"]
                 ."|".$retour["ref_produit"]."|".$retour["designation_produit"]
                 ."|".$retour["numero_facture"]."|".$retour["quantite_entre"]
                 ."|".$retour["puht"]."|".$retour["date_entre"]."|".$retour["observation"];
     
                 $requeteCount="SELECT COUNT(*) countep FROM entre_stock AS es,fournisseur AS f,
                 produits AS p WHERE
                 es.id_fournisseur=f.idf AND es.id_article=p.ref_produit AND (es.date_entre BETWEEN '$datedebut' AND '$datefin') ";
                 $resultatCount= $pdo->query($requeteCount);
                 
                 $tabCount= $resultatCount->fetch();
                 $nbrenstrestock=$tabCount['countep'];
     
                 $reste=$nbrenstrestock % $size; 
                 if($reste===0) 
                 {
                     $nbrPage=$nbrenstrestock/$size;
                     print($nbrPage);
                 }               
                 else
                 {
                     $nbrPage=floor($nbrenstrestock/$size)+1;
                     print($nbrPage);
                 }
                    
                 print($chaine);                        
            break;
    }
}

?>