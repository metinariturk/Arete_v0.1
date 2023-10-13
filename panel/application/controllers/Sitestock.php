<?php

class Sitestock extends CI_Controller
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
        $this->moduleFolder = "site_module";
        $this->viewFolder = "sitestock_v";
        $this->load->model("Sitestock_model");
        $this->load->model("Sitestock_file_model");
        $this->load->model("Auction_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");
        $this->load->model("Site_model");
        $this->load->model("Workgroup_model");
        $this->load->model("Company_model");

        $this->Module_Name = "Sitestock";
        $this->Module_Title = "Şantiye Deposu";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "site";
        $this->Module_File_Dir = "Sitestock";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "sitestock_id";
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";
        $this->File_List = "file_list_v";
        $this->Common_Files = "common";
    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Sitestock_model->get_all(array(
            "stock_id" => null
        ));
        $active_sites = $this->Site_model->get_all();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->active_sites = $active_sites;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function select()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Sitestock_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $viewData->prep_auctions = $prep_auctions;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($site_id = null)
    {

        if ($site_id == null) {
            $site_id = $this->input->post("site_id");
        }
        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Sitestock_model->get_all(array());
        $site = $this->Site_model->get(array("id" => $site_id));
        $settings = $this->Settings_model->get();

        $suppliers = $this->Company_model->get_all(array(
            "company_role" => 3
        ));

        $active_workgroups = json_decode($site->active_group, true);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->site = $site;
        $viewData->active_workgroups = $active_workgroups;
        $viewData->settings = $settings;
        $viewData->suppliers = $suppliers;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($sitestock_id)
    {
        $site_id = get_from_any("sitestock", "site_id", "id", "$sitestock_id");
        $proje_id = get_from_any("site", "proje_id", "id", $site_id);

        $viewData = new stdClass();

        $project = $this->Project_model->get(array("id" => $proje_id));
        $site = $this->Site_model->get(array("id" => $site_id));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->project = $project;
        $viewData->site = $site;

        $viewData->item = $this->Sitestock_model->get(
            array(
                "id" => $sitestock_id
            )
        );

        $viewData->item_files = $this->Sitestock_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $sitestock_id
            ),
        );

        $viewData->viewModule = $this->moduleFolder;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($site_id)
    {
        $supplies = $this->input->post("supplies[]");


        $supplies_array = array();
        $i = 1;
        foreach ($supplies as $supply) {
            $arr = array("id" => $i++);
            if (!empty($supply["product_name"])) {
                $supplies_array[] = $arr + $supply;
            }
        }

        $file_name_len = file_name_digits();
        $file_name = "SD-" . $this->input->post('dosya_no');

        if ($this->input->post("arrival_date")) {
            $sitestock_date = dateFormat('Y-m-d', $this->input->post("arrival_date"));
        } else {
            $sitestock_date = null;
        }

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|required|trim|exact_length[$file_name_len]");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",

            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $site_code = get_from_id("site", "dosya_no", $site_id);
            $proje_id = project_id_site($site_id);
            $project_code = project_code($proje_id);

            $path = "$this->File_Dir_Prefix/$project_code/$site_code/Sitestocks/$file_name";


            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            $insert = $this->Sitestock_model->add(
                array(
                    "dosya_no" => $file_name,
                    "arrival_date" => $sitestock_date,
                    "site_id" => $site_id,
                    "supplies" => json_encode($supplies_array),
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_project_id" => $proje_id,
                    "file_order" => $file_name,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                )
            );

            // TODO Alert sistemi eklenecek...
            if ($insert) {

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt başarılı bir şekilde eklendi",
                    "type" => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }


            // İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);
            if (empty($stock_id)) {
                redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));
            }

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form verilerinde eksik veya hatalı giriş var.",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $site = $this->Site_model->get(array("id" => $site_id));
            $suppliers = $this->Company_model->get_all(array(
                "company_role" => 3
            ));


            $viewData->settings = $settings;

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->site = $site;
            $viewData->suppliers = $suppliers;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function save_consume($stock_id = null)
    {
        $consumes = $this->input->post("consume[]");

        $old_consume_data = json_decode(get_from_id("sitestock","consume",$stock_id), true);

        $consumes_array = array();
        foreach ($consumes as $consume) {
            if (!empty($consume["product_qty"])) {
                $consumes_array[] = $consume;
            }
        }

        if (empty($old_consume_data)) {
            $mergedArray = $consumes_array;
        } else {
            $mergedArray = array_merge($old_consume_data, $consumes_array);
        }

        $update = $this->Sitestock_model->update(
            array(
                "id" => $stock_id
            ),
            array(
                "consume" => json_encode($mergedArray),
            )
        );

        $record_id = $this->db->insert_id();

        if ($update) {
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Kayıt başarılı bir şekilde eklendi",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("$this->Module_Name/$this->Display_route/$stock_id"));

    }

    public function delete($sitestock_id)
    {
        $sitestock_code = get_from_id("sitestock", "dosya_no", "$sitestock_id");
        $site_id = get_from_id("sitestock", "site_id", $sitestock_id);
        $site_code = get_from_id("site", "dosya_no", $site_id);
        $proje_id = project_id_site($site_id);
        $project_code = project_code($proje_id);

        $path = "$this->File_Dir_Prefix/$project_code/$site_code/Sitestocks/$sitestock_code";

        $sil = deleteDirectory($path);


        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        $delete1 = $this->Sitestock_file_model->delete(
            array(
                "$this->Dependet_id_key" => $sitestock_id
            )
        );

        $delete2 = $this->Sitestock_model->delete(
            array(
                "id" => $sitestock_id
            )
        );


        $file_order_id = get_from_any_and("file_order", "connected_module_id", $sitestock_id, "module", $this->Module_Name);

        $update_file_order = $this->Order_model->update(
            array(
                "id" => $file_order_id
            ),
            array(
                "deletedAt" => date("Y-m-d H:i:s"),
                "deletedBy" => active_user_id(),
            )
        );

        // TODO Alert Sistemi Eklenecek...
        if ($delete1 and $delete2) {
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Kayıt başarılı bir şekilde silindi",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Kayıt silme sırasında bir problem oluştu",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("sitestock"));
    }

    public function file_upload($sitestock_id)
    {
        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $sitestock_code = get_from_id("sitestock", "dosya_no", "$sitestock_id");
        $site_id = get_from_id("sitestock", "site_id", $sitestock_id);
        $site_code = get_from_id("site", "dosya_no", $site_id);
        $proje_id = project_id_site($site_id);
        $project_code = project_code($proje_id);

        $path = "$this->File_Dir_Prefix/$project_code/$site_code/Sitestocks/$sitestock_code";

        $config["allowed_types"] = "*";
        $config["upload_path"] = $path;
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {
            $uploaded_file = $this->upload->data("file_name");

            $this->Sitestock_file_model->add(
                array(
                    "img_url" => $uploaded_file,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                    "$this->Dependet_id_key" => $sitestock_id,
                    "size" => $size
                )
            );
        } else {
            echo "islem basarisiz";
            echo $config["upload_path"];
        }
    }

    public function file_download($id)
    {
        $fileName = $this->Sitestock_file_model->get(
            array(
                "id" => $id
            )
        );


        $sitestock_id = get_from_any("sitestock_files", "sitestock_id", "id", $id);
        $sitestock_code = get_from_id("sitestock", "dosya_no", "$sitestock_id");
        $site_id = get_from_id("sitestock", "site_id", $sitestock_id);
        $site_code = get_from_id("site", "dosya_no", $site_id);
        $proje_id = project_id_site($site_id);
        $project_code = project_code($proje_id);

        $path = "$this->File_Dir_Prefix/$project_code/$site_code/Sitestocks/$sitestock_code";

        $file_path = "$path/$fileName->img_url";

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

    public function download_all($sitestock_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $sitestock_code = get_from_id("sitestock", "dosya_no", "$sitestock_id");
        $site_id = get_from_id("sitestock", "site_id", $sitestock_id);
        $site_code = get_from_id("site", "dosya_no", $site_id);
        $proje_id = project_id_site($site_id);
        $project_code = project_code($proje_id);

        $path = "$this->File_Dir_Prefix/$project_code/$site_code/Sitestocks/$sitestock_code";

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $site_code . "-" . $sitestock_code;
        $this->zip->download("$zip_name");

    }

    public function refresh_file_list($stock_id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->item = $this->Sitestock_model->get(
            array(
                "id" => $stock_id
            )
        );

        $viewData->item_files = $this->Sitestock_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $stock_id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/file_list_v", $viewData, true);

        echo $render_html;


    }

    public function fileDelete($id)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $fileName = $this->Sitestock_file_model->get(
            array(
                "id" => $id
            )
        );

        $sitestock_id = get_from_any("sitestock_files", "sitestock_id", "id", $id);
        $sitestock_code = get_from_id("sitestock", "dosya_no", "$sitestock_id");
        $site_id = get_from_id("sitestock", "site_id", $sitestock_id);
        $site_code = get_from_id("site", "dosya_no", $site_id);
        $proje_id = project_id_site($site_id);
        $project_code = project_code($proje_id);


        $delete = $this->Sitestock_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            $path = "$this->File_Dir_Prefix/$project_code/$site_code/Sitestocks/$sitestock_code/$fileName->img_url";

            unlink($path);

            $viewData->item = $this->Sitestock_model->get(
                array(
                    "id" => $sitestock_id
                )
            );

            $viewData->item_files = $this->Sitestock_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $sitestock_id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/file_list_v", $viewData, true);
            echo $render_html;

        }
    }

    public function fileDelete_all($sitestock_id)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $sitestock_code = get_from_id("sitestock", "dosya_no", "$sitestock_id");
        $site_id = get_from_id("sitestock", "site_id", $sitestock_id);
        $site_code = get_from_id("site", "dosya_no", $site_id);
        $proje_id = project_id_site($site_id);
        $project_code = project_code($proje_id);

        $delete = $this->Sitestock_file_model->delete(
            array(
                "$this->Dependet_id_key" => $sitestock_id
            )
        );

        if ($delete) {

            $path = "$this->File_Dir_Prefix/$project_code/$site_code/Sitestocks/$sitestock_code";


            $dir_files = directory_map($path);

            foreach ($dir_files as $dir_file) {
                unlink("$path/$dir_file");
            }

            $viewData->item = $this->Sitestock_model->get(
                array(
                    "id" => $sitestock_id
                )
            );

            $viewData->item_files = $this->Sitestock_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $sitestock_id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/file_list_v", $viewData, true);

            echo $render_html;


        }
    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "SD-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}


