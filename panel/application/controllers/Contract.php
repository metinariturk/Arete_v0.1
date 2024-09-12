<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;


class Contract extends CI_Controller
{
    public $viewFolder = "";

    public $moduleFolder = "";

    public function __construct()
    {
        parent::__construct();

        // Kullanıcı girişi kontrolü
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
        $this->Theme_mode = get_active_user()->mode;

        $uploader = APPPATH . 'libraries/FileUploader.php';
        include($uploader);

        // Geçici şifre kontrolü
        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        // Modül ve görünüm klasörleri tanımlamaları
        $this->moduleFolder = "contract_module";
        $this->viewFolder = "contract_v";

        // Modelleri yükleme
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

        // Modül bilgileri
        $this->Module_Name = "Contract";
        $this->Module_Title = "Sözleşme";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "main";
        $this->Module_File_Dir = "contract";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        $this->Dependet_id_key = "contract_id";
        $this->Module_Parent_Name = "project";

        // Klasör yapıları
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->Display_offer_Folder = "display_offer";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";

        $this->Common_Files = "common";

        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";

        // Ayarları al
        $this->Settings = get_settings();
    }

    public function index()
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Contract_model->get_all(array(
            "isActive" => 1,
            "parent >" => 0,
            "offer" => 0
        ), "sozlesme_tarih DESC");

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list_contract";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function add_contract_price($sub_group_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $this->load->model("Boq_model");


        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $sub_group = $this->Contract_price_model->get(array("id" => $sub_group_id));
        $main_group = $this->Contract_price_model->get(array("id" => $sub_group->parent));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $sub_group->contract_id, 'leader' => 1));
        $contract = $this->Contract_model->get(array('id' => $sub_group->contract_id));


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_contract_price";
        $viewData->sub_group = $sub_group;
        $viewData->main_group = $main_group;
        $viewData->contract = $contract;
        $viewData->leaders = $leaders;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function offer_list()
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Contract_model->get_all(array(
            "isActive" => 1,
            "offer" => 1
        ));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list_offer";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function contract_sub()
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Contract_model->get_all(array(
            "isActive" => 1,
            "parent" => 0,
            "offer" => null,
        ), "id DESC");

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list_sub";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function select()
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Contract_model->get_all(array(
            "isActive" => 1
        ));
        $active_projects = $this->Project_model->get_all(array(
            "isActive" => default_table()
        ));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Select_Folder";
        $viewData->items = $items;
        $viewData->active_projects = $active_projects;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function file_form($id = null, $active_module = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $item = $this->Contract_model->get(array("id" => $id));
        $upload_function = base_url("$this->Module_Name/file_upload/$item->id");
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Contract/";
        $collection_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Collection";
        $advance_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Advance";
        $offer_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Offer";
        $payment_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Payment";

        $companys = $this->Company_model->get_all(array());

        !is_dir($path) && mkdir($path, 0777, TRUE);
        !is_dir($collection_path) && mkdir($collection_path, 0777, TRUE);
        !is_dir($advance_path) && mkdir($advance_path, 0777, TRUE);
        !is_dir($offer_path) && mkdir($offer_path, 0777, TRUE);
        !is_dir($payment_path) && mkdir($payment_path, 0777, TRUE);


        if ($item->offer == 1) {
            redirect(base_url("contract/file_form_offer/$id"));
        }

        $fav = $this->Favorite_model->get(array(
            "user_id" => active_user_id(),
            "module" => "contract",
            "view" => "file_form",
            "module_id" => $id,
        ));

        $viewData = new stdClass();

        $collections = $this->Collection_model->get_all(array('contract_id' => $id), "tahsilat_tarih ASC");
        $advances = $this->Advance_model->get_all(array('contract_id' => $id));
        $bonds = $this->Bond_model->get_all(array('contract_id' => $id));
        $costincs = $this->Costinc_model->get_all(array('contract_id' => $id));
        $extimes = $this->Extime_model->get_all(array('contract_id' => $id));
        $main_bond = $this->Bond_model->get(array('contract_id' => $id, 'teminat_gerekce' => 'contract'));
        $newprices = $this->Newprice_model->get_all(array('contract_id' => $id));
        $payments = $this->Payment_model->get_all(array('contract_id' => $id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1), "rank ASC");
        $sites = $this->Site_model->get_all(array('contract_id' => $id));
        $settings = $this->Settings_model->get();
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $id, 'leader' => 1));

        // View'e gönderilecek Değişkenlerin Set Edilmesi
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->companys = $companys;
        $viewData->project = $project;
        $viewData->upload_function = $upload_function;
        $viewData->path = $path;
        $viewData->advances = $advances;
        $viewData->collections = $collections;
        $viewData->bonds = $bonds;
        $viewData->leaders = $leaders;
        $viewData->costincs = $costincs;
        $viewData->extimes = $extimes;
        $viewData->fav = $fav;
        $viewData->main_bond = $main_bond;
        $viewData->main_groups = $main_groups;
        $viewData->newprices = $newprices;
        $viewData->payments = $payments;
        $viewData->prices_main_groups = $prices_main_groups;
        $viewData->settings = $settings;
        $viewData->form_error = null;
        $viewData->sites = $sites;
        $viewData->active_module = $active_module;

        $form_errors = $this->session->flashdata('form_errors');

        if (!empty($form_errors)) {
            $viewData->form_errors = $form_errors;
        } else {
            $viewData->form_errors = null;
        }

        $viewData->item = $this->Contract_model->get(array("id" => $id));

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/index", $viewData);
    }

    public function file_form_offer($id = null, $active_tab = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $item = $this->Contract_model->get(array("id" => $id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Offer/";
        $draw_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Offer/Drawings/";
        !is_dir($path) && mkdir($path, 0777, TRUE);
        !is_dir($draw_path) && mkdir($draw_path, 0777, TRUE);

        $fav = $this->Favorite_model->get(array(
            "user_id" => active_user_id(),
            "module" => "contract",
            "view" => "file_form",
            "module_id" => $id,
        ));


        $viewData = new stdClass();
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1), "rank ASC");
        $settings = $this->Settings_model->get();
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $id, 'leader' => 1));
        $form_errors = $this->session->flashdata('form_errors');

        // View'e gönderilecek Değişkenlerin Set Edilmesi
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display_offer";
        $viewData->active_tab = $active_tab;
        $viewData->form_errors = $form_errors;
        $viewData->project = $project;
        $viewData->path = $path;
        $viewData->draw_path = $draw_path;
        $viewData->leaders = $leaders;
        $viewData->fav = $fav;
        $viewData->main_groups = $main_groups;
        $viewData->prices_main_groups = $prices_main_groups;
        $viewData->settings = $settings;


        $viewData->item = $this->Contract_model->get(array("id" => $id));

        // İlgili dosya verilerini al

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form_main($project_id = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }


        //Proje yetkilisi mi diye sorgulayabiliriz


        if (empty($project_id)) {
            $project_id = $this->input->post('proje_id');
        }

        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $project = $this->Project_model->get(array("id" => $project_id));
        $settings = $this->Settings_model->get();
        $companys = $this->Company_model->get_all(array());


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_main";
        $viewData->project = $project;
        $viewData->project_id = $project_id;
        $viewData->settings = $settings;
        $viewData->companys = $companys;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        $alert = array(
            "title" => "Sözleşme",
            "text" => "Yeni Oluştur Sayfası ",
            "type" => "success"
        );

        $this->session->set_flashdata("alert", $alert);

    }

    public function new_form_sub($main_contract_id = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = project_id_cont($main_contract_id);

        //Proje yetkilisi mi diye sorgulayabiliriz


        if (empty($project_id)) {
            $project_id = $this->input->post('proje_id');
        }

        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $project = $this->Project_model->get(array("id" => $project_id));
        $settings = $this->Settings_model->get();
        $companys = $this->Company_model->get_all(array());
        $main_contract = $this->Contract_model->get(array("id" => $main_contract_id));


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_sub";
        $viewData->project = $project;
        $viewData->project_id = $project_id;
        $viewData->settings = $settings;
        $viewData->main_contract = $main_contract;
        $viewData->companys = $companys;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        $alert = array(
            "title" => "Sözleşme",
            "text" => "Yeni Oluştur Sayfası ",
            "type" => "success"
        );

        $this->session->set_flashdata("alert", $alert);

    }

    public function new_form_offer($project_id = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        if (empty($project_id)) {
            $project_id = $this->input->post('proje_id');
        }

        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $project = $this->Project_model->get(array("id" => $project_id));
        $settings = $this->Settings_model->get();
        $companys = $this->Company_model->get_all(array());


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_offer";
        $viewData->project = $project;
        $viewData->project_id = $project_id;
        $viewData->settings = $settings;
        $viewData->companys = $companys;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        $alert = array(
            "title" => "Teklif",
            "text" => "Yeni Oluştur Sayfası ",
            "type" => "success"
        );

        $this->session->set_flashdata("alert", $alert);

    }

    public function save_main($project_id = null)
    {
        // Kullanıcının admin olup olmadığını ve yetkilendirme işlemini kontrol edin
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $is_sub = $this->input->post("is_sub") == 1 ? 1 : 0;
        $is_main = $is_sub == 1 ? 0 : 1;
        $project_code = project_code($project_id);

        $file_name_len = file_name_digits();
        $file_name = "SOZ-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        // Form Validation Kuralları
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[contract.dosya_no]|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("contract_name", "Sözleşme Ad", "required|trim");

        $this->form_validation->set_rules("isveren", "İşveren", "required|trim");
        $this->form_validation->set_rules("yuklenici", "Yüklenici", "required|trim");

        $this->form_validation->set_rules("sozlesme_tarih", "Sözleşme Tarih", "required|trim");
        $this->form_validation->set_rules("sozlesme_turu", "Sözleşme Türü", "required|trim");
        $this->form_validation->set_rules("isin_turu", "İşin Türü", "required|trim");
        $this->form_validation->set_rules("isin_suresi", "İşin Süresi", "greater_than[0]|required|trim|integer");
        $this->form_validation->set_rules("sozlesme_bedel", "Sözleşme Bedel", "greater_than[0]|required|trim|numeric");
        $this->form_validation->set_rules("para_birimi", "Para Birimi", "required|trim");


        // Form Validation Hatalarını Tanımla
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük olmalıdır",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış. Sistem sıradaki dosya numarasını otomatik atamaktadır. Özel bir gerekçe yoksa değiştirmeyiniz.",
                "less_than_equal_to" => "<b>{field}</b> uygulaması seçilmelidir",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );

        // Form Validation'u Çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            // Dizin oluşturma işlemi
            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$file_name";
            !is_dir($path) && mkdir($path, 0777, TRUE);

            // Tarih ve adı biçimlendirme işlemleri
            $sozlesme_tarih = $this->input->post("sozlesme_tarih") ? dateFormat('Y-m-d', $this->input->post("sozlesme_tarih")) : null;
            $sozlesme_bitis = dateFormat('Y-m-d', date_plus_days($this->input->post("sozlesme_tarih"), $this->input->post("isin_suresi") - 1));
            $contract_name = mb_convert_case($this->input->post("contract_name"), MB_CASE_TITLE, "UTF-8");


            // Veritabanına Ekleme İşlemi
            $insert = $this->Contract_model->add(
                array(
                    "proje_id" => $project_id,
                    "dosya_no" => $file_name,
                    "contract_name" => $contract_name,
                    "isveren" => $this->input->post("isveren"),
                    "yuklenici" => $this->input->post("yuklenici"),
                    "sozlesme_tarih" => $sozlesme_tarih,
                    "sozlesme_turu" => $this->input->post("sozlesme_turu"),
                    "isin_turu" => $this->input->post("isin_turu"),
                    "isin_suresi" => $this->input->post("isin_suresi"),
                    "sozlesme_bitis" => $sozlesme_bitis,
                    "sozlesme_bedel" => $this->input->post("sozlesme_bedel"),
                    "para_birimi" => $this->input->post("para_birimi"),
                    "isActive" => "1",
                )
            );

            // Kayıt ID'sini Al
            $record_id = $this->db->insert_id();

            // İlgili Modül İçin Sipariş Ekle
            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $record_id,
                    "connected_project_id" => $record_id,
                    "file_order" => $file_name,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                )
            );

            // TODO: Alert sistemi eklenecek...

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
            // Form Validation Başarısız, hata mesajları ile birlikte görüntüyü yükle
            $viewData = new stdClass();
            $project = $this->Project_model->get(array("id" => $project_id));
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all(array());


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add_main";
            $viewData->project = $project;
            $viewData->companys = $companys;
            $viewData->settings = $settings;
            $viewData->project_id = $project_id;
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function save_sub($main_contract_id = null)
    {
        // Kullanıcının admin olup olmadığını ve yetkilendirme işlemini kontrol edin
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $main_contract = $this->Contract_model->get(array('id' => $main_contract_id));

        $project_id = project_id_cont($main_contract_id);
        $project_code = project_code($project_id);

        $file_name_len = file_name_digits();
        $file_name = "SOZ-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        // Form Validation Kuralları
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[contract.dosya_no]|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("contract_name", "Sözleşme Ad", "required|trim");

        $this->form_validation->set_rules("isveren", "İşveren", "required|trim");
        $this->form_validation->set_rules("yuklenici", "Yüklenici", "required|trim");

        $this->form_validation->set_rules("sozlesme_tarih", "Sözleşme Tarih", "required|trim");
        $this->form_validation->set_rules("sozlesme_turu", "Sözleşme Türü", "required|trim");
        $this->form_validation->set_rules("isin_turu", "İşin Türü", "required|trim");
        $this->form_validation->set_rules("isin_suresi", "İşin Süresi", "greater_than[0]|required|trim|integer");
        $this->form_validation->set_rules("sozlesme_bedel", "Sözleşme Bedel", "greater_than[0]|required|trim|numeric");
        $this->form_validation->set_rules("para_birimi", "Para Birimi", "required|trim");


        // Form Validation Hatalarını Tanımla
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük olmalıdır",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış. Sistem sıradaki dosya numarasını otomatik atamaktadır. Özel bir gerekçe yoksa değiştirmeyiniz.",
                "less_than_equal_to" => "<b>{field}</b> uygulaması seçilmelidir",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );

        // Form Validation'u Çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            // Dizin oluşturma işlemi
            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$file_name";
            !is_dir($path) && mkdir($path, 0777, TRUE);

            // Tarih ve adı biçimlendirme işlemleri
            $sozlesme_tarih = $this->input->post("sozlesme_tarih") ? dateFormat('Y-m-d', $this->input->post("sozlesme_tarih")) : null;
            $sozlesme_bitis = dateFormat('Y-m-d', date_plus_days($this->input->post("sozlesme_tarih"), $this->input->post("isin_suresi") - 1));
            $contract_name = mb_convert_case($this->input->post("contract_name"), MB_CASE_TITLE, "UTF-8");

            // Veritabanına Ekleme İşlemi
            $insert = $this->Contract_model->add(
                array(
                    "proje_id" => $project_id,
                    "dosya_no" => $file_name,
                    "contract_name" => $contract_name,
                    "isveren" => $main_contract->yuklenici,
                    "yuklenici" => $this->input->post("yuklenici"),
                    "sozlesme_tarih" => $sozlesme_tarih,
                    "sozlesme_turu" => $this->input->post("sozlesme_turu"),
                    "isin_turu" => $this->input->post("isin_turu"),
                    "isin_suresi" => $this->input->post("isin_suresi"),
                    "sozlesme_bitis" => $sozlesme_bitis,
                    "sozlesme_bedel" => $this->input->post("sozlesme_bedel"),
                    "para_birimi" => $this->input->post("para_birimi"),
                    "parent" => $main_contract_id,
                    "isActive" => "1",
                )
            );

            // Kayıt ID'sini Al
            $record_id = $this->db->insert_id();

            // İlgili Modül İçin Sipariş Ekle
            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $record_id,
                    "connected_project_id" => $record_id,
                    "file_order" => $file_name,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                )
            );

            // TODO: Alert sistemi eklenecek...

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
            // Form Validation Başarısız, hata mesajları ile birlikte görüntüyü yükle
            $viewData = new stdClass();
            $main_contract = $this->Contract_model->get(array("id" => $main_contract_id));

            $project = $this->Project_model->get(array("id" => $project_id));
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all(array());

            $viewData->main_contract = $main_contract;
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add_sub";
            $viewData->project = $project;
            $viewData->companys = $companys;
            $viewData->settings = $settings;
            $viewData->project_id = $project_id;
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function save_offer($project_id = null)
    {
        // Kullanıcının admin olup olmadığını ve yetkilendirme işlemini kontrol edin
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $is_sub = $this->input->post("is_sub") == 1 ? 1 : 0;
        $is_main = $is_sub == 1 ? 0 : 1;
        $project_code = project_code($project_id);

        $file_name_len = file_name_digits();
        $file_name = "SOZ-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        // Form Validation Kuralları
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[contract.dosya_no]|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("contract_name", "Sözleşme Ad", "required|trim");

        $this->form_validation->set_rules("isveren", "İşveren", "required|trim");
        $this->form_validation->set_rules("yuklenici", "Yüklenici", "required|trim");

        $this->form_validation->set_rules("sozlesme_turu", "Sözleşme Türü", "required|trim");
        $this->form_validation->set_rules("isin_turu", "İşin Türü", "required|trim");
        $this->form_validation->set_rules("para_birimi", "Para Birimi", "required|trim");


        // Form Validation Hatalarını Tanımla
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük olmalıdır",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış. Sistem sıradaki dosya numarasını otomatik atamaktadır. Özel bir gerekçe yoksa değiştirmeyiniz.",
                "less_than_equal_to" => "<b>{field}</b> uygulaması seçilmelidir",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );

        // Form Validation'u Çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            // Dizin oluşturma işlemi
            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$file_name";
            !is_dir($path) && mkdir($path, 0777, TRUE);

            // Tarih ve adı biçimlendirme işlemleri
            $sozlesme_tarih = $this->input->post("sozlesme_tarih") ? dateFormat('Y-m-d', $this->input->post("sozlesme_tarih")) : null;
            $sozlesme_bitis = dateFormat('Y-m-d', date_plus_days($this->input->post("sozlesme_tarih"), $this->input->post("isin_suresi") - 1));
            $contract_name = mb_convert_case($this->input->post("contract_name"), MB_CASE_TITLE, "UTF-8");


            // Veritabanına Ekleme İşlemi
            $insert = $this->Contract_model->add(
                array(
                    "proje_id" => $project_id,
                    "dosya_no" => $file_name,
                    "contract_name" => $contract_name,
                    "isveren" => $this->input->post("isveren"),
                    "yuklenici" => $this->input->post("yuklenici"),
                    "sozlesme_tarih" => $sozlesme_tarih,
                    "sozlesme_turu" => $this->input->post("sozlesme_turu"),
                    "isin_turu" => $this->input->post("isin_turu"),
                    "para_birimi" => $this->input->post("para_birimi"),
                    "isActive" => 1,
                    "offer" => 1,
                )
            );

            // Kayıt ID'sini Al
            $record_id = $this->db->insert_id();

            // İlgili Modül İçin Sipariş Ekle
            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $record_id,
                    "connected_project_id" => $record_id,
                    "file_order" => $file_name,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                )
            );

            // TODO: Alert sistemi eklenecek...

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
            // Form Validation Başarısız, hata mesajları ile birlikte görüntüyü yükle
            $viewData = new stdClass();
            $project = $this->Project_model->get(array("id" => $project_id));
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all(array());

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add_offer";
            $viewData->project = $project;
            $viewData->companys = $companys;
            $viewData->settings = $settings;
            $viewData->project_id = $project_id;
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update($id, $active_module = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $this->load->library("form_validation");

        $this->form_validation->set_rules("contract_name", "Sözleşme Ad", "required|trim");

        $this->form_validation->set_rules("sozlesme_tarih", "Sözleşme Tarih", "required|trim");
        $this->form_validation->set_rules("sozlesme_turu", "Sözleşme Türü", "required|trim");
        $this->form_validation->set_rules("isin_turu", "İşin Türü", "required|trim");
        $this->form_validation->set_rules("isin_suresi", "İşin Süresi", "greater_than[0]|required|trim|integer");
        $this->form_validation->set_rules("sozlesme_bedel", "Sözleşme Bedel", "greater_than[0]|required|trim|numeric");
        $this->form_validation->set_rules("para_birimi", "Para Birimi", "required|trim");


        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük olmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("sozlesme_tarih")) {
                $sozlesme_tarih = dateFormat('Y-m-d', $this->input->post("sozlesme_tarih"));
                $sozlesme_bitis = dateFormat('Y-m-d', (date_plus_days($this->input->post("sozlesme_tarih"), ($this->input->post("isin_suresi") - 1))));
            } else {
                $sozlesme_tarih = null;
                $sozlesme_bitis = null;
            }

            if ($this->input->post("sitedel_date")) {
                $yerteslim_tarih = dateFormat('Y-m-d', $this->input->post("sitedel_date"));
                $sozlesme_bitis = dateFormat('Y-m-d', (date_plus_days($this->input->post("sitedel_date"), ($this->input->post("isin_suresi") - 1))));
            } else {
                $yerteslim_tarih = null;
            }


            $contract_name = mb_convert_case($this->input->post("contract_name"), MB_CASE_TITLE, "UTF-8");

            $update = $this->Contract_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "contract_name" => $contract_name,
                    "isveren" => $this->input->post("isveren"),
                    "yuklenici" => $this->input->post("yuklenici"),

                    "sozlesme_tarih" => $sozlesme_tarih,
                    "sozlesme_turu" => $this->input->post("sozlesme_turu"),
                    "isin_turu" => $this->input->post("isin_turu"),
                    "isin_suresi" => $this->input->post("isin_suresi"),
                    "sozlesme_bitis" => $sozlesme_bitis,
                    "sozlesme_bedel" => $this->input->post("sozlesme_bedel"),
                    "para_birimi" => $this->input->post("para_birimi"),

                    "isActive" => "1",
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

            if (!isAdmin()) {
                redirect(base_url("error"));
            }

            $item = $this->Contract_model->get(array("id" => $id));
            $upload_function = base_url("$this->Module_Name/file_upload/$item->id");
            $project = $this->Project_model->get(array("id" => $item->proje_id));
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Contract/";
            $collection_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Collection";
            $advance_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Advance";
            $offer_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Offer";
            $payment_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Payment";

            $companys = $this->Company_model->get_all(array());

            !is_dir($path) && mkdir($path, 0777, TRUE);
            !is_dir($collection_path) && mkdir($collection_path, 0777, TRUE);
            !is_dir($advance_path) && mkdir($advance_path, 0777, TRUE);
            !is_dir($offer_path) && mkdir($offer_path, 0777, TRUE);
            !is_dir($payment_path) && mkdir($payment_path, 0777, TRUE);


            if ($item->offer == 1) {
                redirect(base_url("contract/file_form_offer/$id"));
            }


            if (count_payments($id) == 0) {
                $payment_no = 1;
            } else {
                $payment_no = last_payment($id) + 1;
            }

            $fav = $this->Favorite_model->get(array(
                "user_id" => active_user_id(),
                "module" => "contract",
                "view" => "file_form",
                "module_id" => $id,
            ));


            $viewData = new stdClass();

            $collections = $this->Collection_model->get_all(array('contract_id' => $id), "tahsilat_tarih ASC");
            $advances = $this->Advance_model->get_all(array('contract_id' => $id));
            $bonds = $this->Bond_model->get_all(array('contract_id' => $id));
            $costincs = $this->Costinc_model->get_all(array('contract_id' => $id));
            $extimes = $this->Extime_model->get_all(array('contract_id' => $id));
            $main_bond = $this->Bond_model->get(array('contract_id' => $id, 'teminat_gerekce' => 'contract'));
            $newprices = $this->Newprice_model->get_all(array('contract_id' => $id));
            $payments = $this->Payment_model->get_all(array('contract_id' => $id));
            $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1), "rank ASC");
            $sites = $this->Site_model->get_all(array('contract_id' => $id));
            $settings = $this->Settings_model->get();
            $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1));
            $leaders = $this->Contract_price_model->get_all(array('contract_id' => $id, 'leader' => 1));

            // View'e gönderilecek Değişkenlerin Set Edilmesi
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Display_Folder";
            $viewData->companys = $companys;
            $viewData->project = $project;
            $viewData->upload_function = $upload_function;
            $viewData->path = $path;
            $viewData->advances = $advances;
            $viewData->collections = $collections;
            $viewData->bonds = $bonds;
            $viewData->leaders = $leaders;
            $viewData->costincs = $costincs;
            $viewData->extimes = $extimes;
            $viewData->fav = $fav;
            $viewData->main_bond = $main_bond;
            $viewData->main_groups = $main_groups;
            $viewData->newprices = $newprices;
            $viewData->payment_no = $payment_no;
            $viewData->payments = $payments;
            $viewData->prices_main_groups = $prices_main_groups;
            $viewData->settings = $settings;
            $viewData->sites = $sites;
            $viewData->form_error = true;
            $viewData->active_module = "Update";


            $form_errors = $this->session->flashdata('form_errors');

            if (!empty($form_errors)) {
                $viewData->form_errors = $form_errors;
            } else {
                $viewData->form_errors = null;
            }

            $viewData->item = $this->Contract_model->get(array("id" => $id));


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update_payment_form($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        $settings = $this->Settings_model->get();

        $contract = $this->Contract_model->get(array(
            "id" => $id
        ));

        $payments = $this->Payment_model->get_all(array('contract_id' => $id));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update_payment";
        $viewData->settings = $settings;
        $viewData->payments = $payments;
        $viewData->contract = $contract;

        $viewData->item = $this->Contract_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function sitedel_date($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $sozlesme_tarihi = dateFormat('d-m-Y', get_from_any("contract", "sozlesme_tarih", "id", "$id"));

        $isin_suresi = get_from_any("contract", "isin_suresi", "id", "$id");

        $this->load->library("form_validation");

        $this->form_validation->set_rules("teslim_tarihi", "Teslim Tarihi", "callback_sitedel_contractday[$sozlesme_tarihi]|required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );


        $validate = $this->form_validation->run();

        if ($validate) {

            $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarihi"));

            $sozlesme_bitis = dateFormat('Y-m-d', (date_plus_days($teslim_tarihi, ($isin_suresi - 1))));


            $update = $this->Contract_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "sitedel_date" => $teslim_tarihi,
                    "sozlesme_bitis" => $sozlesme_bitis,
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
            redirect(base_url("$this->Module_Name/file_form/$id/sitedel"));

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Yer Teslim Tarihi,$sozlesme_tarihi olan Sözleşme Tarihinden Önce Olamaz",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("$this->Module_Name/file_form/$id/sitedel/error"));

        }
    }

    public function delete_form($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $contract = $this->Contract_model->get(array("id" => $id));

        $advances = $this->Advance_model->get_all(array('contract_id' => $id));
        $bonds = $this->Bond_model->get_all(array('contract_id' => $id));
        $costincs = $this->Costinc_model->get_all(array('contract_id' => $id));
        $collections = $this->Collection_model->get_all(array('contract_id' => $id));
        $extimes = $this->Extime_model->get_all(array('contract_id' => $id));
        $newprices = $this->Newprice_model->get_all(array('contract_id' => $id));
        $payments = $this->Payment_model->get_all(array('contract_id' => $id));

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "delete_form";
        $viewData->contract = $contract;
        $viewData->advances = $advances;
        $viewData->bonds = $bonds;
        $viewData->costincs = $costincs;
        $viewData->collections = $collections;
        $viewData->extimes = $extimes;
        $viewData->newprices = $newprices;
        $viewData->payments = $payments;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function delete($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = get_from_id("contract", "proje_id", $id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $id);

        $file_ids = array();


        if (!empty($file_ids)) {

            $viewData = new stdClass();

            if (isset($error_log)) {
                $update_error = $this->Delete_model->update(
                    array(
                        "id" => $error_log->id
                    ),
                    array(
                        "error_list" => json_encode($file_ids),
                    )
                );

            } else {
                $add_error = $this->Delete_model->add(
                    array(
                        "module_name" => "Contract",
                        "module_id" => "$id",
                        "error_list" => json_encode($file_ids)
                    )
                );
            }

            $delete_error_id = get_from_any_and("delete_error", "module_name", "Contract", "module_id", $id);

            redirect(base_url("Contract/delete_form/$delete_error_id"));

        } else {
            $viewData = new stdClass();

            $viewData->item = $this->Delete_model->delete(
                array(
                    "id" => $error_log->id
                )
            );

            $delete_contract = $this->Contract_model->delete(array("id" => $id));

            $this->Favorite_model->delete(
                array(
                    "module" => "contract",
                    "module_id" => $id,
                    "user_id" => active_user_id()
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

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code";

            $sil = deleteDirectory($path);


            if ($sil) {
                echo '<br>deleted successfully';
            } else {
                echo '<br>errors occured';
            }

            if ($delete_contract) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Teklif tüm alt süreçleri ile birlikte, başarılı bir şekilde silindi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Teklif silme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Parent_Name/$this->Display_route/$project_id"));
        }
    }

    public function hard_delete($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = get_from_id("contract", "proje_id", $id);
        $project_code = project_code($project_id);
        $sub_folder = get_from_id("contract", "dosya_no", $id);

        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$sub_folder";
        $sil = deleteDirectory($path);

        $delete_module_list = array("Advance_model", "Bond_model", "Costinc_model", "Extime_model", "Payment_model", "Payment_settings_model", "Payment_sign_model", "Newprice_model", "Boq_model", "Collection_model");
        foreach ($delete_module_list as $module) {
            $delete = $this->$module->delete(
                array(
                    "contract_id" => $id
                )
            );
        }

        $delete_contract = $this->Contract_model->delete(array("id" => $id));

        $this->Favorite_model->delete(
            array(
                "module" => "contract",
                "module_id" => $id
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

        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        if ($delete_contract) {
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Sözleşme tüm alt işleri ile birlikte, başarılı bir şekilde silindi",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Sözleşme silme sırasında bir problem oluştu",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("$this->Module_Parent_Name/$this->Display_route/$project_id"));
    }

    public function file_upload($id, $type = null)
    {
        $contract = $this->Contract_model->get(array("id" => $id));
        if ($contract->offer == 1) {
            $type = "Offer";
        } else {
            $type = "Contract";
        }
        $contract_code = contract_code($contract->id);
        $project_id = project_id_cont($contract->id);
        $project_code = project_code($project_id);
        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/$type/";

        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }


        $FileUploader = new FileUploader('files', array(
            'limit' => null,
            'maxSize' => null,
            'extensions' => null,
            'uploadDir' => $path,
            'title' => 'name'
        ));

        // call to upload the files

        $uploadedFiles = $FileUploader->upload();

        $files = ($uploadedFiles['files']);

        if ($uploadedFiles['isSuccess'] && count($uploadedFiles['files']) > 0) {
            // Yüklenen dosyaları işleyin
            foreach ($uploadedFiles['files'] as $file) {
                // Dosya boyutunu kontrol edin ve yeniden boyutlandırma işlemlerini gerçekleştirin
                if ($file['size'] > 2097152) {
                    // Yeniden boyutlandırma işlemi için uygun genişlik ve yükseklik değerlerini belirleyin
                    $newWidth = null; // Örnek olarak 500 piksel genişlik
                    $newHeight = 1080; // Yüksekliği belirtmediğiniz takdirde orijinal oran korunur

                    // Yeniden boyutlandırma işlemi
                    FileUploader::resize($path . $file['name'], $newWidth, $newHeight, $destination = null, $crop = false, $quality = 75);
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($uploadedFiles);
        exit;
    }

    public function file_upload_drawings($id)
    {
        $contract = $this->Contract_model->get(array("id" => $id));
        $contract_code = contract_code($contract->id);
        $project_id = project_id_cont($contract->id);
        $project_code = project_code($project_id);
        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/Offer/Drawings";

        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }


        $FileUploader = new FileUploader('files', array(
            'limit' => null,
            'maxSize' => null,
            'extensions' => null,
            'uploadDir' => $path,
            'title' => 'name'
        ));

        // call to upload the files

        $offer_drawings = $FileUploader->upload();

        $files = ($offer_drawings['files']);

        if ($offer_drawings['isSuccess'] && count($offer_drawings['files']) > 0) {
            // Yüklenen dosyaları işleyin
            foreach ($offer_drawings['files'] as $file) {
                // Dosya boyutunu kontrol edin ve yeniden boyutlandırma işlemlerini gerçekleştirin
                if ($file['size'] > 2097152) {
                    // Yeniden boyutlandırma işlemi için uygun genişlik ve yükseklik değerlerini belirleyin
                    $newWidth = null; // Örnek olarak 500 piksel genişlik
                    $newHeight = 1080; // Yüksekliği belirtmediğiniz takdirde orijinal oran korunur

                    // Yeniden boyutlandırma işlemi
                    FileUploader::resize($path . $file['name'], $newWidth, $newHeight, $destination = null, $crop = false, $quality = 75);
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($offer_drawings);
        exit;
    }

    public function fileDelete_java($id)
    {

        $fileName = $this->input->post('fileName');

        $contract = $this->Contract_model->get(array("id" => $id));
        $project = $this->Project_model->get(array("id" => $contract->proje_id));

        if ($contract->offer == 1) {
            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/$contract->dosya_no/Offer/";
        } else {
            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/$contract->dosya_no/Contract/";
        }

        unlink("$path/$fileName");
    }

    public function download_all($cont_id, $where = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $project_id = get_from_id("contract", "proje_id", $cont_id);
        $project_code = project_code($project_id);
        $cont_code = get_from_id("contract", "dosya_no", $cont_id);
        $cont_name = get_from_id("contract", "contract_name", $cont_id);

        $path = "uploads/project_v/$project_code/$cont_code/$where";

        $where_types =
            array(
                'Genel' => 'Contract',
                'Yer_Teslimi' => 'sitedel',
                'İş Programı' => 'workplan',
                'Geçici Kabul' => 'provision',
                'Kesin Kabul' => 'final',
            );

        $ext = array_search($where, $where_types);

        $files = glob($path . '/*');
        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $cont_name . "_" . $ext;
        $this->zip->download("$zip_name");

    }

    public function download_backup($cont_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $this->load->library('zip');
        $this->zip->compression_level = 1;

        $contract = $this->Contract_model->get(array("id" => $cont_id));
        $project_code = project_code($contract->proje_id);

        $path = FCPATH . "uploads/project_v/$project_code/$contract->dosya_no/";

        $this->zip->read_dir($path, FALSE);

        $zip_name = $contract->contract_name . "_Backup.zip";

        $this->zip->download($zip_name);
    }

    public function get_district($id)
    {
        $result = $this->db->where("city_id", $id)->get("district")->result();
        echo json_encode($result);
    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "SOZ-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function sitedel_contractday($sitedal_day, $contract_day)
    {
        $date_diff = date_minus($sitedal_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function favorite($id)
    {
        $fav_id = get_from_any_and_and("favorite", "module", "contract", "user_id", active_user_id(), "module_id", "$id");
        if (!empty($fav_id)) {
            $this->Favorite_model->delete(
                array(
                    "id" => $fav_id
                )
            );
            echo "favoriden çıktı";
        } else {

            $insert = $this->Favorite_model->add(
                array(
                    "module" => "contract",
                    "view" => "file_form",
                    "module_id" => $id,
                    "user_id" => active_user_id(),
                    "title" => contract_code($id) . " - " . contract_name($id)
                )
            );
            echo "favoriye eklendi";
        }
    }

    public function add_main_group($contract_id)
    {
        $group_name = $this->input->post('main_group');
        $group_code = $this->input->post('main_code');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("main_group", "Grup Kodu", "min_length[3]|max_length[30]|required|trim");
        $this->form_validation->set_rules("main_code", "Grup Kodu", "min_length[1]|max_length[3]|required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "max_length" => "<b>{field}</b> en fazla <b>{param}</b> karakter uzunluğunda olmalıdır",
                "min_length" => "<b>{field}</b> en az <b>{param}</b> karakter uzunluğunda olmalıdır",
                "alpha_numeric" => "<b>{field}</b> geçersiz karakter içeriyor üğişçö gibi",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {
            $insert = $this->Contract_price_model->add(
                array(
                    "contract_id" => $contract_id,
                    "main_group" => 1,
                    "name" => upper_tr($group_name),
                    "code" => $group_code,
                )
            );

            $item = $this->Contract_model->get(array("id" => $contract_id));

            $criteria = array(
                'isActive' => 1,  // isActive özelliğine göre büyükten küçüğe sırala
            );

            $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->item = $item;

            $viewData->main_groups = $main_groups;
            $viewData->sub_groups = $sub_groups;

        } else {

            $item = $this->Contract_model->get(array("id" => $contract_id));
            $criteria = array(
                'isActive' => 1,  // isActive özelliğine göre büyükten küçüğe sırala
            );


            $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->item = $item;
            $viewData->main_groups = $main_groups;
            $viewData->sub_groups = $sub_groups;
            $viewData->form_error = true;

        }

        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_7_price_group", $viewData, true);

        echo $render_boq;

    }

    public function back_main($contract_id)
    {

        $item = $this->Contract_model->get(array('id' => $contract_id));
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $item;

        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;


        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/modules/contract_group", $viewData, true);
        echo $render_boq;

    }

    public function update_sub_group($contract_id)
    {

        $groups = $this->input->post("groups[]");

        $filtered_boqs = array_filter($groups, function ($value) {
            return !empty($value['code']) || !empty($value['name']);
        });

        foreach ($filtered_boqs as $boq_id => $values) {
            if (isset($values['id'])) {
                $update = $this->Contract_price_model->update(
                    array(
                        "id" => $values['id']
                    ),
                    array(
                        "code" => $values['code'],
                        "name" => $values['name'],
                    ));
            }

            if ($boq_id == "new_main") {
                $insert = $this->Contract_price_model->add(
                    array(
                        "contract_id" => $contract_id,
                        "main_group" => 1,
                        "code" => $values['code'],
                        "name" => $values['name'],
                    )
                );
            }
            if (isset($values['new_sub'])) {
                if (!empty($values['new_sub']['code'] || !empty($values['new_sub']['name']))) {
                    $insert = $this->Contract_price_model->add(
                        array(
                            "contract_id" => $contract_id,
                            "parent" => $values['new_sub']['main_id'],
                            "sub_group" => 1,
                            "code" => $values['new_sub']['code'],
                            "name" => $values['new_sub']['name'],
                        )
                    );
                }
            }


        }

        $item = $this->Contract_model->get(array("id" => $contract_id));

        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));


        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $item;
        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;

        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_7_price_group", $viewData, true);

        echo $render_boq;

    }

    public function delete_group($group_id)
    {
        $group = $this->Contract_price_model->get(array("id" => $group_id));

        $delete = $this->Contract_price_model->delete(
            array(
                "id" => $group_id,
            )
        );

        $item = $this->Contract_model->get(array("id" => $group->contract_id));

        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $group->contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $group->contract_id, "sub_group" => 1));


        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $item;
        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;

        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_7_price_group", $viewData, true);
        echo $render_boq;

    }

    public function add_leader($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $this->load->library("form_validation");
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));

        // Form Validation Kuralları
        $this->form_validation->set_rules("leader_code", "İmalat Kodu", "required|trim");
        $this->form_validation->set_rules("leader_name", "İmalat Adı", "required|trim");
        $this->form_validation->set_rules("leader_unit", "İmalat Birim", "required|trim");
        $this->form_validation->set_rules("leader_price", "Fiyat", "required|trim");


        // Form Validation Hatalarını Tanımla
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );


        $validate = $this->form_validation->run();

        if ($validate) {

            // Form verilerini doğru şekilde alma
            $leader_code = $this->input->post('leader_code');
            $leader_name = $this->input->post('leader_name');
            $leader_unit = $this->input->post('leader_unit');
            $leader_price = $this->input->post('leader_price');

            // Lider bilgilerini ekleyin
            $update = $this->Contract_price_model->add(
                array(
                    "contract_id" => $contract_id,
                    "code" => $leader_code,
                    "name" => $leader_name,
                    "unit" => $leader_unit,
                    "price" => $leader_price,
                    "leader" => 1,
                )
            );

            $item = $this->Contract_model->get(array("id" => $contract_id));
            $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));

            $viewData = new stdClass();
            $viewData->leaders = $leaders;

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->viewModule = $this->moduleFolder;
            $viewData->subViewFolder = "display";
            $viewData->item = $item;
            $viewData->main_groups = $main_groups;


            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_8_price_book", $viewData, true);
            echo $render_html;

        } else {

            $item = $this->Contract_model->get(array("id" => $contract_id));
            $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));

            $viewData = new stdClass();
            $viewData->leaders = $leaders;

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->viewModule = $this->moduleFolder;

            $viewData->subViewFolder = "display";
            $viewData->item = $item;
            $viewData->main_groups = $main_groups;
            $viewData->form_error = true;

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_8_price_book", $viewData, true);
            echo $render_html;

        }
    }

    public
    function update_leader_selection()
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $this->load->model("Boq_model");

        echo $leader_id = $this->input->post('leader_id');
        echo $sub_group_id = $this->input->post('sub_group_id');
        echo $situation = $this->input->post('is_checked');

        $boq = $this->Contract_price_model->get(array("leader_id" => $leader_id, "sub_id" => $sub_group_id));
        $leader = $this->Contract_price_model->get(array("id" => $leader_id));
        $sub_group = $this->Contract_price_model->get(array("id" => $sub_group_id));
        $main_group = $this->Contract_price_model->get(array("id" => $sub_group->parent));


        if ($situation == 1) {
            $insert = $this->Contract_price_model->add(
                array(
                    "contract_id" => $sub_group->contract_id,
                    "code" => $main_group->code . "." . $sub_group->code . "." . $leader->code,
                    "sub_id" => $sub_group->id,
                    "main_id" => $main_group->id,
                    "leader_id" => $leader->id,
                    "name" => $leader->name,
                    "unit" => $leader->unit,
                    "price" => $leader->price,
                ));
        } elseif ($situation == 0) {
            $delete = $this->Contract_price_model->delete(
                array(
                    "id" => $boq->id,
                ));
            $delete_boq = $this->Boq_model->delete(
                array(
                    "boq_id" => $boq->id,
                    "contract_id" => $sub_group->contract_id,
                ));
        }


    }

    public function delete_contract_price($boq_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $this->load->model("Boq_model");

        $contract_price = $this->Contract_price_model->get(array("id" => $boq_id));

        $contract_id = $contract_price->contract_id;

        $delete = $this->Contract_price_model->delete(array("id" => $boq_id));
        $delete_leader = $this->Contract_price_model->delete(array("leader_id" => $boq_id));
        $delete_boq = $this->Boq_model->delete(array("leader_id" => $boq_id));

        // Silme işlemi başarılıysa başarılı mesajını, başarısızsa hata mesajını JSON olarak döndürelim
        if ($delete && $delete_boq && $delete_leader) {
            $alert = array(
                "status" => "success",
                "title" => "İşlem Başarılı",
                "message" => "Kayıt ve metrajlar başarılı bir şekilde silindi"
            );
        } elseif ($delete) {
            $alert = array(
                "status" => "success",
                "title" => "İşlem Başarılı",
                "message" => "Kayıt başarılı bir şekilde silindi"
            );
        } else {
            $alert = array(
                "status" => "error",
                "title" => "İşlem Başarısız",
                "message" => "Silme işlemi sırasında bir hata oluştu"
            );
        }

        // Yeniden render edilecek HTML'yi oluştur
        $item = $this->Contract_model->get(array("id" => $contract_id));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));

        $viewData = new stdClass();
        $viewData->leaders = $leaders;

        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_8_price_book", $viewData, true);
        echo $render_html;

    }

    public
    function open_sub($contract_id, $sub_id)
    {
        $sub_cont_items = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "sub_id" => $sub_id));
        $main_group = $this->Contract_price_model->get(array("contract_id" => $contract_id));
        $sub_group = $this->Contract_price_model->get(array("id" => $sub_id));
        $item = $this->Contract_model->get(array('id' => $contract_id));


        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;

        $viewData->sub_cont_items = $sub_cont_items;
        $viewData->main_group = $main_group;
        $viewData->sub_id = $sub_id;
        $viewData->sub_group = $sub_group;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/contract_group", $viewData, true);

        echo $render_html;

    }

    public
    function delete_item($contract_id, $item_id)
    {
        $item = $this->Contract_model->get(array('id' => $contract_id));
        $book_item = $this->Contract_price_model->get(array('id' => $item_id));
        $sub_group = $this->Contract_price_model->get(array('id' => $book_item->sub_id));
        $main_group = $this->Contract_price_model->get(array('id' => $sub_group->parent));

        $delete = $this->Contract_price_model->delete(
            array(
                "id" => $item_id,
            )
        );
        $sub_cont_items = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_id" => $sub_group->id));

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->main_group = $main_group;
        $viewData->sub_group = $sub_group;
        $viewData->sub_cont_items = $sub_cont_items;
        $viewData->sub_id = $sub_group->id;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/contract_group", $viewData, true);

        echo $render_html;

    }

    public
    function delete_sub($contract_id, $sub_id)
    {
        $item = $this->Contract_model->get(array("id" => $contract_id));


        $delete_sub = $this->Contract_price_model->delete(
            array(
                "contract_id" => $contract_id,
                "sub_id" => $sub_id,
            )
        );

        $delete_sub = $this->Contract_price_model->delete(
            array(
                "id" => $sub_id,
            )
        );

        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/contract_group", $viewData, true);

        echo $render_html;

    }

    public
    function delete_main($contract_id, $main_id)
    {
        $item = $this->Contract_model->get(array("id" => $contract_id));


        $delete_item = $this->Contract_price_model->delete(
            array(
                "contract_id" => $contract_id,
                "main_id" => $main_id,
            )
        );

        $delete_sub = $this->Contract_price_model->delete(
            array(
                "contract_id" => $contract_id,
                "parent" => $main_id,
            )
        );

        $delete_main = $this->Contract_price_model->delete(
            array(
                "id" => $main_id,
            )
        );

        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/contract_group", $viewData, true);

        echo $render_html;

    }

    public function upload_book_excel($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $tempFolderPath = 'uploads/temp/';

        // Temp klasör yoksa oluştur
        if (!is_dir($tempFolderPath)) {
            if (!mkdir($tempFolderPath, 0777, true)) {
                die('Temp klasör oluşturulamadı...');
            }
        }

        // Dosya yükleme
        if (!empty($_FILES['excel_file']['name'])) {
            $tempFilePath = $_FILES['excel_file']['tmp_name'];
            $targetFilePath = $tempFolderPath . $_FILES['excel_file']['name'];

            // Dosyayı yükle
            if (move_uploaded_file($tempFilePath, $targetFilePath)) {
                $workbook = IOFactory::load($targetFilePath);
                $worksheet = $workbook->getActiveSheet();

                $dataArray = array();
                $startRow = 5;
                $endRow = 1500; // 3000 satır daha eklendiğini varsayıyorum

                // Boş satır sayacını tanımlayın
                $emptyRowCount = 0;

                // Her bir satır için döngü oluşturun
                for ($row = $startRow; $row <= $endRow; $row++) {
                    // Her bir satırdaki C'den F'ye kadar olan hücrelerden veriyi alarak bir dizi oluşturun
                    $rowData = array(
                        'code' => $worksheet->getCell('C' . $row)->getValue(),
                        'name' => $worksheet->getCell('D' . $row)->getValue(),
                        'unit' => $worksheet->getCell('E' . $row)->getValue(),
                        'price' => $worksheet->getCell('F' . $row)->getValue(),
                    );

                    // Satırın boş olup olmadığını kontrol edin
                    $isEmptyRow = true;
                    foreach ($rowData as $cellValue) {
                        if (!empty($cellValue)) {
                            $isEmptyRow = false;
                            break;
                        }
                    }

                    // Eğer satır boşsa boş satır sayacını artır, aksi takdirde sıfırla
                    if ($isEmptyRow) {
                        $emptyRowCount++;
                    } else {
                        $emptyRowCount = 0;
                    }

                    // Boş satır sayacı 5 ise döngüyü durdur
                    if ($emptyRowCount >= 5) {
                        break;
                    }

                    // Eğer herhangi bir veri boşsa bu satırı atla
                    if (empty($rowData['code']) || empty($rowData['name']) || empty($rowData['unit']) || empty($rowData['price'])) {
                        continue;
                    }

                    // Oluşturulan dizi, ana diziye eklenir
                    $dataArray[] = $rowData;
                }

                // Verileri veritabanına ekleme
                foreach ($dataArray as $data) {
                    $exist_leader = $this->Contract_price_model->get(array(
                            "contract_id" => $contract_id,
                            "name" => $data['name'],
                            "unit" => $data['unit']
                        )
                    );
                    if (!$exist_leader) {
                        $insert = $this->Contract_price_model->add(
                            array(
                                "contract_id" => $contract_id,
                                "code" => $data['code'],
                                "name" => $data['name'],
                                "unit" => $data['unit'],
                                "price" => $data['price'],
                                "leader" => 1, // 'leader' değeri her zaman 1 olarak ayarlanmış
                            )
                        );

                        if ($insert) {
                            $updateCount++;
                        }
                    }
                }

                // İşlemin Sonucunu kontrol etme ve kullanıcıya bildirme
                if ($updateCount > 0) {
                    $alert = array(
                        "title" => "İşlem Başarılı",
                        "text" => "$updateCount veri başarılı bir şekilde eklendi",
                        "type" => "success"
                    );
                } else {
                    $alert = array(
                        "title" => "İşlem Başarısız",
                        "text" => "Veri ekleme sırasında bir problem oluştu veya eklenecek veri bulunamadı",
                        "type" => "danger"
                    );
                }

                // İşlemin Sonucunu Session'a yazma işlemi
                $this->session->set_flashdata("alert", $alert);
                redirect(base_url("some_success_page")); // Başarılı işlem sonrası yönlendirme
            } else {
                die('Dosya yüklenemedi...');
            }
        } else {
            die('Dosya bulunamadı...');
        }
    }
}




