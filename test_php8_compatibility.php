<?php
/**
 * Script de verificación de compatibilidad PHP 8.3.6
 * Ejecutar para verificar que el sistema funciona correctamente
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Test de Compatibilidad PHP 8.3.6</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        h2 { margin-top: 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
<h1>🔍 Test de Compatibilidad - Sistema DOM</h1>
";

// 1. Verificar versión de PHP
echo "<div class='section'>";
echo "<h2>1. Versión de PHP</h2>";
$phpVersion = phpversion();
if (version_compare($phpVersion, '8.0.0', '>=')) {
    echo "<p class='success'>✅ PHP $phpVersion - Compatible</p>";
} else {
    echo "<p class='error'>❌ PHP $phpVersion - Se requiere PHP 8.0 o superior</p>";
}
echo "</div>";

// 2. Verificar extensiones requeridas
echo "<div class='section'>";
echo "<h2>2. Extensiones PHP</h2>";
echo "<table>";
echo "<tr><th>Extensión</th><th>Estado</th></tr>";

$extensions = ['mysqli', 'curl', 'mbstring', 'session', 'json'];
foreach ($extensions as $ext) {
    $status = extension_loaded($ext) ? 
        "<span class='success'>✅ Instalada</span>" : 
        "<span class='error'>❌ No instalada</span>";
    echo "<tr><td>$ext</td><td>$status</td></tr>";
}
echo "</table>";
echo "</div>";

// 3. Verificar conexión a base de datos
echo "<div class='section'>";
echo "<h2>3. Conexión a Base de Datos</h2>";

// Incluir el archivo de conexión
$conexionFile = __DIR__ . '/conexion.php';
if (file_exists($conexionFile)) {
    try {
        include_once($conexionFile);
        
        if (isset($conexion) && $conexion instanceof mysqli) {
            if ($conexion->ping()) {
                echo "<p class='success'>✅ Conexión a MySQL exitosa</p>";
                echo "<p>Servidor: " . $conexion->server_info . "</p>";
                echo "<p>Charset: " . $conexion->character_set_name() . "</p>";
                
                // Verificar tablas principales
                echo "<h3>Tablas del sistema:</h3>";
                echo "<table>";
                echo "<tr><th>Tabla</th><th>Registros</th></tr>";
                
                $tables = ['propiedades', 'tipocertificado', 'usuarios', 'parametros', 'zonas'];
                foreach ($tables as $table) {
                    $result = @mysqli_query($conexion, "SELECT COUNT(*) as total FROM $table");
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        echo "<tr><td>$table</td><td>{$row['total']}</td></tr>";
                    } else {
                        echo "<tr><td>$table</td><td><span class='warning'>⚠️ No encontrada</span></td></tr>";
                    }
                }
                echo "</table>";
            } else {
                echo "<p class='error'>❌ Error de conexión: " . $conexion->error . "</p>";
            }
        } else {
            echo "<p class='error'>❌ Variable de conexión no disponible</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='error'>❌ Archivo conexion.php no encontrado</p>";
}
echo "</div>";

// 4. Verificar funciones de compatibilidad
echo "<div class='section'>";
echo "<h2>4. Funciones de Compatibilidad MySQL</h2>";
echo "<table>";
echo "<tr><th>Función</th><th>Estado</th></tr>";

$mysqlFunctions = [
    'mysql_query', 'mysql_fetch_array', 'mysql_fetch_assoc', 
    'mysql_num_rows', 'mysql_result', 'mysql_insert_id',
    'mysql_affected_rows', 'mysql_real_escape_string', 'mysql_close',
    'mysql_error', 'mysql_connect', 'mysql_select_db'
];

foreach ($mysqlFunctions as $func) {
    $status = function_exists($func) ? 
        "<span class='success'>✅ Disponible</span>" : 
        "<span class='error'>❌ No disponible</span>";
    echo "<tr><td>$func()</td><td>$status</td></tr>";
}
echo "</table>";
echo "</div>";

// 5. Verificar archivos principales
echo "<div class='section'>";
echo "<h2>5. Archivos Principales</h2>";
echo "<table>";
echo "<tr><th>Archivo</th><th>Estado</th></tr>";

$mainFiles = [
    'conexion.php', 'login.php', 'principal.php', 'seguridad.php',
    'validacion.php', 'logout.php', 'menu-adm.php', 'menu-normal.php'
];

foreach ($mainFiles as $file) {
    $filePath = __DIR__ . '/' . $file;
    if (file_exists($filePath)) {
        // Verificar sintaxis
        $output = [];
        $returnCode = 0;
        exec("php -l \"$filePath\" 2>&1", $output, $returnCode);
        
        if ($returnCode === 0) {
            echo "<tr><td>$file</td><td><span class='success'>✅ OK</span></td></tr>";
        } else {
            echo "<tr><td>$file</td><td><span class='error'>❌ Error de sintaxis</span></td></tr>";
        }
    } else {
        echo "<tr><td>$file</td><td><span class='error'>❌ No encontrado</span></td></tr>";
    }
}
echo "</table>";
echo "</div>";

// 6. Resumen
echo "<div class='section'>";
echo "<h2>📋 Resumen</h2>";
echo "<p><strong>Sistema:</strong> DOM - Municipalidad de Arica</p>";
echo "<p><strong>PHP:</strong> $phpVersion</p>";
echo "<p><strong>Servidor Web:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'CLI') . "</p>";
echo "<p><strong>Fecha de prueba:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "</div>";

echo "</body></html>";
?>
