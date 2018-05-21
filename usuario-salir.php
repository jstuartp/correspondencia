<?php require_once('Connections/conexion.php'); ?>

<?php    
    $_SESSION['MM_Username'] = "";
    $_SESSION['MM_UserGroup'] = "";
    $_SESSION['reservas_UserId'] = "";
    $_SESSION['reservas_Mail'] = "";
    $_SESSION['reservas_Nivel'] = "";
    unset($_SESSION['MM_Username']);
    unset($_SESSION['MM_UserGroup']);
    unset($_SESSION['reservas_UserId']);
	unset($_SESSION['reservas_Mail']);
    unset($_SESSION['reservas_Nivel']);
	setcookie("id_usuario_correspondencia", $_SESSION['reservas_UserId'] , time()-(60*60*24*12));

    $updateGoTo = "index.php";
	header(sprintf("Location: %s", $updateGoTo));
	?>

?>