<?php    include("../seguridadsimple.php");
   include("../fechaclasss.php");
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"] ?? ''; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"] ?? ''; }
	  
$link=Conectarse();
$qry = "SELECT * from parametros where id = 1";
$res = mysql_query($qry);
$tablaperiodo = "cert". mysql_result($res, 0, "periodo");

if ( $x_param == 1 ){
			 $qry = "SELECT * from param order by id desc limit 1";
			 $res = mysql_query($qry);
			 $uf = mysql_result($res, 0, "uf");
			 $utm = mysql_result($res, 0, "utm");
			 $cuota = mysql_result($res, 0, "cuota");

	  		 $fec1 = cambiaf_a_mysql($_POST["fecha"]);
			 $fec2 = cambiaf_a_mysql($_POST["fentrega"]);
 		     $dirx = strtoupper($_POST["direccion"]);
			 $rolx = $_POST["rol"] ?? '';
  		     $mtx = $_POST["mt"] ?? '';
  		     $diasx = $_POST["dias"] ?? '';
  		     $certx = $_POST["certificado"] ?? '';
  		     $rutx = $_POST["rut"] ?? '';
  		     $rubx = strtoupper($_POST["rubro"]);
			 
			 $qry = "SELECT * from tipocertificado where id =$certx";
			 $res = mysql_query($qry);
			 $mn = mysql_result($res, 0, "moneda");
			 $valor = mysql_result($res, 0, "precio");

if ( $certx <> '10' ) {

if ( $mn == 1 ) { $total = round($valor * $cuota); }
if ( $mn == 2 ) { $total = round($valor * $uf); }
if ( $mn == 3 ) { $total = round($valor * $utm); }
if ( $mn == 4 ) { $total = $valor; }

}
else
   {
    $total = round($valor * $utm * $diasx * $mtx );
   }
   
			 $link=conectarse();
			 $sql = "INSERT INTO $tablaperiodo (fecha_solicitud,rut,total,idcert,rol,direccion,dias,mt,estado,usuario,fecha_entrega,rubro) VALUES
			 	                                     ('$fec1','$rutx','$total','$certx','$rolx','$dirx','$dias','$dirx',1,'$cuentausuario','$fec2','$rubx')";
			 $result2=mysql_query($sql);
			 $ultimo_id = mysql_insert_id($link);
			 mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Solicitd Ingresada Correctamente, con Nro. Folio : $ultimo_id; ');";
			 echo "location.href='imprimir-solicitud.php?id=$ultimo_id&rut=$rutx';";
			 echo "</script>";
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