<?php


   $imagick_type = new Imagick();

  $file_to_grab = "images/test.jpg";
   
    $file_handle_for_viewing_image_file = fopen($file_to_grab, 'a+');
   
        // Grab File
        // ---------------------------------------------

    $imagick_type->readImageFile($file_handle_for_viewing_image_file);
   
        // Get Image Properties
        // ---------------------------------------------
       
    $imagick_type_properties = $imagick_type->getImageProperties('*', FALSE);
   
        // Print Image Properties
        // ---------------------------------------------
   
    print("<pre>");
       
    print_r($imagick_type_properties);
    foreach($imagick_type_properties as $value)
    {
        print("$value --- ");
        print($imagick_type->getImageProperty("$value"));
        print("<br><br>");
    }
               
    print("</pre>");


        $exif_data = exif_read_data($file_to_grab);
        $edate = $exif_data['DateTime'];
        echo "<p> exif datetime".$edate;


echo "test1.jpg:<br />\n";
$exif = exif_read_data('images/test.jpg', 'IFD0');
echo $exif===false ? "No header data found.<br />\n" : "Image contains headers<br />\n";

$exif = exif_read_data('tests/test2.jpg', 0, true);
echo "test2.jpg:<br />\n";
foreach ($exif as $key => $section) {
    foreach ($section as $name => $val) {
        echo "$key.$name: $val<br />\n";
    }
}


?>
