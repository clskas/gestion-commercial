<?php
require_once('identifier.php');
require_once('connexiondb.php');

if(isset($_GET['info']) && $_GET['info']!="")
{
    $tab_param = explode("-", $_GET['info']);
    $num_cli = $tab_param[0];
    $num_com = $tab_param[1];

    $c_civ=""; $c_nom=""; $c_pre=""; $c_date=""; $c_tot=""; $c_ref="";$c_des="";
    $c_qte= ""; $c_pht=0; $c_mht=0; $compteur=0;

    $requete = "SELECT * FROM clients a, commandes b, detail c WHERE a.Client_num=".$num_cli." AND b.Com_num=".$num_com." AND c.Detail_com=".$num_com.";";
    $retours=$pdo->query($requete);

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
    while($retour = $retours->fetch())
    {
        if($c_civ=="")
        {
            $c_civ = $retour["Client_civilite"];
            $c_nom = $retour["Client_nom"];
            $c_pre = $retour["Client_prenom"];
            $adresse = $retour["adresse"];
            $telephoneclient = $retour["telephone"];
            $c_monnaie= $retour["com_monnaie"];
            $c_unitevente= $retour["unitevent"];
            $c_date= $retour["Com_date"];
            $c_tot = $retour["Com_montant"];
            $pdf->Image("../images/".$logo,null,null,20,20); 
            $pdf->Cell(35,2,"",0,1,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(120,5,utf8_decode($nomentreprise ),0,1,'L');           
            
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(120,5,utf8_decode($adresseentreprise),0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(60,5,"Date de commande : ".date("d/m/y",strtotime($c_date)),0,1,'R');
           
            //$pdf->Cell(60,5,"",0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(109,5,"ID Nationale".$idnationale,0,0,'L');
            //$pdf->Cell(35,10,"",0,0,'R'); //date("d/m/y",strtotime($depenses['date_depense']))
            $pdf->Cell(60,5,utf8_decode("Numero facture : ").$num_com,0,1,'R');
            
            $pdf->Cell(35,5,"",0,1,'R');
            $pdf->Cell(60,5,$c_civ." ".$c_pre." ".$c_nom,0,1,'L');
            $pdf->Cell(35,3,"",0,1,'R');
            //$pdf->Cell(20,10," ",0,0,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,10,utf8_decode("Référence"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,10,utf8_decode("Désignation"),1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,"Qte",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,"PU",1,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,"PT",1,1,'C');
            $pdf->SetFont('Arial','',9);
        }

        $requetelibelle = "SELECT * FROM unite_mesure WHERE libelle='".$retour["unitevent"]."';";
        $reponselibelle = $pdo->query($requetelibelle);
        $resultatlibelle = $reponselibelle->fetch();
        
        $c_libelle=$resultatlibelle["libelle"];

        $requete = "SELECT * FROM articles WHERE Article_code='".$retour["Detail_ref"]."';";
        $reponses = $pdo->query($requete);
        $reponse = $reponses->fetch();
        
        $c_ref=$reponse["Article_code"];
        $c_des=$reponse["Article_designation"];
        $c_qte=$retour["Detail_qte"];
        $c_pht=number_format($retour["puht"],4,',',' ');
        $c_mht=number_format($retour["Detail_qte"]*$retour["puht"],4,',',' ');
        $pdf->Cell(35,0,"",0,1,'R');

       // $pdf->Cell(20,10," ",0,0,'L');
        $pdf->Cell(20,10,"$c_ref",1,0,'R');
        $pdf->Cell(70,10,utf8_decode("$c_des"),1,0,'C');
        $pdf->Cell(30,10,utf8_decode($c_qte.' '.$c_libelle),1,0,'R');
        $pdf->Cell(30,10,"$c_pht.$c_monnaie",1,0,'R');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(30,10,"$c_mht.$c_monnaie",1,1,'R');
        $pdf->SetFont('Arial','',9);
        $compteur++;
    }
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(35,10,"",0,1,'R');
    $pdf->Cell(120,10,"Montant total HT :",0,0,'R');
    $pdf->Cell(30,10,"",0,0,'L');
    $pdf->Cell(30,10,number_format($c_tot,4,',',' ').$c_monnaie,1,1,'R');
    /*$pdf->Cell(120,10,"TVA : ".$tvaentreprise."%",0,0,'R');
    $pdf->Cell(30,10,"",0,0,'L');
    $pdf->Cell(30,10,number_format($tva,2,',',' '),1,1,'R');
    $pdf->Cell(120,10,"Montant total TTC",0,0,'R');
    $pdf->Cell(30,10,"",0,0,'L');
    $pdf->Cell(30,10,number_format($c_tot+$tva,4,',',' '),1,1,'R');
    $pdf->Cell(35,10,"",0,1,'R');*/

    $pdf->SetFont('Arial','I',9);
    $pdf->Cell(180,10,utf8_decode("Les marchandises vendues ne sont ni remises ni échangées"),0,1,'L');
    $pdf->SetFont('Arial','BI',9);
    $pdf->Cell(120,10,utf8_decode("Signature :......................................................................."),0,1,'R');

    $pdf->SetFont('Arial','U',10);
    $restant = 90 - $compteur*10;
    $pdf->Cell(35,$restant,"",0,1,'R');
    $nom_fichier = "../factures/".$num_cli."-".$num_com.".pdf";
    $pdf->Output($nom_fichier,'F');
    $pdf->Output();
}
?>
