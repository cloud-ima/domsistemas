<?php
include("../conexion.php");
$q=$_GET["q"] ?? '';
//$q='1718-10';

	$link=conectarse();
	$ssql="SELECT * FROM propiedades WHERE rol = '$q'";
	$mensaje = 'Rol no Existe en Nuestra Base de Datos';
    $rs = mysql_query($ssql,$link);

	while($row = mysql_fetch_array($rs))
  {
  
   if ( $row["numero"] == 0 ) { $mensaje = $row['direccion'] ; }
   else
		{
	   	    $mensaje = $row['direccion'] . ' ' . $row['numero'];
    	}
			
   if ( $row["depto"] <> '0' ) { 
            $mensaje = $mensaje . ' Depto. Nr. : ' . $row['depto'] . ' Block : ' . $row['block'] ; }
   }
   
echo $mensaje;
mysql_close($link);
?> 