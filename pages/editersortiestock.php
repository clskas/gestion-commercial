<?php
require_once('identifier.php');
require_once('connexiondb.php');
$idSS=isset($_GET['idsortiestock'])?$_GET['idsortiestock']:0;
$requeteSS="SELECT * FROM sortie_stock WHERE id_sortie=$idSS";
$resultatSS=$pdo->query($requeteSS);
$sortiestock=$resultatSS->fetch();
$idarticle=$sortiestock['id_article'];
$quantitesortie=$sortiestock['quantite_sortie'];
$datesortie=$sortiestock['date_sortie'];
$observation=$sortiestock['observation'];

$requeteP="select * from produits";
$resultatP=$pdo->query($requeteP);
?>

<! DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Editer Sortie-stock</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
</head>
<body>
<?php include("menu.php"); ?>

<div class="container">


    <div class="panel panel-primary margetop60">
        <div class="panel-heading">
            Edition Sortie stock
        </div>
        <div class="panel-body">
            <form action="updatesortiestock.php" method="post" class="form-inline" >

                <div class="form-group">
                    <label for="idSS">Numero entré-stock : <?php echo $idSS ?></label>
                    <input type="hidden" name="idSS" class="form-control" value="<?php echo $idSS ?>"/>
                </div>
                
                <div class="form-group largeur100">
                    <label for="idproduit">Produit</label>
                    <select name="idproduit" class="form-control" id="idproduit">
                        <?php while($produit=$resultatP->fetch()){?>
                            <option value="<?php echo $produit['ref_produit'] ?>"
                                <?php if($idarticle===$produit['ref_produit']) echo "selected" ?> >
                                <?php echo $produit['designation_produit'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group largeur100">
                    <label for="quantitesortie">Quantité</label>
                    <input type="number" name="quantitesortie" placeholder="Quantité"
                           class="form-control" value="<?php echo $quantitesortie ?>"/>
                </div>

                <div class="form-group largeur100">
                    <label for="datesortie">Date sortie</label>
                    <input type="text" name="datesortie"
                           class="form-control" value="<?php echo $datesortie ?>"/>
                </div>

                <div class="form-group largeur100">
                    <label for="observation">Observation</label>
                    <input type="text" name="observation"
                           class="form-control" value="<?php echo $observation ?>"/>
                </div>


                <button type="submit" class="btn btn-success margetop20">
                    <span class="glyphicon glyphicon-save"></span>
                    Modifier
                </button>

            </form>
        </div>
    </div>

</div>
</body>
</html>

