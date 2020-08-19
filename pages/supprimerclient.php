<?php 
   
   session_start();
   if(isset($_SESSION['user']))
   {
      require_once('connexiondb.php');
      $idC=isset($_GET['idC'])?$_GET['idC']:0;
      
      $requete="DELETE FROM clients WHERE Client_num=?";
      $params=array($idC);
      $resultat= $pdo->prepare($requete);
      $resultat->execute($params);

      header('location:clients.php');
   }
   else 
   {
         header('location:login.php');
   }
   
 ?>