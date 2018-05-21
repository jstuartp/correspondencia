<?php require_once('../Connections/conexion.php'); 
RestringirAcceso("0, 1, 10,11");?> <!-- accesso -->
<?php 


$oficio_Asignar = $_GET ['oficio_id']; 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {



if (isset ( $_POST['chkusuarios'])) 
{

  $usuarios= $_POST['chkusuarios'];


 
 for ($i= 0; $i < count ($usuarios); $i++){

  echo $usuarios;  

  $insertSQL = sprintf("INSERT INTO oficios_usuario (id_oficioin, observacion, usuario_id, id_estado,  fecha_asignado) VALUES ( %s, %s,". $usuarios[$i].", 1, %s)",
                       
                       GetSQLValueString($oficio_Asignar),
                       GetSQLValueString($_POST['observacion'], "text"),
                  //     GetSQLValueString($_POST['usuario_id'], "int"),
                       GetSQLValueString($_POST['id_estado'], "int"),
                       GetSQLValueString($_POST['fecha_asignado'], "date"));

  
  $Result1 = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));


  $insertGoTo = "../detalle_oficio_in.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

}
}
//SELECT PARA OBTENER LOS NOMBRE Y DATOS DE LOS USUARIOS DEL SISTEMA
//Copyright Wálter Céspedes G 2015


//$query_DatosUsuarios= sprintf("SELECT * FROM usuarios ");

$query_DatosUsuarios= sprintf("SELECT * from usuarios where usuario_id not in 
(SELECT usuario_id from oficios_usuario where oficios_usuario.id_oficioin= ".GetSQLValueString($_GET['oficio_id'], "int").") ORDER BY nombre");
$DatosUsuarios = mysqli_query($con,  $query_DatosUsuarios) or die(mysqli_error($con));
$row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios);
$totalRows_DatosUsuarios = mysqli_num_rows($DatosUsuarios);

//FINAL DE LA PARTE SUPERIOR





?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php include("institucion.php"); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script>

function seleccionar_todo(){
  for (i=0;i<document.form1.elements.length;i++)
    if(document.form1.elements[i].type == "checkbox")  
      document.form1.elements[i].checked=1
}
function deseleccionar_todo(){
  for (i=0;i<document.form1.elements.length;i++)
    if(document.form1.elements[i].type == "checkbox")  
      document.form1.elements[i].checked=0
}
</script>
 
  </head>
  <body >


    <div class="wrapper">

      <?php echo $oficio_Asignar; ?>


      <div class="row">
          <div class="col-md-4"> 

                <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                  <table align="center">
                                    
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Observacion:</td>
                      <td><input type="text" name="observacion" value="" size="32" /></td>
                    </tr>

 <?php 
 
    if ($totalRows_DatosUsuarios > 0) {  
       do { ?>
                      <div class="checkbox">
                        <label>
                          <input name="chkusuarios[]" type="checkbox" id="checkbox"  value="<?php echo $row_DatosUsuarios['usuario_id'];?>" > <?php echo $row_DatosUsuarios['nombre']." ". $row_DatosUsuarios['apellido1'];?>
                        </label>
                      </div>
<?php  } while ($row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios));  


} 
    else
     { //MOSTRAR SI NO HAY RESULTADOS ?>
                No hay usuarios para mostrar
                <?php } 
 ?>
            
       
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Fecha_asignado:</td>
                      <td><input type="text" name="fecha_asignado" value="" size="32" /></td>
                    </tr>

  <!-- pruebas borrar sino sirven-->




  <!-- final pruebas borrar sino sirven-->
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">&nbsp;</td>
                      <td><input type="submit" value="Insertar registro" /></td>
                    </tr>

                    <br> 

                  </table>
                  <input type="hidden" name="MM_insert" value="form1" />
                  <br>
<br>
<a href="javascript:seleccionar_todo()">Marcar todos</a> | 
<a href="javascript:deseleccionar_todo()">Marcar ninguno</a> 
                </form>
            </div>

    </div> <!-- fin de row-->

     
<hr/>

    </div><!-- ./wrapper -->
 </body>
    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- page script -->
  
  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA

?>

