<?php 
//validamos que se halla presiondo el boton submit
session_start();
if (!empty($_SESSION['active'])) {header('location:index.php');}
if(!empty($_POST)){
    $alert='';
    //validoamos que todos los campos esten llenos
    if (empty($_POST['usuario']) | empty($_POST['clave']) | empty($_POST['email']) | empty($_POST['number'])) {
        $alert='Todos los campos son obligatirio';
    }else{//si todos los campos esta llenos iniciamos procesio de registro
        //hacemos la coneccion con el server, puedo crear un archivo de conexion.php
        $conex=mysqli_connect('bjokk9p64b3uajxl6sg9-mysql.services.clever-cloud.com','uzukxkzcotihhxn5','gIyVoHkRyLUmdrzzQ3st','bjokk9p64b3uajxl6sg9');
        //validamos que se halla hecho la conexion de forma correcta
        if (!$conex) {
            $alert='Error en la conexion con el servidor';
        }else{
            $user_name=$_POST['usuario'];
            $email=$_POST['email'];
            $number=$_POST['number'];
            //encriptamos la clave o password
            $password=md5($_POST['clave']);
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
                $insert="INSERT INTO usuarios(user_name,email,number,password) VALUES('$user_name','$email','$number','$password')";
                //esta consulta me devuelve un valor falso o verdadero
                //false si no se pudo hacer,true si se realizo con exito
                $query_insert=mysqli_query($conex,$insert);
                if ($query_insert) {
                    //si se realizo con exito la consulta
                    $alert='Usuario registrado con exito, Ya puedes iniciar sesión';
                }else{
                    $alert='Error al crear o registrar el usuario'.mysqli_error($conex);
                }
            }

            
        }
    }
}
/*if(isset($_REQUEST['file']) && !empty($_POST)) {  //isset($_REQUEST['file']) ES SI SE PULSO EL BOTON CON EL NOMBRE file
    $alert='';
    if (empty($_POST['usuario']) | empty($_POST['clave']) | empty($_POST['email']) | !isset($_FILES['img']['name']) ) {
        $alert='Todos los campos son obligatirios, Sube una imagen o Copia y pega el link de una imagen';
    }else{//si todos los campos esta llenos iniciamos procesio de registro
        //hacemos la coneccion con el server, puedo crear un archivo de conexion.php
        $conex=mysqli_connect('bjokk9p64b3uajxl6sg9-mysql.services.clever-cloud.com','uzukxkzcotihhxn5','gIyVoHkRyLUmdrzzQ3st','bjokk9p64b3uajxl6sg9');
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
                    $insertImg="INSERT INTO imgs(img) VALUES('$binariosImagen')";
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
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function comprobarClaves(){
            var clave=document.f1.clave.value;
            var clave2=document.f1.clave2.value;
            if (clave==clave2){
                document.f1.submit();
            }else{
                alert('Las contraseñas no coinciden');
            }
        }
    </script>
    <link rel="shortcut icon" href="https://img.icons8.com/color/2x/pictures-folder.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>REGISTRARSE</title>
</head>
<body>
    <header>
        <h1>registrarse en el sitema</h1>
        <h2>Validacion y registro</h2>
    </header>
    <!--si dejo action vacio ejecutara este mismo archivo usamos enctype='multipart/form-data' para poder enviar la imagen 
    a la base de datos-->
    <form method="post" enctype='multipart/form-data' name="f1">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="usuario" aria-describedby="emailHelp">
        </div>
        <div class="mb-3" id="perfilImg">
            <label for="email" class="form-label">Correo Electronico</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Telefono</label>
            <input type="number" class="form-control" name="number" id="number">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="clave" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Repita la Contraseña</label>
            <input type="password" class="form-control" name="clave2" id="exampleInputPassword1">
        </div>
        <!--si alerte esta vacio no imprime nada si tiene algo lo imprime (esto es el operador ternario)-->
        <div>
        <div style="display:inline-block;">
                <button type="button" class="btn btn-primary" name="link" onclick="comprobarClaves()">Registrarse</button>
        </div>
        <div class="alert"><?php echo isset($alert)?$alert:''; ?></div>
        <button type="reset" onclick="window.location='index.php';" class="btn btn-primary">Iniciar Sesion</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>