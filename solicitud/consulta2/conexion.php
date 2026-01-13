<?php
function Conectarse()
{ 
   if (!($link=mysql_connect("localhost","root","mariasmarias")))
   {
      echo "Error conectando a la base de datos.";
      exit();
   }
   if (!mysql_select_db("domsistema",$link))
   {
      echo "Error seleccionando la base de datos.";
      exit();
   }
   return $link;
}
$link=Conectarse();
mysql_close($link);
?>