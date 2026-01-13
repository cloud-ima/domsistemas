<?
session_start();
$id = session_id();
include("conexion.php");
$user=$_POST['txtLogin'];
$pass=$_POST['txtClave'];

     // $link=conectarse();
     // $sql= "select * from usuarios where session='$id' ";
      //$result2=mysql_query($sql);
	 // if ($row = mysql_fetch_array($result2)){
	        $nada="";
	  		$link=conectarse();
		    $sql= "UPDATE usuarios SET session='$nada' where session = $id";
		    $result2=mysql_query($sql);
	        mysql_close($link);
			header ("location: login.php?error=Sesión Terminada!!");
	//  }
?>