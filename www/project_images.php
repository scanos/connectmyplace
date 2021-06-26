<?php
require "../../pdo2.php";
$homepage = file_get_contents('../../ccs.php');
$healthy = "nav-item active";
$yummy   = "nav-item";
$homepage = str_replace($healthy, $yummy, $homepage);
echo $homepage;

//require "../../bootstrap.php";
$id = trim($_GET['id']);
$id = strip_tags($id);
$id = htmlspecialchars($id);

                $stmt = $pdo->prepare("SELECT id,description from projects where id = (?)");
                $stmt->execute([$id]);
                while ($row = $stmt->fetch()){echo "<h1> Project ".$row['id']." -  ". $row['description']."</h1>";}


		$stmt2 = $pdo->prepare("SELECT id,pid,name,description from images where pid = (?)");
		$stmt2->execute([$id]);

                echo "<table>";
                while ($row = $stmt2->fetch())
                        {
                         //$pid=$row['pid'];
                         $id=$row['id'];
                         $name=$row['name'];
                         $description=$row['description'];
                         //$description=str_replace(" ","%20","$description");
                         echo "<tr><td>$id  $description</td></tr><tr><td>";
                         echo "<a href= $name><img src='$name'  width='256' height='256'></a>";
                         //$new_url = "<a href=1-basics.php?taskname=".$description."&id=".$id.">photos</a>";
                         echo $new_url;
                         echo "</td><td>";

echo "<form action='add_text_image.php' method='POST'> ";
echo "<p>ADD TEXT";
echo" <input type='text' name='description'> ";
echo" <input type='hidden' name='id' value='$id'> ";
echo" <input type='hidden' name='name' value='$name'> ";
echo " <input type='submit' value='submit'></form>";


echo "<form action='delete_image.php' method='POST'> ";
echo "<p>DELETE TASK / PHOTO";
//echo" <input type='text' name='description'> ";
echo" <input type='hidden' name='id' value='$id'> ";
echo" <input type='hidden' name='name' value='$name'> ";
echo " <input type='submit' value='submit'></form>";
echo "</td></tr>";
}

//cho "<li>$changed_file $changed_file_txt";
//echo "<img src='$changed_file'  width='512' height='512'>";
//echo "<img src='$changed_file_txt'  width='512' height='512'>";



?>
