<?php 
require "../../pdotodo.php";
require "../../todocss.php";
//ob_start();
session_start();
$pid=$_SESSION['pid'];
if(isset($_POST['submit']))
{
$pid=$_POST['projects'];
echo "<p>project ".$pid; 
$mquery="SELECT description FROM projects where id = '".$pid."'";
//echo $mquery;
$stmt3 = $pdo->query("$mquery");
$stmt3->execute();
$row = $stmt3->fetch(PDO::FETCH_ASSOC);
echo " Current project is ".$row['description'];
$_SESSION['pid']=$pid;

echo "<p><button onclick=\"window.location.href=window.location.href; return false;\">Continue</button>";
}
else
{
echo "<form action='' method='POST'> ";
echo "<label for='projects'>Choose a project:</label><select name='projects' id=projects'>";
$stmt = $pdo->query('select id,description from projects');
$stmt->execute();
while ($row = $stmt->fetch())
        {
                $id=$row['id'];
                $description=$row['description'];
                echo "<option value='".$id."'";
                if ($pid == $id){echo " selected";}
                echo ">".$description."</option>";
        }
echo "</select>";
echo "  <p><input type='submit' value='Submit' name='submit'>";


}



?>
