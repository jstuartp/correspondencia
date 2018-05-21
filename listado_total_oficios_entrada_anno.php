<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10");?> <!-- accesso -->
<?php 

$el_anno = GetSQLValueString( $_POST ['anno'], "int"); 



$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE (tipo_oficio=1 OR tipo_oficio=2) AND anno= $el_anno ORDER BY info_oficios.oficio_id ASC " );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);

/* VARIABLES PARA ESTABLECER QUE PERFIL DE USUARIO PUEDE VER LOS MOVIMIENTOS DE LOS OFICIOS
   QUE NO LE HAN SIDO ASIGNADO A ÉL PERO QUE NECESITA CONOCER QUIENES LO TIENEN ASIGNADO Y HAN CONTESTADO ALGÚN OFICIO*/

//$EL_ID_USUARIO = obtenerIdUsuario($_SESSION ['reservas_UserId']); 
//$LA_SECCION_USUARIO = obtenerIDSeccionUsuario($_SESSION ['reservas_UserId']); 
//$EL_NIVEL_USUARIO = obtenerIDNivelUsuario($_SESSION ['reservas_UserId']); 

//$seccion_autorizada = obtenerSeccionAutorizado ($LA_SECCION_USUARIO);
//$nivel_autorizado = obtenerNivelAutorizado ($EL_NIVEL_USUARIO);


$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");
//$usuario_autorizado = GetSQLValueString(obtenerUsuarioAutorizadoEliminar($_SESSION ['reservas_UserId']), "int"); 
$usuario_autorizado_ver = GetSQLValueString(obtenerUsuarioAutorizadoVer($_SESSION ['reservas_UserId']), "int");

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php include(dirname(__FILE__)."/includes/institucion.php"); ?></title>
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css"> 

        .iframe-container {    
          padding-bottom: 60%;
          padding-top: 30px; height: 0; overflow: hidden;
        }
         
        .iframe-container iframe,
        .iframe-container object,
        .iframe-container embed {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <?php include(dirname(__FILE__)."/includes/el_logo.php"); ?>  <!-- llamado al logo o información para personalizar el nombre dle sitio WCG-->
        
        <!-- Header Navbar: style can be found in header.less -->
        
        <?php include(dirname(__FILE__)."/includes/menu_header.php");?> <!-- llamado al menu del header principal -->
       <!-- Header Navbar: style can be found in header.less -->

      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include(dirname(__FILE__)."/includes/menu_izq.php"); ?>   <!-- LLAMADO DEL MENU IZQUIERDA WCG -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Total Oficios de Entrada
            <?php echo $config['nombre_institucion'];?>    <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
          
            <li class="active">Listado Oficios entrada</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
                  <h3 class="box-title">Listado Total de oficios ingresados al sistema</h3>
                </div><!-- /.box-header -->
                

                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>No. Oficio </th>
                        <th>Asunto</th>
                        <th>Ingresado</th>
                        <th>Fecha</th>
                        <th>Año</th>
                        <th>Estado</th>
                      <!--  <th>Responder</th>  -->
                        

                        <?php 

                         if ( $el_usuario == $usuario_autorizado_ver)
                        { 
                          ?>
                        <th>PDF</th>

                         <?php } ?>
                        
                        <?php 

                         if ( $el_usuario == $usuario_autorizado_ver)
                        { 
                          ?>

                        <th>Movimientos</th>

                         <?php } ?>


                      </tr>
                    </thead>
                    <tbody>
              
              <?php 
    //AQUI ES DONDE SE SACAN LOS DATOS, SE COMPRUEBA QUE HAY RESULTADOS
              if ($totalRows_DatosOficios > 0)
              {  
                  do { 
                              
              ?>
                      <tr>
                        <td><?php echo $row_DatosOficios["oficio_id2"]."-".$row_DatosOficios["anno"]; ?></td>
                         <td><?php echo $row_DatosOficios["no_oficio"]; ?></td>

                        <td>
                          <?php 



                                 $la_cadena = $row_DatosOficios["asunto"];
                                 $resultado = substr(".$la_cadena.", 1, 200);
                                 echo $resultado ; 
                                  //echo $row_DatosOficios["asunto"];
                         ?>
                       </td>
                        <td><?php echo obtenerNombre ($row_DatosOficios['usuario_inserta']) ;?> </td>
                        <td><?php echo $row_DatosOficios["fecha"];?> </td>
                        <td> <?php echo $row_DatosOficios["anno"];?></td>
                        
                        
                          <td>  <!-- CODIGO PUESTO POR STUART -->
                              <?php //PASAR POR TODOS LOS ESTADOS PARA PONER LA IMAGEN QUE CORRESPONDA Y EL TEXTO

                        if ($row_DatosOficios["id_estado"] == 1)
                        {
                          ?>
                             <a href="#" class="btn label-info">
                              <span class="glyphicon glyphicon-eye-open"></span> Proceso Administrativo
                            </a> 
                        <?php 
                        }  else if ($row_DatosOficios["id_estado"] == 2 )
                        
                        { ?>
                            <a href="#" class="btn btn-warning">
                              <span class="glyphicon glyphicon-folder-open"></span> En Trámite
                            </a>  
                         
                        <?php }

                        else if ($row_DatosOficios["id_estado"] == 3 )
                        { ?>
                            <a href="#" class="btn btn-danger ">
                                <span class="glyphicon glyphicon-time"></span> Pendiente de Trámite
                            </a>
                        <?php 
                        }

                        else if ($row_DatosOficios["id_estado"] == 4 )
                        {
                          ?>
                          <a href="#" class="btn label-warning ">
                                <span class="glyphicon glyphicon-question-sign"></span> Esperando Respuesta
                            </a>
                      <?php
                        }
                        
                        else if ($row_DatosOficios["id_estado"] == 5 )
                        {
                          ?>
                          <a href="#" class="btn label-success ">
                                <span class="glyphicon glyphicon-ok"></span> Finalizado
                            </a>
                      <?php
                        }
                        
                        else if ($row_DatosOficios["id_estado"] == 6 )
                        {
                          ?>
                          <a href="#" class="btn label-info ">
                                <span class="glyphicon glyphicon-eye-open"></span> Revisión Doctor
                            </a>
                      <?php
                        }
                        
                        else if ($row_DatosOficios["id_estado"] == 7 )
                        {
                          ?>
                          <a href="#" class="btn label-warning ">
                                <span class="glyphicon glyphicon-refresh"></span> Devuelto
                            </a>
                      <?php
                        }

                         ?>
                              <!-- CODIGO PUESTO POR STUART -->
                          </td>
                           
                          
                          <!-- SECCION DE RESPONDER OMITIDA DE MOMENTO STUART -->
                      <!--     <th>     

                           
                           <a href="generar_oficio_salida_respuesta.php?oficio_id=<?php //echo $row_DatosOficios["oficio_id"].'&anno='. $row_DatosOficios['anno'];?>" class="btn label-default ">
                                <span class="glyphicon glyphicon-pencil"></span> Responder
                            </a>
                            <a href="envia_correo_estudiante.php?oficio_id=<?php //echo $row_DatosOficios["oficio_id"];?>" class="btn btn-info ">
                              <span class="glyphicon glyphicon-envelope"></span> E-mail 
                            </a>

                         

                           </th> -->    <!-- SECCION DE RESPONDER OMITIDA DE MOMENTO STUART -->


                        <?php 

                         if ( $el_usuario == $usuario_autorizado_ver)
                        { 
                          ?>
                         <td> <a class="btn btn-block btn-primary view-pdf" data-asunto-in="<?php echo $row_DatosOficios["asunto"];?>" data-id-in="<?php echo $row_DatosOficios["oficio_id2"];?>" data-numero-oficio-in="<?php echo $row_DatosOficios["no_oficio"];?>" data-fecha-in="<?php echo $row_DatosOficios["fecha"];?>" href="imagenes/oficios_in/<?php echo $row_DatosOficios["imagen"];?>">Ver PDF</a>        
  
                        </td>
                        <?php } ?>  

                          

                        <!-- VALORAMOS EL NIVEL Y LA SECCION DEL USUARIO PARA PERMITIRLE PODER VER LOS MOVIMIENTOS DE LOS OFICIOS WCG-->
                        <?php 




                         if ( $el_usuario == $usuario_autorizado_ver )
                        { 
                          ?> 

                        
                          <td> <a href="detalle_oficio_movimientos.php?oficio_id=<?php echo $row_DatosOficios["oficio_id"];?>" target="_blank" <i class="fa fa-file-pdf-o"></i></td>
                          </td>

                           <?php  }?>

                        <!-- FIN ****** VALORAMOS EL NIVEL Y LA SECCION DEL USUARIO PARA PERMITIRLE PODER VER LOS MOVIMIENTOS DE LOS OFICIOS WCG-->

                        
                      </tr>

                      <?php 

                          } while ($row_DatosOficios = mysqli_fetch_assoc($DatosOficios)); 
                                 } 
                                else
                                 { //MOSTRAR SI NO HAY RESULTADOS ?>
                                            No hay resultados.
                                            <?php } 

                      ?>

           </tbody>
                  
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
      $(function () {
        
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "order": [[ 0, "desc" ]], // orden de los resultados primero columna 0 los IN y luego por año columna 3
          "order": [[ 4, "desc" ]], 
          // "order": [[ 0, 'asc' ], [ 1, 'asc' ]],
          //"scrollY": 400
        });
      });
    </script>

    <script>

(function(a){a.createModal=function(b){defaults={title:"",message:"Mensaje",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height: 720px;overflow-y: auto;"':"";html='<div class="modal fade" id="myModal">';html+='<div class="modal-dialog  modal-lg">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);

/*
* Here is how you use it
*/
$(function(){    
    $(document.body).on('click','.view-pdf',function(){ 
        var pdf_link = $(this).attr('href');
        var id_in = $(this).attr('data-id-in');
        var asunto_in= $(this).attr('data-asunto-in');
        var fecha_in = $(this).attr('data-fecha-in');
        var numero_oficio_in = $(this).attr('data-numero-oficio-in');
        var iframe = '<div class="iframe-container"><iframe src="'+pdf_link+'"></iframe></div>'
        $.createModal({
        title:' Oficio No: '+numero_oficio_in+'<br>Título:'+asunto_in.substring(0,100)+'...<br>Fecha: '+ fecha_in,
        message: iframe,
        closeButton:true,
        scrollable:false
        });
        return false;        
    });    
})

</script>

<script type="text/javascript">
<!--
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
//-->
</script>

  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosOficios);
?>
