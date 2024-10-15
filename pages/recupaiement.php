<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_GET['inforecu']) && $_GET['inforecu']!="")
{
    $tab_param = explode("-", $_GET['inforecu']);
    $num_cli = $tab_param[0];
    $num_paiement = $tab_param[1];
    $com_numero =  $tab_param[2];
    $lasommede = $_GET['parametre'];
    $c_civ=""; $c_nom=""; $c_pre=""; $c_date=""; $c_tot=""; $c_ref="";$c_des="";
    $c_qte= ""; $c_pht=0; $c_mht=0; $compteur=0;

    $requete = "SELECT * FROM clients a, commandes b, paiement p WHERE a.Client_num=".$num_cli." AND b.Com_num=".$com_numero." AND p.id_paiement=".$num_paiement.";";
    $retours=$pdo->query($requete);

    $retour = $retours->fetch();
    $c_civ = $retour["Client_civilite"];
    $c_nom = $retour["Client_nom"];
    $c_pre = $retour["Client_prenom"];
    $adresse = $retour["adresse"];
    $telephoneclient = $retour["telephone"];
    $c_montantpaye= $retour["montant_paye"];
    $c_monnaie= $retour["monnaie"];
    $c_date= $retour["date_paiement"];

    $requeteentreprise = "SELECT * FROM entreprise";
    $retoursentreprise = $pdo->query($requeteentreprise);
    $entreprise = $retoursentreprise->fetch();
    $nomentreprise = $entreprise["nom_entreprise"];
    $adresseentreprise = $entreprise["adresse"];
    $idnationale = $entreprise["identite_nationale"];
    $telephone = $entreprise["Telephone"];
    $logo = $entreprise["logo"];
    require ("../fpdf/fpdf.php");

    $pdf = new FPDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','',9);
    $pdf->Image("../images/".$logo,null,null,15,15); 
    $pdf->Cell(35,5,"",0,1,'R');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(120,5,utf8_decode($nomentreprise ),0,1,'L');           
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(120,5,utf8_decode($adresseentreprise),0,1,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(120,5,"ID Nationale".$idnationale,0,0,'L');
    $pdf->Cell(9,5,"",0,1,'R');
    $pdf->Cell(120,5,utf8_decode("Numero téléphone : ").$telephone,0,0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(60,5,"Date paiement : ".date("d/m/y",strtotime($c_date)),0,1,'L');
    $pdf->Cell(35,5,"",0,1,'R');
    $pdf->Cell(120,5,utf8_decode("Reçu numero : ").$num_paiement ,0,0,'L');
    $pdf->Cell(100,5,utf8_decode("Montant payé: ").$c_montantpaye.' '.$c_monnaie ,0,1,'L');
    $pdf->Cell(35,3,"",0,1,'R');
    $pdf->Cell(60,5,utf8_decode("Reçu de : ".$c_civ." ".$c_pre." ".$c_nom),0,1,'L');
    $pdf->Cell(35,5,"",0,1,'R');
    $pdf->Cell(50,5,utf8_decode($lasommede),0,1,'L');
   
    $pdf->SetFont('Arial','BI',9);
    $pdf->Cell(180,30,utf8_decode("Signature................................................."),0,1,'C');

    $pdf->SetFont('Arial','U',10);
    $restant = 90 - $compteur*10;
    $pdf->Cell(35,$restant,"",0,1,'R');
    $nom_fichier = "../recupaiements/".$num_cli."-".$num_paiement.".pdf";
    $pdf->Output($nom_fichier,'F');
    $pdf->Output();
}
?>
