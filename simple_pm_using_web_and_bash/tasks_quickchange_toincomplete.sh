#!/bin/bash

echo "Content-type: text/html"
echo ""
echo "<html><head><title>Event edited</title>"
echo "<meta http-equiv='Refresh' content='0; url=${HTTP_REFERER}' /></head>"

id=${QUERY_STRING#*id=}
id=${id%%&*}
id=${id//+/ }

oldentry="_finished|${id}|"
newentry="_incomplete|${id}|"

echo "<p>oldentry $oldentry"
echo "<p>newentry $newentry"
sed -i "s/$oldentry/$newentry/g" main.calendar
