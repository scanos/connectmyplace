<?php 
require "../../pdotodo.php";
require "../../todocss.php";


echo "<form action='insert_todo.php' method='POST'> ";
echo "<p><label class='heading'>Add Action</label>";
echo "<p>Description <input type ='text' name='insert_description' value='' size='50'>";
echo "<p>Responsible <input type='text'  name='insert_responsible' value=''>";
echo " <p><input type='submit' value='Submit'>";
?>
