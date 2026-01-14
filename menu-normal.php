<?php
$fecha_hoy = date('d')."/".date('m')."/".date('Y');
$hoy = date('Y')."-".date('m')."-".date('d');

		  $link=Conectarse(); 
		  $qry = "SELECT * from parametros where id = 1";
		  $res = mysql_query($qry);
		  $tablaperiodo = "cert". mysql_result($res, 0, "periodo");
		  
		  $link=Conectarse();
  	      $sql2= "select * from $tablaperiodo WHERE fecha_solicitud = '$hoy' ";
		  $ressum = mysql_query($sql2);
		  $tot2 = mysql_num_rows($ressum);
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
<table width="900" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td align="center"><span class="style2">Informaci&oacute;n de Estad&iacute;stica Diaria : <?php echo $fecha_hoy ?> ----------&gt; Solicitudes del D&iacute;a (<?php echo $tot2 ?>) </span></td>
  </tr>
  <tr>
    <td align="left"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="38%" valign="top"><br>
              <table width="300" border="0" align="center" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="47"><div align="left"><a href="solicitud/ingresa.php"><img src="images/iconos_1.jpg" width="365" height="83" border="0"></a></div></td>
                </tr>
                <tr>
                  <td><div align="left"><a href="solicitud/list_solicitudes.php"><img src="images/iconos_2.jpg" width="365" height="87" border="0"></a></div></td>
                </tr>
                <tr>
                  <td><a href="solicitud/list_solicitudes_ok.php"><img src="images/iconos_3.jpg" width="365" height="83" border="0"></a></td>
                </tr>
                <tr>
                  <td><a href="solicitud/entregar.php"><img src="images/iconos_4.jpg" width="365" height="84" border="0"></a></td>
                </tr>
                <tr>
                  <td><a href="solicitud/centro_exportacion.php"><img src="images/iconos_5.jpg" width="365" height="82" border="0"></a></td>
                </tr>
            </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>