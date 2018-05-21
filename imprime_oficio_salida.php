<?php require_once('Connections/conexion.php');
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");

require_once('vendor/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;
//$pdf = new DOMPDF();

$numero_oficio = GetSQLValueString ($_GET['oficio_id'], "int"); 

/*************** sql para obtener las jefaturas las cuales firmarán el oficio salida */

$query_DatosDestinatarios = sprintf("SELECT *
                    from  jefaturas, info_oficios
                    WHERE jefaturas.id_jefatura = info_oficios.id_jefatura and
                          info_oficios.oficio_id = $numero_oficio " );
$DatosDestinatarios = mysqli_query($con,  $query_DatosDestinatarios) or die(mysqli_error($con));
$row_DatosDestinatarios = mysqli_fetch_assoc($DatosDestinatarios);
$totalRows_DatosDestinatarios = mysqli_num_rows($DatosDestinatarios);

/*************** sql para obtener las jefaturas las cuales firmarán el oficio salida */


$meses= array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
$anno= date("Y");

$query_ImprimeOficioSalida = ("SELECT *
                                FROM info_oficios
                                WHERE oficio_id =
$numero_oficio");
$ImprimeOficioSalida = mysqli_query($con,  $query_ImprimeOficioSalida) or die(mysqli_error($con));
$row_ImprimeOficioSalida = mysqli_fetch_assoc($ImprimeOficioSalida);
$totalRows_ImprimeOficioSalida = mysqli_num_rows($ImprimeOficioSalida);

/*********************************MANEJO DE LA FECHA***************************************************************************/
$fecha = strtotime($row_ImprimeOficioSalida["fecha"]);
$dia_Oficio = date('d', $fecha);
$mes_Oficio = date('m', $fecha);

/************************************************************************************************************/



$nombre_institucion = $config['nomeclatura_dependencia'];
$anno_oficio = $row_ImprimeOficioSalida['anno'];


/***************** VARIBLES PARA CONFIGURACIÓN DEL PIE DE LA PÁGINA E IMAGENES ADICIONALES ****************/
$el_pie= $config['pie_del_oficio'];
$el_sitio = $config['sitio_web'];
$el_usuario = obtenerSiglasUsuarioImprime ($row_ImprimeOficioSalida['usuario_inserta']);
$el_correo = $config['el_email'];

$texto_oficio = '
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<style>
@page {
  margin-top: 100px; margin-bottom: 50px;
}

body {
  margin: 21pt 20pt 30pt 16pt; /*varoles originales 18pt 16pt 30pt 16pt los actuales fueron modificados por Stuart */
}

* {
   font-family: Arial, Helvetica, sans-serif;
   font-size: 11pt;
}

p {
  text-align: justify;
  margin: 0.5em;
  padding: 10px;
}

.copias {
    width: 100%;
    text-align: left;
    padding-left: 15px;
    font-size: 9pt;
}

.footer {
    width: 100%;
    text-align: right;
    position: absolute;
}
.footer {
   bottom: 10px;
    right: 16px;
}
</style>
</head>
<body>

<script type="text/php">
 
if ( isset($pdf) ) {

  $w = $pdf->get_width();
  $h = $pdf->get_height();
  $color = array(0,0,0);

  //////////////Header//////////////

  $head = $pdf->open_object();

  // Logo en header 1
  $logo1 = "imagenes/logo_ucr_bn.jpg";
  $pdf->image($logo1, 55, 15, 128, 50);

  // Logo en header 2
  $logo2 = "imagenes/acronimo_bn.jpg";
  $pdf->image($logo2, $w-182, 28, 128, 23);

  // Draw a line along the header
  $y = 70;
  $pdf->line(55, $y, $w-55, $y, $color, 1);

  $pdf->close_object();
  $pdf->add_object($head, "all");

  //////////////Footer//////////////

  $foot = $pdf->open_object();
  $font = $fontMetrics->getFont("arial");
  $size = 9;
  $text_height = $fontMetrics->getFontHeight($font, $size);

  // Logo en footer
//  $logo_footer = "imagenes/60aniversario_bn.png";
//  $pdf->image($logo_footer, $w-129, $h-110, 70, 60);

  // Draw a line along the bottom
  $y = $h - $text_height - 30;
  $pdf->line(55, $y, $w-55, $y, $color, 1);

  // Página n de m
  $z = $h - $text_height - 20;
  $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
  $width = $fontMetrics->getTextWidth("Página 1 de 10", $font, $size);
  $pdf->page_text($w - 16 - $width - 38, $z, $text, $font, $size, $color);

  // Texto footer
  $j = $h - $text_height - 20;
  $text = "'. $el_pie .' | '. $el_sitio.' | '.$el_correo.'";
  $width = $fontMetrics->getTextWidth($text, $font, $size);
  $pdf->page_text(  $w / 3 - $width / 3, $j, $text, $font, $size, $color);
  $pdf->close_object();
  $pdf->add_object($foot, "all");

} 
</script>
<p> <table width="100%" border="0">
  <tbody>
    <tr>
      <td width="50%">&nbsp;</td>
      
      <td width="50%"><strong> '.$nombre_institucion.'-'.$row_ImprimeOficioSalida['oficio_id1'].'-'.$row_ImprimeOficioSalida['anno'].'</strong><br>'.$dia_Oficio." de ".$meses[$mes_Oficio-1]. " de ".$row_ImprimeOficioSalida['anno'].'<br></td>
    </tr>
  </tbody>
</table>
</p>
<p><br> </p> <p> <br></p>
<p style="font-weight: bold;  font-size: 11.5pt">'.$row_ImprimeOficioSalida['destinatario'].'</p>

<p>'.$row_ImprimeOficioSalida['cuerpo_oficio'].'</p> <p> <br></p>
<br>
<br>
<p><table width="100%" border="0">
  <tbody>
    <tr>
      <td width="50%">&nbsp;</td>
      <td width="50%" style="font-weight: bold;  font-size: 11.5pt">' .$row_DatosDestinatarios['grado_academico']." ".$row_DatosDestinatarios['nombre']. " ".$row_DatosDestinatarios['apellido1'] . " " .$row_DatosDestinatarios['apellido2'].'<br> '.$row_DatosDestinatarios['puesto'].'</td>
    </tr>
  </tbody>
</table></p>
<br>
<p class="copias" >
' .$row_DatosDestinatarios['cc_copia'].'
</p>
</body>
</html>';

//echo ($texto_oficio);
//echo ($pdf);

// generamos PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($texto_oficio);
//$dompdf->setPaper('Letter', 'portrait');
$dompdf->render();
//AÑADIR AL FINAL DE LA PÁGINA
$dompdf->stream($nombre_institucion."-".$row_ImprimeOficioSalida['oficio_id1']."-".$anno_oficio.".pdf",array('Attachment'=>0));

mysqli_free_result($ImprimeOficioSalida);
//mysqli_free_result($DatosProvincia);

