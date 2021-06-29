<?php 
require "../../pdotodo.php";
require "../../todocss.php";
session_start();
$pid=$_SESSION['pid'];

echo "project ".$pid;

$mquery="SELECT description FROM projects where id = '".$_SESSION['pid']."'";
$stmt3 = $pdo->query("$mquery");
$stmt3->execute();
$row = $stmt3->fetch(PDO::FETCH_ASSOC);
echo " Project Description ".$row['description'];
echo "<p><a href=insert_todo_form.php>Add Record</a>";

echo "<form action='' method='POST'> ";
echo "<label class='heading'>UnActioned:</label>";
echo "<input type='checkbox' onclick='toggle(this);' />Check all?<br />";


          echo "<table class='table table-striped'><thead><tr><th scope='col'></th><th scope='col'></th><th scope='col'>ID</th><th scope='col'></th>
<th scope='col'>Desc</th><th scope='col'>Action</th><th scope='col'>Cost</th><th scope='col'>Due Date</th>
<th scope='col'>Days</th><th scope='col'>Tag</th></tr></thead><tbody>";



$id_text_query = "select id,risk,description,responsible,action,duedate,DATEDIFF(NOW(),duedate) 
as tdays,reg_date,status,cost,tag1 from todo where pid ='$pid';";
$inner_counter=0;
$stmt = $pdo->query($id_text_query);
                $stmt->execute();
                while ($row = $stmt->fetch())
                        {


                         $id=$row['id'];
                         $description=$row['description'];
                         $reg_date=$row['reg_date'];
                         $action=$row['action'];
                         $status=$row['status'];
                         $cost=$row['cost'];
                         $duedate=$row['duedate'];
                         $tdays=$row['tdays'];
                         $risk=$row['risk'];
                         $tag1=$row['tag1'];

echo "<b>";
$tfont="";
if ($risk == 'big'){
$tfont="red";
$risktext= "R*";
}
else
{
$risktext= "";
}
echo "<tr><th scope='row'></th>";

echo "<td><font color='$tfont'>$risktext</td><td><a href=todo_edit.php?todo_id=$id>$id</a></td><td></b><input type='checkbox' name='lang[]' 
value='$inner_counter' ><input type='hidden' id='$id' name='id[]' value='$id'></td>
<td><input type ='text' name='description[]' value='$description' size='30'></td><td>  
<input type='text' id='$action' name='langtext[]' value='$action' size='60'></td><td> Cost:<input type ='text' name='cost[]' value='$cost' size='5'> 
</td><td>$duedate</font></td><td>";

$tfont="green";
if ($status < 1) {echo "";
                if  ($tdays > 0){$tfont="red";}
                             }else
                             {echo "CL";
                              
                             }
$inner_counter++;

echo "<font color='$tfont'>$tdays</font>";
echo "</td><td><input type ='text' name='tag1[]' value='$tag1' size='6'</td></tr>";


}

echo "</table>";


echo " <p><input type='submit' value='Submit' name='submit'>";
//var_dump($_POST['langtext']);
//var_dump($_POST['lang']);
//var_dump($_POST['cost']);

$stmt3 = $pdo->query("SELECT SUM(cost) AS value_sum FROM todo where pid='$pid'");
$stmt3->execute();
$row = $stmt3->fetch(PDO::FETCH_ASSOC);

echo "<li> total project costs ".$row['value_sum'];



if(isset($_POST['submit']))
{

    if(!empty($_POST['lang'])) 
    {

        foreach($_POST['lang'] as $value)
       {
            $id=$_POST['id'][$value];
            echo "lang value : ".$value.' '.$id.'<br/>';
            $action=$_POST['langtext'][$value];
            $description=$_POST['description'][$value];
            $cost=$_POST['cost'][$value];
            $tag1=$_POST['tag1'][$value];

   	    $id_text_query = "update todo set action = '$action',description='$description',cost='$cost',tag1='$tag1' where id = '$id';";
            echo "<p> ".$id_text_query;
            $stmt2 = $pdo->query($id_text_query);
            $stmt2->execute();
            echo "<p>";
      }

echo "<button onclick=\"window.location.href=window.location.href; return false;\">Continue</button>";
}
}

?>
