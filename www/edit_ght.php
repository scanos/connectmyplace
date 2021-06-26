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



                $stmt = $pdo->prepare("UPDATE sensor_data SET notes = '$notes' where id = (?)");
                $stmt->execute([$id]);
//$stmt = $pdo->query('select sensor_data.reg_date,sensors.description as description,sensor_data.sensor_value as sensor_value,sensor_data.notes as snotes
//FROM sensor_data INNER JOIN sensors ON sensor_data.sensor_id = sensors.id order by sensor_data.reg_date DESC');






?>

