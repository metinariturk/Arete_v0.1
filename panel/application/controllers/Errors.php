<?php
class Errors extends MY_Controller
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

        $this->load->view("errors/index", $viewData);
    }
}
