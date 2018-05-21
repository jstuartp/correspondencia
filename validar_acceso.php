<?php require_once('Connections/conexion.php'); ?>
<?php

if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  //ATENCIÓN USAMOS MD5 para guardar la contraseña.
  $password=md5($_POST['pass']);
  $MM_fldUserAuthorization = "nivel";
  $MM_redirectLoginSuccess = "bien.php";
  $MM_redirectLoginFailed = "error.php";
  $MM_redirecttoReferrer = false;
  
    
  $LoginRS__query=sprintf("SELECT usuario_id, email, pass, nivel FROM usuarios WHERE usuario=%s AND pass=%s AND estado_usuario=1",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysqli_query($con,  $LoginRS__query) or die(mysqli_error(con));
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysqli_result($LoginRS,0,'nivel');
    
  if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;   
    $_SESSION['reservas_UserId'] = mysqli_result($LoginRS,0,'usuario_id');
    $_SESSION['reservas_Mail'] = mysqli_result($LoginRS,0,'email');
    $_SESSION['reservas_Nivel'] = mysqli_result($LoginRS,0,'nivel');
    ContabilizarAcceso($_SESSION['reservas_UserId']);
  
  /* DESCOMENTAR SOLO SI SE USA EL CHECK DE RECORDAR CONTRASEÑA, HABRÁ QUE USAR LA FUNCIÓN generar_cookie()*/
  if ((isset($_POST["recordar"])) && ($_POST["recordar"]=="1"))
  generar_cookie($_SESSION['reservas_UserId']);
        

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];  
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>