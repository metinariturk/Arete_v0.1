<?php

class vehicle extends CI_Controller
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

        $this->moduleFolder = "vehicle_module";
        $this->viewFolder = "vehicle_v";
        $this->load->model("Vehicle_model");
        $this->load->model("Vehicle_file_model");
        $this->load->model("Settings_model");
        $this->load->model("Project_model");
        $this->load->model("Order_model");
        $this->load->model("City_model");
        $this->load->model("Insurance_model");
        $this->load->model("Rent_model");
        $this->load->model("Service_model");
        $this->load->model("Company_model");
        $this->load->model("Fuel_model");

        $this->Module_Name = "vehicle";
        $this->Module_Title = "Yapı Araçları";

        // Folder Structure
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "vehicle_v";
        $this->Module_Depended_Dir = "vehicles";
        $this->Module_Table = "vehicle";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        // Folder Structure

        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "vehicle_id";
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

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Vehicle_model->get_all(array());

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form()
    {

        $viewData = new stdClass();
        $settings = $this->Settings_model->get();
        $cities = $this->City_model->get_all(array());
        $companys = $this->Company_model->get_all(array());


        $items = $this->Vehicle_model->get_all();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->settings = $settings;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->items = $items;
        $viewData->cities = $cities;
        $viewData->companys = $companys;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {

        $viewData = new stdClass();
        $active_projects = $this->Project_model->get_all(array(
            "durumu" => default_table()
        ));
        $other_projects = $this->Project_model->get_all(array(
            "durumu !=" => default_table()
        ));
        $insurances = $this->Insurance_model->get_all(array(
            'kapsam' => 1,
            'vehicle_id' => $id
        ));
        $kaskolar = $this->Insurance_model->get_all(array(
            'kapsam' => 2,
            'vehicle_id' => $id
        ));
        $rents = $this->Rent_model->get_all(array(
            "isActive" => "1",
            'vehicle_id' => $id
        ));
        $services = $this->Service_model->get_all(array("vehicle_id => $id"));
        $fuels = $this->Fuel_model->get_all(array(
            'vehicle_id' => $id
        ));


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->active_projects = $active_projects;
        $viewData->other_projects = $other_projects;
        $viewData->kaskolar = $kaskolar;
        $viewData->insurances = $insurances;
        $viewData->rents = $rents;
        $viewData->services = $services;
        $viewData->fuels = $fuels;


        $viewData->item_files = $this->Vehicle_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );

        $viewData->subViewFolder = "$this->Display_Folder";

        $viewData->item = $this->Vehicle_model->get(
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
        $companys = $this->Company_model->get_all(array());


        $items = $this->Vehicle_model->get_all();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->settings = $settings;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->items = $items;
        $viewData->cities = $cities;
        $viewData->companys = $companys;

        $viewData->item = $this->Vehicle_model->get(
            array(
                "id" => $id
            )
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function save()
    {
        $this->load->library("form_validation");

        $plaka = mb_strtoupper($this->input->post("plaka"), "UTF-8");

        $this->form_validation->set_rules("plaka", "Araç Plakası", "required|trim|min_length[6]|callback_charset_control|is_unique[vehicle.plaka]");
        $this->form_validation->set_rules("marka", "Marka", "required|trim");
        $this->form_validation->set_rules("motor_no", "Motor No", "is_unique[vehicle.motor_no]|required|trim");
        $this->form_validation->set_rules("model", "Model Yılı", "required|trim");
        $this->form_validation->set_rules("ticari_ad", "Ticari Ad", "trim");
        $this->form_validation->set_rules("sase_no", "Şase No", "is_unique[vehicle.sase_no]|required|trim");
        if ($this->input->post("vergi_no") != 0) {
            $this->form_validation->set_rules("vergi_no", "Vergi No/TC No", "integer|min_length[10]|trim");
        }
        $this->form_validation->set_rules("sahibi", "Sahibi", "integer|trim");
        $this->form_validation->set_rules("ilk_tescil", "İlk Tescil Tarihi", "trim");
        $this->form_validation->set_rules("tipi", "Tipi", "trim");
        $this->form_validation->set_rules("tescil_tarih", "Tescil Tarihi", "trim");
        $this->form_validation->set_rules("tescil_no", "Tescil No", "trim");
        $this->form_validation->set_rules("sinif", "Sınıf", "trim");
        $this->form_validation->set_rules("cins", "Cins", "trim");
        $this->form_validation->set_rules("renk", "Renk", "trim");
        $this->form_validation->set_rules("amac", "Amaç", "trim");
        $this->form_validation->set_rules("adress_city", "Şehir", "trim");
        $this->form_validation->set_rules("adress_district", "İlçe", "trim");
        $this->form_validation->set_rules("yakit", "Yakıt", "required|trim");
        $this->form_validation->set_rules("yakit_takip", "Yakıt Takip Kriteri", "required|trim");

        if ($this->input->post("km") == null and $this->input->post("saat") == null) {
            $this->form_validation->set_rules("km", "Kilometre veye Saat", "required|trim");
            $this->form_validation->set_rules("saat", "Saat veya Kilometre", "required|trim");
        }


        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "is_unique" => "<b>{field}</b> daha önce kullanılmış",
                "min_length" => "<b>{field}</b> en az {param} karakter uzunluğunda olmalıdır",
                "charset_control" => "<b>{field}</b> $plaka Plaka Geçersiz Karakter İçeriyor",
                "name_control" => "<b>{field}</b> Geçersiz Karakter İçeriyor",
                "full_name" => "<b>{field}</b> Ad Soyad Bilgilerini Eksiksiz Giriniz",
                "matches" => "<b>{field}</b> Şifreleriniz Eşleşmiyor",
                "valid_email" => "<b>{field}</b> Geçerli bir E-Posta adresi giriniz",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("ilk_tescil")) {
                $ilk_tescil = dateFormat('Y-m-d', $this->input->post("ilk_tescil"));
            } else {
                $ilk_tescil = null;
            }

            if ($this->input->post("tescil_tarih")) {
                $tescil_tarih = dateFormat('Y-m-d', $this->input->post("tescil_tarih"));
            } else {
                $tescil_tarih = null;
            }

            if ($this->input->post("kiralik") == "on") {
                $kiralik = "1";
            } else {
                $kiralik = "0";
            }

            $insert = $this->Vehicle_model->add(
                array(
                    "plaka" => $plaka,
                    "motor_no" => $this->input->post("motor_no"),
                    "sase_no" => $this->input->post("sase_no"),
                    "model" => $this->input->post("model"),
                    "marka" => strtoupper($this->input->post("marka")),
                    "tipi" => yazim_duzeni($this->input->post("tipi")),

                    "ilk_tescil" => $ilk_tescil,
                    "tescil_tarih" => $tescil_tarih,
                    "tescil_no" => $this->input->post("tescil_no"),
                    "ticari_ad" => yazim_duzeni($this->input->post("ticari_ad")),
                    "sinif" => yazim_duzeni($this->input->post("sinif")),
                    "cins" => yazim_duzeni($this->input->post("cins")),
                    "renk" => yazim_duzeni($this->input->post("renk")),
                    "amac" => yazim_duzeni($this->input->post("amac")),
                    "vergi_no" => $this->input->post("vergi_no"),
                    "sahibi" => $this->input->post("sahibi"),
                    "adress_city" => $this->input->post("adress_city"),
                    "adress_district" => $this->input->post("adress_district"),

                    "kiralik" => $kiralik,
                    "yakit" => $this->input->post("yakit"),
                    "yakit_takip" => $this->input->post("yakit_takip"),
                    "km" => $this->input->post("km"),
                    "saat" => $this->input->post("saat"),
                    "isActive" => "1",
                    "createdAt" => date("Y-m-d H:i:s")
                )
            );

            $record_id = $this->db->insert_id();
            $path = "$this->File_Dir_Prefix/$record_id/ruhsat";
            $path2 = "$this->File_Dir_Prefix/$record_id/avatar";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                mkdir("$path2", 0777, TRUE);
                echo "Dosya Yolu Oluşturuldu: " . $path;
            } else {
                echo "<p>Aynı İsimde Dosya Mevcut: " . $path . "</p>";
                echo "<p>Aynı İsimde Dosya Mevcut: " . $path2 . "</p>";
            }


            if ($insert) {

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "$plaka - Plakalı araç başarılı bir şekilde eklendi",
                    "type" => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "$plaka - Plakalı araç ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }

            // İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));
        } else {


            $viewData = new stdClass();

            $companys = $this->Company_model->get_all(array());
            $cities = $this->City_model->get_all(array());


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->companys = $companys;
            $viewData->cities = $cities;


            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form verilerinde hata mevcut",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update($id)
    {

        $this->load->library("form_validation");

        $plaka = mb_strtoupper($this->input->post("plaka"), "UTF-8");

        $this->form_validation->set_rules("plaka", "Araç Plakası", "required|trim|min_length[6]|callback_charset_control|callback_plaka_check[$id]");
        $this->form_validation->set_rules("marka", "Marka", "required|trim");
        $this->form_validation->set_rules("motor_no", "Motor No", "callback_motor_check[$id]|required|trim");
        $this->form_validation->set_rules("model", "Model Yılı", "required|trim");
        $this->form_validation->set_rules("ticari_ad", "Ticari Ad", "trim");
        $this->form_validation->set_rules("sase_no", "Şase No", "callback_sase_check[$id]|required|trim");
        if ($this->input->post("vergi_no") != 0) {
            $this->form_validation->set_rules("vergi_no", "Vergi No/TC No", "integer|min_length[10]|trim");
        }
        $this->form_validation->set_rules("sahibi", "Sahibi", "integer|trim");
        $this->form_validation->set_rules("ilk_tescil", "İlk Tescil Tarihi", "trim");
        $this->form_validation->set_rules("tipi", "Tipi", "trim");
        $this->form_validation->set_rules("tescil_tarih", "Tescil Tarihi", "trim");
        $this->form_validation->set_rules("tescil_no", "Tescil No", "trim");
        $this->form_validation->set_rules("sinif", "Sınıf", "trim");
        $this->form_validation->set_rules("cins", "Cins", "trim");
        $this->form_validation->set_rules("renk", "Renk", "trim");
        $this->form_validation->set_rules("amac", "Amaç", "trim");
        $this->form_validation->set_rules("adress_city", "Şehir", "trim");
        $this->form_validation->set_rules("adress_district", "İlçe", "trim");
        $this->form_validation->set_rules("yakit", "Yakıt", "required|trim");
        $this->form_validation->set_rules("yakit_takip", "Yakıt Takip Kriteri", "required|trim");

        if ($this->input->post("km") == null and $this->input->post("saat") == null) {
            $this->form_validation->set_rules("km", "Kilometre veye Saat", "required|trim");
            $this->form_validation->set_rules("saat", "Saat veya Kilometre", "required|trim");
        }


        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "is_unique" => "<b>{field}</b> daha önce kullanılmış",
                "min_length" => "<b>{field}</b> en az {param} karakter uzunluğunda olmalıdır",
                "plaka_check" => "<b>{field}</b> $plaka plakalı aracın kaydı mevcut",
                "motor_check" => "<b>{field}</b> motor numarası daha önce kullanılmış",
                "sase_check" => "<b>{field}</b> şase numarası daha önce kullanılmış",
                "charset_control" => "<b>{field}</b> $plaka Plaka Geçersiz Karakter İçeriyor",
                "name_control" => "<b>{field}</b> Geçersiz Karakter İçeriyor",
                "full_name" => "<b>{field}</b> Ad Soyad Bilgilerini Eksiksiz Giriniz",
                "matches" => "<b>{field}</b> Şifreleriniz Eşleşmiyor",
                "valid_email" => "<b>{field}</b> Geçerli bir E-Posta adresi giriniz",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("ilk_tescil")) {
                $ilk_tescil = dateFormat('Y-m-d', $this->input->post("ilk_tescil"));
            } else {
                $ilk_tescil = null;
            }

            if ($this->input->post("tescil_tarih")) {
                $tescil_tarih = dateFormat('Y-m-d', $this->input->post("tescil_tarih"));
            } else {
                $tescil_tarih = null;
            }

            if ($this->input->post("kiralik") == "on") {
                $kiralik = "1";
            } else {
                $kiralik = "0";
            }

            $update = $this->Vehicle_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "plaka" => $plaka,
                    "motor_no" => $this->input->post("motor_no"),
                    "sase_no" => $this->input->post("sase_no"),
                    "model" => $this->input->post("model"),
                    "marka" => strtoupper($this->input->post("marka")),
                    "tipi" => yazim_duzeni($this->input->post("tipi")),

                    "ilk_tescil" => $ilk_tescil,
                    "tescil_tarih" => $tescil_tarih,
                    "tescil_no" => $this->input->post("tescil_no"),
                    "ticari_ad" => yazim_duzeni($this->input->post("ticari_ad")),
                    "sinif" => yazim_duzeni($this->input->post("sinif")),
                    "cins" => yazim_duzeni($this->input->post("cins")),
                    "renk" => yazim_duzeni($this->input->post("renk")),
                    "amac" => yazim_duzeni($this->input->post("amac")),
                    "vergi_no" => $this->input->post("vergi_no"),
                    "sahibi" => $this->input->post("sahibi"),
                    "adress_city" => $this->input->post("adress_city"),
                    "adress_district" => $this->input->post("adress_district"),

                    "kiralik" => $kiralik,
                    "yakit" => $this->input->post("yakit"),
                    "yakit_takip" => $this->input->post("yakit_takip"),
                    "km" => $this->input->post("km"),
                    "saat" => $this->input->post("saat"),
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
            $item = $this->Vehicle_model->get(
                array(
                    "id" => $id,
                )
            );

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form verilerinde hata mevcut",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);
            $companys = $this->Company_model->get_all(array());
            $cities = $this->City_model->get_all(array());


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->form_error = true;
            $viewData->item = $item;
            $viewData->companys = $companys;
            $viewData->cities = $cities;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {

        $path = "$this->File_Dir_Prefix/$id";
        echo $path;

        $sil = deleteDirectory($path);

        $delete = $this->Vehicle_model->delete(
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

    public function avatar_upload($id)
    {
        $avatar = get_from_any("vehicle", "avatar", "id", $id);
        if (!empty($avatar)) {
            echo $avatar;
            echo "dosya var işlem yapılmaz";
        } else {
            $file_name = "avatar";

            $config["allowed_types"] = "*";
            $config["upload_path"] = "$this->File_Dir_Prefix/$id/avatar";
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
    }

    public function ruhsat_upload($id)
    {
                $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$id/ruhsat/";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Vehicle_file_model->add(
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

    public function refresh_file_list($id, $from)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$from";

        $viewData->item_files = $this->Vehicle_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/ruhsat_list_v", $viewData, true);

        echo $render_html;

    }

    public function avatarDelete($id, $from)
    {

        $dir_files = directory_map("$this->File_Dir_Prefix/$id/avatar");

        foreach ($dir_files as $dir_file) {
            unlink("$this->File_Dir_Prefix/$id/avatar/$dir_file");
        }

        redirect(base_url("$this->Module_Name/$from/$id"));

    }

    public function fileDelete($id, $from)
    {

        $fileName = $this->Vehicle_file_model->get(
            array(
                "id" => $id
            )
        );


        $delete = $this->Vehicle_file_model->delete(
            array(
                "id" => $id
            )
        );

        if ($delete) {

            $path = "$this->File_Dir_Prefix/$id/ruhsat/$fileName->img_url";

            unlink($path);

            redirect(base_url("$this->Module_Name/$from/$fileName->vehicle_id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$fileName->vehicle_id"));

        }

    }

    public function fileDelete_all($id, $from)
    {

        $delete = $this->Vehicle_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->File_Dir_Prefix/$id/ruhsat");

            foreach ($dir_files as $dir_file) {
                unlink("$this->File_Dir_Prefix/$id/ruhsat/$dir_file");
            }

            redirect(base_url("$this->Module_Name/$from/$id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$id"));

        }

    }

    public function file_download($id, $from)
    {
        $fileName = $this->Vehicle_file_model->get(
            array(
                "id" => $id
            )
        );


        $vehicle_id = get_from_any("vehicle_files", "vehicle_id", "id", $id);

        $file_path = "$this->File_Dir_Prefix/$vehicle_id/ruhsat/$fileName->img_url";

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

    public function plaka_check($plaka, $id)
    {
        $old = get_from_any("vehicle", "plaka", "id", "$id");
        if ($old != $plaka) {
            $var = count_data("vehicle", "plaka", $plaka);
            if (($var > 0)) {
                return FALSE;
            } else {
                return TRUE;
            }
            die();
        } elseif ($old == $plaka) {
            return TRUE;
        }

    }

    public function motor_check($motor_no, $id)
    {
        $old = get_from_any("vehicle", "motor_no", "id", "$id");
        if ($old != $motor_no) {
            $var = count_data("vehicle", "motor_no", $motor_no);
            if (($var > 0)) {
                return FALSE;
            } else {
                return TRUE;
            }
            die();
        } elseif ($old == $motor_no) {
            return TRUE;
        }
    }

    public function sase_check($sase_no, $id)
    {
        $old = get_from_any("vehicle", "sase_no", "id", "$id");
        if ($old != $sase_no) {
            $var = count_data("vehicle", "sase_no", $sase_no);
            if (($var > 0)) {
                return FALSE;
            } else {
                return TRUE;
            }
            die();
        } elseif ($old == $sase_no) {
            return TRUE;
        }
    }

    public function charset_control($vehicle_plate)
    {
        if (strlen($vehicle_plate) - strcspn($vehicle_plate, "\"\\?*:/@|<-çÇğĞüÜöÖıİşŞ.!'?*|=()[]{}>")) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function name_control($vehicle_plate)
    {
        return (!preg_match("/^([-a-z üğışçöÜĞİŞÇÖ])+$/i", $vehicle_plate)) ? FALSE : TRUE;
    }

    public function get_district($id)
    {
        $result = $this->db->where("city_id", $id)->get("district")->result();
        echo json_encode($result);
    }
}
