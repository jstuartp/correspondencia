<?php require_once('DAO_enviados_old.php'); 
 require 'DAO_unidad.php';
 //require './infoOficios_Controller.php';

//RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php


$_DAOEnviadosOld = new DAO_enviados_old();
$_DAOUnidad = new DAO_unidad();

/*
$query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE tipo_oficio=0 ORDER BY info_oficios.oficio_id DESC" );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios  = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);
*/


$_anioConsulta = $_GET['anno'];

$DatosOficios = $_DAOEnviadosOld->GetEnviadosOldByYear($_anioConsulta);       


$row_DatosOficios = $_DAOEnviadosOld->GetArrayDatos($DatosOficios);
$totalRows_DatosOficios = $_DAOEnviadosOld->GetNumRows($DatosOficios);


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
            Oficios Enviados
            <?php echo $config['nombre_institucion'];?>   <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active">Listado Oficios Enviados Años Anteriores</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-open-file" aria-hidden="true"></span>
                  <h3 class="box-title">Listado Oficios Enviados Años Anteriores</h3>
                </div><!-- /.box-header -->

                <div class="box-body">
                     <div class="row">
                        <div class="col-md-6">
                             <h1>Mostrando resultados del año <?php echo $_anioConsulta; ?></h1>
                              <table>
                                <tbody>
                                       <tr> 
                                            <td> <h2>Si desea ver años anteriores favor escojer...</h2></td>                        
                                            <td><select style="width:120px" class="form-control anio" name="anio" data-b-in="<?php echo($_GET['b']); ?>" id="tipo_oficio" >
                                                                <option selected="true" disabled="disabled"><?php echo $_anioConsulta; ?></option>
                                                                <option value="2009" >2009</option>
                                                                <option value="2010" >2010</option>
                                                                <option value="2011" >2011</option>
                                                                <option value="2012" >2012</option>                                
                                                                <option value="2013" >2013</option>
                                                                <option value="2014" >2014</option>
                                                                <option value="2015" >2015</option>
                                                                <option value="2016" >2016</option>
                                                                <option value="2017" >2017</option>
                                                                <option value="2018" >2018</option>
                                                            </select></td>
                                       </tr>
                                </tbody> </table>
                      

                             <br><br>
                         </div>
                     </div>
                    <?php
                    if(isset($_GET['b'])){
                        if($_GET['b']=='1'){   //SI LA BUSQUEDA ES POR RANGO DE FECHAS
                            ?> 
                            <h2><label for="">Busqueda por rango de Fechas </label> </h2>
                            <table>
                                <tbody>
                                    <tr> <?php  $_fecha1 = strtotime("01/01/".$_anioConsulta) ;  $_anio1 = date('Y-m-d',$_fecha1);  ?>
                                            <td><h3>Desde:   </h3></td>                        
                                            <td><input type="date" id="min-date" class="form-control date-range-filter" value="<?php echo $_anio1;?>" data-date-format="dd-mm-yyyy" placeholder="Desde:"></td>
                                            <td><h3> &nbsp; &nbsp; &nbsp; &nbsp; </h3></td>                           
                                            <td><h3>Hasta:   </h3></td> <?php  $_fecha2 = strtotime("12/31/".$_anioConsulta);  $_anio2 = date('Y-m-d',$_fecha2);  ?>
                                            <td><input type="date" id="max-date" class="form-control  date-range-filter" value="<?php echo $_anio2;?>" data-date-format="dd-mm-yyyy" placeholder="Hasta:"></td>
                                       </tr>
                                </tbody>
                            </table><?php 
                            
                        }
                        if($_GET['b']=='2'){  //BUSQUEDA POR DETALLES 
                            ?> <h2>Busqueda con detalle</h2>
                               <br><br><?php
                        }
                        if($_GET['b']=='3'){ //BUSQUEDA POR PALABRA CLAVE
                            ?> <h2>Busqueda por palabra clave</h2>
                               <br><br><?php
                        }
 
                    }
                    ?>
                    <br><br>
                    <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        
                        <th>Oficio</th>
                        <th>Asunto</th>
                        <th>Remitente</th>  
                        <th>Dependencia</th>
                        <th>Fecha Envio</th>
                        
                        <th>Destinatario</th>
                        <th>Observaciones</th>
                      
                        <th>Archivo</th>
                        <th hidden="true">Fecha envio</th>                     
                        
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
                      
                        <td><?php echo $row_DatosOficios["oficio"];  ?></td>
                        <td>
                          <?php

                                $la_cadena = $row_DatosOficios["asunto"];
                                 $resultado = substr(".$la_cadena.", 1, 200);
                                 echo $resultado ;
                                  //echo $row_DatosOficios["asunto"];
                            ?>
                        </td>
                        <td> <?php echo $row_DatosOficios["remitente"];?></td>
                        <td> <?php $_unidad = $_DAOUnidad->GetUnidadById($row_DatosOficios["id_dependencia"]);  echo $_unidad['nombre']; ?></td>
                        
                        <td><?php echo date('d-m-Y', strtotime($row_DatosOficios["fecha_envio"]));  ?></td>
                        <td> <?php echo $row_DatosOficios["destinatario"]; ?></td>
                        <td> <?php 
                                    $la_cadena2 = $row_DatosOficios["observaciones"];
                                    $resultado2 = substr(".$la_cadena2.", 1, 200);
                                    echo $resultado2 ;
                                 ?></td>
                         <td>
                              <?php $fanioFile = date('Y',strtotime($row_DatosOficios["fecha_envio"])); ?>
                            <a class="btn btn-block btn-primary view-pdf" href="<?php echo("imagenes/enviadas_old/".$fanioFile."/".$row_DatosOficios["oficio"].".pdf"); ?> " class="btn label-info detalles"> 
                                   
                                <span class="glyphicon glyphicon-comment"></span> Detalles 
                            </a>
                          </td>   
                          <td hidden="true"><?php echo $row_DatosOficios["fecha_envio"];  ?></td>
                        
                        
                        
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
                        <th>Oficio</th>
                        <th>Asunto</th>
                        <th>Remitente</th>  
                        <th>Dependencia</th>
                        <th>Fecha Envio</th>
                        
                        <th>Destinatario</th>
                        <th>Observaciones</th>
                      
                        <th>Archivo</th>
                        <th hidden="true">Fecha envio</th>  
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
          
 <form action="infoOficios_Controller.php?flag=2" method="post" name="formCambiaEstado" id="formCambiaEstado" >
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
                  <input name="hidden_numOficio" type="hidden" id="hidden_numOficio"  />
                  <input name="id_usuario"  type="hidden" id="id_usuario" value="<?php echo $el_usuario; ?>" />
                  <input name="fecha_actual"  type="hidden" id="fecha_actual" value="<?php echo (date("Y-m-d H:i:s"));?>" />
                  <input name="b"  type="hidden" id="b" value="<?php echo ($_GET['b']) ?>" />
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
    <?php if(isset($_GET['b'])&&($_GET['b']==1)){ ?>
    <script>
// Set up your table
table = $('#example2').DataTable({
   "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "order": [[ 8, "desc" ],[0,"desc"]] // orden de los resultados primero columna 0 los IN y luego por año columna 3
          
})

// Extend dataTables search

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min  = $('#min-date').val();
        var max  = $('#max-date').val();
        var createdAt = data[8] || 0; // Our date column in the table
     
        
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
 //   alert("flag6 to draw");
    table.draw();
} );

</script> <?php } if(isset($_GET['b'])&&($_GET['b']==2)){ ?>
<script> 
   table = $('#example2').DataTable({
   "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "order": [[ 8, "desc" ],[ 0, "desc" ]]
           // orden de los resultados primero columna 0 los IN y luego por año columna 3        
})
    
    
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example2 tfoot th').each( function () {
        var title = $(this).text();
        if((title != 'Fecha2')&&(title != 'Imprime/Modifica')&&(title != 'PDF Recibido')&&(title != 'Detalles')){
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


</script> <?php } if(isset($_GET['b'])&&($_GET['b']==3)){ ?>
<script>
// Set up your table
table = $('#example2').DataTable({
    "language":{"search": "Buscar palabra clave"},
   "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "order": [[ 8, "desc" ],[0,"desc"]] // orden de los resultados primero columna 0 los IN y luego por año columna 3
          
});   

</script> <?php } ?>

    <script>

(function(a){a.createModal=function(b){defaults={title:"",message:"Mensaje:",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height: 720px;overflow-y: auto;"':"";html='<div class="modal fade" id="myModal">';html+='<div class="modal-dialog  modal-lg">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);

/*
* Here is how you use it
*/
$(function(){
    $(document.body).on('click','.view-pdf',function(){
        var pdf_link = $(this).attr('href');
        var iframe = '<div class="iframe-container"><iframe src="'+pdf_link+'"></iframe></div>'
        $.createModal({
        title:' Ver PDF ',
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




$(function(){
$(".change").click(function(e) {
 //   $(document.body).on('click','.view-pdf',function(){
       
        var id_in = $(this).attr('data-id-in');
        var name_in = $(this).attr('data-name');
        var date_in = $(this).attr('data-date');
        $('input[name="hidden_id_oficio"]').val(id_in);
        $('input[name="hidden_id_oficio"]').html(id_in);
         $('input[name="hidden_numOficio"]').val(name_in);
       //$("hidden_id_oficio").val(id_in);
       $('#Oficio_numero').html(name_in); 
      $('#Oficio_fecha').html(date_in);
      
      
       
        $('#ModalCambiaEstado').modal('show');
  
        return false;
    });
})


(function(a){a.createModal=function(b){defaults={title:"",message:"Mensaje:",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height: 720px;overflow-y: auto;"':"";html='<div class="modal fade" id="myModal">';html+='<div class="modal-dialog  modal-lg">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);

/*
* Here is how you use it
*/
$(function(){
    $(document.body).on('click','.view-pdf',function(){
        var pdf_link = $(this).attr('href');
        var iframe = '<div class="iframe-container"><iframe src="'+pdf_link+'"></iframe></div>'
        $.createModal({
        title:' Ver PDF ',
        message: iframe,
        closeButton:true,
        scrollable:false
        });
        return false;
    });
})

</script>

<script>
$(".anio").on('change',function(){
    var anio = $(this).val();
    var b = $(this).attr('data-b-in');
   location.href ="listado_enviados_old.php?anno="+anio+"&b="+b;
});

</script>
 


  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosOficios);
?>
