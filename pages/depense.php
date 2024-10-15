
<?php

require_once('identifier.php');
require_once('connexiondb.php');
  
?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Gestion de dépenses</title>
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
<body onload="desactivertoutedepense();document.getElementById('param').value='tous';chargementdepense();">
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success margetop">
        <div class="panel-heading bg-primary text-white">
            Rechercher de dépenses...
        </div>
        <div class="panel-body">
            <form  method="GET" class="form-inline" id="depen">              
                <div class="form-group largeur100" >                                 
                    <input type="radio" id="tous" name="rechercherdepense" 
                        onclick="document.getElementById('param').value='tous';desactivertout();" value="tous"/>
                        <label for="tous">Toutes les dépenses</label>
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->                                   
                        <input type="radio" id="motiff" name="rechercherdepense" 
                        onclick="activermotif();" value="motiff"> 
                        <label for="motiff">Par motif </label>
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->                                   
                        &nbsp  &nbsp <!--Pour espacement-->               
                        <input type="radio" id="pardate" name="rechercherdepense"  
                        onclick="activerdate();" value="pardate"> 
                        <label for="pardate">Par date</label>
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement -->                                                                                      
                        <input type="radio" id="parperiode" name="rechercherdepense" 
                        onclick="activerparperiode();" value="parperiode"> 
                        <label for="parperiode">Par periode</label>   
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement-->
                        &nbsp  &nbsp <!--Pour espacement --> 
                        <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                            <a href="nouvelledepense.php">
                                <span class="glyphicon glyphicon-plus"></span>
                                Nouvelle dépense
                            </a>
                         <?php } ?>                
                        <input type="text" id="param" name="param" style="visibility:hidden;" />  
                                           
                </div> 
                <div class="form-group largeur100" > 
                    <div class="form-group">
                    <input type="text" name="motif" id="motif" onblur="document.getElementById('param').value='motif'" 
                            class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="pdate" id="pdate" 
                        onblur="document.getElementById('param').value='pardate'"/>
                    </div>
                    <div class="form-group">
                        <label>Date Début</label>
                        <input type="date" name="datedebut" id="datedebut" 
                        onblur="document.getElementById('param').value='datedebut'"/>
                        <label>Date Fin</label>
                        <input type="date" name="datefin" id="datefin" />                 
                    </div>
                </div> 
                
                <div class="form-group">
                    <button type="button" class="btn btn-success" id="recherchedepense" name="recherche" value="Rechercher" style="margin-top:10px;">                 
                    <i class="fas fa-search"></i> Rechercher...
                    </button>
                    <div class="spinner-border text-primary" id="loadingState"></div> 
               </div> 
                &nbsp  &nbsp <!--Pour espacement-->
                &nbsp  &nbsp <!--Pour espacement-->
                &nbsp  &nbsp <!--Pour espacement-->
               <div id="imprimerrappordepense"></div>                      
            </form>
            
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading bg-primary text-white">
            Montant dépensé en FC: <label id="montantdepense"></label>&nbsp  &nbsp&nbsp  &nbsp&nbsp  &nbsp&nbsp  &nbsp&nbsp  &nbsp
            Montant dépensé en $: <label id="montantdepenseendollar"></label>
        </div>
        <div class="panel-body">
            <table class="table table-dark table-striped table-bordered">
                <thead>
                <tr>
                    <th>
                        Motif
                    </th>
                    <th>
                        Montant
                    </th>
                    <th>
                       Date
                    </th>

                    <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                        <th>
                            Action
                        </th>
                    <?php } ?> 
                </tr>
                </thead>
                <tbody id="tbodydepense">
                  
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
    

function chargementdepense() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
                    $('#loadingState').show();
                var url = 'chargementdepense.php';
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
                   
                    var depenses = donnee.depense;
                   if(donnee.sommefranc)
                   {
                    document.getElementById('montantdepense').innerText =  donnee.sommefranc+' '+'FC';
                   }
                   else
                   {
                    document.getElementById('montantdepense').innerText =  '0'+' '+'FC';
                   }

                   if(donnee.sommedollar)
                   {
                    document.getElementById('montantdepenseendollar').innerText =  donnee.sommedollar+' '+'$';
                   }
                   else
                   {
                    document.getElementById('montantdepenseendollar').innerText =   '0'+' '+'$';
                   }
                    var roleuser=donnee.utilisateur;
                    if(depenses.length == 0){
                        document.getElementById('imprimerrappordepense').style.display='none';
                    }
                    else
                    {
                        var casetous = 'tous';
                        document.getElementById('imprimerrappordepense').style.display='block';
                        document.getElementById("imprimerrappordepense").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportdepenses.php?infodepense=" + casetous + "\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = depenses.length;
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

                                displayRecords = depenses.slice(displayRecordsIndex, endRec);
                               
                                $('#tbodydepense').empty();
                                    
                                for (var i = 0; i < displayRecords.length; i++) {
                                    document.getElementById('param').value='suppression';
                                    var idDepense = displayRecords[i]['id_depense'];
                                    var ulrModification = "editerdepense.php?iddepense="+idDepense;
                                    var ulrSuppression = "chargementdepense.php?iddepense="+idDepense;

                                    if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                     
                                    $("#tbodydepense").append('<tr>' +
                                        '<td>'+displayRecords[i]['motif']+'</td>' +
                                        '<td>'+displayRecords[i]['montant']+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td>'+displayRecords[i]['date_depense']+'</td>' +                                        
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer depense"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer depense" onclick="Confirm_Delete('+idDepense+')" ><i class="far fa-trash-alt"></span></button></td>' +                                                                                          
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

                case 'pardate':
                    var url = 'chargementdepense.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: {'pdate':document.getElementById('pdate').value,'param':document.getElementById('param').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var depenses = donnee.depense;
                    var roleuser=donnee.utilisateur;
                   // $('#montantdepense').empty();
                   
                   document.getElementById('montantdepense').innerText =  donnee.sommefranc+' '+'$';
                    document.getElementById('montantdepenseendollar').innerText =  donnee.sommedollar+' '+'$';

                    if(depenses.length == 0){
                        document.getElementById('imprimerrappordepense').style.display='none';
                    }
                    else
                    {
                        var parametr = 'pardate';
                        var datedepe = document.getElementById('pdate').value;
                        document.getElementById('imprimerrappordepense').style.display='block';
                        document.getElementById("imprimerrappordepense").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportdepenses.php?infodepense=" + parametr + "&parametre="+ datedepe +"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = depenses.length;
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

                                displayRecords = depenses.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux depenses
                                
                                    $('#tbodydepense').empty();
                                //var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                for (var i = 0; i < displayRecords.length; i++) {
                                    //document.getElementById('param').value='suppression';
                                    var idDepense = displayRecords[i]['id_depense'];
                                    var ulrModification = "editerdepense.php?iddepense="+idDepense;
                                    var ulrSuppression = "supprimerdepense.php?iddepense="+idDepense;

                                    if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    
                                    $("#tbodydepense").append('<tr>' +
                                        '<td>'+displayRecords[i]['motif']+'</td>' +
                                        '<td>'+displayRecords[i]['montant']+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td>'+displayRecords[i]['date_depense']+'</td>' +                                        
                                        '<td style="visibility:'+visibilite+';">'+
                                        '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer depense"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer depense" onclick="Confirm_Delete('+idDepense+')" ><i class="far fa-trash-alt"></span></button></td>' +                                                                                          
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

                case 'datedebut':
                    var url = 'chargementdepense.php';
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
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var depenses = donnee.depense;
                    var roleuser=donnee.utilisateur;
                   // $('#montantdepense').empty();
                    document.getElementById('montantdepense').innerText =  donnee.sommefranc+' '+'$';
                    document.getElementById('montantdepenseendollar').innerText =  donnee.sommedollar+' '+'$';
                    if(depenses.length == 0){
                        document.getElementById('imprimerrappordepense').style.display='none';
                    }
                    else
                    {
                        var parametr = 'datedebut';
                        var datedebut = document.getElementById('datedebut').value;
                        var datefin = document.getElementById('datefin').value;
                        document.getElementById('imprimerrappordepense').style.display='block';
                        document.getElementById("imprimerrappordepense").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportdepenses.php?infodepense=" + parametr + "&datedbt="+ datedebut +"&datefin="+datefin+"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = depenses.length;
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

                                displayRecords = depenses.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux depenses
                                
                                    $('#tbodydepense').empty();
                                //var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                for (var i = 0; i < displayRecords.length; i++) {
                                    document.getElementById('param').value='suppression';
                                    var idDepense = displayRecords[i]['id_depense'];
                                    var ulrModification = "editerdepense.php?iddepense="+idDepense;
                                    var ulrSuppression = "supprimerdepense.php?iddepense="+idDepense;

                                    if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    
                                    $("#tbodydepense").append('<tr>' +
                                        '<td>'+displayRecords[i]['motif']+'</td>' +
                                        '<td>'+displayRecords[i]['montant']+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td>'+displayRecords[i]['date_depense']+'</td>' +                                        
                                        '<td style="visibility:'+visibilite+';">'+
                                        '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer depense"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer depense" onclick="Confirm_Delete('+idDepense+')" ><i class="far fa-trash-alt"></span></button></td>' +                                                                                          
                                    '</tr>');
                                }
                                                            
                            }
                        });
                    }

                    //$('#loadingState').hide();href="'+ulrSuppression+'"
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    //swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    console.log(data);
                }
            }); 
                break;
                case 'motif':
                    var url = 'chargementdepense.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,'motif':document.getElementById('motif').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var depenses = donnee.depense;
                    var roleuser=donnee.utilisateur;
                   // $('#montantdepense').empty();
                    document.getElementById('montantdepense').innerText =  donnee.somme+' '+'$';
               
                    if(depenses.length == 0){
                        document.getElementById('imprimerrappordepense').style.display='none';
                    }
                    else
                    {
                        var parametr = 'parmotif';
                        var pmotif = document.getElementById('motif').value;
                        document.getElementById('imprimerrappordepense').style.display='block';
                        document.getElementById("imprimerrappordepense").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportdepenses.php?infodepense=" + parametr + "&parametre="+ pmotif +"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = depenses.length;
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

                                displayRecords = depenses.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux depenses
                                
                                    $('#tbodydepense').empty();
                                //var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                for (var i = 0; i < displayRecords.length; i++) {
                                    //document.getElementById('param').value='suppression';
                                    var idDepense = displayRecords[i]['id_depense'];
                                    var ulrModification = "editerdepense.php?iddepense="+idDepense;
                                    var ulrSuppression = "supprimerdepense.php?iddepense="+idDepense;

                                    if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    
                                    $("#tbodydepense").append('<tr>' +
                                        '<td>'+displayRecords[i]['motif']+'</td>' +
                                        '<td>'+displayRecords[i]['montant']+'</td>' +
                                        '<td>'+displayRecords[i]['date_depense']+'</td>' +                                        
                                        '<td style="visibility:'+visibilite+';">'+
                                        '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer depense"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer depense" onclick="Confirm_Delete('+idDepense+')" ><i class="far fa-trash-alt"></span></button></td>' +                                                                                      
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

            case 'inserer': 
            var url = 'chargementdepense.php';
            $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'motif':document.getElementById('motif').value,
                        'montant':document.getElementById('montant').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {

                            swal("Dépense bien enregistrée");                        
                            $('#motif').val('');
                            $('#montant').val('');
                        },
                        error: function (data) {
                            alert("Erreur enregistrement dépense");
                        }
                    });
            break;

            case 'modifier': 
            var url = 'chargementdepense.php';
            $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'motif':document.getElementById('motif').value,
                        'montant':document.getElementById('montant').value,
                        'datedep':document.getElementById('datedep').value,
                        'iddepense':document.getElementById('iddepense').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {

                            var donnee = jQuery.parseJSON(data);
                   
                            var depenses = donnee.depense;
                           /*$('#montantdepense').empty();  motif montant datedep
                            document.getElementById('motif').innerText =  donnee.motif;
                            document.getElementById('montant').innerText =  donnee.montant;
                            document.getElementById('datedep').innerText =  donnee.datedepense;*/
                            swal("Dépense bien modifiée");                        
                            //$('#motif').val('');
                            //$('#montant').val('');
                        },
                        error: function (data) {
                            swal("Erreur modification dépense");
                        }
                    });
            break;
            case 'chargerchampmodifier':
                var url = 'chargementdepense.php';
                $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value,                            
                            'iddepense':document.getElementById('iddepense').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                               var donnee = jQuery.parseJSON(data);                                                                               
                                $('#motif').val(donnee.motif);
                                $('#montant').val(donnee.montant);
                                $('#datedep').val(donnee.datedepense);
                            },
                            error: function (data) {
                                swal("Erreur chargement champ modification");
                            }
                        });
            break;
        }              
}


    $("input[type=radio][name=rechercherdepense]").change(function() {
        switch ($(this).val())
        {
            case'tous':
                document.getElementById('pdate').disabled = true;                             
                document.getElementById('datedebut').disabled = true;            
                document.getElementById('datefin').disabled = true;   
                document.getElementById('motif').disabled = true;    
                document.getElementById('tous').checked = true;    
                document.getElementById('tous').value = 'tous'; 
            break;
    
            case'motiff':
                document.getElementById('pdate').disabled = true;                             
                document.getElementById('datedebut').disabled = true;            
                document.getElementById('datefin').disabled = true;      
                document.getElementById('motif').disabled = false;  
                document.getElementById('motif').value = "";    
                document.getElementById('motiff').checked = true;
            break;
    
            case'pardate':
                document.getElementById('pdate').disabled = false;                                
                document.getElementById('datedebut').disabled = true;            
                document.getElementById('datefin').disabled = true;           
                document.getElementById('motif').disabled = true; 
                document.getElementById('pardate').checked = true;  
            break;        
    
            case'parperiode':
                document.getElementById('pdate').disabled = true;                             
                document.getElementById('datedebut').disabled = false;            
                document.getElementById('datefin').disabled = false;   
                document.getElementById('motif').disabled = true;  
                document.getElementById('parperiode').checked = true; 
            break;
        }  
    });

     $('#recherchedepense').on('click', function(){
        $('#tbodydepense').empty();
        chargementdepense();
        });

function Confirm_Delete(idsuppresion) 

{
    swal({
        title: "Suppression !",
        text: "Voulez-vous vraiment supprimer cette depense?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               deleteDepense(idsuppresion);
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
}  

function deleteDepense(idsuppresion){
    var url = 'chargementdepense.php';
    $.ajax({
                type: 'GET',
                url: url,
                data:{'param':document.getElementById('param').value='suppression','iddepense':idsuppresion},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    swal('Dépense supprimée');                   
                    //chargementdepense();                   
                   //$('#loadingState').hide();                   
                   chargementdepense();
                },
                error: function (data) {
                    swal('Erreur suppression depense');
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    //swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    //console.log(data);
                }
            }); 
}



function desactivertoutedepense()
{   
    document.getElementById('pdate').disabled = true;                             
    document.getElementById('datedebut').disabled = true;            
    document.getElementById('datefin').disabled = true;   
    document.getElementById('motif').disabled = true;    
    document.getElementById('tous').checked = true;    
    document.getElementById('tous').value = 'tous';  
}



function verifForm(formulaire)
{

    var mailOk = verifMail(formulaire.email);
    if(mailOk)
    {
        return true;
    }
    else
    {
        alert("Veuillez remplir correctement le champ email");
        return false;
    }
}

function verifprix(champ)
{
    var qte = parseFloat(champ.value);
    if(isNaN(qte))
    {
        surligne(champ, true);
        alert("Ce champ doit contenir une valeur numérique et nom un text");
        return false;
    }
    else
    {
        surligne(champ, false);
        return true;
    }
}

function champnovide(champ)
{
    var valeur = champ.value.length;
    if(valeur===0)
    {
        surligne(champ, true);
        alert("Ce champ ne doit pas être vide");
        return false;
    }
    else
    {
        surligne(champ, false);
        return true;
    }
}
</script>

