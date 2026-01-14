<?php
/**
 * Script para corregir warnings de PHP 8.3.6
 * - Acceso a $_GET/$_POST/$_REQUEST sin verificación
 * - Variables no inicializadas
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseDir = __DIR__;
$excludeDirs = ['tcpdf', 'impresion', 'fckeditor', 'dompdf', 'fonts'];
$processedFiles = 0;
$modifiedFiles = 0;

echo "=== Corrección de Warnings PHP 8.3.6 ===\n\n";

function shouldExclude($path, $excludeDirs) {
    foreach ($excludeDirs as $exclude) {
        if (strpos($path, DIRECTORY_SEPARATOR . $exclude . DIRECTORY_SEPARATOR) !== false ||
            strpos($path, '/' . $exclude . '/') !== false) {
            return true;
        }
    }
    return false;
}

function fixSuperglobalAccess($content) {
    // Patrones para corregir acceso a superglobales sin verificación
    // $_POST["key"] -> $_POST["key"] ?? ''
    // $_GET["key"] -> $_GET["key"] ?? ''
    // $_REQUEST["key"] -> $_REQUEST["key"] ?? ''
    
    // Solo corregir si no tiene ya ?? o isset
    $patterns = [
        // $_POST["key"] sin ?? después
        '/(\$_POST\s*\[\s*["\'][^"\']+["\']\s*\])(?!\s*\?\?)(?!\s*\))/m' => '$1 ?? \'\'',
        '/(\$_GET\s*\[\s*["\'][^"\']+["\']\s*\])(?!\s*\?\?)(?!\s*\))/m' => '$1 ?? \'\'',
        '/(\$_REQUEST\s*\[\s*["\'][^"\']+["\']\s*\])(?!\s*\?\?)(?!\s*\))/m' => '$1 ?? \'\'',
    ];
    
    foreach ($patterns as $pattern => $replacement) {
        // Solo aplicar si la línea no contiene ya ?? o isset
        $content = preg_replace_callback($pattern, function($matches) {
            return $matches[1] . ' ?? \'\'';
        }, $content);
    }
    
    // Limpiar casos donde se duplicó el ?? ''
    $content = preg_replace("/\?\?\s*''\s*\?\?\s*''/", "?? ''", $content);
    
    return $content;
}

function processDirectory($dir, $excludeDirs, &$processedFiles, &$modifiedFiles) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $filePath = $file->getPathname();
            
            if (shouldExclude($filePath, $excludeDirs)) {
                continue;
            }
            
            // No procesar scripts de migración
            if (strpos(basename($filePath), 'migrate') !== false || 
                strpos(basename($filePath), 'fix_php8') !== false) {
                continue;
            }
            
            $processedFiles++;
            
            $content = file_get_contents($filePath);
            $originalContent = $content;
            
            $content = fixSuperglobalAccess($content);
            
            if ($content !== $originalContent) {
                file_put_contents($filePath, $content);
                $modifiedFiles++;
                echo "✓ Modificado: " . str_replace($dir, '', $filePath) . "\n";
            }
        }
    }
}

processDirectory($baseDir, $excludeDirs, $processedFiles, $modifiedFiles);

echo "\n=== Resumen ===\n";
echo "Archivos procesados: $processedFiles\n";
echo "Archivos modificados: $modifiedFiles\n";
?>
