<?php
require_once('identifier.php');
require_once('connexiondb.php');
?>
<! DOCTYPE HTML>
<html>
    <head>
        <title>Gestion de facturation</title>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">                               
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
        <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../css/fontawesome.min.css">
        <script src="../js/jquery-3.5.1.min.js"></script>              
        <script src="../js/facturationstock.js"></script>
        <script src="../js/sweetalert.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/pagination/jquery.twbsPagination.min.js"></script>
    </head>
    <body>
        <?php include("menu.php"); ?>
        <div class="container ">

            <div class="panel panel-success margetop ">

                <div class="panel-heading bg-primary">
                    Nouvelle vente           
                </div>
                <div class="div_int_page">
                    <div style="width:100%;display:block;text-align:center;"></div>
                    <div class="div_saut_ligne" style="height:30px;"></div>
                    <div style="float:left;width:10%;height:40px;"></div>
                    <div style="float:left;width:10%;height:40px;"></div>
                    <div class="div_saut_ligne" style="height:30px;"></div>
                    <div style="float:left;width:10%;height:350px;"></div>
                    <div style="float:left;width:80%;height:350px;text-align:center;" >
                        <form method="GET" class="form-inline" >
                            <div style="width:10%;height:50px;float:left;"></div>
                            <div style="width:35%;height:50px;float:left;font-size:20px;font-weight:bold;text-align:left;color:#a13638;">
                                <u>Informations du client</u><br />
                            </div>
                            <div style="width:10%;height:50px;float:left;"></div>
                            <div style="width:35%;height:50px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                                <a href="nouveauclient.php">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Nouveau client
                                </a>
                                &nbsp  &nbsp <!--Pour espacement-->
                                &nbsp  &nbsp <!--Pour espacement-->
                                &nbsp  &nbsp <!--Pour espacement-->                                                                                           
                                <a href="historiquedevente.php">                                   
                                    Historique de vente
                                </a>
                            </div> 
                            <div style="width:10%;height:50px;float:left;"></div>
                            <div style="width:10%;height:75px;float:left;"></div>
                            <div style="width:15%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                                 <div class="form-group largeur100"> 
                                    <div>
                                        <label>Client</label>
                                        <select name="ref_client" class="form-control" id="ref_client" 
                                            onchange="document.getElementById('param').value='recup_client';recolter();"
                                            onfocus="document.getElementById('param').value='charger_client';recolter();">
                                            <option value="0">Choisissez le client</option>                                                                                                                                                                                                              
                                        </select>
                                    </div>
                                        &nbsp  &nbsp <!--  Pour espacement <option value="0">Choisir client</option>-->                                  
                                    <div >
                                        <label>Civilité</label>
                                        <input type="text" id="civilite" name="civilite" class="form-control" disabled/>
                                    </div>
                                    &nbsp  &nbsp <!--Pour espacement-->                               
                                    <div>
                                        <label>Nom du client</label>
                                        <input type="text" id="nom_client" name="nom_client" class="form-control" disabled/>
                                    </div>
                                    &nbsp  &nbsp <!--Pour espacement-->                               
                                    <div >
                                        <label>Prénom du client</label>
                                        <input type="text" id="prenom_client" name="prenom_client" class="form-control" disabled/>
                                    </div>
                                </div> 
                            <div style="width:10%;height:75px;float:left;"></div>
                            <div class="div_saut_ligne" style="height:5px;"></div>
                            <div style="width:10%;height:50px;float:left;"></div>
                            <div style="width:80%;height:50px;float:left;font-size:20px;font-weight:bold;text-align:left;color:#a13638;">
                                <u>Ajout des produits commandés</u><br />
                            </div>
                            <div style="width:10%;height:50px;float:left;"></div>
                            <div style="width:10%;height:75px;float:left;"></div>
                            <div class="form-group largeur100">
								<div>
									<label>Réf Produit</label>
									<select id="ref_produit" class="form-control" name="ref_produit"  
										onchange="document.getElementById('param').value='recup_article';recolter();"
										onfocus="document.getElementById('param').value='charger_produit';recolter();">                                             
										<option value="0">Choisissez le produit</option> 
									</select>
								</div>
								&nbsp  &nbsp <!--  onfocus="document.getElementById('param').value='charger_produit';recolter();"  Pour espacement--> 
								<div >
									<label>Qté en stock</label>
									<input type="text" class="form-control"  id="qte" name="qte" disabled style="text-align:right;" />
								</div>
								&nbsp  &nbsp <!--Pour espacement-->
								&nbsp  &nbsp <!--Pour espacement-->
								&nbsp  &nbsp <!--Pour espacement--> 
								<input type="radio" id="comfc" name="commonnaie" value="FC"/>                     
								<label for="fc">Fc</label>
								&nbsp  &nbsp <!--Pour espacement-->
								&nbsp  &nbsp <!--Pour espacement-->
								&nbsp  &nbsp <!--Pour espacement-->                              
								<input type="radio" id="comdollar" name="commonnaie" value="$"/>                      
								<label for="dollar">$</label>  
								&nbsp  &nbsp <!--Pour espacement-->
								&nbsp  &nbsp <!--Pour espacement-->
								&nbsp  &nbsp <!--Pour espacement-->                                   
                            </div>
                             <div class="form-group largeur100">
								<div >
									<label>Désignation du produit</label>
									<input type="text" class="form-control"  id="designation" name="designation" disabled />
								</div>
								&nbsp  &nbsp <!--Pour espacement--> 
								<div >
									<label> Qté commandée</label>
									<!--<input type="hidden" class="form-control"  id="unitmesure" name="unitmesure" />--> 
									<input type="text" class="form-control"  id="qte_commande" name="qte_commande" />
									<label for="idunitefacture">Unités</label>
									<select name="idunitefacture" class="form-control" id="idunitefacture" 
									onfocus="document.getElementById('param').value='charger_unite';
									recolter();">  
									<option value="0">Choisissez unité</option>                  
									</select> 
								</div>
								&nbsp  &nbsp <!--Pour espacement--> 
								<div>
									<label>Prix unitaire HT</label>
									<input type="text" class="form-control"  id="puht" name="puht"  style="text-align:right;" />
								</div>
								&nbsp  &nbsp <!--Pour espacement--> 
								<div >
									<label> Total commande</label>
									<input type="text" class="form-control"  id="total_commande" name="total_commande" disabled />                                       
								</div>
                            </div> 
                            <div class="form-group marginleft">
                                <div >
                                    <input type="button" class="btn btn-info"  
                                    id="ajouter" name="ajouter" value="Ajouter" onclick="plus_com();" 
                                    data-toggle="tooltip" data-placement="top" title="Ajout de produit à la facture!"/>
                                    <input type="text" id="param" name="param" style="visibility:hidden;" />
                                </div>                                                                   
                                <div>
                                    <input type="button" class="btn btn-success"  id="valider" 
                                    data-toggle="tooltip" data-placement="top" title="Enregistrement de la facture!"
                                    name="valider" value="Enregistrer" onclick="document.getElementById('param').value='facturer';verifiermonnaie();"/>
                                    <input type="text"  id="chaine_com" name="chaine_com" style="visibility:hidden;" />
                                    <input type="text"  id="total_com" name="total_com" style="visibility:hidden;" />
                                </div>          
                            </div>
                            <div style="width:10%;height:75px;float:left;"></div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="panel panel-primary">

                <div style="float:left;width:80%;height:auto;text-align:center;">
                    <div class="titre_h1" style="float:left;height:auto;width:100%;">
                        <div style="float:left;width:5%;height:25px;"></div>
                        <div style="width:10%;height:25px;float:left;font-size:16px;font-weight:bold;text-align:left;">
							Code article
						</div>                   
						<div style="width:30%;height:25px;float:left;font-size:16px;font-weight:bold;text-align:left;overflow:hidden;">
							Désignation
						</div>
						<div style="width:10%;height:25px;float:left;font-size:16px;font-weight:bold;text-align:left;">
							Quantité
						</div>
						<div style="width:10%;height:25px;float:left;font-size:16px;font-weight:bold;text-align:left;">
							Unité
						</div>
						<div style="width:10%;height:25px;float:left;font-size:16px;font-weight:bold;text-align:right;">
							PUHT
						</div>
						<div style="width:10%;height:25px;float:left;font-size:16px;font-weight:bold;text-align:right;">
							PTHT
						</div>
                        <div style="float:left;width:5%;height:25px;"></div>
                        <div style="float:left;width:100%;height:auto;" id="det_com">
                            <div class="bord"></div>
                            <div class="suite">
								B001
							</div>                                    
							<div class="des">
								Chaise roulante
							</div>
							<div class="suite">
								10
							</div>
						   <div class="suite">
								unite
							</div>
							<div class="prix">
								12.9
							</div>
							<div class="prix" style="font-weight:bold;">
								1243.75
							</div>
                            <div class="bord"></div>
                        </div>
                        <div style="float:left;width:10%;height:auto;"></div>
                        <div id="editer"></div>
                    </div>
                </div>
                <div style="float:left;width:10%;height:auto;"></div>
                <div class="div_saut_ligne" style="height:30px;">
                </div>
                </div>
            </div>
        </div>
    </body>
</html>