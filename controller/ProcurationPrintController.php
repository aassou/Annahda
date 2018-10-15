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
    include("../config/config.php");
    include('../lib/image-processing.php');
    require_once('../lib/tcpdf/tcpdf.php');
    //classes loading end
    session_start();
    
    //classes managers
    $contratManager = new ContratManager($pdo);
    $companyManager = new CompanyManager($pdo);
    $clientManager  = new ClientManager($pdo);
    $projetManager  = new ProjetManager($pdo);
    //objects
    $idContrat = $_GET['idContrat'];
    $contrat   = $contratManager->getContratById($idContrat);
    $client    = $clientManager->getClientById($contrat->idClient());
    $projet    = $projetManager->getProjetById($contrat->idProjet());
    //vars
    $contratTitle = "وكالة خاصة";
    $titreProjet  = $projet->titre();
    $numberProjet = str_replace(array('ANNAHDA', 'Annahda', 'annahda'), '', $projet->nom());
    $bien         = "";
    $typeBien     = "";
    $cave         = "";
    $etage        = "";
    $articleReservation = "";
    $articleRevente = "";
    if ( $contrat->typeBien() == "appartement" ) {
        $appartementManager = new AppartementManager($pdo);
        $bien = $appartementManager->getAppartementById($contrat->idBien());
        $typeBien = "شقة";
        if ( $bien->cave() == "Avec" ) {
            $cave = "بالمرأب";
        }
        else if ( $bien->cave() =="Sans" ) {
            $cave = "بدون مرأب";
        }
        $etage = $bien->niveau();        
        $articleReservation = "التي سبق لي أن حجزتها من اجل الاستفادة  في المشروع السكني المسمى : النهضة ".$numberProjet." التابع لملكية الشركة المذكورة أعلاه .";
        $articleRevente = "و اوافق للشركة المذكورة أعلاه أن تتصرف في الشقة التي سبق أن حفظت حقي في شرائها.";
    }
    else if ( $contrat->typeBien() == "localCommercial" ) {
        $locauxManager = new LocauxManager($pdo);
        $bien = $locauxManager->getLocauxById($contrat->idBien());
        $typeBien = "محل تجاري";
        $etage = "الطابق الأرضي";
        $articleReservation = "الذي سبق لي أن حجزته من اجل الاستفادة  في المشروع السكني المسمى : النهضة ".$numberProjet." التابع لملكية الشركة المذكورة أعلاه .";
        $articleRevente = "و اوافق للشركة المذكورة أعلاه أن تتصرف في المحل التجاري الذي سبق أن حفظت حقي في شرائه.";
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

// add a page
$pdf->AddPage();
// Restore RTL direction
$pdf->setRTL(true);
// set font
$pdf->SetFont('aealarabiya', '', 24);
// print newline
$pdf->Ln();
$pdf->Cell(0, 12, $contratTitle,0,1,'C');
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 16);
$pdf->Ln();
//$htmlcontent = '<strong>'.'الطرف الثاني'.'</strong>';
//$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'أنا الموقع أسفله : السيد(ة) ،'.$client->nomArabe().' '.'المغربي (ة)، الراشد(ة) ، الحامل (ة)،  لرقم البطاقة الوطنية رقم'.$client->cin();
$htmlcontent .= '،  العنوان و الموطن المختار و المحدد هو,'.$client->adresseArabe().'.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = 'والسيد (ة): .............................. ، المولود (ة) بتاريخ .....................، الحامل (ة) لبطاقة التعريف الوطنية عدد: .............. ، والساكن (ة) ...................................';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '  نصرح و نحن في كامل قوانا العقلية و الجسدية، أننا نوكل بمقتضى هذه الوكالة <br>  السيد (ة): .................................. ، المولود (ة) بتاريخ..........................، الحامل (ة) لبطاقة التعريف الوطنية عدد : ..................... ، والساكن (ة) بشارع .......................';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '<br>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '  لينوب عنا ويقوم مقامنا في كل ما تجب فيه النيابة شرعا، و ذلك من أجل : <br>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '&nbsp;&nbsp;* تمثيلنا أمام السيد الموثق، و ذلك من أجل توقيع عقد الشراء وتوقيع الوعد بالبيع لل'.$typeBien.' الكائنة ب'.$projet->adresseArabe().'، ذات الرسم العقاري عدد '.$bien->titre().' .';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '<br>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '&nbsp;&nbsp;*  تمثيلنا أمام جميع الإدارات و المؤسسات عمومية كانت أم خصوصية،  خاصة إدارة التسجيل و التنبر،الوكالة الوطنية للمحافظة العقارية بالناظور، إدارة  الضرائب  و مكتب الهندسة الطبوغرافية بلدية الناظور، و المكتب الوطني للماء و الكهرباء وذالك من أجل الحصول على جميع الوثائق و الشهادات  التي تستلزمها عملية الشراء ، و كذا القيام بجميع الإجراءات القانونية المواكبة لعقد الشراء.
      -  توقيع الوعد بالبيع أو كل عقد ابتدائي، و كذا فسخه .';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '<br>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '&nbsp;&nbsp;* توقيع و سـحب جميع الوثائق و العقود المتعلقة بالشراء من مكتب الموثق.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '<br><br>';
$htmlcontent = '&nbsp;&nbsp;* اداء ثمن الشراء.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '<br><br>';
$htmlcontent = '&nbsp;&nbsp;*  التعبير عن إرادتنا  في الموافقة على قبول جميع الشروط و البــنود ، و التحملات التي قد يتضمنها عقد الشراء  أو الوعد بالبيع.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '<br>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
//Contrat Footer:
$pdf->SetFont('aealarabiya', '', 16);
$htmlcontent = '<strong>'.'الناظور في '.'</strong>'.date('d/m/Y');
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '<strong style="text-align:left">'.'التوقيع '.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '<strong style="text-align:right">'.'التوقيع '.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

//$pdf->Ln();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('contrat.pdf', 'I');
// END OF FILE
//============================================================+