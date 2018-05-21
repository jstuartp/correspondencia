<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php 

$el_oficio = $_GET ['oficio_id']; 

$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");

//$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE tipo_oficio=1 OR  tipo_oficio=2 AND  id_estado = 7 and oficio_id = $el_oficio ORDER BY info_oficios.oficio_id ASC" );

$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE (tipo_oficio=1 OR tipo_oficio=2) AND oficio_id = $el_oficio ORDER BY info_oficios.oficio_id ASC" );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);


/***************** fin sql para obtener los pdf que se muestra en pantalla ****************/

/**************** SQL PARA OBTENER LOS USUARIOS QUE HAN SIDO ASIGNADOS AL OFICIO ******************/

$query_Usuario_Asignado = sprintf("SELECT    *

                                      FROM 
                                              oficios_usuario, info_oficios 
                                      WHERE 
                                              info_oficios.oficio_id = oficios_usuario.id_oficioin and                                       
                                              info_oficios.oficio_id  = ".GetSQLValueString($_GET['oficio_id'], "int")." ORDER BY oficios_usuario.usuario_id DESC");
$Usuario_Asignado = mysqli_query($con,  $query_Usuario_Asignado) or die(mysqli_error($con));
$row_Usuario_Asignado = mysqli_fetch_assoc($Usuario_Asignado);
$totalRows_Usuario_Asignado = mysqli_num_rows($Usuario_Asignado);

/**************** FIN SQL PARA OBTENER LOS USUARIOS QUE HAN SIDO ASIGNADOS AL OFICIO ******************/

   $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") ) {
  
 

$insertSQL = sprintf("UPDATE info_oficios SET id_estado=%s, fecha_archivado=%s , ubicacion=%s, usuario_modifica=$el_usuario WHERE oficio_id= $el_oficio ",
                                       
                     GetSQLValueString($_POST['id_estado'], "int"),
                     GetSQLValueString($_POST['fecha_archivado'], "date"), 
                     GetSQLValueString($_POST['ubicacion'], "text"), 
                     GetSQLValueString($_POST['usuario_modifica'], "int"));

  //echo $insertSQL ." nombre: ". $row_DatosUsuarios['nombre']. "<br>" ; 
 //$row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios);
  $Result1 = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));
        

 $insertGoTo = "listado_oficios_por_archivar.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  
  header(sprintf("Location: %s", $insertGoTo));
}
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
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="css/extra.css">
  <!-- CSS PARA LOS SCRIPTS DE LOS FORMULARIOS -->
     <link rel="stylesheet" typr="text/css" href="css/bootstrap-datetimepicker.css">
    <!-- CSS PARA LOS SCRIPTS DE LOS FORMULARIOS -->
     <link rel="stylesheet" href="css/extra.css">

     <style type="text/css">

          .fa {
              display: inline-block;
              font: normal normal normal 14px/1 FontAwesome;
              font-size: inherit;
              text-rendering: auto;
              -webkit-font-smoothing: antialiased;
              -moz-osx-font-smoothing: grayscale;
          }
          .panel-profile-header{
              position: relative;
              /*border: 3px solid #DC1717;*/
              border-top-right-radius: 3px;
              border-top-left-radius: 3px;
        
              height: 115px;
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#cecece+0,777777+100&0+0,0.65+100 */
          background: -moz-linear-gradient(top,  rgba(206,206,206,0) 0%, rgba(119,119,119,0.65) 100%); /* FF3.6-15 */
          background: -webkit-linear-gradient(top,  rgba(206,206,206,0) 0%,rgba(119,119,119,0.65) 100%); /* Chrome10-25,Safari5.1-6 */
          background: linear-gradient(to bottom,  rgba(206,206,206,0) 0%,rgba(119,119,119,0.65) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
          filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00cecece', endColorstr='#a6777777',GradientType=0 ); /* IE6-9 */

          }

          .statistics .pull-left {
              color: #1A808C;
              font-weight: 600;
              font-size: 20px;
              line-height: .8em;
          }


          .statistics .entry {
              margin-left: 20px;
              font-size: 20px;
          }
          



    </style>
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
            Oficio listo para ser archivado
            <?php echo $config['nombre_institucion'];?>   <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li><a href="listado_oficios_por_archivar.php">Listado de oficios para archivar</a></li>
            <li class="active">listo para ser archivado</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                 <div class="row panel-profile-header"  >


                  <div class="col-md-4 ">
                    
                      <h2>No. de Oficio:  <br><?php echo $row_DatosOficios['no_oficio']; ?> </h2>

                 </div>

                <div class="col-md-4">
                <div class="box box-solid box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Favor corroborar que el oficio este tramitado por algunos de los usuarios asignados</h3>
                  </div><!-- /.box-header -->
                  <div class="box-body">
                     <h3 class="box-title">Consecutivo del sistema de este oficio es el IN- <?php echo $row_DatosOficios['oficio_id2']."- ".$row_DatosOficios['anno']; ?></h3>
                  </div><!-- /.box-body -->
                </div><!-- /.box -->
              </div>
                
                </div><!-- /.box-header -->

    
     
          <div class="col-md-12"> 

                    <div class="controls controls-header pull-right">
                        <a class="btn btn-primary " id=".$el_oficio." data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Cambiar Estado Oficio</a>&nbsp;
                            

                   </div>  
       </div>
      </section>

          




<!-- Modal que contiene los nombres de los usuarios cambiar estado al oficio-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
        <?php //echo $el_oficio;  ?>

 <!-- inicio del modal -->
                  <div class="callout callout-info">
                    <h4>Archivar Oficio | <?php echo $row_DatosOficios['no_oficio']; ?></h4>
                    <p>Fecha de ingreso: <?php echo $row_DatosOficios['fecha']?> </p>
                  </div>             
          
 <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onSubmit="javascript:return validaralta();">
       <div class="row">
             
                          

                            <div class="col-md-12"> 
                              <div class="row">
                                  <div class='col-sm-12'>
                                    <div class="alert alert-warning">
                                      <strong>Ingrese la Fecha: </strong> 
                                    </div>
                                      <div class="form-group">
                                          <div class='input-group date' >
                                              <input type='text' id='fecha_archivado' name="fecha_archivado" class="form-control" />
                                              <span class="input-group-addon">
                                                  <span class="glyphicon glyphicon-calendar"></span>
                                              </span>
                                          </div>

                                <div class="alert alert-danger oculto" role="alert" id="aviso2"><span class="glyphicon glyphicon-remove" ></span> La fecha no debe estar vacia</div>


                                          <br>
                                          <label for="comment">Ubicación:</label>
                                   <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ubicación del documento físico">
                                           
                                      </div>

                                       <div class="alert alert-danger oculto" role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span> La ubicación no debe estar vacía.</div>


                                  </div>
       
    </div>
                            </div>
       </div> 
  <br><br>
                   

                   
                  </table>
                  <input name="id_estado" type="hidden" id="id_estado" value="4" />  <!-- Cambia el estado cuando se pasa a "archivado" -->

                  <input name="usuario_modifica" type="hidden" id="usuario_modifica" value="<?php $el_usuario ?>" />
                  <input type="hidden" name="MM_insert" value="form1" />
                  <br>


                
        <!-- FIN LISTADO DE LOS USUARIOS-->


      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-primary btn-block btn-flat">Cambiar Estado</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- CAJA QUE CONTIENE EL PDF Y LOS USUARIOS USUARIOS ASIGNADOS AL OFICIO -->
                 <div class="box-body">

               
 <div class="row">
    <div class="col-md-12">
        
        <div class="embed-responsive embed-responsive-4by3">
        <iframe class="embed-responsive-item" src="imagenes/oficios_in/<?php echo $row_DatosOficios['imagen']; ?>"></iframe>
        </div>
    </div>

     <div class="col-md-12">
          
<div class="bg-light-blue disabled color-palette"><span>|</span></div>

          <h3>
                 <i class="fa fa-file-text-o fa-6" aria-hidden="true"></i> Usuarios Asignados al Oficio: 
            <small>| <?php echo $row_DatosOficios['no_oficio']; ?></small>
          </h3>
         <table class="table table-striped">
    <thead>
      <div class="bg-aqua color-palette"><span>Detalle comentarios: </span></div>
     
    </thead>
    <tbody>

          <?php 
               if ($totalRows_Usuario_Asignado > 0) 
              {  
                 do { 
          ?>

      <tr>
         <td>
                      <div class="direct-chat-msg col-md-10">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">
                              <?php 
                              echo obtenerNombre($row_Usuario_Asignado['usuario_id']);
                               ?>

                        </span>
                        <span class="direct-chat-timestamp pull-right"><?php echo obtenerEmail($row_Usuario_Asignado['usuario_id']); ?> | <?php echo $row_Usuario_Asignado['fecha_cambios']; ?></span>
                      </div><!-- /.direct-chat-info -->

                      

                      <img class="direct-chat-img" src="imagenes/avatar_usuarios/<?php ObtieneAvatar($row_Usuario_Asignado['usuario_id'],($el_oficio));?>" alt="message user image"><!-- /.direct-chat-img -->
                      
                      <?php 
      
                           $la_respuesta = respuestaUsuario($row_Usuario_Asignado['usuario_id'],($el_oficio));
                           $el_estadorespuesta = EstadorespuestaUsuario($row_Usuario_Asignado['usuario_id'],($el_oficio));


                           if ($la_respuesta=="")
                           {

                            ?>
                             <div class="direct-chat-text">
                              <?php  echo "Sin respuesta aún del usuario"; ?>
                            </div>

                           <?php } else { ?>


                      <div class="direct-chat-text">
                        <?php 
                            
                            echo $la_respuesta ; 

                        
                        ?>
 
                      </div>
                      


                       <?php } ?> <!-- /.direct-chat-text -->
                    </div>
                      <div class="direct-chat-msg col-md-2">
                 



                       <?php if ($el_estadorespuesta==2){

                          ?>
                          <button type="button" class="btn btn-warning">En Trámite</button>
                          <?php
                        }
                          else if ($el_estadorespuesta==5){
?>
                          <button type="button" class="btn  btn-success">Tramitado</button>
                          <?php
                          

                          }
                           else if ($el_estadorespuesta==1){

                          ?>
                          <button type="button" class="btn  btn-warning">Proceso Administrativo</button>
                          <?php

                          }
                          else if ($el_estadorespuesta==3 ){
                            ?>
                          <button type="button" class="btn btn-danger">Pendiente Trámite</button>
                          <?php

                          }
                          else if ($el_estadorespuesta==4 ){
                            ?>
                          <button type="button" class="btn btn-info">Esperando Respuesta</button>
                          <?php

                          }
                          else if ($el_estadorespuesta==7 ){
                            ?>
                          <button type="button" class="btn btn-danger">Devuelto</button>
                          <?php

                          }
                          else if ($el_estadorespuesta==6 ){
                            ?>
                          <button type="button" class="btn btn-info">Revisión Doctor</button>
                          <?php

                          }

                        ?>
                      </div>

                    <?php  ?>
       </td>
       
      
      </tr>

      <?php  } while ($row_Usuario_Asignado = mysqli_fetch_assoc($Usuario_Asignado));  

              } 
        else
              { //MOSTRAR SI NO HAY RESULTADOS ?>
                No hay usuarios para mostrar
                <?php 
              } 
                ?>  
      
    </tbody>
  </table>
        </div>
    </div>
</div>


<!-- FIN DE CAJA QUE CONTIENE EL PDF Y LOS USUARIOS USUARIOS ASIGNADOS AL OFICIO -->


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
    <script src="js/moment-with-locales.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>     
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script type="text/javascript">
            
            $(function () {
                $('#fecha_archivado').datetimepicker({

                  //viewMode: 'days',
                  //locate: 'es',
                 // format: 'DD/MM/YYYY',
                  format: 'YYYY/MM/DD',
                });
            });
     </script>

      <script>
    
    function validaralta()
      {
        valid = true;
        $("#aviso1").hide("slow");
        $("#aviso2").hide("slow");
      
        
        //COLORES
        if (document.form1.ubicacion.value == ""){
          $("#aviso1").show("slow");
            valid = false;
        }

        if (document.form1.fecha_archivado.value == ""){
        $("#aviso2").show("slow");
        valid = false;
  }
       
        return valid;

      }
        </script>  

  

  
    
  </body>
</html>

