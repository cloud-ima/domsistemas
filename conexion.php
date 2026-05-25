<?php
error_reporting(0);

// ============================================================
// CONFIGURACIÓN DE BASE DE DATOS - PHP 8.3.6 / Apache 2.4.58
// ============================================================
// Modifica estos valores según tu servidor Ubuntu
// ============================================================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // Cambiar por tu usuario MySQL
//define('DB_PASS', 'IuhLFjxE6701iR');        // Cambiar por tu contraseña MySQL
define('DB_PASS', 'g360Qu34hAd8');        // Cambiar por tu contraseña MySQL
define('DB_NAME', 'domsistemas'); // Nombre de la base de datos
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4'); // Default moderno; usar DB_CHARSET=latin1 solo si la BD realmente lo requiere

// Conexión global mysqli
$conexion = null;

function Conectarse()
{
    global $conexion;

    // Si ya existe una conexión global y está activa, retornarla.
    // En este proyecto se llama mysql_close() muchas veces sobre el mismo handle.
    // Si quedó cerrada, se recrea para evitar errores al seguir renderizando vistas.
    if ($conexion !== null && $conexion instanceof mysqli) {
        try {
            if (@$conexion->ping()) {
                return $conexion;
            }
        } catch (Throwable $e) {
            // Se recrea la conexión más abajo.
        }
    }

    // Crear nueva conexión mysqli
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conexion->connect_error) {
        die("Error conectando a la base de datos: " . $conexion->connect_error);
    }

    // Establecer charset configurable para compatibilidad (utf8mb4 recomendado)
    $conexion->set_charset(DB_CHARSET);

    return $conexion;
}

// Funciones de compatibilidad para migración gradual (emular funciones mysql_* antiguas)
function mysql_query($query, $link = null)
{
    global $conexion;
    $conn = $link ?? $conexion ?? Conectarse();
    return mysqli_query($conn, $query);
}

function mysql_fetch_array($result, $type = MYSQLI_BOTH)
{
    if (!$result) return null;
    return mysqli_fetch_array($result, $type);
}

function mysql_fetch_assoc($result)
{
    if (!$result) return null;
    return mysqli_fetch_assoc($result);
}

function mysql_num_rows($result)
{
    if (!$result) return 0;
    return mysqli_num_rows($result);
}

function mysql_result($result, $row, $field = 0)
{
    if (!$result) return null;
    mysqli_data_seek($result, $row);
    $row_data = mysqli_fetch_array($result);
    return $row_data[$field] ?? null;
}

function mysql_insert_id($link = null)
{
    global $conexion;
    $conn = $link ?? $conexion ?? Conectarse();
    return mysqli_insert_id($conn);
}

function mysql_affected_rows($link = null)
{
    global $conexion;
    $conn = $link ?? $conexion ?? Conectarse();
    return mysqli_affected_rows($conn);
}

function mysql_real_escape_string($string, $link = null)
{
    global $conexion;
    $conn = $link ?? $conexion ?? Conectarse();
    return mysqli_real_escape_string($conn, $string);
}

function mysql_close($link = null)
{
    global $conexion;

    // Compatibilidad legacy: no cerrar la conexión global compartida.
    // Muchas pantallas cierran $link en medio del render y luego vuelven a consultar.
    if ($link === null || $link === $conexion) {
        return true;
    }

    if ($link !== null && $link instanceof mysqli) {
        return mysqli_close($link);
    }

    return true;
}

function mysql_error($link = null)
{
    global $conexion;
    $conn = $link ?? $conexion;
    if ($conn instanceof mysqli) {
        return mysqli_error($conn);
    }
    return '';
}

function mysql_connect($server, $username, $password)
{
    global $conexion;
    $conexion = new mysqli($server, $username, $password);
    if ($conexion->connect_error) {
        return false;
    }
    return $conexion;
}

function mysql_select_db($database, $link = null)
{
    global $conexion;
    $conn = $link ?? $conexion;
    if ($conn instanceof mysqli) {
        return mysqli_select_db($conn, $database);
    }
    return false;
}

// Inicializar conexión
$link = Conectarse();
