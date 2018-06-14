<?php 
require_once('Connections/conexion.php');




if ((!isset($_SESSION['reservas_UserId'])) || (!$_SESSION['reservas_UserId']!=0)) comprobarcookies();

//$config = parse_ini_file('../Connections/configuracion.ini'); //declarando la variable para obtener informacion del config

$permitido = $config['seccion_administrativa']; 
$permitido2 =$config['seccion_informatica']; 


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  global $con;
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($con, $theValue) : mysqli_escape_string($con,$theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":

      $theValue = ($theValue != "") ? intval($theValue) : "NULL";   
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }


  return $theValue;
}
}


/**************************** MANEJO DE SESIONES DE USUARIO PARA ESTABLECERLES UN TIEMPO DE 
                                    DURACIÓN EN EL SISTEMA 
                                                                       **********************/

function LimpiarSesionesMuertas($tiempodevida)
{
  
  global $con;
  $query_Delete = "DELETE FROM tblusuarioactivo WHERE TIME_TO_SEC(TIMEDIFF(NOW(), fchUltimo))>".$tiempodevida;
  //echo $query_Delete;
    $ConsultaFuncion = mysqli_query($con, $query_Delete) or die(mysqli_error($con));
  //mysqli_free_result($ConsultaFuncion);
}


function BorrarSesion($id)
{
  global $con;
  $query_Delete = sprintf("DELETE FROM tblusuarioactivo WHERE refUsuario=%s",
                       GetSQLValueString($id, "int"));
    $ConsultaFuncion = mysqli_query($con, $query_Delete) or die(mysqli_error($con));
  //mysqli_free_result($ConsultaFuncion);
}

function InsertarSesion($id)
{
  global $con;
  
  $query_ConsultaFuncion = "INSERT INTO tblusuarioactivo (refUsuario, fchUltimo) VALUES (".$id.", NOW())";
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  //mysqli_free_result($ConsultaFuncion);
}


function ActualizarSesion($id)
{
  
  global $con;
  
  $updateSQL = sprintf("UPDATE tblusuarioactivo SET fchUltimo=NOW() WHERE refUsuario = %s",
                       GetSQLValueString($id, "int"));
    $ConsultaFuncion = mysqli_query($con,  $updateSQL) or die(mysqli_error($con));
  //mysqli_free_result($ConsultaFuncion);
  
}

function ActualizarEstadoSesion($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT idContador FROM tblusuarioactivo WHERE refUsuario=%s",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  if ($totalRows_ConsultaFuncion==0)
  {
    InsertarSesion($id);
  }
  else
  {
    ActualizarSesion($id);
  }

  mysqli_free_result($ConsultaFuncion);
}

function ComprobarEstadoSesion($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT idContador FROM tblusuarioactivo WHERE refUsuario=%s",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  if ($totalRows_ConsultaFuncion==0)
  {
    return false;
  }
  else
  {
    return true;
  }

  mysqli_free_result($ConsultaFuncion);
}

if ((isset($_SESSION['reservas_UserId'])) && ($_SESSION['reservas_UserId']!="")) {
ActualizarEstadoSesion($_SESSION['reservas_UserId']);
}
$tiempovida=300;
LimpiarSesionesMuertas($tiempovida);

//FIN ACTUALIZAR ESTADO DE SESION
//FIN ACTUALIZAR ESTADO DE SESION
//FIN ACTUALIZAR ESTADO DE SESION




/**************************** MANEJO DE SESIONES DE USUARIO PARA ESTABLECERLES UN TIEMPO DE 
                                    DURACIÓN EN EL SISTEMA 
                                                                       **********************/


/********************** FUNCION PARA OBTENER NOMBRE DE USARIO ********************/

function obtenerNombre ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT nombre, apellido1 FROM usuarios WHERE usuario_id =%s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
   

  return $row_ConsultaFuncion["nombre"]." ". $row_ConsultaFuncion["apellido1"];  
  mysqli_free_result($ConsultaFuncion);
 
}

/********************** FUNCION PARA OBTENER email DE USARIO ********************/


function obtenerEmail ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT email FROM usuarios WHERE usuario_id =%s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
    
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion["email"];
}


/************************** FUNCION PARA RESTRINGIR EL ACCESO AL SITIO  *********************************/

// BLOQUE RESTRICCION ACCESO POR NIVELES


function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

/********************* restriccion de acceso por niveles ********************/

function RestringirAcceso($LISTADENIVELES)
{
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = $LISTADENIVELES;
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = "sin_permisos.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
}

/*********************** SQLS PARA RESPUESTA DE LOS USUARIOS A LOS OFICIOS **************************/
function respuestaUsuario ($id, $oficio_id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf(" SELECT  info_oficios.oficio_id, 
                                        oficios_usuario.id_oficioin, 
                                        oficios_usuario.id_estado, 
                                        oficios_usuario.usuario_id, 
                                        oficios_usuario.observacion, 
                                        oficios_usuario.resp_usuario 
                                    FROM 
                                            oficios_usuario, info_oficios 
                                    WHERE 
                                            info_oficios.oficio_id = oficios_usuario.id_oficioin and      
                                            info_oficios.oficio_id  = ".GetSQLValueString($oficio_id, "int" )." and 
                                            oficios_usuario.usuario_id = ".GetSQLValueString($id, "int" )."

                                    ORDER BY oficios_usuario.usuario_id ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion['resp_usuario'];
 
}

/******************************************                      **************************************/

function EstadorespuestaUsuario ($id, $oficio_id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf(" SELECT  info_oficios.oficio_id, 
                                        oficios_usuario.id_oficioin, 
                                        oficios_usuario.id_estado, 
                                        oficios_usuario.usuario_id, 
                                        oficios_usuario.observacion, 
                                        oficios_usuario.resp_usuario 
                                    FROM 
                                            oficios_usuario, info_oficios 
                                    WHERE 
                                            info_oficios.oficio_id = oficios_usuario.id_oficioin and      
                                            info_oficios.oficio_id  = ".GetSQLValueString($oficio_id, "int" )." and 
                                            oficios_usuario.usuario_id = ".GetSQLValueString($id, "int" )."

                                    ORDER BY oficios_usuario.usuario_id ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion['id_estado'];
 
}

/*********************** SQLS PARA RESPUESTA DE LOS USUARIOS A LOS OFICIOS **************************/


function cuentaOficiosAsignados ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf(" SELECT   COUNT(oficios_usuario.id_oficiousua ) as suma, info_oficios.oficio_id, 
                                                  oficios_usuario.id_oficioin, 
                                                  oficios_usuario.id_estado, 
                                                  oficios_usuario.usuario_id, 
                                                  oficios_usuario.observacion, 
                                                  oficios_usuario.resp_usuario 
                                          FROM 
                                                  oficios_usuario, info_oficios 
                                          WHERE 
                                                  info_oficios.oficio_id = oficios_usuario.id_oficioin and      
                                                  info_oficios.oficio_id  = ".GetSQLValueString($id, "int" )." 

                                          ORDER BY oficios_usuario.usuario_id
                                           ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion['suma'];
  
}

/***************** OBTIENE IMAGEN AVATAR DE LOS USUARIOS ASIGNADOS A USUARIO ***************/

function ObtieneAvatar ($id, $oficio_id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf(" SELECT  info_oficios.oficio_id, 
                                        oficios_usuario.id_oficioin, 
                                        oficios_usuario.id_estado, 
                                        oficios_usuario.usuario_id, 
                                        oficios_usuario.observacion, 
                                        oficios_usuario.resp_usuario,
                                        usuarios.avatar
                                    FROM 
                                            oficios_usuario, info_oficios , usuarios 
                                    WHERE 
                                            info_oficios.oficio_id = oficios_usuario.id_oficioin and 
                                             oficios_usuario.usuario_id = usuarios.usuario_id and      
                                            info_oficios.oficio_id  = ".GetSQLValueString($oficio_id, "int" )." and 
                                            oficios_usuario.usuario_id = ".GetSQLValueString($id, "int" )."

                                    ORDER BY oficios_usuario.usuario_id ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);
  echo $row_ConsultaFuncion['avatar'];
  
}

function obtieneAvatarUsuario ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf(" SELECT * FROM usuarios WHERE usuarios.usuario_id= ".GetSQLValueString($id, "int" )." ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion['avatar'];
  
}

/************************* obtener id de usuario asignado a oficio *******************/
function obtenerIdUsuario ($id)
{
  global $con;
 
  $query_ConsultaFuncion = sprintf("SELECT * FROM usuarios WHERE usuario_id =%s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    

  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion["usuario_id"];
}

/********************* obtener la sección del usuario ****************************/
function obtenerSeccionUsuario ($id)
{
  global $con;
 
  $query_ConsultaFuncion = sprintf("SELECT * 
                                      FROM usuarios, secciones 
                                      WHERE usuarios.id_seccion= secciones.id_seccion and 
                                      usuarios.usuario_id = %s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    

  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion["descripcion"];
}


function obtenerIDSeccionUsuario ($id)
{
  global $con;
 
  $query_ConsultaFuncion = sprintf("SELECT * 
                                      FROM usuarios, secciones 
                                      WHERE usuarios.id_seccion= secciones.id_seccion and 
                                      usuarios.usuario_id = %s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    

  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion["id_seccion"];
}
/********************* fin  obtener la sección del usuario ****************************/

/*********************** OBTENER NIVEL DE USUARIO ****************************************/
function obtenerNivelUsuario ($id)
{
  global $con;
 
  $query_ConsultaFuncion = sprintf("SELECT * 
                                      FROM usuarios, niveles 
                                      WHERE usuarios.nivel = niveles.id_nivel and 
                                      usuarios.usuario_id = %s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    

  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion["descripcion"];
}


function obtenerIDNivelUsuario ($id)
{
  global $con;
 
  $query_ConsultaFuncion = sprintf("SELECT * 
                                      FROM usuarios, niveles 
                                      WHERE usuarios.nivel = niveles.id_nivel and 
                                      usuarios.usuario_id = %s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    

  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion["id_nivel"];
}

/*********************** FIN OBTENER NIVEL DE USUARIO *************************************/

/************************* obtener el comentario de la jefatura de un oficio asignado *************/
function obtenerComentarioJefatura ($id1, $id2)
{
  global $con;
 
  $query_ConsultaFuncion = sprintf("SELECT    info_oficios.oficio_id, 
                                              oficios_usuario.id_oficioin, 
                                              oficios_usuario.id_estado, 
                                              oficios_usuario.usuario_id, 
                                              oficios_usuario.observacion, 
                                              oficios_usuario.resp_usuario, 
                                              oficios_usuario.id_oficiousua

                                      FROM 
                                              oficios_usuario, info_oficios 
                                      WHERE 
                                              info_oficios.oficio_id = oficios_usuario.id_oficioin and      
                                              info_oficios.oficio_id  = $id1 and 
                                              oficios_usuario.usuario_id = $id2 ");
  //echo $query_ConsultaFuncion;
  
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    

  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion["observacion"];
}


/**************** OBTENER EL ESTADO DE OFICIO DEL USUARIO PARA ELEGUIR SI ESTA EN TRAMITE O TRAMITADO********/

function obtenerEstadoOficio ($id1, $id2)
{
  global $con;
 
   $query_ConsultaFuncion = sprintf("SELECT    
                                              oficios_usuario.id_estado 
                                              

                                      FROM 
                                              oficios_usuario, info_oficios 
                                      WHERE 
                                              info_oficios.oficio_id = oficios_usuario.id_oficioin and      
                                              info_oficios.oficio_id  = $id1 and 
                                              oficios_usuario.usuario_id = $id2 ");
  
  
  
  /*
  $query_ConsultaFuncion = sprintf("SELECT    info_oficios.oficio_id, 
                                              oficios_usuario.id_oficioin, 
                                              oficios_usuario.id_estado, 
                                              oficios_usuario.usuario_id, 
                                              oficios_usuario.observacion, 
                                              oficios_usuario.resp_usuario, 
                                              oficios_usuario.id_oficiousua

                                      FROM 
                                              oficios_usuario, info_oficios 
                                      WHERE 
                                              info_oficios.oficio_id = oficios_usuario.id_oficioin and      
                                              info_oficios.oficio_id  = $id1 and 
                                              oficios_usuario.usuario_id = $id2 ");*/
  //echo $query_ConsultaFuncion;
  
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  //$totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    

  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion["id_estado"];
}

/************ SQLS PARA OBTENER LOS OFICIOS ASIGNADOS, EN TRÁMITE Y TRAMITADOS PARA PRESENTAR EN ENTRADA bien.php*******************/
function cuentaOficiosAsignados2 ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf(" SELECT   COUNT(id_oficioin ) as suma
                                          FROM 
                                                  oficios_usuario
                                          WHERE 
                                                  ( ( oficios_usuario.recien_asigna= 1) ) and  /*LINEA MODIFICADA POR STUART*/
                                                  oficios_usuario.usuario_id  =  ".GetSQLValueString($id, "int" )." ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion['suma'];
  
}

function cuentaOficiosTramite ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf(" SELECT   COUNT(id_oficioin ) as suma
                                          FROM 
                                                  oficios_usuario
                                          WHERE 
                                                  ((oficios_usuario.id_estado != 5) and (oficios_usuario.recien_asigna = 0)) and 
                                                  oficios_usuario.usuario_id  =  ".GetSQLValueString($id, "int" )." ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion['suma'];
  
}


function cuentaOficiosTramitados ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf(" SELECT   COUNT(id_oficioin ) as suma
                                          FROM 
                                                  oficios_usuario
                                          WHERE 
                                                  oficios_usuario.id_estado= 5 and 
                                                  oficios_usuario.usuario_id  =  ".GetSQLValueString($id, "int" )." ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion['suma'];
  
}


function cuentaOficiosNuevosEntrada ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT COUNT(oficio_id1 ) as suma
                                FROM info_oficios
                                WHERE info_oficios.id_estado=1 and info_oficios.oficio_id 
                                NOT IN
                                      (SELECT oficios_usuario.id_oficiousua
                                       FROM oficios_usuario)");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion['suma'];
  
}

function UsuarioUnico($email)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT * FROM usuarios WHERE email=%s",
    GetSQLValueString($email, "text"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  if ($totalRows_ConsultaFuncion==1) return false; else return true;
  mysqli_free_result($ConsultaFuncion);
}

/****************************** OBTENER EL AÑO PARA LOS OFICIOS ****************/

function obtenerAnno ($id1)
{
  global $con;
 
  $query_ConsultaFuncion = sprintf("SELECT DISTINCT YEAR(fecha) as el_anno FROM info_oficios ORDER BY fecha DESC");
  //echo $query_ConsultaFuncion;
  
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    

  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion["el_anno"];
}


/************************** OBTENEMOS EL NIVEL AUTORIZADO PARA VISUALIZAR MOVIMIENTOS EN LOS OFICIOS ****/
function obtenerNivelAutorizado ($id)
{
  global $con;
 
  $query_ConsultaFuncion = sprintf("SELECT * 
                                    FROM niveles, usuarios
                                        WHERE autorizado = 1 and 
                                        niveles.id_nivel = usuarios.nivel  AND    
                                        usuarios.nivel = %s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    

  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion["id_nivel"];
}



/************************** OBTENEMOS EL NIVEL AUTORIZADO PARA VISUALIZAR MOVIMIENTOS EN LOS OFICIOS ****/
function obtenerSeccionAutorizado ($id)
{
  global $con;
 
  $query_ConsultaFuncion = sprintf("SELECT * 
                                    FROM secciones, usuarios
                                        WHERE autorizado = 1 and 
                                        secciones.id_seccion = usuarios.id_seccion  AND    
                                        usuarios.id_seccion = %s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    

  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion["id_seccion"];
}

/****************** FUNCION PARA GENERAR COOKIE Y RECORDAR EL USUARIO ************/


function ContabilizarAcceso($identificador)
{
  global $con;
  
    $row_ConsultaFuncion = "INSERT INTO tblstatsacceso (refUsuario) VALUES (".$identificador.")";
    $Result1 = mysqli_query($con,  $row_ConsultaFuncion) or die(mysqli_error());
  
   // mysqli_free_result($row_ConsultaFuncion);

}

function generar_cookie($usuario)
{
  mt_srand (time());
    //generamos un número aleatorio
    $numero_aleatorio = mt_rand(1000000,999999999);

  global $con;
  
  
//global $con;
  
  $updateSQL = "UPDATE usuarios SET srtCookie='".$numero_aleatorio."' WHERE usuario_id =". $usuario;
  $ConsultaFuncion = mysqli_query($con,  $updateSQL) or die(mysqli_error($con));

  //3) ahora meto una cookie en el ordenador del usuario con el identificador del usuario y la cookie aleatoria
    setcookie("id_usuario_correspondencia", $usuario , time()+(60*60*24*12));
    setcookie("marca_aleatoria_usuario_correspondencia", $numero_aleatorio, time()+(60*60*24*12));

    
}

function comprobarcookies()
{
//primero tengo que ver si el usuario está memorizado en una cookie
if (isset($_COOKIE["id_usuario_correspondencia"]) && isset($_COOKIE["marca_aleatoria_usuario_cursosoporte"])){
   //Tengo cookies memorizadas
   //además voy a comprobar que esas variables no estén vacías
   if ($_COOKIE["id_usuario_correspondencia"]!="" || $_COOKIE["marca_aleatoria_usuario_cursosoporte"]!=""){
      //Voy a ver si corresponden con algún usuario
    global $localcursopagina;
      
      $query_ConsultaFuncion = "select * from usuarios where usuario_id=" . $_COOKIE["id_usuario_correspondencia"] . " and srtCookie='" . $_COOKIE["marca_aleatoria_usuario_cursosoporte"] . "'";
    $ConsultaFuncion = mysqli_query($localcursopagina,  $query_ConsultaFuncion) or die(mysqli_error());
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);

      if ($totalRows_ConsultaFuncion==1){
         //SI TIENE COOKIE BUENA, SE LE DA ACCESO
     $LoginRS__query="SELECT * FROM usuarios WHERE usuario_id = ".$_COOKIE["id_usuario_correspondencia"]." and estado_usuario =1";
       $LoginRS = mysqli_query($localcursopagina,  $LoginRS__query) or die(mysqli_error());
     $row_LoginRS = mysqli_fetch_assoc($LoginRS);
  
    $_SESSION['MM_Username'] = $row_LoginRS["strEmail"];
    $_SESSION['MM_UserGroup'] = $row_LoginRS["intNivel"];
    $_SESSION['reservas_UserId'] = $row_LoginRS["usuario_id"];
    $_SESSION['reservas_Mail'] = $row_LoginRS["strEmail"];
    $_SESSION['reservas_Nivel'] = $row_LoginRS["intNivel"];
  ContabilizarAcceso($_SESSION['reservas_UserId']);

    $linkhome = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    //$linkhome="index.php"; 
        header("Location: " . $linkhome );
      }
   }
} 
}

function  obtenerUsuarioAutorizadoEliminar ($id)
{
  global $con;
 

$query_UsuariosAutorizados = sprintf("SELECT * 
   FROM   usuarios_autorizados, 
          usuarios, 
          niveles, 
          secciones
    WHERE 
        usuarios.usuario_id = usuarios_autorizados.id_usuario   AND
        usuarios.nivel = niveles.id_nivel AND
        usuarios.id_seccion = secciones.id_seccion AND
        usuarios.usuario_id = usuarios_autorizados.id_usuario AND
        niveles.autorizado = 1 AND
        /*secciones.autorizado = 1 AND*/
        usuarios_autorizados.estado_autorizado = 1 and id_usuario =%s ",GetSQLValueString($id, "int"));
                                      $UsuariosAutorizados = mysqli_query($con,  $query_UsuariosAutorizados) or die(mysqli_error($con));
                                      $row_UsuariosAutorizados = mysqli_fetch_assoc($UsuariosAutorizados);
                                      $totalRows_UsuariosAutorizados = mysqli_num_rows($UsuariosAutorizados);


  mysqli_free_result($UsuariosAutorizados);
  return $row_UsuariosAutorizados["id_usuario"];
}


function obtenerUsuarioAutorizadoVer ($id)
{
  global $con;

$query_UsuariosAutorizados = sprintf("SELECT * 
   FROM   usuarios_autorizados, 
          usuarios, 
          niveles, 
          secciones
    WHERE 
        usuarios.usuario_id = usuarios_autorizados.id_usuario   AND
        usuarios.nivel = niveles.id_nivel AND
        usuarios.id_seccion = secciones.id_seccion AND
        usuarios.usuario_id = usuarios_autorizados.id_usuario AND
        /* niveles.autorizado = 1 AND */
        secciones.autorizado = 1 AND
        usuarios_autorizados.estado_autorizado = 1 and  id_usuario =%s ",GetSQLValueString($id, "int"));
                                      $UsuariosAutorizados = mysqli_query($con,  $query_UsuariosAutorizados) or die(mysqli_error($con));
                                      $row_UsuariosAutorizados = mysqli_fetch_assoc($UsuariosAutorizados);
                                      $totalRows_UsuariosAutorizados = mysqli_num_rows($UsuariosAutorizados); 


  mysqli_free_result($UsuariosAutorizados);
  return $row_UsuariosAutorizados["id_usuario"];
}

/*************************FUNCION PARA OBTENER LOS DATOS DEL ULTIMOP OFICIO GENERADO *******/

function  ObtenerOficioId ($id)
{
  global $con;
  global $config; //Corregido bug001, incluir la variable $config como global
  
  $name = $config['nomeclatura_dependencia'];
  //$name= $permitido;
  $query_ConsultaFuncion = sprintf(" SELECT * FROM info_oficios WHERE oficio_id =  ".GetSQLValueString($id, "int" )." ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);
  return $name. "-".$row_ConsultaFuncion['oficio_id1']. "-". $row_ConsultaFuncion['anno'];

  
}

function  ObtenerOficioIdImprimir ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf(" SELECT * FROM info_oficios WHERE oficio_id =  ".GetSQLValueString($id, "int" )." ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion['oficio_id']; 
  
}

/********************* FUNCIONES PARA EL MODULO DE RESERVACIONES **************/

function CalcularHorasPistaAnuladas($pista)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT * FROM tblfechapista WHERE refPista=%s",GetSQLValueString($pista, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con, $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  if ($totalRows_ConsultaFuncion>0){
     do { 
     ?>
         {
          id: <?php echo $row_ConsultaFuncion["idFecha"]; ?>,
          title: '<?php echo $row_ConsultaFuncion["strMotivo"]; ?>',
          start: '<?php echo $row_ConsultaFuncion["fchFechaInicio"]; ?>',
          end: '<?php echo $row_ConsultaFuncion["fchFechaFin"]; ?>',
        },

         <?php
     } while ($row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion)); 
  }

  mysqli_free_result($ConsultaFuncion);
}
//// WCG////////
function CalcularHorasPistaReservadas($pista)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT * FROM tblreservapista, usuarios WHERE usuarios.usuario_id = tblreservapista.refUsuario and refPropiedad=%s",GetSQLValueString($pista, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con, $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  if ($totalRows_ConsultaFuncion>0){
     do { 
     ?>
         
         {
      
                
                 
                    start: '<?php echo $row_ConsultaFuncion["fchFechaDesde"]; ?>',
                    title: '<?php echo "Lugar: ".$row_ConsultaFuncion["direccion"]; ?>\n \n ' + '<?php echo "Usuario: ".$row_ConsultaFuncion["nombre"]; ?>',
                    end: '<?php echo $row_ConsultaFuncion["fchFechaFin"]; ?>',
                    color: '#1686bf',
                     
                    url: 'reserva_info.php?la_reserva_id=<?php echo  $row_ConsultaFuncion ['idReserva']; ?>',
                   
                   
        },

         <?php
     } while ($row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion)); 
  }

  mysqli_free_result($ConsultaFuncion);
}


function ComprobarFechasLibresPista($idpista, $desde, $hasta)
{
  global $con;
  //echo $desde;
  
  $extraconsulta = CalcularRangosReservadosPista($idpista, $desde, $hasta);
  
  $query_ConsultaFuncion = "SELECT * FROM tblpista WHERE intEstado=1 AND idPista=".$idpista." AND idPista NOT IN (SELECT DISTINCT (tblfechapista.refPista) FROM tblfechapista WHERE (tblfechapista.fchFechaInicio BETWEEN  ".GetSQLValueString(DateToQuotedMySQLDate($desde), "date")." AND ".GetSQLValueString(DateToQuotedMySQLDate($hasta), "date").") OR (tblfechapista.fchFechaFin BETWEEN  ".GetSQLValueString(DateToQuotedMySQLDate($desde), "date")." AND ".GetSQLValueString(DateToQuotedMySQLDate($hasta), "date").")) ".$extraconsulta;
  //echo $query_ConsultaFuncion;
  //echo $desde;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  if ($totalRows_ConsultaFuncion==1){
    //EL HOTEL TIENE LIBRES ESAS FECHAS
    return 1;
  }
  else
  {
    return 0;
  }
  mysqli_free_result($ConsultaFuncion);
}


function CalcularRangosReservadosPista($pista, $desde, $hasta)
{
  global $con;
  
  $desde=DateToQuotedMySQLDate($desde);
  $hasta=DateToQuotedMySQLDate($hasta);
  
  $query_ConsultaFuncion = sprintf("SELECT * FROM tblreservapista WHERE refPropiedad=%s",GetSQLValueString($pista, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con, $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  $consultaextra='';
  
  if ($totalRows_ConsultaFuncion>0){
     do { 
        $consultaextra.=' AND idPista NOT IN (SELECT refPropiedad FROM tblreservapista WHERE (("'.$row_ConsultaFuncion["fchFechaDesde"].'" BETWEEN "'.$desde.'" AND DATE_SUB("'.$hasta.'" ,INTERVAL 1 SECOND)) OR ("'.$row_ConsultaFuncion["fchFechaFin"].'" BETWEEN DATE_ADD("'.$desde.'",INTERVAL 1 SECOND) AND "'.$hasta.'")))';
    
     } while ($row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion)); 
  }
  return $consultaextra;

  mysqli_free_result($ConsultaFuncion);
}


function DateToQuotedMySQLDate($Fecha) 
{ 
$Parte1 = substr($Fecha, 0, 10);
$Parte2 = substr($Fecha, 10, 18);

if ($Parte1<>""){ 
   $trozos=explode("/",$Parte1,3); 
   return $trozos[2]."-".$trozos[1]."-".$trozos[0].$Parte2; } 
else 
   {return "NULL";} 
} 

function ObtenerProvincia($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT strProvincia FROM tblprovincia WHERE idProvincia=%s",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  return $row_ConsultaFuncion["strProvincia"];
  mysqli_free_result($ConsultaFuncion);
}


function ObtenerPropietarioPista($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT refUsuario FROM tblpista WHERE idPista=%s",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  return $row_ConsultaFuncion["refUsuario"];
  mysqli_free_result($ConsultaFuncion);
}

function CalcularHorasDiferencia($desde, $hasta)
{
  $tiempo1=strtotime($desde);
  $tiempo2=strtotime($hasta);
  return $tiempo2-$tiempo1;
}

function ObtieneCorreoParaEnvio($identificador)
{
  global $con;
  
  $query_ConsultaFuncion = "SELECT *
                              FROM    tblreservapista,  usuarios
                              WHERE
                                        usuarios.usuario_id = tblreservapista.refPropietario AND
                                        tblreservapista.refPropietario=$identificador ";
    
    
    //GetSQLValueString($identificador, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  return $row_ConsultaFuncion["email"] ;
  mysqli_free_result($ConsultaFuncion);
}



function ActualizarEstadoOficioBloqueado($id, $oficio)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT * FROM oficios_bloqueados WHERE usuario_id=%s and oficio_id=%s",GetSQLValueString($id, "int"), GetSQLValueString($oficio, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  if ($totalRows_ConsultaFuncion==0)
  {
    InsertarOficioBloqueo($id, $oficio);
  }
  

  mysqli_free_result($ConsultaFuncion);
}


function EliminaEstadoOficioBloqueado($oficio)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("
    SELECT * 
          FROM oficios_bloqueados, oficios_usuario
          WHERE oficios_bloqueados.oficio_id = oficios_usuario.id_oficioin and
                 oficios_bloqueados.oficio_id =  $oficio ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  if ($totalRows_ConsultaFuncion == '1')
  {
    EliminaOficioBloqueo($oficio);
  }
  

  mysqli_free_result($ConsultaFuncion);
}


function InsertarOficioBloqueo($id, $oficio )
{
  global $con;
  
  $query_ConsultaFuncion = "INSERT INTO oficios_bloqueados (usuario_id, oficio_id, fecha_bloqueo) VALUES (".$id.", ".$oficio.",  NOW())";
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  //mysqli_free_result($ConsultaFuncion);
}

function EliminaOficioBloqueo( $oficio)
{
                   
  global $con;
 
$query_Delete = sprintf("DELETE FROM oficios_bloqueados 
                           WHERE oficio_id=%s ",
                      GetSQLValueString($oficio, "int"));
$Result1 = mysqli_query($con, $query_Delete) or die(mysqli_error());
}

function ObtieneNumeroOficio ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf(" SELECT * FROM info_oficios WHERE oficio_id= ".GetSQLValueString($id, "int" )." ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion['oficio_id2'];
  
}

function obtenerEstadoOficio2 ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT * FROM info_oficios, estado_oficio 
                    WHERE info_oficios.id_estado = estado_oficio.id_estado and oficio_id =%s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
    
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion["id_estado"];
}


function obtenerOficioIdEntrada ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT * FROM info_oficios
                    WHERE  oficio_id =%s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
    
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion["oficio_id2"];
}

function obtenerNumeroOficioEntrada ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT * FROM info_oficios
                    WHERE  oficio_id =%s ",GetSQLValueString($id, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
    
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion["no_oficio"];
}



function ObtenerNombreApellido ($identificador)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT usuarios.nombre, usuarios.apellido1, usuarios.usuario FROM usuarios WHERE usuario_id = $identificador",GetSQLValueString($identificador, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
    
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion['nombre']." ".$row_ConsultaFuncion['apellido1'];
}



/* Funcion creada por Stuart
 * recive $_elUsuario= id del usuario para obtener los datos
 * recive $_elEstado= id del estado del oficio
 * retorna la suma de todas las ocurrencias de un estado para un usuario
 */
function ObtenerTotalPorEstado ($_elUsuario,$_elEstado)
{
  global $con;
  
  /*CONSULTA MODIFICADA POR STUART */
  $query_ConsultaFuncion = sprintf(" SELECT  SUM(oficios_usuario.id_estado = $_elEstado) as total
                                    FROM oficios_usuario
                                    WHERE  oficios_usuario.usuario_id = $_elUsuario",GetSQLValueString($_elEstado, "int"),GetSQLValueString($_elUsuario, "int"));
  /************************************/
    
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  //$totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
    
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion['total'];
  
}










function ObtenerTotalAsignados ($identificador)
{
  global $con;
  
  /*CONSULTA MODIFICADA POR STUART */
  $query_ConsultaFuncion = sprintf(" SELECT  SUM(oficios_usuario.id_estado = 9) as asignados_total
                                    FROM oficios_usuario
                                    WHERE  oficios_usuario.usuario_id = $identificador",GetSQLValueString($identificador, "int"));
  /************************************
  
  /*
  $query_ConsultaFuncion = sprintf("SELECT *, SUM(estado_oficio.id_estado=1) as asignados_total
FROM oficios_usuario, info_oficios, estado_oficio
WHERE info_oficios.oficio_id= oficios_usuario.id_oficioin and                             
oficios_usuario.usuario_id =$identificador and  estado_oficio.id_estado= oficios_usuario.id_estado 
and   ( oficios_usuario.id_estado=1 or  oficios_usuario.id_estado=8)
ORDER BY oficios_usuario.id_oficioin DESC,oficios_usuario.id_estado ASC ",GetSQLValueString($identificador, "int"));
  //echo $query_ConsultaFuncion;*/
  
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  //$totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
    
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion['asignados_total'];
  
}

function ObtenerTotalEnTramite ($identificador)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT *, SUM(estado_oficio.id_estado=2) as entramite_total
FROM oficios_usuario, info_oficios, estado_oficio
WHERE info_oficios.oficio_id= oficios_usuario.id_oficioin and                             oficios_usuario.usuario_id =$identificador and  estado_oficio.id_estado= oficios_usuario.id_estado and   oficios_usuario.id_estado=2
ORDER BY oficios_usuario.id_oficioin DESC,oficios_usuario.id_estado ASC",GetSQLValueString($identificador, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
    
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion['entramite_total'];
  
}



function ObtenerTotalTramitados ($identificador)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT *, SUM(estado_oficio.id_estado=3) as tramitados_total
FROM oficios_usuario, info_oficios, estado_oficio
WHERE info_oficios.oficio_id= oficios_usuario.id_oficioin and                             oficios_usuario.usuario_id =$identificador and  estado_oficio.id_estado= oficios_usuario.id_estado and   oficios_usuario.id_estado=3
ORDER BY oficios_usuario.id_oficioin DESC,oficios_usuario.id_estado ASC  ",GetSQLValueString($identificador, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
    
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion['tramitados_total'];
  ;
}

function ObtenerTotalTrasladados ($identificador)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("SELECT *, SUM(estado_oficio.id_estado=8) as trasladados_total
FROM oficios_usuario, info_oficios, estado_oficio
WHERE info_oficios.oficio_id= oficios_usuario.id_oficioin and                             oficios_usuario.usuario_id =$identificador and  estado_oficio.id_estado= oficios_usuario.id_estado and   oficios_usuario.id_estado=8
ORDER BY oficios_usuario.id_oficioin DESC,oficios_usuario.id_estado ASC  ",GetSQLValueString($identificador, "int"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
    
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion['trasladados_total'];
  ;
}

/******************************* resultados de asignados, tramite y tramitados **********/


function ObtenerTotalGrafico ($identificador)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf("

    SELECT SUM(id_estado=2) as ENTRAMITE, SUM(id_estado=3) as PENDIENTE, SUM(id_estado=4) as ESPERA, SUM(id_estado=5) as FINALIZADO
FROM 
oficios_usuario WHERE fecha_asignado >='$identificador' ",GetSQLValueString($identificador, "date"));
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
    
  mysqli_free_result($ConsultaFuncion);

  return $row_ConsultaFuncion['ENTRAMITE'].",".$row_ConsultaFuncion['PENDIENTE'].",".$row_ConsultaFuncion['ESPERA'].",".$row_ConsultaFuncion['FINALIZADO'] ;
  ;
}


function ObtieneNumeroReserva ($id)
{
  global $con;
  
  $query_ConsultaFuncion = sprintf(" SELECT * FROM tblreservapista WHERE idReserva= ".GetSQLValueString($id, "int" )." ");
  //echo $query_ConsultaFuncion;
  $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
  $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
  $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
  
  mysqli_free_result($ConsultaFuncion);
  return $row_ConsultaFuncion['fchreserva'];
  
}



function  obtenerUsuarioAutorizadoEliminar1 ($id)
{
  global $con, $permitido, $permitido2;
 

$query_UsuariosAutorizados = sprintf("SELECT *
                              FROM usuarios
                              WHERE usuario_id = %s
                              AND ((id_seccion =$permitido ) OR (id_seccion= $permitido2))",GetSQLValueString($id, "int"));
                                      $UsuariosAutorizados = mysqli_query($con,  $query_UsuariosAutorizados) or die(mysqli_error($con));
                                      $row_UsuariosAutorizados = mysqli_fetch_assoc($UsuariosAutorizados);
                                      $totalRows_UsuariosAutorizados = mysqli_num_rows($UsuariosAutorizados);


  mysqli_free_result($UsuariosAutorizados);
  return $row_UsuariosAutorizados["usuario_id"];
}


function  obtenerSiglasUsuarioImprime ($id)
{
  global $con;
 

$query_UsuariosAutorizados = sprintf("SELECT *
                              FROM usuarios
                              WHERE usuario_id = %s",GetSQLValueString($id, "int"));
                                      $UsuariosAutorizados = mysqli_query($con,  $query_UsuariosAutorizados) or die(mysqli_error($con));
                                      $row_UsuariosAutorizados = mysqli_fetch_assoc($UsuariosAutorizados);
                                      $totalRows_UsuariosAutorizados = mysqli_num_rows($UsuariosAutorizados);


  mysqli_free_result($UsuariosAutorizados);
  return $row_UsuariosAutorizados["usuario"];
}


/******************** WCG1 ****** NUEVA FUNCION PARA COMPROBAR A LA JEFATURA ************************/
function obtenerJefatura ($id)
{
  global $con;

$query_UsuariosAutorizados = sprintf("SELECT * 
   FROM   
          usuarios 
         
    WHERE 
        usuarios.nivel= 4 and  usuario_id =%s ",GetSQLValueString($id, "int"));
                                      $UsuariosAutorizados = mysqli_query($con,  $query_UsuariosAutorizados) or die(mysqli_error($con));
                                      $row_UsuariosAutorizados = mysqli_fetch_assoc($UsuariosAutorizados);
                                      $totalRows_UsuariosAutorizados = mysqli_num_rows($UsuariosAutorizados); 


  mysqli_free_result($UsuariosAutorizados);
  return $row_UsuariosAutorizados["usuario_id"];
}

/******************** WCG1 ****** NUEVA FUNCION PARA COMPROBAR A LA JEFATURA ************************/

?>
