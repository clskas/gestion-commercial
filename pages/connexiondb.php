<?php
    try{
        $pdo=new PDO("mysql:host=localhost;port=3306;dbname=stocks", "root", "");
    }
    catch(Exception $e){
        die('Erreur de connexion :' .$e->getMessage());
    }
    
?>