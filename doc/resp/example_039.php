<?php
require_once('../tcpdf/config/lang/eng.php');

require_once('../tcpdf/config/tcpdf_config_alt.php');
define("K_TCPDF_EXTERNAL_CONFIG", true);

require_once('../tcpdf/tcpdf.php');

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$PDF_PAGE_FORMAT='LTR';
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', false, 'ISO-8859-1', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MUNICIPALIDAD DE ARICA - DOM');
$pdf->SetTitle('Certificados');
$pdf->SetSubject('Certificados');
$pdf->SetKeywords('DOM - Urbanismo');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$aver = "chupalo rico";
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//$pdf->setFooterFont(Array($aver, '', PDF_FONT_SIZE_DATA));

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 40, 40);
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

// ---------------------------------------------------------

// create some HTML content

$titulo = '<span style="text-align:center;">CERTIFICADO DE NUMERO</span>';

$html = '<span style="text-align:justify;"> En cumplimiento a lo dispuesto en decreto Nr. 5090 del 29 de octubre de 2008 de la Ilustre
 Municipalidad de Arica y en la ley Nr 18.695 Org&aacute;nica constitucional de Municipalidades , el director
 de obras de la comuna de Arica, certifica que la propiedad ROL 123456-9 emplazada en AVENIDA Diego Portales
 tiene asignada la numeraci&oacute;n municipal  9876. Dentro de la Poblaci&oacute;n Arica. , manzana 20, SITIO 1 se
 encuentra emplazada en la comuna de ARICA. </span>';

$lin1 = 'FRANCISCO ZULETA GOMEZ<br>ARQUITECTO<br>DIRECTOR DE OBRAS DOM ARICA';

$pie = 'Nr. Giro: 145875844 , Orden Municipal 1596321125 , Fecha : 26/04/2010';

// set core font
$pdf->SetFont('helvetica', '', 16);

// add a page
$pdf->AddPage();

// output the HTML content
$pdf->writeHTML($titulo, true, 0, true, true);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('helvetica', '', 16);
$pdf->writeHTML($html, true, 0, true, true);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->MultiCell(100, 0, 'FRANCISCO ZULETA GOMEZ'."\n", 0, 'C', 0, 1, '', '', true, 0);
$pdf->MultiCell(100, 0, 'ARQUITECTO'."\n", 0, 'C', 0, 1, '', '', true, 0);
$pdf->MultiCell(100, 0, 'DIRECTOR DE OBRAS DOM ARICA'."\n", 0, 'C', 0, 1, '', '', true, 0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($pie, true, 0, true, true);

$pdf->lastPage();

//Close and output PDF document
$pdf->Output('certificado.pdf', 'I');

//============================================================+
// END OF FILE                                                 
//============================================================+
?>