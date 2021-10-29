<?php 
//PASO 1
//HACEMOS LA CONEXION CON EL SERVIDOR O LA BASE DE DATOS
//mysqli_connetc("nombre_del_server","nombre_de_usuario","contraseña";"nombre_base_de_datos");
$ID=$_SESSION['IDuser'];
if (empty($_SESSION['active'])){header('location:index.php');}
$conex=mysqli_connect('localhost','root','','danny');
if (!$conex) {
    //si no se pudo hacer la coneccion nos manda este mensaje con el error
    echo "No Ha Sido Posible La Conexion Con El Servidor".mysqli_error($conex);
}else {
    //PASO 2 hacemos la consulta obtenemos los datos
    //$consulta="SELECT * FROM usuarios";
    $consulta="SELECT * FROM usuarios WHERE ID='$ID'";
    //mysquli_query("conexion_base_de_datos","consulta");
    $resultado=mysqli_query($conex,$consulta);
    //si se obtiene los datos de forma correcta
    if ($resultado) {
        //el resulta lo ponemos en un array para poder mostrar los datos
        //y se va arepetir hasta que no hayan mas datos que poner en el array y los mostrara
        while($row=$resultado->fetch_array()){
            $ID=$row['ID'];
            $name_user=$row['user_name'];
            $password=$row['password'];
            $perfil_img=$row['perfil_img'];
            $email=$row['email'];
            $tipoImg=$row['tipoDeImg'];
            //una ve tango los datos de un usuario cierro la parte php y inicio la html para mostrarlos
            ?>   
            <div class="card" style="width: 25rem; margin:20px;display:inline-block;">
            <?php if ($tipoImg!=NULL && $tipoImg!='NULL' && $tipoImg!='') {
                include('leerImg.php');
            }else{ ?>
                <img src="<?php echo $perfil_img ?>" alt="IMAGEN" class="card-img-top">
            <?php } ?>
                <div class="card-body">
                    <div class="card-text">
                        <h3>Usuario con ID: <?php echo $ID?></h3>
                        <h5>Nombre de usuario: <?php echo $name_user?></h5>
                        <h5>Tipo de Imagen De Perfil: <?php echo $tipoImg?></h5>
                        <h5>Correo Electronico: <?php echo $email ?></h5>
                        <h5>Contraseña: <?php echo $password?></h5></div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
?>