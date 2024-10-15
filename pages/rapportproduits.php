<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_GET['infoproduits']) && $_GET['infoproduits']!="")
{
    switch($_GET["infoproduits"])
    {
        case "tous": 
            $c_codeproduit=""; $designation=""; $qutemin=""; $c_marque=""; $compteur=0;      
            $requete= "SELECT * FROM produits";
            $resultatp=$pdo->query($requete);
        
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
            $pdf->Image("../images/".$logo,null,null,30,30); 
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
            $pdf->Cell(100,30,utf8_decode("Liste de tous les produits"),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            //$pdf->Cell(35,10," ",0,0,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(25,10,utf8_decode("Code artice"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,10,utf8_decode(" Designation"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,10,utf8_decode("Quantité minimale"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,10,utf8_decode("Marque "),1,0,'C');
           
            while($retour = $resultatp->fetch())
            {           
                $c_codeproduit= $retour["ref_produit"];
                $designation = $retour["designation_produit"];
                $qutemin = $retour["qte_min"];
                $c_marque = $retour["marque"];
                      
                $pdf->Cell(95,10,"",0,1,'L');
                //$pdf->Cell(35,10," ",0,0,'R');
                $pdf->Cell(25,10,"$c_codeproduit",1,0,'R');
               // $pdf->Cell($pdf->GetStringWidth($c_codeproduit)+3, 10,$c_codeproduit, 1, 0, "C"); 
                $pdf->Cell(100,10,utf8_decode($designation),1,0,'C');
                //$pdf->Cell($pdf->GetStringWidth($designation)+3, 10, utf8_decode($designation), 1, 0, "L"); 
                $pdf->Cell(40,10,$qutemin,1,0,'R');
                //$pdf->Cell($pdf->GetStringWidth($qutemin)+3, 10, $qutemin, 1, 0, "C"); 
                $pdf->Cell(100,10, utf8_decode($c_marque), 1, 0, "C");
                //$pdf->Cell($pdf->GetStringWidth($c_marque)+3, 10, utf8_decode($c_marque), 1, 0, "L"); 
               //$pdf->SetFont('Arial','',9);
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportproduits/"."Tous_les_produits"." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();         
        break; 
       
        case "pardesignation": 
            //$designation = $_GET['parametre'];
            $c_codeproduit=""; $designation=""; $qutemin=""; $c_marque=""; $compteur=0; 
            $designation = $_GET['parametre'];     
            $requete="SELECT * FROM produits WHERE designation_produit LIKE '%$designation%'";
            $resultatp=$pdo->query($requete);
        
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
            $pdf->Image("../images/".$logo,null,null,30,30); 
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
            $pdf->Cell(100,30,utf8_decode("Information sur le produit:"." ".$designation),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            //$pdf->Cell(35,10," ",0,0,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(25,10,utf8_decode("Code artice"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,10,utf8_decode(" Designation"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,10,utf8_decode("Quantité minimale"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,10,utf8_decode("Marque "),1,0,'C');
                      
            while($retour = $resultatp->fetch())
            {           
                $c_codeproduit= $retour["ref_produit"];
                $designation = $retour["designation_produit"];
                $qutemin = $retour["qte_min"];
                $c_marque = $retour["marque"];
                      
                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(25,10,"$c_codeproduit",1,0,'R');
                $pdf->Cell(100,10,utf8_decode($designation),1,0,'C');
                $pdf->Cell(40,10,$qutemin,1,0,'R');
                $pdf->Cell(100,10,utf8_decode($c_marque),1,0,'C');
                                       
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportproduits/".$designation." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output(); 
        break; 
       
    }
}
?>
