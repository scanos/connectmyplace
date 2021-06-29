<?php 
require "../../pdotodo.php";
require "../../todocss.php";
$tasks_table="todo";

echo "<meta http-equiv=\"refresh\" content=\"10; URL='index.php'\" />";
if (!empty($_POST))
{
    $description=$_POST['description'];
    $responsible=$_POST['responsible'];
    //$duedate=$_POST['datepicker'];
    $id=$_POST['id'];
    $cost=$_POST['cost'];
    $action=$_POST['action'];
    $status=$_POST['status'];
    $progress=$_POST['progress'];



$t_new_start_date=$_POST['datepicker'];
$no_of_days=$_POST['no_of_days'];
$my_date=substr($my_date,0,10);
$add_days =  " + ". $_POST['no_of_days']." days";
$my_date = date('Y-m-d', strtotime($my_date. $add_days));
$mdd_days = $_POST['no_of_days'] * 24 * 60 * 60;
$tmstamp = strtotime($t_new_start_date) + $mdd_days;
//echo date("Y m d", $tmstamp) ;
$my_date = date("Y-m-d", $tmstamp) ;

echo "<li> adding $add_days due date  is now $my_date start_date is $t_new_start_date";

echo "id $id  status $status description $description action $action"; 


$baseline_date = $my_date;

echo "update todo set duedate = $my_date,start_date= $t_new_start_date,no_of_days = '$no_of_days' where id = $id;";


//$mysql_query="UPDATE ".$tasks_table." set baseline_date = :baseline_date,description = :description,resolution = :resolution,dependency = :dependency
//,no_of_days = :no_of_days,start_date =:start_date,status = :status,duedate =:due_date  WHERE  id = :id";
//echo $mysql_query;
$stmt = $pdo->prepare("UPDATE ".$tasks_table." set description = :description,responsible =:responsible,action = :action,no_of_days = :no_of_days,
start_date =:start_date,status = :status,duedate =:due_date  WHERE  id = :id");


//$stmt = $pdo->prepare($mysql_query);

$stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
$stmt->bindParam(':status', $_POST['status'], PDO::PARAM_INT);
$stmt->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
$stmt->bindParam(':responsible', $responsible, PDO::PARAM_STR);
$stmt->bindParam(':start_date', $t_new_start_date, PDO::PARAM_STR);
$stmt->bindParam(':due_date', $my_date, PDO::PARAM_STR);
//$stmt->bindParam(':baseline_date', $baseline_date, PDO::PARAM_STR);
$stmt->bindParam(':no_of_days', $_POST['no_of_days'], PDO::PARAM_INT);
$stmt->bindParam(':action', $action, PDO::PARAM_STR);
$stmt->execute();



//$t_id = $pdo->lastInsertId();
  // echo " TASK $t_id ADDED ";


}

echo "Record updated";


?>
