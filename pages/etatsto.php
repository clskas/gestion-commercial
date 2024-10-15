
<?php
require_once('identifier.php');
require_once('connexiondb.php');
    
?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Etat stock</title>
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
<body onload="desactivertoutpaiement();document.getElementById('param').value='tous';chargementpaiment();">
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success margetop">
        <div class="panel-heading">
            Recherche sur le paiement ...
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline" id="paiem">
                <div class="form-group">
                   <input type="radio" id="tous" name="rechercher" 
                    onclick="document.getElementById('param').value='tous';desactivertout();" value="tous"/>
                    <label for="tous">Tous les produits</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->             
                    <input type="radio" id="pararticle" name="rechercher"  value="pararticle" /> 
                     <label for="pararticle">Par produit</label>
                     &nbsp  &nbsp <!--Pour espacement-->
                     &nbsp  &nbsp <!--Pour espacement-->
                     &nbsp  &nbsp <!--Pour espacement   placeholder="Saisir le numero de facture-->
                     &nbsp  &nbsp <!--Pour espacement-->                   
                     <input type="text" id="param" name="param" style="visibility:hidden;" /> 
                </div>                               
                    <div class="form-group largeur100">
                        
                        <input type="text" name="produit" id="produit" 
                        onblur="document.getElementById('param').value='parproduit'"/>
                    </div>
                    
                    <div class="form-group">
                        <button type="button" class="btn btn-success" id="recherchepaiement" name="recherchepaiement" value="Rechercher" style="margin-top:10px;">
                            <i class="fas fa-search"></i> Rechercher...
                        </button>
                    </div>               
            </form>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            Montant payé : <label id="montantpaye"></label>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>
                        Code produit
                    </th>
                    <th>
                        Désignation
                    </th>
                    <th>
                        Quantité
                    </th>
                   
                </tr>
                </thead>
                <tbody id="tbodypaie">
                          
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
  
function chargementpaiment() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
                var url = 'chargementsto.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var etatstock = donnee.etatstocke;
                   // $('#montantdepense').empty();
                    //document.getElementById('montantpaye').innerText =  donnee.somme+' '+'$';
               
                    if(etatstock.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
                        totalRecords = etatstock.length;
                        totalPages = Math.ceil(totalRecords / recPerPage);

                        $('#pagination').empty();
                        $('#pagination').removeData("twbs-pagination");
                        $('#pagination').unbind("page");

                        $pagination.twbsPagination({
                            totalPages: totalPages,
                            visiblePages: 6,
                            onPageClick: function (event, page) {
                                displayRecordsIndex = Math.max(page - 1, 0) * recPerPage;
                                endRec = (displayRecordsIndex) + recPerPage;

                                displayRecords = etatstock.slice(displayRecordsIndex, endRec);
                               
                                $('#tbodypaie').empty();
                                
                                for (var i = 0; i < displayRecords.length; i++) {  
                                    var qteenstock = parseInt(displayRecords[i]['Article_Qte']);
                                    var qteminimale = parseInt(displayRecords[i]['qtemin']);
                                    var  color ="green"; 
                                    if(qteenstock<=qteminimale)                                    
                                    {  
                                         color = "red";
                                    }                                   
                                                              
                                                                          
                                    $("#tbodypaie").append('<tr>' +
                                        '<td>'+displayRecords[i]['Article_code']+'</td>' +
                                        '<td>'+displayRecords[i]['Article_designation']+'</td>' +                                       
                                        '<td style="background-color:'+color+';color:white;">'+displayRecords[i]['Article_Qte']+' '+displayRecords[i]['unite']+'</td>' + 
                                        '</tr>');                                                                                                                                                                                                                                                                                               
                                }
                                                            
                            }
                        });
                    }

                    //$('#loadingState').hide();
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    //swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    console.log(data);
                }
            }); 
                break;

                case 'parproduit':
                    var url = 'chargementsto.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: {'designation':document.getElementById('produit').value,'param':document.getElementById('param').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var etatstock = donnee.etatstocke;
                   // $('#montantdepense').empty();
                    //document.getElementById('montantpaye').innerText =  donnee.somme+' '+'$';
               
                    if(etatstock.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
                        totalRecords = etatstock.length;
                        totalPages = Math.ceil(totalRecords / recPerPage);

                        $('#pagination').empty();
                        $('#pagination').removeData("twbs-pagination");
                        $('#pagination').unbind("page");

                        $pagination.twbsPagination({
                            totalPages: totalPages,
                            visiblePages: 6,
                            onPageClick: function (event, page) {
                                displayRecordsIndex = Math.max(page - 1, 0) * recPerPage;
                                endRec = (displayRecordsIndex) + recPerPage;

                                displayRecords = etatstock.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux depenses
                                
                                    $('#tbodypaie').empty();
                                //var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";

                                    for (var i = 0; i < displayRecords.length; i++) {
                                    var qteenstock = parseInt(displayRecords[i]['Article_Qte']);
                                    var qteminimale = parseInt(displayRecords[i]['qtemin']);
                                    //var  color = "green"; 
                                    if( qteminimale >= qteenstock)                                    
                                      var color = "red";
                                    else
                                      var color =  "green";
                                                                                                                                           
                                    $("#tbodypaie").append('<tr>' +
                                        '<td>'+displayRecords[i]['Article_code']+'</td>' +
                                        '<td>'+displayRecords[i]['Article_designation']+'</td>' +                                       
                                        '<td style="background-color:'+color+';color:white;">'+displayRecords[i]['Article_Qte']+' '+displayRecords[i]['unite']+'</td>' + 
                                        '</tr>'); 
                                    }
                                                            
                            }
                        });
                    }

                    //$('#loadingState').hide();
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    //swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    console.log(data);
                }
            });                                                                                            
                break; 

               
        }              
    }

   $('#recherchepaiement').on('click', function(){
        $('#tbodypaie').empty();
        chargementpaiment();
        });

 

$("input[type=radio][name=rechercher]").change(function() {
    switch ($(this).val())
    {
        case'tous':
            document.getElementById('produit').disabled = true;                                               
            document.getElementById('tous').checked = true;    
            document.getElementById('tous').value = 'tous'; 
        break;

        case'pararticle':
            document.getElementById('produit').disabled = false;                                               
            document.getElementById('pararticle').checked = true;  
            document.getElementById('produit').value = ''; 
        break;
      
    }
    
});

function desactivertoutpaiement()
{   
        document.getElementById('produit').disabled = true;                                                 
        document.getElementById('tous').checked = true;    
        document.getElementById('tous').value = 'tous';  
}
</script>
