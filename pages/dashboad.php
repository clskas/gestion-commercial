<?php
    
    require_once('identifier.php');
    require_once('connexiondb.php');

?>

<! DOCTYPE HTML>
<html>
    <head>
        <title>Tableau de bord</title>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">  
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">  
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
        <link rel="stylesheet" type="text/css"  href="../css/font-awesome.min.css">
        <script src="../js/jquery-3.5.1.min.js"></script>              
        <script src="../js/facturationstock.js"></script>
        <script src="../js/sweetalert.min.js"></script>
        <script src="../js/bootstrap.min.js"></script> 
        <script src="../js/Chart.min.js"></script>
        <script src="../js/chartjs-plugin-datalabels.js"></script>  
        <script src="../js/pagination/jquery.twbsPagination.min.js"></script> 
    </head>
    <body onload="desactivertoutegraphique();document.getElementById('param').value='tous';etatcaise();graphiqueetatstock();showGraph();">
        <?php include("menu.php"); ?>
        <div class="container">          
            <form  method="GET" class="form-inline">
                <div class="flex-container">
                    <!--<div style="flex-grow: 1">1</div>
                    <div style="flex-grow: 10">
                        <h1>Dépenses</h1>
                    </div>-->
                    <div style="flex-grow: 8"> 
                        <h1>Etat de la caisse</h1>  
                        <label id="dispo"><strong>Montant disponible dans la caisse</strong></label>                     
                        <div class="form-group largeur100">                       
                            <div class="form-group">
                                <strong>Montant disponible en FC :</strong> <label id="etatcaissefranc"></label>
                            </div> 
                            <div class="form-group"> 
                                <strong>Montant disponible en $ :</strong> <label id="etatcaissedollar"></label>
                            </div>
                        </div>
                        <label id="dette"><strong>Dette</strong></label>
                        <div class="form-group largeur100">                      
                            <div class="form-group">
                                <strong>Dette en FC:</strong> <label id="detteenfc"></label>                            
                            </div>
                            <div class="form-group"> 
                                <strong>Dette en $:</strong> <label id="detteendollar"></label>
                            </div>
                        </div>
                    </div>
                    <div style="flex-grow: 8">
                        <h1>ETAT DE VENTE</h1>
                        <div class="form-group largeur100" >
                                        
                            <input type="radio" id="tous" name="recherchergraphiquevente" 
                                onclick="document.getElementById('param').value='tous';desactivertoutegraphique();" value="tous"/>
                            <label for="tous">Toutes les ventes</label>
                            &nbsp  &nbsp <!--Pour espacement-->                                                     
                            <input type="radio" id="produit" name="recherchergraphiquevente" 
                            value="produit"> 
                            <label for="produit">Par produit </label>
                            &nbsp  &nbsp <!--Pour espacement--> 
                            <input type="radio" id="pardate" name="recherchergraphiquevente"  
                            value="pardate"> 
                            <label for="pardate">Par date</label>
                            &nbsp  &nbsp <!--Pour espacement--> 
                            <input type="radio" id="produitpardate" name="recherchergraphiquevente"  
                            value="produitpardate"> 
                            <label for="produitpardate">Produit par date</label>
                            &nbsp  &nbsp <!--Pour espacement-->                                        
                            <input type="radio" id="parperiode" name="recherchergraphiquevente" 
                            value="parperiode"> 
                            <label for="parperiode">Par periode</label>  
                            &nbsp  &nbsp <!--Pour espacement--> 
                            <input type="radio" id="parclient" name="recherchergraphiquevente" 
                            value="parclient"> 
                            <label for="parclient">Par client</label>  
                            
                            <input type="text" id="param" name="param" style="visibility:hidden;" />                        
                        </div> 
                        <div class="form-group">
                            <div class="form-group">
                            <input type="text" name="designation" id="designation" 
                                class="form-control" onblur="produitetclient();"/>
                            </div>

                            <div class="form-group"  >
                                <label>Date</label>
                                <input type="date" name="pdate" id="pdate" onblur="produitetdate();"/>
                            </div>

                            <div class="form-group" >
                                <label>Date Début</label>
                                <input type="date" name="datedebut" id="datedebut" onblur="document.getElementById('param').value='datedebut'"/>
                                <label>Date Fin</label>
                                <input type="date" name="datefin" id="datefin" />
                            </div>
                            
                            <div style="width:25%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                                <button type="button" class="btn btn-success" id="recherchevente" name="recherche" value="Rechercher" style="margin-top:10px;" >
                                    <span class="glyphicon glyphicon-search"></span> Rechercher...
                                </button>               
                            </div> 
                        </div>       

                        <div id="chart-container">
                            <canvas id="graphCanvas"></canvas>
                        </div>
                                    
                    </div>
                    <div style="flex-grow: 10">
                        <h1>Graphique sur l'état de stock</h1>
                        <div id="chart-containeretatstock">                       
                            <canvas id="etatstock"></canvas>
                        </div>
                    </div>
            </form>           
        </div>
    </body>
</html>


<script>


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

        case'etat_caisse':
            var url = 'chargementpaie.php';                  
            $.ajax({
                type: 'GET',   
                url: url,
                data:{'param':document.getElementById('param').value},
                datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
                success: function (data) {
                    var donnee = jQuery.parseJSON(data); 

                    if(donnee.sommefranc)
                    {
                    document.getElementById('montantdepense').innerText =  montantdisponibleenfcongolais+' '+'FC';
                    }
                    else
                    {
                    document.getElementById('montantdepense').innerText =  '0'+' '+'FC';
                    }

                    if(donnee.sommedollar)
                    {
                    document.getElementById('montantdepenseendollar').innerText =  montantdispoendolar+' '+'$';
                    }
                    else
                    {
                    document.getElementById('montantdepenseendollar').innerText =   '0'+' '+'$';
                    }
                    
                },
                error: function (data) {
                    
                }
                });
        break;
    }   
}

$('#recherchevente').on('click', function(){

showGraph();
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


function etatcaise()
{  
    var url = 'chargeetatcaisse.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: {},
        datatype :'JSON',// Le type de données à recevoir, ici, du JSON.
        success: function (data) {   
            var donnee = jQuery.parseJSON(data);
             
            var resteenfc = parseFloat(donnee.detteenfc);
            var resteenfcongolais = resteenfc.toFixed(4);

            var resteendollar = parseFloat(donnee.detteendollar);
            var resteendolar = resteendollar.toFixed(4);

            var montantdisponibleenfc = parseFloat(donnee.montatdispoenfranc);
            var montantdisponibleenfcongolais = montantdisponibleenfc.toFixed(4);

            var montantdisponibleendollar = parseFloat(donnee.montantdispoendollar);
            var montantdispoendolar = montantdisponibleendollar.toFixed(4);

            if(donnee.montatdispoenfranc) 
            {
                document.getElementById('etatcaissefranc').innerText =  montantdisponibleenfcongolais+' '+'FC';
                document.getElementById('detteenfc').innerText =  resteenfcongolais+' '+'FC';
            }
            else
            {
                document.getElementById('etatcaissefranc').innerText =  '0'+' '+'FC';
                document.getElementById('detteenfc').innerText =  '0'+' '+'FC';
            }

            if(donnee.montantdispoendollar)
            {
                document.getElementById('etatcaissedollar').innerText =  montantdispoendolar+' '+'$';
                document.getElementById('detteendollar').innerText =  resteendolar+' '+'$';
            }
            else
            {
                document.getElementById('etatcaissedollar').innerText =   '0'+' '+'$';
                document.getElementById('detteendollar').innerText =   '0'+' '+'$';

            }
            
        },
        error: function (data) {
            
        }
    }); 
}


    function graphiqueetatstock()
        {
            {
                $.get("chargementgraphiquestock.php",
                function (data)
                {
                  
                    console.log(data);

                     var designation = [];
                    var quantiteenstock = [];
                    var couleur = [];

                    var dynamicColors = function (){
                        var r = Math.floor(Math.random()*255);
                        var g = Math.floor(Math.random()*255);
                        var b = Math.floor(Math.random()*255);
                        return "rgb("+r+","+g+","+b+")";
                    };
                    
                    for (var i in data) {
                        designation.push(data[i].Article_designation);
                        quantiteenstock.push(data[i].Article_Qte);
                        couleur.push(dynamicColors());
                    }

                    var chartdata = {
                        labels: designation,
                        datasets: [
                            {
                                label: 'Quantité disponible en stock',
                                backgroundColor: couleur,
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#white',
                                data: quantiteenstock 
                            }
                        ]
                    };

                    var graphTarget = $("#etatstock");

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
        }
</script>