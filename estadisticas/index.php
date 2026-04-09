<?php include "../seguridad.php";
$fecha_hoy = date('d')."/".date('m')."/".date('Y');
$hoy = date('Y')."-".date('m')."-".date('d');
$anio = date('Y');
if ( $tipousuario <> 1 ) {
                         echo '<script language="javascript">';
                         echo "alert('Sr. Usuario no tiene acceso a este modulo');";
                         echo "location.href='../principal.php';";
                         echo "</script>";
}

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
.style2 {font-size: 12}
.style5 {
        font-size: 24px;
        font-weight: bold;
}
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="664" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="469"><span class="style5">Estad&iacute;stico Diario </span></td>
  </tr>
</table>
<table width="713" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="713" height="29" valign="top"><table width="695" height="26" border="0" cellpadding="2" cellspacing="2">
          <tr>
          <?php
                    $color2 = "#A6E2FF";
                                if ($a == 0) {
                    $color = "#EFEF99";
                                        //$color = "#ffffff";
                                        $a = 1;
                }else{
                    $color = "#ffffff";
                                        $a = 0;
                        }
                                ?>
          <td width="384" height="22" align="center" bgcolor="#EFEFEF"><div align="center"></div>  <strong>Tipo de Certificados valorizados en $ </strong></td>
          <td width="144" align="left" bgcolor="#EFEFEF" ><div align="center"><strong>Total A&ntilde;o</strong></div></td>
          <td width="147" align="right" bgcolor="#EFEFEF" ><div align="center"><strong><?php echo $fecha_hoy ?></strong></div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="56" valign="top"><table width="43" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="43"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <?php
                  $link=Conectarse();

          $result=mysql_query("SELECT * FROM tipocertificado order by id ",$link);
          $a=0;
                  $total_year_acum =0;
                  $num_total_registros_acum = 0;

                  // OPTIMIZADO: Una sola consulta para totales generales del anio
                  $sql2= "SELECT COUNT(*) as cnt, COALESCE(SUM(total),0) as total_acum FROM cert2009 WHERE estado > 1";
                  $ressum = mysql_query($sql2);
                  $row_tmp = mysql_fetch_array($ressum);
                  $total_year_acum = $row_tmp['cnt'];
                  $tot1 = $row_tmp['total_acum'];

                  // OPTIMIZADO: Una sola consulta para totales del dia
                  $sql2= "SELECT COUNT(*) as cnt, COALESCE(SUM(total),0) as total_acum FROM cert2009 WHERE estado > 1 AND fecha_solicitud = '$hoy'";
                  $ressum = mysql_query($sql2);
                  $row_tmp = mysql_fetch_array($ressum);
                  $num_total_registros_acum = $row_tmp['cnt'];
                  $tot2 = $row_tmp['total_acum'];

                  // OPTIMIZADO: Una sola consulta agrupada por idcert para totales del anio
                  $sql2 = "SELECT idcert, COUNT(*) as cnt, COALESCE(SUM(total),0) as total_acum FROM cert2009 WHERE estado > 1 GROUP BY idcert";
                  $ressum = mysql_query($sql2);
                  $stats_year = array();
                  while ($row_tmp = mysql_fetch_array($ressum)) {
                      $stats_year[$row_tmp['idcert']] = array('cnt' => $row_tmp['cnt'], 'total' => $row_tmp['total_acum']);
                  }

                  // OPTIMIZADO: Una sola consulta agrupada por idcert para totales del dia
                  $sql2 = "SELECT idcert, COUNT(*) as cnt, COALESCE(SUM(total),0) as total_acum FROM cert2009 WHERE estado > 1 AND fecha_solicitud = '$hoy' GROUP BY idcert";
                  $ressum = mysql_query($sql2);
                  $stats_day = array();
                  while ($row_tmp = mysql_fetch_array($ressum)) {
                      $stats_day[$row_tmp['idcert']] = array('cnt' => $row_tmp['cnt'], 'total' => $row_tmp['total_acum']);
                  }

while ($row = mysql_fetch_array($result)){

           $cod= $row["id"];
                   $total_year = 0;
                   $porcentaje =0;

                   // Usar datos precalculados en vez de consultas individuales
                   $total_year = isset($stats_year[$cod]) ? $stats_year[$cod]['cnt'] : 0;
                   $acum1 = isset($stats_year[$cod]) ? $stats_year[$cod]['total'] : 0;

                   if ( $total_year_acum > 0 ) {
                       $porcentaje = round((( $total_year / $total_year_acum ) * 100),2);
                   }

                   $num_total_registros = isset($stats_day[$cod]) ? $stats_day[$cod]['cnt'] : 0;
                   $acum2 = isset($stats_day[$cod]) ? $stats_day[$cod]['total'] : 0;

?>
          </font></td>
        </tr>
      </table>
        <table width="695" height="26" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <?php
                $color = "#ffffff";
                                ?>
            <td width="11" height="22" align="center"><div align="center"></div></td>
            <td width="365" align="left" bgcolor="<?php echo $color ?>" ><table width="365" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2"><?php echo $row["nombre"] ?></td>
                </tr>
                <tr>
                  <td width="40">(<?php echo( $porcentaje ) ?>%)</td>
                  <td width="325"><table width="<?php echo($porcentaje) ?>%" height="20" bgcolor="<?php echo $row["color"] ?>">
                      <tr>
                        <td></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
            <td width="146" align="right" bgcolor="<?php echo $color ?>" ><span class="style2"><?php echo number_format($acum1, 0, ",", "."); ?> ---&gt;(<?php echo $total_year ?>)</span></td>
            <td width="147" align="right" bgcolor="<?php echo $color ?>" ><span class="style2"><?php echo number_format($acum2, 0, ",", "."); ?> ---&gt;(<?php echo $num_total_registros ?>) </span></td>
          </tr>
        </table>
        <table width="41" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="41"><?php }?>
            </td>
          </tr>
        </table>
        <table width="694" height="27" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <?php
                $color = "#ffffff";
                                ?>
            <td width="338" height="22" align="center" bgcolor="#EFEFEF"><div align="center"></div>
              <div align="right"><strong>TOTALES -----------&gt;</strong></div></td>
            <td width="190" align="right" bgcolor="#EFEFEF" ><span class="style2"><?php echo number_format($tot1, 0, ",", "."); ?> ---&gt;(<?php echo $total_year_acum ?>) </span></td>
            <td width="146" align="right" bgcolor="#EFEFEF" ><span class="style2"><?php echo number_format($tot2, 0, ",", "."); ?> ---&gt;(<?php echo $num_total_registros_acum ?>) </span></td>
          </tr>
      </table></td>
  </tr>
</table>
<p>
  <?php include ("../footer.php") ?>
</p>
</body>
</html>
