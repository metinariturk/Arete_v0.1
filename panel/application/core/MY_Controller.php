<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $viewData;

    public function __construct()
    {
        parent::__construct();

        if (!get_active_user()) {
            redirect(base_url("login"));
        }

        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        $this->Theme_mode = get_active_user()->mode;

        $uploader = APPPATH . 'libraries/FileUploader.php';

        include($uploader);

        $this->load->model("Settings_model");

        $settings = $this->Settings_model->get(); // query object
        $this->viewData = new stdClass();
        $this->settings = $settings;
    }
}
