<?php    include("../conexion.php");
include("../debug.php");

// Debug: mostrar datos recibidos
debug_log("=== MANTENEDOR: tipocertificado ===");
debug_request();
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"] ?? ''; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"] ?? ''; }
   
if ( $x_param == 1 ){
			 $nomx = $_POST["nombre"] ?? '';
			 $monx = $_POST["moneda"] ?? '';
			 $prex = $_POST["precio"] ?? '';
			 $plax = $_POST["plazo"] ?? '';
			 $copx = $_POST["copias"] ?? '';
			 $ctax = $_POST["cuenta"] ?? '';
			 
			 $link=conectarse();
			 $sql = "INSERT INTO tipocertificado (nombre,moneda,precio,plazo,copias,imputacion) VALUES ('$nomx','$monx','$prex','$plax','$copx','$ctax')";
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
			 $monx = $_POST["moneda"] ?? '';
			 $prex = $_POST["precio"] ?? '';
			 $plax = $_POST["plazo"] ?? '';
			 $copx = $_POST["copias"] ?? '';
			 $ctax = $_POST["cuenta"] ?? '';
			 $idx  = $_POST["codigo"] ?? '';
		 
		 	 $link=conectarse();
    	     $sql= "UPDATE tipocertificado SET nombre='$nomx',moneda='$monx',precio='$prex',plazo='$plax',copias='$copx',imputacion='$ctax' WHERE id='$idx'";
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
			 echo '<script language="javascript">';
			 echo "alert('Opción Deshabilitada por Razones de Seguridad');";
			 echo "location.href='index.php';";
			 echo "opener.window.location.reload( false );";
	         //echo "window.close();";
 		     echo "</script>";		

/*
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
 		     echo "</script>";		*/
}
?>