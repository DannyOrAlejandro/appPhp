<?php
date_default_timezone_set('America/Bogota');
function fecha(){
    $meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio",
    "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    return date('d')." de ".$meses[date('n')]." de ".date('Y');
}
//si en year Y la pongo minuscula solo me dara los dos ultimos digitos del año
?>