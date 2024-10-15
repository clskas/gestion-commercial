<?php
require_once('../les_fonctions/fonctions.php');
require_once('identifier.php');
require_once('connexiondb.php');
$utilisateur=$_SESSION['user']['roles'];
   if(isset($_POST["param"]))
    {
        switch($_POST["param"])
        {
            case "tous":               
                $requeteUser= "SELECT * FROM utilisateur";
                $resultatuser=$pdo->query($requeteUser);

                $users = array();
                 //Récupérer les lignes
                while($retour = $resultatuser->fetch()){
                   array_push($users,$retour);
                }
                //Afficher le tableau au format JSON              
                echo json_encode(array("utilisateur"=>($users),"user"=>$utilisateur));            
                break;
            case "parlogin":
                $logins=isset($_POST['logins'])?$_POST['logins']:"";
                $requeteUser= "SELECT * FROM utilisateur WHERE logins LIKE '%$logins%'";
                $resultatuser=$pdo->query($requeteUser);

                $users = array();
                 //Récupérer les lignes
                while($retour = $resultatuser->fetch()){
                   array_push($users,$retour);
                }
                //Afficher le tableau au format JSON            
                    echo json_encode(array("utilisateur"=>($users),"user"=>$utilisateur));            
                break;  

            case "suppression":  
                $idUser=isset($_POST['idUser'])?$_POST['idUser']:0;
        
                $requete="DELETE FROM utilisateur WHERE iduser=?";
                $params=array($idUser);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
            break;

            case "activer":  
                $idUser=isset($_POST['idUser'])?$_POST['idUser']:0;
                $etat=isset($_POST['etat'])?$_POST['etat']:0;
               
               if($etat==1)
                    $newEtat=0;
               else
                    $newEtat=1;     
               $requete="UPDATE utilisateur SET etat=? WHERE iduser=?";
               $params=array($newEtat,$idUser);
               $resultat= $pdo->prepare($requete);
               $resultat->execute($params);
            break;

            case "inserer":
               if($_SERVER['REQUEST_METHOD']=='POST'){
                    $login = isset($_POST['login'])?$_POST['login']:"";
                    $pwd1 = isset($_POST['pwd1'])?$_POST['pwd1']:"";
                    $pwd2 = isset($_POST['pwd2'])?$_POST['pwd2']:"";
                    $email = isset($_POST['email'])?$_POST['email']:"";
                    $roles = isset($_POST['role'])?$_POST['role']:"";

                    $telephoneuser = isset($_POST['userphone'])?$_POST['userphone']:"";
                    $reseausociouser = isset($_POST['userrezosocio'])?$_POST['userrezosocio']:"";
                    $useradressee = isset($_POST['useradress'])?$_POST['useradress']:"";
                    $validationErrors = array();
                    if(isset($login))
                    {
                        $filitredLogin=filter_var($login,FILTER_SANITIZE_STRING);
                        if(strlen($login)<4)
                        {
                            $validationErrors[]="Error!!! le login doit contenir au moins 4 caractères";
                        }
                    }
            
                    if(isset($pwd1) && isset($pwd2))
                    {
                      if(empty($pwd1))
                       {
                         $validationErrors[]="Error!!! le mot de passe ne doit pas être vide";
                       }
                       if(md5($pwd1)!==md5($pwd2))
                       {
                            $validationErrors[]="Erreur!!! les deux mots de passe ne sont pas identiques";
                       }
                    }
            
                    if(isset($email))
                    {
                        $filitredEmail=filter_var($email,FILTER_SANITIZE_EMAIL);
                        if($filitredEmail !=true)
                        {
                            $validationErrors[]="Erreur!!! Email non valide";
                        }
                    }
            
                    if(empty($validationErrors))
                    {
                        if(rechercher_par_login($login)==0 && rechercher_par_email($email)==0)
                        {
                            $insereruser = "INSERT INTO utilisateur(logins,email,usertelephone,userreseausocio,useradresse 
                            ,roles,etat,pwd) VALUES (?,?,?,?,?,?,?,?)";
                            $paramsuser=array($login,$email,$telephoneuser,$reseausociouser,$useradressee,$roles,0,$pwd1);
                            $resultatuser= $pdo->prepare($insereruser);
                            $resultatuser->execute($paramsuser);

                            $success_msg="Félicitation, votre compte est crée, mais temporairement
                                            inactif jusqu'à son activation par l'administrateur";
            
                        }
                        else
                        {
                             if(rechercher_par_login($login)>0)
                             {
                                $validationErrors[]="Désolé, ce login existe déjà";
                             }
                             if(rechercher_par_email($email)>0)
                             {
                               $validationErrors[]="Désolé, ce email existe déjà";
                             }
                        }          
                    }           
                }
                echo json_encode(array("validationerreur"=>($validationErrors),
                "successmessage"=>$success_msg));                 
            break;

            case "modifier":
               
               $idus=isset($_POST['idu'])?$_POST['idu']:0;
                $selectionneetat="SELECT * FROM utilisateur WHERE iduser=$idus";
                $resultatetat=$pdo->query($selectionneetat);
                $etatuser=$resultatetat->fetch();
                $etat = $etatuser['etat'];   
                $login = isset($_POST['editlogin'])?$_POST['editlogin']:"";
                $pwd1 = isset($_POST['editpwd1'])?$_POST['editpwd1']:"";
                $pwd2 = isset($_POST['editpwd2'])?$_POST['editpwd2']:"";
                $email = isset($_POST['editemail'])?$_POST['editemail']:"";
                $roles = isset($_POST['editrole'])?$_POST['editrole']:"";
                $telephoneuseredit = isset($_POST['userphoneedit'])?$_POST['userphoneedit']:"";
                $reseausociouseredit = isset($_POST['userrezosocioedit'])?$_POST['userrezosocioedit']:"";
                $useradresseedit = isset($_POST['useradressedit'])?$_POST['useradressedit']:"";

                $requete="UPDATE utilisateur SET logins=?,email=?,usertelephone=?,
                userreseausocio=?,useradresse=?,roles=?,etat=?,pwd=? WHERE iduser=?";
                $params=array($login,$email,$telephoneuseredit,$reseausociouseredit,$useradresseedit,$roles,$etat,$pwd1,$idus);
                $resultat= $pdo->prepare($requete);
                $resultat->execute($params);
                $success_msg="Félicitation, votre compte est modifié avec succès"; 
                echo json_encode(array("validationerreur"=>($validationErrors),
               "successmessage"=>$success_msg)); 
                break;

            case "chargerchampmodifier":
                $idutilisateur=isset($_POST['idu'])?$_POST['idu']:0;
                $requete="SELECT * FROM utilisateur WHERE iduser=$idutilisateur";
                $resultat=$pdo->query($requete);
                $users=$resultat->fetch();
                $login = $users['logins'];
                $email = $users['email'];
                $motdepasse = $users['pwd'];
                $fonction = $users['roles'];

                $telephuser = $users['usertelephone'];
                $reseausocio = $users['userreseausocio'];
                $adressuser = $users['useradresse'];

                echo json_encode(array("nomuser"=>$login,"userphones"=>$telephuser,"userreseausocios"=>$reseausocio,
                "useradresses"=>$adressuser,"adressmail"=>$email,"motdepasse"=>$motdepasse,"fonction"=>$fonction));      
                break;   
      }      
    }

?>