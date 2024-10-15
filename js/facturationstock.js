

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
                   // $('#montantdepense').empty();
                    document.getElementById('montantdepense').innerText =  donnee.somme+' '+'$';
                    var roleuser=donnee.utilisateur;
                    if(depenses.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                        '<td>'+displayRecords[i]['montant']+'</td>' +
                                        '<td>'+displayRecords[i]['date_depense']+'</td>' +                                        
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="mr-4"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Delete('+idDepense+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +  
                                                                                         
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
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    
                }
            }); 
                break;

                case 'pardate':
                    var url = 'chargementdepense.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: {'pdate':document.getElementById('pdate').value,
                'param':document.getElementById('param').value},
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
                       // $('#montantdepense').empty(); donnee.somme
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                            '<a href="'+ulrModification+'" class="mr-4"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Delete('+idDepense+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +  
                                                                                         
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
                   
                    var depenses = donnee.depense
                    var roleuser=donnee.utilisateur;
                   // $('#montantdepense').empty();
                    document.getElementById('montantdepense').innerText =  donnee.somme+' '+'$';
               
                    if(depenses.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                        '<td>'+displayRecords[i]['montant']+'</td>' +
                                        '<td>'+displayRecords[i]['date_depense']+'</td>' +                                        
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="mr-4"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Delete('+idDepense+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +  
                                                                                         
                                    '</tr>');
                                }
                                                            
                            }
                        });
                    }

                    $('#loadingState').hide();
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    $('#loadingState').hide();
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                   
                }
            }); 
                break;
                case 'motif':
                    var url = 'chargementdepense.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,
                'motif':document.getElementById('motif').value},
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
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                        '<td>'+displayRecords[i]['montant']+'</td>' +
                                        '<td>'+displayRecords[i]['date_depense']+'</td>' +                                        
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="mr-4"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Delete('+idDepense+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +  
                                                                                         
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
            var rates = document.getElementsByName('monnaie');
            var rate_value;
            for(var i = 0; i < rates.length; i++){
                if(rates[i].checked){
                    rate_value = rates[i].value;
                }
            }
            $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'motif':document.getElementById('motif').value,
                        'montant':document.getElementById('montant').value,                           
                        'monnaie':rate_value},
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
            var rates = document.getElementsByName('monnaie');
            var rate_value;
            for(var i = 0; i < rates.length; i++){
                if(rates[i].checked){
                    rate_value = rates[i].value;
                }
            }
            $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'motif':document.getElementById('motif').value,
                        'montant':document.getElementById('montant').value,
                        'monnaie':rate_value,
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
                                if(donnee.monnaie == 'FC')
                                {                                     
                                     $("#fc").prop("checked", true);
                                }
                                else if(donnee.monnaie == '$')
                                {                                      
                                    $("#dolar").prop("checked", true); 
                                }
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
        swal("Ce champ doit contenir une valeur numérique et nom un text");
        return false;
    }
    else
    {
        
        surligne(champ, false);
        return true;
    }
}
function comparermontantapayeretmontantpaye(champ)
{
    var montantpayer = parseInt($('#montant_paye').val());
    var resteco = parseInt($('#restecom').val());  
    if(montantpayer > resteco)
    {
        surligne(champ, true);
        swal("Le montant payé doit être inférieur ou égal au reste, veuillez revoir le montant payé");
        return false;
    }
    else
    {
        surligne(champ, false);
        return true;
    }
}
function surligne(champ, erreur)
{
    if(erreur)
        champ.style.backgroundColor = "#c0392b";

    else
        champ.style.backgroundColor = "";
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



function chargementfournisseurs() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
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
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var fournisseurs = donnee.fourniss;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(fournisseurs.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                    //var ulrSuppression = "supprimerfournisseur.php?idf="+idpaiement;
                                   // var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
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
                                            '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Deletefournisseur('+idfournisseur+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +   
                                       
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
                   // console.log(data);
                }
            }); 
                break;

                case 'parnom':
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
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var fournisseurs = donnee.fourniss;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(fournisseurs.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                    //var ulrSuppression = "supprimerfournisseur.php?idf="+idpaiement;
                                   // var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
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
                                            '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Deletefournisseur('+idfournisseur+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +   
                                       
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

             case 'modifier': 
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
                        'civilite':document.getElementById('civilite').value,
                        'idf':document.getElementById('idf').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {

                            var donnee = jQuery.parseJSON(data);
                   
                            var depenses = donnee.depense;
                           
                            swal("Fournisseur bien modifié");                        
                            
                        },
                        error: function (data) {
                            swal("Erreur modification fournisseurs");
                        }
                    });
            break;
            case 'chargerchampmodifier':
                var url = 'chargefournisseur.php';
                $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value,                            
                            'idf':document.getElementById('idf').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                               var donnee = jQuery.parseJSON(data);                                                                               
                                $('#nom').val(donnee.nom);
                                $('#prenom').val(donnee.prenom);
                                $('#email').val(donnee.email);
                                $('#telephone').val(donnee.telephone);
                                $('#reseausocial').val(donnee.reseausocial);
                                $('#adresse').val(donnee.adresse);
                               // $('#civilite').val(donnee.civilite);

                                var civilites = donnee.civilites; 
                                var select = $("#civilite");                          
                                select.empty(); 
                   
                            for (var i = 0; i < civilites.length; i++) {     
                                                      
                                select.append('<option value="' +civilites[i]['civilite'] +'">' + civilites[i]['civilite'] + '</option>');                 
                            }  
                            
                            $("#civilite").val(donnee.civilite);
                            },
                            error: function (data) {
                                swal("Erreur chargement champ modification");
                            }
                        });
            break;
        }              
    }



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

function chargementproduits() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
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
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var produits = donnee.produit;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(produits.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                            '<a href="'+ulrModification+'" class="mr-4"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_deleteproduit('+idproduit+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +                                                                                          
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
                   // console.log(data);
                }
            }); 
                break;

                case 'pardesignation':
                    var url = 'chargeproduits.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,
                'designation':document.getElementById('designation').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var produits = donnee.produit;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(produits.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                            '<a href="'+ulrModification+'" class="mr-4"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_deleteproduit('+idproduit+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +                                                                                          
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
                        'designation':document.getElementById('editdesignation').value,
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
                                $('#editdesignation').val(donnee.designationproduit);
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
                data:{'param':document.getElementById('param').value='suppression','idf':idproduit},
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


  
function chargementclients() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
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
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var clients = donnee.client;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(clients.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                            '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Deleteclient('+idClient+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +   
                                       
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
                   // console.log(data);
                }
            }); 
                break;

                case 'parnom':
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
                        recPerPage = 7,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var clients = donnee.client;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(clients.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                            '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Deleteclient('+idClient+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +   
                                       
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

                            swal("Client bien enregistré");                        
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

             case 'modifier': 
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
                        'civilite':document.getElementById('civilite').value,
                        'idC':document.getElementById('idC').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {

                           // var donnee = jQuery.parseJSON(data);
                   
                           // var depenses = donnee.depense;
                           /*$('#montantdepense').empty();  motif montant datedep
                            document.getElementById('motif').innerText =  donnee.motif;
                            document.getElementById('montant').innerText =  donnee.montant;
                            document.getElementById('datedep').innerText =  donnee.datedepense;*/
                            swal("Client bien modifié");                        
                            //$('#motif').val('');
                            //$('#montant').val('');
                        },
                        error: function (data) {
                            swal("Erreur modification client");
                        }
                    });
            break;
            case 'chargerchampmodifier':
                var url = 'chargeclient.php';
                $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value,                            
                            'idC':document.getElementById('idC').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                               var donnee = jQuery.parseJSON(data);                                                                               
                               $('#nom').val(donnee.nom);
                               $('#prenom').val(donnee.prenom);
                               $('#email').val(donnee.email);
                               $('#telephone').val(donnee.telephone);
                               $('#reseausocial').val(donnee.reseausocial);
                               $('#adresse').val(donnee.adresse);
                               //$('#civilite').val(donnee.civilite);
                               var civilites = donnee.civilites; 
                                var select = $("#civilite");                          
                                select.empty(); 
                   
                            for (var i = 0; i < civilites.length; i++) {     
                                                      
                                select.append('<option value="' +civilites[i]['Client_civilite'] +'">' + civilites[i]['Client_civilite'] + '</option>');                 
                            }  
                            
                            $("#civilite").val(donnee.civilite);
                            },
                            error: function (data) {
                                swal("Erreur chargement champ modification");
                            }
                        });
            break;
        }              
    }


    
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



function chargementapprovisionnement() {
    switch(document.getElementById('param').value)
        {
            case 'tous':
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
                   // $('#montantdepense').empty();
                    //document.getElementById('montantdepense').innerText =  donnee.somme+' '+'$';
                   // var roleuser=donnee.utilisateur;
                    if(approvisionnement.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                            '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Deleteapprovisionnement('+identrestock+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +   
                                                                                                                              
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

            case 'pardate':
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
                       // $('#montantdepense').empty(); donnee.somme
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                    var ancienproduit = displayRecords[i]['id_article'];
                                    var ancienqte = displayRecords[i]['quantite_entre'];
                                    var ulrModification = "editerentrestock.php?identrestock="+identrestock+
                                    "ancienproduit="+ancienproduit+"ancienqte="+ancienqte;                                   
                                    //var ulrSuppression = "supprimerfournisseur.php?idC="+idpaiement;
                                   // var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyhistoriqueapprovisionnement").append('<tr>' +
                                        '<td>'+displayRecords[i]['numero_facture']+'</td>' +
                                        '<td>'+displayRecords[i]['fournisseurs']+'</td>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' + 
                                        '<td>'+displayRecords[i]['quantite_entre']+'</td>' + 
                                        '<td>'+displayRecords[i]['date_entre']+'</td>' + 
                                        '<td>'+displayRecords[i]['puht']+'</td>' + 
                                        '<td>'+displayRecords[i]['observation']+'</td>' +  
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Deleteapprovisionnement('+identrestock+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +   
                                                                                                                              
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
                }
            });                                                                                            
            break; 

            case 'datedebut':
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
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                    var ancienproduit = displayRecords[i]['id_article'];
                                    var ancienqte = displayRecords[i]['quantite_entre'];
                                    var ulrModification = "editerentrestock.php?identrestock="+identrestock+
                                    "ancienproduit="+ancienproduit+"ancienqte="+ancienqte;                                   
                                    //var ulrSuppression = "supprimerfournisseur.php?idC="+idpaiement;
                                   // var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyhistoriqueapprovisionnement").append('<tr>' +
                                        '<td>'+displayRecords[i]['numero_facture']+'</td>' +
                                        '<td>'+displayRecords[i]['fournisseurs']+'</td>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' + 
                                        '<td>'+displayRecords[i]['quantite_entre']+'</td>' + 
                                        '<td>'+displayRecords[i]['date_entre']+'</td>' + 
                                        '<td>'+displayRecords[i]['puht']+'</td>' + 
                                        '<td>'+displayRecords[i]['observation']+'</td>' +  
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Deleteapprovisionnement('+identrestock+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +   
                                                                                                                              
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
            case'produitpardate':               
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
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                    var ancienproduit = displayRecords[i]['id_article'];
                                    var ancienqte = displayRecords[i]['quantite_entre'];
                                    var ulrModification = "editerentrestock.php?identrestock="+identrestock+
                                    "ancienproduit="+ancienproduit+"ancienqte="+ancienqte;                                   
                                    //var ulrSuppression = "supprimerfournisseur.php?idC="+idpaiement;
                                   // var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyhistoriqueapprovisionnement").append('<tr>' +
                                        '<td>'+displayRecords[i]['numero_facture']+'</td>' +
                                        '<td>'+displayRecords[i]['fournisseurs']+'</td>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' + 
                                        '<td>'+displayRecords[i]['quantite_entre']+'</td>' + 
                                        '<td>'+displayRecords[i]['date_entre']+'</td>' + 
                                        '<td>'+displayRecords[i]['puht']+'</td>' + 
                                        '<td>'+displayRecords[i]['observation']+'</td>' +  
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Deleteapprovisionnement('+identrestock+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +   
                                                                                                                              
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
            case 'parproduit':
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
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                    var ancienproduit = displayRecords[i]['id_article'];
                                    var ancienqte = displayRecords[i]['quantite_entre'];
                                    var ulrModification = "editerentrestock.php?identrestock="+identrestock+
                                    "ancienproduit="+ancienproduit+"ancienqte="+ancienqte;                                   
                                    //var ulrSuppression = "supprimerfournisseur.php?idC="+idpaiement;
                                   // var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyhistoriqueapprovisionnement").append('<tr>' +
                                        '<td>'+displayRecords[i]['numero_facture']+'</td>' +
                                        '<td>'+displayRecords[i]['fournisseurs']+'</td>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' + 
                                        '<td>'+displayRecords[i]['quantite_entre']+'</td>' + 
                                        '<td>'+displayRecords[i]['date_entre']+'</td>' + 
                                        '<td>'+displayRecords[i]['puht']+'</td>' + 
                                        '<td>'+displayRecords[i]['observation']+'</td>' +  
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Deleteapprovisionnement('+identrestock+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +   
                                                                                                                              
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

            case'parfournisseur':
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
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                    var ancienproduit = displayRecords[i]['id_article'];
                                    var ancienqte = displayRecords[i]['quantite_entre'];
                                    var ulrModification = "editerentrestock.php?identrestock="+identrestock+
                                    "ancienproduit="+ancienproduit+"ancienqte="+ancienqte;                                   
                                    //var ulrSuppression = "supprimerfournisseur.php?idC="+idpaiement;
                                   // var messageSuppression = "Etes-vous sûr de vouloir supprimer ce paiement ?";
                                   if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                    $("#tbodyhistoriqueapprovisionnement").append('<tr>' +
                                        '<td>'+displayRecords[i]['numero_facture']+'</td>' +
                                        '<td>'+displayRecords[i]['fournisseurs']+'</td>' +
                                        '<td>'+displayRecords[i]['designation_produit']+'</td>' + 
                                        '<td>'+displayRecords[i]['quantite_entre']+'</td>' + 
                                        '<td>'+displayRecords[i]['date_entre']+'</td>' + 
                                        '<td>'+displayRecords[i]['puht']+'</td>' + 
                                        '<td>'+displayRecords[i]['observation']+'</td>' +  
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button onclick="Confirm_Deleteapprovisionnement('+identrestock+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +   
                                                                                                                              
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

        case 'inserer': 
                var url = 'chargementapprovisionnement.php';
                var monnaieapprovisi = document.getElementsByName('appromonnaie');
                    var monnaieapprovisi_value;
                    for(var i = 0; i < monnaieapprovisi.length; i++){
                        if(monnaieapprovisi[i].checked){
                            monnaieapprovisi_value = monnaieapprovisi[i].value;
                        }
                    }
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'idFournisseur':document.getElementById('idFournisseur').value,
                        'idproduit':document.getElementById('idproduit').value,
                        'numerofacture':document.getElementById('numerofacture').value,
                        'quantiteentre':document.getElementById('quantiteentre').value,
                        'puht':document.getElementById('puht').value,
                        'monnaieapro':monnaieapprovisi_value,
                        'unite':document.getElementById('iduniteentre').value,
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
                            $('#iduniteentre').val(''); 
                            document.getElementById('approfc').checked = false; 
                            document.getElementById('approdollar').checked = false; 
                        },
                        error: function (data) {
                            alert("Erreur enregistrement client");
                        }
                    });
                break;

             case 'modifier': 
                var url = 'chargementapprovisionnement.php';
                var editmonnaieap = document.getElementsByName('editappromonnaie');
                    var editmonnaie_value;
                    for(var i = 0; i < editmonnaieap.length; i++){
                        if(editmonnaieap[i].checked){
                            editmonnaie_value = editmonnaieap[i].value;
                        }
                    }
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                            'idFournisseur':document.getElementById('idFournisseur').value,
                            'idproduit':document.getElementById('idproduit').value,
                            'numerofacture':document.getElementById('numerofacture').value,
                            'quantiteentre':document.getElementById('quantiteentre').value,
                            'unite':document.getElementById('iduniteedit').value,
                            'puht':document.getElementById('puht').value,
                            'editmonnaie':editmonnaie_value,
                            'observation':document.getElementById('observation').value,
                            'dateenre':document.getElementById('dateenre').value,
                            'idES':document.getElementById('idES').value,
                            'ancienproduit':document.getElementById('ancienproduit').value,
                            'ancienqte':document.getElementById('ancienqte').value},
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
               /// $('#idFournisseur').empty();
                $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value,                            
                            'identrestock':document.getElementById('idES').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                            var donnee = jQuery.parseJSON(data);                                                                               
                                         
                            $('#numerofacture').val(donnee.numerofacture);
                            $('#quantiteentre').val(donnee.quantiteentre);
                            $('#puht').val(donnee.puht);
                            $('#observation').val(donnee.observation);
                            $('#dateenre').val(donnee.dateentre);

                            if(donnee.monnaie == 'FC')
                            {                                     
                                $("#editfc").prop("checked", true);
                            }
                            else if(donnee.monnaie == '$')
                            {                                      
                                $("#editdolar").prop("checked", true); 
                            }

                            var fournisseurs = donnee.fournisseurs;                 
                            var select = $("#idFournisseur");                          
                            select.empty();   
                                            
                            for (var i = 0; i < fournisseurs.length; i++) {     
                                                      
                                select.append('<option value="' +fournisseurs[i]['idf'] +'">' + fournisseurs[i]['fournisseurs'] + '</option>');                 
                            }  
                            
                            $("#idFournisseur").val(donnee.idfournisseur);

                            var unite = donnee.unitem;                 
                            var selectionnerunite = $("#iduniteedit");                          
                            selectionnerunite.empty();   
                                            
                            for (var i = 0; i < unite.length; i++) {     
                                                      
                                selectionnerunite.append('<option value="' +unite[i]['id_unite'] +'">' + unite[i]['libelle'] + '</option>');                 
                            }  
                            
                            $("#iduniteedit").val(donnee.unite);

                            var produits = donnee.designationproduit;
                            var selectionproduit = $("#idproduit"); 
                            selectionproduit.empty();
                            for (var i = 0; i < produits.length; i++) {                                                          
                                selectionproduit.append('<option value="' +produits[i]['ref_produit'] +'">' + produits[i]['designation_produit'] + '</option>');                 
                            } 
                            $("#idproduit").val(donnee.idarticle);
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
                            var select = $("#idFournisseur");                      
                            select.empty();               
                            select.append('<option value="0">Choisissez le fournisseur</option>');                                                                       
                            for (var i = 0; i < fournisseurs.length; i++) {                               
                                select.append('<option value="' +fournisseurs[i]['idf']+'">' + fournisseurs[i]['fournisseurs'] + '</option>');                                                                          
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
                            select.empty();  
                                                       
                            for (var i = 0; i < produits.length; i++) {   
                                                            
                                select.append('<option value="' +produits[i]['ref_produit'] +'">' + produits[i]['designation_produit'] + '</option>');                 
                            }  
                            //select.val(produits['ref_produit']);
                        },
                            error: function (data) {
                                swal("Erreur chargement champ produit");
                        }
                    });
            break;

            case 'recuperer_unite':
                var url = 'chargementapprovisionnement.php';
                $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {
                            var donnee = jQuery.parseJSON(data);  
                            var unites = donnee.unites;
                            var select = $("#iduniteentre");                          
                            select.empty();               
                            select.append('<option value="0">Choisissez unité</option>');                                                                      
                            for (var i = 0; i < unites.length; i++) {                               
                                select.append('<option value="' +unites[i]['id_unite']+'">' + unites[i]['libelle'] + '</option>');                                                                           
                            }                                                                                                                               
                        },
                        error: function (data) {
                            swal("Erreur chargement unité");
                        }
                });
            break;
            case 'recupererqte':                  
            var url = 'chargementapprovisionnement.php';
            $.ajax({
                type: 'GET',
                url: url,
                data:{'param':document.getElementById('param').value,                            
                'ref_article':document.getElementById('idproduit').value},
                datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {      
                   var donnee = jQuery.parseJSON(data);                                                                                                     
                    $('#qteenstock').val(donnee.quantitedispo); 
                },
                error: function (data) {
                   // swal("Erreur chargement produit");
                }
            }); 
        break;
        }              
    }


  
    function chargementpaiment() {
        switch(document.getElementById('param').value)
                {
                    case 'tous':
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
                            recPerPage = 7,
                            page = 1,
                            totalPages = 0;
        
                        var donnee = jQuery.parseJSON(data);
                       
                        var paye = donnee.paie;
                        var roleuser=donnee.user;
    
                        if(donnee.montantpayerenFC)
                        {
                            document.getElementById('montantpaye').innerText =  donnee.montantpayerenFC+' '+'FC';
                            document.getElementById('resteenfranc').innerText =  donnee.resteenfranc+' '+'FC';
                        }                                           
                        else
                        {
                            document.getElementById('montantpaye').innerText =  '0'+' '+'FC';
                            document.getElementById('resteenfranc').innerText =  '0'+' '+'FC';
                        }
                        
                        if(donnee.montantpayerendollar)
                        {
                            document.getElementById('montantpayeendollar').innerText =  donnee.montantpayerendollar+' '+'$';
                            document.getElementById('resteendollar').innerText =  donnee.resteendollar+' '+'$';
                        }                      
                        else
                        {
                            document.getElementById('montantpayeendollar').innerText =   '0'+' '+'$';
                            document.getElementById('resteendollar').innerText =   '0'+' '+'$';
                        }
                       
                        if(paye.length == 0){
                           
                        }else{
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
                                   
                                    $('#tbodypaie').empty();                                      
                                    for (var i = 0; i < displayRecords.length; i++) {               
                                        var idpaiement = displayRecords[i]['id_paiement'];
                                        var ulrModification = "editerpaiement.php?idpaiement="+idpaiement;
                                        
                                        if( roleuser != 'ADMIN')                                    
                                          var visibilite = "hidden";

                                        $("#tbodypaie").append('<tr>' +
                                        '<td>'+displayRecords[i]['numerofacture']+'</td>' +
                                        '<td>'+displayRecords[i]['client']+'</td>' +
                                        '<td>'+displayRecords[i]['date_paiement']+'</td>' +
                                        '<td>'+displayRecords[i]['montant_a_paye']+' '+displayRecords[i]['monnaie']+'</td>' + 
                                        '<td>'+displayRecords[i]['montant_paye']+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td>'+displayRecords[i]['reste']+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer paiement"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer paiement" onclick="Confirm_Deletepaiement('+idpaiement+')" ><i class="far fa-trash-alt"></button></td>' +                                                                                                                        
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

                     case 'dettes':
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
                            recPerPage = 7,
                            page = 1,
                            totalPages = 0;
        
                        var donnee = jQuery.parseJSON(data);
                       
                        var paye = donnee.paie;
                        var roleuser=donnee.user;
    
                        if(donnee.montantpayerenFC)
                        {
                            document.getElementById('montantpaye').innerText =  donnee.montantpayerenFC+' '+'FC';
                            document.getElementById('resteenfranc').innerText =  donnee.resteenfranc+' '+'FC';
                        }                                           
                        else
                        {
                            document.getElementById('montantpaye').innerText =  '0'+' '+'FC';
                            document.getElementById('resteenfranc').innerText =  '0'+' '+'FC';
                        }
                        
                        if(donnee.montantpayerendollar)
                        {
                            document.getElementById('montantpayeendollar').innerText =  donnee.montantpayerendollar+' '+'$';
                            document.getElementById('resteendollar').innerText =  donnee.resteendollar+' '+'$';
                        }                      
                        else
                        {
                            document.getElementById('montantpayeendollar').innerText =   '0'+' '+'$';
                            document.getElementById('resteendollar').innerText =   '0'+' '+'$';
                        }
                       
                        if(paye.length == 0){
                           
                        }else{
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
                                   
                                    $('#tbodypaie').empty();                                      
                                    for (var i = 0; i < displayRecords.length; i++) {               
                                        var idpaiement = displayRecords[i]['id_paiement'];
                                        var ulrModification = "editerpaiement.php?idpaiement="+idpaiement;
                                        
                                        if( roleuser != 'ADMIN')                                    
                                          var visibilite = "hidden";

                                        $("#tbodypaie").append('<tr>' +
                                        '<td>'+displayRecords[i]['numerofacture']+'</td>' +
                                        '<td>'+displayRecords[i]['client']+'</td>' +
                                        '<td>'+displayRecords[i]['date_paiement']+'</td>' +
                                        '<td>'+displayRecords[i]['montant_a_paye']+' '+displayRecords[i]['monnaie']+'</td>' + 
                                        '<td>'+displayRecords[i]['montant_paye']+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td>'+displayRecords[i]['reste']+' '+displayRecords[i]['monnaie']+'</td>' +
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer paiement"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer paiement" onclick="Confirm_Deletepaiement('+idpaiement+')" ><i class="far fa-trash-alt"></button></td>' +                                                                                                                        
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
    
                    case 'pardate':
                        var url = 'chargementpaie.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {'datepaie':document.getElementById('datep').value,'param':document.getElementById('param').value},
                    datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                    success: function (data) {
    
                        var $pagination = $('#pagination'),
                            totalRecords = 0,
                            
                            displayRecords = [],
                            recPerPage = 7,
                            page = 1,
                            totalPages = 0;
        
                        var donnee = jQuery.parseJSON(data);
                       
                        var paye = donnee.paie;
                        var roleuser=donnee.user;
    
                       // $('#montantdepense').empty();
                        document.getElementById('montantpaye').innerText =  donnee.somme+' '+'$';
                   
                        if(paye.length == 0){
                           // $('#montantdepense').empty();
                            //$('#montantdepense').append('Aucune donnée à afficher');
                        }else{
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
                                            if( roleuser != 'ADMIN')                                    
                                          var visibilite = "hidden";
                                            $("#tbodypaie").append('<tr>' +
                                                '<td>'+displayRecords[i]['numerofacture']+'</td>' +
                                                '<td>'+displayRecords[i]['date_paiement']+'</td>' +
                                                '<td>'+displayRecords[i]['montant_a_paye']+'</td>' + 
                                                '<td>'+displayRecords[i]['montant_paye']+'</td>' +
                                                '<td>'+displayRecords[i]['reste']+'</td>' +
                                                '<td style="visibility:'+visibilite+';">'+
                                                '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                                '<button onclick="Confirm_Deletepaiement('+idpaiement+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +                                                                                   
                                           
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
    
                    case 'parfacture':
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
                            recPerPage = 7,
                            page = 1,
                            totalPages = 0;
        
                        var donnee = jQuery.parseJSON(data);
                       
                        var paye = donnee.paie;
                        var roleuser=donnee.user;
    
                        document.getElementById('montantpaye').innerText =  donnee.somme+' '+'$';
                   
                        if(paye.length == 0){
                           // $('#montantdepense').empty();
                            //$('#montantdepense').append('Aucune donnée à afficher');
                        }else{
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
                                    var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
    
                                        for (var i = 0; i < displayRecords.length; i++) {
                                            
                                            var idpaiement = displayRecords[i]['id_paiement'];
                                            var ulrModification = "editerpaiement.php?idpaiement="+idpaiement;
                                            var ulrSuppression = "supprimerpaiement.php?idpaiement="+idpaiement;
                                            if( roleuser != 'ADMIN')                                    
                                          var visibilite = "hidden";
                                            $("#tbodypaie").append('<tr>' +
                                                '<td>'+displayRecords[i]['numerofacture']+'</td>' +
                                                '<td>'+displayRecords[i]['date_paiement']+'</td>' +
                                                '<td>'+displayRecords[i]['montant_a_paye']+'</td>' + 
                                                '<td>'+displayRecords[i]['montant_paye']+'</td>' +
                                                '<td>'+displayRecords[i]['reste']+'</td>' +
                                                '<td style="visibility:'+visibilite+';">'+
                                                '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                                '<button onclick="Confirm_Deletepaiement('+idpaiement+')" ><span class="glyphicon glyphicon-trash"></span></button></td>' +                                                                                   
                                            
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
                    var url = 'chargementpaie.php';                   
                    var rates = document.getElementsByName('monnaie');
                    var rate_value;
                    for(var i = 0; i < rates.length; i++){
                        if(rates[i].checked){
                            rate_value = rates[i].value;
                        }
                    }

                    $.ajax({
                            type: 'GET',   
                            url: url,
                            data:{'param':document.getElementById('param').value,                       
                            'montant_paye':document.getElementById('montant_paye').value,
                            'montantreste':document.getElementById('restecom').value,
                            'lasommede':document.getElementById('lasommede').value,
                            'numerofacture':document.getElementById('numerofacture').value,                           
                            'monnaie':rate_value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                                swal("Paiement bien enregistré");                        
                                $('#montant_paye').val('');
                                $('#numerofacture').val('');
                                $('#montant_apaye').val('');
                                $('#restecom').val('');
                                $('#lasommede').val('');
                                //var lasomede = document.getElementById('lasommede').value;
                                var donnee = jQuery.parseJSON(data); 
                                var lasomede = donnee.lasommed;
                                var recupaie = donnee.clientnum+'-'+donnee.numerorecu+'-'+donnee.numerocommande;
                                document.getElementById("imprimerrecupaiement").innerHTML = "<input type='button' class='btn btn-success' value='Imprimer Reçu' onclick='window.open(\"recupaiement.php?inforecu=" + recupaie + "&parametre="+ lasomede +"\")' />";                              
                            },
                            error: function (data) {
                                alert("Erreur enregistrement paiement");
                            }
                        });
                break;
    
                 case 'modifier': 
                    var url = 'chargementpaie.php';
                    var rates = document.getElementsByName('monnaie');
                    var rate_value;
                    for(var i = 0; i < rates.length; i++){
                        if(rates[i].checked){
                            rate_value = rates[i].value;
                        }
                    }
                    $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value,                       
                            'montant_paye':document.getElementById('montant_paye').value,
                            'datepaie':document.getElementById('datepaie').value,
                            'numerofacture':document.getElementById('numerofactureedit').value,
                            'monnaie':rate_value,
                            'idpaiem':document.getElementById('idpaiem').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {     
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
                                    $('#restecomm').val(donnee.reste);
                                   if(donnee.monnaie == 'FC')
                                   {                                     
                                        $("#fc").prop("checked", true);
                                   }
                                   else if(donnee.monnaie == '$')
                                   {                                      
                                       $("#dolar").prop("checked", true); 
                                   }
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
            
                case 'charger_facture':
                    var url = 'chargementpaie.php';
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {

                        var donnee = jQuery.parseJSON(data);  
                        var factures = donnee.lesfactures;
                        var selectfactures = $("#numerofacture");
                        
                        selectfactures.empty();               
                        selectfactures.append('<option value="0">Choisissez numero facture</option>');                                                                    
                        for (var i = 0; i < factures.length; i++) {                                                               
                            selectfactures.append('<option value="' +factures[i]['Com_num']+'">' + factures[i]['Com_num'] + '</option>');                                                                               
                        } 
                                                                                                                                
                        },
                        error: function (data) {
                            swal("Erreur chargement champ produit");
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
                                    if(donnee.commandes)
                                    {
                                        var montantapayers = parseFloat(donnee.commandes); 
                                        var montantaper = montantapayers.toFixed(4) ;
                                        var restescom = parseFloat(donnee.reste); 
                                        var restecom = restescom.toFixed(4) ;
                                         
                                        $('#montant_apaye').val(montantaper); 
                                        $('#restecom').val(restecom); 

                                        if(donnee.monaie == 'FC')
                                        {                                     
                                            $("#fc").prop("checked", true);
                                        }
                                        else if(donnee.monaie == '$')
                                        {                                      
                                            $("#dollar").prop("checked", true); 
                                        }
                                    }
                                    else
                                    {
                                        $("#dollar").prop("checked", false);
                                        $("#fc").prop("checked", false);
                                        $('#montant_apaye').val(''); 
                                        $('#restecom').val(''); 
                                    }
                                                                  
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
                        swal(data);                   
                                        
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

   /* $("input[type=radio][name=monnaie]").change(function() {
        switch ($(this).val())
        {
            case'franccongolais':                  
                document.getElementById('fc').checked = true;    
                document.getElementById('fc').value = 'FC'; 
                swal('FC');
            break;
    
            case'dolar':                
                document.getElementById('dolar').value = "$";    
                document.getElementById('dolar').checked = true;
                swal('$');
            break;
             
        }
        
    });*/



    
function chargementhistoriquedevente() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
                    $('#loadprogressbar').show();
                    $('#loadingState').show();
                var url = 'chargementvente.php';
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
                    var historiquedevente = donnee.historiquevente;
                    var roleuser=donnee.user;

                    var montantvenduenfcongo = parseFloat(donnee.montantvenduenfc);
                    var montantvenduenfco = montantvenduenfcongo.toFixed(4);

                    var montantvenduendollars = parseFloat(donnee.montantvenduendollar);
                    var montantvenduendolar = montantvenduendollars.toFixed(4);
                    $('#montantvendu').empty();
                   if(donnee.montantvenduendollar)
                    {
                        document.getElementById('montantvendu').innerText =  montantvenduendolar+' '+'$';
                    }
                    else
                    {
                        document.getElementById('montantvendu').innerText = '0'+' '+'$';
                    }  
                    $('#montantvendufc').empty();
                    if(donnee.montantvenduenfc)
                    {
                        document.getElementById('montantvendufc').innerText =  montantvenduenfco+' '+'FC';
                    }
                    else
                    {
                        document.getElementById('montantvendufc').innerText = '0'+' '+'FC';
                    }  
                    if(historiquedevente.length == 0){ 
                        document.getElementById('imprimerrapportvente').style.display='none';
                    }
                    else
                    {
                        var casetous = 'tous';
                        document.getElementById('imprimerrapportvente').style.display='block';
                        document.getElementById("imprimerrapportvente").innerHTML = "<input type='button' class='btn btn-success' value='Imprimer tous' onclick='window.open(\"rapportvente.php?infovente=" + casetous + "\")' />";                    
                        totalRecords = historiquedevente.length;
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

                                displayRecords = historiquedevente.slice(displayRecordsIndex, endRec);                              
                                $('#tbodyhistoriquevente').empty();                                   
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var iddetail = displayRecords[i]['Detail_num'];
                                    var ancienproduit = displayRecords[i]['Detail_ref'];
                                    var ancienqte = displayRecords[i]['Detail_qte'];
                                    var anciennefacture = displayRecords[i]['Detail_com'];
                                    var ancienmontant = displayRecords[i]['Detail_qte']*displayRecords[i]['puht'];
                                    var ulrModification = "editervente.php?iddetail="+iddetail+
                                    "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte+"&anciennefacture="+anciennefacture+
                                    "&ancienmontant="+ancienmontant; 
                                    var puhts = parseFloat(displayRecords[i]['puht']);
                                    var puht = puhts.toFixed(4);
                                    var pthts = parseFloat(displayRecords[i]['Detail_qte']*displayRecords[i]['puht']);
                                    var ptht = pthts.toFixed(4);
                                    if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                   
                                    $("#tbodyhistoriquevente").append('<tr>' +
                                        '<td>'+displayRecords[i]['Detail_com']+'</td>' +
                                        '<td>'+displayRecords[i]['client']+'</td>' +
                                        '<td>'+displayRecords[i]['Com_date']+'</td>' + 
                                        '<td>'+displayRecords[i]['Article_designation']+'</td>' + 
                                        '<td>'+displayRecords[i]['Detail_qte']+' '+displayRecords[i]['unitevent']+'</td>' + 
                                        '<td>'+puht+' '+displayRecords[i]['com_monnaie']+'</td>' + 
                                        '<td>'+ptht+' '+displayRecords[i]['com_monnaie']+'</td>' +                                                                                         
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer vente" ><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer vente" onclick="Confirm_Deletevente('+iddetail+','+ancienproduit+','+ancienqte+','+anciennefacture+','+ancienmontant+')" ><i class="far fa-trash-alt"></i></button></td>' +   
                                                 
                                        '</tr>');
                                }
                                                            
                            }
                        });
                    }
                    $('#loadprogressbar').hide();
                    $('#loadingState').hide();
                },
                error: function (data) {
                    $('#loadprogressbar').hide();
                    $('#loadingState').hide();
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error"); 
                }
            }); 
                break;

                case 'pardate':
                     $('#loadprogressbar').show();
                    $('#loadingState').show();
                    var url = 'chargementvente.php';
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
                   
                    var historiquedevente = donnee.historiquevente;
                    var roleuser=donnee.user;
                    var montantvenduenfcongo = parseFloat(donnee.montantvenduenfc);
                    var montantvenduenfco = montantvenduenfcongo.toFixed(4);

                    var montantvenduendollars = parseFloat(donnee.montantvenduendollar);
                    var montantvenduendolar = montantvenduendollars.toFixed(4);
                    $('#montantvendu').empty();
                   if(donnee.montantvenduendollar)
                    {
                        document.getElementById('montantvendu').innerText =  montantvenduendolar+' '+'$';
                    }
                    else
                    {
                        document.getElementById('montantvendu').innerText = '0'+' '+'$';
                    }  
                    $('#montantvendufc').empty();
                    if(donnee.montantvenduenfc)
                    {
                        document.getElementById('montantvendufc').innerText =  montantvenduenfco+' '+'FC';
                    }
                    else
                    {
                        document.getElementById('montantvendufc').innerText = '0'+' '+'FC';
                    } 
                
                    if(historiquedevente.length == 0){
                        document.getElementById('imprimerrapportvente').style.display='none';
                    }
                    else
                    {
                        var parametr = 'pardate';
                        document.getElementById('imprimerrapportvente').style.display='block';
                        var rapportventepardate = document.getElementById('pdate').value;
                        document.getElementById("imprimerrapportvente").innerHTML = "<input type='button' class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportvente.php?infovente=" + parametr + "&parametre="+ rapportventepardate +"\")' />";                    

                        totalRecords = historiquedevente.length;
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

                                displayRecords = historiquedevente.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux historiquedevente
                                
                                    $('#tbodyhistoriquevente').empty();
                                    for (var i = 0; i < displayRecords.length; i++) {
                                    var iddetail = displayRecords[i]['Detail_num'];
                                    var ancienproduit = displayRecords[i]['Detail_ref'];
                                    var ancienqte = displayRecords[i]['Detail_qte'];
                                    var anciennefacture = displayRecords[i]['Detail_com'];
                                    var ancienmontant = displayRecords[i]['Detail_qte']*displayRecords[i]['puht'];
                                    var ulrModification = "editervente.php?iddetail="+iddetail+
                                    "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte+"&anciennefacture="+anciennefacture+
                                    "&ancienmontant="+ancienmontant; 
                                    var puhts = parseFloat(displayRecords[i]['puht']);
                                    var puht = puhts.toFixed(4);
                                    var pthts = parseFloat(displayRecords[i]['Detail_qte']*displayRecords[i]['puht']);
                                    var ptht = pthts.toFixed(4);
                                    if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                   
                                    $("#tbodyhistoriquevente").append('<tr>' +
                                        '<td>'+displayRecords[i]['Detail_com']+'</td>' +
                                        '<td>'+displayRecords[i]['client']+'</td>' +
                                        '<td>'+displayRecords[i]['Com_date']+'</td>' + 
                                        '<td>'+displayRecords[i]['Article_designation']+'</td>' + 
                                        '<td>'+displayRecords[i]['Detail_qte']+' '+displayRecords[i]['unitevent']+'</td>' + 
                                        '<td>'+puht+' '+displayRecords[i]['com_monnaie']+'</td>' + 
                                        '<td>'+ptht+' '+displayRecords[i]['com_monnaie']+'</td>' +                                                                                         
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer vente" ><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer vente" onclick="Confirm_Deletevente('+iddetail+','+ancienproduit+','+ancienqte+','+anciennefacture+','+ancienmontant+')" ><i class="far fa-trash-alt"></i></button></td>' +   
                                                 
                                        '</tr>');
                                }                       
                            }
                        });
                    }

                    $('#loadprogressbar').hide();
                    $('#loadingState').hide();
                },
                error: function (data) {
                    $('#loadprogressbar').hide();
                    $('#loadingState').hide();
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error"); 
                }
            });                                                                                         
            break; 

                case 'datedebut':
                 
                    $('#loadprogressbar').show();
                    $('#loadingState').show();
                    var url = 'chargementvente.php';
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
                   
                    var historiquedevente = donnee.historiquevente;
                    var roleuser=donnee.user;
                    var montantvenduenfcongo = parseFloat(donnee.montantvenduenfc);
                    var montantvenduenfco = montantvenduenfcongo.toFixed(4);

                    var montantvenduendollars = parseFloat(donnee.montantvenduendollar);
                    var montantvenduendolar = montantvenduendollars.toFixed(4);
                    $('#montantvendu').empty();
                   if(donnee.montantvenduendollar)
                    {
                        document.getElementById('montantvendu').innerText =  montantvenduendolar+' '+'$';
                    }
                    else
                    {
                        document.getElementById('montantvendu').innerText = '0'+' '+'$';
                    }  
                    $('#montantvendufc').empty();
                    if(donnee.montantvenduenfc)
                    {
                        document.getElementById('montantvendufc').innerText =  montantvenduenfco+' '+'FC';
                    }
                    else
                    {
                        document.getElementById('montantvendufc').innerText = '0'+' '+'FC';
                    }                   
               
                    if(historiquedevente.length == 0){
                        document.getElementById('imprimerrapportvente').style.display='none';
                    }
                    else
                    {
                        var parametr = 'datedebut';
                        document.getElementById('imprimerrapportvente').style.display='block';
                        var datedebut = document.getElementById('datedebut').value;
                        var datefin = document.getElementById('datefin').value;
                       // rapportperiode = datedebut+"-"+datefin;
                        document.getElementById("imprimerrapportvente").innerHTML = "<input type='button' class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportvente.php?infovente=" + parametr + "&datedbt="+ datedebut +"&datefin="+datefin+"\")' />";                    

                        totalRecords = historiquedevente.length;
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

                                displayRecords = historiquedevente.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux historiquedevente
                                
                                    $('#tbodyhistoriquevente').empty();
                                    for (var i = 0; i < displayRecords.length; i++) {
                                        var iddetail = displayRecords[i]['Detail_num'];
                                    var ancienproduit = displayRecords[i]['Detail_ref'];
                                    var ancienqte = displayRecords[i]['Detail_qte'];
                                    var anciennefacture = displayRecords[i]['Detail_com'];
                                    var ancienmontant = displayRecords[i]['Detail_qte']*displayRecords[i]['puht'];
                                    var ulrModification = "editervente.php?iddetail="+iddetail+
                                    "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte+"&anciennefacture="+anciennefacture+
                                    "&ancienmontant="+ancienmontant; 
                                    var puhts = parseFloat(displayRecords[i]['puht']);
                                    var puht = puhts.toFixed(4);
                                    var pthts = parseFloat(displayRecords[i]['Detail_qte']*displayRecords[i]['puht']);
                                    var ptht = pthts.toFixed(4);
                                    if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                   
                                    $("#tbodyhistoriquevente").append('<tr>' +
                                        '<td>'+displayRecords[i]['Detail_com']+'</td>' +
                                        '<td>'+displayRecords[i]['client']+'</td>' +
                                        '<td>'+displayRecords[i]['Com_date']+'</td>' + 
                                        '<td>'+displayRecords[i]['Article_designation']+'</td>' + 
                                        '<td>'+displayRecords[i]['Detail_qte']+' '+displayRecords[i]['unitevent']+'</td>' + 
                                        '<td>'+puht+' '+displayRecords[i]['com_monnaie']+'</td>' + 
                                        '<td>'+ptht+' '+displayRecords[i]['com_monnaie']+'</td>' +                                                                                         
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer vente" ><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer vente" onclick="Confirm_Deletevente('+iddetail+','+ancienproduit+','+ancienqte+','+anciennefacture+','+ancienmontant+')" ><i class="far fa-trash-alt"></i></button></td>' +   
                                                 
                                        '</tr>');
                                }                       
                            }
                        });
                    }

                    $('#loadprogressbar').hide();
                    $('#loadingState').hide();
                },
                error: function (data) {
                    $('#loadprogressbar').hide();
                    $('#loadingState').hide();
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error"); 
                }
            });
                break;

            case 'produitpardate':
                $('#loadprogressbar').show();
                $('#loadingState').show();
                var url = 'chargementvente.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,
                'pdate':document.getElementById('pdate').value,
                'designation':document.getElementById('designation').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var historiquedevente = donnee.historiquevente;
                    var roleuser=donnee.user;
                    var montantvenduenfcongo = parseFloat(donnee.montantvenduenfc);
                    var montantvenduenfco = montantvenduenfcongo.toFixed(4);

                    var montantvenduendollars = parseFloat(donnee.montantvenduendollar);
                    var montantvenduendolar = montantvenduendollars.toFixed(4);
                    $('#montantvendu').empty();
                   if(donnee.montantvenduendollar)
                    {
                        document.getElementById('montantvendu').innerText =  montantvenduendolar+' '+'$';
                    }
                    else
                    {
                        document.getElementById('montantvendu').innerText = '0'+' '+'$';
                    }  
                    $('#montantvendufc').empty();
                    if(donnee.montantvenduenfc)
                    {
                        document.getElementById('montantvendufc').innerText =  montantvenduenfco+' '+'FC';
                    }
                    else
                    {
                        document.getElementById('montantvendufc').innerText = '0'+' '+'FC';
                    }               
                    if(historiquedevente.length == 0){
                        document.getElementById('imprimerrapportvente').style.display='none';
                    }
                    else
                    {
                        var parametr = 'produitpardate';
                        document.getElementById('imprimerrapportvente').style.display='block';
                        var datepro = document.getElementById('pdate').value;
                        var designation = document.getElementById('designation').value;
                        rapportproduitpardate = datepro+"-"+designation;
                        document.getElementById("imprimerrapportvente").innerHTML = "<input type='button' class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportvente.php?infovente=" + parametr + "&datepr="+ datepro +"&designation="+designation+"\")' />";                    
                        totalRecords = historiquedevente.length;
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

                                displayRecords = historiquedevente.slice(displayRecordsIndex, endRec);
                                
                                    $('#tbodyhistoriquevente').empty();
                                    for (var i = 0; i < displayRecords.length; i++) {
                                        var iddetail = displayRecords[i]['Detail_num'];
                                    var ancienproduit = displayRecords[i]['Detail_ref'];
                                    var ancienqte = displayRecords[i]['Detail_qte'];
                                    var anciennefacture = displayRecords[i]['Detail_com'];
                                    var ancienmontant = displayRecords[i]['Detail_qte']*displayRecords[i]['puht'];
                                    var ulrModification = "editervente.php?iddetail="+iddetail+
                                    "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte+"&anciennefacture="+anciennefacture+
                                    "&ancienmontant="+ancienmontant; 
                                    var puhts = parseFloat(displayRecords[i]['puht']);
                                    var puht = puhts.toFixed(4);
                                    var pthts = parseFloat(displayRecords[i]['Detail_qte']*displayRecords[i]['puht']);
                                    var ptht = pthts.toFixed(4);
                                    if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                   
                                    $("#tbodyhistoriquevente").append('<tr>' +
                                        '<td>'+displayRecords[i]['Detail_com']+'</td>' +
                                        '<td>'+displayRecords[i]['client']+'</td>' +
                                        '<td>'+displayRecords[i]['Com_date']+'</td>' + 
                                        '<td>'+displayRecords[i]['Article_designation']+'</td>' + 
                                        '<td>'+displayRecords[i]['Detail_qte']+' '+displayRecords[i]['unitevent']+'</td>' + 
                                        '<td>'+puht+' '+displayRecords[i]['com_monnaie']+'</td>' + 
                                        '<td>'+ptht+' '+displayRecords[i]['com_monnaie']+'</td>' +                                                                                         
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer vente" ><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer vente" onclick="Confirm_Deletevente('+iddetail+','+ancienproduit+','+ancienqte+','+anciennefacture+','+ancienmontant+')" ><i class="far fa-trash-alt"></i></button></td>' +   
                                                 
                                        '</tr>');
                                }
                                                            
                            }
                        });
                    }

                    $('#loadprogressbar').hide();
                    $('#loadingState').hide();
                },
                error: function (data) {
                    $('#loadprogressbar').hide();
                    $('#loadingState').hide();
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error"); 
                }
            }); 
                break;
                case 'parproduit':
                    $('#loadprogressbar').show();
                    $('#loadingState').show();
                    var url = 'chargementvente.php';
                $.ajax({
                type: 'GET',
                url: url,
                data: {'param':document.getElementById('param').value,'designation':document.getElementById('designation').value},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {

                    var $pagination = $('#pagination'),
                        totalRecords = 0,
                        
                        displayRecords = [],
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var historiquedevente = donnee.historiquevente;
                    var roleuser=donnee.user;
                    var montantvenduenfcongo = parseFloat(donnee.montantvenduenfc);
                    var montantvenduenfco = montantvenduenfcongo.toFixed(4);

                    var montantvenduendollars = parseFloat(donnee.montantvenduendollar);
                    var montantvenduendolar = montantvenduendollars.toFixed(4);
                    $('#montantvendu').empty();
                   if(donnee.montantvenduendollar)
                    {
                        document.getElementById('montantvendu').innerText =  montantvenduendolar+' '+'$';
                    }
                    else
                    {
                        document.getElementById('montantvendu').innerText = '0'+' '+'$';
                    }  
                    $('#montantvendufc').empty();
                    if(donnee.montantvenduenfc)
                    {
                        document.getElementById('montantvendufc').innerText =  montantvenduenfco+' '+'FC';
                    }
                    else
                    {
                        document.getElementById('montantvendufc').innerText = '0'+' '+'FC';
                    }              
                    if(historiquedevente.length == 0){
                        document.getElementById('imprimerrapportvente').style.display='none';
                    }
                    else
                    {
                        var parametr = 'parproduit';
                        document.getElementById('imprimerrapportvente').style.display='block';
                        var designation = document.getElementById('designation').value;
                        document.getElementById("imprimerrapportvente").innerHTML = "<input type='button' class='btn btn-success' value='Imprimer' onclick='window.open(\"rapportvente.php?infovente=" + parametr + "&parametre="+ designation +"\")' />";                    

                        totalRecords = historiquedevente.length;
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

                                displayRecords = historiquedevente.slice(displayRecordsIndex, endRec);
                                //Detail relatif aux historiquedevente
                                
                                    $('#tbodyhistoriquevente').empty();
                                //var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var iddetail = displayRecords[i]['Detail_num'];
                                    var ancienproduit = displayRecords[i]['Detail_ref'];
                                    var ancienqte = displayRecords[i]['Detail_qte'];
                                    var anciennefacture = displayRecords[i]['Detail_com'];
                                    var ancienmontant = displayRecords[i]['Detail_qte']*displayRecords[i]['puht'];
                                    var ulrModification = "editervente.php?iddetail="+iddetail+
                                    "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte+"&anciennefacture="+anciennefacture+
                                    "&ancienmontant="+ancienmontant; 
                                    var puhts = parseFloat(displayRecords[i]['puht']);
                                    var puht = puhts.toFixed(4);
                                    var pthts = parseFloat(displayRecords[i]['Detail_qte']*displayRecords[i]['puht']);
                                    var ptht = pthts.toFixed(4);
                                    if( roleuser != 'ADMIN')                                    
                                      var visibilite = "hidden";
                                   
                                    $("#tbodyhistoriquevente").append('<tr>' +
                                        '<td>'+displayRecords[i]['Detail_com']+'</td>' +
                                        '<td>'+displayRecords[i]['client']+'</td>' +
                                        '<td>'+displayRecords[i]['Com_date']+'</td>' + 
                                        '<td>'+displayRecords[i]['Article_designation']+'</td>' + 
                                        '<td>'+displayRecords[i]['Detail_qte']+' '+displayRecords[i]['unitevent']+'</td>' + 
                                        '<td>'+puht+' '+displayRecords[i]['com_monnaie']+'</td>' + 
                                        '<td>'+ptht+' '+displayRecords[i]['com_monnaie']+'</td>' +                                                                                         
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer vente" ><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer vente" onclick="Confirm_Deletevente('+iddetail+','+ancienproduit+','+ancienqte+','+anciennefacture+','+ancienmontant+')" ><i class="far fa-trash-alt"></i></button></td>' +   
                                                 
                                        '</tr>');
                                }                       
                            }
                        });
                    }

                    $('#loadprogressbar').hide();
                    $('#loadingState').hide();
                },
                error: function (data) {
                    $('#loadprogressbar').hide();
                    $('#loadingState').hide();
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error"); 
                }
            }); 
                break;

                case'parclient':
                $('#loadprogressbar').show();
                $('#loadingState').show();
                var url = 'chargementvente.php';
            $.ajax({
            type: 'GET',
            url: url,
            data: {'param':document.getElementById('param').value,'client':document.getElementById('designation').value},
            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
            success: function (data) {

                var $pagination = $('#pagination'),
                    totalRecords = 0,
                    
                    displayRecords = [],
                    recPerPage = 5,
                    page = 1,
                    totalPages = 0;

                var donnee = jQuery.parseJSON(data);
               
                var historiquedevente = donnee.historiquevente;
                var roleuser=donnee.user;
                var montantvenduenfcongo = parseFloat(donnee.montantvenduenfc);
                var montantvenduenfco = montantvenduenfcongo.toFixed(4);

                var montantvenduendollars = parseFloat(donnee.montantvenduendollar);
                var montantvenduendolar = montantvenduendollars.toFixed(4);
                $('#montantvendu').empty();
               if(donnee.montantvenduendollar)
                {
                    document.getElementById('montantvendu').innerText =  montantvenduendolar+' '+'$';
                }
                else
                {
                    document.getElementById('montantvendu').innerText = '0'+' '+'$';
                }  
                $('#montantvendufc').empty();
                if(donnee.montantvenduenfc)
                {
                    document.getElementById('montantvendufc').innerText =  montantvenduenfco+' '+'FC';
                }
                else
                {
                    document.getElementById('montantvendufc').innerText = '0'+' '+'FC';
                }               
                if(historiquedevente.length == 0){
                    document.getElementById('imprimerrapportvente').style.display='none';
                }
                else
                {
                    var parametr = 'parclient';
                    document.getElementById('imprimerrapportvente').style.display='block';
                    var client = document.getElementById('designation').value;
                    document.getElementById("imprimerrapportvente").innerHTML = "<input type='button' class='btn btn-success' value='Imprimer rapport par client' onclick='window.open(\"rapportvente.php?infovente=" + parametr + "&parametre="+ client +"\")' />";                    

                    totalRecords = historiquedevente.length;
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
                            displayRecords = historiquedevente.slice(displayRecordsIndex, endRec);                               
                                $('#tbodyhistoriquevente').empty();
                                for (var i = 0; i < displayRecords.length; i++) {
                                    var iddetail = displayRecords[i]['Detail_num'];
                                var ancienproduit = displayRecords[i]['Detail_ref'];
                                var ancienqte = displayRecords[i]['Detail_qte'];
                                var anciennefacture = displayRecords[i]['Detail_com'];
                                var ancienmontant = displayRecords[i]['Detail_qte']*displayRecords[i]['puht'];
                                var ulrModification = "editervente.php?iddetail="+iddetail+
                                "&ancienproduit="+ancienproduit+"&ancienqte="+ancienqte+"&anciennefacture="+anciennefacture+
                                "&ancienmontant="+ancienmontant; 
                                var puhts = parseFloat(displayRecords[i]['puht']);
                                var puht = puhts.toFixed(4);
                                var pthts = parseFloat(displayRecords[i]['Detail_qte']*displayRecords[i]['puht']);
                                var ptht = pthts.toFixed(4);
                                if( roleuser != 'ADMIN')                                    
                                  var visibilite = "hidden";
                               
                                $("#tbodyhistoriquevente").append('<tr>' +
                                    '<td>'+displayRecords[i]['Detail_com']+'</td>' +
                                    '<td>'+displayRecords[i]['client']+'</td>' +
                                    '<td>'+displayRecords[i]['Com_date']+'</td>' + 
                                    '<td>'+displayRecords[i]['Article_designation']+'</td>' + 
                                    '<td>'+displayRecords[i]['Detail_qte']+' '+displayRecords[i]['unitevent']+'</td>' + 
                                    '<td>'+puht+' '+displayRecords[i]['com_monnaie']+'</td>' + 
                                    '<td>'+ptht+' '+displayRecords[i]['com_monnaie']+'</td>' +                                                                                         
                                    '<td style="visibility:'+visibilite+';">'+
                                        '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer vente" ><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                        '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer vente" onclick="Confirm_Deletevente('+iddetail+','+ancienproduit+','+ancienqte+','+anciennefacture+','+ancienmontant+')" ><i class="far fa-trash-alt"></i></button></td>' +                                               
                                    '</tr>');
                            }                        
                        }
                    });
                }

                $('#loadprogressbar').hide();
                $('#loadingState').hide();
            },
            error: function (data) {
                $('#loadprogressbar').hide();
                $('#loadingState').hide();
                swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");                    
            }
        }); 
            break;

            case 'modifier': 
            var url = 'chargementvente.php';
            $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                            'numerocommande':document.getElementById('numerocommande').value,
                            'idclient':document.getElementById('idclient').value,
                            'idarticle':document.getElementById('idarticle').value,
                            'qte':document.getElementById('detailquantite').value,
                            'puht':document.getElementById('puht').value,
                            'datevente':document.getElementById('datedetail').value,

                            'iddetail':document.getElementById('idcommande').value,
                            'anciennefacture':document.getElementById('anciennefacture').value,
                            'ancienmontant':document.getElementById('ancienmontant').value,
                            'ancienproduit':document.getElementById('ancienproduit').value,
                            'ancienqte':document.getElementById('ancienqte').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {
                         
                            swal("Détail vente bien modifié");                        
                            
                        },
                        error: function (data) {
                            swal("Erreur modification approvisionnement");
                        }
                    });
            break;
            case 'chargerchampmodifier':
                var url = 'chargementvente.php';
               /// $('#idFournisseur').empty();
                $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value,                            
                            'iddetail':document.getElementById('idcommande').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                            var donnee = jQuery.parseJSON(data);  
                            
                            var touteslescommandes = donnee.commande;                 
                            var selectionnercommades = $("#numerocommande");                          
                            selectionnercommades.empty();   
                                            
                            for (var i = 0; i < touteslescommandes.length; i++) {     
                                                      
                                selectionnercommades.append('<option value="' +touteslescommandes[i]['Com_num'] +'">' + touteslescommandes[i]['Com_num'] + '</option>');                 
                            }  
                            
                            $("#numerocommande").val(donnee.numerofacture);                         
                            $('#detailquantite').val(donnee.quantitedetail);
                            $('#puht').val(donnee.puht);
                            $('#datedetail').val(donnee.datecommande);
                            var touslesclients = donnee.client;                 
                            var selectionnertouslesclients = $("#idclient");                          
                            selectionnertouslesclients.empty();                                              
                            for (var i = 0; i < touslesclients.length; i++) {                                                         
                                selectionnertouslesclients.append('<option value="' +touslesclients[i]['Client_num'] +'">' + touslesclients[i]['client'] + '</option>');                 
                            }  
                            
                            $("#idclient").val(donnee.clientnum);
                            var produits = donnee.designationproduit;
                            var selectionproduit = $("#idarticle"); 
                            selectionproduit.empty();
                            for (var i = 0; i < produits.length; i++) {                                                          
                                selectionproduit.append('<option value="' +produits[i]['Article_code'] +'">' + produits[i]['Article_designation'] + '</option>');                 
                            } 
                            $("#idarticle").val(donnee.idarticle);
                            },
                            error: function (data) {
                                swal("Erreur chargement champ modification");
                            }
                        });
            break; 

        }              
    }


    $('#recherchevente').on('click', function(){
        $('#tbodyhistoriquevente').empty();
        chargementhistoriquedevente();
        });

   

    function produitetclient()
    {        
		if($('#produit').prop("checked"))
		{
			document.getElementById('param').value='parproduit';               
		}	
        else if($('#parclient').prop("checked"))
		{
			document.getElementById('param').value='parclient';                		
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
            document.getElementById('designation').disabled = true;    
            document.getElementById('tous').checked = true;    
            document.getElementById('tous').value = 'tous'; 
        break;

        case'produit':
            document.getElementById('pdate').disabled = true;                             
            document.getElementById('datedebut').disabled = true;            
            document.getElementById('datefin').disabled = true;      
            document.getElementById('designation').disabled = false;  
            document.getElementById('designation').value = "";    
            document.getElementById('produit').checked = true;
        break;

        case'pardate':
            document.getElementById('pdate').disabled = false;                                
            document.getElementById('datedebut').disabled = true;            
            document.getElementById('datefin').disabled = true;           
            document.getElementById('designation').disabled = true; 
            document.getElementById('pardate').checked = true;  
        break;

        case'produitpardate':
            document.getElementById('pdate').disabled = false;                             
            document.getElementById('datedebut').disabled = true;            
            document.getElementById('datefin').disabled = true;      
            document.getElementById('designation').disabled = false; 
            document.getElementById('designation').value = "";  
            document.getElementById('produitpardate').checked = true; 
        break;

        case'parperiode':
            document.getElementById('pdate').disabled = true;                             
            document.getElementById('datedebut').disabled = false;            
            document.getElementById('datefin').disabled = false;   
            document.getElementById('designation').disabled = true;  
            document.getElementById('parperiode').checked = true; 
        break;

        case'parclient':
            document.getElementById('pdate').disabled = true;                             
            document.getElementById('datedebut').disabled = true;            
            document.getElementById('datefin').disabled = true;      
            document.getElementById('designation').disabled = false;  
            document.getElementById('designation').value = "";    
            document.getElementById('parclient').checked = true; 
        break;

    }
    
});

function desactivertoutevente()
{   
        document.getElementById('pdate').disabled = true;                             
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;   
        document.getElementById('designation').disabled = true;    
        document.getElementById('tous').checked = true;    
        document.getElementById('tous').value = 'tous';  
}



function Confirm_Deletevente(iddetail,ancienproduit,ancienqte,anciennefacture,ancienmontant) 

{
    swal({
        title: "Suppression !",
        text: "Voulez-vous vraiment supprimer ce detail de vente?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               deletevente(iddetail,ancienproduit,ancienqte,anciennefacture,ancienmontant)
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
}  

function deletevente(iddetail,ancienproduit,ancienqte,anciennefacture,ancienmontant){
    var url = 'chargementvente.php';
    $.ajax({
                type: 'GET',
                url: url,
                data:{'param':document.getElementById('param').value='suppression',
                'iddetail':iddetail,
                'ancienproduit':ancienproduit,
                'ancienqte':ancienqte,
                'anciennefacture':anciennefacture,
                'ancienmontant':ancienmontant},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    swal('Detail vente supprimé');                   
                    
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    //console.log(data);
                }
            }); 
} 
    

function chargementutilisateurs() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
                 $('#loadingState').show();
                var url = 'chargementutilisateur.php';
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
                   
                    var lesutilisateurs = donnee.utilisateur;
                   // $('#montantdepense').empty();
                   var roleuser=donnee.user;
                    if(lesutilisateurs.length == 0){
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                        '<td>'+displayRecords[i]['roles']+'</td>' +                                        
                                        '<td style="visibility:'+visibilite+';">'+
                                            '<a href="'+ulrModification+'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editer utilisateur"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<button class="btn btn-danger" onclick="Confirm_deleteuser('+iduser+')" ><i class="far fa-trash-alt"></i></button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +                                                                                          
                                            '<button class="btn btn-info" onclick="Confirm_activeruser('+iduser+','+etatuser+')"><i class="'+etatutilisateur+'"></i></button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;</td>'+
                                        
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
                       // $('#montantdepense').empty();
                        //$('#montantdepense').append('Aucune donnée à afficher');
                    }else{
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
                                    var urlactivation = "activerUtilisateur.php?idUser="+iduser+
                                    "&etat="+etatuser;
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
                                        '<td>'+displayRecords[i]['roles']+'</td>' +                                        
                                        '<td style="visibility:'+visibilite+';">'+
                                        '<a href="'+ulrModification+'" class="btn btn-info"><i class="fas fa-edit"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                        '<button class="btn btn-danger" onclick="Confirm_deleteuser('+iduser+')" ><i class="far fa-trash-alt"></i></button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +                                                                                          
                                        '<button class="btn btn-info" onclick="Confirm_activeruser('+iduser+','+etatuser+')"><i class="'+etatutilisateur+'"></i></button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;</td>'+
                                    
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
                        type: 'POST',
                        url: url,
                        data:{'param':document.getElementById('param').value,
                        'login':document.getElementById('login').value,
                        'pwd1':document.getElementById('pwd1').value,
                        'pwd2':document.getElementById('pwd2').value,
                        'email':document.getElementById('email').value,
                        'userphone':document.getElementById('usernumber').value,
                        'userrezosocio':document.getElementById('userresosicio').value,
                        'useradress':document.getElementById('useradresse').value,
                        'role':document.getElementById('fonctionn').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) { 
                            var donnee = jQuery.parseJSON(data);
                            swal(donnee.successmessage);                                                
                            $('#login').val('');
                            $('#pwd1').val('');
                            $('#pwd2').val('');
                            $('#email').val('');
                        },
                        error: function (data) {
                            var donnee = jQuery.parseJSON(data);
                            swal(donnee.validationerreur); 
                            //alert("Erreur enregistrement utilisateur");
                        }
                    });
            break;

            case 'modifier': 
            var url = 'chargementutilisateur.php';
            $.ajax({
                    type: 'POST',     
                    url: url,
                    data:{'param':document.getElementById('param').value,
                    'editlogin':document.getElementById('modifierlogin').value,
                    'editpwd1':document.getElementById('modifierpwd1').value,
                    'editpwd2':document.getElementById('modiferpwd2').value,
                    'userphoneedit':document.getElementById('usernumberedit').value,
                    'userrezosocioedit':document.getElementById('userresosicioedit').value,
                    'useradressedit':document.getElementById('useradresseedit').value,
                    'editemail':document.getElementById('modiferemailemail').value,
                    'editrole':document.getElementById('modifierrole').value,
                    'idu':document.getElementById('idutili').value},
                    datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                    success: function (data) {
                        //var donnee = jQuery.parseJSON(data);
                        swal("Utilisateur modifié avec succès");                                                                            
                    },
                    error: function (data) {
                        swal("Erreur modification utilisateur");
                    }
                });
            break;
            case 'chargerchampmodifier':
                var url = 'chargementutilisateur.php';
                $.ajax({
                        type: 'POST',
                        url: url,
                        data:{'param':document.getElementById('param').value,                            
                        'idu':document.getElementById('idutili').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {                          
                            var donnee = jQuery.parseJSON(data);                                                                               
                            $('#modifierlogin').val(donnee.nomuser);
                            $('#modifierpwd1').val(donnee.motdepasse);
                            $('#modiferpwd2').val(donnee.motdepasse);
                            $('#modiferemailemail').val(donnee.adressmail);
                            $('#modifierrole').val(donnee.fonction);

                            $('#usernumberedit').val(donnee.userphones);
                            $('#userresosicioedit').val(donnee.userreseausocios);
                            $('#useradresseedit').val(donnee.useradresses);
                        },
                        error: function (data) {
                            swal("Erreur chargement champ modification");
                        }
                    });
            break;
            
        }              
    }

function verifiermsgvalidation()
{
    

    chargementutilisateurs();
}

   $('#rechercheutilisateur').on('click', function(){
        $('#tbodyproduit').empty();
        chargementutilisateurs();
        });

function Confirm_deleteuser(iduser) 

{
    swal({
        title: "Suppression !",
        text: "Etes-vous sûr de vouloir supprimer cet utilisateur?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               deleteutilisateur(iduser);
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
}  

function deleteutilisateur(iduser){
    var url = 'chargementutilisateur.php';
    $.ajax({
                type: 'POST',
                url: url,
                data:{'param':document.getElementById('param').value='suppression','idUser':iduser},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    swal('Utilisateur supprimé avec succes');                   
                    //chargementdepense();                   
                   //$('#loadingState').hide();
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    //console.log(data);
                }
            }); 
}  

function Confirm_activeruser(iduser,etat) 
{
    if (parseInt(etat) == 1)
    {
        swal({
        title: "Desactivation !",
        text: "Etes-vous sûr de vouloir désactiver cet utilisateur?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               activerutilisateur(iduser,etat);
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
    }
    else
    {
        swal({
        title: "Activation !",
        text: "Etes-vous sûr de vouloir activer cet utilisateur?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               //suppression
               activerutilisateur(iduser,etat);
              // $('#tbodydepense').empty();
               
            } else {
                //annuler
               // swal("Your imaginary file is safe!");
            }
        });
    }
    
}  

function activerutilisateur(iduser,etat){
    var url = 'chargementutilisateur.php';
    $.ajax({
                type: 'POST',
                url: url,
                data:{'param':document.getElementById('param').value='activer','idUser':iduser,'etat':etat},
				datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    if(parseInt(etat))
                    {
                        swal('Utilisateur désactivé');                   
                    //chargementdepense();                   
                   //$('#loadingState').hide();
                    }
                    else
                    {
                        swal('Utilisateur Activé');                   
                    //chargementdepense();                   
                   //$('#loadingState').hide();
                    }
                    
                },
                error: function (data) {
                    //  $("#progressBar").hide();
                    //$('#loadingState').hide();
                    swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                    //console.log(data);
                }
            }); 
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

function desactivertoututilisateur()
{   
    document.getElementById('logins').disabled = true;  
    document.getElementById('tous').checked = true;    
    document.getElementById('tous').value = 'tous';  
}


function verifiermonnaie()
{        
    if($('#comfc').prop("checked"))
    {
        recolter();               
    }	
    else if($('#comdollar').prop("checked"))
    {
        recolter();                		
    } 
    else 
    {
        swal('Veuillez cocher la monnaie');             		
    }           
}


function verifiermonnaiedepense()
{        
    if($('#fc').prop("checked"))
    {
        chargementdepense();               
    }	
    else if($('#dollar').prop("checked"))
    {
        chargementdepense();                		
    } 
    else 
    {
        swal('Veuillez cocher la monnaie');             		
    }           
}



function verifierpassword()
{        
    if(empty($('#pwd1')))
    {
        swal("Error!!! le mot de passe ne doit pas être vide");              
    }	
    else if($('#pwd1')!==$('#pwd2'))
    {
        swal("Erreur!!! les deux mots de passe ne sont pas identiques");                		
    } 
    else 
    {
        chargementutilisateurs();            		
    }           
}

function verifiermonnaieapprovisionnement()
{        
    if($('#approfc').prop("checked") && iduniteentre.value != "")
    {
        chargementapprovisionnement();               
    }	
    else if($('#approdollar').prop("checked") && iduniteentre.value != "")
    {
        chargementapprovisionnement();                		
    } 
    else 
    {
        swal('Veuillez cocher la monnaie et choisissez unité'       );             		
    }           
}

/*Debut traitement facturation*/
function recolter()
{
    switch(document.getElementById('param').value)
    {
        case 'recup_client':                 
            var url = 'facture.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data:{'param':document.getElementById('param').value,                            
                    'ref_client':document.getElementById('ref_client').value},
                    datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                    success: function (data) {      
                       var donnee = jQuery.parseJSON(data);                                                                                                     
                        $('#civilite').val(donnee.civilite); 
                        $('#nom_client').val(donnee.nom); 
                        $('#prenom_client').val(donnee.prenom);                                             
                    },
                    error: function (data) {
                        swal("Erreur recupération client");
                    }
                });     
                break;

                case 'recup_article':                  
                    var url = 'facture.php';
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data:{'param':document.getElementById('param').value,                            
                        'ref_produit':document.getElementById('ref_produit').value},
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {      
                           var donnee = jQuery.parseJSON(data);                                                                                                     
                            $('#designation').val(donnee.designation); 
                            $('#qte').val(donnee.quantite); 
                            $('#idunitefacture').val(donnee.unite);
                            $('#qte_commande').val(''); 
                            $('#puht').val('');                                             
                        },
                        error: function (data) {
                            swal("Erreur chargement produit");
                        }
                    }); 
                break;

                case 'recup_unite':                  
                var url = 'facture.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data:{'param':document.getElementById('param').value,                            
                    'idunite':document.getElementById('unitmesure').value},
                    datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                    success: function (data) {      
                       var donnee = jQuery.parseJSON(data);                                                                                                     
                        $('#unitmesure').val(donnee.unitemesu); 
                        $('#qte_commande').val(''); 
                        $('#puht').val('');                                             
                    },
                    error: function (data) {
                        swal("Erreur chargement produit");
                    }
                }); 
                break;

                case 'facturer':
                    var url = 'facture.php';
                    var rates = document.getElementsByName('commonnaie');
                    var rate_value;
                    for(var i = 0; i < rates.length; i++){
                        if(rates[i].checked){
                            rate_value = rates[i].value;
                        }
                    }
                    $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value,
                            'ref_client':document.getElementById('ref_client').value,
                            'total_com':document.getElementById('total_com').value,
                            'chaine_com':document.getElementById('chaine_com').value,
                            'commonnaie':rate_value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.'unitef':document.getElementById('idunitefacture').value,
                            success: function (data) {
                                swal("La facture a été enregistrée avec succes");                        
                                $('#civilite').val('');
                                $('#nom_client').val('');
                                $('#prenom_client').val('');
                                $('#designation').val('');
                                $('#total_commande').val('');
                                $('#qte').val('');
                                $('#qte_commande').val('');
                                $('#puht').val('');
                                $('#idunitefacture').val('');
                                var donnee = jQuery.parseJSON(data); 
                                var reponse = donnee.clientnum+'-'+donnee.detailcom;
                                document.getElementById("editer").innerHTML = "<input type='button' class='btn btn-success' value='Imprimer la facture' onclick='window.open(\"factures.php?info=" + reponse + "\")' />";                              
                            },
                            error: function (data) {
                                swal.fire("Error serveur "+data.status, data.responseJSON.message, "error");
                            }
                        });
                    break;
                    case 'charger_client':
                        var url = 'facture.php';
                        $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                            var donnee = jQuery.parseJSON(data);  
                            var clients = donnee.client;
                            var select = $("#ref_client");
                           
                            select.empty();                                                              
                            select.append('<option value="0">Choisissez le client</option>');
                            for (var i = 0; i < clients.length; i++) {                                                              
                                select.append('<option value="' +clients[i]['Client_num']+'">' + clients[i]['client'] + '</option>');                                                                           
                            } 
                                                                                                                                 
                            },
                            error: function (data) {
                                swal("Erreur chargement champ client");
                            }
                        });
                    break;

                    case 'charger_produit':
                        var url = 'facture.php';
                        $.ajax({
                            type: 'GET',
                            url: url,
                            data:{'param':document.getElementById('param').value},
                            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                            success: function (data) {
    
                            var donnee = jQuery.parseJSON(data);  
                            var produits = donnee.produit;
                            var selectproduit = $("#ref_produit");                          
                           // var selectproduit = $("#ref_produit");
                            selectproduit.empty();               
                            selectproduit.append('<option value="0">Choisissez le produit</option>');                                                                    
                            for (var i = 0; i < produits.length; i++) {                                                               
                                selectproduit.append('<option value="' +produits[i]['Article_code']+'">' + produits[i]['Article_designation'] + '</option>');                                                                               
                            } 
                                                                                                                                 
                            },
                            error: function (data) {
                                swal("Erreur chargement champ produit");
                            }
                        });
                    break;

                    case 'charger_unite':
                        var url = 'facture.php';
                        $.ajax({
                                type: 'GET',
                                url: url,
                                data:{'param':document.getElementById('param').value},
                                datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                                success: function (data) {
                                    var donnee = jQuery.parseJSON(data);  
                                    var unites = donnee.unites;
                                    var select = $("#idunitefacture");                          
                                    select.empty();               
                                    select.append('<option value="0">Choisissez unité</option>');                                                                      
                                    for (var i = 0; i < unites.length; i++) {                               
                                        select.append('<option value="' +unites[i]['id_unite']+'">' + unites[i]['libelle'] + '</option>');                                                                           
                                    }                                                                                                                               
                                },
                                error: function (data) {
                                    swal("Erreur chargement unité");
                                }
                        });
                    break;

    }     
}


var tot_com = 0;

function plus_com()
{
    if(idunitefacture.value != "" && civilite.value != "" && designation.value != "" && ref_client.value != 0 && ref_produit.value != 0 && qte_commande.value != "0" && qte_commande.value != "" && puht.value != "0" && puht.value != "")
    {
        if(parseInt(qte_commande.value) > parseInt(qte.value))
        {
            swal("La quantité en stock n'est pas suffisante pour honorer la commande");
        }          
        else
        {
            var ref_p = ref_produit.value;
            var qte_p = qte_commande.value;
            var unite_p = idunitefacture.value;
            var des_p = designation.value;
            var pht_p = puht.value;

            tot_com = tot_com + qte_p*pht_p;
            total_commande.value = tot_com.toFixed(2);
            total_com.value = total_commande.value;
            chaine_com.value += "|" + ref_p + ";" + qte_p + ";" + unite_p + ";" + des_p + ";" + pht_p;
            facture();
        }
    }
}

function facture()
{
    var tab_com = chaine_com.value.split('|');
    var nb_lignes = tab_com.length;
    document.getElementById("det_com").innerHTML = "";
    for (ligne=0; ligne<nb_lignes; ligne++)
    {
        if(tab_com[ligne]!="")
        {
            var ligne_com = tab_com[ligne].split(';');
            document.getElementById("det_com").innerHTML += "<div class='bord'></div>";
            document.getElementById("det_com").innerHTML += "<div class='suite'>" + ligne_com[0] + "</div>";
            document.getElementById("det_com").innerHTML += "<div class='des'>" + ligne_com[3] + "</div>";
            document.getElementById("det_com").innerHTML += "<div class='suite'>" + ligne_com[1] + "</div>";
            document.getElementById("det_com").innerHTML += "<div class='unite'>" + ligne_com[2] + "</div>";         
            document.getElementById("det_com").innerHTML += "<div class='prix'>" + ligne_com[4] + "</div>";
            document.getElementById("det_com").innerHTML += "<div class='prix'>" + (ligne_com[1]*ligne_com[4]).toFixed(2) + "</div>";
            document.getElementById("det_com").innerHTML += "<div class='bord'><button class='btn btn-danger' value='X' style='height:20px;font-size:12px;' onclick='suppr(\"" + tab_com[ligne] + "\");'><i class='far fa-trash-alt'></i></button></div>";
        }
    }
}
function suppr(ligne_s)
{
    chaine_com.value = chaine_com.value.replace('|' + ligne_s, '');
    var tab_detail = ligne_s.split(';');
    total_commande.value = (total_commande.value -tab_detail[1]*tab_detail[4]).toFixed(2);
    total_com.value = total_commande.value;
    tot_com = total_com.value*1;
    facture();
}
/*Fin traitement facturation*/

/*Debut traitement tableau de bord*/
function showGraph()
{  
    switch(document.getElementById('param').value)
    {
        case 'tous':
            {
        $.get("chargementgraphiquevente.php",
            {'param':document.getElementById('param').value},
        function (data)
        {
         
            console.log(data);

            var designation = [];
            var qte = [];
            var couleur = [];

            var dynamicColors = function (){
                var r = Math.floor(Math.random()*255);
                var g = Math.floor(Math.random()*255);
                var b = Math.floor(Math.random()*255);
                return "rgb("+r+","+g+","+b+")";
            };
            
            for (var i in data) {
                designation.push(data[i].Article_designation);
                qte.push(data[i].Detail_qte);
                couleur.push(dynamicColors());
            }

            var chartdata = {
                labels: designation,
                datasets: [
                    {
                        label: 'Quantité vendue',
                        backgroundColor: couleur,
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#white',
                        data: qte 
                    }
                ]
            };

            var graphTarget = $("#graphCanvas");

            var barGraph = new Chart(graphTarget, {                       
                //type de graphiques: bar, line, pie,spline
                type: 'bar',
                data: chartdata,

                options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                yAxes: [{
                    ticks: {
                    beginAtZero: true,
                    }
                }]
                },
                plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: Math.round,
                    font: {
                    weight: 'bold'
                    }
                }
                }
            }
                
            });
        });
    }
        break;

        case 'pardate':
            {
        $.get("chargementgraphiquevente.php",
        {'pdate':document.getElementById('pdate').value,'param':document.getElementById('param').value},
        function (data)
        {
         
            console.log(data);

            var designation = [];
            var qte = [];
            var couleur = [];

            var dynamicColors = function (){
                var r = Math.floor(Math.random()*255);
                var g = Math.floor(Math.random()*255);
                var b = Math.floor(Math.random()*255);
                return "rgb("+r+","+g+","+b+")";
            };
            
            for (var i in data) {
                designation.push(data[i].Article_designation);
                qte.push(data[i].Detail_qte);
                couleur.push(dynamicColors());
            }

            var chartdata = {
                labels: designation,
                datasets: [
                    {
                        label: 'Quantité vendue',
                        backgroundColor: couleur,
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#white',
                        data: qte 
                    }
                ]
            };

            var graphTarget = $("#graphCanvas");

            var barGraph = new Chart(graphTarget, {                       
                //type de graphiques: bar, line, pie,spline
                type: 'bar',
                data: chartdata,

                options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                yAxes: [{
                    ticks: {
                    beginAtZero: true,
                    }
                }]
                },
                plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: Math.round,
                    font: {
                    weight: 'bold'
                    }
                }
                }
            }
                
            });
        });
    }
        break;

        case 'datedebut':
            {
        $.get("chargementgraphiquevente.php",
        {'datedebut':document.getElementById('datedebut').value,'param':document.getElementById('param').value
        ,'datefin':document.getElementById('datefin').value},
        function (data)
        {
         
            console.log(data);

            var designation = [];
            var qte = [];
            var couleur = [];

            var dynamicColors = function (){
                var r = Math.floor(Math.random()*255);
                var g = Math.floor(Math.random()*255);
                var b = Math.floor(Math.random()*255);
                return "rgb("+r+","+g+","+b+")";
            };
            
            for (var i in data) {
                designation.push(data[i].Article_designation);
                qte.push(data[i].Detail_qte);
                couleur.push(dynamicColors());
            }

            var chartdata = {
                labels: designation,
                datasets: [
                    {
                        label: 'Quantité vendue',
                        backgroundColor: couleur,
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#white',
                        data: qte 
                    }
                ]
            };

            var graphTarget = $("#graphCanvas");

            var barGraph = new Chart(graphTarget, {                       
                //type de graphiques: bar, line, pie,spline
                type: 'bar',
                data: chartdata,

                options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                yAxes: [{
                    ticks: {
                    beginAtZero: true,
                    }
                }]
                },
                plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: Math.round,
                    font: {
                    weight: 'bold'
                    }
                }
                }
            }
                
            });
        });
    }
        break;

        case 'produitpardate':
            {
        $.get("chargementgraphiquevente.php",
        {'param':document.getElementById('param').value,
        'pdate':document.getElementById('pdate').value,
        'designation':document.getElementById('designation').value},
        function (data)
        {
         
            console.log(data);

            var designation = [];
            var qte = [];
            var couleur = [];

            var dynamicColors = function (){
                var r = Math.floor(Math.random()*255);
                var g = Math.floor(Math.random()*255);
                var b = Math.floor(Math.random()*255);
                return "rgb("+r+","+g+","+b+")";
            };
            
            for (var i in data) {
                designation.push(data[i].Article_designation);
                qte.push(data[i].Detail_qte);
                couleur.push(dynamicColors());
            }

            var chartdata = {
                labels: designation,
                datasets: [
                    {
                        label: 'Quantité vendue',
                        backgroundColor: couleur,
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#white',
                        data: qte 
                    }
                ]
            };

            var graphTarget = $("#graphCanvas");

            var barGraph = new Chart(graphTarget, {                       
                //type de graphiques: bar, line, pie,spline
                type: 'bar',
                data: chartdata,

                options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                yAxes: [{
                    ticks: {
                    beginAtZero: true,
                    }
                }]
                },
                plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: Math.round,
                    font: {
                    weight: 'bold'
                    }
                }
                }
            }
                
            });
        });
    }
        break;

        case 'parproduit':
            {
        $.get("chargementgraphiquevente.php",
        {'param':document.getElementById('param').value,'designation':document.getElementById('designation').value},
        function (data)
        {
         
            console.log(data);

            var designation = [];
            var qte = [];
            var couleur = [];

            var dynamicColors = function (){
                var r = Math.floor(Math.random()*255);
                var g = Math.floor(Math.random()*255);
                var b = Math.floor(Math.random()*255);
                return "rgb("+r+","+g+","+b+")";
            };
            
            for (var i in data) {
                designation.push(data[i].Article_designation);
                qte.push(data[i].Detail_qte);
                couleur.push(dynamicColors());
            }

            var chartdata = {
                labels: designation,
                datasets: [
                    {
                        label: 'Quantité vendue',
                        backgroundColor: couleur,
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#white',
                        data: qte 
                    }
                ]
            };

            var graphTarget = $("#graphCanvas");

            var barGraph = new Chart(graphTarget, {                       
                //type de graphiques: bar, line, pie,spline
                type: 'bar',
                data: chartdata,

                options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                yAxes: [{
                    ticks: {
                    beginAtZero: true,
                    }
                }]
                },
                plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: Math.round,
                    font: {
                    weight: 'bold'
                    }
                }
                }
            }
                
            });
        });
    }
        break;

        case'parclient':
            {
        $.get("chargementgraphiquevente.php",
        {'param':document.getElementById('param').value,
        'client':document.getElementById('designation').value},
        function (data)
        {
         
            console.log(data);

            var designation = [];
            var qte = [];
            var couleur = [];

            var dynamicColors = function (){
                var r = Math.floor(Math.random()*255);
                var g = Math.floor(Math.random()*255);
                var b = Math.floor(Math.random()*255);
                return "rgb("+r+","+g+","+b+")";
            };
            
            for (var i in data) {
                designation.push(data[i].Article_designation);
                qte.push(data[i].Detail_qte);
                couleur.push(dynamicColors());
            }

            var chartdata = {
                labels: designation,
                datasets: [
                    {
                        label: 'Quantité vendue',
                        backgroundColor: couleur,
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#white',
                        data: qte 
                    }
                ]
            };

            var graphTarget = $("#graphCanvas");

            var barGraph = new Chart(graphTarget, {                       
                //type de graphiques: bar, line, pie,spline
                type: 'bar',
                data: chartdata,

                options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                yAxes: [{
                    ticks: {
                    beginAtZero: true,
                    }
                }]
                },
                plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: Math.round,
                    font: {
                    weight: 'bold'
                    }
                }
                }
            }
                
            });
        });
    }
        break;
    }

   
}

$('#recherchevente').on('click', function(){

showGraph();
});



function produitetclient()
{        
if($('#produit').prop("checked"))
{
    document.getElementById('param').value='parproduit';               
}	
else if($('#parclient').prop("checked"))
{
    document.getElementById('param').value='parclient';                		
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

$("input[type=radio][name=recherchergraphiquevente]").change(function() {
switch ($(this).val())
{
case'tous':
    document.getElementById('pdate').disabled = true;                             
    document.getElementById('datedebut').disabled = true;            
    document.getElementById('datefin').disabled = true;   
    document.getElementById('designation').disabled = true;    
    document.getElementById('tous').checked = true;    
    document.getElementById('tous').value = 'tous'; 
break;

case'produit':
    document.getElementById('pdate').disabled = true;                             
    document.getElementById('datedebut').disabled = true;            
    document.getElementById('datefin').disabled = true;      
    document.getElementById('designation').disabled = false;  
    document.getElementById('designation').value = "";    
    document.getElementById('produit').checked = true;
break;

case'pardate':
    document.getElementById('pdate').disabled = false;                                
    document.getElementById('datedebut').disabled = true;            
    document.getElementById('datefin').disabled = true;           
    document.getElementById('designation').disabled = true; 
    document.getElementById('pardate').checked = true;  
break;

case'produitpardate':
    document.getElementById('pdate').disabled = false;                             
    document.getElementById('datedebut').disabled = true;            
    document.getElementById('datefin').disabled = true;      
    document.getElementById('designation').disabled = false; 
    document.getElementById('designation').value = "";  
    document.getElementById('produitpardate').checked = true; 
break;

case'parperiode':
    document.getElementById('pdate').disabled = true;                             
    document.getElementById('datedebut').disabled = false;            
    document.getElementById('datefin').disabled = false;   
    document.getElementById('designation').disabled = true;  
    document.getElementById('parperiode').checked = true; 
break;

case'parclient':
    document.getElementById('pdate').disabled = true;                             
    document.getElementById('datedebut').disabled = true;            
    document.getElementById('datefin').disabled = true;      
    document.getElementById('designation').disabled = false;  
    document.getElementById('designation').value = "";    
    document.getElementById('parclient').checked = true; 
break;

}

});

function desactivertoutegraphique()
{   
document.getElementById('pdate').disabled = true;                             
document.getElementById('datedebut').disabled = true;            
document.getElementById('datefin').disabled = true;   
document.getElementById('designation').disabled = true;    
document.getElementById('tous').checked = true;    
document.getElementById('tous').value = 'tous';  
}        

/*Fin traitement facturation*/

/*Debut traitement unité*/

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
                                    var ulrModification = "editerunites.php?idp="+idunite;                             
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
                                    var ulrModification = "editerunites.php?idp="+idunite;                             
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
                            $('#nouvellibel').val('');                          
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
                    'libelleedit':document.getElementById('editlibel').value,                   
                    'idunite':document.getElementById('idunite').value},
                    datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                    success: function (data) {
                        swal("Unité bien modifiée");                                              
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

/*Fin traitement unite */

/* Debut traitement entreprise*/
function chargemententreprises() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
                $('#loadingState').show();
                var url = 'chargeentreprise.php';
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
                type: 'POST',
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
                var myForm = document.getElementById('entrepriseform');
                var formData = new FormData(myForm);
                var url = 'chargeentreprise.php';
                $.ajax({
                        type: 'POST',
                        url: url,
                        data:formData,                      
                        contentType: false,
                        processData: false,
                        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                        success: function (data) {                                                                    
                            swal("Entreprise bien enregistrée");                        
                            $('#editnomentreprise').val('');
                            $('#logo').val('');
                            $('#editemailentre').val('');
                            $('#edittelephone').val('');
                            $('#editreseausocio').val('');
                            $('#editadresseentreprise').val('');
                            $('#editidentitenationale').val('');
                        },
                        error: function (data) {
                            alert("Erreur enregistrement entreprise");
                        }
                    });
            break;

             case 'modifier': 
            var editentrepr = document.getElementById('editformentre');
            var formDataentre = new FormData(editentrepr);
            var url = 'chargeentreprise.php';
            $.ajax({
                    type: 'POST',
                    url: url,
                    data:formDataentre,
                    contentType: false,
                    processData: false,
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
                    type: 'POST',
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
                        $("#img").attr("src",'../images/'+donnee.logo);                           
                        }                                                                                             
                    });
            break;
        }              
    }
/*Fin traitement entreprise */

function chargepageaccueil()
{
    switch(document.getElementById('param').value)
        {
        case 'tous':
        var url = 'chargeaccueil.php';
        $.ajax({
            type: 'GET',
            url: url,
            data:{'param':document.getElementById('param').value},
            datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
            success: function (data) {  
                var donnee = jQuery.parseJSON(data);  
                //$('#entreprisenam').val(donnee.libelleentreprise); 
                document.getElementById('entreprisenam').innerText = donnee.libelleentreprise; 
               $('.entrep').arctext({radius: 300}); 
               $(".entrep").fitText(1.6);                                                                          
                $("#imge").attr("src",'../images/'+donnee.logo);                             
            },
            error: function (data) {
                swal("Erreur chargement champ modification");
            }
        });
        break;
     }
}