<?php
include("../seguridad.php");
include("../fechaclasss.php");
include("fckeditor/fckeditor.php");

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
   
/*    $dire = '../uploads/ID_ROL'.$_GET['id'];
	$direreal='/domsistemas/uploads/ID_ROL'.$_GET['id'];

	
if (is_dir($dire)) {
    $vale=1;
	//echo "existe el directorio";
}
else {
mkdir($dire, 0777, true);
//echo "se ha creado el directorio";
}
*/
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
			  $desx  = $row["destino"];
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
			  $obsx = $row["obs"];
			  
			  $n1x = $row["n1"];
			  $n2x = $row["n2"];
			  $n3x = $row["n3"];
			  $n4x = $row["n4"];
			  $a1x = $row["a1"];
			  $a2x = $row["a2"];
			  $a3x = $row["a3"];
			  $a4x = $row["a4"];
			  $l1x = $row["l1"];
			  $l2x = $row["l2"];
			  $l3x = $row["l3"];
			  $l4x = $row["l4"];
			  $d1x = $row["d1"];
			  $d2x = $row["d2"];
			  $d3x = $row["d3"];
			  $d4x = $row["d4"];

			  $pcx = $row["pc"];
			  $pcdx = $row["pcdate"];
			  $rfx = $row["rf"];
			  $rfdx = $row["rfdate"];
			  $estpatx = $row["estadopatente"];
			  $fsitpatx = $row["festadopatente"];
			  $obspatx = $row["obspatente"];
			  $newnumx = $row["otrosnum"];
			  $oax = $row["oa"];
			  $parz = 2;
			  $estadocampo = "disabled";
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

<script type="text/javascript">
<!--

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
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style5 {color: #333333; font-weight: bold; }
.style8 {
	color: #000000;
	font-weight: bold;
}
.style11 {color: #000000}
.style13 {color: #990000; font-size: 12px; font-weight: bold; }
.style14 {color: #FF0000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="1000" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="990" valign="top"><form name="form1" method="post" action="mantenedor_propiedades.php" onSubmit="return enviar(this)" >
      <br>
      <table width="998" border="0" cellpadding="2" cellspacing="2" bgcolor="#cccccc">
        <tr>
          <td><span class="style8">Antecedentes Generales de la Propiedad (<span class="style13"><font size="3"><? echo $idestado ?></font></span>) </span></td>
        </tr>
      </table>
      <br>
      <table width="998" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="481" valign="top"><table width="480" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td width="122"><div align="left"><strong>R.O.L.</strong></div></td>
              <td width="339"><input name="rol" type="text" class=bordecampos id="rol" value="<? echo $rolx; ?>" size="15" maxlength="10"></td>
            </tr>
            <tr>
              <td><div align="right" class="style11">
                <div align="left">Direcci&oacute;n</div>
              </div></td>
              <td><input  name="dire" type="text" class=bordecampos id="dire" value="<? echo $direx; ?>" size="50" maxlength="100"></td>
            </tr>
            <tr>
              <td><div align="right" class="style11">
                <div align="left">Tipo de V&iacute;a </div>
              </div></td>
              <td><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM vias order by nombre",$linkc);
?>
                <select class=bordecampos name="via" id="select7">
                  <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                  <option value="<? echo $rowc["nombre"] ?>"
<? if($rowc["nombre"] == $viax){?>selected<?}?>> <? echo $rowc["nombre"]?> </option>
                  <? }
mysql_close($linkc);
?>
              </select></td>
            </tr>
            <tr>
              <td><span class="style11">N&uacute;meraci&oacute;n</span></td>
              <td><input  name="num" type="text" class=bordecampos id="num" value="<? echo $numx; ?>" size="50" maxlength="100"></td>
            </tr>
            <tr>
              <td><div align="left"></div></td>
              <td><table width="338" border="0" cellpadding="2" cellspacing="2">
                <tr bgcolor="#efefef">
                  <td width="55"><div align="center" class="style5">Block</div></td>
                  <td width="55"><div align="center" class="style5">Depto</div></td>
                  <td width="50"><div align="center"><span class="style5">Sitio</span></div></td>
                  <td width="89"><div align="center"><span class="style5">Manzana</span></div></td>
                </tr>
                <tr>
                  <td><div align="center">
                    <input  name="block" type="text" class=bordecampos id="block" value="<? echo $blockx; ?>" size="8" maxlength="10">
                  </div></td>
                  <td><div align="center">
                    <input  name="depto" type="text" class=bordecampos id="depto" value="<? echo $deptox; ?>" size="8" maxlength="10">
                  </div></td>
                  <td><div align="center">
                    <input  name="sitio" type="text" class=bordecampos id="sitio" value="<? echo $sitiox; ?>" size="8" maxlength="10">
                  </div></td>
                  <td><div align="center">
                    <input  name="man" type="text" class=bordecampos id="man" value="<? echo $manx; ?>" size="20" maxlength="50">
                  </div></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><div align="left"><span class="style11">Poblaci&oacute;n</span></div></td>
              <td><?php
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
              <td><div align="left"><span class="style11">Nombre Referencia </span></div></td>
              <td><input  name="referencia" type="text" class=bordecampos id="referencia" value="<? echo $refx; ?>" size="50" maxlength="100"></td>
            </tr>
            <tr>
              <td><div align="left"><span class="style11">Clase</span></div></td>
              <td><?php
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
              <td><div align="left"></div></td>
              <td><input name="param" type="hidden" id="param2" value="<? echo $parz ?>">
                <input name="codigo" type="hidden" id="codigo" value="<? echo $idz ?>"></td>
            </tr>
          </table>
            
            <table width="475" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td width="467"><table width="93%" height="20" border="0" cellpadding="2" cellspacing="2">
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
                    <td height="18" align="right" bgcolor="#efefef"><div align="right"></div>                      
                      <div align="left"><span class="style11"><strong>N&uacute;meros Nuevos en la misma Propiedad </strong></span>
                      </div>
                      <div align="center" class="style11"></div>                      <div align="center" class="style11"></div>                      <div align="center" class="style11"></div>                      <div align="center" class="style11"></div></td>
                    </tr>
                </table>
                  <textarea name="numnuevo" cols="70" rows="10" class="bordecampos" id="numnuevo"><? echo $newnumx; ?></textarea>
                  <br>
                  <span class="style14">Nota: Solo llenar este campo especificamente con informaci&oacute;n de <br>
                  nuevos n&uacute;meros agregados a la propiedad , pudiendo ingresar nuevas <br>
                  direcciones para el caso de casa esquina. </span><br></td>
              </tr>
            </table></td>
          <td width="489" valign="top"><table width="480" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td><span class="style11">Destino</span></td>
              <td><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM destino order by nombre",$linkc);
?>
                <select class=bordecampos name="destino" id="select7">
                  <option value="SIN ESPECIFICAR">SIN ESPECIFICAR</option>
                  <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                  <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $desx){?>selected<?}?>> <? echo $rowc["nombre"]?> </option>
                  <? }
mysql_close($linkc);
?>
                </select></td>
            </tr>
            <tr>
              <td width="110"><div align="left" class="style11">Zona</div></td>
              <td width="356"><?php
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
              <td><div align="right" class="style11">
                <div align="left">Urbanizaci&oacute;n</div>
              </div></td>
              <td><?php
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
              <td><div align="right" class="style11">
                <div align="left">Tipo propiedad </div>
              </div></td>
              <td><?php
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
              <td><div align="left"><span class="style11">Uso del Suelo </span></div></td>
              <td><?php
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
              <td><div align="left"><span class="style11">Expropiaci&oacute;n</span></div></td>
              <td><?php
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
              <td><div align="left"><span class="style11">Radio Urbano </span></div></td>
              <td><?php
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
              <td><div align="left" class="style11"><span class="style11">MT 2 </span></div></td>
              <td><input  name="mt" type="text" class=bordecampos id="mt" value="<? echo $mtx; ?>" size="10" maxlength="10"></td>
            </tr>
            <tr>
              <td><div align="left" class="style11">MT 2 Const. </div></td>
              <td><input  name="mtc" type="text" class=bordecampos id="mtc" value="<? echo $mtcx; ?>" size="10" maxlength="10"></td>
            </tr>
            <tr>
              <td><span class="style11">Nr. KARDEX </span></td>
              <td><input  name="kardex" type="text" class=bordecampos id="kardex" value="<? echo $karx; ?>" size="10" maxlength="10"></td>
            </tr>
            <tr>
              <td><div align="left" class="style11">Otro Antecedente</div></td>
              <td><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM antecedentes order by id",$linkc);
?>
                <select class=bordecampos name="antece" id="select7">
                   <option value="0">SIN ESPECIFICAR</option>				
                  <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                  <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $oax){?>selected<?}?>> <? echo $rowc["nombre"]?> </option>
                  <? }
mysql_close($linkc);
?>
                </select></td>
            </tr>
            <tr bgcolor="#efefef">
              <td colspan="2"><div align="center"><strong>PERMISO DE CONSTRUCCI&Oacute;N Y RECEPCION FINAL </strong></div></td>
              </tr>
            <tr>
              <td>PC</td>
              <td><input  name="pc" type="text" class=bordecampos id="pc" value="<? echo $pcx; ?>" size="15" maxlength="10"> 
                - 
                  <input  name="pcd" type="text" class=bordecampos id="pcd" value="<? echo $pcdx; ?>" size="15" maxlength="10"></td>
            </tr>
            <tr>
              <td>RF</td>
              <td><input  name="rf" type="text" class=bordecampos id="rf" value="<? echo $rfx; ?>" size="15" maxlength="10"> 
                - 
                  <input  name="rfd" type="text" class=bordecampos id="rfd" value="<? echo $rfdx; ?>" size="15" maxlength="10"></td>
            </tr>
            <tr>
              <td>Situaci&oacute;n Final </td>
              <td><?php
$linkc=conectarse();
$resultc = mysql_query("SELECT * FROM situacionpatente order by id",$linkc);
?>
                <select class=bordecampos name="sitpatente" id="select7">
				<option value="0">SIN ESPECIFICAR</option>
                  <?php
while($rowc = mysql_fetch_array($resultc)) {
?>
                  <option value="<? echo $rowc["id"] ?>"
<? if($rowc["id"] == $estpatx){?>selected<?}?>> <? echo $rowc["nombre"]?> </option>
                  <? }
mysql_close($linkc);
?>
                </select> <br>
                <? echo $fsitpatx; ?></td>
            </tr>
            <tr>
              <td>Observaciones</td>
              <td><textarea name="obspat" cols="55" rows="7" class="bordecampos" id="obspat"><? echo $obspatx; ?></textarea></td>
            </tr>
            <tr>
              <td><div align="left"></div></td>
              <td><input name="submit" type="submit" value="  Guardar  "></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <br>
      <table width="998" border="0" cellpadding="2" cellspacing="2" bgcolor="#cccccc">
        <tr>
          <td><span class="style8">LINEAS OFICIALES </span></td>
        </tr>
      </table>
            <table width="998" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="481" height="216" valign="top"><table width="480" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td width="177" bgcolor="#efefef"><div align="left"><strong>LADO 1 </strong></div></td>
                <td width="284">&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right" class="style11">
                    <div align="left">Nombre de V&iacute;a </div>
                </div></td>
                <td><input  name="via1" type="text" class=bordecampos id="via1" value="<? echo $n1x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="right" class="style11">
                    <div align="left">Antejard&iacute;n De: </div>
                </div></td>
                <td><input  name="ante1" type="text" class=bordecampos id="ante1" value="<? echo $a1x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="left"><span class="style11">L&iacute;nea oficial se encuentra a </span></div></td>
                <td><input  name="linea1" type="text" class=bordecampos id="linea1" value="<? echo $l1x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="left"><span class="style11">Derecho a V&iacute;a </span></div></td>
                <td><input  name="derecho1" type="text" class=bordecampos id="derecho1" value="<? echo $d1x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="left"></div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="177" bgcolor="#efefef"><div align="left"><strong>LADO 2</strong></div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right" class="style11">
                    <div align="left">Nombre de V&iacute;a </div>
                </div></td>
                <td><input  name="via2" type="text" class=bordecampos id="via2" value="<? echo $n2x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="right" class="style11">
                    <div align="left">Antejard&iacute;n De: </div>
                </div></td>
                <td><input  name="ante2" type="text" class=bordecampos id="ante2" value="<? echo $a2x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="left"><span class="style11">L&iacute;nea oficial se encuentra a </span></div></td>
                <td><input  name="linea2" type="text" class=bordecampos id="linea2" value="<? echo $l2x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="left"><span class="style11">Derecho a V&iacute;a </span></div></td>
                <td><input  name="derecho2" type="text" class=bordecampos id="derecho2" value="<? echo $d2x; ?>" size="40" maxlength="100"></td>
              </tr>
          </table></td>
          <td width="489" valign="top"><table width="487" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td width="177" bgcolor="#efefef"><div align="left"><strong>LADO 3</strong></div></td>
                <td width="296">&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right" class="style11">
                    <div align="left">Nombre de V&iacute;a </div>
                </div></td>
                <td><input  name="via3" type="text" class=bordecampos id="via3" value="<? echo $n3x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="right" class="style11">
                    <div align="left">Antejard&iacute;n De: </div>
                </div></td>
                <td><input  name="ante3" type="text" class=bordecampos id="ante3" value="<? echo $a3x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="left"><span class="style11">L&iacute;nea oficial se encuentra a </span></div></td>
                <td><input  name="linea3" type="text" class=bordecampos id="linea3" value="<? echo $l3x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="left"><span class="style11">Derecho a V&iacute;a </span></div></td>
                <td><input  name="derecho3" type="text" class=bordecampos id="derecho3" value="<? echo $d3x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="177" bgcolor="#efefef"><div align="left"><strong>LADO 4</strong></div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right" class="style11">
                    <div align="left">Nombre de V&iacute;a </div>
                </div></td>
                <td><input  name="via4" type="text" class=bordecampos id="via4" value="<? echo $n4x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="right" class="style11">
                    <div align="left">Antejard&iacute;n De: </div>
                </div></td>
                <td><input  name="ante4" type="text" class=bordecampos id="ante4" value="<? echo $a4x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="left"><span class="style11">L&iacute;nea oficial se encuentra a </span></div></td>
                <td><input  name="linea4" type="text" class=bordecampos id="linea4" value="<? echo $l4x; ?>" size="40" maxlength="100"></td>
              </tr>
              <tr>
                <td><div align="left"><span class="style11">Derecho a V&iacute;a </span></div></td>
                <td><input  name="derecho4" type="text" class=bordecampos id="derecho4" value="<? echo $d4x; ?>" size="40" maxlength="100"></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <br>
      <br>
      <br>
      <br>
      <table width="998" border="0" cellpadding="2" cellspacing="2" bgcolor="#cccccc">
        <tr>
          <td><span class="style8">Otros Antecedentes (Leyes , Resoluciones , Multas) </span></td>
        </tr>
      </table>
            <table width="973" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="965"><?php 
		  		  if ( $parz == 2 ) {
    $oFCKeditor = new FCKeditor('FCKeditor2');
    $oFCKeditor->BasePath = 'fckeditor/';
    $oFCKeditor->Width  = '100%' ;
    $oFCKeditor->Height = '200' ;
	$oFCKeditor->Value = $obsx;
    $oFCKeditor->Create() ;
	}
?></td>
        </tr>
      </table>
      <br>
      <br>
      <table width="998" border="0" cellpadding="2" cellspacing="2" bgcolor="#cccccc">
        <tr>
          <td><div align="center">Direcci&oacute;n de Obras Municipalidad de Arica </div></td>
        </tr>
      </table>
      <br>
    </form></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>