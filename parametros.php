<?php
include("seguridad.php");
//include("fechaclasss.php");

if ( $tipousuario <> 1 ) { 
			 echo '<script language="javascript">';
			 echo "alert('Sr. Usuario no tiene acceso a este m�dulo');";
			 echo "location.href='principal.php';";
			 echo "</script>";
}

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
	color: #333333;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="49%" height="249" align="left" valign="top"> 
      <div align="left"></div>
      <div align="left">
        <br>
        <table width="900" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td colspan="2"><div align="center"></div></td>
            <td width="801"><span class="style2">Par&aacute;metros de Sistema, Seguimiento y Propiedades </span></td>
          </tr>
          <tr>
            <td width="8">&nbsp;</td>
            <td colspan="2" align="left"><table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="43%" valign="top"><table width="252" border="0" align="right" cellpadding="2" cellspacing="2">
                  <tr>
                    <td width="46"><div align="left"><img src="images/form-ico.jpg" width="40" height="39"></div></td>
                    <td width="192" valign="middle"><a href="zonas/">Creaci&oacute;n de Zonas </a></td>
                  </tr>
                  <tr>
                    <td><div align="left"><img src="images/form-ico.jpg" width="40" height="39"></div></td>
                    <td valign="middle"><a href="clases/">Creaci&oacute;n de Clases </a></td>
                  </tr>
                  <tr>
                    <td><img src="images/form-ico.jpg" width="40" height="39"></td>
                    <td valign="middle"><a href="tipocertificado/">Tipos de Certificados </a></td>
                  </tr>
                  <tr>
                    <td><img src="images/form-ico.jpg" width="40" height="39"></td>
                    <td valign="middle"><a href="parametros/">Par&aacute;metros Financieros</a> </td>
                  </tr>
                  <tr>
                    <td><img src="images/form-ico.jpg" width="40" height="39"></td>
                    <td valign="middle"><a href="pob/">Poblaciones </a></td>
                  </tr>
                  <tr>
                    <td><img src="images/form-ico.jpg" width="40" height="39"></td>
                    <td valign="middle"><a href="directores/">Directores y Activaci&oacute;n Firmas</a></td>
                  </tr>
                </table>
                  <br>
                  </td>
                <td width="57%" valign="top">                  <table width="300" border="0" align="left" cellpadding="2" cellspacing="2">
                  <tr>
                    <td width="47"><div align="left"><img src="images/form-ico.jpg" width="40" height="39"></div></td>
                    <td width="253" valign="middle"><a href="tipopropiedades/">Tipo de Propiedades </a></td>
                  </tr>
                  <tr>
                    <td><div align="left"><img src="images/form-ico.jpg" width="40" height="39"></div></td>
                    <td valign="middle"><a href="usos/">Usos de Suelo </a></td>
                  </tr>
                  <tr>
                    <td><img src="images/form-ico.jpg" width="40" height="39"></td>
                    <td valign="middle"><a href="destino/">Destinos de la Propiedad </a></td>
                  </tr>
                  <tr>
                    <td><img src="images/form-ico.jpg" width="40" height="39"></td>
                    <td valign="middle"><a href="usuarios/">Usuarios</a></td>
                  </tr>
                  <tr>
                    <td><img src="images/form-ico.jpg" width="40" height="39"></td>
                    <td valign="middle"><a href="solicitud/consultaestado.php">Modificar Estado de Solicitud </a></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td valign="middle">&nbsp;</td>
                  </tr>
                </table>                  
                <div align="center"></div></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
<br>
<?php include("footer.php"); ?>
</body>
</html>