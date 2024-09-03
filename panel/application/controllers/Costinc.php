<?php

class Costinc extends CI_Controller
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
        $this->viewFolder = "Costinc_v";
        $this->load->model("Costinc_model");
        $this->load->model("Contract_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("Costinc_model");
        $this->load->model("Newprice_model");

        $this->Module_Name = "Costinc";
        $this->Module_Title = "Keşif Artışı";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "contract";
        $this->Module_File_Dir = "Costinc";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir/";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir/";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "costinc_id";
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";
        
        $this->Common_Files = "common";
    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Costinc_model->get_all(array());
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
        $items = $this->Costinc_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
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

    public function new_form_newprice($newprice_id = null)
    {

        $viewData = new stdClass();

        $settings = $this->Settings_model->get();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Costinc_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );

        if (empty($newprice_id)) {
            $contract_id = null;
        } else {
            $contract_id = contract_id_module("newprice", "$newprice_id");
        }

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_newprice";
        $viewData->items = $items;
        $viewData->active_contracts = $active_contracts;
        $viewData->contract_id = $contract_id;
        if ((!empty($this->input->post("contract_id"))) or !empty($contract_id)){
            $viewData->project_id = project_id_cont($contract_id);
        }
        $viewData->newprice_id = $newprice_id;
        $viewData->settings = $settings;
        $viewData->onay_input = "";


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function new_form_contract($contract_id)
    {

        $viewData = new stdClass();

        $settings = $this->Settings_model->get();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Costinc_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_contract";
        $viewData->items = $items;
        $viewData->active_contracts = $active_contracts;
        $viewData->contract_id = $contract_id;
        $viewData->project_id = project_id_cont($contract_id);
        $viewData->settings = $settings;
        $viewData->onay_input = "";


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $newprice_id = get_from_id("costinc", "newprice_id", "$id");
        $artis_oran = get_from_id("costinc", "artis_oran", "$id");
        $contract_id = contract_id_module("costinc", $id);
        $project_id = project_id_cont($contract_id);

        if ($artis_oran >= 20) {
            $onay_input = "checked";
        } else {
            $onay_input = "";
        }

        if (isset($newprice_id)) {
            $viewData->subViewFolder = "update_newprice";
        } else {
            $viewData->subViewFolder = "update_contract";
        }
        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;
        $viewData->onay_input = $onay_input;

        $viewData->item = $this->Costinc_model->get(
            array(
                "id" => $id
            )
        );


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        $contract_id = contract_id_module("costinc", $id);
        $project_id = project_id_cont($contract_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->project_id = $project_id;

        $viewData->item = $this->Costinc_model->get(
            array(
                "id" => $id
            )
        );


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save_newprice($newprice_id = null)
    {
        $contract_id = contract_id_module("newprice", "$newprice_id");
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));


        $file_name_len = file_name_digits();
        $file_name = "KA-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");
        $this->form_validation->set_rules("artis_tarih", "Artış Karar Tarih", "callback_cosntinc_contractday[$contract_day]|required|trim");
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[costinc.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("karar_no", "Karar Numarası", "required|trim");
        $this->form_validation->set_rules("artis_miktar", "Artış Miktar", "greater_than[0]|required|trim|numeric");
        if ($this->input->post('onay') != "on") {
            $onay_input = "";
            $this->form_validation->set_rules("artis_oran", "Artış Oran", "less_than_equal_to[20]|required|trim");
        } else {
            $onay_input = "checked";
            $this->form_validation->set_rules("artis_oran", "Artış Oran", "numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Keşif Artışı Açıklamaları", "required|trim"); //4

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük bir sayı olmalıdır",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "cosntinc_contractday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den fazla keşif artışı veriyorsunuz. İşlem doğru ise yandaki kutucuğu işaretleyerek devam ediniz.",
            )
        );
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Costinc/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            if ($this->input->post("artis_tarih")) {
                $artis_tarihi = dateFormat('Y-m-d', $this->input->post("artis_tarih"));
            } else {
                $artis_tarihi = null;
            }

            $insert = $this->Costinc_model->add(
                array(
                    "contract_id" => $contract_id,
                    "karar_no" => $this->input->post("karar_no"),
                    "dosya_no" => $file_name,
                    "artis_tarih" => $artis_tarihi,
                    "artis_miktar" => $this->input->post("artis_miktar"),
                    "artis_oran" => $this->input->post("artis_oran"),
                    "aciklama" => $this->input->post("aciklama"),
                    "newprice_id" => $newprice_id,
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $record_id,
                    "connected_contract_id" => $id,
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
            $viewData->subViewFolder = "add_newprice";
            $viewData->form_error = true;

            $viewData->contract_id = $contract_id;
            $viewData->newprice_id = $newprice_id;
            $viewData->project_id = $project_id;
            $viewData->onay_input = $onay_input;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function save_contract($contract_id = null)
    {
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));


        $file_name_len = file_name_digits();
        $file_name = "KA-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");
        $this->form_validation->set_rules("artis_tarih", "Artış Karar Tarih", "callback_cosntinc_contractday[$contract_day]|required|trim");
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[costinc.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("karar_no", "Karar Numarası", "required|trim");
        $this->form_validation->set_rules("artis_miktar", "Artış Miktar", "greater_than[0]|required|trim|numeric");
        if ($this->input->post('onay') != "on") {
            $onay_input = "";
            $this->form_validation->set_rules("artis_oran", "Artış Oran", "less_than_equal_to[20]|required|trim");
        } else {
            $onay_input = "checked";
            $this->form_validation->set_rules("artis_oran", "Artış Oran", "numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Keşif Artışı Açıklamaları", "required|trim"); //4

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük bir sayı olmalıdır",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
<br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "cosntinc_contractday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
<br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den fazla keşif artışı veriyorsunuz. İşlem doğru ise yandaki kutucuğu işaretleyerek devam ediniz.",
            )
        );
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Costinc/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            if ($this->input->post("artis_tarih")) {
                $artis_tarihi = dateFormat('Y-m-d', $this->input->post("artis_tarih"));
            } else {
                $artis_tarihi = null;
            }

            $insert = $this->Costinc_model->add(
                array(
                    "contract_id" => $contract_id,
                    "karar_no" => $this->input->post("karar_no"),
                    "dosya_no" => $file_name,
                    "artis_tarih" => $artis_tarihi,
                    "artis_miktar" => $this->input->post("artis_miktar"),
                    "artis_oran" => $this->input->post("artis_oran"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $record_id,
                    "connected_contract_id" => $id,
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
            $viewData->contract_id = $contract_id;
            $viewData->project_id = $project_id;
            $viewData->onay_input = $onay_input;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function update_newprice($id)
    {
        $this->load->library("form_validation");

        $contract_id = contract_id_module("costinc","$id");
        $project_id = project_id_cont($contract_id);
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));



        $this->form_validation->set_rules("karar_no", "Karar Numarası", "required|trim");
        $this->form_validation->set_rules("artis_tarih", "Artış Karar Tarih", "callback_cosntinc_contractday[$contract_day]|required|trim");
        $this->form_validation->set_rules("artis_miktar", "Artış Miktar", "greater_than[0]|required|trim|numeric");
        if ($this->input->post('onay') != "on") {
            $onay_input = "";
            $this->form_validation->set_rules("artis_oran", "Artış Oran", "less_than_equal_to[20]|required|trim");
        } else {
            $onay_input = "checked";
            $this->form_validation->set_rules("artis_oran", "Artış Oran", "numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Keşif Artışı Notları", "required|trim"); //4

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "cosntinc_contractday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük bir sayı olmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den fazla keşif artışı veriyorsunuz. İşlem doğru ise yandaki kutucuğu işaretleyerek devam ediniz.",
            )
        );
        $validate = $this->form_validation->run();

        if ($validate) {

            $artis_tarihi = dateFormat('Y-m-d', $this->input->post("artis_tarih"));

            $update = $this->Costinc_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "karar_no" => $this->input->post("karar_no"),
                    "artis_tarih" => $artis_tarihi,
                    "artis_miktar" => $this->input->post("artis_miktar"),
                    "artis_oran" => $this->input->post("artis_oran"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

            $record_id = $this->db->insert_id();

            $file_order_id = get_from_any_and("file_order", "connected_module_id", $id, "module", $this->Module_Name);

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
            redirect(base_url("$this->Module_Name/$this->Display_route/$id"));

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Bazı Bilgi Girişlerinde Hata Oluştu",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();


            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->Costinc_model->get(
                array(
                    "id" => $id
                )
            );


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update_newprice";

            $viewData->contract_id = $contract_id;
            $viewData->project_id = $project_id;
            $viewData->onay_input = $onay_input;

            $viewData->form_error = true;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update_contract($id)
    {
        $this->load->library("form_validation");

        $contract_id = contract_id_module("costinc","$id");
        $project_id = project_id_cont($contract_id);
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));



        $this->form_validation->set_rules("karar_no", "Karar Numarası", "required|trim");
        $this->form_validation->set_rules("artis_tarih", "Artış Karar Tarih", "callback_cosntinc_contractday[$contract_day]|required|trim");
        $this->form_validation->set_rules("artis_miktar", "Artış Miktar", "greater_than[0]|required|trim|numeric");
        if ($this->input->post('onay') != "on") {
            $onay_input = "";
            $this->form_validation->set_rules("artis_oran", "Artış Oran", "less_than_equal_to[20]|required|trim");
        } else {
            $onay_input = "checked";
            $this->form_validation->set_rules("artis_oran", "Artış Oran", "numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Keşif Artışı Notları", "required|trim"); //4

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "cosntinc_contractday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük bir sayı olmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den fazla keşif artışı veriyorsunuz. İşlem doğru ise yandaki kutucuğu işaretleyerek devam ediniz.",
            )
        );
        $validate = $this->form_validation->run();

        if ($validate) {

            $artis_tarihi = dateFormat('Y-m-d', $this->input->post("artis_tarih"));

            $update = $this->Costinc_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "karar_no" => $this->input->post("karar_no"),
                    "artis_tarih" => $artis_tarihi,
                    "artis_miktar" => $this->input->post("artis_miktar"),
                    "artis_oran" => $this->input->post("artis_oran"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

            $record_id = $this->db->insert_id();

            $file_order_id = get_from_any_and("file_order", "connected_module_id", $id, "module", $this->Module_Name);

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
            redirect(base_url("$this->Module_Name/$this->Display_route/$id"));

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Bazı Bilgi Girişlerinde Hata Oluştu",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();


            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->Costinc_model->get(
                array(
                    "id" => $id
                )
            );



            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update_contract";

            $viewData->contract_id = $contract_id;
            $viewData->project_id = $project_id;
            $viewData->onay_input = $onay_input;

            $viewData->form_error = true;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        //Bağlı teminat silme işlemleri
        $contract_id = contract_id_module("costinc", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);

        if (!empty(get_from_any_and("bond", "contract_id", $contract_id, "teminat_kesif_id", $id))) {
            $bond_id = get_from_any_and("bond", "contract_id", $contract_id, "teminat_kesif_id", $id);
            $bond_file_name = get_from_id("bond", "dosya_no", $bond_id);
            $bond_file_order_id = get_from_any_and("file_order", "connected_module_id", $bond_id, "module", "bond");

            $bond_path = "$this->File_Dir_Prefix/$project_code/$contract_code/contract/bond/$bond_file_name/";

            $sil_bond = deleteDirectory($bond_path);

            $update_bond_order = $this->Order_model->update(
                array(
                    "id" => $bond_file_order_id
                ),
                array(
                    "deletedAt" => date("Y-m-d H:i:s"),
"deletedBy" => active_user_id(),
                )
            );



            $delete_bond = $this->Bond_model->delete(
                array(
                    "id" => $bond_id
                )
            );
        }

        $costinc_code = get_from_id("costinc", "dosya_no", $id);

        $costinc_path = "$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$costinc_code/";

        $sil_costinc = deleteDirectory($costinc_path);

        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }


        $delete2 = $this->Costinc_model->delete(
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
        redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$contract_id"));
    }

    public function file_upload($id)
    {

                $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $contract_id = contract_id_module("costinc", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $costinc_code = get_from_id("costinc", "dosya_no", $id);


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$contract_code/Costinc/$costinc_code";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");



        } else {
            echo "islem basarisiz";
            echo $config["upload_path"];
        }

    }

    public function file_download($id)
    {


        $costinc_id = get_from_id("costinc_files", "costinc_id", $id);
        $contract_id = contract_id_module("costinc", $costinc_id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $bond_code = get_from_id("costinc", "dosya_no", $costinc_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Costinc/$bond_code/$fileName->img_url";

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

    public function download_all($costinc_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $contract_id = get_from_id("costinc", "contract_id", "$costinc_id");
        $Costinc_code = get_from_id("costinc", "dosya_no", "$costinc_id");
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $contract_name = contract_name($contract_id);

        $path = "uploads/project_v/$project_code/$contract_code/Costinc/$Costinc_code";
        echo $path;

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $contract_name . "-" . $Costinc_code;
        $this->zip->download("$zip_name");

    }






    public function duplicate_code_check($file_name)
    {
        $file_name = "KA-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function cosntinc_contractday($costinc_day, $contract_day)
    {
        $date_diff = date_minus($costinc_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
