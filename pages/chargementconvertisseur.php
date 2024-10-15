<?php
	require_once('identifier.php');  
	$taux= isset($_POST['taux'])?$_POST['taux']:0;
    $montant= isset($_POST['montant'])?$_POST['montant']:0;
	if(isset($_POST['rechercher']) && $_POST['rechercher']=='fc')
	{
		if(isset($_POST['sbmt']))
		{		
			if(isset($_POST['taux']) && !empty($_POST['taux']) && isset($_POST['montant']) && !empty($_POST['montant']))
			{
				//Conversion de Franc Congolais en dollars 
                $montant =  isset($_POST['montant'])?$_POST['montant']:"";
                $taux =  isset($_POST['taux'])?$_POST['taux']:"";
				$output = $montant/$taux;
				//global $symbole;
				$symbole="$";
				
									
			}		
        }
        echo json_encode(array("output"=>$output,"symbole"=>$symbole));	
	}
	else if(isset($_POST['rechercher']) && $_POST['rechercher']=='usd')
	{
		if(isset($_POST['sbmt']))
		{		
			if(isset($_POST['taux']) && !empty($_POST['taux']) && isset($_POST['montant']) && !empty($_POST['montant']))
			{
				//Conversion de Franc Congolais en dollars 
                $montant =  isset($_POST['montant'])?$_POST['montant']:"";
                $taux =  isset($_POST['taux'])?$_POST['taux']:"";

			    $output = $montant*$taux;
				//global $symbole;
				 $symbole="FC";
				
									
			}		
        }
        echo json_encode(array("output"=>$output,"symbole"=>$symbole));		
	}
		
?>