<?php 
require "../../pdotodo.php";
require "../../todocss.php";

session_start();
$pid=$_SESSION['pid'];
echo "project ".$pid;

echo "<meta http-equiv=\"refresh\" content=\"5; URL='index.php'\" />";
if (!empty($_POST))
{
$description=$_POST['description'];
$responsible=$_POST['responsible'];


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
echo "id $id description  ".$_POST['description']." responsible  ".$_POST['responsible'];
$baseline_date = $my_date;


$stmt = $pdo->prepare("INSERT INTO todo (responsible,description,pid,start_date,duedate,no_of_days) 
VALUES  (:responsible, :description, :pid, :start_date, :due_date, :no_of_days)");


$stmt->bindParam(':description', $description, PDO::PARAM_STR);
$stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
$stmt->bindParam(':responsible', $responsible, PDO::PARAM_STR);
$stmt->bindParam(':start_date', $t_new_start_date, PDO::PARAM_STR);
$stmt->bindParam(':due_date', $my_date, PDO::PARAM_STR);
$stmt->bindParam(':no_of_days', $_POST['no_of_days'], PDO::PARAM_INT);

$stmt->execute();

$tid = $pdo->lastInsertId();

//$_SESSION['notification'] = " NEW PROJECT ADDED SUCCESSFULLY ID $p_id";
echo " NEW task ADDED SUCCESSFULLY ID $tid";
//$tag1="T".$tid;
//$stmt = $pdo->prepare("UPDATE todo set tag1=:tag1 where id=:tid");
//$stmt->bindParam(':tid', $tid, PDO::PARAM_INT);
//$stmt->bindParam(':tag1', $tag1, PDO::PARAM_STR);

$stmt->execute();


}




?>
