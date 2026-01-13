<?php
include("../seguridad.php");
include("../fechaclasss.php");

//******************************************************
// Validación del Ingreso (Nuevo,edición)


$x_flag = $_GET["flag"];
if ( $x_flag == 0 ) {
   $idestado = "Nuevo Registro";
   $parz = 1;
   $viax = 'SIN ESPECIFICAR';
   $urbax = 'SIN ESPECIFICAR';
   $expox = 'SIN ESPECIFICAR';
   $radiox = 'SIN ESPECIFICAR';
   $zonax = 'SIN ESPECIFICAR';
   $tpx = '1';
   $classx = '1';
  
}   

if ( $x_flag == 1 ) {
    $idestado = "Modificando Registro";
	$link=conectarse();
    $idz=$_GET['id'];
    $ssql = "select * from propiedades where id ='$idz'";
    $rs = mysql_query($ssql,$link);
    $num_registros = mysql_num_rows($rs); 
	if ($num_registros == 0){
	     header("location: list_propiedades.php");
	}else{
	     while ($row = mysql_fetch_array($rs)){
	          $viax  = $row["tipocalle"];
			  $urbax = $row["urbanizacion"];
			  $expox = $row["expropiacion"];
			  $radiox = $row["radiourbano"];
			  $direx = $row["direccion"];
			  $rolx = $row["rol"];
			  $numx = $row["numero"];
			  $blockx = $row["block"];
			  $deptox = $row["depto"];
			  $sitiox = $row["sitio"];
			  $manx = $row["manzana"];
			  $tpx = $row["tipo"];
			  $usox = $row["uso"];
			  $refx = $row["nombre_referencial"];
			  $karx = $row["kardex"];
			  $mtx = $row["mt2total"];
			  $mtcx = $row["mt2cons"];
			  $zonax = $row["zona"];
			  $classx = $row["clase"];			  
			  $pobx = $row["pob"];			  
			  $parz = 2;
            }
	}
				  mysql_close($link);
}   

/*if ($tipousuario == 2 or $tipousuario == 3 ) {
 			 echo '<script language="javascript">';
			 echo "alert('Sr. Usuario, no tiene acceso a Este módulo!');";
			 echo "location.href='principal.php';";
			 echo "</script>";
}*/
	
function suma_fechas($fecha,$ndias)
{
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=split("/", $fecha);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=split("-",$fecha);
              $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
              $nuevafecha=date("Y-m-d",$nueva);
	  return ($nuevafecha);
}

$fec = date('d')."/".date('m')."/".date('Y');
$fecha_hoy = date('d')."/".date('m')."/".date('Y');
$diasplazo = 7;
$fec_entrega = suma_fechas($fec, $diasplazo);
$fec_entrega = cambiaf_a_normal($fec_entrega);
?>
<html>
<head>
<title>MUNIARICA.CL</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<script language='javascript' src="../popcalendar.js"></script>
<script language=javascript type=text/javascript>
function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey;
</script>

<script language=javascript type=text/javascript>
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

<script type="text/javascript">
function enviar(form1){
if(form1.rol.value==""){
     alert("Debe Ingresar Numero de ROL") 
     form1.rol.focus()
return false;
}
if(form1.dire.value==""){
     alert("Debe Ingresar direccion de la Propiedad") 
     form1.dire.focus()
return false;
}

if(form1.num.value==""){
     alert("Debe Especificar numero de domicilio") 
     form1.num.focus()
return false;
}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style2 {color: #FFFFFF; font-weight: bold; }
.style5 {color: #333333; font-weight: bold; }
.style6 {color: #333333}
.style7 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.style8 {
	font-size: 14px;
	font-weight: bold;
}
.style9 {font-size: 12px}
.style10 {color: #000000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="998" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="990" valign="top"><form name="form1" method="post" action="mantenedor_propiedades.php" onSubmit="return enviar(this)" >
      <table width="950%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="2%">&nbsp;</td>
          <td width="64%" valign="top"><br>
            <table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
              <tr>
                <td width="8"><div align="left"><span class="TituloVentana style8"> </span></div></td>
                <td width="678"><span class="TituloVentana style8">Registro de Propiedades</span></td>
              </tr>
            </table>
                        <TABLE width=700 border=0 align="center" cellPadding=0 cellSpacing=0>
              <TBODY>
                <TR>
                  <TD width=13><IMG height=28 src="../menus/titleleft.jpg" 
width=13></TD>
                  <TD class=TituloVentana width="733" 
    background=../menus/titlemiddle.jpg><div align="left" class="style7"> Propiedad (<font size="3"><strong><? echo $idestado ?></strong></font>) </div></TD>
                  <TD width=13><IMG height=28 src="../menus/titleright.jpg" 
    width=13></TD>
                </TR>
                <TR>
                  <TD width=13 background=../menus/BodyLeft.jpg>&nbsp;</TD>
                  <TD width="733" rowspan="2"><table width="659" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td width="178" bgcolor="#efefef"><span class="style2 style6">R.O.L.</span></td>
                        <td width="333"><input  name="rol" type="text" class=bordecampos id="rol" value="<? echo $rolx; ?>" size="15" maxlength="10"></td>
                        <td width="128">&nbsp;</td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style2 style6">Direcci&oacute;n</span></td>
                        <td colspan="2"><input  name="dire" type="text" class=bordecampos id="dire" value="<? echo $direx; ?>" size="70" maxlength="100"></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style2 style6">Tipo de V&iacute;a </span></td>
                        <td colspan="2"><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM vias order by nombre",$linkc);
?>
                            <select class=bordecampos name="via" id="select7">
                              <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                              <option value="<? echo $rowc["id"] ?>"
<? if($rowc["nombre"] == $viax){?>selected<?}?>> <? echo $rowc["nombre"]?> </option>
                              <? }
mysql_close($linkc);
?>
                          </select></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style2 style6">Numeraci&oacute;n</span></td>
                        <td colspan="2"><table width="332" border="0" cellpadding="2" cellspacing="2">
                            <tr bgcolor="#D2E9FF">
                              <td width="83"><div align="center" class="style5">N&uacute;mero</div></td>
                              <td width="83"><div align="center" class="style5">Block</div></td>
                              <td width="83"><div align="center" class="style5">Depto</div></td>
                              <td width="60"><div align="center"><span class="style5">Sitio</span></div></td>
                              <td width="171"><div align="center"><span class="style5">Manzana</span></div></td>
                            </tr>
                            <tr>
                              <td><input  name="num" type="text" class=bordecampos id="num" value="<? echo $numx; ?>" size="10" maxlength="10"></td>
                              <td><input  name="block" type="text" class=bordecampos id="block" value="<? echo $blockx; ?>" size="10" maxlength="10"></td>
                              <td><input  name="depto" type="text" class=bordecampos id="depto" value="<? echo $deptox; ?>" size="10" maxlength="10"></td>
                              <td><input  name="sitio" type="text" class=bordecampos id="sitio" value="<? echo $sitiox; ?>" size="10" maxlength="10"></td>
                              <td><input  name="man" type="text" class=bordecampos id="man" value="<? echo $manx; ?>" size="10" maxlength="10"></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style5">Poblaci&oacute;n</span></td>
                        <td colspan="2"><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM pob order by nombre",$linkc);
?>
                            <select class=bordecampos name="pob" id="select7">
                              <option value="SIN ESPECIFICAR">SIN ESPECIFICAR</option>
                              <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                              <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $pobx){?>selected<?}?>> <? echo $rowc["nombre"]?> </option>
                              <? }
mysql_close($linkc);
?>
                          </select></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style5">Nombre Referencial </span><span class="style5"></span></td>
                        <td colspan="2"><input  name="referencia" type="text" class=bordecampos id="referencia" value="<? echo $refx; ?>" size="50" maxlength="100"></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style6"><strong>Zona</strong></span></td>
                        <td colspan="2"><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM zonas order by id",$linkc);
?>
                            <select class=bordecampos name="zona" id="select7">
                              <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                              <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $zonax){?>selected<?}?>> <? echo $rowc["id"]?> </option>
                              <? }
mysql_close($linkc);
?>
                          </select></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><strong>Urbanizaci&oacute;n</strong>
                            <div align="left"></div></td>
                        <td colspan="2"><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM urbanizacion order by id",$linkc);
?>
                            <select class=bordecampos name="urba" id="select7">
                              <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                              <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $urbax){?>selected<?}?>> <? echo $rowc["id"]?> </option>
                              <? }
mysql_close($linkc);
?>
                          </select></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style6"><strong>Tipo Propiedad </strong></span></td>
                        <td colspan="2"><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM tipo order by nombre",$linkc);
?>
                            <select class=bordecampos name="tipo" id="select7">
                              <option value="0">SIN ESPECIFICAR</option>
                              <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                              <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $tpx){?>selected<?}?>> <? echo $rowc["nombre"]?> </option>
                              <? }
mysql_close($linkc);
?>
                          </select></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style2 style6">Uso del Suelo</span></td>
                        <td colspan="2"><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM usos order by nombre",$linkc);
?>
                            <select class=bordecampos name="uso" id="select7">
                              <option value="SIN ESPECIFICAR">SIN ESPECIFICAR</option>
                              <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                              <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $usox){?>selected<?}?>> <? echo $rowc["nombre"]?> </option>
                              <? }
mysql_close($linkc);
?>
                          </select></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style2 style6">Expropiaci&oacute;n</span></td>
                        <td colspan="2"><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM expropiacion order by id",$linkc);
?>
                            <select class=bordecampos name="expo" id="select7">
                              <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                              <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $expox){?>selected<?}?>> <? echo $rowc["id"]?> </option>
                              <? }
mysql_close($linkc);
?>
                          </select></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style2 style6">Radio urbano </span></td>
                        <td colspan="2"><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM radiourbano order by id",$linkc);
?>
                            <select class=bordecampos name="radio" id="select7">
                              <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                              <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $radiox){?>selected<?}?>> <? echo $rowc["id"]?> </option>
                              <? }
mysql_close($linkc);
?>
                          </select></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style2 style6">Clasificaci&oacute;n</span></td>
                        <td colspan="2"><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM clases order by nombre",$linkc);
?>
                            <select class=bordecampos name="class" id="select7">
                              <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                              <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $classx){?>selected<?}?>> <? echo $rowc["nombre"]?> </option>
                              <? }
mysql_close($linkc);
?>
                          </select></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style2 style6">MT 2 </span></td>
                        <td colspan="2"><input  name="mt" type="text" class=bordecampos id="mt" value="<? echo $mtx; ?>" size="10" maxlength="10"></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style2 style6">MT 2 Construidos </span></td>
                        <td colspan="2"><input  name="mtc" type="text" class=bordecampos id="mtc" value="<? echo $mtcx; ?>" size="10" maxlength="10"></td>
                      </tr>
                      <tr>
                        <td bgcolor="#efefef"><span class="style2 style6">N&uacute;mero KARDEX</span></td>
                        <td colspan="2"><input  name="kardex" type="text" class=bordecampos id="kardex" value="<? echo $karx; ?>" size="10" maxlength="10"></td>
                      </tr>
                      <tr>
                        <td><input name="param" type="hidden" id="param2" value="<? echo $parz ?>">
                            <input name="codigo" type="hidden" id="codigo" value="<? echo $idz ?>"></td>
                        <td colspan="2"><input name="submit" type="submit" value="  Guardar  "></td>
                      </tr>
                    </table>
                      <br>
                  </TD>
                  <TD width=13 background=../menus/BodyRight.jpg>&nbsp;</TD>
                </TR>
                <TR>
                  <TD width=13 background=../menus/BodyLeft.jpg>&nbsp;</TD>
                  <TD width=13 background=../menus/BodyRight.jpg>&nbsp;</TD>
                </TR>
                <TR>
                  <TD><IMG height=24 src="../menus/bottomleft.jpg" width=13></TD>
                  <TD background=../menus/bottommiddle.jpg>&nbsp;</TD>
                  <TD><IMG height=24 src="../menus/bottomright.jpg" 
  width=13></TD>
                </TR>
              </TBODY>
            </TABLE></td>
          <td width="34%" valign="top"><br>
            <br>
            <br>
            <br></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td valign="top"><TABLE cellSpacing=3 cellPadding=0 width=750 align=center 
border=0>
      <TBODY>
        <TR>
          <TD width="738" bgColor=#ffffff><? include "../footer.php" ?>
          </TD>
        </TR>
      </TBODY>
    </TABLE></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>