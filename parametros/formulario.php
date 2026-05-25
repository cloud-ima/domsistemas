<?php

include("../conexion.php");

$x_flag = $_GET["flag"] ?? '';
$x_param = $_GET["param"] ?? '';

// Valores por defecto para evitar variables no inicializadas.
$idestado = "Estado(Ingresando Nuevo Registro)";
$parz = 1;
$desz = "";
$hasz = "";
$ufz = "";
$utmz = "";
$cuoz = "";
$idz = "";

// Nuevo registro: puede venir como ?param=1 o ?flag=0.
if ($x_param == 1 || $x_flag == 0 || $x_flag === '') {
   $idestado = "Estado(Ingresando Nuevo Registro)";
   $parz = 1;
}   

if ( $x_flag == 1 ) {
    $idestado = "Estado(Modificación del Registro)";
	$link=conectarse();
    $idz=$_GET['id'] ?? '';
    $ssql = "select * from param where id ='$idz'";
    $rs = mysql_query($ssql,$link); 
    $num_registros = mysql_num_rows($rs); 
	if ($num_registros == 0){
		   header("location: m_sectores.php");
	}else{
		   while ($row = mysql_fetch_array($rs)){
   				  $desz = $row["desde"];
   				  $hasz = $row["hasta"];
   				  $ufz = $row["uf"];
   				  $utmz = $row["utm"];
   				  $cuoz = $row["cuota"];				  				  				  				  
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript">
function esNumeroValido(v) {
  var x = (v || "").replace(/\./g, "").replace(",", ".").trim();
  if (x === "") return false;
  return !isNaN(x);
}

function enviar(form1){
if(form1.desde.value==""){
     alert("Debe Ingresar Fecha Inicial")
     form1.desde.focus()
return false;
}
if(form1.hasta.value==""){
     alert("Debe Ingresar Fecha Final")
     form1.hasta.focus()
return false;
}
if(form1.uf.value==""){
     alert("Debe Ingresar valor U.F.")
     form1.uf.focus()
return false;
}
if(!esNumeroValido(form1.uf.value)){
     alert("Debe Ingresar un valor numérico válido para U.F.")
     form1.uf.focus()
return false;
}
if(form1.utm.value==""){
     alert("Debe Ingresar valor U.T.M.")
     form1.utm.focus()
return false;
}
if(!esNumeroValido(form1.utm.value)){
     alert("Debe Ingresar un valor numérico válido para U.T.M.")
     form1.utm.focus()
return false;
}
if(form1.cuota.value==""){
     alert("Debe Ingresar valor Cuota Ahorro")
     form1.cuota.focus()
return false;
}
if(!esNumeroValido(form1.cuota.value)){
     alert("Debe Ingresar un valor numérico válido para Cuota Ahorro")
     form1.cuota.focus()
return false;
}
return true;
}
</script>
</head>
<body>
<form action="mantenedor.php" method="POST" enctype="multipart/form-data" onSubmit="return enviar(this)">
  <table width="467" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="467" height="200" valign="top"> 
        <table width="461" border="0" cellpadding="2" cellspacing="0">
          <tr> 
            <td width="461" align="center"> <div align="left"><strong>Par&aacute;metros 
                Financieros<font size="2"> </font></strong></div></td>
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
                  <td width="146" height="26" bgcolor="#efefef" class=estilo_titulo >Fecha 
                    Inicial</td>
                  <td width="294" bgcolor="#efefef"> 
                    <input name="desde" type="text" id="titulo2" value="<?php echo $desz ?>" size="20" maxlength="100">
                  </td>
                </tr>
                <tr>
                  <td height="19" bgcolor="#efefef" class=estilo_titulo >Fecha 
                    Final</td>
                  <td bgcolor="#efefef">
<input name="hasta" type="text" id="nombre" value="<?php echo $hasz ?>" size="20" maxlength="100">
                  </td>
                </tr>
                <tr> 
                  <td height="19" bgcolor="#efefef" class=estilo_titulo >U.F.</td>
                  <td bgcolor="#efefef">
<input name="uf" type="text" id="nombre2" value="<?php echo $ufz ?>" size="20" maxlength="100">
                  </td>
                </tr>
                <tr> 
                  <td height="19" bgcolor="#efefef" class=estilo_titulo >U.T.M.</td>
                  <td bgcolor="#efefef">
<input name="utm" type="text" id="nombre3" value="<?php echo $utmz ?>" size="20" maxlength="100">
                  </td>
                </tr>
                <tr> 
                  <td height="19" bgcolor="#efefef" class=estilo_titulo >Cuota 
                    Ahorro</td>
                  <td bgcolor="#efefef">
<input name="cuota" type="text" id="nombre4" value="<?php echo $cuoz ?>" size="20" maxlength="100">
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
