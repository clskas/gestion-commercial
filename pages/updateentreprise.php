<?php 
    require_once('identifier.php');
    require_once('connexiondb.php');
   
    $identreprise=isset($_POST['identreprise'])?$_POST['identreprise']:0;
    $nomentreprise=isset($_POST['nom_entreprise'])?$_POST['nom_entreprise']:"";
    $adresse=isset($_POST['adresse'])?$_POST['adresse']:"";
    $identitenationale=isset($_POST['identite_nationale'])?$_POST['identite_nationale']:"";
    $telephone=isset($_POST['Telephone'])?$_POST['Telephone']:"F";
    $tva=isset($_POST['tva'])?$_POST['tva']:1;
    $nomPhoto=isset($_FILES['photo']['name'])?$_FILES['photo']['name']:"";
    $imageTemp=$_FILES['photo']['tmp_name'];
    move_uploaded_file($imageTemp,"../images/".$nomPhoto);

   // echo $nomPhoto ."<br>";
   // echo $imageTemp;
   if(!empty($nomPhoto))
   {
    $requete="UPDATE entreprise SET nom_entreprise=?,adresse=?,identite_nationale=?,Telephone=?,tva=?,logo=? WHERE id_entreprise=?";
    $params=array($nomentreprise,$adresse,$identitenationale,$telephone,$tva,$nomPhoto,$identreprise);
   }
   else
   {
    $requete="UPDATE entreprise SET nom_entreprise=?,adresse=?,identite_nationale=?,Telephone=?,tva=? WHERE id_entreprise=?";
    $params=array($nomentreprise,$adresse,$identitenationale,$telephone,$tva,$nomPhoto,$identreprise);
   }
    $resultat= $pdo->prepare($requete);
    $resultat->execute($params);

    header('location:entreprise.php');
 ?>