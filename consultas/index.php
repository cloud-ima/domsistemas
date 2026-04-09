<?php
include "../seguridad.php";
include("../fechaclasss.php");
//include "conexion.php";
$mensajetitulo = "Consultando Registro de Propiedades";
$hoy = date('Y')."-".date('m')."-".date('d');
$x_rut = '';
$x_rol = '';
$x_rol = $_POST["rol"] ?? '';
$x_rut = $_POST["rut"] ?? '';
$x_rut = strtoupper($_POST["rut"] ?? '');

if ( $x_rol == '' and $x_rut == '' ){
          $consultaSQL = "SELECT c.*, r.nombre, r.apellidos, tc.nombre as nombre_certificado, e.nombres as nombre_estado 
                          FROM cert2009 c 
                          LEFT JOIN rut r ON c.rut = r.rut 
                          LEFT JOIN tipocertificado tc ON c.idcert = tc.id 
                          LEFT JOIN estado e ON c.estado = e.id 
                          WHERE c.rol = 'NN' ORDER BY c.rol";
}
else
    {
          if ( $x_rol <> '' ){
              $x_rol_safe = mysql_real_escape_string($x_rol);
              $consultaSQL = "SELECT c.*, r.nombre, r.apellidos, tc.nombre as nombre_certificado, e.nombres as nombre_estado 
                              FROM cert2009 c 
                              LEFT JOIN rut r ON c.rut = r.rut 
                              LEFT JOIN tipocertificado tc ON c.idcert = tc.id 
                              LEFT JOIN estado e ON c.estado = e.id 
                              WHERE c.rol = '$x_rol_safe' ORDER BY c.fecha_solicitud DESC LIMIT 500";
          }
          else 
            { 
              $x_rut_safe = mysql_real_escape_string($x_rut);
              $consultaSQL = "SELECT c.*, r.nombre, r.apellidos, tc.nombre as nombre_certificado, e.nombres as nombre_estado 
                              FROM cert2009 c 
                              LEFT JOIN rut r ON c.rut = r.rut 
                              LEFT JOIN tipocertificado tc ON c.idcert = tc.id 
                              LEFT JOIN estado e ON c.estado = e.id 
                              WHERE c.rut = '$x_rut_safe' ORDER BY c.fecha_solicitud DESC LIMIT 500";
            }
}
//echo $consultaSQL;
?>
<html>
<head>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">

#fixedtipdiv{
position:absolute;
padding: 2px;
border:1px solid black;
font:normal 12px Verdana;
line-height:18px;
z-index:100;
}

</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <?php //include "botones.php"; ?>
    </td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="index.php">
        <table width="527" border="0" align="center" cellspacing="0" cellpadding="0">
          <tr>
            <td width="395" valign="top"><table width="481" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td width="103" valign="middle">&nbsp;</td>
                  <td width="378"><img src="images/escudoarica.jpg" width="62" height="80"></td>
                </tr>
                <tr>
                  <td valign="middle">ROL </td>
                  <td><input name="rol" type="text" id="rol" size="15" maxlength="10">
                    <input type="submit" name="Submit" value="Consultar"></td>
                </tr>
                <tr>
                  <td valign="middle">RUT</td>
                  <td><input name="rut" type="text" id="rut" size="15" maxlength="15">
                    <input type="submit" name="Submit2" value="Consultar">
                  (sin puntos y con gui&oacute;n)</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td width="13"><IMG height=28 src="../menus/titleleft.jpg"
  width=13></td>
    <td width="871" background="../menus/titlemiddle.jpg"><strong><font color="#FFFFFF">Solicitudes
      Vigentes</font></strong></td>
    <td width="16"><IMG height=28 src="../menus/titleright.jpg"
  width=13></td>
  </tr>
  <tr>
    <td background="../menus/BodyLeft.jpg"><img src="../menus/BodyLeft.jpg" width="13" height="14"></td>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
        <tr>
          <td width="96" height="23"><div align="center"><font color="#000000"><strong>Fecha</strong></font></div></td>
          <td width="197"><font color="#000000"><strong>Nombre Solicitante</strong></font></td>
          <td width="236"><font color="#000000"><strong>Tipo Solicitud</strong></font></td>
          <td width="118"><font color="#000000"><strong>Estado</strong></font></td>
          <td width="98"><font color="#000000"><strong>Valor ($)</strong></font></td>
          <td width="112">&nbsp;</td>
        </tr>
      </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="56" valign="top"><table width="87%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="693" align="center"><strong>
                    <?php
                  // OPTIMIZADO: Una sola consulta con JOINs, sin duplicar ejecucion
                  $link=conectarse();
                  $result=mysql_query($consultaSQL,$link);
                  $num_total_registros = mysql_num_rows($result);
                  $totalservicio = 0;
                  $rows_data = [];
                  while ($row = mysql_fetch_array($result)){
                        $totalservicio = $totalservicio + $row["total"];
                        $rows_data[] = $row;
                  }
                  echo " Total Solicitudes : " . $num_total_registros. " ---> Total $ : " . number_format($totalservicio, 0, ",", ".");
                  $a=1;
                  foreach ($rows_data as $row) {
                                           $cod= $row["rut"];
                                           $fecha= $row["fecha_solicitud"];
                                           $est= $row["estado"];
                                           $cert= $row["idcert"];
                                           $fechaed= cambiaf_a_normal($row["fecha_solicitud"]);

                                // Usar datos del JOIN en vez de consultas individuales
                                $nombre = $row["nombre"] . " " . $row["apellidos"];
                                $nombrecerti = $row["nombre_certificado"];
                                $nombreestado = $row["nombre_estado"];

                                                 $ano2 = substr($fecha,0,4);
          $mes2 = substr($fecha,5,2);
          $dia2 = substr($fecha,8,2);

          $ano1 = substr($hoy,0,4);
          $mes1 = substr($hoy,5,2);
          $dia1 = substr($hoy,8,2);

          $timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
          $timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);

          $segundos_diferencia = $timestamp1 - $timestamp2;
          $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
          $dias_diferencia = abs($dias_diferencia);
          $dias_diferencia = floor($dias_diferencia);

                  $direc = "solicitudcom.php?id=".$row["id"]."&rut=". $row["rut"];

        /*         $codsec= $row["estado"];
           $link=Conectarse();
           $qry = "SELECT * FROM estados WHERE id='$codsec'";
                   $res = mysql_query($qry);
           $nombreestado = mysql_result($res, 0, "nombre");*/
?>
                  </strong></td>
                </tr>
              </table>
                <table width="99%" height="35" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <?php
                    $color2 = "#A6E2FF";
                                if ($a == 0) {
                    $color = "#f1f1f1";
                                        $a = 1;
                }else{
                    $color = "#ffffff";
                                        $a = 0;
                        }

                        /*      if ( $dias_diferencia > 19 ) {
                                    $color = "#FFCC66";
                                         } */
                                ?>
                    <td width="100" height="35" align="center" bgcolor="<?php echo $color ?>" ><?php echo $fechaed; ?> <br />
                    </td>
                    <td width="199" bgcolor="<?php echo $color ?>" ><font color="#0066CC"><?php echo $nombre; ?></font></td>
                    <td width="237" bgcolor="<?php echo $color ?>" ><?php echo $nombrecerti ?> (<font color="#990000"><?php echo $row["id"] ?></font>)</td>
                    <td width="119" bgcolor="<?php echo $color ?>" ><?php echo $nombreestado ?></td>
                    <td width="100" align="right" bgcolor="<?php echo $color ?>" ><?php echo number_format($row["total"], 0, ",", "."); ?> </td>
                    <td width="52" bgcolor="<?php echo $color ?>" ><div align="right"><A onclick="MM_openBrWindow('../solicitud/mostrar_solicitud.php?id=<?php echo $row["id"]. "&rut=". $row["rut"] ?>','','scrollbars=yes,width=650,height=500')"
                        href="javascript:;"><img src="../images/zoom.gif" title="Consultar Solicitud" width="20" border="0"></a></div></td>
                    <td width="24" bgcolor="<?php echo $color ?>"><div align="center"> </div></td>
                    <td width="18" bgcolor="<?php echo $color ?>"><div align="center"> </div>
                    <td width="13" bgcolor="<?php echo $color ?>"><div align="center"> </div></td>
                  </tr>
                </table>
                <table width="41" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="41"><?php }?>
                    </td>
                  </tr>
              </table></td>
          </tr>
      </table></td>
    <td background="../menus/BodyRight.jpg"><img src="../menus/BodyRight.jpg" width="13" height="14"></td>
  </tr>
  <tr>
    <td><IMG height=24 src="../menus/bottomleft.jpg" width=13></td>
    <td background="../menus/bottommiddle.jpg">&nbsp;</td>
    <td><IMG height=24 src="../menus/bottomright.jpg"
  width=13></td>
  </tr>
</table>
<br>

<?php
include "../footer.php";
?>
</body>
</html>
