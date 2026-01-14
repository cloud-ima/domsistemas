<?php
//Desarrollado por Jesus Liñán
//ribosomatic.com
//Puedes hacer lo que quieras con el código
//pero visita la web cuando te acuerdes

//Configuracion de la conexion a base de datos
$bd_host = "localhost"; 
$bd_usuario = "root"; 
$bd_password = "mariasmarias"; 
$bd_base = "domsistema"; 

$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 

mysql_select_db($bd_base, $con); 
$idtest=$_GET['rol'] ?? '';
//$idtest = 1471;
//echo $idtest;

//consulta todos los empleados

$sql=mysql_query("SELECT * FROM propiedades where id = $rol",$con);

//muestra los datos consultados
//echo "<p>Nombres - Departamento - Sueldo</p> \n";
while($row = mysql_fetch_array($sql)){
	echo "<p>".$row['direccion']." - ".$row['numero']." - ".$row['depto']."</p> \n";
}
?>