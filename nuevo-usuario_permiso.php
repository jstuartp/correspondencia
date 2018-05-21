<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php 



$query_DatosOficios = sprintf("SELECT * 
                                      FROM usuarios_autorizados, usuarios 
                                       WHERE 
          usuarios_autorizados.id_usuario = usuarios.usuario_id ORDER BY id_usuario DESC " );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);


/****************** SQL PARA OBTENER LOS USUARIOS *****************/

$query_DatosUsuarios = sprintf("SELECT * FROM usuarios WHERE estado_usuario = 1 and usuario_id NOT IN (SELECT id_usuario
     FROM usuarios_autorizados WHERE estado_autorizado = 1) ORDER BY usuario ASC" );
                                $DatosUsuarios = mysqli_query($con,  $query_DatosUsuarios) or die(mysqli_error($con));
                                $row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios);
                                $totalRows_DatosUsuarios = mysqli_num_rows($DatosUsuarios);

/****************** SQL PARA OBTENER LOS USUARIOS *****************/


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "nuevonivel")) {


  $insertSQL = sprintf("INSERT INTO usuarios_autorizados (id_usuario, estado_autorizado) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_usuario'], "int"), 
                       GetSQLValueString($_POST['estado_autorizado'], "int"));

  
  $Result1 = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));


  $insertGoTo = "nuevo-usuario_permiso.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $config['titulo_del_sitio']; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
     <!-- CSS PARA LOS SCRIPTS DE LOS FORMULARIOS -->
     <link rel="stylesheet" href="css/extra.css">

    
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <?php include ("includes/el_logo.php"); ?>  <!-- llamado al logo o información para personalizar el nombre dle sitio WCG-->
        
        <!-- Header Navbar: style can be found in header.less -->
        
        <?php include ("includes/menu_header.php");?> <!-- llamado al menu del header principal -->
       <!-- Header Navbar: style can be found in header.less -->

      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include("includes/menu_izq.php"); ?>   <!-- LLAMADO DEL MENU IZQUIERDA WCG -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Área de TI | Administración de sitio
            <?php echo $config['nombre_institucion'];?>   <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
         
            <li class="active">Permisos usuarios para ver oficios</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Cambio permisos usuarios para ver y eliminar oficios</h3>
                </div><!-- /.box-header -->
                
              <div class="col-xl-12">
                    <div class="box box-solid box-primary">
                      <div class="box-header">
                        <h3 class="box-title">Formulario para insertar usuario con permisos para ver y eliminar oficios</h3>
                      </div><!-- /.box-header -->
                      <div class="box-body">
                       

                       <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="nuevonivel" id="nuevonivel" onSubmit="javascript:return validaralta();">
 <!-- ALERT PARA INDICAR QUE CAMPO NO DEBE ESTAR VACIO WCG -->
                          
                              <div class="form-group">
                                <label for="descripcion" class="col-md-2 control-label">Usuario</label>
                                <div class="col-sm-10">
                                <select class="form-control"  id="id_usuario" name="id_usuario" >
                                  <?php
                                  if ($totalRows_DatosUsuarios > 0) {  
                                  
                                    do { ?>
                                  <option value="<?php echo $row_DatosUsuarios['usuario_id']; ?>"><?php echo $row_DatosUsuarios['usuario']. " | " .$row_DatosUsuarios['nombre']. " ". $row_DatosUsuarios['apellido1']; ?></option>
                                  
                                  <?php } while ($row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios)); 
                                       } ?>
                                  
                                </select>

                                  </br> </br>   
                              </div>                                                
                                     <div class="alert alert-danger oculto " role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span>El usuario no debe estar vacío</div>                

                             <input type="hidden" name="MM_insert" value="nuevonivel" />
                             <input type="hidden" name="estado_autorizado" id="estado_autorizado" value="1"/>
                            
                               <button type="submit" value="Insertar Oficio" class="btn btn-primary">Insertar</button>

                     
                      </form>
                      </div><!-- /.box-body -->
                    </div><!-- /.box -->
                 </div>
                <div class="box-body col-xl-12">
                  <div class="bs-example" data-example-id="contextual-table"> 
                    <table class="table"> 
                                          <thead> 
                                            <tr> 
                                              <th>Usuario ID</th> 
                                              
                                              <th>Usuario</th>
                                              <th>Nombre Apellidos</th>
                                               <th>Nivel</th>
                                              <th>Estado Usuario</th>
                                              <th>Eliminar</th> 
                                            
                                            </tr> 
                                          </thead> 

                        <?php 
                       
                        if ($totalRows_DatosOficios > 0) {  
                           do {  ?>
                                          <tbody> 
                                          

                                          <tr class="info"> 

                                          <th scope="row"><?php echo $row_DatosOficios["id_usuario"]; ?></th> 
                                          <th scope="row"><?php echo $row_DatosOficios["usuario"]; ?></th> 
                                          <th scope="row"><?php echo $row_DatosOficios["nombre"]. "  ". $row_DatosOficios["apellido1"]. " ". $row_DatosOficios["apellido2"]; ?></th>
                                          <th scope="row"><?php echo obtenerNivelUsuario ($row_DatosOficios["id_usuario"] ) ; ?></th> 
                                          <td>
                                          <?php 
                                          $estado_usuario = $row_DatosOficios["estado_autorizado"];
                                         
                                          if ($estado_usuario == 1) 
                                          {

                                            echo "autorizado"; 
                                          } else

                                          if ($estado_usuario == 0) 
                                          {

                                            echo "denegado"; 
                                          }



                                          ?>
                                            
                                          </td> 

                                          <td><a href="borrar_usuario_autorizado.php?id_autorizado=<?php echo $row_DatosOficios['id_autorizado']; ?>"><div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-eraser"></i></div></a></td>

                                         

                                          </tr> 

                                           </tbody> 

                      <?php 
                                            } while ($row_DatosOficios = mysqli_fetch_assoc($DatosOficios)); 
                         } 
                        else
                         { //MOSTRAR SI NO HAY RESULTADOS ?>
                                    No hay resultados.
                                    <?php } ?>


                    </table> 

                  </div>
                   
                </div><!-- /.box-body -->

                
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
    
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>

    <!-- page script -->
    <script>

function validaralta()
{
  valid = true;
  $("#aviso1").hide("slow");
  
  
  //COLORES
  if (document.nuevonivel.id_usuario.value == ""){
    $("#aviso1").show("slow");
      valid = false;
  }
  


  return valid;
}
</script>



  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosOficios);
?>
