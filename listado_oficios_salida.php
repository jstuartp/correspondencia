<?php require_once('Connections/conexion.php');
 require 'DAO_infoOficios.php';
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php


$_DAOInfoOficios = new DAO_infoOficios();

/*
$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE tipo_oficio=0 ORDER BY info_oficios.oficio_id DESC" );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios  = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);
*/
if ($_GET){
        $DatosOficios = $_DAOInfoOficios->GetInfoOficiosSalidaPorAnio($_GET['anno']);    
} else {
    
        $DatosOficios = $_DAOInfoOficios->GetInfoOficiosSalida();    
}

$row_DatosOficios = $_DAOInfoOficios->GetArrayDatos($DatosOficios);
$totalRows_DatosOficios = $_DAOInfoOficios->GetNumRows($DatosOficios);


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
            <li class="active">Listado Oficios Salida anno</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-open-file" aria-hidden="true"></span>
                  <h3 class="box-title">Lista de oficios que se han generado</h3>
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
                    </table>
                    <br><br>
                    <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Oficio</th>
                        <th>Asunto</th>
                        <th>Remitente</th>  
                        <th>Dependencia</th>
                        <th>Fecha</th>
                        <th hidden="true">Fecha2</th>
                        <th>Imprime/Modifica</th>

                        <?php

                            if ( $el_usuario == $usuario_autorizado_ver)
                              { ?>
                        <th>PDF Recibido</th>
                        <?php } ?>

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
                        <td><?php echo $config['nomeclatura_dependencia'] . $row_DatosOficios["oficio_id1"] ."-". $row_DatosOficios["anno"]; ?></td>
                        <td>
                          <?php

                                $la_cadena = $row_DatosOficios["asunto"];
                                 $resultado = substr(".$la_cadena.", 1, 200);
                                 echo $la_cadena ;
                                  //echo $row_DatosOficios["asunto"];
                            ?>
                        </td>
                        <td> <?php echo $row_DatosOficios["remitente"];?></td>
                        <td> <?php echo $row_DatosOficios["unidad_entidad"]; ?></td>
                        
                        <td><?php echo date('d-m-Y', strtotime($row_DatosOficios["fecha"]));  ?></td>
                        <td hidden="true"><?php echo $row_DatosOficios["fecha"];  ?></td>
                        
          <!-- LINK PARA IMPRIMIR EL OFICIO -->


          <td> 

              <a href="imprime_oficio_salida.php?oficio_id=<?php echo $row_DatosOficios['oficio_id']; ?>" target="_blank"><div class="col-md-3 col-sm-4"><i class="glyphicon glyphicon-print text-green"></i></div></a>
          <?php 

          $usuario_sistema =  $el_usuario; 
          $usuario_genera = obtenerIdUsuario($row_DatosOficios["usuario_inserta"]);

          
          if ( $usuario_sistema == $usuario_genera )
                {  
                 if ( $row_DatosOficios['id_estado']== 5 ) { echo "no puede modificar " ;} else {      ?>
<!--          <a href="imprime_oficio_salida.php?oficio_id=<?php /*echo $row_DatosOficios['oficio_id'];*/ ?>" target="_blank"><div class="col-md-3 col-sm-4"><i class="glyphicon glyphicon-print text-green"></i></div></a> -->

<!--          <a href="imprime_oficio_salida_con_logo2.php?oficio_id=<?php echo $row_DatosOficios['oficio_id']; ?>" target="_blank"><div class="col-md-3 col-sm-4"><i class="glyphicon glyphicon-print text-red"></i></div></a> 
-->
          <a href="modifica_oficio_salida.php?oficio_id=<?php echo $row_DatosOficios['oficio_id']; ?>"><div class="col-md-3 col-sm-4"><i class="glyphicon glyphicon-wrench"></i></div></a>

          <?php 

            }
          } ?>
          </td>

           <!-- LINK PARA IMPRIMIR EL OFICIO -->   

                        <?php 


          if ( $el_usuario == $usuario_autorizado_ver)  /*if autorizado ver*/
                              { 

                          if ( $row_DatosOficios['imagen']!= '') 

                            {  ?>
                        <td> <a class="btn btn-block btn-primary btn-success view-pdf" data-asunto-in="<?php echo $row_DatosOficios["asunto"];?>" data-id-in="<?php echo $row_DatosOficios["oficio_id"];?>" data-numero-oficio-in="<?php echo $row_DatosOficios["oficio_id1"];?>" data-fecha-in="<?php echo $row_DatosOficios["fecha"];?>" href="imagenes/oficios_out/<?php echo $row_DatosOficios["imagen"];?>">Ver Oficio</a>   </td>

                        <?php 

                            } 

                                else  if ( $row_DatosOficios['imagen'] == '') //BOTON QUE GUARDE EL DOCUMENTO EN LA CARPETA
                                  {  ?>
                                      
                                         <td><a class="btn btn-warning summit" data-toggle="modal" data-id-in="<?php echo $row_DatosOficios["oficio_id"];?>" > Sin Recibido   </button> 
                                            <!-- <button type="button" class="btn btn-warning">Sin Recibido</button> --> </td>

                            <?php } 

                            }  /*fin if autorizado ver*/     ?> 
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
                  </table>
                    

                    
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <div class="alert alert-info alert-dismissable ">
                    <h4>Subir Oficio Recibido </h4>
                    
                  </div> 
      </div>
      <!-- body del modal con los datos de los usuarios para trasladar el oficio -->
                <div class="modal-body">
                        <?php   ?>

                 <!-- inicio del modal -->              
                          
                 <form action="infoOficios_Controller.php?flag=1" method="post" enctype="multipart/form-data" name="form2" id="form2" >
                       <div class="row">
                           <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="exampleInputFile">Subir Oficio Recibido</label>
                                <input type="file" id=imagen  name="imagen"><?php echo "hola:".$row_DatosOficios['oficio_id'];?>
                                <input type="hidden" name="id" id="id" value="<?php $row_DatosOficios['oficio_id']; ?>" />
                                
                            </div>
                           </div>
                       </div>
                     <input type="submit" value="Insertar Oficio" id="form2" />
                     <input type="hidden" name="MM_insert" value="form2" />
                 </form>
                 </div>
      </div>
      </div>
    </div>
                    
                    
                    
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
   /*   $(function () {

        $('#example2').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "order": [[ 0, "desc" ]], // orden de los resultados primero columna 0 los IN y luego por año columna 3
          "order": [[ 3, "desc" ]]
    //{ "orderData": [ 0, 1 ] },
   // { "orderData": 0, },
   // { "orderData": [ 2, 3, 4 ] },
        });
      });*/

// Assign moment to global namespace
//window.moment = require('../js/moment');
//var moment = require('js/moment');
//moment().format('MM-DD-YYYY');

// Set up your table
table = $('#example2').DataTable({
   "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "order": [[ 0, "desc" ]], // orden de los resultados primero columna 0 los IN y luego por año columna 3
          "order": [[ 3, "desc" ]]
})

// Extend dataTables search

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min  = $('#min-date').val();
        var max  = $('#max-date').val();
        var createdAt = data[5] || 0; // Our date column in the table
     
        
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

//$('#example2_filter').hide();



 /*
$(document).ready(function() {
    var table = $('#example2').DataTable();
     
    // Event listener to the two range filtering inputs to redraw on input
    $('#min, #max').keyup( function() {
        table.draw();
    } );
} );*/
      
      
      
      
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



</script>
  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosOficios);
?>
