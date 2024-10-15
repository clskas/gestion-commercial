<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_GET['infouser']) && $_GET['infouser']!="")
{
    switch($_GET["infouser"])
    {
        case "tous": 
            $logins=""; $email=""; $roles="";$psword=""; $compteur=0;      
            $requeteUser= "SELECT * FROM utilisateur";
            $resultatuser=$pdo->query($requeteUser);
        
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
            $pdf->Cell(100,30,utf8_decode("Liste de tous les utilisateurs "),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            //$pdf->Cell(35,10," ",0,0,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,10,utf8_decode("Utilisatteur"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode(" Email"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(22,10,utf8_decode("Mot de passe"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(35,10,utf8_decode("Role"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,10,utf8_decode("Telephone"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,10,utf8_decode("Reseaux sociaux"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode("Adresse"),1,0,'C');
                   
            while($retour = $resultatuser->fetch())
            {           
                $logins= $retour["logins"];
                $email = $retour["email"];
                $roles = $retour["roles"];
                $psword = $retour["pwd"];
                $teleph = $retour["usertelephone"];
                $rezosocio = $retour["userreseausocio"];  
                $adres = $retour["useradresse"];
                $pdf->Cell(95,10,"",0,1,'L');
                //$pdf->Cell(35,10," ",0,0,'R');
                $pdf->Cell(40,10,utf8_decode($logins),1,0,'C');
               // $pdf->Cell($pdf->GetStringWidth($c_codeproduit)+3, 10,$c_codeproduit, 1, 0, "C"); 
                $pdf->Cell(50,10,utf8_decode($email),1,0,'C');
                $pdf->Cell(22,10,utf8_decode($psword),1,0,'C');
                //$pdf->Cell($pdf->GetStringWidth($designation)+3, 10, utf8_decode($designation), 1, 0, "L"); 
                $pdf->Cell(35,10,utf8_decode($roles),1,0,'C');
                $pdf->Cell(40,10,utf8_decode($teleph),1,0,'C');
                $pdf->Cell(40,10,utf8_decode($rezosocio),1,0,'C');
                $pdf->Cell(50,10,utf8_decode($adres),1,0,'C');
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportutilisateurs/"."Tous_les_utilisateurs"." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();         
        break; 
       
        case "parlogin": 
            //$designation = $_GET['parametre'];
            $logins=""; $email=""; $roles=""; $compteur=0;      
            $logins = $_GET['parametre'];     
            $requeteUser= "SELECT * FROM utilisateur WHERE logins LIKE '%$logins%'";
            $resultatuser=$pdo->query($requeteUser);
        
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
            $pdf->Cell(100,30,utf8_decode("Information relative à l'utilisateur ".$logins),0,0,'C');               
            $pdf->Cell(95,25,"",0,1,'L');
            //$pdf->Cell(35,10," ",0,0,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,10,utf8_decode("Utilisatteur"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode(" Email"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(22,10,utf8_decode("Mot de passe"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(35,10,utf8_decode("Role"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,10,utf8_decode("Telephone"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,10,utf8_decode("Reseaux sociaux"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,10,utf8_decode("Adresse"),1,0,'C');
                   
            while($retour = $resultatuser->fetch())
            {           
                $logins= $retour["logins"];
                $email = $retour["email"];
                $roles = $retour["roles"];
                $psword = $retour["pwd"];
                $teleph = $retour["usertelephone"];
                $rezosocio = $retour["userreseausocio"];  
                $adres = $retour["useradresse"];
                $pdf->Cell(95,10,"",0,1,'L');
                //$pdf->Cell(35,10," ",0,0,'R');
                $pdf->Cell(40,10,utf8_decode($logins),1,0,'C');
               // $pdf->Cell($pdf->GetStringWidth($c_codeproduit)+3, 10,$c_codeproduit, 1, 0, "C"); 
                $pdf->Cell(50,10,utf8_decode($email),1,0,'C');
                $pdf->Cell(22,10,utf8_decode($psword),1,0,'C');
                //$pdf->Cell($pdf->GetStringWidth($designation)+3, 10, utf8_decode($designation), 1, 0, "L"); 
                $pdf->Cell(35,10,utf8_decode($roles),1,0,'C');
                $pdf->Cell(40,10,utf8_decode($teleph),1,0,'C');
                $pdf->Cell(40,10,utf8_decode($rezosocio),1,0,'C');
                $pdf->Cell(50,10,utf8_decode($adres),1,0,'C');
               // $compteur++;             
            }
            $pdf->SetFont('Arial','U',10);
            $restant = 100 - $compteur*10;
            $pdf->Cell(35,$restant,"",0,1,'R');
            $datetime = date("Y-m-d H-i-s");
            $nom_fichier = "../rapportutilisateurs/".$logins." ".$datetime.".pdf";
            $pdf->Output($nom_fichier,'F');
            $pdf->Output();    
        break; 
       
    }
}
?>
