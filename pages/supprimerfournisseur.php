<?php
session_start();
if(isset($_SESSION['user']))
{
    require_once('connexiondb.php');

    if(isset($_POST["param"]))
    {
        switch($_POST["param"])
        {
            case "supprimer":
                $idf=isset($_GET['idf'])?$_GET['idf']:0;

                $requete="DELETE FROM fournisseur WHERE idf=?";
                $params=array($idf);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
                print("ok");
                break;
        }
    }

   // header('location:fournisseurs.php');
}
else
{
    header('location:login.php');
}

?>
