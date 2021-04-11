Get the city id from city.list.json - see http://bulk.openweathermap.org/sample/
weather_header.html
Call the script using the following format ./ow_weather_alert.sh City_name city_id >/dev/null 2>&1
Note weather.html is created anew each time the script is run by copying from weather_header.html then the 5 day OpenWeather forecast data
You only have to change the City_name city_id  as parameters to ./ow_weather_alert.sh, as shown above

set up a crontab like this for every 3 hours, change /home/pi/connectmyplace_weather to that of the directory from which you will run teh script.
# 0 */3 * * * cd /home/pi/connectmyplace_weather/;./ow_weather_alert.sh Portaferry 2640084 >/dev/null 2>&1



