<?php    include("../seguridadsimple.php");
   include("../fechaclasss.php");
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"] ?? ''; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"] ?? ''; }
	  
$fecha_hoy = date('Y')."/".date('m')."/".date('d');
//$fec = date('d')."/".date('m')."/".date('Y');
	  
$link=Conectarse();
$qry = "SELECT * from parametros where id = 1";
$res = mysql_query($qry);
$tablaperiodo = "cert". mysql_result($res, 0, "periodo");

if ( $x_param == 2 )
{
			 $idx = $_POST["codigo"] ?? '';
		 	 $link=conectarse();
    	     $sql= "UPDATE $tablaperiodo SET estado='4',entregado='$cuentausuario',fecha_retiro='$fecha_hoy' WHERE id='$idx'";
   		     $result2=mysql_query($sql);
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Cambios guardados correctamente');";
			 //echo "location.href='list_solicitudes.php';";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";
 		     echo "</script>";
}

if ( $x_param == 3 ){
			 echo '<script language="javascript">';
			 echo "alert('Entro en modo Borrado');";
 		     echo "</script>";

		    /* $idx  = $_GET["id"] ?? '';
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