<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends MY_Controller
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
        $notes = $this->Notes_model->get_all(array("owner" => active_user_id()));

        $viewData->viewFolder = $this->viewFolder;
        $viewData->notes = $notes;
        $viewData->favorites = $favorites;
        $this->load->view("dashboard_v/index", $viewData);
    }
    public function add_notes()
    {
        $title = $this->input->post("title");
        $topic = $this->input->post("topic");
        $note = $this->input->post("note");
        $reminder = $this->input->post("reminder") ? dateFormat('Y-m-d', $this->input->post("reminder")) : null;
        $this->load->library("form_validation");
        $this->form_validation->set_rules("title", "Başlık", "required|trim");
        $this->form_validation->set_rules("note", "Açıklama", "required|trim");
        // Form Validation Hatalarını Tanımla
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );
        // Form Validation'u Çalıştır
        $validate = $this->form_validation->run();
        if ($validate) {
            // Dizin oluşturma işlemi
            $insert = $this->Notes_model->add(
                array(
                    "title" => $title,
                    "topic" => $topic,
                    "note" => $note,
                    "owner" => active_user_id(),
                    "reminder" => $reminder,
                    "isActive" => 1,
                )
            );
            $id = $this->db->insert_id();
            $path = "Uploads/Notes/$id";
            if (!is_dir($path)) {
                try {
                    mkdir($path, 0777, TRUE);
                } catch (Exception $e) {
                    log_message('error', 'Dizin oluşturulamadı: ' . $e->getMessage());
                }
            }
            $notes = $this->Notes_model->get_all(array("owner" => active_user_id()));
            $viewData = new stdClass();
            $viewData->notes = $notes;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("dashboard_v/notes/notes_table", $viewData, true)
            );
            echo json_encode($response);
        } else {
            $notes = $this->Notes_model->get_all(array("owner" => active_user_id()));
            $viewData = new stdClass();
            $viewData->notes = $notes;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("dashboard_v/notes/add_notes_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }
    public function edit_notes($note_id)
    {
        $title = $this->input->post("title");
        $topic = $this->input->post("topic");
        $note = $this->input->post("note");
        $reminder = $this->input->post("reminder") ? dateFormat('Y-m-d', $this->input->post("reminder")) : null;
        $this->load->library("form_validation");
        $this->form_validation->set_rules("title", "Başlık", "required|trim");
        $this->form_validation->set_rules("note", "Açıklama", "required|trim");
        // Form Validation Hatalarını Tanımla
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );
        // Form Validation'u Çalıştır
        $validate = $this->form_validation->run();
        if ($validate) {
            // Dizin oluşturma işlemi
            $update = $this->Notes_model->update(
                array(
                    "id" => $note_id
                ),
                array(
                    "title" => $title,
                    "topic" => $topic,
                    "note" => $note,
                    "owner" => active_user_id(),
                    "reminder" => $reminder,
                )
            );
            $id = $this->db->insert_id();
            $path = "Uploads/Notes/$id";
            if (!is_dir($path)) {
                try {
                    mkdir($path, 0777, TRUE);
                } catch (Exception $e) {
                    log_message('error', 'Dizin oluşturulamadı: ' . $e->getMessage());
                }
            }
            $notes = $this->Notes_model->get_all(array("owner" => active_user_id()));
            $viewData = new stdClass();
            $viewData->notes = $notes;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("dashboard_v/notes/notes_table", $viewData, true)
            );
            echo json_encode($response);
        } else {
            $notes = $this->Notes_model->get_all(array("owner" => active_user_id()));
            $viewData = new stdClass();
            $viewData->notes = $notes;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("dashboard_v/notes/edit_notes_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }
    public function open_edit_notes_modal($edit_note_id)
    {
        $edit_note = $this->Notes_model->get(array("id" => $edit_note_id));
        $viewData = new stdClass();
        $viewData->edit_note = $edit_note;
        $this->load->view("dashboard_v/notes/edit_notes_modal_form", $viewData);
    }
    public function delete_all_notes()
    {
        $this->db->empty_table("notes");
        $viewData = new stdClass();
        $notes = $this->Notes_model->get_all(array("owner" => active_user_id()));
        $viewData->notes = $notes;
        $html = $this->load->view("dashboard_v/notes/notes_table", $viewData, true);
        echo json_encode([
            'html' => $html, // Form hatalarını içeren HTML
        ]);
    }
    public function delete_notes($note_id)
    {
        $delete = $this->Notes_model->delete(
            array(
                "id" => $note_id,
                "owner" => active_user_id()
            )
        );
        $viewData = new stdClass();
        $notes = $this->Notes_model->get_all(array("owner" => active_user_id()));
        $viewData->notes = $notes;
        $html = $this->load->view("dashboard_v/notes/notes_table", $viewData, true);
        echo json_encode([
            'html' => $html, // Form hatalarını içeren HTML
        ]);
    }
    public function change_status($note_id)
    {
        $note = $this->Notes_model->get(array("id" => $note_id));
        if ($note->isActive == 1){
            $change = 0;
        } else {
            $change = 1;
        }
        $update = $this->Notes_model->update(
            array(
                "id" => $note_id
            ),
            array(
                "isActive" => $change,
            )
        );
        $viewData = new stdClass();
        $notes = $this->Notes_model->get_all(array("owner" => active_user_id()));
        $viewData->notes = $notes;
        $html = $this->load->view("dashboard_v/notes/notes_table", $viewData, true);
        echo json_encode([
            'html' => $html, // Form hatalarını içeren HTML
        ]);
    }
}
