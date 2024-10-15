<?php
     /*session_start();
     if(!isset($_SESSION['user']))
         header('location:login.php');*/
    //include("connexiondb.php");//Incude veut dire copier coller le code ecrit dans le fichier connexiondb
   // require("connexiondb.php");//il lit le code du fichier de connexiondb et l'execute ici
    require_once('identifier.php');
    require_once('connexiondb.php');// il nous permet de creer l'objet qui nous permet de nous connecter à la base de données
    
    $logins=isset($_GET['logins'])?$_GET['logins']:"";
    $size=isset($_GET['size'])?$_GET['size']:4;
    $page=isset($_GET['page'])?$_GET['page']:1;
    $offset=($page-1)*$size;

    $requeteUser= "select * from utilisateur where logins like '%$logins%'";

    $requeteCount= "select count(*) countUser from utilisateur"; 
    

    
    $resultatUser=$pdo->query($requeteUser);
    $resultatCount=$pdo->query($requeteCount);
    $tabCount=$resultatCount->fetch();
    $nbrUser=$tabCount['countUser'];
   
   // $tabCount= $resultatCount->fetch();
    //$nbrStagiaire=$tabCount['countS'];

    $reste=$nbrUser % $size; 
    if($reste==0)  
        $nbrPage=$nbrUser/$size;
    else
        $nbrPage=floor($nbrUser/$size)+1; 


?>

<! DOCTYPE HTML>
<html>
    <head>
        <title>Gestion des utilisateurs</title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">       
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
        <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../css/fontawesome.min.css">
        <script src="../js/jquery-3.5.1.min.js"></script>              
        <script src="../js/facturationstock.js"></script>
        <script src="../js/sweetalert.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>   
        <script src="../js/pagination/jquery.twbsPagination.min.js"></script>
    </head>
    <body>
        <?php include("menu.php"); ?>
        <div class="container">
            <div class="panel panel-success margetop">
                <div class="panel-heading">
                    Rechercher des utilisateurs...
                </div>
                <div class="panel-body">
                    <form action="utilisateurs.php" method="get" class="form-inline">
                        <div class="form-group">
                            <input type="text" name="logins" placeholder="login" class="form-control" value="<?php echo $logins; ?>"/>
                        </div>
                            <label for="idfiliere">Login</label>
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-search"></span>
                            Rechercher...
                        </button>    
                    </form>
                        
                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    Liste des utilisateurs (<?php echo $nbrUser ?> utilisateurs)
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    logins
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Role
                                </th>
                                <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                                    <th>
                                        Action
                                    </th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <?php while($user=$resultatUser->fetch()){ ?>
                                    <tr class="<?php echo $user['etat']==1?'success':'danger'?>">
                                        <td><?php echo $user['logins']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo $user['roles']; ?></td>
                                        <?php if($_SESSION['user']['roles']=='ADMIN') { ?>
                                            <td>
                                                <a href="editerUtilisateur.php?idUser=<?php echo $user['iduser'] ?>">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                                &nbsp;&nbsp;
                                                <a  onclick="return confirm('Etes-vous sûr de vouloir supprimer cet utilisateur ?')" href="supprimerUtilisateur.php?idUser=<?php echo $user['iduser'] ?>">
                                                <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                                &nbsp;&nbsp;
                                                <a href="activerUtilisateur.php?idUser=<?php echo $user['iduser'] ?>&etat=<?php echo $user['etat'] ?>">
                                                    <?php
                                                        if($user['etat']==1)
                                                            echo '<span class="glyphicon glyphicon-remove"></span>';
                                                        else
                                                            echo '<span class="glyphicon glyphicon-ok"></span>';  
                                                    ?>  
                                                </a>        
                                            </td>
                                        <?php } ?>    
                                    </tr>  
                                <?php } ?>
                        </tbody>
                    </table>
                    <div>
                        <ul class="pagination">
                            <?php for($i=1; $i<=$nbrPage;$i++){?>
                                <li class="<?php if($i==$page) echo 'active';?>"> <a href="utilisateurs.php?page=<?php echo $i; ?>&logins=<?php echo $logins ?>">
                                        <?php echo $i; ?>
                                    </a> 
                                </li>
                            <?php } ?>           
                        </ul>
                        
                            
                </div>
                </div>
            </div>
        </div>
    </body>
</html>