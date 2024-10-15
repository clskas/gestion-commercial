<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_GET['infoclient']) && $_GET['infoclient']!="")
{
    switch($_GET["infoclient"])
    {
        case "tous": 
            $Client_civilite=""; $Client_nom=""; $Client_prenom=""; $telephone=""; 
            $reseausocial=""; $email=""; $adresse="";$compteur=0;      
            $requete= "SELECT * FROM clients";
            $resultate=$pdo->query($requete);
        
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
            $pdf->Cell(100,30,utf8_decode("Liste de tous les clients"),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,10,utf8_decode("Noms clients"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode(" Téléphone"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(60,10,utf8_decode("Reseaux sociaux"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,10,utf8_decode("Email "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode("Adresse "),1,0,'C');
            
            while($retour = $resultate->fetch())
            {     
                $c_civilite= $retour["Client_civilite"];      
                $c_nom = $retour["Client_nom"];
                $c_prenom = $retour["Client_prenom"];
                $c_telephone = $retour["telephone"];
                $c_reseausocio = $retour["reseausocial"];
                $email = $retour["email"];
                $adresse = $retour["adresse"];
               
                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(80,10,utf8_decode( "$c_civilite".' '."$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(30,10,$c_telephone,1,0,'C');
                $pdf->Cell(60,10,utf8_decode($c_reseausocio),1,0,'C');
                $pdf->Cell(40,10,utf8_decode($email),1,0,'C');
                $pdf->Cell(70,10,utf8_decode($adresse),1,0,'C');
                           
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportclients/"."Tous_les_clients"." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();         
        break; 
       
        case "parnom": 
            $Client_civilite=""; $Client_nom=""; $Client_prenom=""; $telephone=""; 
            $reseausocial=""; $email=""; $adresse="";$compteur=0;  
            $lesclients = $_GET['parametre'];     
            $requete= "SELECT * FROM clients WHERE Client_nom LIKE '%$lesclients%' OR Client_prenom LIKE '%$lesclients%'";
            $resultate=$pdo->query($requete);
        
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
            $pdf->Cell(100,30,utf8_decode("Information sur "." ". $lesclients),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,10,utf8_decode("Noms clients"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,utf8_decode(" Téléphone"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(60,10,utf8_decode("Reseaux sociaux"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,10,utf8_decode("Email "),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode("Adresse "),1,0,'C');
          
            while($retour = $resultate->fetch())
            {     
                $c_civilite= $retour["Client_civilite"];      
                $c_nom = $retour["Client_nom"];
                $c_prenom = $retour["Client_prenom"];
                $c_telephone = $retour["telephone"];
                $c_reseausocio = $retour["reseausocial"];
                $email = $retour["email"];
                $adresse = $retour["adresse"];
               
                $pdf->Cell(95,10,"",0,1,'L');
                $pdf->Cell(80,10,utf8_decode( "$c_civilite".' '."$c_nom".' '."$c_prenom"),1,0,'C');
                $pdf->Cell(30,10,$c_telephone,1,0,'C');
                $pdf->Cell(60,10,utf8_decode($c_reseausocio),1,0,'C');
                $pdf->Cell(40,10,utf8_decode($email),1,0,'C');
                $pdf->Cell(70,10,utf8_decode($adresse),1,0,'C');
                                         
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportclients/".$lesclients." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output(); 
        break; 
       
    }
}
?>
