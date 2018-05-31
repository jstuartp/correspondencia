<?php 
$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");

$la_seccion = GetSQLValueString ( obtenerIDSeccionUsuario ($el_usuario), "int" ) ; 
                      
$el_correo_administrador =  $config['correo_administrador']; 

$query_DatosConsulta = sprintf("SELECT DISTINCT YEAR(fecha) as el_anno FROM info_oficios ORDER BY fecha DESC");
$DatosConsulta = mysqli_query($con,  $query_DatosConsulta) or die(mysqli_error($con));
$row_DatosConsulta = mysqli_fetch_assoc($DatosConsulta);
$totalRows_DatosConsulta = mysqli_num_rows($DatosConsulta);


$query_DatosConsultaAnno = sprintf("SELECT DISTINCT YEAR(fecha) as el_anno FROM info_oficios ORDER BY fecha DESC");
$DatosConsultaAnno = mysqli_query($con,  $query_DatosConsultaAnno) or die(mysqli_error($con));
$row_DatosConsultaAnno = mysqli_fetch_assoc($DatosConsultaAnno);
$totalRows_DatosConsultaAnno = mysqli_num_rows($DatosConsultaAnno);


$query_DatosConsultaAnno2 = sprintf("SELECT DISTINCT YEAR(fecha) as el_anno FROM info_oficios ORDER BY fecha DESC");
$DatosConsultaAnno2 = mysqli_query($con,  $query_DatosConsultaAnno2) or die(mysqli_error($con));
$row_DatosConsultaAnno2 = mysqli_fetch_assoc($DatosConsultaAnno2);
$totalRows_DatosConsultaAnno2 = mysqli_num_rows($DatosConsultaAnno2);



?>

          <!-- row -->
         <!-- Main content -->
      
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                
                <div class="callout callout-info lead">
              <h4>Estimado usuario: </h4>
              <p>Este espacio es para la administración del sitio si tiene algún inconveniente con el mismo favor contactar al encargado al correo : 

              <?php 

              echo $el_correo_administrador;  

              ?> </p>
            </div>

                   
<div class="row">
    


<?php   


/*********** LISTADO DE SECCIONES DE ADMINISTRACION PUBLICA */

//correo_administrador = pedro.miranda@ucr.ac.cr
/* 
seccion_administrativa = 1
seccion_subdireccion = 2
seccion_informatica = 3
seccion_jefatura = 4
seccion_archivo = 5
seccion_direccion = 6

*/



/************************************************************/        
          
          if ( 
               ( $la_seccion == $config['seccion_informatica']  ) or 
               ( $la_seccion == $config['seccion_jefatura'] ) or
               ( $la_seccion == $config['seccion_archivo'] ) or
               ( $la_seccion == $config['seccion_administrativa'] ) or
               ( $la_seccion == $config['seccion_direccion'] ) or
               ( $la_seccion == $config['seccion_subdireccion'] )  ){  
          ?>
    <div class="col-md-4">
      <div class="box box-solid box-default">
        <div class="box-header">
          <h3 class="box-title ion-ios-paper" >  Administración de Correspondencia:</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">

            <ul>
              <li><a href="oficio_in.php" >Ingreso de Correspondencia </a></li>
              <li><a href="generar_oficio_salida.php">Generar Oficio Salida </a></li>
              
              
            </ul>


        
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>

    <?php } ?>

    <?php           
          
          if ( $la_seccion == $config['seccion_informatica'] ) {  
          ?>
    <div class="col-md-4">
      <div class="box box-solid box-default">
        <div class="box-header">
          <h3 class="box-title ion-gear-b"> Área Informática</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <ul>
              <li><a href="nuevo-usuario.php" >Administración de usuarios</a></li>
              <li><a href="nuevo-nivel.php">Administración de niveles  </a></li>              
              <li><a href="nueva-seccion.php">Administración de secciones</a></li>
              <li><a href="nueva-jefatura.php">Administración de Jefaturas</a></li>
           <!--   <li><a href="nuevo_item_reservas.php" >Administración de salas</a></li> -->
              <li><a href="nuevo-usuario_permiso.php">Cambiar permisos para ver oficios</a></li>
            </ul>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>

   
       <?php } ?>



    <div class="col-md-4">
      <div class="box box-solid box-default">
        <div class="box-header">
          <h3 class="box-title ion-ios-list-outline"> Ver listado de oficios entrada por año</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="timeline-footer">
                      
                         <form name="ver_oficios" id="ver_oficios" method="get" action="listado_total_oficios_entrada.php">
                            <div class="form-group" >
                              <label for="sel1">Seleccione el año:</label>
                              <select class="form-control" id="anno" name="anno">
               
                                  <?php 

                                  if ($totalRows_DatosConsultaAnno> 0) 
                                          {  
                                         do {  
                                   ?>
                                 <option>
                                        <?php echo $row_DatosConsultaAnno["el_anno"]; ?>
                                 </option>

                                        <?php 
                                           } while ($row_DatosConsultaAnno = mysqli_fetch_assoc($DatosConsultaAnno)); 
                                               } 
                                              else
                                               { echo "No hay resultados"; ?>
                                                          
                                          <?php } ?>

                                
                              </select>
                              <button type="submit" class="btn btn-primary btn-xs">Acceder</button>
                            </div>
                          </form>
                    </div>
                    
                  </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->

<div class="col-md-4">
      <div class="box box-solid box-default">
        <div class="box-header">
          <h3 class="box-title ion-ios-list-outline"> Ver listado de oficios salida por año</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="timeline-footer">
                      
                         <form name="ver_oficios_salida" id="ver_oficios_salida" method="get" action="listado_oficios_salida.php">
                            <div class="form-group" >
                              <label for="sel1">Seleccione el año:</label>
                              <select class="form-control" id="anno" name="anno">
               
                                  <?php 

                                  if ($totalRows_DatosConsultaAnno2> 0) 
                                          {  
                                         do {  
                                   ?>
                                 <option>
                                        <?php echo $row_DatosConsultaAnno2["el_anno"]; ?>
                                 </option>

                                        <?php 
                                           } while ($row_DatosConsultaAnno2 = mysqli_fetch_assoc($DatosConsultaAnno2)); 
                                               } 
                                              else
                                               { echo "No hay resultados"; ?>
                                                         
                                          <?php } ?>

                                
                              </select>
                              <button type="submit" class="btn btn-primary btn-xs">Acceder</button>
                            </div>
                          </form>
                    </div>
                  </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      

    </div>
  </div>

                   
                </div><!-- /.box-body -->
            </div><!-- /.col -->
          </div><!-- /.row -->
       

       <?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($DatosConsulta);
mysqli_free_result($DatosConsultaAnno);
?>  