<?php
//LAS LIENAS 6 7 Y 8 iriab en el header.php para tds las paginas que tenga el sistema y hacerlas privadas
//inicioaliso las seciones las cuales si se inisio se sesion ya deben estar cradas,
//si no estan creadas no puedo acceder al sistema, entoces validamos que exista una seccion para poder entrar al sistema
//si no existe no se puede entrar nos redirecciona al formulario de inicio de secion
session_start();
if(empty($_SESSION['active'])){header('location:index.php');}
$alert='';
include('DB.php');
if(!$conex){
    echo 'Error en la conexion con la base de datos';
}else{
/*if (isset($_REQUEST['file'])) {  //isset($_REQUEST['file']) ES SI SE PULSO EL BOTON CON EL NOMBRE file
    if (isset($_FILES['img']['name'])) {
        //para no tener problemas debo de validar el tipo de archivo que es para evitar posibles hackeosno lo hare porque
        //es mmi server locar pero se hace asi:
        $tipoArchivo=$_FILES['img']['type'];
        /*$permitidos=array("..","..");  ARRAY CON LOS TIPO DE ARCHIVOS PERMITIDOS
        if(in_array($tipoArchivo,$permitidos)){ PARAMETRO 1 DE LA FUNCION IN_ARRAY EL VALOR QUE KEREMOS SABER SI ESTA EN EL ARRAY PARAMETRO 2 ARRAY EN EL QUE SE BUSCARA SI ESTA O NO EL PARAMETRO 1
            die("ARCHIVO NO PERMITIDO");   SI EL ARCHIVO NO ESTA PERMITIDO MATAMOS TODO PROSECO Y MANDAMOS UN MESAJE
        }
        $nombreArchivo=$_FILES['img']['name']; //NOMBRE ARCHIVO
        $tamañoArchivo=$_FILES['img']['size']; //TAMAÑO DEL ARCHIVO
        $imagenSubida=fopen($_FILES['img']['tmp_name'],'r'); //LEEMOS EL ARCHIVO LA 'r' DE SEGUNDO PARAMETRO ES LECTIRA LEER $_FILES ES UNA VARIABLE MEGAGLOBAL DONDE SE GUARDAN LOS ARCHOS DE FORMA TEMPORAL EL PRIMER [NAME DEL CAMPO IMPUT EN EL FORMULARO] EL SEGUDNO [INDICA QUE SE GUARDARA DE FORMA TEMPORAL SIEMPO ES: 'tmp_name']
        $binariosImagen=fread($imagenSubida,$tamañoArchivo); //COMBERTIMOS LA IMAGEN A BINARIOS 
        $binariosImagen=mysqli_escape_string($conex,$binariosImagen); //limpiamos binarios
        $query="UPDATE usuarios set perfil_img='$binariosImagen' WHERE ID='$ID'"; //CREAMOS CONSULTAS NESESARIAS YO CREE UNA DE MAS
        $querytipe="UPDATE usuarios set tipoDeImg='$tipoArchivo' WHERE ID='$ID'";
        $resultado=mysqli_query($conex,$query);                     //EJECUTAMOS LAS CONSULTAS PRIMER PARAMETRO LA CONEXION SEGUNDO PARAMETRO LA CONSULTA
        $queryTipoDeImg=mysqli_query($conex,$querytipe);
        if($resultado){
            $alert='Imagen Actualizada con Exito';  //SI TODO L SALE CORRECTAMETE
        }else {
            $alert='Error Al Actualizar La Imagen'.mysqli_error($conex); //SI SUCEDDE ALGUN TIPO DE ERROR
        }
    }
}elseif (isset($_REQUEST['link'])) {//isset($_REQUEST['link']) SI SE PULSO EL BOTON CON EL NOMBRE link
    if ($conex) {
        $perfil_img=$_POST['image'];
        $consulta="UPDATE usuarios set perfil_img='$perfil_img' WHERE ID='$ID'";
        $tipoImg="UPDATE usuarios set tipoDeImg='' WHERE ID='$ID'";
        $result=mysqli_query($conex,$consulta);
        $resultTipoImg=mysqli_query($conex,$tipoImg);
        if ($result) {
            $alert='Imagen De Perfil Actualizada Con Exito';
        }else {
            $alert='Error Al Actualizar La Imagen de Perfil';
        }
    }else {
        $alert='Error en la conexion con el servidor';
    }
}*/ $ID=$_SESSION['IDuser'];
    if (isset($_REQUEST['save'])){
        if (isset($_FILES['img']['name'])) {
            $tipoArchivo=$_FILES['img']['type'];
            $nombreArchivo=$_FILES['img']['name']; //NOMBRE ARCHIVO
            $tamañoArchivo=$_FILES['img']['size']; //TAMAÑO DEL ARCHIVO
            $imagenSubida=fopen($_FILES['img']['tmp_name'],'r'); //LEEMOS EL ARCHIVO LA 'r' DE SEGUNDO PARAMETRO ES LECTIRA LEER $_FILES ES UNA VARIABLE MEGAGLOBAL DONDE SE GUARDAN LOS ARCHOS DE FORMA TEMPORAL EL PRIMER [NAME DEL CAMPO IMPUT EN EL FORMULARO] EL SEGUDNO [INDICA QUE SE GUARDARA DE FORMA TEMPORAL SIEMPO ES: 'tmp_name']
            $binariosImagen=fread($imagenSubida,$tamañoArchivo); //COMBERTIMOS LA IMAGEN A BINARIOS 
            $binariosImagen=mysqli_escape_string($conex,$binariosImagen);
            $consulta="INSERT INTO imgs(img,user_id,tipoDeImg) VALUES('$binariosImagen','$ID','$tipoArchivo')";
            $saveImg=mysqli_query($conex,$consulta);
            if ($saveImg) {
                $alert='Imagen guardada con exito';
            }else {
                $alert='Error al guardar la imagen';
            }
        }
    }
    if(isset($_REQUEST['link'])){
        $img=$_POST['image'];
        $consulta="INSERT INTO imgs(img,user_id) VALUES('$img','$ID')";
        $result=mysqli_query($conex,$consulta);
        if ($result) {
            $alert='Imagen guardada con exito';
        }else{
            $alert='Error al guardar la imagen';
        }
    } 
}
include('functions.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://img.icons8.com/color/2x/pictures-folder.png" type="image/x-icon">
    <link rel="stylesheet" href="style2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>USERS OF DB</title>
</head>
<body>
    <header style="color:white;"><i class="bi bi-power"></i>
        <p class="fecha">Medellin, Colombia, <?php echo fecha() ?></p>
        <p class="fecha" style="padding-left:150px;">BIENVENIDO <?php echo $_SESSION['user']; ?></p>
        <div class="dropdown" style="display:inline;float:right;">
  <button class="btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    MENU
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Cambiar Contraseña</a></li>
    <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#email">Cambiar Correo Electronico</a></li>
    <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#number">Cambiar Numero De Telefono</a></li>
    <li><a class="dropdown-item" href="cerrarSesion.php">
        <i class="bi bi-power">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-power" viewBox="0 0 16 16"  style="filter: drop-shadow(0 2px 5px black);">
            <path d="M7.5 1v7h1V1h-1z"/>
            <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
        </svg></i>  Cerrar Sesion </a></li>
  </ul>
</div>
    </header>
    <div class="forms" style="margin:100px;">
        <form action="" method="post" style="display:inline-block;">
            <div style="">
                <label for="exampleInputPassword1" class="form-label" style="font-size:20px;color:white;">Guardar imágen(LINK)</label>
                <input type="text" class="form-control" name="image" id="image" style="margin-right:100px;margin-bottom: 20px; width: 470px;" required>
                <button type="submit" class="btn btn-primary" name="link">Guardar imágen</button>
            </div>
        </form>
        <form method="post" enctype='multipart/form-data' style="display:inline-block">
            <div>
                <label for="exampleInputPassword1" style="font-size:20px;color:white;" class="form-label">Guardar imágen(ARCHIVO)</label>
                <input type="file" class="form-control" name="img" id="img" style="margin-right:100px;margin-bottom: 20px; width: 470px;" required>
                <button type="submit" class="btn btn-primary" name="save">Guardar Imágen</button>
            </div>
        </form>
        <div style="text-aling:center;color:white;text-shadow: 0px 0px 10px black;" class="mb-3"><?php echo $alert; ?></div>
    </div>
    <div style="display:inline-block;"><?php include('mostrar.php');?></div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <?php include('Cpassword.php');?>
</div>
<div class="modal fade" id="email" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <?php include('Cemail.php');?>
</div>
<div class="modal fade" id="number" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <?php include('Cnumber.php');?>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>