<?
   include("../conexion.php");
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"]; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"]; }
	  
	  		 $nomx = strtoupper($_POST["nombres"]);
			 $apex = strtoupper($_POST["apellidos"]);
  		     $telx = $_POST["telefonos"]; 
 		     $dirx = strtoupper($_POST["direc"]);
			 $corx = strtoupper($_POST["correo"]);
  		     $rutx = $_POST["rut"];
   
if ( $x_param == 1 ){
			 $link=conectarse();
			 $sql = "INSERT INTO rut (rut,nombre,apellidos,telefonos,direccion,correo) VALUES ('$rutx','$nomx','$apex','$telx','$dirx','$corx')";
			 $result2=mysql_query($sql);
			 mysql_close($link);
			 echo '<script language="javascript">';
			 //echo "alert('Registro Agregado Correctamente!');";
			 echo "location.href='solicitud.php?rut=$rutx';";
			 echo "</script>";
}

if ( $x_param == 2 ){
		 	 $link=conectarse();
    	     $sql= "UPDATE rut SET nombre='$nomx',apellidos='$apex',telefonos='$telx',direccion='$dirx',correo='$corx' WHERE rut='$rutx'";
   		     $result2=mysql_query($sql);
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 //echo "alert('Registro Actualizado Correctamente');";
			 echo "location.href='solicitud.php?rut=$rutx';";
 		     echo "</script>";
}

if ( $x_param == 3 ){
		    /* $idx  = $_GET["id"];
             $link=conectarse();
             $sql="DELETE FROM noticias where id = '$idx'";
             $result = mysql_query($sql);
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Borrado');";
			 echo "location.href='list_publicaciones.php';";
 		     echo "</script>";		*/
}
?>