//----------------------------------------Include the NodeMCU ESP8266 Library---------------------------------------------------------------------------------------------------------------//
#include <ESP8266WiFi.h>
#include <ESP8266WebServer.h>
#include <SPI.h>
#include <MFRC522.h>

//----------------------------------------Pin definitions for RFID reader and onboard LED--------------------------------------------------------------------------------------------------//
#define SS_PIN D2  //--> SDA / SS is connected to pin D2
#define RST_PIN D1  //--> RST is connected to pin D1
#define ON_Board_LED 2  //--> Onboard LED
#define buzzer D3
#define red_led D0
#define green_led D8

MFRC522 mfrc522(SS_PIN, RST_PIN);  //--> Create MFRC522 instance

//----------------------------------------Wi-Fi credentials-------------------------------------------------------------------------------------------------------------------------------//
const char* ssid = "TP-Link_F3DA";
const char* password = "85352117";

//----------------------------------------Server initialization----------------------------------------------------------------------------------------------------------------------------//
ESP8266WebServer server(80);  //--> Server on port 80

WiFiClient client;  // Create a WiFiClient object

int readsuccess;
byte readcard[4];
char str[32] = "";
String StrUID;

//----------------------------------------Array to hold registered UIDs--------------------------------------------------------------------------------------------------------------------//
String registeredUIDs[] = {"D3E8BE42", "034A2C43","83762400","9364BF42"};  // Example of registered UIDs

//-----------------------------------------------------------------------------------------------SETUP--------------------------------------------------------------------------------------//
void setup() {
  Serial.begin(115200); //--> Initialize serial communication with the PC
  SPI.begin();      //--> Init SPI bus
  mfrc522.PCD_Init(); //--> Init MFRC522 card reader

  pinMode(ON_Board_LED, OUTPUT);
  digitalWrite(ON_Board_LED, HIGH); //--> Turn off LED initially
  pinMode(buzzer, OUTPUT); // Set the buzzer pin as output
  
  // Make sure the buzzer is off initially
  digitalWrite(buzzer, LOW); // Ensure the buzzer is off at the start

  pinMode(red_led, OUTPUT); // Set the buzzer pin as output
  pinMode(green_led, OUTPUT); // Set the buzzer pin as output
  
   

  //----------------------------------------Connect to Wi-Fi router------------------------------------------------------------------------------------------------------------//
  WiFi.begin(ssid, password);
  Serial.println("");
  Serial.print("Connecting");

  //----------------------------------------Flash LED while connecting to Wi-Fi------------------------------------------------------------------------------------------------//
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    digitalWrite(ON_Board_LED, LOW);
    delay(250);
    digitalWrite(ON_Board_LED, HIGH);
    delay(250);
  }

  digitalWrite(ON_Board_LED, HIGH); //--> Turn off LED after connection
  Serial.println("");
  Serial.print("Successfully connected to: ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.println("Please tag a card or keychain to see the UID!");
  Serial.println("");
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//-----------------------------------------------------------------------------------------------LOOP---------------------------------------------------------------------------------------//
void loop() {
  readsuccess = getid();  //--> Check if RFID card is detected

  if (readsuccess) {
    digitalWrite(ON_Board_LED, LOW);  //--> Indicate card detection

 if (isRegistered(StrUID)) {  //--> Check if the card is registered
      // Card is registered, buzz for 1 second and turn on green LED
      digitalWrite(buzzer, HIGH);
      digitalWrite(green_led, HIGH);
      delay(500);
      digitalWrite(buzzer, LOW);
      digitalWrite(green_led, LOW);
    } else {
      // Card is not registered, buzz 3 times and turn on red LED
      for (int i = 0; i < 3; i++) {
        digitalWrite(buzzer, HIGH); // Turn on the buzzer
        digitalWrite(red_led, HIGH); // Turn on red LED
        delay(300);                 // Buzzer stays on for 300ms
        digitalWrite(buzzer, LOW);  // Turn off the buzzer
        digitalWrite(red_led, LOW); // Turn off red LED
        delay(300);                 // Buzzer and LED stay off for 300ms
      }
    }

    sendCardDataToServer(StrUID);  //--> Send card data to server

    delay(1000);  //--> Wait before the next cycle
    digitalWrite(ON_Board_LED, HIGH);  //--> Turn off LED
  }
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//----------------------------------------Function to check if the card is registered--------------------------------------------------------------------------------------------------------//
bool isRegistered(String UID) {
  for (int i = 0; i < sizeof(registeredUIDs) / sizeof(registeredUIDs[0]); i++) {
    if (UID == registeredUIDs[i]) {
      return true;  // Card is registered
    }
  }
  return false;  // Card is not registered
}

//----------------------------------------Function to read RFID card and get UID------------------------------------------------------------------------------------------------------------//
int getid() {
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return 0;
  }
  if (!mfrc522.PICC_ReadCardSerial()) {
    return 0;
  }

  Serial.print("THE UID OF THE SCANNED CARD IS: ");

  for (int i = 0; i < 4; i++) {
    readcard[i] = mfrc522.uid.uidByte[i];  //--> Store the UID
    array_to_string(readcard, 4, str);     //--> Convert to string
    StrUID = str;
  }

  mfrc522.PICC_HaltA();  //--> Halt the card
  Serial.println(StrUID);
  return 1;
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//----------------------------------------Function to convert byte array to string---------------------------------------------------------------------------------------------------------//
void array_to_string(byte array[], unsigned int len, char buffer[]) {
  for (unsigned int i = 0; i < len; i++) {
    byte nib1 = (array[i] >> 4) & 0x0F;
    byte nib2 = (array[i] >> 0) & 0x0F;
    buffer[i * 2 + 0] = nib1 < 0xA ? '0' + nib1 : 'A' + nib1 - 0xA;
    buffer[i * 2 + 1] = nib2 < 0xA ? '0' + nib2 : 'A' + nib2 - 0xA;
  }
  buffer[len * 2] = '\0';  //--> Null-terminate the string
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//----------------------------------------Function to send card UID to server---------------------------------------------------------------------------------------------------------------//
void sendCardDataToServer(String UIDresultSend) {
  if (WiFi.status() == WL_CONNECTED) {  // Ensure the device is connected to Wi-Fi

    // First POST request to getUID.php
    if (client.connect("192.168.1.113", 80)) {  // Connect to the server
      // Prepare the POST request
      String postData = "UIDresult=" + UIDresultSend;

      // Send HTTP POST request to the server
      client.println("POST /RFID_CARD/getUID.php HTTP/1.1");
      client.println("Host: 192.168.1.113");  // Replace with your server's IP address
      client.println("Content-Type: application/x-www-form-urlencoded");
      client.print("Content-Length: ");
      client.println(postData.length());
      client.println();
      client.print(postData);

      // Close connection
      client.stop();

      Serial.println("Card data sent to getUID.php: " + UIDresultSend);
    } else {
      Serial.println("Failed to connect to server for getUID.php");
    }

    // Second POST request to check_card.php
    if (client.connect("192.168.1.113", 80)) {  // Connect to the server again
      // Reuse the same postData variable or create a new one if needed
      String postData = "UIDresult=" + UIDresultSend;

      // Send HTTP POST request to check_card.php
      client.println("POST /RFID_CARD/check_card.php HTTP/1.1");
      client.println("Host: 192.168.1.113");
      client.println("Content-Type: application/x-www-form-urlencoded");
      client.print("Content-Length: ");
      client.println(postData.length());
      client.println();
      client.print(postData);

      // Close connection after sending the request
      client.stop();

      Serial.println("Card data sent to check_card.php: " + UIDresultSend);
    } else {
      Serial.println("Failed to connect to server for check_card.php");
    }

  } else {
    Serial.println("WiFi not connected");
  }
}
