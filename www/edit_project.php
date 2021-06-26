<?php
require "../../pdo2.php";
require "../../bootstrap.php";

$id = trim($_GET['id']);
$id = strip_tags($id);
$id = htmlspecialchars($id);
                $stmt = $pdo->prepare("SELECT id,description from projects where id = (?)");
                $stmt->execute([$id]);


                echo "<table class='table table-striped'><thead><tr><th scope='col'></th><th scope='col'</th><th scope='col'</th><th scope='col'>PID</th>
      <th scope='col'>Desc</th><th scope='col'>Days old</th> </tr></thead><tbody>";

                while ($row = $stmt->fetch())
                        {
                         $id=$row['id'];
                         $description=$row['description'];
                         $days_old=$row['days_old'];
                         $mdescription=str_replace(" ","%20","$description");
                         echo "<th scope='row'></th><td><a href=edit_project.php>Edit</a></td><td>";
                         $new_url = "<a href=1-basics.php?taskname=".$mdescription."&id=".$id.">photos</a>";
                         echo $new_url;
                         echo "</td><td><a href=project_images.php?id=$id>Tasks</a><td>$id</td><td>$description</td><td>$days_old</tr>";
                        }





?>
<form action='test.php' method='post'>
<input type="text" name="datepicker" id="datepicker" value="$start_date">
<input type='submit' value='submit'></form>
