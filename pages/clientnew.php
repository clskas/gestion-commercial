
<?php
require_once('identifier.php');
require_once('connexiondb.php');   
?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Gestion des clients</title>
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
<body onload="desactivertoutclient();document.getElementById('param').value='tous';chargementclients();">
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success margetop">
        <div class="panel-heading bg-primary text-white stron">
            Recherche sur les fournisseurs ...
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline">
                <div class="form-group">
                   <input type="radio" id="tous" name="rechercherclient" 
                    onclick="document.getElementById('param').value='tous';desactivertout();" value="tous"/>
                    <label for="tous">Tous les clients</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                                  
                    <input type="radio" id="nomf" name="rechercherclient" value="nomfourn"/> 
                     <label for="nomf">Par nom ou prenom</label>
                     &nbsp  &nbsp <!--Pour espacement-->
                     &nbsp  &nbsp <!--Pour espacement-->                                 
                     &nbsp  &nbsp <!--Pour espacement-->             
                    <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                        <a href="nouveauclient.php">
                            <span class="glyphicon glyphicon-plus"></span>
                            Nouveau client
                        </a>
                    <?php } ?>
                     <input type="text" id="param" name="param" style="visibility:hidden;" /> 
                </div>
                
                <div class="form-group largeur100">
                    <input type="text" name="nom" id="nom" 
                        class="form-control" onblur="document.getElementById('param').value='parnom'"/>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-success" id="rechercheclient" name="rechercheclient" value="Rechercher" style="margin-top:10px;">
                        <i class="fas fa-search"></i> Rechercher...
                    </button>
                    <div class="spinner-border text-primary" id="loadingState"></div> 
                </div>
                &nbsp  &nbsp <!--Pour espacement-->
                &nbsp  &nbsp <!--Pour espacement-->
                &nbsp  &nbsp <!--Pour espacement-->
                <div id="imprimerrapportclient"></i></div>
            </form>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading bg-primary text-white">
           
        </div>
        <div class="panel-body">
            <table class="table table-dark table-striped">
                <thead>
                <tr>
                    <th>
                        Civilité
                    </th>
                    <th>
                        Nom 
                    </th>
                    <th>
                        Prenom 
                    </th>
                    
                    <th>
                        Téléphone
                    </th>

                    <th>
                        Réseaux sociaux
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Adresse
                    </th>
                    <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                        <th>
                            Action
                        </th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody id="tbodyclient">
                          
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
  
function chargementclients() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
                    $('#loadingState').show();
                var url = 'chargeclient.php';
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
                   
                    var clients = donnee.client;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(clients.length == 0){
                        document.getElementById('imprimerrapportclient').style.display='none';
                    }
                    else
                    {
                        var casetous = 'tous';
                        document.getElementById('imprimerrapportclient').style.display='block';
                        document.getElementById("imprimerrapportclient").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportclients.php?infoclient=" + casetous + "\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = clients.length;
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

                                displayRecords = clients.slice(displayRecordsIndex, endRec);
                               
                                $('#tbodyclient').empty();
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var idClient = displayRecords[i]['Client_num'];
                                    var ulrModification = "editerclient.php?idC="+idClient;
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyclient").append('<tr>' +
                                        '<td>'+displayRecords[i]['Client_civilite']+'</td>' + 
                                        '<td>'+displayRecords[i]['Client_nom']+'</td>' +
                                        '<td>'+displayRecords[i]['Client_prenom']+'</td>' +                                      
                                        '<td>'+displayRecords[i]['telephone']+'</td>' +
                                        '<td>'+displayRecords[i]['reseausocial']+'</td>' +
                                        '<td>'+displayRecords[i]['email']+'</td>' +
                                        '<td>'+displayRecords[i]['adresse']+'</td>' +                                      
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer client"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button  class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer client" onclick="Confirm_Deleteclient('+idClient+')" ><i class="far fa-trash-alt"></i></button></td>' +   
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
                   // console.log(data);
                }
            }); 
                break;

                case 'parnom':
                    $('#loadingState').show();
                    var url = 'chargeclient.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,
                'nom':document.getElementById('nom').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var clients = donnee.client;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(clients.length == 0){
                        document.getElementById('imprimerrapportclient').style.display='none';
                    }
                    else
                    {
                        var parametr = 'parnom';
                        var lesclients = document.getElementById('nom').value;
                        document.getElementById('imprimerrapportclient').style.display='block';
                        document.getElementById("imprimerrapportclient").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportclients.php?infoclient=" + parametr + "&parametre="+ lesclients +"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = clients.length;
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

                                displayRecords = clients.slice(displayRecordsIndex, endRec);
                               
                                    $('#tbodyclient').empty();
                                    
                                for (var i = 0; i < displayRecords.length; i++) {
                                    
                                    var idClient = displayRecords[i]['Client_num'];
                                    var ulrModification = "editerclient.php?idC="+idClient;
                                    //var ulrSuppression = "supprimerfournisseur.php?idC="+idpaiement;
                                   // var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                      $("#tbodyclient").append('<tr>' +
                                        '<td>'+displayRecords[i]['Client_civilite']+'</td>' + 
                                        '<td>'+displayRecords[i]['Client_nom']+'</td>' +
                                        '<td>'+displayRecords[i]['Client_prenom']+'</td>' +                                      
                                        '<td>'+displayRecords[i]['telephone']+'</td>' +
                                        '<td>'+displayRecords[i]['reseausocial']+'</td>' +
                                        '<td>'+displayRecords[i]['email']+'</td>' +
                                        '<td>'+displayRecords[i]['adresse']+'</td>' +                                      
                                        '<td style="visibility:'+visibilite+';">'+
                                        '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer client"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button  class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer client" onclick="Confirm_Deleteclient('+idClient+')" ><i class="far fa-trash-alt"></span></button></td>' +   
                                         
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
                   // console.log(data);
                }
            });                                                                                        
                break; 

                case 'inserer': 
                var url = 'chargeclient.php';
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'nom':document.getElementById('nom').value,
                        'prenom':document.getElementById('prenom').value,
                        'email':document.getElementById('email').value,
                        'telephone':document.getElementById('telephone').value,
                        'reseausocial':document.getElementById('reseausocial').value,
                        'adresse':document.getElementById('adresse').value,
                        'civilite':document.getElementById('civilite').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {

                            swal("Fournisseur bien enregistré");                        
                            $('#nom').val('');
                            $('#prenom').val('');
                            $('#email').val('');
                            $('#telephone').val('');
                            $('#reseausocial').val('');
                            $('#adresse').val('');
                            $('#civilite').val('Monsieur');
                        },
                        error: function (data) {
                            alert("Erreur enregistrement client");
                        }
                    });
            break;
        }              
    }

   $('#rechercheclient').on('click', function(){
        $('#tbodyclient').empty();
        chargementclients();
        });

function Confirm_Deleteclient(idClient) 

{
    swal({
        title: "Suppression !",
        text: "Voulez-vous vraiment supprimer ce client?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               deleteclient(idClient)
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
}  

function deleteclient(idClient){
    var url = 'chargeclient.php';
    $.ajax({
                type: 'GET',
                url: url,
                data:{'param':document.getElementById('param').value='suppression','idC':idClient},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    swal('Client supprimé');                   
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

$("input[type=radio][name=rechercherclient]").change(function() {
    switch ($(this).val())
    {
        case'tous':                                          
            document.getElementById('nom').disabled = true;    
            document.getElementById('tous').checked = true;    
            document.getElementById('tous').value = 'tous'; 
        break;

        case'nomfourn':                                  
            document.getElementById('nom').disabled = false;  
            document.getElementById('nom').value = "";    
            document.getElementById('nomf').checked = true;
        break;      
    }
    
});

function desactivertoutclient()
{   
    document.getElementById('nom').disabled = true;  
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
