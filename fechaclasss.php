<?
function  cambiaf_a_normal ( $fecha ){
ereg (  "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})" ,  $fecha ,  $mifecha );
$fechafinal = $mifecha [ 3 ]. "/" . $mifecha [ 2 ]. "/" . $mifecha [ 1 ];
return  $fechafinal ;
}

function  cambiaf_a_mysql ( $fecha ){
ereg (  "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})" ,  $fecha ,  $mifecha );
$fechafinal = $mifecha [ 3 ]. "-" . $mifecha [ 2 ]. "-" . $mifecha [ 1 ];
return  $fechafinal;
}
?>