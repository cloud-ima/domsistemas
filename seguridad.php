<?php session_start();
$id = session_id();
include("conexion.php");
$link=conectarse();
$result=mysql_query("select * from usuarios where session like '$id' ", $link);
if ($row = mysql_fetch_array($result)){

   $sesionusuario = $row["unidad"];
   $nombreusuario = $row["nombre"];
   $cuentausuario = $row["usuario"];
   $tipousuario = $row["tipo"];
   
   
					    $link=Conectarse();
						$qry = "SELECT * FROM tipousuarios where id = '$tipousuario'";
						$res = mysql_query($qry);
						$nombredepto = mysql_result($res, 0, "nombre");
   
/*   if ( $tipousuario == 1 ) { $nombredepto = "Administrador"; }
   if ( $tipousuario == 2 ) { $nombredepto = "Director"; }
   if ( $tipousuario == 3 ) { $nombredepto = "Atención de Público"; }
   if ( $tipousuario == 4 ) { $nombredepto = "Digitador"; }*/
      
   $iddepto = $row["unidad"];
   $iddire = $row["direccion"];
  /* if ( $tipousuario == 3 ) 
   {
					    $link=Conectarse();
						$qry = "SELECT * FROM unidad where id = '$iddepto'";
						$res = mysql_query($qry);
						$nombredepto = mysql_result($res, 0, "nombre");
   }*/					
include("topmenu.php");						
}
else{
     session_destroy();
     header("location: ../login.php?error=Falta Iniciar Sessión");
}
?>