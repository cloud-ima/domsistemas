<?php

include("../conexion.php");
include("../debug.php");

// Inicializar variables - ZONAS usa: ide, info, file
$parz = 1;
$idez = "";
$infoz = "";
$filez = "";
$idestado = "Estado(Ingresando Nuevo Registro)";

$x_flag = $_GET["flag"] ?? "";
$x_param = $_GET["param"] ?? "";

debug_log("=== FORMULARIO ZONAS ===");
debug_log("flag", $x_flag);
debug_log("param", $x_param);

// Si viene param=1 desde el index o no hay flag, es nuevo registro
if ( $x_param == 1 || $x_flag == "" || $x_flag == 0 ) {
   $idestado = "Estado(Ingresando Nuevo Registro)";
   $parz = 1;
   $idez = "";
   $infoz = "";
   $filez = "";
   debug_log("Modo: NUEVO REGISTRO, parz=", $parz);
}

if ( $x_flag == 1 ) {
    $idestado = "Estado(Modificacion del Registro)";
    $link=conectarse();
    $idez=$_GET["id"] ?? "";
    $ssql = "select * from zonas where id ='$idez'";
    debug_log("SQL edicion", $ssql);
    $rs = mysql_query($ssql,$link);
    $num_registros = mysql_num_rows($rs);
    debug_log("Registros encontrados", $num_registros);
    if ($num_registros == 0){
        header("location: index.php");
    }else{
        while ($row = mysql_fetch_array($rs)){
            $idez = $row["id"];
            $infoz = $row["info"];
            $filez = $row["file"] ?? "";
            $parz = 2;
            debug_log("Datos cargados", ["id"=>$idez, "info"=>$infoz, "file"=>$filez]);
        }
    }
    mysql_close($link);
    debug_log("Modo: EDICION, parz=", $parz);
}

$fechaactualed = date("d")."/".date("n")."/".date("Y");
?>
<html>
<head>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form action="mantenedor.php" method="POST" enctype="multipart/form-data">
  <br>
  <br>
  <table width="467" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="467" height="200" valign="top">
        <table width="461" border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td width="461" align="center"><div align="left"><strong>Zonas</strong></div></td>
          </tr>
          <tr>
            <td align="center"><div align="left"><?php echo $idestado ?></div></td>
          </tr>
        </table>
        <table width="459" border="0" cellpadding="0" cellspacing="0" bordercolor="#cccccc">
          <tr>
            <td width="616" height="68">
              <table width="454" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="146" height="26" bgcolor="#efefef" class="estilo_titulo">Codigo Zona</td>
                  <td width="294" bgcolor="#efefef">
                    <input name="ide" type="text" value="<?php echo $idez ?>" size="20" maxlength="50">
                  </td>
                </tr>
                <tr>
                  <td width="146" height="26" bgcolor="#efefef" class="estilo_titulo">Descripcion</td>
                  <td width="294" bgcolor="#efefef">
                    <input name="info" type="text" value="<?php echo $infoz ?>" size="50" maxlength="100">
                  </td>
                </tr>
                <tr>
                  <td width="146" height="26" bgcolor="#efefef" class="estilo_titulo">Archivo</td>
                  <td width="294" bgcolor="#efefef">
                    <input name="file" type="text" value="<?php echo $filez ?>" size="50" maxlength="100">
                  </td>
                </tr>
                <tr>
                  <td height="19" class="estilo_titulo">
                    <input name="param" type="hidden" value="<?php echo $parz ?>">
                  </td>
                  <td bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table width="454" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="39" class="estilo_titulo">
              <table width="178" border="0" align="left">
                <tr>
                  <td width="73" valign="top">
                    <div align="center">
                      <input name="enviar" type="submit" id="enviar" value="Grabar">
                    </div>
                  </td>
                  <td width="95" valign="top">
                    <input type="reset" name="Submit3" value="Cancelar" onClick="cerrar()">
                    <script language="javascript">
                      function cerrar() {
                        opener.window.location.reload(false);
                        window.close();
                      }
                    </script>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
