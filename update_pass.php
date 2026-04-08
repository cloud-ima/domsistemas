<?php
session_start();
$id = session_id();
include("conexion.php");

$passold = $_POST['passold'] ?? '';
$pass1 = $_POST['pass1'] ?? '';
$pass2 = $_POST['pass2'] ?? '';

if (empty($passold) || empty($pass1) || empty($pass2)) {
    echo '<script language="javascript">';
    echo 'alert("Todos los campos son obligatorios");';
    echo 'history.back();';
    echo '</script>';
    exit;
}

if ($pass1 !== $pass2) {
    echo '<script language="javascript">';
    echo 'alert("Las contraseñas nuevas no coinciden");';
    echo 'history.back();';
    echo '</script>';
    exit;
}

$link = Conectarse();

$stmt = $link->prepare("SELECT * FROM usuarios WHERE session = ?");
if ($stmt) {
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if (password_verify($passold, $row["password"])) {
            $usuario = $row["usuario"];
            $newPasswordHash = password_hash($pass1, PASSWORD_DEFAULT);
            
            $stmtUpdate = $link->prepare("UPDATE usuarios SET password = ? WHERE usuario = ?");
            if ($stmtUpdate) {
                $stmtUpdate->bind_param("ss", $newPasswordHash, $usuario);
                
                if ($stmtUpdate->execute()) {
                    echo '<script language="javascript">';
                    echo 'alert("Contraseña actualizada correctamente");';
                    echo 'location.href="principal.php";';
                    echo '</script>';
                } else {
                    echo '<script language="javascript">';
                    echo 'alert("Error al actualizar la contraseña");';
                    echo 'history.back();';
                    echo '</script>';
                }
                $stmtUpdate->close();
            }
        } else {
            echo '<script language="javascript">';
            echo 'alert("La contraseña anterior es incorrecta");';
            echo 'history.back();';
            echo '</script>';
        }
    } else {
        echo '<script language="javascript">';
        echo 'alert("Sesión no válida. Por favor inicie sesión nuevamente");';
        echo 'location.href="login.php";';
        echo '</script>';
    }
    $stmt->close();
} else {
    echo '<script language="javascript">';
    echo 'alert("Error en la consulta a la base de datos");';
    echo 'history.back();';
    echo '</script>';
}

$link->close();
?>
