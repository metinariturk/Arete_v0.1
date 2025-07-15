<?php
class Weather extends MY_Controller
{
    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();

        $this->moduleFolder = "site_module";
        $this->viewFolder = "weather_v";
        $this->load->model("Report_weather_model");
        $this->load->model("Report_model");
        $this->Module_Title = "Hava Durumu Verileri";
    }
    public function index()
    {
        $viewData = new stdClass();
        
        $items = $this->Report_weather_model->get_all(
            array()
        );
        
        $viewData->subViewFolder = "display";
        $viewData->items = $items;
        $this->load->view("{$this->moduleFolder}/{$this->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function add_date($report_id = null)
    {
        $viewData = new stdClass();
        
        $items = $this->Report_weather_model->get_all(
            array()
        );
        
        $viewData->subViewFolder = "display";
        $viewData->items = $items;
        $viewData->report = $this->Report_model->get(array("id" => $report_id));
        $this->load->view("{$this->moduleFolder}/{$this->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function new_form($report_id = null)
    {
        $viewData = new stdClass();
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->report_id = $report_id;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function save($report_id = null)
    {
        $this->load->library("form_validation");
        if ($this->input->post("update") != "on") {
            $this->form_validation->set_rules("report_date", "Tarih", "required|trim|callback_date_control");
        }
        $this->form_validation->set_rules("min", "En Düşük Sıcaklık", "numeric|required|trim");
        $this->form_validation->set_rules("max", "En Yüksek Sıcaklık", "numeric|required|trim");
        $this->form_validation->set_rules("event", "Hoava Olayı", "required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "date_control" => "<b>Bu tarihe ait veri mevcut</b>",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "valid_email" => "Lütfen geçerli bir e-posta adresi giriniz",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            $date = dateFormat('Y-m-d', $this->input->post("report_date"));
            if ($this->input->post("update") != "on") {
                $insert = $this->Report_weather_model->add(
                    array(
                        "date" => $date,
                        "min" => $this->input->post('min'),
                        "max" => $this->input->post('max'),
                        "event" => $this->input->post('event'),
                    )
                );
            } else {
                $insert = $this->Report_weather_model->update(
                    array(
                        "date" => $date,
                    ),
                    array(
                        "min" => $this->input->post('min'),
                        "max" => $this->input->post('max'),
                        "event" => $this->input->post('event'),
                    )
                );
            }
            
            if ($insert) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt başarılı bir şekilde eklendi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                    "type" => "error"
                );
            }
            if (!empty($report_id)) {
                redirect(base_url("report/file_form/$report_id"));
            } else {
                redirect(base_url("Weather"));
            }
        } else {
            $viewData = new stdClass();
            
            $items = $this->Report_weather_model->get_all(
                array()
            );
            
            $viewData->subViewFolder = "display";
            $viewData->form_error = true;
            $viewData->items = $items;
            $this->load->view("{$this->moduleFolder}/{$this->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }
    public
    function update_form($id)
    {
        $viewData = new stdClass();
        
        $item = $this->Report_weather_model->get(
            array(
                "id" => $id,
            )
        );
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public
    function update($id)
    {
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
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "valid_email" => "Lütfen geçerli bir e-posta adresi giriniz",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            // Upload Süreci...
            $update = $this->Report_weather_model->update(
                array("id" => $id),
                array(
                    "protocol" => $this->input->post("protocol"),
                    "host" => $this->input->post("host"),
                    "port" => $this->input->post("port"),
                    "user_name" => $this->input->post("user_name"),
                    "user" => $this->input->post("user"),
                    "from" => $this->input->post("from"),
                    "to" => $this->input->post("to"),
                    "password" => $this->input->post("password"),
                )
            );
            
            if ($update) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt başarılı bir şekilde güncellendi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Kayıt Güncelleme sırasında bir problem oluştu",
                    "type" => "error"
                );
            }
            redirect(base_url("emailsettings"));
        } else {
            $viewData = new stdClass();
            
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            
            $viewData->item = $this->Report_weather_model->get(
                array(
                    "id" => $id,
                )
            );
            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }
    public
    function delete($id)
    {
        $delete = $this->Report_weather_model->delete(
            array(
                "id" => $id
            )
        );
        
        
        redirect(base_url("emailsettings"));
    }
    public
    function date_control($date)
    {
        $this->load->model("Report_weather_model");
        $control = dateFormat('Y-m-d', $date);
        $weather = $this->Report_weather_model->get(array('date' => $control));
        if (isset($weather)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
