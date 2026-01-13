<?php
error_reporting(0);
function Conectarse()
{ 
   if (!($link=mysql_connect("localhost","imaarica_root","E6@5O=j(iJoh")))
   {
      echo "Error conectando a la base de datos.";
      exit();
   }
   if (!mysql_select_db("imaarica_domsistemas",$link))
   {
      echo "Error seleccionando la base de datos.";
      exit();
   }
   return $link;
}
$link=Conectarse();
mysql_close($link);
?>