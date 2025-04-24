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
        // cURL ile veri al
        $ch = curl_init($location_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $location_response = curl_exec($ch);
        curl_close($ch);

        $location_data = json_decode($location_response, true);
        if (empty($location_data)) {
            return null;
        }

        $city_key = $location_data[0]['Key'];

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
            'date' => date('Y-m-d', strtotime($forecast['Date'])),
            'max_temp' => $forecast['Temperature']['Maximum']['Value'],
            'min_temp' => $forecast['Temperature']['Minimum']['Value'],
            'event' => $forecast['Day']['IconPhrase']
        ];
    }

    // Aktif sitelerin hava durumu verilerini alıp veritabanına kaydetme
    function saveWeatherToDB()
    {
        // Aynı şehir ve tarih var mı?
        $sites = $this->Site_model->get_all(array("isActive" => 1));

        $api_key = "hJA0Edlt4yr3aaQTe2V2b0i43R3A5LX5";

        // Şehir isimlerini al
        $city_names = array();

        foreach ($sites as $site) {
            // Şehirleri array'e ekle
            $city_names[] = $site->location;
        }

        // Tekrarlayan şehirleri kaldır
        $city_names = array_unique($city_names);

        // Eşsiz şehirler için hava durumu sorgusu yap
        foreach ($city_names as $city_name) {
            // Şehir için hava durumu tahminini al
            $forecast = $this->get_forecast_for_city($city_name, $api_key);

            if ($forecast) {
                // Veritabanında aynı şehir ve tarih var mı?
                $existing_report = $this->Report_weather_model->get(array(
                    "location" => $forecast['location'],
                    "date" => $forecast['date']
                ));

                if ($existing_report) {
                    // Eğer veritabanında varsa güncelleme
                    $this->Report_weather_model->update(
                        array("id" => $existing_report->id),
                        array(
                            "max" => $forecast['max_temp'],
                            "min" => $forecast['min_temp'],
                            "event" => $forecast['event']
                        )
                    );
                    echo "{$city_name} verisi güncellendi.<br>";
                } else {
                    // Eğer veritabanında yoksa yeni kayıt ekle
                    $this->Report_weather_model->add(array(
                        "location" => $forecast['location'],
                        "date" => $forecast['date'],
                        "max" => $forecast['max_temp'],
                        "min" => $forecast['min_temp'],
                        "event" => $forecast['event']
                    ));
                    echo "{$city_name} verisi kaydedildi.<br>";
                }
            } else {
                echo "{$city_name} verisi alınamadı.<br>";
            }
        }
    }
}