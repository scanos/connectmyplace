<?php 
require "../../pdotodo.php";
require "../../todocss.php";
session_start();
$pid=$_SESSION['pid'];

echo "project ".$pid;

$mquery="SELECT  image_location,tid FROM todo.image where pid = '".$_SESSION['pid']."'";
$stmt = $pdo->query("$mquery");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);


          echo "<table class='table table-striped'><thead><tr><th scope='col'></th><th scope='col'></th></tbody>";
                $stmt->execute();
                while ($row = $stmt->fetch())
                        {


                         $tid=$row['tid'];
                         $image_location=$row['image_location'];

echo "<tr><th scope='row'></th><th><img src='$image_location'></th></tr>";
}
echo "</table>";
?>
