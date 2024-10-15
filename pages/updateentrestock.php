<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_POST["param"]))
{
    switch($_POST["param"])
    {
        case "modifier":
            $ides=isset($_POST['idES'])?$_POST['idES']:0;
            $idancienproduit=isset($_POST['ancienproduit'])?$_POST['ancienproduit']:0;
            $ancienneqte=isset($_POST['ancienqte'])?$_POST['ancienqte']:0;
            $fournisseur= isset($_POST['idFournisseur'])?$_POST['idFournisseur']:1;
            $produit = isset($_POST['idproduit'])?$_POST['idproduit']:1;
            $numerofacture = isset($_POST['numerofacture'])?$_POST['numerofacture']:"";
            $qte = isset($_POST['quantiteentre'])?$_POST['quantiteentre']:0;
            $puht = isset($_POST['puht'])?$_POST['puht']:0;
            $dateenre = isset($_POST['dateenre'])?$_POST['dateenre']:"";
            $observation = isset($_POST['observation'])?$_POST['observation']:"";

            $requete="UPDATE entre_stock SET id_fournisseur=?,id_article=?,numero_facture=?,quantite_entre=?,puht=?,date_entre=?,observation=? WHERE id_entre=?";
            $params=array($fournisseur,$produit,$numerofacture,$qte,$puht,$dateenre,$observation,$ides);
            $resultat= $pdo->prepare($requete);
            $resultat->execute($params);
            if($resultat)
            {
                $requeteP="SELECT * FROM produits WHERE ref_produit=$produit";
                $resultatP=$pdo->QUERY($requeteP);
                $retour = $resultatP->fetch();
                $designation=$retour["designation_produit"];
    
                if($produit==$idancienproduit)
                {
                    $requeteentre = "SELECT SUM(quantite_entre) AS qte FROM entre_stock WHERE id_article = $produit";
                    $retours=$pdo->query($requeteentre);
                    $retour =$retours->fetch();
                    $quantite=$retour["qte"];
    
                    $requete = "UPDATE articles SET Article_Qte = $quantite WHERE Article_code = $produit";
                    $retours = $pdo->query($requete);
                }
                else
                {
                    $requeteP="SELECT * FROM articles WHERE Article_code=$idancienproduit";
                    $resultatP=$pdo->QUERY($requeteP);
                    $retour = $resultatP->fetch();
                    $quaniteanci=$retour["Article_Qte"];
                    $requete = "UPDATE articles SET Article_Qte = $quaniteanci-$ancienneqte WHERE Article_code = $idancienproduit";
                    $retoura = $pdo->query($requete);

                    if($retoura)
                    {
                        $requetesp="SELECT * FROM articles WHERE Article_code=$idancienproduit";
                        $resultatsp=$pdo->QUERY($requetesp);
                        $retoursp = $resultatsp->fetch();
                        $quaniteancie=$retoursp["Article_Qte"];
        
                        if($quaniteancie==0)
                        {
                            $requetes="DELETE FROM articles WHERE Article_code=$idancienproduit";
                            $resultats= $pdo->QUERY($requetes);
                        }
                    }
                   
    
                    $requeteentre = "SELECT SUM(quantite_entre) AS qte FROM entre_stock WHERE id_article = $produit";
                    $retours=$pdo->query($requeteentre);
                    $retour =$retours->fetch();
                    $quantite=$retour["qte"];
    
                    $requete = "UPDATE articles SET Article_Qte = $quantite WHERE Article_code = $produit";
                    $retours = $pdo->query($requete);
    
                    $requetenouveauid="SELECT * FROM articles WHERE Article_code= $produit";
                    $resultatnouveau=$pdo->QUERY($requetenouveauid);
                    $retournouveau = $resultatnouveau->fetch();
                    if($retournouveau)
                    {
                        $requeteentren = "SELECT SUM(quantite_entre) AS qte FROM entre_stock WHERE id_article = $produit";
                        $retoursn=$pdo->query($requeteentren);
                        $retourn =$retoursn->fetch();
                        $quantiten=$retourn["qte"];
    
                        /*$requeten="SELECT * FROM articles WHERE Article_code=$produit";
                        $resultatn=$pdo->QUERY($requeten);
                        $retour = $resultatn->fetch();
                        $quaniteancie=$retour["Article_Qte"];*/
                        $requete = "UPDATE articles SET Article_Qte = $quantiten WHERE Article_code = $produit";
                        $retours = $pdo->query($requete);
    
                    }
                    else
                    {
                        $requetePn="SELECT * FROM produits WHERE ref_produit=$produit";
                        $resultatPn=$pdo->QUERY($requetePn);
                        $retourPn = $resultatPn->fetch();
                        $designation=$retourPn["designation_produit"];
                        $qtemin= $retourPn["qte_min"];
                    
                        $requete = "INSERT INTO articles(Article_code,Article_designation,Article_PUHT,Article_Qte,qtemin) VALUES (?,?,?,?,?)";
                        $params=array($produit,$designation,$puht,$qte,$qtemin);
                        $resultat= $pdo->prepare($requete);
                        $resultat->execute($params);
                    }
    
                }
            }
           
            print("ok");
            break;
    }
}
header('location:entrestock.php');
?>

