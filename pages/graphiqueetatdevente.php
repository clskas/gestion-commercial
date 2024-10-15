<?php

require_once('identifier.php');
require_once('connexiondb.php');
?>
<!DOCTYPE >
<html>
<head>
<title>Graphique sur l'etat de stock</title>
    <title>Graphique sur la vente</title>   
    <meta charset="utf-8"> 
    <meta  name="viewport" content="width=device-width, initial-scale=1">       
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <script src="../js/jquery-3.5.1.min.js"></script>              
    <script src="../js/facturationstock.js"></script>
    <script src="../js/sweetalert.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Chart.min.js"></script>
    <script src="../js/chartjs-plugin-datalabels.js"></script>
    <script src="../js/pagination/jquery.twbsPagination.min.js"></script>   
</head>
<body onload="desactivertoutegraphique();document.getElementById('param').value='tous';showGraph();">

<div class="container">
    <div class="panel panel-success margetop">
            <div class="panel-heading">
                Recherche sur l'historique de vente ...
            </div>
            <div class="panel-body">
                <form  method="GET" class="form-inline">
            
                    <div class="form-group largeur100" >
                                    
                        <input type="radio" id="tous" name="recherchergraphiquevente" 
                            onclick="document.getElementById('param').value='tous';desactivertoutegraphique();" value="tous"/>
                        <label for="tous">Toutes les ventes</label>
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        
                        <input type="radio" id="produit" name="recherchergraphiquevente" 
                        value="produit"> 
                        <label for="produit">Par produit </label>
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        
                        &nbsp  &nbsp <!--Pour espacement-->

                        <input type="radio" id="pardate" name="recherchergraphiquevente"  
                        value="pardate"> 
                        <label for="pardate">Par date</label>
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->

                        <input type="radio" id="produitpardate" name="recherchergraphiquevente"  
                        value="produitpardate"> 
                        <label for="produitpardate">Produit par date</label>
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                                    
                        <input type="radio" id="parperiode" name="recherchergraphiquevente" 
                        value="parperiode"> 
                        <label for="parperiode">Par periode</label>  
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->  

                        <input type="radio" id="parclient" name="recherchergraphiquevente" 
                        value="parclient"> 
                        <label for="parclient">Par client</label>  
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->  

                        <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                                <a href="facturation.php">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Nouvelle vente
                                </a>
                            <?php } ?> 
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        <a href="graphiqueetatdevente.php">
                        Graphique vente
                        </a>
                        <input type="text" id="param" name="param" style="visibility:hidden;" />                        
                    </div>   
                        
                    <div class="form-group">
                        <input type="text" name="designation" id="designation" 
                            class="form-control" onblur="produitetclient();"/>
                    </div>

                    <div class="form-group"  >
                        <label>Date</label>
                        <input type="date" name="pdate" id="pdate" onblur="produitetdate();"/>
                    </div>

                    <div class="form-group" >
                        <label>Date Début</label>
                        <input type="date" name="datedebut" id="datedebut" onblur="document.getElementById('param').value='datedebut'"/>
                        <label>Date Fin</label>
                        <input type="date" name="datefin" id="datefin" />
                    </div>
                    <div>
                    </div>
                    <div style="width:25%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                        <button type="button" class="btn btn-success" id="recherchevente" name="recherche" value="Rechercher" style="margin-top:10px;" >
                            <span class="glyphicon glyphicon-search"></span> Rechercher...
                        </button>               
                    </div>  

                </form>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
            Quantité vendue : <label id="montantvendu"></label>
            </div>
            <div class="panel-body">
                <div id="chart-container">
                <canvas id="graphCanvas"></canvas>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>


<script>
    $("input[type=radio][name=recherchergraphiquevente]").change(function() {
    switch ($(this).val())
    {
    case'tous':
        document.getElementById('pdate').disabled = true;                             
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;   
        document.getElementById('designation').disabled = true;    
        document.getElementById('tous').checked = true;    
        document.getElementById('tous').value = 'tous'; 
    break;

    case'produit':
        document.getElementById('pdate').disabled = true;                             
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;      
        document.getElementById('designation').disabled = false;  
        document.getElementById('designation').value = "";    
        document.getElementById('produit').checked = true;
    break;

    case'pardate':
        document.getElementById('pdate').disabled = false;                                
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;           
        document.getElementById('designation').disabled = true; 
        document.getElementById('pardate').checked = true;  
    break;

    case'produitpardate':
        document.getElementById('pdate').disabled = false;                             
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;      
        document.getElementById('designation').disabled = false; 
        document.getElementById('designation').value = "";  
        document.getElementById('produitpardate').checked = true; 
    break;

    case'parperiode':
        document.getElementById('pdate').disabled = true;                             
        document.getElementById('datedebut').disabled = false;            
        document.getElementById('datefin').disabled = false;   
        document.getElementById('designation').disabled = true;  
        document.getElementById('parperiode').checked = true; 
    break;

    case'parclient':
        document.getElementById('pdate').disabled = true;                             
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;      
        document.getElementById('designation').disabled = false;  
        document.getElementById('designation').value = "";    
        document.getElementById('parclient').checked = true; 
    break;

    }

    });
</script>