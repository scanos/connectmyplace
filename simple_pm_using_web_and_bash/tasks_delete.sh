#!/bin/bash

echo "Content-type: text/html"
echo ""

cat nav2.html
confirmed=""
id=""
id=${QUERY_STRING#*id=}
id=${id%%&*}
id=${id//+ }
confirmed=${QUERY_STRING#*confirmed=}
confirmed=${confirmed%%&*}
confirmed=${confirmed//+ }

myid=${id}"|"
#echo "id".${id}

#i=0
while read line
do
desc=$(IFS="|" read -ra ADDR <<< "${line}"; echo ${ADDR[2]})
myline=$line
done < <(grep $myid main.calendar)

if [[ "$confirmed" == "yes" ]]; then

sed -i "/$myid/d" main.calendar
echo "<script>alert('$id deleted please press to return to events');"
echo "window.location.href = 'tasks_view.sh';</script>"
echo $myline >> deletion.log
else


echo "<button onclick='myFunction()'>Confirm deletion ${id} ${desc}</button>"
echo "<script>"
echo "function myFunction() {"
echo "  var txt;"
echo "  if (confirm('Press a button!')) {"
echo "window.location.href = 'tasks_delete.sh?id=$id&confirmed=yes';"
echo "  } else {"
echo "alert('$id not deleted please press to return to events');"
echo "window.location.href = 'tasks_view.sh';"

echo "  }"
echo "}"
echo "</script>"



fi


