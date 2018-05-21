<?php
$path = './ced.pdf';

/*header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename='.$path);
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');

//readfile($path);

function genPdfThumbnail($source, $target)
	{
		$source = realpath($source);
		$target = dirname($source).DIRECTORY_SEPARATOR.$target;
		$im     = new Imagick($source."[0]"); // 0-first page, 1-second page
		$im->setImageColorspace(255); // prevent image colors from inverting
		$im->setimageformat("jpeg");
		$im->thumbnailimage(255, 330); // width and height
		$im->writeimage($target);
		$im->clear();
		$im->destroy();
	}
	
genPdfThumbnail($path,'my.jpg');
*/

$im = new imagick($path."[0]");
$im->setImageColorspace(255);
$im->setImageFormat('jpg');
$im->thumbnailimage(255, 330);
header('Content-Type: image/jpeg');
echo $im;
