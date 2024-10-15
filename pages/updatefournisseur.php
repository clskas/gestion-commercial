<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_POST["param"]))
{
    switch($_POST["param"])
    {
        case "modifier":
            $idf=isset($_POST['idf'])?$_POST['idf']:0;
            $civilite=isset($_POST['civilite'])?$_POST['civilite']:"Monsieur";
            $nom=isset($_POST['nom'])?$_POST['nom']:"";
            $prenom=isset($_POST['prenom'])?$_POST['prenom']:"";
            $email=isset($_POST['email'])?$_POST['email']:"";
            $telephone=isset($_POST['telephone'])?$_POST['telephone']:"";
            $adresse=isset($_POST['adresse'])?$_POST['adresse']:"";
            $reseausocial=isset($_POST['reseausocial'])?$_POST['reseausocial']:"";

            $requete="UPDATE fournisseur SET civilite=?,nom=?,prenom=?,email=?,telephone=?,reseausocial=?,adresse=? WHERE idf=?";
            $params=array($civilite,$nom,$prenom,$email,$telephone,$reseausocial,$adresse,$idf);
            $resultat= $pdo->PREPARE($requete);
            $resultat->execute($params);
            print("ok");
            break;
    }
}
//header('location:fournisseurs.php');
?>
