Given that I need to know which devices are and have been connected to my network, I wrote a Bash script - ./check_alive_nmap.sh which uses nmap and outputs the results to a web page. 

Here's one way that I use it:
For measuring and logging external compost bin temperatures, I use ESP32 wifi devices with various temperature sensors connected to an MQTT server. The issue for me is powering them, particularly as they are far from the house and outbuildings. I use low cost solar panels and I need to provide power of around 200 mA, even in deep sleep mode. I only need to take readings 2 to 3 times per day, and given that I have a lot of compost bins, I need to keep costs down.
I have written a simple bash script, based on NMap, which I deploy on a Raspberry Pi command line interface (CLI) to test if the EDP32 devices are being powered.

The script is quite simple,check_alive_nmap.sh and only requires a bash shell. It looks for the IP address of the all devices, including ESP32s which is an indicator that sufficient power has been provided to the device.
It is run from the command line, e.g. ./check_alive_nmap.sh 192.168.8.0/2 ( the argument is my subnet mask)
 . You can add a "&" at the end to run the script in the background or cron it. 
 The script writes to a file or web page if successful.

Further thoughts
The Script
Send an email when the IP address is detected.
Terminate after a certain period. I use it in test mode.

Usage
Allotments / community gardens .
Vehicles GPS.
