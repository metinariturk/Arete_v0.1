<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends MY_Controller
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

        $this->Report_weather_model->add(array(
            "location" => "KONYA",
            "date" => null,
            "max" => null,
            "min" => null,
            "event" => null
        ));
        echo "verisi kaydedildi.<br>";

    }
}