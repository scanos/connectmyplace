#!/bin/bash

echo "Content-type: text/html"
echo ""
echo "<html><head><title>Event edited</title>"
echo "<meta http-equiv='Refresh' content='0; url=${HTTP_REFERER}' /></head>"

id=${QUERY_STRING#*id=}
id=${id%%&*}
id=${id//+/ }

oldentry="_incomplete|${id}"
newentry="_finished|${id}"
sed -i "s/$oldentry/$newentry/g" main.calendar
