<?php
include "../seguridad.php";
include("../fechaclasss.php");

$fecha_hoy = date('d')."/".date('m')."/".date('Y');
$hoy = date('Y')."-".date('m')."-".date('d');

$x_flag = "";
$x_flag = $_POST["fecha"];
$fecha_consulta = cambiaf_a_mysql($x_flag);

$link=Conectarse();
$qry = "SELECT * from parametros where id = 1";
$res = mysql_query($qry);
$tablaperiodo = "cert". mysql_result($res, 0, "periodo");

   if ( $x_flag == '' ) { $consultaSQL = "SELECT * FROM $tablaperiodo where estado = 2 order by id desc limit 400"; }
   else
	  { $consultaSQL = "SELECT * FROM $tablaperiodo where fecha_solicitud = '$fecha_consulta' and ( estado = 2 ) order by id desc limit 400 "; $fecha_hoy = $_POST["fecha"]; }
	  
?>
<html>
<head>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language='javascript' src="../popcalendar.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td>&nbsp; </td>
  </tr>
  <tr> 
    <td><font size="3"><strong>Consulta de Solicitudes Vigentes Canceladas</strong></font></td>
  </tr>
</table>
<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr> 
    <td><strong> 
      <?php 
		  $link=conectarse();
		  $result=mysql_query($consultaSQL,$link);
		  while ($row = mysql_fetch_array($result)){
		        $totalservicio = $totalservicio + $row["total"];
		  }		
		  //		$totaled = number_format($totalservicio, 0, ",", ".");
			//	echo $totaled;
?>
      </strong></td>
    <td><div align="right"></div></td>
  </tr>
  <tr> 
    <td valign="middle"> <table width="527" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="132" valign="top">Consultando Fecha</td>
          <td width="395" valign="top"> <form name="form1" method="post" action="list_solicitudes_ok.php">
              <table width="367" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="89" valign="bottom"> <input name="fecha" type="text" id="dateArriva9" onClick="popUpCalendar(this, form1.dateArriva9, 'dd/mm/yyyy');" value="<? echo $fecha_hoy; ?>" size="11" maxlength="10"> 
                  </td>
                  <td width="278" valign="middle"> <input name="imageField" type="image" onClick="nombreFormulario.send();return false" src="../Images/zoom.gif" width="24" height="22" border="0"> 
                  </td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
    <td valign="top"><a href="../principal.php"><img src="../images/volver.gif" width="50" height="40" border="0"></a></td>
  </tr>
</table>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="13"><IMG height=28 src="../menus/titleleft.jpg" 
width=13></td>
    <td width="871" background="../menus/titlemiddle.jpg"><strong><font color="#FFFFFF">Solicitudes 
      Vigentes canceladas</font></strong></td>
    <td width="16"><IMG height=28 src="../menus/titleright.jpg" 
    width=13></td>
  </tr>
  <tr> 
    <td background="../menus/BodyLeft.jpg"><img src="../menus/BodyLeft.jpg" width="13" height="14"></td>
    <td><table width="980" border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
        <tr> 
          <td width="107" height="23"><div align="center"><font color="#000000"><strong>Fecha</strong></font></div></td>
          <td width="220"><font color="#000000"><strong>Nombre Solicitante</strong></font></td>
          <td width="203"><font color="#000000"><strong>Tipo Solicitud</strong></font></td>
          <td width="125"><font color="#000000"><strong>Estado</strong></font></td>
          <td width="130"><font color="#000000"><strong>Funcionario</strong></font></td>
          <td width="76"><font color="#000000"><strong>Valor ($)</strong></font></td>
          <td width="103">&nbsp;</td>
        </tr>
      </table>
      <table width="970" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="56" valign="top"> <table width="87%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="693" align="center"> <strong> 
                  <?php 
		  $link=conectarse();
  				  
          $result=mysql_query($consultaSQL,$link);
		  $num_total_registros = mysql_num_rows($result);
		  echo " Total Solicitudes : " . $num_total_registros. " ---> Total $ : " . number_format($totalservicio, 0, ",", ".");
          $a=1;
				while ($row = mysql_fetch_array($result)){
           			           $cod= $row["rut"];
							   $fecha= $row["fecha_solicitud"];
							   $est= $row["estado"];
							   $cert= $row["idcert"];
							   $fechaed= cambiaf_a_normal($row["fecha_solicitud"]);
							   
						$link=Conectarse();
						$qry = "SELECT * FROM rut where rut ='$cod'";
						$res = mysql_query($qry);
						$nombre = mysql_result($res, 0, "nombre"). " ".mysql_result($res, 0, "apellidos");

						$qry = "SELECT * FROM tipocertificado where id ='$cert'";
						$res = mysql_query($qry);
						$nombrecerti = mysql_result($res, 0, "nombre");

						$link=Conectarse();
						$qry = "SELECT * FROM estado where id ='$est'";
						$res = mysql_query($qry);
						$nombreestado = mysql_result($res, 0, "nombres");
						
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
		  
		  $direc = "/domsistemas/propiedades/fichapropiedades.php?id=".$row["id"]."&rol=". $row["rol"];
		   
	/*	   $codsec= $row["estado"];
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
                <? 
                    $color2 = "#A6E2FF";
				if ($a == 0) {
                    $color = "#f1f1f1";
					$a = 1;
                }else{
                    $color = "#ffffff";
					$a = 0;
		        }	 
				
				if ( $row["estado"] == 3 ) { 
				    $color = "#FFCC66";
					 } 
				?>
                <td width="110" height="35" align="center" bgcolor="<? echo $color ?>" ><? echo $fechaed;
 ?> <br /> </td>
                <td width="220" bgcolor="<? echo $color ?>" ><font color="#0066CC"><? echo $nombre; ?></font></td>
                <td width="207" bgcolor="<? echo $color ?>" ><? echo $nombrecerti
 ?> (<font color="#990000"><? echo $row["id"] ?></font>) </td>
                <td width="122" bgcolor="<? echo $color ?>" ><? echo $nombreestado ?> </td>
                <td width="112" align="right" bgcolor="<? echo $color ?>" ><span class="style1"><? echo $row["responsable"] ?></span></td>
                <td width="91" align="right" bgcolor="<? echo $color ?>" ><? echo number_format($row["total"], 0, ",", ".");
 ?> </td>
                <td width="27" bgcolor="<? echo $color ?>" ><div align="right"><A onclick="MM_openBrWindow('mostrar_solicitud.php?id=<? echo $row["id"]. "&rut=". $row["rut"] ?>','','scrollbars=no,width=650,height=500')" 
            href="javascript:;"><img src="../Images/zoom.gif" title="Consultar Solicitud" width="20" border="0"></a></div></td>
                <td width="26" bgcolor="<? echo $color ?>"> <div align="center"><A onclick="MM_openBrWindow('solicitud_completa.php?id=<? echo $row["id"]. "&rut=". $row["rut"] ?>','','scrollbars=no,width=650,height=500')" 
            href="javascript:;"><img src="../Images/edit_icon.jpg" width="20" height="20" border="0" title="Consultar Solicitud"></a> 
                  </div></td>
                <td width="19" bgcolor="<? echo $color ?>"><div align="center">
                    <? if ( $row["responsable"] <> 'NULL'  AND $row["responsable"] <> '0' ) {
					if ( $tipousuario == 1 or $tipousuario == 4 ) { echo "<a href='$direc' target=_blank ><img src='../images/ok.jpg' width=20 border=0></a>"; } }
 ?>
                  </div>
                <td width="26" bgcolor="<? echo $color ?>"> <div align="center"></div></td>
              </tr>
            </table>
            <table width="41" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="41"> 
                  <? }?>
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