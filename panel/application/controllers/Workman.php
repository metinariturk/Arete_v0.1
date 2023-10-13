<?php

class Workman extends CI_Controller
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

        $this->moduleFolder = "safety_module";
        $this->viewFolder = "workman_v";

        $this->load->model("Workman_model");
        $this->load->model("Workman_file_model");
        $this->load->model("Workgroup_model");
        $this->load->model("Settings_model");
        $this->load->model("Site_model");
        $this->load->model("Order_model");
        $this->load->model("Education_model");
        $this->load->model("Safety_model");
        $this->load->model("Site_model");
        $this->load->model("Project_model");
        $this->load->model("Contract_model");

        $this->Module_Name = "workman";
        $this->Module_Title = "İş Grupları";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "workman_id";
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";
        $this->Common_Files = "common";
        $this->Upload_Folder = "uploads";

        $this->Module_Main_Dir = "safety_v";
        $this->Module_Depended_Dir = "safety";
        $this->File_List = "file_list_v";
        $this->Module_File_Dir = "Safety";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_File_Dir";

    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Workman_model->get_all(array());
        $main_categories = $this->Workgroup_model->get_all(array(
            'main_category' => 1
        ));
        $activeworkers = $this->Workman_model->get_all_active(array());
        $passiveworkers = $this->Workman_model->get_all_passive(array());
        $allworkers = $this->Workman_model->get_all(array());

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->main_categories = $main_categories;
        $viewData->activeworkers = $activeworkers;
        $viewData->passiveworkers = $passiveworkers;
        $viewData->allworkers = $allworkers;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function select($id)
    {

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $main_categories = $this->Workman_model->get_main_group(array());
        $site = $this->Site_model->get(array("id" => $id));

        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Select_Folder";
        $viewData->main_categories = $main_categories;
        $viewData->site = $site;
        $viewData->settings = $settings;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id, $from = null)
    {
        $viewData = new stdClass();

        $safety_id = get_from_id("workman", "safety_id", $id);
        $settings = $this->Settings_model->get();
        $safety = $this->Safety_model->get(
            array(
                'id' => $safety_id,
            )
        );
        $site = $this->Site_model->get(
            array(
                'id' => $safety->site_id
            )
        );

        $project = $this->Project_model->get(
            array(
                'id' => $safety->proje_id
            )
        );

        $contract = $this->Contract_model->get(
            array(
                'id' => $site->contract_id
            )
        );
        $educations = $this->Education_model->get_all(array(
            'safety_id' => $safety_id,
            'worker_id' => $id
        ));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->active_tab = $from;
        $viewData->settings = $settings;
        $viewData->safety = $safety;
        $viewData->site = $site;
        $viewData->contract = $contract;
        $viewData->project = $project;
        $viewData->educations = $educations;


        $viewData->item = $this->Workman_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Workman_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }


    public function new_form($id)
    {

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $site_id = get_from_id("safety", "site_id", $id);
        $sub_categories = $this->Workgroup_model->get_all(array(
            'sub_category' => 1
        ));
        
        $activeworkers = $this->Workman_model->get_all(array(
            'site_id' => $id,
            'isActive'=> 1
        ));

        $passiveworkers = $this->Workman_model->get_all(array(
            'site_id',$id,
            'isActive', 0
        ));

        $allworkers = $this->Workman_model->get_all(array(
            "site_id" => $id
        ));

        $settings = $this->Settings_model->get();
        $hata = "Personel sorgulamaları NVİ üzerinden yapılmaktadır.";

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->sub_categories = $sub_categories;
        $viewData->sid = $site_id;
        $viewData->id = $id;
        $viewData->hata = $hata;
        $viewData->activeworkers = $activeworkers;
        $viewData->passiveworkers = $passiveworkers;
        $viewData->allworkers = $allworkers;

        $viewData->settings = $settings;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function save($id)
    {

        $name = $this->input->post("name");
        $surname = $this->input->post("surname");
        $social_id = $this->input->post("social_id");
        $birth_date = $this->input->post("birth_date");
        $start_date = $this->input->post("start_date");
        $group = $this->input->post("group");

        $data = $name . "*" . $surname . "*" . $social_id . "*" . $birth_date;

        $tckn_control = tckn_control();

        $data_detail = explode("*", $data);
        $name = $data_detail[0];
        $surname = $data_detail[1];
        $social_id = $data_detail[2];
        $birth_date = $data_detail[3];
        $folder_name = convertToSEO($name . "-" . $surname);

        $client = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");

        $result = $client->TCKimlikNoDogrula([
            'TCKimlikNo' => $social_id,
            'Ad' => $name,
            'Soyad' => $surname,
            'DogumYili' => $birth_date
        ]);

        if ($result->TCKimlikNoDogrulaResult == 1 and $tckn_control == 1) {
            $tckn_validation = 1;
        } elseif ($result->TCKimlikNoDogrulaResult == 1 and $tckn_control == 0) {
            $tckn_validation = 1;
        } elseif ($result->TCKimlikNoDogrulaResult != 1 and $tckn_control == 1) {
            $tckn_validation = 0;
        } elseif ($result->TCKimlikNoDogrulaResult != 1 and $tckn_control == 0) {
            $tckn_validation = 1;
        }


        if ($tckn_validation == 1) {

            $this->load->library("form_validation");

            $this->form_validation->set_rules("name", "Ad", "required|trim");
            $this->form_validation->set_rules("surname", "Soyad", "required|trim");
            $this->form_validation->set_rules("social_id", "TC Kimlik No", "exact_length[11]|required|trim");
            $this->form_validation->set_rules("birth_date", "Doğum Yılı", "required|trim");
            $this->form_validation->set_rules("start_date", "İşe Başlama Tarihi", "required|trim");
            $this->form_validation->set_rules("group", "Ekip Adı", "required|trim");
            $this->form_validation->set_rules('mobile', 'Telefon Numarası', 'required|regex_match[/^[0-9]{10}$/]'); //{10} for 10 digits number


            $this->form_validation->set_message(
                array(
                    "required" => "<b>{field}</b> alanı doldurulmalıdır",
                    "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                    "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                    "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük olmalıdır",
                    "exact_length" => "<b>{field}</b> <b>{param}</b> basamaklı rakamlardan oluşmalıdır",
                    "regex_match" => "<b>{field}</b>  555 123 45 67",
                )
            );

            // Form Validation Calistirilir..
            $validate = $this->form_validation->run();

            $main_category = $this->input->post("main_category");

            $sub_category = $this->input->post("sub_category");

            if (!empty($main_category)) {
                $insert2 = $this->Workman_model->add(
                    array(
                        "name" => $this->input->post("main_category"),
                        "main_category" => "1",
                    )
                );
            }

            if ($validate) {

                if ($this->input->post("start_date")) {
                    $baslangic_tarihi = dateFormat('Y-m-d', $this->input->post("start_date"));
                } else {
                    $baslangic_tarihi = null;
                }

                $safety_code = get_from_id("safety", "dosya_no", $id);
                $contract_id = get_from_any("safety", "contract_id", "id", "$id");
                $site_id = get_from_id("safety", "site_id", $id);
                $site_code = get_from_id("site", "dosya_no", $site_id);

                if (!isset($contract_id)) {
                    $project_id = get_from_any("safety", "proje_id", "id", "$id");
                    $project_code = project_code($project_id);
                    $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/personel/$folder_name/main";
                } else {

                    $project_id = project_id_cont($contract_id);
                    $contract_code = get_from_id("contract", "dosya_no", $contract_id);
                    $project_code = project_code($project_id);
                    $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/personel/$folder_name/main";
                }


                if (!is_dir($path)) {
                    mkdir("$path", 0777, TRUE);
                    echo "oluştu";
                } else {
                    echo "aynı isimde dosya mevcut";
                }

                $insert = $this->Workman_model->add(
                    array(
                        "name" => $name,
                        "surname" => $surname,
                        "social_id" => $social_id,
                        "birth_date" => $birth_date,
                        "start_date" => $baslangic_tarihi,
                        "group" => $this->input->post("group"),
                        "site_id" => $site_id,
                        "safety_id" => $id,
                        "createdAt" => date("Y-m-d"),
                        "isActive" => 1
                    )
                );

                $record_id = $this->db->insert_id();

                $insert2 = $this->Order_model->add(
                    array(
                        "module" => $this->Module_Name,
                        "connected_module_id" => $this->db->insert_id(),
                        "connected_project_id" => $id,
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
                redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));

            } else {


                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Form verilerinde eksik veya hatalı giriş var.",
                    "type" => "danger"
                );
                $this->session->set_flashdata("alert", $alert);

                $viewData = new stdClass();
                $settings = $this->Settings_model->get();
                $viewData->settings = $settings;
                $sub_categories = $this->Workgroup_model->get_all(array(
            'sub_category' => 1
        ));
                $tckn_control = tckn_control();
                $sid = get_from_id("safety", "site_id", "$id");
                $activeworkers = $this->Workman_model->get_all(array(
            'site_id' => $id,
            'isActive'=> 1
        ));
                $passiveworkers = $this->Workman_model->get_all(array(
            'site_id',$id,
            'isActive', 0
        ));
                $allworkers = $this->Workman_model->get_all(array(
            "site_id" => $id
        ));


                $hata = "NVİ ile yapılan doğrulama sonucu aşağıdaki bilgilerle eşleşen TC Vatandaşı yoktur. Bilgileri kontrol edip tekrar deneyiniz";


                /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
                $viewData->viewModule = $this->moduleFolder;
                $viewData->viewFolder = $this->viewFolder;
                $viewData->subViewFolder = "$this->Add_Folder";
                $viewData->form_error = true;
                $viewData->id = $id;
                $viewData->sub_categories = $sub_categories;
                $viewData->sid = $sid;
                $viewData->hata = $hata;
                $viewData->activeworkers = $activeworkers;
                $viewData->passiveworkers = $passiveworkers;
                $viewData->allworkers = $allworkers;


                $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
            }
        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form verilerinde eksik veya hatalı giriş var.",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $viewData->settings = $settings;
            $main_categories = $this->Workgroup_model->get_all(array(
            'main_category' => 1
        ));
            $hata = "NVİ ile yapılan doğrulama sonucu aşağıdaki bilgilerle eşleşen TC Vatandaşı yoktur. Bilgileri kontrol edip tekrar deneyiniz";
            $sid = get_from_id("safety", "site_id", "$id");
            $main_categories = $this->Workgroup_model->get_all_sub_group(array());
            $activeworkers = $this->Workman_model->get_all(array(
            'site_id' => $id,
            'isActive'=> 1
        ));
            $passiveworkers = $this->Workman_model->get_all(array(
            'site_id',$id,
            'isActive', 0
        ));
            $allworkers = $this->Workman_model->get_all(array(
            "site_id" => $id
        ));

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->id = $id;
            $viewData->sid = $sid;
            $viewData->main_categories = $main_categories;
            $viewData->hata = $hata;
            $viewData->activeworkers = $activeworkers;
            $viewData->passiveworkers = $passiveworkers;
            $viewData->allworkers = $allworkers;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }


    public function update_form($id)
    {

        $viewData = new stdClass();

        $site_id = get_from_id("workman", "site_id", $id);
        $main_categories = $this->Workgroup_model->get_all_sub_group(array());
        $activeworkers = $this->Workman_model->get_all(array(
            'site_id' => $id,
            'isActive'=> 1
        ));
        $passiveworkers = $this->Workman_model->get_all(array(
            'site_id',$id,
            'isActive', 0
        ));
        $allworkers = $this->Workman_model->get_all(array(
            "site_id" => $id
        ));
        $settings = $this->Settings_model->get();


        $pid = get_from_any("site", "proje_id", "id", "$id");

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->main_categories = $main_categories;
        $viewData->sid = $site_id;
        $viewData->id = $id;
        $viewData->activeworkers = $activeworkers;
        $viewData->passiveworkers = $passiveworkers;
        $viewData->allworkers = $allworkers;

        $viewData->settings = $settings;
        $viewData->item = $this->Workman_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function update($id)
    {

        $name = $this->input->post("name");
        $surname = $this->input->post("surname");
        $social_id = $this->input->post("social_id");
        $birth_date = $this->input->post("birth_date");

        $data = $name . "*" . $surname . "*" . $social_id . "*" . $birth_date;

        $tckn_control = tckn_control();

        $data_detail = explode("*", $data);
        $name = $data_detail[0];
        $surname = $data_detail[1];
        $social_id = $data_detail[2];
        $birth_date = $data_detail[3];

        $client = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");

        $result = $client->TCKimlikNoDogrula([
            'TCKimlikNo' => $social_id,
            'Ad' => $name,
            'Soyad' => $surname,
            'DogumYili' => $birth_date
        ]);

        if ($result->TCKimlikNoDogrulaResult == 1 and $tckn_control == 1) {
            $tckn_validation = 1;
        } elseif ($result->TCKimlikNoDogrulaResult == 1 and $tckn_control == 0) {
            $tckn_validation = 1;
        } elseif ($result->TCKimlikNoDogrulaResult != 1 and $tckn_control == 1) {
            $tckn_validation = 0;
        } elseif ($result->TCKimlikNoDogrulaResult != 1 and $tckn_control == 0) {
            $tckn_validation = 1;
        }


        if ($tckn_validation == 1) {

            $this->load->library("form_validation");

            $this->form_validation->set_rules("name", "Ad", "required|trim");
            $this->form_validation->set_rules("surname", "Soyad", "required|trim");
            $this->form_validation->set_rules("social_id", "TC Kimlik No", "exact_length[11]|required|trim");
            $this->form_validation->set_rules("birth_date", "Doğum Yılı", "required|trim");
            $this->form_validation->set_rules("start_date", "İşe Başlama Tarihi", "required|trim");
            $this->form_validation->set_rules("group", "Ekip Adı", "required|trim");

            $this->form_validation->set_message(
                array(
                    "required" => "<b>{field}</b> alanı doldurulmalıdır",
                    "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                    "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                    "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük olmalıdır",
                    "exact_length" => "<b>{field}</b> <b>{param}</b> basamaklı rakamlardan oluşmalıdır",
                )
            );

            // Form Validation Calistirilir..
            $validate = $this->form_validation->run();

            $main_category = $this->input->post("main_category");

            $sub_category = $this->input->post("sub_category");

            if (!empty($main_category)) {
                $insert2 = $this->Workman_model->add(
                    array(
                        "name" => $this->input->post("main_category"),
                        "main_category" => "1",
                    )
                );
            }

            if ($validate) {

                if ($this->input->post("start_date")) {
                    $baslangic_tarihi = dateFormat('Y-m-d', $this->input->post("start_date"));
                } else {
                    $baslangic_tarihi = null;
                }

                $update = $this->Workman_model->update(
                    array(
                        "id" => $id
                    ),
                    array(
                        "name" => $name,
                        "surname" => $surname,
                        "social_id" => $social_id,
                        "birth_date" => $birth_date,
                        "start_date" => $baslangic_tarihi,
                        "group" => $this->input->post("group"),
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
                    "text" => "Form verilerinde eksik veya hatalı giriş var.",
                    "type" => "danger"
                );
                $this->session->set_flashdata("alert", $alert);

                $viewData = new stdClass();
                $settings = $this->Settings_model->get();
                $viewData->settings = $settings;
                $main_categories = $this->Workgroup_model->get_all(array(
            'main_category' => 1
        ));
                $tckn_control = tckn_control();
                $site_id = get_from_id("workman", "site_id", $id);


                /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
                $viewData->viewModule = $this->moduleFolder;
                $viewData->viewFolder = $this->viewFolder;
                $viewData->subViewFolder = "$this->Update_Folder";
                $viewData->form_error = true;
                $viewData->id = $id;
                $viewData->sid = $site_id;
                $viewData->main_categories = $main_categories;

                $viewData->item = $this->Workman_model->get(
                    array(
                        "id" => $id
                    )
                );

                $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
            }
        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form verilerinde eksik veya hatalı giriş var.",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $viewData->settings = $settings;
            $main_categories = $this->Workgroup_model->get_all(array(
            'main_category' => 1
        ));
            $hata = "NVİ ile yapılan doğrulama sonucu aşağıdaki bilgilerle eşleşen TC Vatandaşı yoktur. Bilgileri kontrol edip tekrar deneyiniz";
            $sid = get_from_id("safety", "site_id", "$id");
            $main_categories = $this->Workgroup_model->get_all_sub_group(array());
            $activeworkers = $this->Workman_model->get_all(array(
            'site_id' => $id,
            'isActive'=> 1
        ));
            $passiveworkers = $this->Workman_model->get_all(array(
            'site_id',$id,
            'isActive', 0
        ));
            $allworkers = $this->Workman_model->get_all(array(
            "site_id" => $id
        ));

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->id = $id;
            $viewData->sid = $sid;
            $viewData->main_categories = $main_categories;
            $viewData->hata = $hata;
            $viewData->activeworkers = $activeworkers;
            $viewData->passiveworkers = $passiveworkers;
            $viewData->allworkers = $allworkers;

            $viewData->item = $this->Workman_model->get(
                array(
                    "id" => $id
                )
            );

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }


    public function delete($id)
    {
        $a = get_from_any_array("workman", "parent", "$id");
        foreach ($a as $b) {
            $this->Workman_model->update(
                array(
                    "id" => $b->id
                ),
                array(
                    "main_category" => null,
                    "sub_category" => null,
                    "deleted" => "1",
                    "parent" => null,
                )
            );
        }

        $update = $this->Workman_model->update(
            array(
                "id" => $id
            ),
            array(
                "main_category" => null,
                "sub_category" => null,
                "deleted" => "1",
                "parent" => null,
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
                "title" => "İşlem Başarısız",
                "text" => "Kayıt silme sırasında bir problem oluştu",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("workman/new_form"));
    }


    public function file_upload($id)
    {
        $name = get_from_id("workman", "name", $id);
        $surname = get_from_id("workman", "surname", $id);
        $site_id = get_from_id("workman", "site_id", $id);
        $contract_id = get_from_id("site", "contract_id", $site_id);
        $folder_name = convertToSEO($name . "-" . $surname);
        $safety_id = get_from_id("workman", "safety_id", $id);
        $safety_code = get_from_id("safety", "dosya_no", $safety_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/personel/$folder_name/main";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/personel/$folder_name/main";
        }


        if (!is_dir($path)) {
            mkdir("$path", 0777, TRUE);
            echo "oluştu";
        } else {
            echo "aynı isimde dosya mevcut";
        }

                $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $extention = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$path";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);


        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");


        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Workman_file_model->add(
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

    public function file_download($id, $from)
    {
        $fileName = $this->Workman_file_model->get(
            array(
                "id" => $id
            )
        );

        $workman_id = get_from_id("workman_files", "workman_id", $id);
        $name = get_from_id("workman", "name", $workman_id);
        $surname = get_from_id("workman", "surname", $workman_id);
        $folder_name = convertToSEO($name . "-" . $surname);
        $site_id = get_from_id("workman", "site_id", $workman_id);
        $contract_id = get_from_id("site", "contract_id", $site_id);
        $safety_id = get_from_id("workman", "safety_id", $workman_id);
        $safety_code = get_from_id("safety", "dosya_no", $safety_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/personel/$folder_name/main";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/personel/$folder_name/main";
        }

        $file_path = "$path/$fileName->img_url";

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

    public function refresh_file_list($id, $from)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = $from;


        $viewData->item_files = $this->Workman_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id, $from)
    {

        $fileName = $this->Workman_file_model->get(
            array(
                "id" => $id
            )
        );

        $workman_id = get_from_id("workman_files", "workman_id", $id);
        $name = get_from_id("workman", "name", $workman_id);
        $surname = get_from_id("workman", "surname", $workman_id);
        $folder_name = convertToSEO($name . "-" . $surname);
        $site_id = get_from_id("workman", "site_id", $workman_id);
        $contract_id = get_from_id("site", "contract_id", $site_id);
        $safety_id = get_from_id("workman", "safety_id", $workman_id);
        $safety_code = get_from_id("safety", "dosya_no", $safety_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/personel/$folder_name/main";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/personel/$folder_name/main";
        }

        $delete = $this->Workman_file_model->delete(
            array(
                "id" => $id
            )
        );

        if ($delete) {

            $path = "$path/$fileName->img_url";

            unlink($path);

            redirect(base_url("$this->Module_Name/$from/$workman_id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$workman_id"));

        }

    }

    public function fileDelete_all($id, $from)
    {

        $workman_id = $id;
        $name = get_from_id("workman", "name", $workman_id);
        $surname = get_from_id("workman", "surname", $workman_id);
        $folder_name = convertToSEO($name . "-" . $surname);
        $site_id = get_from_id("workman", "site_id", $workman_id);
        $contract_id = get_from_id("site", "contract_id", $site_id);
        $safety_id = get_from_id("workman", "safety_id", $workman_id);
        $safety_code = get_from_id("safety", "dosya_no", $safety_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/personel/$folder_name/main";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/personel/$folder_name/main";
        }


        $delete = $this->Workman_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$path");

            foreach ($dir_files as $dir_file) {
                unlink("$path/$dir_file");
            }

            redirect(base_url("$this->Module_Name/$from/$id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$id"));

        }

    }


    public function isActiveSetter($id)
    {

        if ($id) {

            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->Workman_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "isActive" => $isActive
                )
            );
        }
    }
}
