<html>
<head>
<title>Registro con AJAX</title>
<script language="JavaScript" type="text/javascript" src="ajax.js"></script>
</head>
<body>
<form name="nuevo_empleado" action="" 
onsubmit="enviarDatosEmpleado(); return false">
<table width="300" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="82">Nr. Rol</td>
    <td width="101"><input name="nombres" type="text" /></td>
    <td width="101"><input type="submit" name="Submit" value="Consultar" /></td>
  </tr>
</table>
<p><label>    </label>
  </p>
</form>
<div id="resultado"><?php //include('consulta.php');?></div>
</body>
</html>