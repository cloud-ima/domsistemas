<?php

include("../conexion.php");

$x_flag = $_GET["flag"] ?? '';

if ( $x_flag == 0 ) {
   $idestado = "Nuevo Registro";
   $parz = 1;
   $nomz = "";
}   

if ( $x_flag == 1 ) {
    $idestado = "Modificando Registro";
	$link=conectarse();
    $idz=$_GET['id'] ?? '';
    $ssql = "select * from pob where id ='$idz'";
    $rs = mysql_query($ssql,$link);
    $num_registros = mysql_num_rows($rs); 
	if ($num_registros == 0){
		   header("location: index.php");
	}else{
		   while ($row = mysql_fetch_array($rs)){
		       $nomz = $row["nombre"];
  			   $idz  = $row["id"];
			   $parz = 2;
          }
	}
				  mysql_close($link);
}   
?>
<html>
<head>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="0" topmargin="0">
<TABLE cellSpacing=0 cellPadding=0 width="500" 
border=0>
  <TBODY>
    <TR> 
      <TD 
    style="BORDER-RIGHT: #cccccc 1px; BORDER-TOP: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px; BORDER-BOTTOM: #cccccc 1px solid" 
    vAlign=center align=left width="473" bgColor=#ffffff 
      height=42>&nbsp;&nbsp;<font color="#333333" size="3" face="Georgia, Times New Roman, Times, serif"><strong>Crear 
        Juntas Vecinales(<?php echo $idestado ?>)</strong></font></TD>
      <TD 
    style="BORDER-RIGHT: #cccccc 1px solid; BORDER-TOP: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px; BORDER-BOTTOM: #cccccc 1px solid" 
    vAlign=center align=right width="534" bgColor=#ffffff> 
        <IMG height=40 alt=separador 
      src="images/puntos.gif" width=1></TD>
    </TR>
  </TBODY>
</TABLE>
<form action="mantenedor.php" method="POST" enctype="multipart/form-data" >
  <table width="500" border="0" cellpadding="0" cellspacing="9">
    <tr>
      <td width="790" height="114" valign="top"> 
        <TABLE cellSpacing=6 cellPadding=2 width=100% align=left 
border=0>
          <TBODY>
            <TR> 
              <TD width="96" bgColor=#ffffff><SPAN > Junta Vecinal</SPAN></TD>
              <TD width="360" bgColor=#ffffff><input class=bordecampos name="nombre" type="text" id="nombre" value="<?php echo $nomz ?>" size="60" maxlength="100"></TD>
            </TR>
            <TR> 
              <TD bgColor=#ffffff>&nbsp;</TD>
              <TD bgColor=#ffffff> <DIV> 
                  <div align="left"> 
                    <input class=bordecampos name="enviar" type="submit" id="enviar3" value="Grabar">
                  </div>
                </DIV></TD>
            </TR>
            <TR> 
              <TD bgColor=#ffffff><input name="param" type="hidden" id="param" value="<?php echo $parz ?>"> 
                <input name="codigo" type="hidden" id="codigo" value="<?php echo $idz ?>"></TD>
              <TD bgColor=#ffffff>&nbsp;</TD>
            </TR>
          </TBODY>
        </TABLE>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
      </td>
    </tr>
  </table>
</form>
</body>
</html>