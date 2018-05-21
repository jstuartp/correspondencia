<?php require_once('Connections/conexion.php');
//RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");
require('plugins/fpdf/fpdf.php');

header('Content-type: text/plain; charset=utf-8');

$numero_oficio = GetSQLValueString ($_GET['oficio_id'], "int");

$query_ImprimeOficioSalida = ("SELECT *
                                FROM info_oficios
                                WHERE oficio_id = $numero_oficio");
$ImprimeOficioSalida = mysqli_query($con,  $query_ImprimeOficioSalida) or die(mysqli_error($con));
$row_ImprimeOficioSalida = mysqli_fetch_assoc($ImprimeOficioSalida);
$totalRows_ImprimeOficioSalida = mysqli_num_rows($ImprimeOficioSalida);


$query_DatosDestinatarios = sprintf("SELECT *
					from  jefaturas, info_oficios
					WHERE jefaturas.id_jefatura = info_oficios.id_jefatura and
					info_oficios.oficio_id = $numero_oficio" );
$DatosDestinatarios = mysqli_query($con,  $query_DatosDestinatarios) or die(mysqli_error($con));
$row_DatosDestinatarios = mysqli_fetch_assoc($DatosDestinatarios);
$totalRows_DatosDestinatarios = mysqli_num_rows($DatosDestinatarios);

/************************ VARIABLES PARA INSERTAR LAS FECHAS Y DATOS DEL OFICIO *****************/

$anno= date("Y");

$nomeclatura = $config['nomeclatura_dependencia'];
$el_oficio = $row_ImprimeOficioSalida['oficio_id1'];
$anno_oficio = $row_ImprimeOficioSalida['anno'];

/************************ VARIABLES PARA INSERTAR LAS FECHAS Y DATOS DEL OFICIO *****************/

class PDF extends FPDF
{

public $username = "";


function Header()
{
	global $title;

	// Arial bold 15
	$this->SetFont('Arial','B',15);
	// Calculamos ancho y posición del título.
	$w = $this->GetStringWidth($title)+6;
	 // Logo
    $this->Image('imagenes/logo_ucr.jpg',16,10,50);
    $this->Image('imagenes/acronimo.jpg',140,15,50);
	$this->SetX((100-$w)/3);
	 // Line break
    $this->Ln(30);
    $this->Text(0,31,'           ____________________________________________________________');

}

function Footer()
{
	$datos_pie = "                       Teléfono: (506) 2511-8867  |  Fax: (506) 2225-3749  |  www.facultadeducacion.ucr.ac.cr  |  decanato.educacion@ucr.ac.cr";
	// IMAGEN QUE SE UTILIZA EN EL PIE DEL OFICIO DEL LADO DERECHO //
	$this->Image('imagenes/FACEDU-60aniversario.png',170,237,25);

	// Posición a 1,5 cm del final
	$this->SetY(-15);
	// Arial itálica 8
	$this->SetFont('Arial','',9);
	// Color del texto en gris
	$this->SetTextColor(128);
	// Número de página
	//$this->Cell(0,20,'Página '.$this->PageNo(),0,0,'C');
	 $this->Cell(330,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
	//$this->Cell(0,10,'Nota: ','',0,'C',0);
    $this->Text(0,260,'                      ____________________________________________________________________________________________________');
    $this->Text(0,265,$datos_pie.$this->username);

}



function ChapterBody($file)
{
	// Leemos el fichero
	$txt = file_get_contents($file);
	// Arial 11
	$this->SetFont('Arial','',11);
	// Imprimimos el texto justificado
	$this->MultiCell(0,7,$txt);
	// Salto de línea
	$this->Ln();
	// Cita en itálica
	$this->SetFont('','I');
	//$this->Cell(0,5, $txt);
	$this->SetRightMargin(10,0,0);
}

function PrintChapter($num, $title, $file)
{
	$this->AddPage();
	//$this->ChapterTitle($num);
	$this->ChapterBody($file);
}

}

$pdf = new PDF();
$pdf->SetAuthor('RHV');
$pdf->SetMargins(20, 10, 20);
$pdf->PrintChapter(1,' ','temporal/'.$numero_oficio.'-'.$anno.'.txt');
$pdf->AliasNbPages();
$pdf->Output($nomeclatura.'-'.$el_oficio.'-'.$anno_oficio.'.pdf', 'I'); // si desea que el oficio se abra con alguna aplicacion de pdf debe cambiar la I por una D                    ****
?>
