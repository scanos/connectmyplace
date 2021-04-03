/* for evaluation you can power it from a CNT-003A (CP210X on device manager port)
this works as at 4th April 2021 
powered by CNT003 g -> AT g, 3.3V to AT  vcc, RX to AT tx (pin 3)
*/

#include "Arduino.h"
#include <SoftwareSerial.h>
#include "DFRobotDFPlayerMini.h"
#include <OneWire.h>
SoftwareSerial mySoftwareSerial(RX, TX); // RX, TX
DFRobotDFPlayerMini myDFPlayer;
//void printDetail(uint8_t type, int value);
#define TX    4   // *** D4, Pin 3
#define ONEWIRE_BUSS 7 // *** D2 beside VCC
//1 mhz timer
int temp_prev;
int temp_counter=0;

OneWire TemperatureSensor(ONEWIRE_BUSS);
extern uint8_t BigNumbers[];

void setup(void) {

  //Serial.begin(9600);
  //Serial.println("Initializing...");
   mySoftwareSerial.begin(9600);


  if (!myDFPlayer.begin(mySoftwareSerial)) {  //Use softwareSerial to communicate with mp3.

    while(true);
  }
 

  myDFPlayer.volume(30);  //Set volume value. From 0 to 30
  //myDFPlayer.play(1);  //Play the first mp3


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
    myDFPlayer.play(ti);  //Play next mp3 every 3 second.
  }

  if (myDFPlayer.available()) {
    //printDetail(myDFPlayer.readType(), myDFPlayer.read()); //Print the detail message from DFPlayer to handle different errors and states.
  myDFPlayer.readType(), myDFPlayer.read();  
   }
//Serial.print(" temp");Serial.println(ti);
delay (5000);
/* 30 seconds */

}

