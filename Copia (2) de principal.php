<?php
include("seguridad.php");
//include("fechaclasss.php");

$fecha_hoy = date('d')."/".date('m')."/".date('Y');
$hoy = date('Y')."-".date('m')."-".date('d');
?>
<html>
<head>
<title></title>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language='javascript' src="popcalendar.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 16px;
}
.style3 {color: #FF0000}
.style4 {font-size: 24px}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="49%" height="249" align="left" valign="top"> 
      <div align="left"></div>
      <div align="left">
        <br>
        <table width="900" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td width="8">&nbsp;</td>
            <td width="30">&nbsp;</td>
            <td width="842"><span class="style2">Informaci&oacute;n de Estad&iacute;stica Diaria : <? echo $fecha_hoy ?></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2" align="left"><table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="62%" valign="top"><br>
                  <table width="541" align="left">
                  <tr>
                    <td width="533">                        <table width="97%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="29" valign="top"><table width="96%" height="26" border="0" cellpadding="2" cellspacing="2">
                              <tr>
                                <? 
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
                                <td width="20" height="22" align="center"><div align="center"></div></td>
                                <td width="226" align="left" bgcolor="#EFEFEF" ><strong>Nombre del Certificado </strong>  </td>
                                <td width="74" align="left" bgcolor="#EFEFEF" ><div align="center"><strong>Total A&ntilde;o</strong></div></td>
                                <td width="83" align="right" bgcolor="#EFEFEF" ><div align="center"><strong>Total Dia</strong></div></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td height="56" valign="top"><table width="43" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="43"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                                    <?
		  //include("conexion.php");
		  $link=Conectarse(); 
		  $qry = "SELECT * from parametros where id = 1";
		  $res = mysql_query($qry);
		  $tablaperiodo = "cert". mysql_result($res, 0, "periodo");
		  
          $result=mysql_query("SELECT * FROM tipocertificado order by id ",$link); 
          $a=0;

while ($row = mysql_fetch_array($result)){
           
           $cod= $row["id"];
		   
		   $link=Conectarse();
   	       $sql2= "select * from $tablaperiodo WHERE idcert='$cod'";
		   		  $ressum = mysql_query($sql2);
			      $total_year = mysql_num_rows($ressum);
				  
		   $link=Conectarse();
   	       $sql2= "select * from $tablaperiodo ";
		   		  $ressum = mysql_query($sql2);
			      $tot1 = mysql_num_rows($ressum);
				  
           $link=Conectarse();
   	       $sql2= "select * from $tablaperiodo WHERE fecha_solicitud = '$hoy' ";
		   		  $ressum = mysql_query($sql2);
			      $tot2 = mysql_num_rows($ressum);

           $link=Conectarse();
   	       $sql2= "select * from $tablaperiodo WHERE fecha_solicitud = '$hoy' and idcert='$cod'";
		   		  $ressum = mysql_query($sql2);
			      $num_total_registros = mysql_num_rows($ressum);
				  
?>
                                  </font></td>
                                </tr>
                              </table>
                                <table width="96%" height="26" border="0" cellpadding="2" cellspacing="2">
                                  <tr>
                                    <? 
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
                                    <td width="20" height="22" align="center"><div align="center"></div>                                      </td>
                                    <td width="226" align="left" bgcolor="<? echo $color ?>" ><? echo $row["nombre"] ?> </td>
									<td width="72" align="center" bgcolor="<? echo $color ?>" ><? echo $total_year ?></td>
									<td width="83" align="center" bgcolor="<? echo $color ?>" ><? echo $num_total_registros ?></td>
                                  </tr>
                                </table>
                                <table width="41" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="41"><? }?>
                                    </td>
                                  </tr>
                              </table>
                                <table width="96%" height="26" border="0" cellpadding="2" cellspacing="2">
                                  <tr>
                                    <? 
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
                                    <td width="20" height="22" align="center"><div align="center"></div></td>
                                    <td width="226" align="right" bgcolor="<? echo $color ?>" ><div align="justify" class="style2">ACUMULADO</div></td>
                                    <td width="72" align="center" bgcolor="<? echo $color ?>" ><strong class="style2"><? echo $tot1 ?></strong></td>
                                    <td width="83" align="center" bgcolor="<? echo $color ?>" class="style2" ><strong><? echo $tot2 ?></strong></td>
                                  </tr>
                                </table>
                              <br></td>
                          </tr>
                      </table></td>
                  </tr>
                </table></td>
                <td width="38%" valign="top"><br>
                  <table width="300" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="47"><div align="left"><img src="Images/form-ico.jpg" width="40" height="39"></div></td>
                    <td width="253" valign="middle"><a href="solicitud/ingresa.php">Ingresar Solicitud de Certificado </a></td>
                  </tr>
                  <tr>
                    <td><div align="left"><img src="Images/list-solicitudes.jpg" width="40" height="39"></div></td>
                    <td valign="middle"><a href="solicitud/list_solicitudes.php">Consultar Solictudes </a>(<span class="style3">Tramite</span>) </td>
                  </tr>
                  <tr>
                    <td><img src="Images/list-solicitudes-ok.jpg" width="40" height="39"></td>
                    <td valign="middle"><a href="solicitud/list_solicitudes_ok.php">Consultar Canceladas</a> (<span class="style3">Giro y Pago</span>) </td>
                  </tr>
                  <tr>
                    <td><img src="Images/entregar.jpg" width="40" height="40"></td>
                    <td valign="middle"><a href="solicitud/entregar.php">Entrega de Certificados</a></td>
                  </tr>
                  <tr>
                    <td><img src="Images/excel.jpg" width="40" height="39"></td>
                    <td valign="middle"><a href="solicitud/centro_exportacion.php">Reporte Listado Diario</a> </td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
<br>
<? include("footer.php"); ?>
</body>
</html>