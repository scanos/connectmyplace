
<?php
require "../../pdo2.php";
require "../../bootstrap.php";

echo "<form action='sensor_events_acknowledge.php' method='POST'> ";
echo "Acknowledge all events";
echo " <input type='submit' value='submit'></form>";


//now done on hourly basis with stored procedure
//$stmt = $pdo->query('
//UPDATE sensor_data INNER JOIN sensors ON sensors.id = sensor_data.sensor_id SET sensor_data.event_triggered = 1 
//where (sensor_value < lower_warning_limit or sensor_value > higher_warning_limit or sensor_value < lower_action_limit or sensor_value > higher_action_limit) 
//and sensor_data.event_acknowledged = false');
//$stmt->execute();
//now done on hourly basis with stored procedure



$stmt = $pdo->query('SELECT count(sensors.id) as scount,DATE_FORMAT(sensor_data.reg_date, "%W %M %e %Y") as date_time,sensors.description,sensors.UOM as uom,
FORMAT(AVG(sensor_data.sensor_value),1) as savg FROM sensor_data INNER JOIN sensors ON sensor_data.sensor_id = sensors.id 
where (sensor_value < lower_warning_limit or sensor_value > higher_warning_limit or sensor_value < lower_action_limit or sensor_value > higher_action_limit)
and sensor_data.event_acknowledged = false group by sensors.description');
$stmt->execute();
while ($row = $stmt->fetch())
                        {

                         echo "<p>".$row['date_time']." ".$row['description']." AVG ".$row['savg']."".$row['uom']." COUNT ".$row['scount'];
                         }



//$stmt->close();



                $stmt = $pdo->query('SELECT sensor_data.id as id,sensors.UOM as uom,DATE_FORMAT(sensor_data.reg_date, "%W %b %e %Y %H:%i") as time_date,
sensors.description as description,sensor_data.sensor_value as sensor_value FROM sensor_data INNER JOIN sensors ON sensor_data.sensor_id = sensors.id 
where sensor_value < lower_warning_limit and sensor_data.event_acknowledged = false '); 
                $stmt->execute();
                echo "<table class='table table-striped'><thead><tr><th scope='col'></th><th scope='col'>ID</th><th scope='col'>Date</th><th scope='col'>Desc</th>
      <th scope='col'>Value</th><th scope='col'>Con C</th><th scope='col'>Notes</th></tr></thead><tbody>";

                while ($row = $stmt->fetch())
                        {
                         $id=$row['id'];
                         $UOM=$row['uom'];
                         $description=$row['description'];
                         
                         $reg_date=$row['time_date'];
                         $sensor_value=$row['sensor_value'];
                         echo "<th scope='row'></th><td>$id";
                         echo "</td><td>$reg_date</td><td>$description</td><td>$sensor_value $UOM</td><td>";

echo "<form action='edit_ght.php' method='POST'> ";
echo "<input type='text' id ='notes' name='notes' $notes value='$notes'> ";
//echo "<input type='text' id='mnote' name='mnote' value='${name3}'></td><td> "

echo" <input type='hidden' name='id' value='$id'> ";
echo " <input type='submit' value='submit'></form>";

			echo "</td></tr>";
                        }



?>
