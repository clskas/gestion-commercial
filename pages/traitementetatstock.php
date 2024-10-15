<?php
require_once('identifier.php');

require_once('connexiondb.php');

$designation = isset($_GET['designation'])?$_GET['designation']:"";
$size=isset($_GET['size'])?$_GET['size']:6;
$page=isset($_GET['page'])?$_GET['page']:1;
$offset=($page-1)*$size;

$requete= "SELECT * FROM articles WHERE Article_designation LIKE '%$designation%' LIMIT $size OFFSET $offset";

$requeteCount="SELECT COUNT(*) countp FROM articles ";

$resultP=$pdo->query($requete);

$resultatCount= $pdo->query($requeteCount);

$tabCount= $resultatCount->fetch();
$nbretat=$tabCount['countp'];

$reste=$nbretat % $size; 
if($reste===0) 
    $nbrPage=$nbretat/$size;
else
    $nbrPage=floor($nbretat/$size)+1;


?>