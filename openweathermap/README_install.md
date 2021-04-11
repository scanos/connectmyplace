You will need
a Linux based intranet and internet server
Access to CLI on both and privileges to use secure SCP (Note the script runs on the intranet for security purposes)
OpenWeatherMap api credentials

To install
Download the script ow_weather_alert.sh from Github and save it to a secure directory on your local network , not internet.
In the same directory copy weather_header.html
Create a web page weather.html (containing any word as it will be overwritten) in your home directory where the script will be located , and copy it to webroot on your intranet and internet site, ensuring that the intranet and internet copies of  /var/www/html/weather.html must be have the following permissions
#-rwxr-xr-x 1 pi           www-data         6023 Apr 11 20:00 weather.html
If you are not using Pi then change the owner (not the www-data group) to whichever user is used to run scp

Get the city id from city.list.json - see http://bulk.openweathermap.org/sample/

Call the script using the following format ./ow_weather_alert.sh City_name city_id >/dev/null 2>&1
Note weather.html is created anew each time the script is run by copying from weather_header.html then the 5 day OpenWeather forecast data
You only have to change the City_name city_id  as parameters to ./ow_weather_alert.sh, as shown above

set up a crontab like this for every 3 hours, change /home/pi/connectmyplace_weather to that of the directory from which you will run the script.
0 */3 * * * cd /home/pi/connectmyplace_weather/;./ow_weather_alert.sh Portaferry 2640084 >/dev/null 2>&1



