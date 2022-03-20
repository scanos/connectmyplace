#!/bin/bash

echo "Content-type: text/html"
echo ""
echo "<html><head><title>Event edited</title>"
#echo "<meta http-equiv='Refresh' content='0; url=${HTTP_REFERER}' /></head>"
#echo "<meta http-equiv='Refresh' content='0; url=tasks_view.sh?status=incomplete' /></head>"

id=${QUERY_STRING#*id=}
id=${id%%&*}
id=${id//+/ }


myid="${id}|"
line=$(grep ${id} unapproved.calendar) 

echo "line" $line "myid " ${myid}
echo $line >> main.calendar

sed -i "/${myid}/d" unapproved.calendar
echo "<script>alert('$id approved');</script>"

