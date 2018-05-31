<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php 

$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <!-- <title><?php //include(dirname(__FILE__)."/includes/institucion.php"); ?></title>-->

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

     <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         <section class="content-header">
              <a href="bien.php" class="logo" aling="center">
          <!-- mini logo for sidebar mini 50x50 pixels -->

              <span class="logo-lg" vertical-align="center"><img align="center" class="img-responsive" src="imagenes/banner1.png" alt="Universidad de Costa Rica - Facultad de Medicina"></span>
        </a>
             
             
    <!--      <h1>
            Bienvenido al Sistema de Correspondencia 
            <small>| <?php// echo $config['nombre_institucion']; ?> </small>
              <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
       <!--   </h1> -->

        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo cuentaOficiosAsignados2($el_usuario  ); ?></h3>
                  <p>Oficios Asignados</p>
                </div>
                <div class="icon">
                  <i class="ion ion-compose"></i>
                </div>
                <a href="oficios_en_tramite.php?tipo=1" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo cuentaOficiosTramite($el_usuario  ); ?> </h3>
                  <p>Oficios en Trámite</p>
                </div>
                <div class="icon">
                  <i class="ion ion-ios-paper"></i>
                </div>
                <a href="oficios_en_tramite.php?tipo=2" class="small-box-footer">Más Información<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
           <!--   <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php //echo cuentaOficiosTramitados($el_usuario  ); ?> </h3>
                  <p>Oficios Tramitados</p>
                </div>
                <div class="icon">
                  <i class="ion ion-ios-browsers"></i>
                </div>
                <a href="oficios_en_tramite.php?tipo=3" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
              </div> -->
            </div><!-- ./col -->
            
          </div><!-- /.row -->
          <!-- Main row -->
          
<!-- ROW PARA EL ESPACIO DEL TIMELINE Y LAS ACTIVIDADES DEL USUARIO -->
          <?php include ("includes/administracion.php");?>
<!-- FIN ROW PARA EL ESPACIO DEL TIMELINE Y LAS ACTIVIDADES DEL USUARIO -->
        </section><!-- /.content -->
        


      </div><!-- /.content-wrapper -->
      

      <!-- nombre en el footer para cambiar deacuerdo a la oficina WCG-->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 3.0
        </div>
        <strong><?php include("includes/desarrollador.php") ; ?></strong>
      </footer>


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

