#!/bin/bash
# takes  ipaddress as an argument $1 and script scans until it finds it
# example ./check_alive_nmap.sh "192.168.8.10 "
         COUNTER=0
         while [  $COUNTER -lt 10 ]; do
                echo The counter is $COUNTER
                test_counter=$(nmap -sP 192.168.8.0/24| grep "$1")
                test_length=${#test_counter}
                echo test_length $test_length
if [ "$test_length" -gt 0 ]; then
                        COUNTER=11;
                fi
                sleep 60
                done
echo "ip address found"
#if found write to a file , an alternative us to write to a html page e.g. /var/www/html/check_alive.html
echo $(date) $1 ip address found > ipaddress_found
