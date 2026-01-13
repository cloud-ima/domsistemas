<?php
//include("../seguridad.php");
include("../conexion.php");
include("../fechaclasss.php");

$hoy = date('Y')."-".date('m')."-".date('d');
$rut_id=$_GET['rut'];
$sol_id=$_GET['id'];

$link=Conectarse();
$qry = "SELECT * FROM rut where rut ='$rut_id'";
$res = mysql_query($qry);
$nombre = mysql_result($res, 0, "nombre"). " ".mysql_result($res, 0, "apellidos");
$tel = mysql_result($res, 0, "telefonos");
$dom = mysql_result($res, 0, "direccion");
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
$responsable = mysql_result($res, 0, "responsable");
$fecha_ent = mysql_result($res, 0, "fecha_entrega");
$fecha_ret = mysql_result($res, 0, "fecha_retiro");
$usuario = mysql_result($res, 0, "usuario");
$entregado = mysql_result($res, 0, "entregado");
$rub = mysql_result($res, 0, "rubro");
$ot = mysql_result($res, 0, "orden_numero");

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
/*
if ( $responsable <> '' or $responsable <> '0' ) {
$link=Conectarse();
$qry = "SELECT * FROM usuarios where usuario ='$responsable'";
$res = mysql_query($qry);
$num_registros = mysql_num_rows($res);
if ( $num_registros == 0 )
  {
    $aaa=1; 
  } 
    else 
	  {
	$quienlohizo = mysql_result($res, 0, "nombre");
	mysql_close($link);
      }*/
?>
<html>
<head>
<title>MUNIARICA.CL</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<script language='javascript' src="popcalendar.js"></script>
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
<table width="650" border="1" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td><table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="663" height="505" align="center" valign="top"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><table width="646" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="646" height="82" valign="middle"><div align="center" class="style1"> <font size="5"><strong>Orden de Atenci&oacute;n Nr.</strong></font><strong> <font size="5" face="Geneva, Arial, Helvetica, sans-serif"><? echo $sol_id
 ?><br>
                                <font size="3">(<? echo $nombreestado ?>)</font></font></strong></div></td>
                  </tr>
                </table>
                  <table width="650" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                      <td width="726" bgcolor="#666666"><font color="#FFFFFF"><strong>IDENTIFICACION DEL CONTRIBUYENTE</strong></font></td>
                    </tr>
                  </table>
                  <table width="646" border="0" cellpadding="2" cellspacing="1">
                    <tr>
                      <td><span class="style1">Se&ntilde;or(a) </span></td>
                      <td><strong><font color="#990000"><? echo $rut_id
 ?></font> , <font color="#333333"><? echo $nombre
 ?></font></strong></td>
                    </tr>
                    <tr>
                      <td height="22">Direcci&oacute;n</td>
                      <td><? echo $dom
 ?></td>
                    </tr>
                    <tr>
                      <td width="141" height="22"><span class="style1">Fono/Email </span></td>
                      <td width="491"><? echo $tel
 ?> ------- <? echo $mail;

 ?></td>
                    </tr>
                </table></td>
            </tr>
            <tr>
              <td width="565">&nbsp;</td>
            </tr>
            <tr>
              <td height="97" valign="top"><table width="650" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td bgcolor="#666666"><div align="left"><font color="#FFFFFF"><strong>ANTECEDENTES DEL SERVICIO </strong></font></div></td>
                  </tr>
                </table>
                  <div align="justify">
                    <table width="650" border="0" cellpadding="4" cellspacing="2">
                      <tr>
                        <td><span class="style1">Tipo de Certificado</span></td>
                        <td colspan="2"><? echo $nombrecerti ?></td>
                      </tr>
                      <tr>
                        <td><span class="style1">* Solo para BNUP</span></td>
                        <td width="186"><span class="style1">Metros Lineales: <? echo $mt ?></span></td>
                        <td width="277"><span class="style1">Dias :<? echo $dias ?></span></td>
                      </tr>
                      <tr>
                        <td><span class="style1">Direcci&oacute;n</span></td>
                        <td colspan="2"><span class="style1"><? echo $direccion ?> , ROL: <? echo $rol ?></span></td>
                      </tr>
                      <tr>
                        <td><span class="style1">Rubro</span></td>
                        <td colspan="2"><span class="style1"><? echo $rub ?></span></td>
                      </tr>
                      <tr>
                        <td width="137"><span class="style1">Fecha Solicitud</span></td>
                        <td colspan="2"><span class="style1"><? echo $fecha_sol ?>
                          </span>
                        <div align="justify" class="style1"></div></td>
                      </tr>
                      <tr>
                        <td><span class="style1">Fecha Entrega</span></td>
                        <td colspan="2"><span class="style1"><? echo $fecha_ent ?></span></td>
                      </tr>
                      <tr>
                        <td><span class="style1">Atendido por</span></td>
                        <td colspan="2"><span class="style1"><? echo $atendido ?></span></td>
                      </tr>
                      <tr>
                        <td><span class="style1">TOTAL $</span></td>
                        <td colspan="2"><span class="style1"><? echo $total ?></span></td>
                      </tr>
                      <tr>
                        <td height="18" colspan="3" bgcolor="#666666"><font color="#FFFFFF"><strong>DATOS CONTABLES </strong></font></td>
                      </tr>
                      <tr>
                        <td><span class="style1">N&uacute;mero de Giro</span></td>
                        <td colspan="2"><span class="style1">_________________________________________________</span></td>
                      </tr>
                      <tr>
                        <td><span class="style1">Fecha del Giro</span></td>
                        <td colspan="2"><span class="style1">_________________________________________________</span></td>
                      </tr>
                      <tr>
                        <td><span class="style1">N&uacute;mero de O.T.</span></td>
                        <td colspan="2"><span class="style1">_________________________________________________</span></td>
                      </tr>
                      <tr>
                        <td colspan="3"><p align="center">
                            <input type="button" name="imprimir" value="Imprimir" onclick="window.print();">
                        </p></td>
                      </tr>
                      <tr>
                        <td colspan="3"><div align="center"><a href="ingresa.php"><strong>Regresar Formulario de Ingreso</strong></a> </div></td>
                      </tr>
                      <tr valign="top">
                        <td height="300" colspan="3"><table width="627" border="0" cellspacing="2" cellpadding="2">
                          <tr>
                            <td width="327" valign="middle"><div align="center">___________________________________________<br>
  Firma del Solicitante </div></td>
                            <td width="286" valign="top"><div align="center"><img src="images/PLANO-CERT-NUMERO.jpg" width="250" height="250"><br>
                                  <br>
                              *** Solo para n&uacute;mero nuevo *** </div></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
                </div></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>