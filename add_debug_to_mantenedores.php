<?php
/**
 * Script para agregar debugging a todos los mantenedores
 */

$baseDir = __DIR__;
$mantenedores = [
    'destino/mantenedor.php',
    'zonas/mantenedor.php', 
    'parametros/mantenedor.php',
    'pob/mantenedor.php',
    'tipocertificado/mantenedor.php',
    'tipopropiedades/mantenedor.php',
    'usos/mantenedor.php',
    'usuarios/mantenedor.php',
    'directores/mantenedor.php',
];

echo "=== Agregando debugging a mantenedores ===\n\n";

foreach ($mantenedores as $file) {
    $filePath = $baseDir . '/' . $file;
    
    if (!file_exists($filePath)) {
        echo "❌ No existe: $file\n";
        continue;
    }
    
    $content = file_get_contents($filePath);
    
    // Verificar si ya tiene debug incluido
    if (strpos($content, 'debug.php') !== false) {
        echo "⏭️ Ya tiene debug: $file\n";
        continue;
    }
    
    // Agregar include de debug después de conexion.php
    $content = preg_replace(
        '/include\s*\(\s*["\']\.\.\/conexion\.php["\']\s*\)\s*;/',
        'include("../conexion.php");' . "\n" . 'include("../debug.php");' . "\n\n" . 
        '// Debug: mostrar datos recibidos' . "\n" .
        'debug_log("=== MANTENEDOR: ' . basename(dirname($file)) . ' ===");' . "\n" .
        'debug_request();',
        $content
    );
    
    file_put_contents($filePath, $content);
    echo "✅ Modificado: $file\n";
}

echo "\n=== Completado ===\n";
?>
