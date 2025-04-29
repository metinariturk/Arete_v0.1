<?php
class Emailsettings extends MY_Controller
{
    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "emailsettings_v";
        $this->Module_Name = "Emailsettings";
        $this->load->model("Emailsettings_model");
        $this->Module_Title = "E Posta Ayarları";
        if(!get_active_user()){
            redirect(base_url("login"));
        }
    }
    public function index(){
        $viewData = new stdClass();
        
        $items = $this->Emailsettings_model->get_all(
            array()
        );
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function new_form(){
        $viewData = new stdClass();
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function save(){
        $this->load->library("form_validation");
        
        $this->form_validation->set_rules("protocol", "Protokol Numarası", "required|trim");
        $this->form_validation->set_rules("host", "E-posta Sunucusu", "required|trim");
        $this->form_validation->set_rules("port", "Port Numarası", "required|trim");
        $this->form_validation->set_rules("user_name", "Kullanıcı Adı", "required|trim");
        $this->form_validation->set_rules("user", "E-posta (User)", "required|trim|valid_email");
        $this->form_validation->set_rules("from", "Kimden Gidecek (from)", "required|trim|valid_email");
        $this->form_validation->set_rules("to", "Kime Gidecek (to)", "required|trim|valid_email");
        $this->form_validation->set_rules("password", "Şifre", "required|trim");
        $this->form_validation->set_message(
            array(
                "required"    => "<b>{field}</b> alanı doldurulmalıdır",
                "valid_email" => "Lütfen geçerli bir e-posta adresi giriniz",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if($validate){
            $insert = $this->Emailsettings_model->add(
                array(
                    "protocol"      => $this->input->post("protocol"),
                    "host"          => $this->input->post("host"),
                    "port"          => $this->input->post("port"),
                    "user_name"     => $this->input->post("user_name"),
                    "user"          => $this->input->post("user"),
                    "from"          => $this->input->post("from"),
                    "to"            => $this->input->post("to"),
                    "password"      => $this->input->post("password"),
                    "isActive"      => 1,
                    "createdAt"     => date("Y-m-d H:i:s")
                )
            );
            redirect(base_url("$this->Module_Name"));
        } else {
            $viewData = new stdClass();
            
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->form_error = true;
            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }
    public function update_form($id){
        $viewData = new stdClass();
        
        $item = $this->Emailsettings_model->get(
            array(
                "id"    => $id,
            )
        );
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function update($id){
        $this->load->library("form_validation");
        $this->form_validation->set_rules("protocol", "Protokol Numarası", "required|trim");
        $this->form_validation->set_rules("host", "E-posta Sunucusu", "required|trim");
        $this->form_validation->set_rules("port", "Port Numarası", "required|trim");
        $this->form_validation->set_rules("user_name", "Kullanıcı Adı", "required|trim");
        $this->form_validation->set_rules("user", "E-posta (User)", "required|trim|valid_email");
        $this->form_validation->set_rules("from", "Kimden Gidecek (from)", "required|trim|valid_email");
        $this->form_validation->set_rules("to", "Kime Gidecek (to)", "required|trim|valid_email");
        $this->form_validation->set_rules("password", "Şifre", "required|trim");
        $this->form_validation->set_message(
            array(
                "required"    => "<b>{field}</b> alanı doldurulmalıdır",
                "valid_email" => "Lütfen geçerli bir e-posta adresi giriniz",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if($validate){
            // Upload Süreci...
            $update = $this->Emailsettings_model->update(
                array("id" => $id),
                array(
                    "protocol"      => $this->input->post("protocol"),
                    "host"          => $this->input->post("host"),
                    "port"          => $this->input->post("port"),
                    "user_name"     => $this->input->post("user_name"),
                    "user"          => $this->input->post("user"),
                    "from"          => $this->input->post("from"),
                    "to"            => $this->input->post("to"),
                    "password"      => $this->input->post("password"),
                )
            );
            redirect(base_url("emailsettings"));
        } else {
            $viewData = new stdClass();
            
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            
            $viewData->item = $this->Emailsettings_model->get(
                array(
                    "id"    => $id,
                )
            );
            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }
    public function delete($id){

        $delete = $this->Emailsettings_model->delete(
            array(
                "id"    => $id
            )
        );
        
        redirect(base_url("emailsettings"));
    }
}
