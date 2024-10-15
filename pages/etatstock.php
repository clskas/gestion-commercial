
<! DOCTYPE HTML>
<html>
<head>
    <title>Etat de stock</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">       
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
<body onload="desactivertout();document.getElementById('param').value='tous';chargementetat()">
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success margetop">
        <div class="panel-heading">
            Rechercher etat stock
        </div>
        <div class="panel-body">
            <form  method="GET" class="form-inline" id="artic">
            <div class="form-group largeur100" >
                                  
                <input type="radio" id="tous" name="rechercher" 
                    onclick="document.getElementById('param').value='tous';desactivertout();" value="tous"/>
                <label for="tous">Toutes les ventes</label>
                &nbsp  &nbsp <!--Pour espacement-->
                &nbsp  &nbsp <!--Pour espacement-->
                &nbsp  &nbsp <!--Pour espacement-->                                                  
                <input type="radio" id="produit" name="rechercher" 
                    value="produit"> 
                <label for="produit">Par produit </label>                                                                              
                <input type="text" id="param" name="param" style="visibility:hidden;" />                        
            </div>   

            <div class="form-group">            
                <input type="text" name="designation" id="designation" class="form-control"
                onblur="document.getElementById('param').value='produit'"/>                        
			</div>
                
            <div style="width:25%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                <button type="button" class="btn btn-success" id="rechercheproduit" name="rechercheproduit" value="Rechercher" style="margin-top:10px;">                 
                    <span class="glyphicon glyphicon-search"></span> Rechercher...
                </button>
            </div>               
        </form>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
        Montant payé : <label id="montantdepense"></label>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>
                            Id produit
                        </th>
                        <th>
                            Designation
                        </th>
                        <th>
                            Quantité
                        </th>
                    </tr>
                </thead>
                <tbody id="tbodyetatstock">
              			                          
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

function chargementetat()
{
    switch(document.getElementById('param').value)
            {
                case 'tous':
                var url = 'chargementetatstock.php';
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
                   
                    var etatdestock = donnee.etatstocke;
                   // $('#montantdepense').empty();
                    //document.getElementById('montantdepense').innerText =  donnee.etatstocke;
               /*if(displayRecords[i]['Article_Qte']<=displayRecords[i]['qtemin'])
                                         '<td style="background-color:red;">'+displayRecords[i]['Article_Qte']+'</td>' +
                                         else
                                         '<td style="background-color:red;">'+displayRecords[i]['Article_Qte']+'</td>' +
                    */
                    if(etatdestock.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
                        totalRecords = etatdestock.length;
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

                                displayRecords = etatdestock.slice(displayRecordsIndex, endRec);
                               
                                $('#tbodyetatstock').empty();
                                for (var i = 0; i < displayRecords.length; i++){
                                    $("#tbodyetatstock").append('<tr>' +
                                    '<td>'+displayRecords[i]['Article_code']+'</td>' +
                                    '<td>'+displayRecords[i]['Article_designation']+'</td>' +
                                    '<td>'+displayRecords[i]['Article_Qte']+'</td>' +         
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
                    //console.log(data);
                }
            }); 
        break;

        case 'produit':
            var url = 'chargementetatstock.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,'designation':document.getElementById('designation').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var etatdestock = donnee.etatstock;
                   // $('#montantdepense').empty();
                    //document.getElementById('montantdepense').innerText =  donnee.somme+' '+'$';
               
                    if(etatdestock.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
                        totalRecords = etatdestock.length;
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

                                displayRecords = etatdestock.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux etatdestock
                               /*
                               else
                                        {
                                            '<td style="background-color:red;">'+displayRecords[i]['Article_Qte']+'</td>' +
                                        }
                                */ 
                                $('#tbodyetatstock').empty();
                                for (var i = 0; i < displayRecords.length; i++) {
                                   
                                    $("#tbodyetatstock").append('<tr>' +
                                        '<td>'+displayRecords[i]['Article_code']+'</td>' +
                                        '<td>'+displayRecords[i]['Article_designation']+'</td>' +
                                        if(displayRecords[i]['Article_Qte']<=displayRecords[i]['qtemin'])
                                         '<td style="background-color:red;">'+displayRecords[i]['Article_Qte']+'</td>' +
                                        else
                                         '<td style="background-color:red;">'+displayRecords[i]['Article_Qte']+'</td>' +
                                                        
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
  

$("input[type=radio][name=rechercher]").change(function() {
    switch ($(this).val())
    {
        case'tous':  
            document.getElementById('designation').disabled = true;    
            document.getElementById('tous').checked = true;    
            document.getElementById('tous').value = 'tous'; 
        break;

        case'produit':                             
            document.getElementById('designation').disabled = false;  
            document.getElementById('designation').value = "";    
            document.getElementById('produit').checked = true;
        break;
       
    }
    
});

    $('#rechercheproduit').on('click', function(){
        $('#tbodyetatstock').empty();
        chargementetat();
        });

function desactivertout()
{         
    document.getElementById('designation').disabled = true;    
    document.getElementById('tous').checked = true;    
    document.getElementById('tous').value = 'tous';  
}

 </script>