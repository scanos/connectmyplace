#!/bin/bash
htab="&ensp;"

itext=${QUERY_STRING#*itext=}
itext=${itext%%&*}
itext=${itext//+/ }
itext=${itext//\%2F/\/}
itext=${itext//\%3A/\:}
itext=${itext//\%0D%0A/&#13;}
itext=${itext//\%3F/?}
itext=${itext//\%3D/=}


ltext=${#itext}

id=${QUERY_STRING#*id=}
id=${id%%&*}
id=${id//+/ }

repeat=${QUERY_STRING#*repeat=}
repeat=${repeat%%&*}
repeat=${repeat//+/ }




echo "Content-type: text/html"
echo ""
cat nav2.html
itext_infile=$(cat ${id})
photo_id=${id}
echo "<li>photo_id $photo_id"

echo "<h1> Edit Task $id </h1>"
echo "<div class='container'>"
#echo "<h2>A</h2>"
echo "<form action='tasks_id.sh'>"
echo "<div class='form-group'>"

checkid="${id}_"
checkrepeat=$(grep ${checkid} repeat.calendar)
#echo "<p> checkrepeat $checkrepeat "
#formrepeat=${checkrepeat//$checkid/}

formrepeat=$(IFS="|" read -ra ADDR <<< "${checkrepeat}"; echo ${ADDR[1]})


#echo "<p> checkrepeat $checkrepeat "
echo "<label for='note'>Repeat (days)</label>"
echo "<input type='text' class='form-control' id='repeat' placeholder='repeat every x days' name='repeat' value='${formrepeat}'>"

echo "<label for='note'>Note:</label>"
echo " <textarea class='form-control' id='itext' placeholder='Add Notes' name='itext' rows='15'> ${itext_infile}</textarea>"
echo "<input type='hidden' id='id' name='id' value='${id}'>"
#echo "<input type='hidden' id='hiddenrepeat' name='hiddenrepeat' value='${repeat}'>"

echo "</div>"
echo "<button type='submit' class='btn btn-default'>Submit</button></form></div>"
#echo "<p> id $id itext $itext ltext $ltext"
echo "<p>"

echo "<div class='container'>"
echo "<h2>Add Sub Task</h2>"
echo "<form action='tasks_add.sh'>"
echo "<div class='form-group'>"
echo "<label for='responsible'>Responsible:</label>"
echo "<input type='email' class='form-control' id='responsible' placeholder='Enter email' name='responsible'>"
echo "</div>"
echo "<div class='form-group'>"
echo "<label for='note'>Note:</label>"
echo "<input type='text' class='form-control' id='note' placeholder='Enter description' name='note'>"
echo "<input type='hidden' id='mydate' name='mydate' value='$mydate'>"
echo "<input type='hidden' id='id' name='id' value='$id'>"
echo "<input type='hidden' id='type' name='subtask' value='subtask'>"
echo "</div>"

echo " <div class='form-check'>"
echo " <input type='checkbox' class='form-check-input' name='complete_check' id='complete_check' value='_finished'>"
echo " <label class='form-check-label' for='complete_check'>Task completed</label>"
echo "</div>"

echo "<button type='submit' class='btn btn-default'>Submit</button></form></div>"

echo "<div class='container'><h2>Sub Tasks</h2><p>Event <div class='table-responsive'><table class='table'><thead><tr>"
echo "<th scope='col'>Notes</th><th scope='col'>Responsible</th><th scope='col'>Status</th>"
echo "<th scope='col'></th><th scope='col'></th><th scope='col'></th></thead> <tbody>"


ss=${id}".calendar"
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

#echo "<p>$name1 $name2 $name3 $name4 $name5 $name6";
nilvalue=''
echo "<tr><th scope='row'><b><a href=tasks_id.sh?id=${name6}&itext=${nilvalue}>${name6}</a></b></th><td> ${name2}</td><td><form action=plant_event_edit.sh>"
echo "<input type='text' id='mnote' name='mnote' value='${name3}'></td><td> "
echo "<input type='text' id='responsible' name='responsible' value='${name4}'>"
echo "</td><td></td><td>"

echo "<input type='hidden' id='id' name='id' value='${name6}'>"

if [[ "$name5" == "_finished" ]];
then
#class="font-weight-bold"
echo "</td><td><p class='text-success'><b>${name5}</b></p></td><td>"
echo "</td><td><label for='mark_as_complete'> Mark as NOT completed</label><br></td></td>"
echo "<td><input type='checkbox' id='mark_as_complete' name='mark_as_complete' value='_incomplete'></td>"

fi



if [[ "$name5" == "_incomplete" ]];
then
echo "</td><td>${name5}</td><td>"
echo "</td><td><label for='mark_as_complete'> Mark as completed</label><br></td></td>"
echo "<td><input type='checkbox' id='mark_as_complete' name='mark_as_complete' value='_finished'></td>"
fi
echo "<td><input type='submit' value='Submit'></form></td>"
echo "<td><a href=tasks_delete.sh?id=$name6>   Delete Event</a></td></tr>"
    (( i++ ))




done < <(cat $ss)
echo " </tbody></table>"
echo "</div></div>"





#this adds note from this form to the id file
if [[ "$ltext" -gt "0" ]]
then
echo "$itext" > ${id}
#echo "$itext added to ${id}"
#echo " "
fi
#this adds note from this form to the id file


#this adds repeat value from this form to repeat.calendar

#formrepeat 1 repeat 14
# when repeat changed then have to update repeat.calendar
# special case if length of repeat is 0 then delete from repeat calendar

lengthrepeat=${#repeat}

if [[ "$formrepeat" -ne "$repeat" ]]; then
echo "<p> formrepeat $formrepeat repeat $repeat lengthrepeat $lengthrepeat"
fi

if [[ "$repeat" -gt "0" ]]; then
sed -i "/${id}_/d" repeat.calendar
echo "${id}_|${repeat}" >> repeat.calendar
fi

if  [[ "$formrepeat" -gt "0" && "$lengthrepeat" -lt "1" ]]; then
sed -i "/${id}_/d" repeat.calendar
fi

#echo "<p> formrepeat $formrepeat repeat $repeat lengthrepeat $lengthrepeat"





#fi


#sed -i "/$myid/d" main.calendar
#echo "<script>alert('$id deleted please press to return to events');"
#echo "window.location.href = 'plant_view_events.sh';</script>"
#echo $myline >> deletion.log
#else

#this adds repeat value from this form to repeat.calendar





#idpng="${photo_id}.png"
#echo "<li> idpng $idpng  id $id photo_id $photo_id"
#echo "<p><a href=https://connectmyplace.com/1-basics.html?imagename=${idpng}>Take Photo</a>"
#echo "<img src='https://connectmyplace.com/${idpng}'  width='460' height='345'>"

echo "<h2> Take Photo </h2>"
echo "<form action='https://connectmyplace.com/1-basics.html'  method='get'>"
echo "<div class='form-group'>"
echo "<label for='tag'>Tag:</label>"
echo "<input type='text' id='tag' name='tag'>"
echo "<input type='hidden' id='imagename' name='imagename' value='${photo_id}'>"
echo "<button type='submit' class='btn btn-default'>Submit</button></form></div>"
#searchid=${id}".txt"
searchid=${photo_id}".txt"
echo "<p>searchid $searchid"
getimg_pics=$(curl https://connectmyplace.com/images/${searchid})
ss="${photo_id}.calendar"
echo "<p> ss is $ss"
IFS='|' # space is set as delimiter
read -ra ADDR <<< "${getimg_pics}" # str is read into an array as tokens separated by IFS
for i in "${ADDR[@]}"; do # access each element of array
    #echo "<p>${i}"
    if [[ "${i}" == *"png"* ]]; then
    #echo "<p><img src='https://connectmyplace.com/images/${i}'  width='460' height='345'>"
    #echo "<img src='https://connectmyplace.com/images/${i}' class='img-fluid' alt='Responsive image'>"
    echo "<img class='img-responsive' src='https://connectmyplace.com/images/${i}' alt='Bhub' width='460' height='345'>" 
    echo "<li>${i}"
    else
    echo "<p>${i}" 
    fi 
done




