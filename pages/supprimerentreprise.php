<?php 
   
   session_start();
   if(isset($_SESSION['user']))
   {
      require_once('connexiondb.php');
      $identreprise=isset($_GET['identreprise'])?$_GET['identreprise']:0; 
      $requete="DELETE FROM entreprise WHERE id_entreprise=?";
      $params=array($identreprise);
      $resultat= $pdo->prepare($requete);
      $resultat->execute($params);
      header('location:entreprise.php');
   }
   else 
   {
         header('location:login.php');
   }
   
 ?>