
<?php
/*session_start();
if(!isset($_SESSION['user']))
    header('location:login.php');*/
require_once('identifier.php');
//include("connexiondb.php");//Incude veut dire copier coller le code ecrit dans le fichier connexiondb
// require("connexiondb.php");//il lit le code du fichier de connexiondb et l'execute ici
require_once('connexiondb.php');// il nous permet de creer l'objet qui nous permet de nous connecter à la base de données

$idproduit= isset($_GET['idproduit'])?$_GET['idproduit']:1;
$datesortie= isset($_GET['datesortie'])?$_GET['datesortie']:"";
$datedebut= isset($_GET['datedebut'])?$_GET['datedebut']:"";
$datefin= isset($_POST['datefin'])?$_POST['datefin']:"";
$quantitesortie= isset($_GET['quantitesortie'])?$_GET['quantitesortie']:0;
$observation= isset($_GET['observation'])?$_GET['observation']:"";

$size=isset($_GET['size'])?$_GET['size']:6;
$page=isset($_GET['page'])?$_GET['page']:1;
$offset=($page-1)*$size;


/*
 var input = prompt("Saisissez un réel:");
input = input.replace(',', '.');

var reel = parseFloat(input);

alert(reel + "* 2 = " + (reel * 2));
 */


/*
 SELECT tArticles.tArticlePK, SUM(tEntrees.EntreeQuant)-SUM(tSorties.SortieQuant) AS Stock
FROM tArticles, tEntrees, tSorties
WHERE tArticles.tArticlesPK=tSorties.tSortiesFK
AND tArticles.tArticlesPK=tEntrees.tArticlesFK
GROUP BY tArticlePK
 */

/*SELECT tArticles.tArticlePK, Nz(Sum([EntreeQuant]),0)-Nz(Sum([SortieQuant]),0) AS Stock
FROM (tArticles LEFT JOIN tEntrees ON tArticles.tArticlePK = tEntrees.tArticlesFK) LEFT JOIN tSorties ON tArticles.tArticlePK = tSorties.tArticlesFK
GROUP BY tArticles.tArticlePK;*/

//Selection de toutes les entrées en stock
$selectionnertout="SELECT * FROM sortie_stock";
/*$selectionnertout="SELECT id_entre,idf,CONCAT( nom,' ', prenom ) as fournisseurs,ref_produit,
    designation_produit,numero_facture,quantite_entre,
     puht,date_entre,observation FROM entre_stock as es,fournisseur as f,produits as p WHERE
     es.id_fournisseur=f.idf AND es.id_article=p.ref_produit LIMIT $size OFFSET $offset";*/
//SELECT * FROM table WHERE nom_colonne BETWEEN 'valeur1' AND 'valeur2'

/*$selectionnerpardate="SELECT * FROM entre_stock WHERE date_entre='$dateentre'";
$resultate=$pdo->query($selectionnerpardate);*/
/*$param=array($dateentre);
$resultatpardate= $pdo->prepare($selectionnerpardate);
$resultate=$resultatpardate->execute($param);*/

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


$requeteCount="SELECT COUNT(*) countep FROM sortie_stock ";


$resultate=$pdo->query($selectionnertout);

$resultatCount= $pdo->query($requeteCount);

$tabCount= $resultatCount->fetch();
$nbrsortiestock=$tabCount['countep'];

$reste=$nbrsortiestock % $size; // % est l'operateur module qui est le reste de la division euclidienne de $nbrFiliere par $size
if($reste===0)  // $nbrFiliere est donc multiple de $size
    $nbrPage=$nbrsortiestock/$size;
else
    $nbrPage=floor($nbrsortiestock/$size)+1; // floor est une fonction qui retourne la partie entrière d'un nombre decimal



?>

<! DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Gestion de sortie des produits en stock</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <script src="../js/jquery-3.3.1.js"></script>
    <script src="../js/monjs.js"></script>
</head>
<body>
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success margetop">
        <div class="panel-heading">
            Recherche sur les sorties en stock ...
        </div>
        <div class="panel-body">
            <form action="entrestock.php" method="get" class="form-inline">


                <div class="form-group" name="toutes" id="toutes">
                    <input type="text" name="designation" id="designation" placeholder="Saisir la designation du produit"
                           class="form-control" value="<?php echo $idproduit; ?>"/>
                </div>

                <div class="form-group" name="pardate" id="pardate">
                    <label>Date</label>
                    <input type="date" name="date" id="date" />
                </div>

                <div class="form-group" name="parperiode" id="parperiode">
                    <label>Date Début</label>
                    <input type="date" name="datedebut" id="datedebut" />
                    <label>Date Fin</label>
                    <input type="date" name="datefin" id="datefin" />
                </div>


                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-search"></span>
                    Rechercher...
                </button>
                &nbsp  &nbsp <!--Pour espacement-->
                <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                    <a href="nouvellesortie.php">
                        <span class="glyphicon glyphicon-plus"></span>
                        Nouvelle sortie
                    </a>
                <?php } ?>

            </form>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            Liste des sorties (<?php echo $nbrsortiestock ?> Sortie stock)
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>
                        Id sortie
                    </th>

                    <th>
                        Designation produit
                    </th>

                    <th>
                        Quantité sortie
                    </th>

                    <th>
                        Date sortie
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

                <?php while($sorties=$resultate->fetch()){ ?>
                    <tr>
                        <td><?php echo $sorties['id_sortie']; ?></td>
                        <td><?php echo $sorties['id_article']; ?></td>
                        <td><?php echo $sorties['quantite_sortie']; ?></td>
                        <td><?php echo $sorties['date_sortie']; ?></td>
                        <td><?php echo $sorties['observation']; ?></td>

                        <?php if($_SESSION['user']['roles']=='ADMIN') { ?>

                            <td>

                                <a href="editersortiestock.php?idsortiestock=<?php echo $sorties['id_sortie'] ?>">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                &nbsp;
                                <a  onclick="return confirm('Etes-vous sûr de vouloir supprimer cet enregistrement ?')" href="supprimersortiestock.php?idsortiestock=<?php echo $sorties['id_sortie'] ?>">
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
                        <li class="<?php if($i==$page) echo 'active';?>"> <a href="sortiestock.php?page=<?php echo $i; ?>">
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


