/*DFPlayer - A Mini MP3 Player For Arduino
 <https://www.dfrobot.com/index.php?route=product/product&product_id=1121>
 ***************************************************
 This example shows the basic function of library for DFPlayer.
 Created 2016-12-07
 By [Angelo qiao](Angelo.qiao@dfrobot.com)
 GNU Lesser General Public License.
 See <http://www.gnu.org/licenses/> for details.
 All above must be included in any redistribution
 ****************************************************/

/***********Notice and Trouble shooting***************
 1.Connection and Diagram can be found here
 <https://www.dfrobot.com/wiki/index.php/DFPlayer_Mini_SKU:DFR0299#Connection_Diagram>
 2.This code is tested on Arduino Uno, Leonardo, Mega boards.
 ***************************************************
ConnectMyPlace and to get it to work on ATTINY, first start the DF player and then power on the ATTINY85
On the dfplayer pin out is vcc rx tx
On the Attiny85 it is      rx  tx gnd
tx <> rx
rx <> tx
//ATTINY85 clock 1 mhz 
*/

#include "Arduino.h"
#include <SoftwareSerial.h>
#include "DFRobotDFPlayerMini.h"
#include <OneWire.h>
#define ONEWIRE_BUSS 7 // *** D2 beside VCC

OneWire TemperatureSensor(ONEWIRE_BUSS);
extern uint8_t BigNumbers[];
#define RX    3   // *** D3, Pin 2
#define TX    4   // *** D4, Pin 3
SoftwareSerial mySoftwareSerial(RX, TX); // RX, TX
DFRobotDFPlayerMini myDFPlayer;

int tc = 0; // temperature counter - to allow for temperature sensor equiibrating
int maxvalue = 55;

void setup()
{
  delay(3000);
  mySoftwareSerial.begin(9600);


  if (!myDFPlayer.begin(mySoftwareSerial)) {  //Use softwareSerial to communicate with mp3.

    while(true);
  }
 
  myDFPlayer.volume(30);  //Set volume value. From 0 to 30
  }

void loop()
{

byte i;
byte data[12];
int16_t raw;
float t;
int ti;
TemperatureSensor.reset(); // reset one wire buss
TemperatureSensor.skip(); // select only device
TemperatureSensor.write(0x44); // start conversion
delay(1000); // wait for the conversion
TemperatureSensor.reset();
TemperatureSensor.skip();
TemperatureSensor.write(0xBE); // Read Scratchpad
for ( i = 0; i < 9; i++) { // 9 bytes
data[i] = TemperatureSensor.read();
}

raw = (data[1] << 8) | data[0];
t = (float)raw / 16.0;
ti = (int) t;
delay(3000);
if (ti < maxvalue && tc > 1){
    ti = ti + 30;
    myDFPlayer.play(ti);
    }
    else
    {
    //myDFPlayer.play(92); //sensor stabilize alert
    }
  

  if (myDFPlayer.available()) {
    myDFPlayer.readType(), myDFPlayer.read();  

   }

   delay(5000);
   tc = tc + 1;
     
}
