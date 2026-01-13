<?php
include("../seguridadsimple.php");
include("../fechaclasss.php");

//imprimirCS.php?variable=<?php echo $_POST[numerocs];

if ( $tipousuario <> 1 and $tipousuario <> 4 ) { 
			 echo '<script language="javascript">';
			 echo "alert('Sr. Usuario no tiene acceso a este módulo');";
			 echo "location.href='../parametros.php';";
			 echo "</script>";
}

$link=conectarse();

//*******************[ Busqueda de Directores para firma de documentos ]**********************
			  $qry = "SELECT * FROM directores where activo ='S'";
			  $res = mysql_query($qry);
			  $linea_fin1 = mysql_result($res, 0, "nombre");
			  $linea_fin2 = mysql_result($res, 0, "titulo");
			  $linea_fin3 = mysql_result($res, 0, "cargo");			 

$ok = $_POST['listo'];
$ff = $_POST['foliox'];

include("grabaclass.php");

//echo $idx;
//echo $folioz;

 if ( $ok == 'checkbox' )
	 {
 		 	 $link=conectarse();
	   	     $sql= "UPDATE cert2009 SET estado = '3' where id = '$ff' ";
   		     $result2=mysql_query($sql);
 			 mysql_close($link);
	 }

$link=conectarse();
$ssql = "select * from propiedades where rol ='$rolx' limit 1";
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
				 $qry = "SELECT * FROM $tablaperiodo where id ='$folioz'";
				 $res = mysql_query($qry);
				 $fecha_sol = mysql_result($res, 0, "fecha_solicitud");
				 $totalx = mysql_result($res, 0, "total");
				 $idcertx = mysql_result($res, 0, "idcert");
				 $rutx = mysql_result($res, 0, "rut");
				 $girox = mysql_result($res, 0, "giro_numero");
				 $gfechax = cambiaf_a_normal(mysql_result($res, 0, "giro_fecha"));
				 $ordenx = mysql_result($res, 0, "orden_numero"); 
				 
   			//  $link=Conectarse();
			//  $qry = "SELECT * FROM cert2009 where id ='$ff'";
			//  $res = mysql_query($qry);
			  $idusuario = mysql_result($res, 0, "responsable");

				 

				 $link=Conectarse();
				 $qry = "SELECT * FROM rut where rut ='$rutx'";
				 $res = mysql_query($qry);
				 $nomx = mysql_result($res, 0, "nombre"). ' ' . mysql_result($res, 0, "apellidos");
				 $corx = mysql_result($res, 0, "correo");

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
			  $oax = $row["oa"];
			  
			  $mas = "";
			  $oa = "";
		  
			  if ( $oax <> 0  ){
   			     $link=Conectarse();
				 $qry = "SELECT * FROM antecedentes where id ='$oax'";
				 $res = mysql_query($qry);
				 $oa = "Antecedentes " ;
				 $mas = mysql_result($res, 0, "nombre");				 
			  }	 

			  
			  $link=Conectarse();
				 $qry = "SELECT * FROM pob where id ='$pobx'";
				 $res = mysql_query($qry);
				 $nompob = mysql_result($res, 0, "nombre");

			  $link=Conectarse();
				 $qry = "SELECT * FROM zonas where id ='$zonax'";
				 $res = mysql_query($qry);
				 $zonainfo = mysql_result($res, 0, "info");

			  $parz = 2;
            }
}			
				  mysql_close($link);

?>
<html>
<head>
<title></title>
<link href="../css/estilosprint.css" rel="stylesheet" type="text/css">
<script language='javascript' src="../popcalendar.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function popup()
{
window.open('zonas/zm1.pdf','','toolbar=0,location=0,menubar=0,resizable=0,top=0,left=0')
}
</script> 
<style type="text/css">
<!--
.style11 {color: #000000}
.style15 {
	font-size: 16px;
	font-weight: bold;
	color: #000000;
}
.style17 {
	color: #000000;
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>
<body onload="popup()" leftmargin="0" topmargin="0">
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="658" valign="top"><table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><div align="center"><img src="images/escudoarica.jpg" width="120" height="161"></div></td>
        </tr>
        <tr>
          <td><div align="center"><span class="style15">CERTIFICADO DE 
  INFORMES PREVIOS 
  N&ordm; <? echo $ff ?> </span></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><span class="style11"><strong>IDENTIFICACION DE LA PROPIEDAD <br>
          </strong></span>
          <hr></td>
        </tr>
        <tr>
          <td><table width="650" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="106"><div align="left" class="style11"><strong>R.O.L.</strong></div></td>
              <td width="537" class="style17"><? echo $rolx; ?></td>
            </tr>
            <tr>
              <td><div align="right" class="style11">
                  <div align="left">Direcci&oacute;n</div>
              </div></td>
              <td><span class="style11"><? echo $direx; ?>, Pob. <? echo $nompob; ?></span></td>
            </tr>
            <tr>
              <td valign="middle"><div align="left"><span class="style11">Numeraci&oacute;n</span></div></td>
              <td valign="top">                <table width="537" border="0" cellpadding="0" cellspacing="0">
                  <tr bgcolor="#efefef">
                    <td width="529" colspan="5"><div align="center" class="style11">
                      <div align="left">N&uacute;mero: <? echo $numx; ?>, Block <? echo $blockx; ?>, Depto. <? echo $deptox; ?>, Sitio <? echo $sitiox; ?>, Manzana <? echo $manx; ?></div>
                    </div></td>
                    </tr>
              </table></td>
            </tr>
            <tr>
              <td><span class="style11">Zona</span></td>
              <td class="style11"><strong>(<? echo $zonax; ?>)</strong> <? echo $zonainfo; ?></td>
            </tr>
            <tr>
              <td><? echo $oa; ?></td>
              <td><? echo $mas; ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><hr></td>
        </tr>
        <tr>
          <td><span class="style11"><strong>LINEAS OFICIALES</strong></span>
            <hr>          </td>
        </tr>
        <tr>
          <td valign="top"><table width="650" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="333" height="183" valign="top"><table width="332" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2" bgcolor="#efefef"><div align="left" class="style11"><strong>LINEA 1 </strong></div></td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="right" class="style11">
                        <div align="left">Nombre de V&iacute;a , <? echo $n1x; ?></div>
                    </div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="right" class="style11">
                        <div align="left">Antejard&iacute;n De: <? echo $a1x; ?></div>
                    </div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="left" class="style11">L&iacute;nea oficial se encuentra a ,<? echo $l1x; ?></div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="left"><span class="style11">Derecho a V&iacute;a , <? echo $d1x; ?></span></div>                      </td>
                    </tr>
                  <tr>
                    <td width="165"><div align="left"></div></td>
                    <td width="153">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" bgcolor="#efefef"><div align="left" class="style11"><strong>LINEA 2</strong></div></td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="right" class="style11">
                        <div align="left">Nombre de V&iacute;a , <? echo $n2x; ?></div>
                    </div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="right" class="style11">
                        <div align="left">Antejard&iacute;n De: <? echo $a2x; ?></div>
                    </div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="left"><span class="style11">L&iacute;nea oficial se encuentra a , <? echo $l2x; ?></span></div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="left"><span class="style11">Derecho a V&iacute;a , <? echo $d2x; ?></span></div>                      </td>
                    </tr>
              </table></td>
              <td width="317" valign="top"><table width="314" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2" bgcolor="#efefef"><div align="left" class="style11"><strong>LINEA 3</strong></div></td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="right" class="style11">
                        <div align="left">Nombre de V&iacute;a , <? echo $n3x; ?></div>
                    </div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="right" class="style11">
                        <div align="left">Antejard&iacute;n De: <? echo $a3x; ?></div>
                    </div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="left"><span class="style11">L&iacute;nea oficial se encuentra a , <? echo $l3x; ?></span></div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="left"><span class="style11">Derecho a V&iacute;a , <? echo $d3x; ?></span></div>                      </td>
                    </tr>
                  <tr>
                    <td width="154"><div align="left"></div></td>
                    <td width="146">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" bgcolor="#efefef"><div align="left" class="style11"><strong>LINEA 4</strong></div></td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="right" class="style11">
                        <div align="left">Nombre de V&iacute;a , <? echo $n4x; ?></div>
                    </div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="right" class="style11">
                        <div align="left">Antejard&iacute;n De: <? echo $a4x; ?></div>
                    </div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="left"><span class="style11">L&iacute;nea oficial se encuentra a , <? echo $l4x; ?></span></div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2"><div align="left"><span class="style11">Derecho a V&iacute;a , <? echo $d4x; ?></span></div>                      </td>
                    </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><hr></td>
        </tr>
        <tr>
          <td><span class="style11"><strong>INFORMACION CONTABLE</strong></span></td>
        </tr>
        <tr>
          <td><hr></td>
        </tr>
        <tr>
          <td><table width="650" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td width="136"><div align="center" class="style11"><strong>Fecha Solicitud</strong></div></td>
              <td width="94"><div align="center" class="style11"><strong>N&ordm; Giro </strong></div></td>
              <td width="83"><div align="center" class="style11"><strong>Fecha Giro </strong></div></td>
              <td width="91"><div align="center" class="style11"><strong>N&ordm; Orden </strong></div></td>
              <td width="157"><div align="center" class="style11"><strong>Monto Cancelado</strong></div></td>
              <td width="129"><div align="center" class="style11"><strong>RUT Solicitante </strong></div></td>
            </tr>
            <tr>
              <td><div align="center" class="style11"><? echo $fecha_sol; ?></div></td>
              <td><div align="center" class="style11"><? echo $girox; ?></div></td>
              <td><div align="center" class="style11"><? echo $gfechax; ?></div></td>
              <td><div align="center" class="style11"><? echo $ordenx; ?></div></td>
              <td><div align="center" class="style11">$ <? echo $totalx; ?></div></td>
              <td><div align="center" class="style11"><? echo $rutx; ?></div></td>
            </tr>
          </table></td>
        </tr>
      </table>      
      <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table width="574" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="269">&nbsp;</td>
        <td width="384"><hr></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center" class="style11"><strong><? echo $linea_fin1;?><br>
          <? echo $linea_fin2;?><br>
          <? echo $linea_fin3;?>        </strong></div></td>
      </tr>
    </table>    <p>&nbsp;</p>
    <p>Usuario: <? echo $idusuario; ?> </p></td>
  </tr>
</table>
<p>&nbsp; </p>
<p><br>
  <br>
</p>
</body>
</html>
