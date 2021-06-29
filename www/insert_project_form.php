<?php 
require "../../pdotodo.php";
require "../../todocss.php";


echo "<form action='insert_project.php' method='POST'> ";
echo "<p><label class='heading'>Add Project</label>";
echo "<p>Description <input type ='text' name='insert_description' value='' size='50'>";
echo "<p>Owner <input type='text'  name='insert_owner' value=''>";

PRINT <<< END

<fieldset>
<legend><span class="number">3</span>Objectives</legend>
<input type="text" name="objectives" id="objectives" value="$objectives">
</fieldset>


<fieldset>
<legend><span class="number">3</span>Start Date</legend>
<input type="text" name="datepicker" id="datepicker" value="">
</fieldset>


<fieldset>
<legend><span class="number">3</span>Due Date</legend>
<input type="text" name="datepicker1" id="datepicker1" value="">

</fieldset>
END;
echo " <p><input type='submit' value='Submit'>";

