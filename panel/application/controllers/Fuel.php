<?php

class Fuel extends CI_Controller
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
        $this->viewFolder = "fuel_v";
        $this->load->model("Fuel_model");
        $this->load->model("Fuel_file_model");

        $this->load->model("Vehicle_model");
        $this->load->model("Settings_model");

        $this->Module_Name = "Fuel";
        $this->Module_Title = "Yakıt Yönetimi";

        // Folder Structure
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "vehicle_v";
        $this->Module_Depended_Dir = "vehicle";
        $this->Module_File_Dir = "Fuel";
        $this->Module_Table = "Fuel";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir";
        // Folder Structure

        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "fuel_id";
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
        $items = $this->Fuel_model->get_all(array());
        $vehicles = $this->Vehicle_model->get_all(array());

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->vehicles = $vehicles;        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($vehicle_id = null, $kapsam = null)
    {

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Fuel_model->get_all(array());
        $vehicles = $this->Vehicle_model->get_all(array());
        $settings = $this->Settings_model->get();



        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->vehicles = $vehicles;
        $viewData->settings = $settings;
        $viewData->vehicle_id = $vehicle_id;
        $viewData->kapsam = $kapsam;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->item = $this->Fuel_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Fuel_file_model->get_all(
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

        $viewData->item = $this->Fuel_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Fuel_file_model->get_all(
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

        $last_km_saat = get_last_fuel($vehicle_id, "ikmal_km_saat");

        $this->load->library("form_validation");

        $this->form_validation->set_rules("vehicle_id", "Araç ID", "required|trim");
        $this->form_validation->set_rules("ikmal_tarih", "İkmal Tarihi", "required|trim");
        $this->form_validation->set_rules("ikmal_km_saat", "İkmal Anındaki Km ve Saat Bilgisi", "greater_than[$last_km_saat]|is_natural_no_zero|required|trim");
        $this->form_validation->set_rules("km_saat", "Takip Referansı", "is_natural_no_zero|required|trim"); //2
        $this->form_validation->set_rules("fuel_type", "Yakıt Türü", "required|trim"); //2
        $this->form_validation->set_rules("ikmal_miktar", "Dolum Miktarı", "greater_than[0]|numeric|required|trim"); //2
        $this->form_validation->set_rules("ikmal_bf", "Yakıt Birim Fiyatı", "greater_than[0]|numeric|required|trim"); //2
        $this->form_validation->set_rules("ikmal_tutar", "Toplam Tutar", "greater_than[0]|numeric|required|trim"); //2
        $this->form_validation->set_rules("aciklama", "Açıklama", "trim"); //2

        $this->form_validation->set_message(
            array(
                "required"              => "<b>{field}</b> alanı doldurulmalıdır",
                "is_natural_no_zero"    => "<b>{field}</b> alanı tam pozitif sayı olmalıdır.",
                "numeric"               => "<b>{field}</b> alanı bir sayı olmalıdır.",
                "greater_than"          => "<b>{field}</b> {param} değerinden büyük bir sayı olmalıdır.",
                "is_natural_no_zero"    => "<b>{field}</b> değerinden büyük bir sayı olmalıdır.",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$vehicle_id/$this->Module_Name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "Dosya Yolu Oluşturuldu: ". $path;
            } else {
                echo "<p>Aynı İsimde Dosya Mevcut: ". $path."</p>";
            }

            if (!empty($this->input->post("ikmal_tarih"))) {
                $ikmal_tarih = dateFormat('Y-m-d', $this->input->post("ikmal_tarih"));
            } else {
                $ikmal_tarih = null;
            }


            $insert = $this->Fuel_model->add(
                array(
                    "vehicle_id"        => $vehicle_id,
                    "ikmal_tarih"       => $ikmal_tarih,
                    "ikmal_km_saat"     => $this->input->post("ikmal_km_saat"),
                    "km_saat"           => $this->input->post("km_saat"),
                    "fuel_type"         => $this->input->post("fuel_type"),
                    "ikmal_miktar"      => $this->input->post("ikmal_miktar"),
                    "ikmal_bf"          => $this->input->post("ikmal_bf"),
                    "ikmal_tutar"       => $this->input->post("ikmal_tutar"),
                    "aciklama"          => $this->input->post("aciklama"),
                    "ortalama"          => $this->input->post("ortalama"),
                    "createdAt"         => date("Y-m-d H:i:s"),
                )
            );

            $record_id = $this->db->insert_id();

            // TODO Alert sistemi eklenecek...
            if ($insert) {

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Yakıt bilgileri başarılı bir şekilde eklendi",
                    "type" => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Yakıt bilgileri ekleme sırasında bir problem oluştu",
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
                "text" => "Yakıt bilgileri ekleme formunda hata var",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);

    
        $viewData = new stdClass();
            $vehicles = $this->Vehicle_model->get_all(array());
            $settings = $this->Settings_model->get();



            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->vehicle_id = $vehicle_id;
            $viewData->vehicles = $vehicles;
            $viewData->settings = $settings;




            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update($id)
    {

        $this->load->library("form_validation");

        $this->form_validation->set_rules("ikmal_tarih", "İkmal Tarihi", "required|trim");
        $this->form_validation->set_rules("ikmal_km_saat", "İkmal Anındaki Km ve Saat Bilgisi", "is_natural_no_zero|required|trim");
        $this->form_validation->set_rules("km_saat", "Takip Referansı", "is_natural_no_zero|required|trim"); //2
        $this->form_validation->set_rules("fuel_type", "Yakıt Türü", "required|trim"); //2
        $this->form_validation->set_rules("ikmal_miktar", "Dolum Miktarı", "greater_than[0]|numeric|required|trim"); //2
        $this->form_validation->set_rules("ikmal_bf", "Yakıt Birim Fiyatı", "greater_than[0]|numeric|required|trim"); //2
        $this->form_validation->set_rules("ikmal_tutar", "Toplam Tutar", "greater_than[0]|numeric|required|trim"); //2
        $this->form_validation->set_rules("aciklama", "Açıklama", "trim"); //2



        $this->form_validation->set_message(
            array(
                "required"              => "<b>{field}</b> alanı doldurulmalıdır",
                "is_natural_no_zero"    => "<b>{field}</b> alanı tam pozitif sayı olmalıdır.",
                "numeric"               => "<b>{field}</b> alanı bir sayı olmalıdır.",
                "greater_than"          => "<b>{field}</b> {param} değerinden büyük bir sayı olmalıdır.",
                "is_natural_no_zero"    => "<b>{field}</b> değerinden büyük bir sayı olmalıdır.",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            if (!empty($this->input->post("ikmal_tarih"))) {
                $ikmal_tarih = dateFormat('Y-m-d', $this->input->post("ikmal_tarih"));
            } else {
                $ikmal_tarih = null;
            }

            $update = $this->Fuel_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "ikmal_tarih"       => $ikmal_tarih,
                    "ikmal_km_saat"     => $this->input->post("ikmal_km_saat"),
                    "km_saat"           => $this->input->post("km_saat"),
                    "fuel_type"         => $this->input->post("fuel_type"),
                    "ikmal_miktar"      => $this->input->post("ikmal_miktar"),
                    "ikmal_bf"          => $this->input->post("ikmal_bf"),
                    "ikmal_tutar"       => $this->input->post("ikmal_tutar"),
                    "ortalama"          => $this->input->post("ortalama"),
                    "aciklama"          => $this->input->post("aciklama"),
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

            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Fuel_model->get(
                array(
                    "id" => $id,
                )
            );

            $viewData->item_files = $this->Fuel_file_model->get_all(
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

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

        // Başarılı ise
        // Kayit işlemi baslar
        // Başarısız ise
        // Hata ekranda gösterilir...

    }

    public function delete($id)
    {

        $vehicle_id = get_from_id($this->Module_Table, "vehicle_id",$id);

        $path = "$this->File_Dir_Prefix/$vehicle_id/$this->Module_Name/" ;

        $sil = deleteDirectory($path);

        $delete1 = $this->Fuel_file_model->delete(
            array(
                "$this->Dependet_id_key"    => $id
            )
        );
        $delete2 = $this->Fuel_model->delete(
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
        $config["upload_path"] = "$this->File_Dir_Prefix/$vehicle_id/$this->Module_Name/";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Fuel_file_model->add(
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
        $fileName = $this->Fuel_file_model->get(
            array(
                "id"    => $id
            )
        );


        $fuel_id = get_from_id("fuel_files","fuel_id", $id);
        $vehicle_id = get_from_id("fuel","vehicle_id", $fuel_id);


        $file_path = "$this->File_Dir_Prefix/$vehicle_id/$this->Module_Name/$fileName->img_url";

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


        $viewData->item_files = $this->Fuel_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id, $from){

        $fileName = $this->Fuel_file_model->get(
            array(
                "id"    => $id
            )
        );


        $fuel_id = get_from_id("fuel_files","fuel_id", $id);
        $vehicle_id = get_from_id("fuel","vehicle_id", $fuel_id);

        $delete = $this->Fuel_file_model->delete(
            array(
                "id"    => $id
            )
        );

        if($delete){

            $path = "$this->File_Dir_Prefix/$vehicle_id/$this->Module_Name/$fileName->img_url";

            unlink($path);

            redirect(base_url("$this->Module_Name/$from/$fuel_id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$fuel_id"));

        }

    }

    public function fileDelete_all($id, $from){

        echo $vehicle_id = get_from_id("fuel", "vehicle_id",$id);


        $delete = $this->Fuel_file_model->delete(
            array(
                "$this->Dependet_id_key"    => $id
            )
        );

        if($delete){

            $dir_files = directory_map("$this->File_Dir_Prefix/$vehicle_id/$this->Module_Name");

            foreach($dir_files as $dir_file){
                unlink("$this->File_Dir_Prefix/$vehicle_id/$this->Module_Name/$dir_file");
            }

            redirect(base_url("$this->Module_Name/$from/$id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$id"));

        }

    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "KK-".$file_name;

        $var = count_data("file_order","file_order",$file_name);
        if (($var > 0))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function isActiveSetter($id){

        if($id){

            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->Fuel_model->update(
                array(
                    "id"    => $id
                ),
                array(
                    "isActive"  => $isActive
                )
            );
        }
    }

    public function baslangic_bitis($baslangic, $bitis)
    {
        $date_diff = date_minus($bitis, $baslangic);
        if (($date_diff >= 0)) {
            return FALSE;
            echo $date_diff;
            die();

        } else {
            return TRUE;
            echo $date_diff;

            die();

        }
    }


}
