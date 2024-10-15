<?php
require_once('identifier.php');
require_once('connexiondb.php'); 
?>

<! DOCTYPE HTML>
<html>
    <head>
        <title>Gestion entreprise</title>
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
    <body onload="desactivertoutentreprise();document.getElementById('param').value='tous';chargemententreprises();">        <?php include("menu.php"); ?>
        <div class="container">
            <div class="panel panel-success margetop">
                <div class="panel-heading bg-primary text-white">
                    Rechercher... 
                </div>
                <div class="panel-body">
                    <form method="POST" class="form-inline">
                        <div class="form-group">
                            <input type="radio" id="tous" name="rechercherentreprise" 
                            onclick="document.getElementById('param').value='tous';" value="tous"/>
                            <label for="tous">Toutes les entreprises</label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                                        
                            <input type="radio" id="nomentrepris" name="rechercherentreprise" value="entreprisename"/> 
                            <label for="nomentrepris">Nom entreprise</label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->                                  
                            &nbsp  &nbsp <!--Pour espacement-->
                    
                            <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                                <a href="nouveauentreprise.php">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Créer une nouvelle entreprise
                                </a>
                            <?php } ?>
                            <input type="text" id="param" name="param" style="visibility:hidden;" /> 
                        </div>
                        <div class="form-group largeur100">
                            <input type="text" name="nomentreprise" id="nomentreprise" 
                            class="form-control" onblur="document.getElementById('param').value='parentreprise'"/>
                        </div>
                            
                        <div class="form-group">
                            <button type="button" class="btn btn-success" id="rechercheentreprise" name="rechercheentreprise" value="Rechercher" style="margin-top:10px;">
                                <i class="fas fa-search"></i> Rechercher...
                            </button>
                            <div class="spinner-border text-primary" id="loadingState"></div> 
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading bg-primary text-white">
                            Les entreprises
                </div>
                <div class="panel-body">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>
                                    Nom entreprise
                                </th>
                                <th>
                                    Réseau social
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Identité Nationale
                                </th>
                                <th>
                                    Numéro téléphone
                                </th>
                                <th>
                                    Adresse
                                </th>
                                <th>
                                    Logo
                                </th>
                                
                                <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                                    <th>
                                        Action
                                    </th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody id="tbodyentreprise">
                          
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
function chargemententreprises() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
                $('#loadingState').show();
                var url = 'chargeentreprise.php';
                $.ajax({
                type: 'POST',
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
                   
                    var entreprises = donnee.entreprise;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(entreprises.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
                        totalRecords = entreprises.length;
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
                                displayRecords = entreprises.slice(displayRecordsIndex, endRec);                              
                                $('#tbodyentreprise').empty();                                   
                                for (var i = 0; i < displayRecords.length; i++) {                                                                   
                                    var identreprise = displayRecords[i]['id_entreprise'];
                                    var ulrModification = "editerentreprise.php?identreprise="+identreprise;                      
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";                                
                                    $("#tbodyentreprise").append('<tr>' +
                                        '<td>'+displayRecords[i]['nom_entreprise']+'</td>' + 
                                        '<td>'+displayRecords[i]['reseausocial']+'</td>' +
                                        '<td>'+displayRecords[i]['emailentreprise']+'</td>' +                                      
                                        '<td>'+displayRecords[i]['identite_nationale']+'</td>' +
                                        '<td>'+displayRecords[i]['Telephone']+'</td>' +
                                        '<td>'+displayRecords[i]['adresse']+'</td>' +
                                        '<td>'+'<img src="../images/'+displayRecords[i]['logo']+'" width="50px" height="50px" class="img-circle">'+'</td>' +                                      
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer entreprise"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer entreprise" onclick="Confirm_Deleteentreprise('+identreprise+')" ><i class="far fa-trash-alt"></button></td>' +                                                                                                                        
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

                case 'parentreprise':
                    $('#loadingState').show();
                    var url = 'chargeentreprise.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,
                'nomentr':document.getElementById('nomentreprise').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var entreprises = donnee.entreprise;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(entreprises.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
                        totalRecords = entreprises.length;
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

                                displayRecords = entreprises.slice(displayRecordsIndex, endRec);
                               
                                    $('#tbodyentreprise').empty();
                                    
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var identreprise = displayRecords[i]['id_entreprise'];
                                    var ulrModification = "editerentreprise.php?identreprise="+identreprise;                      
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";                                
                                    $("#tbodyentreprise").append('<tr>' +
                                        '<td>'+displayRecords[i]['nom_entreprise']+'</td>' + 
                                        '<td>'+displayRecords[i]['reseausocial']+'</td>' +
                                        '<td>'+displayRecords[i]['emailentreprise']+'</td>' +                                      
                                        '<td>'+displayRecords[i]['identite_nationale']+'</td>' +
                                        '<td>'+displayRecords[i]['Telephone']+'</td>' +
                                        '<td>'+displayRecords[i]['adresse']+'</td>' +
                                        '<td>'+'<img src="../images/'+displayRecords[i]['logo']+'" width="50px" height="50px" class="img-circle">'+'</td>' +                                      
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer entreprise"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer entreprise" onclick="Confirm_Deleteentreprise('+identreprise+')" ><i class="far fa-trash-alt"></button></td>' +                                                                                                                        
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
                var url = 'chargeentreprise.php';
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'nom_entreprise':document.getElementById('editnomentreprise').value,
                        'emaile':document.getElementById('editemailentre').value,
                        'Telephone':document.getElementById('edittelephone').value,
                        'reseausocial':document.getElementById('editreseausocio').value,
                        'adresse':document.getElementById('editadresseentreprise').value,
                        'logo':document.getElementById('logo').value,
                        'identite_nationale':document.getElementById('editidentitenationale').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {
                                                                     
                            swal("Entreprise bien enregistrée");                        
                            $('#editnomentreprise').val('');
                            //$('#logo').val('');
                            $('#editemailentre').val('');
                            $('#edittelephone').val('');
                            $('#editreseausocio').val('');
                            $('#editadresseentreprise').val('');
                            $('#editidentitenationale').val('');
                        },
                        error: function (data) {
                            alert("Erreur enregistrement client");
                        }
                    });
            break;

             case 'modifier': 
            var url = 'chargeentreprise.php';
            $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'nom_entreprise':document.getElementById('nomentreprise').value,
                        'emaile':document.getElementById('emailentre').value,
                        'Telephone':document.getElementById('telephoneeentreprise').value,
                        'reseausocial':document.getElementById('reseausocio').value,
                        'adresse':document.getElementById('adresseentreprise').value,
                        'logo':document.getElementById('photo').value,
                        'identite_nationale':document.getElementById('identitenationale').value,
                        'identreprise':document.getElementById('identreprise').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {                              
                            swal("Entreprise bien modifiée");                                                   
                        },
                        error: function (data) {
                            swal("Erreur modification entreprise");
                        }
                    });
            break;
            case 'chargerchampmodifier':
                var url = 'chargeentreprise.php';
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,                            
                        'identreprise':document.getElementById('identreprise').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {   
                            var donnee = jQuery.parseJSON(data);                                                                               
                            $('#nomentreprise').val(donnee.nomentreprise);
                            $('#identitenationale').val(donnee.idn);
                            $('#emailentre').val(donnee.email);
                            $('#telephoneeentreprise').val(donnee.telephone);
                            $('#reseausocio').val(donnee.reseausocial);
                            $('#adresseentreprise').val(donnee.adresseentreprise);
                            $('#photo').val(donnee.logo);
                            }                                                                     
                    });
            break;
        }              
    }
    $('#rechercheentreprise').on('click', function(){
        $('#tbodyentreprise').empty();
        chargemententreprises();
        });


function Confirm_Deleteentreprise(identreprise) 
{
    swal({
        title: "Suppression !",
        text: "Voulez-vous vraiment supprimer cette entreprise?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               deleteentreprise(identreprise)
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
}  

function deleteentreprise(identreprise){
    var url = 'chargeentreprise.php';
    $.ajax({
        type: 'POST',
        url: url,
        data:{'param':document.getElementById('param').value='suppression','identreprise':identreprise},
        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
        success: function (data) {
            swal("Entreprise supprimée avec succès");                   
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

$("input[type=radio][name=rechercherentreprise]").change(function() {
    switch ($(this).val())
    {
        case'tous':                                          
            document.getElementById('nomentreprise').disabled = true;    
            document.getElementById('tous').checked = true;    
            document.getElementById('tous').value = 'tous'; 
        break;

        case'entreprisename':                                  
            document.getElementById('nomentreprise').disabled = false;  
            document.getElementById('nomentrepris').value = "";    
            document.getElementById('nomentrepris').checked = true;
        break;      
    }
    
});

function desactivertoutentreprise()
{   
    document.getElementById('nomentreprise').disabled = true;  
    document.getElementById('tous').checked = true;    
    document.getElementById('tous').value = 'tous';  
}
</script>