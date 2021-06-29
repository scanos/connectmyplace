<?php 
require "../../pdotodo.php";
require "../../todocss.php";


echo "<meta http-equiv=\"refresh\" content=\"5; URL='index.php'\" />";
if (!empty($_POST))
{
    $description=$_POST['insert_description'];
    $temp_user=$_POST['insert_owner'];
    $objectives=$_POST['objectives'];
    $start_date=$_POST['datepicker'];
    $due_date=$_POST['datepicker1'];


    echo  "<p>$description $responsible  OBJ $objectives SD $start_date DD $due_date";

$projects_table="projects";
$stmt = $pdo->prepare("INSERT INTO ".$projects_table." (description,owner,objectives,due_date,start_date) 
VALUES  (:description, :owner, :objectives, :due_date, :start_date)");
$stmt->bindParam(':description', $_POST['insert_description'], PDO::PARAM_STR);
$stmt->bindParam(':owner', $temp_user, PDO::PARAM_STR);
$stmt->bindParam(':objectives', $_POST['objectives'], PDO::PARAM_STR);
$stmt->bindParam(':due_date', $due_date, PDO::PARAM_STR);
$stmt->bindParam(':start_date',$start_date, PDO::PARAM_STR);


$stmt->execute();
$p_id = $pdo->lastInsertId();
//$_SESSION['notification'] = " NEW PROJECT ADDED SUCCESSFULLY ID $p_id";
echo " NEW PROJECT ADDED SUCCESSFULLY ID $p_id";

//$temp_location = "Location: edit_project.php?id=$p_id";












}




?>
