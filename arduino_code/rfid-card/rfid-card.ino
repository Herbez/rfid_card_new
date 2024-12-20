//----------------------------------------Include the NodeMCU ESP8266 Library---------------------------------------------------------------------------------------------------------------//
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>
#include <ArduinoJson.h>

//----------------------------------------Pin definitions for RFID reader and onboard LED--------------------------------------------------------------------------------------------------//
#define SS_PIN D2  //--> SDA / SS is connected to pin D2
#define RST_PIN D1  //--> RST is connected to pin D1
#define ON_Board_LED 2  //--> Onboard LED
#define buzzer D3
#define red_led D0
#define green_led D8

MFRC522 mfrc522(SS_PIN, RST_PIN);  //--> Create MFRC522 instance

//----------------------------------------Wi-Fi credentials-------------------------------------------------------------------------------------------------------------------------------//
const char* ssid = "UoK-Official";
const char* password = "uokinternal@2024!!";

//----------------------------------------Server configuration----------------------------------------------------------------------------------------------------------------------------//
const char* serverIP = "10.10.96.62"; // Replace with your server IP
const char* fetchUIDsPath = "/RFID_CARD/admin/fetch_uids.php";

WiFiClient client;
HTTPClient http;

//----------------------------------------Dynamic Registered UIDs Array-------------------------------------------------------------------------------------------------------------------//
#define MAX_UIDS 50
String registeredUIDs[MAX_UIDS];
int uidCount = 0;

//----------------------------------------Global Variables-------------------------------------------------------------------------------------------------------------------------------//
String StrUID; // Declare the variable globally

//----------------------------------------SETUP FUNCTION------------------------------------------------------------------------------------------------------------------------------//
void setup() {
  Serial.begin(115200); //--> Initialize serial communication with the PC
  SPI.begin();      //--> Init SPI bus
  mfrc522.PCD_Init(); //--> Init MFRC522 card reader

  pinMode(ON_Board_LED, OUTPUT);
  digitalWrite(ON_Board_LED, HIGH); //--> Turn off LED initially
  pinMode(buzzer, OUTPUT); // Set the buzzer pin as output
  digitalWrite(buzzer, LOW); // Ensure the buzzer is off at the start

  pinMode(red_led, OUTPUT);
  pinMode(green_led, OUTPUT);

  //----------------------------------------Connect to Wi-Fi router------------------------------------------------------------------------------------------------------------//
  WiFi.begin(ssid, password);
  Serial.println("");
  Serial.print("Connecting");

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

  // Fetch the registered UIDs from the server
  fetchRegisteredUIDs();
}

//----------------------------------------LOOP FUNCTION-----------------------------------------------------------------------------------------------------------------------------//
void loop() {
  if (getid()) {  //--> Check if RFID card is detected
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
        digitalWrite(buzzer, HIGH);
        digitalWrite(red_led, HIGH);
        delay(300);
        digitalWrite(buzzer, LOW);
        digitalWrite(red_led, LOW);
        delay(300);
      }
    }

    sendCardDataToServer(StrUID);  //--> Send card data to server
    
    delay(1000);  //--> Wait before the next cycle
    digitalWrite(ON_Board_LED, HIGH);  //--> Turn off LED
  }
}

//----------------------------------------Function to fetch registered UIDs from server------------------------------------------------------------------------------------------------//
void fetchRegisteredUIDs() {
  if (WiFi.status() == WL_CONNECTED) {
    String url = String("http://") + serverIP + fetchUIDsPath;
    http.begin(client, url);
    int httpCode = http.GET();

    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      Serial.println("Registered UIDs fetched: " + payload);

      // Parse the JSON response
      StaticJsonDocument<1024> doc;
      DeserializationError error = deserializeJson(doc, payload);
      if (!error) {
        uidCount = doc.size();
        for (int i = 0; i < uidCount && i < MAX_UIDS; i++) {
          registeredUIDs[i] = doc[i].as<String>();
        }
        Serial.println("UIDs loaded successfully.");
      } else {
        Serial.println("JSON parsing error.");
      }
    } else {
      Serial.println("Failed to fetch UIDs, HTTP code: " + String(httpCode));
    }

    http.end();
  } else {
    Serial.println("WiFi not connected");
  }
}
void sendCardDataToServer(String UIDresultSend) {
  if (WiFi.status() == WL_CONNECTED) {  // Ensure the device is connected to Wi-Fi

    // First POST request to getUID.php
    if (client.connect("10.10.96.62", 80)) {  // Connect to the server
      // Prepare the POST request
      String postData = "UIDresult=" + UIDresultSend;

      // Send HTTP POST request to the server
      client.println("POST /RFID_CARD/admin/getUID.php HTTP/1.1");
      client.println("Host: 10.10.96.62");  // Replace with your server's IP address
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
    if (client.connect("10.10.96.62", 80)) {  // Connect to the server again
      // Reuse the same postData variable or create a new one if needed
      String postData = "UIDresult=" + UIDresultSend;

      // Send HTTP POST request to check_card.php
      client.println("POST /RFID_CARD/admin/check_card.php HTTP/1.1");
      client.println("Host: 10.10.96.62");
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

//----------------------------------------Function to check if the card is registered------------------------------------------------------------------------------------------------//
bool isRegistered(String UID) {
  for (int i = 0; i < uidCount; i++) {
    if (UID == registeredUIDs[i]) {
      return true;  // Card is registered
    }
  }
  return false;  // Card is not registered
}

//----------------------------------------Function to read RFID card and get UID----------------------------------------------------------------------------------------------------//
int getid() {
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return 0;
  }
  if (!mfrc522.PICC_ReadCardSerial()) {
    return 0;
  }

  Serial.print("THE UID OF THE SCANNED CARD IS: ");
  char str[32];

  for (int i = 0; i < 4; i++) {
    sprintf(&str[i * 2], "%02X", mfrc522.uid.uidByte[i]);
  }
  StrUID = String(str);
  mfrc522.PICC_HaltA();  //--> Halt the card
  Serial.println(StrUID);
  return 1;
}

