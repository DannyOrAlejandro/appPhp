<?php 
//validamos que se halla presiondo el boton submit
if(!empty($_POST) && isset($_REQUEST['link'])){
    $alert='';
    //validoamos que todos los campos esten llenos
    if (empty($_POST['usuario']) | empty($_POST['clave'])) {
        $alert='Todos los campos son obligatirios';
    }else{//si todos los campos esta llenos iniciamos procesio de registro
        //hacemos la coneccion con el server, puedo crear un archivo de conexion.php
        $conex=mysqli_connect('localhost','danny','dgstar','danny');
     
        
        //validamos que se halla hecho la conexion de forma correcta
        if (!$conex) {
            $alert='Error en la conexion con el servidor';
        }else{
            $user_name=$_POST['usuario'];
            $email=$_POST['email'];
            //encriptamos la clave o password
            $password=md5($_POST['clave']);
            $perfil_img=$_POST['image'];
            //creamos consulta para saber si el email o nombre de usuraio esta repetido
            $query_validacion="SELECT * FROM usuarios WHERE user_name='$user_name' OR email='$email'";
            $query=mysqli_query($conex,$query_validacion);
            //meto el resultado de la consulta en un array
            $result=mysqli_fetch_array($query);
            //solo registramos el usuario si no existe y el user_name y email deben ser unicos en la tabla
            //por lo que si alguno de los dos existe no se hace el registro
            //si me arroja mas de 0 considencias la consilta quiere decir que el usuario si existe
            //o el correo o user_name ya esta en ela tabla
            if($result>0){
                $alert='el nombre de usuario o correo ya esta en uso ingrese uno diferente';
            }else{
                //cramos la consulta para inserter los datos en la tabla si no estan el user_name o email repetidos
                $insert="INSERT INTO usuarios(user_name,password,perfil_img,email) VALUES('$user_name','$password','$perfil_img','$email')";
                //esta consulta me devuelve un valor falso o verdadero
                //false si no se pudo hacer,true si se realizo con exito
                $query_insert=mysqli_query($conex,$insert);
                if ($query_insert) {
                    //si se realizo con exito la consulta
                    $alert='Usuario creado o registrado con exito, ya puedes iniciar sesion';
                }else{
                    $alert='error al crear o registrar el usuario';
                }
            }

            
        }
    }
}elseif(isset($_REQUEST['file']) && !empty($_POST)) {  //isset($_REQUEST['file']) ES SI SE PULSO EL BOTON CON EL NOMBRE file
    $alert='';
    if (empty($_POST['usuario']) | empty($_POST['clave'])) {
        $alert='Todos los campos son obligatirios';
    }else{//si todos los campos esta llenos iniciamos procesio de registro
        //hacemos la coneccion con el server, puedo crear un archivo de conexion.php
        $conex=mysqli_connect('localhost','danny','dgstar','danny');
        //validamos que se halla hecho la conexion de forma correcta
        if (!$conex) {
            $alert='Error en la conexion con el servidor';
        }else{
            $user_name=$_POST['usuario'];
            $email=$_POST['email'];
            //encriptamos la clave o password
            $password=md5($_POST['clave']);
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
                //$query="INSERT INTO usuarios(perfil_img) VALUES('$binariosImagen')"; //CREAMOS CONSULTAS NESESARIAS YO CREE UNA DE MAS
                //creamos consulta para saber si el email o nombre de usuraio esta repetido
                $query_validacion="SELECT * FROM usuarios WHERE user_name='$user_name' OR email='$email'";
                $query=mysqli_query($conex,$query_validacion);
                //meto el resultado de la consulta en un array
                $result=mysqli_fetch_array($query);
                //solo registramos el usuario si no existe y el user_name y email deben ser unicos en la tabla
                //por lo que si alguno de los dos existe no se hace el registro
                //si me arroja mas de 0 considencias la consilta quiere decir que el usuario si existe
                //o el correo o user_name ya esta en ela tabla
                if($result>0){
                    $alert='el nombre de usuario o correo ya esta en uso ingrese uno diferente';
                }else{
                    //cramos la consulta para inserter los datos en la tabla si no estan el user_name o email repetidos
                    $insert="INSERT INTO usuarios(user_name,password,perfil_img,email) VALUES('$user_name','$password','$binariosImagen','$email')";
                    //esta consulta me devuelve un valor falso o verdadero
                    //false si no se pudo hacer,true si se realizo con exito
                    $query_insert=mysqli_query($conex,$insert);
                    $querytipe="UPDATE usuarios set tipoDeImg='$tipoArchivo' WHERE user_name='$user_name'";
                    //$resultado=mysqli_query($conex,$query);                     //EJECUTAMOS LAS CONSULTAS PRIMER PARAMETRO LA CONEXION SEGUNDO PARAMETRO LA CONSULTA
                    $queryTipoDeImg=mysqli_query($conex,$querytipe);
                    if ($query_insert) {
                    //si se realizo con exito la consulta
                    $alert='Usuario creado o registrado con exito, ya puedes iniciar sesion';
                }else{
                    $alert='error al crear o registrar el usuario';
                }
            }
        }

    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>INICIAR SECION</title>
</head>
<body>
    <header>
        <h1>registrarse en el sitema de DANNY</h1>
        <h2>Validacion y registro en la Base de datos de danny</h2>
    </header>
    <!--si dejo action vacio ejecutara este mismo archivo usamos enctype='multipart/form-data' para poder enviar la imagen 
    a la base de datos-->
    <form method="post" enctype='multipart/form-data'>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="usuario" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">NO SE DISTINGUEN ENTRE MAYUSCULAS Y MINUSCULAS</div>
        </div>
        <div class="mb-3" id="perfilImg">
            <label for="email" class="form-label">Correo Electronico</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="clave" id="exampleInputPassword1">
        </div>
        <!--si alerte esta vacio no imprime nada si tiene algo lo imprime (esto es el operador ternario)-->
        <div>
        <div style="display:inline-block;">
                <label for="exampleInputPassword1" class="form-label" style="font-size:20px;color:white;">Registrarse Con Imagen De Perfil(Link)</label>
                <input type="text" class="form-control" name="image" id="image" style="margin-right:100px;margin-bottom: 20px; width: 470px;">
                <button type="submit" class="btn btn-primary" name="link">Registrarse Con Imagen De Perfil(Link)</button>
            </div>
            <div style="display:inline-block;">
                <label for="exampleInputPassword1" style="font-size:20px;color:white;" class="form-label">Registrarse Con Imagen De Perfil(Archivo)</label>
                <input type="file" class="form-control" name="img" id="img" style="margin-bottom: 20px; width: 470px;">
                <button type="submit" class="btn btn-primary" name="file">Registrarse Con Imagen De Perfil(Archivo)</button>
            </div>
        </div>
        <div class="alert"><?php echo isset($alert)?$alert:''; ?></div>
        <button type="reset" onclick="window.location='index.php';" class="btn btn-primary">Iniciar Sesion</button>
    </form>
    <?php
    include("mostrar.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>