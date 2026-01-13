<?php

$bd_host = "localhost"; 
$bd_usuario = "root"; 
$bd_password = "mariasmarias"; 
$bd_base = "domsistema"; 

$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 

mysql_select_db($bd_base, $con); 

//consulta todos los empleados

$sql=mysql_query("SELECT * FROM propiedades limit 1",$con);

//muestra los datos consultados
//haremos uso de tabla para tabular los resultados
?>
<table style="border:1px solid #FF0000; color:#000099;width:400px;">
<tr style="background:#99CCCC;">
	<td>Nombres</td>
	<td>Departamento</td>
	<td>Sueldo</td>
</tr>

<?php
while($row = mysql_fetch_array($sql)){
	echo "	<tr>";
	echo " 		<td>".$row['direccion']."</td>";
	echo " 		<td>".$row['numero']."</td>";
	echo " 		<td>".$row['depto']."</td>";
	echo "	</tr>";
}
?>
</table>