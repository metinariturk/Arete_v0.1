<?php

class Bond extends CI_Controller
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
        $this->viewFolder = "bond_v";
        $this->load->model("Bond_model");
        $this->load->model("Contract_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Costinc_model");
        $this->load->model("Order_model");
        $this->load->model("Advance_model");
        $this->Module_Name = "Bond";
        $this->Module_Title = "Teminat";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "contract";
        $this->Module_File_Dir = "bond";
        $this->Module_Table = "bond";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "bond_id";
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
        $items = $this->Bond_model->get_all(array());
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
        $items = $this->Bond_model->get_all(array());
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

    public function new_form($from = null, $contract_id = null, $ad_cost_id = null)
    {

        $project_id = project_id_cont($contract_id);

        if ($from == "contract_newform" or $contract_id == null) {
            $bond_related = "contract";
            $contract_id = $this->input->post("contract_id");
            $detail = null;
        } elseif ($from == "contract_display") {
            $bond_related = "contract";
            $contract_id = $contract_id;
            $detail = null;
        } elseif ($from == "advance") {
            $bond_related = "advance";
            $detail = $ad_cost_id;
        } elseif ($from == "costinc") {
            $bond_related = "costinc";
            $detail = $ad_cost_id;
        }
        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Bond_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );
        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->project_id = $project_id;
        $viewData->contract_id = $contract_id;
        $viewData->ad_cost_id = $ad_cost_id;
        $viewData->from = $from;
        $viewData->bond_related = $bond_related;
        $viewData->settings = $settings;
        $viewData->limitless = "";
        $viewData->limitless_input = "";


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function new_form_advance($advance_id = null)
    {
        $contract_id = contract_id_module("advance", "$advance_id");
        $project_id = project_id_cont($contract_id);

        $bond_related = "advance";
        $detail = $advance_id;

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Bond_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );
        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_advance";
        $viewData->items = $items;
        $viewData->project_id = $project_id;
        $viewData->advance_id = $advance_id;
        $viewData->contract_id = $contract_id;
        $viewData->bond_related = $bond_related;
        $viewData->settings = $settings;
        $viewData->limit_check = "";
        $viewData->limit_input = "";


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function new_form_contract($contract_id = null)
    {

        if (empty($contract_id)) {
            $contract_id = $this->input->post("contract_id");
        }
        $project_id = project_id_cont($contract_id);

        $bond_related = "contract";
        $detail = $contract_id;

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Bond_model->get_all(array());

        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );

        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_contract";
        $viewData->items = $items;
        $viewData->project_id = $project_id;
        $viewData->contract_id = $contract_id;
        $viewData->bond_related = $bond_related;
        $viewData->settings = $settings;
        $viewData->limit_check = "";
        $viewData->limit_input = "";


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function new_form_costinc($costinc_id = null)
    {

        $contract_id = contract_id_module("costinc", "$costinc_id");
        $project_id = project_id_cont($contract_id);

        $bond_related = "costinc";
        $detail = $costinc_id;

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Bond_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );
        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_costinc";
        $viewData->items = $items;
        $viewData->project_id = $project_id;
        $viewData->costinc_id = $costinc_id;
        $viewData->contract_id = $contract_id;
        $viewData->bond_related = $bond_related;
        $viewData->settings = $settings;
        $viewData->limit_check = "";
        $viewData->limit_input = "";


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {
        $viewData = new stdClass();
        $settings = $this->Settings_model->get();

        $type = get_from_id("bond", "teminat_gerekce", "$id");

        if ($type == "price_diff" or $type == null) {
            $type_page = "update_contract";
        } else {
            $type_page = "update_$type";
        }


        $contract_id = contract_id_module("bond", $id);
        $project_id = project_id_cont($contract_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$type_page";
        $viewData->settings = $settings;
        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;

        $viewData->item = $this->Bond_model->get(
            array(
                "id" => $id
            )
        );



        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$type_page/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        $contract_id = contract_id_module("bond", $id);
        $project_id = project_id_cont($contract_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->project_id = $project_id;
        $viewData->contract_id = $contract_id;

        $viewData->item = $this->Bond_model->get(
            array(
                "id" => $id
            )
        );

        
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save_advance($advance_id = null)
    {
        $limit_control = $this->input->post("sure_kontrol");

        $contract_id = contract_id_module("advance", $advance_id);
        $project_id = project_id_cont($contract_id);
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));

        if ($limit_control == "on") {
            $gecerlilik_tarihi = null;
            $teminat_sure = null;
        } elseif ($limit_control == null) {
            $gecerlilik_tarihi = dateFormat('Y-m-d', date_plus_days($this->input->post("teslim_tarihi"), $this->input->post("teminat_sure")));
            $teminat_sure = $this->input->post("teminat_sure");
        }

        if (is_numeric($this->input->post("teminat_miktar"))) {
            $contract_bond_min = $this->input->post("avans_miktar");
        } else {
            $contract_bond_min = 0;
        }

        $file_name_len = file_name_digits();
        $file_name = "TM-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[bond.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");

        if ($limit_control != "on") {
            $this->form_validation->set_rules("teminat_sure", "Teminat Süre", "is_natural_no_zero|required|trim");
        }

        if ($this->input->post("teminat_turu") == "Banka Teminatı") {
            $this->form_validation->set_rules("teminat_banka", "Teminat Veren Banka", "required|trim");
        }


        $this->form_validation->set_rules("teminat_turu", "Teminat Türü", "required|trim"); //5
        $this->form_validation->set_rules("teslim_tarihi", "Teminat Başlangıç Tarihi", "callback_bond_contractday[$contract_day]|required|trim");
        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "greater_than_equal_to[$contract_bond_min]|numeric|required|trim"); //7

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı bir sayı olmalıdır",
                "bond_contractday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden eski olamaz",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "greater_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den büyük bir miktar olmalıdır",
            )
        );

        $validate = $this->form_validation->run();
        if ($validate) {

            $project_id = project_id_cont($contract_id);
            $project_code = project_code($project_id);
            $contract_code = contract_code($contract_id);
            $contract_code = contract_code($contract_id);

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Bond/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            if (!empty($this->input->post("teslim_tarihi"))) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarihi"));
            } else {
                $teslim_tarihi = null;
            }

            if (!empty($this->input->post("iade_tarihi"))) {
                $iade_tarihi = dateFormat('Y-m-d', $this->input->post("iade_tarihi"));
            } else {
                $iade_tarihi = null;
            }

            $insert = $this->Bond_model->add(
                array(
                    "dosya_no" => $file_name,
                    "contract_id" => $contract_id,
                    "teminat_avans_id" => $advance_id,
                    "teminat_gerekce" => "advance",
                    "teminat_turu" => $this->input->post("teminat_turu"),
                    "teminat_miktar" => $this->input->post("teminat_miktar"),
                    "teminat_banka" => $this->input->post("teminat_banka"),
                    "teslim_tarihi" => $teslim_tarihi,
                    "gecerlilik_tarihi" => $gecerlilik_tarihi,
                    "teminat_sure" => $teminat_sure,
                    "teminat_durumu" => $this->input->post("teminat_durumu"),
                    "iade_tarihi" => $iade_tarihi,
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
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


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add_advance";
            $viewData->settings = $settings;

            $viewData->project_id = $project_id;
            $viewData->advance_id = $advance_id;
            $viewData->contract_id = $contract_id;

            $viewData->form_error = true;
            $viewData->from = "advance";


            if ($limit_control == "on") {
                $viewData->limit_check = "checked";
                $viewData->limit_input = "disabled";

            } elseif ($limit_control == null) {
                $viewData->limit_check = "";
                $viewData->limit_input = "";
            }

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function save_contract($contract_id = null)
    {
        $limit_control = $this->input->post("sure_kontrol");


        $contract_id = $contract_id;
        $project_id = project_id_cont($contract_id);
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));

        if ($limit_control == "on") {
            $gecerlilik_tarihi = null;
            $teminat_sure = null;
        } elseif ($limit_control == null) {
            $gecerlilik_tarihi = dateFormat('Y-m-d', date_plus_days($this->input->post("teslim_tarihi"), $this->input->post("teminat_sure")));
            $teminat_sure = $this->input->post("teminat_sure");
        }

        $file_name_len = file_name_digits();
        $file_name = "TM-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[bond.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");

        if ($limit_control != "on") {
            $this->form_validation->set_rules("teminat_sure", "Teminat Süre", "is_natural_no_zero|required|trim");
        }

        if ($this->input->post("teminat_turu") == "Banka Teminatı") {
            $this->form_validation->set_rules("teminat_banka", "Teminat Veren Banka", "required|trim");
        }


        $this->form_validation->set_rules("teminat_turu", "Teminat Türü", "required|trim"); //5
        $this->form_validation->set_rules("teslim_tarihi", "Teminat Başlangıç Tarihi", "callback_bond_contractday[$contract_day]|required|trim");

        if ($this->input->post("fiyat_fark") != "on") {
            $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "numeric|required|trim"); //7
        } else {
            $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "numeric|required|trim"); //7
        }


        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı bir sayı olmalıdır",
                "bond_contractday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden 30 günden fazla eski olamaz",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "greater_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den büyük bir miktar olmalıdır",
            )
        );

        $validate = $this->form_validation->run();
        if ($validate) {
            $project_id = project_id_cont($contract_id);
            $project_code = project_code($project_id);
            $contract_code = contract_code($contract_id);

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Bond/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            if (!empty($this->input->post("teslim_tarihi"))) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarihi"));
            } else {
                $teslim_tarihi = null;
            }

            if (!empty($this->input->post("iade_tarihi"))) {
                $iade_tarihi = dateFormat('Y-m-d', $this->input->post("iade_tarihi"));
            } else {
                $iade_tarihi = null;
            }


            if ($this->input->post("fiyat_fark") == "on") {
                $type = "price_diff";
            } else {
                $type = "contract";
            }

            $insert = $this->Bond_model->add(
                array(
                    "dosya_no" => $file_name,
                    "contract_id" => $contract_id,
                    "teminat_gerekce" => $type,
                    "teminat_turu" => $this->input->post("teminat_turu"),
                    "teminat_miktar" => $this->input->post("teminat_miktar"),
                    "teminat_banka" => $this->input->post("teminat_banka"),
                    "teslim_tarihi" => $teslim_tarihi,
                    "gecerlilik_tarihi" => $gecerlilik_tarihi,
                    "teminat_sure" => $teminat_sure,
                    "teminat_durumu" => $this->input->post("teminat_durumu"),
                    "iade_tarihi" => $iade_tarihi,
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
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


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add_contract";
            $viewData->settings = $settings;

            $viewData->project_id = $project_id;
            $viewData->contract_id = $contract_id;

            $viewData->form_error = true;
            $viewData->from = "contract";


            if ($limit_control == "on") {
                $viewData->limit_check = "checked";
                $viewData->limit_input = "disabled";

            } elseif ($limit_control == null) {
                $viewData->limit_check = "";
                $viewData->limit_input = "";
            }

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function save_costinc($costinc_id = null)
    {
        $limit_control = $this->input->post("sure_kontrol");

        echo $contract_id = contract_id_module("costinc", $costinc_id);
        $project_id = project_id_cont($contract_id);
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));
        $contract_bond_ratio = get_from_id("contract", "teminat_oran", "$contract_id");


        if ($limit_control == "on") {
            $gecerlilik_tarihi = null;
            $teminat_sure = null;
        } elseif ($limit_control == null) {
            $gecerlilik_tarihi = dateFormat('Y-m-d', date_plus_days($this->input->post("teslim_tarihi"), $this->input->post("teminat_sure")));
            $teminat_sure = $this->input->post("teminat_sure");
        }

        if (is_numeric($this->input->post("teminat_miktar"))) {
            $contract_bond_min = $this->input->post("artis_miktar") * $contract_bond_ratio / 100;
        } else {
            $contract_bond_min = 0;
        }

        $file_name_len = file_name_digits();
        $file_name = "TM-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[bond.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");

        if ($limit_control != "on") {
            $this->form_validation->set_rules("teminat_sure", "Teminat Süre", "is_natural_no_zero|required|trim");
        }

        if ($this->input->post("teminat_turu") == "Banka Teminatı") {
            $this->form_validation->set_rules("teminat_banka", "Teminat Veren Banka", "required|trim");
        }


        $this->form_validation->set_rules("teminat_turu", "Teminat Türü", "required|trim"); //5
        $this->form_validation->set_rules("teslim_tarihi", "Teminat Başlangıç Tarihi", "callback_bond_contractday[$contract_day]|required|trim");
        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "greater_than_equal_to[$contract_bond_min]|numeric|required|trim"); //7

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı bir sayı olmalıdır",
                "bond_contractday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden 30 günden fazla eski olamaz",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "greater_than_equal_to" => "<b>{field}</b> % $contract_bond_ratio olan teminat oranını sağlamak için <b>{param}</b> 'den büyük bir miktar olmalıdır",
            )
        );

        $validate = $this->form_validation->run();
        if ($validate) {

            $project_id = project_id_cont($contract_id);
            $project_code = project_code($project_id);
            $contract_code = contract_code($contract_id);
            $contract_code = contract_code($contract_id);

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Bond/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            if (!empty($this->input->post("teslim_tarihi"))) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarihi"));
            } else {
                $teslim_tarihi = null;
            }

            if (!empty($this->input->post("iade_tarihi"))) {
                $iade_tarihi = dateFormat('Y-m-d', $this->input->post("iade_tarihi"));
            } else {
                $iade_tarihi = null;
            }

            $insert = $this->Bond_model->add(
                array(
                    "dosya_no" => $file_name,
                    "contract_id" => $contract_id,
                    "teminat_kesif_id" => $costinc_id,
                    "teminat_gerekce" => "costinc",
                    "teminat_turu" => $this->input->post("teminat_turu"),
                    "teminat_miktar" => $this->input->post("teminat_miktar"),
                    "teminat_banka" => $this->input->post("teminat_banka"),
                    "teslim_tarihi" => $teslim_tarihi,
                    "gecerlilik_tarihi" => $gecerlilik_tarihi,
                    "teminat_sure" => $teminat_sure,
                    "teminat_durumu" => $this->input->post("teminat_durumu"),
                    "iade_tarihi" => $iade_tarihi,
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
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


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add_costinc";
            $viewData->settings = $settings;

            $viewData->project_id = $project_id;
            $viewData->costinc_id = $costinc_id;
            $viewData->contract_id = $contract_id;

            $viewData->form_error = true;
            $viewData->from = "costinc";


            if ($limit_control == "on") {
                $viewData->limit_check = "checked";
                $viewData->limit_input = "disabled";

            } elseif ($limit_control == null) {
                $viewData->limit_check = "";
                $viewData->limit_input = "";
            }

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function update_bond_advance($id)
    {

        $limit_control = $this->input->post("sure_kontrol");

        $contract_id = contract_id_module("bond", $id);
        $project_id = project_id_cont($contract_id);
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));

        if ($limit_control == "on") {
            $gecerlilik_tarihi = null;
            $teminat_sure = null;
        } elseif ($limit_control == null) {
            $gecerlilik_tarihi = dateFormat('Y-m-d', date_plus_days($this->input->post("teslim_tarihi"), $this->input->post("teminat_sure")));
            $teminat_sure = $this->input->post("teminat_sure");
        }

        if (is_numeric($this->input->post("teminat_miktar"))) {
            $contract_bond_min = $this->input->post("avans_miktar");
        } else {
            $contract_bond_min = 0;
        }

        $this->load->library("form_validation");


        if ($limit_control != "on") {
            $this->form_validation->set_rules("teminat_sure", "Teminat Süre", "is_natural_no_zero|required|trim");
        }

        if ($this->input->post("teminat_turu") == "Banka Teminatı") {
            $this->form_validation->set_rules("teminat_banka", "Teminat Veren Banka", "required|trim");
        }

        if (!empty($this->input->post("iade_tarihi"))) {
            $this->form_validation->set_rules("iade_aciklama", "İade Açıklama", "required|trim");
            $this->form_validation->set_rules("iade_tarihi", "İade Tarihi", "callback_bond_contractday[$contract_day]|required|trim");
            $iade_durum = 1;
        }

        if (!empty($this->input->post("iade_aciklama"))) {
            $this->form_validation->set_rules("iade_tarihi", "İade Tarihi", "required|trim");
            $this->form_validation->set_rules("iade_tarihi", "İade Tarihi", "callback_bond_contractday[$contract_day]|required|trim");
        }

        $this->form_validation->set_rules("teminat_turu", "Teminat Türü", "required|trim"); //5
        $this->form_validation->set_rules("teslim_tarihi", "Teminat Başlangıç Tarihi", "callback_bond_contractday[$contract_day]|required|trim");
        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "greater_than_equal_to[$contract_bond_min]|numeric|required|trim"); //7

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı bir sayı olmalıdır",
                "bond_contractday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden 30 günden fazla eski olamaz",

                "greater_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den büyük bir miktar olmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            if (!empty($this->input->post("teslim_tarihi"))) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarihi"));
            } else {
                $teslim_tarihi = null;
            }

            if (!empty($this->input->post("iade_tarihi"))) {
                $iade_tarihi = dateFormat('Y-m-d', $this->input->post("iade_tarihi"));
            } else {
                $iade_tarihi = null;
            }


            $update = $this->Bond_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "teminat_turu" => $this->input->post("teminat_turu"),
                    "teminat_miktar" => $this->input->post("teminat_miktar"),
                    "sozlesme_oran" => $this->input->post("sozlesme_oran"),
                    "teminat_banka" => $this->input->post("teminat_banka"),
                    "teslim_tarihi" => $teslim_tarihi,
                    "gecerlilik_tarihi" => $gecerlilik_tarihi,
                    "teminat_sure" => $teminat_sure,
                    "teminat_durumu" => $iade_durum,
                    "iade_tarihi" => $iade_tarihi,
                    "iade_aciklama" => $this->input->post("iade_aciklama"),
                )
            );

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
            $settings = $this->Settings_model->get();


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update_advance";
            $viewData->settings = $settings;

            $viewData->project_id = $project_id;
            $viewData->contract_id = $contract_id;

            $viewData->form_error = true;
            $viewData->from = "advance";


            if ($limit_control == "on") {
                $viewData->limit_check = "checked";
                $viewData->limit_input = "disabled";

            } elseif ($limit_control == null) {
                $viewData->limit_check = "";
                $viewData->limit_input = "";
            }

            $viewData->item = $this->Bond_model->get(
                array(
                    "id" => $id
                )
            );


            


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/update_advance/index", $viewData);
        }
    }

    public function update_bond_contract($id)
    {

        $limit_control = $this->input->post("sure_kontrol");

        $contract_id = contract_id_module("bond", $id);
        $project_id = project_id_cont($contract_id);
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));


        if ($limit_control == "on") {
            $gecerlilik_tarihi = null;
            $teminat_sure = null;
        } elseif ($limit_control == null) {
            $gecerlilik_tarihi = dateFormat('Y-m-d', date_plus_days($this->input->post("teslim_tarihi"), $this->input->post("teminat_sure")));
            $teminat_sure = $this->input->post("teminat_sure");
        }



        $this->load->library("form_validation");


        if ($limit_control != "on") {
            $this->form_validation->set_rules("teminat_sure", "Teminat Süre", "is_natural_no_zero|required|trim");
        }

        if ($this->input->post("teminat_turu") == "Banka Teminatı") {
            $this->form_validation->set_rules("teminat_banka", "Teminat Veren Banka", "required|trim");
        }

        if (!empty($this->input->post("iade_tarihi"))) {
            $this->form_validation->set_rules("iade_aciklama", "İade Açıklama", "required|trim");
            $this->form_validation->set_rules("iade_tarihi", "İade Tarihi", "callback_bond_contractday[$contract_day]|required|trim");
            $iade_durum = 1;

        }

        if (!empty($this->input->post("iade_aciklama"))) {
            $this->form_validation->set_rules("iade_tarihi", "İade Tarihi", "required|trim");
            $this->form_validation->set_rules("iade_tarihi", "İade Tarihi", "callback_bond_contractday[$contract_day]|required|trim");
        }

        $this->form_validation->set_rules("teminat_turu", "Teminat Türü", "required|trim"); //5
        $this->form_validation->set_rules("teslim_tarihi", "Teminat Başlangıç Tarihi", "callback_bond_contractday[$contract_day]|required|trim");
        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "numeric|required|trim"); //7

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı bir sayı olmalıdır",
                "bond_contractday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden 30 günden fazla eski olamaz",

                "greater_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den büyük bir miktar olmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            if (!empty($this->input->post("teslim_tarihi"))) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarihi"));
            } else {
                $teslim_tarihi = null;
            }

            if (!empty($this->input->post("iade_tarihi"))) {
                $iade_tarihi = dateFormat('Y-m-d', $this->input->post("iade_tarihi"));
            } else {
                $iade_tarihi = null;
            }

            if ($this->input->post("fiyat_fark") == "on") {
                $type = "price_diff";
            } elseif ($this->input->post("fiyat_fark") != "on") {
                $type = "contract";
            }

            $update = $this->Bond_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "teminat_turu" => $this->input->post("teminat_turu"),
                    "teminat_miktar" => $this->input->post("teminat_miktar"),
                    "sozlesme_oran" => $this->input->post("sozlesme_oran"),
                    "teminat_banka" => $this->input->post("teminat_banka"),
                    "teminat_gerekce" => $type,
                    "teslim_tarihi" => $teslim_tarihi,
                    "gecerlilik_tarihi" => $gecerlilik_tarihi,
                    "teminat_sure" => $teminat_sure,
                    "teminat_durumu" => $iade_durum,
                    "iade_tarihi" => $iade_tarihi,
                    "iade_aciklama" => $this->input->post("iade_aciklama"),
                )
            );

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
            $settings = $this->Settings_model->get();


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update_contract";
            $viewData->settings = $settings;

            $viewData->project_id = $project_id;
            $viewData->contract_id = $contract_id;

            $viewData->form_error = true;
            $viewData->from = "contract";


            if ($limit_control == "on") {
                $viewData->limit_check = "checked";
                $viewData->limit_input = "disabled";

            } elseif ($limit_control == null) {
                $viewData->limit_check = "";
                $viewData->limit_input = "";
            }

            $viewData->item = $this->Bond_model->get(
                array(
                    "id" => $id
                )
            );


            


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/update_contract/index", $viewData);
        }
    }

    public function update_bond_costinc($id)
    {

        $limit_control = $this->input->post("sure_kontrol");

        $contract_id = contract_id_module("bond", $id);
        $project_id = project_id_cont($contract_id);
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));

        if ($limit_control == "on") {
            $gecerlilik_tarihi = null;
            $teminat_sure = null;
        } elseif ($limit_control == null) {
            $gecerlilik_tarihi = dateFormat('Y-m-d', date_plus_days($this->input->post("teslim_tarihi"), $this->input->post("teminat_sure")));
            $teminat_sure = $this->input->post("teminat_sure");
        }

        if (is_numeric($this->input->post("teminat_miktar"))) {
            $contract_bond_min = $this->input->post("avans_miktar");
        } else {
            $contract_bond_min = 0;
        }

        $this->load->library("form_validation");


        if ($limit_control != "on") {
            $this->form_validation->set_rules("teminat_sure", "Teminat Süre", "is_natural_no_zero|required|trim");
        }

        if ($this->input->post("teminat_turu") == "Banka Teminatı") {
            $this->form_validation->set_rules("teminat_banka", "Teminat Veren Banka", "required|trim");
        }

        if (!empty($this->input->post("iade_tarihi"))) {
            $this->form_validation->set_rules("iade_aciklama", "İade Açıklama", "required|trim");
            $this->form_validation->set_rules("iade_tarihi", "İade Tarihi", "callback_bond_contractday[$contract_day]|required|trim");
            $iade_durum = 1;

        }

        if (!empty($this->input->post("iade_aciklama"))) {
            $this->form_validation->set_rules("iade_tarihi", "İade Tarihi", "required|trim");
            $this->form_validation->set_rules("iade_tarihi", "İade Tarihi", "callback_bond_contractday[$contract_day]|required|trim");
        }

        $this->form_validation->set_rules("teminat_turu", "Teminat Türü", "required|trim"); //5
        $this->form_validation->set_rules("teslim_tarihi", "Teminat Başlangıç Tarihi", "callback_bond_contractday[$contract_day]|required|trim");
        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "greater_than_equal_to[$contract_bond_min]|numeric|required|trim"); //7

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı bir sayı olmalıdır",
                "bond_contractday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden 30 günden fazla eski olamaz",

                "greater_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den büyük bir miktar olmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            if (!empty($this->input->post("teslim_tarihi"))) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarihi"));
            } else {
                $teslim_tarihi = null;
            }

            if (!empty($this->input->post("iade_tarihi"))) {
                $iade_tarihi = dateFormat('Y-m-d', $this->input->post("iade_tarihi"));
            } else {
                $iade_tarihi = null;
            }


            $update = $this->Bond_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "teminat_turu" => $this->input->post("teminat_turu"),
                    "teminat_miktar" => $this->input->post("teminat_miktar"),
                    "sozlesme_oran" => $this->input->post("sozlesme_oran"),
                    "teminat_banka" => $this->input->post("teminat_banka"),
                    "teslim_tarihi" => $teslim_tarihi,
                    "gecerlilik_tarihi" => $gecerlilik_tarihi,
                    "teminat_sure" => $teminat_sure,
                    "teminat_durumu" => $iade_durum,
                    "iade_tarihi" => $iade_tarihi,
                    "iade_aciklama" => $this->input->post("iade_aciklama"),
                )
            );

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
            $settings = $this->Settings_model->get();


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update_costinc";
            $viewData->settings = $settings;

            $viewData->project_id = $project_id;
            $viewData->contract_id = $contract_id;

            $viewData->form_error = true;
            $viewData->from = "costinc";


            if ($limit_control == "on") {
                $viewData->limit_check = "checked";
                $viewData->limit_input = "disabled";

            } elseif ($limit_control == null) {
                $viewData->limit_check = "";
                $viewData->limit_input = "";
            }

            $viewData->item = $this->Bond_model->get(
                array(
                    "id" => $id
                )
            );


            


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/update_costinc/index", $viewData);
        }
    }

    public function delete($id)
    {

        $contract_id = contract_id_module("bond", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $file_name = get_from_id("bond", "dosya_no", $id);
        $file_order_id = get_from_any_and("file_order", "connected_module_id", $id, "module", $this->Module_Name);


        $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Bond/$file_name/";

        $sil = deleteDirectory($path);

        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        $update_file_order = $this->Order_model->update(
            array(
                "id" => $file_order_id
            ),
            array(
                "deletedAt" => date("Y-m-d H:i:s"),
                "deletedBy" => active_user_id(),
            )
        );


        $delete = $this->Bond_model->delete(
            array(
                "id" => $id
            )
        );

        // TODO Alert Sistemi Eklenecek...
        if ($delete) {

            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Kayıt başarılı bir şekilde silindi",
                "type" => "success"
            );

        } else {

            $alert = array(
                "title" => "İşlem Başarılı",
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
        $contract_id = contract_id_module("bond", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $bond_code = get_from_id("bond", "dosya_no", $id);


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$contract_code/Bond/$bond_code";
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
        

        $bond_id = get_from_id("bond_files", "bond_id", $id);
        $contract_id = contract_id_module("bond", $bond_id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $bond_code = get_from_id("bond", "dosya_no", $bond_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Bond/$bond_code/$fileName->img_url";

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

    public function download_all($bond_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $contract_id = get_from_id("bond", "contract_id", "$bond_id");
        $Bond_code = get_from_id("bond", "dosya_no", "$bond_id");
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $contract_name = contract_name($contract_id);

        $path = "uploads/project_v/$project_code/$contract_code/Bond/$Bond_code";
        echo $path;

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $contract_name . "-" . $Bond_code;
        $this->zip->download("$zip_name");

    }






    public function duplicate_code_check($file_name)
    {
        $file_name = "TM-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function date_minus_check($date1, $date2)
    {
        $format_date1 = dateFormat('Y-m-d', "$date1");
        $format_date2 = dateFormat('Y-m-d', "$date2");
        $a = strtotime($format_date1);
        $b = strtotime($format_date2);
        $c = $a - $b;
        if (($c < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function bond_contractday($bond_day, $contract_day)
    {
        $date_diff = date_minus($bond_day, $contract_day);
        $days_diff = $date_diff / (60 * 60 * 24); // Tarih farkını gün cinsine dönüştürme

        if ($days_diff >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
