<?php
include "../seguridad.php";
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
<br>
<table width="692" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="right"><a href="../principal.php">Volver al Menu Principal</a></div></td>
  </tr>
</table>
<table width="692" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="14"><img src="../cajamenus/menu_03.jpg" width="14" height="25"></td>
    <td width="668" background="../cajamenus/menu_04.jpg"><div align="center"><strong><font color="#333333">Directores con Firmas Autorizadas</font></strong></div></td>
    <td width="10"><img src="../cajamenus/menu_05.jpg" width="10" height="25"></td>
  </tr>
  <tr> 
    <td background="../cajamenus/menu_07.jpg">&nbsp;</td>
    <td><table width="653" align="center">
        <tr> 
          <td width="645"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
              <tr> 
                <td width="661" height="12"><div align="left"><A onclick="MM_openBrWindow('formulario.php?param=1','','scrollbars=no,width=500,height=250')" 
            href="javascript:;"><? echo "Agregar Nuevo Registro" ?></a></div></td>
                <td width="661"><div align="right"></div></td>
              </tr>
            </table>
            <table width="88%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="6%"><div align="right"><strong>Id</strong></div></td>
                <td><div align="center"><strong>Nombre del Director </strong><strong></strong></div>                  </td>
              </tr>
            </table>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td height="56" valign="top"> <table width="43" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="43"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <?php 
		  //include("../conexion.php");
		  $link=Conectarse(); 
          $result=mysql_query("SELECT * FROM directores order by nombre",$link); 
          $a=0;

while ($row = mysql_fetch_array($result)){
           
        /*   $codsec= $row["estado"];
           $link=Conectarse(); 
           $qry = "SELECT * FROM estadodecretos WHERE id='$codsec'";
		   $res = mysql_query($qry);
           $nombreseccion = mysql_result($res, 0, "nombre"); */
?>
                        </font></td>
                    </tr>
                  </table>
                  <table width="100%" height="20" border="0" cellpadding="2" cellspacing="2">
                    <tr> 
                      <? 
                    $color2 = "#A6E2FF";
				if ($a == 0) {
                    $color = "#f1f1f1";
					//$color = "#ffffff";
					$a = 1;
                }else{
                    $color = "#ffffff";
					$a = 0;
		        }	 
				?>
                      <td width="31" height="18" align="right" bgcolor="<? echo $color ?>"> 
                        <div align="right"><? echo $row["id"]?></div></td>
                      <td width="441" align="center" bgcolor="<? echo $color ?>" ><? echo $row["nombre"] ?> 
                        <br /> <div align="center"></div>                        <div align="center"></div> <div align="center"></div></td>
                      <td width="17" align="center" bgcolor="<? echo $color ?>" ><? if ( $row["activo"] == 'S' ) {
						echo "<img width=20 src=\"ok.png\">";
						 } ?></td>
                      <td width="33" bgcolor="<? echo $color ?>"><div align="center"><A onclick="MM_openBrWindow('formulario.php?id=<? echo $row["id"]. "&flag=1"?>','','scrollbars=no,width=500,height=250')" 
            href="javascript:;"><img src="../css/modificar.gif" alt="Modificar Ficha" width="17" height="12" border="0"></a></div></td>
                      <td width="42" bgcolor="<? echo $color ?>"> <div align="center"><a href="mantenedor.php?id=<?php echo $row['id']."&param=3"; ?>"class="bot" onClick="if(!confirm('¿Deseas realmente borrar el Registro, ID Número : <?php echo strtolower($row['id']); ?>?'))return false"><img src="../css/action_stop.gif" title="Eliminar Parámetro" width="16" height="16" border="0"></a></div></td>
                      <td width="43" bgcolor="<? echo $color ?>"><a href="mantenedor.php?id=<?php echo $row['id']."&param=4"; ?>">Activar</a></td>
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
        </tr>
      </table></td>
    <td background="../cajamenus/menu_09.jpg">&nbsp;</td>
  </tr>
  <tr> 
    <td><img src="../cajamenus/menu_10.jpg" width="14" height="17"></td>
    <td background="../cajamenus/menu_11.jpg"><img src="../cajamenus/menu_11.jpg" width="380" height="17"></td>
    <td><img src="../cajamenus/menu_12.jpg" width="10" height="17"></td>
  </tr>
</table>
<br>
</body>
</html>