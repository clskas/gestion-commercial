<?php
$idunite=isset($_GET['idunit'])?$_GET['idunit']:0;

?>

<! DOCTYPE HTML>
<html>
<head>
    <title>Edition unités</title>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">             
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
<body onload="document.getElementById('param').value='chargerchampmodifier';chargementunitemesure();">
<?php include("menu.php"); ?>

<div class="container">
    <div class="panel panel-primary margetop">
        <div class="panel-heading bg-primary">
            Edition unités :
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline">
                <div class="form-group">
                    <input type="hidden" name="idunite" id="idunite" class="form-control" value="<?php echo $idunite ?>"/>
                    <input type="text" id="param" name="param" style="visibility:hidden;" />
                </div>

                <div class="form-group largeur100">
                    <label for="editlibel">Libellé</label>
                    <input type="text" name="editlibel" id="editlibel" class="form-control"/>
                </div>

                <div class="form-group">
                    <input type="button" id="modifier" name="modifier" value="Modifier" style="margin-top:10px;" onclick="document.getElementById('param').value='modifier';chargementunitemesure();"/>
                </div>

            </form>
        </div>
    </div>

</div>
</body>
</html>
