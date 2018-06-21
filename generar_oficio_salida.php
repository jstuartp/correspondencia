<?php require_once('Connections/conexion.php');
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->

<?php
require './detalleOficioSalida_Controller.php';
require "DAO_infoOficios.php";

$_daoInfoOficios = new DAO_infoOficios();

$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");

/*********************SQL PARA OBTENER JEFATURA QUE FIRMA OFICIOS ************/
$query_DatosDestinatarios = sprintf("SELECT * FROM jefaturas ORDER BY nombre ASC" );
$DatosDestinatarios = mysqli_query($con,  $query_DatosDestinatarios) or die(mysqli_error($con));
$row_DatosDestinatarios = mysqli_fetch_assoc($DatosDestinatarios);
$totalRows_DatosDestinatarios = mysqli_num_rows($DatosDestinatarios);
/*********************FIN SQL PARA OBTENER JEFATURA QUE FIRMA OFICIOS ************/

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

    $_fecha = strtotime($_POST['fecha']);
    $_anio = date('Y',$_fecha);
$firma1='';
$firma2='';
$firma3 ="";

    if($_POST['firmante1']!="Firma 1"){
    $firma1 = $_POST['firmante1'].'+'.$_POST['firmante1a']; }
    if ($_POST['firmante2']!="Firma 2"){
    $firma2 = $_POST['firmante2'].'+'.$_POST['firmante2a'];}
    if ($_POST['firmante3']!="Firma 3"){
    $firma3 = $_POST['firmante3'].'+'.$_POST['firmante3a'];}
    
   
    //Consulta para insertar datos del oficio a la base de datos
$insertSQL = sprintf("INSERT into info_oficios (oficio_id1, anno, destinatario, asunto, usuario_inserta, tipo_oficio, cuerpo_oficio, 
    cc_copia, id_jefatura,fecha,remitente,unidad_entidad, id_estado,destinatario_out,firma2,firma3) 
( SELECT (IFNULL( MAX(oficio_id1)+1, 1) ) as oficioidtemp, %s, %s, %s, %s, %s, %s, %s, %s,%s,%s, %s, %s,%s,%s, %s from info_oficios where anno=%s ORDER BY oficio_id DESC) limit 0,1",

                        GetSQLValueString($_anio, "date"),
                        GetSQLValueString($_POST['destinatario'], "text"),
                        GetSQLValueString($_POST['asunto'], "text"),
                        GetSQLValueString($_POST['usuario_inserta'], "int"),
                        GetSQLValueString($_POST['tipo_oficio'], "int"),
                        GetSQLValueString($_POST['cuerpo_oficio'], "text"),
                        GetSQLValueString($_POST['cc_copia'], "text"),
                        GetSQLValueString($_POST['id_jefatura'], "int"),
                        GetSQLValueString($_POST['fecha'], "date"),
                        GetSQLValueString($_POST['remitente'], "text"),
                        GetSQLValueString($_POST['unidad_entidad'], "text"),
                        GetSQLValueString($_POST['id_estado'], "text"),
                        GetSQLValueString($firma1, "text"),
                        GetSQLValueString($firma2, "text"),
                        GetSQLValueString($firma3, "text"),
                        GetSQLValueString($_anio, "date"));
 //echo $insertSQL ." nombre: ". $row_DatosUsuarios['nombre']. "<br>" ;
 //$row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios);
  $Result1 = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));

$yer_of_date= date('Y', strtotime($_POST['fecha']));                        
//Obtiene el nuevo ID                        
$newId = $_daoInfoOficios->GetInfoOficiosUltimoId1ByYear($yer_of_date);


/****************obtiene el id del registro recien ingresado****************************/
$consultaLastId = mysqli_query($con,  "SELECT (IFNULL( MAX(oficio_id),1))as id FROM info_oficios WHERE tipo_oficio = 0 ORDER BY oficio_id DESC") or die(mysqli_error($con));
$_consultaLastId= mysqli_fetch_assoc($consultaLastId);
$_lasId= $_consultaLastId['id'];
$_numOficio="FM".$newId."-".$yer_of_date; //   MODIFICAR SI SE QUIERE CAMBIAR EL FORMATO DEL NUMERO DE OFICIO DE SALIDA- SERIA FM45-2018
/***************************************************************************************/
$observaciones="Ingresado"; //SE QUEMAN LAS OBSERVACIONES PARA LA PRIMERA VEZ QUE SE INGRESA UN OFICIO DE SALIDA

$_detalleOficioSalida = new detalleOficioSalida_Controller();
$_detalleOficioSalida->SetDetallesOficiosSalida($_lasId, $_POST['id_estado'], $_POST['usuario_inserta'], $observaciones, $_POST['fecha'], $_numOficio);

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
            Oficios de Salida
                <?php echo $config['nombre_institucion'];?>   <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active">Generar Oficio Salida</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Editor generación de Oficios </h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->
                </div><!-- /.box-header -->
                <div class="box-body pad">
                  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onSubmit="javascript:return validaralta();">
                      
                    <h2>Fecha del oficio</h2>
                    <input name="fecha" id="fecha" type="date" class="form-control">
                    <div class="alert alert-danger oculto" role="alert" id="aviso6"><span class="glyphicon glyphicon-remove" ></span>Debe seleccionar la fecha de ingreso</div>
		                     
                    <h2>Asunto: (* Resumen del contenido del oficio)</h2>
                    <textarea id="asunto" name="asunto" rows="1" class="form-control"></textarea>
                    <div class="alert alert-danger oculto" role="alert" id="aviso7"><span class="glyphicon glyphicon-remove" ></span> El asunto no debe ir vacío</div>

                    <!-- MODIFICADO STUART -->
                    
                    <h2>Remitente: (* en caso de ser varios, solo el principal) </h2>
                    <textarea id="remitente" name="remitente" rows="1" class="form-control"></textarea>
                    <div class="alert alert-danger oculto" role="alert" id="aviso8"><span class="glyphicon glyphicon-remove" ></span> El remitente no puede ser vacío</div>
                    
                    <div id="interno">				
							<!-- Unidad (Interna) -->
							<fieldset class="form-group">
								<h2>Unidad de destino:(* en caso de ser varios, solo el principal)</h2>
								<select class="form-control" id="unidad" name="unidad_entidad">
									<option value="" >Seleccionar...</option>
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
                    
                    <h2>Dirigido a: ( * nombre, puesto y detalles de la persona a quien se dirige el oficio)</h2>
                    <textarea id="destinatario" name="destinatario" rows="5" cols="80" ></textarea>
                    <div class="alert alert-danger oculto" role="alert" id="aviso2"><span class="glyphicon glyphicon-remove" ></span> Dirigido a  no debe ir vacío</div>

                    <h2>Texto del Oficio: (* Cuerpo del oficio )</h2>
                    <textarea id="cuerpo_oficio" name="cuerpo_oficio" rows="10" cols="80"></textarea>
                    <div class="alert alert-danger oculto" role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span> El cuerpo del oficio no debe ir vacío</div>

					<h2>Copias para:</h2>
					<textarea class="form-control" rows="4" rows="1" name="cc_copia" type="text" id="cc_copia" value="C: Archivo"></textarea>
					<div class="alert alert-danger oculto" role="alert" id="aviso4"><span class="glyphicon glyphicon-remove" ></span> La (as) copias no deben estar vacío</div>

					<fieldset class="form-group">
                                            <h2>Jefatura que firmará el documento: (* Responsable de la firma del oficio) </h2>  
                        <select class="form-control" name="id_jefatura" id="id_jefatura">
                              <?php //Jala las jefaturas a quienes se asignará el oficio
                        if ($totalRows_DatosDestinatarios > 0) {
                               do {

                                ?>
                              <option value="<?php echo $row_DatosDestinatarios['id_jefatura'];?>" ><?php echo $row_DatosDestinatarios['grado_academico']. " ".$row_DatosDestinatarios['nombre']. " ". $row_DatosDestinatarios['apellido1'] ." " .$row_DatosDestinatarios['apellido2']?></option>
                            <?php 
                        } while ($row_DatosDestinatarios = mysqli_fetch_assoc($DatosDestinatarios));
                             } 
                            else
                             { //MOSTRAR SI NO HAY RESULTADOS ?>
                                        No hay resultados.
                                        <?php } ?>
                        </select>
                    </fieldset>
                                        <fieldset class="form-group ">
                                            <h2> Varias firmas? <input type="checkbox" class="varios" name="varios" value="ON"  /> </h2>
                                            <div id="firmas" style="display: none">
                                                <textarea class="form-control" rows="1"  name="firmante1" type="text" id="firmante1"  value="Firma 1">Firma 1</textarea>
                                                <textarea class="form-control" rows="1"  name="firmante1a" type="text" id="firmante1a"  value="Puesto firma 1">Puesto firma 1</textarea>
                                                <textarea class="form-control" rows="1"  name="firmante2" type="text" id="firmante2"  value="Firma 2">Firma 2</textarea>
                                                <textarea class="form-control" rows="1"  name="firmante2a" type="text" id="firmante2a"  value="Puesto firma 2">Puesto firma 2</textarea>
                                                <textarea class="form-control" rows="1"  name="firmante3" type="text" id="firmante3"  value="Firma 3">Firma 3</textarea>
                                                <textarea class="form-control" rows="1"  name="firmante3a" type="text" id="firmante3a"  value="Puesto firma 3">Puesto firma 3</textarea>
                                            </div>
                    </fieldset>                    
                    <div class="alert alert-danger oculto" role="alert" id="aviso5"><span class="glyphicon glyphicon-remove" ></span> Jefatura que firma no debe estar vacío</div>

                    <input name="tipo_oficio" type="hidden" id="tipo_oficio" value="0" />
                    <input name="id_estado" type="hidden" id="tipo_oficio" value="0" />
                    <input name="anno" type="hidden" id="anno" value="<?php echo date('Y')?>" />
                    <input name="usuario_inserta" type="hidden" id="usuario_inserta" value="<?php echo $el_usuario; ?>" />
                    <input name="id_estado" type="hidden" id="id_estado" value="1" />
                    <button type="submit" class="btn btn-primary">Crear Oficio Salida</button>
                    <input type="hidden" name="MM_insert" value="form1" />
                  </form>
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
        CKEDITOR.replace( 'destinatario', {
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
        entities: false
		});

        CKEDITOR.replace( 'cuerpo_oficio', {
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
        entities: false
		});
        


        CKEDITOR.replace( 'cc_copia', {
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
        entities: false
		});
		var t = "C: Archivo";
		CKEDITOR.instances.cc_copia.setData(t);

        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
    </script>

    <script>

$(document).ready(function(){
  $('.varios').on('change',function(){
     // alert('entro');
    if (this.checked) {
    document.getElementById('firmas').style.display='block';

     
     
    } else {
     document.getElementById('firmas').style.display='none';
    }  
  })
});


function validaralta()
{
    valid = true;
  $("#aviso1").hide("slow");
  $("#aviso2").hide("slow");
  $("#aviso3").hide("slow");
  $("#aviso4").hide("slow");
  $("#aviso5").hide("slow");

 
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
  if (document.form1.asunto.value == ""){
    $("#aviso7").show("slow");
      valid = false;
  }
  if (document.form1.remitente.value == ""){
    $("#aviso8").show("slow");
      valid = false;
  }

  return valid;
}
</script>
    <!-- page script -->

  </body>
</html>

