<?php
include("../seguridadsimple.php");
include("../topmenu2.php");
include("../fechaclasss.php");

$hoy = date('Y')."-".date('m')."-".date('d');
$sol_id=$_POST['id'] ?? '';

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
$estadoid = mysql_result($res, 0, "estado");
$ac = mysql_result($res, 0, "responsable");
$fecha_ent = cambiaf_a_normal(mysql_result($res, 0, "fecha_entrega"));
$fecha_ret = cambiaf_a_normal(mysql_result($res, 0, "fecha_retiro"));
$usuario = mysql_result($res, 0, "usuario");
$entregado = mysql_result($res, 0, "entregado");
$rub = mysql_result($res, 0, "rubro");
$ot = mysql_result($res, 0, "orden_numero");
$rut_id=mysql_result($res, 0, "rut");

$link=Conectarse();
$qry = "SELECT * FROM rut where rut ='$rut_id'";
$res = mysql_query($qry);
$nombre = mysql_result($res, 0, "nombre"). " ".mysql_result($res, 0, "apellidos");
$tel = mysql_result($res, 0, "telefonos");
$mail = strtolower(mysql_result($res, 0, "correo"));

$parz = 4;

$link=Conectarse();
$qry = "SELECT * FROM tipocertificado where id ='$idcert'";
$res = mysql_query($qry);
$nombrecerti = mysql_result($res, 0, "nombre");

$link=Conectarse();
$qry = "SELECT * FROM estado where id ='$estadoid'";
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
<form name="form1" method="post" action="mantenedor_solicitud.php">
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="663" height="505" align="center" valign="top"> <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="565"> <table width="650" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="650" height="49" valign="middle"> <div align="center" class="style1"> 
                      <font size="5"><strong>Orden de Atenci&oacute;n 
                      Nr.</strong></font><strong>                      <font size="5" face="Geneva, Arial, Helvetica, sans-serif"><?php echo $sol_id
 ?><br>
                      <font size="3">(<?php echo $nombreestado ?>)</font></font></strong></div></td>
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
                  <td><strong><font color="#990000"><?php echo $rut_id
 ?></font> , <font color="#333333"><?php echo $nombre
 ?> 
                    <input name="param" type="hidden" id="param2" value="4">
                    <input name="codigo" type="hidden" id="param" value="<?php echo $sol_id; ?>">
                    </font></strong></td>
                </tr>
                <tr> 
                  <td width="115" height="22" bgcolor="#efefef">Fono/Email </td>
                  <td width="519"><?php echo $tel
 ?> ------- <?php echo $mail;

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
                    <td colspan="2"><?php echo $nombrecerti ?></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef"><font color="#CC0000">* Solo para BNUP</font></td>
                    <td width="248">Metros Lineales: <?php echo $mt ?></td>
                    <td width="323">Dias :<?php echo $dias ?></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">Direcci&oacute;n</td>
                    <td colspan="2"><?php echo $direccion ?> , ROL: 
                      <input name="rol_aux" type="<?php echo $seguridaddecampo; ?>" id="rol_aux" value="<?php echo $rol ?>" size="20"> 
                    <?php echo $rol ?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#efefef">Rubro</td>
                    <td colspan="2"><?php echo $rub ?></td>
                  </tr>
                  <tr> 
                    <td width="136" bgcolor="#efefef">Fecha Solicitud</td>
                    <td colspan="2"><?php echo $fecha_sol ?> <div align="justify"></div></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">Fecha Entrega</td>
                    <td colspan="2"><input name="fentrega" type="text" id="dateArriva1" onClick="popUpCalendar(this, form1.dateArriva1, 'dd-mm-yyyy');" value="<?php echo $fecha_ent; ?>" size="11" maxlength="10"></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">Atendido por</td>
                    <td colspan="2"><?php echo $atendido ?></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">TOTAL $</td>
                    <td colspan="2"><?php echo $total ?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#efefef">Responsable</td>
                    <td colspan="2"><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM usuarios where usuario <> 'administrador' order by nombre",$linkc);
?>
                      <select class=bordecampos name="responsable" id="select7">
                        <option value="0">Seleccione Responsable...</option>
                        <?php
while($rowc = mysql_fetch_array($resultc)){
?>
                        <option value="<?php echo $rowc["usuario"] ?>"
<?php if($rowc["usuario"] == $ac){?>selected<?php }?>> <?php echo $rowc["nombre"]?> </option>
                        <?php }
mysql_close($linkc);
?>
                      </select></td>
                  </tr>
                  <tr>
                    <td bgcolor="#efefef">Estado</td>
                    <td colspan="2"><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM estado order by id",$linkc);
?>
                      <select class=bordecampos name="estado" id="select7">
                        <option value="0">Seleccione Estado...</option>
                        <?php
while($rowc = mysql_fetch_array($resultc)){
?>
                        <option value="<?php echo $rowc["id"] ?>"
<?php if($rowc["id"] == $estadoid){?>selected<?php }?>> <?php echo $rowc["nombres"]?> </option>
                        <?php }
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
                    <td colspan="2"> <input name="giro" type="text" id="giro" value="<?php echo $giro ?>" size="20"></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">Fecha del Giro</td>
                    <td colspan="2"><input name="fgiro" type="text" id="dateArriva2" onClick="popUpCalendar(this, form1.dateArriva2, 'dd/mm/yyyy');" value="<?php echo $gfecha ?>" size="20" maxlength="10"></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#efefef">N&uacute;mero de O.T.</td>
                    <td> <input name="ot" type="text" id="ot" value="<?php echo $ot ?>" size="20"></td>
                    <td><table width="137" border="0" cellspacing="3" cellpadding="3">
                        <tr> 
                          <td width="66"><input type="submit" name="Submit" value="Guardar "></td>
                          <td width="57"> <input name="Volver" type="button"
       onClick="history.back();" 
       value="Volver"></td>
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