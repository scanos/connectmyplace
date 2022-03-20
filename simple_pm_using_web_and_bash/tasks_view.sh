#!/bin/bash

echo "Content-type: text/html"
echo ""
cat nav2.html

echo "<ul class='list-group'>"
echo "<li class='list-group-item'><a href=tasks_view.sh?status=unapproved>Unapproved tasks</a></li>"
echo "<li class='list-group-item'><a href=tasks_view.sh?status=overdue>See Overdue tasks</a></li>"
echo "<li class='list-group-item'><a href=tasks_view.sh?status=incomplete>See incomplete tasks</a></li>"
echo "<li class='list-group-item'> <a href=tasks_view.sh>See all tasks</a></li>"
echo "</ul>"

echo "<div class='container'>"
echo "<h2>Add a Task</h2>"
echo "<form action='tasks_add.sh'>"
echo "<div class='form-group'>"
echo "<label for='responsible'>Responsible:</label>"
echo "<select id='responsible' name='responsible'>"

while read emailaddress
do
echo "<option value= '$emailaddress'>$emailaddress</option>"
done < <(cat tasks_users)

echo "</select>"





echo "</div>"
echo "<div class='form-group'>"
echo "<label for='datepicker'>Due Date:</label>"
echo "<input class='form-control' type='text' placeholder='Enter Due Date' name='datepicker' id='datepicker' />"
echo "</div>"


echo " <div class='form-check'>"
echo " <input type='checkbox' class='form-check-input' name='complete_check' id='complete_check' value='_finished'>"
echo " <label class='form-check-label' for='complete_check'>Task completed</label>"
echo "</div>"



echo "<div class='form-group'>"
echo "<label for='note'>Note:</label>"
echo "<input type='text' class='form-control' id='note' placeholder='Enter description' name='note'>"




echo "<input type='hidden' id='mydate' name='mydate' value='$mydate'>"
echo "<input type='hidden' id='status' name='status' value='_incomplete'>"

echo "</div>"
echo "<button type='submit' class='btn btn-default'>Submit</button></form></div>"


status=""
status=${QUERY_STRING#*status=}
status=${status%%&*}
status=${status//+/ }
mtoday=$(date +'%d'-'%m'-'%Y')
#echo "<p> before loop mtoday is $mtoday status $status length status ${#status}"
lstatus=${#status}

#for looping through main calendar
if [[ "$lstatus" -lt "2" ]];
then
ss="tac main.calendar"

echo "<div class='container'><h2>Table</h2><p>Event <div class='table-responsive'><table class='table'><thead><tr>"

echo "<th scope='col'>Notes</th><th scope='col'>Responsible</th><th scope='col'>Status</th>"
echo "<th scope='col'></th><th scope='col'></th><th scope='col'></th></thead> <tbody>"

else

        if [[ "$status" == "unapproved" ]]; then
        ss="tac unapproved.calendar"

        url2="plant_event_quickchange_toapproved.sh"
        url3="Change to Approved"
        fi


        if [[ "$status" == "incomplete" ]]; then
        ss="grep incomplete main.calendar"
        url1="tasks_id.sh"
        url2="tasks_quickchange_tocomplete.sh"
        url3="Change to Completed"
        fi

        if [[ "$status" == "overdue" ]]; then
        overdueoutput=$("/usr/lib/cgi-bin/action_plan/test_incomplete_main.sh")
        echo ${overdueoutput}

        fi



echo "<ul class='list-group'>"


while read line 
do 

array[ $i ]="$line"
name2=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[1]})
name3=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[2]})
name4=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[3]})
name5=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[4]})
name6=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[5]})

echo "<li class='list-group-item'><a href=tasks_id.sh?id=${name6}&itext=${nilvalue}>${name6}</a> $name2 <b>$name3</b> $name4 <b>$name5</b>
<a href=tasks_quickchange_tocomplete.sh?id=${name6}> Change to completed </a></li>"

while read subtasks
do
subtaskid=$(IFS="|" read -ra ADDR <<< "${subtasks}"; echo ${ADDR[5]})
subtaskdesc=$(IFS="|" read -ra ADDR <<< "${subtasks}"; echo ${ADDR[2]})
subtaskresp=$(IFS="|" read -ra ADDR <<< "${subtasks}"; echo ${ADDR[3]})
subtaskstatus=$(IFS="|" read -ra ADDR <<< "${subtasks}"; echo ${ADDR[4]})
echo "<li>"$subtaskid $subtaskdesc $subtaskresp $subtaskstatus


done < <(cat $name6".calendar")

	done < <($ss)

echo "</ul>"
ss="cat blank"

fi



#for looping through main calendar

i=0
while read line
do
array[ $i ]="$line"
name1=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[0]})
#echo $name1
name2=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[1]})
name3=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[2]})
name4=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[3]})
name5=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[4]})
name6=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[5]})

nilvalue=''
echo "<tr><th scope='row'><b><a href=tasks_id.sh?id=${name6}&itext=${nilvalue}>${name6}</a></b></th><td> ${name2}</td><td><form action=tasks_edit.sh>"
echo "<input type='text' id='mnote' name='mnote' value='${name3}'></td><td> "
echo "<input type='text' id='responsible' name='responsible' value='${name4}'>"
echo "</td><td></td><td>"

echo "<input type='hidden' id='id' name='id' value='${name6}'>"
echo "<td><input type='submit' value='Submit'></form></td>"



if [[ "$name5" == "_finished" ]]; 
then
echo "</td><td><p class='text-success'><b>${name5}</b></p></td><td>"
echo "<td><a href=tasks_quickchange_toincomplete.sh?id=${name6}> Change to not finished </a></td>"
fi

if [[ "$name5" == "_incomplete" ]];
then
echo "</td><td>${name5}</td><td>"
echo "<td><a href=tasks_quickchange_tocomplete.sh?id=${name6}> Change to COMPLETED </a></td>"
echo "<tr><td>$subtasks</td></tr>"


fi


if [[ "$name5" == "_unapproved" ]];
then
echo "</td><td><p class='text-success'><b>${name5}</b></p></td><td>"
echo "<td><a href=plant_event_quickchange_toincomplete.sh?id=${name6}> Change to not finished </a></td>"
fi



echo "<td><a href=tasks_delete.sh?id=$name6>   Delete Event</a></td></tr>"
    (( i++ ))
done < <($ss)

echo " </tbody></table>"
echo "</div></div>"

echo "<li class='list-group-item'><a href=tasks_view.sh?status=unapproved>Unapproved tasks</a></li>"
echo "<p> <a href=tasks_view.sh?status=incomplete>See incomplete tasks</a>"
echo "<p> <a href=tasks_view.sh>See all tasks</a>"

