<?php
//LAS LIENAS 6 7 Y 8 iriab en el header.php para tds las paginas que tenga el sistema y hacerlas privadas
//inicioaliso las seciones las cuales si se inisio se sesion ya deben estar cradas,
//si no estan creadas no puedo acceder al sistema, entoces validamos que exista una seccion para poder entrar al sistema
//si no existe no se puede entrar nos redirecciona al formulario de inicio de secion
session_start();
$ID=$_SESSION['IDuser'];
if (empty($_SESSION['active'])) {header('location:index.php');}
$alert='';
$conex=mysqli_connect('localhost','danny','dgstar','danny');  //creamos conexion
if (isset($_REQUEST['file'])) {  //isset($_REQUEST['file']) ES SI SE PULSO EL BOTON CON EL NOMBRE file
    if (isset($_FILES['img']['name'])) {
        //para no tener problemas debo de validar el tipo de archivo que es para evitar posibles hackeosno lo hare porque
        //es mmi server locar pero se hace asi:
        $tipoArchivo=$_FILES['img']['type'];
        /*$permitidos=array("..","..");  ARRAY CON LOS TIPO DE ARCHIVOS PERMITIDOS
        if(in_array($tipoArchivo,$permitidos)){ PARAMETRO 1 DE LA FUNCION IN_ARRAY EL VALOR QUE KEREMOS SABER SI ESTA EN EL ARRAY PARAMETRO 2 ARRAY EN EL QUE SE BUSCARA SI ESTA O NO EL PARAMETRO 1
            die("ARCHIVO NO PERMITIDO");   SI EL ARCHIVO NO ESTA PERMITIDO MATAMOS TODO PROSECO Y MANDAMOS UN MESAJE
        }
        */
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
}elseif (isset($_REQUEST['save'])){
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
            $alert='Error al guardar la imagen: '.mysqli_error($conex);
        }
    }
}
include('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>USERS OF DB</title>
</head>
<body>
    <header style="color:white;">
        <a href="cerrarSesion.php"><img style="display:inline-block;float:right;" id="cerrarSesion" src="http://icons555.com/images/icons-gray/image_icon_logout_pic_512x512.png" alt=""></a>
        <p class="fecha">Colombia, Bogota, <?php echo fecha() ?></p>
        <p class="fecha" style="padding-left:200px;">BIENVENIDO <?php echo $_SESSION['user']; ?></p>
    </header>
    <div class="forms" style="margin: 100px;">
        <form action="" method="post" style="display:inline-block;">
            <div style="">
                <label for="exampleInputPassword1" class="form-label" style="font-size:20px;color:white;">Imagen de perfil(LINK)</label>
                <input type="text" class="form-control" name="image" id="image" style="margin-right:100px;margin-bottom: 20px; width: 470px;" required>
                <button type="submit" class="btn btn-primary" name="link">Actualizar Foto De Perfil</button>
            </div>
        </form>
        <form method="post" enctype='multipart/form-data' style="display:inline-block">
            <div>
                <label for="exampleInputPassword1" style="font-size:20px;color:white;" class="form-label">Imagen de perfil(ARCHIVO)</label>
                <input type="file" class="form-control" name="img" id="img" style="margin-right:100px;margin-bottom: 20px; width: 470px;" required>
                <button type="submit" class="btn btn-primary" name="file">Actualizar Foto De Perfil</button>
                <button type="submit" class="btn btn-primary" name="save">Guardar Imagen</button>
            </div>
        </form>
        <div style="text-aling:center;"><?php echo $alert; ?></div>
    </div>
    <div style="display:inline-block;"><?php include('mostrar.php');?></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>