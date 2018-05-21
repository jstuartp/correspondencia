<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10");?> <!-- accesso -->
<?php

$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");


$query_DatosOficios = sprintf(" SELECT MAX(oficio_id) AS el_maximo_id
                                   FROM info_oficios " );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);


$ultimo_oficio_insertado= $row_DatosOficios['el_maximo_id'];

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


    <link rel="stylesheet" href="css/extra.css">
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
            <?php echo $config['nombre_institucion'];?>  <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>

            <li class="active">Oficio Generado</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Listado de oficios ingresados al sistema</h3>
                </div><!-- /.box-header -->

                <div class="box-body">
                  <div class="row">
                  <div class="col-md-6 ">
                  <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Oficio Generado</span>
                      <span class="info-box-number el_oficio texto_oficio ">
                      <?php echo  ObtenerOficioId ($ultimo_oficio_insertado);?></span>
                      <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                      </div>
                      <span class="progress-description">
                    </div><!-- /.info-box-content -->
                  </div><!-- /.info-box -->
                </div>
                </div>

                 <div class="row col-md-6" align="center">
                  <div class="col-sm-6"><a href="imprime_oficio_salida.php?oficio_id=<?php echo  ObtenerOficioIdImprimir ($ultimo_oficio_insertado); ?>" target="_blank" ><div class="col-md-6"><i class="fa fa-print fa-3x" ></i><br>Imprimir PDF</div></a> </div>
                  <div class="col-sm-6"><button class="btn btn-info botonCopiar">Copiar Número de Oficio</button></div>
                </div> 
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
var boton = document.querySelector('.botonCopiar');

boton.addEventListener('click', function(event) {
  // seleccionar el texto de la dirección de email
  var email = document.querySelector('.el_oficio');
  var range = document.createRange();
  range.selectNode(email);
  window.getSelection().addRange(range);

  try {
    // intentar copiar el contenido seleccionado
    var resultado = document.execCommand('copy');
    console.log(resultado ? 'copiado' : 'No se pudo copiar ');
  } catch(err) {
    console.log('ERROR al intentar copiar ');
  }

  // eliminar el texto seleccionado
  window.getSelection().removeAllRanges();
  // cuando los navegadores lo soporten, habría
  // que utilizar: removeRange(range)
});
</script>
  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosOficios);

?>
