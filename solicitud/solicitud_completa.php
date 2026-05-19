<?php
include("../seguridadsimple.php");
include("../topmenu2.php");
include("../fechaclasss.php");

function normalizar_texto_mojibake($txt)
{
    $t = (string)($txt ?? '');
    if ($t === '') {
        return $t;
    }

    // Corrige textos típicamente dañados: "PastÃ³n" -> "Pastón".
    if (preg_match('/Ã.|Â.|â.|ï¿½/u', $t)) {
        // Caso típico en este sistema: texto UTF-8 mal leído como latin1 (ej: "PastÃ³n").
        // utf8_decode corrige estos nombres al renderizar en página UTF-8.
        $fixed = @utf8_decode($t);
        if ($fixed !== false && $fixed !== '') {
            $t = $fixed;
        }
    }

    return $t;
}

$hoy = date('Y')."-".date('m')."-".date('d');
$rut_id=$_GET['rut'] ?? '';
$sol_id=$_GET['id'] ?? '';

if ($tipousuario == 1 ) { $seguridaddecampo='text'; $onoff = ''; } else { $seguridaddecampo='hidden'; $onoff = 'disabled';};

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
$responsable = $ac;
$fecha_ent = cambiaf_a_normal(mysql_result($res, 0, "fecha_entrega"));
$fecha_ret = cambiaf_a_normal(mysql_result($res, 0, "fecha_retiro"));
$usuario = mysql_result($res, 0, "usuario");
$entregado = mysql_result($res, 0, "entregado");
$rub = mysql_result($res, 0, "rubro");
$ot = mysql_result($res, 0, "orden_numero");

// Fallback de datos históricos: algunos registros quedaron en cert2009.
// Si faltan campos clave en la tabla activa, completar desde cert2009.
if ($tablaperiodo !== 'cert2009' && ($rol === '' || $giro === '' || $ot === '' || $ac === '' || $ac === '0')) {
    $qryLegacy = "SELECT * FROM cert2009 WHERE id ='$sol_id' LIMIT 1";
    $resLegacy = mysql_query($qryLegacy);
    if ($resLegacy && mysql_num_rows($resLegacy) > 0) {
        if ($rol === '') { $rol = mysql_result($resLegacy, 0, "rol"); }
        if ($giro === '') { $giro = mysql_result($resLegacy, 0, "giro_numero"); }
        if ($gfecha === '' || $gfecha === null) { $gfecha = mysql_result($resLegacy, 0, "giro_fecha"); }
        if ($ot === '') { $ot = mysql_result($resLegacy, 0, "orden_numero"); }
        if ($ac === '' || $ac === '0') {
            $ac = mysql_result($resLegacy, 0, "responsable");
            $responsable = $ac;
        }
        if ($estado === '' || $estado === null) { $estado = mysql_result($resLegacy, 0, "estado"); }
    }
}

if ( $gfecha == '' ) { $gfecha = cambiaf_a_normal($hoy); }else{$gfecha = cambiaf_a_normal($gfecha); }

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

$responsables = array();
$link=Conectarse();
$qry = "SELECT usuario, nombre FROM usuarios WHERE usuario <> 'administrador' ORDER BY nombre";
$res = mysql_query($qry);
if ($res) {
    while ($rowResp = mysql_fetch_array($res)) {
        $rowResp['nombre'] = normalizar_texto_mojibake($rowResp['nombre']);
        $responsables[] = $rowResp;
    }
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
                    <input name="param" type="hidden" id="param2" value="2">
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
                    <td colspan="2">
                      <select class=bordecampos name="responsable" id="select7">
                        <option value="0">Seleccione Responsable...</option>
                        <?php foreach($responsables as $rowc){ ?>
                        <option value="<?php echo htmlspecialchars($rowc["usuario"], ENT_QUOTES, 'UTF-8'); ?>"
<?php if($rowc["usuario"] == $ac){?>selected<?php }?>> <?php echo htmlspecialchars($rowc["nombre"], ENT_QUOTES, 'UTF-8'); ?> </option>
                        <?php } ?>
                      </select>
                    </td>
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
