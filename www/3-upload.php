<?php
// SET THE DESTINATION FOLDER


require "../../pdo2.php";
$source = $_FILES["upimage"]["tmp_name"];
$myFile = "imagename.txt";
$destination = file_get_contents("imagename.txt");

$file_dir  = "images";
print_r("$file_dir/".$destination);
// MOVE UPLOADED FILE TO DESTINATION

	//move_uploaded_file($file_array['tmp_name'],
	//		"$file_dir/".$file_array['name'])

$file_reference=explode('_',$destination);
$myfile1=$file_reference[0];
$myfile2=$file_reference[0].".txt";
$fp = fopen("$file_dir/".$myfile2, 'a');//opens file in append mode.
fwrite($fp, $destination);
fclose($fp);


echo move_uploaded_file($source, "$file_dir/".$destination) ? "OK" : "ERROR UPLOADING";
$changed_file="$file_dir/".$destination;

putenv('PATH=/usr/local/bin/');
//

$image_size=shell_exec("identify -format '%wx%h' $changed_file");
//gives the width x height
$image_file=$file_dir."/imagesize";
//$pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
//$pieces = explode(" ", $pizza);
//echo $pieces[0]; // piece1
//echo $pieces[1]; // piece2
$temp_image=explode("x", $image_size);
$m_image_width=$temp_image[0];
$m_image_height=$temp_image[1];
$m_dimension=number_format(($m_image_width/$m_image_height), 2);
$m_image_text="width is $m_image_width height is $m_image_height dimension is $m_dimension";
file_put_contents("$image_file", $m_image_text);
//width is 640 height is 480

$m_image_height=number_format(512/$m_dimension);
$m_image_resize="512x".$m_image_height;
//shell_exec("mogrify -resize 512x512 $changed_file");
shell_exec("mogrify -resize $m_image_resize $changed_file");



//Replace the characters "world" in the string "Hello world!" with "Peter":
//echo str_replace("world","Peter","Hello world!");

$changed_file_txt=str_replace(".jpg","_txt.jpg","$changed_file");
//shell_exec("convert $changed_file -background Khaki  label:'This is Saint Pats North Queen Street 1967' -gravity Center -append $changed_file_txt");

//header("Location: https://botanihub.co.uk/cgi-bin/ITSM/ITSM_view_tasks.sh");
//header("Location: test.php");
//echo "<script>window.location.replace('http://www.w3schools.com');</script>";
//header("Location: http://example.com/myOtherPage.php");
//shell_exec("convert $file_dir/$img -resize 256x256 $file_dir/test56.jpg");


//print <<<END
//<h1>This is a test</h1>
//END;
echo "<li>$changed_file $changed_file_txt";
//echo "<img src='$changed_file'  width='512' height='512'>";
//echo "<img src='$changed_file_txt'  width='512' height='512'>";
//$pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
echo "<li> resize is  $m_image_resize";

$pieces = explode("_", $changed_file);
$pid=$pieces[2];
// filename is $changed_file
                //$stmt = $pdo->query('SELECT id,description FROM projects');
                $stmt = $pdo->prepare("INSERT INTO images (name,pid) VALUES (:changed_file, :pid)");
		$stmt->bindParam(':changed_file', $changed_file, PDO::PARAM_STR);
		$stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
		//$stmt->bindParam(':resolution', $_POST['resolution'], PDO::PARAM_STR);

                $stmt->execute();


//$stmt = $pdo->prepare("INSERT INTO images (description,resolution,owner) VALUES  (:description, :resolution, :owner)");




exit;
?>
