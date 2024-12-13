#include "WiFi.h"
#include "HTTPClient.h"

// Pin konfigurasi
#define PH_PIN 35      // Pin analog untuk sensor pH
#define TDS_PIN 32     // Pin analog untuk sensor TDS

// Variabel konversi
float tdsVoltage = 0, tdsValue = 0;
float temperature = 25.0; // Suhu default untuk penghitungan TDS
float phVoltage = 0, phValue = 0;

// Siapkan variabel untuk Wifi 
const char* ssid = "Electeical 5G";
const char* pass = "Electrical12";

// Siapkan variabel host/server yang menampung aplikasi web
const char* host = "192.168.100.53";

// Variabel untuk pengiriman data tiap 10 detik
unsigned long previousMillis = 0; 
const long interval = 10000; // 10 detik interval

void setup() {
  Serial.begin(115200);
  pinMode(PH_PIN, INPUT);
  pinMode(TDS_PIN, INPUT);
  Serial.println("Sistem Monitoring Air");

  // Koneksi WiFi
  WiFi.begin(ssid, pass);
  Serial.println("Connecting...");
  while(WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(500);
  }

  // Berhasil terkoneksi
  Serial.println("Connected");
}

void loop() {
  unsigned long currentMillis = millis();
  
  // Hanya kirim data setiap interval 10 detik
  if (currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis; // Menyimpan waktu pengiriman terakhir

    // Membaca data dari sensor pH
    phVoltage = analogRead(PH_PIN) * (3.3 / 4095.0); // Konversi tegangan (ESP32 ADC 12-bit, 3.3V)
    phValue = 3.5 * phVoltage + 1.0; // Kalibrasi pH (sesuaikan jika perlu dengan buffer pH 4, 7, atau 10)
    Serial.print("Nilai pH: ");
    Serial.println(phValue);

    // Membaca data dari sensor TDS
    tdsVoltage = analogRead(TDS_PIN) * (3.3 / 4095.0); // Konversi tegangan (ESP32 ADC 12-bit, 3.3V)
    float compensationCoefficient = 1.0 + 0.02 * (temperature - 25.0); // Koefisien kompensasi suhu
    float compensationVoltage = tdsVoltage / compensationCoefficient; // Tegangan setelah kompensasi
    tdsValue = (133.42 * compensationVoltage * compensationVoltage * compensationVoltage -
                255.86 * compensationVoltage * compensationVoltage +
                857.39 * compensationVoltage) * 0.5; // Formula TDS
    Serial.print("Nilai TDS: ");
    Serial.print(tdsValue);
    Serial.println(" ppm");

    // Kirim data ke server
    WiFiClient client ;
    // Inisialisasi port web server 80
    const int httpPort = 80;
    if( !client.connect(host, httpPort) ) {
      Serial.println("Connection Failed");
      return;
    }

    // Kirim data sensor ke database / web
    String Link ;
    HTTPClient http ;

    Link = "http://" + String(host) + "/multisensor/kirimdata.php?tds=" + String(tdsValue) + "&ph=" + String(phValue);
    // Eksekusi alamat link
    http.begin(Link);
    http.GET();

    // Baca respon setelah berhasil nilai sensor
    String respon = http.getString();
    Serial.println(respon);
    http.end();
  }
}
