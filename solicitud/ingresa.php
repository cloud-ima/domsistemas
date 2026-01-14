<?php include("../seguridad.php");
/*if ($tipousuario == 2 or $tipousuario == 3 ) {
 			 echo '<script language="javascript">';
			 echo "alert('Sr. Usuario, no tiene acceso a Este módulo!');";
			 echo "location.href='principal.php';";
			 echo "</script>";
}*/	 ?>
<html>
<head>
<title>MUNIARICA.CL</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../validarut.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="0" topmargin="0">
<table width="457" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="10">&nbsp;</td>
    <td width="429"><div align="right"><a href="../principal.php"><img src="../images/volver.gif" width="50" height="40" border="0"></a></div></td>
    <td width="18"><div align="right"></div></td>
  </tr>
</table>
<table width="100%" height="80%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><div align="center">
        <form name="form1" action="nuevorut.php" method="POST" onSubmit="javascript:return Rut(document.form1.rut.value)">
          R.U.T. : 
          <input name="rut" type="text" maxlength="15" />
          <input type="submit" value="Ingresar" />
        </form>
        
      </div></td>
  </tr>
  <tr>
    <td>
      <?php include("../footer.php");?>
    </td>
  </tr>
</table>
</body>
</html>