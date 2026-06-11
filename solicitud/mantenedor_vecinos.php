<?php
include("../conexion.php");

function salida_error($mensaje, $destino = 'ingresa.php')
{
    $mensajeSeguro = htmlspecialchars((string)$mensaje, ENT_QUOTES, 'UTF-8');
    $destinoSeguro = htmlspecialchars((string)$destino, ENT_QUOTES, 'UTF-8');
    echo "<!doctype html><html><head><meta charset='utf-8'><title>Error</title></head><body>";
    echo "<p>$mensajeSeguro</p>";
    echo "<p><a href='$destinoSeguro'>Volver</a></p>";
    echo "</body></html>";
    exit;
}

function redirigir($destino)
{
    if (!headers_sent()) {
        header("Location: $destino");
        exit;
    }
    $destinoSeguro = htmlspecialchars((string)$destino, ENT_QUOTES, 'UTF-8');
    echo "<!doctype html><html><head><meta charset='utf-8'><meta http-equiv='refresh' content='0;url=$destinoSeguro'></head><body>";
    echo "<a href='$destinoSeguro'>Continuar</a>";
    echo "</body></html>";
    exit;
}

$x_param = '';
if (isset($_GET["param"])) {
    $x_param = $_GET["param"] ?? '';
}

if (isset($_POST["param"])) {
    $x_param = $_POST["param"] ?? '';
}

$nomx = strtoupper(trim((string)($_POST["nombres"] ?? '')));
$apex = strtoupper(trim((string)($_POST["apellidos"] ?? '')));
$telx = trim((string)($_POST["telefonos"] ?? ''));
$dirx = strtoupper(trim((string)($_POST["direc"] ?? '')));
$corx = strtoupper(trim((string)($_POST["correo"] ?? '')));
$rutx = trim((string)($_POST["rut"] ?? ''));

if ($rutx === '' || ($x_param != 1 && $x_param != 2)) {
    redirigir('ingresa.php');
}
   
if ($x_param == 1) {
    $link = conectarse();
    $rutxEsc = mysql_real_escape_string($rutx, $link);
    $nomxEsc = mysql_real_escape_string($nomx, $link);
    $apexEsc = mysql_real_escape_string($apex, $link);
    $telxEsc = mysql_real_escape_string($telx, $link);
    $dirxEsc = mysql_real_escape_string($dirx, $link);
    $corxEsc = mysql_real_escape_string($corx, $link);
    $sql = "INSERT INTO rut (rut,nombre,apellidos,telefonos,direccion,correo) VALUES ('$rutxEsc','$nomxEsc','$apexEsc','$telxEsc','$dirxEsc','$corxEsc')";
    $result2 = mysql_query($sql);
    if (!$result2) {
        $err = mysql_error($link);
        mysql_close($link);
        salida_error("No se pudo guardar el contribuyente. Error: $err", 'ingresa.php');
    }
    mysql_close($link);
    redirigir('solicitud.php?rut=' . rawurlencode($rutx));
}

if ($x_param == 2) {
    $link = conectarse();
    $rutxEsc = mysql_real_escape_string($rutx, $link);
    $nomxEsc = mysql_real_escape_string($nomx, $link);
    $apexEsc = mysql_real_escape_string($apex, $link);
    $telxEsc = mysql_real_escape_string($telx, $link);
    $dirxEsc = mysql_real_escape_string($dirx, $link);
    $corxEsc = mysql_real_escape_string($corx, $link);
    $sql = "UPDATE rut SET nombre='$nomxEsc',apellidos='$apexEsc',telefonos='$telxEsc',direccion='$dirxEsc',correo='$corxEsc' WHERE rut='$rutxEsc'";
    $result2 = mysql_query($sql);
    if (!$result2) {
        $err = mysql_error($link);
        mysql_close($link);
        salida_error("No se pudo actualizar el contribuyente. Error: $err", 'ingresa.php');
    }
    mysql_close($link);
    redirigir('solicitud.php?rut=' . rawurlencode($rutx));
}

if ( $x_param == 3 ){
		    /* $idx  = $_GET["id"] ?? '';
             $link=conectarse();
             $sql="DELETE FROM noticias where id = '$idx'";
             $result = mysql_query($sql);
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Borrado');";
			 echo "location.href='list_publicaciones.php';";
 		     echo "</script>";		*/
}
?>