<?php

include ("conexion.php");
$link=Conectarse();

$nom=$_POST['nombres'];
$sql=mysql_query("SELECT * FROM propiedades where id = '$nom'",$link);

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