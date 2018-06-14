<?php require_once('Connections/conexion.php');
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php

$oficio_id= $_GET['oficio_id'];
$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");

/*********************SQL PARA OBTENER JEFATURA QUE FIRMA OFICIOS ************/

$query_DatosDestinatarios = sprintf("SELECT *
                                       FROM jefaturas
                                       ORDER BY nombre ASC" );
$DatosDestinatarios = mysqli_query($con,  $query_DatosDestinatarios) or die(mysqli_error($con));
$row_DatosDestinatarios = mysqli_fetch_assoc($DatosDestinatarios);
$totalRows_DatosDestinatarios = mysqli_num_rows($DatosDestinatarios);

/*********************FIN SQL PARA OBTENER JEFATURA QUE FIRMA OFICIOS ************/

/******************** SQL PARA OBTENER EL OFICIO DE SALIDA A MODIFICAR **********/
$query_DatosOficios = sprintf("SELECT *
                                  FROM info_oficios
                                  WHERE tipo_oficio=0  AND oficio_id = $oficio_id
                                  ORDER BY info_oficios.oficio_id DESC" );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);

/******************** SQL PARA OBTENER EL OFICIO DE SALIDA A MODIFICAR **********/

/*******************************DATOS DE LAS UNIDADES**********************************/

$query_DatosUnidades = sprintf("SELECT * FROM unidades ORDER BY nombre ASC" );
$DatosUnidades = mysqli_query($con,  $query_DatosUnidades) or die(mysqli_error($con));
$row_DatosUnidades = mysqli_fetch_assoc($DatosUnidades);
$totalRows_DatosUnidades = mysqli_num_rows($DatosUnidades);

/*******************************DATOS DE LAS UNIDADES**********************************/





$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {


    $updateSQL= sprintf("UPDATE info_oficios
                             SET
                             unidad_entidad=%s,
                             fecha=%s,
                             remitente=%s,
                             destinatario=%s,
                             asunto=%s,
                             cuerpo_oficio=%s,
                             cc_copia=%s,
                             id_jefatura=%s,
                             usuario_inserta=%s

                             WHERE oficio_id = $oficio_id ",
            GetSQLValueString($_POST['unidad_entidad'], "text"),
            GetSQLValueString($_POST['fecha'], "date"),
            GetSQLValueString($_POST['remitente'], "text"),
            GetSQLValueString($_POST['destinatario'], "text"),
            GetSQLValueString($_POST['asunto'], "text"),
            GetSQLValueString($_POST['cuerpo_oficio'], "text"),
            GetSQLValueString($_POST['cc_copia'], "text"),
            GetSQLValueString($_POST['id_jefatura'], "int"),
            GetSQLValueString($_POST['usuario_inserta'], "int"));


  $Result1 = mysqli_query($con,   $updateSQL) or die(mysqli_error($con));


  
  $insertGoTo = "oficio_generado.php?oficio_id=".$oficio_id;

  header(sprintf("Location: %s", $insertGoTo));
  
  /*
  $insertGoTo = "listado_oficios_salida.php";
 /* if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  */
}

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
            Oficios Salida | Modifica Oficios
            <?php echo $config['nombre_institucion'];?>   <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>

            <li class="active">Modificación oficio salida</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Editor para modificar Oficio Salida</h3>
                </div><!-- /.box-header -->

              <div class="col-md-12">
                    <div class="box box-solid box-primary">
                      <div class="box-header">
                        <h3 class="box-title">Formulario para modificar oficio salida</h3>
                      </div><!-- /.box-header -->
                      <div class="box-body">

                      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onSubmit="javascript:return validaralta();">

                    <h2>Fecha del oficio</h2> <?php  $_fecha = strtotime($row_DatosOficios['fecha']);  $_anio = date('Y-m-d',$_fecha);  ?>
                    <input name="fecha" id="fecha" type="date" class="form-control" value="<?php echo $_anio;?>">
                    <div class="alert alert-danger oculto" role="alert" id="aviso6"><span class="glyphicon glyphicon-remove" ></span>Debe seleccionar la fecha de ingreso</div>     
                          

                     <h2>Asunto: (* debe ser un pequeño resumen de lo que contendrá el oficio)</h2>

                    <textarea id="asunto" name="asunto" rows="1" class="form-control" ><?php echo htmlentities($row_DatosOficios['asunto'], ENT_COMPAT, 'utf-8'); ?></textarea>

                    <div class="alert alert-danger oculto" role="alert" id="aviso7"><span class="glyphicon glyphicon-remove" ></span> El asunto no debe ir vacío</div>

                    <!-- MODIFICADO STUART -->
                    
                    <h2>Remitente: (* en caso de ser varios, solo el principal) </h2>
                    <textarea id="remitente" name="remitente" rows="1" class="form-control"><?php echo htmlentities($row_DatosOficios['remitente'], ENT_COMPAT, 'utf-8'); ?> </textarea>
                    <div class="alert alert-danger oculto" role="alert" id="aviso8"><span class="glyphicon glyphicon-remove" ></span> El remitente no puede ser vacío</div>
                    
                    <div id="interno">				
							<!-- Unidad (Interna) -->
							<fieldset class="form-group">
								<h2>Unidad de destino:(* en caso de ser varios, solo el principal)</h2>
                                                                <select required="true" class="form-control" id="unidad" name="unidad_entidad" selected="<?php echo $row_DatosOficios['unidad_entidad'] ;?>">
									<option value="<?php echo $row_DatosOficios['unidad_entidad'] ;?>" ><?php echo $row_DatosOficios['unidad_entidad'] ;?></option>
									<?php
									if ($totalRows_DatosUnidades > 0) {  
										do {
									?>
									<option value="<?php echo $row_DatosUnidades['nombre']?>" ><?php echo $row_DatosUnidades['nombre']?></option>
									<?php
										} while ($row_DatosUnidades = mysqli_fetch_assoc($DatosUnidades));
									} 
									else
									{ 
									?>
										No hay resultados.
									<?php } ?>
								</select>
							 </fieldset>
						</div>
                    
                    <!-- MODIFICADO STUART -->
                    
                    
                    
                    <h2>Dirigido a: ( * nombre, puesto y detalles de la persona a quién se dirije el oficio)</h2>

                    <textarea name="destinatario" cols="80" rows="10" id="destinatario"><?php echo htmlentities($row_DatosOficios['destinatario'], ENT_COMPAT, 'utf-8'); ?></textarea>

                    <div class="alert alert-danger oculto" role="alert" id="aviso2"><span class="glyphicon glyphicon-remove" ></span> Dirigido a  no debe ir vacío</div>

                    


                    <h2>Texto del Oficio: (* este será el cuerpo del oficio )</h2>
                    <textarea id="cuerpo_oficio" name="cuerpo_oficio" rows="10" cols="80"><?php echo htmlentities($row_DatosOficios['cuerpo_oficio'], ENT_COMPAT, 'utf-8'); ?></textarea>

                    <div class="alert alert-danger oculto" role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span> El asunto no debe ir vacío</div>


                        <h2>Copias para:  ( Ej.: Cc.: Archivo) </h2>
                        <textarea class="form-control" rows="4" rows="1" name="cc_copia" type="text" id="cc_copia" ><?php echo htmlentities($row_DatosOficios['cc_copia'], ENT_COMPAT, 'utf-8'); ?></textarea>

                        <div class="alert alert-danger oculto" role="alert" id="aviso4"><span class="glyphicon glyphicon-remove" ></span> La (as) copias no deben estar vacío</div>

                        <fieldset class="form-group">

                            <h2>Jefatura que Firmará el documento: (* Será el responsable de la firma del oficio) </h2>
                            <select class="form-control" name="id_jefatura" id="id_jefatura">
                              <?php
                        if ($totalRows_DatosDestinatarios > 0) {
                               do {

                                ?>
                              <option value="<?php echo $row_DatosDestinatarios['id_jefatura'];?>" ><?php echo $row_DatosDestinatarios['nombre']. " ". $row_DatosDestinatarios['apellido1'] ." " .$row_DatosDestinatarios['apellido2']?></option>
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


                        <input name="usuario_inserta" type="hidden" id="usuario_inserta" value="<?php echo $el_usuario; ?>" /></td>
                        <button type="submit" class="btn btn-primary">Guardar Oficio</button>

                             <input type="hidden" name="MM_insert" value="form1" />

                  </form>
                      </div><!-- /.box-body -->
                    </div><!-- /.box -->
                 </div>




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
<!-- CK Editor -->
    <script src="plugins/ckeditor/ckeditor.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- page script -->
    <script>
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
   /*      CKEDITOR.replace( 'asunto', {
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
        entities: false
    });*/

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
  $("#aviso6").hide("slow");
  $("#aviso7").hide("slow");
  $("#aviso8").hide("slow");


  //COLORES
  

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
  if (document.form1.fecha.value == ""){
    $("#aviso6").show("slow");
      valid = false;
  }
 
  if (document.form1.asunto.value.toString().localeCompare("") == 0){
    $("#aviso7").show("slow");
    
      valid = false;
  }
  if (document.form1.remitente.value.toString().localeCompare("")== 0){
			$("#aviso8").show("slow");
			  valid = false;
		  }


  return valid;
}
</script>



  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosOficios);
mysqli_free_result($DatosDestinatarios);
?>
