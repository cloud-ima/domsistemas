<? //include "top.php" ?>
<? $error=$_GET['error']; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>MUNIARICA.CL</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1"><LINK 
href="menus/estilos.css" type=text/css rel=stylesheet>
<SCRIPT src="menus/util.js"></SCRIPT>

<SCRIPT src="menus/util2.js"></SCRIPT>

<SCRIPT language=javascript>
function fncConectar() {
var oFormulario;

	if (document.all.txtLogin.value=='') {
		alert('Debe especificar un nombre de usuario');
		return false;
	}

	if (document.all.txtClave.value=='') {
		alert('Debe especificar una clave de ingreso');
		return false;
	}

	//desactivar cierre de sesión automático
	top.frames[0].document.all.chk_proceso.checked = true;

	oFormulario = document.forms['frmLogin'];
	oFormulario.action = 'validacion.php?action=login&versession=no';
	oFormulario.submit();
}

</SCRIPT>

<SCRIPT language=JavaScript type=text/JavaScript>
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</SCRIPT>

<META content="MSHTML 6.00.2900.2180" name=GENERATOR></HEAD>
<BODY class=normal oncopy="" onload=document.forms[0].elements[0].focus();>
<!--<div id="Layer1" style="position:absolute; left:16px; top: 9px; width:39px; height:36px; z-index:1"><img src="../images/llaves.jpg" width="48" height="56"></div>-->
<br>
<br>
<br>
<FORM name=frmLogin action="validacion.php" method=post>
  <TABLE width=356 border=0 align="center" cellPadding=0 cellSpacing=0>
    <TBODY>
      <TR> 
        <TD width=13><IMG height=28 src="menus/titleleft.jpg" 
width=13></TD>
        <TD class=TituloVentana width="330" 
    background=menus/titlemiddle.jpg><div align="left">Iniciar sesión</div></TD>
        <TD width=13><IMG height=28 src="menus/titleright.jpg" 
    width=13></TD>
      </TR>
      <TR> 
        <TD width=13 background=menus/BodyLeft.jpg>&nbsp;</TD>
        <TD width="330"><BR> <SPAN 
      class=normal>Por favor, introduzca su Usuario y clave para <STRONG>iniciar 
          una sesión</STRONG> en el sistema.<BR>
          </SPAN>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td><div align="center"><strong><font class=normal color="#FF0000"><? echo $error ?></font></strong></div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
        </TD>
        <TD width=13 background=menus/BodyRight.jpg>&nbsp;</TD>
      </TR>
      <TR> 
        <TD width=13 background=menus/BodyLeft.jpg>&nbsp;</TD>
        <TD width="330"><TABLE class=normal cellSpacing=3 cellPadding=0 width="88%" border=0>
            <TBODY>
              <TR> 
                <TD width="37%"> <DIV align=right><STRONG>Usuario:</STRONG>&nbsp;</DIV></TD>
                <TD width="63%">&nbsp; <INPUT class=NormalCell 
            onkeypress="valida_keypress(' 0áéíóú123456789/*-.,-:;abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ')" 
            id=txtLogin onblur="this.className='NormalCell'" 
            onfocus="this.className='FocusCell'; this.select();" maxLength=30 
            name=txtLogin></TD>
              </TR>
              <TR> 
                <TD> <DIV align=right><STRONG>Clave:</STRONG>&nbsp;</DIV></TD>
                <TD>&nbsp; <INPUT class=NormalCell 
            onkeypress="valida_keypress(' 0áéíóú123456789/*-.,-:;abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ')" 
            id=txtClave onblur="this.className='NormalCell'" 
            onfocus="this.className='FocusCell'; this.select();" type=password 
            maxLength=20 name=txtClave></TD>
              </TR>
            </TBODY>
          </TABLE>
          <br>
        </TD>
        <TD width=13 background=menus/BodyRight.jpg>&nbsp;</TD>
      </TR>
      <TR> 
        <TD width=13 background=menus/BodyLeft.jpg>&nbsp;</TD>
        <TD width="330"> <DIV align=right> 
            <INPUT class=BotonNormal id=cmdAceptar onmouseover="this.className='BotonOver'" onmouseout="this.className='BotonNormal'" type="submit" value=" Iniciar sesión " name=cmdAceptar>
          </DIV></TD>
        <TD width=13 background=menus/BodyRight.jpg>&nbsp;</TD>
      </TR>
      <TR> 
        <TD><IMG height=24 src="menus/bottomleft.jpg" width=13></TD>
        <TD background=menus/bottommiddle.jpg>&nbsp;</TD>
        <TD><IMG height=24 src="menus/bottomright.jpg" 
  width=13></TD>
      </TR>
    </TBODY>
  </TABLE>
</FORM>

<br>
<table class=normal width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">
        <? include("footer.php");?>
      </div></td>
  </tr>
</table>
