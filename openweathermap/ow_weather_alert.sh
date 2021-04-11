#!/bin/bash
#get the city id from city.list.json - see http://bulk.openweathermap.org/sample/
#call the script using the following format ./ow_weather_alert.sh City_name city_id >/dev/null 2>&1
#note weather.html is created anew each time the script is run by copying from weather_header.html then the 5 day OpenWeather forecast data
#You only have to change the City_name city_id  as parameters to ./ow_weather_alert.sh, as shown above

webdate=$(date)
webpage=$(cat weather_header.html)
webpage=${webpage//XXXX/$1}
webpage=${webpage//DDDD/$webdate}
echo $webpage>weather.html

test=$(tail -1 ~/rainfall)
test=$(echo ${test#*\?})
datenow=$(date +%s)
test=$(echo $datenow - $test | bc)
test=$(echo $test / 3600 | bc)
echo "<p> Last rained $test hours ago" >> weather.html
echo "<p style=\"color:red\">lines shown in red where wind greater than 30 mph or temperature less than 3 deg C</p>"  >> weather.html
testweather=$(curl "http://api.openweathermap.org/data/2.5/forecast?id=${2}&APPID=YOURAPP_ID")

for (( i=0; i<=38; i++ ))
do
        testicon=$(echo $testweather | jq ".list[$i].weather[].icon")
        longicon="<img src=http://openweathermap.org/img/wn/XXX@2x.png   width='50' height='50'>"
        testicon=${longicon/XXX/$testicon}
        testicon=${testicon//\"/}
	testdate=$(echo $testweather | jq ".list[$i].dt_txt")
	testday=$(echo "${testdate%% *}")
        #remove 1st character comma
        testday=${testday#?}
	newdate=$(date -d "${testday}" "+%a %d %B %Y")
        testtime=$(echo "${testdate##* }")
        testtime=${testtime/\"/}
	windspeed=$(echo $testweather | jq ".list[$i].wind.speed")
	windspeed=$(echo "scale=0; $windspeed * 2.23694" | bc)
        windspeed=$(printf "%.2g\t" ${windspeed})

        rain=$(echo $testweather | jq ".list[$i].rain[]")

if [[ $rain == *"null"* ]]; then
rain=""
else
	mlength=${#rain}
	echo "$mlength  $rain"
	if [[ "$mlength" -gt "0" ]]; then
		rain="rain $rain mms"
	fi
fi

snow=$(echo $testweather | jq ".list[${i}].snow[]")
if [[ $snow == *"null"* ]]; then
snow=""
else
	mlength=${#snow}
	if [[ "$mlength" -gt "0" ]]; then
	snow="snow $snow mms"
	fi
fi
temp=$(echo $testweather | jq ".list[${i}].main.temp") 
temp=$(echo $temp- 273.15| bc)

#converts to integer
temp=${temp%.*}
 
b=30.0
z=3.0
#if (( $(echo "$num1 > $num2" |bc -l) )); then
if (( $(echo "$windspeed > $b" |bc -l)  || $(echo "$temp < $z" |bc -l)  )); then
 
	#if [ "$windspeed" -gt "$b" ] || [ "$temp" -lt "$z" ]; then
	pstart="<p style=\"color:red\">"
	else
	pstart="<p>"
	fi

echo $pstart $newdate $testtime $windspeed mph $temp C ${rain} ${snow} $testicon"</p>" >> weather.html


done

#This copies the local weather.html file to your remote server's web area
#Note that the /var/www/html/weather.html must be chown 
#-rwxr-xr-x 1 pi           www-data         6023 Apr 11 20:00 weather.html

sshpass -p 'YOURPASSWORD' scp weather.html pi@YOURREMOTESERVERIPADDRESS:/var/www/html/weather.html

# use a crontab like this for every 3 hours
# 0 */3 * * * cd /home/pi/connectmyplace_weather/;./ow_weather_alert.sh Portaferry 2640084 >/dev/null 2>&1

#copies to local intranet
sudo cp -p weather.html /var/www/html/weather.html

