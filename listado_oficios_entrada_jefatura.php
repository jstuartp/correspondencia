<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6");?> <!-- permisos para accesso a estas páginas-->
<?php 

require 'DAO_infoOficios.php';


//$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE tipo_oficio=1 OR tipo_oficio=2 AND  id_estado = 7 ORDER BY info_oficios.oficio_id ASC" );


/************************ WCG1 CORRECCION A SQL  ****************//*
$query_DatosOficios = sprintf("SELECT *
                                FROM info_oficios
                                WHERE info_oficios.id_estado=1 and info_oficios.oficio_id 
                                NOT IN
                                      (SELECT oficios_usuario.id_oficioin
                                       FROM oficios_usuario)" ) ;

/************************ WCG1 FIN DE CORRECCION A SQL  ****************/
$_daoInfoOficios = new DAO_infoOficios();

$DatosOficios = $_daoInfoOficios->GetInfoOficiosSinAsignar(); 
$row_DatosOficios = $_daoInfoOficios->GetArrayDatos($DatosOficios);
$totalRows_DatosOficios =$_daoInfoOficios->GetNumRows($DatosOficios);

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
            Oficios nuevos de entrada para Revisión de Jefatura
                 <?php echo $config['nombre_institucion'];?>    <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
        
            <li class="active">Revisión Jefatura</li> 
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                  <h3 class="box-title">Listado de oficios nuevos ingresados al sistema</h3>
                </div><!-- /.box-header -->
                

                <div class="box-body">
                   <label for="">Buscar Fechas </label>
                    <table>
                        <tbody>
                            <tr>
                                <td>Desde:</td>                        
                                <td><input type="date" id="min-date" class="form-control date-range-filter" data-date-format="dd-mm-yyyy" placeholder="Desde:"></td>
                            </tr>
                            <tr>
                                <td>Hasta:</td>
                                <td><input type="date" id="max-date" class="form-control date-range-filter" data-date-format="dd-mm-yyyy" placeholder="Hasta:"></td>
                            </tr>
                        </tbody>
                    </table><br>
                    
                    
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Oficio No.</th>
                        <th>Asunto</th>
                        <th>Fecha</th>
                        <th hidden="true">date</th>
                        <th>Remitente</th>
                        <th>Dependencia</th>
                        <th>Observaciones</th>
                        <th>PDF</th>
                        <th>Detalle</th>
                        <th>Estado</th>
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
                       <!--   <td><?php //echo "IN-".  $row_DatosOficios["oficio_id2"]; ?></td> -->
                         <td><?php echo $row_DatosOficios["no_oficio"]; ?></td>
                         <td><?php echo $row_DatosOficios["asunto"];?></td>
                         <td><?php echo date('d-m-Y', strtotime($row_DatosOficios["fecha"]));?></td>
                         <td hidden="true"><?php echo $row_DatosOficios["fecha"] ;?></td>
                        <td> <?php echo $row_DatosOficios["remitente"];?></td>
                        <td> <?php echo $row_DatosOficios["unidad_entidad"];?></td>
                        <td> <?php echo $row_DatosOficios["observaciones"];?></td>
                        <td> <a class="btn btn-primary view-pdf" data-asunto-in="<?php echo $row_DatosOficios["asunto"];?>" data-id-in="<?php echo $row_DatosOficios["oficio_id2"];?>" data-numero-oficio-in="<?php echo $row_DatosOficios["no_oficio"];?>" data-fecha-in="<?php echo $row_DatosOficios["fecha"];?>" href="imagenes/oficios_in/<?php echo $row_DatosOficios["imagen"];?>">Ver PDF</a></td>
                        <td> 
                            <a href="detalle_oficio_in.php?oficio_id=<?php echo $row_DatosOficios["oficio_id"];?>" class="btn btn-warning" role="button">Ver Detalle</a>


                       </td>
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
    <script src="plugins/moment/moment.js"></script>
    <script>
table =$('#example2').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          //"scrollY": 400
           "order": [[ 0, "desc" ]], // orden de los resultados primero columna 0 los IN y luego por año columna 3
          "order": [[ 4, "desc" ]] 
        })
      // Extend dataTables search

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min  = $('#min-date').val();
        var max  = $('#max-date').val();
        var createdAt = data[3] || 0; // Our date column in the table
     
        
//alert(" Fecha escojo "+min+ " Fecha busco "+createdAt);
//alert("Iguales? "+moment(createdAt).isSameOrAfter(min));

     //   alert(min+" -- "+createdAt+" -- "+max);
     //   alert(moment(createdAt).isSameOrAfter(min));
        if  ( 
               ( min === "" || max === "" )
               || 
                ( moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max) ) 
            )
        {
           // alert("cumplio");
            return true;
        }
        //alert(min+" -- "+createdAt+" -- "+max);
        //alert('es igual o despues'+moment(createdAt).isSameOrAfter(min));
        //alert('es igual o antes'+moment(createdAt).isSameOrBefore(max));
       // alert("fallo");
        return false;
    }
);

// Re-draw the table when the a date range filter changes
$('.date-range-filter').change( function() {
   // alert("flag6 to draw");
    table.draw();
} );
    </script>

    <script>

(function(a){a.createModal=function(b){defaults={title:"",message:"Mensaje",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height: 1000px;overflow-y: auto;"':"";html='<div class="modal fade" id="myModal">';html+='<div class="modal-dialog  modal-lg">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);

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
  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosOficios);
?>
