<?php    include("../conexion.php");
include("../debug.php");

// Debug: mostrar datos recibidos
debug_log("=== MANTENEDOR: zonas ===");
debug_request();
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"] ?? ''; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"] ?? ''; }
   
if ( $x_param == 1 ){
			 $desx = $_POST["ide"] ?? '';
			 $infx = $_POST["info"] ?? '';
			 $filex = $_POST["file"] ?? '';			 			 
			 $link=conectarse();
			 $sql = "INSERT INTO zonas (id,info,file) VALUES ('$desx','$infx','$filex')";
			 $result2=mysql_query($sql);
			 mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Agregado Correctamente!');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";
			 echo "</script>";
}

if ( $x_param == 2 ){
			 $idx  = $_POST["ide"] ?? '';
			 $infx = $_POST["info"] ?? '';
			 $filex = $_POST["file"] ?? '';			 			 
		 
		 	 $link=conectarse();
    	     $sql= "UPDATE zonas SET info='$infx', file='$filex' WHERE id='$idx'";
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
			 if ( $idx <> 'SIN ESPECIFICAR ' ) {
	             $link=conectarse();
    	         $sql="DELETE FROM zonas where id = '$idx'";
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