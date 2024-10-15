
 <?php 

require_once('identifier.php');
require_once('connexiondb.php');

?>
                
<! DOCTYPE HTML>
<html>
<head>
    <title>Gestion des entrées en stock</title>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">       
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">                               
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/fontawesome.min.css">
    <script src="../js/jquery-3.5.1.min.js"></script>              
    <!--<script src="../js/facturationstock.js"></script>-->
    <script src="../js/sweetalert.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>   
    <script src="../js/pagination/jquery.twbsPagination.min.js"></script>
</head>
<body onload="desactivertout();document.getElementById('param').value='tous';chargementapprovisionnement();">
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success  margetop">
        <div class="panel-heading bg-primary text-white stron">
            Recherche sur l'historique des approvisionnements ...
        </div>
        <div class="panel-body ">
            <form  method="GET" class="form-inline" id="historiqueappro">
            <div class="form-group largeur100" >
            <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                    <a href="nouvellentree.php" class="stron">
                        <span class="glyphicon glyphicon-plus"></span>
                        Nouvel approvisionnement
                    </a>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <a href="etatsto.php" class="stron">
                       Etat de Stock
                    </a>
                                       
                <?php } ?>
            </div>
           
                <div class="form-group largeur100" >
                                  
                    <input type="radio" id="tous" name="rechercher" 
                    onclick="document.getElementById('param').value='tous'"   value="tous"/>
                    <label for="tous">Tous les approvisionnements</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    
                    <input type="radio" id="produit" name="rechercher" 
                     value="produit"> 
                    <label for="produit">Par produit </label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    
                    &nbsp  &nbsp <!--Pour espacement-->

                    <input type="radio" id="pardate" name="rechercher"  
                     value="pardate"> 
                    <label for="pardate">Par date</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->

                    <input type="radio" id="produitpardate" name="rechercher"  
                     value="produitpardate"> 
                    <label for="pardate">Produit par date</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                                
                    <input type="radio" id="parperiode" name="rechercher" 
                     value="parperiode"> 
                    <label for="parperiode">Par periode</label>   
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    <input type="radio" id="parfournisseur" name="rechercher" 
                     value="parfournisseur"> 
                    <label for="parfournisseur">Par fournisseur</label>  

                    <input type="text" id="param" name="param" style="visibility:hidden;" />                        
                </div>  
               
                <div class="form-group largeur100">
                    <div class="form-group" >
                        <input type="text" name="produits" id="produits" class="form-control"
                        onblur="produitetfournisseur();" />                   
                    </div>

                    <div class="form-group">
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
                
                <div class="form-group" >                    
                    <button type="button" class="btn btn-success" id="rechercheapprovisionnement" name="recherche" value="Rechercher" style="margin-top:10px;" >
                        <i class="fas fa-search"></i> Rechercher...
                    </button>
                    <div class="spinner-border text-primary" id="loadingState"></div> 
                </div> 
                &nbsp  &nbsp <!--Pour espacement-->
                &nbsp  &nbsp <!--Pour espacement-->
                &nbsp  &nbsp <!--Pour espacement-->
                &nbsp  &nbsp <!--Pour espacement-->
                <div id="imprimerrapportapprovisionnement"></div> 
            </form>
           
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading bg-primary text-white">
          Historique approvisionnement
        </div>
        <div class="panel-body">
            <table class="table table-dark table-striped">
                <thead>
                <tr>
                    <th>
                        Numero facture
                    </th>
                    <th>
                        Fournisseur
                    </th>
                    <th>
                        Designation produit
                    </th>

                    <th>
                        Quantité entrée
                    </th>

                    <th>
                        Date entrée
                    </th>
                    <th>
                        puht
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
                  
                <tbody id="tbodyhistoriqueapprovisionnement">                

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
function chargementapprovisionnement() {
    switch(document.getElementById('param').value)
        {
            case 'tous':
                $('#loadingState').show();
                var url = 'chargementapprovisionnement.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var approvisionnement = donnee.entrestock;
                    var roleuser=donnee.user;
                   
                   /* $( "#progressbar" ).progressbar({
                    value: donnee.progressbar
                    });*/

                    if(approvisionnement.length == 0){
                        document.getElementById('imprimerrapportapprovisionnement').style.display='none';
                    }
                    else
                    {
                        var casetous = 'tous';
                        document.getElementById('imprimerrapportapprovisionnement').style.display='block';
                        document.getElementById("imprimerrapportapprovisionnement").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportapprovisionnement.php?infoapprovisionnement=" + casetous + "\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = approvisionnement.length;
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
                                displayRecords = approvisionnement.slice(displayRecordsIndex, endRec);                     
                                $('#tbodyhistoriqueapprovisionnement').empty();
                                    
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var identrestock = displayRecords[i]['id_entre'];
                                    var quantiteappro = displayRecords[i]['quantite_entre'];
                                    var prixu = parseFloat(displayRecords[i]['puht']);
                                    var puht = prixu.toFixed(4);
                                    var ancienproduit = displayRecords[i]['id_article'];
                                    var ancienqte = displayRecords[i]['quantite_entre'];
                                    var ulrModification = "editerentrestock.php?identrestock="+identrestock+
                                    "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte;                                   
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyhistoriqueapprovisionnement").append('<tr>' +
                                        '<td>'+displayRecords[i]['numero_facture']+'</td>' +
                                        '<td>'+displayRecords[i]['fournisseurs']+'</td>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' + 
                                        '<td>'+quantiteappro+' '+displayRecords[i]['libelle']+'</td>' + 
                                        '<td>'+displayRecords[i]['date_entre']+'</td>' + 
                                        '<td>'+puht+' '+displayRecords[i]['monnaie']+'</td>' + 
                                        '<td>'+displayRecords[i]['observation']+'</td>' +  
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer approvisionnement"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer approvisionnement" onclick="Confirm_Deleteapprovisionnement('+identrestock+','+ancienproduit+','+ancienqte+')" ><i class="far fa-trash-alt"></i></button></td>' +                                                                                                                                
                                    '</tr>');
                                }
                                                            
                            }
                        });
                    }
                    //$('#loadprogressbar').hide();
                    $('#loadingState').hide();
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    //swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    console.log(data);
                }
            }); 
                break;

            case 'pardate':
                $('#loadingState').show();
                var url = 'chargementapprovisionnement.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: {'pdate':document.getElementById('pdate').value,'param':document.getElementById('param').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var approvisionnement = donnee.entrestock;
                    var roleuser=donnee.user;
                    //var roleuser=donnee.utilisateur;
                   // $('#montantdepense').empty();
                   
                   
                    //document.getElementById('montantdepense').innerText =  donnee.somme+' '+'$';

                    if(approvisionnement.length == 0){
                        document.getElementById('imprimerrapportapprovisionnement').style.display='none';
                    }
                    else
                    {
                        var parametr = 'pardate';
                        document.getElementById('imprimerrapportapprovisionnement').style.display='block';
                        var dateappro = document.getElementById('pdate').value;
                        document.getElementById("imprimerrapportapprovisionnement").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportapprovisionnement.php?infoapprovisionnement=" + parametr + "&parametre="+ dateappro +"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = approvisionnement.length;
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

                                displayRecords = approvisionnement.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux approvisionnement
                                
                                    $('#tbodyhistoriqueapprovisionnement').empty();
                                    for (var i = 0; i < displayRecords.length; i++) {
                                        var identrestock = displayRecords[i]['id_entre'];
                                    var quantiteappro = displayRecords[i]['quantite_entre'];
                                    var prixu = parseFloat(displayRecords[i]['puht']);
                                    var puht = prixu.toFixed(4);
                                    var ancienproduit = displayRecords[i]['id_article'];
                                    var ancienqte = displayRecords[i]['quantite_entre'];
                                    var ulrModification = "editerentrestock.php?identrestock="+identrestock+
                                    "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte;                                   
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyhistoriqueapprovisionnement").append('<tr>' +
                                        '<td>'+displayRecords[i]['numero_facture']+'</td>' +
                                        '<td>'+displayRecords[i]['fournisseurs']+'</td>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' + 
                                        '<td>'+quantiteappro+' '+displayRecords[i]['libelle']+'</td>' + 
                                        '<td>'+displayRecords[i]['date_entre']+'</td>' + 
                                        '<td>'+puht+' '+displayRecords[i]['monnaie']+'</td>' + 
                                        '<td>'+displayRecords[i]['observation']+'</td>' +  
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer approvisionnement"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer approvisionnement" onclick="Confirm_Deleteapprovisionnement('+identrestock+','+ancienproduit+','+ancienqte+')" ><i class="far fa-trash-alt"></i></button></td>' +                                                                                                                                
                                    '</tr>');
                                }
                                                            
                            }
                        });
                    }

                    $('#loadingState').hide();
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    //swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    console.log(data);
                }
            });                                                                                            
                break; 

            case 'datedebut':
                $('#loadingState').show();
                    var url = 'chargementapprovisionnement.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'datedebut':document.getElementById('datedebut').value,'param':document.getElementById('param').value
                ,'datefin':document.getElementById('datefin').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var approvisionnement = donnee.entrestock;
                    var roleuser=donnee.user;
                   // $('#montantdepense').empty();
                    //document.getElementById('montantdepense').innerText =  donnee.somme+' '+'$';
               
                    if(approvisionnement.length == 0){
                        document.getElementById('imprimerrapportapprovisionnement').style.display='none';
                    }
                    else
                    { 
                        var parametr = 'datedebut';
                        var datedebut = document.getElementById('datedebut').value;
                        var datefin = document.getElementById('datefin').value;
                        document.getElementById('imprimerrapportapprovisionnement').style.display='block';
                        var dateappro = document.getElementById('pdate').value;
                        document.getElementById("imprimerrapportapprovisionnement").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportapprovisionnement.php?infoapprovisionnement=" + parametr + "&datedbt="+ datedebut +"&datefin="+datefin+"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = approvisionnement.length;
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

                                displayRecords = approvisionnement.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux approvisionnement
                                
                                    $('#tbodyhistoriqueapprovisionnement').empty();
                                //var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var identrestock = displayRecords[i]['id_entre'];
                                    var quantiteappro = displayRecords[i]['quantite_entre'];
                                    var prixu = parseFloat(displayRecords[i]['puht']);
                                    var puht = prixu.toFixed(4);
                                    var ancienproduit = displayRecords[i]['id_article'];
                                    var ancienqte = displayRecords[i]['quantite_entre'];
                                    var ulrModification = "editerentrestock.php?identrestock="+identrestock+
                                    "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte;                                   
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyhistoriqueapprovisionnement").append('<tr>' +
                                        '<td>'+displayRecords[i]['numero_facture']+'</td>' +
                                        '<td>'+displayRecords[i]['fournisseurs']+'</td>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' + 
                                        '<td>'+quantiteappro+' '+displayRecords[i]['libelle']+'</td>' + 
                                        '<td>'+displayRecords[i]['date_entre']+'</td>' + 
                                        '<td>'+puht+' '+displayRecords[i]['monnaie']+'</td>' + 
                                        '<td>'+displayRecords[i]['observation']+'</td>' +  
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer approvisionnement"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer approvisionnement" onclick="Confirm_Deleteapprovisionnement('+identrestock+','+ancienproduit+','+ancienqte+')" ><i class="far fa-trash-alt"></i></button></td>' +                                                                                                                                
                                    '</tr>');
                                }
                                                            
                            }
                        });
                    }

                    $('#loadingState').hide();
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    //swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    console.log(data);
                }
            }); 
                break;
            case'produitpardate':  
                $('#loadingState').show();             
                var url = 'chargementapprovisionnement.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,
                'pdate':document.getElementById('pdate').value,
                'designation':document.getElementById('produits').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var approvisionnement = donnee.entrestock;
                    var roleuser=donnee.user;
                   // $('#montantdepense').empty();
                    //document.getElementById('montantdepense').innerText =  donnee.somme+' '+'$';
               
                    if(approvisionnement.length == 0){
                        document.getElementById('imprimerrapportapprovisionnement').style.display='none';
                    }
                    else
                    {
                        var parametr = 'produitpardate';
                        var dateentre = document.getElementById('pdate').value;
                        var produit = document.getElementById('produits').value;
                        document.getElementById('imprimerrapportapprovisionnement').style.display='block';
                        document.getElementById("imprimerrapportapprovisionnement").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportapprovisionnement.php?infoapprovisionnement=" + parametr + "&dateentre="+ dateentre +"&produit="+produit+"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = approvisionnement.length;
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

                                displayRecords = approvisionnement.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux historiquedevente
                                
                                $('#tbodyhistoriqueapprovisionnement').empty();
                                //var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var identrestock = displayRecords[i]['id_entre'];
                                    var quantiteappro = displayRecords[i]['quantite_entre'];
                                    var prixu = parseFloat(displayRecords[i]['puht']);
                                    var puht = prixu.toFixed(4);
                                    var ancienproduit = displayRecords[i]['id_article'];
                                    var ancienqte = displayRecords[i]['quantite_entre'];
                                    var ulrModification = "editerentrestock.php?identrestock="+identrestock+
                                    "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte;                                   
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyhistoriqueapprovisionnement").append('<tr>' +
                                        '<td>'+displayRecords[i]['numero_facture']+'</td>' +
                                        '<td>'+displayRecords[i]['fournisseurs']+'</td>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' + 
                                        '<td>'+quantiteappro+' '+displayRecords[i]['libelle']+'</td>' + 
                                        '<td>'+displayRecords[i]['date_entre']+'</td>' + 
                                        '<td>'+puht+' '+displayRecords[i]['monnaie']+'</td>' + 
                                        '<td>'+displayRecords[i]['observation']+'</td>' +  
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer approvisionnement"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer approvisionnement" onclick="Confirm_Deleteapprovisionnement('+identrestock+','+ancienproduit+','+ancienqte+')" ><i class="far fa-trash-alt"></i></button></td>' +                                                                                                                                
                                    '</tr>');
                                }
                                                            
                            }
                        });
                    }

                    $('#loadingState').hide();
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
                $('#loadingState').show();
                    var url = 'chargementapprovisionnement.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,'designation':document.getElementById('produits').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var approvisionnement = donnee.entrestock;
                    var roleuser=donnee.user;
                   // $('#montantdepense').empty();
                    //document.getElementById('montantdepense').innerText =  donnee.somme+' '+'$';
               
                    if(approvisionnement.length == 0){
                        document.getElementById('imprimerrapportapprovisionnement').style.display='none';
                    }
                    else
                    {
                        var parametr = 'parproduit';
                        document.getElementById('imprimerrapportapprovisionnement').style.display='block';
                        var designation = document.getElementById('produits').value;
                        document.getElementById("imprimerrapportapprovisionnement").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportapprovisionnement.php?infoapprovisionnement=" + parametr + "&parametre="+ designation +"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = approvisionnement.length;
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

                                displayRecords = approvisionnement.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux approvisionnement
                                
                                    $('#tbodyhistoriqueapprovisionnement').empty();
                                //var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var identrestock = displayRecords[i]['id_entre'];
                                    var quantiteappro = displayRecords[i]['quantite_entre'];
                                    var prixu = parseFloat(displayRecords[i]['puht']);
                                    var puht = prixu.toFixed(4);
                                    var ancienproduit = displayRecords[i]['id_article'];
                                    var ancienqte = displayRecords[i]['quantite_entre'];
                                    var ulrModification = "editerentrestock.php?identrestock="+identrestock+
                                    "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte;                                   
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyhistoriqueapprovisionnement").append('<tr>' +
                                        '<td>'+displayRecords[i]['numero_facture']+'</td>' +
                                        '<td>'+displayRecords[i]['fournisseurs']+'</td>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' + 
                                        '<td>'+quantiteappro+' '+displayRecords[i]['libelle']+'</td>' + 
                                        '<td>'+displayRecords[i]['date_entre']+'</td>' + 
                                        '<td>'+puht+' '+displayRecords[i]['monnaie']+'</td>' + 
                                        '<td>'+displayRecords[i]['observation']+'</td>' +  
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer approvisionnement"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer approvisionnement" onclick="Confirm_Deleteapprovisionnement('+identrestock+','+ancienproduit+','+ancienqte+')" ><i class="far fa-trash-alt"></i></button></td>' +                                                                                                                                
                                    '</tr>');
                                }
                                                            
                            }
                        });
                    }

                    $('#loadingState').hide();
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    //swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    console.log(data);
                }
            }); 
                break;

            case'parfournisseur':
                $('#loadingState').show();
                    var url = 'chargementapprovisionnement.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,'fournisseur':document.getElementById('produits').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var approvisionnement = donnee.entrestock;
                    var roleuser=donnee.user;
                   // $('#montantdepense').empty();
                    //document.getElementById('montantdepense').innerText =  donnee.somme+' '+'$';
               
                    if(approvisionnement.length == 0){
                        document.getElementById('imprimerrapportapprovisionnement').style.display='none';
                    }
                    else
                    {
                        var parametr = 'parfournisseur';
                        document.getElementById('imprimerrapportapprovisionnement').style.display='block';
                        var fournisseur = document.getElementById('produits').value;
                        document.getElementById("imprimerrapportapprovisionnement").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportapprovisionnement.php?infoapprovisionnement=" + parametr + "&parametre="+ fournisseur +"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = approvisionnement.length;
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

                                displayRecords = approvisionnement.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux approvisionnement
                                
                                    $('#tbodyhistoriqueapprovisionnement').empty();
                                //var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var identrestock = displayRecords[i]['id_entre'];
                                    var quantiteappro = displayRecords[i]['quantite_entre'];
                                    var prixu = parseFloat(displayRecords[i]['puht']);
                                    var puht = prixu.toFixed(4);
                                    var ancienproduit = displayRecords[i]['id_article'];
                                    var ancienqte = displayRecords[i]['quantite_entre'];
                                    var ulrModification = "editerentrestock.php?identrestock="+identrestock+
                                    "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte;                                   
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyhistoriqueapprovisionnement").append('<tr>' +
                                        '<td>'+displayRecords[i]['numero_facture']+'</td>' +
                                        '<td>'+displayRecords[i]['fournisseurs']+'</td>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' + 
                                        '<td>'+quantiteappro+' '+displayRecords[i]['libelle']+'</td>' + 
                                        '<td>'+displayRecords[i]['date_entre']+'</td>' + 
                                        '<td>'+puht+' '+displayRecords[i]['monnaie']+'</td>' + 
                                        '<td>'+displayRecords[i]['observation']+'</td>' +  
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer approvisionnement"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer approvisionnement" onclick="Confirm_Deleteapprovisionnement('+identrestock+','+ancienproduit+','+ancienqte+')" ><i class="far fa-trash-alt"></i></button></td>' +                                                                                                                                
                                    '</tr>');
                                }
                                                            
                            }
                        });
                    }

                    $('#loadingState').hide();
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    //swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    //console.log(data);
                }
            }); 
            break;

        case 'inserer': 
                var url = 'chargementapprovisionnement.php';
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'idFournisseur':document.getElementById('idFournisseur').value,
                        'idproduit':document.getElementById('idproduit').value,
                        'numerofacture':document.getElementById('numerofacture').value,
                        'quantiteentre':document.getElementById('quantiteentre').value,
                        'puht':document.getElementById('puht').value,
                        'observation':document.getElementById('observation').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {
                                 
                            swal("Approvisionnement bien enregistré");                        
                            $('#idFournisseur').val('Veuillez choisir le fournisseur');
                            $('#idproduit').val('Veuillez choisir le produit');
                            $('#numerofacture').val('');
                            $('#quantiteentre').val('');
                            $('#puht').val('');
                            $('#observation').val('');
                           
                        },
                        error: function (data) {
                            alert("Erreur enregistrement client");
                        }
                    });
                break;

             case 'modifier': 
            var url = 'chargementapprovisionnement.php';
            $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                            'idFournisseur':document.getElementById('idFournisseur').value,
                            'idproduit':document.getElementById('idproduit').value,
                            'numerofacture':document.getElementById('numerofacture').value,
                            'quantiteentre':document.getElementById('quantiteentre').value,
                            'puht':document.getElementById('puht').value,
                            'observation':document.getElementById('observation').value,
                            'dateenre':document.getElementById('dateenre').value,
                            'idES':document.getElementById('idES').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {
                            swal("Approvisionnement bien modifié");                                                   
                        },
                        error: function (data) {
                            swal("Erreur modification approvisionnement");
                        }
                    });
            break;
            case 'chargerchampmodifier':
                var url = 'chargementapprovisionnement.php';
                $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value,                            
                            'identrestock':document.getElementById('idES').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                            var donnee = jQuery.parseJSON(data);  

                                                                                                
             
                            $('#idFournisseur').val(donnee.idfournisseur);
                            $('#idproduit').val(donnee.idarticle);
                            $('#numerofacture').val(donnee.numerofacture);
                            $('#quantiteentre').val(donnee.quantiteentre);
                            $('#puht').val(donnee.puht);
                            $('#observation').val(donnee.observation);
                            $('#dateenre').val(donnee.dateentre);
                            $('#idFournisseur').innerText(donnee.fournisseurs);
                            $('#idproduit').innerText(donnee.designationproduit);

                            },
                            error: function (data) {
                                swal("Erreur chargement champ modification");
                            }
                        });
            break; 
      
            case 'recuperer_fournisseur':
                var url = 'chargementapprovisionnement.php';
                $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                            var donnee = jQuery.parseJSON(data);  
                            var fournisseurs = donnee.fournisseur;
                             for (var i = 0; i < fournisseurs.length; i++) {
                                $('#idFournisseur :selected').val(donnee.fournisseurs[i]['idf']);
                                $('#idFournisseur :selected').innerText(donnee.fournisseurs[i]['fournisseurs']);
                                }                                                                                                       
                                
                            },
                            error: function (data) {
                                swal("Erreur chargement champ fournisseur");
                            }
                        });
            break;

            case 'recuperer_produit':
                var url = 'chargementapprovisionnement.php';
                $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                            var donnee = jQuery.parseJSON(data);  
                            var produits = donnee.produit;
                            var select = $("#idproduit");
                                                     
                            $.each(data, function(index, array) {  
                                select.append('<option value="' + array.ref_produit +'">' + array.designation_produit + '</option>');                 
                                });
                                                                                                                                   

                            },
                            error: function (data) {
                                swal("Erreur chargement champ produit");
                            }
                        });
            break;
        }              
    }

    $('#rechercheapprovisionnement').on('click', function(){
        $('#tbodyhistoriqueapprovisionnement').empty();
        chargementapprovisionnement();
        });


         function produitetfournisseur(){        
			if($('#produit').prop("checked"))
			{
				document.getElementById('param').value='parproduit';               
			}	
            else if($('#parfournisseur').prop("checked"))
			{
				document.getElementById('param').value='parfournisseur';                
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
            document.getElementById('produits').disabled = true;    
            document.getElementById('tous').checked = true;    
            document.getElementById('tous').value = 'tous'; 
        break;

        case'produit':
            document.getElementById('pdate').disabled = true;                             
            document.getElementById('datedebut').disabled = true;            
            document.getElementById('datefin').disabled = true;      
            document.getElementById('produits').disabled = false;  
            document.getElementById('produits').value = "";    
            document.getElementById('produit').checked = true;
        break;

        case'pardate':
            document.getElementById('pdate').disabled = false;                                
            document.getElementById('datedebut').disabled = true;            
            document.getElementById('datefin').disabled = true;           
            document.getElementById('produits').disabled = true; 
            document.getElementById('pardate').checked = true;  
        break;

        case'produitpardate':
            document.getElementById('pdate').disabled = false;                             
            document.getElementById('datedebut').disabled = true;            
            document.getElementById('datefin').disabled = true;      
            document.getElementById('produits').disabled = false; 
            document.getElementById('produits').value = "";  
            document.getElementById('produitpardate').checked = true; 
        break;

        case'parperiode':
            document.getElementById('pdate').disabled = true;                             
            document.getElementById('datedebut').disabled = false;            
            document.getElementById('datefin').disabled = false;   
            document.getElementById('produits').disabled = true;  
            document.getElementById('parperiode').checked = true; 
        break;

        case'parfournisseur':
            document.getElementById('pdate').disabled = true;                             
            document.getElementById('datedebut').disabled = true;            
            document.getElementById('datefin').disabled = true;      
            document.getElementById('produits').disabled = false;  
            document.getElementById('produits').value = "";    
            document.getElementById('parfournisseur').checked = true; 
        break;

    }
    
});

function desactivertout()
{   
        document.getElementById('pdate').disabled = true;                             
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;   
        document.getElementById('produits').disabled = true;    
        document.getElementById('tous').checked = true;    
        document.getElementById('tous').value = 'tous';  
}


function Confirm_Deleteapprovisionnement(identrestock,ancienproduit,ancienqte) 

{
    swal({
        title: "Suppression !",
        text: "Voulez-vous vraiment supprimer cet approvisionnement?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               deleteapprovisionnement(identrestock,ancienproduit,ancienqte)
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
}  

function deleteapprovisionnement(identrestock,ancienproduit,ancienqte){
    var url = 'chargementapprovisionnement.php';
    $.ajax({
                type: 'GET',
                url: url,
                data:{'param':document.getElementById('param').value='suppression',
                'identrestock':identrestock,
                'ancienproduit':ancienproduit,
                'ancienqte':ancienqte},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    swal('Approvisionnement supprimé');                   
                    
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
