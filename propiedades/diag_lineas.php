<?php
include("../conexion.php");

header('Content-Type: text/plain; charset=utf-8');

$rol = $_GET['rol'] ?? '1050-2';
$link = Conectarse();

$rolEsc = mysqli_real_escape_string($link, $rol);
$sql = "SELECT id, rol, n1,n2,n3,n4,a1,a2,a3,a4,l1,l2,l3,l4,d1,d2,d3,d4, otrosnum, obs
        FROM propiedades
        WHERE rol = '$rolEsc'
        ORDER BY id DESC
        LIMIT 30";

$res = mysqli_query($link, $sql);
if (!$res) {
    echo "SQL_ERROR: " . mysqli_error($link) . PHP_EOL;
    exit;
}

echo "ROL consultado: $rol" . PHP_EOL;
echo str_repeat("=", 100) . PHP_EOL;

while ($r = mysqli_fetch_assoc($res)) {
    echo "ID={$r['id']} ROL={$r['rol']}" . PHP_EOL;
    echo "N: [{$r['n1']}] [{$r['n2']}] [{$r['n3']}] [{$r['n4']}]" . PHP_EOL;
    echo "A: [{$r['a1']}] [{$r['a2']}] [{$r['a3']}] [{$r['a4']}]" . PHP_EOL;
    echo "L: [{$r['l1']}] [{$r['l2']}] [{$r['l3']}] [{$r['l4']}]" . PHP_EOL;
    echo "D: [{$r['d1']}] [{$r['d2']}] [{$r['d3']}] [{$r['d4']}]" . PHP_EOL;
    echo "OTROSNUM: [{$r['otrosnum']}]" . PHP_EOL;
    echo "OBS (resumen): [" . mb_substr((string)$r['obs'], 0, 120, 'UTF-8') . "]" . PHP_EOL;
    echo str_repeat("-", 100) . PHP_EOL;
}

