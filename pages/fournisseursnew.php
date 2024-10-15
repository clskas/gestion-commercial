
<?php
require_once('identifier.php');
require_once('connexiondb.php');
    
?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Gestion des fournisseurs</title>
    <meta charset="utf-8" > 
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
<body onload="desactivertoutfournisseur();document.getElementById('param').value='tous';chargementfournisseurs();">
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success margetop">
        <div class="panel-heading bg-primary text-white">
            Recherche sur les fournisseurs ...
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline" id="fournis">
                <div class="form-group">
                   <input type="radio" id="tous" name="rechercherfournisseur" 
                    onclick="document.getElementById('param').value='tous';desactivertout();" value="tous"/>
                    <label for="tous">Tous les fourniseurs</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                                  
                    <input type="radio" id="nomf" name="rechercherfournisseur" value="nomfourn"/> 
                     <label for="nomf">Par nom </label>
                     &nbsp  &nbsp <!--Pour espacement-->
                     &nbsp  &nbsp <!--Pour espacement-->
                                  
                     &nbsp  &nbsp <!--Pour espacement-->
              
                    <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                        <a href="nouveaufournisseur.php">
                            <span class="glyphicon glyphicon-plus"></span>
                            Nouveau fournisseur
                        </a>
                    <?php } ?>
                     <input type="text" id="param" name="param" style="visibility:hidden;" /> 
                </div>
               
                <div class="form-group largeur100">
                    <input type="text" name="nom" id="nom" 
                        class="form-control" onblur="document.getElementById('param').value='parnom'"/>
                </div>

                <div class="form-group">                       
                    <button type="button" class="btn btn-success" id="recherchefournisseur" name="recherchefournisseur" value="Rechercher" style="margin-top:10px;">
                        <i class="fas fa-search"></i> Rechercher...
                    </button>
                    <div class="spinner-border text-primary" id="loadingState"></div>
                </div>  
                &nbsp  &nbsp <!--Pour espacement-->
                &nbsp  &nbsp <!--Pour espacement-->
                &nbsp  &nbsp <!--Pour espacement--> 
                <div id="imprimerrapporfournisseur"></div>           
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
                        Nom Fournisseur
                    </th>
                    <th>
                        Prenom Fournisseur
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
                <tbody id="tbodyfournisseur">
                          
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
  
function chargementfournisseurs() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
                    $('#loadingState').show();
                var url = 'chargefournisseur.php';
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
                   
                    var fournisseurs = donnee.fourniss;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(fournisseurs.length == 0){
                        document.getElementById('imprimerrapporfournisseur').style.display='none';
                    }
                    else
                    {
                        var casetous = 'tous';
                        document.getElementById('imprimerrapporfournisseur').style.display='block';
                        document.getElementById("imprimerrapporfournisseur").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportsfournisseurs.php?infofournisseur=" + casetous + "\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = fournisseurs.length;
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

                                displayRecords = fournisseurs.slice(displayRecordsIndex, endRec);
                               
                                    $('#tbodyfournisseur').empty();
                                    
                                for (var i = 0; i < displayRecords.length; i++) {
                                           
                                    var idfournisseur = displayRecords[i]['idf'];
                                    var ulrModification = "editerfournisseurs.php?idf="+idfournisseur;
                                    
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyfournisseur").append('<tr>' +
                                        '<td>'+displayRecords[i]['civilite']+'</td>' +
                                        '<td>'+displayRecords[i]['nom']+'</td>' +
                                        '<td>'+displayRecords[i]['prenom']+'</td>' + 
                                        '<td>'+displayRecords[i]['telephone']+'</td>' +
                                        '<td>'+displayRecords[i]['reseausocial']+'</td>' +
                                        '<td>'+displayRecords[i]['email']+'</td>' +
                                        '<td>'+displayRecords[i]['adresse']+'</td>' +                                      
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer fournisseur"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer fournisseur" onclick="Confirm_Deletefournisseur('+idfournisseur+')" ><i class="far fa-trash-alt"></button></td>' +   
                                     
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
                    var url = 'chargefournisseur.php';
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
                   
                    var fournisseurs = donnee.fourniss;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(fournisseurs.length == 0){
                        document.getElementById('imprimerrapporfournisseur').style.display='none';
                    }
                    else
                    {
                        var parametr = 'parnom';
                        var lesfournisseurs = document.getElementById('nom').value;
                        document.getElementById('imprimerrapporfournisseur').style.display='block';
                        document.getElementById("imprimerrapporfournisseur").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportsfournisseurs.php?infofournisseur=" + parametr + "&parametre="+ lesfournisseurs +"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = fournisseurs.length;
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

                                displayRecords = fournisseurs.slice(displayRecordsIndex, endRec);
                               
                                    $('#tbodyfournisseur').empty();
                                    
                                for (var i = 0; i < displayRecords.length; i++) {
                                           
                                    var idfournisseur = displayRecords[i]['idf'];
                                    var ulrModification = "editerfournisseurs.php?idf="+idfournisseur;
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyfournisseur").append('<tr>' +
                                        '<td>'+displayRecords[i]['civilite']+'</td>' +
                                        '<td>'+displayRecords[i]['nom']+'</td>' +
                                        '<td>'+displayRecords[i]['prenom']+'</td>' + 
                                        '<td>'+displayRecords[i]['telephone']+'</td>' +
                                        '<td>'+displayRecords[i]['reseausocial']+'</td>' +
                                        '<td>'+displayRecords[i]['email']+'</td>' +
                                        '<td>'+displayRecords[i]['adresse']+'</td>' +                                      
                                        '<td style="visibility:'+visibilite+';">'+
                                        '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer fournisseur"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer fournisseur" onclick="Confirm_Deletefournisseur('+idfournisseur+')" ><i class="far fa-trash-alt"></button></td>' +   
                                     
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
                var url = 'chargefournisseur.php';
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
                            alert("Erreur enregistrement fournisseur");
                        }
                    });
            break;
        }              
    }

   $('#recherchefournisseur').on('click', function(){
        $('#tbodyfournisseur').empty();
        chargementfournisseurs();
        });

function Confirm_Deletefournisseur(idfournisseur) 

{
    swal({
        title: "Suppression !",
        text: "Voulez-vous vraiment supprimer ce fournisseur?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               deletefournisseur(idfournisseur)
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
}  

function deletefournisseur(idfournisseur){
    var url = 'chargefournisseur.php';
    $.ajax({
                type: 'GET',
                url: url,
                data:{'param':document.getElementById('param').value='suppression','idf':idfournisseur},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    swal('Fournisseur supprimé');                   
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

$("input[type=radio][name=rechercherfournisseur]").change(function() {
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

function desactivertoutfournisseur()
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
