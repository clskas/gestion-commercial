
<?php
require_once('identifier.php');

require_once('connexiondb.php');

$idproduit= isset($_GET['idproduit'])?$_GET['idproduit']:"";
$idfournisseur= isset($_GET['idfournisseur'])?$_GET['idfournisseur']:1;
$dateentre= isset($_GET['dateentre'])?$_GET['dateentre']:"";
$datedebut= isset($_POST['datedebut'])?$_POST['datedebut']:"";
$datefin= isset($_POST['datefin'])?$_POST['datefin']:"";
$quantiteentre= isset($_GET['quantiteentre'])?$_GET['quantiteentre']:0;
$observation= isset($_GET['observation'])?$_GET['observation']:"";
$numerofacture= isset($_GET['numerofacture'])?$_GET['numerofacture']:"";
$prixuht=isset($_GET['prixuht'])?$_GET['prixuht']:0;

$size=isset($_GET['size'])?$_GET['size']:6;
$page=isset($_GET['page'])?$_GET['page']:1;
$offset=($page-1)*$size;

//Selection de toutes les entrées en stock
//$selectionnertout="SELECT * FROM entre_stock";

$selectionnertout="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) AS fournisseurs,ref_produit,designation_produit,numero_facture,quantite_entre,puht,date_entre,observation,id_article FROM entre_stock AS es,fournisseur AS f,produits AS p WHERE es.id_fournisseur=f.idf AND es.id_article=p.ref_produit";
/*$selectionnerparperiode="SELECT * FROM entre_stock WHERE date_entre BETWEEN $datedebut AND $datefin";
$param=array($datedebut,$datefin);
$resultatparperiode= $pdo->prepare($selectionnerparperiode);
$resultatparperiode->execute($params);*/

/*$selectionnerpardate= "SELECT id_entre,idf,CONCAT( nom,' ', prenom ) as fournisseurs,ref_produit,
    designation_produit,numero_facture,quantite_entre,
     puht,date_entre,observation FROM entre_stock as es,fournisseur as f,produits as p WHERE
     es.id_fournisseur=f.idf AND es.id_article=p.ref_produit es.date_entre=? LIMIT $size OFFSET $offset";

$param=array($dateentre);
$resultatpardate= $pdo->prepare($selectionnerpardate);
$resultate=$resultatpardate->execute($param);*/


$requeteCount="SELECT COUNT(*) countep FROM entre_stock ";


$resultate=$pdo->query($selectionnertout);

$resultatCount= $pdo->query($requeteCount);

$tabCount= $resultatCount->fetch();
$nbrenstrestock=$tabCount['countep'];

$reste=$nbrenstrestock % $size; // % est l'operateur module qui est le reste de la division euclidienne de $nbrFiliere par $size
if($reste===0)  // $nbrFiliere est donc multiple de $size
    $nbrPage=$nbrenstrestock/$size;
else
    $nbrPage=floor($nbrenstrestock/$size)+1; // floor est une fonction qui retourne la partie entrière d'un nombre decimal



?>

<! DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Gestion des entrées en stock</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
        <script src="../js/jquery-3.3.1.js"></script>
        <script src="../js/monjs.js"></script>
        <script src="../js/verifyform.js"></script>
        <script src="../js/prototype.js"></script>
</head>
<body>
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success margetop">
        <div class="panel-heading">
            Ajout, Modification et Suppression des approvisionnements...
            &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
                   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
                   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
                   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   
				   <input type="button" value="X" style="height:20px;font-size:12px;background-color:red;" onclick="" />
        </div>
        <div class="panel-body">
            <form action="entrestock.php" method="get" class="form-inline">           
                <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                    <a href="nouvellentree.php">
                        <span class="glyphicon glyphicon-plus"></span>
                        Nouvelle entrée
                    </a>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <a href="etatsto.php">
                       Etat de Stock
                    </a>
                                     
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <a href="historiqueapprovisionnement.php">
                       Historique approvisionnement                      
                    </a>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <a href="graphiquestock.php">
                       Graphique stock
                    </a>
                <?php } ?>

            </form>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
           Liste des produits (<?php echo $nbrenstrestock ?> Entrées stock)
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>
                        Numero facture
                    </th>
                    <th>
                        Fournisseur
                    </th>
                    <th>
                        Designation produit
                    </th>

                    <th>
                        Quantité entrée
                    </th>

                    <th>
                        Date entrée
                    </th>
                    <th>
                        puht
                    </th>

                    <th>
                        Observation
                    </th>

                    <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                        <th>
                            Action
                        </th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>

                <?php while($entrees=$resultate->fetch()){ ?>
                    <tr>
                        <td><?php echo $entrees['numero_facture']; ?></td>
                        <td><?php echo $entrees['fournisseurs']; ?></td>
                        <td><?php echo $entrees['designation_produit']; ?></td>
                        <td><?php echo $entrees['quantite_entre']; ?></td>
                        <td><?php echo $entrees['date_entre']; ?></td>
                        <td><?php echo $entrees['puht']; ?></td>
                        <td><?php echo $entrees['observation']; ?></td>
                        <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                            <td>
                                <a href="editerentrestock.php?identrestock=<?php echo $entrees['id_entre'] ?>&ancienproduit=<?php echo $entrees['id_article'] ?>&ancienqte=<?php echo $entrees['quantite_entre'] ?>">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                &nbsp;
                                <a  onclick="return confirm('Etes-vous sûr de vouloir supprimer cet approvisionnement ?')" href="supprimerentrestock.php?identrestock=<?php echo $entrees['id_entre'] ?>&ancienproduit=<?php echo $entrees['id_article'] ?>&ancienqte=<?php echo $entrees['quantite_entre'] ?>">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
            <div>
                <ul class="pagination">
                    <?php for($i=1; $i<=$nbrPage;$i++){?>
                        <li class="<?php if($i==$page) echo 'active';?>"> <a href="entrestock.php?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>

