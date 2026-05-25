<?php    include("../seguridadsimple.php");
   include("../fechaclasss.php");
   
   $x_param = '';
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"] ?? ''; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"] ?? ''; }
	  
$link=Conectarse();
$qry = "SELECT * from parametros where id = 1";
$res = mysql_query($qry);
$tablaperiodo = "cert". mysql_result($res, 0, "periodo");

function normaliza_fecha_post($fecha)
{
    $fecha = trim((string)$fecha);
    if ($fecha === '') {
        return '';
    }
    if (strpos($fecha, '-') !== false) {
        $partes = explode('-', $fecha);
        if (count($partes) === 3) {
            return $partes[0] . "/" . $partes[1] . "/" . $partes[2];
        }
    }
    return $fecha;
}

if ( $x_param == 1 ){
			 $qry = "SELECT * from param order by id desc limit 1";
			 $res = mysql_query($qry);
             if (!$res || mysql_num_rows($res) === 0) {
                 echo '<script language="javascript">';
                 echo "alert('No existe configuración monetaria en tabla param.');";
                 echo "location.href='solicitud.php';";
                 echo "</script>";
                 exit;
             }
			 $uf = mysql_result($res, 0, "uf");
			 $utm = mysql_result($res, 0, "utm");
			 $cuota = mysql_result($res, 0, "cuota");

	  		 $fec1 = cambiaf_a_mysql(normaliza_fecha_post($_POST["fecha"] ?? ''));
			 $fec2 = cambiaf_a_mysql(normaliza_fecha_post($_POST["fentrega"] ?? ''));
 		     $dirx = strtoupper(trim($_POST["direccion"] ?? ''));
			 $rolx = trim($_POST["rol"] ?? '');
  		     $mtx_raw = trim($_POST["mt"] ?? '');
  		     $diasx_raw = trim($_POST["dias"] ?? '');
  		     $certx = $_POST["certificado"] ?? '';
  		     $rutx = $_POST["rut"] ?? '';
  		     $rubx = strtoupper(trim($_POST["rubro"] ?? ''));

             // Evita fallos en INSERT por campos numéricos vacíos cuando no aplica B.N.U.P.
             $mtx = ($mtx_raw === '' ? 0 : (float)$mtx_raw);
             $diasx = ($diasx_raw === '' ? 0 : (int)$diasx_raw);

             if ($certx === '' || $certx === '0' || $rutx === '') {
                 echo '<script language="javascript">';
                 echo "alert('Faltan datos obligatorios para guardar la solicitud.');";
                 echo "history.back();";
                 echo "</script>";
                 exit;
             }
			 
			 $qry = "SELECT * from tipocertificado where id =$certx";
			 $res = mysql_query($qry);
             if (!$res || mysql_num_rows($res) === 0) {
                 echo '<script language="javascript">';
                 echo "alert('Tipo de certificado no válido.');";
                 echo "history.back();";
                 echo "</script>";
                 exit;
             }
			 $mn = mysql_result($res, 0, "moneda");
			 $valor = mysql_result($res, 0, "precio");
             $total = 0;

if ( $certx <> '10' ) {
// Para certificados normales, estos campos no aplican.
$mtx = 0;
$diasx = 0;

if ( $mn == 1 ) { $total = round($valor * $cuota); }
if ( $mn == 2 ) { $total = round($valor * $uf); }
if ( $mn == 3 ) { $total = round($valor * $utm); }
if ( $mn == 4 ) { $total = $valor; }

}
else
   {
    if ($mtx <= 0 || $diasx <= 0) {
        echo '<script language="javascript">';
        echo "alert('Para B.N.U.P. debe ingresar Metros Lineales y Días de uso mayores a cero.');";
        echo "history.back();";
        echo "</script>";
        exit;
    }
    $total = round($valor * $utm * $diasx * $mtx );
   }
   
			 $link=conectarse();
			 $sql = "INSERT INTO $tablaperiodo (fecha_solicitud,rut,total,idcert,rol,direccion,dias,mt,estado,usuario,fecha_entrega,rubro) VALUES
			 	                                     ('$fec1','$rutx','$total','$certx','$rolx','$dirx','$diasx','$mtx',1,'$cuentausuario','$fec2','$rubx')";
			 $result2=mysql_query($sql);
             if (!$result2) {
                 $error_sql = addslashes(mysql_error($link));
                 echo '<script language="javascript">';
                 echo "alert('No se pudo guardar la solicitud. Error SQL: $error_sql');";
                 echo "history.back();";
                 echo "</script>";
                 exit;
             }
			 $ultimo_id = mysql_insert_id($link);
			 mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Solicitd Ingresada Correctamente, con Nro. Folio : $ultimo_id; ');";
			 echo "location.href='imprimir-solicitud.php?id=$ultimo_id&rut=$rutx';";
			 echo "</script>";
             exit;
}

if ( $x_param == 2 ){
           
			 $idx = $_POST["codigo"] ?? '';
			 $fec1 = cambiaf_a_mysql($_POST["fgiro"]);
		 
			 $girx = $_POST["giro"] ?? '';
  		     $otx = $_POST["ot"] ?? '';
			 $acx = $_POST["responsable"] ?? '';
			 $rolx = $_POST["rol_aux"] ?? '';
			 $esx = '1';
			 
			 if ( $otx <> "" ) { $esx = '2'; }
		 	 $link=conectarse();
    	     $sql= "UPDATE $tablaperiodo SET rol='$rolx', giro_fecha='$fec1',giro_numero='$girx',orden_numero='$otx',estado='$esx',responsable='$acx' WHERE id='$idx'";
   		     $result2=mysql_query($sql);
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Cambios guardados correctamente');";
			 echo "location.href='list_solicitudes.php';";
			 echo "opener.window.location.reload( false );";
	        // echo "window.close();";
 		     echo "</script>";
}

if ( $x_param == 3 ){
	if ($tipousuario == 1 ) {
		     $idx  = $_GET["id"] ?? '';
             $link=conectarse();
			 $sql= "UPDATE $tablaperiodo SET estado='5' WHERE id='$idx'";
   		     $result2=mysql_query($sql);
 //            $sql="DELETE FROM $tablaperiodo where id = '$idx'";
 //            $result = mysql_query($sql);
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Borrado');";
			 echo "location.href='list_solicitudes.php';";
 		     echo "</script>";
			 }
else {
			 echo '<script language="javascript">';
			 echo "alert('Sr. usuario no tiene los permisos para borrar la solicitud');";
			 echo "location.href='list_solicitudes.php';";
 		     echo "</script>";
			 }
	 
}

if ( $x_param == 4 ){
           
			 $idx = $_POST["codigo"] ?? '';
		//	 $fec1 = cambiaf_a_mysql($_POST["fgiro"]);
		 
			 $girx = $_POST["giro"] ?? '';
  		     $otx = $_POST["ot"] ?? '';
			 $acx = $_POST["responsable"] ?? '';
			 $rolx = $_POST["rol_aux"] ?? '';
			 $esx = $_POST["estado"] ?? '';
			 
		 	 $link=conectarse();
//    	     $sql= "UPDATE $tablaperiodo SET rol='$rolx', giro_fecha='$fec1',giro_numero='$girx',orden_numero='$otx',estado='$esx',responsable='$acx' WHERE id='$idx'";
    	     $sql= "UPDATE $tablaperiodo SET rol='$rolx', giro_numero='$girx',orden_numero='$otx',estado='$esx',responsable='$acx' WHERE id='$idx'";			 
   		     $result2=mysql_query($sql);
  		     mysql_close($link);
/*			 echo "entro aqui";
			 echo $esx;*/
			 echo '<script language="javascript">';
			 echo "alert('Cambios guardados correctamente');";
			 echo "location.href='consultaestado.php';";
			 echo "opener.window.location.reload( false );";
	        // echo "window.close();";
 		     echo "</script>";
}

?>
