<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php 

$la_seccion = GetSQLValueString ($_GET['id_seccion'], "int");


/******************* SQL PARA DESPLEGAR LOS USUARIOS QUE ESTAN EN EL SISTEMA *************/
$query_DatosOficios = sprintf("SELECT * FROM secciones WHERE id_seccion= $la_seccion ORDER BY id_seccion DESC " );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "nuevaseccion")) {

                          
    $updateSQL= sprintf("UPDATE secciones SET descripcion=%s, autorizado=%s WHERE id_seccion= $la_seccion",
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['autorizado'], "int"));

  
  $Result1 = mysqli_query($con,   $updateSQL) or die(mysqli_error($con));


  $insertGoTo = "nueva-seccion.php";
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
         
            <li class="active">Nuevo Nivel</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Modificar sección</h3>
                </div><!-- /.box-header -->
                
                    <div class="col-md-12">
                    <div class="box box-solid box-primary">
                      <div class="box-header">
                        <h3 class="box-title">Formulario para modificar sección</h3>
                      </div><!-- /.box-header -->
                      <div class="box-body">
                       
                      <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="nuevaseccion" id="nuevaseccion" onSubmit="javascript:return validaralta();">
                       <!-- ALERT PARA INDICAR QUE CAMPO NO DEBE ESTAR VACIO WCG -->
                          
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Descripción</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción" value="<?php echo $row_DatosOficios['descripcion']; ?>">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                                     <div class="alert alert-danger oculto " role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span>La descripción de la sección no debe estar vacia</div>  
                             
                            <div class="form-group">
                                  <label for="descripcion" class="col-sm-2 control-label">Modificar Permisos</label>
                             <div class="col-sm-10">
                              <select class="form-control col-sm-10" id="autorizado" name="autorizado" >
                                <option value="1">Autorizar</option>
                                <option value="0">Denegar</option>
                                
                              </select> 
                              </div>   
                               </div> 
                               <div class="alert alert-danger oculto " role="alert" id="aviso2"><span class="glyphicon glyphicon-remove" ></span>Autorización no debe estar vacia</div>         

                             <input type="hidden" name="MM_insert" value="nuevaseccion" />
                            
                               <button type="submit" value="Insertar Oficio" class="btn btn-primary">Insertar</button>

                     
                      </form>
                      </div><!-- /.box-body -->
                    </div><!-- /.box -->
                 </div>

               

               
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

  valid = true;
  $("#aviso2").hide("slow");
   
  
  //COLORES
  if (document.nuevaseccion.descripcion.value == ""){
    $("#aviso1").show("slow");
      valid = false;
  }

 
  if (document.nuevaseccion.autorizado.value == ""){
    $("#aviso2").show("slow");
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

mysqli_free_result($DatosOficios1);

?>
