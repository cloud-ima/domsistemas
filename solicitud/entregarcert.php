<?php

session_start();
include("../conexion.php");
include("../fechaclasss.php");

// conexion.php aplica error_reporting(0), por eso lo reactivamos aquí.
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR), true)) {
        $msg = "Fatal en entregarcert.php: " . $error['message'] . " en " . $error['file'] . ":" . $error['line'];
        @file_put_contents(__DIR__ . '/entregarcert_debug.log', date('Y-m-d H:i:s') . ' ' . $msg . PHP_EOL, FILE_APPEND);
        echo "<!doctype html><html><head><meta charset='utf-8'><title>Error Entrega</title></head><body style='font-family:Arial,sans-serif;padding:16px;'>";
        echo "<h3 style='margin:0 0 8px 0;color:#a00000;'>Error al entregar certificado</h3>";
        echo "<p style='margin:0 0 14px 0;'>" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p style='margin:0;'><button onclick='window.close()'>Cerrar ventana</button></p>";
        echo "</body></html>";
    }
});

@file_put_contents(
    __DIR__ . '/entregarcert_debug.log',
    date('Y-m-d H:i:s') . ' REQUEST method=' . ($_SERVER['REQUEST_METHOD'] ?? '') .
    ' param=' . (string)($_REQUEST['param'] ?? '') .
    ' codigo=' . (string)($_REQUEST['codigo'] ?? '') . PHP_EOL,
    FILE_APPEND
);

$x_param = $_POST["param"] ?? ($_GET["param"] ?? ($_REQUEST["param"] ?? ''));
$fecha_hoy = date('Y') . "/" . date('m') . "/" . date('d');
$cuentausuario = 'sistema';

// Autenticación liviana local para evitar redirecciones en popup en blanco.
$sid = session_id();
if ($sid !== '') {
    $linkAuth = Conectarse();
    $qAuth = "SELECT usuario FROM usuarios WHERE session LIKE '$sid' LIMIT 1";
    $rAuth = mysql_query($qAuth, $linkAuth);
    if ($rAuth && mysql_num_rows($rAuth) > 0) {
        $cuentaTmp = mysql_result($rAuth, 0, "usuario");
        if (trim((string)$cuentaTmp) !== '') {
            $cuentausuario = $cuentaTmp;
        }
    }
}

function render_page($title, $message, $ok = false) {
    $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $color = $ok ? "#0a7a0a" : "#a00000";
    echo "<!doctype html><html><head><meta charset='utf-8'><title>{$safeTitle}</title></head><body style='font-family:Arial,sans-serif;padding:16px;'>";
    echo "<h3 style='margin:0 0 8px 0;color:{$color};'>{$safeTitle}</h3>";
    echo "<p style='margin:0 0 14px 0;'>{$safeMessage}</p>";
    echo "<p style='margin:0 0 8px 0;'><button onclick='window.close()'>Cerrar ventana</button></p>";
    echo "<p style='margin:0;'><a href='javascript:history.back()'>Volver</a></p>";
    echo "</body></html>";
    exit;
}

function get_varchar_len_from_type($typeDef) {
    if (preg_match('/\((\d+)\)/', (string)$typeDef, $m)) {
        return (int)$m[1];
    }
    return 0;
}

if ($x_param != '2' && $x_param != '3') {
    render_page("Entrega de Certificado", "Operación no válida en entrega de certificado.");
}

if ($x_param == '2') {
    $idx = trim((string)($_POST["codigo"] ?? ''));
    if ($idx === '') {
        render_page("Entrega de Certificado", "Falta el código de solicitud para entregar el certificado.");
    }

    $link = Conectarse();
    $qry = "SELECT * FROM parametros WHERE id = 1";
    $res = mysql_query($qry);
    $periodo = mysql_result($res, 0, "periodo");
    if (trim((string)$periodo) === '') {
        render_page("Entrega de Certificado", "No se encontró el periodo activo para entrega de certificados.");
    }

    $tablaperiodo = "cert" . $periodo;
    $entregadoPor = $cuentausuario ?? '';
    if (trim((string)$entregadoPor) === '') {
        $entregadoPor = 'sistema';
    }
    $entregadoPor = trim((string)$entregadoPor);

    // Ajusta el largo al tamaño real de la columna para evitar "Data too long".
    $maxLenEntregado = 0;
    $colRes = mysql_query("SHOW COLUMNS FROM $tablaperiodo LIKE 'entregado'", $link);
    if ($colRes && mysql_num_rows($colRes) > 0) {
        $typeDef = mysql_result($colRes, 0, "Type");
        $maxLenEntregado = get_varchar_len_from_type($typeDef);
    }
    if ($maxLenEntregado > 0) {
        $entregadoPor = substr($entregadoPor, 0, $maxLenEntregado);
    } else {
        // Fallback conservador para esquemas legacy.
        $entregadoPor = substr($entregadoPor, 0, 20);
    }
    if ($entregadoPor === '') {
        $entregadoPor = 'sis';
    }
    $entregadoPorSql = mysql_real_escape_string($entregadoPor, $link);

    $sql = "UPDATE $tablaperiodo SET estado='4', entregado='$entregadoPorSql', fecha_retiro='$fecha_hoy' WHERE id='$idx'";
    $result2 = mysql_query($sql);
    if (!$result2) {
        $error_sql = mysql_error($link);
        render_page("Entrega de Certificado", "No se pudo entregar el certificado. Error SQL: " . $error_sql);
    }
    mysql_close($link);

    // Refresca la lista en segundo plano y muestra confirmación visible.
    echo "<!doctype html><html><head><meta charset='utf-8'><title>Entrega de Certificado</title></head><body style='font-family:Arial,sans-serif;padding:16px;'>";
    echo "<script>try{if(window.opener && !window.opener.closed){window.opener.location.reload(false);}}catch(e){}</script>";
    echo "<h3 style='margin:0 0 8px 0;color:#0a7a0a;'>Entrega realizada correctamente</h3>";
    echo "<p style='margin:0 0 14px 0;'>La solicitud #".htmlspecialchars($idx, ENT_QUOTES, 'UTF-8')." fue marcada como entregada.</p>";
    echo "<p style='margin:0 0 8px 0;'><button onclick='window.close()'>Cerrar ventana</button></p>";
    echo "<p style='margin:0;'><a href='javascript:history.back()'>Volver</a></p>";
    echo "</body></html>";
    exit;
}

if ($x_param == '3') {
    render_page("Entrega de Certificado", "Modo borrado no implementado en esta pantalla.");
}
