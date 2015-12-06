<?php

// Include the main TCPDF library (search for installation path).
require_once('lib/tcpdf/tcpdf.php');
require_once('model/Client.php');
require_once('model/ClientManager.php');
require_once('config.php');
$clientManager = new ClientManager($pdo);
$client = $clientManager->getClientById(312);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 018');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
$pdf->SetFont('dejavusans', '', 12);

// add a page
$pdf->AddPage();

// Persian and English content
//$htmlpersian = '<span color="#660000">Persian example:</span><br />سلام بالاخره مشکل PDF فارسی به طور کامل حل شد. اینم یک نمونش.<br />مشکل حرف \"ژ\" در بعضی کلمات مانند کلمه ویژه نیز بر طرف شد.<br />نگارش حروف لام و الف پشت سر هم نیز تصحیح شد.<br />با تشکر از  "Asuni Nicola" و محمد علی گل کار برای پشتیبانی زبان فارسی.';
//$pdf->WriteHTML($htmlpersian, true, 0, true, 0);

// set LTR direction for english translation
//$pdf->setRTL(false);

//$pdf->SetFontSize(10);

// print newline
//$pdf->Ln();

// Persian and English content
//$htmlpersiantranslation = '<span color="#0000ff">Hi, At last Problem of Persian PDF Solved completely. This is a example for it.<br />Problem of "jeh" letter in some word like "ویژه" (=special) fix too.<br />The joining of laa and alf letter fix now.<br />Special thanks to "Nicola Asuni" and "Mohamad Ali Golkar" for Persian support.</span>';
//$pdf->WriteHTML($htmlpersiantranslation, true, 0, true, 0);

// Restore RTL direction
$pdf->setRTL(true);

// set font
$pdf->SetFont('aealarabiya', '', 18);

// print newline
$pdf->Ln();

// Arabic and English content
$pdf->Cell(0, 12, 'عقد حفظ الحق في ملكية شقة',0,1,'C');
$pdf->SetFont('dejavusans', '', 14);
$pdf->Ln();
//$htmlcontent = '<strong>'.'الطرف الثاني'.'</strong>';
//$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '<strong>'.'الطرف الأول'.'</strong>'.' : مجموعة النهضة للاعمار ش .م .م.، في شخص ممثلها القانوني, و الكائن مقرها الاجتماعي ب 313 حي أولاد ابراهيم ميزانين رقم -ب-1 الناظور.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.'الطرف الثاني'.'</strong>'.': السيد(ة) ،'.$client->nomArabe().' '.'المغربي (ة)، الراشد(ة)، ، الحامل (ة)،  لرقم البطاقة الوطنية رقم'.$client->cin().' '.'،  العنوان و الموطن المختار و المحدد هو,';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->SetFont('aealarabiya', '', 18);
$pdf->Cell(0, 12, 'نص العقد',0,1,'C');
$pdf->SetFont('aealarabiya', '', 12);
//Contenu du contrat
//Acte 1:
$htmlcontent = '<strong style="text-decoration: underline">'.'البند الأول:'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يقر الطرفان بأهليتهما للتعاقد و التصرف القانوني طبقا لقواعد حسن النية و التراض وبدون قهر ولا غبن.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
//Acte 2:
$htmlcontent = '<strong style="text-decoration: underline">'.'البند الثاني:'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'اتفق الطرفان على أن هدا العقد ليس عقد بيع ابتدائي، وغير ناقل لملكية الوحدة العقارية إلا بعد سداد كامل الثمن إلى الطرف الأول و إبرام
العقد النهائي وفق الشروط و الشكليات المحددة في القانون.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
//Acte 3:
$htmlcontent = '<strong style="text-decoration: underline">'.'البند الثالث:'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يقر الطرف الأول انه يحفظ حق الطرف الثاني في شراء شقة  و مراب للسيارة.في مشروعه السكني المسمى ب النهضة ...... الكائن بإقليم
الناظور  المطار وفق المواصفات الآتية:';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
//Acte 3 : Details
    //Detail 1:
    $pdf->Ln();
    $superficie = 90;
    $htmlcontent = '<div style="margin-right:100px; margin-left:100px;">';
    $htmlcontent .= '1. مساحة الشقة : المساحة الهندسية المبنية بالتقريب '.$superficie.' متر مربع،. و المساحة المحفظة، سيتم الحصول عليها من طرف إدارة
    المحافظة العقارية عند الحصول على التحفيظ العقاري للشقة.';
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    //Detail 2:
    $etage = 3;
    $htmlcontent = '2. الطابق : '.$etage;
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    //Detail 3:
    $rue = 80;
    $htmlcontent = '3. الواجهة : الشقة ذات واجهة واحدة تطل على شارع '.$rue.'  متر ';
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    //Detail 3:
    $numero = 3;
    $htmlcontent = '4. الرقم : رقم الشقة '.$numero;
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    //Detail 4:
    $htmlcontent = '5.وضعية الشقة وفق الاتفاق  : تسليم الشقة في وضعية الأشغال النهائية  للبناء. أو الاساسية للبناء';
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    //Detail 5:
    $htmlcontent = '6.الرسم العقاري الأم : ';
    $htmlcontent .= '</div>';
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 4:
$htmlcontent = '<strong style="text-decoration: underline">'.'البند الرابع:'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يؤدي الطرف الثاني للطرف الأول من أجل حفظ حقه في ملكية الشقة موضوع العقد مبلغ تسبيق حدد بالتراضي في .....................................درهم   (................................ درهم) ، مقابل توصيل مفصل كوسيلة وحيدة لإثبات الأداء، وذلك في أجل لا يتعدى خمسة ايام ابتدءا من تاريخ توقيع هذا العقد..';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
// set LTR direction for english translation
$pdf->setRTL(false);

// print newline
$pdf->Ln();

$pdf->SetFont('aealarabiya', '', 18);

// Arabic and English content
//$htmlcontent2 = '<span color="#0000ff">This is Arabic "العربية" Example With TCPDF.</span>';
//$pdf->WriteHTML($htmlcontent2, true, 0, true, 0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_018.pdf', 'I');

//5.4. الرقم : رقم الشقة وضعية الشقة وفق الاتفاق  : تسليم الشقة في وضعية الأشغال النهائية  للبناء. أو الاساسية للبناء
//4. الرقم : رقم الشقة 
//============================================================+
// END OF FILE
//============================================================+