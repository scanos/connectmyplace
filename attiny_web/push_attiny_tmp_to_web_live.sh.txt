#!/bin/bash
attiny_temp=$(tail -1 /share/putty.log)
echo "<li> $(date) $attiny_temp" >>  attiny_ble_temperature_test.html
sshpass -p '<pwd>' scp attiny_ble_temperature_test.html pi@<hostip_address>:/var/www/html/attiny_ble_temperature_test.html 
