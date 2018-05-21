<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6");?> <!-- accesso -->
<?php 

$query_DatosUsuarios = sprintf("SELECT * 
                                      FROM usuarios 
                                      WHERE estado_usuario= 1 
                                      ORDER BY NOMBRE ASC" );
$DatosUsuarios = mysqli_query($con,  $query_DatosUsuarios) or die(mysqli_error($con));
$row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios);
$totalRows_DatosUsuarios = mysqli_num_rows($DatosUsuarios);



$fecha_actual = date("Y-m-d");  
$los_asignados = ObtenerTotalGrafico ($config['calendario_anno']); 

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

    <script type="text/javascript" src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript" src="dist/js/Chart.bundle.min.js"></script>

    <script type="text/javascript">
  $(document).ready(function(){
    var datos = {
      type: "pie",
      data : {
        datasets :[{
          data : [
            <?php  echo $los_asignados;  ?>
            
          ],
          backgroundColor: [
            "#F7464A",            
            "#FDB45C",
            "#3f9a3b",
            '#2acaff',
            
           
          ],
        }],
        labels : [
          "En Trámite",
          "Pendiente de Trámite",
          "Esperando Respuesta",
          "Finalizado",
          
        ]
      },
      options : {
        responsive : true,
      }
    };

    var canvas = document.getElementById('chart').getContext('2d');
    window.pie = new Chart(canvas, datos);

    setInterval(function(){
      datos.data.datasets.splice(0);
      var newData = {
        backgroundColor : [
          "#F7464A",          
          "#FDB45C",
          "#3f9a3b",
          '#2acaff',
         
        ],
        data : [<?php  echo $los_asignados;  ?>]
      };

      datos.data.datasets.push(newData);

      window.pie.update();

    }, 5000);





  });
  </script>
    
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
            Oficios de Entrada
                <?php echo $config['nombre_institucion'];?>  <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien-php"><i class="fa fa-dashboard"></i> Principal</a></li>
           
            <li class="active">Reporte actividad</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Informe de estados de correspondencia</h3>
                </div><!-- /.box-header -->
                

                <div class="box-body">
                <div class="col-md-8">
                  <div id="canvas-container" style="width:50%;">
                    <canvas id="chart" width="500" height="350"></canvas>

                       
       <div class="container">
  <h2>Gráfico Correspondencia asignada año 2017</h2>

 </div>
 </div>
 </div>
                </div> <br> <br>


                

  <div class="row">
    <div class="col-md-12">
       <div class="container">
  <h2>Desglose de correspondencia por asignada usuario :<?php //echo $los_asignados;  ?></h2>
  <p>La siguiente lista es un detalle de los estados en los que esta la correspondencia asignada por usuario:</p>                                                  
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Usuario ID</th>
        <th>Nombre</th>
        <th>Recien Asignados</th>
        <th>En Trámite</th>
        <th>Pendiente de Trámite</th>
        <th>Esperando Respuesta</th>
        <th>Finalizados</th>
        
      </tr>
    </thead>

    <tbody>

         <?php 
    //AQUI ES DONDE SE SACAN LOS DATOS, SE COMPRUEBA QUE HAY RESULTADOS
              if ($totalRows_DatosUsuarios > 0)
              {  
                  do { 
                              
              ?>
      <tr>
        <td><?php echo $row_DatosUsuarios['usuario_id']; ?></td>
        <td><?php echo ObtenerNombreApellido($row_DatosUsuarios['usuario_id']);            
        ?></td>
        <td><?php 
        
        /* Se llenan las variables necesarias con los conteos realizados en la base de datos, asi solo se cuenta una vez y no es necesario volver a la base
         * para los demas conteos
         */
        $_totalAsignados = ObtenerTotalPorEstado($row_DatosUsuarios['usuario_id'],9);
        $_totalEnTramite = ObtenerTotalPorEstado($row_DatosUsuarios['usuario_id'],2);
        $_totalPendientes = ObtenerTotalPorEstado($row_DatosUsuarios['usuario_id'],3);
        $_totalEsperandoRespuesta = ObtenerTotalPorEstado($row_DatosUsuarios['usuario_id'],4);
        $_totalFinalizados = ObtenerTotalPorEstado($row_DatosUsuarios['usuario_id'],5);
        
        //inicia el if para mostrar los totales solo con la variable y no con las llamadas a la base
              if ($_totalAsignados == 0 )
                {
                    echo "sin datos";

                } else 
             
              if ($_totalAsignados >= 10)

              {
                 ?>
                   
                   <a href="oficios_asignados_reporte.php?usuario_id=<?php echo $row_DatosUsuarios['usuario_id']; ?>" class="btn btn-danger" role="button">Tiene <?php echo ($_totalAsignados." ") ?> Recien Asignados</a>

                   <?php               

               } else 
              echo  ($_totalAsignados) ;
              ?>
            
                
         </td>
        
        <td><?php 

              if ($_totalEnTramite == 0 )
                {
                    echo "sin datos";

                } else 
             
              if ($_totalEnTramite >= 10)

              {
                 ?>
                   <button type="button" class="btn btn-warning">Tiene <?php echo $_totalEnTramite ?> En Tramite</button>  
                   <?php               

               } else 
              echo  $_totalEnTramite ;
              ?>
            
        </td>


        <td><?php 

          if ($_totalPendientes == 0 )
                {
                    echo "sin datos";

                } else 
             
              if ($_totalPendientes >= 10)

              {
                 ?>
                   <button type="button" class="btn btn-info">Tiene <?php echo ($_totalPendientes." ") ?> Pendientes</button>  
                   <?php               

               } else 



        echo $_totalPendientes; ?> </td>

        
        <td><?php 

          if ($_totalEsperandoRespuesta == 0 )
                {
                    echo "sin datos";

                } else 
             
              if ($_totalEsperandoRespuesta >= 10)

              {
                 ?>
                   <button type="button" class="btn btn-info">Tiene <?php echo ($_totalEsperandoRespuesta." ") ?> Pendientes</button>  
                   <?php               

               } else 



        echo $_totalEsperandoRespuesta; ?> </td>
        
        <td><?php 
        if ($_totalFinalizados == 0)
        {

          echo "sin datos";

          }  else  if ($_totalFinalizados > 0){
        
?>
       <button type="button" class="btn btn-success">Tiene <?php echo ($_totalFinalizados." ") ?> Finalizados</button>   
<?php 
        } ?></td>

        
      </tr>

          <?php 

                          } while ($row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios)); 
                                 } 
                                else
                                 { //MOSTRAR SI NO HAY RESULTADOS ?>
                                            No hay resultados.
                                            <?php } 

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
    



  </body>
</html>

