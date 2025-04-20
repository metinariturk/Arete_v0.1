<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Giriş doğrulaması yapılmaz, sadece cron job'ları için kullanılacak.
        $this->load->model("Report_weather_model");


    }

    public function test_cron()
    {
        // Cron job işlemleri
        log_message('error', 'Cron job test_cron çalıştı.');

        // Burada cron job için yapılacak işlemleri ekleyebilirsiniz
        // Örneğin: Hava durumu verisi çekme, veri güncelleme vs.

        $viewData = new stdClass();

        $control = date('Y-m-d');  // Bugünün tarihi, 'Y-m-d' formatında


        $insert = $this->Report_weather_model->add(
            array(
                "date" => $control,
                "min" => "15",
                "max" => "115",
                "event" => "yağmur",
            )
        );
    }
}