<?php
include("seguridad.php");
//include("fechaclasss.php");

$fecha_hoy = date('d')."/".date('m')."/".date('Y');
$hoy = date('Y')."-".date('m')."-".date('d');
?>
<html>
<head>
<title></title>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language='javascript' src="popcalendar.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 16px;
}
.style3 {color: #FF0000}
.style4 {font-size: 24px}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><? if ($tipousuario == 1 ) { include ("menu-adm.php"); } else { include ("menu-normal.php"); }?></td>
  </tr>
</table>
<br>
<? include("footer.php"); ?>
</body>
</html>