<?php    include("../conexion.php");
include("../debug.php");

// Debug: mostrar datos recibidos
debug_log("=== MANTENEDOR: usuarios ===");
debug_request();
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"] ?? ''; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"] ?? ''; }
   
if ( $x_param == 1 ){
			 $nomx = $_POST["nombre"] ?? '';
			 $ctax = $_POST["cuenta"] ?? '';
			 $pasx = $_POST["pass"] ?? '';
			 $tipx = $_POST["tipo"] ?? '';
			 
			 $link=conectarse();
			 $sql = "INSERT INTO usuarios (nombre,usuario,tipo,password,unidad,estado) VALUES ('$nomx','$ctax','$tipx','$pasx','1','1')";
			 $result2=mysql_query($sql);
			 mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Agregado Correctamente!');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";
			 echo "</script>";
}

if ( $x_param == 2 ){
			 $nomx = $_POST["nombre"] ?? '';
			 $ctax = $_POST["cuenta"] ?? '';
			 $pasx = $_POST["pass"] ?? '';
			 $tipx = $_POST["tipo"] ?? '';
			 $idx  = $_POST["codigo"] ?? '';
		 
		 	 $link=conectarse();
    	     $sql= "UPDATE usuarios SET nombre='$nomx',password='$pasx',tipo='$tipx' WHERE id='$idx'";
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
             $sql="DELETE FROM usuarios where id = '$idx'";
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