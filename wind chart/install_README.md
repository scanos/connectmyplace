download this git and copy contents of wind chart to a directory outside web root, e.g. /home/pi if using a Raspberry Pi 
then
pi@pi92c5:~ $ sudo chmod 755 *.*
pi@pi92c5:~ $ sudo sudo chown pi:pi wi*.*

Check your directory listing 
ls -ltr wi*.*
-rwxr-xr-x 1 pi pi 378 Mar 23 09:44 windheader.html
-rwxr-xr-x 1 pi pi 843 Mar 23 09:46 wind_connectmyplace.sh
-rwxr-xr-x 1 pi pi 426 Mar 23 09:49 windfooter.html
-rwxr-xr-x  1 pi pi 934 Mar 23 09:49 windchartline.html
-rwxr-xr-x  1 pi pi  78 Mar 23 09:55 wind.log

Replace the lat, long values with those for your location and the term YOUR_API_ID with your OpenweatherMap API id in wind_connectmyplace.sh
nano wind_connectmyplace.sh
wind=$( echo $(sudo curl "https://api.openweathermap.org/data/2.5/weather?lat=54.38&lon=-5.54&APPID=YOUR_API_ID" | jq '.wind.speed'))

Install jq and bc if they aren't preinstalled
e.g. sudo apt-get install jq 

create a copy of windchartline.html in your web root , e.g. /var/www/html and ensure that the wind_connectmyplace.sh script owner can access this.
For example, sudo chown pi:www-data /var/www/html/windchartline.html 

Set up a crontab e.g. for every half hour
0,20 * * * * cd /home/pi/;./wind_connectmyplace.sh

