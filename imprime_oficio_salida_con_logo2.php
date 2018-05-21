<?php require_once('Connections/conexion.php');
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");

$numero_oficio = GetSQLValueString ($_GET['oficio_id'], "int");

/*************** sql para obtener las jefaturas las cuales firmarán el oficio salida */

$query_DatosDestinatarios = sprintf("SELECT * from  jefaturas, info_oficios
					WHERE jefaturas.id_jefatura = info_oficios.id_jefatura and
					info_oficios.oficio_id =  $numero_oficio " );
$DatosDestinatarios = mysqli_query($con,  $query_DatosDestinatarios) or die(mysqli_error($con));
$row_DatosDestinatarios = mysqli_fetch_assoc($DatosDestinatarios);
$totalRows_DatosDestinatarios = mysqli_num_rows($DatosDestinatarios);

/*************** sql para obtener las jefaturas las cuales firmarán el oficio salida */

$dia= date("j");
$dias= array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
$meses= array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","setiembre","octubre","noviembre","diciembre");
$anno= date("Y");

$query_ImprimeOficioSalida = ("SELECT *
                                FROM info_oficios
                                WHERE oficio_id = $numero_oficio");
$ImprimeOficioSalida = mysqli_query($con,  $query_ImprimeOficioSalida) or die(mysqli_error($con));
$row_ImprimeOficioSalida = mysqli_fetch_assoc($ImprimeOficioSalida);
$totalRows_ImprimeOficioSalida = mysqli_num_rows($ImprimeOficioSalida);
$nombre_institucion = $config['nomeclatura_dependencia'];
$anno_oficio = $row_ImprimeOficioSalida['anno'];

/***************** VARIBLES PARA CONFIGURACIÓN DEL PIE DE LA PÁGINA E IMAGENES ADICIONALES ****************/

$el_pie= $config['pie_del_oficio'];
$el_sitio = $config['sitio_web'];
$result="imagenes/logo_ucr.jpg";
$el_correo = $config['el_email'];
$archivo= "temporal/".$numero_oficio."-".$anno.".txt"; // el nombre de tu archivo
$el_texto =utf8_decode(

 "                                                                       ".$dias[date('w')]." ".$dia. " de " .$meses[date('n')-1]. " de ".date('Y'). " \n                                                                       ".$nombre_institucion." - ".$row_ImprimeOficioSalida['oficio_id1']." - ".$row_ImprimeOficioSalida['anno'].
 "\n\n". $row_ImprimeOficioSalida['destinatario'] . "\n\n" .                 $row_ImprimeOficioSalida['cuerpo_oficio']. "\n\n\n\n                                                                     ". $row_DatosDestinatarios['grado_academico']." ".$row_DatosDestinatarios['nombre']. " ".$row_DatosDestinatarios['apellido1'] . " " .$row_DatosDestinatarios['apellido2']. "\n" . "                                                                     ".$row_DatosDestinatarios['puesto']. "\n\n" . $row_ImprimeOficioSalida['cc_copia']. "\n"	);

$txt = strip_tags($el_texto);
$contenido= $txt; // Recibe los datos para el txt
str_replace('&nbsp',$el_texto, "");

$fch= fopen($archivo, "w"); // Abres el archivo para escribir en él
fwrite($fch, $contenido); // Grabas
fclose($fch); // Cierras el archivo.

ob_start();
  header("refresh: 1; url =".$config['direccion_server']."/imprime_oficio_salida_con_logo.php?oficio_id=$numero_oficio");

  echo 'Un momento por favor estamos generando el oficio...';

ob_end_flush();
?>
