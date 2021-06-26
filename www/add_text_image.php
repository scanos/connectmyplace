<?php
require "../../pdo2.php";

//echo "<li>id $_POST['id'] description $_POST['description'] name $name";

$id = trim($_POST['id']);
$id = strip_tags($id);
$id = htmlspecialchars($id);
$description = trim($_POST['description']);
$description = strip_tags($description);
$description = htmlspecialchars($description);
$name = trim($_POST['name']);
$name = strip_tags($name);
$name = htmlspecialchars($name);

echo "<li>id $id description $description name $name";

$stmt = $pdo->prepare("UPDATE images set description = :description WHERE id = :id");
//$stmt2 = $pdo->prepare("SELECT id,pid,name,description from images where pid = (?)");

$stmt->bindParam(':id', $id, PDO::PARAM_INT);       
$stmt->bindParam(':description', $description, PDO::PARAM_STR);
$stmt->execute();


//  shell_exec("convert $name  -font Century-Schoolbook-L-Bold -pointsize 25 ( +clone -resize 1x1  -fx 1-intensity -threshold 50% -scale 32x32 -write mpr:color +delete )  -tile mpr:color  -annotate +10+26 '$description' $name");






?>
