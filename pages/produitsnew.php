
<?php
require_once('identifier.php');
require_once('connexiondb.php');
    
?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Gestion des produits</title>
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
<body onload="desactivertoutproduit();document.getElementById('param').value='tous';chargementproduits();">
<?php include("menu.php"); ?>
<div class="container">
    <div class="panel panel-success margetop">
        <div class="panel-heading bg-primary text-white">
            Recherche des produits ...
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline" id="pr">
                <div class="form-group">
                   <input type="radio" id="tous" name="rechercherproduit" 
                    onclick="document.getElementById('param').value='tous';desactivertout();" value="tous"/>
                    <label for="tous">Tous les produits</label>
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                                  
                    <input type="radio" id="nomp" name="rechercherproduit" value="nomprod"/> 
                     <label for="nomp">Par désignation </label>
                     &nbsp  &nbsp <!--Pour espacement-->
                     &nbsp  &nbsp <!--Pour espacement-->
                                  
                     &nbsp  &nbsp <!--Pour espacement-->
              
                    <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                        <a href="nouveauproduit.php">
                            <span class="glyphicon glyphicon-plus"></span>
                            Nouveau produit
                        </a>
                    <?php } ?>
                     <input type="text" id="param" name="param" style="visibility:hidden;" /> 
                </div>
                
                    <div class="form-group largeur100">
                        <input type="text" name="designat" id="designat" 
                            class="form-control" onblur="document.getElementById('param').value='pardesignation'"/>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-success" id="rechercheproduit" name="recherchefournisseur" value="Rechercher" style="margin-top:10px;">
                        <i class="fas fa-search"></i> Rechercher...
                        </button>
                        <div class="spinner-border text-primary" id="loadingState"></div> 
                    </div> 
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->
                    &nbsp  &nbsp <!--Pour espacement-->  
                    <div id="imprimerrapportproduit"></div>        
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
                        Designation produit
                    </th>
                    <th>
                        Quantité minimale
                    </th>
                    <th>
                        Marque
                    </th>

                    <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                        <th>
                            Action
                        </th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody id="tbodyproduit">
                          
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
  
function chargementproduits() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
                    $('#loadingState').show();
                var url = 'chargeproduits.php';
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
                   
                    var produits = donnee.produit;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(produits.length == 0){
                        document.getElementById('imprimerrapportproduit').style.display='none';
                    }
                    else
                    {
                        var casetous = 'tous';
                        document.getElementById('imprimerrapportproduit').style.display='block';
                        document.getElementById("imprimerrapportproduit").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportproduits.php?infoproduits=" + casetous + "\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = produits.length;
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

                                displayRecords = produits.slice(displayRecordsIndex, endRec);
                               
                                $('#tbodyproduit').empty();                                   
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var idproduit = displayRecords[i]['ref_produit'];
                                    var ulrModification = "editerproduits.php?idp="+idproduit;                             
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                      $("#tbodyproduit").append('<tr>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' +
                                        '<td>'+displayRecords[i]['qte_min']+'</td>' +
                                        '<td>'+displayRecords[i]['marque']+'</td>' +                                        
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer produit"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer produit" onclick="Confirm_deleteproduit('+idproduit+')" ><i class="far fa-trash-alt"></button></td>' +                                                                                                                             
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

                case 'pardesignation':
                    $('#loadingState').show();
                    var url = 'chargeproduits.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,
                'designation':document.getElementById('designat').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var produits = donnee.produit;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(produits.length == 0){
                        document.getElementById('imprimerrapportproduit').style.display='none';
                    }
                    else
                    {
                        var parametr = 'pardesignation';
                        document.getElementById('imprimerrapportproduit').style.display='block';
                        var designation = document.getElementById('designat').value;
                        document.getElementById("imprimerrapportproduit").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportproduits.php?infoproduits=" + parametr + "&parametre="+ designation +"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = produits.length;
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

                                displayRecords = produits.slice(displayRecordsIndex, endRec);
                               
                                    $('#tbodyproduit').empty();
                                    
                                for (var i = 0; i < displayRecords.length; i++) {
                                         
                                    var idproduit = displayRecords[i]['ref_produit'];
                                    var ulrModification = "editerproduits.php?idp="+idproduit;
                                    //var ulrSuppression = "supprimerfournisseur.php?idf="+idpaiement;
                                   // var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                      $("#tbodyproduit").append('<tr>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' +
                                        '<td>'+displayRecords[i]['qte_min']+'</td>' +
                                        '<td>'+displayRecords[i]['marque']+'</td>' +                                        
                                        '<td style="visibility:'+visibilite+';">'+
                                        '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer produit"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer produit" onclick="Confirm_deleteproduit('+idproduit+')" ><i class="far fa-trash-alt"></button></td>' +                                                                                          
                                    
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
                var url = 'chargeproduits.php';
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'designation':document.getElementById('designation').value,
                        'qtemin':document.getElementById('qtemin').value,
                        'marque':document.getElementById('marque').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {
                            swal("Produit bien enregistré");                        
                            $('#designation').val('');
                            $('#qtemin').val('');
                            $('#marque').val('');
                        },
                        error: function (data) {
                            alert("Erreur enregistrement produit");
                        }
                    });
            break;

            case 'modifier': 
            var url = 'chargeproduits.php';
            $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'designation':document.getElementById('designation').value,
                        'qtemin':document.getElementById('qtemin').value,
                        'marque':document.getElementById('marque').value,
                        'idp':document.getElementById('idp').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {

                           // var donnee = jQuery.parseJSON(data);
                   
                           // var depenses = donnee.depense;
                           /*$('#montantdepense').empty();  motif montant datedep
                            document.getElementById('motif').innerText =  donnee.motif;
                            document.getElementById('montant').innerText =  donnee.montant;
                            document.getElementById('datedep').innerText =  donnee.datedepense;*/
                            swal("Produit bien modifié");                        
                            //$('#motif').val('');
                            //$('#montant').val('');
                        },
                        error: function (data) {
                            swal("Erreur modification produit");
                        }
                    });
            break;
            case 'chargerchampmodifier':
                var url = 'chargeproduits.php';
                $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value,                            
                            'idp':document.getElementById('idp').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                               var donnee = jQuery.parseJSON(data);                                                                               
                                $('#designation').val(donnee.designationproduit);
                                $('#qtemin').val(donnee.qteminimale);
                                $('#marque').val(donnee.marque);
                            },
                            error: function (data) {
                                swal("Erreur chargement champ modification");
                            }
                        });
            break;
        }              
    }

   $('#rechercheproduit').on('click', function(){
        $('#tbodyproduit').empty();
        chargementproduits();
        });

function Confirm_deleteproduit(idproduit) 

{
    swal({
        title: "Suppression !",
        text: "Voulez-vous vraiment supprimer ce produit?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               deleteproduit(idproduit)
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
}  

function deleteproduit(idproduit){
    var url = 'chargeproduits.php';
    $.ajax({
                type: 'GET',
                url: url,
                data:{'param':document.getElementById('param').value='suppression','idp':idproduit},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    swal('Produit supprimé');                   
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

$("input[type=radio][name=rechercherproduit]").change(function() {
    switch ($(this).val())
    {
        case'tous':                                          
            document.getElementById('designat').disabled = true;    
            document.getElementById('tous').checked = true;    
            document.getElementById('tous').value = 'tous'; 
        break;

        case'nomprod':                                  
            document.getElementById('designat').disabled = false;  
            document.getElementById('designat').value = "";    
            document.getElementById('nomp').checked = true;
        break;      
    }
    
});

function desactivertoutproduit()
{   
    document.getElementById('designat').disabled = true;  
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
