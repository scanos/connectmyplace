<?php
require "../../pdo2.php";
require "../../bootstrap.php";

$stmt = $pdo->query('select summary_sensors.event_triggered as m_event_triggered,summary_sensors.id as id,summary_sensors.scount,sensors.description,sensors.UOM,date(summary_sensors.sdate) as sdate,
summary_sensors.smax,summary_sensors.smin,summary_sensors.savg,summary_sensors.notes from summary_sensors left join sensors 
on sensors.id = summary_sensors.sensor_id order by summary_sensors.id DESC');


                $stmt->execute();
                echo "<table class='table table-striped'><thead><tr><th scope='col'></th><th scope='col'>Date</th><th scope='col'>Desc</th><th scope='col'>UOM</th>
       <th scope='col'>COUNT</th><th scope='col'>AVG</th>
      <th scope='col'>MAX</th><th scope='col'>MIN</th><th scope='col'>Notes</th></tr></thead><tbody>";

                while ($row = $stmt->fetch())
                        {
                         $m_event=$row['m_event_triggered'];
                         if ($m_event < 1)
			{
                         echo "<th scope='row'></th>";}
                        else
			{ echo "<tr class='table-danger'><td></td>";
                        }

                         echo "<td>".$row['sdate'];
                         echo "</td><td>".$row['description']."</td><td>".$row['UOM']."</td><td>".$row['scount']."</td><td>".$row['savg'];
                         echo "</td><td>".$row['smax']."</td><td>".$row['smin']."</td><td>";

echo "<form action='edit_summary_sensors.php' method='POST'> ";
echo "<input type='text' id ='notes' name='notes' $notes value='".$row['notes']."'> ";
//echo "<input type='text' id='mnote' name='mnote' value='${name3}'></td><td> "

echo" <input type='hidden' name='id' value='".$row['id']."'> ";
echo " <input type='submit' value='submit'></form>";

			echo "</td></tr>";
                        }



?>
