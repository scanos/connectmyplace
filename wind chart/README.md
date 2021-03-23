This shows how to graph IOT data on a chart.
The components are as follows:
1. A bash script - part 1 - to capture IOT data, in the example OpenWeather data will be used, and write to a log file - wind.log
2. A bash script - part 2 - to combine the log file - wind.log with a header and footer file and copy to web root to make it viewable on the web.
3. A header html file - windheader.html
4. A footer html file - windfooter.html

![windchart1](https://user-images.githubusercontent.com/29405761/112129212-173fbe80-8bbf-11eb-8b83-a4552021f9c2.png)

The modus operandi is that on a scheduled based, cron, the bash script reads wind data, writes it to a log file and then creates a html (windchartline.html) file (from the log, header and foooter file) and copies it to the web site. 
,Please ensure that the owner of the crontab has access permissions to windchartline.html, e.g. use chown xxowner:www-data windchartline.html


