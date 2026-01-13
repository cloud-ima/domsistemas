<?
include("../seguridad.php");
$link=conectarse();
$rut_id=$_POST['rut'];
if ( $rut_id == '') { header("location: ingresa.php"); }
$sql = "select * from rut where rut ='$rut_id'";
$rs = mysql_query($sql,$link);
$num_registros = mysql_num_rows($rs);
if ($num_registros == 0)
    {
		      $nomz = "";
			  $apez = "";
			  $telz = "";
			  $dirz = "";
			  $corz = "";
			  
			  $parz = "1";
	}
	else
	{
	 while ($row = mysql_fetch_array($rs)){
		      $nomz = $row["nombre"];
			  $apez = $row["apellidos"];
			  $telz = $row["telefonos"];
			  $dirz = $row["direccion"];
			  $corz = $row["correo"];
			  $parz = "2";
            }
    }
 		   mysql_close($link);
?>
<html>
<head>
<title>MUNIARICA.CL</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<script language=javascript type=text/javascript>
function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey;
</script>

<script type="text/javascript">
function enviar(formulario){
if(formulario.nombres.value==""){
     //formulario.nombre.className="disabled";
     alert("Falta ingresar nombres") 
     formulario.nombres.focus()
return false;
}
if(formulario.apellidos.value==""){
     //formulario.nombre.className="disabled";
     alert("Falta ingresar Apellidos") 
     formulario.apellidos.focus()
return false;
}
if(formulario.telefonos.value==""){
     //formulario.nombre.className="disabled";
     alert("Debe ingresar teléfonos del contacto") 
     formulario.telefonos.focus()
return false;
}
}
</script>
<script type="text/javascript" src="../validarut.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="0" topmargin="0">
<br>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="17">&nbsp;</td>
    <td width="853"><div align="right"><a href="../principal.php"><img src="../images/volver.gif" width="50" height="40" border="0"></a></div></td>
    <td width="1"><div align="right"></div></td>
  </tr>
</table>
<br>
<table width="100%" height="80%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <table width="506" border="0" align="center" cellpadding="0" cellspacing="8">
          <tr valign="top"> 
            <td width="490" height="322"> 
              <div align="justify"> 
                <form name="formulario" method="post" action="mantenedor_vecinos.php" onSubmit="return enviar(this)">
                  <br>
                  <table width="466" height="220" border="0" align="center" cellpadding="5" cellspacing="5">
                    <tr bgcolor="#336699"> 
                      <td height="20" colspan="2"> <div align="center"><font color="#FFFFFF"><strong>Complete 
                          los siguientes datos para continuar:</strong> </font></div></td>
                    </tr>
                    <tr> 
                      <td width="122" height="20">R.U.T.</td>
                      <td width="309"><strong><font color="#990000"><? echo $rut_id ?></font></strong></td>
                    </tr>
                    <tr> 
                      <td height="20">Nombres</td>
                      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
                        <input name="nombres" type="text" id="nombre2" value="<? echo $nomz?>" size="50">
                        </font></td>
                    </tr>
                    <tr> 
                      <td height="20">Apellidos</td>
                      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
                        <input name="apellidos" type="text" id="email2" value="<? echo $apez?>" size="50">
                        </font></td>
                    </tr>
                    <tr> 
                      <td height="20">Tel&eacute;fonos</td>
                      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
                        <input name="telefonos" type="text" id="email3" value="<? echo $telz?>" size="50">
                        </font></td>
                    </tr>
                    <tr> 
                      <td height="25">Direcci&oacute;n</td>
                      <td height="25"><font size="2" face="Arial, Helvetica, sans-serif"> 
                        <input name="direc" type="text" id="direc" value="<? echo $dirz?>" size="50">
                        </font></td>
                    </tr>
                    <tr> 
                      <td height="25">Correo El&eacute;ctr&oacute;nico</td>
                      <td height="25"><font size="2" face="Arial, Helvetica, sans-serif"> 
                        <input name="correo" type="text" id="correo" value="<? echo $corz?>" size="50">
                        </font></td>
                    </tr>
                    <tr> 
                      <td height="25"><font size="2" face="Arial, Helvetica, sans-serif"> 
                        <input name="rut" type="hidden" id="rut3" value="<? echo $rut_id ?>">
                        <input name="param" type="hidden" id="param3" value="<? echo $parz ?>">
                        </font></td>
                      <td height="25"><input type="submit" name="Submit" value="Continuar"></td>
                    </tr>
                  </table>
                </form>
              </div></td>
          </tr>
        </table>
        </font><br>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td><div align="center"> 
                <? include("../footer.php");?>
              </div></td>
          </tr>
        </table>
        <br>
    </div></td>
  </tr>
</table>
</body>
</html>