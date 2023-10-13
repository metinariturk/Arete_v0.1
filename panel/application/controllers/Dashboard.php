<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public $viewFolder = "";
    public $session_user = "";

    public function __construct()
    {
        parent::__construct();

        if (!get_active_user()) {
            redirect(base_url("login"));
        }
        $this->Theme_mode = get_active_user()->mode;

        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }


        $this->viewFolder = "dashboard_v";
        $this->Module_Name = "dashboard";
        $this->Display_Folder = "Anasayfa";
        $this->Module_Title = "Ana Sayfa";
        $this->load->model("Notes_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");
        $this->load->model("Favorite_model");


    }

    public function index()
    {

        $viewData = new stdClass();

        $favorites = $this->Favorite_model->get_all(array(
                "user_id" => active_user_id(),
            )
        );


        $notes = $this->Notes_model->get_all(array());
        $last_created_elements = $this->Order_model->get_all_or(array(
            "createdBy" => active_user_id(),
            "deletedBy" => active_user_id(),
            "updatedBy" => active_user_id(),
        ));


        $viewData->viewFolder = $this->viewFolder;
        $viewData->notes = $notes;
        $viewData->favorites = $favorites;
        $viewData->last_created_elements = $last_created_elements;

        $viewData->subViewFolder = "list";

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save_note()
    {
        $note = $this->input->post("note");

        $insert = $this->Notes_model->add(
            array(
                "note" => $note,
                "isActive" => 1,
            )
        );

        redirect(base_url());

    }

    public function distributor()
    {
        $data = $this->input->post("search");
        $gelen_dizin = explode(" - ", $data);
        echo $gelen_dizin[0];
        echo $gelen_dizin[2];

        if ($gelen_dizin[2] == "Proje") {
            redirect(base_url("project/file_form/$gelen_dizin[0]"));
        }

        if ($gelen_dizin[2] == "Sözleşme") {
            redirect(base_url("contract/file_form/$gelen_dizin[0]"));
        }

        if ($gelen_dizin[2] == "Alt Sözleşme") {
            redirect(base_url("subcontract/file_form/$gelen_dizin[0]"));
        }

        if ($gelen_dizin[2] == "Şantiye") {
            redirect(base_url("site/file_form/$gelen_dizin[0]"));
        }

        if ($gelen_dizin[2] == "Teklif") {
            redirect(base_url("auction/file_form/$gelen_dizin[0]"));
        }

    }

    public function isActiveSetter($id)
    {

        $note = $this->Notes_model->get(array("id" => $id));

        $note->isActive == 1 ? $isActive = 0 : $isActive = 1;

        $this->Notes_model->update(
            array(
                "id" => $id
            ),
            array(
                "isActive" => $isActive
            )
        );

        echo $isActive;
    }

    public function checkall($paramater)
    {

        $note = $this->Notes_model->get_all(array());

        $this->Notes_model->update(
            array(),
            array(
                "isActive" => "$paramater"
            )
        );
    }

    public function delete($id)
    {
        $delete = $this->Notes_model->delete(
            array(
                "id" => $id
            )
        );

        $viewData = new stdClass();

        $notes = $this->Notes_model->get_all(array());

        $viewData->notes = $notes;

        $render_html = $this->load->view("dashboard_v/list/todo", $viewData, true);

        echo $render_html;
    }

}
