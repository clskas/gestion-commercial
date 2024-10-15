<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_GET['infodepense']) && $_GET['infodepense']!="")
{
    switch($_GET["infodepense"])
    {
        case "tous": 
            $motif=""; $montant=""; $datedepense="";$compteur=0;      
            $requete="SELECT * FROM depense ";               
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
            $pdf->Cell(100,30,utf8_decode("Liste de toutes les dépenses"),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(150,10,utf8_decode("Motif"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode(" Montant"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode("Date"),1,0,'C');           
            while($retour = $resultatp->fetch())    
            {     
                $motif= $retour["motif"];      
                $montant = $retour["montant"];
                $datedepense = $retour["date_depense"];
                $monnaie = $retour["monnaie"];              
                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(150,10,utf8_decode( "$motif"),1,0,'C');
                $pdf->Cell(50,10,$montant.' '. $monnaie,1,0,'R');
                $pdf->Cell(50,10,date("d/m/y",strtotime($datedepense)),1,0,'C');
            
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportdepenses/"."Toutes_les_depenses"." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();         
        break; 
        case "parmotif": 
            $motif=""; $montant=""; $datedepense="";$compteur=0;      
            $motif = $_GET['parametre'];     
            $requete="SELECT * FROM depense WHERE motif LIKE '%$motif%'";
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
            $pdf->Cell(100,30,utf8_decode("Motif de dépense"),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(150,10,utf8_decode("Motif"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode(" Montant"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode("Date"),1,0,'C');           
            while($retour = $resultatp->fetch())    
            {     
                $motif= $retour["motif"];      
                $montant = $retour["montant"];
                $datedepense = $retour["date_depense"];
                $monnaie = $retour["monnaie"];    
                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(150,10,utf8_decode( "$motif"),1,0,'C');
                $pdf->Cell(50,10,$montant.' '. $monnaie,1,0,'R');
                $pdf->Cell(50,10,date("d/m/y",strtotime($datedepense)),1,0,'C');                       
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportdepenses/".$motif." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();  
        break; 
       
        case "pardate": 
            $motif=""; $montant=""; $datedepense="";$compteur=0;      
            $datedepense = $_GET['parametre'];     
            $requete="SELECT * FROM depense WHERE date_depense = '$datedepense'"; 
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
            $pdf->Cell(100,30,utf8_decode("Dépenses du ".date("d/m/y",strtotime($datedepense))),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(150,10,utf8_decode("Motif"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode(" Montant"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode("Date"),1,0,'C');           
            while($retour = $resultatp->fetch())    
            {     
                $motif= $retour["motif"];      
                $montant = $retour["montant"];
                $datedepense = $retour["date_depense"];
                $monnaie = $retour["monnaie"];    
                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(150,10,utf8_decode( "$motif"),1,0,'C');
                $pdf->Cell(50,10,$montant.' '. $monnaie,1,0,'R');
                $pdf->Cell(50,10,date("d/m/y",strtotime($datedepense)),1,0,'C');                       
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportdepenses/".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();  
        break; 
        case "datedebut": 
            $motif=""; $montant=""; $datedepense="";$compteur=0;      
            $datedebut = $_GET['datedbt'];
            $datefin = $_GET['datefin'];    
            $requete="SELECT * FROM depense WHERE date_depense BETWEEN '$datedebut' AND '$datefin'";
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
            $pdf->Cell(100,30,utf8_decode("Dépenses du ".date("d/m/y",strtotime($datedebut))." "."au"." ".date("d/m/y",strtotime($datefin))),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(150,10,utf8_decode("Motif"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode(" Montant"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode("Date"),1,0,'C');           
            while($retour = $resultatp->fetch())    
            {     
                $motif= $retour["motif"];      
                $montant = $retour["montant"];
                $datedepense = $retour["date_depense"];
                $monnaie = $retour["monnaie"];
     
                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(150,10,utf8_decode( "$motif"),1,0,'C');
                $pdf->Cell(50,10,$montant.' '. $monnaie,1,0,'R');
                $pdf->Cell(50,10,date("d/m/y",strtotime($datedepense)),1,0,'C');
                             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportdepenses/".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();  
        break; 
       
    }
}
?>
