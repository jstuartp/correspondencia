<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php 

/******************* SQL PARA DESPLEGAR LOS USUARIOS QUE ESTAN EN EL SISTEMA *************/
$query_DatosOficios = sprintf("SELECT * , 
                                secciones.descripcion as descrip_seccion, 
                                niveles.descripcion as descrip_nivel, 
                                estado_usuario.descripcion as estado_descripcion
                                FROM usuarios, secciones, niveles, estado_usuario
                                WHERE usuarios.id_seccion = secciones.id_seccion and
                                      niveles.id_nivel = usuarios.nivel and
                                      usuarios.estado_usuario = estado_usuario.id_estado
                                ORDER BY nombre ASC" );
                                $DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
                                $row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
                                $totalRows_DatosOficios = mysqli_num_rows($DatosOficios);


/********** SQL PARA OBTENER LAS SECCIONES ****************/

$query_DatosSecciones = sprintf("SELECT * FROM secciones ORDER BY descripcion ASC" );
$DatosSecciones = mysqli_query($con,  $query_DatosSecciones) or die(mysqli_error($con));
$row_DatosSecciones = mysqli_fetch_assoc($DatosSecciones);
$totalRows_DatosSecciones = mysqli_num_rows($DatosSecciones);

/********** SQL PARA OBTENER LOS NIVELES****************/

$query_DatosNiveles = sprintf("SELECT * FROM niveles ORDER BY descripcion ASC" );
$DatosNiveles = mysqli_query($con,  $query_DatosNiveles) or die(mysqli_error($con));
$row_DatosNiveles = mysqli_fetch_assoc($DatosNiveles);
$totalRows_DatosNiveles = mysqli_num_rows($DatosNiveles);


/****************** SQL PARA INSERCIÓN DE NUEVOS NIVELES WCG *****************/

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "nuevonivel")) {


  $insertSQL = sprintf("INSERT INTO usuarios (nombre, apellido1, apellido2, nivel, usuario, pass, email, id_seccion, estado_usuario, avatar) VALUES (%s, %s,%s,%s,%s,%s,%s,%s,%s, %s)",
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

  
  $Result1 = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));


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
            <?php echo $config['nombre_institucion'];?>   <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
         
            <li class="active">Nuevo Usuario</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Insertar nuevo usuario</h3>
                </div><!-- /.box-header -->
                
                  <div class="col-xl-12">
                    <div class="box box-solid box-primary">
                      <div class="box-header">
                        <h3 class="box-title">Formulario para insertar nuevo usuario</h3>
                      </div><!-- /.box-header -->
                      <div class="box-body">
                       

                       <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="nuevonivel" id="nuevonivel" onSubmit="javascript:return validaralta();">
 <!-- ALERT PARA INDICAR QUE CAMPO NO DEBE ESTAR VACIO WCG -->
                          
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span> El nombre no debe estar vacío
                              </div>

                              <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Apellido 1</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="apellido1" name="apellido1" placeholder="Apellido 1">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso2"><span class="glyphicon glyphicon-remove" ></span> El apellido no debe estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->   

                               <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Apellido 2</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="apellido2" name="apellido2" placeholder="Apellido 2">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso3"><span class="glyphicon glyphicon-remove" ></span> El apellido no debe estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->     

                              <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                            

<div class="form-group">
                                  <label for="descripcion" class="col-sm-2 control-label">Nivel </label>
                                  <div class="col-sm-10">
                                <select class="form-control"  id="nivel" name="nivel" >
                                  <?php
                                  if ($totalRows_DatosNiveles > 0) {  
       do { ?>
                                  <option value="<?php echo $row_DatosNiveles['id_nivel']; ?>"><?php echo $row_DatosNiveles['descripcion']; ?></option>
                                  
<?php } while ($row_DatosNiveles = mysqli_fetch_assoc($DatosNiveles)); 
     } ?>
                                  
                                </select>
                                </div>
                                 </br>     </br> 
                                </div>

                              <div class="alert alert-danger oculto " role="alert" id="aviso4"><span class="glyphicon glyphicon-remove" ></span> El nivel no debe estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->    

                               <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                              


                                <div class="form-group">
                                  <label for="descripcion" class="col-sm-2 control-label">Secciones </label>
                                  <div class="col-sm-10">
                                <select class="form-control"  id="id_seccion" name="id_seccion" >
                                  <?php
                                  if ($totalRows_DatosSecciones > 0) {  
       do { ?>
                                  <option value="<?php echo $row_DatosSecciones['id_seccion']; ?>"><?php echo $row_DatosSecciones['descripcion']; ?></option>
                                  
<?php } while ($row_DatosSecciones = mysqli_fetch_assoc($DatosSecciones)); 
     } ?>
                                  
                                </select>
                                </div>
                                 </br>     </br> 
                                </div>




                              <div class="alert alert-danger oculto " role="alert" id="aviso5"><span class="glyphicon glyphicon-remove" ></span> La sesión no debe estar vacía</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->    

                            

                               <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Usuario</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso6"><span class="glyphicon glyphicon-remove" ></span> El usuario no debe estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->   
                            

                             <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Contraseña</label>
                                <div class="col-sm-10">
                                  <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso8"><span class="glyphicon glyphicon-remove" ></span> El usuario no debe estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->   



                              <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                  <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                                  </br>     </br>   
                              </div>                                                
                              <div class="alert alert-danger oculto " role="alert" id="aviso7"><span class="glyphicon glyphicon-remove" ></span> El correo no debe estar vacio</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->   


                            <!-- INICIO DE FORM GROUP PARA INSERTAR DATOS -->
                             
                                <div class="form-group">
                                  <label for="descripcion" class="col-sm-2 control-label">Avatar</label>
                                  <div class="col-sm-10">
                                <select class="form-control"  id="avatar" name="avatar" >
                                  <option value="hombre.jpg"> Hombre</option>
                                  <option value="mujer.jpg">Mujer.jpg</option>
                                  
                                </select>
                                </div>
                                </div>


                              <div class="alert alert-danger oculto " role="alert" id="aviso9"><span class="glyphicon glyphicon-remove" ></span> El avatar no puede estar vacío</div>

                              <!-- FIN DE FORM GROUP PARA INSERTAR DATOS -->   

                             <input type="hidden" name="MM_insert" value="nuevonivel" />
                             <input type="hidden" name="estado_usuario" id="estado_usuario" value="1"/>

                               <button type="submit" value="Insertar Oficio" class="btn btn-primary">Insertar</button>

                     
                      </form>
                      </div><!-- /.box-body -->
                    </div><!-- /.box -->
                 </div>

                 
                <div class="box-body col-md-12">
                  <div class="bs-example" data-example-id="contextual-table"> 
                    <table class="table"> 
                                          <thead> <tr> <th>ID usuario</th> <th>Nombre</th>  <th>Nivel</th>  <th>Sección</th>  <th>Usuario</th>  <th>Email</th>  <th>Estado</th>  <th>Avatar</th> <th>Modificar</th></tr> 
                                          </thead> 

                    <?php 
                        //AQUI ES DONDE SE SACAN LOS DATOS, SE COMPRUEBA QUE HAY RESULTADOS
                        if ($totalRows_DatosOficios > 0) {  
                           do {  ?>
                                          <tbody> 
                                          

                                          <tr class="info"> <th scope="row"><?php echo $row_DatosOficios["usuario_id"]; ?></th> 
                                            <td><?php echo $row_DatosOficios["nombre"]." ". $row_DatosOficios['apellido1']. " " . $row_DatosOficios['apellido2']; ?></td>  
                                            <td><?php echo $row_DatosOficios["descrip_nivel"]; ?></td>
                                            <td><?php echo $row_DatosOficios["descrip_seccion"]; ?></td>
                                            <td><?php echo $row_DatosOficios["usuario"];?></td>
                                            <td><?php echo $row_DatosOficios["email"];?></td>
                                            <td>
                                              <?php if ($row_DatosOficios["estado_usuario"]==0 )
                                              { ?>
                                              <span class="label label-danger"><?php echo $row_DatosOficios["estado_descripcion"];?></span>

                                                <?php } else { ?>
                                                <span class="label label-success">Activo</span> <?php
                                              } ?>
                                              

                                            </td>


                                            <td><img src="imagenes/avatar_usuarios/<?php echo $row_DatosOficios["avatar"];?>" height="40px" width="40px" class="img-circle" alt="User Image"></td>

                                          

                                            <td><a href="modificar-usuario.php?usuario_id=<?php echo $row_DatosOficios['usuario_id']; ?>"><div class="col-md-3 col-sm-4"><i class="glyphicon glyphicon-wrench"></i> </div></a></td>

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
