#!/bin/bash


wind=$( echo $(sudo curl "https://api.openweathermap.org/data/2.5/weather?lat=54.38&lon=-5.54&APPID=YOUR_API_ID" | jq '.wind.speed'))
wind=$(echo "scale=0; $wind * 2.23694" | bc )
wind=${wind%.*} #return substring before decimal point

mydate=$(date "+%d-%m-%Y %H:%M")
echo $mydate "$wind" "Wind" "Speed" "mph"
echo "['$mydate', $wind]," >> wind.log

cat windheader.html wind.log windfooter.html > windchartline.html
cp windchartline.html /var/www/html/windchartline.html




