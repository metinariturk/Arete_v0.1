<?php

class Offer extends CI_Controller
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

        $this->moduleFolder = "auction_module";
        $this->viewFolder = "offer_v";
        $this->load->model("Offer_model");
        $this->load->model("Offer_file_model");
        $this->load->model("Auction_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");
        $this->load->model("Company_model");


        $this->Module_Name = "offer";
        $this->Module_Title = "Teklif Formu";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "auction";
        $this->Module_File_Dir = "Offer";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "offer_id";
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
        $items = $this->Offer_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->prep_auctions = $prep_auctions;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function select()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Offer_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $viewData->prep_auctions = $prep_auctions;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($auc_id = null)
    {

        if ($auc_id == null) {
            $auc_id = $this->input->post("auction_id");
        }

        if (isset($auc_id)) {
            $project_id = project_id_auc($auc_id);
        }
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $projects = $this->Project_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));
        $companys = $this->Company_model->get_all(array(

        ));
        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->projects = $projects;
        $viewData->prep_auctions = $prep_auctions;
        $viewData->auc_id = $auc_id;
        if (isset($auc_id)) {
            $viewData->project_id = $project_id;
        }
        $viewData->companys = $companys;
        $viewData->settings = $settings;
        if (isset($auc_id)) {
            $viewData->istekliler = json_decode(get_from_id("auction", "istekliler", "$auc_id"));
        }
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        $auction_id = auction_id_module("Offer", "$id");
        $project_id = project_id_auc($auction_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->auction_id = $auction_id;
        $viewData->project_id = $project_id;


        $viewData->item = $this->Offer_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Offer_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($auc_id)
    {
        $file_name_len = file_name_digits();
        $file_name = "TKL-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[offer.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",

            )
        );
        $validate = $this->form_validation->run();

        if ($validate) {
            $offers = $this->input->post("offers[]");

            print_r($offers);
            $project_id = get_from_id("auction", "proje_id", $auc_id);
            $project_code = project_code($project_id);
            $auction_code = get_from_id("auction", "dosya_no", $auc_id);

            $path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            $insert = $this->Offer_model->add(
                array(
                    "auction_id" => $auc_id,
                    "dosya_no" => $file_name,
                    "offer" => json_encode($offers),
                    "aciklama" => $this->input->post("aciklama"),
                    "createdAt" => date("Y-m-d")
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_auction_id" => $auc_id,
                    "file_order" => "$file_name",
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

                redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }


        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form verilerinde eksik veya hatalı giriş var.",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();

            $viewData->auc_id = $auc_id;
            $viewData->istekliler = json_decode(get_from_id("auction", "istekliler", "$auc_id"));
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function delete($id)
    {
        $auction_id = get_from_id("offer", "auction_id", $id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);
        $offer_code = get_from_id("offer", "dosya_no", $id);

        $path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$offer_code/";

        $sil = deleteDirectory($path);

        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        $delete1 = $this->Offer_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $delete2 = $this->Offer_model->delete(
            array(
                "id" => $id
            )
        );

        $file_order_id = get_from_any_and("file_order", "connected_module_id", $id, "module", $this->Module_Name);
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
        redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$auction_id"));
    }

    public function file_upload($id, $comp_id)
    {
        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $auction_id = get_from_id("offer", "auction_id", $id);

        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", get_from_id("offer", "auction_id", $id));
        $offer_code = get_from_id("offer", "dosya_no", $id);

        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix";
        $config["file_name"] = $comp_id . "---" . date("d-m-y");

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Offer_file_model->add(
                array(
                    "img_url" => $uploaded_file,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                    "$this->Dependet_id_key" => $id,
                    "size" => $size
                )
            );

            redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$auction_id"));

        } else {
            echo "islem basarisiz";
            echo $config["upload_path"];
        }
    }

    public function file_download($id)
    {
        $fileName = $this->Offer_file_model->get(
            array(
                "id" => $id
            )
        );


        $offer_id = get_from_id("offer_files", "offer_id", $id);
        $auction_id = get_from_id("offer", "auction_id", $offer_id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$fileName->img_url";

        if ($file_path) {

            if (file_exists($file_path)) {
                $data = file_get_contents($file_path);

                force_download((bid_file_name($fileName->img_url)), $data);
            } else {
                echo "Dosya veritabanında var ancak klasör içinden silinmiş, SİSTEM YÖNETİCİNİZE BAŞVURUN";
            }
        } else {
            echo "Dosya Yok";
        }

    }

    public function refresh_file_list($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->item = $this->Offer_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Offer_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;


        $fileName = $this->Offer_file_model->get(
            array(
                "id" => $id
            )
        );

        $offer_id = get_from_id("offer_files", "offer_id", $id);
        $auction_id = get_from_id("offer", "auction_id", $offer_id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);

        $delete = $this->Offer_file_model->delete(
            array(
                "id" => $id
            )
        );

        if ($delete) {

            $path = "$this->File_Dir_Prefix/$project_code/$auction_code/Offer/$fileName->img_url";
            unlink($path);

            $viewData->item = $this->Offer_model->get(
                array(
                    "id" => $offer_id
                )
            );

            $viewData->item_files = $this->Offer_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $offer_id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;

        }

    }

    public function fileDelete_all($id)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;


        $auction_id = get_from_id("offer", "auction_id", $id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);

        $delete = $this->Offer_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix");

            foreach ($dir_files as $dir_file) {
                unlink("$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$dir_file");
            }

            $viewData->item = $this->Offer_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Offer_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );

        }

    }

    public function download_all($offer_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $auction_id = get_from_id("Offer", "auction_id", "$offer_id");
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);
        $auction_name = get_from_id("auction", "ihale_ad", $auction_id);

        $path = "uploads/project_v/$project_code/$auction_code/$this->Module_Name";
        echo $path;

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $auction_name;
        $this->zip->download("$zip_name");

    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "TKL-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
