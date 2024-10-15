<?php
    require_once('identifier.php');
?>
<div class="container-fluid">
<nav  class="navbar navbar-expand-sm bg-dark navbar-dark bg-company-red " >
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
       
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto nav-tabs">           
                <li class="dropdown nav-item ">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Produits
                    </a>
                
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="nouveauproduit.php">Ajouter produit</a>
                        <a class="dropdown-item" href="produitsnew.php">Rapport sur les produits</a>                 
                    </div>
                </li>

                <li class="dropdown nav-item ">
                    <?php if($_SESSION['user']['roles']=='ADMIN' || $_SESSION['user']['roles']=='Magasinier') {?>
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Fournisseurs                       
                        </a>               
                    <?php } ?> 
                
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="nouveaufournisseur.php">Ajout fournisseur</a>
                        <a class="dropdown-item" href="fournisseursnew.php">Rapport sur les fournisseurs</a>                 
                    </div>
                </li>

                <li class="dropdown nav-item ">
                
                    <?php if($_SESSION['user']['roles']=='ADMIN' || $_SESSION['user']['roles']=='vendeur') {?>
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Clients
                        </a>               
                    <?php } ?> 
                
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="nouveauclient.php" data-anijs="if: mouseover, do: swing animated">Nouveau client</a>
                        <a class="dropdown-item" href="clientnew.php">Visualisation des clients enregistrés</a>                 
                    </div>
                </li>

                <li class="dropdown nav-item ">
                    <?php if($_SESSION['user']['roles']=='ADMIN' || $_SESSION['user']['roles']=='Magasinier') {?>
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Approvisionnement
                        </a>               
                    <?php } ?> 
                
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="nouvellentree.php">Nouvel approvisionnement</a>
                        <a class="dropdown-item" href="historiqueapprovisionnement.php">Rapport sur les approvisionnements</a>                 
                        <a class="dropdown-item" href="unitedemesure.php">Les unités de mesure</a>                 
                    </div>
                </li>

                <li class="dropdown nav-item">
                    <?php if($_SESSION['user']['roles']=='ADMIN' || $_SESSION['user']['roles']=='caissier') {?>
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Gestion paiement
                        </a>               
                    <?php } ?> 
                                        
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="nouveaupaiement.php">Nouveau paiement</a>
                        <a class="dropdown-item" href="paiement.php">Historique de paiement</a>                        
                    </div>
                </li>

                <li class="dropdown nav-item ">
                
                    <?php if($_SESSION['user']['roles']=='ADMIN' || $_SESSION['user']['roles']=='vendeur') {?>
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gestion Vente
                        </a>               
                    <?php } ?> 
                
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="facturation.php">Nouvelle vente</a>
                        <a class="dropdown-item" href="historiquedevente.php">Historique de vente</a>                 
                        <a class="dropdown-item" href="nouveauclient.php">Nouveau client</a>                 
                    </div>
                </li>

                <li class="dropdown nav-item">
                    <?php if($_SESSION['user']['roles']=='ADMIN' || $_SESSION['user']['roles']=='caissier') {?>
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dépense                       
                        </a>               
                    <?php } ?> 
                                        
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="nouvelledepense.php">Nouvelle dépense</a>
                        <a class="dropdown-item" href="depense.php">Rapport sur les dépenses</a>                        
                    </div>
                </li>
                <!-- <li><a href="convertisseurmonnaie.php">Convertisseur de Monnaie</a></li>
                <li><a href="entreprise.php">Entreprise</a></li>--> 
                <li class="dropdown nav-item">
                    <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             Utilisateurs
                        </a>              
                    <?php } ?> 
                                        
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="nouvelUtilisateur.php">Ajout utilisateur</a>
                        <a class="dropdown-item" href="utilisateursnew.php">Rapport sur les utilisateurs</a>                        
                    </div>
                </li>                
               
                <li class="dropdown nav-item">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Autres
                    </a>
                
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="convertisseurmonnaie.php">Convertisseur de monnaie</a>
                        <a class="dropdown-item" href="entreprise.php">Entreprise</a> 
			            <a class="dropdown-item" href="nouveauentreprise.php">Nouvelle entreprise</a> 
                        <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                            <a class="dropdown-item" href="dashboad.php">
                            Tableau de bord
                            </a>               
                        <?php } ?> 
                    </div>
                </li>
                &nbsp  &nbsp <!--Pour espacement-->                                                           
                <li class="nav-item">
                <a class="nav-link" href="editerUtilisateur.php?id=<?php echo $_SESSION['user']['iduser'] ?>"><i class="glyphicon glyphicon-user"> </i><?php echo ' '.$_SESSION['user']['logins'] ?> </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="seDeconnecter.php"><i class="glyphicon glyphicon-log-out"> </i>&nbsp Se deconnecter</a>
                </li>
            
            </ul> 
        </div>      
</nav>
</div>