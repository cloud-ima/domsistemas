<?php
//Configuracion de la conexion a base de datos
$bd_host = "localhost"; 
$bd_usuario = "root"; 
$bd_password = "mariasmarias"; 
$bd_base = "domsistema"; 

$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 

mysql_select_db($bd_base, $con); 

//consulta todos los empleados

$sql=mysql_query("SELECT * FROM propiedades where id = 1471",$con);

//muestra los datos consultados
echo "</p>Nombres - Departamento - Sueldo</p> n";
while($row = mysql_fetch_array($sql)){
	echo "<p>".$row['direccion']." - ".$row['numero']." - ".$row['depto']."</p> n";
}
?>