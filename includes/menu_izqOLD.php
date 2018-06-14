<?php require_once('Connections/conexion.php'); 
 require 'UsuariosControler.php';

 // Objeto para el uso de la tabla usuarios
 $_UsuariosControler = new UsuariosControler();
 
 
$el_usuario = GetSQLValueString(obtenerIdUsuario($_SESSION ['reservas_UserId']), "int");

$la_seccion = GetSQLValueString ( obtenerIDSeccionUsuario ($el_usuario), "int" ) ;


$query_totalOficios = sprintf(" SELECT count(*) as total 
                                    FROM info_oficios " );
$totalOficios = mysqli_query($con,  $query_totalOficios) or die(mysqli_error($con));
$row_totalOficios = mysqli_fetch_assoc($totalOficios);
$totalRows_totalOficios = mysqli_num_rows($totalOficios);


$query_totalEntrada = sprintf(" SELECT count(*) as total 
                                    FROM info_oficios WHERE (tipo_oficio=1 OR tipo_oficio=2) AND id_estado = 9 /*Todos los que no esten finalizados*/
                                    ORDER BY info_oficios.oficio_id DESC" );
$totalEntrada = mysqli_query($con,  $query_totalEntrada) or die(mysqli_error($con));
$row_totalEntrada = mysqli_fetch_assoc($totalEntrada);
$totalRows_totalEntrada = mysqli_num_rows($totalEntrada);

$query_totalEntradaGeneral = sprintf(" SELECT count(*) as total 
                                    FROM info_oficios WHERE tipo_oficio=1 OR tipo_oficio=2 
                                    ORDER BY info_oficios.oficio_id DESC" );
$totalEntradaGeneral = mysqli_query($con,  $query_totalEntradaGeneral) or die(mysqli_error($con));
$row_totalEntradaGeneral = mysqli_fetch_assoc($totalEntradaGeneral);
$totalRows_totalEntradaGeneral = mysqli_num_rows($totalEntradaGeneral);

$query_totalSalida = sprintf(" SELECT count(*) as total 
                                    FROM info_oficios WHERE tipo_oficio=0  
                                    ORDER BY info_oficios.oficio_id DESC" );
$totalSalida = mysqli_query($con,  $query_totalSalida) or die(mysqli_error($con));
$row_totalSalida = mysqli_fetch_assoc($totalSalida);
$totalRows_totalSalida = mysqli_num_rows($totalSalida);


$query_totalOficiosEntrada = sprintf("SELECT COUNT(oficio_id1 ) as total
                                FROM info_oficios
                                WHERE info_oficios.id_estado!=5 and info_oficios.oficio_id 
                                NOT IN
                                      (SELECT oficios_usuario.id_oficiousua
                                       FROM oficios_usuario)" );
$totalOficiosEntrada = mysqli_query($con,  $query_totalOficiosEntrada) or die(mysqli_error($con));
$row_totalOficiosEntrada = mysqli_fetch_assoc($totalOficiosEntrada);
$totalRows_totalOficiosEntrada = mysqli_num_rows($totalOficiosEntrada);

$query_totalOficiosVistosJf = sprintf(" SELECT COUNT(oficio_id1 ) as total 
                                            FROM info_oficios 
                                            WHERE (tipo_oficio=1 OR tipo_oficio=2) AND
                                              
                                                   id_estado = 6 
                                                   ORDER BY info_oficios.oficio_id ASC" );
$totalOficiosVistosJf  = mysqli_query($con,  $query_totalOficiosVistosJf ) or die(mysqli_error($con));
$row_totalOficiosVistosJf  = mysqli_fetch_assoc($totalOficiosVistosJf );
$totalRows_totalOficiosVistosJf  = mysqli_num_rows($totalOficiosVistosJf );

/***********************************************CONSULTA PARA MOSTRAR LOS OFICIOS NUEVOS QUE NO HAN SIDO ASIGNADOS STUART********************/

$query_totalOficiosSinAsignar = sprintf(" SELECT COUNT(oficio_id1 ) as total 
                                            FROM info_oficios 
                                            WHERE (tipo_oficio=1 OR tipo_oficio=2) AND
                                              
                                                   id_estado = 1 and info_oficios.oficio_id 
                                                                    NOT IN
                                                                    (SELECT oficios_usuario.id_oficioin
                                                                        FROM oficios_usuario)
                                                                        ORDER BY info_oficios.oficio_id ASC" );
$totalOficiosSinAsignar  = mysqli_query($con,  $query_totalOficiosSinAsignar ) or die(mysqli_error($con));
$row_totalOficiosSinAsingar  = mysqli_fetch_assoc($totalOficiosSinAsignar );
$totalRows_totalOficiosSinASignar  = mysqli_num_rows($totalOficiosSinAsignar );
/***********************************************CONSULTA PARA MOSTRAR LOS OFICIOS NUEVOS QUE NO HAN SIDO ASIGNADOS STUART********************/




/****************** SQL PARA OBTENER LOS DATOS DE LOS USUARIOS Y SUS NIVELES PARA MOSTRAR MENÚ ************/
$query_DatosUsuariosNiveles = sprintf(" SELECT * 
                                        FROM usuarios " );
$DatosUsuariosNiveles= mysqli_query($con,  $query_DatosUsuariosNiveles) or die(mysqli_error($con));
$row_DatosUsuariosNiveles = mysqli_fetch_assoc($DatosUsuariosNiveles);
$totalRows_DatosUsuariosNiveles = mysqli_num_rows($DatosUsuariosNiveles);


/***************** LISTADO DE PISTAS PARA RESERVACIONES ***************/

$query_DatosItems = sprintf("SELECT * FROM tblpista where intEstado= 1 ORDER BY idPista DESC " );
$DatosItems = mysqli_query($con,  $query_DatosItems) or die(mysqli_error($con));
$row_DatosItems = mysqli_fetch_assoc($DatosItems);
$totalRows_DatosItems = mysqli_num_rows($DatosItems);
?>


<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
            <?php include("estado_usuario.php"); ?>
          <!-- search form -->
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">Menú principal </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o text-green"></i>
                <span>Listados de Oficios</span>
                <span class="label pull-right bg-yellow"><?php echo $row_totalOficios["total"]; ?> </span>
              </a>
              <ul class="treeview-menu">
          <!--      <span class="label label-primary pull-right "><?php //echo $row_totalEntrada["total"]; ?> </span>  -->
          <!--      <li><a href="listado_oficios_entrada.php"><i class="fa fa-folder-open text-red"></i> Oficios recién ingresados</a></li> -->
                 <span class="label label-primary pull-right"><?php echo $row_totalSalida["total"]; ?></span>
                <li><a href="listado_oficios_salida.php"><i class="fa  fa-folder-open-o text-green"></i> Total Oficios de Salida</a></li>
                             <span class="label label-primary pull-right"><?php echo $row_totalEntradaGeneral ["total"]; ?></span>
               <li><a href=" listado_total_oficios_entrada.php"><i class="fa  fa-folder-open-o text-green"></i> Total Oficios de Entrada</a></li>
              </ul>
            </li>
              <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Oficios Asignados  <?php echo $_UsuariosControler->DevuelveUsuarioDeId($el_usuario);?></span>
                <span class="label pull-right bg-green "><?php// echo obtenerTotalOficiosAsignados($_SESSION['reservas_UserId']); ?></span>
              </a>
              <ul class="treeview-menu">
              <span class="label label-primary pull-right"><?php echo cuentaOficiosAsignados2($el_usuario  ); ?> </span>
                <li><a href="oficios_en_tramite.php?tipo=1"><i class="fa fa-circle-o text-red"></i> Oficios Asignados</a></li>
                <span class="label label-primary pull-right"><?php echo cuentaOficiosTramite($el_usuario  ); ?>  </span>
                <li><a href="oficios_en_tramite.php?tipo=2"><i class="fa fa-circle-o text-yellow"></i> Oficios en trámite</a></li>
                <span class="label label-primary pull-right"><?php echo cuentaOficiosTramitados($el_usuario  ); ?>   </span>
                <li><a href="oficios_en_tramite.php?tipo=3"><i class="fa fa-circle-o text-green"></i> Oficios tramitados</a></li>
              </ul>
            </li>
            <!-- VALIDAMOS EL NIVEL DE USUARIOS PARA JEFATURA PARA QUE PUEDA VER LOS OFICIOS A REVISAR -->
            <?php  if ( ( $la_seccion == $config['seccion_jefatura']) or ($la_seccion == $config['seccion_informatica'])  or ($la_seccion == $config['seccion_direccion']) ){  ?>
             <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Módulo Jefatura</span>
                <span class="label pull-right bg-green "><?php// echo obtenerTotalOficiosAsignados($_SESSION['reservas_UserId']); ?></span>
              </a>
              <ul class="treeview-menu">
              <span class="label pull-right bg-yellow"><?php echo $row_totalOficiosSinAsingar["total"];  ?> </span>
                <li><a href="listado_oficios_entrada_jefatura.php"><i class="fa fa-circle-o text-red"></i> Oficios Sin Asignar</a></li>
          <!--      <span class="label pull-right bg-yellow"><?php //echo $row_totalOficiosVistosJf["total"]; ?> </span>  
                <li><a href="listado_oficios_vistos_jefatura.php"><i class="fa fa-circle-o text-yellow"></i>Vistos por Jefatura</a></li>
                <li><a href="listado_oficios_por_archivar.php"><i class="fa fa-circle-o text-green"></i>Por Archivar /Archivados</a></li>
                <li><a href="reporte_actividades.php"><i class="glyphicon glyphicon-signal text-red"></i> Reporte actividades usuarios</a></li> -->
              </ul>
            </li>
            <?php } else echo ""; ?>
             <!-- FIN VALIDAMOS EL NIVEL DE USUARIOS PARA JEFATURA PARA QUE PURA VER LOS OFICIOS A REVISAR -->

             <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Ingreso|Salida Correspondencia</span>
                <span class="label pull-right bg-green "><?php// echo obtenerTotalOficiosAsignados($_SESSION['reservas_UserId']); ?></span>
              </a>
              <ul class="treeview-menu">
                <li><a href="oficio_in.php"><i class="fa fa-circle-o text-red"></i> Ingresar Oficio de Entrada</a></li>
                <li><a href="generar_oficio_salida.php"><i class="fa fa-circle-o text-yellow"></i>Generar Oficio de Salida</a></li>
              </ul>
            </li>
             
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($totalOficios);
mysqli_free_result($totalEntrada);
mysqli_free_result($totalEntradaGeneral);
mysqli_free_result($totalSalida);
mysqli_free_result($totalOficiosEntrada);
mysqli_free_result($totalOficiosVistosJf);
mysqli_free_result($DatosUsuariosNiveles);
?>
