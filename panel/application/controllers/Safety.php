<?php

class Safety extends CI_Controller
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

               if (!get_active_user()) {
            redirect(base_url("login"));
        }
 $this->Theme_mode = get_active_user()->mode;        $this->moduleFolder = "safety_module";
        $this->viewFolder = "Safety_v";

        $this->load->model("Safety_model");
        $this->load->model("Safety_file_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");
        $this->load->model("Company_model");
        $this->load->model("Vehicle_model");
        $this->load->model("Report_model");
        $this->load->model("Contract_model");
        $this->load->model("Safetystock_model");
        $this->load->model("Sitewallet_model");
        $this->load->model("Workman_model");
        $this->load->model("Site_model");
        $this->load->model("Extime_model");
        $this->load->model("Score_model");

        $this->Upload_Folder = "uploads";
        $this->Module_Name = "Safety";
        $this->Module_Title = "İş Yeri Yönetimi";
        $this->Module_File_Dir = "safety";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "contract";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir/";

        $this->Module_File_Dir = "safety";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        $this->Dependet_id_key = "safety_id";
        $this->Module_Parent_Name = "contract";

        //Folder Structure

        $this->moduleFolder = "safety_module";
        $this->viewFolder = "safety_v";
        $this->Module_Title = "İş Yeri";
        $this->Module_Main_Dir = "safety_v";
        $this->Module_File_Dir = "main";
        $this->Display_route = "file_form";
        $this->Display_Folder = "display";
        $this->Add_Folder = "add";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        $this->File_List = "file_list_v";
        $this->List_Folder = "list";
        $this->Dependet_id_key = "safety_id";
        $this->Common_Files = "common";

        $this->Select_Folder = "select";
        $this->Update_Folder = "update";
        $this->File_List = "file_list_v";
    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Safety_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "durumu" => 1
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
        $items = $this->Safety_model->get_all(array());
        $active_sites = $this->Site_model->get_all(array());

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $viewData->active_sites = $active_sites;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($sid = null)
    {
        if ($sid == null) {
            $sid = $this->input->post('site_id');
        }

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Safety_model->get_all(array());
        $site = $this->Site_model->get(array("id" => $sid));
        $users = $this->User_model->get_all(array());
        $vehicles = $this->Vehicle_model->get_all(array());
        $not_employers = $this->Company_model->get_all(array(
            "employer !=" =>1
        ));


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->sid = $sid;
        $viewData->users = $users;
        $viewData->vehicles = $vehicles;
        $viewData->site = $site;
        $viewData->not_employers = $not_employers;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id, $active_tab = null)
    {
        if ($active_tab == null) {
            $active_tab = 1;
        }

        $tab_index = array(
            'Genel Bilgiler',
            'Günlük Puantaj',
            'İSG Depo',
            'Kaza İşlemleri',
            'Eğitimler',
            'Saha Gözlem',
            'Personel');

        $contract_id = get_from_any("safety", "contract_id", "id", "$id");
        $viewData = new stdClass();
        $reports = $this->Report_model->get_all(array(
            "site_id" => $id
        ));
        $safety_stocks = $this->Safetystock_model->get_all(array(
            'safety_id' => $id,
        ));
        $site_id = get_from_any("safety", "site_id", "id", "$id");
        $scores = $this->Score_model->get_all(array(
            'safety_id' => $id,
        ));
        $workers = $this->Workman_model->get_all(array(
            'safety_id' => $id,
            'isActive' => 1
        ));
        $passiveworkers = $this->Workman_model->get_all(array(
            'safety_id' => $id,
            'isActive'=> 0
        ));
        $site = $this->Site_model->get(array(
            "id" => $site_id
        ));
        $settings = $this->Settings_model->get();


        if (isset($contract_id)) {
            $pid = get_from_any("safety", "proje_id", "id", "$id");
            $contract = $this->Contract_model->get(array(
                    "id" => $contract_id
                )
            );
            $project = $this->Project_model->get(array(
                    "id" => $id
                )
            );
            $extimes = $this->Extime_model->get_all(array(
                'contract_id' =>$contract_id

            ));
        }

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        if (isset($contract_id)) {
            $viewData->contract = $contract;
            $viewData->project = $project;
            $viewData->extimes = $extimes;
        }

        $viewData->viewFolder = $this->viewFolder;

        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->reports = $reports;
        $viewData->safety_stocks = $safety_stocks;
        $viewData->active_tab = $active_tab;
        $viewData->workers = $workers;
        $viewData->passiveworkers = $passiveworkers;
        $viewData->site = $site;
        $viewData->tab_index = $tab_index;
        $viewData->settings = $settings;
        $viewData->scores = $scores;


        $viewData->item = $this->Safety_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Safety_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($id, $from = null)
    {

        $file_name_len = file_name_digits();
        $file_name = "ISG-" . $this->input->post('dosya_no');


        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "is_unique[safety.dosya_no]|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("acilis_tarihi", "İş Yeri Açılış Tarihi", "required|trim");
        $this->form_validation->set_rules("isg_personeller[]", "İSG Uzamanı", "required|trim");
        $this->form_validation->set_rules("sicil_no", "İş Yeri Sicil No", "numeric|is_unique[safety.sicil_no]|exact_length[26]|required|trim");
        $this->form_validation->set_rules("nace_kodu", "NACE Kodu", "numeric|exact_length[6]|required|trim");
        $this->form_validation->set_rules("danger_class", "Tehlike Sınıfı", "numeric|required|trim");
        $this->form_validation->set_rules("osgb", "OSGB Firması", "required|trim");

        $this->form_validation->set_message(
            array(
                "is_unique" => "<b>{field}</b> Sicile ait başka bir işyeri mevcut",
                "numeric" => "<b>{field}</b> Numerik olması gerekir",
                "exact_length" => "<b>{field}</b> alanı <b>{param}</b> karakterden oluşmalıdır",
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "duplicate_name_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $contract_id = get_from_any("site", "contract_id", "id", "$id");
            $site_code = get_from_any("site", "dosya_no", "id", "$id");

            if ($contract_id == 0) {
                $contract_id = $this->input->post('contract_id');
                $project_id = get_from_id("site", "proje_id", $id);
                $project_code = project_code($project_id);
                $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$file_name/main";
            } else {
                $project_id = project_id_cont($contract_id);
                $contract_code = get_from_id("contract", "dosya_no", $contract_id);
                $project_code = project_code($project_id);
                $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$file_name/main";
            }

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }


            if ($this->input->post("acilis_tarihi")) {
                $acilis_tarihi = dateFormat('Y-m-d', $this->input->post("acilis_tarihi"));
            } else {
                $acilis_tarihi = null;
            }

            $isg_personeller = $this->input->post('isg_personeller');

            if (!empty($isg_personeller)) {
                $isg_personeller = implode(",", array_unique($isg_personeller));
            } else {
                $isg_personeller = null;
            }

            $insert = $this->Safety_model->add(
                array(
                    "site_id" => $id,
                    "contract_id" => $contract_id,
                    "proje_id" => $project_id,
                    "dosya_no" => $file_name,
                    "isg_personeller" => $isg_personeller,
                    "acilis_tarihi" => $acilis_tarihi,
                    "sicil_no" => $this->input->post('sicil_no'),
                    "nace_kodu" => $this->input->post('nace_kodu'),
                    "danger_class" => $this->input->post('danger_class'),
                    "osgb" => $this->input->post('osgb'),
                    "aciklama" => $this->input->post("aciklama"),
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
            $items = $this->Safety_model->get_all(array());
            $site = $this->Site_model->get(array("id" => $id));
            $users = $this->User_model->get_all(array());
            $vehicles = $this->Vehicle_model->get_all(array());
            $not_employers = $this->Company_model->get_all(array(
            "employer !=" =>1
        ));


            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->items = $items;
            $viewData->sid = $id;
            $viewData->users = $users;
            $viewData->form_error = true;
            $viewData->vehicles = $vehicles;
            $viewData->site = $site;
            $viewData->not_employers = $not_employers;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function update_form($id)
    {

        $viewData = new stdClass();

        $pid = get_from_any("safety", "proje_id", "id", "$id");

        $active_conn_contracts = $this->Contract_model->get_all(array(
            'durumu' => '1',
            'subcont' => null,
            'proje_id' => $pid

        ));
        $active_subcontracts = $this->Contract_model->get_all(array(
            'durumu' => 1,
            'subcont' => 1,
            'proje_id' => $pid
        ));
        $users = $this->User_model->get_all(array());
        $vehicles = $this->Vehicle_model->get_all(array());


        $pid = get_from_any("safety", "proje_id", "id", "$id");

        $project = $this->Project_model->get(array(
            "id" => $pid
        ));

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->project = $project;
        $viewData->active_conn_contracts = $active_conn_contracts;
        $viewData->active_subcontracts = $active_subcontracts;
        $viewData->users = $users;
        $viewData->vehicles = $vehicles;

        $viewData->item = $this->Safety_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Safety_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function update($id)
    {
        echo $contract_id = get_from_any("safety", "contract_id", "id", "$id");

        if ($contract_id > 0) {
            echo $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarihi"));
            echo $sozlesme_tarihi = dateFormat('d-m-Y', get_from_any("contract", "sozlesme_tarih", "id", "$contract_id"));
        }

        $this->load->library("form_validation");
        if ($contract_id > 0) {
            $this->form_validation->set_rules("teslim_tarihi", "Teslim Tarihi", "required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Kabul Notları", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",

            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

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

            $update = $this->Safety_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "santiye_ad" => $this->input->post("santiye_ad"),
                    "santiye_sefi" => $this->input->post("santiye_sefi"),
                    "teknik_personel" => $data_personel,
                    "araclar" => $data_araclar,
                    "teslim_tarihi" => $teslim_tarihi,
                    "aciklama" => $this->input->post("aciklama"),
                    "sub_contracts" => $data_sub_contracts,
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


            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->form_error = true;
            $viewData->item = $this->Safety_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Safety_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                ),
            );


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

        // Başarılı ise
        // Kayit işlemi baslar
        // Başarısız ise
        // Hata ekranda gösterilir...

    }

    public function active_group($id, $to = null)
    {

        if (empty($this->input->post("active_group"))) {
            $active_group = null;
        } else {
            $active_group = json_encode($this->input->post("active_group"));
        }

        $update = $this->Safety_model->update(
            array(
                "id" => $id
            ),
            array(
                "active_group" => $active_group,
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
        redirect(base_url("$this->Module_Name/$this->Display_route/$id/$to"));
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function active_machine($id, $to = null)
    {
        if (empty($this->input->post("active_machine"))) {
            $active_machine = null;
        } else {
            $active_machine = json_encode($this->input->post("active_machine"));
        }

        $update = $this->Safety_model->update(
            array(
                "id" => $id
            ),
            array(
                "active_machine" => $active_machine,
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
        redirect(base_url("$this->Module_Name/$this->Display_route/$id/$to"));
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function delete($id)
    {

        $contract_id = get_from_id("safety", "contract_id", $id);

        if ($contract_id == 0) {
            $project_id = get_from_id("safety", "proje_id", $id);
            $project_code = project_code($project_id);
            $safety_code = get_from_id("safety", "dosya_no", $id);
            $path = "$this->File_Dir_Prefix/$project_code/safety/$safety_code";
        } else {
            $project_id = get_from_id("safety", "proje_id", $id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $safety_code = get_from_id("safety", "dosya_no", $id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/safety/$safety_code";
        }


        $sil = deleteDirectory($path);

        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        $delete1 = $this->Safety_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $delete2 = $this->Safety_model->delete(
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

        if ($contract_id == 0) {
            redirect(base_url("project/file_form/$project_id"));
        } else {
            redirect(base_url("contract/file_form/$contract_id"));
        }
    }

    public function file_upload($id)
    {

        $contract_id = get_from_id("safety", "contract_id", $id);
        $site_id = get_from_id("safety", "site_id", $id);
        $site_code = get_from_id("site", "dosya_no", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("safety", "proje_id", $id);
            $project_code = project_code($project_id);
            $safety_code = get_from_id("safety", "dosya_no", $id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/safety/$safety_code/main";
        } else {
            $project_id = get_from_id("safety", "proje_id", $id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $safety_code = get_from_id("safety", "dosya_no", $id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/safety/$safety_code/main";
        }

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

            $this->Safety_file_model->add(
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

    public function file_download($id)
    {
        $fileName = $this->Safety_file_model->get(
            array(
                "id" => $id
            )
        );

        $safety_id = get_from_id("safety_files", "safety_id", $id);
        $contract_id = get_from_id("safety", "contract_id", $safety_id);
        $site_id = get_from_id("safety", "site_id", $safety_id);
        $site_code = get_from_id("site", "dosya_no", $site_id);


        if ($contract_id == 0) {
            $project_id = get_from_id("safety", "proje_id", $safety_id);
            $project_code = project_code($project_id);
            $safety_code = get_from_id("safety", "dosya_no", $safety_id);
            $file_path = "$this->File_Dir_Prefix/$project_code/site/$site_code/safety/$safety_code/main/$fileName->img_url";
        } else {
            $project_id = get_from_id("safety", "proje_id", $safety_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $safety_code = get_from_id("safety", "dosya_no", $safety_id);
            $file_path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/safety/$safety_code/main/$fileName->img_url";
        }

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


        $viewData->item_files = $this->Safety_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id, $from)
    {

        $fileName = $this->Safety_file_model->get(
            array(
                "id" => $id
            )
        );

        $safety_id = get_from_id("safety_files", "safety_id", $id);
        $contract_id = get_from_id("safety", "contract_id", $safety_id);
        $site_id = get_from_id("safety", "site_id", $safety_id);
        $site_code = get_from_id("site", "dosya_no", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("safety", "proje_id", $safety_id);
            $project_code = project_code($project_id);
            $safety_code = get_from_id("safety", "dosya_no", $safety_id);
            $file_path = "$this->File_Dir_Prefix/$project_code/site/$site_code/safety/$safety_code/main/$fileName->img_url";

        } else {
            $project_id = get_from_id("safety", "proje_id", $safety_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $safety_code = get_from_id("safety", "dosya_no", $safety_id);
            $file_path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/safety/$safety_code/main/$fileName->img_url";

        }


        $delete = $this->Safety_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            unlink($fileName);

            redirect(base_url("$this->Module_Name/$from/$safety_id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$safety_id"));
        }
    }

    public function fileDelete_all($id, $from)
    {

        $contract_id = get_from_id("safety", "contract_id", $id);
        $site_id = get_from_id("safety", "site_id", $id);
        $site_code = get_from_id("site", "dosya_no", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("safety", "proje_id", $id);
            $project_code = project_code($project_id);
            $safety_code = get_from_id("safety", "dosya_no", $id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/safety/$safety_code/main";
        } else {
            $project_id = get_from_id("safety", "proje_id", $id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $safety_code = get_from_id("safety", "dosya_no", $id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/safety/$safety_code/main";
        }
        $delete = $this->Safety_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map($path);

            foreach ($dir_files as $dir_file) {
                unlink("$path/$dir_file");
            }

            redirect(base_url("$this->Module_Name/$from/$id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$id"));

        }

    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "ISG-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
