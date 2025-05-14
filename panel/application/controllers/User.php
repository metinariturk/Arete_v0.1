<?php

class user extends MY_Controller
{
    public $viewFolder = "";
    public $moduleFolder = "";

    public function __construct()
    {
        parent::__construct();

        $this->moduleFolder = "user_module";
        $this->viewFolder = "user_v";
        $this->load->model("User_model");
        $this->load->model("Settings_model");
        $this->load->model("Project_model");
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
        $this->Dependet_id_key = "user_id";
        //Folder Structure
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Update_Folder = "u";
        $this->Common_Files = "common";
    }

    public function index()
    {
        $viewData = new stdClass();
        $active_user = $this->User_model->get(array("id" => active_user_id()));

        $items = $this->User_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $contracts = $this->Contract_model->get_all(array());
        $sites = $this->Site_model->get_all(array());
        $modules = getModuleList();


        $settings = $this->Settings_model->get();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->active_user = $active_user;
        $viewData->modules = $modules;

        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->contracts = $contracts;
        $viewData->sites = $sites;
        $viewData->settings = $settings;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function file_form($id)
    {

        if (!user_has_permission('user', ['r'])) {
            show_error('Bu sayfaya erişim yetkiniz yok!', 403);
        }

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

        $modules = getModuleList();
        $projects = $this->Project_model->get_all(array());
        $contracts = $this->Contract_model->get_all(array());
        $sites = $this->Site_model->get_all(array());
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->projects = $projects;
        $viewData->contracts = $contracts;
        $viewData->modules = $modules;
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

    public function create_user()
    {

        if (!user_has_permission('user', ['w'])) {
            show_error('Bu sayfaya erişim yetkiniz yok!', 403);
        }

        $this->load->library("form_validation");
        $this->load->library('encryption');
        $user_name = $this->input->post("user_name");
        $this->form_validation->set_rules("user_name", "Kullanıcı Adı", "required|trim|min_length[6]|is_unique[users.user_name]|callback_charset_control");
        $this->form_validation->set_rules('phone', 'Telefon Numarası', 'callback_validate_phone_number');
        $this->form_validation->set_rules("name", "Ad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("surname", "Soyad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("email", "E-Posta", "valid_email|required|trim");
        if (!empty($this->input->post("user_role"))) {
            $this->form_validation->set_rules("password", "Şifre", "required|trim|min_length[8]");
            $this->form_validation->set_rules("password_check", "Şifre Kontrol", "matches[password]|required|trim");
        }
// Yeni eklemeler:
        $this->form_validation->set_rules("unvan", "Ünvan", "trim|max_length[100]"); // Ünvan
        $this->form_validation->set_rules("createdAt", "Giriş Tarihi", "trim"); // Giriş Tarihi

        $this->form_validation->set_rules("bank", "Banka", "trim|max_length[100]"); // Banka

        if (!empty($this->input->post("bank"))) {
            $this->form_validation->set_rules("IBAN", "IBAN", "required|trim|max_length[34]|callback_validate_iban");
        } else {
            $this->form_validation->set_rules("IBAN", "IBAN", "trim|max_length[34]|callback_validate_iban");
        }
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "regex_match" => "<b>{field}</b> uygun formatta yazılmamış veya uyumsuz karakterler var",
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
                    "bank" => $this->input->post("bank"),  // Banka adı
                    "IBAN" => $this->input->post("IBAN"),  // IBAN numarası
                )
            );

            $record_id = $this->db->insert_id();

            $path = "$this->File_Dir_Prefix/$record_id";
// Güvenlik için dosya yolunu doğrulamak (path güvenli olmalı)
            $response = array();

            $path = realpath($path) ? $path : "$this->File_Dir_Prefix/$record_id";
// Dizin oluşturulmadan önce var olup olmadığını kontrol et
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            $viewData = new stdClass();

            $settings = $this->Settings_model->get();

            $items = $this->User_model->get_all(array(
                "isActive" => 1
            ));
            $active_user = $this->User_model->get(array("id" => $record_id));

            $companys = $this->Company_model->get_all();
            $viewData->settings = $settings;
            $viewData->companys = $companys;
            $viewData->items = $items;
            $viewData->active_user = $active_user;

            $response = array(
                'status' => 'success',
                'html' => $this->load->view("user_module/user_v/list/user/user_table", $viewData, true)
            );

            echo json_encode($response);

        } else {

            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $items = $this->User_model->get_all(array(
                "user_role" => 1
            ));
            $companys = $this->Company_model->get_all();
            $viewData->settings = $settings;
            $viewData->companys = $companys;
            $viewData->items = $items;
            $viewData->form_error = true;

            $response = array(
                'status' => 'error',
                'html' => $this->load->view("user_module/user_v/list/user/add_user_form_input", $viewData, true)
            );

            echo json_encode($response);
        }
    }

    public function update($user_id)
    {
        if (!user_has_permission('user', ['u'])) {
            show_error('Bu sayfaya erişim yetkiniz yok!', 403);
        }

        $this->load->library("form_validation");

        $this->load->library('encryption');

        $user = $this->User_model->get(array("id" => $user_id));
        $user_name = $this->input->post("user_name");
        $password_posted = $this->input->post("password");
        $password_check_posted = $this->input->post("password_check");
        $current_password_db = $this->encryption->decrypt($user->password);

        if ($user->user_name != $user_name) {
            $this->form_validation->set_rules("user_name", "Kullanıcı Adı", "required|trim|min_length[6]|is_unique[users.user_name]|callback_charset_control");
        }

        $this->form_validation->set_rules('phone', 'Telefon Numarası', 'callback_validate_phone_number');
        $this->form_validation->set_rules("name", "Ad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("surname", "Soyad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("email", "E-Posta", "valid_email|required|trim");

        if ($this->input->post("user_role")) {
            // Şifre alanında değişiklik olup olmadığını kontrol et
            $password_posted = $this->input->post("password");
            $password_check_posted = $this->input->post("password_check");
            $current_password_db = $this->encryption->decrypt($user->password);
            // Şifre alanı boşsa mevcut şifreyi kullan
            if (empty($password_posted)) {
                $this->form_validation->set_rules("password", "Şifre", "trim|min_length[8]|required");
                $new_password = null;
            } else {
                $new_password = $password_posted;
            }

            // Eğer yeni şifre girilmişse ve mevcut şifreden farklıysa, şifre doğrulamasını yap
            if (!empty($password_posted) && $password_posted !== $current_password_db) {
                $this->form_validation->set_rules("password", "Şifre", "trim|min_length[8]|required");
                // Şifre tekrar alanı da doluysa ve yeni şifre girilmişse eşleşme kontrolü yap
                if (!empty($password_check_posted)) {
                    $this->form_validation->set_rules("password_check", "Şifre Tekrar", "required|matches[password]|trim");
                } else {
                    // Yeni şifre girilmiş ancak tekrarı boşsa hata ver
                    $this->form_validation->set_rules("password_check", "Şifre Tekrar", "required|trim");
                }
            }

            $updated_password = $this->encryption->encrypt($new_password);

        } else {
            $updated_password = null;
        }


        $this->form_validation->set_rules("unvan", "Ünvan", "trim|max_length[100]"); // Ünvan
        $this->form_validation->set_rules("createdAt", "Giriş Tarihi", "trim"); // Giriş Tarihi

        $this->form_validation->set_rules("bank", "Banka", "trim|max_length[100]"); // Banka

        if (!empty($this->input->post("bank"))) {
            $this->form_validation->set_rules("IBAN", "IBAN", "required|trim|max_length[34]|callback_validate_iban");
        } else {
            $this->form_validation->set_rules("IBAN", "IBAN", "trim|max_length[34]|callback_validate_iban");
        }
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "regex_match" => "<b>{field}</b> uygun formatta yazılmamış veya uyumsuz karakterler var",
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

            $update = $this->User_model->update(
                array(
                    "id" => $user_id
                ),
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
                    "password" => $updated_password,
                    "isActive" => "1",
                    "createdAt" => date("Y-m-d H:i:s"),
                    "bank" => $this->input->post("bank"),  // Banka adı
                    "IBAN" => $this->input->post("IBAN"),  // IBAN numarası
                )
            );

            $item = $this->User_model->get(array("id" => $user_id));

            $viewData = new stdClass();

            $viewData->item = $item;

            $response = array(
                'status' => 'success',
                'html' => $this->load->view("user_module/user_v/display/info", $viewData, true)
            );

            echo json_encode($response);

        } else {

            $viewData = new stdClass();

            $item = $this->User_model->get(array("id" => $user_id));

            $viewData->item = $item;

            $viewData->form_error = true;

            $response = array(
                'status' => 'error',
                'html' => $this->load->view("user_module/user_v/display/update_form_input", $viewData, true)
            );

            echo json_encode($response);
        }
    }

    public function update_permissions($user_id)
    {
        if (!user_has_permission('user', ['w'])) {
            show_error('Bu sayfaya erişim yetkiniz yok!', 403);
        }

        $raw_permissions = $this->input->post("permissions");

        $final_permissions = [];

        if (!empty($raw_permissions)) {
            foreach ($raw_permissions as $module => $letters) {
                // Yalnızca r, w, u, d olanları al
                $letters = array_filter($letters, function ($l) {
                    return in_array($l, ['r', 'w', 'u', 'd']);
                });

                $final_permissions[$module] = implode('', array_unique($letters));
            }

            $json_permissions = json_encode($final_permissions); // veritabanına kaydet
        } else {
            $json_permissions = null;
        }

        $update = $this->User_model->update(
            array("id" => $user_id),
            array("permissions" => $json_permissions)
        );

        $item = $this->User_model->get(array("id" => $user_id));
        $modules = getModuleList();

        $viewData = new stdClass();
        $viewData->item = $item;
        $viewData->modules = $modules;

        $response = array(
            'status' => 'success',
            'html' => $this->load->view("user_module/user_v/display/permission", $viewData, true)
        );

        echo json_encode($response);
    }


    public function delete_user($id)
    {
        if (!user_has_permission('user', ['w'])) {
            show_error('Bu sayfaya erişim yetkiniz yok!', 403);
        }

        $user = $this->User_model->get(['id' => $id]);

        if ($user && $user->is_Admin == 1) {
            echo json_encode([
                'success' => false,
                'message' => 'Admin yetkisine sahip kullanıcı silinemez.'
            ]);
            return;
        }

        $delete_user = $this->User_model->delete(['id' => $id]);

        // Dosyaları da sil
        $this->load->helper('file');
        $path = "$this->File_Dir_Prefix/$id";
        delete_files($path, true);
        if (is_dir($path)) {
            rmdir($path);
        }

        echo json_encode([
            'success' => $delete_user,
            'message' => $delete_user
                ? 'Kullanıcı başarıyla silindi.'
                : 'Kullanıcı silinemedi.',
            'redirect' => base_url("user")
        ]);
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
        // Tüm boşlukları ve parantezleri sil
        $phone = str_replace([' ', '(', ')'], '', $phone);

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

    function validate_iban($iban)
    {
        // Eğer alan boşsa kontrol etme, geçerli kabul et (çünkü "required" değil)
        if (empty(trim($iban))) {
            return TRUE;
        }

        // IBAN'daki boşlukları kaldır
        $iban = str_replace(' ', '', $iban);

        // Türkiye IBAN formatı için regex kontrolü
        if (preg_match('/^TR\d{24}$/', $iban)) {
            return TRUE;
        } else {
            // Hata mesajı ekle
            $this->form_validation->set_message('validate_iban', "Geçersiz IBAN numarası: $iban");
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
        $modules = getModuleList();
        $item = $this->User_model->get(
            array(
                "id" => $id
            )
        );

        $permissions = $item->permissions;

        if (!is_string($permissions)) {
            // Geçersiz yetki formatı varsa null'a çekiyoruz
            $this->User_model->update(
                array("id" => $id),
                array("permissions" => null)
            );

            // İstersen log yazabilirsin
            log_message('error', "Kullanıcı ($id) yetkileri bozulmuştu, sıfırlandı.");

            // Devam etmeden önce $permissions değişkenini sıfırla
            $permissions = null;
        }

        $viewData = new stdClass();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->item = $item;
        $viewData->modules = $modules;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/show_details", $viewData);
    }

    public function show_update_form($id)
    {

        $viewData = new stdClass();
        $settings = $this->Settings_model->get();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->settings = $settings;
        $viewData->item = $this->User_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/update_form_input", $viewData);
    }

    public function show_update_permission($id)
    {
        $modules = getModuleList();
        $settings = $this->Settings_model->get();


        $viewData = new stdClass();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";

        $viewData->settings = $settings;

        $viewData->modules = $modules;
        $viewData->item = $this->User_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/update_permission", $viewData);
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

    function delete_avatar_file($id)
    {
        // Klasör yolu
        $path = "$this->File_Dir_Prefix/$id/";

        // Klasör var mı kontrol et
        if (!is_dir($path)) {
            return false;
        }

        // avatar içeren dosyaları tara
        foreach (glob($path . '*avatar*') as $file) {
            if (is_file($file)) {
                unlink($file);
                return true; // İlk eşleşeni sildikten sonra çık
            }
        }

        return false; // Hiçbir şey silinmediyse
    }

    public function open_edit_user_modal($user_id)
    {
        // Verilerin getirilmesi
        $edit_user = $this->User_model->get(array("id" => $user_id));
        $viewData = new stdClass();

        $viewData->edit_user = $edit_user;

        $this->load->view("user_module/user_v/list/user/edit_user_modal_form", $viewData, true);
    }

}


