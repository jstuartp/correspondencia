<?php require_once('Connections/conexion.php');
 require './DAO_oficio_usuario_log.php';
 require './DAO_infoOficios.php';
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
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

         <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-open-file" aria-hidden="true"></span>
                  <h3 class="box-title">Detalles de movimientos de Oficios de Entrada</h3>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>Detalle de Movimientos para el Oficio: <?php echo $_infoOficios->GetNumOficioEntradaById($_GET['id']); ?></h2>
                            <br><br>
                        </div>
                        
                    </div>
                    <table id="example2" class="table table-bordered table-hover">
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
                    

                    
<!-- MODAL PARA CAMBIAR EL ESTADO AL OFICIO -->                    
<!-- Modal que contiene los nombres de los usuarios cambiar estado al oficio-->

<div class="modal fade" id="ModalCambiaEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
        <?php //echo $el_oficio;  ?>

 <!-- inicio del modal -->
                  <div class="callout callout-info">
                      <h4>Cambiar estado del oficio | <label id="Oficio_numero"> </label> </h4> 
                    <p>Fecha de ingreso: <label id="Oficio_fecha"> </label> </p>
                  </div>             
          
 <form action="InfoOficios_Controller.php?flag=2" method="post" name="formCambiaEstado" id="formCambiaEstado" >
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

                                                            
                                                   
        </div> 
        
  <br><br>
                    <div class="form-group">
                      <label for="observacion">Comentario de: | <?php echo obtenerNombre($el_usuario); ?>  </label>
                      <input type="text" class="form-control" id="resp_usuario" placeholder="Respuesta Usuario" name="resp_usuario" value="">
                    </div>
                 </table>
                  <input name="hidden_id_oficio" type="hidden" id="hidden_id_oficio"  />
                  <input type="hidden" name="MM_insert" value="formCambiaEstado" />
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
  
<!-- FIN MODAL PARA CAMBIAR ESTADO AL OFICIO -->                   


                    
                    
                    
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
<!--    <script src="dist/js/demo.js"></script>
    <script src="plugins/moment/moment.js"></script>
    
    


    <!-- page script -->
    <script>
   table = $('#example2').DataTable({
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
