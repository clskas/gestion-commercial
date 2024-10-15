<?php
require_once('identifier.php');
require_once('connexiondb.php');

$nom = isset($_GET['nom'])?$_GET['nom']:"";
$civilite = isset($_GET['civilite'])?$_GET['civilite']:"";
$prenom = isset($_GET['prenom'])?$_GET['prenom']:"";
$email = isset($_GET['email'])?$_GET['email']:"";
$telephone= isset($_GET['telephone'])?$_GET['telephone']:"";
$adresse= isset($_GET['adresse'])?$_GET['adresse']:"";
$reseausocial= isset($_GET['reseausocial'])?$_GET['reseausocial']:"";
$size=isset($_GET['size'])?$_GET['size']:6;
$page=isset($_GET['page'])?$_GET['page']:1;
$offset=($page-1)*$size;

$requete= "SELECT * FROM fournisseur WHERE nom LIKE '%$nom%' LIMIT $size OFFSET $offset";

$requeteCount="SELECT COUNT(*) countf FROM fournisseur WHERE nom LIKE '%$nom%'";

$resultf=$pdo->query($requete);

$resultatCount= $pdo->query($requeteCount);

$tabCount= $resultatCount->fetch();
$nbrfounisseurs=$tabCount['countf'];

$reste=$nbrfounisseurs % $size;
if($reste===0)
    $nbrPage=$nbrfounisseurs/$size;
else
    $nbrPage=floor($nbrfounisseurs/$size)+1;
?>

<! DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Gestion des fournisseurs</title>
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
            Recherche des fournisseurs...
        </div>
        <div class="panel-body">
            <form action="fournisseurs.php" method="get" class="form-inline" id="supprimerfournisseur">
                <div class="form-group">
                    <input type="text" name="nom" placeholder="Taper le nom du fournisseur" class="form-control" value="<?php echo $nom; ?>"/>
                </div>

                <input type="text" id="param" name="param" style="visibility:hidden;" />
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-search"></span>
                    Rechercher...
                </button>
                &nbsp  &nbsp <!--Pour espacement-->
                <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                    <a href="nouveaufournisseur.php">
                        <span class="glyphicon glyphicon-plus"></span>
                        Nouveau fournisseur
                    </a>
                <?php } ?>

            </form>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            Liste des fournisseurs (<?php echo $nbrfounisseurs ?> fournisseurs)
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>
                        Id Fournisseur
                    </th>
                    <th>
                        Civilité
                    </th>

                    <th>
                        Nom Fournisseur
                    </th>
                    <th>
                        Prenom Fournisseur
                    </th>

                    <th>
                        Numero téléphone
                    </th>

                    <th>
                        Réseaux sociaux
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Adresse
                    </th>
                    <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                        <th>
                            Action
                        </th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>

                <?php while($fournisseurs=$resultf->fetch()){ ?>
                    <tr>  
                        <td><?php echo $fournisseurs['idf']; ?></td>
                        <td><?php echo $fournisseurs['civilite']; ?></td>
                        <td><?php echo $fournisseurs['nom']; ?></td>
                        <td><?php echo $fournisseurs['prenom']; ?></td>
                        <td><?php echo $fournisseurs['telephone']; ?></td>
                        <td><?php echo $fournisseurs['reseausocial']; ?></td>
                        <td><?php echo $fournisseurs['email']; ?></td>
                        <td><?php echo $fournisseurs['adresse']; ?></td>
                        <?php if($_SESSION['user']['roles']=='ADMIN') { ?>

                            <td>

                                <a href="editerfournisseurs.php?idf=<?php echo $fournisseurs['idf'] ?>">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                &nbsp;
                                <a  onclick="document.getElementById('param').value='supprimer';return confirm('Etes-vous sûr de vouloir supprimer ce fournisseur ?');supprimerfournisseur()" href="supprimerfournisseur.php?idf=<?php echo $fournisseurs['idf'] ?>">
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
                        <li class="<?php if($i==$page) echo 'active';?>"> <a href="fournisseurs.php?page=<?php echo $i; ?>&nom=<?php echo $nom ?>">
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
