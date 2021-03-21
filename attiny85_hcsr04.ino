/*
  For use with a 4 Pin Ultrasonic Ranging Sensor & an ATtiny85 Microprocessor
    
        Power can be supplied to the ATtiny85 via the Arduino
  VCC   //  5v  (+)
  GND   //  GND (-)
  
  TRIG  //  Analog Input 3 (Pin 3)
  ECHO  //  Analog Input 2 (Pin 4)
  LED //  Analog Input 1 (Pin 2)
  LED1  //  PWM (Pin 1)
  LED2  //  PWM (Pin 0)
        (c) Jacob Clark 2013 

Clock internal 1 MHZ
Programmer USBAsp
*/
const int ledPin  =   0;
const int ledPin1 =   1;
const int ledPin2   =   2;
const int trigPin   =   3;
const int echoPin   =       4;

void setup() {
  pinMode(ledPin, OUTPUT);
  pinMode(ledPin1, OUTPUT);
  pinMode(ledPin2, OUTPUT);
}

void loop(){

  long duration, inches, cm;
  
  pinMode(trigPin, OUTPUT);
  digitalWrite(trigPin, LOW);
  
  delayMicroseconds(2);
  digitalWrite(trigPin, HIGH);
  
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);
  
  pinMode(echoPin, INPUT);
  duration = pulseIn(echoPin, HIGH);
  
  inches = microsecondsToInches(duration);
  cm = microsecondsToCentimeters(duration);
  
  if(cm < 10 && cm < 100 && cm < 1000){
    digitalWrite(ledPin, HIGH);
    digitalWrite(ledPin1, LOW);
    digitalWrite(ledPin2, LOW);
  }
  
  if(cm > 10 && cm > 100 && cm < 1000){
    digitalWrite(ledPin, LOW);
    digitalWrite(ledPin1, HIGH);
    digitalWrite(ledPin2, LOW);
  }
  
  if(cm > 10 && cm > 100 && cm > 1000){
    digitalWrite(ledPin, LOW);
    digitalWrite(ledPin1, LOW);
    digitalWrite(ledPin2, HIGH);
  }
  
  delay(100);
}

long microsecondsToInches(long microseconds){
  return microseconds / 74 / 2;
}

long microsecondsToCentimeters(long microseconds){
  return microseconds / 29 / 2;
}
