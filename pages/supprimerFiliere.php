<?php 
    session_start();
    if(isset($_SESSION['user']))
    {
    require_once('connexiondb.php');
    $idc=isset($_GET['idC'])?$_GET['idC']:0;
    $requeteC="select count(*) countStag from stagiaire where idFiliere=$idf";
    $resultatStag= $pdo->query($requeteC);
    $tabCountStag= $resultatStag->fetch();
    $nbrStag=$tabCountStag['countStag'];

        if($nbrStag==0){
                $requete="delete from filiere where idFiliere=?";
                $params=array($idf);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
                header('location:filieres.php');
        }
        else 
         {
            $msg="Impossible de supprimer : Veuillez d'abord supprimer tous les stagiaires inscrits dans cette filière";
             header("location:alerte.php?message=$msg");
        }
  
    }
    else 
    {
        header('location:login.php');
    }
 ?>