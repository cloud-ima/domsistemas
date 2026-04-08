<?php session_start();
$id = session_id();
include("conexion.php");

$user = $_POST['txtLogin'] ?? '';
$pass = $_POST['txtClave'] ?? '';

$link = Conectarse();

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

//********************************************************

$stmtLogin = $link->prepare("SELECT * FROM usuarios WHERE usuario = ?");
if ($stmtLogin) {
    $stmtLogin->bind_param("s", $user);
    $stmtLogin->execute();
    $result = $stmtLogin->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($pass, $row["password"])) {
            $tipx = $row["tipo"];
            
            if ($row["estado"] == 1) {
                session_start();
                $id = session_id();
                /*
                $_SESSION['acceso']=$row["tipo"];
                $_SESSION['user']=$row["usuario"];
                $_SESSION['idnom']=$row["nombre"];
                */
                $stmtSession = $link->prepare("UPDATE usuarios SET session = ? WHERE usuario = ?");
                if ($stmtSession) {
                    $stmtSession->bind_param("ss", $id, $user);
                    $stmtSession->execute();
                    $stmtSession->close();
                }
                header("location: principal.php");
            } elseif ($row["estado"] == 0) {
                header("location: login.php?error=El Usuario ingresado ha sido desabilitado...!!");
            }
        } else {
            header("location: login.php?error=Usuario o Contraseña Incorrecto!!");
        }
    } else {
        header("location: login.php?error=Usuario o Contraseña Incorrecto!!");
    }

    $stmtLogin->close();
}

$link->close();
?>