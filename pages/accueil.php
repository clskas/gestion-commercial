<! DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Accueil</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">       
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
        <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../css/fontawesome.min.css">
        <script src="../js/jquery-3.5.1.min.js"></script> 
        <script src="../js/jquery.arctext.js"></script> 
        <script src="../js/jquery.fittext.js"></script>  
        <script src="../js/facturationstock.js"></script>
        <script src="../js/sweetalert.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/pagination/jquery.twbsPagination.min.js"></script>
        <script src="../js/anijs-min.js"></script> 
        <link rel="stylesheet" href="http://anijs.github.io/lib/anicollection/anicollection.css">
        <script src="https://anijs.github.io/lib/anijs/helpers/dom/anijs-helper-dom-min.js"></script>
    </head>
    <body class="accuei" onload="document.getElementById('param').value='tous';chargepageaccueil();">
        <?php include("menu.php"); ?>
        <div class="container">
            <div class="panel panel-success margetop">
                <div class="panel-heading">
                    
                </div>
                <div class="panel-body">                  
                    <div class='preview' id="idaccueil">
                        <div class="largeur100">
                            <input type="text" id="param" name="param" style="visibility:hidden;" /> 
                            <label id="entreprisenam" class="largeur100 entrep"> </label>                                      
                        </div>
                        <div >
                            <img id="imge" width="200px" height="200px">
                        </div> 
                                       
                    </div>
                    
                </div>
            </div>
        </div>
    </body>
</html>