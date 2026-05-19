<?php    include("../conexion.php");
include("../debug.php");

// Debug: mostrar datos recibidos
debug_log("=== MANTENEDOR: usuarios ===");
debug_request();
   
   if ( isset($_GET["param"]) ) {
      $x_param = $_GET["param"] ?? ''; }
	  
   if ( isset($_POST["param"]) ) {
      $x_param = $_POST["param"] ?? ''; }
   
if ( $x_param == 1 ){
			 $nomx = trim($_POST["nombre"] ?? '');
			 $ctax = trim($_POST["cuenta"] ?? '');
			 $pasx = $_POST["pass"] ?? '';
			 $tipx = trim($_POST["tipo"] ?? '');

			 if ($ctax === '' || $nomx === '' || $tipx === '' || $pasx === '') {
			 	echo '<script language="javascript">';
			 	echo "alert('Debe completar cuenta, nombre, tipo y password.');";
			 	echo "history.back();";
			 	echo "</script>";
			 	exit;
			 }
			 
			 $link=conectarse();
			 $passHash = password_hash($pasx, PASSWORD_DEFAULT);
			 $sql = "INSERT INTO usuarios (nombre,usuario,tipo,password,unidad,estado) VALUES (?,?,?,?,?,?)";
			 $stmt = $link->prepare($sql);
			 $unidad = '1';
			 $estado = '1';
			 if ($stmt) {
			 	$stmt->bind_param("ssssss", $nomx, $ctax, $tipx, $passHash, $unidad, $estado);
			 	$stmt->execute();
			 	$stmt->close();
			 }
			 mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Agregado Correctamente!');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";
			 echo "</script>";
}

if ( $x_param == 2 ){
			 $nomx = trim($_POST["nombre"] ?? '');
			 $ctax = trim($_POST["cuenta"] ?? '');
			 $pasx = $_POST["pass"] ?? '';
			 $tipx = trim($_POST["tipo"] ?? '');
			 $idx  = trim($_POST["codigo"] ?? '');

			 if ($ctax === '' || $nomx === '' || $tipx === '' || $idx === '') {
			 	echo '<script language="javascript">';
			 	echo "alert('Datos incompletos para actualizar usuario.');";
			 	echo "history.back();";
			 	echo "</script>";
			 	exit;
			 }
		 
		 	 $link=conectarse();
    	     if ($pasx !== '') {
    	     	$passHash = password_hash($pasx, PASSWORD_DEFAULT);
    	     	$sql= "UPDATE usuarios SET nombre=?, usuario=?, password=?, tipo=? WHERE id=?";
    	     	$stmt = $link->prepare($sql);
    	     	if ($stmt) {
    	     		$stmt->bind_param("ssssi", $nomx, $ctax, $passHash, $tipx, $idx);
    	     		$stmt->execute();
    	     		$stmt->close();
    	     	}
    	     } else {
    	     	$sql= "UPDATE usuarios SET nombre=?, usuario=?, tipo=? WHERE id=?";
    	     	$stmt = $link->prepare($sql);
    	     	if ($stmt) {
    	     		$stmt->bind_param("sssi", $nomx, $ctax, $tipx, $idx);
    	     		$stmt->execute();
    	     		$stmt->close();
    	     	}
    	     }
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Actualizado Correctamente');";
			 echo "opener.window.location.reload( false );";
	         echo "window.close();";
 		     echo "</script>";
			 /* echo "<script>window.close();</script>";
			 echo "location.href='p_tipodecreto.php';";*/
}

if ( $x_param == 3 ){
			 $idx  = $_GET["id"] ?? '';
             $link=conectarse();
             $sql="DELETE FROM usuarios where id = '$idx'";
             $result = mysql_query($sql);
  		     mysql_close($link);
			 echo '<script language="javascript">';
			 echo "alert('Registro Borrado');";
			 echo "location.href='index.php';";
			 echo "opener.window.location.reload( false );";
	         //echo "window.close();";
 		     echo "</script>";
}
?>
