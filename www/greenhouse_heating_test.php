<?php
require "../../pdo2.php";
require "../../bootstrap.php";

                $stmt = $pdo->query('SELECT id,microgreen,reg_date,greenhouse1,greenhouse2,conservatory,outsideweather,weather,notes FROM greenhouse_heating_test ORDER BY reg_date DESC');
                $stmt->execute();
                echo "<table class='table table-striped'><thead><tr><th scope='col'></th><th scope='col'>ID</th><th scope='col'>Date</th><th scope='col'>GH1 C</th>
      <th scope='col'>GH2 C</th><th scope='col'>Con C</th><th scope='col'>Outside T C</th><th scope='col'>Weather</th> <th scope='col'>Mgre</th><th scope='col'>Notes</th></tr></thead><tbody>";

                while ($row = $stmt->fetch())
                        {
                         $id=$row['id'];
                         $greenhouse1=$row['greenhouse1'];
                         $greenhouse2=$row['greenhouse2'];
                         
                         $reg_date=$row['reg_date'];
                         $conservatory=$row['conservatory'];
                         $outsideweather=$row['outsideweather'];
                         $weather=$row['weather'];
                         $microgreen=$row['microgreen'];
	
                         $notes=$row['notes'];



			 //$mdescription=str_replace(" ","%20","$description");
                         echo "<th scope='row'></th><td>$id";
                         //$new_url = "<a href=1-basics.php?taskname=".$mdescription."&id=".$id.">photos</a>";
                         //echo $new_url;
                         echo "</td><td>$reg_date</td><td>$greenhouse1</td><td>$greenhouse2</td><td>$conservatory</td><td>$outsideweather</td><td>$weather</td><td><td>$microgreen</td><td>";

echo "<form action='edit_ght.php' method='POST'> ";
echo "<input type='text' id ='notes' name='notes' $notes value='$notes'> ";
//echo "<input type='text' id='mnote' name='mnote' value='${name3}'></td><td> "

echo" <input type='hidden' name='id' value='$id'> ";
echo " <input type='submit' value='submit'></form>";

			echo "</td></tr>";
                        }



?>
