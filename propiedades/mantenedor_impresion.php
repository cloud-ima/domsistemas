<?
   include("../seguridadsimple.php");
   include("../fechaclasss.php");
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"]; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"]; }
	  
$link=Conectarse();


if ( $x_param == 1 ){

			// $idx = $_POST['id'];
			  $rolx = $_POST['rol'];
			  $direx = $_POST['dire'];
			  $viax = $_POST['via'];
			  $numx = $_POST['num'];
			  $blockx = $_POST['block'];
			  $deptox = $_POST['depto'];
			  $sitiox = $_POST['sitio'];
			  $manx = $_POST['man'];
			  $pobx = $_POST['pob'];
			  $refx = $_POST['referencia'];
			  $zonax = $_POST['zona'];
			  $urbax = $_POST['urba'];
			  $tipox = $_POST['tipo'];
			  $usox = $_POST['uso'];
			  $expox = $_POST['expo'];
			  $radiox = $_POST['radio'];
			  $classx = $_POST['class'];
			  $mtx = $_POST['mt'];
			  $mtcx = $_POST['mtc'];
			  $kx = $_POST['kardex'];
			  $obsx = $_POST["FCKeditor2"];
			  
   			 $link=conectarse();
			 $sql = "INSERT INTO propiedades (rol,tipocalle,direccion,numero,depto,block,pob,manzana,sitio,clase,tipo,mt2total,mt2cons,uso,nombre_referencial,urbanizacion,kardex,expropiacion,radiourbano,zona,obs) VALUES
                                         ('$rolx','$viax','$direx','$numx','$deptox','$blockx','$pobx','$manx','$sitiox','$classx','$tipox','$mtx','$mtcx','$usox','$refx','$urbax','$kx','$expox','$radiox','$zonax','$obsx')";
			 $result2=mysql_query($sql);
			 $ultimo_id = mysql_insert_id($link);
			 mysql_close($link);
			 $linknuevo = 'propiedades.php?id='.$ultimo_id.'&flag=1';
			 echo '<script language="javascript">';
			 echo "alert('Nueva registro de Propiedad Correctamente, con Nro. Folio : $ultimo_id; ');";
			 echo "location.href='$linknuevo';";
			 echo "</script>";
}

if ( $x_param == 2 ){
			 $idx = $_POST['codigo'];
			 $rolx = $_POST['rol'];
			 $direx = $_POST['dire'];
			 $viax = $_POST['via'];
			 $numx = $_POST['num'];
			 $blockx = $_POST['block'];
			 $deptox = $_POST['depto'];
			 $sitiox = $_POST['sitio'];
			 $manx = $_POST['man'];
			 $pobx = $_POST['pob'];
			 $refx = $_POST['referencia'];
			 $zonax = $_POST['zona'];
			 $urbax = $_POST['urba'];
			 $tipox = $_POST['tipo'];
			 $usox = $_POST['uso'];
			 $expox = $_POST['expo'];
			 $radiox = $_POST['radio'];
			 $classx = $_POST['class'];
			 $mtx = $_POST['mt'];
			 $mtcx = $_POST['mtc'];
			 $kx = $_POST['kardex'];
			 $obsx = $_POST["FCKeditor2"];			 
 			 $linknuevo = 'propiedades.php?id='.$idx.'&flag=1';

		 	 $link=conectarse();
    	     $sql= "UPDATE propiedades SET
			 tipocalle='$viax',
			 direccion='$direx',
			 numero='$numx',
			 depto='$deptox',
			 block='$blockx',
			 pob='$pobx',
			 manzana='$manx',
			 sitio='$sitiox',
			 clase='$classx',
			 tipo='$tipox',
			 mt2total='$mtx',
			 mt2cons='$mtcx',
			 uso='$usox',
			 nombre_referencial='$refx',
			 urbanizacion='$urbax',
			 kardex='$kx',
			 expropiacion='$expox',
			 radiourbano='$radiox',
			 obs='$obsx',
			 zona='$zonax' WHERE id='$idx'";
   		     $result2=mysql_query($sql);
  		     mysql_close($link);
			 /*echo "opener.window.location.reload( false );";
	         echo "window.close();";
 		     echo "</script>"*/;
			 
		
						 echo '<script language="javascript">';
						 echo "alert('Cambios guardados correctamente');";
						 echo "location.href='$linknuevo';";
						 echo "</script>";
}

if ( $x_param == 3 ){
			 echo '<script language="javascript">';
			 echo "alert('Entro en modo Borrado');";
 		     echo "</script>";

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