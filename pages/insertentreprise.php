<?php 
    require_once('identifier.php');
    require_once('connexiondb.php');
    $nomentreprise=isset($_POST['editnomentreprise'])?$_POST['editnomentreprise']:"";
    $adresse=isset($_POST['editadresseentreprise'])?$_POST['editadresseentreprise']:"";
    $identitenationale=isset($_POST['editidentitenationale'])?$_POST['editidentitenationale']:"";
    $telephone=isset($_POST['edittelephone'])?$_POST['edittelephone']:"F";
    $emailentr=isset($_POST['editemailentre'])?$_POST['editemailentre']:"";
    $reseausocio=isset($_POST['editreseausocio'])?$_POST['editreseausocio']:"";
    $nomPhoto=isset($_FILES['logo']['name'])?$_FILES['logo']['name']:"";
    $imageTemp=$_FILES['logo']['tmp_name'];
    move_uploaded_file($imageTemp,"../images/".$nomPhoto);
        
    $requete="INSERT INTO entreprise(nom_entreprise,adresse,identite_nationale,Telephone,emailentreprise,reseausocial,logo) values(?,?,?,?,?,?,?)";
    $params=array($nomentreprise,$adresse,$identitenationale,$telephone,$emailentr,$reseausocio,$nomPhoto);           
    $resultat= $pdo->prepare($requete);
    $resultat->execute($params);

    header('location:entreprise.php');

    if(isset($_FILES['logo']['name']))
    {
        /* Getting file name */
        $filename = $_FILES['logo']['name'];                
        /* Location */
        $location = "../images/".$filename;
        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);               
        /* Valid extensions */
        $valid_extensions = array("jpg","jpeg","png");
        /* Check file extension */
        if(in_array(strtolower($imageFileType), $valid_extensions)) {
           /* Upload file */ 
            move_uploaded_file($_FILES['logo']['tmp_name'],$location);                     
            $requete="INSERT INTO entreprise(nom_entreprise,adresse,identite_nationale,Telephone,emailentreprise,reseausocial,logo) values(?,?,?,?,?,?,?)";
            $params=array($nomentreprise,$adresse,$identitenationale,$telephone,$emailentr,$reseausocio,$filename);           
            $resultat= $pdo->prepare($requete);
            $resultat->execute($params);                                          
        }              
    } 
    else
    {    
        $filename="";               
        $requete="INSERT INTO entreprise(nom_entreprise,adresse,identite_nationale,Telephone,emailentreprise,reseausocial,logo) values(?,?,?,?,?,?,?)";
        $params=array($nomentreprise,$adresse,$identitenationale,$telephone,$emailentr,$reseausocio,$filename);           
        $resultat= $pdo->prepare($requete);
        $resultat->execute($params);
    } 

 ?>