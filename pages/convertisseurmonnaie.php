<?php
	require_once('identifier.php');  
	$taux= isset($_POST['taux'])?$_POST['taux']:0;
	$montant= isset($_POST['montant'])?$_POST['montant']:0;
	$output = 0;
	$symbole="";
	if(isset($_POST['rechercher']) && $_POST['rechercher']=='fc')
	{
		if(isset($_POST['sbmt']))
		{		
			if(isset($_POST['taux']) && !empty($_POST['taux']) && isset($_POST['montant']) && !empty($_POST['montant']))
			{
				//Conversion de Franc Congolais en dollars 
				//global $output;
				$output = $montant/$taux;
				//global $symbole;
				$symbole="$";									
			}		
		}	
	}
	else if(isset($_POST['rechercher']) && $_POST['rechercher']=='usd')
	{
		if(isset($_POST['sbmt']))
		{		
			if(isset($_POST['taux']) && !empty($_POST['taux']) && isset($_POST['montant']) && !empty($_POST['montant']))
			{
				//Conversion de Franc Congolais en dollars 
				//global $output ;
			    $output = $montant*$taux;
				//global $symbole;
				$symbole="FC";									
			}		
		}	
	}
		
?>

<! DOCTYPE HTML>
<HTML>
   <head>
    <title>Convertisseur de monnaie</title>
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
    <body>
	<?php include("menu.php"); ?>
        <div class="container col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
            <div class="panel panel-primary margetop">
                <div class="panel-heading">
                   <h1>Convertisseur de monnaie</h1> 
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->
				   &nbsp  &nbsp <!--Pour espacement-->				   
                </div>
                <div class="panel-body">
                    <form action="convertisseurmonnaie.php" method="post" class="form-inline">
					    <div class="form-group largeur100">
							<input type="radio" id="dallors" name="rechercher" value="usd"> 
							<label for="dallors">Dollars en Fc</label>
							&nbsp  &nbsp <!--Pour espacement-->
							&nbsp  &nbsp <!--Pour espacement-->
							&nbsp  &nbsp <!--Pour espacement-->										
							<input type="radio" id="franc" name="rechercher"  value="fc" checked/> 
							<label for="franc">Franc congolais en dollars</label>    
                        </div>
					
                        <div class="form-group largeur100">
                            <label for="taux">Taux</label>
							&nbsp  &nbsp <!--Pour espacement-->
							&nbsp  &nbsp <!--Pour espacement-->
							&nbsp  &nbsp <!--Pour espacement-->	
							&nbsp  &nbsp <!--Pour espacement-->
							&nbsp  &nbsp <!--Pour espacement-->
							&nbsp  &nbsp <!--Pour espacement-->	
							&nbsp  &nbsp <!--Pour espacement-->
                            <input type="text" name="taux" id="taux" placeholder="Taux" class="form-control"/>
                        </div>
                        <div class="form-group largeur100">
                            <label for="montant">Montant à convertir</label>
							&nbsp  &nbsp <!--Pour espacement-->
                            <input type="text" name="montant" id="montant" placeholder="Montant à convertir" class="form-control"/>
                        </div>  
						<div class="form-group largeur100"> 
							<label for="montant">Montant converti</label> 
							&nbsp  &nbsp <!--Pour espacement-->	
							&nbsp  &nbsp <!--Pour espacement-->						                    
                            <input type="text" name="montantconverti" id="montantconverti" class="form-control" value="<?php echo $output." ".$symbole; ?>"/>
                        </div> 
                        <button type="submit" class="btn btn-success margetop20" name="sbmt" id="sbmt">
                             Convertir
                        </button>    
						
                    </form>

                </div>    
            </div>
            </div>
    </body>
</HTML>