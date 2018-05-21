<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->

<?php 


$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");
$oficio_in =  GetSQLValueString ($_GET ['oficio_id'], "int"); 
$oficio_responde = GetSQLValueString( obtenerOficioIdEntrada($oficio_in ), "int" ) ; 
$num_oficio_entrada = GetSQLValueString( obtenerNumeroOficioEntrada($oficio_in ), "text" ) ; 
$el_anno = GetSQLValueString($_GET['anno'], "int");
$anno_actual = date("Y");  

/*********************SQL PARA OBTENER JEFATURA QUE FIRMA OFICIOS ************/

$query_DatosDestinatarios = sprintf("SELECT * FROM jefaturas ORDER BY nombre ASC" );
$DatosDestinatarios = mysqli_query($con,  $query_DatosDestinatarios) or die(mysqli_error($con));
$row_DatosDestinatarios = mysqli_fetch_assoc($DatosDestinatarios);
$totalRows_DatosDestinatarios = mysqli_num_rows($DatosDestinatarios);

/*********************FIN SQL PARA OBTENER JEFATURA QUE FIRMA OFICIOS ************/

/********************** SQL PARA SABER SI ESTE OFICIO YA TIENE UNA RESPUESTA ************/

$query_DatosDestinatarios1 = sprintf(" SELECT oficio_id,oficio_id2, anno
     FROM info_oficios 
     WHERE oficio_id = $oficio_in and
           anno = $el_anno AND 
             oficio_id2 in (
                            SELECT respuesta
                            FROM info_oficios
                             WHERE respuesta > 0 AND
                             tipo_oficio = 0 and 
                             anno= $anno_actual   ) " );
$DatosDestinatarios1 = mysqli_query($con,  $query_DatosDestinatarios1) or die(mysqli_error($con));
$row_DatosDestinatarios1 = mysqli_fetch_assoc($DatosDestinatarios1);
$totalRows_DatosDestinatarios1 = mysqli_num_rows($DatosDestinatarios1);

/********************** FIN SQL PARA SABER SI ESTE OFICIO YA TIENE UNA RESPUESTA ************/

/************************* SQL PARA OBTENER EL OFICIO QUE DIO RESPUESTA **************/

$oficio_de_respuesta =  $row_DatosDestinatarios1['oficio_id2']; 

$query_DatosOficioRespuesta = sprintf(" SELECT * 
                                          FROM info_oficios
                                            WHERE tipo_oficio = 0 and 
                                                  respuesta = '$oficio_de_respuesta' AND
                                                  anno= $anno_actual" );
$DatosOficioRespuesta = mysqli_query($con,  $query_DatosOficioRespuesta) or die(mysqli_error($con));
$row_DatosOficioRespuesta = mysqli_fetch_assoc($DatosOficioRespuesta);
$totalRows_DatosOficioRespuesta = mysqli_num_rows($DatosOficioRespuesta);



/************************* FIN SQL PARA OBTENER EL OFICIO QUE DIO RESPUESTA **************/




   $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
   

$insertSQL = sprintf("INSERT into info_oficios (oficio_id1, anno, destinatario, asunto, usuario_inserta, tipo_oficio, cuerpo_oficio, cc_copia, id_jefatura, id_estado, respuesta) 
( SELECT (IFNULL( MAX(oficio_id1)+1, 1) ) as oficioidtemp, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s from info_oficios where anno=%s ORDER BY oficio_id DESC) limit 0,1",
                       
                        GetSQLValueString($_POST['anno'], "date"),
                        GetSQLValueString($_POST['destinatario'], "text"),
                        GetSQLValueString($_POST['asunto'], "text"),
                        GetSQLValueString($_POST['usuario_inserta'], "int"),
                        GetSQLValueString($_POST['tipo_oficio'], "int"),
                        GetSQLValueString($_POST['cuerpo_oficio'], "text"),
                        GetSQLValueString($_POST['cc_copia'], "text"),
                        GetSQLValueString($_POST['id_jefatura'], "int"),
                        GetSQLValueString($_POST['id_estado'], "int"),
                        GetSQLValueString($_POST['respuesta'], "int"),
                        GetSQLValueString($_POST['anno'], "date"));
  //echo $insertSQL ." nombre: ". $row_DatosUsuarios['nombre']. "<br>" ; 
 //$row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios);
  $Result1 = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));
      

 $insertGoTo = "oficio_generado.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

     <!-- CSS PARA LOS SCRIPTS DE LOS FORMULARIOS -->
     <link rel="stylesheet" href="css/extra.css">
    
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
            <?php echo $config['nombre_institucion'];?>   <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
            
            
            <li class="active">Respuesta Oficio Entrada</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header">
                  <h2 class="box-title">
                  Generación Oficio Respuesta  </h2>  <br> <br>
                  
              
                  <div class="pull-right box-tools">
                    
                    
                  </div><!-- /. tools -->
                </div><!-- /.box-header -->
                <div class="box-body pad">


                <?php 

                  if  ( $row_DatosDestinatarios1 > 0 ) { 
               ?>

               <div class="alert alert-danger">
                 <h3> Este Oficio ya fue respondido mediante el oficio de Salida No. <?php echo $row_DatosOficioRespuesta['oficio_id1'];  ?> </h3>
               </div> 


                 <a href="#demo" class="btn btn-info" data-toggle="collapse">Ver PDF </a>
                  <div id="demo" class="collapse">
                    
                    <div class="col-md-12">
        
                      <div class="embed-responsive embed-responsive-4by3">
                      <iframe class="embed-responsive-item" src="imagenes/oficios_out/<?php echo $row_DatosOficioRespuesta['imagen'];  ?>"></iframe>
                      </div>
                  </div>


                  </div>
                <br><br>

                          <div class="col-md-4">
      <div class="box box-solid box-default">
        <div class="box-header">
          <h3 class="box-title ion-ios-list-outline"> Regresar a ver listados por año</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="timeline-footer">
                      
                         <form name="ver_oficios" id="ver_oficios" method="post" action="listado_total_oficios_entrada_anno.php">
                            <div class="form-group" >
                              <label for="sel1">Seleccione el año:</label>
                              <select class="form-control" id="anno" name="anno">
               
                                  <?php 

                                  if ($totalRows_DatosDestinatarios1 > 0) 
                                          {  
                                         do {  
                                   ?>
                                 <option>
                                        <?php echo $el_anno; ?>
                                 </option>

                                        <?php 
                                           } while ($row_DatosDestinatarios1 = mysqli_fetch_assoc($DatosDestinatarios1)); 
                                               } 
                                              else
                                               { //MOSTRAR SI NO HAY RESULTADOS ?>
                                                          No hay resultados.
                                          <?php } ?>

                                
                              </select>
                              <button type="submit" class="btn btn-primary">Regresar</button>
                            </div>
                          </form>
                    </div>
                    
                  </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->


                  <?php 

                  } else { ?>

                  <div class="alert alert-success">
   <h3> Este Oficio da respuesta al oficio de entrada No.<?php echo $oficio_responde; ?> <strong>| Con el número de oficio: <?php echo $num_oficio_entrada; ?></strong> </h3>
</div> 

                  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onSubmit="javascript:return validaralta();">


                    <h2>Dirigido a: ( * nombre, puesto y detalles de la persona a quién se dirije el oficio)</h2>
                    <textarea id="destinatario" name="destinatario" rows="10" cols="80" ></textarea>

                    <div class="alert alert-danger oculto" role="alert" id="aviso2"><span class="glyphicon glyphicon-remove" ></span> Dirigido a  no debe ir vacío</div>

                     <h2>Asunto: (* debe ser un pequeño resumen de lo que contendrá el oficio)</h2>
                      
                    <textarea id="asunto" name="asunto" rows="10" cols="80"></textarea>

                    <div class="alert alert-danger oculto" role="alert" id="aviso3"><span class="glyphicon glyphicon-remove" ></span> El asunto no debe ir vacío</div>

                    
                    <h2>Texto del Oficio: (* este será el cuerpo del oficio )</h2>                      
                    <textarea id="cuerpo_oficio" name="cuerpo_oficio" rows="10" cols="80"></textarea>

                    <div class="alert alert-danger oculto" role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span> El asunto no debe ir vacío</div>

             
                        <h2>Copias para:  ( Ej.: Cc.: Archivo) </h2>
                        <textarea class="form-control" rows="4" rows="1" name="cc_copia" type="text" id="cc_copia" value=""></textarea>
                        
                        <div class="alert alert-danger oculto" role="alert" id="aviso4"><span class="glyphicon glyphicon-remove" ></span> La (as) copias no deben estar vacío</div>
  
                        <fieldset class="form-group">
                           
                            <h2>Jefatura que Firmará el documento: (* Será el responsable de la firma del oficio) </h2>
                            <select class="form-control" name="id_jefatura" id="id_jefatura">
                              <?php 
                        if ($totalRows_DatosDestinatarios > 0) {  
                               do { 

                                ?>
                              <option value="<?php echo $row_DatosDestinatarios['id_jefatura'];?>" ><?php echo $row_DatosDestinatarios['grado_academico'] ." " . $row_DatosDestinatarios['nombre']. " ". $row_DatosDestinatarios['apellido1'] ." " .$row_DatosDestinatarios['apellido2']?></option>
                            <?php 
                        } while ($row_DatosDestinatarios = mysqli_fetch_assoc($DatosDestinatarios)); 
                             } 
                            else
                             { //MOSTRAR SI NO HAY RESULTADOS ?>
                                        No hay resultados.
                                        <?php } ?>

                            </select>
                          </fieldset>
                          <div class="alert alert-danger oculto" role="alert" id="aviso5"><span class="glyphicon glyphicon-remove" ></span> Jefatura que firma no debe estar vacío</div>

                        <input name="tipo_oficio" type="hidden" id="tipo_oficio" value="0" />
                        <input name="anno" type="hidden" id="anno" value="<?php echo date('Y')?>" />
                        <input name="usuario_inserta" type="hidden" id="usuario_inserta" value="<?php echo $el_usuario; ?>" /></td>
                         <input name="respuesta" type="hidden" id="respuesta" value="<?php echo $oficio_responde;  ?>" /></td>
                          <input name="id_estado" type="hidden" id="id_estado" value="5" /></td>
                        <button type="submit" class="btn btn-primary">Crear Oficio Salida</button>

                             <input type="hidden" name="MM_insert" value="form1" />  

                  </form>

                  <?php } ?> 
                </div>
              </div><!-- /.box -->

           
            </div><!-- /.col-->
          </div><!-- ./row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
    
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- CK Editor -->
    <script src="plugins/ckeditor/ckeditor.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
         CKEDITOR.replace( 'asunto', {
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
        entities: false
    });

        CKEDITOR.replace( 'cc_copia', {
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
        entities: false
    });


        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
    </script>


    <script>
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
         CKEDITOR.replace( 'destinatario', {
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
        entities: false
    });


        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
    </script>

      <script>
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
         CKEDITOR.replace( 'cuerpo_oficio', {
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
        entities: false
    });


        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
    </script>

    <script>

function validaralta()
{
    valid = true;
  $("#aviso1").hide("slow");
  $("#aviso2").hide("slow");
  $("#aviso3").hide("slow");
  $("#aviso4").hide("slow");
  $("#aviso5").hide("slow");


  

  //COLORES
  if (CKEDITOR.instances.asunto.getData()== "" ){
    $("#aviso1").show("slow");
      valid = false;
  }
  
  if (CKEDITOR.instances.destinatario.getData() == ""){
    $("#aviso2").show("slow");
      valid = false;
  }
  
 if (CKEDITOR.instances.cuerpo_oficio.getData() == ""){
    $("#aviso3").show("slow");
      valid = false;
  }

   if (CKEDITOR.instances.cc_copia.getData() == ""){
    $("#aviso4").show("slow");
      valid = false;
  }

  if (document.form1.id_jefatura.value == ""){
    $("#aviso5").show("slow");
      valid = false;
  }
  

  return valid;
}
</script>
    <!-- page script -->





  </body>
</html>

