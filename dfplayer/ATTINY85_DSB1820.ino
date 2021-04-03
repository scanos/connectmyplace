/* for evaluation you can power it from a CNT-003A (CP210X on device manager port)
this works as at 4th April 2021 
powered by CNT003 g -> AT g, 3.3V to AT  vcc, RX to AT tx (pin 3)

*/

#include <SoftwareSerial.h>
#include <OneWire.h>
#define TX    4   // *** D4, Pin 3
#define ONEWIRE_BUSS 7 // *** D2 beside VCC
//1 mhz timer
int temp_prev;
int temp_counter=0;
SoftwareSerial Serial(0, TX);
OneWire TemperatureSensor(ONEWIRE_BUSS);
extern uint8_t BigNumbers[];

void setup(void) {

  Serial.begin(9600);
  Serial.println("Initializing...");


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

Serial.print(" temp");Serial.println(ti);
delay (5000);
/* 30 seconds */

}

