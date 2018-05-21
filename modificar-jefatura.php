<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php 

$la_jefatura = $_GET['id_jefatura'];


/******************* SQL PARA DESPLEGAR LOS USUARIOS QUE ESTAN EN EL SISTEMA *************/
$query_DatosOficios = sprintf("SELECT * FROM jefaturas WHERE id_jefatura= $la_jefatura ORDER BY id_jefatura DESC " );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "mod_jefatura")) {

                          
    $updateSQL= sprintf("UPDATE jefaturas SET nombre=%s, 
                                                apellido1=%s,
                                                apellido2=%s,
                                                puesto=%s,
                                                grado_academico=%s,
                                                activo=%s
                                              
                                              WHERE id_jefatura= $la_jefatura",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido1'], "text"),
                       GetSQLValueString($_POST['apellido2'], "text"),
                       GetSQLValueString($_POST['puesto'], "text"),
                       GetSQLValueString($_POST['grado_academico'], "text"),
                       GetSQLValueString($_POST['activo'], "int"));

  
  $Result1 = mysqli_query($con,   $updateSQL) or die(mysqli_error($con));


  $insertGoTo = "nueva-jefatura.php";
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
              <li><a href="nueva-jefatura.php"><i class="fa fa-dashboard"></i> Nueva Jefatura</a></li>
         
            <li class="active">Modifica Jefatura</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Modificar Jefatura</h3>
                </div><!-- /.box-header -->
                
                    <div class="col-md-12">
                    <div class="box box-solid box-primary">
                      <div class="box-header">
                        <h3 class="box-title">Formulario para modificar sección</h3>
                      </div><!-- /.box-header -->
                      <div class="box-body">
                       
                      <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="mod_jefatura" id="mod_jefatura" onSubmit="javascript:return validaralta();">
                       <!-- ALERT PARA INDICAR QUE CAMPO NO DEBE ESTAR VACIO WCG -->
                          
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $row_DatosOficios['nombre']; ?>">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span> El nombre no debe estar vacío
                              </div>

                             
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Apellido 1</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="apellido1" name="apellido1" placeholder="Apellido 1" value="<?php echo $row_DatosOficios['apellido1']; ?>">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso2"><span class="glyphicon glyphicon-remove" ></span> El apellido1 no debe estar vacío</div>

                            

                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Apellido 2</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="apellido2" name="apellido2" placeholder="Apellido 2" value="<?php echo $row_DatosOficios['apellido2']; ?>">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso3"><span class="glyphicon glyphicon-remove" ></span> El apellido2 no debe estar vacío</div>
                              

                                <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Puesto</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="puesto" name="puesto" placeholder="Puesto" value="<?php echo $row_DatosOficios['puesto']; ?>">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso4"><span class="glyphicon glyphicon-remove" ></span> El puesto debe estar vacío</div>

                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Grado Académico</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="grado_academico" name="grado_academico" placeholder="Grado Académico" value="<?php echo $row_DatosOficios['grado_academico']; ?>">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso5"><span class="glyphicon glyphicon-remove" ></span> El grado académico no debe estar vacío</div>

                              <div class="form-group">
                                  <label for="descripcion" class="col-sm-2 control-label">Estado Usuario</label>
                                  <div class="col-sm-10">
                                

                                <select multiple class="form-control"  id="activo" name="activo" >
                                  <option value="1"> Activo</option>
                                  <option value="0">Inactivo</option>
                                  
                                </select>
                                </div>
                                  </br>     </br>    </br>     </br>  
                                <div class="alert alert-danger oculto " role="alert" id="aviso6"><span class="glyphicon glyphicon-remove" ></span> El estado de usuario no debe estar vacío</div>

                                </br>     </br>  
                                </div>

                               <input type="hidden" name="MM_insert" value="mod_jefatura" />                   
                            
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
  $("#aviso2").hide("slow");
  $("#aviso3").hide("slow");
  $("#aviso4").hide("slow");
  $("#aviso5").hide("slow");
  $("#aviso6").hide("slow");

  
  
  //COLORES
  if (document.mod_jefatura.nombre.value == ""){
    $("#aviso1").show("slow");
      valid = false;
  }

  if (document.mod_jefatura.apellido1.value == ""){
    $("#aviso2").show("slow");
      valid = false;
  }

  if (document.mod_jefatura.apellido2.value == ""){
    $("#aviso3").show("slow");
      valid = false;
  }
  
  if (document.mod_jefatura.puesto.value == ""){
    $("#aviso4").show("slow");
      valid = false;
  }

if (document.mod_jefatura.grado_academico.value == ""){
    $("#aviso5").show("slow");
      valid = false;
  }

  if (document.mod_jefatura.activo.value == ""){
    $("#aviso6").show("slow");
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
