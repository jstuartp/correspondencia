<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->

<?php 

  $el_oficio = $_GET['oficio_id'] ; 

  $query_DatosConsulta = sprintf("SELECT * 
                                   FROM oficios_bloqueados
                                   WHERE oficio_id= %s ", GetSQLValueString($el_oficio, "int"));
  $DatosConsulta = mysqli_query($con,  $query_DatosConsulta) or die(mysqli_error($con));
  $row_DatosConsulta = mysqli_fetch_assoc($DatosConsulta);
  $totalRows_DatosConsulta = mysqli_num_rows($DatosConsulta);

  if ($totalRows_DatosConsulta == '0')
  {
      $query_OficioAsignado= sprintf("SELECT * FROM oficios_usuario WHERE id_oficioin= %s ", GetSQLValueString($el_oficio, "int"));
      $OficioAsignado = mysqli_query($con,  $query_OficioAsignado) or die(mysqli_error($con));
      $row_OficioAsignado = mysqli_fetch_assoc($OficioAsignado);
      $totalRows_OficioAsignado = mysqli_num_rows($OficioAsignado);

     if ($totalRows_OficioAsignado == 1){ ?>   
      
                  <div class="callout callout-danger">
                    <h4>NO SE PUEDE ELIMINAR OFICIO </p>
                  </div>

        <div class="example-modal">
            <div class="modal modal-danger">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Este oficio no puede ser eliminado ya que ha sido asignado a: <?php echo "<br>".obtenerNombre ($row_OficioAsignado['usuario_id']);  ?></h4>
                  </div>
                  <div class="modal-body">
                    
                  <div class="modal-footer">
                    <a href="listado_oficios_entrada.php" class="btn btn-outline pull-left" data-dismiss="modal">Regresar</a>
                              </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
          </div><!-- /.example-modal -->
<?php 


     } else if ($totalRows_OficioAsignado ==0){

        $query_ConsultaFuncion = sprintf("
          SELECT * 
          FROM oficios_bloqueados, oficios_usuario
          WHERE oficios_bloqueados.oficio_id = oficios_usuario.id_oficioin and
                 oficios_bloqueados.oficio_id =  $el_oficio ");
          //echo $query_ConsultaFuncion;
          $ConsultaFuncion = mysqli_query($con,  $query_ConsultaFuncion) or die(mysqli_error($con));
          $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
          $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
          
            if ($totalRows_ConsultaFuncion == '0')
            {
               $query_Delete = sprintf("DELETE FROM info_oficios 
                           WHERE oficio_id = %s and  
                           NOT EXISTS (
                                   SELECT * 
                                   FROM oficios_bloqueados
                                   WHERE oficio_id= %s ); 
                                   ",
                       
                       GetSQLValueString($el_oficio, "int"), 
                       GetSQLValueString($el_oficio, "int")) ;
  
  
  //echo $query_Delete; 
  
  $ConsultaFuncion = mysqli_query($con,  $query_Delete) or die(mysqli_error($con));
  $insertGoTo = "listado_oficios_entrada.php";
  header(sprintf("Location: %s", $insertGoTo));
  mysqli_free_result($ConsultaFuncion);

            } 
     }
  }
  else if ($totalRows_DatosConsulta == 1)
  {
      
        ?>

                  <div class="callout callout-danger">
                    <h4>NO SE PUEDE ELIMINAR OFICIO </p>
                  </div>

        <div class="example-modal">
            <div class="modal modal-danger">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Este oficio no puede ser eliminado ya se encuentra bloqueado por: <?php echo "<br>".obtenerNombre($row_DatosConsulta['usuario_id']);  ?> </h4>
                  </div>
                  <div class="modal-body">
                    
                  <div class="modal-footer">
                    <a href="listado_oficios_entrada.php" class="btn btn-outline pull-left" data-dismiss="modal">Regresar</a>
                              </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
          </div><!-- /.example-modal -->
          <?php  

          
      
  }
  

  mysqli_free_result($DatosConsulta);



?>


<!DOCTYPE html>
<html>

 <style>
      .example-modal .modal {
        position: relative;
        top: auto;
        bottom: auto;
        right: auto;
        left: auto;
        display: block;
        z-index: 1;
      }
      .example-modal .modal {
        background: transparent !important;
      }
    </style>
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
    

 
                 

        



  </body>
</html>


