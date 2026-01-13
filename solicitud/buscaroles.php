<?php
include "../seguridadsimple.php";
//include "conexion.php";
$mensajetitulo = "Consultando Registro de Propiedades";
$hoy = date('Y')."-".date('m')."-".date('d');
$x_num = '';
$x_rol = '';
$x_via = '';
$x_rol = $_POST["rol"];
$x_num = $_POST["num"];
$x_via = strtoupper($_POST["via"]);

if ( $x_rol == '' and $x_num == '' and $x_via == '' ){
          $consultaSQL = "SELECT * FROM propiedades where rol = 'NN' order by rol"; 
}
else
    {
	  if ( $x_rol <> '' ){
	      //$consultaSQL = "SELECT * FROM propiedades where rol LIKE '%$x_rol%' order by rol";
		  $consultaSQL = "SELECT * FROM propiedades where rol = '$x_rol' order by rol";
	}
	  else 
	    { 
	      $consultaSQL = "SELECT * FROM propiedades where (direccion LIKE '%$x_num%' and direccion LIKE '%$x_via%') order by direccion";
		}
}
//echo $consultaSQL;
?>
<html>
<head>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language='javascript'>
  function seleccionar(codigo,nombre)
  {
      //opener.window.location.reload( false );
	        // echo "window.close();";
	  alert(nombre);
      solicitud = opener.document.getElementById('form1');
//      solicitud.rol.value = codigo;
  //    solicitud = opener.document.getElementById('form1');	  
      solicitud.direccion.value = nombre;
//	  window.close();
      close();
  }
</script>
<style type="text/css">

#fixedtipdiv{
position:absolute;
padding: 2px;
border:1px solid black;
font:normal 12px Verdana;
line-height:18px;
z-index:100;
}

</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td> 
      <? //include "botones.php"; ?>
    </td>
  </tr>
  <tr> 
    <td height="142"><div align="center"> 
        <form name="form1" method="post" action="">
          <table width="600" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="864"><table width="600" border="0" cellspacing="3" cellpadding="2">
                  <tr> 
                    <td colspan="2"><font size="4"><strong>Buscador de Propiedades 
                      </strong></font></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr> 
                    <td width="220">Nombre Avenida/Calle/Pasaje</td>
                    <td colspan="2"><input name="via" type="text" id="num3" value="<? echo $x_via; ?>" size="30">
                      * Solo para busqueda por n&uacute;mero</td>
                  </tr>
                  <tr> 
                    <td>N&uacute;mero de Domicilio</td>
                    <td colspan="2"><input name="num" type="text" id="num2" value="<? echo $x_num; ?>" size="30"></td>
                  </tr>
                  <tr> 
                    <td>N&uacute;mero de Rol</td>
                    <td width="194"><input name="rol" type="text" id="rol2" value="<? echo $x_rol ?>" size="30"></td>
                    <td width="324"><input name="imageField" type="image" onClick="nombreFormulario.send();return false" src="../Images/zoom.gif" width="24" height="22" border="0"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </form>
    </div></td>
  </tr>
</table>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="13"><IMG height=28 src="../menus/titleleft.jpg" 
width=13></td>
    <td width="871" background="../menus/titlemiddle.jpg"><strong><font color="#FFFFFF">Registro 
      de Propiedades</font></strong></td>
    <td width="16"><IMG height=28 src="../menus/titleright.jpg" 
    width=13></td>
  </tr>
  <tr> 
    <td background="../menus/BodyLeft.jpg"><img src="../menus/BodyLeft.jpg" width="13" height="14"></td>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
        <tr> 
          <td width="96" height="23"><div align="center"><font color="#000000"><strong>Rol</strong></font></div></td>
          <td width="125"><font color="#000000"><strong>Tipo V&iacute;a</strong></font></td>
          <td width="216"><font color="#000000"><strong>Direcci&oacute;n</strong></font></td>
          <td width="310"><font color="#000000"><strong>Poblaci&oacute;n/Manzana/Sitio</strong></font><font color="#000000">&nbsp;</font></td>
          <td width="112">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="56" valign="top"> <table width="87%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="693" align="center"> <strong> 
                  <?php 
				  $link=conectarse();
		          $result=mysql_query($consultaSQL,$link);
				  $num_total_registros = mysql_num_rows($result);
				  echo " Total registros Encontrados : " . $num_total_registros;
		          $a=1;
				while ($row = mysql_fetch_array($result)){
				
				    $codigo = "'".$row["rol"]."'";
					$dire = $row["direccion"];
           			/*           $cod= $row["rut"];
							   $fecha= $row["fechaingreso"];
							   $link=Conectarse();
						$qry = "SELECT * FROM vecinos where rut ='$cod'";
						$res = mysql_query($qry);
						$nombre = mysql_result($res, 0, "nombre"). " ".mysql_result($res, 0, "apellidos");
						
						$link=Conectarse();
						$cod = $row["estado"];
						$qry = "SELECT * FROM estados where id ='$cod'";
						$res = mysql_query($qry);
						$nombreestado = mysql_result($res, 0, "nombre"); 
		  
		  $direc = "solicitudcom.php?id=".$row["id"]."&rut=". $row["rut"]; */
		   
	/*	   $codsec= $row["estado"];
           $link=Conectarse(); 
           $qry = "SELECT * FROM estados WHERE id='$codsec'";
		   $res = mysql_query($qry);
           $nombreestado = mysql_result($res, 0, "nombre");*/
?>
                  </strong></td>
              </tr>
            </table>
            <table width="99%" height="35" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <? 
                    $color2 = "#A6E2FF";
				if ($a == 0) {
                    $color = "#f1f1f1";
					$a = 1;
                }else{
                    $color = "#ffffff";
					$a = 0;
		        }	 
				
			/*	if ( $dias_diferencia > 19 ) { 
				    $color = "#FFCC66";
					 } */
				?>
                <td width="57" height="35" align="center" bgcolor="<? echo $color ?>" ><? echo $row["rol"]
 ?> <br /> </td>
                <td width="81" bgcolor="<? echo $color ?>" ><? echo $row["tipocalle"]
 ?></td>
                <td width="140" bgcolor="<? echo $color ?>" ><? echo $row["direccion"]
 ?></td>
                <td width="212" bgcolor="<? echo $color ?>" ><? echo $row["pob"]
 ?> - <? echo $row["manzana"]
 ?> - <? echo $row["sitio"]
 ?> </td>
                <td width="32" bgcolor="<? echo $color ?>" ><div align="right"></div></td>
                <td width="20" bgcolor="<? echo $color ?>"> <div align="center"><a href="javascript:seleccionar(<? echo $codigo ?>,<? echo $dire ?>)">Seleccione</a>
                  </div></td>
                <td width="11" bgcolor="<? echo $color ?>"><div align="center"> 
                  </div>
                <td width="13" bgcolor="<? echo $color ?>"> <div align="center"></div></td>
              </tr>
            </table>
            <table width="41" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="41"> 
                  <? }?>
                </td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    <td background="../menus/BodyRight.jpg"><img src="../menus/BodyRight.jpg" width="13" height="14"></td>
  </tr>
  <tr> 
    <td><IMG height=24 src="../menus/bottomleft.jpg" width=13></td>
    <td background="../menus/bottommiddle.jpg">&nbsp;</td>
    <td><IMG height=24 src="../menus/bottomright.jpg" 
  width=13></td>
  </tr>
</table>
</body>
</html>