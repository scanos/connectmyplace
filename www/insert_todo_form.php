<?php 
require "../../pdotodo.php";

//echo "<meta http-equiv=\"refresh\" content=\"0; URL='index.php'\" />";
require "../../todocss.php";
session_start();
$pid=$_SESSION['pid'];

echo "project ".$pid;


echo "<form action='insert_todo.php' method='POST'> ";
echo "<p><label class='heading'>Add Action</label>";
echo "<p>Description <input type ='text' name='description' value='' size='50'>";
echo "<p>Responsible <input type='text'  name='responsible' value=''>";
echo "<input type='hidden'  name='pid' value='$pid'>";

PRINT <<< END
<fieldset>
<legend><span class="number">3</span>Start Date</legend>
<input type="text" name="datepicker" id="datepicker" value="$start_date">
</fieldset>

<fieldset>
<legend><span class="number">4</span>Duration of task(d) </legend>
<input type="text" name="no_of_days" id="no_of_days" value="$no_of_days" size="3">
</fieldset>




END;

echo " <p><input type='submit' value='Submit'>";
?>
