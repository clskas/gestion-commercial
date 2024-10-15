
function surligne(champ, erreur)
{
    if(erreur)
        champ.style.backgroundColor = "#c0392b";

    else
        champ.style.backgroundColor = "";
}

function verifMail(champ)
    {
        var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
        if(!regex.test(champ.value))
        {
            surligne(champ, true);
            alert("Veuillez saisir correctement votre adresse mail qui doit contenir le symbole @");
            return false;
        }
        else
        {
            surligne(champ, false);
            return true;
        }
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

$('#pardateradio').click(function(){
    $('#pardate').show();
});


 /*La fonction se compose de deux paramètres
     *Le premier indique l'id du bouton dans lequel on affichera "Désactiver le bouton" ou "Réactiver le bouton".
     *Le seconde inqique l'id du bouton duquel on va changer le statut */
      
    function GestionBouton(IdLien, IdBouton){
        //On récupère le statut actuel du bouton
        //(true = desactivé, false = activé)
        StatutBouton = document.getElementById(IdBouton).disabled;
         
        //Si le bouton est désactivé ...
        if(StatutBouton == true){
            //... on le réactive
            document.getElementById(IdBouton).disabled = false;
             
            //Et on change le texte du bouton qui permet d'activer la fonction présente
            document.getElementById(IdLien).value = 'Désactiver le bouton';
        }
         
        //... Sinon
        else{
            //On désactive le bouton
            document.getElementById(IdBouton).disabled = true;
             
            //Et on change le texte du bouton qui permet d'activer la fonction présente
            document.getElementById(IdLien).value = 'Réactiver le bouton';
        }
        //Fin de la condition
     
    //Fin de la fonction
    }

function activerdatefactu()
{                               
    document.getElementById('datep').disabled = false;                                               
    document.getElementById('numerofacture').disabled = true; 
     document.getElementById('pardate').checked = true;      
}
    
function activerfournisseur(){  
                             
    document.getElementById('pdate').disabled = true;                             
    document.getElementById('datedebut').disabled = true;            
    document.getElementById('datefin').disabled = true;      
    document.getElementById('produits').disabled = false;  
    document.getElementById('produits').value = "";    
    document.getElementById('parfournisseur').checked = true; 
    }

    function activernumerofactu(){  
                             
        document.getElementById('datep').disabled = true;                                          
        document.getElementById('numerofacture').disabled = false;             
        document.getElementById('numerofac').checked = true; 
    }

    function activermotif(){  
                             
        document.getElementById('pdate').disabled = true; 
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;                                        
        document.getElementById('motif').disabled = false;             
        document.getElementById('motiff').checked = true; 
    }

    function activerproduitpardate(){  
                             
        document.getElementById('pdate').disabled = false;                             
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;      
        document.getElementById('designation').disabled = false; 
        document.getElementById('designation').value = "";  
        document.getElementById('produitpardate').checked = true;       
    }

   
    
    function activerclient(){                         
        document.getElementById('pdate').disabled = true;                             
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;   
        document.getElementById('designation').disabled = false;  
        document.getElementById('client').checked = true; 

    }

   
    
    function desactivertoutefactu(){   
        document.getElementById('datep').disabled = true;                                      
        document.getElementById('numerofacture').disabled = true;    
        document.getElementById('tous').checked = true;           
    }

    function desactivertoutedepense(){   
        document.getElementById('pdate').disabled = true;                             
        document.getElementById('datedebut').disabled = true;            
        document.getElementById('datefin').disabled = true;   
        document.getElementById('motif').disabled = true;    
        document.getElementById('tous').checked = true;    
        document.getElementById('tous').value = 'tous';           
    }
    
function recolterappro()
{
    document.getElementById("historiqueappro").request({
        onComplete:function(transport){
            if(document.getElementById('param').value='tous')
            {
                
                    var tab_info = transport.responseText.split('|');
                   document.getElementById('designation').value = tab_info[1];
                   /* while(tab_info.length > 0){
                        document.getElementById('numfactur').value = tab_info[6];
                        document.getElementById('fourn').value = tab_info[3];
                        document.getElementById('designatio').value = tab_info[5];
                        document.getElementById('qtiteentre').value = tab_info[7];
                        document.getElementById('dateent').value = tab_info[9];
                        document.getElementById('prixu').value= tab_info[8];
                        document.getElementById('observa').value= tab_info[10];
                       
                    }*/
             }     
             else if(document.getElementById('produit').value='produit')      
             {
                
                    var tab_info = transport.responseText.split('|');
                    while(tab_info){
                        document.getElementById('numfactur').value = tab_info[6];
                        document.getElementById('fourn').value = tab_info[3];
                        document.getElementById('designatio').value = tab_info[5];
                        document.getElementById('qtiteentre').value = tab_info[7];
                        document.getElementById('dateent').value = tab_info[9];
                        document.getElementById('prixu').value= tab_info[8];
                        document.getElementById('observa').value= tab_info[10];
                       
                    }
                                      
             }
             else if(document.getElementById('pardate').value='pardate') 
             {
                var reponse = transport.responseText;
                while(tab_info){
                    document.getElementById('numfactur').value = tab_info[6];
                    document.getElementById('fourn').value = tab_info[3];
                    document.getElementById('designatio').value = tab_info[5];
                    document.getElementById('qtiteentre').value = tab_info[7];
                    document.getElementById('dateent').value = tab_info[9];
                    document.getElementById('prixu').value= tab_info[8];
                    document.getElementById('observa').value= tab_info[10];
                   
                }
             } 
             else if(document.getElementById('parperiode').value='parperiode') 
             {
                var reponse = transport.responseText;
                while(tab_info){
                    document.getElementById('numfactur').value = tab_info[6];
                    document.getElementById('fourn').value = tab_info[3];
                    document.getElementById('designatio').value = tab_info[5];
                    document.getElementById('qtiteentre').value = tab_info[7];
                    document.getElementById('dateent').value = tab_info[9];
                    document.getElementById('prixu').value= tab_info[8];
                    document.getElementById('observa').value= tab_info[10];
                   
                }
             }   
                    
         }
       
    });
}



function recolter()
{
    document.getElementById("formulaire").request({
        onComplete:function(transport){
            switch(document.getElementById('param').value)
            {
                case 'recup_client':
                    var tab_info = transport.responseText.split('|');
                    document.getElementById('civilite').value = tab_info[0];
                    document.getElementById('nom_client').value = tab_info[1];
                    document.getElementById('prenom_client').value = tab_info[2];
                    break;

                case 'recup_article':
                    var tab_info = transport.responseText.split('|');
                    document.getElementById('designation').value = tab_info[0];
                    document.getElementById('qte').value = tab_info[1];
                    document.getElementById('qte_commande').value="";
                    document.getElementById('puht').value="";
                    break;

                case 'facturer':
                    var reponse = transport.responseText;
                    if(transport.responseText=="nok")
                        alert("Une erreur est survenue");
                    else
                    {
                        alert("La facture a été enregistrée avec succes");
                        document.getElementById('civilite').value="";
                        document.getElementById('nom_client').value="";
                        document.getElementById('prenom_client').value="";
                        document.getElementById('designation').value="";
                        document.getElementById('total_commande').value="";
                        document.getElementById('qte').value="";
                        document.getElementById('qte_commande').value="";
                        document.getElementById('puht').value="";

                        document.getElementById("editer").innerHTML = "<input type='button' value='Imprimer la facture' onclick='window.open(\"edition.php?info=" + reponse + "\")' />";
                    }
                    break;

            }
        }
    });
}


var tot_com = 0;

function plus_com()
{
    if(civilite.value != "" && designation.value != "" && ref_client.value != 0 && ref_produit.value != 0 && qte_commande.value != "0" && qte_commande.value != "" && puht.value != "0" && puht.value != "")
    {
        if(parseInt(qte_commande.value) > parseInt(qte.value))
            alert("La quantité en stock n'est pas suffisante pour honorer la commande");
        else
        {
            var ref_p = ref_produit.value;
            var qte_p = qte_commande.value;
            var des_p = designation.value;
            var pht_p = puht.value;

            tot_com = tot_com + qte_p*pht_p;
            total_commande.value = tot_com.toFixed(2);
            total_com.value = total_commande.value;
            chaine_com.value += "|" + ref_p + ";" + qte_p + ";" + des_p + ";" + pht_p;
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
            document.getElementById("det_com").innerHTML += "<div class='suite'>" + ligne_com[1] + "</div>";
            document.getElementById("det_com").innerHTML += "<div class='des'>" + ligne_com[2] + "</div>";
            document.getElementById("det_com").innerHTML += "<div class='prix'>" + ligne_com[3] + "</div>";
            document.getElementById("det_com").innerHTML += "<div class='prix'>" + (ligne_com[1]*ligne_com[3]).toFixed(2) + "</div>";
            document.getElementById("det_com").innerHTML += "<div class='bord'><input type='button' value='X' title='Supprimer le produit' style='height:20px;font-size:12px;' onclick='suppr(\"" + tab_com[ligne] + "\");' /></div>";
        }
    }
}

function suppr(ligne_s)
{
    chaine_com.value = chaine_com.value.replace('|' + ligne_s, '');
    var tab_detail = ligne_s.split(';');

    total_commande.value = (total_commande.value -tab_detail[1]*tab_detail[3]).toFixed(2);
    total_com.value = total_commande.value;
    tot_com = total_com.value*1;

    facture();
}

function recolterfacture()
{
    document.getElementById("forme").request({
        onComplete:function(transport) {
            switch(document.getElementById('param').value)
            {
                case 'inserer':
                    if(transport.responseText=="nok")
                        alert("Une erreur est survenue");
                    else
                    {
                        alert("Paiement enregistré");
                    }
                    break;
            case 'recup_commande':
            var tab_info = transport.responseText.split('|');
            document.getElementById('montant_apaye').value = tab_info[3];
                break;
            }

        } });
}

function modifierpaie()
{
    document.getElementById("editerpaie").request({
        onComplete:function(transport) {
            switch(document.getElementById('param').value)
            {
                case 'recup_commande':
                    var tab_info = transport.responseText.split('|');
                    document.getElementById('montant_apaye').value = tab_info[3];
                    break;

                case 'modifier':
                    if(transport.responseText=="nok")
                        alert("Une erreur est survenue");
                    else
                    {
                        alert("Paiement modifié");
                    }
                    break;
            }

        } });
}

function insererfournisseur()
{
    document.getElementById("fournisseur").request({
        onComplete:function(transport) {
            switch(document.getElementById('param').value)
            {
                case 'inserer':
                    if(transport.responseText=="ok")
                    {
                        alert("Fournisseur enregistré");
                        document.getElementById('civilite').value="Monsieur";
                        document.getElementById('nom').value="";
                        document.getElementById('prenom').value="";
                        document.getElementById('telephone').value="";
                        document.getElementById('email').value="";
                        document.getElementById('reseausocial').value="";
                        document.getElementById('adresse').value="";
                    }

                    else
                    {
                        alert("Erreur enregistrement fournisseur");
                    }
                    break;
            }

        } });
}

function insererproduit()
{
    document.getElementById("newproduit").request({
        onComplete:function(transport) {
            switch(document.getElementById('param').value)
            {
                case 'inserer':
                    if(transport.responseText=="ok")
                    {
                        alert("Produit enregistré");
                        document.getElementById('designation').value="";
                        document.getElementById('qtemin').value="";
                        document.getElementById('tva').value="";
                        document.getElementById('marque').value="";
                    }
                    else
                    {
                        alert("Erreur enregistrement produit");
                    }
                    break;
            }

        } });
}

function insererdepense()
{
    document.getElementById("depense").request({
        onComplete:function(transport) {
            switch(document.getElementById('param').value)
            {
                case 'inserer':
                    if(transport.responseText=="ok")
                    {
                        alert("Dépense enregistrée");
                        document.getElementById('motif').value="";
                        document.getElementById('montant').value="";
                        
                    }
                    else
                    {
                        alert("Erreur enregistrement dépense");
                    }
                    break;
            }

        } });
}

function insererclient()
{
    document.getElementById("client").request({
        onComplete:function(transport) {
            switch(document.getElementById('param').value)
            {
                case 'inserer':
                    if(transport.responseText=="ok")
                    {
                        alert("Client enregistré");
                        document.getElementById('civilite').value="Monsieur";
                        document.getElementById('nom').value="";
                        document.getElementById('prenom').value="";
                        document.getElementById('telephone').value="";
                        document.getElementById('em²').value="";
                        document.getElementById('adresse').value="";
                    }
                    else
                    {
                        alert("Erreur enregistrement client");
                    }
                    break;
            }

        } });
}

function insererapprovisionnement()
{
    document.getElementById("approvisionnement").request({
        onComplete:function(transport) {
            switch(document.getElementById('param').value)
            {
                case 'inserer':
                    if(transport.responseText=="ok")
                    {
                        alert("Erreur enregistrement approvisionnement");
                    }
                    else
                    {
                        alert("Approvisionnement enregistré");
                        //document.getElementById('civilite').value="Monsieur";
                        document.getElementById('numerofacture').value="";
                        document.getElementById('quantiteentre').value="";
                        document.getElementById('puht').value="";
                        document.getElementById('observation').value="";
                        
                    }
                    break;
            }

        } });
}

function modifierfournisseur()
{
    document.getElementById("editerfournisseur").request({
        onComplete:function(transport) {
            switch(document.getElementById('param').value)
            {
                case 'modifier':
                    if(transport.responseText=="ok")
                    {
                        alert("Fournisseur modifié");
                    }

                    else
                    {
                        alert("Erreur modification fournisseur");
                    }
                    break;
            }

        } });
}

function modifierclient()
{
    document.getElementById("modifierclient").request({
        onComplete:function(transport) {
            switch(document.getElementById('param').value)
            {
                case 'modifier':
                    if(transport.responseText=="ok")
                        alert("Erreur modification client");
                    else
                        alert("Client modifié");
                    break;
            }

        } });
}

function modifierapprovisionnement()
{
    document.getElementById("modifierentre").request({
        onComplete:function(transport) {
            switch(document.getElementById('param').value)
            {
                case 'modifier':
                    if(transport.responseText=="ok")
                        alert("Erreur modification approvisionnement");
                    else
                        alert("Approvisionnement modifié");
                    break;
            }

        } });
}

function modifierproduit()
{
    document.getElementById("editerproduit").request({
        onComplete:function(transport) {
            if(document.getElementById('param').value=='modifier')
            {
                //case 'modifier':
                    if(transport.responseText=="ok")
                    {
                        alert("Erreur modification produit");
                    }
                    else
                    {
                        alert("Produit modifié");

                    }
                    //break;
            }

        } });
}

function modifierdepense()
{
    document.getElementById("editerdepense").request({
        onComplete:function(transport) {
            switch(document.getElementById('param').value)
            {
                case 'modifier':
                    if(transport.responseText=="ok")
                    {
                        alert("Erreur modification dépense");
                    }
                    else
                    {
                        alert("Depense modifiée");

                    }
                    break;
            }

        } });
}


function supprimerdepense()
{
    document.getElementById("depen").request({
        onComplete:function(transport) {                 
        switch(document.getElementById('param').value)
        {
            case 'supprimer':
                if(transport.responseText=="ok")
                {
                    alert("Dépense supprimée");
                }
                else
                {
                    alert("Erreur suppression dépense");

                }
                break;
        }

    } });
}


function supprimerfournisseur()
{
    document.getElementById("supprimerfournisseur").request({
        onComplete:function(transport) {

                    if(transport.responseText=="ok")
                    {
                        alert("Fournisseur supprimé");
                    }
                    else
                    {
                        alert("Erreur suppression fournisseur");
                    }

        } });
}

function sommedepense()
{
    document.getElementById("depen").request({
        onComplete:function(transport) {

            switch(document.getElementById('param').value)
            {
                case 'pardate':
                    var tab_info = transport.responseText;
                    // var longueurtableau = transport.responseText.length;
                    document.getElementById('montantdepense').innerHTML = tab_info;
                    break;
            }

        } });
}

 function chargementdepense() {
    switch(document.getElementById('param').value)
            {
                case 'tous':
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
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var depenses = donnee.depense
                   // $('#montantdepense').empty();
                    document.getElementById('montantdepense').innerText =  donnee.somme;
               
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
                                //onclick="return confirm('Etes-vous sûr de vouloir supprimer ce paiement ?')"
                                //Detail relatif aux depenses onclick="Conform_Delete()"
                                //'<a onclick="return confirm("'+messageSuppression+'");" class="ml-4" href="'+ulrSuppression+'"><span class="glyphicon glyphicon-trash"></span></a></td>' +                                      
                                
                                    $('#tbodydepense').empty();
                                    
                                for (var i = 0; i < displayRecords.length; i++) {
                                    
                                    var idDepense = displayRecords[i]['id_depense'];
                                    var ulrModification = "editerdepense.php?iddepense="+idDepense;
                                    var ulrSuppression = "supprimerdepense.php?iddepense="+idDepense;
                                    var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                    $("#tbodydepense").append('<tr>' +
                                        '<td>'+displayRecords[i]['motif']+'</td>' +
                                        '<td>'+displayRecords[i]['montant']+'</td>' +
                                        '<td>'+displayRecords[i]['date_depense']+'</td>' + 
                                        '<td>'+
                                            '<a href="'+ulrModification+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<a onclick="Conform_Delete()" href="'+ulrSuppression+'"><span class="glyphicon glyphicon-trash"></span></a></td>' +                                      
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
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var depenses = donnee.depense
                   // $('#montantdepense').empty();
                    document.getElementById('montantdepense').innerText =  donnee.somme;
               
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
                                var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                for (var i = 0; i < displayRecords.length; i++) {
                                   
                                    var idDepense = displayRecords[i]['id_depense'];
                                    var ulrModification = "editerdepense.php?iddepense="+idDepense;
                                    var ulrSuppression = "supprimerdepense.php?iddepense="+idDepense;

                                    $("#tbodydepense").append('<tr>' +
                                        '<td>'+displayRecords[i]['motif']+'</td>' +
                                        '<td>'+displayRecords[i]['montant']+'</td>' +
                                        '<td>'+displayRecords[i]['date_depense']+'</td>' + 
                                        '<td>'+
                                            '<a href="'+ulrModification+'" class="mr-4"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<a onclick="return confirm("'+messageSuppression+'");" class="ml-4" href="'+ulrSuppression+'"><span class="glyphicon glyphicon-trash"></span></a></td>' +                                      
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
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var depenses = donnee.depense
                   // $('#montantdepense').empty();
                    document.getElementById('montantdepense').innerText =  donnee.somme;
               
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
                                var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                for (var i = 0; i < displayRecords.length; i++) {
                                   
                                    var idDepense = displayRecords[i]['id_depense'];
                                    var ulrModification = "editerdepense.php?iddepense="+idDepense;
                                    var ulrSuppression = "supprimerdepense.php?iddepense="+idDepense;

                                    $("#tbodydepense").append('<tr>' +
                                        '<td>'+displayRecords[i]['motif']+'</td>' +
                                        '<td>'+displayRecords[i]['montant']+'</td>' +
                                        '<td>'+displayRecords[i]['date_depense']+'</td>' + 
                                        '<td>'+
                                            '<a href="'+ulrModification+'" class="mr-4"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<a onclick="return confirm("'+messageSuppression+'");" class="ml-4" href="'+ulrSuppression+'"><span class="glyphicon glyphicon-trash"></span></a></td>' +                                      
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
                        recPerPage = 5,
                        page = 1,
                        totalPages = 0;
    
                    var donnee = jQuery.parseJSON(data);
                   
                    var depenses = donnee.depense
                   // $('#montantdepense').empty();
                    document.getElementById('montantdepense').innerText =  donnee.somme;
               
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
                                var messageSuppression = "Etes-vous sûr de vouloir supprimer cette depense ?";
                                for (var i = 0; i < displayRecords.length; i++) {
                                   
                                    var idDepense = displayRecords[i]['id_depense'];
                                    var ulrModification = "editerdepense.php?iddepense="+idDepense;
                                    var ulrSuppression = "supprimerdepense.php?iddepense="+idDepense;

                                    $("#tbodydepense").append('<tr>' +
                                        '<td>'+displayRecords[i]['motif']+'</td>' +
                                        '<td>'+displayRecords[i]['montant']+'</td>' +
                                        '<td>'+displayRecords[i]['date_depense']+'</td>' + 
                                        '<td>'+
                                            '<a href="'+ulrModification+'" class="mr-4"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' +
                                            '<a onclick="return confirm("'+messageSuppression+'");" class="ml-4" href="'+ulrSuppression+'"><span class="glyphicon glyphicon-trash"></span></a></td>' +                                      
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
        }              
    }


     $('#recherche').on('click', function(){
        $('#tbodydepense').empty();
        chargementdepense();
        });



function Conform_Delete() 
{
    return confirm("Etes-vous sûr de vouloir supprimer cette depense?");
} 



