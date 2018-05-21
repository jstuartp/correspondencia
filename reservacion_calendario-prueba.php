<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10");?> <!-- accesso -->
<?php 



$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE tipo_oficio=1 OR tipo_oficio=2 AND id_estado = 7 ORDER BY info_oficios.oficio_id DESC " );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);

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

    <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.print.css" media="print">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
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
            Oficios de Entrada
            <?php include("includes/titulo_pequeno.php"); ?>   <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li><a href="#">Tablas</a></li>
            <li class="active">Tablas de contenido</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Listo de oficios ingresados al sistema</h3>
                </div><!-- /.box-header -->
                

                <div class="box-body">
                   <div id="calendar"></div>
                   
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
    <!-- fullCalendar 2.2.5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
     <script src="plugins/fullcalendar/fullcalendar.min.js"></script>
    <!-- page script -->
    <script>

  $(document).ready(function() {
    
    $('#calendar').fullCalendar({
      defaultView: 'agendaWeek',
      axisFormat: 'HH:mm',
      ignoreTimezone: "true",
      businessHours:{
        start: '08:00', 
        end: '17:00',
        dow: [ 1, 2, 3, 4, 5 ]
        },
          lang: 'es',
          allDaySlot:false,
          format: 'DD/MM/YYYY',
          defaultDate: '<?php echo date('Y-m-d');?>',
          selectable: true,
          selectHelper: true,
      select: function(start, end) {
       inicio=moment(start).format('DD/MM/YYYY HH:mm');
       fin=moment(end).format('DD/MM/YYYY HH:mm');
       $('#calendarModal #apptStartTime').val(inicio);
       $('#calendarModal #apptEndTime').val(fin);
       $('#calendarModal #when').text(inicio+' hasta '+fin);
       $('#calendarModal').modal('show');

        
      },
      editable: false,




            events: [
              {
                title: 'All Day Event',
                start: '2016-09-01'
              }
            ]
          });
    
  });

</script>


<div id="calendarModal" class="modal fade" role="dialog" >

<div class="modal-dialog">
    <div class="modal-content"><form action="reservacion-ver-previa.php?id=<?php echo $_GET["id"];?>" method="post" class="form-horizontal" id="createAppointmentForm">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
            <h2 id="modalTitle" class="modal-title">Reservaciónes Oficina de Divulgación</h2>
        </div>
        <div id="modalBody" class="modal-body">
         
            <div class="control-group">
                
                <div class="controls">
                   
                    <input type="hidden" id="apptStartTime" name="apptStartTime" />
                    <input type="hidden" id="apptEndTime" name="apptEndTime" />
                      

                      <h3>
                      Detalle 
                    <textarea name="direccion" cols="42"  id="direccion"></textarea> 
                   
                    </h3>
                </div>
            </div>
            <div class="control-group">
                <h3><label class="control-label" for="when">Horario de Reservación:</label></h3>
                <div class="controls controls-row" id="when" style="margin-top:5px; color:#F00; font-size:14px"></div>
            </div>
        </div>
            <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="submitButton">Guardar</button>
    </div></form>
    </div>
</div>
</div>


  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosOficios);
?>
