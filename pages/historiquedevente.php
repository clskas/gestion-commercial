
 <?php 
require_once('identifier.php');
require_once('connexiondb.php');

?>
                
<! DOCTYPE HTML>
<html>
<head>
    <title>Historique de vente</title>
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
<body onload="desactivertoutevente();document.getElementById('param').value='tous';chargementhistoriquedevente()">
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success margetop">
        <div class="panel-heading bg-primary text-white">
            Recherche sur l'historique de vente ...
        </div>
        <div class="panel-body">
            <form  method="GET" class="form-inline" id="historiquevente">
           
                <div class="form-group largeur100" >                                                 
                    <input type="radio" id="tous" name="rechercher" class="form-check-input"
                        onclick="document.getElementById('param').value='tous';desactivertoutevente();" value="tous"/>
                    <label for="tous">Toutes les ventes</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    
                    <input type="radio" id="produit" name="rechercher" class="form-check-input"
                     value="produit"> 
                    <label for="produit">Par produit </label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    
                    &nbsp  &nbsp <!--Pour espacement-->

                    <input type="radio" id="pardate" name="rechercher"  class="form-check-input"
                     value="pardate"> 
                    <label for="pardate">Par date</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->

                    <input type="radio" id="produitpardate" name="rechercher"  class="form-check-input"
                     value="produitpardate"> 
                    <label for="produitpardate">Produit par date</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                                
                    <input type="radio" id="parperiode" name="rechercher" class="form-check-input"
                     value="parperiode"> 
                    <label for="parperiode">Par periode</label>  
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->  

                    <input type="radio" id="parclient" name="rechercher" class="form-check-input"
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
                    
                    <a href="graphiqueetatdevente.php">
                       Graphique vente
                    </a>
                    <input type="text" id="param" name="param" style="visibility:hidden;" />                        
                </div>   
                <div class="form-group largeur100 ">     
                    <div class="form-group">
                        <input type="text" name="designation" id="designation" placeholder="Désignation produit"
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
                                
                </div>
                <div class="form-group">                                   
                        <button type="button" class="btn btn-success" id="recherchevente" name="recherche" value="Rechercher" style="margin-top:10px;" >
                        <i class="fas fa-search"></i> Rechercher...
                        </button>                    
                    &nbsp                                         
                    <div class="spinner-border text-primary" id="loadingState"></div> 
                    <!--<div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="loadprogressbar"
                        style="width:100%;">
                    </div>                 
                    </div>  -->
                                
                </div>                                                                              
            </form>
            <div id="imprimerrapportvente"></div> 
        </div>
    </div>
    
    <div class="panel panel-primary ">
        <div class="panel-heading bg-primary text-white">
        Montant vendu en $: <label id="montantvendu"></label>
            &nbsp  &nbsp <!--Pour espacement-->
            &nbsp  &nbsp <!--Pour espacement-->
            &nbsp  &nbsp <!--Pour espacement-->
        Montant vendu en FC: <label id="montantvendufc"></label>
        </div>
        <div class="panel-body">
            <table class="table table-dark table-striped table-bordered">
                <thead>
                <tr>
                    <th>
                        Numero facture
                    </th>
                    <th>
                        Client
                    </th>
                    <th>
                        Date vente
                    </th>
                    <th>
                        Designation produit
                    </th>

                    <th>
                        Quantité vendue
                    </th>
                   
                    <th>
                        puht
                    </th>

                    <th>
                        Montant total
                    </th>   

                    <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                        <th>
                            Action
                        </th>
                    <?php } ?>            
                </tr>
                </thead>
                  
                <tbody id="tbodyhistoriquevente">
                                  
                </tbody>
            </table>
            <div>
                <nav class="m-3 paginator pagination-sm" aria-label="Page navigation">
                    <ul class="pagination" id="pagination"></ul>
                </nav> 
            </div>
        </div>
    </div>
</div>
</body>
</html>


<script>
    $('#recherchevente').on('click', function(){
        $('#tbodyhistoriquevente').empty();
        chargementhistoriquedevente();
        });

    function produitetclient()
    {        
		if($('#produit').prop("checked"))
		{
			document.getElementById('param').value='parproduit';               
		}	
        else if($('#parclient').prop("checked"))
		{
			document.getElementById('param').value='parclient';                		
        } 
        else if($('#produitpardate').prop("checked"))
		{
			document.getElementById('param').value='produitpardate';               		
        }           
    }

    function produitetdate()
    {        
		if($('#pardate').prop("checked"))
		{
			document.getElementById('param').value='pardate';               
		}	        
        else if($('#produitpardate').prop("checked"))
		{
			document.getElementById('param').value='produitpardate';               		
        }           
    }

 $("input[type=radio][name=rechercher]").change(function() {
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

function desactivertoutevente()
{   
        document.getElementById('pdate').disabled = true;                             
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;   
        document.getElementById('designation').disabled = true;    
        document.getElementById('tous').checked = true;    
        document.getElementById('tous').value = 'tous';  
}

function Confirm_Deletevente(iddetail,ancienproduit,ancienqte,anciennefacture,ancienmontant) 

{
    swal({
        title: "Suppression !",
        text: "Voulez-vous vraiment supprimer ce detail de vente?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               deletevente(iddetail,ancienproduit,ancienqte,anciennefacture,ancienmontant)
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
}  

function deletevente(iddetail,ancienproduit,ancienqte,anciennefacture,ancienmontant){
    var url = 'chargementvente.php';
    $.ajax({
                type: 'GET',
                url: url,
                data:{'param':document.getElementById('param').value='suppression',
                'iddetail':iddetail,
                'ancienproduit':ancienproduit,
                'ancienqte':ancienqte,
                'anciennefacture':anciennefacture,
                'ancienmontant':ancienmontant},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    swal('Detail vente supprimé');                   
                    
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    //console.log(data);
                }
            }); 
} 

</script>

