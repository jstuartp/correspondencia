<?php

require_once('Connections/conexion.php'); 
require_once('DAO_enviados_old.php'); 

$id= $_GET['id'];

$_DAOEnviadosOld = new DAO_enviados_old();

$contenido = $_DAOEnviadosOld->GetArchivoEnviadoOldById($id);
$path = "imagenes/enviadas_old/FM-1-2018, MEDICINA, ACLARACIONES PCGS DR. MAXMILIANO MOREIRA.doc";


header("Content-Type: application/octet-stream");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename= FM-1-2018, MEDICINA, ACLARACIONES PCGS DR. MAXMILIANO MOREIRA.doc"); 

readfile($path);

//echo $contenido['archivo']; 



