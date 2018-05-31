<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php 

$el_oficio = $_GET ['oficio_id']; 
$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");

//$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE tipo_oficio=1 OR tipo_oficio=2 AND  id_estado = 7 and oficio_id = $el_oficio ORDER BY info_oficios.oficio_id ASC" );
$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE (tipo_oficio=1 OR tipo_oficio=2) AND oficio_id = $el_oficio ORDER BY info_oficios.oficio_id ASC" );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);

/***************** sql para obtener los pdf que se muestra en pantalla ****************/
$query_DatoPdf = sprintf("SELECT * FROM info_oficios WHERE (tipo_oficio=1 OR tipo_oficio=2) AND oficio_id = $el_oficio ORDER BY info_oficios.oficio_id ASC" );
$DatoPdf = mysqli_query($con,  $query_DatoPdf) or die(mysqli_error($con));
$row_DatoPdf = mysqli_fetch_assoc($DatoPdf);
$totalRows_DatoPdf = mysqli_num_rows($DatoPdf);
/***************** fin sql para obtener los pdf que se muestra en pantalla ****************/


   $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") ) {
  
 

$insertSQL = sprintf("UPDATE oficios_usuario SET id_estado=%s, resp_usuario=%s, fecha_cambios=%s WHERE id_oficioin= $el_oficio and usuario_id=$el_usuario ",
                                       
                     GetSQLValueString($_POST['id_estado'], "int"),
                     GetSQLValueString($_POST['resp_usuario'], "text"),
                     GetSQLValueString($_POST['fecha_cambios'], "date") );

  //echo $insertSQL ." nombre: ". $row_DatosUsuarios['nombre']. "<br>" ; 
 //$row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios);
  $Result1 = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));
        
  /* Actualizacion del estado del oficio en la tabla info_oficios STUART*/
$updateSQL = sprintf("UPDATE info_oficios SET id_estado=%s WHERE  oficio_id=$el_oficio ",
            GetSQLValueString($_POST['id_estado'], "int"));
//echo $updateSQL;
$Result1 = mysqli_query($con, $updateSQL) or die(mysqli_error($con));

//NO SE ACTUALIZA EL ESTADO DEL OFICIO EN LA TABLA INFO_OFICIOS, SOLO EN LA REFERENCIA QUE TIENE LA TABLA OFICIOS_USUARIO CREO QUE SE DEBE CORREGIR
  

 $insertGoTo = "detalle_oficio_asignado.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  
  header(sprintf("Location: %s", $insertGoTo));
}
}


/* SQL PARA OBTENER LOS USUARIOS QUE NO HAN SIDO ASIGNADOS AL OFICIO */
$query_DatosUsuarios= sprintf("SELECT * 
                               FROM usuarios 
                               WHERE estado_usuario= 1 and id_seccion <> 6 and usuario_id not in 
                                  (SELECT usuario_id 
                                    FROM oficios_usuario 
                                    WHERE oficios_usuario.id_oficioin= ".GetSQLValueString($_GET['oficio_id'], "int").") ORDER BY nombre");
$DatosUsuarios = mysqli_query($con,  $query_DatosUsuarios) or die(mysqli_error($con));
$row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios);
$totalRows_DatosUsuarios = mysqli_num_rows($DatosUsuarios);
/* FIN PARA OBTENER LOS USUARIOS QUE NO HAN SIDO ASIGNADOS AL OFICIO */


/* SQL PARA OBTENER EL USUARIO ASIGNADO AL OFICIO */

$query_UsuariosAsignados = sprintf("SELECT    *

                                      FROM 
                                              oficios_usuario, info_oficios 
                                      WHERE 
                                              info_oficios.oficio_id = oficios_usuario.id_oficioin and 
                                               oficios_usuario.usuario_id = $el_usuario  and 
      
                                              info_oficios.oficio_id  = ".GetSQLValueString($_GET['oficio_id'], "int")." ORDER BY oficios_usuario.usuario_id DESC");
$UsuariosAsignados = mysqli_query($con,  $query_UsuariosAsignados) or die(mysqli_error($con));
$row_UsuariosAsignados = mysqli_fetch_assoc($UsuariosAsignados);
$totalRows_UsuariosAsignados = mysqli_num_rows($UsuariosAsignados);

/* FIN DE SQL PARA OBTENER EL USUARIO ASIGNADO AL OFICIO */

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

/************************ SQL PARA OBTENER TOTAL DE USUARIOS REGISTRADOS EN SISTEMA *****************/

$query_TotalUsuarios = sprintf("SELECT  COUNT(usuario_id ) as suma FROM usuarios WHERE estado_usuario = 1 and id_seccion <> 6" );
$TotalUsuarios = mysqli_query($con,  $query_TotalUsuarios) or die(mysqli_error($con));
$row_TotalUsuarios= mysqli_fetch_assoc($TotalUsuarios);
$totalRows_TotalUsuarios = mysqli_num_rows($TotalUsuarios);


/************************* SQL QUE ACTUALIZA EL OFICIO EN EL MOMENTO QUE ES TRASLADADO A OTRO COMPAÑERO(A) ****************/

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {


$updateSQL = sprintf("UPDATE oficios_usuario SET id_oficioin=%s, usuario_id=%s, id_estado=%s,  usuario_traslada=%s, detalle_traslado=%s, fecha_traslado=%s WHERE  id_oficioin=$el_oficio  and usuario_id= $el_usuario ",
                       GetSQLValueString($_POST['id_oficioin'], "int"),
                      // GetSQLValueString($_POST['observacion'], "text"),
                       //GetSQLValueString($usuarios[$i], "int"),
                       GetSQLValueString($_POST['usuario_id'], "int"),
                       GetSQLValueString($_POST['id_estado'], "int"),
                       //GetSQLValueString($_POST['resp_usuario'], "text"),
                       GetSQLValueString($_POST['usuario_traslada'], "text"),
                       GetSQLValueString($_POST['detalle_traslado'], "text"),
                       GetSQLValueString($_POST['fecha_traslado'], "date"),
                       GetSQLValueString($_POST['id_oficiousua'], "int"));
//echo $updateSQL;
$Result1 = mysqli_query($con, $updateSQL) or die(mysqli_error($con));





  $insertGoTo = "envia_correo_oficio_traslado.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

/************************* FIN SQL QUE ACTUALIZA EL OFICIO EN EL MOMENTO QUE ES TRASLADADO A OTRO COMPAÑERO(A) ****************/


/* FIN DE LLAMADOS */

$estado= obtenerEstadoOficio($el_oficio, $el_usuario  ); 
  

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

  <!-- CSS PARA LOS SCRIPTS DE LOS FORMULARIOS -->
     <link rel="stylesheet" href="css/extra.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
            Oficio Asignado para su respectivo trámite 
             <?php echo $config['nombre_institucion'];?>   <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
              <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li><a href="oficios_asignados.php">Listado oficios asignados</a></li>
            <li class="active">Detalle Oficio Asignado</li>
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
                      <h2>Oficio de Entrada No. <br><?php echo $row_DatosOficios['no_oficio']; ?> </h2>

                 </div>
                
                 <div class="col-md-8">

                  <?php $el_estado = obtenerEstadoOficio($el_oficio, $el_usuario  ); /*echo ($el_estado)Agregado por stuart  */; 

                      if ($el_estado == "2" )/*En tramite*/{

                   
                  ?>

                  <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Comentario por parte de Jefatura al oficio IN- <?php echo $row_DatosOficios['oficio_id2']."- ".$row_DatosOficios['anno']; ?></h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                      <?php 
                      

                      $el_comentario = obtenerComentarioJefatura($el_oficio, $el_usuario  );
                      echo $el_comentario; 


                      //echo $row_UsuariosAsignados['observacion'] ;?>
                    </div><!-- /.box-body --> 

                  </div> <?php } else if ($el_estado == "3" ) /*Tramitado*/ {  ?>

                   <div class="box box-success box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Comentario por parte de Jefatura al oficio IN- <?php echo $row_DatosOficios['oficio_id2']."- ".$row_DatosOficios['anno']; ?></h3>  

                      <div class="box-tools pull-right">
                       
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" style="display: block;">

                      <?php 
                      /*wcg revisar para sacar el comentario de la jefa ya que no me funciona*/

                    
                      echo obtenerComentarioJefatura($el_oficio, $el_usuario  );


                      //echo $row_UsuariosAsignados['observacion'] ;?>
                    </div><!-- /.box-body --> 

                  </div> 

                </div> <?php } else if (($el_estado == "1" ) or ($el_estado == "8" )) {  ?>

                   <div class="box box-solid box-danger">
                    <div class="box-header with-border">
                      
                       <?php  if ($el_estado == "1" ) /*Asignado*/{?>
                      <h3 class="box-title">Comentario por parte de Jefatura al oficio IN- <?php echo $row_DatosOficios['oficio_id2']."- ".$row_DatosOficios['anno']; ?></h3>  
                         <?php } else if ($el_estado == "8" ) /*Traslado*/ { ?>
                      <h3 class="box-title">Oficio fue trasladado por: <?php echo obtenerNombre ($row_UsuariosAsignados['usuario_traslada']); ?>  <br>Oficio IN- <?php echo $row_DatosOficios['oficio_id2']."- ".$row_DatosOficios['anno']; ?></h3> <br> <?php echo "Comentario compañero que traslada: ". $row_UsuariosAsignados['detalle_traslado'];?> 
                       <?php } ?>


                      <div class="box-tools pull-right">
                       
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" style="display: block;">

                      <?php 
                      /*wcg revisar para sacar el comentario de la jefa ya que no me funciona*/

                    
                      echo obtenerComentarioJefatura($el_oficio, $el_usuario  );


                      //echo $row_UsuariosAsignados['observacion'] ;?>
                    </div><!-- /.box-body --> 

                  </div> <?php } ?>


                </div>
                
                  </div>
                </div><!-- /.box-header -->
     
          <div class="col-md-12">
                    
          <?php  if ($estado==5) /*Tramitado*/ { ?>

                   

                   <?php } else { ?>

                    <div class="controls controls-header pull-right">
                        <a class="btn btn-primary " id=".$el_oficio." data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Cambiar Estado Oficio</a>&nbsp;
                        
<?php }?>
                                
                   <?php  //if (($estado==3)/*Asignado*/ or ($estado==8)) /*Traslado*/  { ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2"><i class="fa fa-plus"></i> Trasladar Oficio    </button>
        
                  <?php// }?>


       

                   </div>  
       </div>
       <div class="row">
          <div class="col-sm-4"></div>
          
        </div>

          
 <!-- modal que llama a grupo de usuarios para el traslado del oficio -->

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <div class="alert alert-danger alert-dismissable ">
                    <h4>Traslado de Oficio: | <?php echo $row_DatosOficios['no_oficio']; ?></h4>
                    <p>Fecha de ingreso: <?php echo $row_DatosOficios['fecha']?> </p>
                  </div> 
      </div>
      <!-- body del modal con los datos de los usuarios para trasladar el oficio -->
                <div class="modal-body">
                        <?php //echo $el_oficio;  ?>

                 <!-- inicio del modal -->              
                          
                 <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2" onSubmit="javascript:return cambiar_estado();">
                       <div class="row">
                            <?php 
                               if ($totalRows_DatosUsuarios > 0) 
                              {  
                                 do { ?>
                                  <div class="col-md-4"> 

                                    <div class="radio">
                                        <label>
                                          <input type="radio" name="usuario_id" id="usuario_id" value="<?php echo $row_DatosUsuarios['usuario_id'];?>">
                                          <?php echo $row_DatosUsuarios['nombre']." ". $row_DatosUsuarios['apellido1'];?>
                                        </label>
                                      </div>

                                  </div>
                                  <?php  } while ($row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios));  

                              } 
                        else
                              { //MOSTRAR SI NO HAY RESULTADOS ?>
                                No hay usuarios para mostrar
                                <?php 
                              } 
                                ?>    
                       </div> <!-- FIN DEL ROW QUE ESTOY MODIFICANDO  -->
                  <br><br>
                  <div class="form-group">
                    <label for="observacion">Observación para compañero(a): </label>
                    <input type="text" class="form-control" id="detalle_traslado" placeholder="Detalle traslado" name="detalle_traslado" value="">
                  </div>

                   <div class="alert alert-danger oculto" role="alert" id="anuncio"><span class="glyphicon glyphicon-remove" ></span> La observación al compañero (a) no puede estar vacía</div>


                                  </table>
                                  <!-- INPUTS OCULTOS PARA EL TRASLADO DEL OFICIO -->
                                  <input name="usuario_traslada" type="hidden" id="usuario_traslada" value="<?php echo $el_usuario; ?>" />
                                  <input name="id_estado" type="hidden" id="id_estado" value="9" />
                                  <input name="id_oficioin" type="hidden" id="id_oficioin" value="<?php echo $el_oficio; ?>" />
                                  <!-- <input name="observacion" type="hidden" id="observacion" value="<?php echo $el_comentario;?>" /> -->
                                  <input name="fecha_traslado" type="hidden" id="fecha_traslado" value="<?php $date ?>" />
                                  <input type="hidden" name="id_oficiousua" value="<?php echo $row_UsuariosAsignados['id_oficiousua']; ?>" />
                                  <!-- INPUTS OCULTOS PARA EL TRASLADO DEL OFICIO -->

                                  
                                  <input type="hidden" name="MM_insert" value="form2" />
                                  <br>

                
                                
                        <!-- FIN LISTADO DE LOS USUARIOS-->


                      </div>
                      <button type="submit" class="btn btn-primary btn-block btn-flat">Trasladar</button>
<!-- fin del body del modal con los datos de los usuarios para trasladar el oficio -->
</form>

      
    </div>
  </div>
</div>
</div>
<!-- fin de modal que llama a grupo de usuarios para el traslado del oficio -->



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
                    <h4>Cambiar estado del oficio | <?php echo $row_DatosOficios['no_oficio']; ?></h4>
                    <p>Fecha de ingreso: <?php echo $row_DatosOficios['fecha']?> </p>
                  </div>             
          
 <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onSubmit="javascript:return validaralta(); ">
       <div class="row">
                    <div class="col-md-4"> 
                                  <label>
                              <input name="id_estado" type="radio" id="radio" value="1" />
                              </label>
                              <strong > Proceso Administrativo 
                    </div>
                    <div class="col-md-4"> 
                              <label>
                              <input name="id_estado" type="radio" id="radio" value="2" checked />
                              </label>
                              <strong > En Trámite 
                    </div>
                    <div class="col-md-4"> 
                              <label>
                              <input name="id_estado" type="radio" id="radio" value="4" />
                              </label>
                              <strong > Esperando Respuesta 
                    </div>
                    <div class="col-md-4"> 
                              <label>
                              <input name="id_estado" type="radio" id="radio" value="5" />
                              </label>
                              <strong > Finalizado 
                    </div>
                    <div class="col-md-4"> 
                                  <label>
                              <input name="id_estado" type="radio" id="radio" value="7" />
                              </label>
                              <strong > Devuelto 
                    </div>

                                                            
                                                   
                  </div> <?php// } else if (($estado==2)/*En tramite*/or($estado==8)/*Traslado*/) 
                              //{  ?>
                  <?php //}  ?>
   <!--    </div> -->
  <br><br>
                    <div class="form-group">
                      <label for="observacion">Comentario de: | <?php echo obtenerNombre($el_usuario); ?>  </label>
                      <input type="text" class="form-control" id="resp_usuario" placeholder="Respuesta Usuario" name="resp_usuario" value="">
                    </div>

                    <div class="alert alert-danger oculto" role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span> La respuesta no debe estar vacía</div>
                    <input name="fecha_cambios" type="hidden" id="fecha_cambios" value="<?php $date?>" />
                </form>
                  
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



                <div class="box-body">

               
 <div class="row">
    <div class="col-md-12">
        
        <div class="embed-responsive embed-responsive-4by3">
        <iframe class="embed-responsive-item" src="imagenes/oficios_in/<?php echo $row_DatoPdf['imagen']; ?>"></iframe>
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

        
         
        if (document.form1.resp_usuario.value == ""){
          $("#aviso1").show("slow");
            valid = false;
        }
        
        if (document.form1.id_estado.value == ""){
          $("#aviso2").show("slow");
            valid = false;
        }


        return valid;
      }
    </script>

     <script>

      function cambiar_estado()
      {
          valid = true;
        $("#anuncio").hide("slow");
               
         
        if (document.form2.detalle_traslado.value == ""){
          $("#anuncio").show("slow");
            valid = false;
        }
        
        
        return valid;
      }
    </script>

    <script> 

          function validarRadio(F){
                    var i var ok
                       ok=0
           for(i=0; i<form1.id_estado.length;i++){
            if(form1.id_estado[i].checked)
            {
             ok=1
            }    
           }
           
           if(ok==1)
            return true
           if(ok==0)
            return false

              return true
          }

    </script>
    
  </body>
</html>

<?php

mysqli_free_result($DatosOficios);
mysqli_free_result($DatoPdf);
mysqli_free_result($DatosUsuarios);
mysqli_free_result($TotalUsuarios);
mysqli_free_result($UsuariosAsignados);
mysqli_free_result($Usuario_Asignado);
?>
