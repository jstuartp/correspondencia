<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php 



$query_DatosHoteles = "SELECT * FROM tblpista WHERE intEstado=1 AND idPista=".GetSQLValueString($_GET["id"], "int");
$DatosHoteles = mysqli_query($con,  $query_DatosHoteles) or die(mysqli_error($con));
$row_DatosHoteles = mysqli_fetch_assoc($DatosHoteles);
$totalRows_DatosHoteles = mysqli_num_rows($DatosHoteles);

$resultado=ComprobarFechasLibresPista($_GET["id"], $_POST["apptStartTime"], $_POST["apptEndTime"]);



$hora= date ("h:i:s");
$fecha= date ("j/n/Y h:i:s");


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
            Detalle de reservación
                <?php echo $config['nombre_institucion'];?>    <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li><a href="reservacion_calendario.php?id=<?php echo GetSQLValueString($_GET["id"], "int")?>">Calendario</a></li>
          
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Detalle de la Reservación</h3>
                </div><!-- /.box-header -->
                

                <div class="box-body">
               
<?php 

                              $fecha1=$_POST["apptStartTime"];
                              $fecha2=date("d-m-Y h:i:s A",strtotime($fecha1));

                              $fecha3= $_POST["apptEndTime"]; 
                              $fecha4=date("d-m-Y h:i:s A",strtotime($fecha3));

?>

<h1><?php echo $row_DatosHoteles["strNombre"]." ".$row_DatosHoteles["strLocalidad"]." (".ObtenerProvincia($row_DatosHoteles["refProvincia"]). ")"; ?> </h1>

            <div class="col-lg-8 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>Hora Inicio: <?php echo $fecha1 ; ?></h3>
                  <p>Hora Finalización: <?php echo $fecha3 ;  ?></p>
                  <p>Detalle: : <?php echo $_POST["direccion"]?></p>
                </div>
                <div class="icon">
                  <i class="fa fa-calendar"></i>
                </div>

                <?php if ($resultado==1){
    //InsertarPrereserva(GetSQLValueString($_GET["id"], "int"), $_POST["apptStartTime"], $_POST["apptEndTime"]);
    ?>

                <a href="vehiculo-reserva.php?id=<?php echo GetSQLValueString($_GET["id"], "int")?>&FDesde=<?php echo $_POST["apptStartTime"]?>&FHasta=<?php echo $_POST["apptEndTime"]?>&FPropietario=<?php echo ObtenerPropietarioPista(GetSQLValueString($_GET["id"], "int"));?>&FPrecio=<?php echo $row_DatosHoteles["dblPrecio"];?>&direccion=<?php echo $_POST["direccion"] ?>&fecha_reserva=<?php echo $fecha ?>" role="button" " class="small-box-footer">
                 <h2>Reservar <i class="fa fa-arrow-circle-right"></i> </h2>
                </a>

                <?php }
  else
  {
  ?>
    <div class="alert alert-danger" role="alert" id="individual1">

    <span class="fa fa-frown-o fa-4" > <a href="reservacion_calendario.php?id=<?php echo GetSQLValueString($_GET["id"], "int")?>" ></span> <h2>Fechas no disponibles. Selecciona otro rango.</h2></div>
  <?php }?>
              </div>
            </div><!-- ./col -->
                  <!-- wcg -->

  
</div>
                  <!-- wcg -->
                   
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
mysqli_free_result($DatosOficios);
?>
