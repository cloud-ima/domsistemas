<?php
/**
 * Script de migración a PHP 8.3.6
 * Corrige short open tags (<? a <?php) en todos los archivos PHP
 * 
 * USO: php migrate_php8.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseDir = __DIR__;
$excludeDirs = ['tcpdf', 'impresion', 'fckeditor', 'dompdf', 'fonts'];
$processedFiles = 0;
$modifiedFiles = 0;

echo "=== Migración a PHP 8.3.6 ===\n\n";

function shouldExclude($path, $excludeDirs) {
    foreach ($excludeDirs as $exclude) {
        if (strpos($path, DIRECTORY_SEPARATOR . $exclude . DIRECTORY_SEPARATOR) !== false ||
            strpos($path, '/' . $exclude . '/') !== false) {
            return true;
        }
    }
    return false;
}

function fixShortOpenTags($content) {
    // Reemplazar <? seguido de espacio o salto de línea (pero no <?php ni <?=)
    $patterns = [
        '/<\?\s(?!php|=)/i' => '<?php ',
        '/<\?\n(?!php|=)/i' => "<?php\n",
        '/<\?\r\n(?!php|=)/i' => "<?php\r\n",
        '/<\?\t(?!php|=)/i' => "<?php\t",
        '/<\?}/' => '<?php }',  // Caso especial <?}
        '/<\?\$/' => '<?php $', // Caso especial <?$variable
        '/<\?if/' => '<?php if', // Caso especial <?if
        '/<\?echo/' => '<?php echo', // Caso especial <?echo
        '/<\?include/' => '<?php include', // Caso especial <?include
    ];
    
    foreach ($patterns as $pattern => $replacement) {
        $content = preg_replace($pattern, $replacement, $content);
    }
    
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
            
            // Excluir directorios de librerías externas
            if (shouldExclude($filePath, $excludeDirs)) {
                continue;
            }
            
            // No procesar este script
            if (basename($filePath) === 'migrate_php8.php') {
                continue;
            }
            
            $processedFiles++;
            
            $content = file_get_contents($filePath);
            $originalContent = $content;
            
            // Corregir short open tags
            $content = fixShortOpenTags($content);
            
            if ($content !== $originalContent) {
                file_put_contents($filePath, $content);
                $modifiedFiles++;
                echo "✓ Modificado: " . str_replace($dir, '', $filePath) . "\n";
            }
        }
    }
}

// Ejecutar migración
processDirectory($baseDir, $excludeDirs, $processedFiles, $modifiedFiles);

echo "\n=== Resumen ===\n";
echo "Archivos procesados: $processedFiles\n";
echo "Archivos modificados: $modifiedFiles\n";
echo "\n¡Migración completada!\n";
echo "\nNOTA: Las funciones mysql_* ahora están emuladas en conexion.php\n";
echo "El sistema debería ser compatible con PHP 8.3.6\n";
?>
