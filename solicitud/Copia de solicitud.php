<?php
include("../seguridad.php");
include("../fechaclasss.php");

$rut_id = $_GET["rut"];
$link=Conectarse();
$qry = "SELECT * FROM rut where rut ='$rut_id'";
$res = mysql_query($qry);
$nombre = mysql_result($res, 0, "nombre"). " ".mysql_result($res, 0, "apellidos");
$tel = mysql_result($res, 0, "telefonos");
$dir = mysql_result($res, 0, "direccion");
$cor = mysql_result($res, 0, "correo");
$parz = 1;

/*if ($tipousuario == 2 or $tipousuario == 3 ) {
 			 echo '<script language="javascript">';
			 echo "alert('Sr. Usuario, no tiene acceso a Este módulo!');";
			 echo "location.href='principal.php';";
			 echo "</script>";
}*/
	
$mensajetitulo="Ingreso de Solicitud";

function suma_fechas($fecha,$ndias)
{
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=split("/", $fecha);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=split("-",$fecha);
              $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
              $nuevafecha=date("Y-m-d",$nueva);
	  return ($nuevafecha);
}

$fec = date('d')."/".date('m')."/".date('Y');
$fecha_hoy = date('d')."/".date('m')."/".date('Y');
$diasplazo = 7;
$fec_entrega = suma_fechas($fec, $diasplazo);
$fec_entrega = cambiaf_a_normal($fec_entrega);
?>
<html>
<head>
<title>MUNIARICA.CL</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<script language='javascript' src="../popcalendar.js"></script>
<script language=javascript type=text/javascript>
function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey;
</script>

<script language=javascript type=text/javascript>
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

<script type="text/javascript">
function enviar(form1){
if(form1.certificado.value=="0"){
     alert("Debe Seleccionar Tipo de Certificado o Permiso") 
     form1.certificado.focus()
return false;
}
if(form1.direccion.value==""){
     alert("Debe Especificar una Dirección") 
     form1.direccion.focus()
return false;
}
if(form1.rol.value==""){
     alert("Debe Ingresar Número de Rol") 
     form1.rol.focus()
return false;
}
if(form1.certificado.value=="10" && form1.mt.value==""){
	  alert("Debe Ingresar los metros cuadrados del B.N.U.P.")
	  form1.mt.focus()
	  return false;
}
if(form1.certificado.value=="10" && form1.dias.value==""){
	  alert("Debe Ingresar los dias para cálculo de B.N.U.P.")
	  form1.dias.focus()
	  return false;
}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style1 {
	color: #000033;
	font-weight: bold;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="750" border="0" align="center" cellpadding="3" cellspacing="3">
  <tr> 
    <td width="391" valign="middle"> 
      <div align="right"></div>
      <div align="left"><font size="3"><strong><? echo $mensajetitulo ?></strong></font></div></td>
    <td width="425"><div align="right"></div></td>
  </tr>
</table>
<form name="form1" method="post" action="mantenedor_solicitud.php" onSubmit="return enviar(this)" >
  <table width="816" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="816" height="480" valign="top"> <TABLE cellSpacing=3 cellPadding=0 width=750 align=center 
border=0>
          <TBODY>
            <TR> 
              <TD bgColor=#ffffff><input name="param" type="hidden" id="param2" value="<? echo $parz ?>"> 
                <input name="rut" type="hidden" id="codigo2" value="<? echo $rut_id ?>"> 
              </TD>
              <TD width="88" align="right" bgColor=#ffffff> <div align="right"> 
                </div></TD>
              <TD width="321" align="right" bgColor=#ffffff>
                <div align="right">
                  <input name="submit" type="submit" value="  Guardar  ">
                  </div></TD>
              <TD width="91" align="right" bgColor=#ffffff><a href="../principal.php"><img src="../images/volver.gif" width="50" height="40" border="0"></a></TD>
            </TR>
            <TR> 
              <TD bgColor=#ffffff><strong>RUT</strong></TD>
              <TD colspan="3" bgColor=#ffffff><font color="#990000"><strong><? echo $rut_id
 ?></strong></font></TD>
            </TR>
            <TR> 
              <TD bgColor=#ffffff>Nombre de Solicitante</TD>
              <TD colspan="3" bgColor=#ffffff><font color="#333333"><strong><? echo $nombre
 ?></strong></font></TD>
            </TR>
            <TR> 
              <TD width="235" bgColor=#ffffff>Direcci&oacute;n y Tel&eacute;fonos 
                de Contacto</TD>
              <TD colspan="3" bgColor=#ffffff><font color="#333333"><strong><? echo $dir . " -------- " . $tel;

 ?></strong> <br>
                <strong><? echo $cor;

 ?></strong> </font></TD>
            </TR>
            <TR> 
              <TD colspan="4" bgColor=#ffffff><hr></TD>
            </TR>
            <TR> 
              <TD bgColor=#ffffff>Tipo Certificado o Permiso</TD>
              <TD colspan="3" bgColor=#ffffff> 
                <?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM tipocertificado order by nombre",$linkc);
?>
                <select class=bordecampos name="certificado" id="select7">
                  <option value="0">Seleccione Tipo de Certificado o Permiso...</option>
                  <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                  <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $tc){?>selected<?}?>> <? echo $rowc["nombre"]?> </option>
                  <? }
mysql_close($linkc);
?>
                </select></TD>
            </TR>
            <TR> 
              <TD bgColor=#ffffff><SPAN >Fecha Ingreso</SPAN></TD>
              <TD colspan="3" bgColor=#ffffff><font color="#000099"> 
                <input name="fecha" type="hidden" value="<? echo $fecha_hoy; ?>" size="11" maxlength="10">
                <strong><? echo $fec;
 ?></strong></font></TD>
            </TR>
            <TR> 
              <TD bgColor=#ffffff>Fecha de Entrega</TD>
              <TD colspan="3" bgColor=#ffffff><font color="#000099"> 
                <input name="fentrega" type="text" id="dateArriva9" onClick="popUpCalendar(this, form1.dateArriva9, 'dd-mm-yyyy');" value="<? echo $fec_entrega; ?>" size="11" maxlength="10">
                </font> </TD>
            </TR>
            <TR bgcolor="#ADBEE4"> 
              <TD height="20" colspan="4"><div align="center" class="style1">Para 
                  Solicitud de Certificados</div></TD>
            </TR>
            <TR> 
              <TD bgColor=#ffffff>Direcci&oacute;n Completa</TD>
              <TD colspan="3" valign="top" bgColor=#ffffff> <textarea name="direccion" cols="70" rows="3" class="bordecampos" id="direccion">
</textarea> 
              </TD>
            </TR>
            <TR> 
              <TD bgColor=#ffffff>N&uacute;mero de Rol</TD>
              <TD colspan="3" bgColor=#ffffff><input  name="rol" type="text" class=bordecampos id="rol" size="20" maxlength="20"></TD>
            </TR>
            <TR bgcolor="#ADBEE4"> 
              <TD height="20" colspan="4"> <div align="center" class="style1">Para 
                  Solicitud de Permisos B.N.U.P. | Patentes y Certificado Numero</div></TD>
            </TR>
            <TR> 
              <TD bgColor=#ffffff>Metros Lineales</TD>
              <TD bgColor=#ffffff><input  name="mt" type="text" class=bordecampos id="mt" size="7" maxlength="10"> 
              </TD>
              <TD colspan="2" bgColor=#ffffff><table width="318" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="121">D&iacute;as de uso</td>
                  <td width="197"><input  name="dias" type="text" class=bordecampos id="dias" size="7" maxlength="10"></td>
                </tr>
              </table></TD>
            </TR>
            <TR> 
              <TD bgColor=#ffffff>Rubro , Giro</TD>
              <TD colspan="3" bgColor=#ffffff><textarea name="rubro" cols="70" rows="3" class="bordecampos" id="rubro"></textarea> 
              </TD>
            </TR>
            <TR> 
              <TD height="25" bgColor=#ffffff>Atendido por</TD>
              <TD colspan="3" bgColor=#ffffff><p><font color="#000099"><strong><? echo $nombreusuario; ?></strong></font></p></TD>
            </TR>
            <TR> 
              <TD colspan="4" bgColor=#ffffff> 
                <? include "../footer.php" ?>
              </TD>
            </TR>
          </TBODY>
        </TABLE></td>
    </tr>
  </table>
</form>
</body>
</html>