<?
   include("../conexion.php");
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"]; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"]; }
   
if ( $x_param == 1 ){
			 $desx = $_POST["nom"];
 			 $titx = $_POST["tit"];
			 $carx = $_POST["car"];			 
			 $link=conectarse();
			 $sql = "INSERT INTO directores (nombre,titulo,cargo) VALUES ('$desx','$titx','$carx')";
			 $result2=mysql_query($sql);
			 mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Agregado Correctamente!');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";
			 echo "</script>";
}

if ( $x_param == 2 ){
			 $desx = $_POST["nom"];
 			 $titx = $_POST["tit"];
			 $carx = $_POST["car"];			 
			 
			 $idx  = $_POST["codigo"];
		 
		 	 $link=conectarse();
    	     $sql= "UPDATE directores SET nombre='$desx',titulo = '$titx',cargo='$carx' WHERE id='$idx'";
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
			 $idx  = $_GET["id"];
             $link=conectarse();
   	         $sql="DELETE FROM directores where id = '$idx'";
       	     $result = mysql_query($sql);
	    	 mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Borrado');";
			 echo "location.href='index.php';";
			 echo "opener.window.location.reload( false );";
	         //echo "window.close();";
 		     echo "</script>";		
}
if ( $x_param == 4 ){
			$idx  = $_GET["id"];
			
            $link=conectarse();
 	        $sql="update directores set activo = 'N'";
     	    $result = mysql_query($sql);
  		    mysql_close($link);
			
            $link=conectarse();			
    	    $sql= "UPDATE directores SET activo='S' WHERE id='$idx'";
   		    $result2=mysql_query($sql);
  		    mysql_close($link);

			echo '<script language="javascript">';
			echo "location.href='index.php';";
			echo "opener.window.location.reload( false );";
 		    echo "</script>";		
}

?>