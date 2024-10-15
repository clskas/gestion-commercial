<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_GET['infopaiement']) && $_GET['infopaiement']!="")
{
    switch($_GET["infopaiement"])
    {
        case "tous": 
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;      
            $selectionnertout="SELECT * FROM paiement AS p,clients AS cl,
            commandes AS c WHERE p.numerofacture=c.Com_num
            AND c.Com_client=cl.Client_num";
            $resultate=$pdo->query($selectionnertout);
        
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
            $pdf->Cell(100,30,utf8_decode("Liste de tous les paiements"),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Reçu paiement"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(110,10,utf8_decode(" Client"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10," Date paie",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Montant à payer "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Montant payé "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,"  Reste ",1,0,'C');
            
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["Client_nom"];
                $c_prenom = $retour["Client_prenom"];
                $c_numefac = $retour["id_paiement"];
                $c_datepaie = $retour["date_paiement"];
                $montantapayer = $retour["montant_a_paye"];
                $payer = $retour["montant_paye"];
                $c_monnaie = $retour["monnaie"];
                $c_reste = $retour["reste"];
                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(30,10,"$c_numefac",1,0,'C');
                $pdf->Cell(110,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(50,10,date("d/m/y",strtotime($c_datepaie)),1,0,'C');
                $pdf->Cell(30,10,$montantapayer.$c_monnaie,1,0,'R');
                $pdf->Cell(30,10,$payer.$c_monnaie,1,0,'R');
                $pdf->Cell(30,10,$c_reste.$c_monnaie,1,0,'R');                       
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportpaiement/"."Tous_les_paiements"." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();         
        break; 
        case "pardate":
            $datepaie = $_GET['parametre'];         
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;        
            $selectionnertout="SELECT * FROM paiement AS p,clients AS cl,
            commandes AS c WHERE p.numerofacture=c.Com_num
            AND c.Com_client=cl.Client_num AND p.date_paiement='$datepaie'";
            $resultate=$pdo->query($selectionnertout);               
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
            $pdf->Cell(100,30,utf8_decode("Paiements du ".date("d/m/y",strtotime($datepaie))),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Reçu paiement"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(110,10,utf8_decode(" Client"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10," Date paie",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Montant à payer "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Montant payé "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,"  Reste ",1,0,'C');
            
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["Client_nom"];
                $c_prenom = $retour["Client_prenom"];
                $c_numefac = $retour["id_paiement"];
                $c_datepaie = $retour["date_paiement"];
                $montantapayer = $retour["montant_a_paye"];
                $payer = $retour["montant_paye"];
                $c_monnaie = $retour["monnaie"];
                $c_reste = $retour["reste"];
                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(30,10,"$c_numefac",1,0,'C');
                $pdf->Cell(110,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(50,10,date("d/m/y",strtotime($c_datepaie)),1,0,'C');
                $pdf->Cell(30,10,$montantapayer.$c_monnaie,1,0,'R');
                $pdf->Cell(30,10,$payer.$c_monnaie,1,0,'R');
                $pdf->Cell(30,10,$c_reste.$c_monnaie,1,0,'R');
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportpaiement/".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();   
        break; 
        case "parfacture": 
            $num_facture = $_GET['parametre'];
            $c_nom=""; $c_numefac=""; $c_datepaie=""; $montantapayer=""; $payer=""; $c_reste=""; $compteur=0;
            $selectionnertout="SELECT * FROM paiement AS p,clients AS cl,
            commandes AS c WHERE p.numerofacture=c.Com_num
            AND c.Com_client=cl.Client_num AND p.numerofacture=$num_facture";
            $resultate=$pdo->query($selectionnertout);              
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
            $pdf->Cell(100,30,utf8_decode("Paiement de la facture"." ".$num_facture),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Reçu paiement"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(110,10,utf8_decode(" Client"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10," Date paie",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Montant à payer "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode("Montant payé "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,"  Reste ",1,0,'C');
            
            while($retour = $resultate->fetch())
            {           
                $c_nom = $retour["Client_nom"];
                $c_prenom = $retour["Client_prenom"];
                $c_numefac = $retour["id_paiement"];
                $c_datepaie = $retour["date_paiement"];
                $montantapayer = $retour["montant_a_paye"];
                $payer = $retour["montant_paye"];
                $c_monnaie = $retour["monnaie"];
                $c_reste = $retour["reste"];
                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(30,10,"$c_numefac",1,0,'C');
                $pdf->Cell(110,10,utf8_decode("$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(50,10,date("d/m/y",strtotime($c_datepaie)),1,0,'C');
                $pdf->Cell(30,10,$montantapayer.$c_monnaie,1,0,'R');
                $pdf->Cell(30,10,$payer.$c_monnaie,1,0,'R');
                $pdf->Cell(30,10,$c_reste.$c_monnaie,1,0,'R');            
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportpaiement/".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();   
        break; 
    }
}
?>
