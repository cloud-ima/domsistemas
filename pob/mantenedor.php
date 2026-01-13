<?
include("../conexion.php");   
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"]; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"]; }
   
if ( $x_param == 1 ){

			 $nomx = $_POST["nombre"];
			 $link=conectarse();
			 $sql = "INSERT INTO pob (nombre) VALUES ('$nomx')";
			 $result2=mysql_query($sql);
			 mysql_close($link);
			 
			 echo '<script language="javascript">';
			 echo "alert('Registro Agregado Correctamente!');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";			 
//			 echo "location.href='index.php';";
//			 echo "opener.window.location.reload( false );";
//	         echo "window.close();";
			 echo "</script>";
}

if ( $x_param == 2 ){
			 $nomx = $_POST["nombre"];
			 $idx  = $_POST["codigo"];
		 
		 	 $link=conectarse();
    	     $sql= "UPDATE pob SET nombre='$nomx' WHERE id='$idx'";
   		     $result2=mysql_query($sql);
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Actualizado Correctamente');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";			 
     //		 echo "location.href='index.php';";			 
	//		 echo "opener.window.location.reload( false );";
	 //      echo "window.close();";
 		     echo "</script>";
}

if ( $x_param == 3 ){
		     $idx  = $_GET["id"];
             $link=conectarse();
             $sql="DELETE FROM pob where id = '$idx'";
             $result = mysql_query($sql);
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Borrado');";
			// echo "opener.window.location.reload( false );";
	        // echo "window.close();";			 
			 echo "location.href='index.php';";
			// echo "opener.window.location.reload( false );";
 		     echo "</script>";		
}
?>