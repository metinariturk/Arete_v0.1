<?php

class Service extends CI_Controller
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

        $this->moduleFolder = "vehicle_module";
        $this->viewFolder = "service_v";
        $this->load->model("Service_model");
        $this->load->model("Service_file_model");

        $this->load->model("Vehicle_model");
        $this->load->model("Settings_model");
        $this->load->model("Company_model");

        $this->Module_Name = "service";
        $this->Module_Title = "Servis/Bakım";

        // Folder Structure
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "vehicle_v";
        $this->Module_Depended_Dir = "vehicle";
        $this->Module_File_Dir = "service";
        $this->Module_Table = "service";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir";
        // Folder Structure

        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "service_id";
        //Folder Structure
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";

        $this->File_List = "file_list_v";
        $this->Common_Files = "common";
        $module_unique_name = module_name($this->Module_Name);
    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Service_model->get_all(array());
        $vehicles = $this->Vehicle_model->get_all(array());

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->vehicles = $vehicles;        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($vehicle_id = null)
    {

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Service_model->get_all(array());
        $vehicles = $this->Vehicle_model->get_all(array());
        $employers = $this->Company_model->get_all(array(

            ));
        $not_employers = $this->Company_model->get_all(array(
            "employer !=" =>1
        ));
        $settings = $this->Settings_model->get();



        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->vehicles = $vehicles;
        $viewData->settings = $settings;
        $viewData->employers = $employers;
        $viewData->not_employers = $not_employers;
        $viewData->vehicle_id = $vehicle_id;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->item = $this->Service_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Service_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {

        $viewData = new stdClass();
        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->settings = $settings;

        $viewData->item = $this->Service_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Service_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function save($vehicle_id = null)
    {

        if ($vehicle_id==null){
            $vehicle_id = $this->input->post("vehicle_id");
        }

        $this->load->library("form_validation");

        $this->form_validation->set_rules("vehicle_id", "Araç ID", "integer|required|trim");
        $this->form_validation->set_rules("gerekce", "Servis/Bakım Türü", "integer|required|trim");
        $this->form_validation->set_rules("servis_tarih", "Servis/Bakım Tarihi", "required|trim"); //2
        $this->form_validation->set_rules("servis_km_saat", "Servis/Bakım Saat veya Kilometre Bilgisi", "integer|required|trim"); //2
        $this->form_validation->set_rules("km_saat", "Saat veya Kilometre Bilgisi", "integer|required|trim"); //2
        $this->form_validation->set_rules("islem_turu", "Gerekçe", "required|trim"); //2
        $this->form_validation->set_rules("servis_firma", "Servis Sağlayan Firma", "integer|required|trim"); //2
        $this->form_validation->set_rules("genel_bilgi", "Genel Açıklama", "required|trim"); //2
        $this->form_validation->set_rules("fiyat", "KDV Dahil Bedel", "required|trim"); //2

        $this->form_validation->set_message(
            array(
                "required"  => "<b>{field}</b> alanı doldurulmalıdır",
                "integer"  => "<b>{field}</b> alanı tam sayı olmalıdır.",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {


            $path = "$this->File_Dir_Prefix/$vehicle_id/servis";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "Dosya Yolu Oluşturuldu: ". $path;
            } else {
                echo "<p>Aynı İsimde Dosya Mevcut: ". $path."</p>";
            }

            if (!empty($this->input->post("servis_tarih"))) {
                $servis_tarih = dateFormat('Y-m-d', $this->input->post("servis_tarih"));
            } else {
                $servis_tarih = null;
            }



            $insert = $this->Service_model->add(
                array(
                    "vehicle_id"        => $vehicle_id,
                    "gerekce"           => $this->input->post("gerekce"),
                    "servis_tarih"      => $servis_tarih,
                    "servis_km_saat"    => $this->input->post("servis_km_saat"),
                    "km_saat"           => $this->input->post("km_saat"),
                    "islem_turu"       => $this->input->post("islem_turu"),
                    "servis_firma"      => $this->input->post("servis_firma"),
                    "genel_bilgi"       => $this->input->post("genel_bilgi"),
                    "fiyat"             => $this->input->post("fiyat"),
                    "createdAt"         => date("Y-m-d H:i:s"),
                )
            );

            $record_id = $this->db->insert_id();

            // TODO Alert sistemi eklenecek...
            if ($insert) {

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Servis/Bakım bilgileri başarılı bir şekilde eklendi",
                    "type" => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Servis/Bakım bilgileri ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }

            // İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));

            //kaydedilen elemanın id nosunu döküman ekleme sayfasına post ediyoruz


        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Servis/Bakım bilgileri ekleme formunda hata var",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);

    
        $viewData = new stdClass();
            $vehicles = $this->Vehicle_model->get_all(array());
            $settings = $this->Settings_model->get();
            $employers = $this->Company_model->get_all(array(

            ));
            $not_employers = $this->Company_model->get_all(array(
            "employer !=" =>1
        ));

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->vehicle_id = $vehicle_id;
            $viewData->vehicles = $vehicles;
            $viewData->settings = $settings;
            $viewData->employers = $employers;
            $viewData->not_employers = $not_employers;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update($id)
    {

        $vehicle_id = $this->input->post("vehicle_id");

        $this->load->library("form_validation");

        $this->form_validation->set_rules("gerekce", "Servis/Bakım Türü", "integer|required|trim");
        $this->form_validation->set_rules("servis_tarih", "Servis/Bakım Tarihi", "required|trim"); //2
        $this->form_validation->set_rules("servis_km_saat", "Servis/Bakım Saat veya Kilometre Bilgisi", "integer|required|trim"); //2
        $this->form_validation->set_rules("km_saat", "Saat veya Kilometre Bilgisi", "integer|required|trim"); //2
        $this->form_validation->set_rules("islem_turu", "Gerekçe", "required|trim"); //2
        $this->form_validation->set_rules("servis_firma", "Servis Sağlayan Firma", "integer|required|trim"); //2
        $this->form_validation->set_rules("genel_bilgi", "Genel Açıklama", "required|trim"); //2
        $this->form_validation->set_rules("fiyat", "KDV Dahil Bedel", "required|trim"); //2

        $this->form_validation->set_message(
            array(
                "required"  => "<b>{field}</b> alanı doldurulmalıdır",
                "integer"  => "<b>{field}</b> alanı tam sayı olmalıdır.",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            if (!empty($this->input->post("servis_tarih"))) {
                $servis_tarih = dateFormat('Y-m-d', $this->input->post("servis_tarih"));
            } else {
                $servis_tarih = null;
            }


            $update = $this->Service_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "gerekce"           => $this->input->post("gerekce"),
                    "servis_tarih"      => $servis_tarih,
                    "servis_km_saat"    => $this->input->post("servis_km_saat"),
                    "km_saat"           => $this->input->post("km_saat"),
                    "islem_turu"       => $this->input->post("islem_turu"),
                    "servis_firma"      => $this->input->post("servis_firma"),
                    "genel_bilgi"       => $this->input->post("genel_bilgi"),
                    "fiyat"             => $this->input->post("fiyat"),
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
                    "title" => "İşlem Başarılı",
                    "text" => "Güncelleme sırasında bir problem oluştu",
                    "type" => "danger"
                );


            }

            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$id"));

        } else {

            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Form Bilgilerini kontrol ediniz",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);

    
        $viewData = new stdClass();


            $vehicles = $this->Vehicle_model->get_all(array());
            $settings = $this->Settings_model->get();
            $not_employers = $this->Company_model->get_all(array(
            "employer !=" =>1
        ));

            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Service_model->get(
                array(
                    "id" => $id,
                )
            );

            $viewData->item_files = $this->Service_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                ),
            );

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->form_error = true;
            $viewData->item = $item;
             $viewData->vehicles = $vehicles;
            $viewData->settings = $settings;
            $viewData->not_employers = $not_employers;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function delete($id)
    {

        $vehicle_id = get_from_id($this->Module_Table, "vehicle_id",$id);

        $path = "$this->File_Dir_Prefix/$vehicle_id/servis/" ;

        $sil = deleteDirectory($path);

        $delete1 = $this->Service_file_model->delete(
            array(
                "$this->Dependet_id_key"    => $id
            )
        );
        $delete2 = $this->Service_model->delete(
            array(
                "id" => $id
            )
        );

        // TODO Alert Sistemi Eklenecek...
        if ($delete1 and $delete2) {
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "$module_unique_name başarılı bir şekilde silindi",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "$module_unique_name silme sırasında bir problem oluştu",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$vehicle_id"));
    }

    public function file_upload($id, $vehicle_id)
    {

                $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$vehicle_id/servis/";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Service_file_model->add(
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
            echo  $config["upload_path"];
        }

    }

    public function file_download($id, $from)
    {
        $fileName = $this->Service_file_model->get(
            array(
                "id"    => $id
            )
        );


        $service_id = get_from_id("service_files","service_id", $id);
        $vehicle_id = get_from_id("service","vehicle_id", $service_id);


        $file_path = "$this->File_Dir_Prefix/$vehicle_id/servis/$fileName->img_url";

        if ($file_path) {

            if (file_exists($file_path)) {
                $data = file_get_contents($file_path);
                force_download($fileName->img_url, $data); }
                 else {
                echo "Dosya veritabanında var ancak klasör içinden silinmiş, SİSTEM YÖNETİCİNİZE BAŞVURUN";
            }
        }
        else {
            echo "Dosya Yok";
        }

    }

    public function refresh_file_list($id, $from)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$from";


        $viewData->item_files = $this->Service_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id, $from){

        $fileName = $this->Service_file_model->get(
            array(
                "id"    => $id
            )
        );


        $service_id = get_from_id("service_files","service_id", $id);
        $vehicle_id = get_from_id("service","vehicle_id", $service_id);

        $delete = $this->Service_file_model->delete(
            array(
                "id"    => $id
            )
        );

        if($delete){

            $path = "$this->File_Dir_Prefix/$vehicle_id/servis/$fileName->img_url";

            unlink($path);

            redirect(base_url("$this->Module_Name/$from/$service_id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$service_id"));

        }

    }

    public function fileDelete_all($id, $from){

        echo $vehicle_id = get_from_id("service", "vehicle_id",$id);


        $delete = $this->Service_file_model->delete(
            array(
                "$this->Dependet_id_key"    => $id
            )
        );

        if($delete){

            $dir_files = directory_map("$this->File_Dir_Prefix/$vehicle_id/servis");

            foreach($dir_files as $dir_file){
                unlink("$this->File_Dir_Prefix/$vehicle_id/servis/$dir_file");
            }

            redirect(base_url("$this->Module_Name/$from/$id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$id"));

        }

    }

}
