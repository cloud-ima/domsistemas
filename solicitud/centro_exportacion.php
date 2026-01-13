<? include("../seguridad.php"); 
$fecha_hoy = date('Y')."-".date('m')."-".date('d');?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<script language='javascript' src="../popcalendar.js"></script>
<script language=javascript type=text/javascript>
function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey;
}
</script>

<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<br>
<table width="475" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="right"></div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td valign="middle"><strong><img src="Images/excelico.jpg" width="111" height="113" align="left"><br>
      <br>
      <br>
      <br>
    <span class="style1">Reporte Diario de Solicitudes de Certificados</span> </strong></td>
  </tr>
  <tr> 
    <td><form name="form1" method="post" action="excel01.php">
        <table width="463" border="0" align="center" cellpadding="0" cellspacing="5">
          <tr> 
            <td width="198">Fecha Inicial</td>
            <td width="349"><font color="#000099"> 
              <input name="desde" type="text" id="dateArriva3" onClick="popUpCalendar(this, form1.dateArriva3, 'yyyy-mm-dd');" value="<? echo $fecha_hoy ?>" size="15" maxlength="10">
              </font></td>
          </tr>
          <tr> 
            <td>Fecha T&eacute;rmino</td>
            <td><font color="#000099"> 
              <input name="hasta" type="text" id="dateArriva4" onClick="popUpCalendar(this, form1.dateArriva4, 'yyyy-mm-dd');" value="<? echo $fecha_hoy ?>" size="15" maxlength="10">
              </font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Consultar"></td>
          </tr>
        </table>
        <br>
      </form></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<?php
include "../footer.php";
?>
