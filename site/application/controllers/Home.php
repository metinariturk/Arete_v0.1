<?php

class Home extends CI_Controller {

    public $viewFolder = "";

    public function __construct()
    {
        parent::__construct();

        $this->viewFolder = "deneme";

        $this->load->model("Settings_model");


    }

    public function index(){

        $viewData = new stdClass();

        $viewData->viewFolder = "home_v";

        $this->load->view( $viewData->viewFolder,  $viewData);

    }

    public function info_v(){

        $viewData = new stdClass();

        $settings = $this->Settings_model->get();

        $viewData->viewFolder = "info_v";
        $viewData->settings = $settings;


        $this->load->view( $viewData->viewFolder,  $viewData);

    }

    public function about(){

        $viewData = new stdClass();

        $settings = $this->Settings_model->get();

        $viewData->viewFolder = "about_us_v";
        $viewData->settings = $settings;

        $this->load->view( $viewData->viewFolder,  $viewData);

    }

    public function panel(){

        redirect("https://www.aretemuhendislik.com.tr/panel");

    }


}
