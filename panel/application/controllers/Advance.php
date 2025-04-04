<?php

class Advance extends CI_Controller
{
    public $viewFolder = "";

    public $moduleFolder = "";

    public function __construct()
    {
        parent::__construct();

        if (!get_active_user()) {
            redirect(base_url("login"));
        }

        $uploader = APPPATH . 'libraries/FileUploader.php';
        include($uploader);

        $this->Theme_mode = get_active_user()->mode;
        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        $this->moduleFolder = "contract_module";
        $this->viewFolder = "advance_v";
        $this->load->model("Advance_model");
        $this->load->model("Contract_model");
        $this->load->model("Payment_settings_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("Bond_model");

        $this->Module_Name = "advance";
        $this->Module_Title = "Avans";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "contract";
        $this->Module_File_Dir = "advance";
        $this->Module_Table = "advance";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "advance_id";
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
        $items = $this->Advance_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "isACtive" => 1
            )
        );


        
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->active_contracts = $active_contracts;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($contract_id = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        if ($contract_id == null) {
            $contract_id = $this->input->post("contract_id");
        }

        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */

        $settings = $this->Settings_model->get();


        
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->active_contracts = $active_contracts;
        if ((!empty($this->input->post("contract_id"))) or !empty($contract_id)) {
            $viewData->project_id = project_id_cont($contract_id);
        }
        $viewData->contract_id = $contract_id;
        $viewData->settings = $settings;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {

        $item = $this->Advance_model->get(array("id"=>$id));
        $contract = $this->Contract_model->get(array("id"=>$item->contract_id));
        $project = $this->Project_model->get(array("id"=>$contract->project_id));
        $payment_settings = $this->Payment_settings_model->get(array("contract_id"=>$contract->id));
        $settings = $this->Settings_model->get();

        if (!isAdmin()) {
            redirect(base_url("error"));
        }


        $viewData = new stdClass();

        
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->contract = $contract;
        $viewData->project = $project;
        $viewData->payment_settings = $payment_settings;
        $viewData->settings = $settings;
        $viewData->item = $item;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);


    }

    public function file_form($id)
    {

        $contract_id = contract_id_module("advance", $id);

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = project_id_cont("$contract_id");

        $viewData = new stdClass();

        
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $viewData->item = $this->Advance_model->get(
            array(
                "id" => $id
            )
        );

        

        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($contract_id)
    {
        $contract = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $contract->project_id));

        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $this->load->library("form_validation");

        $file_name_len = file_name_digits();
        $file_name = "AV-" . $this->input->post('dosya_no');

        $contract_price = get_from_id("contract", "sozlesme_bedel", $contract_id);
        $sozlesme_tarih = dateFormat_dmy(get_from_any("contract", "sozlesme_tarih", "id", "$contract_id"));

        $this->form_validation->set_rules("dosya_no", "Dosya No", "is_unique[advance.dosya_no]|exact_length[$file_name_len]|trim|callback_duplicate_code_check"); //2
        $this->form_validation->set_rules("avans_tarih", "Avans Tarihi", "callback_contract_advanceday[$sozlesme_tarih]|required|trim");
        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "less_than_equal_to[$contract_price]|numeric|required|trim");
        } else {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_advanceday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "duplicate_name_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $project_id = project_id_cont("$contract_id");
            $project_code = project_code("$project_id");
            $contract_code = contract_code($contract_id);

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/$this->Module_Name/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            $avans_tarihi = dateFormat('Y-m-d', $this->input->post("avans_tarih"));


            $insert = $this->Advance_model->add(
                array(
                    "dosya_no" => $file_name,
                    "contract_id" => $contract_id,
                    "avans_tarih" => $avans_tarihi,
                    "avans_miktar" => $this->input->post("avans_miktar"),
                    "aciklama" => $this->input->post("aciklama"),
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
            // TODO Alert sistemi eklenecek...
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
            // İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("Contract/file_form/$contract_id/Advance"));
            //kaydedilen elemanın id nosunu döküman ekleme sayfasına post ediyoruz
        } else {

            $this->load->model("Advance_model");
            $this->load->model("Bond_model");
            $this->load->model("City_model");
            $this->load->model("Company_model");
            $this->load->model("Contract_model");
            $this->load->model("Contract_price_model");
            $this->load->model("Costinc_model");
            $this->load->model("Collection_model");
            $this->load->model("Delete_model");
            $this->load->model("District_model");
            $this->load->model("Extime_model");
            $this->load->model("Favorite_model");
            $this->load->model("Newprice_model");
            $this->load->model("Order_model");
            $this->load->model("Payment_model");
            $this->load->model("Project_model");
            $this->load->model("Settings_model");
            $this->load->model("Site_model");
            $this->load->model("User_model");
            $this->load->model("Site_model");

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Bazı Bilgi Girişlerinde Hata Oluştu",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            if (!isAdmin()) {
                redirect(base_url("error"));
            }

            $item = $this->Contract_model->get(array("id" => $contract->id));
            $upload_function = base_url("$this->Module_Name/file_upload/$item->id");
            $project = $this->Project_model->get(array("id" => $item->project_id));
            $path = "$this->File_Dir_Prefix/$project->dosya_no/$item->dosya_no/Contract/";
            $collection_path = "$this->File_Dir_Prefix/$project->dosya_no/$item->dosya_no/Collection";
            $advance_path = "$this->File_Dir_Prefix/$project->dosya_no/$item->dosya_no/Advance";
            $offer_path = "$this->File_Dir_Prefix/$project->dosya_no/$item->dosya_no/Offer";
            $payment_path = "$this->File_Dir_Prefix/$project->dosya_no/$item->dosya_no/Payment";

            $companys = $this->Company_model->get_all(array());

            !is_dir($path) && mkdir($path, 0777, TRUE);
            !is_dir($collection_path) && mkdir($collection_path, 0777, TRUE);
            !is_dir($advance_path) && mkdir($advance_path, 0777, TRUE);
            !is_dir($offer_path) && mkdir($offer_path, 0777, TRUE);
            !is_dir($payment_path) && mkdir($payment_path, 0777, TRUE);

            if ($item->offer == 1) {
                redirect(base_url("contract/file_form_offer/$contract->id"));
            }

            if (count_payments($contract->id) == 0) {
                $payment_no = 1;
            } else {
                $payment_no = last_payment($contract->id) + 1;
            }

            $fav = $this->Favorite_model->get(array(
                "user_id" => active_user_id(),
                "module" => "contract",
                "view" => "file_form",
                "module_id" => $contract->id,
            ));

            $viewData = new stdClass();

            $collections = $this->Collection_model->get_all(array('contract_id' => $contract->id), "tahsilat_tarih ASC");
            $advances = $this->Advance_model->get_all(array('contract_id' => $contract->id));
            $bonds = $this->Bond_model->get_all(array('contract_id' => $contract->id));
            $costincs = $this->Costinc_model->get_all(array('contract_id' => $contract->id));
            $site = $this->Site_model->get(array("contract_id" => $item->id));
            $extimes = $this->Extime_model->get_all(array('contract_id' => $contract->id));
            $main_bond = $this->Bond_model->get(array('contract_id' => $contract->id, 'teminat_gerekce' => 'contract'));
            $newprices = $this->Newprice_model->get_all(array('contract_id' => $contract->id));
            $payments = $this->Payment_model->get_all(array('contract_id' => $contract->id));
            $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "main_group" => 1), "code ASC");
            $sites = $this->Site_model->get_all(array('contract_id' => $contract->id));
            $settings = $this->Settings_model->get();
            $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "main_group" => 1));
            $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, 'leader' => 1));

            // View'e gönderilecek Değişkenlerin Set Edilmesi
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            if ($item->offer == 1) {
                $viewData->subViewFolder = "display_offer";
            } else {
                $viewData->subViewFolder = "display";
            }

            $viewData->companys = $companys;
            $viewData->project = $project;
            $viewData->upload_function = $upload_function;
            $viewData->path = $path;
            $viewData->advances = $advances;
            $viewData->collections = $collections;
            $viewData->site = $site;
            $viewData->bonds = $bonds;
            $viewData->leaders = $leaders;
            $viewData->costincs = $costincs;
            $viewData->extimes = $extimes;
            $viewData->fav = $fav;
            $viewData->main_bond = $main_bond;
            $viewData->main_groups = $main_groups;
            $viewData->newprices = $newprices;
            $viewData->form_error = true;
            $viewData->payment_no = $payment_no;
            $viewData->payments = $payments;
            $viewData->prices_main_groups = $prices_main_groups;
            $viewData->settings = $settings;
            $viewData->sites = $sites;
            $viewData->active_module = "Advance";


            $form_errors = $this->session->flashdata('form_errors');

            if (!empty($form_errors)) {
                $viewData->form_errors = $form_errors;
            } else {
                $viewData->form_errors = null;

            }

            $viewData->item = $item;

            $this->load->view("{$viewData->viewModule}/contract_v/display/index", $viewData);
        }
    }

    public function update($id)
    {

        $this->load->library("form_validation");

        $contract_id = contract_id_module("advance", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $contract_id = contract_id_module("advance", $id);
        $contract_price = get_from_id("contract", "sozlesme_bedel", $contract_id);

        $sozlesme_tarihi = dateFormat('d-m-Y', get_from_any("contract", "sozlesme_tarih", "id", "$contract_id"));


        $this->form_validation->set_rules("avans_tarih", "Avans Tarihi", "required|trim");
        $this->form_validation->set_rules("avans_tarih", "Avans Tarihi", "callback_contract_advanceday[$sozlesme_tarihi]|required|trim");
        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "less_than_equal_to[$contract_price]|numeric|required|trim");
        } else {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "contract_advanceday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
                "is_natural_no_zero" => "<b>{field}</b> alanı '0' dan farklı bir tamsayı olmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("avans_tarih")) {
                $avans_tarihi = dateFormat('Y-m-d', $this->input->post("avans_tarih"));
            } else {
                $avans_tarihi = null;
            }

            $update = $this->Advance_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "avans_tarih" => $avans_tarihi,
                    "avans_miktar" => $this->input->post("avans_miktar"),
                    "aciklama" => $this->input->post("aciklama"),
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


            $viewData = new stdClass();
            $contract_id = contract_id_module("advance", $id);
            $project_id = project_id_cont("$contract_id");
            $settings = $this->Settings_model->get();

            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Advance_model->get(
                array(
                    "id" => $id,
                )
            );

            
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->form_error = true;
            $viewData->item = $item;
            $viewData->contract_id = $contract_id;
            $viewData->project_id = $project_id;
            $viewData->settings = $settings;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {
        //Bağlı teminat silme işlemleri
        $contract_id = contract_id_module("advance", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);

        $bond_id = get_from_any_and("bond", "contract_id", $contract_id, "teminat_avans_id", $id);

        if (!empty($bond_id)) {

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

        $file_order_id = get_from_any_and("file_order", "connected_module_id", $id, "module", $this->Module_Name);
        $advance_code = get_from_id("advance", "dosya_no", $id);

        $advance_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Advance/$advance_code/";

        $sil_advance = deleteDirectory($advance_path);

        if ($sil_advance) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>Hata Oluştu';
        }

        $update_file_order = $this->Order_model->update(
            array("id" => $file_order_id),
            array("deletedAt" => date("Y-m-d H:i:s"),
                "deletedBy" => active_user_id(),
            )
        );

        $delete_advance = $this->Advance_model->delete(
            array("id" => $id)
        );

        // TODO Alert Sistemi Eklenecek...
        if ($update_file_order and $delete_advance_file and $delete_advance) {

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

        $contract_id = contract_id_module("advance", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $advance_code = get_from_id("advance", "dosya_no", $id);


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$contract_code/advance/$advance_code";
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



    }

    public function download_all($advance_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $contract_id = get_from_id("advance", "contract_id", "$advance_id");
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $Advance_code = get_from_id("advance", "dosya_no", "$advance_id");
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $contract_name = contract_name($contract_id);

        $path = "uploads/project_v/$project_code/$contract_code/Advance/$Advance_code";

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $contract_name . "-" . $Advance_code;
        $this->zip->download("$zip_name");

    }



    public function duplicate_code_check($file_name)
    {
        $file_name = "AV-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function contract_advanceday($advance_day, $contract_day)
    {
        $date_diff = date_minus($advance_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
