
<?php
require_once('identifier.php');
require_once('connexiondb.php');
    
?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Gestion des unités de mesure</title>
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
<body onload="desactivertoutunitedemesure();document.getElementById('param').value='tous';chargementunitemesure();">
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success margetop">
        <div class="panel-heading bg-primary text-white">
            Recherche des unites ...
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline" id="pr">
                <div class="form-group">
                   <input type="radio" id="tous" name="rechercherunitedemesure" 
                    onclick="document.getElementById('param').value='tous';desactivertout();" value="tous"/>
                    <label for="tous">Toutes les unités de mesure</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->                                
                    <input type="radio" id="nomunitemesure" name="rechercherunitedemesure" value="libel"/> 
                     <label for="nomunitemesure">Par unité de mesure </label>
                     &nbsp  &nbsp <!--Pour espacement-->
                     &nbsp  &nbsp <!--Pour espacement-->                                 
                     &nbsp  &nbsp <!--Pour espacement-->            
                    <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                        <a href="nouvelleunitemesure.php">
                            <span class="glyphicon glyphicon-plus"></span>
                            Nouvelle unité de mesure
                        </a>
                    <?php } ?>
                     <input type="text" id="param" name="param" style="visibility:hidden;" /> 
                </div>
                
                    <div class="form-group largeur100">
                        <input type="text" name="libelle" id="libelle" 
                            class="form-control" onblur="document.getElementById('param').value='parlibelle'"/>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-success" id="rechercheunite" name="rechercheunite" value="Rechercher" style="margin-top:10px;">
                        <i class="fas fa-search"></i> Rechercher...
                        </button>
                        <div class="spinner-border text-primary" id="loadingState"></div> 
                    </div>
                   
                
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
                        libelle produit
                    </th>
                
                    <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                        <th>
                            Action
                        </th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody id="tbodyunite">
                          
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
  
function chargementunitemesure() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
                    $('#loadingState').show();
                var url = 'chargeunitemesure.php';
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
                    var unites = donnee.unites;
                   var roleuser=donnee.user;
                    if(unites.length == 0){
                       //$('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
                        totalRecords = unites.length;
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
                                displayRecords = unites.slice(displayRecordsIndex, endRec);
                               
                                $('#tbodyunite').empty();                                   
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var idunite = displayRecords[i]['id_unite'];
                                    var ulrModification = "editerunites.php?idunit="+idunite;                             
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                      $("#tbodyunite").append('<tr>' +
                                        '<td>'+displayRecords[i]['libelle']+'</td>' +                                                                             
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer unite"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer unite" onclick="Confirm_deleteunite('+idunite+')" ><i class="far fa-trash-alt"></button></td>' +                                                                                                                             
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

                case 'parlibelle':
                    $('#loadingState').show();
                    var url = 'chargeunitemesure.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,
                'libelle':document.getElementById('libelle').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var unites = donnee.unites;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(unites.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
                        totalRecords = unites.length;
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
                                displayRecords = unites.slice(displayRecordsIndex, endRec);
                               
                                $('#tbodyunite').empty();                                   
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var idunite = displayRecords[i]['id_unite'];
                                    var ulrModification = "editerunites.php?idunit="+idunite;                             
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                      $("#tbodyunite").append('<tr>' +
                                        '<td>'+displayRecords[i]['libelle']+'</td>' +                                                                             
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer unite"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer unite" onclick="Confirm_deleteunite('+idunite+')" ><i class="far fa-trash-alt"></button></td>' +                                                                                                                             
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
                var url = 'chargeunitemesure.php';
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'nouvellibel':document.getElementById('nouvellibel').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {
                            swal("Unité bien enregistrée");                        
                            $('#libelle').val('');
                            
                        },
                        error: function (data) {
                            alert("Erreur enregistrement unité");
                        }
                    });
            break;

            case 'modifier': 
            var url = 'chargeunitemesure.php';
            $.ajax({
                    type: 'GET',
                    url: url,
                    data:{'param':document.getElementById('param').value,
                    'libelle':document.getElementById('editlibel').value,                   
                    'idunite':document.getElementById('idunite').value},
                    datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                    success: function (data) {
                        swal("Unité bien modifiée");                        
                        //$('#motif').val('');
                        //$('#montant').val('');
                    },
                    error: function (data) {
                        swal("Erreur modification unité");
                    }
                });
            break;
            case 'chargerchampmodifier':
                var url = 'chargeunitemesure.php';
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,                            
                        'idunite':document.getElementById('idunite').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {   
                            var donnee = jQuery.parseJSON(data);                                                                               
                            $('#editlibel').val(donnee.libelleunit);                             
                        },
                        error: function (data) {
                            swal("Erreur chargement champ modification");
                        }
                    });
            break;
        }              
    }

   $('#rechercheunite').on('click', function(){
        $('#tbodyunite').empty();
        chargementunitemesure();
        });

function Confirm_deleteunite(idunite) 

{
    swal({
        title: "Suppression !",
        text: "Voulez-vous vraiment supprimer cette unité?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               deleteunite(idunite)
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
}  

function deleteunite(idunite){
    var url = 'chargeunitemesure.php';
    $.ajax({
                type: 'GET',
                url: url,
                data:{'param':document.getElementById('param').value='suppression','idunite':idunite},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    swal('Unité supprimée avec succès');                   
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

$("input[type=radio][name=rechercherunitedemesure]").change(function() {
    switch ($(this).val())
    {
        case'tous':                                          
            document.getElementById('libelle').disabled = true;    
            document.getElementById('tous').checked = true;    
            document.getElementById('tous').value = 'tous'; 
        break;

        case'libel':                                  
            document.getElementById('libelle').disabled = false;  
            document.getElementById('libelle').value = "";    
            document.getElementById('nomunitemesure').checked = true;
        break;      
    }
    
});

function desactivertoutunitedemesure()
{   
    document.getElementById('libelle').disabled = true;  
    document.getElementById('tous').checked = true;    
    document.getElementById('tous').value = 'tous';  
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
