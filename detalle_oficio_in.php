<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10");?> <!-- accesso -->
<?php 

$el_oficio = GetSQLValueString($_GET['oficio_id'], "int"); 

$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");

//La consulta muestra un error, al no tener parentesis en el OR, trae todos los datos y no el detalle del oficio especifico
//Corregido por Stuart 
$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE (tipo_oficio=1 OR  tipo_oficio=2) AND  oficio_id =%s ORDER BY info_oficios.oficio_id ASC",GetSQLValueString($el_oficio, "int"));
//echo ($query_DatosOficios);
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);

/* llamado de los querys para la selección de los usuarios que no estan asignados a oficio 
   y la inserción de los que se seleccionó a la BD */

   $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") ) {
  if (isset ( $_POST['usuarios'])) 
  {

   $usuarios= $_POST['usuarios'];
   $longitud = count($usuarios);

      for($i=0; $i<$longitud; $i++)
       {
 

        $insertSQL = sprintf("INSERT INTO 
                             oficios_usuario (id_oficioin, observacion, usuario_id, id_estado) 
                              VALUES ( %s, %s,". $usuarios[$i].", 9)",
                       
                       GetSQLValueString($el_oficio, "int"),
                       GetSQLValueString($_POST['observacion'], "text"),
                       GetSQLValueString($_POST['id_estado'], "int"));

          //echo $insertSQL ." nombre: ". $row_DatosUsuarios['nombre']. "<br>" ; 
         //$row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios);
          $Result1 = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));
                }

        /* Actualizacion del estado del oficio en la tabla info_oficios STUART*/
        $updateSQL = sprintf("UPDATE info_oficios SET id_estado=%s WHERE  oficio_id=$el_oficio ",
        GetSQLValueString($_POST['id_estado'], "int"));
        echo $updateSQL;
        $Result1 = mysqli_query($con, $updateSQL) or die(mysqli_error($con));        
                
                
         $insertGoTo = "envia_correo_oficio_asignado.php";
          if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
          }
          header(sprintf("Location: %s", $insertGoTo));
        }
        }

/*SQL PARA CAMBIAR EL ESTADO A VISTO POR LA JEFATURA PARA QUE ESTE NO LE APAREZCA EN EL LISTADO DE OFICIOS DE ENTRADA*/


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {


$updateSQL = sprintf("UPDATE info_oficios SET  id_estado=6  WHERE oficio_id=".GetSQLValueString($_GET['oficio_id'], "int")." ");
echo $updateSQL;
$Result1 = mysqli_query($con, $updateSQL) or die(mysqli_error($con));


  $insertGoTo = "listado_oficios_entrada_jefatura.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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


/* SQL PARA OBTENER LOS USUARIOS QUE HAN SIDO ASIGNADOS AL OFICIO */

$query_UsuariosAsignados = sprintf("SELECT    info_oficios.oficio_id, 
                                              oficios_usuario.id_oficioin, 
                                              oficios_usuario.id_estado, 
                                              oficios_usuario.usuario_id, 
                                              oficios_usuario.observacion, 
                                              oficios_usuario.resp_usuario, 
                                              oficios_usuario.id_oficiousua,
                                              oficios_usuario.fecha_cambios

                                      FROM 
                                              oficios_usuario, info_oficios 
                                      WHERE 
                                              info_oficios.oficio_id = oficios_usuario.id_oficioin and      
                                              info_oficios.oficio_id  = ".GetSQLValueString($_GET['oficio_id'], "int")." ORDER BY oficios_usuario.usuario_id DESC");
$UsuariosAsignados = mysqli_query($con,  $query_UsuariosAsignados) or die(mysqli_error($con));
$row_UsuariosAsignados = mysqli_fetch_assoc($UsuariosAsignados);
$totalRows_UsuariosAsignados = mysqli_num_rows($UsuariosAsignados);

/****** SQL PARA OBTENER TOTAL DE USUARIOS REGISTRADOS EN SISTEMA *****************/

$query_TotalUsuarios = sprintf("SELECT  COUNT(usuario_id ) as suma FROM usuarios WHERE estado_usuario = 1 and id_seccion <> 6" );
$TotalUsuarios = mysqli_query($con,  $query_TotalUsuarios) or die(mysqli_error($con));
$row_TotalUsuarios= mysqli_fetch_assoc($TotalUsuarios);
$totalRows_TotalUsuarios = mysqli_num_rows($TotalUsuarios);

/******* SQL PARA ACTUALIZAR LA TABLA DE OFICIOS BLOQUEADOS PARA EVITAR QUE SE ELIMINE MIENTRAS UN USUARIO ESTE EN UTILIZANDO DESDE ESTA PÁGINA *********************/


echo ActualizarEstadoOficioBloqueado($el_usuario, $el_oficio);
echo EliminaEstadoOficioBloqueado( $el_oficio); 


/* FIN DE LLAMADOS */

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
        <?php include ("includes/el_logo.php"); ?>  <!-- llamado al logo o información para personalizar el nombre del sitio WCG-->
        
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
            Oficios de Entrada para Revisión de Jefatura
              <?php echo $config['nombre_institucion'];?>   <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
              <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li><a href="listado_oficios_entrada_jefatura.php">Listado de Oficios</a></li>
            <li class="active">Detalle Oficio</li>
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
                      <h2>Oficio de Entrada No. <?php echo $row_DatosOficios['no_oficio']; ?> </h2>
                     
                 </div>
                
                 <div class="col-md-8">

                  <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Resumen | Oficio IN- <?php echo $row_DatosOficios['oficio_id2']."- ".$row_DatosOficios['anno'];?></h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                      <?php echo $row_DatosOficios['asunto'] ;?>
                    </div><!-- /.box-body --> 

                  </div>

                </div>
                
                  </div>
                </div><!-- /.box-header -->
     
          <div class="col-md-12">
                    <div class="statistics pull-left">
<!--
                        <div class="pull-left entry">
                            <span class="count"><?php echo cuentaOficiosAsignados($el_oficio);?></span>
                            <br>
                            <span class="title">Asignados</span>
                        </div>

                        <div class="pull-left entry">
                            <span class="count"><?php echo $row_TotalUsuarios['suma']; ?></span>
                            <br>
                            <span class="title">Usuarios en el sistema</span>
                        </div>

                       -->

                    </div>
                    <!-- end: User statistics -->

                    <div class="controls controls-header pull-right">

<!-- FORMULARIO PARA CAMBIAR ESTADO A OFICIO A VISTO POR LA JEFATURA-->

        <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
      

                  </table>
                  <input type="hidden" name="id_estado"  />
                  <input type="hidden" name="MM_insert" value="form2" />
                  <br>



      </div>
      <div class="modal-footer">
     <!-- Indicates a successful or positive action -->

     

          <?php  if ($row_DatosOficios['id_estado'] == 7 ) { ?>

        <button type="submit" class="btn btn-success">Visto por Jefatura</button>
          <?php  } else echo "";  ?>
          

        </form>

<!-- FIN FORMULARIO PARA CAMBIAR ESTADO A OFICIO A VISTO POR LA JEFATURA-->
 
                        <a class="btn btn-primary " id=".$el_oficio." data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Asignar Usuarios</a>&nbsp;
                       
        
        <div class="btn-group dropdown-navigation">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-cog"></i>            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu pull-right">

                            <li>
                    <a class="" href="pasar_archivovbjefatura2.php?oficio_id=<?php echo $el_oficio; ?>"><i class="fa fa-cogs"></i> <span>Pasar a Archivo</span></a>                </li>
                            
            
        </ul>
        
<br/><br/>
       </div>

                   </div> 
       </div>
       <div class="row">
          <div class="col-sm-4"></div>
          
        </div>

          
                            
<!-- Modal que contiene los nombres de los usuarios para asignar al oficio-->
<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
        <?php //echo $el_oficio;  ?>

 <!-- inicio del modal -->
                  <div class="callout callout-info">
                    <h4>Asignación usuarios al Oficio No. | <?php echo $row_DatosOficios['no_oficio']; ?></h4>
                    <p>Fecha de ingreso: <?php echo $row_DatosOficios['fecha']?> </p>
                  </div>             
          
 <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onSubmit="javascript:return validaralta();">
       <div class="row">
            <?php 
               if ($totalRows_DatosUsuarios > 0) 
              {  
                 do { ?>
                  <div class="col-md-4"> 
                   <div class="checkbox">
                        <label>
                                <input type="checkbox" name="usuarios[]" value="<?php echo $row_DatosUsuarios['usuario_id'];?>" id="checkbox">
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
    <label for="observacion">Observación Jefatura: </label>
    <input type="text" class="form-control" id="observacion" placeholder="observacion" name="observacion" value="">
  </div>

  <div class="alert alert-danger oculto" role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span> La observación no debe estar vacía</div>
                  
                  </table>
                  <input type="hidden" name="id_estado" value="9" /> <!-- VALOR 9 PARA QUE APAREZCA COMO RECIEN ASIGNADO AL USUARIO  STUART-->
                  <input type="hidden" name="MM_insert" value="form1" />
                  <br>

<a href="javascript:seleccionar_todo()">Marcar todos</a> | 
<a href="javascript:deseleccionar_todo()">Des-marcar todos</a> 
                
        <!-- FIN LISTADO DE LOS USUARIOS-->


      </div>
      <div class="modal-footer">
     
        <button type="submit" class="btn btn-primary btn-block btn-flat">Asignar</button>
        </form>
      </div>
    </div>
  </div>
</div>


                <div class="box-body">

               
 <div class="row">
    <div class="col-md-12">
        
        <div class="embed-responsive embed-responsive-4by3">
        <iframe class="embed-responsive-item" src="../imagenes/oficios_in/<?php echo $row_DatosOficios['imagen']; ?>"></iframe>
        </div>
    </div>

     <div class="col-md-12">
          
<div class="bg-light-blue disabled color-palette"><span>|</span></div>

          <h3>
            Usuarios Asignados al Oficio: 
            <small>| <?php echo $row_DatosOficios['no_oficio']; ?></small>
          </h3>
         <table class="table table-striped">
    <thead>
      <div class="bg-aqua color-palette"><span>Detalle comentarios: </span></div>
     
    </thead>
    <tbody>

          <?php 
               if ($totalRows_UsuariosAsignados == 0) 
              {  
                 echo "no existen comentarios";

                 }

                 else if ($totalRows_UsuariosAsignados > 0)
                 {

                      do { 
          ?>

      <tr>
         <td>
                      <div class="direct-chat-msg col-md-10">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">
                              <?php 
                              echo obtenerNombre($row_UsuariosAsignados['usuario_id']);
                               ?>

                        </span>
                        <span class="direct-chat-timestamp pull-right"><?php echo obtenerEmail($row_UsuariosAsignados['usuario_id']); ?> | <?php echo $row_UsuariosAsignados['fecha_cambios']; ?></span>
                      </div><!-- /.direct-chat-info -->

                      

                      <img class="direct-chat-img" src="imagenes/avatar_usuarios/<?php ObtieneAvatar($row_UsuariosAsignados['usuario_id'],($el_oficio));?>" alt="message user image"><!-- /.direct-chat-img -->
                      
                          <?php 
      
                           $la_respuesta = respuestaUsuario($row_UsuariosAsignados['usuario_id'],($el_oficio));
                            $el_estadorespuesta = EstadorespuestaUsuario($row_UsuariosAsignados['usuario_id'],($el_oficio));

                           if ($la_respuesta=="")
                           {

                            ?>
                             <div class="direct-chat-text">
                              <?php  echo "Sin respuesta aún del usuario"; ?>
                            </div>

                           <?php } else { ?>

                            <div class="direct-chat-text">
                              <?php echo $la_respuesta; ?>
                                 
                            </div>
                       <?php } ?><!-- /.direct-chat-text -->
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
       
        

       <td><?php  if(($row_UsuariosAsignados['id_estado'] == 1) or ($row_UsuariosAsignados['id_estado'] == 8))
                { 
                   ?>
                   <a href="borrar_usuario_oficio.php?usuario_id=<?php echo $row_UsuariosAsignados['usuario_id']."&el_id=".$row_UsuariosAsignados['id_oficioin']; ?>  "><div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-eraser"></i> Borrar</div></a>
       <?php 
                } 

                    else if ( $row_UsuariosAsignados['id_estado'] == 2) 
                      {
                        
                        ?>
                        <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
<?php
                      }


       ?>
       
       </td>
      </tr>

      <?php  } while ($row_UsuariosAsignados = mysqli_fetch_assoc($UsuariosAsignados));  

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

    <script>

function validaralta()
{
    valid = true;
  $("#aviso1").hide("slow");
  
  //COLORES
  if (document.form1.observacion.value == ""){
    $("#aviso1").show("slow");
      valid = false;
  }
  
  


  return valid;
}
</script>

  <script>
$(window).bind('unload', function(){
            $.ajax({
            type: 'post',
            async: false,
            url: 'borrar_oficio_bloqueado.php?oficio_id=<?php echo $el_oficio; ?>'

            });
        });
</script>


  </body>
</html>


