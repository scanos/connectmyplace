<?php
require "../../pdo2.php";
require "../../bootstrap.php";

$id = trim($_POST['id']);
$id = strip_tags($id);
$id = htmlspecialchars($id);
$notes = trim($_POST['notes']);
$notes = strip_tags($notes);
$notes = htmlspecialchars($notes);
echo "$id notes ".$notes;



                $stmt = $pdo->prepare("UPDATE summary_sensors SET notes = '$notes' where id = (?)");
                $stmt->execute([$id]);

//header('Location:sensor_summary.php');




?>
