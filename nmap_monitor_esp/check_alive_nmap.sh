#!/bin/bash
#script uses nmap scans to search for ip addresses and then update hostname,ip and time on a local file (PART 1)
#the records from the local file, including last seen, are written on the fly to a web page (PART 2)
#this creates a historical record of every device and ip address that has been on the network
#to run script, use the following add the subnet as an argument,e.g.  ./check_alive_nmap.sh 192.168.8.0/24
#typical crontab entry is */15 * * * * cd /home/pi/;./check_alive_nmap.sh 192.168.8.0/24 >/dev/null 2>&1


# PART 1 run NMAP to update local file 
filename="nmap_log"
if [[ ! -f $filename ]]; then
  touch $filename
fi

test_counter=$(nmap -sP $1 | grep "Nmap scan report")
test_counter=${test_counter//Nmap scan report for /}
declare -a my_array=($test_counter)
alength=${#my_array}
step=2
for ((i = 0; i <= $alength; i += $step))
do
	element=${my_array[$i]}
	#remove blank entries
	if [ "${#element}" -gt 0 ]; then
	search=$(grep "$element" $filename)
	search_length=${#search}
        # checks if hostname already in file otherwise appends a new record
	if [ "$search_length" -gt 0 ]; then
        	mydate=$(IFS=" " read -ra ADDR <<< "${search}"; echo ${ADDR[0]})
                myhost=$(IFS=" " read -ra ADDR <<< "${search}"; echo ${ADDR[1]})
                replace="$mydate $myhost"
                new_record=$(echo $(date +%s) $myhost)
                sed -i "s/$replace/$new_record/" $filename
        else
                echo $(date +%s) ${my_array[$i]} ${my_array[$i+1]} >> $filename
        fi

 fi
done
# PART 1 run NMAP to update local file

# PART 2 create web page on the fly
input=$filename
echo "<!DOCTYPE html><html><head><style>table, th, td {border: 1px solid black;}</style></head><body>" > /var/www/html/live_ipaddress.html
echo "<h1>Devices on my home network</h1>" >> /var/www/html/live_ipaddress.html
echo  "<table border=1>" >> /var/www/html/live_ipaddress.html
while IFS= read -r line
do
	myip=$(IFS=" " read -ra ADDR <<< "${line}"; echo ${ADDR[2]})
	myhost=$(IFS=" " read -ra ADDR <<< "${line}"; echo ${ADDR[1]})
	mydate=$(IFS=" " read -ra ADDR <<< "${line}"; echo ${ADDR[0]})
	END=$(date +%s)
	dateint="$((END - mydate))"
	lengthdateint=${#dateint}
	if (( $lengthdateint > 1)); then
		D1=$mydate; D2=$END
		datetext=$(echo "$(((D2-D1)/86400)):$(date -u -d@$((D2-D1)) +%H:%M)")
		sudo echo  "<tr style='background-color:#FF0000'><td> $dateint $myhost $myip </td><td>$datetext (d:hh:mm)</td>" >> /var/www/html/live_ipaddress.html
	else
		sudo echo "<tr><td>$myhost $myip</td><td> 0 mins </td>">> /var/www/html/live_ipaddress.html
	fi
done < "$input"
# PART 2 create web page on the fly

