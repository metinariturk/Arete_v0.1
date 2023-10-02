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

        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        $this->load->model("Settings_model");
        $this->load->model("Project_model");
        $this->load->model("Project_file_model");
        $this->load->model("Contract_model");
        $this->load->model("Extime_model");
        $this->load->model("Advance_model");
        $this->load->model("Bond_model");
        $this->load->model("Costinc_model");
        $this->load->model("Drawings_model");
        $this->load->model("User_model");
        $this->load->model("Order_model");
        $this->load->model("Auction_model");
        $this->load->model("Site_model");
        $this->load->model("Favorite_model");

        $this->moduleFolder = "contract_module";
        $this->viewFolder = "project_v";
        $this->Module_Name = "project";
        $this->Module_Title = "Proje";
        $this->Module_Main_Dir = "project_v";
        $this->Module_File_Dir = "main";
        $this->Display_Folder = "display";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        $this->File_List = "file_list_v";
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

        $viewData = new stdClass();

        $actives = $this->Project_model->get_all(array(
            "durumu" => 1
        ));

        $passives = $this->Project_model->get_all(array(
            "durumu" => !1
        ));


        $all_projects = $this->Project_model->get_all();

        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->actives = $actives;
        $viewData->passives = $passives;
        $viewData->all_projects = $all_projects;
        $viewData->settings = $settings;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {

        $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$id"));
        if (!isAdmin()) {
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }


        $viewData = new stdClass();
        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));

        $fav = $this->Favorite_model->get(array(
            "user_id" => active_user_id(),
            "module" => "project",
            "view" => "file_form",
            "module_id" => $id,
        ));

        $prep_auctions = $this->Auction_model->get_all(array(
                "proje_id" => $id
            )
        );
        $sites = $this->Site_model->get_all(array('proje_id' => $id));
        $contracts = $this->Contract_model->get_all(
            array(
                'proje_id' => $id,
                'subcont' => null
            )
        );
        $subcontracts = $this->Contract_model->get_all(array(
            'durumu' => 1,
            'subcont' => 1,
            'proje_id' => $id
        ));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->users = $users;
        $viewData->prep_auctions = $prep_auctions;
        $viewData->sites = $sites;
        $viewData->contracts = $contracts;
        $viewData->subcontracts = $subcontracts;
        $viewData->fav = $fav;

        $viewData->display_route = $this->display_route;
        $viewData->item = $this->Project_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Project_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);


        $alert = null;
        $this->session->set_flashdata("alert", $alert);

    }

    public function new_form()
    {

        $viewData = new stdClass();

        $items = $this->Project_model->get_all();
        $settings = $this->Settings_model->get();
        $users = $this->User_model->get_all();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->items = $items;
        $viewData->settings = $settings;
        $viewData->users = $users;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {

        if (!isAdmin()) {
            $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$id"));
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }

        $this->session->set_flashdata("alert", null);
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $item = $this->Project_model->get(
            array(
                "id" => $id,
            )
        );

        $viewData->item_files = $this->Project_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );

        $settings = $this->Settings_model->get();
        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->users = $users;

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->settings = $settings;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save()
    {

        $file_name_len = file_name_digits();

        $project_code = "PRJ-" . $this->input->post("proje_kodu");

        $this->load->library("form_validation");


        $this->form_validation->set_rules("durumu", "İşin Durumu", "required|trim");
        $this->form_validation->set_rules("department", "Bağlı Olduğu Birim", "required|trim");
        $this->form_validation->set_rules("proje_kodu", "Proje Kodu", "exact_length[$file_name_len]|numeric|required|trim|callback_duplicate_code_check");
        $this->form_validation->set_rules("butce_bedel", "Bütçe Bedel", "trim|numeric");
        $this->form_validation->set_rules("proje_ad", "Proje Adı", "required|trim|is_unique[projects.proje_ad]");

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

            $yetkili = $this->input->post('yetkili_personeller');

            if (!empty($yetkili)) {
                $data_yetkili = implode(",", array_unique($yetkili));
                print_r($data_yetkili);
            } else {
                $data_yetkili = null;
            }

            $project_code = "PRJ-" . convertToSEO($this->input->post("proje_kodu"));
            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code";

            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
                mkdir("$path/$this->Module_File_Dir", 0777, TRUE);
            }


            $insert = $this->Project_model->add(
                array(
                    "durumu" => $this->input->post("durumu"),
                    "proje_kodu" => $project_code,
                    "proje_ad" => yazim_duzen($this->input->post("proje_ad")),
                    "department" => $this->input->post("department"),
                    "butce_bedel" => $this->input->post("butce_bedel"),
                    "butce_para_birimi" => $this->input->post("butce_para_birimi"),
                    "etiketler" => $this->input->post("etiketler"),
                    "yetkili_personeller" => $data_yetkili,
                    "genel_bilgi" => $this->input->post("genel_bilgi"),
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
                    "createdBy" => active_user_id(),
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
            $viewData->subViewFolder = "add";
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
        $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$id"));
        if (!isAdmin()) {
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }
        $current_name = get_from_any("projects", "proje_ad", "id", $id);
        $updated_name = $this->input->post("proje_ad");

        $this->load->library("form_validation");

        $proje_ad = $this->input->post("proje_ad");

        $this->form_validation->set_rules("durumu", "İşin Durumu", "required|trim");
        $this->form_validation->set_rules("department", "Bağlı Olduğu Birim", "required|trim");
        $this->form_validation->set_rules("butce_bedel", "Bütçe Bedel", "trim|numeric");
        if ($proje_ad != $current_name) {
            $this->form_validation->set_rules("proje_ad", "Proje Adı", "required|trim|is_unique[projects.proje_ad]");
        }

        if ($current_name != $updated_name) {
            $this->form_validation->set_rules("proje_ad", "Proje Adı", "required|trim|callback_duplicate_name_check");
        }

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> boş bırakılamaz",
            )
        );

        // Form Validation Calistirilir..
        // TRUE - FALSE
        $validate = $this->form_validation->run();

        if ($validate) {

            $yetkili = $this->input->post('yetkili_personeller');

            if (!empty($yetkili)) {
                $data_yetkili = implode(",", array_unique($yetkili));
            } else {
                $data_yetkili = null;
            }

            if ($this->input->post("duyuru_tarihi")) {
                $duyuru_tarihi = dateFormat('Y-m-d', $this->input->post("duyuru_tarihi"));
            } else {
                $duyuru_tarihi = null;
            }

            $update = $this->Project_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "durumu" => $this->input->post("durumu"),
                    "proje_ad" => $this->input->post("proje_ad"),
                    "ilgi" => $this->input->post("ilgi"),
                    "type" => $this->input->post("type"),
                    "department" => $this->input->post("department"),
                    "butce_bedel" => $this->input->post("butce_bedel"),
                    "butce_para_birimi" => $this->input->post("butce_para_birimi"),
                    "etiketler" => $this->input->post("etiketler"),
                    "yetkili_personeller" => $data_yetkili,
                    "genel_bilgi" => $this->input->post("genel_bilgi"),
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


            $viewData = new stdClass();
            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));


            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Project_model->get(
                array(
                    "id" => $id,
                )
            );

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form Kontrol Hatalarını İnceleyiniz",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->users = $users;
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            $viewData->item = $item;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function delete($id)
    {
        $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$id"));
        if (!isAdmin()) {
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }

        $project_name = project_name($id);
        $number_of_contracts = count(get_from_any_array_select_ci("id", "contract", "proje_id", $id));
        $number_of_aucitons = count(get_from_any_array_select_ci("id", "auction", "proje_id", $id));
        $number_of_sites = count(get_from_any_array_select_ci("id", "site", "proje_id", $id));
        $control = $number_of_contracts + $number_of_aucitons + $number_of_sites;


        if ($control > 0) {

            $alert = array(
                "title" => "Bu Projeye Bağlı Sözleşme/İhale/Şantiye Mevcut",
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


            $folder_name = get_from_any("projects", "proje_kodu", "id", $id);
            $project_name = get_from_any("projects", "proje_ad", "id", $id);
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
        $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$id"));
        if (!isAdmin()) {
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $kod = get_from_id("projects", "proje_kodu", $id);
        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->Upload_Folder/$this->viewFolder/$kod/$this->Module_File_Dir/";
        $config["file_name"] = $file_name;
        $config["max_size"] = '200048';

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $alert = array(
                "title" => "Dosya Yükle",
                "text" => "$file_name Dosyasını Yükleme Başarılı",
                "type" => "success"
            );
            $this->session->set_flashdata("alert", $alert);
            $uploaded_file = $this->upload->data("file_name");

            $this->Project_file_model->add(
                array(
                    "img_url" => $uploaded_file,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                    "$this->Dependet_id_key" => $id,
                    "size" => $size
                )
            );

        } else {
            $alert = array(
                "title" => "Dosya Yükle",
                "text" => "$file_name Dosyasını Yükleme Başarısız, Sistem Yöneticinizle Görüşün",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);
        }
    }

    public function file_download($id)
    {


        $fileName = $this->Project_file_model->get(
            array(
                "id" => $id
            )
        );

        $project_id = get_from_id("projects_files", "$this->Dependet_id_key", $id);
        $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$project_id"));
        if (!isAdmin()) {
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }

        $folder = get_from_id("projects", "proje_kodu", $project_id);

        $file_path = "$this->Upload_Folder/$this->viewFolder/$folder/$this->Module_File_Dir/$fileName->img_url";

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

    public function fileDelete($id)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;


        $fileName = $this->Project_file_model->get(
            array(
                "id" => $id
            )
        );


        $project_id = get_from_id("projects_files", "$this->Dependet_id_key", $id);

        $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$project_id"));
        if (!isAdmin()) {
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }

        $folder = get_from_id("projects", "proje_kodu", $project_id);

        $delete = $this->Project_file_model->delete(
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

            $viewData->item = $this->Project_model->get(
                array(
                    "id" => $project_id
                )
            );

            $viewData->item_files = $this->Project_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $project_id
                )
            );

            $render_html = $this->load->view("{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;


            $path = "$this->Upload_Folder/$this->viewFolder/$folder/$this->Module_File_Dir/$fileName->img_url";

            unlink($path);
        } else {
            $alert = array(
                "title" => "Tümünü Sil",
                "text" => "Dosyayı Başarılı Bir Şekilde Silemediniz",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);
        }

    }

    public function fileDelete_all($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $folder = get_from_id("projects", "proje_kodu", $id);

        $delete = $this->Project_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {
            $alert = array(
                "title" => "Tümünü Sil",
                "text" => "Tüm Dosyaları Başarılı Bir Şekilde Sildiniz",
                "type" => "success"
            );
            $this->session->set_flashdata("alert", $alert);

            $dir_files = directory_map("$this->Upload_Folder/$this->viewFolder/$folder/$this->Module_File_Dir");

            foreach ($dir_files as $dir_file) {
                unlink("$this->Upload_Folder/$this->viewFolder/$folder/$this->Module_File_Dir/$dir_file");
            }

            $viewData->item = $this->Project_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Project_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );

            $render_html = $this->load->view("{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;

        } else {
            $alert = array(
                "title" => "Tümünü Sil",
                "text" => "Tüm Dosyaları Başarılı Bir Şekilde Silemediniz",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);
        }
    }

    public function refresh_file_list($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->item = $this->Project_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Project_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
        echo $render_html;

    }

    public function download_all($project_id)
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
        $project_name = get_from_id("projects", "proje_ad", $project_id);

        $path = "uploads/project_v/$project_code/main";
        echo $path;

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $project_name;
        $this->zip->download("$zip_name");

    }

    public function duplicate_code_check($str)
    {

        $viewData = new stdClass();

        $settings = $this->Settings_model->get();

        $viewData->settings = $settings;

        $file_name = "PRJ-" . $str;
        $var = count_data("projects", "proje_kodu", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function duplicate_name_check($str)
    {
        $var = count_data("projects", "proje_ad", $str);

        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function favorite($id)
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
                    "title" => project_code_name($id),
                )
            );
            echo "favoriye eklendi";
        }
    }
}
