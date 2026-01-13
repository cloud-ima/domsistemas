<?php
//include("../seguridadsimple.php");
include("../conexion.php");
include("../fechaclasss.php");

$link=conectarse();

$ok = $_POST['listo'];
$ff = $_POST['foliox'];

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

 if ( $ok == 'checkbox' )
	 {
 		 	 $link=conectarse();
	   	     $sql= "UPDATE cert2009 SET estado = '3' where id = '$ff' ";
   		     $result2=mysql_query($sql);
 			 mysql_close($link);
	 }

			 $idx = $_POST['codigo'];
			 $rolx = $_POST['rol'];
			 $direx = $_POST['dire'];
			 $viax = $_POST['via'];
			 $numx = $_POST['num'];
			 $blockx = $_POST['block'];
			 $deptox = $_POST['depto'];
			 $sitiox = $_POST['sitio'];
			 $manx = $_POST['man'];
			 $pobx = $_POST['pob'];
			 $refx = $_POST['referencia'];
			 $zonax = $_POST['zona'];
			 $urbax = $_POST['urba'];
			 $tipox = $_POST['tipo'];
			 $usox = $_POST['uso'];
			 $expox = $_POST['expo'];
			 $radiox = $_POST['radio'];
			 $classx = $_POST['class'];
			 $mtx = $_POST['mt'];
			 $mtcx = $_POST['mtc'];
			 $kx = $_POST['kardex'];
			 

			 
			/* $pcx = $_POST["pc"];
	 	     $pcdx = $_POST["pcd"];
			 $rfx = $_POST["rf"];
			 $rfdx = $_POST["rfd"];
			  
 			 $sitpatx = $_POST["sitpatente"];
			 $obspatx = $_POST["obspat"];
			 $numnx = $_POST["numnuevo"];*/
			  
			  
			  if ( $sitpatx == 2 ) { 
		      $resto = 'Se informa que la propiedad antes mencionada : Cumple la normativa para obtenci&oacute;n de Patente Municipal 
  seg&uacute;n los antecedentes , Permiso de Construcci&oacute;n : ' . $pcx. ' de fecha ' .$pcdx . ' y Recepci&oacute;n Final: ' . $rfx . ' de fecha ' .$rfdx. ' ' . $obspatx.  '.'; 
  		}

		if ( $sitpatx == 1 ) { 
		if ( $rfx == '' ){
 $resto = 'Se informa que la propiedad antes mencionada : No Cumple la normativa para obtenci&oacute;n de Patente Municipal 
  seg&uacute;n los antecedentes , Permiso de Construcci&oacute;n : ' . $pcx. ' de fecha ' .$pcdx . ', ' . $obspatx.  '.'; 		
         }else{
     $resto = 'Se informa que la propiedad antes mencionada : No Cumple la normativa para obtenci&oacute;n de Patente Municipal 
  seg&uacute;n los antecedentes , Permiso de Construcci&oacute;n : ' . $pcx. ' de fecha ' .$pcdx . ' y Recepci&oacute;n Final: ' . $rfx . ' de fecha ' .$rfdx. ' ' . $obspatx.  '.'; 		
}  
  		}

  			  $link=Conectarse();
			  $qry = "SELECT * FROM cert2009 where id ='$ff'";
			  $res = mysql_query($qry);
			  $idusuario = mysql_result($res, 0, "responsable");
			  $fechag = mysql_result($res, 0, "giro_fecha");

 			  $cod = $_POST['pob'];
 			  $link=Conectarse();
			  $qry = "SELECT * FROM pob where id ='$cod'";
			  $res = mysql_query($qry);
			  $pobed = mysql_result($res, 0, "nombre");
			  
			  $roled = $_POST['rol'];
			  $numed =  $_POST['num'];
	          $viaed  = strtolower($_POST['via']);
			  $direed = $_POST['dire'];
			  $sitioed = $_POST['sitio'];
			  $maned = $_POST['man'];
			  $deptox = $_POST['depto'];
			  $deptoed=''; 	  

			  $urbax = $_POST['urba'];
			  $expox = $_POST['expo'];
			  $radiox = $_POST['radio'];
			  $zonax =  $_POST['zona'];
			  $classx = $_POST['class'];
			  			  
	/*		  $tpx = $row["tipo"];
			  $usox = $row["uso"];
			  $refx = $row["nombre_referencial"];
			  $karx = $row["kardex"];
			  $mtx = $row["mt2total"];
			  $mtcx = $row["mt2cons"];
	*/
	
	if ( $deptox <> '') {
			       $deptoed = 'Block ' . $_POST['block'] . ' Depto Num. '. $_POST['depto'];
			  }	   

			  if ( $maned <> '' ){
			       $maned = ' , Manzana ' . $_POST['man'];
			  }

			  if ( $sitioed <> '' ){
			       $sitioed = ' , Sitio ' . $_POST['sitio']; 
			  }else { $sitioed = ''; }

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
$titulo = '<span style="text-align:center;">INFORME DE CONSTRUCCION PARA OBTENER</span>';
$titulo2 = 'PATENTE MUNICIPAL N&ordm; ' . $folioz; ;
//$nntt = 'Folio : ' . $folioz;

$html2 = '<span style="text-align:center;">PATENTE MUNICIPAL N&ordm; ' . $folioz .' </span>';

$html = '<span style="text-align:justify;"> De acuerdo a lo dispuesto en el Art&iacute;culo 142 de la Ley General de Urbanismo y construcci&oacute;n, en el decreto Alcaldicio  N&ordm; 6.247 de fecha 28 de septiembre del 2010
 articulo 1 numeral 183 inciso 19 y de la Ley N&ordm; 18.695 Org&aacute;nica constitucional de Municipalidades , el Director
 de Obras de la Comuna de Arica, certifica que la propiedad Rol N&ordm; ' . $roled . ' ubicada en ' . $viaed . ' ' . $direed . '  
 tiene asignada la numeraci&oacute;n Municipal  ' . $numed . ' ' . $deptoed . ' dentro de la poblaci&oacute;n o sector ' . $pobed. $maned . $sitioed . ' , la cual se
 encuentra emplazada en la comuna de ARICA. Inserto en la Zona ' . $zonax .' del Plano regulador vigente de la ciudad de Arica, aprobado
 por resoluci&oacute;n Nr. 4 de fecha 03/03/2009, publicado en el diario oficial con fecha 11/07/2009.'. $resto .' </span>';
 
//$html3 = '<span style="text-align:justify;"> Inserto en la Zona ' . $zonax .' del Plano regulador vigente de la ciudad de Arica, aprobado
// por resoluci&oacute;n Nr. 4 de fecha 03/03/2009, publicado en el diario oficial con fecha 11/07/2009.</span>';

$lin1 = 'FRANCISCO ZULETA GOMEZ<br>ARQUITECTO<br>DIRECTOR DE OBRAS DOM ARICA';

$pie = 'N&ordm; Giro: ' . $girox . ' , Orden Municipal : ' . $orden . ' , Fecha : ' . $fechg . ' , usuario :  ' . $idusuario; 
$pie2 = 'Kardex : ' . $kx ; 

// set core font
$pdf->SetFont('helvetica', '', 16);

// add a page
$pdf->AddPage();
// output the HTML content
//$pdf->Ln();
$pdf->writeHTML(' ', true, 0, true, true);
$pdf->writeHTML(' ', true, 0, true, true);
$pdf->writeHTML(' ', true, 0, true, true);
$pdf->writeHTML($titulo, true, 0, true, true);
$pdf->writeHTML($html2, true, 0, true, true);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
//$pdf->Ln();

$pdf->SetFont('helvetica', '', 13);
$pdf->writeHTML($html, true, 0, true, true);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('helvetica', '', 10);
$firma1 = '<span style="text-align:center;">'.$linea_fin1.'</span>';
$firma2 = '<span style="text-align:center;">'.$linea_fin2.'</span>';
$firma3 = '<span style="text-align:center;">'.$linea_fin3.'</span>';
$pdf->writeHTML($firma1, true, 0, true, true);
$pdf->writeHTML($firma2, true, 0, true, true);
$pdf->writeHTML($firma3, true, 0, true, true);
/*$pdf->MultiCell(100, 0, 'FRANCISCO ZULETA GOMEZ'."\n", 0, 'C', 0, 1, '', '', true, 0);
$pdf->MultiCell(100, 0, 'ARQUITECTO'."\n", 0, 'C', 0, 1, '', '', true, 0);
$pdf->MultiCell(100, 0, 'DIRECTOR DE OBRAS ARICA'."\n", 0, 'C', 0, 1, '', '', true, 0);*/
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($pie, true, 0, true, true);
$pdf->writeHTML($pie2, true, 0, true, true);
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('certificado.pdf', 'I');

//============================================================+
// END OF FILE                                                 
//============================================================+


?>