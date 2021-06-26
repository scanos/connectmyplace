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

$stmt = $pdo->prepare("DELETE FROM images WHERE id = :id");
//$stmt2 = $pdo->prepare("SELECT id,pid,name,description from images where pid = (?)");

$stmt->bindParam(':id', $id, PDO::PARAM_INT);       
//$stmt->bindParam(':description', $description, PDO::PARAM_STR);
$stmt->execute();

//shell_exec("convert $name -background Khaki  label:'$description' -gravity Center -append $name");
shell_exec("rm $name");





?>
