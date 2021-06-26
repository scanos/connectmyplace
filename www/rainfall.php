<?php
require "../../pdo2.php";
require "../../bootstrap.php";
$total_rainfall=0;
          //      $stmt = $pdo->query('SELECT location,rainfall,DATE_FORMAT(reg_date, "%W %M %e %Y") as report_date,datediff(now(),reg_date)as days_old FROM rainfall');
//$stmt = $pdo->query('SELECT location,rainfall,DATE_FORMAT(reg_date, "%W %M %e %Y") as report_date,datediff(now(),reg_date)as days_old FROM rainfall WHERE reg_date >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)');

$stmt = $pdo->query('SELECT location,FORMAT(sum(rainfall),1) as rainfall ,DATE_FORMAT(reg_date, "%W %M %e %Y") as report_date,datediff(now(),reg_date)as days_old FROM rainfall WHERE reg_date >= DATE_ADD(CURDATE(), INTERVAL -3 DAY) group by report_date ORDER by days_old DESC');


            
    $stmt->execute();
                echo "<table class='table table-striped'><thead><tr><th scope='col'>Location</th>
      <th scope='col'>Date</th><th scope='col'>Rainfall</th><th scope='col'>Days old</th> </tr></thead><tbody>";

                while ($row = $stmt->fetch())
                        {
                         $location=$row['location'];
                         $rainfall=$row['rainfall'];
                         $days_old=$row['days_old'];
                         $report_date=$row['report_date'];
                         echo "<th scope='row'>$location</th><td>$report_date</td><td>$rainfall</td><td>$days_old</td></tr>";
                        $total_rainfall += $rainfall;

                        }
     echo "</table>";
     echo "<p> Total Rainfall $total_rainfall"; 

$stmt1 = $pdo->query('SELECT location,rainfall,DATE_FORMAT(reg_date, "%W %M %e %Y") as report_date,datediff(now(),reg_date)as days_old FROM rainfall where rainfall > 0 ORDER by days_old ASC limit 1');
 while ($row = $stmt1->fetch())
                        {
                         $days_old=$row['days_old'];
                         $report_date=$row['report_date'];
                         echo "<p> Last rained $report_date $days_old days ago";

                        }




?>
