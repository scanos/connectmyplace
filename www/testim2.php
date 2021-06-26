<?php


//echo "<img src='images/test.jpg' width='42' height='42'>";

$image = new Imagick();

$draw = new ImagickDraw();
$pixel = new ImagickPixel( 'gray' );

/* New image */
$image->newImage(800, 75, $pixel);

/* Black text */
$draw->setFillColor('black');

/* Font properties */
//$draw->setFont('Bookman-DemiItalic');
$draw->setFont('Courier');

$draw->setFontSize( 20 );

/* Create text */
$image->annotateImage($draw, 10, 45, 0, 'The quick brown fox jumps over the lazy dog');

/* Give image a format */
$image->setImageFormat('png');

/* Output the image with headers */
//header('Content-type: image/png');
//echo $image;

/* Read the image */



header('Content-type: image/png');
echo $image;

//echo "<img src='images/test.jpg' width='42' height='42'>";


//$canvas = new Imagick();

/* Canvas needs to be large enough to hold the both images */
//$width = $im->getImageWidth() + 40;
//$height = ($im->getImageHeight() * 2) + 30;
//$canvas->newImage($width, $height, new ImagickPixel("black"));
//$canvas->setImageFormat("png");

/* Composite the original image and the reflection on the canvas */
//$canvas->compositeImage($im, imagick::COMPOSITE_OVER, 20, 10);
//$canvas->compositeImage($reflection, imagick::COMPOSITE_OVER, 20, $im->getImageHeight() + 10);

/* Output the image*/
//header("Content-Type: image/png");
//echo $canvas;




?>
