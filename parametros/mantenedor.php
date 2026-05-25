<?php    include("../conexion.php");
if (file_exists("../debug.php")) {
    include_once("../debug.php");
}

// Debug: mostrar datos recibidos
if (function_exists('debug_log')) {
    debug_log("=== MANTENEDOR: parametros ===");
}
if (function_exists('debug_request')) {
    debug_request();
}

$x_param = '';
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"] ?? ''; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"] ?? ''; }
   
if ( $x_param == 1 ){
			 $desx = $_POST["desde"] ?? '';
			 $hasx = $_POST["hasta"] ?? '';
			 $ufx = $_POST["uf"] ?? '';
			 $utmx = $_POST["utm"] ?? '';
			 $cuox = $_POST["cuota"] ?? '';

             if (trim($desx) === '' || trim($hasx) === '' || trim($ufx) === '' || trim($utmx) === '' || trim($cuox) === '') {
                 echo '<script language="javascript">';
                 echo "alert('Debe Ingresar Fecha Inicial, Fecha Final, U.F., U.T.M. y Cuota Ahorro');";
                 echo "history.back();";
                 echo "</script>";
                 exit;
             }

             // Normaliza valores monetarios: permite ingresar 2.070,68 o 2070.68
             $ufx = str_replace(array('.', ','), array('', '.'), trim((string)$ufx));
             $utmx = str_replace(array('.', ','), array('', '.'), trim((string)$utmx));
             $cuox = str_replace(array('.', ','), array('', '.'), trim((string)$cuox));

			 $link=conectarse();
			 $sql = "INSERT INTO param (desde,hasta,uf,utm,cuota) VALUES ('$desx','$hasx','$ufx','$utmx','$cuox')";
			 $result2=mysql_query($sql);
             if (!$result2) {
                 $error_sql = htmlspecialchars(mysql_error($link));
                 echo "<h3>Error al guardar parámetros financieros</h3><pre>$error_sql</pre><p><a href='javascript:history.back()'>Volver</a></p>";
                 exit;
             }
			 mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Agregado Correctamente!');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";
			 echo "</script>";
             exit;
}

if ( $x_param == 2 ){
			 $desx = $_POST["desde"] ?? '';
			 $hasx = $_POST["hasta"] ?? '';
			 $ufx = $_POST["uf"] ?? '';
			 $utmx = $_POST["utm"] ?? '';
			 $cuox = $_POST["cuota"] ?? '';
			 $idx  = $_POST["codigo"] ?? '';

             if (trim($desx) === '' || trim($hasx) === '' || trim($ufx) === '' || trim($utmx) === '' || trim($cuox) === '') {
                 echo '<script language="javascript">';
                 echo "alert('Debe Ingresar Fecha Inicial, Fecha Final, U.F., U.T.M. y Cuota Ahorro');";
                 echo "history.back();";
                 echo "</script>";
                 exit;
             }

             $ufx = str_replace(array('.', ','), array('', '.'), trim((string)$ufx));
             $utmx = str_replace(array('.', ','), array('', '.'), trim((string)$utmx));
             $cuox = str_replace(array('.', ','), array('', '.'), trim((string)$cuox));
		 
		 	 $link=conectarse();
    	     $sql= "UPDATE param SET desde='$desx',hasta='$hasx',uf='$ufx',utm='$utmx',cuota='$cuox' WHERE id='$idx'";
   		     $result2=mysql_query($sql);
             if (!$result2) {
                 $error_sql = htmlspecialchars(mysql_error($link));
                 echo "<h3>Error al actualizar parámetros financieros</h3><pre>$error_sql</pre><p><a href='javascript:history.back()'>Volver</a></p>";
                 exit;
             }
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Actualizado Correctamente');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";
 		     echo "</script>";
             exit;
			 /* echo "<script>window.close();</script>";
			 echo "location.href='p_tipodecreto.php';";*/
}

if ( $x_param == 3 ){
			 $idx  = $_GET["id"] ?? '';
             $link=conectarse();
             $sql="DELETE FROM param where id = '$idx'";
             $result = mysql_query($sql);
             if (!$result) {
                 $error_sql = htmlspecialchars(mysql_error($link));
                 echo "<h3>Error al borrar parámetro financiero</h3><pre>$error_sql</pre><p><a href='javascript:history.back()'>Volver</a></p>";
                 exit;
             }
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Borrado');";
			 echo "location.href='index.php';";
			 echo "opener.window.location.reload( false );";
	         //echo "window.close();";
 		     echo "</script>";		
             exit;
}
?>
