<?php
    
    require_once('identifier.php');
    require_once('connexiondb.php');

?>

<! DOCTYPE HTML>
<html>
    <head>
        <title>Gestion des utilisateurs</title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">  
        <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">-->   
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
        <link rel="stylesheet" type="text/css"  href="../css/font-awesome.min.css">
        <script src="../js/jquery-3.5.1.min.js"></script>              
        <script src="../js/facturationstock.js"></script>
        <script src="../js/sweetalert.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>   
        <script src="../js/pagination/jquery.twbsPagination.min.js"></script> 
    </head>
    <body>
        <?php include("menu.php"); ?>
        <div class="container">
            <div class="flex-container">
                <div>1</div>
                <div>2</div>
                <div>3</div>  
                <div>4</div>              
            </div>

            <div class="flex-container">
                <div style="order: 3">1</div>
                <div style="order: 2">2</div>
                <div style="order: 4">3</div>
                <div style="order: 1">4</div>
            </div>

            <div class="flex-container">
                <div style="flex-grow: 1">1</div>
                <div style="flex-grow: 1">2</div>
                <div style="flex-grow: 8">3</div>
            </div>
            <!--La flex-shrinkpropriété spécifie dans quelle mesure un élément flexible sera réduit par rapport au reste des éléments flexibles. -->
            <!--Ne laissez pas le troisième élément flexible rétrécir autant que les autres éléments flexibles: -->
            <div class="flex-container">
                <div>1</div>
                <div>2</div>
                <div style="flex-shrink: 0">3</div>
                <div>4</div>
                <div>5</div>               
            </div>

            <!-- Rendre le troisième élément flexible non extensible (0), non rétrécissable (0) et avec une longueur initiale de 200 pixels: -->

            <div class="flex-container">
                <div>1</div>
                <div>2</div>
                <div style="flex: 0 0 200px">3</div>
                <div>4</div>
            </div>

            <!-- La align-selfpropriété spécifie l'alignement de l'élément sélectionné à l'intérieur du conteneur flexible.

La align-self propriété remplace l'alignement par défaut défini par la align-itemspropriété du conteneur .
Alignez le troisième élément flexible au milieu du conteneur: -->
            <div class="flex-container">
                <div>1</div>
                <div>2</div>
                <div style="align-self: center">3</div>
                <div>4</div>
            </div>
            <!--  Alignez le deuxième élément flexible en haut du conteneur et le troisième élément flexible en bas du conteneur: -->
            <div class="flex-container">
                <div >
                  <ul class="navbar-nav mr-auto nav-tabs">           
                    <li class="dropdown nav-item active">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Produits
                        </a>
                    
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="nouveauproduit.php">Ajouter produit</a>
                            <a class="dropdown-item" href="produitsnew.php">Rapport sur les produits</a>                 
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="fournisseursnew.php">Fournisseurs</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="clientnew.php">Clients</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="historiqueapprovisionnement.php">Entre stock</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="paiement.php">Paiement facture</a>
                    </li>

                    <li class="nav-item">
                        <a
                        class="nav-link" href="facturation.php">Vente</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="depense.php">Dépense</a>
                    </li>
                    <!-- <li><a href="convertisseurmonnaie.php">Convertisseur de Monnaie</a></li>
                    <li><a href="entreprise.php">Entreprise</a></li>-->                 
                    <li class="nav-item">
                        <a class="nav-link" href="utilisateursnew.php">Utilisateurs</a>
                    </li>

                    <li class="dropdown nav-item">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Autres
                        </a>
                    
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="convertisseurmonnaie.php">Convertisseur de monnaie</a>
                            <a class="dropdown-item" href="entreprise.php">Entreprise</a>  
                            <a class="dropdown-item" href="conceptionfacture.php">dashbo</a>               
                        </div>
                    </li>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                            
                    <li class="nav-item">
                    <a class="nav-link" href="editerUtilisateur.php?id=<?php echo $_SESSION['user']['iduser'] ?>"><i class="glyphicon glyphicon-user"> </i><?php echo ' '.$_SESSION['user']['logins'] ?> </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="seDeconnecter.php"><i class="glyphicon glyphicon-log-out"> </i>&nbsp Se deconnecter</a>
                    </li>
              
              </ul> 
                </div>
                <div style="align-self: flex-start">2</div>
                <div style="align-self: flex-end; height:350px;">3</div>
                <div style="align-self: flex-start">autre</div>
                <div>4</div>
            </div>
        </div>



<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: Arial;
}

.header {
  text-align: center;
  padding: 32px;
}

.row {
  display: flex;
  flex-wrap: wrap;
  padding: 0 4px;
}

/* Create four equal columns that sits next to each other */
.column {
  flex: 25%;
  max-width: 25%;
  padding: 0 4px;
}

.column img {
  margin-top: 8px;
  vertical-align: middle;
}

/* Responsive layout - makes a two column-layout instead of four columns */
@media (max-width: 800px) {
  .column {
    flex: 50%;
    max-width: 50%;
  }
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media (max-width: 600px) {
  .column {
    flex: 100%;
    max-width: 100%;
  }
}
</style>
<body>

<!-- Header -->
<div class="header">
  <h1>Responsive Image Grid</h1>
  <p>Resize the browser window to see the responsive effect.</p>
</div>

<!-- Photo Grid -->
<div class="row"> 
  <div class="column">
    <img src="/w3images/wedding.jpg" style="width:100%">
    <img src="/w3images/rocks.jpg" style="width:100%">
    <img src="/w3images/falls2.jpg" style="width:100%">
    <img src="/w3images/paris.jpg" style="width:100%">
    <img src="/w3images/nature.jpg" style="width:100%">
    <img src="/w3images/mist.jpg" style="width:100%">
    <img src="/w3images/paris.jpg" style="width:100%">
  </div>
  
  <div class="column">
    <img src="/w3images/underwater.jpg" style="width:100%">
    <img src="/w3images/ocean.jpg" style="width:100%">
    <img src="/w3images/wedding.jpg" style="width:100%">
    <img src="/w3images/mountainskies.jpg" style="width:100%">
    <img src="/w3images/rocks.jpg" style="width:100%">
    <img src="/w3images/underwater.jpg" style="width:100%">
  </div> 
   
  <div class="column">
    <img src="/w3images/wedding.jpg" style="width:100%">
    <img src="/w3images/rocks.jpg" style="width:100%">
    <img src="/w3images/falls2.jpg" style="width:100%">
    <img src="/w3images/paris.jpg" style="width:100%">
    <img src="/w3images/nature.jpg" style="width:100%">
    <img src="/w3images/mist.jpg" style="width:100%">
    <img src="/w3images/paris.jpg" style="width:100%">
  </div>
  
  <div class="column">
    <img src="/w3images/underwater.jpg" style="width:100%">
    <img src="/w3images/ocean.jpg" style="width:100%">
    <img src="/w3images/wedding.jpg" style="width:100%">
    <img src="/w3images/mountainskies.jpg" style="width:100%">
    <img src="/w3images/rocks.jpg" style="width:100%">
    <img src="/w3images/underwater.jpg" style="width:100%">
  </div>

  <div class="row">
    <div class="col-sm-4 bg-primary">.col-sm-4</div>
    <div class="col-sm-8 bg-success">.col-sm-8</div>
  </div>
</div>
    </body>
</html>

