<?php
error_reporting(0);
require_once('class.ezpdf.php');
$pdf =& new Cezpdf('LETTER');
$pdf->selectFont('../fonts/courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);

$conexion = mysql_connect("localhost", "root", "mariasmarias");
mysql_select_db("domsistema", $conexion);
$queEmp = "SELECT * FROM tipocertificado order by id ";
$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);

$ixx = 0;
while($datatmp = mysql_fetch_assoc($resEmp)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}
$titles = array(
				'id'=>'<b>Num</b>',
				'nombre'=>'<b>Nombre</b>',
				'reporte'=>'<b>Reporte</b>',
				'moneda'=>'<b>Moneda</b>'
			);
$options = array(
				'shadeCol'=>array(0.9,0.9,0.9),
				'xOrientation'=>'center',
				'width'=>500
			);
$txttit = "<b>LISTADO DE CERTIFICADOS</b>\n";
$txttit.= "Archivo Maestro Certificados y Valores\n";

$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
//$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
//$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();
?>