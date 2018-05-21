<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php 

$el_usuario = GetSQLValueString ($_GET['usuario_id'], "int");


/******************* SQL PARA DESPLEGAR LOS USUARIOS QUE ESTAN EN EL SISTEMA *************/
$query_DatosOficios = sprintf("SELECT * , 
                                secciones.descripcion as descrip_seccion, 
                                niveles.descripcion as descrip_nivel, 
                                estado_usuario.descripcion as estado_descripcion
                                FROM usuarios, secciones, niveles, estado_usuario
                                WHERE usuarios.id_seccion = secciones.id_seccion and
                                      niveles.id_nivel = usuarios.nivel and
                                      usuarios.estado_usuario = estado_usuario.id_estado and
                                    usuarios.usuario_id = $el_usuario
                                ORDER BY usuario_id DESC" );
                                $DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
                                $row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
                                $totalRows_DatosOficios = mysqli_num_rows($DatosOficios);
/************************* SQL SIN FILTRO DE LOS USUARIOS EN EL SISTEMA **************************/

$query_DatosOficios1 = sprintf("SELECT * , 
                                secciones.descripcion as descrip_seccion, 
                                niveles.descripcion as descrip_nivel, 
                                estado_usuario.descripcion as estado_descripcion
                                FROM usuarios, secciones, niveles, estado_usuario
                                WHERE usuarios.id_seccion = secciones.id_seccion and
                                      niveles.id_nivel = usuarios.nivel and
                                      usuarios.estado_usuario = estado_usuario.id_estado 
                                ORDER BY usuario_id DESC" );
                                $DatosOficios1 = mysqli_query($con,  $query_DatosOficios1) or die(mysqli_error($con));
                                $row_DatosOficios1 = mysqli_fetch_assoc($DatosOficios1);
                                $totalRows_DatosOficios1 = mysqli_num_rows($DatosOficios1);


/********** SQL PARA OBTENER LAS SECCIONES ****************/

$query_DatosSecciones = sprintf("SELECT * FROM secciones, usuarios 
                                    WHERE secciones.id_seccion = usuarios.id_seccion and
                                          usuarios.usuario_id = $el_usuario " );
$DatosSecciones = mysqli_query($con,  $query_DatosSecciones) or die(mysqli_error($con));
$row_DatosSecciones = mysqli_fetch_assoc($DatosSecciones);
$totalRows_DatosSecciones = mysqli_num_rows($DatosSecciones);

/******************** SQL PARA OBTENER SECCION SIN FILTRO DE USUARIO *******************/
$query_DatosSecciones1 = sprintf("SELECT * FROM secciones ORDER BY descripcion ASC" );
$DatosSecciones1 = mysqli_query($con,  $query_DatosSecciones1) or die(mysqli_error($con));
$row_DatosSecciones1 = mysqli_fetch_assoc($DatosSecciones1);
$totalRows_DatosSecciones1 = mysqli_num_rows($DatosSecciones1);

/******************** FIN SQL PARA OBTENER SECCIONES SIN FILTRO DE USUARIO *******************/

/********** SQL PARA OBTENER LOS NIVELES****************/

$query_DatosNiveles = sprintf("SELECT * FROM niveles, usuarios
                              WHERE niveles.id_nivel = usuarios.nivel and
                               usuarios.usuario_id= $el_usuario" );
$DatosNiveles = mysqli_query($con,  $query_DatosNiveles) or die(mysqli_error($con));
$row_DatosNiveles = mysqli_fetch_assoc($DatosNiveles);
$totalRows_DatosNiveles = mysqli_num_rows($DatosNiveles);

/************ SQL SIN FILTRO PARA OBTENER LOS  NIVELES ********************************/
$query_DatosNiveles1 = sprintf("SELECT * FROM niveles ORDER BY descripcion ASC" );
$DatosNiveles1 = mysqli_query($con,  $query_DatosNiveles1) or die(mysqli_error($con));
$row_DatosNiveles1 = mysqli_fetch_assoc($DatosNiveles1);
$totalRows_DatosNiveles1 = mysqli_num_rows($DatosNiveles1);

/****************** SQL PARA INSERCIÓN DE NUEVOS NIVELES WCG *****************/

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "nuevonivel")) {

                          
    $updateSQL= sprintf("UPDATE usuarios SET nombre=%s, apellido1=%s, apellido2=%s, nivel=%s, usuario=%s, pass=%s, email=%s, id_seccion=%s, estado_usuario=%s,  avatar=%s WHERE usuario_id= $el_usuario",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido1'], "text"),
                       GetSQLValueString($_POST['apellido2'], "text"),
                       GetSQLValueString($_POST['nivel'], "int"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString(md5($_POST['pass']), "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['id_seccion'], "int"),
                       GetSQLValueString($_POST['estado_usuario'], "int"),
                       GetSQLValueString($_POST['avatar'], "text"));

  
  $Result1 = mysqli_query($con,   $updateSQL) or die(mysqli_error($con));


  $insertGoTo = "nuevo-usuario.php";
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
            <?php echo $config['nombre_institucion'];?>  <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
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
                  <h3 class="box-title">Modificar usuario</h3>
                </div><!-- /.box-header -->
                
 <div class="col-md-12">
                    <div class="box box-solid box-primary">
                      <div class="box-header">
                        <h3 class="box-title">Formulario para modificar usuarios</h3>
                      </div><!-- /.box-header -->
                      <div class="box-body">
                       

                       <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="nuevonivel" id="nuevonivel" onSubmit="javascript:return validaralta();">
 <!-- ALERT PARA INDICAR QUE CAMPO NO DEBE ESTAR VACIO WCG -->
                          
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row_DatosOficios['nombre']; ?>" >
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span> El nombre no debe estar vacío
                              </div>

                              <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Apellido 1</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?php echo $row_DatosOficios['apellido1']; ?>">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso2"><span class="glyphicon glyphicon-remove" ></span> El apellido no debe estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->   

                               <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Apellido 2</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?php echo $row_DatosOficios['apellido2']; ?>">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso3"><span class="glyphicon glyphicon-remove" ></span> El apellido no debe estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->     

                              <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                            

                              <div class="form-group">
                                 
                                  <label for="descripcion" class="col-sm-2 control-label">Nivel </label>
                                  <div class="col-sm-10">

                                   
                                <select class="form-control"  id="nivel" name="nivel"  >
                                  <?php
                                  if ($totalRows_DatosNiveles1 > 0) {  
                                do { 
                                  
                                     if ( $row_DatosNiveles1['id_nivel']== $row_DatosNiveles['id_nivel'] ):
                                      ?>                                  
                                        <option style="font-weight:bold" selected="selected" value="<?php echo $row_DatosNiveles['id_nivel']; ?>"><?php echo $row_DatosNiveles1['descripcion']; ?></option>
                                       <?php else: ?>   

                                      <option value="<?php echo $row_DatosNiveles1['id_nivel']; ?>"><?php echo $row_DatosNiveles1['descripcion']; ?></option>
                                            
                                      <?php endif; ?>                                                             
                                     <?php } while ($row_DatosNiveles1 = mysqli_fetch_assoc($DatosNiveles1)); 
                                      
                                      } 

                                      ?>
                                  
                                </select>
                                </div>
                                 </br>    
                                </div>

                              <div class="alert alert-danger oculto " role="alert" id="aviso4"><span class="glyphicon glyphicon-remove" ></span> El nivel no debe estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->    

                               <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                              
  </br>    

                                <div class="form-group">
                                   
                                  <label for="descripcion" class="col-sm-2 control-label">Secciones </label>

                                  <div class="col-sm-10">
                                   

                                <select class="form-control"  id="id_seccion" name="id_seccion" >
                                  <?php
                                  if ($totalRows_DatosSecciones1 > 0) {  
                                 do { 

                                  if ( $row_DatosSecciones1['id_seccion']== $row_DatosSecciones['id_seccion'] ):
                                      ?>                                  
                                        <option style="font-weight:bold" selected="selected" value="<?php echo $row_DatosSecciones['id_seccion']; ?>"><?php echo $row_DatosSecciones1['descripcion']; ?></option>
                                       <?php else: ?>   

                                      <option value="<?php echo $row_DatosSecciones1['id_seccion']; ?>"><?php echo $row_DatosSecciones1['descripcion']; ?></option>
                                            
                                      <?php endif; ?>                                                             
                                     <?php } while ($row_DatosSecciones1 = mysqli_fetch_assoc($DatosSecciones1)); 
                                      
                                      } 

                                      ?>
                                  
                                  
                                </select>
                                </div>
                                 </br>       
                                </div>

                              <div class="alert alert-danger oculto " role="alert" id="aviso5"><span class="glyphicon glyphicon-remove" ></span> La sesión no debe estar vacía</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->    

                            

                               <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                                </br> 
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Usuario</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $row_DatosOficios['usuario']; ?>" >
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso6"><span class="glyphicon glyphicon-remove" ></span> El usuario no debe estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->   
                            

                             <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Contraseña</label>
                                <div class="col-sm-10">
                                  <input type="password" class="form-control" id="pass" name="pass" value="<?php echo $row_DatosOficios['pass']; ?>" >
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso8"><span class="glyphicon glyphicon-remove" ></span> La contraseña no debe estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->   



                              <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                  <input type="email" class="form-control" id="email" name="email" value="<?php echo $row_DatosOficios['email']; ?>">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso7"><span class="glyphicon glyphicon-remove" ></span> El correo no debe estar vacio</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->   

                                <div class="form-group">
                                  <label for="descripcion" class="col-sm-2 control-label">Estado Usuario</label>
                                  <div class="col-sm-10">
                                <select multiple class="form-control"  id="estado_usuario" name="estado_usuario" >
                                  <option value="1"> Activo</option>
                                  <option value="0">Inactivo</option>
                                  
                                </select>
                                </div>
                                </br>     </br>  
                                </div>

                            <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                             
                                <div class="form-group">
                                  
                                  <label for="descripcion" class="col-sm-2 control-label">Avatar</label>
                                  <div class="col-sm-10">
                               
                                  
                                 <select multiple class="form-control" name="avatar" id="avatar">
                                  <option value="hombre.jpg">Hombre</option>
                                  <option value="mujer.jpg">Mujer</option>
                                 </select>
                                                                  
                                </div>
                                </div>


                              <div class="alert alert-danger oculto " role="alert" id="aviso9"><span class="glyphicon glyphicon-remove" ></span> El avatar no puede estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->   

                             <input type="hidden" name="MM_insert" value="nuevonivel" />
                            

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
  $("#aviso7").hide("slow");
  $("#aviso8").hide("slow");
   $("#aviso8").hide("slow");
  
  
  //COLORES
  if (document.nuevonivel.nombre.value == ""){
    $("#aviso1").show("slow");
      valid = false;
  }

  if (document.nuevonivel.apellido1.value == ""){
    $("#aviso2").show("slow");
      valid = false;
  }

  if (document.nuevonivel.apellido2.value == ""){
    $("#aviso3").show("slow");
      valid = false;
  }
  
  if (document.nuevonivel.nivel.value == ""){
    $("#aviso4").show("slow");
      valid = false;
  }

if (document.nuevonivel.id_seccion.value == ""){
    $("#aviso5").show("slow");
      valid = false;
  }

  if (document.nuevonivel.usuario.value == ""){
    $("#aviso6").show("slow");
      valid = false;
  }

   if (document.nuevonivel.email.value == ""){
    $("#aviso7").show("slow");
      valid = false;
  }

   if (document.nuevonivel.pass.value == ""){
    $("#aviso8").show("slow");
      valid = false;
  }

  if (document.nuevonivel.avatar.value == ""){
    $("#aviso9").show("slow");
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
mysqli_free_result($DatosSecciones);
mysqli_free_result($DatosNiveles);
?>
