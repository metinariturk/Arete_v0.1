<?php

class user extends CI_Controller
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

        $this->moduleFolder = "user_module";
        $this->viewFolder = "user_v";
        $this->load->model("User_model");
        $this->load->model("Settings_model");
        $this->load->model("Project_model");
        $this->load->model("Order_model");
        $this->load->model("Company_model");
        $this->load->model("Project_model");
        $this->load->model("Contract_model");
        $this->load->model("Site_model");


        $this->Module_Name = "user";
        $this->Module_Title = "Sistem Kullanıcısı";

        // Folder Structure
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "users_v";
        $this->Module_Depended_Dir = "users";
        $this->Module_File_Dir = "system_users";
        $this->Module_Table = "system_users";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir/$this->Module_File_Dir";
        // Folder Structure

        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "user_id";
        //Folder Structure
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Update_Folder = "update";


        $this->Common_Files = "common";
    }

    public function index()
    {
        $viewData = new stdClass();

        $user = get_active_user();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->User_model->get_all(array());
        $projects = $this->Project_model->get_all(array());

        $contracts = $this->Contract_model->get_all(array());
        $sites = $this->Site_model->get_all(array());

        $user = $this->User_model->get(array(
            "id" => $user->id
        ));
        $settings = $this->Settings_model->get();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->contracts = $contracts;
        $viewData->sites = $sites;
        $viewData->user = $user;
        $viewData->settings = $settings;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }


    public function file_form($id)
    {
        $viewData = new stdClass();

        $path = "$this->File_Dir_Prefix/$id/";

        // Dizin kontrolü
        if (!is_dir($path)) {
            // Dizin yoksa oluştur
            if (!mkdir($path, 0777, true)) {
                echo json_encode(['error' => 'Dizin oluşturulamadı.']);
                exit;
            }
        }

        $projects = $this->Project_model->get_all(array());

        $contracts = $this->Contract_model->get_all(array());
        $sites = $this->Site_model->get_all(array());


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->projects = $projects;
        $viewData->contracts = $contracts;
        $viewData->sites = $sites;

        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->item = $this->User_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item = $this->User_model->get(
            array(
                "id" => $id
            )
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function update_form($id)
    {
        $viewData = new stdClass();

        $modules = getModuleList();


        $settings = $this->Settings_model->get();
        $companys = $this->Company_model->get_all();


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->settings = $settings;
        $viewData->modules = $modules;
        $viewData->companys = $companys;

        $viewData->item = $this->User_model->get(
            array(
                "id" => $id
            )
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function save()
    {

        $this->load->library("form_validation");

        $this->load->library('encryption');

        $user_name = $this->input->post("user_name");

        $this->form_validation->set_rules("user_name", "Kullanıcı Adı", "required|trim|min_length[6]|is_unique[users.user_name]|callback_charset_control");
        $this->form_validation->set_rules('phone', 'Telefon Numarası', 'callback_validate_phone_number');
        $this->form_validation->set_rules("user_role", "Kullanıcı Türü", "required|trim");
        $this->form_validation->set_rules("name", "Ad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("surname", "Soyad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("email", "E-Posta", "valid_email|required|trim");
        $this->form_validation->set_rules("password", "Şifre", "required|trim|min_length[8]");
        $this->form_validation->set_rules("password_check", "Şifre Kontrol", "matches[password]|required|trim");

// Yeni eklemeler:
        $this->form_validation->set_rules("unvan", "Ünvan", "trim|max_length[100]"); // Ünvan
        $this->form_validation->set_rules("createdAt", "Giriş Tarihi", "trim"); // Giriş Tarihi
        $this->form_validation->set_rules("banka", "Banka", "trim|max_length[100]"); // Banka
        $this->form_validation->set_rules("IBAN", "IBAN", "trim|max_length[34]|alpha_numeric"); // IBAN


        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "regex_match" => "<b>{field}</b> 10 haneli olarak, sayılardan oluşmalıdır",
                "is_unique" => "<b>{field}</b> daha önce kullanılmış",
                "min_length" => "<b>{field}</b> en az {param} karakter uzunluğunda olmalıdır",
                "duplicate_name_check" => "<b>{field}</b> $user_name daha önce kullanılmış",
                "charset_control" => "<b>{field}</b> $user_name Geçersiz Karakter İçeriyor",
                "name_control" => "<b>{field}</b> Geçersiz Karakter İçeriyor",
                "full_name" => "<b>{field}</b> Ad Soyad Bilgilerini Eksiksiz Giriniz",
                "matches" => "<b>{field}</b> Şifreleriniz Eşleşmiyor",
                "valid_email" => "<b>{field}</b> Geçerli bir E-Posta adresi giriniz",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $name = mb_convert_case($this->input->post("name"), MB_CASE_TITLE, "UTF-8");
            $surname = mb_strtoupper($this->input->post("surname"), "UTF-8");
            $user_role = $this->input->post("user_role") ? 1 : 0; // Eğer checkbox işaretliyse 1, değilse 0 alır

            $insert = $this->User_model->add(
                array(
                    "user_name" => $this->input->post("user_name"),
                    "user_role" => $user_role, // Checkbox'tan gelen değer burada kullanılıyor
                    "profession" => $this->input->post("profession"),
                    "company" => $this->input->post("company"),
                    "unvan" => $this->input->post("unvan"),
                    "name" => $name,
                    "phone" => $this->input->post("phone"),
                    "surname" => $surname,
                    "email" => $this->input->post("email"),
                    "password" => $this->encryption->encrypt($this->input->post("password")),
                    "isActive" => "1",
                    "createdAt" => date("Y-m-d H:i:s"),
                    "banka" => $this->input->post("teminat_banka"),  // Banka adı
                    "IBAN" => $this->input->post("IBAN"),  // IBAN numarası
                    "address" => $this->input->post("address")  // Adres, eğer varsa
                )
            );


            $record_id = $this->db->insert_id();
            $path = "$this->File_Dir_Prefix/$record_id";

// Güvenlik için dosya yolunu doğrulamak (path güvenli olmalı)
            $path = realpath($path) ? $path : "$this->File_Dir_Prefix/$record_id";

// Dizin oluşturulmadan önce var olup olmadığını kontrol et
            if (!is_dir($path)) {
                if (mkdir($path, 0755, true)) { // 0755 genellikle daha güvenli izinler sağlar
                    echo "Dosya Yolu Başarıyla Oluşturuldu: " . $path;
                } else {
                    // Hata mesajı ve loglama
                    echo "<p>Hata: Dizin oluşturulamadı: " . $path . "</p>";
                    log_message('error', 'Dizin oluşturulamadı: ' . $path); // Hata loglama
                }
            } else {
                // Aynı isimde dosya mevcutsa daha profesyonel bir mesaj
                echo "<p><strong>Uyarı:</strong> Aynı isimde bir dosya veya dizin zaten mevcut: " . $path . "</p>";
            }

            // İşlemin Sonucunu Session'a yazma işlemi...

            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));
        } else {


            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $items = $this->User_model->get_all(array(
                "user_role" => 1
            ));
            $companys = $this->Company_model->get_all();


            $viewData->settings = $settings;
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->companys = $companys;
            $viewData->subViewFolder = "add";
            $viewData->items = $items;
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update($id)
    {

        $permissions = json_encode($this->input->post("permissions"));

        $this->load->library('encryption');
        $this->load->library("form_validation");
        $user = $this->User_model->get(array("id" => $id));

        if (empty($this->input->post("password"))) {
            $current_password = $this->encryption->decrypt($user->password);
        } else {
            $current_password = $this->input->post("password");
        }

        $user_name = $this->input->post("user_name");

        if ($user->user_name != $user_name) {
            $this->form_validation->set_rules("user_name", "Kullanıcı Adı", "required|trim|min_length[6]|is_unique[users.user_name]|callback_charset_control");
        }

        $this->form_validation->set_rules('phone', 'Telefon Numarası', 'callback_validate_phone_number');
        $this->form_validation->set_rules("profession", "Meslek", "required|trim");
        $this->form_validation->set_rules("company", "Firma", "required|trim");
        $this->form_validation->set_rules("name", "Ad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("surname", "Soyad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("email", "E-Posta", "valid_email|required|trim");

        if (!empty($this->input->post("password")) && $this->input->post("password") !== $this->encryption->decrypt($user->password)) {
            $this->form_validation->set_rules("password", "Şifre", "trim|min_length[8]");
            $this->form_validation->set_rules("password_check", "Şifre Kontrol", "matches[password]|required|trim");
        }

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "regex_match" => "<b>{field}</b> 10 haneli olarak, sayılardan oluşmalıdır",
                "is_unique" => "<b>{field}</b> daha önce kullanılmış",
                "min_length" => "<b>{field}</b> en az {param} karakter uzunluğunda olmalıdır",
                "duplicate_name_check" => "<b>{field}</b> $user_name daha önce kullanılmış",
                "charset_control" => "<b>{field}</b> $user_name Geçersiz Karakter İçeriyor",
                "name_control" => "<b>{field}</b> Geçersiz Karakter İçeriyor",
                "full_name" => "<b>{field}</b> Ad Soyad Bilgilerini Eksiksiz Giriniz",
                "matches" => "<b>{field}</b> Şifreleriniz Eşleşmiyor",
                "valid_email" => "<b>{field}</b> Geçerli bir E-Posta adresi giriniz",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $name = mb_convert_case($this->input->post("name"), MB_CASE_TITLE, "UTF-8");
            $surname = mb_strtoupper($this->input->post("surname"), "UTF-8");

            $update = $this->User_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "user_name" => $this->input->post("user_name"),
                    "user_role_id" => $this->input->post("user_role"),
                    "profession" => $this->input->post("profession"),
                    "unvan" => $this->input->post("unvan"),
                    "permissions" => $permissions,
                    "name" => $name,
                    "surname" => $surname,
                    "email" => $this->input->post("email"),
                    "company" => $this->input->post("company"),
                    "phone" => $this->input->post("phone"),
                    "password" => $this->encryption->encrypt($current_password),
                )
            );

            // TODO Alert sistemi eklenecek...
            if ($update) {

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kullanıcı Kaydı başarılı bir şekilde güncellendi",
                    "type" => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kullanıcı Kaydı güncelleme sırasında bir problem oluştu",
                    "type" => "danger"
                );


            }

            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$id"));

        } else {

            $modules = getModuleList();

            $viewData = new stdClass();

            /** Tablodan Verilerin Getirilmesi.. */
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all();


            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->settings = $settings;
            $viewData->modules = $modules;
            $viewData->companys = $companys;
            $viewData->form_error = true;

            $viewData->item = $this->User_model->get(
                array(
                    "id" => $id
                )
            );
            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $path = "$this->File_Dir_Prefix/$id";
        echo $path;

        $sil = deleteDirectory($path);

        $delete = $this->User_model->delete(
            array(
                "id" => $id
            )
        );

        // TODO Alert Sistemi Eklenecek...
        if ($delete) {
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Sistem Kullanıcısı başarılı bir şekilde silindi",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Sistemi Kullanıcısı silme sırasında bir problem oluştu",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("$this->Module_Name/index"));
    }

    public function file_upload($id)
    {

        $file_name = "avatar";

        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$id/";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

        } else {
            echo "islem basarisiz";
            echo $config["upload_path"];
        }

    }


    public function fileDelete($id, $from)
    {

        $dir_files = directory_map("$this->File_Dir_Prefix/$id");

        foreach ($dir_files as $dir_file) {
            unlink("$this->File_Dir_Prefix/$id/$dir_file");
        }

        redirect(base_url("$this->Module_Name/$from/$id"));

    }

    public function isActiveSetter($id)
    {

        if ($id) {

            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->User_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "isActive" => $isActive
                )
            );
        }
    }

    public function duplicate_name_check($file_name)
    {
        $var = count_data("users", "user_name", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function charset_control($user_name)
    {
        if (strlen($user_name) - strcspn($user_name, "\"\\?*:/@|< -çÇğĞüÜöÖıİşŞ.!'?*|=()[]{}>")) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function name_control($user_name)
    {
        return (!preg_match("/^([-a-z üğışçöÜĞİŞÇÖ])+$/i", $user_name)) ? FALSE : TRUE;
    }

    function validate_phone_number($phone)
    {
        // Tüm boşlukları sil
        $phone = str_replace(' ', '', $phone);

        // Eğer başında 0 varsa, bu sıfırı sil
        if (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }

        // 10 haneli mi kontrol et
        if (strlen($phone) === 10 && preg_match('/^[0-9]{10}$/', $phone)) {
            return TRUE;
        } else {
            // Hata mesajı ekle
            $this->form_validation->set_message('validate_phone_number', 'Geçersiz telefon numarası.');
            return FALSE;
        }
    }


    public function mode()
    {
        $user_mode = get_active_user()->mode;

        $user_id = get_active_user()->id;
// Yeni mode değeri
        $new_mode = $user_mode == 1 ? 0 : 1;

        echo $user_id;

        $update = $this->User_model->update(
            array("id" => $user_id),
            array("mode" => $new_mode)
        );


        $session_data = $this->session->userdata();

        $session_data['user']->mode = $new_mode;

        $this->session->unset_userdata("user");

        $this->session->set_userdata($session_data);

    }

    public function user_detail($id)
    {
        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";

        $viewData->item = $this->User_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/show_details", $viewData);

    }

    public function ajax_upload_file($id)
    {
        $path = "$this->File_Dir_Prefix/$id/";

        // Dizin kontrolü
        if (!is_dir($path)) {
            // Dizin yoksa oluştur
            if (!mkdir($path, 0777, true)) {
                echo json_encode(['error' => 'Dizin oluşturulamadı.']);
                exit;
            }
        } else {
            // Dizin varsa, içindeki tüm dosyaları sil
            $files = glob($path . '*'); // Dizin içindeki tüm dosyaları al

            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // Dosyaları sil
                }
            }
        }

        $configuration = [
            'limit' => 1,
            'fileMaxSize' => 10,
            'extensions' => ['image/*'],
            'title' => $id . '_avatar', // Dosya adını burada değiştiriyoruz
            'uploadDir' => $path, // $path doğrudan kullanılıyor
            'replace' => false,
            'editor' => [
                'maxWidth' => 512,
                'maxHeight' => 512,
                'crop' => false,
                'quality' => 95
            ]
        ];

        if (isset($_POST['fileuploader']) && isset($_POST['name'])) {
            $name = str_replace(array('/', '\\'), '', $_POST['name']);
            $editing = isset($_POST['editing']) && $_POST['editing'] == true;

            if (is_file($configuration['uploadDir'] . $name)) {
                $configuration['title'] = $name;
                $configuration['replace'] = true;
            }
        }

        // initialize FileUploader
        $FileUploader = new FileUploader('files', $configuration);

        // call to upload the files
        $data = $FileUploader->upload();

        // change file's public data
        if (!empty($data['files'])) {
            $item = $data['files'][0];

            $data['files'][0] = array(
                'title' => $item['title'],
                'name' => $item['name'],
                'size' => $item['size'],
                'size2' => $item['size2']
            );
        }

        // export to js
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

}
