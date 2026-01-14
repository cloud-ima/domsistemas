<?php

include("../conexion.php");

$x_flag = $_GET["flag"] ?? '';

if ( $x_flag == 0 ) {
   $idestado = "Estado(Ingresando Nuevo Registro)";
   $parz = 1;
   $nomz = "";
}   

if ( $x_flag == 1 ) {
    $idestado = "Estado(Modificación del Registro)";
	$link=conectarse();
    $idz=$_GET['id'] ?? '';
    $ssql = "select * from tipocertificado where id ='$idz'";
    $rs = mysql_query($ssql,$link);
    $num_registros = mysql_num_rows($rs); 
	if ($num_registros == 0){
		   header("location: index.php");
	}else{
		   while ($row = mysql_fetch_array($rs)){
   				  $nomz = $row["nombre"];
   				  $monz = $row["moneda"];
   				  $prez = $row["precio"];
   				  $plaz = $row["plazo"];
   				  $copz = $row["copias"];
   				  $ctaz = $row["imputacion"];				  
				  $idz = $row["id"];
				  $parz = 2;
          }
	}
				  mysql_close($link);
}
//include "seguridad.php";
$fechaactualed = date('d')."/".date('n')."/".date('Y');
?>
<html>
<head>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form action="mantenedor.php" method="POST" enctype="multipart/form-data" >
  <table width="467" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="467" height="200" valign="top"> 
        <table width="461" border="0" cellpadding="2" cellspacing="0">
          <tr> 
            <td width="461" align="center"> <div align="left"><strong>Creaci&oacute;n 
                de certificados<font size="2"></font></strong></div></td>
          </tr>
          <tr>
            <td align="center"><div align="left"><?php echo $idestado ?></div></td>
          </tr>
        </table>
        <table width="459" border="0" cellpadding="0" cellspacing="0" bordercolor="#cccccc">
          <tr>
            <td width="616" height="68"> 
              <table width="454" border="0" cellpadding="2" cellspacing="2">
                <!-- <tr> -->
                <!-- <td class=estilo_titulo >Código</td><td> -->
                <input type=hidden  class=estilo_text  name=t08_cod value=''>
                <!-- </td> -->
                <!-- </tr> -->
                <tr> 
                  <td width="146" height="26" bgcolor="#efefef" class=estilo_titulo >Nombre 
                    Certificado</td>
                  <td width="294" bgcolor="#efefef"> <input name="nombre" type="text" id="titulo2" value="<?php echo $nomz ?>" size="48" maxlength="100"> 
                  </td>
                </tr>
                <tr> 
                  <td height="19" bgcolor="#efefef" class=estilo_titulo >Moneda</td>
                  <td bgcolor="#efefef"> 
                    <?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM moneda order by id",$linkc);
?>
                    <select class=bordecampos name="moneda" id="moneda">
                      <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                      <option value="<?php echo $rowc["id"] ?>"
<?php if($rowc["id"] == $monz){?>selected<?php }?>> <?php echo $rowc["nombre"]?> </option>
                      <?php }
mysql_close($linkc);
?>
                    </select> </td>
                </tr>
                <tr> 
                  <td height="19" bgcolor="#efefef" class=estilo_titulo >Precio</td>
                  <td bgcolor="#efefef"> <input name="precio" type="text" id="nombre2" value="<?php echo $prez ?>" size="20" maxlength="100"> 
                  </td>
                </tr>
                <tr> 
                  <td height="19" bgcolor="#efefef" class=estilo_titulo >Plazo 
                    en D&iacute;as</td>
                  <td bgcolor="#efefef"> <input name="plazo" type="text" id="nombre3" value="<?php echo $plaz ?>" size="20" maxlength="100"> 
                  </td>
                </tr>
                <tr>
                  <td height="19" bgcolor="#efefef" class=estilo_titulo >N&ordm; 
                    de Copias</td>
                  <td bgcolor="#efefef"> <input name="copias" type="text" id="copias" value="<?php echo $copz ?>" size="20" maxlength="100"> 
                  </td>
                </tr>
                <tr> 
                  <td height="19" bgcolor="#efefef" class=estilo_titulo >Cuenta 
                    Imputaci&oacute;n </td>
                  <td bgcolor="#efefef"> <input name="cuenta" type="text" id="cuenta" value="<?php echo $ctaz ?>" size="20" maxlength="100"> 
                  </td>
                </tr>
                <tr> 
                  <td height="19" class=estilo_titulo > <input name="param" type="hidden" id="param4" value="<?php echo $parz ?>"> 
                    <input name="codigo" type="hidden" id="param5" value="<?php echo $idz ?>"></td>
                  <td bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </table>
        <table width="454" border="0" cellpadding="0" cellspacing="0">
          <!-- <tr> -->
          <!-- <td class=estilo_titulo >Código</td><td> -->
          <input type=hidden  class=estilo_text  name=t08_cod2 value=''>
          <!-- </td> -->
          <!-- </tr> -->
          <tr> 
            <td height="39" class=estilo_titulo > 
              <table width="178" border="0" align="left">
                <tr> 
                  <td width="73" valign="top"> <div align="center">
                      <input name="enviar" type="submit" id="enviar" value="Grabar">
                    </div></td>
                  <td width="95" valign="top">
<input type="reset" name="Submit3" value="Cancelar" onClick="cerrar()">
				  <script language="javascript">
function cerrar()
{
	opener.window.location.reload( false );
	window.close();
}
  </script>
                </tr>
              </table></td>
          </tr>
        </table> 
      </td>
    </tr>
  </table>
  </form>
</body>
</html>