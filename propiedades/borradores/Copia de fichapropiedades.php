<?php
include("../seguridad.php");
include("../fechaclasss.php");
include("fckeditor/fckeditor.php");
if ( $tipousuario <> 1 and $tipousuario <> 4 ) { 
			 echo '<script language="javascript">';
			 echo "alert('Sr. Usuario no tiene acceso a este módulo');";
			 echo "location.href='../parametros.php';";
			 echo "</script>";
}
$idz = $_GET["id"] ?? '';
$rolz = $_GET["rol"] ?? '';

$link=conectarse();
$ssql = "select * from propiedades where rol ='$rolz' limit 1";
$rs = mysql_query($ssql,$link);
$num_registros = mysql_num_rows($rs); 
if ($num_registros == 0){
	     header("location: list_propiedades.php");
}else{
	     while ($row = mysql_fetch_array($rs)){
				 
		//*************************| Proceso de Busqueda de la Solicitud |**************************************	 
		 
				 $link=Conectarse();
				 $qry = "SELECT * from parametros where id = 1";
				 $res = mysql_query($qry);
				 $tablaperiodo = "cert". mysql_result($res, 0, "periodo");

				 $link=Conectarse();
				 $qry = "SELECT * FROM $tablaperiodo where id ='$idz'";
				 $res = mysql_query($qry);
				 $fecha_sol = mysql_result($res, 0, "fecha_solicitud");
				 $totalx = mysql_result($res, 0, "total");
				 $idcertx = mysql_result($res, 0, "idcert");
				 $rutx = mysql_result($res, 0, "rut");
				 $girox = mysql_result($res, 0, "giro_numero");
				 $gfechax = cambiaf_a_normal(mysql_result($res, 0, "giro_fecha"));
				 $ordenx = mysql_result($res, 0, "orden_numero"); 

				 $link=Conectarse();
				 $qry = "SELECT * FROM rut where rut ='$rutx'";
				 $res = mysql_query($qry);
				 $nomx = mysql_result($res, 0, "nombre"). ' ' . mysql_result($res, 0, "apellidos");
				 $corx = mysql_result($res, 0, "correo");

				 $link=Conectarse();
				 $qry = "SELECT * FROM tipocertificado where id ='$idcertx'";
				 $res = mysql_query($qry);
				 $cerdoc = mysql_result($res, 0, "nombre");
				 $reporte = mysql_result($res, 0, "reporte");

				 
		//*************************| Fin del Proceso de Busqueda de la Solicitud |********************************
		 
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
			  $obsx = $row["obs"];
			  $idx =  $row["id"];
			  $parz = 2;
            }
}			
				  mysql_close($link);

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
if(form1.pob.value=="SIN ESPECIFICAR"){
     alert("Debe Especificar Nombre de Población") 
     form1.pob.focus()
return false;
}
}
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
.style14 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="1000" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="990" valign="top"><form name="form1" method="post" action="<?php echo $reporte; ?>" onSubmit="return enviar(this)" >
      <br>
      <table width="998" border="0" cellpadding="2" cellspacing="2" bgcolor="#cccccc">
        <tr>
          <td><span class="style8">Antecedentes Generales de la Propiedad (<span class="style13"><font size="3"><?php echo $idestado ?></font></span>) </span></td>
        </tr>
      </table>
      <br>
      <table width="998" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="481" valign="top"><table width="480" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td width="122"><div align="left"><strong>R.O.L.</strong></div></td>
              <td width="339"><input  name="rol" type="text" class=bordecampos id="rol" value="<?php echo $rolx; ?>" size="15" maxlength="10"></td>
            </tr>
            <tr>
              <td><div align="right" class="style11">
                <div align="left">Direcci&oacute;n</div>
              </div></td>
              <td><input  name="dire" type="text" class=bordecampos id="dire" value="<?php echo $direx; ?>" size="50" maxlength="100"></td>
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
                  <option value="<?php echo $rowc["id"] ?>"
<?php if($rowc["nombre"] == $viax){?>selected<?php }?>> <?php echo $rowc["nombre"]?> </option>
                  <?php }
mysql_close($linkc);
?>
              </select></td>
            </tr>
            <tr>
              <td><div align="left"><span class="style11">N&uacute;meraci&oacute;n</span></div></td>
              <td><table width="306" border="0" cellpadding="2" cellspacing="2">
                <tr bgcolor="#efefef">
                  <td width="57"><div align="center" class="style5">N&uacute;mero</div></td>
                  <td width="55"><div align="center" class="style5">Block</div></td>
                  <td width="55"><div align="center" class="style5">Depto</div></td>
                  <td width="50"><div align="center"><span class="style5">Sitio</span></div></td>
                  <td width="57"><div align="center"><span class="style5">Manzana</span></div></td>
                </tr>
                <tr>
                  <td><div align="center">
                    <input  name="num" type="text" class=bordecampos id="num" value="<?php echo $numx; ?>" size="8" maxlength="10">
                  </div></td>
                  <td><div align="center">
                    <input  name="block" type="text" class=bordecampos id="block" value="<?php echo $blockx; ?>" size="8" maxlength="10">
                  </div></td>
                  <td><div align="center">
                    <input  name="depto" type="text" class=bordecampos id="depto" value="<?php echo $deptox; ?>" size="8" maxlength="10">
                  </div></td>
                  <td><div align="center">
                    <input  name="sitio" type="text" class=bordecampos id="sitio" value="<?php echo $sitiox; ?>" size="8" maxlength="10">
                  </div></td>
                  <td><div align="center">
                    <input  name="man" type="text" class=bordecampos id="man" value="<?php echo $manx; ?>" size="8" maxlength="10">
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
                  <option value="<?php echo $rowc["id"] ?>"
<?php if($rowc["id"] == $pobx){?>selected<?php }?>> <?php echo $rowc["nombre"]?> </option>
                  <?php }
mysql_close($linkc);
?>
                </select></td>
            </tr>
            <tr>
              <td><div align="left"><span class="style11">Nombre Referencia </span></div></td>
              <td><input  name="referencia" type="text" class=bordecampos id="referencia" value="<?php echo $refx; ?>" size="50" maxlength="100"></td>
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
                  <option value="<?php echo $rowc["id"] ?>"
<?php if($rowc["id"] == $classx){?>selected<?php }?>> <?php echo $rowc["nombre"]?> </option>
                  <?php }
mysql_close($linkc);
?>
                </select></td>
            </tr>
            <tr>
              <td><div align="left"></div></td>
              <td><input name="param" type="hidden" id="param" value="<?php echo $parz ?>">
                <input name="codigo" type="hidden" id="codigo" value="<?php echo $idx ?>">
                <input name="foliox" type="hidden" id="foliox" value="<?php echo $idz ?>"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
          <td width="489" valign="top"><table width="480" border="0" cellspacing="2" cellpadding="2">
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
                  <option value="<?php echo $rowc["id"] ?>"
<?php if($rowc["id"] == $zonax){?>selected<?php }?>> <?php echo $rowc["id"]?> </option>
                  <?php }
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
                  <option value="<?php echo $rowc["id"] ?>"
<?php if($rowc["id"] == $urbax){?>selected<?php }?>> <?php echo $rowc["id"]?> </option>
                  <?php }
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
                  <option value="<?php echo $rowc["id"] ?>"
<?php if($rowc["id"] == $tpx){?>selected<?php }?>> <?php echo $rowc["nombre"]?> </option>
                  <?php }
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
                  <option value="<?php echo $rowc["id"] ?>"
<?php if($rowc["id"] == $usox){?>selected<?php }?>> <?php echo $rowc["nombre"]?> </option>
                  <?php }
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
                  <option value="<?php echo $rowc["id"] ?>"
<?php if($rowc["id"] == $expox){?>selected<?php }?>> <?php echo $rowc["id"]?> </option>
                  <?php }
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
                  <option value="<?php echo $rowc["id"] ?>"
<?php if($rowc["id"] == $radiox){?>selected<?php }?>> <?php echo $rowc["id"]?> </option>
                  <?php }
mysql_close($linkc);
?>
                </select></td>
            </tr>
            <tr>
              <td><div align="left" class="style11"><span class="style11">MT 2 </span></div></td>
              <td><input  name="mt" type="text" class=bordecampos id="mt" value="<?php echo $mtx; ?>" size="10" maxlength="10"></td>
            </tr>
            <tr>
              <td><div align="left" class="style11">MT 2 Const. </div></td>
              <td><input  name="mtc" type="text" class=bordecampos id="mtc" value="<?php echo $mtcx; ?>" size="10" maxlength="10"></td>
            </tr>
            <tr>
              <td><div align="left" class="style11">Nr. KARDEX </div></td>
              <td><input  name="kardex" type="text" class=bordecampos id="kardex" value="<?php echo $karx; ?>" size="10" maxlength="10"></td>
            </tr>
            <tr>
              <td><div align="left"></div></td>
              <td><input name="submit" type="submit" value="  Guardar  / Imprimir "></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="listo" type="checkbox" id="listo" value="checkbox">
                <span class="style14">Marcar Listo para Entrega </span></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="998" border="0" cellpadding="2" cellspacing="2" bgcolor="#cccccc">
        <tr>
          <td><span class="style8">Antecedentes Contables </span></td>
        </tr>
      </table>
            <table width="973" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="965"><table width="998" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td width="481" valign="top"><table width="480" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="122"><div align="left"><strong>RUT</strong></div></td>
                    <td width="339"><input  name="rut" type="hidden" class=bordecampos id="rut" value="<?php echo $rutx; ?>" size="20" maxlength="10"> <?php echo $rutx; ?></td>
                  </tr>
                  <tr>
                    <td><div align="right" class="style11">
                        <div align="left">Contribuyente</div>
                    </div></td>
                    <td><input   name="nombre" type="hidden" class=bordecampos id="nombre" value="<?php echo $nomx; ?>" size="50" maxlength="100"> <?php echo $nomx; ?></td>
                  </tr>
                  <tr>
                    <td><div align="left"><span class="style11">Correo Electr&oacute;nico </span></div></td>
                    <td><input   name="correo" type="hidden" class=bordecampos id="correo" value="<?php echo $corx; ?>" size="50" maxlength="100"><?php echo $corx; ?></td>
                  </tr>
                  <tr>
                    <td><div align="left"><span class="style11">Fecha Solicitud </span></div></td>
                    <td><input   name="fecha" type="hidden" class=bordecampos id="fecha" value="<?php echo $fecha_sol; ?>" size="50" maxlength="100"><?php echo $fecha_sol; ?></td>
                  </tr>
              </table></td>
              <td width="489" valign="top"><table width="480" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="110"><div align="left" class="style11">Num. Giro </div></td>
                    <td width="356"><input   name="giro" type="hidden" class=bordecampos id="giro" value="<?php echo $girox; ?>" size="20" maxlength="10"><?php echo $girox; ?></td>
                  </tr>
                  <tr>
                    <td><div align="left" class="style11">Fecha Giro </div></td>
                    <td><input   name="fechagiro" type="hidden" class=bordecampos id="fechagiro" value="<?php echo $gfechax; ?>" size="20" maxlength="10"><?php echo $gfechax; ?></td>
                  </tr>
                  <tr>
                    <td><div align="left" class="style11">Orden Municipal </div></td>
                    <td><input   name="orden" type="hidden" class=bordecampos id="orden" value="<?php echo $ordenx; ?>" size="20" maxlength="10"><?php echo $ordenx; ?></td>
                  </tr>
                  <tr>
                    <td><span class="style11">Certificado</span></td>
                    <td><input   name="doc" type="hidden" class=bordecampos id="doc" value="<?php echo $cerdoc; ?>" size="50" maxlength="10"><?php echo $cerdoc; ?></td>
                  </tr>
                  <tr>
                    <td><div align="left"><span class="style11">Total ($) </span></div></td>
                    <td><input   name="total" type="hidden" class=bordecampos id="total" value="<?php echo $totalx; ?>" size="20" maxlength="10"><?php echo $totalx; ?></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table>
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