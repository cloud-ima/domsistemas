<?php

include("../conexion.php");
include("../fechaclasss.php");

$link=conectarse();
$idz=$_GET['id'];
$folioz=$_GET['folio'];

$ssql = "select * from propiedades where id ='$idz'";
$rs = mysql_query($ssql,$link);
$num_registros = mysql_num_rows($rs); 
if ($num_registros == 0){
			 echo '<script language="javascript">';
			 echo "alert('Error en Numero de Propiedad!!');";
			 echo "location.href='list_solicitudes.php';";
 		     echo "</script>";
}else{
	     while ($row = mysql_fetch_array($rs)){
		 
 			  $cod = $row["pob"];
 			  $link=Conectarse();
			  $qry = "SELECT * FROM pob where id ='$cod'";
			  $res = mysql_query($qry);
			  $pobed = mysql_result($res, 0, "nombre");
			  $roled = $row["rol"];
			  $numed = $row["numero"];
	          $viaed  = $row["tipocalle"];
			  $direed = $row["direccion"];
			  $sitioed = $row["sitio"];
			  $maned = $row["manzana"];
			  $deptox = $row["depto"];
			  $deptoed='';			  
			  
			  if ( $deptox <> '' ) {
			       $deptoed = 'Block ' . $row["block"] . ' Depto Num. '. $row["depto"];
			  }	   

			  $urbax = $row["urbanizacion"];
			  $expox = $row["expropiacion"];
			  $radiox = $row["radiourbano"];
			  $tpx = $row["tipo"];
			  $usox = $row["uso"];
			  $refx = $row["nombre_referencial"];
			  $karx = $row["kardex"];
			  $mtx = $row["mt2total"];
			  $mtcx = $row["mt2cons"];
			  $zonax = $row["zona"];
			  $classx = $row["clase"];

			  $obsx = $row["obs"];
			  $parz = 2;
            }
	}
				  mysql_close($link);

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
 de obras de la comuna de Arica, certifica que la propiedad ' . $roled . ' ubicada en ' . $viaed . ' ' . $direed . '  
 tiene asignada la numeraci&oacute;n municipal  ' . $numed . ' ' . $deptoed. ' Dentro de la Poblaci&oacute;n ' . $pobed. ' , manzana '. $maned ' , SITIO ' . $sitioed . ' se
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