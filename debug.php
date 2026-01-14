<?php
/**
 * Sistema de Debug para DOM
 * Muestra información de debugging en consola del navegador
 */

// Activar errores de PHP
error_reporting(E_ALL);
ini_set('display_errors', 0); // No mostrar en pantalla, solo en log

// Archivo de log
define('DEBUG_LOG_FILE', __DIR__ . '/debug.log');
define('DEBUG_ENABLED', true);

/**
 * Escribe mensaje de debug en consola JavaScript y archivo log
 */
function debug_log($message, $data = null) {
    if (!DEBUG_ENABLED) return;
    
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message";
    
    if ($data !== null) {
        $logMessage .= " | Data: " . print_r($data, true);
    }
    
    // Escribir en archivo log
    file_put_contents(DEBUG_LOG_FILE, $logMessage . "\n", FILE_APPEND);
    
    // Mostrar en consola JavaScript
    $jsMessage = addslashes($message);
    $jsData = $data !== null ? json_encode($data, JSON_UNESCAPED_UNICODE) : 'null';
    
    echo "<script>console.log('%c[DEBUG] $jsMessage', 'color: #00aa00; font-weight: bold;', $jsData);</script>\n";
}

/**
 * Debug para queries SQL
 */
function debug_query($sql, $result = null) {
    if (!DEBUG_ENABLED) return;
    
    $timestamp = date('Y-m-d H:i:s');
    $status = $result ? 'OK' : 'FAILED';
    
    // Log en archivo
    $logMessage = "[$timestamp] SQL [$status]: $sql";
    file_put_contents(DEBUG_LOG_FILE, $logMessage . "\n", FILE_APPEND);
    
    // Mostrar en consola
    $jsSql = addslashes($sql);
    $color = $result ? '#0066cc' : '#cc0000';
    echo "<script>console.log('%c[SQL $status] $jsSql', 'color: $color;');</script>\n";
    
    if (!$result) {
        global $conexion;
        $error = mysqli_error($conexion);
        if ($error) {
            echo "<script>console.error('[SQL ERROR] " . addslashes($error) . "');</script>\n";
            file_put_contents(DEBUG_LOG_FILE, "[$timestamp] SQL ERROR: $error\n", FILE_APPEND);
        }
    }
}

/**
 * Debug para variables POST/GET
 */
function debug_request() {
    if (!DEBUG_ENABLED) return;
    
    debug_log('$_POST', $_POST);
    debug_log('$_GET', $_GET);
}

/**
 * Limpiar archivo de log
 */
function debug_clear_log() {
    file_put_contents(DEBUG_LOG_FILE, "=== Log limpiado: " . date('Y-m-d H:i:s') . " ===\n");
}
?>
