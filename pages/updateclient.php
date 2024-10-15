<?php 
    require_once('identifier.php');
    require_once('connexiondb.php');
if(isset($_POST["param"]))
{
    switch($_POST["param"])
    {
        case "modifier":
            $idC=isset($_POST['idC'])?$_POST['idC']:0;
            $nom=isset($_POST['nom'])?$_POST['nom']:"";
            $prenom=isset($_POST['prenom'])?$_POST['prenom']:"";
            $email=isset($_POST['email'])?$_POST['email']:"";
            $telephone=isset($_POST['telephone'])?$_POST['telephone']:"";
            $reseausocial=isset($_POST['reseausocial'])?$_POST['reseausocial']:"";
            $adresse=isset($_POST['adresse'])?$_POST['adresse']:"";
            $civilite=isset($_POST['civilite'])?$_POST['civilite']:"Monsieur";
            $requete="update clients set Client_civilite=?,Client_nom=?,Client_prenom=?,email=?,telephone=?,adresse=?,reseausocial=? where CLient_num=?";
            $params=array($civilite,$nom,$prenom,$email,$telephone,$adresse,$reseausocial,$idC);
            $resultat= $pdo->prepare($requete);
            $resultat->execute($params);
            print("ok");
            break;
    }
}
header('location:clients.php');
 ?>