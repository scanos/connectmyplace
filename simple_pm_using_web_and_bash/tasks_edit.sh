#!/bin/bash

echo "Content-type: text/html"
echo ""
echo "<html><head><title>Event edited</title>"
echo "<meta http-equiv='Refresh' content='1; url=tasks_view.sh' /></head>"

id=${QUERY_STRING#*id=}
id=${id%%&*}
id=${id//+/ }


responsible=${QUERY_STRING#*responsible=}
responsible=${responsible%%&*}
responsible=${responsible//+/ }
responsible=${responsible//%40/@}

note=${QUERY_STRING#*mnote=}
note=${note%%&*}
note=${note//+/ }

mark_as_complete=${QUERY_STRING#*mark_as_complete=}
mark_as_complete=${mark_as_complete%%&*}
mark_as_complete=${mark_as_complete//+/ }

echo "<p> id $id mark as complete mark_as_complete $mark_as_complete mark length ${#mark_as_complete}<p>"
#echo "<p> note $note resp $responsible<p>"


i=0
while read line
do
array[ $i ]="$line"
name1=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[0]})
name2=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[1]})
name3=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[2]})
name4=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[3]})
name5=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[4]})
name6=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[5]})
status=$name5
#echo "<li> status $status after name5"
		#if [[ "$mark_as_complete" == "_finished" ]];
		#then
		#status="_finished"
                #fi
                #if [[ "$mark_as_complete" == "_incomplete" ]];
                #then
                #status="_incomplete"
                #fi
#name4=${name4/ //}
oldentry="|$name3|$name4|$name5|$name6|"
#responsible=${responsible/ //}
newentry="|$note|$responsible|$status|$name6|"
    (( i++ ))
done < <(grep $id main.calendar)
echo "<p>oldentry $oldentry"
echo "<p>newentry $newentry"
echo "checking if oldentry is right"
grep $oldentry main.calendar 

echo "<p>id $id"
sed -i "s/$oldentry/$newentry/g" main.calendar
