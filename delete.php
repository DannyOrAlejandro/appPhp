<?php 
$conex=mysqli_connect('bjokk9p64b3uajxl6sg9-mysql.services.clever-cloud.com','uzukxkzcotihhxn5','gIyVoHkRyLUmdrzzQ3st','bjokk9p64b3uajxl6sg9');
$id=$_REQUEST['id'];
if (!$conex) {
    echo 'Error Al Eliminar La Imagen';
}else{
    $consulta="DELETE FROM imgs where id='$id'";
    mysqli_query($conex,$consulta);
    header('location:panelControl.php');
}
?>