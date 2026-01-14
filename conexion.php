<?php
error_reporting(0);

// ============================================================
// CONFIGURACIÓN DE BASE DE DATOS - PHP 8.3.6 / Apache 2.4.58
// ============================================================
// Modifica estos valores según tu servidor Ubuntu
// ============================================================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // Cambiar por tu usuario MySQL
define('DB_PASS', 'g360Qu34hAd8');        // Cambiar por tu contraseña MySQL
define('DB_NAME', 'domsistemas'); // Nombre de la base de datos

// Conexión global mysqli
$conexion = null;

function Conectarse()
{ 
    global $conexion;
    
    // Si ya existe una conexión activa, retornarla
    if ($conexion !== null && $conexion instanceof mysqli && $conexion->ping()) {
        return $conexion;
    }
    
    // Crear nueva conexión mysqli
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conexion->connect_error) {
        die("Error conectando a la base de datos: " . $conexion->connect_error);
    }
    
    // Establecer charset UTF-8
    $conexion->set_charset("utf8mb4");
    
    return $conexion;
}

// Funciones de compatibilidad para migración gradual (emular funciones mysql_* antiguas)
function mysql_query($query, $link = null) {
    global $conexion;
    $conn = $link ?? $conexion ?? Conectarse();
    return mysqli_query($conn, $query);
}

function mysql_fetch_array($result, $type = MYSQLI_BOTH) {
    if (!$result) return null;
    return mysqli_fetch_array($result, $type);
}

function mysql_fetch_assoc($result) {
    if (!$result) return null;
    return mysqli_fetch_assoc($result);
}

function mysql_num_rows($result) {
    if (!$result) return 0;
    return mysqli_num_rows($result);
}

function mysql_result($result, $row, $field = 0) {
    if (!$result) return null;
    mysqli_data_seek($result, $row);
    $row_data = mysqli_fetch_array($result);
    return $row_data[$field] ?? null;
}

function mysql_insert_id($link = null) {
    global $conexion;
    $conn = $link ?? $conexion ?? Conectarse();
    return mysqli_insert_id($conn);
}

function mysql_affected_rows($link = null) {
    global $conexion;
    $conn = $link ?? $conexion ?? Conectarse();
    return mysqli_affected_rows($conn);
}

function mysql_real_escape_string($string, $link = null) {
    global $conexion;
    $conn = $link ?? $conexion ?? Conectarse();
    return mysqli_real_escape_string($conn, $string);
}

function mysql_close($link = null) {
    global $conexion;
    if ($link !== null && $link instanceof mysqli) {
        return mysqli_close($link);
    }
    // No cerrar la conexión global automáticamente
    return true;
}

function mysql_error($link = null) {
    global $conexion;
    $conn = $link ?? $conexion;
    if ($conn instanceof mysqli) {
        return mysqli_error($conn);
    }
    return '';
}

function mysql_connect($server, $username, $password) {
    global $conexion;
    $conexion = new mysqli($server, $username, $password);
    if ($conexion->connect_error) {
        return false;
    }
    return $conexion;
}

function mysql_select_db($database, $link = null) {
    global $conexion;
    $conn = $link ?? $conexion;
    if ($conn instanceof mysqli) {
        return mysqli_select_db($conn, $database);
    }
    return false;
}

// Inicializar conexión
$link = Conectarse();
?>