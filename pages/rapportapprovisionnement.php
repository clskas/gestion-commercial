<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_GET['infoapprovisionnement']) && $_GET['infoapprovisionnement']!="")
{
    switch($_GET["infoapprovisionnement"])
    {
        case "tous": 
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM entre_stock AS es,fournisseur AS f,produits AS p,unite_mesure AS um 
            WHERE es.id_fournisseur=f.idf AND es.id_article=p.ref_produit AND es.unite=um.id_unite ";
            $resultate = $pdo->query($selectionnertout);
        
            $requeteentreprise = "SELECT * FROM entreprise";
            $retoursentreprise = $pdo->query($requeteentreprise);
            $entreprise = $retoursentreprise->fetch();
            $nomentreprise = $entreprise["nom_entreprise"];
            $adresseentreprise = $entreprise["adresse"];
            $idnationale = $entreprise["identite_nationale"];
            $telephone = $entreprise["Telephone"];
            $logo = $entreprise["logo"];
            require ("../fpdf/fpdf.php");
        
            $pdf = new FPDF('L','mm','A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial','',9);

            $pdf->Image("../images/".$logo,null,null,15,15); 
            $pdf->Cell(100,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,utf8_decode($nomentreprise ),0,0,'L');           
            $pdf->Cell(60,5," ",0,1,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(100,5,utf8_decode($adresseentreprise),0,0,'L');
                             
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->Cell(100,5,utf8_decode("Numero téléphone : ").$telephone,0,0,'L');
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,"ID Nationale".$idnationale,0,0,'L'); 
            $pdf->SetFont('Times','BIU',30);
            $pdf->Cell(100,30,utf8_decode("Historique sur les approvisionnements"),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode(" Fournisseur"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10,utf8_decode("Date entrée"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(25,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,"Observation",1,0,'C');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["nom"];
                $c_prenom = $retour["prenom"];
                $c_numefac = $retour["numero_facture"];
                $c_dateapp = $retour["date_entre"];
                $designation = $retour["designation_produit"];
                $qute = $retour["quantite_entre"];
                $c_monnaie = $retour["monnaie"];
                $c_puht = $retour["puht"];
                $observation = $retour["observation"];
                $libelle = $retour["libelle"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(70,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_dateapp)),1,0,'C');
                $pdf->Cell(70,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(25,10,utf8_decode($qute.' '.$libelle),1,0,'C');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(50,10,$observation,1,0,'R');
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportapprovisionnement/"."Tous_les_approvisionnements"." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();         
        break; 
        case "pardate":
            $dateentre = $_GET['parametre'];
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM entre_stock AS es,fournisseur AS f,produits AS p,unite_mesure AS um 
            WHERE es.id_fournisseur=f.idf AND es.id_article=p.ref_produit 
            AND es.unite=um.id_unite AND es.date_entre = '$dateentre'";
            $resultate = $pdo->query($selectionnertout);
        
            $requeteentreprise = "SELECT * FROM entreprise";
            $retoursentreprise = $pdo->query($requeteentreprise);
            $entreprise = $retoursentreprise->fetch();
            $nomentreprise = $entreprise["nom_entreprise"];
            $adresseentreprise = $entreprise["adresse"];
            $idnationale = $entreprise["identite_nationale"];
            $telephone = $entreprise["Telephone"];
            $logo = $entreprise["logo"];
            require ("../fpdf/fpdf.php");
        
            $pdf = new FPDF('L','mm','A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial','',9);

            $pdf->Image("../images/".$logo,null,null,15,15); 
            $pdf->Cell(100,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,utf8_decode($nomentreprise ),0,0,'L');           
            $pdf->Cell(60,5," ",0,1,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(100,5,utf8_decode($adresseentreprise),0,0,'L');
                             
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->Cell(100,5,utf8_decode("Numero téléphone : ").$telephone,0,0,'L');
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,"ID Nationale".$idnationale,0,0,'L'); 
            $pdf->SetFont('Times','BIU',30);
            $pdf->Cell(100,30,utf8_decode("Approvisionnement du"." ".date("d/m/y",strtotime($dateentre))),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode(" Fournisseur"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10,utf8_decode("Date entrée"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(25,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,"Observation",1,0,'C');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["nom"];
                $c_prenom = $retour["prenom"];
                $c_numefac = $retour["numero_facture"];
                $c_dateapp = $retour["date_entre"];
                $designation = $retour["designation_produit"];
                $qute = $retour["quantite_entre"];
                $c_monnaie = $retour["monnaie"];
                $c_puht = $retour["puht"];
                $observation = $retour["observation"];
                $libelle = $retour["libelle"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(70,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_dateapp)),1,0,'C');
                $pdf->Cell(70,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(25,10,utf8_decode($qute.' '.$libelle),1,0,'C');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(50,10,$observation,1,0,'R');
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportapprovisionnement/"."Approvisionnement du"." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();          
        break; 
        case "parproduit": 
            $designation = $_GET['parametre'];
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM entre_stock AS es,fournisseur AS f,produits AS p,unite_mesure AS um 
            WHERE es.id_fournisseur=f.idf AND es.id_article=p.ref_produit 
            AND es.unite=um.id_unite AND p.designation_produit = '$designation'";
            $resultate = $pdo->query($selectionnertout);
        
            $requeteentreprise = "SELECT * FROM entreprise";
            $retoursentreprise = $pdo->query($requeteentreprise);
            $entreprise = $retoursentreprise->fetch();
            $nomentreprise = $entreprise["nom_entreprise"];
            $adresseentreprise = $entreprise["adresse"];
            $idnationale = $entreprise["identite_nationale"];
            $telephone = $entreprise["Telephone"];
            $logo = $entreprise["logo"];
            require ("../fpdf/fpdf.php");
        
            $pdf = new FPDF('L','mm','A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial','',9);

            $pdf->Image("../images/".$logo,null,null,15,15); 
            $pdf->Cell(100,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,utf8_decode($nomentreprise ),0,0,'L');           
            $pdf->Cell(60,5," ",0,1,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(100,5,utf8_decode($adresseentreprise),0,0,'L');
                             
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->Cell(100,5,utf8_decode("Numero téléphone : ").$telephone,0,0,'L');
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,"ID Nationale".$idnationale,0,0,'L'); 
            $pdf->SetFont('Times','BIU',30);
            $pdf->Cell(100,30,utf8_decode("Information sur l'approvisionnement du produit:"." ".$designation ),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode(" Fournisseur"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10,utf8_decode("Date entrée"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(25,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,"Observation",1,0,'C');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["nom"];
                $c_prenom = $retour["prenom"];
                $c_numefac = $retour["numero_facture"];
                $c_dateapp = $retour["date_entre"];
                $designation = $retour["designation_produit"];
                $qute = $retour["quantite_entre"];
                $c_monnaie = $retour["monnaie"];
                $c_puht = $retour["puht"];
                $observation = $retour["observation"];
                $libelle = $retour["libelle"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(70,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_dateapp)),1,0,'C');
                $pdf->Cell(70,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(25,10,utf8_decode($qute.' '.$libelle),1,0,'C');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(50,10,$observation,1,0,'R');
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportapprovisionnement/".$designation." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();       
        break; 
        case "datedebut": 
            $datedebut = $_GET['datedbt'];
            $datefin = $_GET['datefin'];
            
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM entre_stock AS es,fournisseur AS f,produits AS p,unite_mesure AS um 
            WHERE es.id_fournisseur=f.idf AND es.id_article=p.ref_produit 
            AND es.unite=um.id_unite AND (es.date_entre BETWEEN '$datedebut' AND '$datefin')";
            $resultate = $pdo->query($selectionnertout);
        
            $requeteentreprise = "SELECT * FROM entreprise";
            $retoursentreprise = $pdo->query($requeteentreprise);
            $entreprise = $retoursentreprise->fetch();
            $nomentreprise = $entreprise["nom_entreprise"];
            $adresseentreprise = $entreprise["adresse"];
            $idnationale = $entreprise["identite_nationale"];
            $telephone = $entreprise["Telephone"];
            $logo = $entreprise["logo"];
            require ("../fpdf/fpdf.php");
        
            $pdf = new FPDF('L','mm','A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial','',9);

            $pdf->Image("../images/".$logo,null,null,15,15); 
            $pdf->Cell(100,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,utf8_decode($nomentreprise ),0,0,'L');           
            $pdf->Cell(60,5," ",0,1,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(100,5,utf8_decode($adresseentreprise),0,0,'L');
                             
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->Cell(100,5,utf8_decode("Numero téléphone : ").$telephone,0,0,'L');
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,"ID Nationale".$idnationale,0,0,'L'); 
            $pdf->SetFont('Times','BIU',30);
            $pdf->Cell(100,30,utf8_decode("Approvisionnement du"." ".date("d/m/y",strtotime($datedebut))." "."au"." ".date("d/m/y",strtotime($datefin))),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode(" Fournisseur"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10,utf8_decode("Date entrée"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(25,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,"Observation",1,0,'C');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["nom"];
                $c_prenom = $retour["prenom"];
                $c_numefac = $retour["numero_facture"];
                $c_dateapp = $retour["date_entre"];
                $designation = $retour["designation_produit"];
                $qute = $retour["quantite_entre"];
                $c_monnaie = $retour["monnaie"];
                $c_puht = $retour["puht"];
                $observation = $retour["observation"];
                $libelle = $retour["libelle"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(70,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_dateapp)),1,0,'C');
                $pdf->Cell(70,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(25,10,utf8_decode($qute.' '.$libelle),1,0,'C');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(50,10,$observation,1,0,'R');
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportapprovisionnement/".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();      
        break;
        case "produitpardate":
            $dateentre = $_GET['dateentre'];
            $idproduit = $_GET['produit'];
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM entre_stock AS es,fournisseur AS f,produits AS p,unite_mesure AS um 
            WHERE es.id_fournisseur=f.idf AND es.id_article=p.ref_produit 
            AND es.unite=um.id_unite AND p.designation_produit = '$idproduit' AND es.date_entre = '$dateentre'";
            $resultate = $pdo->query($selectionnertout);
        
            $requeteentreprise = "SELECT * FROM entreprise";
            $retoursentreprise = $pdo->query($requeteentreprise);
            $entreprise = $retoursentreprise->fetch();
            $nomentreprise = $entreprise["nom_entreprise"];
            $adresseentreprise = $entreprise["adresse"];
            $idnationale = $entreprise["identite_nationale"];
            $telephone = $entreprise["Telephone"];
            $logo = $entreprise["logo"];
            require ("../fpdf/fpdf.php");
        
            $pdf = new FPDF('L','mm','A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial','',9);

            $pdf->Image("../images/".$logo,null,null,15,15); 
            $pdf->Cell(100,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,utf8_decode($nomentreprise ),0,0,'L');           
            $pdf->Cell(60,5," ",0,1,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(100,5,utf8_decode($adresseentreprise),0,0,'L');
                             
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->Cell(100,5,utf8_decode("Numero téléphone : ").$telephone,0,0,'L');
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,"ID Nationale".$idnationale,0,0,'L'); 
            $pdf->SetFont('Times','BIU',30);
            $pdf->Cell(100,30,utf8_decode("Approvisionnement de:"." ".$idproduit." "."le"." ".date("d/m/y",strtotime($dateentre))),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode(" Fournisseur"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10,utf8_decode("Date entrée"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(25,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,"Observation",1,0,'C');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["nom"];
                $c_prenom = $retour["prenom"];
                $c_numefac = $retour["numero_facture"];
                $c_dateapp = $retour["date_entre"];
                $designation = $retour["designation_produit"];
                $qute = $retour["quantite_entre"];
                $c_monnaie = $retour["monnaie"];
                $c_puht = $retour["puht"];
                $observation = $retour["observation"];
                $libelle = $retour["libelle"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(70,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_dateapp)),1,0,'C');
                $pdf->Cell(70,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(25,10,utf8_decode($qute.' '.$libelle),1,0,'C');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(50,10,$observation,1,0,'R');
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportapprovisionnement/".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();        
        break;
        case "parfournisseur":
            $nomprenom = $_GET['parametre']; 
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM entre_stock AS es,fournisseur AS f,produits AS p,unite_mesure AS um 
            WHERE es.id_fournisseur=f.idf AND es.id_article=p.ref_produit 
            AND es.unite=um.id_unite  AND (f.nom LIKE '%$nomprenom%' OR f.prenom LIKE '%$nomprenom%')";
            $resultate = $pdo->query($selectionnertout);
        
            $requeteentreprise = "SELECT * FROM entreprise";
            $retoursentreprise = $pdo->query($requeteentreprise);
            $entreprise = $retoursentreprise->fetch();
            $nomentreprise = $entreprise["nom_entreprise"];
            $adresseentreprise = $entreprise["adresse"];
            $idnationale = $entreprise["identite_nationale"];
            $telephone = $entreprise["Telephone"];
            $logo = $entreprise["logo"];
            require ("../fpdf/fpdf.php");
        
            $pdf = new FPDF('L','mm','A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial','',9);

            $pdf->Image("../images/".$logo,null,null,15,15); 
            $pdf->Cell(100,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,utf8_decode($nomentreprise ),0,0,'L');           
            $pdf->Cell(60,5," ",0,1,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(100,5,utf8_decode($adresseentreprise),0,0,'L');
                             
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->Cell(100,5,utf8_decode("Numero téléphone : ").$telephone,0,0,'L');
            $pdf->Cell(9,5,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,5,"ID Nationale".$idnationale,0,0,'L'); 
            $pdf->SetFont('Times','BIU',30);
            $pdf->Cell(100,30,utf8_decode("Approvisionnement du fournisseur:"." ".$nomprenom),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode(" Fournisseur"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10,utf8_decode("Date entrée"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(25,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,"Observation",1,0,'C');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["nom"];
                $c_prenom = $retour["prenom"];
                $c_numefac = $retour["numero_facture"];
                $c_dateapp = $retour["date_entre"];
                $designation = $retour["designation_produit"];
                $qute = $retour["quantite_entre"];
                $c_monnaie = $retour["monnaie"];
                $c_puht = $retour["puht"];
                $observation = $retour["observation"];
                $libelle = $retour["libelle"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(70,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_dateapp)),1,0,'C');
                $pdf->Cell(70,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(25,10,utf8_decode($qute.' '.$libelle),1,0,'C');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(50,10,$observation,1,0,'R');
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportapprovisionnement/".$nomprenom." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();       
        break;
        
    }
}
?>
