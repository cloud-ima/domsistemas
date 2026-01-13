<?php
include("../seguridadsimple.php");
include("../fechaclasss.php");

$hoy = date('Y')."-".date('m')."-".date('d');
$rut_id=$_GET['rut'];
$sol_id=$_GET['id'];

$link=Conectarse();
$qry = "SELECT * FROM rut where rut ='$rut_id'";
$res = mysql_query($qry);
$nombre = mysql_result($res, 0, "nombre"). " ".mysql_result($res, 0, "apellidos");
$tel = mysql_result($res, 0, "telefonos");
$mail = strtolower(mysql_result($res, 0, "correo"));

$link=Conectarse();
$qry = "SELECT * from parametros where id = 1";
$res = mysql_query($qry);
$tablaperiodo = "cert". mysql_result($res, 0, "periodo");

$link=Conectarse();
$qry = "SELECT * FROM $tablaperiodo where id ='$sol_id'";
$res = mysql_query($qry);
$fecha_sol = mysql_result($res, 0, "fecha_solicitud");
$total = mysql_result($res, 0, "total");
$direccion = mysql_result($res, 0, "direccion");
$idcert = mysql_result($res, 0, "idcert");
$dias = mysql_result($res, 0, "dias");
$mt = mysql_result($res, 0, "mt");
$rol = mysql_result($res, 0, "rol");
$giro = mysql_result($res, 0, "giro_numero");
$gfecha = mysql_result($res, 0, "giro_fecha");
$estado = mysql_result($res, 0, "estado");
$ac = mysql_result($res, 0, "responsable");
$fecha_ent = cambiaf_a_normal(mysql_result($res, 0, "fecha_entrega"));
$fecha_ret = cambiaf_a_normal(mysql_result($res, 0, "fecha_retiro"));
$usuario = mysql_result($res, 0, "usuario");
$entregado = mysql_result($res, 0, "entregado");
$rub = mysql_result($res, 0, "rubro");
$ot = mysql_result($res, 0, "orden_numero");

if ( $gfecha == '' ) { $gfecha = cambiaf_a_normal($hoy); }

$parz = 2;

$link=Conectarse();
$qry = "SELECT * FROM tipocertificado where id ='$idcert'";
$res = mysql_query($qry);
$nombrecerti = mysql_result($res, 0, "nombre");

$link=Conectarse();
$qry = "SELECT * FROM estado where id ='$estado'";
$res = mysql_query($qry);
$nombreestado = mysql_result($res, 0, "nombres");


$link=Conectarse();
$qry = "SELECT * FROM usuarios where usuario ='$usuario'";
$res = mysql_query($qry);
$atendido = mysql_result($res, 0, "nombre");

$quienentrego = '';
if ( $entregado <> '' ) {
$link=Conectarse();
$qry = "SELECT * FROM usuarios where usuario ='$entregado'";
$res = mysql_query($qry);
$quienentrego = mysql_result($res, 0, "nombre");
 }

if ( $responsable <> '' ) {
$link=Conectarse();
$qry = "SELECT * FROM usuarios where usuario ='$responsable'";
$res = mysql_query($qry);
$quienlohizo = mysql_result($res, 0, "nombre");
}

mysql_close($link);

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="entregarcert.php">
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="663" height="505" align="center" valign="top"> <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="565"> <table width="650" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="650" height="49" valign="middle"> <div align="center" class="style1"> 
                      <font size="5"><strong>Orden de Atenci&oacute;n 
                      Nr.</strong></font><strong>                      <font size="5" face="Geneva, Arial, Helvetica, sans-serif"><? echo $sol_id
 ?><br>
                      <font size="3">(<? echo $nombreestado ?>)</font></font></strong></div></td>
                </tr>
              </table>
              <table width="650" border="0" cellspacing="2" cellpadding="2">
                <tr> 
                  <td width="726" bgcolor="#666666"><font color="#FFFFFF"><strong>IDENTIFICACION 
                    DEL CONTRIBUYENTE</strong></font></td>
                </tr>
              </table>
              <table width="650" border="0" cellpadding="2" cellspacing="2">
                <tr> 
                  <td bgcolor="#efefef">Se&ntilde;or(a) </td>
                  <td><strong><font color="#990000"><? echo $rut_id
 ?></font> , <font color="#333333"><? echo $nombre
 ?> 
                    <input name="param" type="hidden" id="param2" value="2">
                    <input name="codigo" type="hidden" id="param" value="<? echo $sol_id; ?>">
                    </font></strong></td>
                </tr>
                <tr> 
                  <td width="115" height="22" bgcolor="#efefef">Fono/Email </td>
                  <td width="519"><? echo $tel
 ?> ------- <? echo $mail;

 ?></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="97" valign="top"> <table width="650" border="0" cellspacing="2" cellpadding="2">
                <tr> 
                  <td bgcolor="#666666"> <div align="left"><font color="#FFFFFF"><strong>ANTECEDENTES 
                      DEL SERVICIO </strong></font></div></td>
                </tr>
              </table>
              <div align="justify"> 
                <table width="650" border="0" cellpadding="2" cellspacing="2">
                  <tr> 
                    <td bgcolor="#efefef">Tipo de Certificado</td>
                    <td colspan="2"><? echo $nombrecerti ?></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef"><font color="#CC0000">* Solo para BNUP</font></td>
                    <td width="248">Metros Lineales: <? echo $mt ?></td>
                    <td width="323">Dias :<? echo $dias ?></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">Direcci&oacute;n</td>
                    <td colspan="2"><? echo $direccion ?> , ROL: <? echo $rol ?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#efefef">Rubro</td>
                    <td colspan="2"><? echo $rub ?></td>
                  </tr>
                  <tr> 
                    <td width="136" bgcolor="#efefef">Fecha Solicitud</td>
                    <td colspan="2"><? echo $fecha_sol ?> <div align="justify"></div></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">Fecha Entrega</td>
                    <td colspan="2"><input name="fentrega" type="text" id="dateArriva1" onClick="popUpCalendar(this, form1.dateArriva1, 'dd-mm-yyyy');" value="<? echo $fecha_ent; ?>" size="11" maxlength="10"></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">Atendido por</td>
                    <td colspan="2"><? echo $atendido ?></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">TOTAL $</td>
                    <td colspan="2"><? echo $total ?></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">Responsable</td>
                    <td colspan="2"> 
                      <?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM usuarios where usuario <> 'administrador' order by nombre",$linkc);
?>
                      <select class=bordecampos name="responsable" id="select7" disabled>
                        <option value="0">Seleccione Responsable...</option>
                        <?php
while($rowc = mysql_fetch_array($resultc)){
?>
                        <option value="<? echo $rowc["usuario"] ?>"
<? if($rowc["usuario"] == $ac){?>selected<?}?>> <? echo $rowc["nombre"]?> </option>
                        <? }
mysql_close($linkc);
?>
                      </select></td>
                  </tr>
                  <tr> 
                    <td height="18" colspan="3" bgcolor="#666666"><font color="#FFFFFF"><strong>DATOS 
                      CONTABLES </strong></font></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">N&uacute;mero de Giro</td>
                    <td colspan="2"> <input disabled name="giro" type="text" id="giro" value="<? echo $giro ?>" size="20"></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">Fecha del Giro</td>
                    <td colspan="2"><input  disabled name="fgiro" type="text" id="dateArriva2" onClick="popUpCalendar(this, form1.dateArriva2, 'dd-mm-yyyy');" value="<? echo $gfecha ?>" size="20" maxlength="10"></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">N&uacute;mero de O.T.</td>
                    <td> <input  disabled name="ot" type="text" id="ot" value="<? echo $ot ?>" size="20"></td>
                    <td><table width="137" border="0" cellspacing="3" cellpadding="3">
                        <tr> 
                          <td width="66"><input type="submit" name="Submit" value="Entregar Certificado"></td>
                          <td width="57"> <input name="button" type="button"
       onClick="window.close();" 
       value="Cerrar "></td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>