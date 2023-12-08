<?php

class Home extends CI_Controller
{

    public $viewFolder = "";

    public function __construct()
    {
        parent::__construct();

        $this->viewFolder = "deneme";

        $this->load->model("Settings_model");


    }

    public function index()
    {

        $viewData = new stdClass();

        $viewData->viewFolder = "home_v";

        $this->load->view($viewData->viewFolder, $viewData);

    }

    public function info_v()
    {

        $viewData = new stdClass();

        $settings = $this->Settings_model->get();

        $viewData->viewFolder = "info_v";
        $viewData->settings = $settings;


        $this->load->view($viewData->viewFolder, $viewData);

    }

    public function about()
    {

        $viewData = new stdClass();

        $settings = $this->Settings_model->get();

        $viewData->viewFolder = "about_us_v";
        $viewData->settings = $settings;

        $this->load->view($viewData->viewFolder, $viewData);

    }

    public function panel()
    {

        redirect("https://www.aretemuhendislik.com.tr/panel");

    }

    public function download_paper($paper = null)
    {
        $session_user = $this->session->userdata("user");
        $this->load->helper('download');
        if (is_loaded('download')) {
            echo "yüklendi";
        }

        if ($session_user->is_Admin == 1) {
            $file_path = base_url("/assets/documents/a.pdf");
            if (file_exists($file_path)) {
                // Dosya içeriğini al
                $data = file_get_contents($file_path);
                // İndirme işlemini başlat
                force_download("a.pdf", $data);
            } else
                echo $file_path;
        }
    }
}
