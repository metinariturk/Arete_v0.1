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
        $models = [
            'Advance_model',
            'Boq_model',
            'Bond_model',
            'City_model',
            'Payment_settings_model',
            'Payment_sign_model',
            'Company_model',
            'Contract_model',
            'Contract_price_model',
            'Costinc_model',
            'Collection_model',
            'Delete_model',
            'District_model',
            'Extime_model',
            'Favorite_model',
            'Newprice_model',
            'Order_model',
            'Payment_model',
            'Project_model',
            'Settings_model',
            'Site_model',
            'User_model',
        ];

        // Tüm modelleri yükle
        foreach ($models as $model) {
            $this->load->model($model);
        }

        // Modül bilgileri
        $this->Module_Name = "Contract";
        $this->Module_Title = "Sözleşme";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "main";
        $this->Module_File_Dir = "contract";
        $this->Display_route = "file_form";
        $this->Upload_Folder = "uploads";
        $this->Dependet_id_key = "contract_id";
        $this->Module_Parent_Name = "project";

        // Klasör yapıları
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->Display_offer_Folder = "display_offer";

        $this->Common_Files = "common";

        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";

        // Ayarları al
        $this->Settings = get_settings();
    }

    public function index()
    {
        if (!isAdmin() && !permission_control("contract", "read")) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Contract_model->get_all(array(), "sozlesme_tarih DESC");

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list_contract";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function file_form($id = null, $active_module = null)
    {
        if (!isAdmin() && !permission_control("contract", "read")) {
            redirect(base_url("error"));
        }

        $item = $this->Contract_model->get(array("id" => $id));
        if ($item->parent > 0) {
            $main_contract = $this->Contract_model->get(array("id" => $item->parent));
        }
        $upload_function = base_url("$this->Module_Name/file_upload/$item->id");
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Contract/";
        $collection_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Collection";
        $advance_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Advance";
        $offer_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Offer";
        $payment_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Payment";
        $main_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no";

        $companys = $this->Company_model->get_all(array());

        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        if (!is_dir($collection_path)) {
            mkdir($collection_path, 0777, TRUE);
        }
        if (!is_dir($advance_path)) {
            mkdir($advance_path, 0777, TRUE);
        }
        if (!is_dir($offer_path)) {
            mkdir($offer_path, 0777, TRUE);
        }
        if (!is_dir($payment_path)) {
            mkdir($payment_path, 0777, TRUE);
        }

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
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1), "code ASC");
        $sites = $this->Site_model->get_all(array('contract_id' => $id));
        $settings = $this->Settings_model->get();
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1));

        $site = $this->Site_model->get(array("proje_id" => $item->proje_id));


        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $id, 'leader' => 1));

        // View'e gönderilecek Değişkenlerin Set Edilmesi
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->companys = $companys;
        $viewData->project = $project;

        $viewData->upload_function = $upload_function;
        $viewData->path = $path;
        $viewData->main_path = $main_path;
        $viewData->sub_path = $main_path;
        $viewData->advances = $advances;
        $viewData->collections = $collections;
        $viewData->bonds = $bonds;
        $viewData->leaders = $leaders;
        $viewData->costincs = $costincs;
        $viewData->extimes = $extimes;
        $viewData->site = $site;
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

        if ($item->parent > 0) {
            $viewData->main_contract = $main_contract;
        }

        $form_errors = $this->session->flashdata('form_errors');

        if (!empty($form_errors)) {
            $viewData->form_errors = $form_errors;
        } else {
            $viewData->form_errors = null;
        }

        $viewData->item = $this->Contract_model->get(array("id" => $id));

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/index", $viewData);
    }

    public function new_form_main($project_id = null)
    {
        if (!isAdmin() && !permission_control("contract", "write")) {
            redirect(base_url("error"));
        }

        $next_file_name = get_next_file_code("Contract");

        if (empty($project_id)) {
            $project_id = $this->input->post('proje_id');
        }

        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $project = $this->Project_model->get(array("id" => $project_id));
        $settings = $this->Settings_model->get();
        $companys = $this->Company_model->get_all(array());

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_main";
        $viewData->project = $project;
        $viewData->project_id = $project_id;
        $viewData->settings = $settings;
        $viewData->next_file_name = $next_file_name;
        $viewData->companys = $companys;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function new_form_sub($main_contract_id = null)
    {
        if (!isAdmin() && !permission_control("contract", "write")) {
            redirect(base_url("error"));
        }

        $all_contracts = $this->Contract_model->get_all();
        $file_numbers = array_map(function ($contract) {
            // '-' karakterine göre ayır ve ilk kısmı al
            $parts = explode('-', $contract->dosya_no);

            // Eğer sayıya çevirebiliyorsa, sayıya çevir, aksi takdirde sıfırla
            return is_numeric($parts[1]) ? (int)$parts[1] : 0;
        }, $all_contracts);
        sort($file_numbers);
        $max_value = empty($file_numbers) ? 0 : max($file_numbers);
        $max_value++;
        $next_file_name = str_pad($max_value, 4, '0', STR_PAD_LEFT);


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


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_sub";
        $viewData->project = $project;
        $viewData->project_id = $project_id;
        $viewData->settings = $settings;
        $viewData->next_file_name = $next_file_name;
        $viewData->main_contract = $main_contract;
        $viewData->companys = $companys;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);


    }

    public function new_form_offer($project_id = null)
    {
        if (!isAdmin() && !permission_control("contract", "write")) {
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


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_offer";
        $viewData->project = $project;
        $viewData->project_id = $project_id;
        $viewData->settings = $settings;
        $viewData->companys = $companys;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);


    }

    public function save_main($project_id = null)
    {
        // Kullanıcının admin olup olmadığını ve yetkilendirme işlemini kontrol edin
        if (!isAdmin() && !permission_control("contract", "write")) {
            redirect(base_url("error"));
        }

        $is_sub = $this->input->post("is_sub") == 1 ? 1 : 0;
        $is_main = $is_sub == 1 ? 0 : 1;
        $project_code = project_code($project_id);

        $file_name = "SOZ-" . $this->input->post('dosya_no');
        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|trim");
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
                "less_than_equal_to" => "<b>{field}</b> uygulaması seçilmelidir",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );

        // Form Validation'u Çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            // Dizin oluşturma işlemi
            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$file_name";
            !is_dir($path) || mkdir($path, 0777, TRUE);

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

            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));

        } else {
            // Form Validation Başarısız, hata mesajları ile birlikte görüntüyü yükle
            $viewData = new stdClass();
            $project = $this->Project_model->get(array("id" => $project_id));
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all(array());


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
        if (!isAdmin() && !permission_control("contract", "write")) {
            redirect(base_url("error"));
        }

        $main_contract = $this->Contract_model->get(array('id' => $main_contract_id));

        $project_id = project_id_cont($main_contract_id);
        $project_code = project_code($project_id);

        $file_name_len = file_name_digits();
        $file_name = "SOZ-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        // Form Validation Kuralları
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|trim");
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
                "less_than_equal_to" => "<b>{field}</b> uygulaması seçilmelidir",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );

        // Form Validation'u Çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            // Dizin oluşturma işlemi
            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$file_name";
            !is_dir($path) || mkdir($path, 0777, TRUE);

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
        if (!isAdmin() && !permission_control("contract", "write")) {
            redirect(base_url("error"));
        }

        $is_sub = $this->input->post("is_sub") == 1 ? 1 : 0;
        $is_main = $is_sub == 1 ? 0 : 1;
        $project_code = project_code($project_id);

        $file_name_len = file_name_digits();
        $file_name = "SOZ-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        // Form Validation Kuralları
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|trim");
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
                "less_than_equal_to" => "<b>{field}</b> uygulaması seçilmelidir",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );

        // Form Validation'u Çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            // Dizin oluşturma işlemi
            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$file_name";
            !is_dir($path) || mkdir($path, 0777, TRUE);

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


            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));
        } else {
            // Form Validation Başarısız, hata mesajları ile birlikte görüntüyü yükle
            $viewData = new stdClass();
            $project = $this->Project_model->get(array("id" => $project_id));
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all(array());


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

    public function sitedel_date($id)
    {
        if (!isAdmin() && !permission_control("contract", "update")) {
            redirect(base_url("error"));
        }

        $sozlesme_tarihi = dateFormat('d-m-Y', get_from_any("contract", "sozlesme_tarih", "id", "$id"));

        $isin_suresi = get_from_any("contract", "isin_suresi", "id", "$id");

        $this->load->library("form_validation");

        $this->form_validation->set_rules("teslim_tarih", "Teslim Tarihi", "callback_sitedel_contractday[$sozlesme_tarihi]|required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );


        $validate = $this->form_validation->run();

        if ($validate) {

            $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarih"));

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


            redirect(base_url("$this->Module_Name/file_form/$id/sitedel"));

        } else {


            redirect(base_url("$this->Module_Name/file_form/$id/sitedel/error"));

        }
    }

    public function delete_form($id)
    {
        if (!isAdmin() && !permission_control("contract", "delete")) {
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
        if (!isAdmin() && !permission_control("contract", "delete")) {
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


            redirect(base_url("$this->Module_Parent_Name/$this->Display_route/$project_id"));
        }
    }

    public function hard_delete($id)
    {
        if (!isAdmin() && !permission_control("contract", "delete")) {
            redirect(base_url("error"));
        }

        $contract = $this->Contract_model->get(array("id" => $id));
        $project = $this->Project_model->get(array("id" => $contract->proje_id));

        $project_id = $contract->proje_id;
        $project_code = project_code($project_id);
        $sub_folder = get_from_id("contract", "dosya_no", $id);

        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$sub_folder";
        $sil = deleteDirectory($path);

        $models = [
            'Advance_model',
            'Attendance_model',
            'Bond_model',
            'Boq_model',
            'Collection_model',
            'Contract_price_model',
            'Costinc_model',
            'Extime_model',
            'Newprice_model',
            'Payment_model',
            'Payment_settings_model',
            'Payment_sign_model',
            'Report_sign_model',
        ];

        $this->db->trans_start(); // Transaction başlat

        foreach ($models as $model) {
            if (property_exists($this, $model)) {
                $this->$model->delete(['contract_id' => $id]); // Silme işlemi
            }
        }

        $delete_contract = $this->Contract_model->delete(array("id" => $id));
        $delete_sub_contract = $this->Contract_model->delete(array("parent" => $id));
        $delete_favorite = $this->Favorite_model->delete(array("module" => "contract", "module_id" => "$id"));

        if ($delete_contract) {
            redirect(base_url("project/file_form/$project->id"));
        }
    }

    public function file_upload($type, $contract_id, $sub_folder = null)
    {

        if (!isAdmin() && !permission_control("contract", "read")) {
            redirect(base_url("error"));
        }

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));

        $path = $this->Upload_Folder . DIRECTORY_SEPARATOR . $this->Module_Main_Dir . DIRECTORY_SEPARATOR . $project->project_code . DIRECTORY_SEPARATOR . $item->dosya_no . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR;

        if ($sub_folder !== null) {
            $path .= $sub_folder . DIRECTORY_SEPARATOR;
        }


        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }

        $FileUploader = new FileUploader("files_$type", array(
            'limit' => null,
            'maxSize' => null,
            'extensions' => null,
            'uploadDir' => $path,
            'title' => 'name'
        ));


        $uploadedFiles = $FileUploader->upload();

        $file = ($uploadedFiles['files']);
        $maxFileSize = 2 * 1024 * 1024; // 2 MB

        if ($uploadedFiles['isSuccess'] || count($uploadedFiles["files"]) > 0) {

            // Yüklenen dosyaları işleyin
            foreach ($uploadedFiles["files"] as $file) {
                // Dosya boyutunu kontrol edin ve yeniden boyutlandırma işlemlerini gerçekleştirin
                if ($file['size'] > $maxFileSize) {
                    // Yeniden boyutlandırma işlemi için uygun genişlik ve yükseklik değerlerini belirleyin
                    $newWidth = null; // Örnek olarak 500 piksel genişlik
                    $newHeight = 1080; // Yüksekliği belirtmediğiniz takdirde orijinal oran korunur

                    // Yeniden boyutlandırma işlemi
                    FileUploader::resize($path . $file['name'], $newWidth, $newHeight, $destination = null, $crop = false, $quality = 75);
                }
            }
        }


        if (!$uploadedFiles['isSuccess']) {
            error_log(print_r($uploadedFiles['warnings'], true));
            echo json_encode(['isSuccess' => false, 'warnings' => $uploadedFiles['warnings']]);
            exit;
        }


        header('Content-Type: application/json');
        echo json_encode($uploadedFiles);
        exit;
    }

    public function fileDelete_java($module, $id)
    {
        if (!isAdmin() && !permission_control("contract", "delete")) {
            redirect(base_url("error"));
        }

        $fileName = $this->input->post('fileName');

        $contract = $this->Contract_model->get(array("id" => $id));
        $project = $this->Project_model->get(array("id" => $contract->proje_id));

        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/$contract->dosya_no/$module/";

        unlink("$path/$fileName");
    }

    public function download_all($cont_id, $where = null)
    {

        if (!isAdmin() && !permission_control("contract", "read")) {
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
        if (!isAdmin() && !permission_control("contract", "read")) {
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

    public function changeStatus($id)
    {
        // Kayıt kontrolü
        $item = $this->Contract_model->get(array("id" => $id));
        if (!$item) {
            echo "Kayıt bulunamadı.";
            return false;
        }

        // Güncelleme işlemi
        if ($item->isActive == 0 || $item->isActive == 1) {
            $update = $this->Contract_model->update(
                array("id" => $id),
                array("isActive" => 2)
            );
        } elseif ($item->isActive == 2) {
            $update = $this->Contract_model->update(
                array("id" => $id),
                array("isActive" => 1)
            );
        } else {
            echo "Geçerli bir durum güncellemesi yapılamadı.";
            return false;
        }

        // Güncelleme sonucu kontrolü
        if ($update) {
            echo "Durum başarıyla güncellendi.";
        } else {
            echo "Güncelleme sırasında bir hata oluştu.";
        }
    }

    public function add_main_group($contract_id)
    {
        if (!isAdmin() && !permission_control("contract", "update")) {
            redirect(base_url("error"));
        }

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

            $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));
            $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));

            $viewData = new stdClass();


            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->item = $item;
            $viewData->subViewFolder = "display";
            $viewData->main_groups = $main_groups;
            $viewData->sub_groups = $sub_groups;

            $viewData->leaders = $leaders;


        } else {

            $item = $this->Contract_model->get(array("id" => $contract_id));

            $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));
            $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));
            $viewData = new stdClass();


            $viewData->subViewFolder = "display";
            $viewData->leaders = $leaders;
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->item = $item;
            $viewData->main_groups = $main_groups;
            $viewData->sub_groups = $sub_groups;
            $viewData->form_error = true;

        }

        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_5_d_work_group", $viewData, true);

        echo $render_boq;

    }

    public function back_main($contract_id)
    {

        $item = $this->Contract_model->get(array('id' => $contract_id));
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));

        $viewData = new stdClass();


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $item;
        $viewData->subViewFolder = "display";

        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;


        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/modules/contract_group", $viewData, true);
        echo $render_boq;

    }

    public function update_sub_group($contract_id)
    {
        if (!isAdmin() && !permission_control("contract", "update")) {
            redirect(base_url("error"));
        }

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
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1), "code ASC");
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));


        $viewData = new stdClass();
        $viewData->leaders = $leaders;


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $item;
        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;
        $viewData->prices_main_groups = $prices_main_groups;
        $viewData->subViewFolder = "display";


        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_5_d_work_group", $viewData, true);

        echo $render_boq;

    }

    public function refresh_leader_group($contract_id)
    {

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1), "code ASC");

        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $item;
        $viewData->prices_main_groups = $prices_main_groups;
        $viewData->subViewFolder = "display";


        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_5_b_contract_price_group", $viewData, true);

        echo $render_boq;

    }

    public function refresh_contract_price($contract_id)
    {

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1), "code ASC");

        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $item;
        $viewData->prices_main_groups = $prices_main_groups;
        $viewData->subViewFolder = "display";


        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_5_a_contract_price_table", $viewData, true);

        echo $render_boq;

    }

    public function delete_group($group_id)
    {
        if (!isAdmin() && !permission_control("contract", "delete")) {
            redirect(base_url("error"));
        }
        $group = $this->Contract_price_model->get(array("id" => $group_id));

        $delete = $this->Contract_price_model->delete(
            array(
                "id" => $group_id,
            )
        );

        $item = $this->Contract_model->get(array("id" => $group->contract_id));

        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $group->contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $group->contract_id, "sub_group" => 1));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $group->contract_id, 'leader' => 1));


        $viewData = new stdClass();
        $viewData->leaders = $leaders;


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $item;
        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;
        $viewData->subViewFolder = "display";


        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_5_d_work_group", $viewData, true);
        echo $render_boq;

    }

    public function add_leader($contract_id)
    {
        if (!isAdmin() && !permission_control("contract", "update")) {
            redirect(base_url("error"));
        }
        $settings = $this->Settings_model->get();

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


            $viewData->viewFolder = $this->viewFolder;
            $viewData->viewModule = $this->moduleFolder;
            $viewData->subViewFolder = "display";
            $viewData->item = $item;
            $viewData->main_groups = $main_groups;

            $viewData->settings = $settings;


            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_5_c_price_book", $viewData, true);
            echo $render_html;

        } else {

            $item = $this->Contract_model->get(array("id" => $contract_id));
            $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));

            $viewData = new stdClass();
            $viewData->leaders = $leaders;


            $viewData->viewFolder = $this->viewFolder;
            $viewData->viewModule = $this->moduleFolder;

            $viewData->subViewFolder = "display";
            $viewData->item = $item;
            $viewData->main_groups = $main_groups;
            $viewData->form_error = true;
            $viewData->settings = $settings;


            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_5_c_price_book", $viewData, true);
            echo $render_html;

        }
    }

    public function update_leader()
    {

        $leader_id = $this->input->post('leader_id');
        if (!isAdmin() && !permission_control("contract", "update")) {
            redirect(base_url("error"));
        }

        $settings = $this->Settings_model->get();

        $this->load->library("form_validation");

        $leader = $this->Contract_price_model->get(array("id" => $leader_id));

        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $leader->contract_id, "main_group" => 1));

        $validate = $this->form_validation->run();


        // Form verilerini doğru şekilde alma
        $leader_code = $this->input->post('leader_code');
        $leader_name = $this->input->post('leader_name');
        $leader_unit = $this->input->post('leader_unit');
        $leader_price = $this->input->post('leader_price');

        // Lider bilgilerini ekleyin
        $update = $this->Contract_price_model->update(
            array(
                "id" => $leader_id
            ),
            array(
                "code" => $leader_code,
                "name" => $leader_name,
                "unit" => $leader_unit,
                "price" => $leader_price,
            )
        );

        $item = $this->Contract_model->get(array("id" => $leader->contract_id));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $leader->contract_id, 'leader' => 1));

        $viewData = new stdClass();
        $viewData->leaders = $leaders;


        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->main_groups = $main_groups;

        $viewData->settings = $settings;


        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_5_c_price_book", $viewData, true);
        echo $render_html;


    }

    public
    function update_leader_selection($sub_group_id)
    {
        if (!isAdmin() && !permission_control("contract", "update")) {
            redirect(base_url("error"));
        }

        $this->load->model("Boq_model");

        $sub_group = $this->Contract_price_model->get(array("id" => $sub_group_id));
        $main_group = $this->Contract_price_model->get(array("id" => $sub_group->parent));


        $updated_leaders = $this->input->post('leaders') ?? []; // Eğer boş ise boş bir dizi olarak ayarla

        $existing_leaders = $this->Contract_price_model->get_all(
            array("sub_id" => $sub_group_id),
            "leader_id"
        );

        $existing_leader_ids = array_map(function ($existing_leader) {
            return $existing_leader->leader_id;
        }, $existing_leaders);

        $leaders_to_remove = array_diff($existing_leader_ids, $updated_leaders);

        foreach ($leaders_to_remove as $leader_id_to_remove) {

            $boq = $this->Contract_price_model->get(array("leader_id" => $leader_id_to_remove, "sub_id" => $sub_group_id));

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


        // Eklenecek liderler: Yeni listede olup eski listede olmayanlar
        $leaders_to_add = array_diff($updated_leaders, $existing_leader_ids);

        foreach ($leaders_to_add as $leader_id_to_add) {
            $leader = $this->Contract_price_model->get(array("id" => $leader_id_to_add));
            if ($leader) {
                $this->Contract_price_model->add(array(
                    "contract_id" => $sub_group->contract_id,
                    "code" => $main_group->code . "." . $sub_group->code . "." . $leader->code,
                    "sub_id" => $sub_group->id,
                    "main_id" => $main_group->id,
                    "leader_id" => $leader->id,
                    "name" => $leader->name,
                    "unit" => $leader->unit,
                    "price" => $leader->price,
                ));
            }
        }


        $item = $this->Contract_model->get(array("id" => $sub_group->contract_id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $sub_group->contract_id, "main_group" => 1), "code ASC");

        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $item;
        $viewData->prices_main_groups = $prices_main_groups;
        $viewData->subViewFolder = "display";


        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_5_b_contract_price_group", $viewData, true);
        echo $render_html;

    }

    public function delete_contract_price($boq_id)
    {
        if (!isAdmin() && !permission_control("contract", "delete")) {
            redirect(base_url("error"));
        }
        $this->load->model("Boq_model");

        $contract_price = $this->Contract_price_model->get(array("id" => $boq_id));

        $contract_id = $contract_price->contract_id;

        $delete = $this->Contract_price_model->delete(array("id" => $boq_id));
        $delete_leader = $this->Contract_price_model->delete(array("leader_id" => $boq_id));
        $delete_boq = $this->Boq_model->delete(array("leader_id" => $boq_id));

        // Silme işlemi başarılıysa başarılı mesajını, başarısızsa hata mesajını JSON olarak döndürelim
        if ($delete || $delete_boq || $delete_leader) {
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

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_5_c_price_book", $viewData, true);
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
        if (!isAdmin() && !permission_control("contract", "delete")) {
            redirect(base_url("error"));
        }


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
        if (!isAdmin() && !permission_control("contract", "delete")) {
            redirect(base_url("error"));
        }


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
        if (!isAdmin() && !permission_control("contract", "delete")) {
            redirect(base_url("error"));
        }


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
        if (!isAdmin() && !permission_control("contract", "write")) {
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


                redirect(base_url("contract/file_form/$contract_id/Price")); // Başarılı işlem sonrası yönlendirme
            } else {
                die('Dosya yüklenemedi...');
            }
        } else {
            die('Dosya bulunamadı...');
        }
    }

    public function update_boqs()
    {
        if (!isAdmin() && !permission_control("contract", "update")) {
            redirect(base_url("error"));
        }


        // JSON verilerini al
        $data = file_get_contents('php://input');

        // JSON verilerini diziye dönüştür
        $data_array = json_decode($data, true);

        // Verileri kontrol etmek için
        if ($data_array) {
            // Her bir öğeyi güncelle
            foreach ($data_array as $values) {
                // Veritabanında güncelleme yapmak için model metodunu kullanın
                $update = $this->Contract_price_model->update(
                    array("id" => $values['id']), // Güncellenecek satırın ID'si
                    array("qty" => $values['qty']) // Güncellenecek veriler
                );

                // Güncellemenin başarılı olup olmadığını kontrol et (Opsiyonel)
                if ($update) {
                    log_message('info', 'Güncelleme başarılı: ID ' . $values['id']);
                } else {
                    log_message('error', 'Güncelleme başarısız: ID ' . $values['id']);
                }
            }

            // JSON yanıt
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gelen veri boş veya geçersiz formatta.'));
        }
    }

    public
    function create_payment($contract_id)
    {
        if (!isAdmin() && !permission_control("contract", "write")) {
            redirect(base_url("error"));
        }


        $contract = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $contract->proje_id));
        $last_payment = $this->Payment_model->last_payment(array("contract_id" => $contract_id));

        $start_date = ($contract->sitedel_date != null)
            ? dateFormat('d-m-Y', $contract->sitedel_date)
            : dateFormat('d-m-Y', $contract->sozlesme_tarih);

        $hak_no = $this->input->post('hakedis_no');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("hakedis_no", "Hakediş No", "required|numeric|trim"); //2

        if ($hak_no == 1) {
            $this->form_validation->set_rules("imalat_tarihi", "İmalat Tarihi", "trim|callback_date_greater_than[$start_date]");
        } else {
            $last_payment_day = dateFormat('d-m-Y', $last_payment->imalat_tarihi);
            $this->form_validation->set_rules("imalat_tarihi", "İmalat Tarihi", "trim|callback_date_greater_than[$last_payment_day]");
        }

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "numeric" => "<b>{field}</b> rakamlardan oluşmalıdır",
                "limit_advance" => "<b>{field}</b> en fazla kadar olmalıdır.",
                "greater_than_equal_to" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "date_greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project->project_code/$contract->dosya_no/Payment/$hak_no";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            if ($this->input->post('hakedis_no') == "on") {
                $final = 1;
            } else {
                $final = 0;
            }

            $imalat_tarihi = dateFormat('Y-m-d', $this->input->post("imalat_tarihi"));


            $insert = $this->Payment_model->add(
                array(
                    "contract_id" => $contract_id,
                    "hakedis_no" => $this->input->post('hakedis_no'),
                    "imalat_tarihi" => $imalat_tarihi,
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_contract_id" => $contract_id,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                )
            );


            $this->session->unset_userdata('form_errors');
            $viewData = new stdClass();

            $project = $this->Project_model->get(array("id" => $contract->proje_id));
            $payments = $this->Payment_model->get_all(array('contract_id' => $contract->id));

            // View'e gönderilecek Değişkenlerin Set Edilmesi
            $viewData->viewModule = $this->moduleFolder;


            $viewData->viewFolder = "contract_v";
            $viewData->project = $project;
            $viewData->payments = $payments;
            $viewData->project_code = $project->project_code;

            $viewData->item = $this->Contract_model->get(array("id" => $contract->id));

            $this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_3_payments", $viewData);


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


            if (!isAdmin() && !permission_control("contract", "write")) {
                redirect(base_url("error"));
            }

            $item = $this->Contract_model->get(array("id" => $contract->id));
            $upload_function = base_url("$this->Module_Name/file_upload/$item->id");
            $project = $this->Project_model->get(array("id" => $item->proje_id));
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Contract/";
            $collection_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Collection";
            $advance_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Advance";
            $offer_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Offer";
            $payment_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Payment";

            $companys = $this->Company_model->get_all(array());

            !is_dir($path) || mkdir($path, 0777, TRUE);
            !is_dir($collection_path) || mkdir($collection_path, 0777, TRUE);
            !is_dir($advance_path) || mkdir($advance_path, 0777, TRUE);
            !is_dir($offer_path) || mkdir($offer_path, 0777, TRUE);
            !is_dir($payment_path) || mkdir($payment_path, 0777, TRUE);


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
            $extimes = $this->Extime_model->get_all(array('contract_id' => $contract->id));
            $main_bond = $this->Bond_model->get(array('contract_id' => $contract->id, 'teminat_gerekce' => 'contract'));
            $newprices = $this->Newprice_model->get_all(array('contract_id' => $contract->id));
            $payments = $this->Payment_model->get_all(array('contract_id' => $contract->id));
            $site = $this->Site_model->get(array('contract_id' => $contract->id));
            $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "main_group" => 1), "code ASC");
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
            $viewData->site = $site;
            $viewData->error_modal = "AddPaymentModal"; // Hata modali için set edilen değişken

            $form_errors = $this->session->flashdata('form_errors');

            if (!empty($form_errors)) {
                $viewData->form_errors = $form_errors;
            } else {
                $viewData->form_errors = null;
            }

            $viewData->item = $this->Contract_model->get(array("id" => $contract->id));

            $this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_3_payments", $viewData);
        }

    }

    public
    function create_collection($contract_id)
    {
        if (!isAdmin() && !permission_control("contract", "read")) {
            redirect(base_url("error"));
        }

        $this->load->model("Contract_model");
        $this->load->model("Settings_model");

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $settings = $this->Settings_model->get();

        $this->load->library("form_validation");

        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);

        $this->form_validation->set_rules("tahsilat_tarih", "Tahsilat Tarihi", "callback_contract_collection[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("tahsilat_turu", "Tahsilat Türü", "required|trim");

        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_collection[$sozlesme_tarih]|trim");
        }

        if ($this->input->post('tahsilat_turu') == "Çek" || $this->input->post('tahsilat_turu') == "Senet") {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_collection[$sozlesme_tarih]|trim|required");
        }

        $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|numeric|required|trim");

        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|less_than_equal_to[$contract_price]|numeric|trim");
        } else {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_collection" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Collection";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            if ($this->input->post("tahsilat_tarih")) {
                $tahsilat_tarihi = dateFormat('Y-m-d', $this->input->post("tahsilat_tarih"));
            } else {
                $tahsilat_tarihi = null;
            }
            if ($this->input->post("vade_tarih")) {
                $vade_tarihi = dateFormat('Y-m-d', $this->input->post("vade_tarih"));
            } else {
                $vade_tarihi = null;
            }

            $insert = $this->Collection_model->add(
                array(
                    "contract_id" => $contract_id,
                    "tahsilat_tarih" => $tahsilat_tarihi,
                    "vade_tarih" => $vade_tarihi,
                    "tahsilat_miktar" => $this->input->post("tahsilat_miktar"),
                    "tahsilat_turu" => $this->input->post("tahsilat_turu"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

            $record_id = $this->db->insert_id();

            // Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Collection/$record_id";
            // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);


            // Yükleme ayarları belirleniyor
            $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
            $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
            $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
            $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)

            // Yükleme kütüphanesi yükleniyor
            $this->load->library("upload", $config);


            // Dosya yükleme işlemi
            if (!$this->upload->do_upload("file")) {
                // Yükleme başarısız olduysa hata mesajı döndürülüyor
                $error = $this->upload->display_errors();
            } else {
                // Yükleme başarılıysa devam eden işlemler
                $data = $this->upload->data();
            }

            $collections = $this->Collection_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->project = $project;
            $viewData->collections = $collections;
            $viewData->settings = $settings;
            $viewData->item = $item;


            $response = array(
                'status' => 'success',
                'html' => $this->load->view("{$viewData->viewModule}/contract_v/display/collection/collection_table", $viewData, true)
            );
            echo json_encode($response);

        } else {

            $collections = $this->Collection_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->project = $project;
            $viewData->collections = $collections;
            $viewData->settings = $settings;
            $viewData->item = $item;
            $viewData->form_error = true;

            $response = array(
                'status' => 'error',
                'html' => $this->load->view("{$viewData->viewModule}/contract_v/display/collection/add_collection_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public
    function create_advance($contract_id)
    {
        if (!isAdmin() && !permission_control("contract", "read")) {
            redirect(base_url("error"));
        }

        $this->load->model("Contract_model");
        $this->load->model("Settings_model");

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $settings = $this->Settings_model->get();

        $this->load->library("form_validation");

        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);

        $this->form_validation->set_rules("avans_tarih", "Avans Tarihi", "callback_contract_advance[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("avans_turu", "Avans Türü", "required|trim");

        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_advance[$sozlesme_tarih]|trim");
        }

        if ($this->input->post('avans_turu') == "Çek" || $this->input->post('avans_turu') == "Senet") {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_advance[$sozlesme_tarih]|trim|required");
        }

        $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|numeric|required|trim");

        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|less_than_equal_to[$contract_price]|numeric|trim");
        } else {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_advance" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Advance";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            if ($this->input->post("avans_tarih")) {
                $avans_tarih = dateFormat('Y-m-d', $this->input->post("avans_tarih"));
            } else {
                $avans_tarih = null;
            }
            if ($this->input->post("vade_tarih")) {
                $vade_tarihi = dateFormat('Y-m-d', $this->input->post("vade_tarih"));
            } else {
                $vade_tarihi = null;
            }

            $insert = $this->Advance_model->add(
                array(
                    "contract_id" => $contract_id,
                    "avans_tarih" => $avans_tarih,
                    "vade_tarih" => $vade_tarihi,
                    "avans_miktar" => $this->input->post("avans_miktar"),
                    "avans_turu" => $this->input->post("avans_turu"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

            $record_id = $this->db->insert_id();

            // Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Advance/$record_id";
            // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);


            // Yükleme ayarları belirleniyor
            $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
            $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
            $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
            $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)

            // Yükleme kütüphanesi yükleniyor
            $this->load->library("upload", $config);


            // Dosya yükleme işlemi
            if (!$this->upload->do_upload("file")) {
                // Yükleme başarısız olduysa hata mesajı döndürülüyor
                $error = $this->upload->display_errors();
            } else {
                // Yükleme başarılıysa devam eden işlemler
                $data = $this->upload->data();
            }


            $advances = $this->Advance_model->get_all(array('contract_id' => $item->id), "avans_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->project = $project;
            $viewData->advances = $advances;
            $viewData->settings = $settings;
            $viewData->item = $item;

            $this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_4_b_advance", $viewData);

            //kaydedilen elemanın id nosunu döküman ekleme
            // sına post ediyoruz

        } else {

            $advances = $this->Advance_model->get_all(array('contract_id' => $item->id), "avans_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->project = $project;
            $viewData->advances = $advances;
            $viewData->settings = $settings;
            $viewData->item = $item;

            $viewData->form_error = true;
            $viewData->error_modal = "AddAdvanceModal"; // Hata modali için set edilen değişken

            $form_errors = $this->session->flashdata('form_errors');

            if (!empty($form_errors)) {
                $viewData->form_errors = $form_errors;
            } else {
                $viewData->form_errors = null;
            }

            $this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_4_b_advance", $viewData);
        }

    }

    public
    function create_bond($contract_id)
    {
        if (!isAdmin() && !permission_control("contract", "read")) {
            redirect(base_url("error"));
        }

        $this->load->model("Contract_model");
        $this->load->model("Settings_model");

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $settings = $this->Settings_model->get();

        $this->load->library("form_validation");

        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);

        $this->form_validation->set_rules("teslim_tarih", "Teminat Tarihi", "callback_contract_bond[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("teminat_turu", "Teminat Türü", "required|trim");

        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("teslim_tarih", "Vade Tarihi", "callback_contract_bond[$sozlesme_tarih]|trim");
        }

        if ($this->input->post('teminat_turu') != "Nakit") {
            $this->form_validation->set_rules("gecerlilik_tarih", "Vade Tarihi", "callback_contract_bond[$sozlesme_tarih]|trim|required");
        }

        if ($this->input->post('teminat_turu') == "Çek") {
            $this->form_validation->set_rules("teminat_banka", "Banka Adı", "trim|required");
        }

        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "required|numeric|required|trim");

        $this->form_validation->set_rules("teminat_gerekce", "Gerekçe", "required|trim");

        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "required|numeric|trim");

        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_bond" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );

// Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Bond";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            if ($this->input->post("teslim_tarih")) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarih"));
            } else {
                $teslim_tarihi = null;
            }
            if ($this->input->post("gecerlilik_tarih")) {
                $gecerlilik_tarihi = dateFormat('Y-m-d', $this->input->post("gecerlilik_tarih"));
            } else {
                $gecerlilik_tarihi = null;
            }

            $insert = $this->Bond_model->add(
                array(
                    "contract_id" => $contract_id,
                    "teminat_gerekce" => $this->input->post("teminat_gerekce"),
                    "teminat_turu" => $this->input->post("teminat_turu"),
                    "teminat_miktar" => $this->input->post("teminat_miktar"),
                    "teminat_banka" => $this->input->post("teminat_banka"),
                    "teslim_tarih" => $teslim_tarihi,
                    "gecerlilik_tarih" => $gecerlilik_tarihi,
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

            $record_id = $this->db->insert_id();

// Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Bond/$record_id";
// Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);


// Yükleme ayarları belirleniyor
            $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
            $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
            $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
            $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)

// Yükleme kütüphanesi yükleniyor
            $this->load->library("upload", $config);


// Dosya yükleme işlemi
            if (!$this->upload->do_upload("file")) {
// Yükleme başarısız olduysa hata mesajı döndürülüyor
                $error = $this->upload->display_errors();
            } else {
// Yükleme başarılıysa devam eden işlemler
                $data = $this->upload->data();
            }


            $bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "teslim_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->project = $project;
            $viewData->bonds = $bonds;
            $viewData->settings = $settings;
            $viewData->item = $item;

            $this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_4_c_bond", $viewData);

//kaydedilen elemanın id nosunu döküman ekleme
// sına post ediyoruz

        } else {

            $bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "teslim_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->project = $project;
            $viewData->bonds = $bonds;
            $viewData->settings = $settings;
            $viewData->item = $item;

            $viewData->form_error = true;
            $viewData->error_modal = "AddBondModal"; // Hata modali için set edilen değişken

            $form_errors = $this->session->flashdata('form_errors');

            if (!empty($form_errors)) {
                $viewData->form_errors = $form_errors;
            } else {
                $viewData->form_errors = null;
            }

            $this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_4_c_bond", $viewData);
        }

    }

    public function open_edit_contract_modal($contract_id)
    {
        // Verilerin getirilmesi

        $edit_item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $edit_item->proje_id));
        $companys = $this->Company_model->get_all(array());

        $settings = $this->Settings_model->get();

        // Görünüm için değişkenlerin set edilmesi
        $viewData = new stdClass();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->settings = $settings;
        $viewData->edit_item = $edit_item;
        $viewData->companys = $companys;
        $viewData->project = $project;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modals/edit_contract_modal_form", $viewData);
    }

    public function open_edit_collection_modal($collection_id)
    {
        // Verilerin getirilmesi

        $edit_collection = $this->Collection_model->get(array("id" => $collection_id));
        $item = $this->Contract_model->get(array("id" => $edit_collection->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $settings = $this->Settings_model->get();

        // Görünüm için değişkenlerin set edilmesi
        $viewData = new stdClass();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->settings = $settings;
        $viewData->item = $item;
        $viewData->project = $project;
        $viewData->edit_collection = $edit_collection;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/collection/edit_collection_modal_form", $viewData);
    }

    public function open_edit_advance_modal($advance)
    {
        // Verilerin getirilmesi

        $edit_advance = $this->Advance_model->get(array("id" => $advance));
        $item = $this->Contract_model->get(array("id" => $edit_advance->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $settings = $this->Settings_model->get();

        // Görünüm için değişkenlerin set edilmesi
        $viewData = new stdClass();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->settings = $settings;
        $viewData->item = $item;
        $viewData->project = $project;
        $viewData->edit_advance = $edit_advance;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modals/edit_advance_modal_form", $viewData);
    }

    public function open_edit_bond_modal($bond)
    {
        // Verilerin getirilmesi

        $edit_bond = $this->Bond_model->get(array("id" => $bond));
        $item = $this->Contract_model->get(array("id" => $edit_bond->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $settings = $this->Settings_model->get();

        // Görünüm için değişkenlerin set edilmesi
        $viewData = new stdClass();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->settings = $settings;
        $viewData->item = $item;
        $viewData->project = $project;
        $viewData->edit_bond = $edit_bond;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modals/edit_bond_modal_form", $viewData);
    }

    public function open_edit_contract_price($sub_group_id)
    {
        if (!isAdmin() && !permission_control("contract", "read")) {
            redirect(base_url("error"));
        }
        $this->load->model("Boq_model");


        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $sub_group = $this->Contract_price_model->get(array("id" => $sub_group_id));
        $main_group = $this->Contract_price_model->get(array("id" => $sub_group->parent));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $sub_group->contract_id, 'leader' => 1));
        $item = $this->Contract_model->get(array('id' => $sub_group->contract_id));


        $viewData = new stdClass();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->sub_group = $sub_group;
        $viewData->main_group = $main_group;
        $viewData->item = $item;
        $viewData->leaders = $leaders;
        $viewData->edit_contract_price = $sub_group;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modals/edit_contract_price_modal_form", $viewData);
    }


    function edit_collection($collection_id)
    {
        if (!isAdmin() && !permission_control("contract", "read")) {
            redirect(base_url("error"));
        }

        $this->load->model("Contract_model");
        $this->load->model("Settings_model");

        $edit_collection = $this->Collection_model->get(array("id" => $collection_id));
        $item = $this->Contract_model->get(array("id" => $edit_collection->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $settings = $this->Settings_model->get();

        $this->load->library("form_validation");

        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);

        $this->form_validation->set_rules("tahsilat_tarih", "Tahsilat Tarihi", "callback_contract_collection[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("tahsilat_turu", "Tahsilat Türü", "required|trim");

        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_collection[$sozlesme_tarih]|trim");
        }

        if ($this->input->post('tahsilat_turu') == "Çek") {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_collection[$sozlesme_tarih]|trim|required");
        }

        $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|numeric|required|trim");

        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|less_than_equal_to[$contract_price]|numeric|trim");
        } else {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_collection" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Collection";

            if ($this->input->post("tahsilat_tarih")) {
                $tahsilat_tarihi = dateFormat('Y-m-d', $this->input->post("tahsilat_tarih"));
            } else {
                $tahsilat_tarihi = null;
            }
            if ($this->input->post("vade_tarih")) {
                $vade_tarihi = dateFormat('Y-m-d', $this->input->post("vade_tarih"));
            } else {
                $vade_tarihi = null;
            }

            $update = $this->Collection_model->update(
                array(
                    "id" => $collection_id
                ),
                array(
                    "tahsilat_tarih" => $tahsilat_tarihi,
                    "vade_tarih" => $vade_tarihi,
                    "tahsilat_miktar" => $this->input->post("tahsilat_miktar"),
                    "tahsilat_turu" => $this->input->post("tahsilat_turu"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

            // Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Collection/$collection_id";
            // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

            // Yükleme ayarları belirleniyor
            $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
            $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
            $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
            $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)

            // Yükleme kütüphanesi yükleniyor
            $this->load->library("upload", $config);


            // Dosya yükleme işlemi
            if (!$this->upload->do_upload("file")) {
                // Yükleme başarısız olduysa hata mesajı döndürülüyor
                $error = $this->upload->display_errors();
            } else {
                // Yükleme başarılıysa devam eden işlemler
                $data = $this->upload->data();
            }

            $collections = $this->Collection_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->project = $project;
            $viewData->item = $item;
            $viewData->collections = $collections;
            $viewData->settings = $settings;

            $response = array(
                'status' => 'success',
                'html' => $this->load->view("{$viewData->viewModule}/contract_v/display/collection/collection_table", $viewData, true)
            );

            echo json_encode($response);

        } else {

            $edit_collection = $this->Collection_model->get(array("id" => $collection_id));
            $item = $this->Contract_model->get(array("id" => $edit_collection->contract_id));
            $project = $this->Project_model->get(array("id" => $item->proje_id));
            $settings = $this->Settings_model->get();
            $collections = $this->Collection_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->edit_collection = $edit_collection;
            $viewData->project = $project;
            $viewData->collections = $collections;
            $viewData->settings = $settings;
            $viewData->item = $item;

            $viewData->form_error = true;

            $response = array(
                'status' => 'error',
                'html' => $this->load->view("{$viewData->viewModule}/contract_v/display/collection/edit_collection_form_input", $viewData, true)
            );
            echo json_encode($response);

        }
    }

    public function delete_collection($collection_id)
    {
        if (!isAdmin() && !permission_control("contract", "read")) {
            redirect(base_url("error"));
            return;
        }

        $this->load->model("Contract_model");
        $this->load->model("Settings_model");

        $delete_collection = $this->Collection_model->get(array("id" => $collection_id));
        $item = $this->Contract_model->get(array("id" => $delete_collection->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));

        $delete = $this->Collection_model->delete(array("id" => $collection_id));

        $this->load->helper('file'); // File helper'ını yükle

        $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Collection/$collection_id";

        delete_files($path, true); // İkinci parametre (true), klasörün kendisini de siler

        if (is_dir($path)) {
            rmdir($path);
        }

        $settings = $this->Settings_model->get();
        $collections = $this->Collection_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");

        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = "contract_v";
        $viewData->subViewFolder = "display";
        $viewData->project = $project;
        $viewData->collections = $collections;
        $viewData->settings = $settings;
        $viewData->item = $item;

        $formErrorHtml = $this->load->view("{$viewData->viewModule}/contract_v/display/collection/collection_table", $viewData, true);

        echo json_encode([
            'html' => $formErrorHtml, // Form hatalarını içeren HTML
        ]);
    }

    function edit_contract($contract_id)
    {

        if (!isAdmin() && !permission_control("contract", "write")) {
            redirect(base_url("error"));
        }

        $this->load->library("form_validation");

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
                "less_than_equal_to" => "<b>{field}</b> uygulaması seçilmelidir",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );
        // Form Validation'u Çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {

            $sozlesme_tarih = $this->input->post("sozlesme_tarih") ? dateFormat('Y-m-d', $this->input->post("sozlesme_tarih")) : null;
            $sozlesme_bitis = dateFormat('Y-m-d', date_plus_days($this->input->post("sozlesme_tarih"), $this->input->post("isin_suresi") - 1));
            $contract_name = mb_convert_case($this->input->post("contract_name"), MB_CASE_TITLE, "UTF-8");

            // Veritabanına Ekleme İşlemi
            $update = $this->Contract_model->update(
                array("id" => $contract_id),
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
                )
            );

            $viewData = new stdClass();
            $item = $this->Contract_model->get(array("id" => $contract_id));
            $settings = get_settings();
            $viewData->edit_item = $item;

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->settings = $settings;
            $viewData->item = $item;

            echo json_encode([
                'status' => 'success',
                'message' => 'Contract successfully updated.',
                'refreshDivId' => 'tab_Contract', // Refresh edilecek div'in ID'si
                'closeModalId' => 'EditContractModal' // Kapatılacak modalın ID'si
            ]);


        } else {

            $viewData = new stdClass();
            $item = $this->Contract_model->get(array("id" => $contract_id));
            $settings = get_settings();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->settings = $settings;
            $viewData->item = $item;
            $viewData->edit_item = $item;

            $viewData->form_error = true;
            // Form hatalarını içeren HTML oluştur
            $formErrorHtml = $this->load->view("{$viewData->viewModule}/contract_v/display/modals/edit_contract_form_input", $viewData, true);

            // Hata durumunda JSON yanıt
            echo json_encode([
                'status' => 'error',
                'html' => $formErrorHtml, // Form hatalarını içeren HTML
                'modalId' => 'EditContractModal' // Açık kalması gereken modal
            ]);
        }
    }

    function edit_bond($bond_id)
    {
        if (!isAdmin() && !permission_control("contract", "read")) {
            redirect(base_url("error"));
        }

        $this->load->model("Contract_model");
        $this->load->model("Settings_model");

        $edit_bond = $this->Bond_model->get(array("id" => $bond_id));
        $item = $this->Contract_model->get(array("id" => $edit_bond->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $settings = $this->Settings_model->get();
        $bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "teslim_tarih ASC");

        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = "contract_v";
        $viewData->subViewFolder = "display";

        $viewData->project = $project;
        $viewData->bonds = $bonds;
        $viewData->settings = $settings;
        $viewData->item = $item;

        $this->load->library("form_validation");

        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);

        $this->form_validation->set_rules("teslim_tarih", "Teminat Tarihi", "callback_contract_bond[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("teminat_turu", "Teminat Türü", "required|trim");

        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("teslim_tarih", "Vade Tarihi", "callback_contract_bond[$sozlesme_tarih]|trim");
        }

        if ($this->input->post('teminat_turu') != "Nakit") {
            $this->form_validation->set_rules("gecerlilik_tarih", "Vade Tarihi", "callback_contract_bond[$sozlesme_tarih]|trim|required");
        }

        if ($this->input->post('teminat_turu') == "Çek") {
            $this->form_validation->set_rules("teminat_banka", "Banka Adı", "trim|required");
        }

        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "required|numeric|required|trim");

        $this->form_validation->set_rules("teminat_gerekce", "Gerekçe", "required|trim");

        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "required|numeric|trim");

        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_bond" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );

// Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Bond";

            if ($this->input->post("teslim_tarih")) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarih"));
            } else {
                $teslim_tarihi = null;
            }
            if ($this->input->post("gecerlilik_tarih")) {
                $gecerlilik_tarihi = dateFormat('Y-m-d', $this->input->post("gecerlilik_tarih"));
            } else {
                $gecerlilik_tarihi = null;
            }

            $update = $this->Bond_model->update(
                array(
                    "id" => $bond_id
                ),
                array(
                    "teminat_gerekce" => $this->input->post("teminat_gerekce"),
                    "teminat_turu" => $this->input->post("teminat_turu"),
                    "teminat_miktar" => $this->input->post("teminat_miktar"),
                    "teminat_banka" => $this->input->post("teminat_banka"),
                    "teslim_tarih" => $teslim_tarihi,
                    "gecerlilik_tarih" => $gecerlilik_tarihi,
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

// Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Bond/$bond_id";
// Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);


// Yükleme ayarları belirleniyor
            $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
            $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
            $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
            $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)

// Yükleme kütüphanesi yükleniyor
            $this->load->library("upload", $config);


// Dosya yükleme işlemi
            if (!$this->upload->do_upload("file")) {
// Yükleme başarısız olduysa hata mesajı döndürülüyor
                $error = $this->upload->display_errors();
            } else {
// Yükleme başarılıysa devam eden işlemler
                $data = $this->upload->data();
            }

            $edit_bond = $this->Bond_model->get(array("id" => $bond_id));
            $item = $this->Contract_model->get(array("id" => $edit_bond->contract_id));
            $project = $this->Project_model->get(array("id" => $item->proje_id));
            $settings = $this->Settings_model->get();
            $bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "teslim_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->project = $project;
            $viewData->bonds = $bonds;
            $viewData->settings = $settings;
            $viewData->item = $item;

            $this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_4_c_bond", $viewData);

//kaydedilen elemanın id nosunu döküman ekleme
// sına post ediyoruz

        } else {

            $edit_bond = $this->Bond_model->get(array("id" => $bond_id));
            $item = $this->Contract_model->get(array("id" => $edit_bond->contract_id));
            $project = $this->Project_model->get(array("id" => $item->proje_id));
            $settings = $this->Settings_model->get();
            $bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "teslim_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->edit_bond = $edit_bond;
            $viewData->project = $project;
            $viewData->bonds = $bonds;
            $viewData->settings = $settings;
            $viewData->item = $item;

            $viewData->form_error = true;
            $viewData->error_modal = "EditBondModal"; // Hata modali için set edilen değişken

            if (!empty($form_errors)) {
                $viewData->form_errors = $form_errors;
            } else {
                $viewData->form_errors = null;
            }

            $this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_4_c_bond", $viewData);

        }
    }

    function edit_advance($advance_id)
    {
        if (!isAdmin() && !permission_control("contract", "read")) {
            redirect(base_url("error"));
        }

        $this->load->model("Contract_model");
        $this->load->model("Settings_model");

        $edit_advance = $this->Advance_model->get(array("id" => $advance_id));
        $item = $this->Contract_model->get(array("id" => $edit_advance->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $settings = $this->Settings_model->get();
        $advances = $this->Advance_model->get_all(array('contract_id' => $item->id), "avans_tarih ASC");

        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = "contract_v";
        $viewData->subViewFolder = "display";

        $viewData->project = $project;
        $viewData->advances = $advances;
        $viewData->settings = $settings;
        $viewData->item = $item;

        $this->load->library("form_validation");

        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);

        $this->form_validation->set_rules("avans_tarih", "Avans Tarihi", "callback_contract_advance[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("avans_turu", "Avans Türü", "required|trim");

        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_advance[$sozlesme_tarih]|trim");
        }

        if ($this->input->post('avans_turu') == "Çek") {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_advance[$sozlesme_tarih]|trim|required");
        }

        $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|numeric|required|trim");

        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|less_than_equal_to[$contract_price]|numeric|trim");
        } else {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_advance" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );

// Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("avans_tarih")) {
                $avans_tarihi = dateFormat('Y-m-d', $this->input->post("avans_tarih"));
            } else {
                $avans_tarihi = null;
            }
            if ($this->input->post("vade_tarih")) {
                $vade_tarihi = dateFormat('Y-m-d', $this->input->post("vade_tarih"));
            } else {
                $vade_tarihi = null;
            }

            $update = $this->Advance_model->update(
                array(
                    "id" => $advance_id
                ),
                array(
                    "avans_tarih" => $avans_tarihi,
                    "vade_tarih" => $vade_tarihi,
                    "avans_miktar" => $this->input->post("avans_miktar"),
                    "avans_turu" => $this->input->post("avans_turu"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

// Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Advance/$advance_id";
// Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);


// Yükleme ayarları belirleniyor
            $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
            $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
            $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
            $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)

// Yükleme kütüphanesi yükleniyor
            $this->load->library("upload", $config);

// Dosya yükleme işlemi
            if (!$this->upload->do_upload("file")) {
// Yükleme başarısız olduysa hata mesajı döndürülüyor
                $error = $this->upload->display_errors();
            } else {
// Yükleme başarılıysa devam eden işlemler
                $data = $this->upload->data();
            }

            $edit_advance = $this->Advance_model->get(array("id" => $advance_id));
            $item = $this->Contract_model->get(array("id" => $edit_advance->contract_id));
            $project = $this->Project_model->get(array("id" => $item->proje_id));
            $settings = $this->Settings_model->get();
            $advances = $this->Advance_model->get_all(array('contract_id' => $item->id), "avans_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->project = $project;
            $viewData->advances = $advances;
            $viewData->settings = $settings;
            $viewData->item = $item;

            $this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_4_b_advance", $viewData);


        } else {

            $edit_advance = $this->Advance_model->get(array("id" => $advance_id));
            $item = $this->Contract_model->get(array("id" => $edit_advance->contract_id));
            $project = $this->Project_model->get(array("id" => $item->proje_id));
            $settings = $this->Settings_model->get();
            $advances = $this->Advance_model->get_all(array('contract_id' => $item->id), "avans_tarih ASC");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "contract_v";
            $viewData->subViewFolder = "display";

            $viewData->edit_advance = $edit_advance;
            $viewData->project = $project;
            $viewData->advances = $advances;
            $viewData->settings = $settings;
            $viewData->item = $item;

            $viewData->form_error = true;
            $viewData->error_modal = "EditAdvanceModal";

            if (!empty($form_errors)) {
                $viewData->form_errors = $form_errors;
            } else {
                $viewData->form_errors = null;
            }

            $this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_4_b_advance", $viewData);

        }
    }

    public function contract_collection($collection_day, $contract_day)
    {
        $date_diff = date_minus($collection_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function contract_advance($advance_day, $contract_day)
    {
        $date_diff = date_minus($advance_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function contract_bond($bond_day, $contract_day)
    {
        $date_diff = date_minus($bond_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function date_greater_than($date1, $date2_field)
    {
        $format_date1 = dateFormat('Y-m-d', "$date1");
        $format_date2 = dateFormat('Y-m-d', "$date2_field");

        if (strtotime($format_date1) > strtotime($format_date2)) {
            return TRUE; // Karşılaştırma doğruysa TRUE döner
        }
        return FALSE; // Karşılaştırma yanlışsa FALSE döner

    }

    public function date_greater_than_equal($date1, $date2_field)
    {
        $format_date1 = dateFormat('Y-m-d', "$date1");
        $format_date2 = dateFormat('Y-m-d', "$date2_field");

        if (strtotime($format_date1) >= strtotime($format_date2)) {
            return TRUE;
        }
        return FALSE;
    }

    public function date_less_than($date1, $date2_field)
    {
        $format_date1 = dateFormat('Y-m-d', "$date1");
        $format_date2 = dateFormat('Y-m-d', "$date2_field");

        if (strtotime($format_date1) < strtotime($format_date2)) {
            return TRUE;
        }
        return FALSE;
    }

    public function date_less_than_equal($date1, $date2_field)
    {
        $format_date1 = dateFormat('Y-m-d', "$date1");
        $format_date2 = dateFormat('Y-m-d', "$date2_field");

        if (strtotime($format_date1) <= strtotime($format_date2)) {
            return TRUE;
        }
        return FALSE;
    }

    public function folder_open()
    {
        $folder_id = $this->input->post('folder_id'); // folder_id parametresi
        $folder_name = $this->input->post('folder_name'); // folder_name parametresi
        $contract_id = $this->input->post('contractID');     // folder_id parametresi
        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        if ($folder_id != null) {
            $sub_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/$folder_name/$folder_id";
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/$folder_name/$folder_id/";
        } else {
            $sub_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/$folder_name";
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/$folder_name/";
        }


        // Görünüm için değişkenlerin set edilmesi
        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->item = $item;
        $viewData->path = $path;
        $viewData->folder_id = $folder_id;
        $viewData->sub_path = $sub_path;
        $viewData->folder_name = $folder_name;

        $this->load->view("{$viewData->viewModule}/contract_v/display/modules/folder_view", $viewData);

    }

    public function create_folder($contract_id)
    {

        // Gelen ID'ye göre veriyi al
        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));

        // Eğer $item bulunamazsa işlem durdurulur
        if (!$item) {
            echo "Geçersiz Contract ID!";
            return;
        }

        // Formdan gelen klasör adı
        $folderName = $this->input->post('folderName');


        // Yeni klasör yolu
        $new_folder = "{$this->File_Dir_Prefix}/{$project->project_code}/{$item->dosya_no}/$folderName";


        // Gelen verilerle işlem yap
        if (!empty($folderName)) {
            if (!is_dir($new_folder)) {

                if (mkdir("$new_folder", 0777, TRUE)) { // Klasör oluştur
                    echo "Klasör başarıyla oluşturuldu!";
                } else {
                    echo "Klasör oluşturulurken bir hata oluştu!";
                }
            } else {
                echo "Klasör zaten mevcut!";
            }
        } else {
            echo "Eksik veri gönderildi!";
        }

        $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Contract/";

        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->item = $item;
        $viewData->path = $path;
        $viewData->sub_path = $new_folder;
        $viewData->folder_name = $folderName;
        $viewData->error_find = $new_folder;

        $this->load->view("{$viewData->viewModule}/contract_v/display/modules/folder_view", $viewData);

    }

    public function download_file($encoded_path)
    {
        // Dosya yolunu decode et
        $file_path = base64_decode(urldecode($encoded_path));

        // Platforma uygun dosya yolunu normalize et
        $file_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file_path);  // / ve \'yi platforma uygun şekilde değiştir

        // Dosyanın var olup olmadığını kontrol et
        if (file_exists($file_path)) {
            // Dosya indirmeye başla
            $this->load->helper('download');
            force_download($file_path, NULL);  // Dosyayı indir
        } else {
            echo "Dosya bulunamadı!";
        }
    }

    public function delete_file($encoded_path)
    {
        // Dosya yolunu decode et
        $file_path = base64_decode(urldecode($encoded_path));

        // Platforma uygun dosya yolunu normalize et
        $file_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file_path);  // / ve \'yi platforma uygun şekilde değiştir

        // Dosyanın var olup olmadığını kontrol et
        if (file_exists($file_path)) {
            // Dosyayı sil
            if (unlink($file_path)) {
                echo "Dosya başarıyla silindi.";
            } else {
                echo "Dosya silinirken bir hata oluştu.";
            }
        } else {
            echo "Dosya bulunamadı!";
        }
    }


}



