<?php

$config = parse_ini_file('configuracion.ini'); 
//La "p" antes de localhost indica que la conexión es persistente 

if (!isset($_SESSION)) {
  session_start();
}else {
    session_destroy();
}


$con = mysqli_connect($config ['hostname_con'], $config['username_con'], $config['password_con'], $config ['database_extra_con']);
mysqli_set_charset($con, 'utf8');


if (is_file("includes/funciones.php")) 
include("includes/funciones.php"); 
else
{
	include("includes/funciones.php");
}
?>