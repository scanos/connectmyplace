
<?php
require "../../pdo2.php";

$stmt = $pdo->query('
UPDATE sensor_data INNER JOIN sensors ON sensors.id = sensor_data.sensor_id SET sensor_data.event_acknowledged = 1 where sensor_data.event_triggered = true');
$stmt->execute();


header("Location: sensor_events.php");

?>
