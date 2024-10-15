<?php

session_start();
if(isset($_SESSION['user']))
{
    require_once('connexiondb.php');
    $ides=isset($_GET['identrestock'])?$_GET['identrestock']:0;
    $ancienproduit=isset($_GET['ancienproduit'])?$_GET['ancienproduit']:0;
    $ancienneqte=isset($_GET['ancienqte'])?$_GET['ancienqte']:0;

    $requete="DELETE FROM entre_stock WHERE id_entre=?";
    $params=array($ides);
    $resultat= $pdo->prepare($requete);
    $resultat->execute($params);

    if($resultat)
    {
        $requeteP="SELECT * FROM articles WHERE Article_code=$ancienproduit";
        $resultatP=$pdo->QUERY($requeteP);
        $retour = $resultatP->fetch();
        $quaniteanci=$retour["Article_Qte"];
        $qte=$quaniteanci-$ancienneqte;
        $requete = "UPDATE articles SET Article_Qte = $qte WHERE Article_code = $ancienproduit";
        $retours = $pdo->query($requete);
        if($retours)
        {
            $requetesp="SELECT * FROM articles WHERE Article_code=$ancienproduit";
            $resultatsp=$pdo->QUERY($requetesp);
            $retoursp = $resultatsp->fetch();
            $quaniteancie=$retoursp["Article_Qte"];
    
            if($quaniteancie==0)
            {
                $requetes="DELETE FROM articles WHERE Article_code=$ancienproduit";
                $resultats= $pdo->QUERY($requetes);
            }
        }
       
    }

    

    header('location:entrestock.php');
}
else
{
    header('location:login.php');
}

?>

