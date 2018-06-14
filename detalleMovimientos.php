<?php require_once('Connections/conexion.php');
 require './DAO_oficio_usuario_log.php';
 require './DAO_infoOficios.php';
//RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php


$_detalleOficio = new DAO_oficio_usuario_log();
$_infoOficios = new DAO_infoOficios();


/*
$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE tipo_oficio=0 ORDER BY info_oficios.oficio_id DESC" );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios  = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);
*/
if (isset($_GET)){
        $DatosOficios= $_detalleOficio->GetTrasladosByOficioId($_GET['id']);
        $row_DatosOficios = $_detalleOficio->GetArrayDatos($DatosOficios); 
        $totalRows_DatosOficios = $_detalleOficio->GetNumRows($DatosOficios);
        
        $DatosCambio = $_detalleOficio->GetCambiosByOficioId($_GET['id']);
        $row_Cambios =  $_detalleOficio->GetArrayDatos($DatosCambio);     
        $totalRows_Cambios = $_detalleOficio->GetNumRows($DatosCambio);
        
        
} else {
    
        //$DatosOficios = $_DAOInfoOficios->GetInfoOficiosSalida();    
}
/*
$row_DatosOficios = $_DAOInfoOficios->GetArrayDatos($DatosOficios); */



$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");
$usuario_autorizado = GetSQLValueString(obtenerUsuarioAutorizadoEliminar($_SESSION ['reservas_UserId']), "int"); 
$usuario_autorizado_ver = GetSQLValueString(obtenerUsuarioAutorizadoVer($_SESSION ['reservas_UserId']), "int");






?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $config['titulo_del_sitio']; ?></title>
  
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

   
  </head>
  <body class="">
    <div class="wrapper">

         <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Detalle de Movimientos para el Oficio: <?php echo $_infoOficios->GetNumOficioEntradaById($_GET['id']); ?></h3>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>Detalle de Cambios de Estado</h2>
                            <br><br>
                        </div>
                        
                    </div>
                    <table id="tablaCambios" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                       

                        <th>Usuario Actual</th>
                        <th>Fecha de Cambio</th>
                        <th>Detalle del Cambio</th>  
                        <th>Nuevo Estado</th>
                        <th hidden="true">Fechacambio</th>
                      </tr>
                    </thead>
                    <tbody>

              <?php
    //AQUI ES DONDE SE SACAN LOS DATOS, SE COMPRUEBA QUE HAY RESULTADOS
              if ($totalRows_Cambios > 0)
              {
                  do { 

              ?>
                      <tr>
                        
                       
                        <td> <?php echo obtenerNombre($row_Cambios["usuario_id"]); ?>  </td>
                        
                        <td> <?php echo date('d-m-Y H:i:s', strtotime($row_Cambios["fecha_cambios"]));  ?></td>
                        
                        <td> <?php echo $row_Cambios["resp_usuario"]; ?> </td>
                        <td>  <!-- CODIGO PUESTO POR STUART -->
                              <?php //PASAR POR TODOS LOS ESTADOS PARA PONER LA IMAGEN QUE CORRESPONDA Y EL TEXTO

                        if ($row_Cambios["id_estado"] == 1)
                        {
                          ?>
                            <button type="button" class="btn btn-primary change"  >
                                <span class="glyphicon glyphicon-eye-open"></span> Proceso Administrativo </button>
                         <!--   <a class="btn btn-primary "  data-toggle="modal" data-target="#modalCambiaEstado" > -->
                             <!-- <span class="glyphicon glyphicon-eye-open"></span> Proceso Administrativo -->
                            </a> 
                        <?php 
                        }  else if ($row_Cambios["id_estado"] == 2 )
                        
                        { ?>
                            <a data-toggle="modalCambiaEstado" class="btn btn-warning change" >
                              <span class="glyphicon glyphicon-folder-open"></span> En Trámite
                            </a>  
                         
                        <?php }

                        else if ($row_Cambios["id_estado"] == 3 )
                        { ?>
                            <a href="" class="btn btn-danger change" >
                                <span class="glyphicon glyphicon-time"></span> Pendiente de Trámite
                            </a>
                        <?php 
                        }

                        else if ($row_Cambios["id_estado"] == 4 )
                        {
                          ?>
                          <a href="" class="btn label-warning change" >
                                <span class="glyphicon glyphicon-question-sign"></span> Esperando Respuesta
                            </a>
                      <?php
                        }
                        
                        else if ($row_Cambios["id_estado"] == 5 )
                        {
                          ?>
                          <a  class="btn label-success " >
                                <span class="glyphicon glyphicon-ok"></span> Finalizado
                            </a>
                      <?php
                        }
                        
                        else if ($row_Cambios["id_estado"] == 6 )
                        {
                          ?>
                          <a href="" class="btn label-info change" >
                                <span class="glyphicon glyphicon-eye-open"></span> Revisión Doctor
                            </a>
                      <?php
                        }
                        
                        else if ($row_Cambios["id_estado"] == 7 )
                        {
                          ?>
                          <a href="" class="btn label-warning change" >
                                <span class="glyphicon glyphicon-refresh"></span> Devuelto
                            </a>
                      <?php
                        }

                         ?>
                              <!-- CODIGO PUESTO POR STUART -->
                          </td>
                        
                        
                          <td hidden="true"><?php echo $row_Cambios["fecha_cambios"];?>?></td>   
                      </tr> 

                      <?php 

                                            
                                            } while ($row_Cambios = mysqli_fetch_assoc($DatosCambio)); 
                                 } 
                                else
                                 { //MOSTRAR SI NO HAY RESULTADOS ?>
                                            No hay resultados.
                                            <?php } 

                      ?>

           </tbody>

                  </table>
                
                    
                     <div class="row">
                        <div class="col-md-4">
                            <h2>Detalle de Traslados</h2>
                            <br><br>
                        </div>
                        
                    </div>
                    
                    
                    
                    
                    
                <table id="traslados" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                       
                        <th>Usuario que Traslada</th>
                        <th>Usuario Actual</th>
                        <th>Fecha de traslado</th>
                        <th>Detalle de Traslados</th>  
                        <th>Estado</th>
                        <th hidden="true">FechaTraslada2</th>
                      </tr>
                    </thead>
                    <tbody>

              <?php
    //AQUI ES DONDE SE SACAN LOS DATOS, SE COMPRUEBA QUE HAY RESULTADOS
              if ($totalRows_DatosOficios > 0)
              {
                  do { if($row_DatosOficios["usuario_traslada"]!="0"){

              ?>
                      <tr>
                        
                        <td> <?php echo obtenerNombre($row_DatosOficios["usuario_traslada"]); ?></td>
                        <td> <?php echo obtenerNombre($row_DatosOficios["usuario_id"]); ?>  </td>
                        
                        <td> <?php echo date('d-m-Y H:i:s', strtotime($row_DatosOficios["fecha_traslado"]));  ?></td>
                        
                        <td> <?php echo $row_DatosOficios["detalle_traslado"]; ?> </td>
                        <td>  <!-- CODIGO PUESTO POR STUART -->
                              <?php //PASAR POR TODOS LOS ESTADOS PARA PONER LA IMAGEN QUE CORRESPONDA Y EL TEXTO

                        if ($row_DatosOficios["id_estado"] == 1)
                        {
                          ?>
                            <button type="button" class="btn btn-primary change"  >
                                <span class="glyphicon glyphicon-eye-open"></span> Proceso Administrativo </button>
                         <!--   <a class="btn btn-primary "  data-toggle="modal" data-target="#modalCambiaEstado" > -->
                             <!-- <span class="glyphicon glyphicon-eye-open"></span> Proceso Administrativo -->
                            </a> 
                        <?php 
                        }  else if ($row_DatosOficios["id_estado"] == 2 )
                        
                        { ?>
                            <a data-toggle="modalCambiaEstado" class="btn btn-warning change" >
                              <span class="glyphicon glyphicon-folder-open"></span> En Trámite
                            </a>  
                         
                        <?php }

                        else if ($row_DatosOficios["id_estado"] == 3 )
                        { ?>
                            <a href="" class="btn btn-danger change" >
                                <span class="glyphicon glyphicon-time"></span> Pendiente de Trámite
                            </a>
                        <?php 
                        }

                        else if ($row_DatosOficios["id_estado"] == 4 )
                        {
                          ?>
                          <a href="" class="btn label-warning change" >
                                <span class="glyphicon glyphicon-question-sign"></span> Esperando Respuesta
                            </a>
                      <?php
                        }
                        
                        else if ($row_DatosOficios["id_estado"] == 5 )
                        {
                          ?>
                          <a  class="btn label-success " >
                                <span class="glyphicon glyphicon-ok"></span> Finalizado
                            </a>
                      <?php
                        }
                        
                        else if ($row_DatosOficios["id_estado"] == 6 )
                        {
                          ?>
                          <a href="" class="btn label-info change" >
                                <span class="glyphicon glyphicon-eye-open"></span> Revisión Doctor
                            </a>
                      <?php
                        }
                        
                        else if ($row_DatosOficios["id_estado"] == 7 )
                        {
                          ?>
                          <a href="" class="btn label-warning change" >
                                <span class="glyphicon glyphicon-refresh"></span> Devuelto
                            </a>
                      <?php
                        }

                         ?>
                              <!-- CODIGO PUESTO POR STUART -->
                          </td>
                        
                        
                          <td hidden="true"><?php echo $row_DatosOficios["fecha_traslado"];?>?></td>   
                      </tr> 

                      <?php 

                                            }
                                            } while ($row_DatosOficios = mysqli_fetch_assoc($DatosOficios)); 
                                 } 
                                else
                                 { //MOSTRAR SI NO HAY RESULTADOS ?>
                                            No hay resultados.
                                            <?php } 

                      ?>

           </tbody>

                  </table>

                    
         


                    
                    
                    
                </div><!-- /.box-body -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    </div><!-- ./wrapper -->

    <script  src="bootstrap/js/bootstrap-filestyle.min.js"></script>
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
  <!--  <script src="dist/js/demo.js"></script>
    <script src="plugins/moment/moment.js"></script>
    
    


    <!-- page script -->
    <script>
   table = $('#tablaCambios').DataTable({
   "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "order": [[ 4, "desc" ],[ 3, "desc" ]]
           // orden de los resultados primero columna 0 los IN y luego por año columna 3        
});
      
   table = $('#traslados').DataTable({
   "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "order": [[ 5, "desc" ],[ 4, "desc" ]]
           // orden de los resultados primero columna 0 los IN y luego por año columna 3        
});
      
      
      
    </script>

  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosOficios);
?>
