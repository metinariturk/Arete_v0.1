<?php

class Guest extends CI_Controller
{
    public $viewFolder = "";

    public $moduleFolder = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->model("Settings_model");
        $this->load->model("Project_model");
        $this->load->model("Payment_model");
        $this->load->model("Contract_model");
        $this->load->model("User_model");
        $this->load->model("Site_model");
        $this->load->model("Report_model");
        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");

        $this->viewFolder = "guest_v";
        $this->Module_Name = "guest";
        $this->Module_Title = "Misafir";
        $this->Module_Main_Dir = "project_v";
        $this->Module_File_Dir = "main";
        $this->Display_Folder = "display";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        $this->File_List = "file_list_v";
        $this->List_Folder = "list";
        $this->Common_Files = "common";
        $this->Settings = get_settings();
        $this->display_route = "file_form";

    }

    public function index()
    {
        redirect(base_url("login"));
    }

    public function file_form($guest_code=null)
    {

        if ($guest_code == null ){
            redirect(base_url("Errors"));
        }

        $viewData = new stdClass();

        $sites = $this->Site_model->get_all(array("guest_code" => $guest_code));

        if (empty($sites)){
            redirect(base_url("Errors"));
        }

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->sites = $sites;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

}
