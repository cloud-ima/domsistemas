<?php    include("../conexion.php");
include("../debug.php");

// Debug: mostrar datos recibidos
debug_log("=== MANTENEDOR: parametros ===");
debug_request();
   
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
			 $link=conectarse();
			 $sql = "INSERT INTO param (desde,hasta,uf,utm,cuota) VALUES ('$desx','$hasx','$ufx','$utmx','$cuox')";
			 $result2=mysql_query($sql);
			 mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Agregado Correctamente!');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";
			 echo "</script>";
}

if ( $x_param == 2 ){
			 $desx = $_POST["desde"] ?? '';
			 $hasx = $_POST["hasta"] ?? '';
			 $ufx = $_POST["uf"] ?? '';
			 $utmx = $_POST["utm"] ?? '';
			 $cuox = $_POST["cuota"] ?? '';
			 $idx  = $_POST["codigo"] ?? '';
		 
		 	 $link=conectarse();
    	     $sql= "UPDATE param SET desde='$desx',hasta='$hasx',uf='$ufx',utm='$utmx',cuota='$cuox' WHERE id='$idx'";
   		     $result2=mysql_query($sql);
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Actualizado Correctamente');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";
 		     echo "</script>";
			 /* echo "<script>window.close();</script>";
			 echo "location.href='p_tipodecreto.php';";*/
}

if ( $x_param == 3 ){
			 $idx  = $_GET["id"] ?? '';
             $link=conectarse();
             $sql="DELETE FROM param where id = '$idx'";
             $result = mysql_query($sql);
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Borrado');";
			 echo "location.href='index.php';";
			 echo "opener.window.location.reload( false );";
	         //echo "window.close();";
 		     echo "</script>";		
}
?>