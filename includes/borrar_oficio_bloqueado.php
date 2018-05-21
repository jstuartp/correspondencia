<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10");?> <!-- accesso -->

<?php

$el_oficio = $_POST ['oficio_id']; 
$el_usuario = $_POST ['usuario_id']; 


global $con;
  $query_Delete = "DELETE FROM oficios_bloqueados WHERE oficio_id=$el_oficio and usuario_id= $el_usuario ";
  //echo $query_Delete;
    $ConsultaFuncion = mysqli_query($con, $query_Delete) or die(mysqli_error($con));

?>