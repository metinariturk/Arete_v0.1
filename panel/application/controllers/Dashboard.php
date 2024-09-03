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


        $notes = $this->Notes_model->get_all(array("owner"=> active_user_id()));
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
                "owner" => active_user_id(),
            )
        );

        $notes = $this->Notes_model->get_all(array("owner" => active_user_id()));

        $viewData = new stdClass();

        $viewData->notes = $notes;

        $render_html = $this->load->view("dashboard_v/list/todo", $viewData, true);

        echo $render_html;

    }

    public function delete($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $delete = $this->Notes_model->delete(
            array(
                "id" => $id,
                "owner" => active_user_id()
            )
        );

        $viewData = new stdClass();

        $notes = $this->Notes_model->get_all(array("owner" => active_user_id()));

        $viewData->notes = $notes;

        $render_html = $this->load->view("dashboard_v/list/todo", $viewData, true);

        echo $render_html;
    }

    public function delete_all()
    {
        $this->db->empty_table("notes");

        $viewData = new stdClass();

        $notes = $this->Notes_model->get_all(array("owner" => active_user_id()));

        $viewData->notes = $notes;

        $render_html = $this->load->view("dashboard_v/list/todo", $viewData, true);

        echo $render_html;
    }


}
