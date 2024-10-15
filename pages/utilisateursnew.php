<?php
    
    require_once('identifier.php');
    require_once('connexiondb.php');// il nous permet de creer l'objet qui nous permet de nous connecter à la base de données
    
    $logins=isset($_GET['logins'])?$_GET['logins']:"";
   
    $requeteUser= "select * from utilisateur where logins like '%$logins%'";

?>

<! DOCTYPE HTML>
<html>
    <head>
        <title>Gestion des utilisateurs</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">  
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
        <link rel="stylesheet" type="text/css"  href="../css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css"  href="../css/all.css">
        <script src="../js/jquery-3.5.1.min.js"></script>              
        <script src="../js/facturationstock.js"></script>
        <script src="../js/sweetalert.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>   
        <script src="../js/pagination/jquery.twbsPagination.min.js"></script> 
    </head>
    <body onload="desactivertoututilisateur();document.getElementById('param').value='tous';chargementutilisateurs();">
        <?php include("menu.php"); ?>
        <div class="container">
            <div class="panel panel-success margetop">
                <div class="panel-heading bg-primary text-white">
                    Rechercher des utilisateurs...
                </div>
                <div class="panel-body">
                    <form method="GET" class="form-inline">
                        <div class="form-group">
                            <input type="radio" id="tous" name="rechercherutilisateur" 
                            onclick="document.getElementById('param').value='tous';desactivertout();" value="tous"/>
                            <label for="tous">Tous les utilisateurs</label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->                                      
                            <input type="radio" id="login" name="rechercherutilisateur" value="radiologin"/> 
                            <label for="login">Par nom utilisateur </label>
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->                                       
                            &nbsp  &nbsp <!--Pour espacement-->                   
                            <?php if($_SESSION['user']['roles']=='ADMIN') {?>
                                <a href="nouvelUtilisateur.php">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Nouvel Utilisateur
                                </a>
                            <?php } ?>
                            <input type="text" id="param" name="param" style="visibility:hidden;" /> 
                        </div>
                    
                        <div class="form-group largeur100">
                            <input type="text" name="logins" id="logins" 
                                class="form-control" onblur="document.getElementById('param').value='parlogin'"/>
                        </div>

                        <div class="form-group">
                            
                            <button type="button" class="btn btn-success" id="rechercheutilisateur" name="rechercheutilisateur" value="Rechercher" style="margin-top:10px;">
                                <i class="fas fa-search"></i> Rechercher...
                            </button>
                           
                            <div class="spinner-border text-primary" id="loadingState"></div>  
                            &nbsp  &nbsp <!--Pour espacement-->
                            &nbsp  &nbsp <!--Pour espacement-->                                       
                            &nbsp  &nbsp <!--Pour espacement-->   
                            &nbsp  &nbsp <!--Pour espacement-->                                       
                            &nbsp  &nbsp <!--Pour espacement-->  
                            &nbsp  &nbsp <!--Pour espacement-->                                       
                            &nbsp  &nbsp <!--Pour espacement--> 
                            <div id="imprimeruser"></div>                   
                        </div>                 
                    </form> 
                                       
                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading bg-primary text-white">
                    Liste des utilisateurs 
                </div>
                <div class="panel-body">
                    <table class="table table-dark table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    Nom utilisateur
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                   Mot de passe
                                </th>
                                <th>
                                    Role
                                </th>

                                <th>
                                   Téléphone
                                </th>
                                <th>
                                    Reseau social
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
                        <tbody id="tbodyutilisateur">
                           
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

function chargementutilisateurs() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
                 $('#loadingState').show();
                var url = 'chargementutilisateur.php';
                $.ajax({
                type: 'POST',
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
                   
                    var lesutilisateurs = donnee.utilisateur;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(lesutilisateurs.length == 0){
                        document.getElementById('imprimeruser').style.display='none';
                    }
                    else
                    {
                        var casetous = 'tous';
                        document.getElementById('imprimeruser').style.display='block';
                        document.getElementById("imprimeruser").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportusers.php?infouser=" + casetous + "\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = lesutilisateurs.length;
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

                                displayRecords = lesutilisateurs.slice(displayRecordsIndex, endRec);
                               
                                $('#tbodyutilisateur').empty();                             
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var iduser = displayRecords[i]['iduser'];
                                    var etatuser = displayRecords[i]['etat'];
                                    var ulrModification = "editerUtilisateur.php?idUser="+iduser;
                                   /* var urlactivation = "activerUtilisateur.php?idUser="+iduser+
                                    "&etat="+etatuser;*/
                                    if(parseInt(etatuser) == 1)
                                    {
                                        var etat = 'success';
                                        var etatutilisateur = 'fas fa-user-times'; 
                                    }                                      
                                    else 
                                    {
                                        var etat = 'danger';
                                        var etatutilisateur = 'fas fa-check-circle';
                                    }  
                                        
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                      $("#tbodyutilisateur").append('<tr class="'+etat+'">' +
                                        '<td>'+displayRecords[i]['logins']+'</td>' +         
                                        '<td>'+displayRecords[i]['email']+'</td>' +
                                        '<td>'+displayRecords[i]['pwd']+'</td>' +
                                        '<td>'+displayRecords[i]['roles']+'</td>' + 
                                        '<td>'+displayRecords[i]['usertelephone']+'</td>' +                                        
                                        '<td>'+displayRecords[i]['userreseausocio']+'</td>' +                                        
                                        '<td>'+displayRecords[i]['useradresse']+'</td>' +                                                                               
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer utilisateur"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer utilisateur" onclick="Confirm_deleteuser('+iduser+')" ><i class="far fa-trash-alt"></i></button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +                                                                                          
                                            '<button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Activer ou Désactiver utilisateur" onclick="Confirm_activeruser('+iduser+','+etatuser+')"><i class="'+etatutilisateur+'"></i></button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;</td>'+                                       
                                            '</tr>');
                                }                                                           
                            }
                        });
                    }
                    
                    $('#loadingState').hide();
                },
                error: function (data) {
                    //$('#loadprogressbar').hide();
                    //$('#loadingState').hide();
                    //swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                }
            }); 
                break;

                case 'parlogin':
                    $('#loadingState').show();
                var url = 'chargementutilisateur.php';
                $.ajax({
                type: 'POST',
                url: url,
                data: {'param':document.getElementById('param').value,
                        'logins':document.getElementById('logins').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,                       
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var lesutilisateurs = donnee.utilisateur;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(lesutilisateurs.length == 0){
                        document.getElementById('imprimeruser').style.display='none';
                    }
                    else
                    {
                        var parametr = 'parlogin';
                        document.getElementById('imprimeruser').style.display='block';
                        var logins = document.getElementById('logins').value;
                        document.getElementById("imprimeruser").innerHTML = "<button class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportusers.php?infouser=" + parametr + "&parametre="+ logins +"\")'><i class='fas fa-print'>Imprimer</i></button>";
                        totalRecords = lesutilisateurs.length;
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

                                displayRecords = lesutilisateurs.slice(displayRecordsIndex, endRec);
                               
                                $('#tbodyutilisateur').empty();                             
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var iduser = displayRecords[i]['iduser'];
                                    var etatuser = displayRecords[i]['etat'];
                                    var ulrModification = "editerUtilisateur.php?idUser="+iduser;
                                   /* var urlactivation = "activerUtilisateur.php?idUser="+iduser+
                                    "&etat="+etatuser;*/
                                    if(parseInt(etatuser) == 1)
                                    {
                                        var etat = 'success';
                                        var etatutilisateur = 'fas fa-user-times'; 
                                    }                                      
                                    else 
                                    {
                                        var etat = 'danger';
                                        var etatutilisateur = 'fas fa-check-circle';
                                    }  
                                        
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                      $("#tbodyutilisateur").append('<tr class="'+etat+'">' +
                                        '<td>'+displayRecords[i]['logins']+'</td>' +         
                                        '<td>'+displayRecords[i]['email']+'</td>' +
                                        '<td>'+displayRecords[i]['pwd']+'</td>' +
                                        '<td>'+displayRecords[i]['roles']+'</td>' + 
                                        '<td>'+displayRecords[i]['usertelephone']+'</td>' +                                        
                                        '<td>'+displayRecords[i]['userreseausocio']+'</td>' +                                        
                                        '<td>'+displayRecords[i]['useradresse']+'</td>' +                                         '<td style="visibility:'+visibilite+';">'+
                                        '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer utilisateur"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                        '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer utilisateur" onclick="Confirm_deleteuser('+iduser+')" ><i class="far fa-trash-alt"></i></button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +                                                                                          
                                        '<button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Activer ou Désactiver utilisateur" onclick="Confirm_activeruser('+iduser+','+etatuser+')"><i class="'+etatutilisateur+'"></i></button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;</td>'+                                       
                                        '</tr>');
                                }                                                           
                            }
                        });
                    }                  
                    $('#loadingState').hide();
                },
                error: function (data) {
                    //$('#loadprogressbar').hide();
                    //$('#loadingState').hide();
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                }
            });                                                                                        
                break; 

                case 'inserer': 
                var url = 'chargementutilisateur.php';
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'login':document.getElementById('login').value,
                        'pwd1':document.getElementById('pwd1').value,
                        'pwd2':document.getElementById('pwd2').value,
                        'email':document.getElementById('email').value,
                        'role':document.getElementById('role').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {
                            swal("Utilisateur enregistré avec succès");                        
                            $('#login').val('');
                            $('#pwd1').val('');
                            $('#pwd2').val('');
                            $('#email').val('');
                        },
                        error: function (data) {
                            alert("Erreur enregistrement utilisateur");
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

$("input[type=radio][name=rechercherutilisateur]").change(function() {
    switch ($(this).val())
    {
        case'tous':                                          
            document.getElementById('logins').disabled = true;    
            document.getElementById('tous').checked = true;    
            document.getElementById('tous').value = 'tous'; 
        break;

        case'radiologin':                                  
            document.getElementById('logins').disabled = false;  
            document.getElementById('logins').value = "";    
            document.getElementById('login').checked = true;
        break;      
    }
    
});

$('#rechercheutilisateur').on('click', function(){
        $('#tbodyproduit').empty();
        chargementutilisateurs();
        });
</script>