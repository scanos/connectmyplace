<?php
require "../../pdotodo.php";
require "../../todocss.php";
session_start();
$pid=$_SESSION['pid'];

echo "project ".$pid;


$get_tid=$_GET["tid"];
//echo "<p> post $_POST get tid ".get_tid;

if($get_tid >= 0)
{
PRINT <<< END

<form action="" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="hidden" name="get_tid" value="$get_tid">
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
END;
}













//$target_dir = "images/";
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$uploadOk = 1;
//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {

$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));





  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
$source=$_FILES["fileToUpload"]["tmp_name"];
$destination="ttttt.jpg";
echo move_uploaded_file($source, "$target_dir/".$destination) ? "OK" : "ERROR UPLOADING";
$changed_file="$target_dir/".$destination;
echo $changed_file;
//echo "<p><img src='$changed_file'>";


//header('Content-type: image/jpeg');
$im = new Imagick('images/ttttt.jpg');
//echo $im;
//$im->scaleImage(2000, 1500, true); // => 1600x1200
//$im->scaleImage(1000, 500, true); // => 666x500

$im->scaleImage(500, 250, true); // => 666x500

//script 2 scaling image works

$im->setImageFormat ("jpeg");
//$newfile=$target_dir."testtest.jpg";

$mydate = date("d-m-Y_h:i:sa");
$newfile = $target_dir."$mydate"."_".$_GET['tid']."_".".jpg";

// echo $(date +%s);
//$now = new DateTime(); 

//$newfile=$target_dir; 
//$test_secs=$time();
//$now_secs_string=strval($test_secs);
//echo "now_secs_string $now_secs_string";
//$newfile=($newfile . $time());
//$newfile= $target_dir.$now_secs_string.".jpg";

//$a = 7;
//$b = "3 dollars";
//
//print ($a . $b);  // 73 dollars


echo "newfile ".$newfile;
file_put_contents ("$newfile", $im); // works, or:
//echo "<p>File reduced in size <a href=images/ttttt.jpg>imh</a>";
echo "<p><img src='$newfile'>";
//$tid=9999;
//MariaDB [todo]> describe image;
//| image_location | varchar(255) | YES  |     | NULL                |                |
//| tid            | int(11)      | YES  |     | NULL                |                |
//| ts             | timestamp    | NO   |     | current_timestamp() |                |
//| id             | int(11)      | NO   | PRI | NULL                | auto_increment |
//+----------------+---------
$stmt = $pdo->prepare("INSERT INTO image (image_location,tid,pid) VALUES (:image_location, :tid, :pid)");
//$stmt = $pdo->prepare("INSERT INTO todo (responsible,description,pid,start_date,duedate,no_of_days)
//VALUES  (:responsible, :description, :pid, :start_date, :due_date, :no_of_days)");


$stmt->bindParam(':image_location', $newfile, PDO::PARAM_STR);
$stmt->bindParam(':tid', $_GET['tid'], PDO::PARAM_INT);
$stmt->bindParam(':pid', $pid, PDO::PARAM_INT);


$stmt->execute();

$tid = $pdo->lastInsertId();

//$_SESSION['notification'] = " NEW PROJECT ADDED SUCCESSFULLY ID $p_id";
echo " NEW task ADDED SUCCESSFULLY ID $tid";








//echo "<img src='".$changed_file."'>";
//header('Content-type: image/jpeg');
//$im = new Imagick($changed_file);
//$im->scaleImage(500, 250, true); 
//echo $im;

//file_put_contents ("images/xxxxx.jpg", $im); // works, or
//echo "<img src='images/xxxxx.jpg'>";



  		       } else {
    echo "File is not an image.";
    $uploadOk = 0;
}

//if(isset($_GET['id']))
//{
   //  $id = $_GET['id'];
//}












  			}
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


?>
