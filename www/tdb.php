<?php
require "../../pdo2.php";
require "../../bootstrap.php";

                $stmt = $pdo->query('SELECT id,description,datediff(now(),reg_date)as days_old FROM projects');
                $stmt->execute();
                echo "<table class='table table-striped'><thead><tr><th scope='col'></th><th scope='col'</th><th scope='col'</th><th scope='col'>PID</th>
      <th scope='col'>Desc</th><th scope='col'>Days old</th> </tr></thead><tbody>";

                while ($row = $stmt->fetch())
                        {
                         $id=$row['id'];
                         $description=$row['description'];
                         $days_old=$row['days_old'];
			 $mdescription=str_replace(" ","%20","$description");
                         echo "<th scope='row'></th><td><a href=edit_project.php?id=$id>Edit</a></td><td>";
                         $new_url = "<a href=1-basics.php?taskname=".$mdescription."&id=".$id.">photos</a>";
                         echo $new_url;
                         echo "</td><td><a href=project_images.php?id=$id>Tasks</a><td>$id</td><td>$description</td><td>$days_old</tr>";
                        }


echo "<form action='add_project.php' method='post'> ";
echo "<p>QUICK ADD NEW PROJECT ---------";
echo"Description <input type='text' name='description'> ";
echo"Owner <input type='text' name='owner'> ";
echo " <input type='submit' value='submit'></form>";

?>
