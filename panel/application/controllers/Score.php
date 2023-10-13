<?php

class Score extends CI_Controller
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
        $this->viewFolder = "score_v";

        $this->load->model("Score_model");
        $this->load->model("Score_file_model");
        $this->load->model("Workgroup_model");
        $this->load->model("Settings_model");
        $this->load->model("Site_model");
        $this->load->model("Order_model");
        $this->load->model("Education_model");
        $this->load->model("Workman_model");
        $this->load->model("Safety_model");
        $this->load->model("Site_model");

        $this->Module_Name = "score";
        $this->Module_Title = "Puantaj";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "score_id";
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
        $items = $this->Score_model->get_all(array());
        $main_categories = $this->Workgroup_model->get_all(array(
            'main_category' => 1
        ));
        $activeworkers = $this->Score_model->get_all_active(array());
        $passiveworkers = $this->Score_model->get_all_passive(array());
        $allworkers = $this->Score_model->get_all(array());

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
        $main_categories = $this->Score_model->get_main_group(array());
        $site = $this->Site_model->get(array("id" => $id));

        

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Select_Folder";
        $viewData->main_categories = $main_categories;
        $viewData->site = $site;
        


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        

        $score = $this->Score_model->get(
            array(
                "id" => $id
            )
        );

        $safety = $this->Safety_model->get(
            array(
                "id" => $score->safety_id
            )
        );

        $site = $this->Site_model->get(array(
            'id' => $safety->site_id
        ));


        $workers = $this->Workman_model->get_all(array(
            'safety_id' => $score->safety_id,
            'isActive' => 1
        ));


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->site = $site;
        $viewData->safety = $safety;
        $viewData->workers = $workers;

        $viewData->item = $this->Score_model->get(
            array(
                "id" => $id
            )
        );

        $date = get_from_id("score", "month", "$id");

        $ay = date_parse_from_format('m-Y', $date)['month'];
        $yil = date_parse_from_format('m-Y', $date)['year'];
        $gun_sayisi = cal_days_in_month(CAL_GREGORIAN, $ay, $yil);
        $hangi_gundeyiz = date_parse_from_format('Y-m-d', date("Y/m/d"))['day'];


        $viewData->hangi_gundeyiz = $hangi_gundeyiz;
        $viewData->gun_sayisi = $gun_sayisi;
        $viewData->ay = $ay;


        $viewData->item_files = $this->Score_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($id, $date)
    {
        $safety_id = $id;

        $ay = date_parse_from_format('m-Y', $date)['month'];
        $yil = date_parse_from_format('m-Y', $date)['year'];
        $gun_sayisi = cal_days_in_month(CAL_GREGORIAN, $ay, $yil);
        $hangi_gundeyiz = date_parse_from_format('Y-m-d', date("Y/m/d"))['day'];


        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $workers = $this->Workman_model->get_all(array(
            'safety_id' => $safety_id,
            'isActive' => 1
        ));

        $safety = $this->Safety_model->get(array(
            'id' => "$safety_id"
        ));

        $site = $this->Site_model->get(array(
            'id' => $safety->site_id
        ));


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = $this->Add_Folder;
        $viewData->date = $date;
        $viewData->workers = $workers;
        $viewData->safety = $safety;
        $viewData->site = $site;
        $viewData->gun_sayisi = $gun_sayisi;
        $viewData->hangi_gundeyiz = $hangi_gundeyiz;
        $viewData->ay = $ay;
        $viewData->yil = $yil;


        
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($id, $date)
    {
        if ($date == null) {
            date_default_timezone_set('Europe/Istanbul');
            $date = date('m-Y', time());
        }

        $site_id = get_from_id("safety", "site_id", "$id");
        $site_code = get_from_id("site", "site_code", "$id");
        $safety_code = get_from_id("safety", "dosya_no", "$id");
        $contract_id = get_from_id("site", "contract_id", "$site_id");


        if (!isset($contract_id)) {
            $project_id = get_from_any("safety", "proje_id", "id", "$id");
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/puantaj/$date";
        } else {

            $project_id = project_id_cont($contract_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/puantaj/$date";
        }


        if (!is_dir($path)) {
            mkdir("$path", 0777, TRUE);
            echo "oluştu";
        } else {
            echo "aynı isimde dosya mevcut";
        }

        $scores = $this->input->post("score[]");

        $insert = $this->Score_model->add(
            array(
                "safety_id" => $id,
                "month" => $date,
                "score" => json_encode($scores),
                "createdAt" => date("Y-m-d"),
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

    }

    public function update_form($id, $date = null)
    {

        if ($date == null) {
            date_default_timezone_set('Europe/Istanbul');
            $date = date('m-Y', time());
            $isset_score = get_from_any_and("score", "safety_id", $id, "month", $date);
            if (isset($isset_score)) {
                redirect(base_url("$this->Module_Name/update_form/$isset_score/$date"));
            } else {
                redirect(base_url("$this->Module_Name/new_form/$id/$date"));
            }
        }



        $ay = date_parse_from_format('m-Y', $date)['month'];
        $yil = date_parse_from_format('m-Y', $date)['year'];
        $gun_sayisi = cal_days_in_month(CAL_GREGORIAN, $ay, $yil);
        $hangi_gundeyiz = date_parse_from_format('Y-m-d', date("Y/m/d"))['day'];

        $score = $this->Score_model->get(
            array(
                "id" => $id
            )
        );

        $safety = $this->Safety_model->get(
            array(
                "id" => $score->safety_id
            )
        );

        $site = $this->Site_model->get(array(
            'id' => $safety->site_id
        ));



        $viewData = new stdClass();
        $workers = $this->Workman_model->get_all(array(
            'safety_id' => $safety->id,
            'isActive' => 1
        ));

        
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = $this->Update_Folder;
        $viewData->id = $id;
        $viewData->safety = $safety;
        $viewData->site = $site;
        $viewData->date = $date;
        $viewData->score = $score;
        $viewData->workers = $workers;
        $viewData->gun_sayisi = $gun_sayisi;
        $viewData->hangi_gundeyiz = $hangi_gundeyiz;
        $viewData->ay = $ay;
        $viewData->yil = $yil;

        $viewData->item = $this->Score_model->get(
            array(
                "id" => $id
            )
        );


        
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function update($id)
    {

        $update = $this->Score_model->update(
            array(
                "id" => $id
            ),
            array(
                "score" => json_encode($this->input->post("score")),
                "updatedAt" => date("Y-m-d"),
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

    }

    public function delete($id)
    {
        $a = get_from_any_array("workman", "parent", "$id");
        foreach ($a as $b) {
            $this->Score_model->update(
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

        $update = $this->Score_model->update(
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

            $this->Score_file_model->add(
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
        $fileName = $this->Score_file_model->get(
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


        $viewData->item_files = $this->Score_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id, $from)
    {

        $fileName = $this->Score_file_model->get(
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

        $delete = $this->Score_file_model->delete(
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


        $delete = $this->Score_file_model->delete(
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

}
