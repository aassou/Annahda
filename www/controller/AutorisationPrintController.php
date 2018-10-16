<?php

// Include the main TCPDF library (search for installation path).
//classes loading begin
    function classLoad ($myClass) {
        if(file_exists('../model/'.$myClass.'.php')){
            include('../model/'.$myClass.'.php');
        }
        elseif(file_exists('../controller/'.$myClass.'.php')){
            include('../controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('../config/config.php');
    include('../lib/image-processing.php');
    require_once('../lib/tcpdf/tcpdf.php');
    //classes loading end
    session_start();
    
    //classes managers
    $contratManager = new ContratManager($pdo);
    $companyManager = new CompanyManager($pdo);
    $clientManager = new ClientManager($pdo);
    $projetManager = new ProjetManager($pdo);
    $reglementsPrevu = new ReglementPrevu($pdo);
    $contratCasLibre = new ContratCasLibre($pdo);
    //classes
    $idContrat = $_POST['idContrat'];
    $compteur = $_POST['compteur'];
    $contrat = $contratManager->getContratById($idContrat);
    $client = $clientManager->getClientById($contrat->idClient());
    $projet = $projetManager->getProjetById($contrat->idProjet());

    $titreProjet = $projet->titre();
    $contratTitle = "اذن المالك";
    $bien = "";
    $typeBien = "";
    $bienNumero = "";
    $cave = "";
    $etage = "";
    if ( $contrat->typeBien() == "appartement" ) {
        $appartementManager = new AppartementManager($pdo);
        $bien = $appartementManager->getAppartementById($contrat->idBien());
        $typeBien = "للشقة التي يشغلها ";
        $bienNumero = "شقة رقم ";
        if ( $bien->cave() == "Avec" ) {
            $cave = "بالمرأب";
        }
        else if ( $bien->cave() =="Sans" ) {
            $cave = "بدون مرأب";
        }
        $etage = 'الطابق '.$bien->niveau();        
    }
    else if ( $contrat->typeBien() == "localCommercial" ) {
        $locauxManager = new LocauxManager($pdo);
        $bien = $locauxManager->getLocauxById($contrat->idBien());
        $typeBien = "للمحل التجاري الذي يشغله ";
        $etage = "الطابق الأرضي";
        $bienNumero = "محل رقم ";
    }
    $superficie = $bien->superficie();
    $numero = $bien->nom();
    $facade = $contrat->facadeArabe();
    $etatBien = "";
    if ( $contrat->etatBienArabe() == "GrosOeuvre" ) {
        $etatBien = "الأشغال الأساسية للبناء";    
    } 
    else if ( $contrat->etatBienArabe() == "Finition" ) {
        $etatBien = "الأشغال النهائية للبناء";
    }
    $contratReference = "";
    if ( strlen($contrat->reference()) > 1 ) {
        $contratReference = "رقم العقد : ".$contrat->reference().'-'.$contrat->id();   
    }
    $avanceLettresArabe = $contrat->avanceArabe();
    $prixLettresArabe = $contrat->prixVenteArabe();
    $idSociete = $contrat->societeArabe();
    $company = $companyManager->getCompanyById($idSociete);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);
//$pdf->SetHeaderData(false, false, false, false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//$pdf->setHeaderMargin(0);
// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';

// set some language-dependent strings (optional)
$pdf->setLanguageArray($lg);

// ---------------------------------------------------------

// set font
//$pdf->SetFont('dejavusans', '', 12);

// add a page
$pdf->AddPage();

// Restore RTL direction
$pdf->setRTL(true);

// set font
$pdf->SetFont('aealarabiya', '', 18);

// print newline
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0, 12, $contratTitle,0,1,'C');
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 14);
$htmlcontent = 'أنا الموقع أسفله السيد ربيع الماحي بصفتي مسير شركة '.$company->nomArabe().':';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$pdf->Ln();
$htmlcontent = 'اذن '.' للسيد(ة) ،'.$client->nomArabe().' أن يمضي على وثيقة الاشتراك للتزويد ب'.$compteur.' '.$typeBien.' بالعمارة السكنية ذات التحفيظ العقاري عدد '.$titreProjet.' '.$etage.' الكائنة ب'.$projet->adresseArabe().' الناظور الجديد. '.$bienNumero.' '.$numero.'.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
//Contrat Footer:
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 16);
$htmlcontent = '<strong>'.'الناظور في '.'</strong>'.date('d/m/Y', strtotime($contrat->dateCreation()));
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 16);
$htmlcontent = '<strong style="text-align:center">'.'توقيع المالك '.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$htmlcontent = '<hr/>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
//$pdf->Ln();
// ---------------------------------------------------------
// set font
$pdf->SetFont('aealarabiya', '', 18);

// print newline
$pdf->Ln();
$pdf->Cell(0, 12, $contratTitle,0,1,'C');
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 14);
$htmlcontent = 'أنا الموقع أسفله السيد ربيع الماحي بصفتي مسير شركة '.$company->nomArabe().':';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$pdf->Ln();
$htmlcontent = 'اذن '.' للسيد(ة) ،'.$client->nomArabe().' أن يمضي على وثيقة الاشتراك للتزويد ب'.$compteur.' '.$typeBien.' بالعمارة السكنية ذات التحفيظ العقاري عدد '.$titreProjet.' '.$etage.' الكائنة ب'.$projet->adresseArabe().' الناظور الجديد. '.$bienNumero.' '.$numero.'.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
//Contrat Footer:
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 16);
$htmlcontent = '<strong>'.'الناظور في '.'</strong>'.date('d/m/Y', strtotime($contrat->dateCreation()));
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 16);
$htmlcontent = '<strong style="text-align:center">'.'توقيع المالك '.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
//Close and output PDF document
$pdf->Output('Autorisation.pdf', 'I');
// END OF FILE
//============================================================+