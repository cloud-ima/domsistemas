<?php
$id = session_id();
include("seguridad.php");
$pold = $_POST['passold'] ?? '';
$p1 = $_POST['pass1'] ?? '';
$link=conectarse();
$qry = "SELECT * FROM usuarios where session = '$id'";
$res = mysql_query($qry);
$password = mysql_result($res, 0, "password");
						
if ( $password == $pold )
 {
		$link=conectarse();
		$sql="UPDATE usuarios SET password='$p1' WHERE session='$id'";
		$result = mysql_query($sql);
		mysql_close($link);
		echo '<script language="javascript">';
		echo "alert('PassWord Cambiado Correctamente!');";
        echo "location.href='principal.php';";			 
        echo "</script>";
 }		
else
 {
		echo '<script language="javascript">';
		echo "alert('el password Actual se encuentra erroneo, por favor Ingrese Nuevamente!');";
		echo "location.href='cambiopass.php';";
        echo "</script>";
 }

?>
