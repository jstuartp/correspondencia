<?php require_once('Connections/conexion.php');
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");

require_once('vendor/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;
//$pdf = new DOMPDF();

$numero_oficio = GetSQLValueString ($_GET['oficio_id'], "int"); 

/*************** sql para obtener las jefaturas las cuales firmarán el oficio salida */



$nombre_institucion = $config['nomeclatura_dependencia'];


/***************** VARIBLES PARA CONFIGURACIÓN DEL PIE DE LA PÁGINA E IMAGENES ADICIONALES ****************/
$el_pie= $config['pie_del_oficio'];
$el_sitio = $config['sitio_web'];
$el_usuario = obtenerSiglasUsuarioImprime ($row_ImprimeOficioSalida['usuario_inserta']);
$el_correo = $config['el_email'];

/********************** Variable Si hay mas de un firmante*************************************************************************************/

$firma1= array("","");
$firma2= array("","");
$firma3= array("","");

if($row_ImprimeOficioSalida['destinatario_out']!=""){
$firma1 = explode("+",$row_ImprimeOficioSalida['destinatario_out']);
if($row_ImprimeOficioSalida['firma2']!=""){
$firma2 = explode("+",$row_ImprimeOficioSalida['firma2']);}
if($row_ImprimeOficioSalida['firma3']!=""){
$firma3 = explode("+",$row_ImprimeOficioSalida['firma3']);}
    


    $texto_oficio_Stuart ='<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<style>
@page {
  margin-top: 100px; margin-bottom: 50px;
}

body {
  margin: 21pt 30pt 18pt 30pt; /*varoles originales 18pt 16pt 30pt 16pt los actuales fueron modificados por Stuart */
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

.centroS {
	text-align: center;
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
  $pdf->image($logo2, $w-182, 28, 128, 30); //(182,28,128,23)

  // Draw a line along the header
  $y = 70;
 // $pdf->line(55, $y, $w-55, $y, $color, 1);

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
      
      <td width="50%" align="right" ><strong> '.$dia_Oficio." de ".$meses[$mes_Oficio-1]. " de ".$row_ImprimeOficioSalida['anno'].'<br>'.$nombre_institucion.'-'.$row_ImprimeOficioSalida['oficio_id1'].'-'.$row_ImprimeOficioSalida['anno'].'</strong><br></td>
    </tr>
  </tbody>
</table>
</p>
<p><br> </p> <p> </p>
<p style="font-weight: bold;  font-size: 11.5pt">'.$row_ImprimeOficioSalida['destinatario'].'</p>

<p>'.$row_ImprimeOficioSalida['cuerpo_oficio'].'</p> <p> <br></p>
<br>

<p>
<table width="105%" height="67" border="0" align="center">
  <tbody>
    <tr>
     
      <td width="33%"align="center" valign="top" style="font-weight: bold;  font-size: 9.0pt">'.$firma1[0].'</td>
      <td width="33%" align="center" valign="top" style="font-weight: bold;  font-size: 9.0pt">'.$firma2[0].'</td>
      <td width="33%" align="center" valign="top" style="font-weight: bold;  font-size: 9.0pt">'.$firma3[0].'</td>
    </tr>
    <tr>
      <td  align="center" valign="top" style="font-weight: bold;  font-size: 9.5pt"><span style="font-weight: bold; font-size: 9.0pt">'.$firma1[1].'</span></td>
      <td align="center" valign="top" style="font-weight: bold;  font-size: 9.5pt"><span style="font-weight: bold; font-size: 9.0pt">'.$firma2[1].'</span></td>
      <td align="center" valign="top" style="font-weight: bold;  font-size: 9.5pt"><span style="font-weight: bold;  font-size: 9.0pt">'.$firma3[1].'</span></td>
    </tr>
  </tbody>
</table
</p>


<br>
<p class="copias" >
' .$row_DatosDestinatarios['cc_copia'].'
</p>
</body>
</html>';
    
}else {


/**********************************************************************************************************/



/*****************************************************************************************************************/
$texto_oficio_Stuart ='
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<style>
@page {
  margin-top: 100px; margin-bottom: 50px;
}

body {
  margin: 21pt 30pt 18pt 30pt; /*varoles originales 18pt 16pt 30pt 16pt los actuales fueron modificados por Stuart */
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

.centroS {
	text-align: center;
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
  $pdf->image($logo2, $w-182, 28, 128, 30); //(182,28,128,23)

  // Draw a line along the header
  $y = 70;
 // $pdf->line(55, $y, $w-55, $y, $color, 1);

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
      
      <td width="50%" align="right" ><strong> '.$dia_Oficio." de ".$meses[$mes_Oficio-1]. " de ".$row_ImprimeOficioSalida['anno'].'<br>'.$nombre_institucion.'-'.$row_ImprimeOficioSalida['oficio_id1'].'-'.$row_ImprimeOficioSalida['anno'].'</strong><br></td>
    </tr>
  </tbody>
</table>
</p>
<p><br> </p> <p> </p>
<p style="font-weight: bold;  font-size: 11.5pt">'.$row_ImprimeOficioSalida['destinatario'].'</p>

<p>'.$row_ImprimeOficioSalida['cuerpo_oficio'].'</p> <p> <br></p>
<br>


<p><table width="100%" border="0" >
  <tbody>
    <tr>
     
      <td align="center" width="50%" style="font-weight: bold;  font-size: 11.5pt">' .$row_DatosDestinatarios['grado_academico']." ".$row_DatosDestinatarios['nombre']. " ".$row_DatosDestinatarios['apellido1'] . " " .$row_DatosDestinatarios['apellido2'].'<br> '.$row_DatosDestinatarios['puesto'].'</td>
    </tr>
  </tbody>
</table></p> 
<br>
<p class="copias" >
' .$row_DatosDestinatarios['cc_copia'].'
</p>
</body>
</html>';
/*****************************************************************************************************************/
}


$texto_oficio = '
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<style>
@page {
  margin-top: 100px; margin-bottom: 50px;
}

body {
  margin: 21pt 20pt 35pt 18pt; /*varoles originales 18pt 16pt 30pt 16pt los actuales fueron modificados por Stuart */
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
      
      <td width="50%"><strong> '.$dia_Oficio." de ".$meses[$mes_Oficio-1]. " de ".$row_ImprimeOficioSalida['anno'].'<br>'.$nombre_institucion.'-'.$row_ImprimeOficioSalida['oficio_id1'].'-'.$row_ImprimeOficioSalida['anno'].'</strong><br></td>
    </tr>
  </tbody>
</table>
</p>
<p><br> </p> <p> </p>
<p style="font-weight: bold;  font-size: 11.5pt">'.$row_ImprimeOficioSalida['destinatario'].'</p>
    


<p>'.$row_ImprimeOficioSalida['cuerpo_oficio'].'</p> <p> <br></p>
<br>



<p><table width="100%" border="0" >
  <tbody>
    <tr>
      <td width="50%">&nbsp;</td>
      <td align="center" width="50%" style="font-weight: bold;  font-size: 11.5pt">' .$row_DatosDestinatarios['grado_academico']." ".$row_DatosDestinatarios['nombre']. " ".$row_DatosDestinatarios['apellido1'] . " " .$row_DatosDestinatarios['apellido2'].'<br> '.$row_DatosDestinatarios['puesto'].'</td>
    </tr>
  </tbody>
</table>
<br>
<p class="copias" >
' .$row_DatosDestinatarios['cc_copia'].'
</p>
</body>
</html>';

//echo ($texto_oficio);
//echo ($pdf);
//echo $texto_oficio_Stuart;
// generamos PDF 

$dompdf = new Dompdf();
$dompdf->loadHtml($texto_oficio_Stuart);
//$dompdf->setPaper('Letter', 'portrait');
$dompdf->render();
//AÑADIR AL FINAL DE LA PÁGINA
$dompdf->stream($nombre_institucion."-".$row_ImprimeOficioSalida['oficio_id1']."-".$anno_oficio.".pdf",array('Attachment'=>0));

mysqli_free_result($ImprimeOficioSalida);
//mysqli_free_result($DatosProvincia);

