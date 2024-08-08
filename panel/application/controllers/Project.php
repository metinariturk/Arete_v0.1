<?php

class Project extends CI_Controller
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

        $uploader = APPPATH . 'libraries/FileUploader.php';
        include($uploader);

        $this->load->model("Settings_model");
        $this->load->model("Project_model");
        $this->load->model("Payment_model");
        $this->load->model("Project_file_model");
        $this->load->model("Report_model");
        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Contract_model");
        $this->load->model("User_model");
        $this->load->model("Order_model");

        $this->load->model("Site_model");
        $this->load->model("Favorite_model");

        $this->viewFolder = "project_v";
        $this->Module_Name = "project";
        $this->Module_Title = "Proje";
        $this->Module_Main_Dir = "project_v";
        $this->Module_File_Dir = "main";
        $this->Display_Folder = "display";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        
        $this->List_Folder = "list";
        $this->Dependet_id_key = "project_id";
        $this->Common_Files = "common";

        $this->Settings = get_settings();

        $this->display_route = "file_form";
        $this->update_route = "update_form";
        $this->create_route = "new_form";

    }

    public function index()
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        $items = $this->Project_model->get_all(array());
        $settings = $this->Settings_model->get();
        $users = $this->User_model->get_all();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->users = $users;
        $viewData->settings = $settings;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $item = $this->Project_model->get(
            array(
                "id" => $id
            )
        );

        $upload_function = base_url("$this->Module_Name/file_upload/$item->id");
        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$item->project_code/main/";


        !is_dir($path) && mkdir($path, 0777, TRUE);

        $fav = $this->Favorite_model->get(array(
            "user_id" => active_user_id(),
            "module" => "project",
            "view" => "file_form",
            "module_id" => $id,
        ));

        $offers = $this->Contract_model->get_all(array(
                "proje_id" => $id, "offer" => 1
            )
        );

        $sites = $this->Site_model->get_all(array('proje_id' => $id));
        $contracts = $this->Contract_model->get_all(
            array(
                "proje_id" => $id,
            )
        );

        $viewData = new stdClass();
        $settings = $this->Settings_model->get();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->settings = $settings;
        $viewData->offers = $offers;
        $viewData->upload_function = $upload_function;
        $viewData->path = $path;
        $viewData->sites = $sites;
        $viewData->contracts = $contracts;
        $viewData->fav = $fav;
        $viewData->display_route = $this->display_route;
        $viewData->item = $item;
        $viewData->page_description = $item->project_name;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        $alert = null;
        $this->session->set_flashdata("alert", $alert);

    }

    public function save()
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $file_name_len = file_name_digits();

        $project_code = "PRJ-" . $this->input->post("project_code");

        $this->load->library("form_validation");

        $this->form_validation->set_rules("project_code", "Proje Kodu", "exact_length[$file_name_len]|numeric|required|trim|callback_duplicate_code_check");
        $this->form_validation->set_rules("project_name", "Proje Adı", "required|trim|is_unique[projects.project_name]");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> boş bırakılamaz",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
                "numeric" => "<b>{field}</b> alanı bir sayı olmalıdır",
                "is_unique" => "<b>{field}</b> 'na sahip başka bir proje mevcut",
                "duplicate_code_check" => "<b>{field}</b> - '$project_code' daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
            )
        );


        $validate = $this->form_validation->run();


        if ($validate) {

            $project_code = "PRJ-" . convertToSEO($this->input->post("project_code"));
            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code";

            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
                mkdir("$path/$this->Module_File_Dir", 0777, TRUE);
            }


            $insert = $this->Project_model->add(
                array(
                    "project_code" => $project_code,
                    "project_name" => yazim_duzen($this->input->post("project_name")),
                    "notes" => $this->input->post("notes"),
                    "createdAt" => date("Y-m-d H:i:s")
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "file_order" => $project_code,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id()
                )
            );


            // TODO Alert sistemi eklenecek...
            if ($insert) {

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt başarılı bir şekilde eklendi",
                    "type" => "success"
                );
                $this->session->set_flashdata("alert", $alert);


            } else {


                $viewData = new stdClass();

                $items = $this->Project_model->get_all();
                $settings = $this->Settings_model->get();

                /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
                $viewData->viewModule = $this->moduleFolder;
                $viewData->viewFolder = $this->viewFolder;
                $viewData->subViewFolder = "add";
                $viewData->items = $items;
                $viewData->settings = $settings;

                $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
                $this->session->set_flashdata("alert", $alert);

            }

            // İşlemin Sonucunu Session'a yazma işlemi...
            redirect(base_url("$this->Module_Name/file_form/$record_id"));

        } else {


            $viewData = new stdClass();

            $items = $this->Project_model->get_all();
            $settings = $this->Settings_model->get();
            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "list";
            $viewData->form_error = true;
            $viewData->items = $items;
            $viewData->settings = $settings;
            $viewData->users = $users;


            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form Kontrol Hatalarını İnceleyiniz",
                "type" => "danger"
            );
            // İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);
        }

    }

    public function update($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project = $this->Project_model->get(array("id" => $id));
        $updated_name = $this->input->post("project_name");

        $this->load->library("form_validation");

        if ($updated_name != $project->project_name) {
            $this->form_validation->set_rules("project_name", "Proje Adı", "required|trim|is_unique[projects.project_name]");
        } else {
            $this->form_validation->set_rules("project_name", "Proje Adı", "required|trim");
        }

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> boş bırakılamaz",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
                "numeric" => "<b>{field}</b> alanı bir sayı olmalıdır",
                "is_unique" => "<b>{field}</b> 'na sahip başka bir proje mevcut",

            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $update = $this->Project_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "project_name" => $this->input->post("project_name"),
                    "notes" => $this->input->post("notes"),
                )
            );

            $file_order_id = get_from_any_and("file_order", "connected_module_id", $id, "module", $this->Module_Name);

            $update2 = $this->Order_model->update(
                array(
                    "id" => $file_order_id
                ),
                array(
                    "updatedAt" => date("Y-m-d H:i:s"),
                    "updatedBy" => active_user_id(),
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

            redirect(base_url("$this->Module_Name/file_form/$id"));

        } else {

            if (!isAdmin()) {
                redirect(base_url("error"));
            }

            $viewData = new stdClass();

            $fav = $this->Favorite_model->get(array(
                "user_id" => active_user_id(),
                "module" => "project",
                "view" => "file_form",
                "module_id" => $id,
            ));

            $offers = $this->Contract_model->get_all(array(
                    "proje_id" => $id, "offer" => 1
                )
            );

            $sites = $this->Site_model->get_all(array('proje_id' => $id));

            $contracts = $this->Contract_model->get_all(
                array(
                    "proje_id" => $id,
                )
            );

            $settings = $this->Settings_model->get();


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Display_Folder";
            $viewData->settings = $settings;
            $viewData->offers = $offers;
            $viewData->sites = $sites;
            $viewData->contracts = $contracts;
            $viewData->fav = $fav;
            $viewData->form_error = true;

            $viewData->display_route = $this->display_route;
            $viewData->item = $this->Project_model->get(
                array(
                    "id" => $id
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

            $alert = null;

            $this->session->set_flashdata("alert", $alert);
        }
    }

    public function delete($id)
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project = $this->Project_model->get(array("id"=> $id));

        $project_name = project_name($id);
        $number_of_contracts = count(get_from_any_array_select_ci("id", "contract", "proje_id", $id));
        $number_of_sites = count(get_from_any_array_select_ci("id", "site", "proje_id", $id));
        $control = $number_of_contracts + $number_of_aucitons + $number_of_sites;


        if ($control > 0) {

            $alert = array(
                "title" => "Bu Projeye Bağlı Sözleşme/Teklif/Şantiye Mevcut",
                "text" => "$project_name silmek için alt birimleri silmeniz gerekmektedir.",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/file_form/$id"));
        } else {

            $this->Favorite_model->delete(
                array(
                    "module" => "project",
                    "module_id" => $id
                )
            );


            $folder_name = $project->project_code;
            $project_name = $project->project_name;
            $path = "$this->Upload_Folder/$this->viewFolder/$folder_name/";

            if (file_exists($path)) {
                $sil = deleteDirectory($path);

                $alert = array(
                    "title" => "Silinen Kayıt",
                    "text" => "$project_name",
                    "type" => "danger"
                );
                $this->session->set_flashdata("alert", $alert);
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Dosya Zaten Silinmiş Görünüyor, İzinsiz Erişim Kontrolü Yapılmalı",
                    "type" => "danger"
                );
                $this->session->set_flashdata("alert", $alert);
            }
            $file_order_id = get_from_any_and('file_order', 'connected_module_id', $id, 'module', 'Project');

            $update_file_order = $this->Order_model->update(
                array(
                    "id" => $file_order_id
                ),
                array(
                    "deletedAt" => date("Y-m-d H:i:s"),
                    "deletedBy" => active_user_id(),

                )
            );
            $delete1 = $this->Project_file_model->delete(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );

            $delete = $this->Project_model->delete(array("id" => $id));

            if (!$sil) {

                $alert = array(
                    "title" => "Dosya Silinme İşlemi Başarısız",
                    "text" => "Proje Dosyaları Silinmesi Sırasında Bir Problem Oluştu",
                    "type" => "danger"
                );

                $this->session->set_flashdata("alert", $alert);
                redirect(base_url("$this->Module_Name"));
            }

            // TODO Alert Sistemi Eklenecek...
            if ($delete) {

                $alert = array(
                    "title" => "Proje Veri Tabanından Silindi",
                    "text" => "$project_name isimli proje tüm alt süreçleriyle birlikte kalıcı olarak silindi",
                    "type" => "danger"
                );
                $this->session->set_flashdata("alert", $alert);

            } else {

                $alert = array(
                    "title" => "Proje Veri Tabanından Silinemedi",
                    "text" => "Proje silinmesi sırasında bir problem oluştu",
                    "type" => "danger"
                );
                $this->session->set_flashdata("alert", $alert);
            }
            redirect(base_url("$this->Module_Name"));
        }
    }

    public function file_upload($id)
    {

        if (!isAdmin()) {
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }


        $project = $this->Project_model->get(array("id" => $id));
        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/main/";

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
        $fileName = $this->input->post('fileName');

        $project = $this->Project_model->get(array("id" => $id));

        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/main/";

        unlink("$path/$fileName");
    }

    public
    function download_all($project_id)
    {
        $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$project_id"));
        if (!isAdmin()) {
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }

        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $project_code = project_code($project_id);
        $project_name = get_from_id("projects", "project_name", $project_id);

        $path = "uploads/project_v/$project_code/main";
        echo $path;

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $project_name;
        $this->zip->download("$zip_name");

    }

    public
    function duplicate_code_check($str)
    {

        $viewData = new stdClass();

        $settings = $this->Settings_model->get();

        $viewData->settings = $settings;

        $file_name = "PRJ-" . $str;
        $var = count_data("projects", "project_code", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public
    function duplicate_name_check($str)
    {
        $var = count_data("projects", "project_name", $str);

        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public
    function favorite($id)
    {
        $fav_id = get_from_any_and_and("favorite", "module", "project", "user_id", active_user_id(), "module_id", "$id");
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
                    "module" => "project",
                    "view" => "file_form",
                    "module_id" => $id,
                    "user_id" => active_user_id(),
                    "title" => project_code($id) . " - " . project_name($id),
                )
            );
            echo "favoriye eklendi";
        }
    }
}
