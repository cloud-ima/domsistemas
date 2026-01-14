<?php    include("../conexion.php");
include("../debug.php");

// Debug: mostrar datos recibidos
debug_log("=== MANTENEDOR: destino ===");
debug_request();
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"] ?? ''; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"] ?? ''; }
   
if ( $x_param == 1 ){
			 $desx = $_POST["nom"] ?? '';
			 $link=conectarse();
			 $sql = "INSERT INTO destino (nombre) VALUES ('$desx')";
			 $result2=mysql_query($sql);
			 mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Agregado Correctamente!');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";
			 echo "</script>";
}

if ( $x_param == 2 ){
			 $desx = $_POST["nom"] ?? '';
			 $idx  = $_POST["codigo"] ?? '';
		 
		 	 $link=conectarse();
    	     $sql= "UPDATE destino SET nombre='$desx' WHERE id='$idx'";
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
			 if ( $idx <> 1 ) {
	             $link=conectarse();
    	         $sql="DELETE FROM destino where id = '$idx'";
        	     $result = mysql_query($sql);
  		    	 mysql_close($link);
			 }
			 echo '<script language="javascript">';
			 echo "alert('Registro Borrado');";
			 echo "location.href='index.php';";
			 echo "opener.window.location.reload( false );";
	         //echo "window.close();";
 		     echo "</script>";		
}
?>