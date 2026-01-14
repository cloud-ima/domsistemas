<?php
include "../seguridad.php";
include("../fechaclasss.php");

if ($tipousuario <> 1 ) {
			 echo '<script language="javascript">';
			 echo "alert('Sr. usuario no tiene los permisos para ingresar a esta secci�n');";
			 echo "location.href='list_solicitudes.php';";
 		     echo "</script>";
}			 
  
?>
<html>
<head>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language='javascript' src="../popcalendar.js"></script>
</head>
<body leftmargin="0" topmargin="0">
<table width="486" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="486"> <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="3"><strong>Consulta de Solicitudes Vigentes</strong></font></div></td>
  </tr>
</table>
<br>
<table width="487" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr> 
    <td width="421" valign="middle"> <table width="303" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="133" valign="top">Nro. Solicitud </td>
          <td width="170" valign="top"> <form name="form1" method="post" action="mostrar_solicitud_estado.php">
              <table width="147" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="90" valign="bottom"><input name="id" type="text" id="id" size="15" maxlength="15"></td>
                  <td width="10" valign="middle">&nbsp;                  </td>
                  <td width="47" valign="middle"><input name="imageField" type="image" onClick="nombreFormulario.send();return false" src="../images/zoom.gif" width="24" height="22" border="0"></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table>      </td>
  </tr>
</table>
<br>
<?php
include "../footer.php";
?>
</body>
</html>