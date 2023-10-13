<?php

class Compute extends CI_Controller
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

        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        $this->moduleFolder = "auction_module";
        $this->viewFolder = "compute_v";
        $this->load->model("Compute_model");
        $this->load->model("Compute_file_model");
        $this->load->model("Auction_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");

        $this->Module_Name = "compute";
        $this->Module_Title = "Metraj";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "auction";
        $this->Module_File_Dir = "compute";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "compute_id";
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
        $items = $this->Compute_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
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
        $items = $this->Compute_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));
        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->prep_auctions = $prep_auctions;
        $viewData->auc_id = $auc_id;
        if (isset($auc_id)) {
            $viewData->project_id = $project_id;
        }
        $viewData->users = $users;
        $viewData->settings = $settings;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {

        $viewData = new stdClass();

        $auc_id = auction_id_module($this->Module_Name, $id);
        $project_id = project_id_auc($auc_id);
        $settings = $this->Settings_model->get();


        $viewData->project_id = $project_id;

        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->settings = $settings;
        $viewData->project_id = $project_id;
        $viewData->users = $users;

        $viewData->item = $this->Compute_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Compute_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();
        $auc_id = auction_id_module($this->Module_Name, $id);
        $project_id = project_id_auc($auc_id);
        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $viewData->item = $this->Compute_model->get(
            array(
                "id" => $id
            )
        );
        $viewData->project_id = $project_id;

        $viewData->item_files = $this->Compute_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($id)
    {
        $auc_id = $id;
        $auction_code = auction_code($auc_id);
        $project_id = project_id_auc($auc_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);

        $file_name_len = file_name_digits();
        $file_name = "MET-" . $this->input->post('dosya_no');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[compute.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("metraj_grup", "Metraj Grubu", "required|trim");
        $this->form_validation->set_rules("metraj_ad", "Mteraj Ad", "required|trim");

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

            $path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            $insert = $this->Compute_model->add(
                array(
                    "dosya_no" => $file_name,
                    "auction_id" => $id,
                    "metraj_grup" => $this->input->post("metraj_grup"),
                    "metraj_ad" => mb_convert_case(convertToSEO($this->input->post("metraj_ad")), MB_CASE_TITLE),
                    "onay" => $this->input->post("onay"),
                    "aciklama" => $this->input->post("aciklama"),
                    "createdAt" => date("Y-m-d")
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_project_id" => $project_id,
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

            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form verilerinde eksik veya hatalı giriş var.",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);


            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));

            $viewData = new stdClass();
            $settings = $this->Settings_model->get();

            $viewData->settings = $settings;
            $viewData->users = $users;
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->auc_id = $id;
            $viewData->project_id = $project_id;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function update($id)
    {
        $auc_id = auction_id_module("compute", $id);
        $project_id = project_id_auc($auc_id);

        $this->load->library("form_validation");

        $this->form_validation->set_rules("metraj_grup", "Metraj Grubu", "required|trim");
        $this->form_validation->set_rules("metraj_ad", "Çizim Ad", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $update = $this->Compute_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "metraj_grup" => $this->input->post("metraj_grup"),
                    "metraj_ad" => mb_convert_case(convertToSEO($this->input->post("metraj_ad")), MB_CASE_TITLE),
                    "onay" => $this->input->post("onay"),
                    "aciklama" => $this->input->post("aciklama")
                )
            );

            $record_id = $this->db->insert_id();

            $file_order_id = get_from_any_and("file_order", "connected_module_id", $id, "module", $this->Module_Name);

            $update2 = $this->Order_model->update(
                array(
                    "id" => $file_order_id
                ),
                array(
                    "updatedAt" => date("Y-m-d H:i:s"),
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
            redirect(base_url("$this->Module_Name/$this->Display_route/$id"));

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Bazı Bilgi Girişlerinde Hata Oluştu",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);
            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";

            $viewData->users = $users;

            $viewData->form_error = true;
            $viewData->settings = $settings;
            $viewData->project_id = $project_id;

            $viewData->item = $this->Compute_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Compute_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                ),
            );

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {

        $auction_id = get_from_id("compute", "auction_id", $id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);
        $Compute_code = get_from_id("compute", "dosya_no", $id);

        $path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Compute_code/";

        $sil = deleteDirectory($path);

        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        $delete1 = $this->Compute_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $delete2 = $this->Compute_model->delete(
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

    public function file_upload($id)
    {
        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $auction_id = get_from_id("compute", "auction_id", $id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);
        $auction_code = get_from_id("auction", "dosya_no", get_from_id("compute", "auction_id", $id));
        $Compute_code = get_from_id("compute", "dosya_no", $id);

        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Compute_code";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Compute_file_model->add(
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

    public function file_download($id)
    {
        $fileName = $this->Compute_file_model->get(
            array(
                "id" => $id
            )
        );

        $compute_id = get_from_id("compute_files", "compute_id", $id);
        $auction_id = get_from_id("compute", "auction_id", $compute_id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);
        $Compute_code = get_from_id("compute", "dosya_no", $compute_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Compute_code/$fileName->img_url";

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

    public function refresh_file_list($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->item = $this->Compute_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Compute_file_model->get_all(
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


        $fileName = $this->Compute_file_model->get(
            array(
                "id" => $id
            )
        );


        $compute_id = get_from_id("compute_files", "compute_id", $id);
        $auction_id = get_from_id("compute", "auction_id", $compute_id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);
        $Compute_code = get_from_id("compute", "dosya_no", $compute_id);

        $delete = $this->Compute_file_model->delete(
            array(
                "id" => $id
            )
        );

        if ($delete) {

            $path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Compute_code/$fileName->img_url";

            unlink($path);

            $viewData->item = $this->Compute_model->get(
                array(
                    "id" => $compute_id
                )
            );

            $viewData->item_files = $this->Compute_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $compute_id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;

        }

    }

    public function fileDelete_all($id)
    {

        $viewData = new stdClass();
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;


        $auction_id = get_from_id("compute", "auction_id", $id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);
        $Compute_code = get_from_id("compute", "dosya_no", $id);

        $delete = $this->Compute_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Compute_code");

            foreach ($dir_files as $dir_file) {
                unlink("$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Compute_code/$dir_file");
            }


            $viewData->item = $this->Compute_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Compute_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;

        }

    }

    public function download_all($compute_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $auction_id = get_from_id("compute", "auction_id", "$compute_id");
        $comppute_code = get_from_id("compute", "dosya_no", "$compute_id");
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);
        $auction_name = get_from_id("auction", "ihale_ad", $auction_id);

        $path = "uploads/project_v/$project_code/$auction_code/$this->Module_Name/$comppute_code";

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $auction_name;
        $this->zip->download("$zip_name");

    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "MET-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


}
