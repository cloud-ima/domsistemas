<?php

include("../conexion.php");

$x_flag = $_GET["flag"];

if ( $x_flag == 0 ) {
   $idestado = "Estado(Ingresando Nuevo Registro)";
   $parz = 1;
   $nomz = "";
}   

if ( $x_flag == 1 ) {
    $idestado = "Estado(Modificación del Registro)";
	$link=conectarse();
    $idz=$_GET['id'];
    $ssql = "select * from directores where id ='$idz'";
    $rs = mysql_query($ssql,$link); 
    $num_registros = mysql_num_rows($rs); 
	if ($num_registros == 0){
		   header("location: index.php");
	}else{
		   while ($row = mysql_fetch_array($rs)){
   				  $nomz = $row["nombre"];
   				  $titz = $row["titulo"];
   				  $carz = $row["cargo"];				  				  
				  $idz = $row["id"];
				  $parz = 2;
          }
	}
				  mysql_close($link);
}
//include "../seguridad.php";
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
  <br>
  <br>
  <table width="467" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="467" height="200" valign="top"> 
        <table width="461" border="0" cellpadding="2" cellspacing="0">
          <tr> 
            <td width="461" align="center"> <div align="left"><strong>Usos de Suelo <font size="2"></font></strong></div></td>
          </tr>
          <tr>
            <td align="center"><div align="left"><? echo $idestado ?></div></td>
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
                  <td width="146" height="26" bgcolor="#efefef" class=estilo_titulo >Nombre</td>
                  <td width="294" bgcolor="#efefef"> 
                    <input name="nom" type="text" id="titulo2" value="<? echo $nomz ?>" size="50" maxlength="100">
                  </td>
                </tr>
                <tr>
                  <td height="19" bgcolor="#efefef" class=estilo_titulo >T&iacute;tulo</td>
                  <td bgcolor="#FFFFFF"><input name="tit" type="text" id="titulo2" value="<? echo $titz ?>" size="50" maxlength="100"></td>
                </tr>
                <tr>
                  <td height="19" bgcolor="#efefef" class=estilo_titulo >Cargo</td>
                  <td bgcolor="#FFFFFF"><input name="car" type="text" id="titulo2" value="<? echo $carz ?>" size="50" maxlength="100"></td>
                </tr>
                <tr> 
                  <td height="19" class=estilo_titulo > <input name="param" type="hidden" id="param4" value="<? echo $parz ?>"> 
                    <input name="codigo" type="hidden" id="param5" value="<? echo $idz ?>"></td>
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