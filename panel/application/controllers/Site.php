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

        $this->load->model("Site_model");
        $this->load->model("Site_file_model");
        $this->load->model("Contract_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");
        $this->load->model("Vehicle_model");
        $this->load->model("Auction_model");
        $this->load->model("Condition_model");
        $this->load->model("Report_model");
        $this->load->model("Report_sign_model");
        $this->load->model("Sitestock_model");
        $this->load->model("Sitewallet_model");
        $this->load->model("Extime_model");
        $this->load->model("Safety_model");
        $this->load->model("Costinc_model");
        $this->load->model("Workman_model");
        $this->load->model("Workgroup_model");
        $this->load->model("Workmachine_model");
        $this->load->model("Favorite_model");

        $this->Upload_Folder = "uploads";
        $this->Module_Name = "Site";
        $this->Module_Title = "Şantiye Yönetimi";
        $this->Module_Main_Dir = "project_v";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";

        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        $this->Dependet_id_key = "site_id";
        $this->Module_Parent_Name = "contract";

        //Folder Structure

        $this->moduleFolder = "site_module";
        $this->viewFolder = "site_v";
        $this->Module_Title = "Şantiye";
        $this->Module_Main_Dir = "site_v";
        $this->Display_route = "file_form";
        $this->Display_Folder = "display";
        $this->Add_Folder = "add";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        $this->File_List = "file_list_v";
        $this->List_Folder = "list";
        $this->Dependet_id_key = "site_id";
        $this->Common_Files = "common";

        $this->Select_Folder = "select";
        $this->Update_Folder = "update";
        $this->File_List = "file_list_v";
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
            'durumu' => 1,
            'id' => $project_id
        ));

        $users = $this->User_model->get_all(array());
        $vehicles = $this->Vehicle_model->get_all(array());

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
        $viewData->vehicles = $vehicles;

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
            $path = "$this->Upload_Folder/project_v/$project_code/$file_name/main/";

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
                'durumu' => 1,
                'id' => $project_id
            ));

            $users = $this->User_model->get_all(array());
            $vehicles = $this->Vehicle_model->get_all(array());

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
            $viewData->vehicles = $vehicles;
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function sitewallet($site_id, $type)
    {
        if ($this->input->post("expense_date")) {
            $date = dateFormat('Y-m-d', $this->input->post("expense_date"));
        } else {
            $date = null;
        }

        $site_code = get_from_id("site", "dosya_no", $site_id);
        $proje_id = project_id_site($site_id);
        $project_code = project_code($proje_id);

        $path = "$this->File_Dir_Prefix/$project_code/$site_code/Sitewallet/$date";

        if (!is_dir($path)) {
            mkdir("$path", 0777, TRUE);
            echo "oluştu";
        } else {
            echo "aynı isimde dosya mevcut";
        }


        $insert = $this->Sitewallet_model->add(
            array(
                "site_id" => $site_id,
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

        $record_id = $this->db->insert_id();

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

        $size = $_FILES["file"]["size"];

        $config["allowed_types"] = "*";
        $config["upload_path"] = "$path";
        $config["file_name"] = $record_id;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

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

        redirect(base_url("$this->Module_Name/$this->Display_route/$site_id/sitewallet"));


        // İşlemin Sonucunu Session'a yazma işlemi...
        $this->session->set_flashdata("alert", $alert);
    }

    public function file_form($id, $active_tab = null)
    {
        $session_user = $this->session->userdata("user");

        if ($session_user->user_role != 2) {
            if (!isAdmin()) {
                redirect(base_url("error"));
            }
        }

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

        $reports = $this->Report_model->get_all(array("site_id" => $id), "report_date DESC");

        $contractor_sign = $this->Report_sign_model->get(array("site_id" => $id, "module" => "contractor_sign"));
        $contractor_staff = $this->Report_sign_model->get_all(array("site_id" => $id, "module" => "contractor_staff"));
        $owner_sign = $this->Report_sign_model->get(array("site_id" => $id, "module" => "owner_sign"));
        $owner_staff = $this->Report_sign_model->get_all(array("site_id" => $id, "module" => "owner_staff"));
        $personel_datas = $this->Workman_model->get_all(array("site_id" => $id, "isActive" => 1), "group DESC");
        $year_month = date('Y-m');
        $puantaj = $this->Attendance_model->get(array("site_id" => $id, "year_month" => $year_month));

        $site_stocks = $this->Sitestock_model->get_all(array("site_id" => $id, "stock_id" => null));

        $all_expenses = $this->Sitewallet_model->get_all(array(
            "site_id" => $id,
            "type" => 1
        ));

        $all_deposites = $this->Sitewallet_model->get_all(array(
            "site_id" => $id,
            "type" => 0
        ));

        $conn_safety = $this->Safety_model->get(array(
            "site_id" => $id
        ));

        $main_categories = $this->Workgroup_model->get_all(array(
            'main_category' => 1
        ));

        $main_categories_workmachine = $this->Workmachine_model->get_all(array(
            'main_category' => 1
        ));

        $item = $this->Site_model->get(
            array(
                "id" => $id
            )
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->reports = $reports;
        $viewData->site_stocks = $site_stocks;
        $viewData->active_tab = $active_tab;
        $viewData->all_expenses = $all_expenses;
        $viewData->all_deposites = $all_deposites;
        $viewData->personel_datas = $personel_datas;
        $viewData->main_categories = $main_categories;
        $viewData->main_categories_workmachine = $main_categories_workmachine;
        $viewData->item = $item;
        $viewData->puantaj = $puantaj;
        if (!empty($puantaj->puantaj)) {
            $viewData->puantaj_data = json_decode($puantaj->puantaj,true);
        }
        $viewData->contractor_sign = $contractor_sign;
        $viewData->contractor_staff = $contractor_staff;
        $viewData->owner_sign = $owner_sign;
        $viewData->owner_staff = $owner_staff;
        $viewData->workgroups = json_decode($item->active_group, true);
        $viewData->workmachines = json_decode($item->active_machine, true);
        $viewData->fav = $fav;


        $viewData->item_files = $this->Site_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
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
        $vehicles = $this->Vehicle_model->get_all(array());


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
        $viewData->vehicles = $vehicles;

        $viewData->item = $this->Site_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Site_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function update_project($id)
    {

        $this->load->library("form_validation");

        $this->form_validation->set_rules("santiye_sefi", "Şantiye Şefi", "greater_than[0]|required|trim");
        $this->form_validation->set_rules("santiye_ad", "Şantiye Adı", "required|trim");

        $validate = $this->form_validation->run();

        if ($validate) {


            $personeller = $this->input->post('teknik_personel');

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

            $update = $this->Site_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "santiye_ad" => $this->input->post("santiye_ad"),
                    "santiye_sefi" => $this->input->post("santiye_sefi"),
                    "teknik_personel" => $data_personel,
                    "araclar" => $data_araclar,
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
                    "text" => "Kayıt Ekleme sırasında bir problem oluştu",
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

            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Project_model->get(
                array(
                    "id" => $id,
                )
            );
            $vehicles = $this->Vehicle_model->get_all(array());

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update_project";
            $viewData->form_error = true;
            $viewData->vehicles = $vehicles;


            $viewData->item = $this->Site_model->get(
                array(
                    "id" => $id
                )
            );
            $viewData->item_files = $this->Site_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                ),
            );
            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {
        $site_code = get_from_id("site", "dosya_no", $id);
        $project_id = get_from_id("site", "proje_id", $id);
        $project_code = project_code($project_id);
        $path = "$this->File_Dir_Prefix/$project_code/$site_code";

        $delete1 = $this->Site_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

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

        $project_id = get_from_id("site", "proje_id", $id);
        $project_code = project_code($project_id);
        $site_code = site_code($id);
        $path = "$this->File_Dir_Prefix/$project_code/$site_code/main";

        if (!is_dir($path)) {
            mkdir("$path", 0777, TRUE);
            echo "oluştu";
        } else {
            echo "aynı isimde dosya mevcut";
        }

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $config["allowed_types"] = "*";
        $config["upload_path"] = "$path";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Site_file_model->add(
                array(
                    "img_url" => $uploaded_file,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                    "$this->Dependet_id_key" => $id,
                    "size" => $size
                )
            );
            echo $config["upload_path"];


        } else {
            echo "islem basarisiz";
            echo $config["upload_path"];

        }

    }

    public function file_download($id)
    {
        $fileName = $this->Site_file_model->get(
            array(
                "id" => $id
            )
        );


        $site_id = get_from_id("site_files", "site_id", $id);
        $project_id = get_from_id("site", "proje_id", $site_id);
        $project_code = project_code($project_id);
        $site_code = site_code($site_id);
        $file_path = "$this->File_Dir_Prefix/$project_code/$site_code/main/$fileName->img_url";

        if ($file_path) {

            if ($file_path && file_exists($file_path)) {
                $data = file_get_contents($file_path);
                force_download($fileName->img_url, $data);
                $alert = [
                    "title" => "İşlem Başarılı",
                    "text" => "Dosya indirildi",
                    "type" => "success"
                ];

                $this->session->set_flashdata("alert", $alert);
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Dosya veritabanında var ancak klasör içinden silinmiş, SİSTEM YÖNETİCİNİZE BAŞVURUN",
                    "type" => "danger"
                );

                $this->session->set_flashdata("alert", $alert);
            }
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Dosya yok",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);
        }
    }

    public function expense_download($expense_id)
    {

        $date_folder = get_from_id("sitewallet", "date", "$expense_id");

        $site_id = get_from_id("sitewallet", "site_id", $expense_id);

        $site_code = site_code($site_id);
        $project_id = project_id_site($site_id);
        $project_code = project_code($project_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$site_code/Sitewallet/$date_folder";

        $files = scandir($file_path);
        foreach ($files as $file) {
            // Dosya ismini uzantısız olarak almak için pathinfo() fonksiyonunu kullanabilirsiniz
            $filename = pathinfo($file, PATHINFO_FILENAME);

            if (strpos($filename, $expense_id) !== false) {
                $this->load->helper('download');
                force_download("$file_path/$file", NULL);
            }
        }


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

    public function download_all($site_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $site_code = site_code($site_id);
        $project_id = project_id_site($site_id);
        $project_code = project_code($project_id);
        $project_name = get_from_id("projects", "proje_ad", $project_id);

        $path = "uploads/project_v/$project_code/$site_code";
        $zip_name = $project_name;

        $this->zip->read_dir($path, FALSE);
        $this->zip->download("$zip_name.zip");

    }

    public function refresh_file_list($id)
    {
        $viewData = new stdClass();
        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->item = $this->Site_model->get(
            array(
                "id" => $id
            )
        );
        $viewData->item_files = $this->Site_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );
        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
        echo $render_html;
    }

    public function fileDelete($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $fileName = $this->Site_file_model->get(
            array(
                "id" => $id
            )
        );

        $site_id = get_from_id("site_files", "site_id", $id);
        $project_id = project_id_site($site_id);
        $project_code = project_code($project_id);
        $dosya_no = site_code($site_id);

        $delete = $this->Site_file_model->delete(
            array(
                "id" => $id
            )
        );

        $path = "uploads/project_v/$project_code/$dosya_no/main/$fileName->img_url";
        unlink($path);

        if ($delete) {


            $alert = array(
                "title" => "Dosya Sil",
                "text" => "Dosyayı Başarılı Bir Şekilde Sildiniz",
                "type" => "success"
            );
            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Site_model->get(
                array(
                    "id" => $site_id
                )
            );
            $viewData->item_files = $this->Site_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $site_id
                )
            );


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

    public function fileDelete_all($site_id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $site_code = site_code($site_id);
        $project_id = project_id_site($site_id);
        $project_code = project_code($project_id);

        $delete = $this->Site_file_model->delete(
            array(
                "site_id" => $site_id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$site_code/main");
            !empty($value) && array_map('unlink', glob($dir_files));

            $alert = array(
                "title" => "Tüm Dosyalar Silindi",
                "text" => " Tüm Dosyaları Silme Başarılı",
                "type" => "success"
            );

            $this->session->set_flashdata("alert", $alert);

            $viewData->item = $this->Site_model->get(
                array(
                    "id" => $site_id
                )
            );

            $viewData->item_files = $this->Site_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $site_id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;


        } else {

            $alert = array(
                "title" => "Dosyalar Silinemedi",
                "text" => " Tüm Dosyaları Silme Başarısız",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);

        }

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

        $viewData->item_files = $this->Site_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $site_id
            ),
        );

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

        $viewData->item_files = $this->Site_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $site_id
            ),
        );

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

        $viewData->item_files = $this->Site_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $site_id
            ),
        );

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
        $viewData->item_files = $this->Site_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $site_id
            ),
        );
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
                    "title" => site_code_name($id)
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

            $viewData->item_files = $this->Site_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $site_id
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

            $viewData->item_files = $this->Site_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $site_id
                )
            );

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

        $viewData->item_files = $this->Site_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $site_id
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

    public function save_personel($site_id)
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

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/puantaj_liste", $viewData);
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


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/puantaj_liste", $viewData);
        }


    }


    public function update_puantaj()
    {

        $workerId = $this->input->post('workerId');
        $date = $this->input->post('date');
        $site_id = $this->input->post('site');
        $is_checked = $this->input->post('isChecked');

        $this->load->model("Attendance_model");

        $year_month = dateFormat('Y-m', $date);
        $day = dateFormat('d', $date);

        $old_puantaj = $this->Attendance_model->get(array("site_id" => 1, "year_month" => $year_month));

        if (!empty($old_puantaj)){
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
            $contract_id = contract_id_module("site", "$site_id");
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
        $puantaj = $this->Attendance_model->get(array("site_id" => 1, "year_month" => $year_month));


        /** Tablodan Verilerin Getirilmesi.. */
        $item = $this->Site_model->get(array("id" => $site_id));
        $personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1), "group DESC");



        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->puantaj_data = json_decode($puantaj->puantaj,true);;
        $viewData->personel_datas = $personel_datas;
        $viewData->form_error = true;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/modules/puantaj_liste", $viewData);

    }

    public function check_end_date($end_date)
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

    public function name_control($user_name)
    {
        if (preg_match('/^([-a-z üğışçöÜĞİŞÇÖ])+$/i', $user_name)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('custom_alpha_check', 'Alan sadece harf, boşluk, tire ve Türkçe karakterler içerebilir.');
            return FALSE;
        }
    }
}