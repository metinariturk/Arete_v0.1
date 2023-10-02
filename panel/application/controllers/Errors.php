<?php

class Errors extends CI_Controller
{
    public $viewFolder = "";

    public $moduleFolder = "";

    public function __construct()
    {
        parent::__construct();

        $this->moduleFolder = "errors";

    }

    public function index()
    {


        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $this->load->view("errors/index", $viewData);

    }

}
