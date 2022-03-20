#!/bin/bash

echo "Content-type: text/html"
echo ""
echo "<html><head><title>Note added</title>"

echo "<meta http-equiv='Refresh' content='10; url=${HTTP_REFERER}' /></head>"
echo "<body>Note added "

#echo "query string ${QUERY_STRING}"



note=${QUERY_STRING#*note=}
note=${note%%&*}
note=${note//+/ }
responsible=${QUERY_STRING#*responsible=}
responsible=${responsible%%&*}
responsible=${responsible//+/ }
responsible=${responsible//%E2%27/}
responsible=${responsible//%40/@}

mydate=${QUERY_STRING#*mydate=}
mydate=${mydate%%&*}
mydate=${mydate//+/ }
status=${QUERY_STRING#*status=}
status=${status%%&*}
status=${status//+/ }
#note that the _ is added to the status to ensure no errors during future updates

id=${QUERY_STRING#*id=}
id=${id%%&*}
id=${id//+/ }

subtask=${QUERY_STRING#*subtask=}
subtask=${subtask%%&*}
subtask=${subtask//+/ }

#complete_check
complete_check=${QUERY_STRING#*complete_check=}
complete_check=${complete_check%%&*}
complete_check=${complete_check//+/ }


datepicker=${QUERY_STRING#*datepicker=}
datepicker=${datepicker%%&*}
datepicker=${datepicker//+/ }

echo "<p> datepicker $datepicker id $id subtask $subtask lsubtask $lsubtask $note $responsible $mydate $status complete_check $complete_check"


if [[ "$subtask" == "subtask" ]]; then
ss=$id".calendar"
myreffile=$id".ref"
myref=$(cat $myreffile)
     if [[${#myref} -lt "1" ]]; then
	myref=0
     fi
(( myref++ ))
echo "$myref" > ${myreffile} 
recref="${id}_${myref}"
oldentry="_finished|${id}|"
newentry="_incomplete|${id}|"
echo "<p>oldentry $oldentry"
echo "<p>newentry $newentry"
sed -i "s/$oldentry/$newentry/g" main.calendar
echo "<script>alert(' sub task added and Main task $id set to incomplete');</script>"
else
ss="main.calendar"
myref=$(($(cat eventref.txt)+1))
echo "$myref" > eventref.txt
recref=XX$myref
fi

responsible=${responsible/%40/@}
temp="%E2%27"
responsible=${responsible/$temp/}
responsible=${responsible/ //}
mydate=$datepicker


#if task is completed don't send email
status=$complete_check
if [[ "$status" != "_finished" ]]; then
status="_incomplete"

ddd=$(hostname -I)
IFS=' ' read -r -a dddarray <<< "$ddd"
murl="http://"${dddarray[0]}"/cgi-bin/action_plan/tasks_view.sh?status=incomplete"

echo "murl $murl"

while read emailaddress
do
      if [[ "$emailaddress" == "$responsible" ]]; then
      	echo "<html><body> You have been assigned Task $recref $note <a href=${murl}> click to see updated task list</a></body></html>"| mail -a "Content-type: text/html; " -s "New Task added" "$emailaddress"
     else
     	echo "<html><body> For information, $responsible has been assigned Task $recref $note <a href=${murl}> click to see updated task list</a></body></html>"| mail -a "Content-type: text/html; " -s "New Task added" "$emailaddress"
      fi
done < <(cat tasks_users)

fi
#if task is completed don't send email

echo "spare|$mydate|$note|$responsible|$status|$recref|<br><p>" >> $ss
