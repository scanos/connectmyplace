//https://abidcg.blogspot.com/2019/05/clap-switch-with-arduino-and-sound.html
int Sensor = A1; //pin 2 attiny85
int clap = 0;
long detection_range_start = 0;
long detection_range = 0;
boolean status_lights = false;
/* TinyTone for ATtiny85 */
//clock 1mhz internal
//usbasp programmer

// Notes
const int Note_C  = 239;
const int Note_CS = 225;
const int Note_D  = 213;
const int Note_DS = 201;
const int Note_E  = 190;
const int Note_F  = 179;
const int Note_FS = 169;
const int Note_G  = 159;
const int Note_GS = 150;
const int Note_A  = 142;
const int Note_AS = 134;
const int Note_B  = 127;
const int Note_S = 255;

int Speaker = 1;

void setup()
{
  pinMode(Speaker, OUTPUT);
  pinMode(Sensor, INPUT);
pinMode(0,OUTPUT);
digitalWrite(0, HIGH);
delay(100);
digitalWrite(0, LOW);
}

void loop()
{
  int status_sensor = digitalRead(Sensor);
if (status_sensor == 0)
{
if (clap == 0)
{
detection_range_start = detection_range = millis();
clap++;
}
else if (clap > 0 && millis()-detection_range >= 50)
{
detection_range = millis();
clap++;
}
}
if (millis()-detection_range_start >= 400)
{
if (clap == 2)
{
if (!status_lights)
{
status_lights = true;
digitalWrite(0, HIGH);
 playTune();
delay(10);
digitalWrite(0, LOW);
}
else if (status_lights)
{
status_lights = false;
digitalWrite(0, LOW);
}
}
clap = 0;
}

}

void TinyTone(unsigned char divisor, unsigned char octave, unsigned long duration)
{
  TCCR1 = 0x90 | (8-octave); // for 1MHz clock
  // TCCR1 = 0x90 | (11-octave); // for 8MHz clock
  OCR1C = divisor-1;         // set the OCR
  delay(duration);
  TCCR1 = 0x90;              // stop the counter
}

// Play a scale
void playTune(void)
{

    for (int i = 0; i <= 10; i++) {
     TinyTone(Note_C, 4, 50);
     TinyTone(Note_G, 4, 50);
    delay(10);
    }
    
TinyTone(Note_S, 4, 300);


}
