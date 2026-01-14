<?php
$hoy = date('Y')."-".date('m')."-".date('d');
$filename = 'LISTADO-'.$hoy;
include("../seguridadsimple.php");
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");
//echo "Listado de Solicitudes Pendientes Fecha Consulta Desde : ". $inicio. " al ". $hasta;
$inicio = $_POST["desde"] ?? '';
$termino = $_POST["hasta"] ?? '';
if ( $termino == "" )
{
    $termino = $inicio ;
}
$lugar = $_POST["lugar"] ?? '';

echo "Solicitudes Comprendidas, Desde : ". $inicio. " al ". $termino;

$consultaSQL = "SELECT * FROM cert2009 where ( fecha_solicitud >= '$inicio' and fecha_solicitud <= '$termino' ) order by id ";
//$consultaSQL = "SELECT * FROM cert2009 where ( fecha_solicitud >= '$inicio' and fecha_solicitud <= '$termino' ) and ( estado <> 4 ) order by id desc";

//SELECT * FROM table WHERE field BETWEEN $low AND $high
		  $link=Conectarse(); 
	      $result=mysql_query($consultaSQL,$link);
		  echo "<table border=1>\n";
		  echo "<tr>\n";
		  echo "<th>Folio   </th>\n";
		  echo "<th>Fecha   </th>\n";
		  echo "<th>ROL     </th>\n";
		  echo "<th>TC      </th>\n";		  
  		  echo "<th>Dirección / Numero / Depto / Block / Sitio / Manzana  / </th>\n";
 		  echo "<th>Nombre del Contribuyente </th>\n";
		  echo "<th>Firma de Recepción Conforme </th>\n";
		  echo "</tr>\n";

      	  $num_total_registros = mysql_num_rows($result);
          //$result=mysql_query("SELECT * FROM solicitud where recepcion = '$sesionusuario' and estado = 1 or estado = 3  order by fechaingreso desc",$link); 
		  echo " Total Solicitudes : " . $num_total_registros;
   		  while ($row = mysql_fetch_array($result)){
				               $cod= $row["rut"];
							   $fecha= $row["fecha_solicitud"];
							   $idcert= $row["idcert"];							   

							   $link=Conectarse();
						$qry = "SELECT * FROM rut where rut ='$cod'";
						$res = mysql_query($qry);
						$nombre = mysql_result($res, 0, "nombre"). " ".mysql_result($res, 0, "apellidos")  . '                              ' ;
//						$nombre = mysql_result($res, 0, "apellidos") ;

							   $link=Conectarse();
						$qry = "SELECT * FROM tipocertificado where id ='$idcert'";
						$res = mysql_query($qry);
						$tcx = mysql_result($res, 0, "nombre");

						
		  
		  $idaux = $row["id"];
		  $diraux = $row["direccion"] . '                              ' ;
		  $rolaux = $row["rol"];

	//	  $staux = $nombreestado . "  Dias (" . $dias_diferencia .")";
		  $obs = "                             ";
		  
		  echo "<tr>\n";
		  echo "<td valign=\"top\"><font >$idaux</font></td>\n";
		  echo "<td valign=\"top\"><font >$fecha</font></td>\n";	  
		  echo "<td valign=\"top\"><font >$rolaux</font></td>\n";
		  echo "<td valign=\"top\"><font >$tcx</font></td>\n";		  
		  echo "<td valign=\"top\"><font >$diraux</font></td>\n";		  
//		  echo "<td align=\"center\" valign=\"top\"><font >$diraux</font></td>\n";
		  echo "<td valign=\"top\"><font >$nombre</font></td>\n";
		  echo "<td valign=\"top\"><font >$obs</font></td>\n";
		  echo "</tr>\n";
	   
	/*	   $codsec= $row["estado"];
           $link=Conectarse(); 
           $qry = "SELECT * FROM estados WHERE id='$codsec'";
		   $res = mysql_query($qry);
           $nombreestado = mysql_result($res, 0, "nombre");*/
}
		  echo "</table>\n";

?> 