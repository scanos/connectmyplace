The steps are firstly, connect your ATTINY85 through a BLE module as shown in  https://www.instructables.com/DIY-Bluetooth-Temperature-Sensor-ATTINY85/
This shows how to build the circuit and also provides the Arduino code.
Next, log onto your PC and connect to the BLE/ATTINY85 through a Putty session. The important thing is next to store your Putty log on a network drive which is a samba share on your Pi. 
On your Pi, you will need to make an SSH (secure tunnel connection) to your web server. run the script
