<?php
//inisialisamos una sesion para destruir todas las seciones
session_start();
session_destroy();
header('location:index.php');
?>