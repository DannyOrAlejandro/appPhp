<?php 
include('DB.php');
$id=$_REQUEST['id'];
if (!$conex) {
    echo 'Error Al Eliminar La Imagen';
}else{
    $consulta="DELETE FROM imgs where id='$id'";
    mysqli_query($conex,$consulta);
    header('location:panelControl.php');
}
?>