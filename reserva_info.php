<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php 

$query_DatosReservaDia = " SELECT * 
                            FROM tblreservapista 
                              WHERE intEstado=1 and 
                                     idReserva=".GetSQLValueString($_GET["la_reserva_id"], "int" );
$DatosReservaDia = mysqli_query($con,  $query_DatosReservaDia) or die(mysqli_error($con));
$row_DatosReservaDia = mysqli_fetch_assoc($DatosReservaDia);
$totalRows_DatosReservaDia = mysqli_num_rows($DatosReservaDia);


                              
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
                  <h3 class="box-title">Informe detallado de la reservación</h3>
                </div><!-- /.box-header -->
                

                <div class="box-body">
                  

                    
 <?php 

                              $id_calendario = $row_DatosReservaDia['refPropiedad'];

                              $fecha1=$row_DatosReservaDia['fchFechaDesde'];
                              $fecha2=date("d-m-Y h:i:s A",strtotime($fecha1));

                              $fecha3= $row_DatosReservaDia['fchFechaFin']; 
                              $fecha4=date("d-m-Y h:i:s A",strtotime($fecha3));

                              $fecha5= $row_DatosReservaDia['fchreserva']; 
                              $fecha6=date("d-m-Y h:i:s A",strtotime($fecha5));


   ?>

<div class="col-lg-8 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php  echo "Reservación # ". $row_DatosReservaDia['idReserva'] ; ?></h3>
                  <p><font color='fffff' size='+1'>Insertado en sistema el día: <?php echo  $fecha6 . " | Usuario que solicita : ". obtenerNombre($row_DatosReservaDia['refUsuario']);  ?></font></p>
                  <p><font color='red' size='+2'><?php echo "Fecha de Inicio: ". $fecha2. " | " . "Fecha de Fin:  ".$fecha4;  ?></font></p>
                  
                  <p><font color='fffff' size='+2'>Detalle: <?php echo $row_DatosReservaDia['direccion'];   ?> </font></p>

                </div>
                

                <?php if ($id_calendario == 1 ) { ?>
                <div class="icon">
                  <i class="fa fa-car"></i>
                </div>

                <?php } else if ( $id_calendario ==2) { ?>


                <div class="icon">
                  <i class=" fa fa-camera-retro"></i>
                </div>

                <?php }  ?>


                <a href="<?php echo "reservacion_calendario.php?id=". $id_calendario; ?>" class="small-box-footer"> 
                  <h2>Regresar <i class="fa fa-arrow-circle-right"></i> </h2>
                </a>
              </div>
            </div><!-- ./col -->
                   
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
    


  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosReservaDia);
?>
