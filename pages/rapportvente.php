<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_GET['infovente']) && $_GET['infovente']!="")
{
    switch($_GET["infovente"])
    {
        case "tous": 
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM detail AS det,clients AS cl,articles AS a,
            commandes AS c WHERE det.Detail_ref=a.Article_code AND det.Detail_com=c.Com_num
             AND c.Com_client=cl.Client_num ORDER BY Detail_com DESC";
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
            $pdf->Cell(100,30,utf8_decode("Historique de toutes les ventes "),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(85,10,utf8_decode(" Client"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10," Date vente",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PT ",1,0,'R');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["Client_nom"];
                $c_prenom = $retour["Client_prenom"];
                $c_numefac = $retour["Detail_com"];
                $c_datevente = $retour["Com_date"];
                $designation = $retour["Article_designation"];
                $qute = $retour["Detail_qte"];
                $c_monnaie = $retour["com_monnaie"];
                $c_puht = $retour["puht"];
                $libelle = $retour["unitevent"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(85,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_datevente)),1,0,'C');
                $pdf->Cell(80,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(30,10,utf8_decode($qute.' '.$libelle),1,0,'R');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(20,10,$qute*$c_puht.' '.$c_monnaie,1,0,'R');           
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportvente/"."Toutes_les_ventes"." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();         
        break; 
        case "pardate":
            $datevente = $_GET['parametre'];
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM detail AS det,clients AS cl,articles AS a,
            commandes AS c WHERE det.Detail_ref=a.Article_code AND det.Detail_com=c.Com_num
             AND c.Com_client=cl.Client_num AND c.Com_date = '$datevente' ORDER BY Detail_com DESC";
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
            $pdf->Cell(100,30,utf8_decode("Vente du".date("d/m/y",strtotime($datevente))),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(85,10,utf8_decode(" Client"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10," Date vente",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PT ",1,0,'R');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["Client_nom"];
                $c_prenom = $retour["Client_prenom"];
                $c_numefac = $retour["Detail_com"];
                $c_datevente = $retour["Com_date"];
                $designation = $retour["Article_designation"];
                $qute = $retour["Detail_qte"];
                $c_monnaie = $retour["com_monnaie"];
                $c_puht = $retour["puht"];
                $libelle = $retour["unitevent"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(85,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_datevente)),1,0,'C');
                $pdf->Cell(80,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(30,10,utf8_decode($qute.' '.$libelle),1,0,'R');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(20,10,$qute*$c_puht.' '.$c_monnaie,1,0,'R');
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportvente/".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output(); 
        break; 
        case "parproduit": 
            $designation = $_GET['parametre'];
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM detail AS det,clients AS cl,articles AS a,
            commandes AS c WHERE det.Detail_ref=a.Article_code AND det.Detail_com=c.Com_num
             AND c.Com_client=cl.Client_num AND a.Article_designation = '$designation' ORDER BY Detail_com DESC";
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
            $pdf->Cell(100,30,utf8_decode("Historique de vente par produit"),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(85,10,utf8_decode(" Client"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10," Date vente",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PT ",1,0,'R');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["Client_nom"];
                $c_prenom = $retour["Client_prenom"];
                $c_numefac = $retour["Detail_com"];
                $c_datevente = $retour["Com_date"];
                $designation = $retour["Article_designation"];
                $qute = $retour["Detail_qte"];
                $c_monnaie = $retour["com_monnaie"];
                $c_puht = $retour["puht"];
                $libelle = $retour["unitevent"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(85,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_datevente)),1,0,'C');
                $pdf->Cell(80,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(30,10,utf8_decode($qute.' '.$libelle),1,0,'R');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(20,10,$qute*$c_puht.' '.$c_monnaie,1,0,'R');
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportvente/"."vente de ".$designation." "."le"." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output(); 
        break; 
        case "datedebut": 
            $tab_param = explode("-", $_GET['datedbt']);
            $datedebut = $_GET['datedbt'];
            $datefin = $_GET['datefin'];
            
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM detail AS det,clients AS cl,articles AS a,
            commandes AS c WHERE det.Detail_ref=a.Article_code AND det.Detail_com=c.Com_num
             AND c.Com_client=cl.Client_num 
             AND (c.Com_date BETWEEN '$datedebut' AND '$datefin') ORDER BY det.Detail_com DESC";
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
            $pdf->Cell(100,30,utf8_decode("Vente du ".date("d/m/y",strtotime($datedebut))." "."au"." ".date("d/m/y",strtotime($datefin))),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(85,10,utf8_decode(" Client"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10," Date vente",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PT ",1,0,'R');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["Client_nom"];
                $c_prenom = $retour["Client_prenom"];
                $c_numefac = $retour["Detail_com"];
                $c_datevente = $retour["Com_date"];
                $designation = $retour["Article_designation"];
                $qute = $retour["Detail_qte"];
                $c_monnaie = $retour["com_monnaie"];
                $c_puht = $retour["puht"];
                $libelle = $retour["unitevent"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(85,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_datevente)),1,0,'C');
                $pdf->Cell(80,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(30,10,utf8_decode($qute.' '.$libelle),1,0,'R');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(20,10,$qute*$c_puht.' '.$c_monnaie,1,0,'R');
            
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportvente/".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output(); 
        break;
        case "produitpardate":
            $datevent = $_GET['datepr'];
            $idproduit = $_GET['designation'];
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM detail AS det,clients AS cl,articles AS a,
            commandes AS c WHERE det.Detail_ref=a.Article_code AND det.Detail_com=c.Com_num
            AND c.Com_client=cl.Client_num 
            AND a.Article_designation = '$idproduit' AND c.Com_date = '$datevent' ORDER BY Detail_com DESC";
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
            $pdf->Cell(100,30,utf8_decode("Vente de:"." ".$idproduit." "."le"." ".date("d/m/y",strtotime($datevent))),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(85,10,utf8_decode(" Client"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10," Date vente",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PT ",1,0,'R');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["Client_nom"];
                $c_prenom = $retour["Client_prenom"];
                $c_numefac = $retour["Detail_com"];
                $c_datevente = $retour["Com_date"];
                $designation = $retour["Article_designation"];
                $qute = $retour["Detail_qte"];
                $c_monnaie = $retour["com_monnaie"];
                $c_puht = $retour["puht"];
                $libelle = $retour["unitevent"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(85,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_datevente)),1,0,'C');
                $pdf->Cell(80,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(30,10,utf8_decode($qute.' '.$libelle),1,0,'R');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(20,10,$qute*$c_puht.' '.$c_monnaie,1,0,'R');
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportvente/".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();  
        break;
        case "parclient":
            $nomprenom = $_GET['parametre'];
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM detail AS det,clients AS cl,articles AS a,
            commandes AS c WHERE det.Detail_ref=a.Article_code AND det.Detail_com=c.Com_num
             AND c.Com_client=cl.Client_num 
             AND (cl.Client_nom LIKE '%$nomprenom%' OR cl.Client_prenom  LIKE '%$nomprenom%') ORDER BY Detail_com DESC";
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
            $pdf->Cell(100,30,utf8_decode("Vente effectuée par le client"." ".$nomprenom ),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(15,10,utf8_decode("Facture"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(85,10,utf8_decode(" Client"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(32,10," Date vente",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,10,utf8_decode("Désignation "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Quantité "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PU ",1,0,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,"  PT ",1,0,'R');
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["Client_nom"];
                $c_prenom = $retour["Client_prenom"];
                $c_numefac = $retour["Detail_com"];
                $c_datevente = $retour["Com_date"];
                $designation = $retour["Article_designation"];
                $qute = $retour["Detail_qte"];
                $c_monnaie = $retour["com_monnaie"];
                $c_puht = $retour["puht"];
                $libelle = $retour["unitevent"];

                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(15,10,"$c_numefac",1,0,'C');
                $pdf->Cell(85,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(32,10,date("d/m/y",strtotime($c_datevente)),1,0,'C');
                $pdf->Cell(80,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(30,10,utf8_decode($qute.' '.$libelle),1,0,'R');
                $pdf->Cell(20,10,$c_puht.' '.$c_monnaie,1,0,'R');
                $pdf->Cell(20,10,$qute*$c_puht.' '.$c_monnaie,1,0,'R');
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportvente/".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output(); 
        break;
    }
}
?>
