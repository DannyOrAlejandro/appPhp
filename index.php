<?php
$alert='';
//si existe post o sea si ya se pulso el boton iniciar sesion
//empty es si esta vacio, pero al negarlo es si tiene datos
//inicializamos las variables de sesion para que me pueda detectar la variable del primer if 
//y a la vez se indica que se inicio o inisiara sesion
session_start();
//validamos que ya no se haya iniciado seccion y vemos si hay una seccion activa
//la variable se inicializa con la linea 8 al igual que todas las que tenga $_SESSION(variables de sesion) y se llenan al iniciar sesion
if (!empty($_SESSION['active'])) {
    //si la secion esta activa no puede volver a la pagina de login
    header('location: panelControl.php');
}else {
    //si no hay secciones activas se inisiara con el proseso de inisio de sesion
    if (!empty($_POST)) {
        //validamos que los campos no esten vacios
        //si esta vacio el campo con nombre usuario o si esta vacio el campo con nombre password datos obtenidos con $_POST
        //es el valor del atributo name del html lo k va como parametro para post
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
        //si estan vacios
        $alert="ingrese su usuario y contraseña";
        }else {
            //si no estan vacios nos conectamos al base datos
            //mysqli_connetc("nombre_del_server","nombre_de_usuario","contraseña";"nombre_base_de_datos");
            $conex=mysqli_connect('bjokk9p64b3uajxl6sg9-mysql.services.clever-cloud.com','uzukxkzcotihhxn5','gIyVoHkRyLUmdrzzQ3st','bjokk9p64b3uajxl6sg9');
            if (!$conex) {
                //si sucede algun error en la coneccion
                $alert= "Error en la conexion con la base de datos";
            }else{
                //si se conecta de forma correcta guardamos los valores que el usuario ingreso
                //encriptemos las contraseñas con md5 y las escapamos la contraseña y el usuario para evitar inyecciones sql
                $user= mysqli_real_escape_string($conex,$_POST['usuario']);
                $password= md5(mysqli_real_escape_string($conex,$_POST['clave']));
                //creamos las consulta sql
                $consulta="SELECT * FROM usuarios WHERE user_name='$user' AND password='$password'";
                $query=mysqli_query($conex,$consulta);
                //obtenemos numero de filas o numero de considencias en la consulta
                $result=mysqli_num_rows($query);
                //validamos que existe en la db(data base)
                if ($result>0) {
                    //pongo el resultado en un array
                    $data=mysqli_fetch_array($query);
                    //print_r($data); con esto si kiero puedo imprimir es array de los datos que me trajo y ver
                    //que puedo acceder a sus datos po medio de la posicion o el nombre de la columna en la base de dato
                    //indicamos que se inisio una sesion anteriormente al inicializarlas anteriormente y creamos las variables de sesion
                    //variables de sesion es como desetructurar el array anterior con la informacion del usuario
                    $_SESSION['active']=true;
                    $_SESSION['IDuser']=$data['ID'];
                    $_SESSION['user']=$data['user_name'];
                    $_SESSION['contraseña']=$data['password'];
                    //$_SESSION['foto']=$data['perfil_img'];
                    //una ves se comprete el proceso le damos acceso al sistema
                    header('location: panelControl.php');
                }else{//si es usuario no existe en la base de datos o no se encontro
                    $alert='usuario o clave incorrectas';
                    //destruimos todas las variables de sesion oseas cerramos secion
                    session_destroy();
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
    <link rel="shortcut icon" href="https://img.icons8.com/color/2x/pictures-folder.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>INICIAR SECION</title>
</head>
<body>
    <header><br><br>
        <h1>INICIO DE SESIÓN, PROYECTO PIA</h1>
        <h2>Validación e Inicio de Sesión</h2>
    </header>
    <!--si dejo action vacio ejecutara este mismo archivo-->
    <form action="" method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="usuario" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Contraseña</label>
        <input type="password" class="form-control" name="clave" id="exampleInputPassword1">
    </div><!--si alerte esta vacio no imprime nada si tiene algo lo imprime (esto es el operador ternario)-->
    <div class="alert"><?php echo isset($alert)?$alert:''; ?></div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        <button type="reset" onclick="window.location='registrarse.php';" class="btn btn-primary">Registrarse</button>
    </form>
    <footer class="container">
        <article class="container-fluid">
            <div class="mb-3">
                <h2>INFORMACIÓN DE LA APLICACIÓN</h2>
                <p class="mx-3"><i>Galeria de imágenes creada por los desarrolladores citados en la parte inferior de la página. </i></p>
            </div>
            <div class="mb-3">
                <h2>INFORMACIÓN DE LOS DESARROLLADORES</h2>
                <div class="mx-3">
                    <a href="https://code.sololearn.com/WgYx7B79upuY/?ref=app" target="_blank"><button type="button" class="btn btn-outline-primary">Michel Andrea Álvarez</button></a>
                    <a href="https://code.sololearn.com/WHF9nBFCmrrK" target="_blank"><button type="button" class="btn btn-outline-warning">Danny Alejadro Álvarez</button></a>
                    <a href="https://code.sololearn.com/WsCnxHZSUsdD" target="_blank"><button type="button" class="btn btn-outline-info">Maria Paulina Ospina</button></a>
                    <a href="perfil/perfil.html" target="_blank"><button type="button" class="btn btn-outline-light">Jhon Jairo Correa</button></a>
                </div>
            </div>
        </article>
    </footer>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>