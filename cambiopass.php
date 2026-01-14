<?php include("seguridad.php");
?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<script language="Javascript">
function validar()
{
ingreso = new String()
ingreso1 = new String()
ingresoold = new String()
ingreso = document.formu.pass1.value
ingreso1 = document.formu.pass2.value
ingresoold = document.formu.passold.value

if ( ingresoold.length == 0 ) 
	{
		alert( "Debe ingresar la Contraseña Anterior");
		formu.passold.focus()
		return false;
	}

if ( ingreso.length == 0 ) 
	{
		alert( "Debe ingresar una Contraseña");
		formu.pass1.focus()
		return false;
	}

if ( ingreso1.length == 0 ) 
	{
		alert( "Debe ingresar una Contraseña");
		formu.pass2.focus()
		return false;
	}

if (ingreso != ingreso1)
{ alert("Contraseña Incorrecta, confirme nuevamente")
formu.pass2.focus()
return false
}
return true
}
</script>


<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<style type="text/css">
<!--
.style3 {font-size: 16px}
.style2 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 16px;
}
-->
</style>
<body leftmargin="0" topmargin="0">
<font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font> 
<table width="616" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="616" height="18"><div align="left">
        <table width="562" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="523"><div align="right"></div></td>
          </tr>
          <tr> 
            <td><div align="center"><span class="style2"><br>
              Cambio de Contrase&ntilde;a </span></div></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr> 
    <td height="130"> <form NAME="formu" action="update_pass.php" OnSubmit="return validar()" method="post" >
        <table width="364" height="121" border="0" align="center" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF">
          <tr> 
            <td height="24">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="24"><font color="#000000">Contrase&ntilde;a Anterior</font></td>
            <td> <input name="passold" type="password" id="passold" size="20" maxlength="20"></td>
          </tr>
          <tr> 
            <td width="170" height="24"><font color="#000000">Nueva Contrase&ntilde;a</font></td>
            <td width="179"><input name="pass1" type="password" id="pass1" size="20" maxlength="20"> 
            </td>
          </tr>
          <tr> 
            <td height="24"><font color="#000000">Confirmar Contrase&ntilde;a</font></td>
            <td><input name="pass2" type="password" id="pass2" value="" size="20" maxlength="20"></td>
          </tr>
        </table>
        <br>
        <table width="258" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="120"><div align="center"> 
                <input name="enviar" type="submit" id="enviar" value="Guardar">
              </div></td>
            <td width="138"><div align="center"> 
                <input type="reset" name="Submit3" value="Borrar Formulario">
              </div></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"></div></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>

<br>
<?php
include "footer.php";
?>
<br>
