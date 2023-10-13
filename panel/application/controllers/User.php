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


        $this->moduleFolder = "user_module";
        $this->viewFolder = "user_v";
        $this->load->model("User_model");
        $this->load->model("Settings_model");
        $this->load->model("Project_model");
        $this->load->model("Order_model");
        $this->load->model("Company_model");
        $this->load->model("User_role_model");
        $this->load->model("Project_model");
        $this->load->model("Auction_model");
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

        $this->File_List = "file_list_v";
        $this->Common_Files = "common";
    }

    public function index()
    {
        $viewData = new stdClass();

        $user = get_active_user();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->User_model->get_all(array());
        $user_roles = $this->User_role_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $auctions = $this->Auction_model->get_all(array());
        $contracts = $this->Contract_model->get_all(array());
        $sites = $this->Site_model->get_all(array());

        $user = $this->User_model->get(array(
            "id" => $user->id
        ));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->auctions = $auctions;
        $viewData->contracts = $contracts;
        $viewData->sites = $sites;
        $viewData->user_roles = $user_roles;
        $viewData->user = $user;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form()
    {

        $viewData = new stdClass();
        $settings = $this->Settings_model->get();
        $items = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $companys = $this->Company_model->get_all();
        $user_roles = $this->User_role_model->get_all(
            array(
                "isActive" => 1
            )
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->settings = $settings;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->companys = $companys;
        $viewData->subViewFolder = "add";
        $viewData->items = $items;
        $viewData->user_roles = $user_roles;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        $projects = $this->Project_model->get_all(array());
        $auctions = $this->Auction_model->get_all(array());
        $contracts = $this->Contract_model->get_all(array());
        $sites = $this->Site_model->get_all(array());

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->projects = $projects;
        $viewData->auctions = $auctions;
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
        $user_roles = $this->User_role_model->get_all(
            array(
                "isActive" => 1
            )
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->settings = $settings;
        $viewData->modules = $modules;
        $viewData->companys = $companys;
        $viewData->user_roles = $user_roles;

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
        $this->form_validation->set_rules("phone", "Telefon Numarası ", "regex_match[/^[0-9]{10}$/]"); //{10} for 10 digits number
        $this->form_validation->set_rules("user_role", "Kullanıcı Türü", "required|trim");
        $this->form_validation->set_rules("name", "Ad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("surname", "Soyad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("company", "Firma", "required|trim");
        $this->form_validation->set_rules("email", "E-Posta", "valid_email|required|trim");
        $this->form_validation->set_rules("password", "Şifre", "required|trim|min_length[8]");
        $this->form_validation->set_rules("password_check", "Şifre Kontrol", "matches[password]|required|trim");

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

        $default_permissions = user_role_permissions($this->input->post("user_role"));


        if ($validate) {

            $name = mb_convert_case($this->input->post("name"), MB_CASE_TITLE, "UTF-8");
            $surname = mb_strtoupper($this->input->post("surname"), "UTF-8");

            $insert = $this->User_model->add(
                array(
                    "user_name" => $this->input->post("user_name"),
                    "user_role" => $this->input->post("user_role"),
                    "profession" => $this->input->post("profession"),
                    "company" => $this->input->post("company"),
                    "unvan" => $this->input->post("unvan"),
                    "name" => $name,
                    "phone" => $this->input->post("phone"),
                    "permissions" => $default_permissions,
                    "surname" => $surname,
                    "email" => $this->input->post("email"),
                    "password" => $this->encryption->encrypt($this->input->post("password")),
                    "isActive" => "1",
                    "createdAt" => date("Y-m-d H:i:s")
                )
            );

            $record_id = $this->db->insert_id();
            $path = "$this->File_Dir_Prefix/$record_id";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "Dosya Yolu Oluşturuldu: " . $path;
            } else {
                echo "<p>Aynı İsimde Dosya Mevcut: " . $path . "</p>";
            }


            if ($insert) {

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "$file_name - Sistem Kullanıcısı başarılı bir şekilde eklendi",
                    "type" => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "$file_name - Sistem Kullanıcısı ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }

            // İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));
        } else {


            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $items = $this->User_model->get_all(array(
                "user_role" => 1
            ));
            $companys = $this->Company_model->get_all();
            $user_roles = $this->User_role_model->get_all(
                array(
                    "isActive" => 1
                )
            );

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->settings = $settings;
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->companys = $companys;
            $viewData->subViewFolder = "add";
            $viewData->items = $items;
            $viewData->user_roles = $user_roles;
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update($id)
    {

        $current_role = get_from_id("users", "user_role_id", "$id");
        $income_role = $this->input->post("user_role");

        $this->load->library('encryption');
        $this->load->library("form_validation");

        $current_user_name = get_from_any("users", "user_name", "id", $id);

        if (empty($this->input->post("password"))) {
            $current_password = $this->encryption->decrypt(get_from_any("users", "password", "id", $id));
        } else {
            $current_password = $this->input->post("password");
        }

        $user_name = $this->input->post("user_name");

        if ($current_user_name != $user_name) {
            $this->form_validation->set_rules("user_name", "Kullanıcı Adı", "required|trim|min_length[6]|is_unique[users.user_name]|callback_charset_control");
        }


        $this->form_validation->set_rules("phone", "Telefon Numarası ", "regex_match[/^[0-9]{10}$/]"); //{10} for 10 digits number
        $this->form_validation->set_rules("user_role", "Kullanıcı Türü", "required|trim");
        $this->form_validation->set_rules("profession", "Meslek", "required|trim");
        $this->form_validation->set_rules("company", "Firma", "required|trim");
        $this->form_validation->set_rules("name", "Ad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("surname", "Soyad", "callback_name_control|min_length[3]|required|trim");
        $this->form_validation->set_rules("email", "E-Posta", "valid_email|required|trim");
        $this->form_validation->set_rules("password", "Şifre", "trim|min_length[8]");
        if (!empty($this->input->post("password"))) {
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

            if ($current_role == $income_role) {
                $permissions = json_encode($this->input->post("permissions"));
            } else {
                $permissions = user_role_permissions($this->input->post("user_role"));
            }

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


            $viewData = new stdClass();

            /** Tablodan Verilerin Getirilmesi.. */
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all();
            $user_roles = $this->User_role_model->get_all(
                array(
                    "isActive" => 1
                )
            );

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->settings = $settings;
            $viewData->companys = $companys;
            $viewData->user_roles = $user_roles;
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

    public function refresh_file_list($id, $from)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$from";


        $viewData->item_files = $this->User_model->get_all(
            array(
                "id" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

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


}
