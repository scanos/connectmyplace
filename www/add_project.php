<?php
require "../../pdo2.php";

$description = trim($_POST['description']);
$description = strip_tags($description);
$description = htmlspecialchars($description);
$owner = trim($_POST['owner']);
$owner = strip_tags($owner);
$owner = htmlspecialchars($owner);


$stmt = $pdo->prepare("INSERT INTO projects (description,owner) VALUES  (:description, :owner)");


$stmt->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
$stmt->bindParam(':owner', $_POST['owner'], PDO::PARAM_STR);
$stmt->execute();
$p_id = $pdo->lastInsertId();
echo "Project added $p_id";

?>
