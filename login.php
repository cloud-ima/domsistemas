<? $error=$_GET['error']; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>DOM - Municipalidad de Arica</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ffffff;
}
.table-main {
	font-family: Tebruchet MS,Tahoma,sans-serif;
	font-size: 11px;
	line-height: 22px;
	color: #ffffff;
	background-image:url(img/bg_login.jpg);
/*	background-repeat: no-repeat;*/
	background-repeat: repeat-x;
}
.table-inside {
	font-family: Tebruchet MS,Tahoma,sans-serif;
	font-size: 11px;
	line-height: 22px;
	color: #ffffff;
	background-image:url(img/top_center.jpg);
	background-repeat: no-repeat;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-main">
  <tr>
    <td><table width="846" border="0" align="center" cellpadding="0" cellspacing="0" class="table-inside">
      <tr>
        <td width="423"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="43">&nbsp;</td>
        <td width="380"><table width="369" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="369">&nbsp;</td>
          </tr>
        </table>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
		  <FORM name=frmLogin action="validacion.php" method=post>
            <TABLE width=323 border=0 align="center" cellPadding=0 cellSpacing=0>
              <TBODY>
                <TR>
                  <TD width=13>&nbsp;</TD>
                  <TD width="304"><BR>
                      <SPAN 
      class=normal>Por favor, introduzca su Usuario y clave para <STRONG>iniciar una sesi&oacute;n</STRONG> en el sistema.<BR>
                      </SPAN>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><div align="center"><strong><font class=normal color="#FF0000"><? echo $error ?></font></strong></div></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                    </table></TD>
                  <TD width=39>&nbsp;</TD>
                </TR>
                <TR>
                  <TD width=13>&nbsp;</TD>
                  <TD width="304"><TABLE class=normal cellSpacing=3 cellPadding=0 width="88%" border=0>
                      <TBODY>
                        <TR>
                          <TD width="37%"><DIV align=right><STRONG>Usuario:</STRONG>&nbsp;</DIV></TD>
                          <TD width="63%"><INPUT class=NormalCell 
            onkeypress="valida_keypress(' 0&aacute;&eacute;&iacute;&oacute;&uacute;123456789/*-.,-:;abcdefghijklmn&ntilde;opqrstuvwxyzABCDEFGHIJKLMN&Ntilde;OPQRSTUVWXYZ')" 
            id=txtLogin onblur="this.className='NormalCell'" 
            onfocus="this.className='FocusCell'; this.select();" maxLength=30 
            name=txtLogin></TD>
                        </TR>
                        <TR>
                          <TD><DIV align=right><STRONG>Clave:</STRONG>&nbsp;</DIV></TD>
                          <TD><INPUT class=NormalCell 
            onkeypress="valida_keypress(' 0&aacute;&eacute;&iacute;&oacute;&uacute;123456789/*-.,-:;abcdefghijklmn&ntilde;opqrstuvwxyzABCDEFGHIJKLMN&Ntilde;OPQRSTUVWXYZ')" 
            id=txtClave onblur="this.className='NormalCell'" 
            onfocus="this.className='FocusCell'; this.select();" type=password 
            maxLength=20 name=txtClave></TD>
                        </TR>
                        <TR>
                          <TD>&nbsp;</TD>
                          <TD><input class=BotonNormal id=cmdAceptar onMouseOver="this.className='BotonOver'" onMouseOut="this.className='BotonNormal'" type="submit" value=" Iniciar sesi&oacute;n " name=cmdAceptar></TD>
                        </TR>
                      </TBODY>
                    </TABLE>
                      <br>
                  </TD>
                  <TD width=39>&nbsp;</TD>
                </TR>
              </TBODY>
            </TABLE>
          </form>          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="850" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td><div align="center" class="style2">Direcci&oacute;n de Obras Ilustre Municipalidad de Arica - Soporte y Desarrollo Soporte T&eacute;cnico 206968 </div></td>
  </tr>
</table>
</body>
</html>
