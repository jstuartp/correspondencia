<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");?> <!-- accesso -->
<?php 



$query_DatosOficios = sprintf("SELECT * FROM tblpista ORDER BY idPista DESC " );
$DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
$row_DatosOficios = mysqli_fetch_assoc($DatosOficios);
$totalRows_DatosOficios = mysqli_num_rows($DatosOficios);


$query_DatosUsuarios = sprintf("SELECT * FROM usuarios ORDER BY usuario_id DESC " );
$DatosUsuarios = mysqli_query($con,  $query_DatosUsuarios) or die(mysqli_error($con));
$row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios);
$totalRows_DatosUsuarios = mysqli_num_rows($DatosUsuarios);


/****************** SQL PARA INSERCIÓN DE NUEVOS NIVELES WCG *****************/

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "nuevonivel")) {


  $insertSQL = sprintf("INSERT INTO tblpista (  refUsuario,  
                                                strNombre, 
                                                intEstado,  
                                                refProvincia, 
                                                strLocalidad, 
                                                strDescripcion, 
                                                strDireccion , 
                                                /*fchAlta, */
                                                dblPrecio,   
                                                imagen ) 
                                                VALUES (%s, %s,%s, %s,%s, %s,%s ,%s ,%s )",
                       GetSQLValueString($_POST['refUsuario'], "int"),
                       GetSQLValueString($_POST['strNombre'], "text"),
                        GetSQLValueString($_POST['intEstado'], "int"),
                         GetSQLValueString($_POST['refProvincia'], "text"),
                          GetSQLValueString($_POST['strLocalidad'], "text"),
                           GetSQLValueString($_POST['strDescripcion'], "text"),
                            GetSQLValueString($_POST['strDireccion'], "text"), 
                            // GetSQLValueString($_POST['fchAlta'], "date"),
                              GetSQLValueString($_POST['dblPrecio'], "text"),
                               GetSQLValueString($_POST['imagen'], "text"));

  
  $Result1 = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));


  $insertGoTo = "nuevo_item_reservas.php";
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
            Área de TI | Administración de sitio
            <?php echo $config['nombre_institucion'];?>  <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
         
            <li class="active">Nuevo Nivel</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Insertar nueva sala o vehículo</h3>
                </div><!-- /.box-header -->
                
              <div class="col-xl-12">
                    <div class="box box-solid box-primary">
                      <div class="box-header">
                        <h3 class="box-title">Formulario para insertar nueva Sala en calendario</h3>
                      </div><!-- /.box-header -->
                      <div class="box-body">
                       
                      <div class="col-md-6">
                       <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="nuevonivel" id="nuevonivel" onSubmit="javascript:return validaralta();">
 <!-- ALERT PARA INDICAR QUE CAMPO NO DEBE ESTAR VACIO WCG -->
                                              

                              <div class="form-group">
                              <label for="descripcion" class="control-label">Asignar a usuario</label>
                               <select class="form-control" id="refUsuario" name="refUsuario">
                                 <?php 

                                  if ($totalRows_DatosUsuarios > 0) 
                                          {  
                                         do {  
                                   ?>
                                <option value="<?php echo $row_DatosUsuarios['usuario_id'];?>" ><?php echo $row_DatosUsuarios['nombre']. " ". $row_DatosUsuarios['apellido1'] ." " .$row_DatosUsuarios['apellido2']?></option>
                                  <?php 
                                           } while ($row_DatosUsuarios = mysqli_fetch_assoc($DatosUsuarios)); 
                                               } 
                                              else
                                               { //MOSTRAR SI NO HAY RESULTADOS ?>
                                                          No hay resultados.
                                          <?php } ?>
                              </select>
                              </div>

                                <div class="input-group">
                                <span class="input-group-addon">Nombre:</span>
                                <input id="strNombre"  name="strNombre" type="text" class="form-control" name="msg" placeholder="Nombre de la Sala o Vehículo">
                              </div>
                                </br>
                              

                               
                                <label for="comment">Estado de la Sala:</label>
                              <select class="form-control col-sm-10" id="intEstado" name="intEstado" >
                                <option value="1">Activo (a)</option>
                                <option value="0">Inactivo (a)</option>
                                
                              </select> 

                             
                             <div class="input-group">
                                <span class="input-group-addon">Horario:</span>
                                <input id="strLocalidad"  name="strLocalidad" type="text" class="form-control" placeholder="Horario de la Sala o Vehículo">
                              </div>
                                </br>

                                 <div class="input-group">
                                <span class="input-group-addon">Descripción:</span>
                                <input id="strDescripcion"  name="strDescripcion" type="text" class="form-control" placeholder="Descripción de la Sala o Vehículo">
                              </div>
                                </br>

                                <div class="input-group">
                                <span class="input-group-addon">Dirección:</span>
                                <input id="strDireccion"  name="strDireccion" type="text" class="form-control" placeholder="Descripción de la Sala o Vehículo">
                              </div>
                                </br>

                            


                                                                          
                                     <div class="alert alert-danger oculto " role="alert" id="aviso1"><span class="glyphicon glyphicon-remove" ></span>La descripción del nivel no debe estar vacia</div>                

                             <input type="hidden" name="MM_insert" value="nuevonivel" />
                              <input type="hidden" name="dblPrecio" id="dblPrecio" value="0"/>
                              <input type="hidden" name="refProvincia" id="refProvincia" value="2"/>
                              <input type="hidden" name="imagen" id="imagen" value="sala.jpg"/> 
                              
                            <br><br><br><br>
                               <button type="submit" value="Insertar Oficio" class="btn btn-primary">Insertar</button>

                     
                      </form>

                      </div>


                      </div><!-- /.box-body -->
                    </div><!-- /.box -->
                 </div>
                <div class="box-body col-xl-12">
                  <div class="bs-example" data-example-id="contextual-table"> 
                    <table class="table"> 
                                          <thead> 
                                            <tr> 
                                              <th>ID Nivel</th> 
                                              <th>Usuario Asignado</th>
                                              <th>Horario</th>
                                              <th>Descripción</th>  
                                              <th>Dirección</th>                                             
                                              <th>Modificar</th>
                                              <th>Estado</th>
                                            </tr> 
                                          </thead> 

                        <?php 
                       
                        if ($totalRows_DatosOficios > 0) {  
                           do {  ?>
                                          <tbody> 
                                          

                                          <tr class="info"> 
                                          <th scope="row"><?php echo $row_DatosOficios["idPista"]; ?></th> 
                                          <td><?php echo ObtenerNombreApellido ($row_DatosOficios["refUsuario"]); ?></td>

                                          <td><?php echo $row_DatosOficios["strLocalidad"]; ?></td> 
                                          <td><?php echo $row_DatosOficios["strDescripcion"]; ?></td>   
                                          <td><?php echo $row_DatosOficios["strDireccion"]; ?></td> 
                                          <td><?php 
                                          if ( $row_DatosOficios["intEstado"] == 1) {

                                            echo "ACTIVO"; 
                                          } else if 
                                           ( $row_DatosOficios["intEstado"] == 0){

                                            echo "INACTIVO"; 
                                           }

                                          ?></td> 
                                         

                                          <td><a href="modificar-item-reservas.php?la_pista=<?php echo $row_DatosOficios['idPista']; ?>"><div class="col-md-3 col-sm-4"><i class="glyphicon glyphicon-wrench"></i> </div></a></td>

                                          </tr> 

                                           </tbody> 

                      <?php 
                                            } while ($row_DatosOficios = mysqli_fetch_assoc($DatosOficios)); 
                         } 
                        else
                         { //MOSTRAR SI NO HAY RESULTADOS ?>
                                    No hay resultados.
                                    <?php } ?>


                    </table> 

                  </div>
                   
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
    <script>

function validaralta()
{
  valid = true;
  $("#aviso1").hide("slow");
  
  
  //COLORES
  if (document.nuevonivel.descripcion.value == ""){
    $("#aviso1").show("slow");
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
?>
