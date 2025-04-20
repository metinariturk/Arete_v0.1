<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Giriş doğrulaması yapılmaz, sadece cron job'ları için kullanılacak.
    }

    public function test_cron()
    {
        // Cron job işlemleri
        log_message('error', 'Cron job test_cron çalıştı.');

        // Burada cron job için yapılacak işlemleri ekleyebilirsiniz
        // Örneğin: Hava durumu verisi çekme, veri güncelleme vs.

        $viewData = new stdClass();

        $control = dateFormat('Y-m-d', $date);


        $insert = $this->Weather_model->add(
            array(
                "date" => $date,
                "min" => "15",
                "max" => "115",
                "event" => "yağmur",
            )
        );
    }
}