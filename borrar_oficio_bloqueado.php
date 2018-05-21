<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10");?> <!-- accesso -->

<?php 

$el_oficio = $_GET ['oficio_id']; 

if (isset($_GET ['oficio_id']))
  {

  		$oficio_id= $_GET ['oficio_id']; 

$query_Delete =sprintf("DELETE FROM oficios_bloqueados 
                           WHERE oficio_id=$oficio_id");
                      

 $Result1     = mysqli_query($con, $query_Delete) or die(mysqli_error());      
 //$insertGoTo = "listado_oficios_entrada_jefatura.php";
 // header(sprintf("Location: %s", $insertGoTo));
  //mysqli_free_result($Result1);
  echo "SI SE ELIMINO CORRECTAMENTE EL OFICIO ";
}
?>




