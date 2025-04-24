<?php
class company extends CI_Controller
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
        $this->viewFolder = "company_v";
        $this->load->model("company_model");
        $this->load->model("Settings_model");
        $this->load->model("Project_model");
        $this->load->model("Contract_model");
        
        $this->load->model("City_model");
        $this->load->model("User_model");
        $this->Module_Name = "company";
        $this->Module_Title = "Firma";
        // Folder Structure
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "companys_v";
        $this->Module_Depended_Dir = "companys";
        $this->Module_File_Dir = "system_companys";
        $this->Module_Table = "system_companys";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir/$this->Module_File_Dir";
        // Folder Structure
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "company_id";
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
        
        $companys = $this->company_model->get_all(array());
        $contracts = $this->Contract_model->get_all(array());
        $settings = $this->Settings_model->get();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->settings = $settings;
        $viewData->contracts = $contracts;
        $viewData->companys = $companys;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function new_form()
    {
        $viewData = new stdClass();
        $settings = $this->Settings_model->get();
        $cities = $this->City_model->get_all(array());
        $items = $this->company_model->get_all();
        
        $viewData->settings = $settings;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->items = $items;
        $viewData->cities = $cities;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function file_form($id)
    {
        $viewData = new stdClass();
        $this->load->library('encryption');
        $contracts = $this->Contract_model->get_all(array());
        
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->contracts = $contracts;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->item = $this->company_model->get(
            array(
                "id" => $id
            )
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function update_form($id)
    {
        $viewData = new stdClass();
        $settings = $this->Settings_model->get();
        $cities = $this->City_model->get_all(array());
        $executive_users = $this->User_model->get_all(array());
        
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->settings = $settings;
        $viewData->cities = $cities;
        $viewData->executive_users = $executive_users;
        $viewData->item = $this->company_model->get(
            array(
                "id" => $id
            )
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function save()
    {
        $this->load->library("form_validation");
        $name = mb_convert_case($this->input->post("company_name"), MB_CASE_TITLE, "UTF-8");
        if ($this->input->post("company_role") == "Kullanıcı Firma"){
            $employer = 1;
        } else {
            $employer = null;
        }
        $insert = $this->company_model->add(
            array(
                "company_role" => $this->input->post("company_role"),
                "profession" => $this->input->post("profession"),
                "company_name" => $name,
                "employer" => $employer,
                "tax_city" => $this->input->post("tax_city"),
                "tax_office" => $this->input->post("tax_office"),
                "tax_no" => $this->input->post("tax_no"),
                "adress" => $this->input->post("adress"),
                "adress_city" => $this->input->post("adress_city"),
                "adress_district" => $this->input->post("adress_district"),
                "email" => $this->input->post("email"),
                "phone" => $this->input->post("phone"),
                "email_2" => $this->input->post("email_2"),
                "executive" => $this->input->post("executive"),
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
        redirect(base_url("$this->Module_Name/index"));
    }
    public
    function update($id)
    {
        $this->load->library('encryption');
        $this->load->library("form_validation");
        if (empty($this->input->post("password"))) {
            $current_password = $this->encryption->decrypt(get_from_any("companys", "password", "id", $id));
        } else {
            $current_password = $this->input->post("password");
        }
        $current_company_name = get_from_any("companys", "company_name", "id", $id);
        $income_company_name = $this->input->post("company_name");
        $current_tax_no = get_from_any("companys", "tax_no", "id", $id);
        $income_tax_no = $this->input->post("tax_no");
        if ($current_company_name != $income_company_name) {
            $this->form_validation->set_rules("company_name", "Firma Adı", "is_unique[companys.company_name]|min_length[3]|required|trim");
        }
        $this->form_validation->set_rules("company_role", "Firma Rolü", "required|trim");
        $this->form_validation->set_rules("profession", "Faaliyet Alanı", "required|trim");
        $this->form_validation->set_rules("tax_city", "Vergi Daire İl", "trim");
        $this->form_validation->set_rules("tax_office", "Vergi Dairesi", "trim");
        if ($current_tax_no != $income_tax_no) {
            $this->form_validation->set_rules("tax_no", "Vergi No", "max_length[11]|min_length[10]|is_unique[companys.tax_no]|trim|numeric");
        }
        $this->form_validation->set_rules("adress", "Adres", "trim");
        $this->form_validation->set_rules("adress_city", "Şehir", "trim");
        $this->form_validation->set_rules("adress_district", "İlçe", "trim");
        $this->form_validation->set_rules("phone", "Telefon Numarası ", "regex_match[/^[0-9]{10}$/]"); //{10} for 10 digits number
        if (!empty($this->input->post("password"))) {
            $this->form_validation->set_rules("IBAN", "IBAN ", "exact_length[26]|numeric"); //{10} for 10 digits number
        }
        $this->form_validation->set_rules("email", "E-Posta", "valid_email|trim");
        $this->form_validation->set_rules("email2", "E-Posta", "valid_email|trim");
        $this->form_validation->set_rules("password", "Şifre", "trim|min_length[6]");
        if (!empty($this->input->post("password"))) {
            $this->form_validation->set_rules("password_check", "Şifre Kontrol", "matches[password]|required|trim");
        }
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "regex_match" => "<b>{field}</b> 10 haneli olarak, sayılardan oluşmalıdır",
                "is_unique" => "<b>{field}</b> kaydı mevcut",
                "min_length" => "<b>{field}</b> en az {param} karakter uzunluğunda olmalıdır",
                "max_length" => "<b>{field}</b> en çok {param} karakter uzunluğunda olmalıdır",
                "full_name" => "<b>{field}</b> Ad Soyad Bilgilerini Eksiksiz Giriniz",
                "matches" => "<b>{field}</b> Şifreleriniz Eşleşmiyor",
                "valid_email" => "<b>{field}</b> Geçerli bir E-Posta adresi giriniz",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            $update = $this->company_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "company_role" => $this->input->post("company_role"),
                    "profession" => $this->input->post("profession"),
                    "company_name" => $income_company_name,
                    "tax_city" => $this->input->post("tax_city"),
                    "tax_office" => $this->input->post("tax_office"),
                    "tax_no" => $this->input->post("tax_no"),
                    "adress" => $this->input->post("adress"),
                    "adress_city" => $this->input->post("adress_city"),
                    "adress_district" => $this->input->post("adress_district"),
                    "bank" => $this->input->post("bank"),
                    "IBAN" => $this->input->post("IBAN"),
                    "email" => $this->input->post("email"),
                    "email_2" => $this->input->post("email_2"),
                    "phone" => $this->input->post("phone"),
                    "executive" => $this->input->post("executive"),
                    "password" => $this->encryption->encrypt($current_password),
                    "isActive" => "1",
                    "createdAt" => date("Y-m-d H:i:s")
                )
            );
            
            redirect(base_url("$this->Module_Name/$this->Display_route/$id"));
        } else {
            $viewData = new stdClass();
            $item = $this->company_model->get(
                array(
                    "id" => $id,
                )
            );
            $settings = $this->Settings_model->get();
            $cities = $this->City_model->get_all(array());
            $viewData->item = $this->company_model->get(
                array(
                    "id" => $id
                )
            );
            $executive_users = $this->User_model->get_all(array());
            
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->settings = $settings;
            $viewData->cities = $cities;
            $viewData->executive_users = $executive_users;
            $viewData->form_error = true;
            $viewData->item = $item;
            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }
    public
    function delete($id)
    {
        $path = "$this->File_Dir_Prefix/$id";
        $sil = deleteDirectory($path);
        $delete = $this->company_model->delete(
            array(
                "id" => $id
            )
        );
        
        
        redirect(base_url("$this->Module_Name/index"));
    }
    public
    function file_upload($id)
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
    public
    function fileDelete($id, $from)
    {
        $dir_files = directory_map("$this->File_Dir_Prefix/$id");
        foreach ($dir_files as $dir_file) {
            unlink("$this->File_Dir_Prefix/$id/$dir_file");
        }
        redirect(base_url("$this->Module_Name/$from/$id"));
    }
    public
    function delete_avatar($id)
    {
        $dir_files = directory_map("$this->File_Dir_Prefix/$id");
        foreach ($dir_files as $dir_file) {
            unlink("$this->File_Dir_Prefix/$id/$dir_file");
        }
        $viewData = new stdClass();
        
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $this->company_model->get(
            array(
                "id" => $id
            )
        );
        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/avatar", $viewData, true);
        echo $render_html;
    }
    public
    function duplicate_name_check($file_name)
    {
        $var = count_data("companys", "company_name", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public
    function charset_control($company_name)
    {
        if (strlen($company_name) - strcspn($company_name, "\"\\?*:/@|< -çÇğĞüÜöÖıİşŞ.!'?*|=()[]{}>")) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public
    function isActiveSetter($id)
    {
        if ($id) {
            $isActive = ($this->input->post("data") === "true") ? 1 : 0;
            $this->company_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "isActive" => $isActive
                )
            );
        }
    }
    public
    function get_district($id)
    {
        $result = $this->db->where("city_id", $id)->get("district")->result();
        echo json_encode($result);
    }
    public
    function get_tax_office($id)
    {
        $result = $this->db->where("city_id", $id)->get("tax_office")->result();
        echo json_encode($result);
    }
}
