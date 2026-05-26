<?php
ob_start();
//include("../seguridadsimple.php");
include("../conexion.php");
include("../fechaclasss.php");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$link = conectarse();

$ok = $_POST['listo'] ?? '';
$ff = $_POST['foliox'] ?? '';

//*******************[ Busqueda de Directores para firma de documentos ]**********************
$qry = "SELECT * FROM directores where activo ='S'";
$res = mysql_query($qry);
$linea_fin1 = mysql_result($res, 0, "nombre");
$linea_fin2 = mysql_result($res, 0, "titulo");
$linea_fin3 = mysql_result($res, 0, "cargo");

include("grabaclass.php");
//echo $rfdx;
//echo $idx;
//echo $ff;

if (empty($ff) || empty($idx)) {
	echo "<h3>Error</h3><p>Faltan datos para generar el certificado (folio o propiedad).</p>";
	exit;
}

if ($ok == 'checkbox') {
	$link = conectarse();
	$sql = "UPDATE cert2009 SET estado = '3' where id = '$ff' ";
	$result2 = mysql_query($sql);
	mysql_close($link);
}

$idx = $_POST['codigo'] ?? '';
$rolx = $_POST['rol'] ?? '';
$direx = $_POST['dire'] ?? '';
$viax = $_POST['via'] ?? '';
$numx = $_POST['num'] ?? '';
$blockx = $_POST['block'] ?? '';
$deptox = $_POST['depto'] ?? '';
$sitiox = $_POST['sitio'] ?? '';
$manx = $_POST['man'] ?? '';
$pobx = $_POST['pob'] ?? '';
$refx = $_POST['referencia'] ?? '';
$zonax = $_POST['zona'] ?? '';
$urbax = $_POST['urba'] ?? '';
$tipox = $_POST['tipo'] ?? '';
$usox = $_POST['uso'] ?? '';
$expox = $_POST['expo'] ?? '';
$radiox = $_POST['radio'] ?? '';
$classx = $_POST['class'] ?? '';
$mtx = $_POST['mt'] ?? '';
$mtcx = $_POST['mtc'] ?? '';
$kx = $_POST['kardex'] ?? '';
$pcx = $_POST['pc'] ?? '';
$pcdx = $_POST['pcd'] ?? '';
$rfx = $_POST['rf'] ?? '';
$rfdx = $_POST['rfd'] ?? '';
$sitpatx = $_POST['sitpatente'] ?? '';
$obspatx = $_POST['obspat'] ?? '';
$numnx = $_POST['numnuevo'] ?? '';
$resto = '';



/* $pcx = $_POST["pc"] ?? '';
	 	     $pcdx = $_POST["pcd"] ?? '';
			 $rfx = $_POST["rf"] ?? '';
			 $rfdx = $_POST["rfd"] ?? '';
			  
 			 $sitpatx = $_POST["sitpatente"] ?? '';
			 $obspatx = $_POST["obspat"] ?? '';
			 $numnx = $_POST["numnuevo"] ?? '';*/


if ($sitpatx == 2) {
	$resto = 'Se informa que la propiedad antes mencionada : Cumple la normativa para obtenci&oacute;n de Patente Municipal 
  seg&uacute;n los antecedentes , Permiso de Construcci&oacute;n : ' . $pcx . ' de fecha ' . $pcdx . ' y Recepci&oacute;n Final: ' . $rfx . ' de fecha ' . $rfdx . ' ' . $obspatx .  '.';
}

if ($sitpatx == 1) {
	if ($rfx == '') {
		$resto = 'Se informa que la propiedad antes mencionada : No Cumple la normativa para obtenci&oacute;n de Patente Municipal 
  seg&uacute;n los antecedentes , Permiso de Construcci&oacute;n : ' . $pcx . ' de fecha ' . $pcdx . ', ' . $obspatx .  '.';
	} else {
		$resto = 'Se informa que la propiedad antes mencionada : No Cumple la normativa para obtenci&oacute;n de Patente Municipal 
  seg&uacute;n los antecedentes , Permiso de Construcci&oacute;n : ' . $pcx . ' de fecha ' . $pcdx . ' y Recepci&oacute;n Final: ' . $rfx . ' de fecha ' . $rfdx . ' ' . $obspatx .  '.';
	}
}

$link = Conectarse();
$qry = "SELECT * FROM cert2009 where id ='$ff'";
$res = mysql_query($qry);
$idusuario = mysql_result($res, 0, "responsable");
$fechag = mysql_result($res, 0, "giro_fecha");

$cod = $_POST['pob'] ?? '';
$link = Conectarse();
$qry = "SELECT * FROM pob where id ='$cod'";
$res = mysql_query($qry);
$pobed = mysql_result($res, 0, "nombre");

$roled = $_POST['rol'] ?? '';
$numed =  $_POST['num'] ?? '';
$viaed  = strtolower((string)($_POST['via'] ?? ''));
$direed = $_POST['dire'] ?? '';
$sitioed = $_POST['sitio'] ?? '';
$maned = $_POST['man'] ?? '';
$deptox = $_POST['depto'] ?? '';
$deptoed = '';

$urbax = $_POST['urba'] ?? '';
$expox = $_POST['expo'] ?? '';
$radiox = $_POST['radio'] ?? '';
$zonax =  $_POST['zona'] ?? '';
$classx = $_POST['class'] ?? '';

/*		  $tpx = $row["tipo"];
			  $usox = $row["uso"];
			  $refx = $row["nombre_referencial"];
			  $karx = $row["kardex"];
			  $mtx = $row["mt2total"];
			  $mtcx = $row["mt2cons"];
	*/

if ($deptox <> '') {
	$blocktmp = (string)($_POST['block'] ?? '');
	$deptotmp = (string)($_POST['depto'] ?? '');
	$deptoed = 'Block ' . $blocktmp . ' Depto Num. ' . $deptotmp;
}

if ($maned <> '') {
	$maned = ' , Manzana ' . (string)($_POST['man'] ?? '');
}

if ($sitioed <> '') {
	$sitioed = ' , Sitio ' . (string)($_POST['sitio'] ?? '');
} else {
	$sitioed = '';
}

$tcpdfLang = '../tcpdf/config/lang/eng.php';
$tcpdfCfg = '../tcpdf/config/tcpdf_config_alt.php';
$tcpdfMain = '../tcpdf/tcpdf.php';
if (!file_exists($tcpdfLang) || !file_exists($tcpdfCfg) || !file_exists($tcpdfMain)) {
	echo "<h3>Error</h3><p>No se encontró la librería TCPDF para generar el certificado.</p>";
	exit;
}
require_once($tcpdfLang);
require_once($tcpdfCfg);
if (!defined("K_TCPDF_EXTERNAL_CONFIG")) {
	define("K_TCPDF_EXTERNAL_CONFIG", true);
}
require_once($tcpdfMain);

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$PDF_PAGE_FORMAT = 'LTR';
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

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

// Formato y diseño equivalente al original.
$titulo = '<span style="text-align:center;">INFORME DE CONSTRUCCION PARA OBTENER</span>';
$html2 = '<span style="text-align:center;">PATENTE MUNICIPAL N° ' . (string)$folioz . ' </span>';
$html = '<span style="text-align:justify;"> De acuerdo a lo dispuesto en el Artículo 142 de la Ley General de Urbanismo y construcción, en el decreto Alcaldicio  N° 6.247 de fecha 28 de septiembre del 2010 articulo 1 numeral 183 inciso 19 y de la Ley N° 18.695 Orgánica constitucional de Municipalidades , el Director de Obras de la Comuna de Arica, certifica que la propiedad Rol N° ' . (string)$roled . ' ubicada en ' . (string)$viaed . ' ' . (string)$direed . ' tiene asignada la numeración Municipal  ' . (string)$numed . ' ' . (string)$deptoed . ' dentro de la población o sector ' . (string)$pobed . (string)$maned . (string)$sitioed . ' , la cual se encuentra emplazada en la comuna de ARICA. Inserto en la Zona ' . (string)$zonax . ' del Plano regulador vigente de la ciudad de Arica, aprobado por resolución Nr. 4 de fecha 03/03/2009, publicado en el diario oficial con fecha 11/07/2009.' . (string)$resto . ' </span>';
$pie = 'N° Giro: ' . (string)$girox . ' , Orden Municipal : ' . (string)$orden . ' , Fecha : ' . (string)$fechg . ' , usuario :  ' . (string)$idusuario;
$pie2 = 'Kardex : ' . (string)$kx;

$pdf->SetFont('helvetica', '', 16);
$pdf->AddPage();
$pdf->writeHTML(' ', true, 0, true, true);
$pdf->writeHTML(' ', true, 0, true, true);
$pdf->writeHTML(' ', true, 0, true, true);
$pdf->writeHTML($titulo, true, 0, true, true);
$pdf->writeHTML($html2, true, 0, true, true);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('helvetica', '', 13);
$pdf->writeHTML($html, true, 0, true, true);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('helvetica', '', 10);
$firma1 = '<span style="text-align:center;">' . (string)$linea_fin1 . '</span>';
$firma2 = '<span style="text-align:center;">' . (string)$linea_fin2 . '</span>';
$firma3 = '<span style="text-align:center;">' . (string)$linea_fin3 . '</span>';
$pdf->writeHTML($firma1, true, 0, true, true);
$pdf->writeHTML($firma2, true, 0, true, true);
$pdf->writeHTML($firma3, true, 0, true, true);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($pie, true, 0, true, true);
$pdf->writeHTML($pie2, true, 0, true, true);
$pdf->lastPage();

//Close and output PDF document
$pdfBinary = $pdf->Output('certificado.pdf', 'S');
if (ob_get_length()) {
	ob_end_clean();
}
if ($pdfBinary === false || strlen($pdfBinary) < 500) {
	echo "<h3>Error</h3><p>No fue posible generar el PDF del certificado de patente.</p>";
	exit;
}
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="certificado_patente.pdf"');
header('Content-Length: ' . strlen($pdfBinary));
echo $pdfBinary;
exit;

//============================================================+
// END OF FILE                                                 
//============================================================+
