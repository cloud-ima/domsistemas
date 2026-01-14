<?php session_start();
$id = session_id();
include("conexion.php");
$user=$_POST['txtLogin'] ?? '';
$pass=$_POST['txtClave'] ?? '';

      $link=conectarse();
      $sql= "select * from usuarios where session='$id' ";
      $result2=mysql_query($sql);
	  if ($row = mysql_fetch_array($result2)){
	        $nada="";
	  		$link=conectarse();
		    $sql= "UPDATE usuarios SET session='$nada' where session='$id' ";
		    $result2=mysql_query($sql);
	        mysql_close($link);
	  }

//********************************************************

$link=conectarse();
$result=mysql_query("select * from usuarios where usuario like '$user' and password like '$pass'", $link);
if ($row = mysql_fetch_array($result)){
    $tipx=$row["tipo"];
do {

   if ($row["estado"] == 1) {
      session_start();
	  $id = session_id();
	  /*
      $_SESSION['acceso']=$row["tipo"];
      $_SESSION['user']=$row["usuario"];
	  $_SESSION['idnom']=$row["nombre"];*/
	  $link=conectarse();
      $sql= "UPDATE usuarios SET session='$id' WHERE usuario = '$user'";
      $result2=mysql_query($sql);
      mysql_close($link);
      header ("location: principal.php");
   }

   if ($row["estado"] == 0) {
      header ("location: login.php?error=El Usuario ingresado ha sido desabilitado...!!");
   }
   
} while ($row= mysql_fetch_array($result));
} else {
   header ("location: login.php?error=Usuario o Contraseña Incorrecto!!");
}
mysql_close($link);
?>