<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->

<?php
require "DAO_infoOficios.php";
require "DAO_jefaturas.php";

$_daoInfoOficios = new DAO_infoOficios();
$_daoJefaturas = new DAO_jefaturas();

$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");

$Datos_Oficio = $_daoInfoOficios->GetInfoOficiosById($_GET['oficio_id']);

$rowDatos_Oficio = $_daoInfoOficios->GetArrayDatos($Datos_Oficio);



//Obtiene los datos de las jefaturas
$query_DatosDestinatarios = sprintf("SELECT * FROM jefaturas ORDER BY nombre ASC" ); //Extrae todos los campos
$DatosDestinatarios = mysqli_query($con,  $query_DatosDestinatarios) or die(mysqli_error($con));
$row_DatosDestinatarios = mysqli_fetch_assoc($DatosDestinatarios);
$totalRows_DatosDestinatarios = mysqli_num_rows($DatosDestinatarios);//Cantidad de registros obtenidos

$query_DatosUnidades = sprintf("SELECT * FROM unidades ORDER BY nombre ASC" );
$DatosUnidades = mysqli_query($con,  $query_DatosUnidades) or die(mysqli_error($con));
$row_DatosUnidades = mysqli_fetch_assoc($DatosUnidades);
$totalRows_DatosUnidades = mysqli_num_rows($DatosUnidades);


   $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

    /*
                $archivos_disp_ar = array('pdf');
                $carpeta = 'imagenes/oficios_in/';
                $imagen = $_FILES['imagen']['tmp_name'];
                $nombre_orig = $_FILES['imagen']['name'];
                $array_nombre = explode('.',$nombre_orig);
                $cuenta_arr_nombre = count($array_nombre);
                $extension = strtolower($array_nombre[--$cuenta_arr_nombre]);

                      //validamos la extension
                      if(!in_array($extension, $archivos_disp_ar)) $error = "Este tipo de archivo no es permitido";

                      if(empty($error)){

                        //creamos nuevo nombre para que tenga nombre unico
                        $nombre_nuevo = time().'_'.rand(0,10).'.'.$extension;
						//echo $nombre_nuevo;
                        //nombre nuevo con la carpeta
                        $nombre_nuevo_con_carpeta = $carpeta.$nombre_nuevo;
                        //por fin movemos el archivo a la carpeta de imagenes
                        $mover_archivos = move_uploaded_file($imagen , $nombre_nuevo_con_carpeta);
                        //de damos permisos 777
                        chmod($nombre_nuevo_con_carpeta,0777);// este hay que comentarlo a la hora de pasarlo a produccion
*/
//extrae el anio de la fecha
$yer_of_date= date('Y', strtotime($_POST['fecha']));                        
//Obtiene el nuevo ID                        
$newId = $_daoInfoOficios->GetInfoOficiosUltimoId2ByYear($yer_of_date);

$imagen = $_FILES['imagen']['tmp_name'];
$carpeta = 'imagenes/oficios_in/'.$_POST['imagen1'];
$mover_archivos = move_uploaded_file($imagen , $carpeta);
//echo ($mover_archivos);

    //MODIFICAR EL OFICIO
    $update = $_daoInfoOficios->UpdateOficioEntrada($_POST['unidad_entidad'], $yer_of_date, $_POST['destinatario_in'],
            $_POST['asunto'], $_POST['fecha'], $_POST['no_oficio'], $_POST['imagen1'], $_POST['observaciones'], $_POST['remitente'],
            $_POST['tipo_oficio'], $_POST['id']);
    
    /*
$insertSQL = sprintf("INSERT into info_oficios (oficio_id2, fecha, anno, no_oficio, asunto, unidad_entidad, remitente, destinatario_in, usuario_inserta, tipo_oficio, observaciones, imagen, extension_archivos "
        . "id_estado, usuario_modifica) Values ( %s, %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)", 
               GetSQLValueString($newId, "int"),       
               GetSQLValueString($_POST['fecha'], "date"), // despues de este insertar nuevos campos recordar!!!
               GetSQLValueString($yer_of_date, "date"),
               GetSQLValueString($_POST['no_oficio'], "text"),
               GetSQLValueString($_POST['asunto'], "text"),
               GetSQLValueString($_POST['unidad_entidad'], "text"),
               GetSQLValueString($_POST['remitente'], "text"),
               GetSQLValueString($_POST['destinatario_in'], "text"),
               GetSQLValueString($_POST['usuario_inserta'], "int"),
               GetSQLValueString($_POST['tipo_oficio'], "int"),
               GetSQLValueString($_POST['observaciones'], "text"),
               GetSQLValueString($nombre_nuevo, "text"),
               GetSQLValueString($extension, "text"),
               GetSQLValueString($_POST['id_estado'], "int"),
               GetSQLValueString($_POST['usuario_modifica'], "int"));

	//		    echo $insertSQL;
			   
			   $Result1 = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));*/
//$LastId = $_daoInfoOficios->GetInfoOficiosLastId();
  $insertGoTo = "oficios_sin_asignar.php";
 /* if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
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
     <!-- CSS PARA LOS SCRIPTS DE LOS FORMULARIOS -->
     <link rel="stylesheet" href="css/extra.css">

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
            Oficios de Entrada
                <?php echo $config['nombre_institucion'];?>    <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active">Módulo Ingreso de correspondencia</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Módulo ingreso correspondencia</h3>
                </div><!-- /.box-header -->
                <div class="box-body pad"> <!-- inicio de contenido del formulario -->
                    <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="javascript:return validaralta();">
					
						<!-- Fecha de ingreso del oficio -->
						<h3>Fecha de ingreso:</h3> <?php  $_fecha = strtotime($rowDatos_Oficio['fecha']);  $_anio = date('Y-m-d',$_fecha); ?>
                                                <input name="fecha" id="fecha" type="date" class="form-control" value="<?php echo $_anio; ?>">
						<div class="alert alert-danger oculto" role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span>Debe seleccionar la fecha de ingreso</div>
					
                                                <!-- Número de Oficio -->
						<h3>No. de Oficio:</h3>
						<textarea autofocus name="no_oficio" id="no_oficio" class="form-control" rows="1" type="text" value="<?php echo $rowDatos_Oficio['no_oficio']; ?>"><?php echo $rowDatos_Oficio['no_oficio']; ?></textarea>
						<div class="alert alert-danger oculto" role="alert" id="aviso2"><span class="glyphicon glyphicon-remove" ></span>El número de oficio no puede estar vacío</div>
                                                
                                                                                                
						<!-- Tipo de Oficio (Interno/Externo) -->
						<fieldset class="form-group">
                                                    <h3>Tipo:</h3>
                                                    <?php if($rowDatos_Oficio['tipo_oficio']== 1){ ?>
                                                    <select class="form-control" name="tipo_oficio" id="tipo_oficio"  onchange="cambiar(this)">
                                                        <option selected="true" value="1" >Interno</option>
                                                        <option value="2" >Externo</option>
                                                    </select>
                                                    <?php }else {  ?>
                                                    <select class="form-control" name="tipo_oficio" id="tipo_oficio"  onchange="cambiar(this)">
                                                        <option value="1" >Interno</option>
                                                        <option selected="true" value="2" >Externo</option>
                                                    </select>
                                                    <?php } ?>
                                                </fieldset>
						
						

						<div id="interno">				
							<!-- Unidad (Interna) -->
							<fieldset class="form-group">
								<h3>Unidad de procedencia:</h3>
								<select class="form-control" id="unidad" name="unidad_entidad" selected="<?php echo $rowDatos_Oficio['unidad_entidad']; ?>">
									<option value="<?php echo $rowDatos_Oficio['unidad_entidad'] ;?>" ><?php echo $rowDatos_Oficio['unidad_entidad'] ;?></option>
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
											
						<div id="externo" style="display: none">
							<!-- Entidad (Externa) -->
							<h3>Entidad de procedencia:</h3>
							<textarea id="entidad" class="form-control" rows="1" type="text" value="<?php echo $rowDatos_Oficio['unidad_entidad']; ?>"><?php echo $rowDatos_Oficio['unidad_entidad']; ?></textarea>
						</div>
						<div class="alert alert-danger oculto" role="alert" id="aviso3"><span class="glyphicon glyphicon-remove" ></span>Debe especificar la unidad o entidad de procedencia</div>

						<!-- Remitente -->
						<h3>Remitente:</h3>
						<textarea name="remitente" id="remitente" class="form-control" rows="1" type="text" value="<?php echo $rowDatos_Oficio['remitente']; ?>"><?php echo $rowDatos_Oficio['remitente']; ?></textarea>				
						<div class="alert alert-danger oculto" role="alert" id="aviso4"><span class="glyphicon glyphicon-remove" ></span>El remitente no puede estar vacío</div>

						<!-- Asunto del oficio -->
                        <h3>Asunto:</h3>
                        <textarea name="asunto" id="asunto" class="form-control" rows="1" type="text" value="<?php echo $rowDatos_Oficio['asunto']; ?>"><?php echo $rowDatos_Oficio['asunto']; ?></textarea>
                        <div class="alert alert-danger oculto" role="alert" id="aviso5"><span class="glyphicon glyphicon-remove" ></span>El asunto no puede estar vacío</div>

						<!-- Observaciones -->
                        <h3>Observaciones:</h3>
                        <textarea name="observaciones" id="observaciones" class="form-control" rows="3" type="text" value="<?php echo $rowDatos_Oficio['observaciones']; ?>"><?php echo $rowDatos_Oficio['observaciones']; ?></textarea>

 						<!-- A quien se traslada -->
                        <fieldset class="form-group">
							<h3>Asignar a:</h3>
                                                        <?php $_jefe = $_daoJefaturas->GetJefaturaById($rowDatos_Oficio['id_jefatura']); ?>
							<select class="form-control" name="destinatario_in" id="destinatario_in" selected="<?php echo ($_jefe['nombre']." ".$_jefe['apellido1']." ".$_jefe['apellido2']);?>">
								<?php 
								if ($totalRows_DatosDestinatarios > 0) {  
									do { 
								?>
								<option value="<?php echo $row_DatosDestinatarios['nombre']. " ". $row_DatosDestinatarios['apellido1'] ." " .$row_DatosDestinatarios['apellido2']?>" ><?php echo $row_DatosDestinatarios['grado_academico']. " ".$row_DatosDestinatarios['nombre']. " ". $row_DatosDestinatarios['apellido1'] ." " .$row_DatosDestinatarios['apellido2']?></option>
								<?php 
									} while ($row_DatosDestinatarios = mysqli_fetch_assoc($DatosDestinatarios)); 
								} 
								else
								{
								?>
									No hay resultados.
								<?php } ?>
							</select>
                        </fieldset>
						<br>
                        <div class="form-group">
                             <div class="row">
                                <div class="col-md-2">
                                    <label for="exampleInputFile">PDF Actual</label>
                                        <a class="btn btn-block btn-primary view-pdf" data-asunto-in="<?php echo $rowDatos_Oficio["asunto"];?>"  data-id-in="<?php echo $rowDatos_Oficio["oficio_id2"];?>" data-numero-oficio-in="<?php echo $rowDatos_Oficio["no_oficio"];?>" data-fecha-in="<?php echo $rowDatos_Oficio["fecha"];?>" href="imagenes/oficios_in/<?php echo $rowDatos_Oficio["imagen"];?>">Ver PDF</a>      
                                </div>
                             </div>
                            
                            
                            <br>
                          <label for="exampleInputFile">Cambiar PDF del Oficio</label>
                          <input type="file" id="imagen"  accept="application/pdf" name="imagen" >
                          <div class="alert alert-danger oculto" role="alert" id="aviso6"><span class="glyphicon glyphicon-remove" ></span>El documento debe ser un PDF</div>
                        </div>

						<table>
						  <tr valign="baseline">
							<td nowrap="nowrap" align="right">
                                                  <input name="tipo_archivos" type="hidden" id="tipo_archivos" value="general" /> <!--seria necesario verificar el tipo del archivo -->
							</td>
<!--							  <input type="hidden" name="fecha" id="fecha" />
-->							  <input name="usuario_inserta" type="hidden" id="usuario_inserta" value="<?php echo $el_usuario ; ?>" />
<!--							  <input name="tipo_oficio" type="hidden" id="tipo_oficio" value="1" />
-->							  <input name="anno" type="hidden" id="anno" value="<?php echo date('Y')?>" />
							  <input name="id_estado" type="hidden" id="id_estado" value="1" />
                                                          <input name="imagen1" type="hidden" id="imagen1" value="<?php echo $rowDatos_Oficio['imagen']; ?>" />
							  <input name="usuario_modifica" type="hidden" id="usuario_modifica" value="-1" />
                                                          <input name="id" type="hidden" id="id" value="<?php echo ($_GET['oficio_id']); ?>" />
<!--							  <input name="unidad_entidad" type="hidden" id="unidad_entidad" value="CCSSS" />
-->							  <input type="submit" value="Modificar Oficio" />
						  </tr>
						</table>
						<input type="hidden" name="MM_insert" value="form1" />
					</form>
                </div> <!-- fin inicio de contenido del formulario -->
			  </div><!-- /.box -->
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
    <script src="plugins/moment/moment.js"></script>
    <!-- page script -->

	<script>
		function validaralta()
		{
		  valid = true;
		  $("#aviso1").hide("slow"); //fecha
		  $("#aviso2").hide("slow"); //no. oficio
		  $("#aviso3").hide("slow"); //unidad-entidad
		  $("#aviso4").hide("slow"); //remitente
		  $("#aviso5").hide("slow"); //asunto

		   //Revisa campo fecha no vacío
		   if (document.form1.fecha.value == ""){
			$("#aviso1").show("slow");
			  valid = false;
		  }
		   //Revisa campo no. oficio no vacío
		  if (document.form1.no_oficio.value == ""){
			$("#aviso2").show("slow");
			  valid = false;
		  }
		   //Revisa campo unidad-entidad no vacío
		  if (document.form1.unidad.value == "" && document.form1.entidad.value == ""){
			$("#aviso3").show("slow");
			  valid = false;
		  }
		   //Revisa campo remitente no vacío
		  if (document.form1.remitente.value == ""){
			$("#aviso4").show("slow");
			  valid = false;
		  }
		   //Revisa campo asunto no vacío
		  if (document.form1.asunto.value == ""){
			$("#aviso5").show("slow");
			  valid = false;
		  }
                  //revisar si el documento a subir es un PDF*******************************************************
                    var archivo = document.form1.imagen.value;
                    extensionesPermitidas = new Array(".pdf");
                    miError = "";
                    if (!archivo){ }
                    else
                    {
                        extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
                        permitida = false;
                        for (var i = 0; i < extensionesPermitidas.length; i++) 
                        {
                            if (extensionesPermitidas[i] == extension) 
                                {
                                    permitida = true;
                                    break;
                                }
                        }
                        if (!permitida)
                        {
                            $("#aviso6").show("slow");
                            valid = false;
                        }
                    }
                  //*********************************************************************** revision de archivo
                  
		  return valid;
		}

		function cambiar(obj) {
			var selectBox = obj;
			var selected = selectBox.options[selectBox.selectedIndex].value;

			if(selected === '2'){
				interno.style.display = "none";
				externo.style.display = "block";
				document.getElementById("no_oficio").focus();
				document.getElementById("unidad").setAttribute("name", "");
				document.getElementById("entidad").setAttribute("name", "unidad_entidad");
			}
			else{
				interno.style.display = "block";
				externo.style.display = "none";
				document.getElementById("unidad").setAttribute("name", "unidad_entidad");
				document.getElementById("entidad").setAttribute("name", "");
			}
		}
	</script>
        
        
         <script>
(function(a){a.createModal=function(b){defaults={title:"",message:"Mensaje",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height: 720px;overflow-y: auto;"':"";html='<div class="modal fade" id="myModal">';html+='<div class="modal-dialog  modal-lg">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);

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
        title:'Oficio No: '+numero_oficio_in+'<br>Título:'+asunto_in.substring(0,100)+'...<br>Fecha: '+ fecha_in ,
        message: iframe,
        closeButton:true,
        scrollable:false
        });
        return false;        
    });    
})

</script>

    <!-- page script -->

  </body>
</html>

<?php
mysqli_free_result($DatosDestinatarios);
?>
