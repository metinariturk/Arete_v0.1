<?php

class Extime extends CI_Controller
{
    public $viewFolder = "";

    public $moduleFolder = "";

    public function __construct()
    {

        parent::__construct();

               if (!get_active_user()) {
            redirect(base_url("login"));
        }
 $this->Theme_mode = get_active_user()->mode;        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        $this->moduleFolder = "contract_module";
        $this->viewFolder = "extime_v";
        $this->load->model("Extime_model");
        $this->load->model("Extime_file_model");
        $this->load->model("Contract_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("Costinc_model");
        $this->load->model("Costinc_file_model");

        $this->Module_Name = "Extime";
        $this->Module_Title = "Süre Uzatımı";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "extime_id";
        //Folder Structure
        // Folder Structure
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_File_Dir = "extime";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir/";
        // Folder Structure
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";

        $this->File_List = "file_list_v";
        $this->Common_Files = "common";
    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Extime_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->active_contracts = $active_contracts;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function select()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Extime_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "durumu" => 1
            )
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $viewData->active_contracts = $active_contracts;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form_contract($contract_id = null)
    {
        if (empty($contract_id)) {
            $contract_id = $this->input->post("contract_id");
        }

        $project_id = project_id_cont($contract_id);
        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );
        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_contract";
        $viewData->active_contracts = $active_contracts;
        $viewData->project_id = $project_id;
        $viewData->contract_id = $contract_id;
        $viewData->settings = $settings;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function new_form_costinc($costinc_id)
    {
        $contract_id = contract_id_module("costinc", "$costinc_id");
        $project_id = project_id_cont($contract_id);
        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );

        $costinc = $this->Costinc_model->get(array(
                "id" => $costinc_id
            )
        );
        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_costinc";
        $viewData->active_contracts = $active_contracts;
        $viewData->project_id = $project_id;
        $viewData->contract_id = $contract_id;
        $viewData->costinc_id = $costinc_id;
        $viewData->costinc = $costinc;
        $viewData->settings = $settings;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {

        $viewData = new stdClass();
        $settings = $this->Settings_model->get();

        $type = get_from_any("extime", "costinc_id", "id", "$id");
        $contract_id = contract_id_module("extime", $id);
        $project_id = project_id_cont($contract_id);

        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );


        if (empty($type)) {
            $viewData->subViewFolder = "update_contract";
        } else {
            $viewData->subViewFolder = "update_costinc";
        }

        $viewData->active_contracts = $active_contracts;

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;

        $viewData->settings = $settings;

        $viewData->item = $this->Extime_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Extime_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        $contract_id = contract_id_module("extime", "$id");
        $project_id = project_id_cont($contract_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->project_id = $project_id;

        $viewData->item = $this->Extime_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Extime_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save_contract($contract_id)
    {
        $file_name_len = file_name_digits();
        $file_name = "SU-" . $this->input->post('dosya_no');
        $extime_control = get_from_any_array("extime", "contract_id", "$contract_id");

        if (!empty($extime_control)) {
            $criter_decision_start = dateFormat_dmy(get_last_date("$contract_id", "Extime", "karar_tarih"));
            $criter_time_start = dateFormat_dmy(get_last_date("$contract_id", "Extime", "bitis_tarih"));
            $text_start = "Son Keşif Artışına Bağlı Süre Uzatımı";
            $text = "Son Keşif Artışına Bağlı Süre Uzatımı";
        } else {
            $criter_decision_start = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));
            $criter_time_start = dateFormat_dmy(get_from_id("contract", "sozlesme_bitis", "$contract_id"));
            $text_start = "Sözleşme Sözleşme İmza Tarihi Olan";
            $text = "Sözleşme Bitiş Tarihi Olan";
        }

        $contract_code = contract_code($contract_id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);

        $this->load->library("form_validation");
        $this->form_validation->set_rules("karar_tarih", "Artış Karar Tarih", "callback_extime_contractday[$criter_decision_start]|required|trim");
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[extime.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("uzatim_miktar", "Uzatım Miktar", "greater_than[0]|integer|required|trim"); //6
        $this->form_validation->set_rules("baslangic_tarih", "Başlangıç Tarih", "callback_extime_lastcontractday[$criter_time_start]|required|trim"); //7
        $this->form_validation->set_rules("aciklama", "Süre Uzatımı Notları", "required|trim"); //4

        $this->form_validation->set_message(
            array(

                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük bir sayı olmalıdır",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "extime_contractday" => "<b>{field}</b> $text_start olan <b>{param}</b> tarhihinden önce olamaz",
                "extime_lastcontractday" => "<b>{field}</b> $text tarihi olan <b>{param}</b> tarhihinden önce olamaz",
                "duplicate_name_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
            )
        );
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Extime/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            if (!empty($this->input->post("karar_tarih"))) {
                $karar_tarih = dateFormat('Y-m-d', $this->input->post("karar_tarih"));
            } else {
                $karar_tarih = null;
            }

            if (!empty($this->input->post("baslangic_tarih"))) {
                $baslangic_tarih = dateFormat('Y-m-d', $this->input->post("baslangic_tarih"));
            } else {
                $baslangic_tarih = null;
            }

            $end_date = dateFormat('Y-m-d', (date_plus_days($this->input->post("baslangic_tarih"), ($this->input->post("uzatim_miktar") - 1))));

            $insert = $this->Extime_model->add(
                array(
                    "contract_id" => $contract_id,
                    "dosya_no" => $file_name,
                    "karar_tarih" => $karar_tarih,
                    "uzatim_miktar" => $this->input->post("uzatim_miktar"),
                    "baslangic_tarih" => $baslangic_tarih,
                    "bitis_tarih" => $end_date,
                    "costinc_id" => $this->input->post("kesif_id"),
                    "uzatim_turu" => $this->input->post("uzatim_turu"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $record_id,
                    "connected_contract_id" => $contract_id,
                    "file_order" => $file_name,
                    "createdAt" => date("Y-m-d H:i:s"),
"createdBy" => active_user_id(),
                )
            );

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
                    "type" => "danger"
                );
            }
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));
        } else {

            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $viewData->settings = $settings;
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add_contract";
            $viewData->form_error = true;
            $viewData->contract_id = $contract_id;
            $viewData->project_id = project_id_cont($contract_id);

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public
    function save_costinc($costinc_id)
    {
        $contract_id = contract_id_module("costinc", "$costinc_id");
        $file_name_len = file_name_digits();
        $file_name = "SU-" . $this->input->post('dosya_no');

        $file_name_len = file_name_digits();
        $file_name = "SU-" . $this->input->post('dosya_no');
        $extime_control = get_from_any_array("extime", "contract_id", "$contract_id");

        if (!empty($extime_control)) {
            $criter_decision_start = dateFormat_dmy(get_last_date("$contract_id", "Extime", "karar_tarih"));
            $criter_time_start = dateFormat_dmy(get_last_date("$contract_id", "Extime", "bitis_tarih"));
            $text_start = "Son Keşif Artışına Bağlı Süre Uzatımı";
            $text = "Son Keşif Artışına Bağlı Süre Uzatımı";
        } else {
            $criter_decision_start = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));
            $criter_time_start = dateFormat_dmy(get_from_id("contract", "sozlesme_bitis", "$contract_id"));
            $text_start = "Sözleşme Sözleşme İmza Tarihi Olan";
            $text = "Sözleşme Bitiş Tarihi Olan";
        }


        $contract_code = contract_code($contract_id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);

        $this->load->library("form_validation");

        $this->form_validation->set_rules("karar_tarih", "Artış Karar Tarih", "callback_extime_contractday[$criter_decision_start]|required|trim");
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[extime.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("uzatim_miktar", "Uzatım Miktar", "greater_than[0]|integer|required|trim"); //6
        $this->form_validation->set_rules("baslangic_tarih", "Başlangıç Tarih", "callback_extime_lastcontractday[$criter_time_start]|required|trim"); //7
        $this->form_validation->set_rules("aciklama", "Süre Uzatımı Notları", "required|trim"); //4


        $this->form_validation->set_message(
            array(

                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük bir sayı olmalıdır",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "extime_contractday" => "<b>{field}</b> $text_start olan <b>{param}</b> tarhihinden önce olamaz",
                "extime_lastcontractday" => "<b>{field}</b> $text tarihi olan <b>{param}</b> tarhihinden önce olamaz",
                "duplicate_name_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
            )
        );
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Extime/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            if (!empty($this->input->post("karar_tarih"))) {
                $karar_tarih = dateFormat('Y-m-d', $this->input->post("karar_tarih"));
            } else {
                $karar_tarih = null;
            }

            if (!empty($this->input->post("baslangic_tarih"))) {
                $baslangic_tarih = dateFormat('Y-m-d', $this->input->post("baslangic_tarih"));
            } else {
                $baslangic_tarih = null;
            }

            $end_date = dateFormat('Y-m-d', (date_plus_days($this->input->post("baslangic_tarih"), ($this->input->post("uzatim_miktar") - 1))));

            $insert = $this->Extime_model->add(
                array(
                    "contract_id" => $contract_id,
                    "dosya_no" => $file_name,
                    "karar_tarih" => $karar_tarih,
                    "uzatim_miktar" => $this->input->post("uzatim_miktar"),
                    "baslangic_tarih" => $baslangic_tarih,
                    "bitis_tarih" => $end_date,
                    "costinc_id" => $costinc_id,
                    "uzatim_turu" => "Keşif Artışı",
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $record_id,
                    "connected_contract_id" => $contract_id,
                    "file_order" => $file_name,
                    "createdAt" => date("Y-m-d H:i:s"),
"createdBy" => active_user_id(),
                )
            );

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
                    "type" => "danger"
                );
            }
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));
        } else {

            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $costinc = $this->Costinc_model->get(array(
                    "id" => $costinc_id
                )
            );

            $viewData->settings = $settings;
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add_costinc";
            $viewData->form_error = true;
            $viewData->contract_id = $contract_id;
            $viewData->project_id = project_id_cont($contract_id);
            $viewData->costinc_id = $costinc_id;
            $viewData->costinc = $costinc;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public
    function update_costinc($id)
    {
        $viewData = new stdClass();
        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->settings = $settings;


        $viewData->item = $this->Extime_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Extime_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public
    function update_contract($extime_id)
    {
        $this->load->library("form_validation");


        $contract_id = contract_id_module("extime", "$extime_id");
        $project_id = project_id_cont($contract_id);
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));
        $lastcontract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_bitis", "$contract_id"));
        $get_last_end_extime_date = dateFormat_dmy(get_last_date("$contract_id", "Extime", "bitis_tarih"));
        $get_last_decision_extime_date = dateFormat_dmy(get_last_date("$contract_id", "Extime", "karar_tarih"));

        if (isset($get_last_end_extime_date)) {
            $criter = $get_last_end_extime_date;
            $text = "Son Keşif Artışına Bağlı Süre Uzatımı";
        } else {
            $criter = $lastcontract_day;
            $text = "Sözleşme Bitiş";
        }

        if (isset($get_last_decision_extime_date)) {
            $criter_start = $get_last_decision_extime_date;
            $text_start = "Son Keşif Artışı Karar Tarihi";
        } else {
            $criter_start = $contract_day;
            $text_start = "Sözleşme İmza Tarihi";
        }

        $this->load->library("form_validation");

        $this->form_validation->set_rules("karar_tarih", "Artış Karar Tarih", "callback_extime_contractday[$criter_start]|required|trim");
        $this->form_validation->set_rules("uzatim_miktar", "Uzatım Miktar", "greater_than[0]|integer|required|trim"); //6
        $this->form_validation->set_rules("baslangic_tarih", "Başlangıç Tarih", "callback_extime_lastcontractday[$criter]|required|trim"); //7
        $this->form_validation->set_rules("aciklama", "Süre Uzatımı Notları", "required|trim"); //4


        $this->form_validation->set_message(
            array(

                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük bir sayı olmalıdır",
                "extime_contractday" => "<b>{field}</b> $text_start olan <b>{param}</b> tarhihinden önce olamaz",
                "extime_lastcontractday" => "<b>{field}</b> $text tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );
        $validate = $this->form_validation->run();

        if ($validate) {


            if (!empty($this->input->post("karar_tarih"))) {
                $karar_tarih = dateFormat('Y-m-d', $this->input->post("karar_tarih"));
            } else {
                $karar_tarih = null;
            }

            if (!empty($this->input->post("baslangic_tarih"))) {
                $baslangic_tarih = dateFormat('Y-m-d', $this->input->post("baslangic_tarih"));
            } else {
                $baslangic_tarih = null;
            }

            $end_date = dateFormat('Y-m-d', (date_plus_days($this->input->post("baslangic_tarih"), ($this->input->post("uzatim_miktar") - 1))));

            $update = $this->Extime_model->update(
                array(
                    "id" => $extime_id
                ),
                array(
                    "karar_tarih" => $karar_tarih,
                    "uzatim_miktar" => $this->input->post("uzatim_miktar"),
                    "baslangic_tarih" => $baslangic_tarih,
                    "bitis_tarih" => $end_date,
                    "costinc_id" => $this->input->post("kesif_id"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

            $record_id = $this->db->insert_id();

            $file_order_id = get_from_any_and("file_order", "connected_module_id", $extime_id, "module", $this->Module_Name);

            $update2 = $this->Order_model->update(
                array(
                    "id" => $file_order_id
                ),
                array(
                    "updatedAt" => date("Y-m-d H:i:s"),
                )
            );

            // TODO Alert sistemi eklenecek...
            if ($update) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt başarılı bir şekilde güncellendi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Güncelleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }

            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$extime_id"));

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Bazı Bilgi Girişlerinde Hata Oluştu",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();


            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->Extime_model->get(
                array(
                    "id" => $extime_id
                )
            );

            $viewData->item_files = $this->Extime_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $extime_id
                ),
            );


            $settings = $this->Settings_model->get();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update_contract";
            $viewData->form_error = true;
            $viewData->settings = $settings;
            $viewData->contract_id = $contract_id;
            $viewData->project_id = $project_id;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public
    function delete($id)
    {

        $contract_id = contract_id_module("extime", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $extime_code = get_from_id("extime", "dosya_no", $id);

        $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Extime/$extime_code/";

        $sil = deleteDirectory($path);

        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        $delete = $this->Extime_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $delete = $this->Extime_model->delete(
            array(
                "id" => $id
            )
        );

        $file_order_id = get_from_any_and("file_order", "connected_module_id", $id, "module", $this->Module_Name);
        $update_file_order = $this->Order_model->update(
            array(
                "id" => $file_order_id
            ),
            array(
                "deletedAt" => date("Y-m-d H:i:s"),
"deletedBy" => active_user_id(),
            )
        );

        // TODO Alert Sistemi Eklenecek...
        if ($delete1 and $delete2) {
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Kayıt başarılı bir şekilde silindi",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Kayıt silme sırasında bir problem oluştu",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("Contract/$this->Display_route/$contract_id/extime"));
    }

    public
    function file_upload($id)
    {

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $contract_id = contract_id_module("extime", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $extime_code = get_from_id("extime", "dosya_no", $id);


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$contract_code/Extime/$extime_code";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Extime_file_model->add(
                array(
                    "img_url" => $uploaded_file,
                    "createdAt" => date("Y-m-d H:i:s"),
"createdBy" => active_user_id(),
                    "$this->Dependet_id_key" => $id,
                    "size" => $size
                )
            );


        } else {
            echo "islem basarisiz";
            echo $config["upload_path"];
        }

    }

    public
    function file_download($id)
    {
        $fileName = $this->Extime_file_model->get(
            array(
                "id" => $id
            )
        );

        $extime_id = get_from_id("extime_files", "extime_id", $id);
        $extime_code = get_from_id("extime", "dosya_no", $extime_id);
        $contract_id = contract_id_module("extime", $extime_id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Extime/$extime_code/$fileName->img_url";

        if ($file_path) {

            if (file_exists($file_path)) {
                $data = file_get_contents($file_path);
                force_download($fileName->img_url, $data);
            } else {
                echo "Dosya veritabanında var ancak klasör içinden silinmiş, SİSTEM YÖNETİCİNİZE BAŞVURUN";
            }
        } else {
            echo "Dosya Yok";
        }

    }

    public
    function download_all($extime_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $extime_code = get_from_id("extime", "dosya_no", $extime_id);
        $contract_id = contract_id_module("extime", $extime_id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $contract_name = contract_name($contract_id);

        $path = "uploads/project_v/$project_code/$contract_code/Extime/$extime_code";
        echo $path;

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $contract_name . "-" . $extime_code;
        $this->zip->download("$zip_name");

    }

    public
    function refresh_file_list($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->item = $this->Extime_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Extime_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public
    function fileDelete($id)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $fileName = $this->Extime_file_model->get(
            array(
                "id" => $id
            )
        );


        $extime_id = get_from_id("extime_files", "extime_id", $id);
        $contract_id = contract_id_module("extime", $extime_id);
        $contract_code = contract_code($contract_id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $extime_code = get_from_id("Extime", "dosya_no", $extime_id);

        $delete = $this->Extime_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Extime/$extime_code/$fileName->img_url";

            unlink($path);

            $viewData->item = $this->Extime_model->get(
                array(
                    "id" => $extime_id
                )
            );

            $viewData->item_files = $this->Extime_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $extime_id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;

        }
    }

    public
    function fileDelete_all($id)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $contract_id = contract_id_module("extime", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $extime_code = get_from_id("Extime", "dosya_no", $id);

        $delete = $this->Extime_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->File_Dir_Prefix/$project_code/$contract_code/Extime/$extime_code");

            foreach ($dir_files as $dir_file) {
                unlink("$this->File_Dir_Prefix/$project_code/$contract_code/Extime/$extime_code/$dir_file");
            }

            $viewData->item = $this->Extime_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Extime_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

            echo $render_html;


        }
    }

    public
    function duplicate_code_check($file_name)
    {
        $file_name = "SU-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public
    function extime_contractday($sign_start, $contract_day)
    {
        $date_diff = date_minus($sign_start, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public
    function extime_lastcontractday($extime_start, $contract_lastday)
    {
        $date_diff = date_minus($extime_start, $contract_lastday);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


}
