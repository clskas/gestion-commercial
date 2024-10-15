
<?php
require_once('identifier.php');
require_once('connexiondb.php');
    
?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Gestion de paiement</title>
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
<body onload="desactivertoutpaiement();document.getElementById('param').value='tous';chargementpaiment();">
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success margetop">
        <div class="panel-heading bg-primary text-white">
            Recherche sur le paiement ...
        </div>
        <div class="panel-body ">
            <form method="GET" class="form-inline" id="paiem">
                <div class="form-group " > 
                   <input type="radio" id="tous" name="rechercherpaiement" 
                    onclick="document.getElementById('param').value='tous';desactivertout();" value="tous"/>
                    <label for="tous">Tous les paiements</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                                  
                    <input type="radio" id="numerofac" name="rechercherpaiement" value="numerofac"/> 
                     <label for="produit">Par facture </label>
                     &nbsp  &nbsp <!--Pour espacement-->
                     &nbsp  &nbsp <!--Pour espacement-->                               
                    &nbsp  &nbsp <!--Pour espacement-->
              
                    <input type="radio" id="pardate" name="rechercherpaiement"  value="pardate"/> 
                     <label for="pardate">Par date</label>                   
                     &nbsp  &nbsp <!--Pour espacement-->
                     &nbsp  &nbsp <!--Pour espacement-->
                     &nbsp  &nbsp <!--Pour espacement-->
                     &nbsp  &nbsp <!--Pour espacement-->
                    <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                        <a href="nouveaupaiement.php" class="stron">
                            <span class="glyphicon glyphicon-plus"></span>
                            Nouveau paiement
                        </a>
                    <?php } ?>
                     <input type="text" id="param" name="param" style="visibility:hidden;" /> 
                </div>
                <div class="form-group largeur100 ">  
                    <div class="form-group">
                        <input type="text" name="numerofacture" id="numerofacture" 
                            class="form-control" onblur="document.getElementById('param').value='parfacture'"/>
                    </div>

                    <div class="form-group">
                        <label for="datep">Date</label>
                        <input type="date" name="datep" id="datep" 
                        onblur="document.getElementById('param').value='pardate'"/>
                    </div>                   
                </div>
                <div class="form-group "> 
                    <button type="button" class="btn btn-success" id="recherchepaiement" name="recherchepaiement" value="Rechercher" style="margin-top:10px;">
                        <i class="fas fa-search"></i> Rechercher...
                    </button>                                                                                                   
                </div> 
                <div class="spinner-border text-primary " id="loadingState"></div> 
            </form>
            <div id="imprimerrapportpaiement"></div>

        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading bg-primary text-white">
            Montant payé en Fc: <label id="montantpaye"></label>&nbsp  &nbsp&nbsp  &nbsp&nbsp  &nbsp&nbsp  &nbsp&nbsp  &nbsp
            Montant payé en $: <label id="montantpayeendollar"></label>
            &nbsp  &nbsp&nbsp  &nbsp&nbsp  &nbsp&nbsp  &nbsp&nbsp 
            Reste en Fc: <label id="resteenfranc"></label>&nbsp  &nbsp&nbsp  &nbsp&nbsp  &nbsp&nbsp  &nbsp&nbsp  &nbsp
            Reste en $: <label id="resteendollar"></label>
        </div>
        <div class="panel-body">
            <table class="table table-dark table-striped">
                <thead>
                <tr>
                    <th>
                        Numero facture
                    </th>
                    <th>
                        Nom client
                    </th>
                    <th>
                        Date paiement
                    </th>
                    <th>
                        Montant à payer 
                    </th>

                    <th>
                        Montant payé 
                    </th>

                    <th>
                        Rester 
                    </th>

                    <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                        <th>
                            Action
                        </th>
                    <?php } ?>
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
                $('#loadprogressbar').show();
                var url = 'chargementpaie.php';
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
                   
                    var paye = donnee.paie;
                    var roleuser=donnee.user;
                    var montantenfcongo = parseFloat(donnee.montantenfc);
                    var montantenfc = montantenfcongo.toFixed(4);

                    var montantendollars = parseFloat(donnee.montantendollar);
                    var montantendollar = montantendollars.toFixed(4);

                    var resteenfc = parseFloat(donnee.resteenfranc);
                    var resteenfcongolais = resteenfc.toFixed(4);

                    var resteendollar = parseFloat(donnee.resteendollar);
                    var resteendolar = resteendollar.toFixed(4);
                   
                    if(donnee.montantenfc) 
                    {
                        document.getElementById('montantpaye').innerText =  montantenfc+' '+'FC';
                        document.getElementById('resteenfranc').innerText = resteenfcongolais +' '+'FC';
                    }                                         
                    else
                    {
                        document.getElementById('montantpaye').innerText =  '0'+' '+'FC';
                        document.getElementById('resteenfranc').innerText =  '0'+' '+'FC';
                    }
                    
                    if(donnee.montantendollar)
                    {
                        document.getElementById('montantpayeendollar').innerText =  montantendollar+' '+'$';
                        document.getElementById('resteendollar').innerText =  resteendolar+' '+'$';
                    }
                    else
                    {
                        document.getElementById('montantpayeendollar').innerText =   '0'+' '+'$';
                        document.getElementById('resteendollar').innerText =   '0'+' '+'$';
                    }
                    //var donnee = jQuery.parseJSON(data); 
                           
                    if(paye.length == 0){
                        document.getElementById('imprimerrapportpaiement').style.display='none';
                    }else{
                        var rapportpaie = 'tous';
                        document.getElementById('imprimerrapportpaiement').style.display='block';
                        document.getElementById("imprimerrapportpaiement").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportpaiement.php?infopaiement=" + rapportpaie + "\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = paye.length;
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

                                displayRecords = paye.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux depenses
                                
                                    $('#tbodypaie').empty();
                                var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";

                                    for (var i = 0; i < displayRecords.length; i++) {
                                        //.toFixed(4)
                                        var idpaiement = displayRecords[i]['id_paiement'];
                                        var ulrModification = "editerpaiement.php?idpaiement="+idpaiement;
                                        var ulrSuppression = "supprimerpaiement.php?idpaiement="+idpaiement;
                                        var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
                                        var montantapayers = parseFloat(displayRecords[i]['montant_a_paye']);
                                        var montantapayer = montantapayers.toFixed(4);
                                        var montantpayers = parseFloat(displayRecords[i]['montant_paye']);
                                        var montantpayer = montantpayers.toFixed(4);
                                        var restes = parseFloat(displayRecords[i]['reste']);
                                        var reste = restes.toFixed(4);
                                        if( roleuser != 'ADMIN')                                    
                                            var visibilite = "hidden";
                                      $("#tbodypaie").append('<tr>' + 
                                        '<td>'+displayRecords[i]['numerofacture']+'</td>' +
                                        '<td>'+displayRecords[i]['client']+'</td>' +
                                        '<td>'+displayRecords[i]['date_paiement']+'</td>' +
                                        '<td>'+montantapayer+' '+displayRecords[i]['monnaie']+'</td>' + 
                                        '<td>'+montantpayer+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td>'+reste+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer paiement"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer paiement" onclick="Confirm_Deletepaiement('+idpaiement+')" ><i class="far fa-trash-alt"></button></td>' +                                                                                                                        
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
                    $('#loadingState').show();
                    var url = 'chargementpaie.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: {'datepaie':document.getElementById('datep').value,
                    'param':document.getElementById('param').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var paye = donnee.paie;
                    var roleuser=donnee.user;

                    var resteenfc = parseFloat(donnee.resteenfranc);
                    var resteenfcongolais = resteenfc.toFixed(4);

                    var resteendollar = parseFloat(donnee.resteendollar);
                    var resteendolar = resteendollar.toFixed(4);
                   
                    if(donnee.montantenfc) 
                    {
                        document.getElementById('montantpaye').innerText =  donnee.montantenfc+' '+'FC';
                        document.getElementById('resteenfranc').innerText = resteenfcongolais +' '+'FC';
                    }                                         
                    else
                    {
                        document.getElementById('montantpaye').innerText =  '0'+' '+'FC';
                        document.getElementById('resteenfranc').innerText =  '0'+' '+'FC';
                    }
                    
                    if(donnee.montantendollar)
                    {
                        document.getElementById('montantpayeendollar').innerText =  donnee.montantendollar+' '+'$';
                        document.getElementById('resteendollar').innerText =  resteendolar+' '+'$';
                    }
                    else
                    {
                        document.getElementById('montantpayeendollar').innerText =   '0'+' '+'$';
                        document.getElementById('resteendollar').innerText =   '0'+' '+'$';
                    }
               
                    if(paye.length == 0){
                        document.getElementById('imprimerrapportpaiement').style.display='none';
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
                        var parametr = 'pardate';
                        document.getElementById('imprimerrapportpaiement').style.display='block';
                        var datepaiem = document.getElementById('datep').value;
                        var rapportpaiepardate = datepaiem;
                        document.getElementById("imprimerrapportpaiement").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportpaiement.php?infopaiement=" + parametr + "&parametre="+ rapportpaiepardate +"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = paye.length;
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

                                displayRecords = paye.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux depenses
                                
                                    $('#tbodypaie').empty();
                                var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";

                                    for (var i = 0; i < displayRecords.length; i++) {
                                        var idpaiement = displayRecords[i]['id_paiement'];
                                        var ulrModification = "editerpaiement.php?idpaiement="+idpaiement;
                                        var ulrSuppression = "supprimerpaiement.php?idpaiement="+idpaiement;
                                        var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
                                        var montantapayers = parseFloat(displayRecords[i]['montant_a_paye']);
                                        var montantapayer = montantapayers.toFixed(4);
                                        var montantpayers = parseFloat(displayRecords[i]['montant_paye']);
                                        var montantpayer = montantpayers.toFixed(4);
                                        var restes = parseFloat(displayRecords[i]['reste']);
                                        var reste = restes.toFixed(4);
                                        if( roleuser != 'ADMIN')                                    
                                            var visibilite = "hidden";
                                      $("#tbodypaie").append('<tr>' + 
                                        '<td>'+displayRecords[i]['numerofacture']+'</td>' +
                                        '<td>'+displayRecords[i]['client']+'</td>' +
                                        '<td>'+displayRecords[i]['date_paiement']+'</td>' +
                                        '<td>'+montantapayer+' '+displayRecords[i]['monnaie']+'</td>' + 
                                        '<td>'+montantpayer+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td>'+reste+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer paiement"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer paiement" onclick="Confirm_Deletepaiement('+idpaiement+')" ><i class="far fa-trash-alt"></button></td>' +                                                                                   
                                       
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

                case 'parfacture':
                    $('#loadingState').show();
                    var url = 'chargementpaie.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,'numfacture':document.getElementById('numerofacture').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var paye = donnee.paie;
                    var roleuser=donnee.user;

                    var resteenfc = parseFloat(donnee.resteenfranc);
                    var resteenfcongolais = resteenfc.toFixed(4);

                    var resteendollar = parseFloat(donnee.resteendollar);
                    var resteendolar = resteendollar.toFixed(4);
                   
                    if(donnee.montantenfc) 
                    {
                        document.getElementById('montantpaye').innerText =  donnee.montantenfc+' '+'FC';
                        document.getElementById('resteenfranc').innerText = resteenfcongolais +' '+'FC';
                    }                                         
                    else
                    {
                        document.getElementById('montantpaye').innerText =  '0'+' '+'FC';
                        document.getElementById('resteenfranc').innerText =  '0'+' '+'FC';
                    }
                    
                    if(donnee.montantendollar)
                    {
                        document.getElementById('montantpayeendollar').innerText =  donnee.montantendollar+' '+'$';
                        document.getElementById('resteendollar').innerText =  resteendolar+' '+'$';
                    }
                    else
                    {
                        document.getElementById('montantpayeendollar').innerText =   '0'+' '+'$';
                        document.getElementById('resteendollar').innerText =   '0'+' '+'$';
                    }
               
                    if(paye.length == 0){
                        document.getElementById('imprimerrapportpaiement').style.display='none';
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
                        document.getElementById('imprimerrapportpaiement').style.display='block';
                        var parametreparfacture = 'parfacture';
                        var numefacture = document.getElementById('numerofacture').value;
                        var rapportpaieparfacture = numefacture;
                        document.getElementById("imprimerrapportpaiement").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportpaiement.php?infopaiement=" + parametreparfacture + "&parametre="+ rapportpaieparfacture +"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = paye.length;
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
                                displayRecords = paye.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux depenses                              
                                    $('#tbodydepense').empty();
                                    for (var i = 0; i < displayRecords.length; i++) {
                                        var idpaiement = displayRecords[i]['id_paiement'];
                                        var ulrModification = "editerpaiement.php?idpaiement="+idpaiement;
                                        var ulrSuppression = "supprimerpaiement.php?idpaiement="+idpaiement;
                                        var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
                                        var montantapayers = parseFloat(displayRecords[i]['montant_a_paye']);
                                        var montantapayer = montantapayers.toFixed(4);
                                        var montantpayers = parseFloat(displayRecords[i]['montant_paye']);
                                        var montantpayer = montantpayers.toFixed(4);
                                        var restes = parseFloat(displayRecords[i]['reste']);
                                        var reste = restes.toFixed(4);
                                        if( roleuser != 'ADMIN')                                    
                                            var visibilite = "hidden";
                                      $("#tbodypaie").append('<tr>' + 
                                        '<td>'+displayRecords[i]['numerofacture']+'</td>' +
                                        '<td>'+displayRecords[i]['client']+'</td>' +
                                        '<td>'+displayRecords[i]['date_paiement']+'</td>' +
                                        '<td>'+montantapayer+' '+displayRecords[i]['monnaie']+'</td>' + 
                                        '<td>'+montantpayer+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td>'+reste+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer paiement"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer paiement" onclick="Confirm_Deletepaiement('+idpaiement+')" ><i class="far fa-trash-alt"></button></td>' +                                                                                   
                                       
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
                }
            }); 
                break;
               
                case 'inserer': 
                var url = 'chargementpaie.php';
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,                       
                        'montant_paye':document.getElementById('montant_paye').value,
                        'numerofacture':document.getElementById('numerofacture').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {

                            swal("Paiement bien enregistré");                        
                            $('#montant_paye').val('');
                            $('#numerofacture').val('');
                            $('#montant_apaye').val('');
                           
                        },
                        error: function (data) {
                            alert("Erreur enregistrement paiement");
                        }
                    });
            break;

             case 'modifier': 
            var url = 'chargementpaie.php';
            $.ajax({
                        type: 'GET',
                        url: url,
                         data:{'param':document.getElementById('param').value,                       
                        'montant_paye':document.getElementById('montant_paye').value,
                        'datepaie':document.getElementById('datepaie').value,
                        'numerofacture':document.getElementById('numerofacture').value,
                        'idpaiem':document.getElementById('idpaiem').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {

                            var donnee = jQuery.parseJSON(data);
                                              
                            swal("Paiement bien modifié");                        
                            
                        },
                        error: function (data) {
                            swal("Erreur modification paiement");
                        }
                    });
            break;
            case 'chargerchampmodifier':
                var url = 'chargementpaie.php';
                $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value,                            
                            'idpaiement':document.getElementById('idpaiem').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {  
                               var donnee = jQuery.parseJSON(data);                                                                               
                                $('#datepaie').val(donnee.datepaiement);
                                $('#montant_apaye').val(donnee.montantapayer);
                                $('#montant_paye').val(donnee.montantpaye);
                               
                                var commandes = donnee.commandes; 
                                var select = $("#numerofactureedit");                          
                                select.empty(); 
                   
                            for (var i = 0; i < commandes.length; i++) {     
                                                      
                                select.append('<option value="' +commandes[i]['Com_num'] +'">' + commandes[i]['Com_num'] + '</option>');                 
                            }  
                            
                            $("#numerofactureedit").val(donnee.numerofacture);
                            },
                            error: function (data) {
                                swal("Erreur chargement champ modification");
                            }
                        });
            break; 
            
        
            case 'recup_commande':
                var url = 'chargementpaie.php';
                $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value,                            
                            'numerofacture':document.getElementById('numerofacture').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                               var donnee = jQuery.parseJSON(data); 
                                                                                                       
                                $('#montant_apaye').val(donnee.commandes);                               
                               
                            },
                            error: function (data) {
                                swal("Erreur recupération numéro facture");
                            }
                        });
            break;
        }              
    }

   $('#recherchepaiement').on('click', function(){
        $('#tbodypaie').empty();
        chargementpaiment();          
        });

function Confirm_Deletepaiement(idpaiement) 

{
    swal({
        title: "Suppression !",
        text: "Voulez-vous vraiment supprimer ce paiement?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               deletepaiement(idpaiement)
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
}  

function deletepaiement(idpaiement){
    var url = 'chargementpaie.php';
    $.ajax({
                type: 'GET',
                url: url,
                data:{'param':document.getElementById('param').value='suppression','idpaiement':idpaiement},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    swal("Paiement supprimé avec succès");                   
                    //chargementdepense();                   
                   //$('#loadingState').hide();
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    //swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    //console.log(data);
                }
            }); 
}  

$("input[type=radio][name=rechercherpaiement]").change(function() {
    switch ($(this).val())
    {
        case'tous':
            document.getElementById('datep').disabled = true;                                           
            document.getElementById('numerofacture').disabled = true;    
            document.getElementById('tous').checked = true;    
            document.getElementById('tous').value = 'tous'; 
        break;

        case'numerofac':
            document.getElementById('datep').disabled = true;                                  
            document.getElementById('numerofacture').disabled = false;  
            document.getElementById('numerofacture').value = "";    
            document.getElementById('numerofac').checked = true;
        break;

        case'pardate':
            document.getElementById('datep').disabled = false;                                                    
            document.getElementById('numerofacture').disabled = true; 
            document.getElementById('pardate').checked = true;  
        break;
      
    }
    
});

function desactivertoutpaiement()
{   
    document.getElementById('datep').disabled = true;                                       
    document.getElementById('numerofacture').disabled = true;    
    document.getElementById('tous').checked = true;    
    document.getElementById('tous').value = 'tous';  
}

function cacherboutonimprimer()
{   
    document.getElementById('imprimerrapportpaiement').style.display='none';
    //document.getElementById('imprimerrapportpaiement').style.display='block';
}
</script>
