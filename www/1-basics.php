<!DOCTYPE html>
<html>
  <head>
    <title>
      HTML Webcam Capture Demo
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!--
    <script src="1-basics.js"></script>
    <script src="2-output-file.js"></script>
    -->
    <script src="3-upload.js"></script>
    <style>
      #vid-show, #vid-canvas, #vid-take {
        margin-bottom: 20px;
      }
      html, body {
        padding: 0;
        margin: 0;
      }
    </style>
  </head>
  <body>
<script>
function getQueryStringValue (key) {  
    return unescape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
}

</script>

<div> botanifile : <span id="botanifile"></span></div>
<script>
document.getElementById("botanifile").innerHTML = getQueryStringValue("data");
var span = document.getElementById("data");
</script>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$file = 'imagename.txt';
print(Date("l F d, Y"));
$mf = fopen($file, 'w');
//$txt = $_GET["imagename"];
//$tag = $_GET["tag"];
$id = $_GET["id"];
$taskname = $_GET["taskname"];
//$txt = $txt."_$id".".png";
$mydate = date("d-m-Y_h:i:sa");
$txt = "$mydate"."_".$id."_".".jpg";
//$txt = date("d-m-Y_h:i:sa")."$id_"."$taskname_".".png";


echo "file: $file $txt<bR>";
$mf = fopen($file, 'w');
fwrite($mf, $txt);
fclose($mf);
//$resizeimage = "/images/".$txt;
//shell_exec("ls -l images/");

//shell_exec("sudo mogrify -resize 512x512 $resizeimage");
//sudo mogrify -resize 512x512 ../../html/images/*.jpg
?>





    <div id="vid-controls">
      <video id="vid-show" autoplay width="500" height="250"></video>
      <input id="vid-take" type="button" value="Take Photo"/>
     <div id="vid-canvas"></div>
    </div>
    <p><a href=cgi-bin/ITSM/ITSM_view_tasks.sh>Tasks</a>

<form action="3-upload.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="upimage" id="upimage">
  <input type="submit" value="Upload Image" name="submit">
</form>


  </body>
</html>
