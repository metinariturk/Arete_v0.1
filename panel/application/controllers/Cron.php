<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Report_weather_model");
        $this->load->model("Site_model");
    }

    // Şehir için hava durumu verisini almak
    public function get_forecast_for_city($cityName, $api_key)
    {
        $location_url = "http://dataservice.accuweather.com/locations/v1/cities/search?apikey={$api_key}&q=" . urlencode($cityName) . "&language=tr";
        $ch = curl_init($location_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $location_response = curl_exec($ch);
        curl_close($ch);

        $location_data = json_decode($location_response, true);

        if (empty($location_data)) {
            return null;
        }

        // --- BURADAKİ KONTROL ÇOK ÖNEMLİ ---
        $found_city = null;
        foreach ($location_data as $loc) {
            // Eğer ülke kodu Türkiye (TR) ise ve tip "City" (Şehir) ise
            // Veya AdministrativeArea (id) yani bölge kodu doğruysa
            if (isset($loc['Country']['ID']) && $loc['Country']['ID'] === 'TR') {
                $found_city = $loc;
                break; // İlk bulunan Türkiye şehrini al
            }
        }

        if (empty($found_city)) {
            return null; // Türkiye'de bu isimde bir şehir bulunamadı
        }

        $city_key = $found_city['Key'];

        $forecast_url = "http://dataservice.accuweather.com/forecasts/v1/daily/1day/{$city_key}?apikey={$api_key}&language=tr&metric=true";
        // cURL ile 1 günlük hava durumu tahmini al
        $ch = curl_init($forecast_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $forecast_response = curl_exec($ch);
        curl_close($ch);

        $forecast_data = json_decode($forecast_response, true);

        if (empty($forecast_data['DailyForecasts'][0])) {
            return null;
        }

        $forecast = $forecast_data['DailyForecasts'][0];

        return [
            'location' => $cityName,
            'date' => $forecast['Date'], // Tam datetime stringi (örn. 2025-06-22T14:00:00+03:00)
            'max_temp' => $forecast['Temperature']['Maximum']['Value'],
            'min_temp' => $forecast['Temperature']['Minimum']['Value'],
            'event' => $forecast['Day']['IconPhrase']
        ];
    }

    // Aktif sitelerin hava durumu verilerini alıp veritabanına kaydetme
    function saveWeatherToDB()
    {
        // Aktif siteleri al
        $sites = $this->Site_model->get_all(array("isActive" => 1));

        // AccuWeather API anahtarınız
        $api_key = "hJA0Edlt4yr3aaQTe2V2b0i43R3A5LX5";

        // Tüm aktif sitelerin şehir isimlerini al
        $city_names = array();
        foreach ($sites as $site) {
            $city_names[] = $site->location;
        }

        // Tekrarlayan şehir isimlerini kaldır (her şehri sadece bir kez sorgula)
        $city_names = array_unique($city_names);

        // Her şehir için hava durumu sorgusu yap ve kaydet
        foreach ($city_names as $city_name) {
            // Şehir için hava durumu tahminini al.
            // get_forecast_for_city fonksiyonu artık 'date' alanında
            // fonksiyonun çalıştığı anki sistem datetime değerini döndürüyor.
            $forecast = $this->get_forecast_for_city($city_name, $api_key);
            date_default_timezone_set('Europe/Istanbul');
            $current_system_time_only = date('H:i:s');
            $current_system_day_only = date('Y-m-d');

            if ($forecast) {
                // Veri başarıyla alındıysa, yeni bir kayıt ekle.
                // Artık güncelleme kontrolü yapmıyoruz, çünkü her çalıştırma yeni bir kayıt olacak.
                $this->Report_weather_model->add(array(
                    "location" => $forecast['location'],
                    "date" => $current_system_day_only, // get_forecast_for_city'den gelen anlık datetime
                    "time" => $current_system_time_only, // AccuWeather'ın orijinal tahmin zamanı
                    "max" => $forecast['max_temp'],
                    "min" => $forecast['min_temp'],
                    "event" => $forecast['event']
                ));
                echo "{$city_name} verisi kaydedildi.<br>";
            } else {
                echo "{$city_name} verisi alınamadı.<br>";
            }
        }
    }
}