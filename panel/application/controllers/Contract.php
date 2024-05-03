<?php

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
        $this->load->model("Books_model");
        $this->load->model("Books_main_model");
        $this->load->model("Books_sub_model");
        $this->load->model("Books_item_model");
        $this->load->model("Books_title_model");
        $this->load->model("Books_item_model");
        $this->load->model("Catalog_model");
        $this->load->model("City_model");
        $this->load->model("Company_model");
        $this->load->model("Condition_model");
        $this->load->model("Contract_file_model");
        $this->load->model("Contract_model");
        $this->load->model("Contract_price_model");
        $this->load->model("Costinc_model");
        $this->load->model("Collection_model");
        $this->load->model("Delete_model");
        $this->load->model("District_model");
        $this->load->model("Drawings_file_model");
        $this->load->model("Drawings_model");
        $this->load->model("Extime_model");
        $this->load->model("Favorite_model");
        $this->load->model("Newprice_model");
        $this->load->model("Order_model");
        $this->load->model("Payment_model");
        $this->load->model("Project_model");
        $this->load->model("Safety_model");
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
        $this->List_Folder = "list";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";
        $this->File_List = "file_list_v";
        $this->Common_Files = "common";

        // Ayarları al
        $this->Settings = get_settings();
    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Contract_model->get_all(array(
            "isActive" => 1,

        ));


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function select()
    {
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

    public function file_form($id = null, $active_tab = null, $error = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        if (empty($id)) {
            $id = $this->input->post("contract_id");
            $active_tab = "payment";
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
        $books = $this->Books_model->get_all(array('isActive' => 1));
        $catalogs = $this->Catalog_model->get_all(array('contract_id' => $id));
        $costincs = $this->Costinc_model->get_all(array('contract_id' => $id));
        $drawings = $this->Drawings_model->get_all(array('contract_id' => $id));
        $extimes = $this->Extime_model->get_all(array('contract_id' => $id));
        $main_bond = $this->Bond_model->get(array('contract_id' => $id, 'teminat_gerekce' => 'contract'));
        $newprices = $this->Newprice_model->get_all(array('contract_id' => $id));
        $payments = $this->Payment_model->get_all(array('contract_id' => $id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1), "rank ASC");
        $sites = $this->Site_model->get_all(array('contract_id' => $id));
        $settings = $this->Settings_model->get();
        $master_catalog = $this->Catalog_model->get(array('contract_id' => $id, "master" => 1));
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1));
        $book_items = $this->Contract_price_model->get_all(array('contract_id' => $id, 'book_id !=' => null));

        // View'e gönderilecek Değişkenlerin Set Edilmesi
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->active_tab = $active_tab;
        $viewData->advances = $advances;
        $viewData->collections = $collections;
        $viewData->bonds = $bonds;
        $viewData->book_items = $book_items;
        $viewData->catalogs = $catalogs;
        $viewData->costincs = $costincs;
        $viewData->drawings = $drawings;
        $viewData->extimes = $extimes;
        $viewData->fav = $fav;
        $viewData->main_bond = $main_bond;
        $viewData->main_groups = $main_groups;
        $viewData->master_catalog = $master_catalog;
        $viewData->newprices = $newprices;
        $viewData->payment_no = $payment_no;
        $viewData->payments = $payments;
        $viewData->prices_main_groups = $prices_main_groups;
        $viewData->settings = $settings;
        $viewData->sites = $sites;

        $form_errors = $this->session->flashdata('form_errors');

        if (!empty($form_errors)) {
            $viewData->form_errors = $form_errors;
        } else {
            $viewData->form_errors = null;

        }

        if ($active_tab == "workplan" && isset($error)) {
            $viewData->error_workplan = "Ödenek Dilimleri Toplamı Sözleşme Toplam Bedeli ile Aynı Olmalıdır<br>Fark Tutar = " . money_format($error);
        } elseif ($active_tab == "sitedel" && isset($error)) {
            $viewData->error = "Yer Teslimi Tarihi, Sözleşme Tarihinden Önce Olamaz";
        } elseif ($active_tab == "provision" && isset($error)) {
            $viewData->error = "Geçici Kabul Tarihi, Sözleşme Tarihinden Önce Olamaz";
        }

        $viewData->item = $this->Contract_model->get(array("id" => $id));


        // İlgili dosya verilerini al
        $viewData->item_files = $this->Contract_file_model->get_all(array("$this->Dependet_id_key" => $id, "type" => "contract"));
        $viewData->sitedel_files = $this->Contract_file_model->get_all(array("$this->Dependet_id_key" => $id, "type" => "sitedel"));
        $viewData->workplan_files = $this->Contract_file_model->get_all(array("$this->Dependet_id_key" => $id, "type" => "workplan"));
        $viewData->provision_files = $this->Contract_file_model->get_all(array("$this->Dependet_id_key" => $id, "type" => "provision"));
        $viewData->final_files = $this->Contract_file_model->get_all(array("$this->Dependet_id_key" => $id, "type" => "final"));

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form_main($project_id = null)
    {
        if (!isAdmin()) {
            $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$project_id"));
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
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
            $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$project_id"));
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
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

    public function save_main($project_id = null)
    {
        // Kullanıcının admin olup olmadığını ve yetkilendirme işlemini kontrol edin
        if (!isAdmin()) {
            $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$project_id"));
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }

        $is_sub = $this->input->post("is_sub") == 1 ? 1 : 0;
        $is_main = $is_sub == 1 ? 0 : 1;
        $project_code = project_code($project_id);

        $file_name_len = file_name_digits();
        $file_name = "SOZ-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        // Form Validation Kuralları
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[contract.dosya_no]|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("sozlesme_ad", "Sözleşme Ad", "required|trim");

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
            $sozlesme_ad = mb_convert_case($this->input->post("sozlesme_ad"), MB_CASE_TITLE, "UTF-8");


            // Veritabanına Ekleme İşlemi
            $insert = $this->Contract_model->add(
                array(
                    "proje_id" => $project_id,
                    "dosya_no" => $file_name,
                    "sozlesme_ad" => $sozlesme_ad,
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
            $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$project_id"));
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }

        $main_contract = $this->Contract_model->get(array('id' => $main_contract_id));

        $project_id = project_id_cont($main_contract_id);
        $project_code = project_code($project_id);

        $file_name_len = file_name_digits();
        $file_name = "SOZ-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        // Form Validation Kuralları
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[contract.dosya_no]|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("sozlesme_ad", "Sözleşme Ad", "required|trim");

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
            $sozlesme_ad = mb_convert_case($this->input->post("sozlesme_ad"), MB_CASE_TITLE, "UTF-8");

            // Veritabanına Ekleme İşlemi
            $insert = $this->Contract_model->add(
                array(
                    "proje_id" => $project_id,
                    "dosya_no" => $file_name,
                    "sozlesme_ad" => $sozlesme_ad,
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


    public function update_form($id, $from = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        $companys = $this->Company_model->get_all(array());

        $settings = $this->Settings_model->get();

        $not_employers = $this->Company_model->get_all(array());
        $contract = $this->Contract_model->get(array(
            "id" => $id
        ));

        $cities = $this->City_model->get_all(array());
        $distircts = $this->District_model->get_all(array());
        $active_tab = $from;
        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $isverenler = $this->Company_model->get_all(array());

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->settings = $settings;
        $viewData->distircts = $distircts;
        $viewData->companys = $companys;
        $viewData->cities = $cities;
        $viewData->isverenler = $isverenler;
        $viewData->active_tab = $active_tab;
        $viewData->users = $users;

        $viewData->item = $this->Contract_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Contract_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $this->load->library("form_validation");

        $this->form_validation->set_rules("sozlesme_ad", "Sözleşme Ad", "required|trim");

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


            $sozlesme_ad = mb_convert_case($this->input->post("sozlesme_ad"), MB_CASE_TITLE, "UTF-8");

            $update = $this->Contract_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "sozlesme_ad" => $sozlesme_ad,
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


            $viewData = new stdClass();
            $yukleniciler = $this->Company_model->get_all(array());
            $yuklenici_users = $this->User_model->get_all(array("user_role" => 2));
            $isveren_users = $this->User_model->get_all(array("user_role" => 1));

            $settings = $this->Settings_model->get();

            $not_employers = $this->Company_model->get_all(array());
            $contract = $this->Contract_model->get(array(
                "id" => $id
            ));

            $cities = $this->City_model->get_all(array());
            $distircts = $this->District_model->get_all(array());
            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));
            $isverenler = $this->Company_model->get_all(array());


            $active_tab = null;
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->form_error = true;
            $viewData->settings = $settings;
            $viewData->yukleniciler = $yukleniciler;
            $viewData->yuklenici_users = $yuklenici_users;
            $viewData->distircts = $distircts;
            $viewData->isveren_users = $isveren_users;
            $viewData->not_employers = $not_employers;
            $viewData->cities = $cities;
            $viewData->isverenler = $isverenler;
            $viewData->users = $users;

            $viewData->item = $this->Contract_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Contract_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                ),
            );

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

        $viewData->item_files = $this->Contract_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
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

    public function workplan_date($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $sozlesme_tarihi = dateFormat('d-m-Y', get_from_any("contract", "sozlesme_tarih", "id", "$id"));

        $this->load->library("form_validation");

        $this->form_validation->set_rules("workplan_date", "Program Teslim Tarihi", "callback_workplan_contractday[$sozlesme_tarihi]|required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $work_plan = dateFormat('Y-m-d', $this->input->post("workplan_date"));

            $update = $this->Contract_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "workplan_date" => $work_plan,
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
            redirect(base_url("$this->Module_Name/file_form/$id/workplan"));

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Yer Teslim Tarihi,$sozlesme_tarihi olan Sözleşme Tarihinden Önce Olamaz",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("$this->Module_Name/file_form/$id/workplan/error"));

        }
    }

    public function workplan_payment($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        if (!empty($this->input->post("old_payment[]"))) {

            $payments_array = $this->input->post("workplan_payment[]");
            $payments_old_array = $this->input->post("old_payment[]");

            $clear_array = array();
            foreach ($payments_array as $payments) {
                foreach ($payments as $payment) {
                    $clear_array[] = $payment;
                }
            }

            $data_payment = json_encode(array_filter(array_merge($payments_old_array, $clear_array), 'strlen'));
        } else {
            $payments_array = $this->input->post("workplan_payment[]");
            $clear_array = array();
            foreach ($payments_array as $payments) {
                foreach ($payments as $payment) {
                    $clear_array[] = $payment;
                }
            }
            print_r($clear_array);

            $data_payment = json_encode(array_filter($clear_array, 'strlen'));
        }

        if ((array_sum(json_decode($data_payment))) != (limit_cost($id))) {
            $check = array_sum(json_decode($data_payment)) - limit_cost($id);
        }

        $update = $this->Contract_model->update(
            array(
                "id" => $id
            ),
            array(
                "workplan_payment" => $data_payment,
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
        redirect(base_url("$this->Module_Name/file_form/$id/workplan/$check"));
    }

    public function provision_date($id)
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $sozlesme_tarihi = dateFormat('d-m-Y', get_from_any("contract", "sozlesme_tarih", "id", "$id"));

        $this->load->library("form_validation");

        $this->form_validation->set_rules("provision_date", "Geçici Kabul Tarihi", "callback_provision_contractday[$sozlesme_tarihi]|required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );


        $validate = $this->form_validation->run();

        if ($validate) {

            $provision_date = dateFormat('Y-m-d', $this->input->post("provision_date"));

            $update = $this->Contract_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "provision_date" => $provision_date,
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
            redirect(base_url("$this->Module_Name/file_form/$id/provision"));

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Yer Teslim Tarihi,$sozlesme_tarihi olan Sözleşme Tarihinden Önce Olamaz",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("$this->Module_Name/file_form/$id/provision/error"));

        }
    }

    public function final_date($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $gecici_kabul_tarihi = dateFormat('d-m-Y', get_from_any("contract", "provision_date", "id", "$id"));

        $this->load->library("form_validation");

        $this->form_validation->set_rules("final_date", "Geçici Kabul Tarihi", "callback_final_contractday[$gecici_kabul_tarihi]|required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $final_date = dateFormat('Y-m-d', $this->input->post("final_date"));

            $update = $this->Contract_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "final_date" => $final_date,
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
            redirect(base_url("$this->Module_Name/file_form/$id/final"));

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Kesin Kabul Tarihi,$gecici_kabul_tarihi olan Geçici Kabul Tarihinden Önce Olamaz",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("$this->Module_Name/file_form/$id/final/error"));

        }
    }

    public function delete_form($error_list_id)
    {
        $contract_id = get_from_any("delete_error", "module_id", "id", "$error_list_id");

        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $viewData = new stdClass();

        $project_id = project_id_cont($contract_id);
        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "delete_form";
        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;

        $viewData->item = $this->Delete_model->get(
            array(
                "id" => $error_list_id
            )
        );

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

        $payments = $this->Payment_model->get_all(array('contract_id' => $id));
        foreach ($payments as $payment) {
            $file_ids[] = "Payment*" . $payment->id;
        }

        $bonds = $this->Bond_model->get_all(array('contract_id' => $id));
        foreach ($bonds as $bond) {
            $file_ids[] = "Bond*" . $bond->id;
        }


        $advances = $this->Advance_model->get_all(array('contract_id' => $id));
        foreach ($advances as $advance) {
            $file_ids[] = "Advance*" . $advance->id;
        }

        $drawings = $this->Drawings_model->get_all(array('contract_id' => $id));
        foreach ($drawings as $drawing) {
            $file_ids[] = "Drawings*" . $drawing->id;
        }

        $costincs = $this->Costinc_model->get_all(array('contract_id' => $id));
        foreach ($costincs as $costinc) {
            $file_ids[] = "Costinc*" . $costinc->id;
        }

        $newprices = $this->Newprice_model->get_all(array('contract_id' => $id));
        foreach ($newprices as $newprice) {
            $file_ids[] = "Newprice*" . $newprice->id;
        }

        $extimes = $this->Extime_model->get_all(array('contract_id' => $id));
        foreach ($extimes as $extime) {
            $file_ids[] = "Extime*" . $extime->id;
        }

        $catalogs = $this->Catalog_model->get_all(array('contract_id' => $id));
        foreach ($catalogs as $catalog) {
            $file_ids[] = "Catalog*" . $catalog->id;
        }

        $sites = $this->Site_model->get_all(array('contract_id' => $id));
        foreach ($sites as $site) {
            $file_ids[] = "Site*" . $site->id;
        }

        $error_log = $this->Delete_model->get(
            array(
                "module_name" => "Contract",
                "module_id" => "$id",
            )
        );

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

            $delete_contract_files = $this->Contract_file_model->delete(array("$this->Dependet_id_key" => $id));
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

        $delete_module_list = array("advance", "bond", "costinc", "drawings", "extime", "payment", "catalog", "newprice");
        foreach ($delete_module_list as $module) {
            if (!empty($module_ids = get_from_any_array_select_ci("id", "$module", "contract_id", $id))) {
                foreach ($module_ids as $module_id) {
                    $this->db->where(array("id" => $module_id))->delete($module);
                    $module_file = $module . "_files";
                    $module_name_id = $module . "_id";
                    $this->db->where(array($module_name_id => $module_id))->delete($module_file);
                }
            }
        }

        $delete_contract_files = $this->Contract_file_model->delete(array("$this->Dependet_id_key" => $id));
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
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $contract_id = $id;
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $id);

        $config["allowed_types"] = "*";

        $config["upload_path"] = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/$type";
        if (!is_dir($config["upload_path"])) {
            mkdir($config["upload_path"], 0777, TRUE);
        }

        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            if (empty($type)) {
                $this->Contract_file_model->add(
                    array(
                        "img_url" => $uploaded_file,
                        "type" => "contract",
                        "createdAt" => date("Y-m-d H:i:s"),
                        "createdBy" => active_user_id(),
                        "$this->Dependet_id_key" => $id,
                        "size" => $size
                    )
                );
            } else {
                $this->Contract_file_model->add(
                    array(
                        "img_url" => $uploaded_file,
                        "type" => "$type",
                        "createdAt" => date("Y-m-d H:i:s"),
                        "createdBy" => active_user_id(),
                        "$this->Dependet_id_key" => $id,
                        "size" => $size
                    )
                );
            }


        } else {
            echo "islem basarisiz";
            echo $config["upload_path"];
        }

    }

    public function file_download($contract_file_id, $where = null)
    {
        $fileName = $this->Contract_file_model->get(array("id" => $contract_file_id));
        $contract_id = contract_id_module("contract_file", $contract_file_id);
        $contract_code = contract_code($contract_id);
        $project_id = project_id_cont($contract_id);

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_code = project_code($project_id);
        $file_path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/Contract/$fileName->img_url";

        if (file_exists($file_path)) {
            // Dosya içeriğini al
            $data = file_get_contents($file_path);
            // İndirme işlemini başlat
            force_download($fileName->img_url, $data);
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Dosya indirildi",
                "type" => "success"
            );
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$contract_id"));
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Dosya veritabanında var ancak klasör içinden silinmiş, SİSTEM YÖNETİCİNİZE BAŞVURUN",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$contract_id"));
        }
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
        $cont_name = get_from_id("contract", "sozlesme_ad", $cont_id);

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


    public function refresh_file_list($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->item = $this->Contract_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Contract_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id,
                "type" => "Contract"

            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;
    }

    public function refresh_site_list($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->item = $this->Contract_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->sitedel_files = $this->Contract_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id,
                "type" => "sitedel"
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/sitedel_list_v", $viewData, true);

        echo $render_html;

    }

    public function refresh_provision_list($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->item = $this->Contract_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->provision_files = $this->Contract_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id,
                "type" => "provision"
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/provision_list_v", $viewData, true);

        echo $render_html;

    }

    public function refresh_final_list($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->item = $this->Contract_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->final_files = $this->Contract_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id,
                "type" => "final"
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/final_list_v", $viewData, true);

        echo $render_html;

    }

    public function refresh_workplan_list($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->item = $this->Contract_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->workplan_files = $this->Contract_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id,
                "type" => "workplan"
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/workplan_list_v", $viewData, true);

        echo $render_html;

    }


    public function fileDelete($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $fileName = $this->Contract_file_model->get(
            array(
                "id" => $id
            )
        );

        $contract_id = get_from_id("contract_files", "contract_id", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $dosya_no = contract_code($contract_id);
        $delete = $this->Contract_file_model->delete(
            array(
                "id" => $id
            )
        );
        if ($delete) {

            $alert = array(
                "title" => "Dosya Sil",
                "text" => "Dosyayı Başarılı Bir Şekilde Sildiniz",
                "type" => "success"
            );
            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Contract_model->get(
                array(
                    "id" => $contract_id
                )
            );
            $viewData->item_files = $this->Contract_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $contract_id,
                    "type" => "contract"
                )
            );

            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$dosya_no/Contract/$fileName->img_url";
            unlink($path);

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;


        } else {
            $alert = array(
                "title" => "Dosya Silinemedi",
                "text" => " $fileName->img_url Dosyası Silme Başarısz",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);
        }
    }

    public function SitefileDelete($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;


        $fileName = $this->Contract_file_model->get(
            array(
                "id" => $id
            )
        );

        $contract_id = get_from_id("contract_files", "contract_id", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $dosya_no = get_from_id("contract", "dosya_no", ($contract_id));

        $delete = $this->Contract_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            $alert = array(
                "title" => "Dosya Sil",
                "text" => "Dosyayı Başarılı Bir Şekilde Sildiniz",
                "type" => "success"
            );
            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Contract_model->get(
                array(
                    "id" => $contract_id
                )
            );

            $viewData->sitedel_files = $this->Contract_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $contract_id,
                    "type" => "sitedel"
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/sitedel_list_v", $viewData, true);

            echo $render_html;

            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$dosya_no/sitedel/$fileName->img_url";
            unlink($path);
        } else {
            $alert = array(
                "title" => "Dosya Silinemedi",
                "text" => " $fileName->img_url Dosyası Silme Başarısz",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);
        }

    }

    public function WorkplanfileDelete($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;


        $fileName = $this->Contract_file_model->get(
            array(
                "id" => $id
            )
        );

        $contract_id = get_from_id("contract_files", "contract_id", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $dosya_no = get_from_id("contract", "dosya_no", ($contract_id));

        $delete = $this->Contract_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            $alert = array(
                "title" => "Dosya Sil",
                "text" => "Dosyayı Başarılı Bir Şekilde Sildiniz",
                "type" => "success"
            );
            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Contract_model->get(
                array(
                    "id" => $contract_id
                )
            );

            $viewData->workplan_files = $this->Contract_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $contract_id,
                    "type" => "workplan"
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/workplan_list_v", $viewData, true);

            echo $render_html;

            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$dosya_no/workplan/$fileName->img_url";
            unlink($path);
        } else {
            $alert = array(
                "title" => "Dosya Silinemedi",
                "text" => " $fileName->img_url Dosyası Silme Başarısz",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);
        }

    }

    public function ProvisionfileDelete($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;


        $fileName = $this->Contract_file_model->get(
            array(
                "id" => $id
            )
        );

        $contract_id = get_from_id("contract_files", "contract_id", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $dosya_no = get_from_id("contract", "dosya_no", ($contract_id));

        $delete = $this->Contract_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            $alert = array(
                "title" => "Dosya Sil",
                "text" => "Dosyayı Başarılı Bir Şekilde Sildiniz",
                "type" => "success"
            );
            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Contract_model->get(
                array(
                    "id" => $contract_id
                )
            );

            $viewData->provision_files = $this->Contract_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $contract_id,
                    "type" => "provision"
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/provision_list_v", $viewData, true);

            echo $render_html;

            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$dosya_no/provision/$fileName->img_url";
            unlink($path);
        } else {
            $alert = array(
                "title" => "Dosya Silinemedi",
                "text" => " $fileName->img_url Dosyası Silme Başarısz",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);
        }

    }

    public function FinalfileDelete($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;


        $fileName = $this->Contract_file_model->get(
            array(
                "id" => $id
            )
        );

        $contract_id = get_from_id("contract_files", "contract_id", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $dosya_no = get_from_id("contract", "dosya_no", ($contract_id));

        $delete = $this->Contract_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            $alert = array(
                "title" => "Dosya Sil",
                "text" => "Dosyayı Başarılı Bir Şekilde Sildiniz",
                "type" => "success"
            );
            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Contract_model->get(
                array(
                    "id" => $contract_id
                )
            );

            $viewData->final_files = $this->Contract_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $contract_id,
                    "type" => "final"
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/final_list_v", $viewData, true);

            echo $render_html;

            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$dosya_no/final/$fileName->img_url";
            unlink($path);
        } else {
            $alert = array(
                "title" => "Dosya Silinemedi",
                "text" => " $fileName->img_url Dosyası Silme Başarısz",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);
        }

    }


    public function fileDelete_all($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);

        $delete = $this->Contract_file_model->delete(
            array(
                "$this->Dependet_id_key" => $contract_id,
                "type" => "contract"
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/Contract");

            foreach ($dir_files as $dir_file) {
                unlink("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/Contract/$dir_file");
            }

            $alert = array(
                "title" => "Tüm Dosyalar Silindi",
                "text" => " Tüm Dosyaları Silme Başarılı",
                "type" => "success"
            );

            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Contract_model->get(
                array(
                    "id" => $contract_id
                )
            );

            $viewData->item_files = $this->Contract_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $contract_id,
                    "type" => "contract"
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/file_list_v", $viewData, true);

            echo $render_html;

        }
    }

    public function fileDelete_all_sitedel($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);

        $delete = $this->Contract_file_model->delete(
            array(
                "$this->Dependet_id_key" => $contract_id,
                "type" => "sitedel"
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/sitedel");

            foreach ($dir_files as $dir_file) {
                unlink("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/sitedel/$dir_file");
            }

            $alert = array(
                "title" => "Tüm Dosyalar Silindi",
                "text" => " Tüm Dosyaları Silme Başarılı",
                "type" => "success"
            );

            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Contract_model->get(
                array(
                    "id" => $contract_id
                )
            );

            $viewData->sitedel_files = $this->Contract_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $contract_id,
                    "type" => "sitedel"
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/sitedel_list_v", $viewData, true);

            echo $render_html;

        }
    }

    public function fileDelete_all_workplan($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);

        $delete = $this->Contract_file_model->delete(
            array(
                "$this->Dependet_id_key" => $contract_id,
                "type" => "workplan"
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/workplan");

            foreach ($dir_files as $dir_file) {
                unlink("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/workplan/$dir_file");
            }

            $alert = array(
                "title" => "Tüm Dosyalar Silindi",
                "text" => " Tüm Dosyaları Silme Başarılı",
                "type" => "success"
            );

            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Contract_model->get(
                array(
                    "id" => $contract_id
                )
            );

            $viewData->sitedel_files = $this->Contract_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $contract_id,
                    "type" => "workplan"
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/workplan_list_v", $viewData, true);

            echo $render_html;

        }
    }

    public function fileDelete_all_provision($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);

        $delete = $this->Contract_file_model->delete(
            array(
                "$this->Dependet_id_key" => $contract_id,
                "type" => "provision"
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/provision");

            foreach ($dir_files as $dir_file) {
                unlink("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/provision/$dir_file");
            }

            $alert = array(
                "title" => "Tüm Dosyalar Silindi",
                "text" => " Tüm Dosyaları Silme Başarılı",
                "type" => "success"
            );

            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Contract_model->get(
                array(
                    "id" => $contract_id
                )
            );

            $viewData->sitedel_files = $this->Contract_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $contract_id,
                    "type" => "provision"
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/provision_list_v", $viewData, true);

            echo $render_html;

        }
    }

    public function fileDelete_all_final($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);

        $delete = $this->Contract_file_model->delete(
            array(
                "$this->Dependet_id_key" => $contract_id,
                "type" => "final"
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/final");

            foreach ($dir_files as $dir_file) {
                unlink("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/final/$dir_file");
            }

            $alert = array(
                "title" => "Tüm Dosyalar Silindi",
                "text" => " Tüm Dosyaları Silme Başarılı",
                "type" => "success"
            );

            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Contract_model->get(
                array(
                    "id" => $contract_id
                )
            );

            $viewData->sitedel_files = $this->Contract_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $contract_id,
                    "type" => "final"
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/final_list_v", $viewData, true);

            echo $render_html;

        }
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

    public function workplan_contractday($workplan_date, $contract_day)
    {
        $date_diff = date_minus($workplan_date, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function provision_contractday($provision_date, $contract_day)
    {
        $date_diff = date_minus($provision_date, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function final_contractday($final_date, $contract_day)
    {
        $date_diff = date_minus($final_date, $contract_day);
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
                    "title" => project_name(project_id_cont($id)) . " / " . contract_name($id)
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

            $book_items = $this->Books_model->get_all(array());
            $criteria = array(
                'isActive' => 1,  // isActive özelliğine göre büyükten küçüğe sırala
            );
            $sortedBooks = sortArrayByCriteria($book_items, $criteria);

            $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->item = $item;
            $viewData->sortedBooks = $sortedBooks;

            $viewData->main_groups = $main_groups;
            $viewData->sub_groups = $sub_groups;

        } else {

            $item = $this->Contract_model->get(array("id" => $contract_id));
            $book_items = $this->Books_model->get_all(array());
            $criteria = array(
                'isActive' => 1,  // isActive özelliğine göre büyükten küçüğe sırala
            );

            $sortedBooks = sortArrayByCriteria($book_items, $criteria);

            $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->item = $item;
            $viewData->main_groups = $main_groups;
            $viewData->sub_groups = $sub_groups;
            $viewData->sortedBooks = $sortedBooks;
            $viewData->form_error = true;

        }
        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/boq_list_v", $viewData, true);
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

    public function back_to_book($contract_id)
    {

        $book_items = $this->Books_model->get_all(array());
        $item = $this->Contract_model->get(array("id" => $contract_id));

        $sortedBooks = sortArrayByCriteria($book_items, (array('isActive' => 1)));

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->sortedBooks = $sortedBooks;
        $viewData->item = $item;


        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/modules/book", $viewData, true);
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

        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/boq_list_v", $viewData, true);
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

        $render_boq = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/boq_list_v", $viewData, true);
        echo $render_boq;

    }

    public
    function delete_boq($contract_id, $boq_id)
    {

        $get_main_group = get_from_any("book", "parent", "id", $boq_id);


        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;


        $main_categories = $this->Books_model->get_all(array('main_category' => 1));


        $item = $this->Contract_model->get(
            array(
                "id" => $contract_id
            )
        );
        $viewData->item = $item;

        $viewData->main_categories = $main_categories;

        $viewData->item_files = $this->Contract_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $contract_id
            ),
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/boq_list_v", $viewData, true);

        echo $render_html;

    }

    public
    function save_price($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $boqs = $this->input->post("boq[]");

        $filtered_boqs = array_filter($boqs, function ($value) {
            return !empty($value['id']) || !empty($value['code']) || !empty($value['name']);
        });

        foreach ($filtered_boqs as $boq_id => $values) {
            if (!empty($values['id'])) {
                $update = $this->Contract_price_model->update(
                    array(
                        "id" => $boq_id
                    ),
                    array(
                        "code" => $values['code'],
                        "name" => $values['name'],
                        "unit" => $values['unit'],
                        "qty" => $values['qty'],
                        "price" => $values['price'],
                        "total" => $values['total']
                    ));
            } else {
                $sub = $this->Contract_price_model->get(array("id" => $boq_id));
                $insert = $this->Contract_price_model->add(
                    array(
                        "contract_id" => $contract_id,
                        "main_id" => $sub->parent,
                        "sub_id" => $sub->id,
                        "code" => $values['code'],
                        "name" => $values['name'],
                        "unit" => $values['unit'],
                        "qty" => $values['qty'],
                        "price" => $values['price'],
                        "total" => $values['total']
                    )
                );
            }
        }


        $sub_groups = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "sub_group" => 1));
        foreach ($sub_groups as $sub_group) {
            $group_total = $this->Contract_price_model->sum_all(array("sub_id" => $sub_group->id, "contract_id" => $contract_id), "total");
            $update = $this->Contract_price_model->update(
                array(
                    "id" => $sub_group->id
                ),
                array(
                    "qty" => null,
                    "price" => null,
                    "total" => $group_total
                ));
        }

        $main_groups = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => 1));
        foreach ($main_groups as $main_group) {
            $sub_group_total = $this->Contract_price_model->sum_all(array("parent" => $main_group->id, "contract_id" => $contract_id, "sub_group" => 1), "total");
            $update = $this->Contract_price_model->update(
                array(
                    "id" => $main_group->id
                ),
                array(
                    "qty" => null,
                    "price" => null,
                    "total" => $sub_group_total
                ));
        }


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

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1), "rank ASC");


        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->prices_main_groups = $prices_main_groups;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/modules/price_update", $viewData, true);

        echo $render_html;

    }

    public
    function drag_drop_price($contract_id, $book_id , $sub_id )
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $boq = $this->Contract_price_model->get(array("id" => $book_id));
        $sub = $this->Contract_price_model->get(array("id" => $sub_id));


        $insert = $this->Contract_price_model->add(
            array(
                "contract_id" => $contract_id,
                "sub_id" => $sub_id,
                "main_id" => $sub->parent,
                "name" => $boq->name,
                "unit" => $boq->unit,
            ));

        // TODO Alert sistemi eklenecek...
        if ($insert) {
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

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1), "rank ASC");
        $book_items = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'book_id !=' => null));


        $viewData = new stdClass();

        $viewData->book_items = $book_items;

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->prices_main_groups = $prices_main_groups;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/modules/price_update", $viewData, true);

        echo $render_html;

    }

    public
    function delete_contract_price($item_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $contract_price = $this->Contract_price_model->get(array("id" => $item_id));
        $contract_id = $contract_price->contract_id;
        $delete = $this->Contract_price_model->delete(
            array(
                "id" => $item_id,
            ));

        // TODO Alert sistemi eklenecek...
        if ($delete) {
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

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1), "rank ASC");


        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->prices_main_groups = $prices_main_groups;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/modules/price_update", $viewData, true);

        echo $render_html;

    }


    public
    function show_main($contract_id, $book_id)
    {
        $main_groups = $this->Books_main_model->get_all(array(
            'book_id' => $book_id,
        ));

        $item = $this->Contract_model->get(array("id" => $contract_id));


        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;

        $viewData->main_groups = $main_groups;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/book_main", $viewData, true);

        echo $render_html;

    }

    public
    function show_sub($contract_id, $main_id)
    {
        $sub_groups = $this->Books_sub_model->get_all(array(
            'main_id' => $main_id,
        ));

        $main_group = $this->Books_main_model->get(array(
            'id' => $main_id,
        ));

        $item = $this->Contract_model->get(array("id" => $contract_id));

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->main_id = $main_id;
        $viewData->book_id = $main_group->book_id;

        $viewData->sub_groups = $sub_groups;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/book_sub", $viewData, true);

        echo $render_html;

    }

    public
    function show_item($contract_id, $sub_id)
    {
        $book_titles = $this->Books_title_model->get_all(array(
            'sub_id' => $sub_id,
        ));

        $sub_group = $this->Books_sub_model->get(array(
            'id' => $sub_id,
        ));

        $book_items = $this->Books_item_model->get_all(array(
            'sub_id' => $sub_id,
        ));

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "display";

        $viewData->item = $item;
        $viewData->book_titles = $book_titles;
        $viewData->book_items = $book_items;
        $viewData->main_id = $sub_group->main_id;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/book_items", $viewData, true);

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
    function add_item_sub($contract_id, $item_id, $sub_id)
    {
        $item = $this->Contract_model->get(array('id' => $contract_id));
        $sub_group = $this->Contract_price_model->get(array('id' => $sub_id));
        $main_group = $this->Contract_price_model->get(array('id' => $sub_group->parent));

        $book_item = $this->Books_item_model->get(array('id' => $item_id));

        $book_name = get_from_any("books", "code", "id", "$book_item->book_id");
        $main_code = get_from_any("books_main", "main_code", "id", "$book_item->main_id");
        $sub_code = get_from_any("books_sub", "sub_code", "id", "$book_item->sub_id");
        $title_code = get_from_any("books_title", "title_code", "id", "$book_item->title_id");

        $code = $book_name . "." . $main_code . "." . $sub_code . "." . $title_code . "." . $book_item->item_code;

        $item_isset = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "book_id" => $book_item->book_id, "item_id" => $item_id));

        if (empty($item_isset)) {
            $insert = $this->Contract_price_model->add(
                array(
                    "contract_id" => $contract_id,
                    "book_id" => $book_item->book_id,
                    "main_id" => $main_group->id,
                    "sub_id" => $sub_group->id,
                    "item_id" => $book_item->id,
                    "name" => $book_item->item_name,
                    "unit" => $book_item->item_unit,
                    "code" => $code,
                )
            );
        }

        $sub_cont_items = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_id" => $sub_id));

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->main_group = $main_group;
        $viewData->sub_group = $sub_group;
        $viewData->sub_cont_items = $sub_cont_items;
        $viewData->sub_id = $sub_id;

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

    function print_report($contract_id, $P_or_D = null)
    {
        $contract = $this->Contract_model->get(array("id" => $contract_id));
        $extimes = $this->Extime_model->get_all(array("contract_id" => $contract_id));
        $costincs = $this->Costinc_model->get_all(array("contract_id" => $contract_id));
        $payments = $this->Payment_model->get_all(array("contract_id" => $contract_id));
        $advances = $this->Advance_model->get_all(array("contract_id" => $contract_id));
        $bonds = $this->Bond_model->get_all(array("contract_id" => $contract_id));
        $collections = $this->Collection_model->get_all(array("contract_id" => $contract_id), "tahsilat_tarih ASC");

        $viewData = new stdClass();

        $viewData->contract = $contract;

        $advance_given = sum_from_table("advance", "avans_miktar", $contract->id);

        $total_payment_A = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "A");
        $total_payment_B = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "B");
        $total_payment_F = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "F");
        $total_payment_G = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "G");
        $total_payment_H = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "H");
        $total_payment_I = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "I");
        $total_payment_Kes_e = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "Kes_e");
        $total_payment_balance = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "balance");
        $total_collections = $this->Collection_model->sum_all(array('contract_id' => $contract->id), "tahsilat_miktar");

        $contractor = $this->Company_model->get(array("id" => $contract->yuklenici));
        $owner = $this->Company_model->get(array("id" => $contract->isveren));

        $viewData->contractor = $contractor;
        $viewData->owner = $owner;

        $yuklenici = company_name($contract->yuklenici);
        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        $page_width = $pdf->getPageWidth();


        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();


// Çerçeve için boşlukları belirleme
        $topMargin = 20;  // 4 cm yukarıdan
        $bottomMargin = 20;  // 4 cm aşağıdan
        $rightMargin = 10;  // 2 cm sağdan
        $leftMargin = 10;  // 2 cm soldan

// Çerçeve renk ve kalınlığını ayarla
        $pdf->SetDrawColor(0, 0, 0); // Siyah renk
        $pdf->SetLineWidth(0.5); // Çizgi kalınlığı

// Çerçeve çizme
        $pdf->Rect($leftMargin, $topMargin, $pdf->getPageWidth() - $rightMargin - $leftMargin, $pdf->getPageHeight() - $bottomMargin - $topMargin);

        $pdf->SetFont('dejavusans', 'B', 12);

// Metin eklemek (örnek olarak ilk satır)
        $yPosition = $topMargin; // 5 cm yukarıdan başla
        $xPosition = $leftMargin; // 2 cm soldan başla
        $pdf->SetXY($xPosition, $yPosition);
        $pdf->SetLineWidth(0.1); // Çizgi kalınlığı
        $pdf->Cell(190, 10, 'SÖZLEŞME RAPORU', 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetX(20);
        $pdf->SetFont('dejavusans', 'B', 8);
        $pdf->Cell(170, 7, mb_strtoupper($contract->sozlesme_ad), 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetX(25);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(32, 5, "Sözleşme Bedeli", 1, 0, "C", 0);
        $pdf->Cell(32, 5, "Sözleşme Tarihi", 1, 0, "C", 0);
        $pdf->Cell(32, 5, "Yer Teslim Tarihi", 1, 0, "C", 0);
        $pdf->Cell(32, 5, "Süresi", 1, 0, "C", 0);
        $pdf->Cell(32, 5, "Bitiş Tarihi", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(25);
        $pdf->SetFont('dejavusans', 'N', 6);
        $pdf->Cell(32, 5, money_format($contract->sozlesme_bedel) . " " . $contract->para_birimi, 1, 0, "C", 0);
        $pdf->Cell(32, 5, dateFormat_dmy($contract->sozlesme_tarih), 1, 0, "C", 0);
        $pdf->Cell(32, 5, dateFormat_dmy($contract->sitedel_date), 1, 0, "C", 0);
        $pdf->Cell(32, 5, $contract->isin_suresi . " Gün", 1, 0, "C", 0);
        $pdf->Cell(32, 5, dateFormat_dmy($contract->sozlesme_bitis), 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(20);
        $pdf->Cell(170, 3, "", 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(20);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(170, 6, 'SÜREYE GÖRE İLERLEME', 0, 0, "C", 0);
        $pdf->SetFont('dejavusans', 'N', 6);
        $pdf->Ln(); // Yeni satıra geç

        $sonSatirY = $pdf->GetY();

        $contrac_start_y = $sonSatirY;
        $bar_height = 8;
        $start_x = 25;
        $bar_width = 70;
        $last_x = $start_x + $bar_width;
        $row_height = 8;

        $elapsed_Day = fark_gun($contract->sozlesme_tarih);
        $total_day = $contract->isin_suresi;
        $percantage = $elapsed_Day / $total_day * 100;
        $pdf->progress_bar($percantage, $bar_height, $bar_width, $contrac_start_y, $start_x, $last_x); // Yeni satıra geç
        $remain_day = ($total_day - $elapsed_Day);
        if ($elapsed_Day > $total_day) {
            $elapsed_Day = " -";
        }
        if ($remain_day < 0) {
            $remain_day = " -";
        }
        $pdf->SetY($contrac_start_y); // Yeni satıra geç
        $pdf->SetX(95); // Yeni satıra geç
        $pdf->Cell(30, 4, "Sözleşme Süresi", 1, 0, "C", 0);
        $pdf->Cell(30, 4, 'Geçen Süre', 1, 0, "C", 0);
        $pdf->Cell(30, 4, 'Kalan Süre', 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(95); // Yeni satıra geç
        $pdf->Cell(30, 4, $contract->isin_suresi . " Gün", 1, 0, "C", 0);
        $pdf->Cell(30, 4, $elapsed_Day . " Gün", 1, 0, "C", 0);
        $pdf->Cell(30, 4, $remain_day . " Gün", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(30, 2, "", 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $contract_time_end_Y = $pdf->GetY();

        $extime_start_y = $contract_time_end_Y;
        $i = 1;
        foreach ($extimes as $extime) {
            $elapsed_Day = fark_gun($extime->baslangic_tarih);
            $total_day = $extime->uzatim_miktar;
            $percantage = $elapsed_Day / $total_day * 100;
            $pdf->progress_bar($percantage, $bar_height, $bar_width, $extime_start_y, $start_x, $last_x); // Yeni satıra geç
            $remain_day = ($total_day - $elapsed_Day);
            if ($elapsed_Day > $total_day) {
                $elapsed_Day = " -";
            }
            if ($remain_day < 0) {
                $remain_day = " -";
            }
            $pdf->SetY($extime_start_y); // Yeni satıra geç
            $pdf->SetX(95); // Yeni satıra geç
            $pdf->Cell(30, 4, $i . "- Süre Uzatımı", 1, 0, "C", 0);
            $pdf->Cell(30, 4, 'Geçen Süre', 1, 0, "C", 0);
            $pdf->Cell(30, 4, 'Kalan Süre', 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(95); // Yeni satıra geç
            $pdf->Cell(30, 4, $extime->uzatim_miktar . " Gün", 1, 0, "C", 0);
            $pdf->Cell(30, 4, $elapsed_Day . " Gün", 1, 0, "C", 0);
            $pdf->Cell(30, 4, $remain_day . " Gün", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $extime_start_y += 10;

        }
        $pdf->Cell(30, 2, "", 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç


        $pdf->SetX(20); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(170, 6, 'FİNANSAL İLERLEME', 0, 0, "C", 0);
        $pdf->SetFont('dejavusans', 'N', 6);
        $pdf->Ln(); // Yeni satıra geç

        $extime_end_Y = $pdf->GetY();

        $contract_price_start_Y = $extime_end_Y;

        $total_payment = $total_payment_A;
        $contract_price = $contract->sozlesme_bedel;

        $percantage = $total_payment / $contract_price * 100;
        $pdf->progress_bar($percantage, $bar_height, $bar_width, $contract_price_start_Y, $start_x, $last_x); // Yeni satıra geç
        if ($total_payment > $contract_price) {
            $remain_contract = "0";
        } else {
            $remain_contract = $contract_price - $total_payment;
        }

        $pdf->SetY($contract_price_start_Y); // Yeni satıra geç
        $pdf->SetX(95); // Yeni satıra geç
        $pdf->Cell(30, 4, "Sözleşme Bedel", 1, 0, "C", 0);
        $pdf->Cell(30, 4, "Hakediş Toplam", 1, 0, "C", 0);
        $pdf->Cell(30, 4, "Sözleşmeden Kalan", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(95); // Yeni satıra geç
        $pdf->Cell(30, 4, money_format($contract->sozlesme_bedel) . " " . $contract->para_birimi, 1, 0, "C", 0);
        $pdf->Cell(30, 4, money_format($total_payment) . " " . $contract->para_birimi, 1, 0, "C", 0);
        $pdf->Cell(30, 4, money_format($remain_contract) . " " . $contract->para_birimi . " Gün", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(30, 2, "", 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $contract_price_end_y = $pdf->GetY();

        $costinc_start_y = $contract_price_end_y;
        $i = 1;
        foreach ($costincs as $costinc) {
            $total_payment = $total_payment_A - $contract_price;
            $total_costinc = +$costinc->artis_miktar;
            $percantage = $total_payment / $total_costinc * 100;
            $pdf->progress_bar($percantage, $bar_height, $bar_width, $costinc_start_y, $start_x, $last_x); // Yeni satıra geç
            if ($total_payment > $total_costinc) {
                $used_costinc = $costinc->artis_miktar;
                $remain_costinc = "0";
            } else {
                $used_costinc = $contract_price + $total_costinc - $total_payment_A;
                $remain_costinc = $total_costinc - ($contract_price + $total_costinc - $total_payment_A);
            }
            $pdf->SetX(95); // Yeni satıra geç
            $pdf->Cell(30, 4, $i++ . " No'lu Keşif Artışı", 1, 0, "C", 0);
            $pdf->Cell(30, 4, "Hakediş Toplam", 1, 0, "C", 0);
            $pdf->Cell(30, 4, "Sözleşmeden Kalan", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(95); // Yeni satıra geç
            $pdf->Cell(30, 4, money_format($costinc->artis_miktar) . " " . $contract->para_birimi, 1, 0, "C", 0);
            $pdf->Cell(30, 4, money_format($used_costinc) . " " . $contract->para_birimi, 1, 0, "C", 0);
            $pdf->Cell(30, 4, money_format($remain_costinc) . " " . $contract->para_birimi . " Gün", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Ln(); // Yeni satıra geç
            $costinc_start_y += 10;
        }
        $costinc_end_y = $pdf->GetY();

        $graph_y_start = $costinc_end_y;
        $pdf->SetX(10); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(190, 6, 'HAKEDİŞ DURUMU', 0, 0, "C", 1);
        $pdf->SetFont('dejavusans', 'N', 6);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 6);
        $pdf->Cell(8, 5, "No", 1, 0, "C", 0);
        $pdf->Cell(28, 5, "Hakediş Tutar", 1, 0, "C",);
        $pdf->Cell(25, 5, "Fiyat Farkı", 1, 0, "C", 0);
        $pdf->Cell(25, 5, "Tahhuk Tutarı", 1, 0, "C", 0);
        $pdf->Cell(25, 5, "Teminat", 1, 0, "C", 0);
        $pdf->Cell(25, 5, "Kesinti", 1, 0, "C", 0);
        $pdf->Cell(25, 5, "Avans Mahsubu", 1, 0, "C", 0);
        $pdf->Cell(29, 5, "Net Bedel", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'N', 6);

        foreach ($payments as $payment) {
            $pdf->SetX(10);
            $pdf->Cell(8, 5, "$payment->hakedis_no", 1, 0, "C", 0);
            $pdf->Cell(28, 5, money_format($payment->A) . " " . $contract->para_birimi, 1, 0, "R",);
            $pdf->Cell(25, 5, money_format($payment->B) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 5, money_format($payment->G) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 5, money_format($payment->Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 5, money_format($payment->H - $payment->Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 5, money_format($payment->I) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(29, 5, money_format($payment->balance) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Ln(); // Yeni satıra geç
        }
        $pdf->SetFont('dejavusans', 'B', 6);

        $pdf->SetX(10);
        $pdf->Cell(8, 5, "∑", 1, 0, "C", 0);
        $pdf->Cell(28, 5, money_format($total_payment_A) . " " . $contract->para_birimi, 1, 0, "R",);
        $pdf->Cell(25, 5, money_format($total_payment_B) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 5, money_format($total_payment_G) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 5, money_format($total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 5, money_format($total_payment_H - $total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 5, money_format($total_payment_I) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(29, 5, money_format($total_payment_balance) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(32, 2, "", 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 5);

        $pdf->Cell(60, 4, "*Teminat Kesintisi : " . money_format($total_payment_Kes_e) . " " . $contract->para_birimi, 0, 0, "L", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->Cell(60, 4, "*Toplam KDV : " . money_format($total_payment_F) . " " . $contract->para_birimi, 0, 0, "L", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(60, 4, "", 0, 0, "L", 0);
        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetX(25); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        if (!empty($advances)) {
            $pdf->Cell(40, 6, 'AVANS DURUMU', 0, 0, "C", 0);
        }
        $pdf->Cell(9, 6, "", 0, 0, "C", 0);

        if (!empty($bonds)) {
            $pdf->Cell(111, 6, 'TEMİNAT DURUMU', 0, 0, "C", 0);
        }
        $pdf->SetFont('dejavusans', 'B', 6);
        $pdf->Ln(); // Yeni satıra geç
        $bonds_start_y = $pdf->GetY();
        if (!empty($advances)) {
            $pdf->SetX(25);
            $pdf->Cell(5, 6, 'No', 1, 0, "C", 0);
            $pdf->Cell(15, 6, 'Avans Tarih', 1, 0, "C", 0);
            $pdf->Cell(20, 6, 'Avans Miktar', 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç

            $pdf->SetFont('dejavusans', 'N', 6);

            $i = 1;
            foreach ($advances as $advance) {
                $pdf->SetX(25);
                $pdf->Cell(5, 6, $i++, 1, 0, "C", 0);
                $pdf->Cell(15, 6, dateFormat_dmy($advance->avans_tarih), 1, 0, "C", 0);
                $pdf->Cell(20, 6, money_format($advance->avans_miktar) . " " . $contract->para_birimi, 1, 0, "R", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
            $pdf->SetX(25);
            $pdf->SetFont('dejavusans', 'B', 6);

            $pdf->Cell(20, 4, "TOPLAM", 1, 0, "L", 0);
            $pdf->Cell(20, 4, money_format($advance_given) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(25);

            $pdf->Cell(20, 4, "Mahsup Edilen", 1, 0, "L", 0);
            $pdf->Cell(20, 4, money_format($total_payment_I) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(25);

            $pdf->Cell(20, 4, "Kalan Avans", 1, 0, "L", 0);
            $pdf->Cell(20, 4, money_format($advance_given - $total_payment_I) . " " . $contract->para_birimi, 1, 0, "R", 0);
        }
        $last_advance_y = $pdf->GetY();


        if (!empty($bonds)) {
            $pdf->SetFont('dejavusans', 'B', 6);
            if (empty($advancesi)) {
                $pdf->SetXY(25, $bonds_start_y);
            } else {
                $pdf->SetXY(74, $bonds_start_y);
            }
            $pdf->Cell(5, 6, 'No', 1, 0, "C", 0);
            $pdf->Cell(18, 6, 'Tür', 1, 0, "C", 0);
            $pdf->Cell(12, 6, 'Gerekçe', 1, 0, "C", 0);
            $pdf->Cell(19, 6, 'Teminat Miktar', 1, 0, "C", 0);
            $pdf->Cell(19, 6, 'Veriliş Tarihi', 1, 0, "C", 0);
            $pdf->Cell(19, 6, 'Vade Tarih', 1, 0, "C", 0);
            $pdf->Cell(19, 6, 'İade Durumu', 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 6);

            $i = 1;
            foreach ($bonds as $bond) {
                if (empty($advancesi)) {
                    $pdf->SetX(25);
                } else {
                    $pdf->SetX(74);
                }
                $pdf->Cell(5, 6, $i++, 1, 0, "C", 0);
                $pdf->Cell(18, 6, $bond->teminat_turu, 1, 0, "C", 0);
                $pdf->Cell(12, 6, module_name($bond->teminat_gerekce), 1, 0, "C", 0);
                $pdf->Cell(19, 6, money_format($bond->teminat_miktar) . " " . $contract->para_birimi, 1, 0, "C", 0);
                $pdf->Cell(19, 6, dateFormat_dmy($bond->teslim_tarihi), 1, 0, "C", 0);
                $pdf->Cell(19, 6, dateFormat_dmy($bond->gecerlilik_tarihi), 1, 0, "C", 0);
                if ($bond->teminat_durumu == 1) {
                    $durum = "İade Edildi";
                } else {
                    $durum = "İşveren";
                }
                $pdf->Cell(19, 6, $durum, 1, 0, "C", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
        }

        $last_bond_y = $pdf->GetY();
        if ($last_bond_y > $last_advance_y) {
            $pdf->SetY($last_bond_y); // Yeni satıra geç
        } else {
            $pdf->SetY($last_advance_y); // Yeni satıra geç
        }

        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->SetX(25);
        if (!empty($collections)) {
            $pdf->Cell(160, 6, 'ÖDEME DURUMU', 0, 0, "C", 0);
        }
        $pdf->SetFont('dejavusans', 'B', 6);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(160, 4, '', 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $bonds_start_y = $pdf->GetY();
        if (!empty($collections)) {
            $pdf->SetX(25);
            $pdf->Cell(5, 6, 'No', 1, 0, "C", 0);
            $pdf->Cell(15, 6, 'Tarih', 1, 0, "C", 0);
            $pdf->Cell(25, 6, 'Miktar', 1, 0, "C", 0);
            $pdf->Cell(35, 6, 'Türü', 1, 0, "C", 0);
            $pdf->Cell(90, 6, 'Aciklama', 1, 0, "C", 0);
            $collection_y = $pdf->GetY();
            $pdf->Ln(); // Yeni satıra geç

            $pdf->SetFont('dejavusans', 'N', 6);

            $i = 1;
            foreach ($collections as $collection) {
                if ($collection->tahsilat_turu == "Çek") {
                    $notice_date = "/ " . dateFormat_dmy($collection->vade_tarih);
                } else {
                    $notice_date = "";
                }
                $pdf->SetX(25);
                $pdf->Cell(5, 6, $i++, 1, 0, "C", 0);
                $pdf->Cell(15, 6, dateFormat_dmy($collection->tahsilat_tarih), 1, 0, "C", 0);
                $pdf->Cell(25, 6, money_format($collection->tahsilat_miktar) . " " . $contract->para_birimi, 1, 0, "R", 0);
                $pdf->Cell(35, 6, $collection->tahsilat_turu . $notice_date, 1, 0, "C", 0);
                $pdf->Cell(90, 6, $collection->aciklama, 1, 0, "L", 0);
                $pdf->Cell(4, 6, "", 0, 0, "C", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
        }
        $pdf->Ln(); // Yeni satıra geç

        $last_collection_y = $pdf->GetY();

        $pdf->SetY($last_collection_y); // Yeni satıra geç

        if (!empty($collections)) {
            $pdf->SetX(25);
            $pdf->Cell(25, 6, "ALACAK", 1, 0, "C", 0);
            $pdf->Cell(25, 6, "TAHSİLAT", 1, 0, "C", 0);
            $pdf->Cell(25, 6, "TEMİNAT", 1, 0, "C", 0);
            $pdf->Cell(25, 6, "DİĞER KESİNTİ", 1, 0, "C", 0);
            $pdf->Cell(25, 6, "KALAN", 1, 0, "C", 0);

            $pdf->SetFont('dejavusans', 'N', 6);
            $pdf->Ln(); // Yeni satıra geç

            $pdf->SetX(25);
            $pdf->Cell(25, 6, money_format($total_payment_G) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 6, money_format($total_collections) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 6, money_format($total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 6, money_format($total_payment_H - $total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 6, money_format($total_payment_Kes_e + $total_payment_balance - $total_collections - $total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Ln(); // Yeni satıra geç
        }


        $file_name = contract_name($contract->id) . "-İlerlerme Raporu";

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }


}




