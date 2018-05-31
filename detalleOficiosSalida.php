<?php require_once('Connections/conexion.php');
 require './detalleOficioSalida_Controller.php';
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php


$_detalleOficioSalida = new detalleOficioSalida_Controller();

/*
$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE tipo_oficio=0 ORDER BY info_oficios.oficio_id DESC" );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios  = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);
*/
if (isset($_GET)){
        $DatosOficios= $_detalleOficioSalida->GetDetallesOficioSalida($_GET['id']);
        $row_DatosOficios = $_detalleOficioSalida->GetArrayData($DatosOficios); 
        $totalRows_DatosOficios = $_detalleOficioSalida->GetTotalRows($DatosOficios);
        
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
            Oficios de Salida
            <?php echo $config['nombre_institucion'];?>   <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active">Detalles Oficios de Salida</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-open-file" aria-hidden="true"></span>
                  <h3 class="box-title">Detalles para cada oficio de Salida</h3>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>Detalle de Movimientos para el Oficio: <?php echo $row_DatosOficios["numOficio"]; ?></h2>
                            <br><br>
                        </div>
                        <div class="col-md-4">
                            <a href="listado_oficios_salidaTodos.php?b=3" class="btn btn-primary" >
                                <span class="glyphicon glyphicon-ok"></span> Volver
                            </a>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                       
                        <th>Modificado por</th>
                        <th>Fecha Modificación</th>  
                        <th>Detalles Modificación</th>
                        <th>Último Estado</th>
                        <th hidden="true">Fecha2</th>
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
                        
                        <td>
                            
                          <?php echo obtenerNombre($row_DatosOficios["id_usuario"]); ?>
                        </td>
                        <td> <?php echo date('d-m-Y', strtotime($row_DatosOficios["fecha"]));  ?></td>
                        <td> <?php echo $row_DatosOficios["observaciones"]; ?></td>
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
                        
                        
                          <td hidden="true"><?php echo $row_DatosOficios["fecha"];?>?></td>     
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
           <tfoot>
            <tr>
                      
                        <th>Modificado por</th>
                        <th>Fecha Modificación</th>  
                        <th>Detalles Modificación</th>
                        <th>Último Estado</th>
                        <th hidden="true">Fecha2</th>
            </tr>
        </tfoot> 
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
    <script src="dist/js/demo.js"></script>
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
          "order": [[ 4, "desc" ],[ 0, "desc" ]]
           // orden de los resultados primero columna 0 los IN y luego por año columna 3        
})
    
    
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example2 tfoot th').each( function () {
        var title = $(this).text();
        if(title != 'Fecha2'){
        $(this).html( '<input type="text" size="15" placeholder="Buscar '+title+'" />' );}
    } );
 $('#example2 tfoot tr').appendTo('#example2 thead');
 
    // DataTable
    var table = $('#example2').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this; 
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) { 
               // alert(this.value);
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
        
} );
      
      
    </script>

    <script>

(function(a){a.createModal=function(b){defaults={title:"",message:"Mensaje:",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height: 720px;overflow-y: auto;"':"";html='<div class="modal fade" id="myModal">';html+='<div class="modal-dialog  modal-lg">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);

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
        title:' Oficio Salida No:'+numero_oficio_in+'<br>Título:'+asunto_in.substring(0,100)+'...<br>Fecha: '+ fecha_in,
        message: iframe,
        closeButton:true,
        scrollable:false
        });
        return false;
    });
})

$(function(){
    $(document.body).on('click','.summit',function(){
 //   $(document.body).on('click','.view-pdf',function(){
       
        var id_in = $(this).attr('data-id-in');
    //    var asunto_in= $(this).attr('data-asunto-in');
   //     var fecha_in = $(this).attr('data-fecha-in');
    //    var numero_oficio_in = $(this).attr('data-numero-oficio-in');
        var iframe = '<div class="iframe-container"><form action="infoOficios_Controller.php?flag=1" method="post" enctype="multipart/form-data" name="form2" id="form2" >'+
                       '<div class="row">'+
                           '<div class="col-md-4"> <div class="form-group"> <label for="exampleInputFile">Subir Oficio Recibido: '+id_in+'</label><input type="file" id=imagen  name="imagen">'+
                               '<input type="hidden" name="id" id="id" value="'+id_in+'" /></div></div></div>'+
                     '<input type="submit" value="Insertar Oficio" id="form2" />'+
                     '<input type="hidden" name="MM_insert" value="form2" />'+
                 '</form> </iframe></div>'
        $.createModal({
        title:'Subir Archivo',
        message: iframe,
        closeButton:true,
        scrollable:false
        });
        return false;
    });
})



/*
$(function(){
$(".change").click(function(e) {
 //   $(document.body).on('click','.view-pdf',function(){
       
        var id_in = $(this).attr('data-id-in');
        var name_in = $(this).attr('data-name');
        var date_in = $(this).attr('data-date');
        $('input[name="hidden_id_oficio"]').val(id_in);
        $('input[name="hidden_id_oficio"]').html(id_in);
       //$("hidden_id_oficio").val(id_in);
       $('#Oficio_numero').html(name_in); 
      $('#Oficio_fecha').html(date_in);
       
        $('#ModalCambiaEstado').modal('show');
  
        return false;
    });
})
*/



</script>
  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosOficios);
?>
