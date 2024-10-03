<?php

class Site extends CI_Controller
{
    public $viewFolder = "";

    public $moduleFolder = "";

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

        $this->moduleFolder = "site_module";
        $this->viewFolder = "site_v";

        $uploader = APPPATH . 'libraries/FileUploader.php';
        include($uploader);

        $this->load->model("Site_model");
        $this->load->model("Contract_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");
        $this->load->model("Report_model");
        $this->load->model("Report_sign_model");
        $this->load->model("Sitestock_model");
        $this->load->model("Sitewallet_model");
        $this->load->model("Extime_model");
        $this->load->model("Costinc_model");
        $this->load->model("Workman_model");
        $this->load->model("Workgroup_model");
        $this->load->model("Workmachine_model");
        $this->load->model("Favorite_model");
        $settings = $this->Settings_model->get();

        $this->Upload_Folder = "uploads"; // Ana yükleme klasörü
        $this->Module_Name = "Site"; // Modül adı
        $this->Module_Title = "Şantiye Yönetimi"; // Modül başlığı
        $this->Module_Main_Dir = "project_v"; // Ana modül dizini
        $this->File_Dir_Prefix = "{$this->Upload_Folder}/{$this->Module_Main_Dir}"; // Dosya dizin ön eki

        $this->Display_route = "file_form"; // Görüntüleme rotası
        $this->Update_route = "update_form"; // Güncelleme rotası
        $this->Dependet_id_key = "site_id"; // Bağımlı ID anahtarı
        $this->Module_Parent_Name = "contract"; // Modülün ana adı

        // Klasör yapısı
        $this->moduleFolder = "site_module"; // Modül klasörü
        $this->viewFolder = "site_v"; // Görünüm klasörü
        $this->Display_Folder = "display"; // Görüntüleme klasörü
        $this->Add_Folder = "add"; // Ekleme klasörü
        $this->List_Folder = "list"; // Listeleme klasörü
        $this->Select_Folder = "select"; // Seçim klasörü
        $this->Update_Folder = "update"; // Güncelleme klasörü
        $this->Common_Files = "common"; // Ortak dosyalar
        $this->settings = $settings;


    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Site_model->get_all(array());
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
        $items = $this->Site_model->get_all(array());
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

    public function new_form($project_id = null)
    {
        if (empty($project_id)) {
            $project_id = $this->input->post('project_id');
        }

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Site_model->get_all(array());

        $contracts = $this->Contract_model->get_all(array(
            "isActive" => 1,
            'proje_id' => $project_id
        ));

        $subcontracts = $this->Contract_model->get_all(array(
            'isActive' => 1,
            'proje_id' => $project_id
        ));

        $projects = $this->Project_model->get_all(array(
            'id' => $project_id
        ));

        $users = $this->User_model->get_all(array());

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->items = $items;
        $viewData->contracts = $contracts;
        $viewData->subcontracts = $subcontracts;
        $viewData->project_id = $project_id;
        $viewData->projects = $projects;
        $viewData->users = $users;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function save($project_id)
    {

        $file_name_len = file_name_digits();
        $file_name = "SNT-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "is_unique[site.dosya_no]|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("contract_id", "Sözleşme", "required|trim");
        $this->form_validation->set_rules("santiye_sefi", "Şantiye Şefi", "greater_than[0]|required|trim");
        $this->form_validation->set_rules("santiye_ad", "Şantiye Adı", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "greater_than" => "<b>{field}</b> Seçilmelidir",
                "duplicate_name_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$file_name/Main/";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            if ($this->input->post("teslim_tarihi")) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarihi"));
            } else {
                $teslim_tarihi = null;
            }

            $personeller = $this->input->post('teknik_personeller');

            if (!empty($personeller)) {
                $data_personel = implode(",", array_unique($personeller));
            } else {
                $data_personel = null;
            }

            $araclar = $this->input->post('araclar');

            if (!empty($araclar)) {
                $data_araclar = implode(",", array_unique($araclar));
            } else {
                $data_araclar = null;
            }

            $sub_contracts = $this->input->post('sub_contract');

            if (!empty($sub_contracts)) {
                $data_sub_contracts = implode(",", array_unique($sub_contracts));
            } else {
                $data_sub_contracts = null;
            }

            $insert = $this->Site_model->add(
                array(
                    "contract_id" => $contract_id,
                    "proje_id" => $project_id,
                    "contract_id" => $this->input->post('contract_id'),
                    "dosya_no" => $file_name,
                    "santiye_ad" => $this->input->post("santiye_ad"),
                    "santiye_sefi" => $this->input->post("santiye_sefi"),
                    "teknik_personel" => $data_personel,
                    "araclar" => $data_araclar,
                    "is_Active" => "1",
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
            /** Tablodan Verilerin Getirilmesi.. */
            $items = $this->Site_model->get_all(array());

            $contracts = $this->Contract_model->get_all(array(
                "isActive" => 1,
                'proje_id' => $project_id

            ));

            $subcontracts = $this->Contract_model->get_all(array(
                'isActive' => 1,
                'proje_id' => $project_id
            ));

            $projects = $this->Project_model->get_all(array(
                'id' => $project_id
            ));

            $users = $this->User_model->get_all(array());

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->items = $items;
            $viewData->contracts = $contracts;
            $viewData->subcontracts = $subcontracts;
            $viewData->project_id = $project_id;
            $viewData->projects = $projects;
            $viewData->users = $users;
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function sitewallet($site_id, $type)
    {
        // Veritabanından site, sözleşme ve proje bilgilerini alıyoruz
        $item = $this->Site_model->get(array("id" => $site_id));
        $contract = $this->Contract_model->get(array("id" => $item->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $all_expenses = $this->Sitewallet_model->get_all(array("site_id" => $site_id,"type" => 1));
        $total_expense = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "1");

        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->contract = $contract;
        $viewData->all_expenses = $all_expenses;
        $viewData->total_expense = $total_expense;
        $viewData->item = $item;

        // Form validation kütüphanesini yüklüyoruz
        $this->load->library("form_validation");

        // Form doğrulama kuralları ekliyoruz
        $this->form_validation->set_rules('expense_date', 'Tarih', 'required');
        $this->form_validation->set_rules('price', 'Fiyat', 'required|numeric');
        $this->form_validation->set_rules('payment_type', 'Ödeme Türü', 'required');
        $this->form_validation->set_rules('payment_notes', 'Açıklama', 'required');

        // Form doğrulama hatalarını özelleştiriyoruz
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "alpha" => "<b>{field}</b> alanı harflerden oluşmaladır",
                "numeric" => "<b>{field}</b> sayılardan oluşmalıdır",
            )
        );
        // Formun doğrulama işlemi başlatılıyor
        $validate = $this->form_validation->run();
        // Eğer formdan tarih bilgisi gelmişse, formatı Y-m-d olarak ayarlıyoruz
        if ($this->input->post("expense_date")) {
            $date = dateFormat('Y-m-d', $this->input->post("expense_date"));
        } else {
            $date = null; // Eğer tarih girilmediyse, null değer atıyoruz
        }
        // Eğer doğrulama başarılı ise aşağıdaki işlemleri yapıyoruz
        if ($validate) {
            // Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Sitewallet/$date";
            // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "Klasör oluşturuldu";
            } else {
                echo "Aynı isimde dosya mevcut"; // Aynı isimde dosya mevcutsa uyarı veriliyor
            }
            // Yeni site cüzdanı kaydı veritabanına ekleniyor
            $insert = $this->Sitewallet_model->add(
                array(
                    "site_id" => $item->id,
                    "date" => $date,
                    "price" => $this->input->post("price"),
                    "bill_code" => $this->input->post("bill_code"),
                    "payment_type" => $this->input->post("payment_type"),
                    "note" => $this->input->post("payment_notes"),
                    "type" => $type,
                    "createdAt" => date("Y-m-d"),
                    "createdBy" => active_user_id(),
                )
            );
            // Eklenen kaydın ID'si alınarak dosya yüklemesi için kullanılıyor
            $record_id = $this->db->insert_id();
            // Yüklenen dosyanın ismi SEO dostu hale getiriliyor
            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            // Dosya boyutu alınıyor
            $size = $_FILES["file"]["size"];
            // Yükleme ayarları belirleniyor
            $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
            $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
            $config["file_name"] = $record_id; // Dosya adı kaydın ID'si olarak belirleniyor
            $this->load->library("upload", $config);
            $upload = $this->upload->do_upload("file");

            if (!$upload) {
                log_message('error', 'File upload failed: ' . $this->upload->display_errors());
                $viewData->upload_error = $this->upload->display_errors(); // Hata mesajlarını kullanıcıya göstermek için
            }
        } else {
            $viewData->form_error = true; // Formda hata olduğunu belirtiyoruz
            $viewData->error_modal = "AddExpenseModal"; // Hata modali için set edilen değişken
        }

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_4_1_expenses", $viewData);
    }



    public function expense_delete($expense_id)
    {

        $date_folder = get_from_id("sitewallet", "date", "$expense_id");

        $site_id = get_from_id("sitewallet", "site_id", $expense_id);
        $site_code = site_code($site_id);
        $project_id = project_id_site($site_id);
        $project_code = project_code($project_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$site_code/Sitewallet/$date_folder";

        $delete1 = $this->Sitewallet_model->delete(
            array(
                "id" => $expense_id
            )
        );

        if ($file_path && is_dir($file_path)) {
            $files = scandir($file_path);

            foreach ($files as $file) {
                $file_name_without_extension = pathinfo($file, PATHINFO_FILENAME);
                if ($expense_id == $file_name_without_extension) {
                    $path = $file_path . "/" . $file;
                    unlink($path);
                }
            }
        }
    }


    public function file_form($id, $active_tab = null)
    {
        $session_user = $this->session->userdata("user");


        if ($session_user->user_role != 2) {
            if (!isAdmin()) {
                redirect(base_url("error"));
            }
        }

        $item = $this->Site_model->get(
            array(
                "id" => $id
            )
        );

        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $contract = $this->Contract_model->get(array("id" => $item->contract_id));
        $sites = $this->Site_model->get_all(array("is_Active" => 1));
        $upload_function = base_url("$this->Module_Name/file_upload/$item->id");

        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/$item->dosya_no/main/";

        !is_dir($path) && mkdir($path, 0777, TRUE);


        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Report_supply_model");
        $this->load->model("Report_sign_model");
        $this->load->model("Attendance_model");


        $fav = $this->Favorite_model->get(array(
            "user_id" => active_user_id(),
            "module" => "site",
            "view" => "file_form",
            "module_id" => $id,
        ));

        $viewData = new stdClass();
        $settings = $this->Settings_model->get();


        $reports = $this->Report_model->get_all(array("site_id" => $id));

        $contractor_sign = $this->Report_sign_model->get(array("site_id" => $id, "module" => "contractor_sign"));
        $contractor_staff = $this->Report_sign_model->get_all(array("site_id" => $id, "module" => "contractor_staff"));
        $owner_sign = $this->Report_sign_model->get(array("site_id" => $id, "module" => "owner_sign"));
        $owner_staff = $this->Report_sign_model->get_all(array("site_id" => $id, "module" => "owner_staff"));
        $personel_datas = $this->Workman_model->get_all(array("site_id" => $id, "isActive" => 1), "group DESC");
        $year_month = date('Y-m');
        $puantaj = $this->Attendance_model->get(array("site_id" => $id, "year_month" => $year_month));

        $site_stocks = $this->Sitestock_model->get_all(array("site_id" => $item->id, "parent_id" => null));

        $all_expenses = $this->Sitewallet_model->get_all(array(
            "site_id" => $id,
            "type" => 1
        ));

        $all_deposites = $this->Sitewallet_model->get_all(array(
            "site_id" => $id,
            "type" => 0
        ));

        $main_categories = $this->Workgroup_model->get_all(array(
            'main_category' => 1
        ));

        $main_categories_workmachine = $this->Workmachine_model->get_all(array(
            'main_category' => 1
        ));

        $all_workroups = $this->Report_workgroup_model->get_unique_workgroups($id);
        $all_workmachines = $this->Report_workmachine_model->get_unique_workmachine($id);
        $total_expense = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "1");
        $total_deposit = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "0");
        $users = $this->User_model->get_all(array());


        $month = date('n');
        $year = date('Y');

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->path = $path;
        $viewData->upload_function = $upload_function;
        $viewData->active_tab = $active_tab;

        $viewData->all_deposites = $all_deposites;
        $viewData->all_expenses = $all_expenses;
        $viewData->all_workgroups = $all_workroups;
        $viewData->all_workmachines = $all_workmachines;
        $viewData->contract = $contract;
        $viewData->contractor_sign = $contractor_sign;
        $viewData->contractor_staff = $contractor_staff;
        $viewData->sites = $sites;
        $viewData->fav = $fav;
        $viewData->item = $item;
        $viewData->main_categories = $main_categories;
        $viewData->main_categories_workmachine = $main_categories_workmachine;
        $viewData->month = $month;
        $viewData->owner_sign = $owner_sign;
        $viewData->owner_staff = $owner_staff;
        $viewData->personel_datas = $personel_datas;
        $viewData->project = $project;
        $viewData->puantaj = $puantaj;
        if (!empty($puantaj->puantaj)) {
            $viewData->puantaj_data = json_decode($puantaj->puantaj, true);
        }
        $viewData->reports = $reports;
        $viewData->settings = $settings;
        $viewData->site_stocks = $site_stocks;
        $viewData->total_expense = $total_expense;
        $viewData->total_deposit = $total_deposit;
        $viewData->users = $users;
        $viewData->workgroups = json_decode($item->active_group, true);
        $viewData->workmachines = json_decode($item->active_machine, true);
        $viewData->year = $year;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function update_form($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        $project_id = get_from_id("site", "proje_id", "$id");
        $contract_id = get_from_id("site", "contract_id", "$id");

        $active_conn_contracts = $this->Contract_model->get_all(array(
            "isActive" => 1,
            'proje_id' => $project_id

        ));

        $active_subcontracts = $this->Contract_model->get_all(array(
            'isActive' => 1,
            'proje_id' => $project_id
        ));

        $users = $this->User_model->get_all(array());


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        if (!empty($contract_id)) {
            $viewData->subViewFolder = "update_contract";
        } else {
            $viewData->subViewFolder = "update_project";
        }
        $viewData->active_conn_contracts = $active_conn_contracts;
        $viewData->active_subcontracts = $active_subcontracts;
        $viewData->users = $users;

        $viewData->item = $this->Site_model->get(
            array(
                "id" => $id
            )
        );


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function delete($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $site_code = get_from_id("site", "dosya_no", $id);
        $project_id = get_from_id("site", "proje_id", $id);
        $project_code = project_code($project_id);
        $path = "$this->File_Dir_Prefix/$project_code/$site_code";


        $delete2 = $this->Site_model->delete(
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


        $this->Favorite_model->delete(
            array(
                "module" => "site",
                "module_id" => $id,
                "user_id" => active_user_id()
            )
        );

        // TODO Alert Sistemi Eklenecek...
        if ($delete1 and $delete2) {
            $sil = deleteDirectory($path);
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

        redirect(base_url("project/file_form/$project_id"));
    }

    public function file_upload($id)
    {

        if (!isAdmin()) {
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }

        $project_id = project_id_site($id);
        $site = $this->Site_model->get(array("id" => $id));
        $project = $this->Project_model->get(array("id" => $project_id));
        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/$site->dosya_no/main/";

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

    public function fileDelete_java($id)
    {
        if (!isAdmin()) {
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }

        $project_id = project_id_site($id);
        $site = $this->Site_model->get(array("id" => $id));
        $project = $this->Project_model->get(array("id" => $project_id));
        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/$site->dosya_no/main/";

        $fileName = $this->input->post('fileName');

        unlink("$path/$fileName");
    }

    public function download_all($site_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $site_code = site_code($site_id);
        $project_id = project_id_site($site_id);
        $project_code = project_code($project_id);
        $project_name = get_from_id("projects", "project_name", $project_id);

        $path = "uploads/project_v/$project_code/$site_code";
        $zip_name = $project_name;

        $this->zip->read_dir($path, FALSE);
        $this->zip->download("$zip_name.zip");

    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "SNT-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function site_contractday($sitedal_day, $contract_day)
    {
        $date_diff = date_minus($sitedal_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function add_group($site_id, $group_id)
    {

        $active_groups = json_decode(get_from_id("site", "active_group", $site_id), true);
        $get_main_group = get_from_any("workgroup", "parent", "id", $group_id);


        if (empty($active_groups) || !isset($active_groups[$get_main_group]) || !in_array($group_id, $active_groups[$get_main_group])) {
            $active_groups[$get_main_group][] = $group_id;
        }
        $modified_group = $active_groups;


        $update = $this->Site_model->update(
            array(
                "id" => $site_id
            ),
            array(
                "active_group" => json_encode($modified_group),
            )
        );

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;


        $main_categories = $this->Workgroup_model->get_all(array('main_category' => 1));


        $item = $this->Site_model->get(
            array(
                "id" => $site_id
            )
        );
        $viewData->item = $item;

        $viewData->workgroups = json_decode($item->active_group, true);
        $viewData->main_categories = $main_categories;


        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/modules/workgroup", $viewData, true);

        echo $render_html;

    }

    public function delete_group($site_id, $group_id)
    {

        $active_groups = json_decode(get_from_id("site", "active_group", $site_id), true);
        $get_main_group = get_from_any("workgroup", "parent", "id", $group_id);


        foreach ($active_groups as &$subArray) {
            if (($index = array_search($group_id, $subArray)) !== false) {
                unset($subArray[$index]);
                if (empty($subArray)) {
                    unset($active_groups[$get_main_group]);
                }
            }
        }

        $modified_group = $active_groups;

        $update = $this->Site_model->update(
            array(
                "id" => $site_id
            ),
            array(
                "active_group" => json_encode($modified_group),
            )
        );

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;


        $main_categories = $this->Workgroup_model->get_all(array('main_category' => 1));


        $item = $this->Site_model->get(
            array(
                "id" => $site_id
            )
        );
        $viewData->item = $item;

        $viewData->workgroups = json_decode($item->active_group, true);
        $viewData->main_categories = $main_categories;


        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/modules/workgroup", $viewData, true);

        echo $render_html;

    }

    public function add_machine_group($site_id, $machine_id)
    {

        $active_groups = json_decode(get_from_id("site", "active_machine", $site_id), true);
        $get_main_group = get_from_any("workmachine", "parent", "id", $machine_id);


        if (empty($active_groups) || !isset($active_groups[$get_main_group]) || !in_array($machine_id, $active_groups[$get_main_group])) {
            $active_groups[$get_main_group][] = $machine_id;
        }
        $modified_group = $active_groups;


        $update = $this->Site_model->update(
            array(
                "id" => $site_id
            ),
            array(
                "active_machine" => json_encode($modified_group),
            )
        );

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $main_categories_workmachine = $this->Workmachine_model->get_all(array(
            'main_category' => 1
        ));

        $viewData->main_categories_workmachine = $main_categories_workmachine;


        $item = $this->Site_model->get(
            array(
                "id" => $site_id
            )
        );

        $viewData->item = $item;

        $viewData->workmachines = json_decode($item->active_machine, true);


        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/modules/workmachine", $viewData, true);

        echo $render_html;

    }

    public function delete_machine_group($site_id, $machine_id)
    {

        $active_groups = json_decode(get_from_id("site", "active_machine", $site_id), true);
        $get_main_group = get_from_any("workmachine", "parent", "id", $machine_id);

        foreach ($active_groups as &$subArray) {
            if (($index = array_search($machine_id, $subArray)) !== false) {
                unset($subArray[$index]);
                if (empty($subArray)) {
                    unset($active_groups[$get_main_group]);
                }
            }
        }

        $modified_group = $active_groups;

        $update = $this->Site_model->update(
            array(
                "id" => $site_id
            ),
            array(
                "active_machine" => json_encode($modified_group),
            )
        );

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $main_categories_workmachine = $this->Workmachine_model->get_all(array(
            'main_category' => 1
        ));

        $viewData->main_categories_workmachine = $main_categories_workmachine;
        $item = $this->Site_model->get(
            array(
                "id" => $site_id
            )
        );
        $viewData->item = $item;
        $viewData->workmachines = json_decode($item->active_machine, true);

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/modules/workmachine", $viewData, true);

        echo $render_html;

    }

    public function favorite($id)
    {
        $fav_id = get_from_any_and_and("favorite", "module", "site", "user_id", active_user_id(), "module_id", "$id");
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
                    "module" => "site",
                    "view" => "file_form",
                    "module_id" => $id,
                    "user_id" => active_user_id(),
                    "title" => site_code($id) . " - " . site_name($id)
                )
            );
            echo "favoriye eklendi";
        }
    }

    public function sign_options($site_id, $module)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $this->load->model("Report_sign_model");


        $position = $this->input->post("position");
        $name = $this->input->post("name");

        $this->load->library("form_validation");

        $this->form_validation->set_rules("position", "Ünvan", "min_length[3]|required|alpha_tr|trim"); //2
        $this->form_validation->set_rules("name", "Ad-Soyad", "min_length[3]|required|alpha_tr|trim"); //2

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "alpha_tr" => "<b>{field}</b> harflerden oluşmalıdır",
                "min_length" => "<b>{field}</b> en az <b>{param}</b> uzunluğunda olmalıdır.",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {
            $contractor_sign = $this->Report_sign_model->get(array("site_id" => $site_id, "module" => "contractor_sign"));
            $owner_sign = $this->Report_sign_model->get(array("site_id" => $site_id, "module" => "owner_sign"));

            if ($module == "contractor_sign") {
                if (empty($contractor_sign)) {
                    $insert = $this->Report_sign_model->add(
                        array(
                            "site_id" => $site_id,
                            "module" => $module,
                            "position" => $position,
                            "name" => $name,
                        )
                    );
                }
            } elseif ($module == "owner_sign") {
                if (empty($owner_sign)) {
                    $insert = $this->Report_sign_model->add(
                        array(
                            "site_id" => $site_id,
                            "module" => $module,
                            "position" => $position,
                            "name" => $name,
                        )
                    );
                }
            } else {
                $insert = $this->Report_sign_model->add(
                    array(
                        "site_id" => $site_id,
                        "module" => $module,
                        "position" => $position,
                        "name" => $name,
                    )
                );
            }
            // TODO Alert sistemi eklenecek...
            if (isset($insert)) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "İmza Ayarları Yapıldı",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "İmza Ayarları Güncellendi",
                    "type" => "success"
                );
            }
            $this->session->set_flashdata("alert", $alert);

            $contractor_sign = $this->Report_sign_model->get(array("site_id" => $site_id, "module" => "contractor_sign"));
            $contractor_staff = $this->Report_sign_model->get_all(array("site_id" => $site_id, "module" => "contractor_staff"));
            $owner_sign = $this->Report_sign_model->get(array("site_id" => $site_id, "module" => "owner_sign"));
            $owner_staff = $this->Report_sign_model->get_all(array("site_id" => $site_id, "module" => "owner_staff"));

            $viewData = new stdClass();
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;

            $viewData->item = $this->Site_model->get(
                array(
                    "id" => $site_id
                )
            );


            $viewData->contractor_sign = $contractor_sign;
            $viewData->contractor_staff = $contractor_staff;
            $viewData->owner_sign = $owner_sign;
            $viewData->owner_staff = $owner_staff;

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/signs/$module", $viewData, true);
            echo $render_html;
        } else {
            $alert = array(
                "title" => "İsim veya Ünvan Bilgilerinde Eksik Var",
                "text" => "İmza Ayarları Güncellenemedi",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            $contractor_sign = $this->Report_sign_model->get(array("site_id" => $site_id, "module" => "contractor_sign"));
            $contractor_staff = $this->Report_sign_model->get_all(array("site_id" => $site_id, "module" => "contractor_staff"));
            $owner_sign = $this->Report_sign_model->get(array("site_id" => $site_id, "module" => "owner_sign"));
            $owner_staff = $this->Report_sign_model->get_all(array("site_id" => $site_id, "module" => "owner_staff"));

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;

            $viewData->form_error = true;

            $viewData->item = $this->Site_model->get(
                array(
                    "id" => $site_id
                )
            );

            $viewData->contractor_sign = $contractor_sign;
            $viewData->contractor_staff = $contractor_staff;
            $viewData->owner_sign = $owner_sign;
            $viewData->owner_staff = $owner_staff;


            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/signs/$module", $viewData, true);
            echo $render_html;
        }
    }

    public function delete_sign($id, $module, $site_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $contractor_sign = $this->Report_sign_model->get(array("site_id" => $site_id, "module" => "contractor_sign"));
        $contractor_staff = $this->Report_sign_model->get_all(array("site_id" => $site_id, "module" => "contractor_staff"));
        $owner_sign = $this->Report_sign_model->get(array("site_id" => $site_id, "module" => "owner_sign"));
        $owner_staff = $this->Report_sign_model->get_all(array("site_id" => $site_id, "module" => "owner_staff"));

        $delete = $this->Report_sign_model->delete(
            array(
                "id" => $id
            )
        );

        // TODO Alert sistemi eklenecek...
        if ($delete) {
            $alert = array(
                "title" => "İmza Sütunu Silindi",
                "text" => "İmza Ayarları Yapıldı",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İmza Sütunu Silinemedi",
                "text" => "İmza Ayarları Güncellendi",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->contractor_sign = $contractor_sign;
        $viewData->contractor_staff = $contractor_staff;
        $viewData->owner_sign = $owner_sign;
        $viewData->owner_staff = $owner_staff;

        $viewData->item = $this->Site_model->get(
            array(
                "id" => $site_id
            )
        );


        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/signs/$module", $viewData, true);
        echo $render_html;
    }

    public function sign_rankSetter()
    {
        $data = $this->input->post("data");

        parse_str($data, $order);
        $items = $order['sub'];

        foreach ($items as $rank => $id) {
            $this->Report_sign_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "rank" => $rank,
                )
            );
        }
    }

    public function add_stock($site_id)
    {
        $site = $this->Site_model->get(array("id" => $site_id));
        $settings = $this->Settings_model->get();

        $this->load->library("form_validation");

        $this->form_validation->set_rules('stock_name', 'Stok Adı', 'required');
        $this->form_validation->set_rules('unit', 'Birim', 'required');
        $this->form_validation->set_rules('stock_in', 'Gelen Miktar', 'required|numeric');
        $this->form_validation->set_rules('stock_out', 'Çıkan Miktar', 'numeric');
        $this->form_validation->set_rules('arrival_date', 'Giriş Tarihi', 'required');
        $this->form_validation->set_rules('notes', 'Açıklama', 'required');

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "alpha" => "<b>{field}</b> alanı harflerden oluşmaladır",
                "numeric" => "<b>{field}</b> sayılardan oluşmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("arrival_date")) {
                $arrival_date = dateFormat('Y-m-d', $this->input->post("arrival_date"));
            } else {
                $arrival_date = null;
            }

            if ($this->input->post("exit_date")) {
                $exit_date = dateFormat('Y-m-d', $this->input->post("exit_date"));
            } else {
                $exit_date = null;
            }

            $insert = $this->Sitestock_model->add(
                array(
                    "site_id" => $site_id,
                    "stock_name" => $this->input->post("stock_name"),
                    "unit" => $this->input->post("unit"),
                    "stock_in" => $this->input->post("stock_in"),
                    "arrival_date" => $arrival_date,
                    "notes" => $this->input->post("notes"),
                    "createdAt" => date("Y-m-d"),
                    "createdBy" => active_user_id(),
                )
            );

            $viewData = new stdClass();
            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Site_model->get(array("id" => $site_id));
            $site_stocks = $this->Sitestock_model->get_all(array("site_id" => $site->id, "parent_id" => null));

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->item = $item;
            $viewData->settings = $settings;
            $viewData->site_stocks = $site_stocks;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_3_sitestock", $viewData);
        } else {

            $site_stocks = $this->Sitestock_model->get_all(array("site_id" => $site->id, "parent_id" => null));

            $viewData = new stdClass();
            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Site_model->get(array("id" => $site_id));

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->item = $item;
            $viewData->settings = $settings;
            $viewData->site_stocks = $site_stocks;
            $viewData->form_error = true;
            $viewData->error_modal = "AddStockModal";

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_3_sitestock", $viewData);

        }
    }

    public function exit_stock($site_id)
    {
        // Verilerin getirilmesi
        $item = $this->Site_model->get(array("id" => $site_id));
        $site_stocks = $this->Sitestock_model->get_all(array("site_id" => $site_id, "parent_id" => null));
        $site_stock = $this->Sitestock_model->get(array("id" => $this->input->post('stock_id')));
        $kalan = $site_stock->stock_in - sum_anything("sitestock", "stock_out", "parent_id", "$site_stock->id");
        $settings = $this->Settings_model->get();

        $this->load->library("form_validation");

        $this->form_validation->set_rules('transfer', 'Gideceği Bölge', "numeric|required");
        $this->form_validation->set_rules('stock_out', 'Çıkan Miktar', "numeric|required|less_than_equal_to[$kalan]");
        $this->form_validation->set_rules('exit_date', 'Çıkış Tarihi', 'required');
        $this->form_validation->set_rules('exit_notes', 'Açıklama', 'required');

        $this->form_validation->set_message(array(
            "required" => "<b>{field}</b> alanı doldurulmalıdır",
            "numeric" => "<b>{field}</b> sayılardan oluşmalıdır",
            "less_than_equal_to" => "<b>{field}ı</b> Kalan Miktarından Fazla Olamaz. <br>Kalan Stok (<b>{param}</b>)",
        ));

        $validate = $this->form_validation->run();

        if ($validate) {
            // Çıkış tarihi alınıyor, format doğru değilse null atanıyor
            $exit_date = dateFormat('Y-m-d', $this->input->post("exit_date"));

            $insert = $this->Sitestock_model->add(array(
                "site_id" => $site_id,
                "parent_id" => $this->input->post('stock_id'),
                "notes" => $this->input->post("exit_notes"),
                "stock_out" => $this->input->post("stock_out"),
                "exit_date" => $exit_date,
                "transfer" => $this->input->post("transfer"),
                "createdAt" => date("Y-m-d"),
                "createdBy" => active_user_id(),
            ));

            if ($insert) {
                $inserted_id = $this->db->insert_id(); // Eklemeden sonra ID'yi al

                // Transfer işlemi varsa, transfer edilen stoğu yeni siteye ekleme
                if ($this->input->post("transfer")) {
                    $transfered_item = $this->Sitestock_model->get(array("id" => $this->input->post('stock_id')));
                    $this->Sitestock_model->add(array(
                        "site_id" => $this->input->post("transfer"),
                        "stock_name" => $transfered_item->stock_name,
                        "unit" => $transfered_item->unit,
                        "stock_in" => $this->input->post("stock_out"),
                        "arrival_date" => $exit_date,
                        "notes" => $this->input->post("exit_notes"),
                        "site_from" => $site_id,
                        "connection" => $inserted_id, // Buraya uygun değeri ekleyin
                        "createdAt" => date("Y-m-d"),
                        "createdBy" => active_user_id(),
                    ));
                }

            }
            $sites = $this->Site_model->get_all(array("is_Active" => 1));

            // Görünüm için değişkenlerin set edilmesi
            $viewData = new stdClass();
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->site_stocks = $site_stocks;
            $viewData->item = $item;
            $viewData->settings = $settings;
            $viewData->sites = $sites;
            $viewData->site_stock = $site_stock;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_3_sitestock", $viewData);

        } else {
            $sites = $this->Site_model->get_all(array("is_Active" => 1));

            // Hata varsa formu tekrar doldurmak için görünüm
            $viewData = new stdClass();
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->site_stocks = $site_stocks;
            $viewData->item = $item;
            $viewData->settings = $settings;
            $viewData->sites = $sites;
            $viewData->site_stock = $site_stock;
            $viewData->form_error = true;
            $viewData->error_modal = "ExitModal";

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_3_sitestock", $viewData);
        }
    }

    public function exit_stock_form($site_stok_id)
    {
        // Verilerin getirilmesi

        $site_stock = $this->Sitestock_model->get(array("id" => $site_stok_id));
        $item = $this->Site_model->get(array("id" => $site_stock->site_id));
        $sites = $this->Site_model->get_all(array("is_Active" => 1));
        $site_stocks = $this->Sitestock_model->get_all(array("site_id" => $item->id, "parent_id" => null));

        // Görünüm için değişkenlerin set edilmesi
        $viewData = new stdClass();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->site_stocks = $site_stocks;
        $viewData->item = $item;
        $viewData->site_stock = $site_stock;
        $viewData->sites = $sites;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modals/exit_modal_form", $viewData);


    }

    public function delete_stock()
    {
        // Verilerin getirilmesi
        $site_stock = $this->Sitestock_model->get(array("id" => $this->input->post("id")));

        $delete_stock = $this->Sitestock_model->delete(array(
            "id" => $site_stock->id,
        ));

        $delete_connected_stock = $this->Sitestock_model->delete(array(
            "connection" => $site_stock->id,
        ));


        if ($delete_stock) {

            $item = $this->Site_model->get(array("id" => $site_stock->site_id));
            $site_stocks = $this->Sitestock_model->get_all(array("site_id" => $item->id, "parent_id" => null));
            $sites = $this->Site_model->get_all(array("is_Active" => 1));

            // Görünüm için değişkenlerin set edilmesi
            $viewData = new stdClass();
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->site_stock = $site_stock;
            $viewData->site_stocks = $site_stocks;
            $viewData->item = $item;
            $viewData->sites = $sites;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_3_sitestock", $viewData);
        } else {
            $viewData = new stdClass();

            $item = $this->Site_model->get(array("id" => $site_stock->site_id));
            $site_stocks = $this->Sitestock_model->get_all(array("site_id" => $item->id, "parent_id" => null));
            $sites = $this->Site_model->get_all(array("is_Active" => 1));

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->site_stock = $site_stock;
            $viewData->site_stocks = $site_stocks;
            $viewData->item = $item;
            $viewData->sites = $sites;
            $viewData->warning = "Veri Silinemedi";

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_3_sitestock", $viewData);

        }
    }


    public
    function save_personel($site_id)
    {

        $this->load->library("form_validation");

        $this->form_validation->set_rules('name_surname', 'Ad Soyad', 'required|callback_name_control');
        $this->form_validation->set_rules('group', 'Meslek', 'required');
        $this->form_validation->set_rules('social_id', 'TC Kimlik No', 'numeric');
        $this->form_validation->set_rules('start_date', 'Giriş Tarihi', 'required');
        $this->form_validation->set_rules('end_date', 'Çıkış Tarihi', 'callback_check_end_date');

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "alpha" => "<b>{field}</b> alanı harflerden oluşmaladır",
                "numeric" => "<b>{field}</b> sayılardan oluşmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {
            if ($this->input->post("start_date")) {
                $start_date = dateFormat('Y-m-d', $this->input->post("start_date"));
            } else {
                $start_date = null;
            }

            if ($this->input->post("end_date")) {
                $end_date = dateFormat('Y-m-d', $this->input->post("end_date"));
            } else {
                $end_date = null;
            }

            $insert = $this->Workman_model->add(
                array(
                    "site_id" => $site_id,
                    "name_surname" => $this->input->post("name_surname"),
                    "group" => $this->input->post("group"),
                    "bank" => $this->input->post("bank"),
                    "IBAN" => $this->input->post("IBAN"),
                    "social_id" => $this->input->post('social_id'),
                    "start_date" => $start_date,
                    "end_date" => $end_date,
                    "isActive" => 1,
                )
            );

            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Kayıt başarılı bir şekilde eklendi",
                "type" => "success"
            );
            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();
            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Site_model->get(array("id" => $site_id));

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->item = $item;
            $viewData->personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1));
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/personel_liste", $viewData);
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();
            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Site_model->get(array("id" => $site_id));

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->item = $item;
            $viewData->personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1));
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/personel_liste", $viewData);
        }


    }

    public
    function update_personel($worker_id, $site_id)
    {

        $this->load->library("form_validation");

        $this->form_validation->set_rules('name_surname', 'Ad Soyad', 'required|callback_name_control');
        $this->form_validation->set_rules('group', 'Meslek', 'required');
        $this->form_validation->set_rules('social_id', 'TC Kimlik No', 'numeric');
        $this->form_validation->set_rules('start_date', 'Giriş Tarihi', 'required');
        $this->form_validation->set_rules('end_date', 'Çıkış Tarihi', 'callback_check_end_date');


        $this->form_validation->set_message('name_control', 'İsim Soyisim Alanı sadece harf, boşluk ve Türkçe karakterler içerebilir.');


        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "alpha" => "<b>{field}</b> alanı harflerden oluşmaladır",
                "numeric" => "<b>{field}</b> sayılardan oluşmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {
            if ($this->input->post("start_date")) {
                $start_date = dateFormat('Y-m-d', $this->input->post("start_date"));
            } else {
                $start_date = null;
            }

            if ($this->input->post("end_date")) {
                $end_date = dateFormat('Y-m-d', $this->input->post("end_date"));
            } else {
                $end_date = null;
            }

            $update = $this->Workman_model->update(
                array("id" => $worker_id),
                array(
                    "site_id" => $site_id,
                    "name_surname" => $this->input->post("name_surname"),
                    "group" => $this->input->post("group"),
                    "bank" => $this->input->post("bank"),
                    "IBAN" => $this->input->post("IBAN"),
                    "social_id" => $this->input->post('social_id'),
                    "start_date" => $start_date,
                    "end_date" => $end_date,
                    "isActive" => 1,
                )
            );

            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Kayıt başarılı bir şekilde eklendi",
                "type" => "success"
            );
            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();
            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Site_model->get(array("id" => $site_id));

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->item = $item;
            $viewData->personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1));
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/personel_liste", $viewData);
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();
            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Site_model->get(array("id" => $site_id));

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->item = $item;
            $viewData->personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1));
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/personel_liste", $viewData);
        }


    }

    public
    function update_personel_form()
    {

        $workerId = $this->input->post('workerId');

        $worker = $this->Workman_model->get(array("id" => $workerId));
        $settings = $this->Settings_model->get();

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $item = $this->Site_model->get(array("id" => $worker->site_id));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->worker = $worker;
        $viewData->settings = $settings;
        $viewData->workgroups = json_decode($item->active_group, true);
        $viewData->workmachines = json_decode($item->active_machine, true);

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/personel_update", $viewData);

    }

    public
    function update_puantaj($site_id)
    {

        $workerId = $this->input->post('workerId');
        $date = $this->input->post('date');
        $is_checked = $this->input->post('isChecked');

        $this->load->model("Attendance_model");

        $year_month = dateFormat('Y-m', $date);
        $day = dateFormat('d', $date);

        $old_puantaj = $this->Attendance_model->get(array("site_id" => $site_id, "year_month" => $year_month));

        if (!empty($old_puantaj)) {
            $old_puantaj_array = json_decode($old_puantaj->puantaj, true);
        }

        if ($is_checked == 1) {
            if (isset($old_puantaj_array[$day])) {
                // Anahtar varsa, içine yeni bir değer ekleyin
                $old_puantaj_array[$day][] = $workerId;
            } else {
                // Anahtar yoksa, yeni bir anahtar oluşturun ve içine yeni bir dizi ekleyin
                $old_puantaj_array[$day] = array($workerId);
            }
        } elseif ($is_checked == 0) {
            if (isset($old_puantaj_array[$day])) {
                // $workerId değerini $day anahtarı altından kaldırın
                $key = array_search($workerId, $old_puantaj_array[$day]);
                if ($key !== false) {
                    unset($old_puantaj_array[$day][$key]);
                    // Eğer $day anahtarının altında başka bir değer yoksa, $day anahtarını tamamen kaldırın
                    if (count($old_puantaj_array[$day]) == 0) {
                        unset($old_puantaj_array[$day]);
                    }
                }
            }
        }

        // Puantajda değişiklik yap
        if (isset($old_puantaj)) {
            $this->Attendance_model->update(
                array("id" => $old_puantaj->id),
                array("puantaj" => json_encode($old_puantaj_array))
            );
        } else {
            // Yeni bir puantaj oluştur
            $contract_id = contract_id_module("site", $site_id);
            $new_puantaj = json_encode($old_puantaj_array);

            $this->Attendance_model->add(
                array(
                    "site_id" => $site_id,
                    "contract_id" => $contract_id,
                    "year_month" => $year_month,
                    "puantaj" => $new_puantaj
                )
            );
        }

        $viewData = new stdClass();
        $puantaj = $this->Attendance_model->get(array("site_id" => $site_id, "year_month" => $year_month));
        $year = explode("-", $year_month)[0];
        $month = explode("-", $year_month)[1];

        /** Tablodan Verilerin Getirilmesi.. */
        $item = $this->Site_model->get(array("id" => $site_id));
        $personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1), "group DESC");

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->year = $year;
        $viewData->month = $month;
        $viewData->puantaj_data = json_decode($puantaj->puantaj, true);
        $viewData->personel_datas = $personel_datas;
        $viewData->form_error = true;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/puantaj_liste", $viewData);

    }

    public
    function puantaj_date($site_id)
    {

        $month = date($this->input->post('month'));
        $year = date($this->input->post('year'));


        $viewData = new stdClass();
        $this->load->model("Attendance_model");
        $puantaj = $this->Attendance_model->get(array("site_id" => $site_id, "year_month" => "$year-$month"));

        /** Tablodan Verilerin Getirilmesi.. */
        $item = $this->Site_model->get(array("id" => $site_id));
        $personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1), "group DESC");

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->year = $year;
        $viewData->month = $month;

        if (isset($puantaj)) {
            $viewData->puantaj = $puantaj;
            $viewData->puantaj_data = json_decode($puantaj->puantaj, true);
        } else {
            $viewData->puantaj = null;
            $viewData->puantaj_data = null;
        }
        $viewData->personel_datas = $personel_datas;
        $viewData->form_error = true;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/puantaj_liste", $viewData);

    }

    public
    function check_end_date($end_date)
    {
        $start_date = $this->input->post('start_date'); // Başlangıç tarihini post verisinden alın

        // Eğer end date boş değilse ve start date doluysa kontrol yap
        if (!empty($end_date) && !empty($start_date)) {
            // İki tarih arasındaki farkı hesaplayın
            $date_diff = strtotime($end_date) - strtotime($start_date);

            if ($date_diff < 0) {
                // Eğer çıkış tarihi, giriş tarihinden önce ise hata mesajı ayarlayın
                $this->form_validation->set_message('check_end_date', 'Çıkış tarihi, giriş tarihinden sonraki bir tarih olmalıdır.');
                return FALSE;
            }
        }

        return TRUE; // Kontrol yapılmadı veya geçerli
    }

    public
    function name_control($user_name)
    {
        if (preg_match('/^([a-z üğışçöÜĞİŞÇÖ])*$/i', $user_name)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public
    function puantaj_print($site_id, $month, $year)
    {
        $month = date($month);
        $year = date($year);
        $year_month = $year . "-" . $month;
        $month_name = ay_isimleri($month);

        $year_month = dateFormat('Y-m', $year_month);

        $viewData = new stdClass();

        $this->load->model("Attendance_model");
        $puantaj = $this->Attendance_model->get(array("site_id" => $site_id, "year_month" => "$year_month"));
        $site = $this->Site_model->get(array("id" => $site_id));

        if (isset($puantaj)) {
            $puantaj_data = json_decode($puantaj->puantaj, true);
        } else {
            $puantaj_data = null;
        }

        $this->load->library('pdf_creator');

        // Yeni bir TCPDF nesnesi oluşturun
        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın

        $pdf->SetPageOrientation('L');

        $pdf->headerSubText = "Şantiye Adı : $site->santiye_ad";

        $pdf->headerText = "$month_name $year Puantaj Tablosu";

        $pdf->SetPrintFooter(false);
        $pdf->AddPage();

        $personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1), "group DESC");

        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(7, 6, '#', 1);
        $pdf->Cell(40, 6, 'Adı Soyadı', 1);
        $pdf->Cell(30, 6, 'Ekip', 1);
        for ($j = 1; $j <= gun_sayisi(); $j++) {
            $pdf->Cell(6, 6, $j, 1, "", "C");
        }
        $pdf->Cell(16, 6, 'Toplam', 1);
        $pdf->Ln(); // Bir sonraki satıra geç

// Tablo verilerini oluştur
        $pdf->SetFont('dejavusans', '', 10);
        $i = 1;
        foreach ($personel_datas as $personel_data) {
            $pdf->Cell(7, 6, $i++, 1);
            $pdf->Cell(40, 6, $personel_data->name_surname, 1);
            $pdf->Cell(30, 6, group_name($personel_data->group), 1);

            for ($j = 1; $j <= gun_sayisi(); $j++) {
                $j_double_digit = str_pad($j, 2, "0", STR_PAD_LEFT);
                $isChecked = (isset($puantaj_data[$j_double_digit]) && in_array($personel_data->id, $puantaj_data[$j_double_digit])) ? 'X' : '';
                $pdf->Cell(6, 6, $isChecked, 1, "", "C");
            }

            $count_of_value = 0;
            if (isset($puantaj_data)) {
                $value_to_count = $personel_data->id;
                foreach ($puantaj_data as $sub_array) {
                    if (in_array($value_to_count, $sub_array)) {
                        $count_of_value += array_count_values($sub_array)[$value_to_count];
                    }
                }
            }
            $pdf->SetFont('dejavusans', 'B', 10);

            $pdf->Cell(16, 6, $count_of_value, 1);
            $pdf->SetFont('dejavusans', '', 10);


            $pdf->Ln(); // Bir sonraki satıra geç
        }

        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(77, 10, 'Toplam', 1, 0, 'C');
        for ($j = 1; $j <= gun_sayisi(); $j++) {
            $j_double_digit = str_pad($j, 2, "0", STR_PAD_LEFT);
            if (array_key_exists($j_double_digit, $puantaj_data)) {
                $pdf->Cell(6, 10, count($puantaj_data[$j_double_digit]), 1, 0, 'C');
            } else {
                $pdf->Cell(6, 10, '0', 1, 0, 'C');
            }
        }
        $total_keys = 0;
        foreach ($puantaj_data as $sub_array) {
            $total_keys += count($sub_array);
        }
        $pdf->Cell(16, 10, $total_keys, 1, 1, 'C'); // Yeni satıra geç

        // PDF'yi görüntüleme veya indirme
        $pdf->Output("$site->santiye_ad" . "-" . $month_name . " " . $year . ".pdf");

    }

    public
    function personel_print($site_id, $is_active)
    {
        $viewData = new stdClass();

        $this->load->model("Attendance_model");
        $site = $this->Site_model->get(array("id" => $site_id));
        $puantaj = $this->Workman_model->get(array("site_id" => $site->id, "end_date" => NULL));


        if (isset($puantaj)) {
            $puantaj_data = json_decode($puantaj->puantaj, true);
        } else {
            $puantaj_data = null;
        }

        $this->load->library('pdf_creator');

        // Yeni bir TCPDF nesnesi oluşturun
        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın

        $pdf->SetPageOrientation('L');


        $pdf->headerSubText = "Şantiye Adı : $site->santiye_ad";

        $pdf->headerText = "Personel Tablosu";

        if ($is_active == 1) {
            $pdf->headerPaymentNo = "Aktif Çalışanlar Listesi";
        } elseif ($is_active == 0) {
            $pdf->headerPaymentNo = "Tüm Çalışanlar Listesi";
        }

        $pdf->SetPrintFooter(false);
        $pdf->AddPage();

        if ($is_active == 1) {
            $personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "end_date" => NULL));
        } elseif ($is_active == 0) {
            $personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id));
        }
        $pdf->SetFont('dejavusans', '', 8);

        $pdf->Cell(10, 7, '#', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Adı Soyadı', 1, 0, 'C');
        $pdf->Cell(28, 7, 'TC Kimlik No', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Branş', 1, 0, 'C');
        $pdf->Cell(25, 7, 'İşe Giriş', 1, 0, 'C');
        if ($is_active == 0) {
            $pdf->Cell(25, 7, 'İşten Çıkış', 1, 0, 'C');
        }

        $pdf->Cell(60, 7, 'Hesap No', 1, 0, 'C');
        $pdf->Cell(60, 7, 'Banka', 1, 0, 'C');
        $pdf->Ln();

// Table data
        $i = 1;
        foreach ($personel_datas as $personel_data) {
            $pdf->Cell(10, 7, $i++, 1, 0, 'C');
            $pdf->Cell(40, 7, $personel_data->name_surname, 1, 0, 'L');
            $pdf->Cell(28, 7, $personel_data->social_id, 1, 0, 'C');
            $pdf->Cell(30, 7, group_name($personel_data->group), 1, 0, 'C');
            $pdf->Cell(25, 7, dateFormat_dmy($personel_data->start_date), 1, 0, 'C');
            if ($is_active == 0) {
                $pdf->Cell(25, 7, (!empty($personel_data->end_date) ? dateFormat_dmy($personel_data->end_date) : 'Çalışıyor'), 1, 0, 'C');
            }
            $pdf->Cell(60, 7, $personel_data->IBAN, 1, 0, 'C');
            $pdf->Cell(60, 7, $personel_data->bank, 1, 0, 'C');
            $pdf->Ln();
        }

        $name = $site->santiye_ad . "-" . "-Personel Listesi.pdf";
        // PDF'yi görüntüleme veya indirme
        $pdf->Output($name);

    }
}