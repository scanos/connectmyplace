<?php

    //$imagick = new \Imagick(realpath($imagePath));
    $imagick = new Imagick("images/test.jpg");
 
    $draw = new \ImagickDraw();
    $draw->setStrokeColor('Red');
    $draw->setFillColor('Green');
 
    $draw->setStrokeWidth(1);
    $draw->setFontSize(20);
     
    $text = "Imagick is a native php \nextension to create and \nmodify images using the\nImageMagick API.";
 
   $draw->setFont('Courier');


    $imagick->annotateimage($draw, 40, 40, 0, $text);
 
    header("Content-Type: image/jpg");
    echo $imagick->getImageBlob();



?>
