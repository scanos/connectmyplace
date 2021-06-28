VERY IMPT need to reset MAX upload size in php ini to greater than the default of 2M
sudo find / -name php.ini

PHP files image upload using JS PHP and imagemagick
to install imagemagick on a pi
sudo apt install imagemagick
sudo apt install php7.3-imagick
//script 1 thumbnail works
//header('Content-type: image/jpeg');
//$image = new Imagick('images/27-06-2021_06:04:34am_1_.jpg');
// //If 0 is provided as a width or height parameter,
// //aspect ratio is maintained
//$image->thumbnailImage(100, 0);
//echo $image;
//script 1 thumbnail works


//script 2 scaling image works
//header('Content-type: image/jpeg');
//$im = new Imagick('images/test_1.jpg');
//echo $im;
//$im->scaleImage(2000, 1500, true); // => 1600x1200
//$im->scaleImage(1000, 500, true); // => 666x500

//$im->scaleImage(500, 250, true); // => 666x500

//script 2 scaling image works

//$im->setImageFormat ("jpeg");
//file_put_contents ("images/test_2.jpg", $im); // works, or:

//echo "<a href=images/test_2.jpg>imh</a>";
//echo $im;

