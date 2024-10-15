<?php
require_once('identifier.php');
require_once('connexiondb.php');
$idproduit=isset($_POST['ref_produit'])?$_POST['ref_produit']:1;

if(isset($_POST["tampon"]) && $_POST["tampon"]=="recup")
{
    $idproduit=$_POST["ref_produit"];
    $requete = "SELECT * FROM articles WHERE Article_code = '$idproduit'";
    //$requete = "SELECT * FROM articles WHERE Article_code = '".$_POST["ref_produit"]."';";
    $retours = $pdo->query($requete);
    $retour = $retours->fetch();
    $chaine = $retour["Article_designation"]."|".$retour["Article_Qte"];
    print($chaine);
}
else
{
   // $idproduit=$_POST["ref_produit"];
    $requete = "UPDATE articles SET Article_Qte = Article_Qte + ".$_POST['qte_produit']." WHERE Article_code = '".$_POST["ref_produit"]."';";
    //$requete = "UPDATE articles SET Article_Qte = Article_Qte + ".$_POST['qte_produit']." WHERE Article_code = '$idproduit'";
    $retours = $pdo->query($requete);
    //$retours = mysqli_query($liaison2, $requete);
    if($retours==1)
        print("ok");
    else
        print("nok");
}

//mysqli_close($liaison2);
?>
