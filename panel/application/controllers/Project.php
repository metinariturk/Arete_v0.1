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

        $this->load->model("Report_model");
        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Contract_model");
        $this->load->model("Company_model");
        $this->load->model("Workman_model");
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

        if (!isAdmin() && !permission_control("project", "read")) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        $items = $this->Project_model->get_all(array());
        $settings = $this->Settings_model->get();
        $users = $this->User_model->get_all();


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

        if (!isAdmin() && !permission_control("project", "read")) {
            redirect(base_url("error"));
        }

        $item = $this->Project_model->get(array("id" => $id));
        $companys = $this->Company_model->get_all(array());
        $main_contracts = $this->Contract_model->get_all(array("proje_id" => $id, "parent" => 0));
        $sites = $this->Site_model->get_all(array("proje_id" => $id));
        $next_contract_name = get_next_file_code("Contract");
        $next_site_name = get_next_file_code("Site");
        $users = $this->User_model->get_all(array());

        $upload_function = base_url("$this->Module_Name/file_upload/$item->id");
        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$item->project_code/main/";


        !is_dir($path) && mkdir($path, 0777, TRUE);

        $fav = $this->Favorite_model->get(array(
            "user_id" => active_user_id(),
            "module" => "project",
            "view" => "file_form",
            "module_id" => $id,
        ));


        $viewData = new stdClass();
        $settings = $this->Settings_model->get();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->settings = $settings;
        $viewData->next_contract_name = $next_contract_name;
        $viewData->next_site_name = $next_site_name;
        $viewData->users = $users;
        $viewData->companys = $companys;
        $viewData->upload_function = $upload_function;
        $viewData->path = $path;
        $viewData->sites = $sites;
        $viewData->main_contracts = $main_contracts;
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
        if (!isAdmin() && !permission_control("project", "write")) {
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
        if (!isAdmin() && !permission_control("project", "update")) {
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
            $viewData->form_error = true;
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
    }

    public function delete($id)
    {

        if (isAdmin() && permission_control("project", "delete")) {

            $project = $this->Project_model->get(array("id" => $id));

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
        } else {
            echo "Bu İşlemi Yapma Yetkiniz Yok";
        }

    }

    public function file_upload($id)
    {

        if (isAdmin() || permission_control("project", "update")) {

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
        } else {
            echo "Bu İşlemi Yapma Yetkiniz Yok";
        }
    }

    public function fileDelete_java($id)
    {
        if (isAdmin() && permission_control("project", "delete")) {
            $fileName = $this->input->post('fileName');

            $project = $this->Project_model->get(array("id" => $id));

            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/main/";

            unlink("$path/$fileName");
        } else {
            echo "Bu İşlemi Yapma Yetkiniz Yok";
        }
    }

    public
    function download_all($project_id)
    {
        if (isAdmin() && permission_control("project", "update")) {
            $this->load->library('zip');
            $this->zip->compression_level = 0;

            $project_code = project_code($project_id);
            $project_name = get_from_id("projects", "project_name", $project_id);

            $path = "uploads/project_v/$project_code/main";

            $files = glob($path . '/*');

            foreach ($files as $file) {
                $this->zip->read_file($file, FALSE);
            }

            $zip_name = $project_name;
            $this->zip->download("$zip_name");
        } else {
            echo "Bu İşlemi Yapma Yetkiniz Yok";
        }
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

    public function create_contract($project_id = null, $parent_contract = null)
    {
        // Kullanıcının admin olup olmadığını ve yetkilendirme işlemini kontrol edin
        if (!isAdmin() && !permission_control("contract", "write")) {
            redirect(base_url("error"));
        }


        $project_code = project_code($project_id);

        $file_name = "SOZ-" . get_next_file_code("Contract");

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

            $viewData = new stdClass();

            $item = $this->Project_model->get(array("id" => $project_id));
            $main_contracts = $this->Contract_model->get_all(array("proje_id" => $project_id, "parent" => 0));
            $settings = $this->Settings_model->get();

            // View'e gönderilecek Değişkenlerin Set Edilmesi
            $viewData->item = $item;
            $viewData->main_contracts = $main_contracts;
            $viewData->settings = $settings;

            $response = array(
                'status' => 'success',
                'html' => $this->load->view("project_v/display/contract/contract_table", $viewData, true)
            );
            echo json_encode($response);

        } else {
            // Form Validation Başarısız, hata mesajları ile birlikte görüntüyü yükle
            $viewData = new stdClass();


            $item = $this->Project_model->get(array("id" => $project_id));
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all(array());
            $main_contracts = $this->Contract_model->get_all(array("proje_id" => $project_id, "parent" => 0));
            $next_contract_name = get_next_file_code("Contract");

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->companys = $companys;
            $viewData->next_contract_name = $next_contract_name;
            $viewData->main_contracts = $main_contracts;
            $viewData->item = $item;
            $viewData->settings = $settings;
            $viewData->form_error = true;

            $response = array(
                'status' => 'error',
                'html' => $this->load->view("project_v/display/contract/add_contract_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public function create_site($project_id = null)
    {
        // Kullanıcının admin olup olmadığını ve yetkilendirme işlemini kontrol edin
        if (!isAdmin() && !permission_control("contract", "write")) {
            redirect(base_url("error"));
        }

        $next_site_name = get_next_file_code("Site");
        $file_name = "SNT-" . $next_site_name;

        $this->load->library("form_validation");

        $this->form_validation->set_rules("contract_id", "Sözleşme", "required|trim|integer");
        $this->form_validation->set_rules("santiye_sefi", "Şantiye Şefi", "greater_than[0]|required|trim");
        $this->form_validation->set_rules("santiye_ad", "Şantiye Adı", "required|trim|is_unique[site.santiye_ad]");

        $this->form_validation->set_message(
            array(
                "integer" => "<b>{field}</b> alanı doldurulmalıdır",
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> Seçilmelidir",
                "is_unique" => "<b>Aynı İsimde Şanitye Mevcut</b> Farklı İsim Seçiniz",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$file_name/Main/";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
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

            $sub_contracts = $this->input->post('sub_contract');

            $insert = $this->Site_model->add(
                array(
                    "proje_id" => $project_id,
                    "contract_id" => $this->input->post('contract_id'),
                    "dosya_no" => $file_name,
                    "santiye_ad" => $this->input->post("santiye_ad"),
                    "santiye_sefi" => $this->input->post("santiye_sefi"),
                    "teknik_personel" => $data_personel,
                    "is_Active" => "1",
                )
            );

            $viewData = new stdClass();

            $item = $this->Project_model->get(array("id" => $project_id));
            $main_contracts = $this->Contract_model->get_all(array("proje_id" => $project_id, "parent" => 0));
            $settings = $this->Settings_model->get();
            $sites = $this->Site_model->get_all(array("proje_id" => $project_id));

            // View'e gönderilecek Değişkenlerin Set Edilmesi
            $viewData->item = $item;
            $viewData->main_contracts = $main_contracts;
            $viewData->settings = $settings;
            $viewData->sites = $sites;

            $response = array(
                'status' => 'success',
                'html' => $this->load->view("project_v/display/site/site_table", $viewData, true)
            );
            echo json_encode($response);

        } else {
            // Form Validation Başarısız, hata mesajları ile birlikte görüntüyü yükle
            $viewData = new stdClass();

            $item = $this->Project_model->get(array("id" => $project_id));
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all(array());
            $sites = $this->Site_model->get_all(array("proje_id" => $project_id));
            $main_contracts = $this->Contract_model->get_all(array("proje_id" => $project_id, "parent" => 0));
            $next_site_name = get_next_file_code("Site");
            $users = $this->User_model->get_all();

            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->companys = $companys;
            $viewData->sites = $sites;
            $viewData->next_site_name = $next_site_name;
            $viewData->main_contracts = $main_contracts;
            $viewData->item = $item;
            $viewData->settings = $settings;
            $viewData->users = $users;

            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("project_v/display/site/add_site_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }
}
