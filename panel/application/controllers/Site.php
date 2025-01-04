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

        $models = [
            "Site_model" => 1,
            "Contract_model" => 1,
            "Project_model" => 1,
            "Settings_model" => 1,
            "Order_model" => 1,
            "User_model" => 1,
            "Report_model" => 1,
            "Report_sign_model" => 1,
            "Sitestock_model" => 1,
            "Sitewallet_model" => 1,
            "Extime_model" => 1,
            "Costinc_model" => 1,
            "Workman_model" => 1,
            "Workgroup_model" => 1,
            "Workmachine_model" => 1,
            "Favorite_model" => 1
        ];

        foreach ($models as $model => $shouldLoad) {
            if ($shouldLoad) {
                $this->load->model($model);
            }
        }

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
        $this->Update_Folder = "update"; // Güncelleme klasörü
        $this->Common_Files = "common"; // Ortak dosyalar
        $this->settings = $this->Settings_model->get();;
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


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";

        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->active_contracts = $active_contracts;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
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

    public function select()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Site_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );


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
        $path_sitewallet = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/$item->dosya_no/Sitewallet/";
        $path_personel = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/$item->dosya_no/Personel/";

        !is_dir($path) && mkdir($path, 0777, TRUE);
        !is_dir($path_sitewallet) && mkdir($path_sitewallet, 0777, TRUE);
        !is_dir($path_personel) && mkdir($path_personel, 0777, TRUE);


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
        $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $id, "isActive" => 1), "group DESC");
        $passive_personel_datas = $this->Workman_model->get_all(array("site_id" => $id, "isActive" => 0), "group DESC");

        $year_month = date('Y-m');
        $puantaj = $this->Attendance_model->get(array("site_id" => $id, "year_month" => $year_month));

        $site_stocks = $this->Sitestock_model->get_all(array("site_id" => $item->id, "parent_id" => null));

        $all_expenses = $this->Sitewallet_model->get_all(array(
            "site_id" => $id,
            "type" => 1
        ));

        $all_deposits = $this->Sitewallet_model->get_all(array(
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
// O ayın son gününü bul
        $last_day_of_month = date('t', strtotime("$year-$month-01"));

// $last_day_of_month, o ayın son gününü (kaç gün olduğunu) verecektir
        $count_of_days = (int)$last_day_of_month;

        $viewData->viewModule = $this->moduleFolder;

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->path = $path;
        $viewData->upload_function = $upload_function;
        $viewData->active_tab = $active_tab;
        $viewData->count_of_days = $count_of_days;

        $viewData->all_deposits = $all_deposits;
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
        $viewData->active_personel_datas = $active_personel_datas;
        $viewData->passive_personel_datas = $passive_personel_datas;
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

    /*----*/

    /*WorkGroup and WorkMachine Start*/
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


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";


        $main_categories = $this->Workgroup_model->get_all(array('main_category' => 1));


        $item = $this->Site_model->get(
            array(
                "id" => $site_id
            )
        );
        $viewData->item = $item;

        $viewData->workgroups = json_decode($item->active_group, true);
        $viewData->main_categories = $main_categories;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_6_1_workgroup", $viewData);


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


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";


        $main_categories = $this->Workgroup_model->get_all(array('main_category' => 1));


        $item = $this->Site_model->get(
            array(
                "id" => $site_id
            )
        );
        $viewData->item = $item;

        $viewData->workgroups = json_decode($item->active_group, true);
        $viewData->main_categories = $main_categories;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_6_1_workgroup", $viewData);


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


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";


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


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_6_2_workmachine", $viewData);


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


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

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

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_6_2_workmachine", $viewData);


    }

    /*WorkGroup and WorkMachine End*/

    /*----*/

    /*    Rapor İmza Ayarları Start*/

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

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/signs/$module", $viewData);
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

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/signs/$module", $viewData);
        }
    }

    public function delete_sign($id, $module, $site_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }


        $delete = $this->Report_sign_model->delete(
            array(
                "id" => $id
            )
        );


        $viewData = new stdClass();

        $contractor_sign = $this->Report_sign_model->get(array("site_id" => $site_id, "module" => "contractor_sign"));
        $contractor_staff = $this->Report_sign_model->get_all(array("site_id" => $site_id, "module" => "contractor_staff"));
        $owner_sign = $this->Report_sign_model->get(array("site_id" => $site_id, "module" => "owner_sign"));
        $owner_staff = $this->Report_sign_model->get_all(array("site_id" => $site_id, "module" => "owner_staff"));


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

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/signs/$module", $viewData);

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

    /*    Rapor İmza Ayarları Start*/


    /*----*/

    /*Sitewalllet Start*/

    public function expense_file_download($data_id, $file_name)
    {

        $site_wallet = $this->Sitewallet_model->get(array("id" => $data_id));
        $site = $this->Site_model->get(array("id" => $site_wallet->site_id));
        $project = $this->Project_model->get(array("id" => $site->proje_id));

        $file_path = "$this->File_Dir_Prefix/$project->project_code/$site->dosya_no/Sitewallet/$data_id/$file_name";

        if ($file_path) {
            if (file_exists($file_path)) {
                $data = file_get_contents($file_path);
                force_download($file_name, $data);
            }
        }
    }

    public function download_all_expense($data_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $site_wallet = $this->Sitewallet_model->get(array("id" => $data_id));
        $site = $this->Site_model->get(array("id" => $site_wallet->site_id));
        $project = $this->Project_model->get(array("id" => $site->proje_id));

        // Dosya yolunu oluşturmak
        $file_path = "$this->File_Dir_Prefix/$project->project_code/$site->dosya_no/Sitewallet/$data_id/$file_name";


        $zip_name = "Harcama - $data_id";

        $this->zip->read_dir($file_path, FALSE);
        $this->zip->download("$zip_name.zip");

    }

    public function expense_file_delete($data_id, $file_name)
    {
        // İlgili verileri almak
        $site_wallet = $this->Sitewallet_model->get(array("id" => $data_id));
        $site = $this->Site_model->get(array("id" => $site_wallet->site_id));
        $project = $this->Project_model->get(array("id" => $site->proje_id));

        // Dosya yolunu oluşturmak
        $file_path = "$this->File_Dir_Prefix/$project->project_code/$site->dosya_no/Sitewallet/$data_id/$file_name";

        // Dosya yolu var mı diye kontrol
        if ($file_path) {
            // Dosya sistemde mevcut mu?
            if (file_exists($file_path)) {
                // Dosyayı silmek
                if (unlink($file_path)) {
                    echo "Dosya başarıyla silindi.";
                } else {
                    echo "Dosya silinirken bir hata oluştu.";
                }
            }
        }
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

    public function add_expense($site_id)
    {

        // Veritabanından site, sözleşme ve proje bilgilerini alıyoruz
        $item = $this->Site_model->get(array("id" => $site_id));
        $contract = $this->Contract_model->get(array("id" => $item->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));


        // Form validation kütüphanesini yüklüyoruz
        $this->load->library("form_validation");

        // Form doğrulama kuralları ekliyoruz
        $this->form_validation->set_rules('expense_date', 'Tarih', 'required');
        $this->form_validation->set_rules('price', 'Fiyat', 'required|numeric');
        $this->form_validation->set_rules('payment_type', 'Ödeme Türü', 'required');
        $this->form_validation->set_rules('expense_notes', 'Açıklama', 'required');

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

        // Eğer doğrulama başarılı ise aşağıdaki işlemleri yapıyoruz
        if ($validate) {

            // Eğer formdan tarih bilgisi gelmişse, formatı Y-m-d olarak ayarlıyoruz
            if ($this->input->post("expense_date")) {
                $date = dateFormat('Y-m-d', $this->input->post("expense_date"));
            } else {
                $date = null; // Eğer tarih girilmediyse, null değer atıyoruz
            }


            $bill_code = $this->input->post("bill_code");
            if (empty($bill_code)) {
                $bill_code = NULL; // Eğer boşsa NULL ata
            }

            // Yeni site cüzdanı kaydı veritabanına ekleniyor
            $insert = $this->Sitewallet_model->add(
                array(
                    "site_id" => $item->id,
                    "date" => $date,
                    "price" => $this->input->post("price"),
                    "bill_code" => $bill_code,
                    "payment_type" => $this->input->post("payment_type"),
                    "note" => $this->input->post("expense_notes"),
                    "type" => 1,
                    "createdAt" => date("Y-m-d"),
                    "createdBy" => active_user_id(),
                )
            );

            // Eklenen kaydın ID'si alınarak dosya yüklemesi için kullanılıyor
            $record_id = $this->db->insert_id();

            // Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Sitewallet/$record_id";
            // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            // Yüklenen dosyanın ismi SEO dostu hale getiriliyor
            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

            // Dosya boyutu alınıyor
            $size = $_FILES["file"]["size"];

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

            $all_expenses = $this->Sitewallet_model->get_all(array("site_id" => $site_id, "type" => 1));
            $all_deposits = $this->Sitewallet_model->get_all(array("site_id" => $site_id, "type" => 0));
            $total_expense = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "1");
            $total_deposit = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "0");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->contract = $contract;
            $viewData->project = $project;
            $viewData->all_deposits = $all_deposits;
            $viewData->all_expenses = $all_expenses;
            $viewData->total_expense = $total_expense;
            $viewData->total_deposit = $total_deposit;
            $viewData->item = $item;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_4_1_expenses", $viewData);

        } else {

            $all_expenses = $this->Sitewallet_model->get_all(array("site_id" => $site_id, "type" => 1));
            $all_deposits = $this->Sitewallet_model->get_all(array("site_id" => $site_id, "type" => 0));
            $total_expense = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "1");
            $total_deposit = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "0");


            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->contract = $contract;
            $viewData->project = $project;
            $viewData->all_expenses = $all_expenses;
            $viewData->all_deposits = $all_deposits;
            $viewData->total_expense = $total_expense;
            $viewData->total_deposit = $total_deposit;
            $viewData->item = $item;
            $viewData->form_error = true; // Formda hata olduğunu belirtiyoruz
            $viewData->error_modal = "AddExpenseModal"; // Hata modali için set edilen değişken
            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_4_1_expenses", $viewData);

        }
    }

    public function add_deposit($site_id)
    {

        // Veritabanından site, sözleşme ve proje bilgilerini alıyoruz
        $item = $this->Site_model->get(array("id" => $site_id));
        $contract = $this->Contract_model->get(array("id" => $item->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));


        // Form validation kütüphanesini yüklüyoruz
        $this->load->library("form_validation");

        $this->form_validation->set_rules('deposit_date', 'Tarih', 'required');
        $this->form_validation->set_rules('price', 'Fiyat', 'required|numeric');
        $this->form_validation->set_rules('payment_type', 'Ödeme Türü', 'required');
        $this->form_validation->set_rules('deposit_notes', 'Açıklama', 'required');

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

        // Eğer doğrulama başarılı ise aşağıdaki işlemleri yapıyoruz
        if ($validate) {


            // Eğer formdan tarih bilgisi gelmişse, formatı Y-m-d olarak ayarlıyoruz
            if ($this->input->post("deposit_date")) {
                $date = dateFormat('Y-m-d', $this->input->post("deposit_date"));
            } else {
                $date = null; // Eğer tarih girilmediyse, null değer atıyoruz
            }

            $bill_code = $this->input->post("bill_code");
            if (empty($bill_code)) {
                $bill_code = NULL; // Eğer boşsa NULL ata
            }

            // Yeni site cüzdanı kaydı veritabanına ekleniyor
            $insert = $this->Sitewallet_model->add(
                array(
                    "site_id" => $item->id,
                    "date" => $date,
                    "price" => $this->input->post("price"),
                    "bill_code" => $bill_code,
                    "payment_type" => $this->input->post("payment_type"),
                    "note" => $this->input->post("deposit_notes"),
                    "type" => 0,
                    "createdAt" => date("Y-m-d"),
                    "createdBy" => active_user_id(),
                )
            );

            // Eklenen kaydın ID'si alınarak dosya yüklemesi için kullanılıyor
            $record_id = $this->db->insert_id();

            // Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Sitewallet/$record_id";
            // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            // Yüklenen dosyanın ismi SEO dostu hale getiriliyor
            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

            // Dosya boyutu alınıyor
            $size = $_FILES["file"]["size"];

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

            $all_expenses = $this->Sitewallet_model->get_all(array("site_id" => $site_id, "type" => 1));
            $all_deposits = $this->Sitewallet_model->get_all(array("site_id" => $site_id, "type" => 0));
            $total_expense = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "1");
            $total_deposit = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "0");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->contract = $contract;
            $viewData->project = $project;
            $viewData->all_deposits = $all_deposits;
            $viewData->all_expenses = $all_expenses;
            $viewData->total_expense = $total_expense;
            $viewData->total_deposit = $total_deposit;
            $viewData->item = $item;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_4_2_deposits", $viewData);

        } else {

            $all_expenses = $this->Sitewallet_model->get_all(array("site_id" => $site_id, "type" => 1));
            $all_deposits = $this->Sitewallet_model->get_all(array("site_id" => $site_id, "type" => 0));
            $total_expense = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "1");
            $total_deposit = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "0");


            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->contract = $contract;
            $viewData->project = $project;
            $viewData->all_expenses = $all_expenses;
            $viewData->all_deposits = $all_deposits;
            $viewData->total_expense = $total_expense;
            $viewData->total_deposit = $total_deposit;
            $viewData->item = $item;

            $viewData->form_error = true; // Formda hata olduğunu belirtiyoruz

            $viewData->error_modal = "AddDepositModal"; // Hata modali için set edilen değişken
            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_4_2_deposits", $viewData);
        }
    }

    public function delete_sitewallet($sitewallet_id)
    {

        $sitewallet = $this->Sitewallet_model->get(array("id" => $sitewallet_id));
        $item = $this->Site_model->get(array("id" => $sitewallet->site_id));
        $contract = $this->Contract_model->get(array("id" => $item->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));

        $file_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Sitewallet/$sitewallet->id";

        $delete = $this->Sitewallet_model->delete(
            array(
                "id" => $sitewallet->id
            )
        );

        if ($file_path && is_dir($file_path)) {
            $files = scandir($file_path);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    // Dosya adı ve uzantısını ayır
                    $file_name_without_extension = pathinfo($file, PATHINFO_FILENAME);

                    // Eğer dosya adı $expense_id ile eşleşiyorsa sil
                    if ($sitewallet->id == $file_name_without_extension) {
                        $path = $file_path . "/" . $file;
                        if (!unlink($path)) {
                            log_message('error', "Dosya silinemedi: $path");
                        }
                    }
                }
            }
        }

        $all_expenses = $this->Sitewallet_model->get_all(array("site_id" => $item->id, "type" => 1));
        $total_expense = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "1");
        $all_deposits = $this->Sitewallet_model->get_all(array("site_id" => $item->id, "type" => 0));


        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->contract = $contract;
        $viewData->project = $project;
        $viewData->all_expenses = $all_expenses;
        $viewData->all_deposits = $all_deposits;
        $viewData->total_expense = $total_expense;
        $viewData->item = $item;

        if ($sitewallet->type == 1) {
            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_4_1_expenses", $viewData);
        } elseif (($sitewallet->type == 0))
            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_4_2_deposits", $viewData);
    }

    public function open_edit_expenses_modal($expense_id)
    {
        // Verilerin getirilmesi

        $edit_expense = $this->Sitewallet_model->get(array("id" => $expense_id));
        $item = $this->Site_model->get(array("id" => $edit_expense->site_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));

        // Görünüm için değişkenlerin set edilmesi
        $viewData = new stdClass();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->project = $project;
        $viewData->edit_expense = $edit_expense;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modals/edit_expense_modal_form", $viewData);
    }

    public function edit_expense($expense_id)
    {

        // Veritabanından site, sözleşme ve proje bilgilerini alıyoruz
        $edit_expense = $this->Sitewallet_model->get(array("id" => $expense_id));
        $item = $this->Site_model->get(array("id" => $edit_expense->site_id));
        $contract = $this->Contract_model->get(array("id" => $item->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));


        // Form validation kütüphanesini yüklüyoruz
        $this->load->library("form_validation");

        // Form doğrulama kuralları ekliyoruz
        $this->form_validation->set_rules('edit_expense_date', 'Tarih', 'required');
        $this->form_validation->set_rules('edit_price', 'Fiyat', 'required|numeric');
        $this->form_validation->set_rules('edit_payment_type', 'Ödeme Türü', 'required');
        $this->form_validation->set_rules('edit_expense_notes', 'Açıklama', 'required');

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

        // Eğer doğrulama başarılı ise aşağıdaki işlemleri yapıyoruz
        if ($validate) {

            // Eğer formdan tarih bilgisi gelmişse, formatı Y-m-d olarak ayarlıyoruz
            if ($this->input->post("edit_expense_date")) {
                $date = dateFormat('Y-m-d', $this->input->post("edit_expense_date"));
            } else {
                $date = null; // Eğer tarih girilmediyse, null değer atıyoruz
            }


            $bill_code = $this->input->post("edit_bill_code");
            if (empty($bill_code)) {
                $bill_code = NULL; // Eğer boşsa NULL ata
            }


            $update = $this->Sitewallet_model->update(
                array("id" => $expense_id),
                array(
                    "date" => $date,
                    "price" => $this->input->post("edit_price"),
                    "bill_code" => $bill_code,
                    "payment_type" => $this->input->post("edit_payment_type"),
                    "note" => $this->input->post("edit_expense_notes"),
                    "updatedAt" => date("Y-m-d"),
                    "updatedBy" => active_user_id(),
                )
            );


            // Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Sitewallet/$expense_id";
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

            $all_expenses = $this->Sitewallet_model->get_all(array("site_id" => $item->id, "type" => 1));
            $all_deposits = $this->Sitewallet_model->get_all(array("site_id" => $item->id, "type" => 0));
            $total_expense = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "1");
            $total_deposit = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "0");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->contract = $contract;
            $viewData->project = $project;
            $viewData->all_deposits = $all_deposits;
            $viewData->all_expenses = $all_expenses;
            $viewData->total_expense = $total_expense;
            $viewData->total_deposit = $total_deposit;
            $viewData->item = $item;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_4_1_expenses", $viewData);

        } else {

            $all_expenses = $this->Sitewallet_model->get_all(array("site_id" => $item->id, "type" => 1));
            $all_deposits = $this->Sitewallet_model->get_all(array("site_id" => $item->id, "type" => 0));
            $total_expense = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "1");
            $total_deposit = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "0");

            $viewData = new stdClass();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->contract = $contract;
            $viewData->project = $project;
            $viewData->all_expenses = $all_expenses;
            $viewData->all_deposits = $all_deposits;
            $viewData->total_expense = $total_expense;
            $viewData->total_deposit = $total_deposit;
            $viewData->item = $item;
            $viewData->form_error = true; // Formda hata olduğunu belirtiyoruz
            $viewData->error_modal = "EditExpenseModal"; // Hata modali için set edilen değişken
            $viewData->edit_expense = $edit_expense; // Hata modali için set edilen değişken

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_4_1_expenses", $viewData);

        }
    }

    public function sitewallet_file_delete($sitestock_id)
    {
        $site_stock = $this->Sitewallet_model->get(array("id" => $sitestock_id));
        $item = $this->Site_model->get(array("id" => $site_stock->site_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));

        // Dosya yolu
        $file_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Sitewallet";

        // Klasördeki tüm dosyaları alıyoruz
        $files = scandir($file_path);

        // '.' ve '..' gibi klasörleri filtreleyip sadece dosya isimlerini almak için array_filter kullanıyoruz
        $files = array_filter($files, function ($file) use ($file_path) {
            return !is_dir($file_path . '/' . $file); // Klasörleri dahil etmiyoruz, sadece dosyalar
        });

        // Dosya isimlerini uzantıları olmadan yeni bir diziye alıyoruz
        $file_names_without_extension = array_map(function ($file) {
            return pathinfo($file, PATHINFO_FILENAME); // Sadece dosya adını (uzantısız) alıyoruz
        }, $files);

        // $sitestock_id ile eşleşen bir dosya olup olmadığını kontrol ediyoruz
        if (in_array($sitestock_id, $file_names_without_extension)) {
            // Eşleşen dosyanın tam yolunu bul
            foreach ($files as $file) {
                $file_name_without_extension = pathinfo($file, PATHINFO_FILENAME);
                if ($file_name_without_extension == $sitestock_id) {
                    $file_to_delete = $file_path . '/' . $file; // Dosya yolunu oluştur
                    // Dosyayı sil
                    if (unlink($file_to_delete)) {
                        // Silme işlemi başarılı ise
                        echo json_encode(['success' => true, 'message' => 'Dosya başarıyla silindi.']);
                    } else {
                        // Hata durumu
                        echo json_encode(['success' => false, 'message' => 'Dosya silinemedi.']);
                    }
                    return; // İşlem tamamlandı, daha fazla işlem yapma
                }
            }
        } else {
            // Dosya bulunamadıysa
            echo json_encode(['success' => false, 'message' => 'Dosya bulunamadı.']);
        }
    }


    /*Sitewalllet End*/

    /*----*/

    /*Validation Controls Start*/

    public
    function name_control($user_name)
    {
        if (preg_match('/^([a-z üğışçöÜĞİŞÇÖ])*$/i', $user_name)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function IBAN_control($IBAN)
    {
        // Tüm boşlukları kaldır
        $IBAN = str_replace(' ', '', $IBAN);

        // "TR" ibaresinin başında olup olmadığını kontrol et
        if (substr($IBAN, 0, 2) !== 'TR') {
            $IBAN = 'TR' . $IBAN; // Eğer yoksa, başına "TR" ekle
        }

        // Toplam uzunluğunu kontrol et
        if (strlen($IBAN) === 26) {
            return TRUE; // IBAN geçerli
        } else {
            return FALSE; // IBAN geçersiz
        }
    }

    public function TC_control($social_id)
    {
        // T.C. kimlik numarasının 11 haneli olması gerekiyor
        if (strlen($social_id) !== 11) {
            return FALSE;
        }

        // T.C. kimlik numarasının yalnızca rakamlardan oluşup oluşmadığını kontrol et
        if (!preg_match('/^[0-9]+$/', $social_id)) {
            return FALSE;
        }

        // Son rakamın çift olup olmadığını kontrol et
        if ($social_id[10] % 2 != 0) {
            return FALSE;
        }

        // İlk 10 rakamın toplamını hesapla
        $first10Sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $first10Sum += (int)$social_id[$i];
        }

        // İlk 10 rakamın toplamının birler basamağını al
        $eleventhDigit = $first10Sum % 10;

        // 11. rakamın doğruluğunu kontrol et
        if ((int)$social_id[10] !== $eleventhDigit) {
            return FALSE;
        }
        return TRUE; // T.C. kimlik numarası geçerli
    }

    public
    function duplicate_code_check($file_name)
    {
        $file_name = "SNT-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public
    function site_contractday($sitedal_day, $contract_day)
    {
        $date_diff = date_minus($sitedal_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /*Validation Controls End*/

    /*----*/

    /*Site Stock Start*/

    public
    function add_stock($site_id)
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

    public
    function exit_stock($site_id)
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

    public
    function open_exit_stock_modal($site_stok_id)
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

    public
    function delete_stock($stock_id)
    {
        // Verilerin getirilmesi
        $site_stock = $this->Sitestock_model->get(array("id" => $stock_id));


        $delete_stock = $this->Sitestock_model->delete(array(
            "id" => $site_stock->id,
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

    /*Site Stock End*/

    /*----*/

    /*Personel Start*/

    public
    function add_personel($site_id)
    {

        // Veritabanından site, sözleşme ve proje bilgilerini alıyoruz
        $item = $this->Site_model->get(array("id" => $site_id));
        $contract = $this->Contract_model->get(array("id" => $item->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));

        $settings = $this->Settings_model->get();

        // Form validation kütüphanesini yüklüyoruz
        $this->load->library("form_validation");

        // Form doğrulama kuralları ekliyoruz
        $this->form_validation->set_rules('name_surname', 'Ad Soyad', 'required|callback_name_control');
        $this->form_validation->set_rules('group', 'Meslek', 'required');

        if ($this->input->post("social_id")) {
            $this->form_validation->set_rules('social_id', 'TC Kimlik', 'callback_TC_control');
        }
        if ($this->input->post("IBAN")) {
            $this->form_validation->set_rules('IBAN', 'IBAN', 'callback_IBAN_control');
        }
        $this->form_validation->set_rules('start_date', 'Giriş Tarihi', 'required');

        $this->form_validation->set_message(
            array(
                "IBAN_control" => "<b>{field}</b> TR ibaresi hariç 24 haneden oluşmalıdır, eğer TR ibaresi ile girerseniz 26 haneli olmalıdır. Boşluklar dikkate alınmamaktadır",
                "TC_control" => "<b>{field}</b> Kimlik No Hatalı",
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "alpha" => "<b>{field}</b> alanı harflerden oluşmaladır",
                "name_control" => "<b>{field}</b> Özel Karakter Kullanmayınız",
                "numeric" => "<b>{field}</b> sayılardan oluşmalıdır",
            )
        );

        // Formun doğrulama işlemi başlatılıyor
        $validate = $this->form_validation->run();

        // Eğer doğrulama başarılı ise aşağıdaki işlemleri yapıyoruz
        if ($validate) {

            $name_surname = ucwords(strtolower($this->input->post("name_surname")));
            $IBAN = str_replace(' ', '', $this->input->post("IBAN"));

            // "TR" ibaresinin başında olup olmadığını kontrol et
            if (substr($IBAN, 0, 2) !== 'TR') {
                $IBAN = 'TR' . $IBAN; // Eğer yoksa, başına "TR" ekle
            }


            // Eğer formdan tarih bilgisi gelmişse, formatı Y-m-d olarak ayarlıyoruz
            if ($this->input->post("start_date")) {
                $start_date = dateFormat('Y-m-d', $this->input->post("start_date"));
            } else {
                $start_date = null;
            }

            $insert = $this->Workman_model->add(
                array(
                    "site_id" => $site_id,
                    "name_surname" => $name_surname,
                    "group" => $this->input->post("group"),
                    "bank" => $this->input->post("bank"),
                    "IBAN" => $IBAN,
                    "social_id" => $this->input->post('social_id'),
                    "start_date" => $start_date,
                    "notes" => $this->input->post('personel_notes'),
                    "isActive" => 1,
                )
            );

            // Eklenen kaydın ID'si alınarak dosya yüklemesi için kullanılıyor
            $record_id = $this->db->insert_id();

            // Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Personel/$record_id";
            // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            // Yüklenen dosyanın ismi SEO dostu hale getiriliyor
            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

            // Dosya boyutu alınıyor
            $size = $_FILES["file"]["size"];

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

            $viewData = new stdClass();
            $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1));
            $passive_personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 0));

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->contract = $contract;
            $viewData->project = $project;
            $viewData->active_personel_datas = $active_personel_datas;
            $viewData->passive_personel_datas = $passive_personel_datas;
            $viewData->workgroups = json_decode($item->active_group, true);

            $viewData->item = $item;
            $viewData->settings = $settings;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_5_1_personel", $viewData);

        } else {

            $viewData = new stdClass();
            $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1));
            $passive_personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 0));

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->contract = $contract;
            $viewData->project = $project;
            $viewData->active_personel_datas = $active_personel_datas;
            $viewData->passive_personel_datas = $passive_personel_datas;
            $viewData->workgroups = json_decode($item->active_group, true);
            $viewData->item = $item;
            $viewData->settings = $settings;

            $viewData->form_error = true; // Formda hata olduğunu belirtiyoruz
            $viewData->error_modal = "AddPersonelModal"; // Hata modali için set edilen değişken

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_5_1_personel", $viewData);

        }
    }

    public
    function edit_personel($personel_id)
    {

        // Veritabanından site, sözleşme ve proje bilgilerini alıyoruz
        $edit_personel = $this->Workman_model->get(array("id" => $personel_id));
        $item = $this->Site_model->get(array("id" => $edit_personel->site_id));
        $contract = $this->Contract_model->get(array("id" => $item->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));

        $settings = $this->Settings_model->get();

        // Form validation kütüphanesini yüklüyoruz
        $this->load->library("form_validation");

        // Form doğrulama kuralları ekliyoruz
        $this->form_validation->set_rules('name_surname', 'Ad Soyad', 'required|callback_name_control');
        $this->form_validation->set_rules('group', 'Meslek', 'required');

        if ($this->input->post("social_id")) {
            $this->form_validation->set_rules('social_id', 'TC Kimlik', 'callback_TC_control');
        }
        if ($this->input->post("IBAN")) {
            $this->form_validation->set_rules('IBAN', 'IBAN', 'callback_IBAN_control');
        }
        $this->form_validation->set_rules('start_date', 'Giriş Tarihi', 'required');

        $this->form_validation->set_message(
            array(
                "IBAN_control" => "<b>{field}</b> TR ibaresi hariç 24 haneden oluşmalıdır, eğer TR ibaresi ile girerseniz 26 haneli olmalıdır. Boşluklar dikkate alınmamaktadır",
                "TC_control" => "<b>{field}</b> Kimlik No Hatalı",
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "alpha" => "<b>{field}</b> alanı harflerden oluşmaladır",
                "name_control" => "<b>{field}</b> Özel Karakter Kullanmayınız",
                "numeric" => "<b>{field}</b> sayılardan oluşmalıdır",
            )
        );

        // Formun doğrulama işlemi başlatılıyor
        $validate = $this->form_validation->run();

        // Eğer doğrulama başarılı ise aşağıdaki işlemleri yapıyoruz
        if ($validate) {

            $name_surname = ucwords(mb_strtolower($this->input->post("name_surname"), 'UTF-8'));
            $IBAN = str_replace(' ', '', $this->input->post("IBAN"));

            // "TR" ibaresinin başında olup olmadığını kontrol et
            if (substr($IBAN, 0, 2) !== 'TR') {
                $IBAN = 'TR' . $IBAN; // Eğer yoksa, başına "TR" ekle
            }


            // Eğer formdan tarih bilgisi gelmişse, formatı Y-m-d olarak ayarlıyoruz
            if ($this->input->post("start_date")) {
                $start_date = dateFormat('Y-m-d', $this->input->post("start_date"));
            } else {
                $start_date = null;
            }

            if ($this->input->post("exit_date")) {
                $exit_date = dateFormat('Y-m-d', $this->input->post("exit_date"));
                $is_Active = 0;
            } else {
                $exit_date = null;
                $is_Active = 1;
            }

            $update = $this->Workman_model->update(
                array("id" => $edit_personel->id),
                array(
                    "name_surname" => $name_surname,
                    "group" => $this->input->post("group"),
                    "bank" => $this->input->post("bank"),
                    "IBAN" => $IBAN,
                    "social_id" => $this->input->post('social_id'),
                    "start_date" => $start_date,
                    "exit_date" => $exit_date,
                    "notes" => $this->input->post('personel_notes'),
                    "isActive" => $is_Active,
                )
            );


            // Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Personel/$edit_personel->id";
            // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            // Yüklenen dosyanın ismi SEO dostu hale getiriliyor
            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

            // Dosya boyutu alınıyor
            $size = $_FILES["file"]["size"];

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

            $viewData = new stdClass();
            $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $item->id, "isActive" => 1));
            $passive_personel_datas = $this->Workman_model->get_all(array("site_id" => $item->id, "isActive" => 0));

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->contract = $contract;
            $viewData->project = $project;
            $viewData->active_personel_datas = $active_personel_datas;
            $viewData->passive_personel_datas = $passive_personel_datas;
            $viewData->workgroups = json_decode($item->active_group, true);

            $viewData->item = $item;
            $viewData->settings = $settings;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_5_1_personel", $viewData);

        } else {

            $viewData = new stdClass();
            $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $item->id, "isActive" => 1));
            $passive_personel_datas = $this->Workman_model->get_all(array("site_id" => $item->id, "isActive" => 0));

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->contract = $contract;
            $viewData->project = $project;
            $viewData->active_personel_datas = $active_personel_datas;
            $viewData->passive_personel_datas = $passive_personel_datas;
            $viewData->workgroups = json_decode($item->active_group, true);
            $viewData->item = $item;
            $viewData->settings = $settings;
            $viewData->edit_personel = $edit_personel;

            $viewData->form_error = true; // Formda hata olduğunu belirtiyoruz
            $viewData->error_modal = "EditPersonelModal"; // Hata modali için set edilen değişken

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_5_1_personel", $viewData);

        }
    }

    public function open_edit_personel_modal($personel_id)
    {
        // Verilerin getirilmesi

        $edit_personel = $this->Workman_model->get(array("id" => $personel_id));
        $item = $this->Site_model->get(array("id" => $edit_personel->site_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $settings = $this->Settings_model->get();

        // Görünüm için değişkenlerin set edilmesi
        $viewData = new stdClass();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->project = $project;
        $viewData->edit_personel = $edit_personel;
        $viewData->workgroups = json_decode($item->active_group, true);
        $viewData->settings = $settings;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modals/edit_personel_modal_form", $viewData);
    }

    public
    function chance_list($site_id, $group_code = null, $situation = null)
    {
        $item = $this->Site_model->get(array("id" => $site_id));
        $contract = $this->Contract_model->get(array("id" => $item->contract_id));
        $project = $this->Project_model->get(array("id" => $item->proje_id));
        $settings = $this->Settings_model->get();

        $viewData = new stdClass();
        if (isset($situation) && $group_code != 0) {
            // Eğer $situation tanımlı ve $group_code sıfırdan farklıysa
            $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => $situation, "group" => $group_code));
        } elseif ($group_code == 0 && isset($situation)) {
            // Eğer $group_code 0 ise ve $situation tanımlıysa
            $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => $situation));
        } elseif ($group_code != 0 && !isset($situation)) {
            // Eğer $group_code tanımlı ve $situation null ise
            $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "group" => $group_code));
        } elseif (!isset($situation) && !isset($group_code)) {
            // Eğer her iki değer de tanımlı değilse
            $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id));
        }

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->contract = $contract;
        $viewData->project = $project;
        $viewData->active_personel_datas = $active_personel_datas;
        $viewData->group_code = $group_code;
        $viewData->situation = $situation;
        $viewData->workgroups = json_decode($item->active_group, true);

        $viewData->item = $item;
        $viewData->settings = $settings;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_5_1_personel", $viewData);
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
        $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1), "group DESC");


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->year = $year;
        $viewData->month = $month;
        $viewData->puantaj_data = json_decode($puantaj->puantaj, true);
        $viewData->active_personel_datas = $active_personel_datas;
        $viewData->form_error = true;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_5_2_puantaj", $viewData);

    }

    public
    function puantaj_date($site_id)
    {

        $month = $this->input->post('month');
        $year = $this->input->post('year');

// O ayın son gününü bul
        $last_day_of_month = date('t', strtotime("$year-$month-01"));

// $last_day_of_month, o ayın son gününü (kaç gün olduğunu) verecektir
        $count_of_days = (int)$last_day_of_month;

        $viewData = new stdClass();
        $this->load->model("Attendance_model");
        $puantaj = $this->Attendance_model->get(array("site_id" => $site_id, "year_month" => "$year-$month"));

        /** Tablodan Verilerin Getirilmesi.. */
        $item = $this->Site_model->get(array("id" => $site_id));
        $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1), "group DESC");


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->year = $year;
        $viewData->month = $month;
        $viewData->count_of_days = $count_of_days;

        if (isset($puantaj)) {
            $viewData->puantaj = $puantaj;
            $viewData->puantaj_data = json_decode($puantaj->puantaj, true);
        } else {
            $viewData->puantaj = null;
            $viewData->puantaj_data = null;
        }
        $viewData->active_personel_datas = $active_personel_datas;
        $viewData->form_error = true;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/tabs/tab_5_2_puantaj", $viewData);

    }

    /*Personel End*/


}