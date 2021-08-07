#!/bin/bash
# Get the city id from city.list.json - see http://bulk.openweathermap.org/sample/ in this case 2640084 for Portaferry
# Call the script using this notation ./weather_medium_entry.sh
total_rainfall=0
testweather=$(sudo curl "https://api.openweathermap.org/data/2.5/forecast?id=2640084&APPID=be24cd1ab5d2f7fc33c7d2e43ca58cfb")
#note that this is a temporary api code and will not work now 
rec_count=$(echo $testweather | jq -r '.cnt')
city_name=$(echo $testweather | jq -r '.city.name')

for (( i=0; i<=${rec_count}; i++ ))
do
        rain=$(echo $testweather | jq -r .list[$i] |grep "3h"| cut -d ":" -f 2)
        rdate=$(echo $testweather | jq -r .list[$i].dt_txt)
        rainlength=${#rain}
        if [ "$rainlength" -gt "0" ]; then
                echo $rdate rain $rain
                rain=$(echo "$rain * 100" | bc) #convert rain to integer by multipyling by one hundred
                rain="${rain%%.*}" #remove zeros after decimal point
                total_rainfall=$((total_rainfall + rain))
        fi
done

total_rainfall=$(echo "$total_rainfall / 100" | bc) #reverse the previous multiplication by one hundred
echo "total_rainfall for" $city_name $total_rainfall "mms"
