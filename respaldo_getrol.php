<?php
$q=$_GET["q"] ?? '';
//$q='1718-10';
error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
$con = mysql_connect('localhost', 'muniaric_root', 'tnb688dite');
if (!$con)
  {
  die('Error en Conexión ' . mysql_error());
  }

mysql_select_db("muniaric_dom", $con);

$sql="SELECT * FROM propiedades WHERE rol = '$q'";
//$sql="SELECT * FROM propiedades WHERE rol = '1718-10'";

$mensaje = 'Rol no Existe en Nuestra Base de Datos';

$result = mysql_query($sql);

while($row = mysql_fetch_array($result))
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
mysql_close($con);
?> 