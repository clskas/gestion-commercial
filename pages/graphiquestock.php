<!DOCTYPE >
<html>
<head>
<title>Graphique sur l'etat de stock</title>
<style type="text/css">
BODY {
    width: 1200PX;
}

#chart-container {
    width: 100%;
    height: auto;
    margin-top:50px;
    margin-left:50px;
}
h1
{
    margin-left:50px;
}
</style>

<meta charset="utf-8">
    <title>Gestion des entrées en stock</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">       
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/fontawesome.min.css">
    <script src="../js/jquery-3.5.1.min.js"></script>              
    <script src="../js/facturationstock.js"></script>
    <script src="../js/sweetalert.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Chart.min.js"></script>
    <script src="../js/chartjs-plugin-datalabels.js"></script>
    <script src="../js/pagination/jquery.twbsPagination.min.js"></script>   
</head>
<body onload="showGraph();">
<h1>Graphique sur l'état de stock</h1>
    <div id="chart-container">
    
        <canvas id="graphCanvas"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
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
                                label: 'Quantité en stock',
                                backgroundColor: couleur,
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#white',
                                data: quantiteenstock 
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
        }
        </script>

</body>
</html>