<?php
session_start();
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$user = trim($_POST['txtLogin'] ?? '');
$pass = $_POST['txtClave'] ?? '';

if ($user === '' || $pass === '') {
    header("Location: login.php?error=Debe ingresar usuario y contraseña");
    exit;
}

$link = Conectarse();
$id = session_id();

// Limpiar sesión previa asociada al id actual
$stmt = $link->prepare("SELECT id FROM usuarios WHERE session = ?");
if ($stmt) {
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result2 = $stmt->get_result();
    if ($result2 && $result2->fetch_assoc()) {
        $nada = "";
        $stmtUpdate = $link->prepare("UPDATE usuarios SET session = ? WHERE session = ?");
        if ($stmtUpdate) {
            $stmtUpdate->bind_param("ss", $nada, $id);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        }
    }
    $stmt->close();
}

$stmtLogin = $link->prepare("SELECT * FROM usuarios WHERE usuario = ?");
if (!$stmtLogin) {
    header("Location: login.php?error=Error interno al validar credenciales");
    exit;
}

$stmtLogin->bind_param("s", $user);
$stmtLogin->execute();
$result = $stmtLogin->get_result();
$row = $result ? $result->fetch_assoc() : null;
$stmtLogin->close();

if (!$row) {
    header("Location: login.php?error=Usuario o Contraseña Incorrecto!!");
    exit;
}

$dbPassword = (string)($row["password"] ?? '');
$isHash = password_get_info($dbPassword)['algo'] !== null;
$passwordOk = false;

if ($isHash) {
    $passwordOk = password_verify($pass, $dbPassword);
} else {
    // Compatibilidad con contraseñas antiguas en texto plano.
    $passwordOk = hash_equals($dbPassword, $pass);
    if ($passwordOk) {
        $newHash = password_hash($pass, PASSWORD_DEFAULT);
        $stmtMigrate = $link->prepare("UPDATE usuarios SET password = ? WHERE usuario = ?");
        if ($stmtMigrate) {
            $stmtMigrate->bind_param("ss", $newHash, $user);
            $stmtMigrate->execute();
            $stmtMigrate->close();
        }
    }
}

if (!$passwordOk) {
    header("Location: login.php?error=Usuario o Contraseña Incorrecto!!");
    exit;
}

if ((int)$row["estado"] !== 1) {
    header("Location: login.php?error=El Usuario ingresado ha sido desabilitado...!!");
    exit;
}

session_regenerate_id(true);
$id = session_id();

$stmtSession = $link->prepare("UPDATE usuarios SET session = ? WHERE usuario = ?");
if ($stmtSession) {
    $stmtSession->bind_param("ss", $id, $user);
    $stmtSession->execute();
    $stmtSession->close();
}

$link->close();
header("Location: principal.php");
exit;
?>