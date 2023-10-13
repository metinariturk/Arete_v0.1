<?php

class Catalog extends CI_Controller
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

        $this->moduleFolder = "contract_module";
        $this->viewFolder = "catalog_v";
        $this->load->model("Catalog_model");

        $this->load->model("Contract_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");

        $this->Module_Name = "Catalog";
        $this->Module_Title = "Katalog";

        // Folder Structure
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "contract";
        $this->Module_File_Dir = "catalog";
        $this->Module_Table = "catalog";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir";
        // Folder Structure

        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "catalog_id";
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
        $items = $this->Catalog_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "durumu" => 1
            )
        );


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->active_contracts = $active_contracts;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function select()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Catalog_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "durumu" => 1
            )
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $viewData->active_contracts = $active_contracts;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($contract_id = null)
    {
        if ($contract_id == null) {
            $contract_id = $this->input->post("contract_id");
        }

        $active_contracts = $this->Contract_model->get_all(array(
                "durumu" => 1
            )
        );

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Catalog_model->get_all(array());

        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->active_contracts = $active_contracts;
        $viewData->items = $items;
        if ((!empty($this->input->post("contract_id"))) or !empty($contract_id)){
        $viewData->project_id = project_id_cont($contract_id);
        }
        $viewData->contract_id = $contract_id;
        $viewData->settings = $settings;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        $contract_id = contract_id_module("catalog","$id");
        $contract_code = contract_code($contract_id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $catalog_name = get_from_any("catalog","dosya_no","id","$id");

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->contract_id = $contract_id;
        $viewData->contract_code = $contract_code;
        $viewData->project_code = $project_code;
        $viewData->project_id = $project_id;
        $viewData->catalog_name = $catalog_name;

        $viewData->item = $this->Catalog_model->get(
            array(
                "id" => $id
            )
        );


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {
        $viewData = new stdClass();

        $contract_id = contract_id_module("catalog","$id");
        $contract_code = contract_code($contract_id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $catalog_name = get_from_any("catalog","dosya_no","id","$id");

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";

        $viewData->contract_id = $contract_id;
        $viewData->contract_code = $contract_code;
        $viewData->project_code = $project_code;
        $viewData->project_id = $project_id;
        $viewData->catalog_name = $catalog_name;

        $viewData->item = $this->Catalog_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function save($contract_id)
    {
        $project_id = project_id_cont($contract_id);

        $file_name_len = file_name_digits();
        echo $file_name = "KAT-" . $this->input->post('dosya_no');
        echo $catalog_ad = $this->input->post('catalog_ad');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("catalog_ad", "Katalog Ad", "required|trim"); //2

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $project_code = project_code($project_id);
            $contract_code = contract_code($contract_id);

            $temp_thumb_path = "uploads/temp/Catalog/$file_name/thumb";
            $temp_original_path = "uploads/temp/Catalog/$file_name";

            $real_orginal_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Catalog/$file_name";
            $real_thumb_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Catalog/$file_name/thumb";

            if (!is_dir($real_orginal_path)) {
                mkdir("$real_orginal_path", 0777, TRUE);
            }

            if (!is_dir($real_thumb_path)) {
                mkdir("$real_thumb_path", 0777, TRUE);
            }

            if ($this->input->post("master") == "on") {
                $master = 1;
            } else {
                $master = 0;
            }

            $thumb_files = directory_map($temp_thumb_path, 1);
            if (!empty($thumb_files)) {
                foreach ($thumb_files as $thumb_file) {
                    $fileThumbPath = $temp_thumb_path."/".$thumb_file;
                    $destinationThumbFilePath = $real_thumb_path."/".$thumb_file;
                    copy($fileThumbPath, $destinationThumbFilePath);
                }
            }


            $org_files = directory_map($temp_original_path, 1);
            if (!empty($org_files)) {
                foreach ($org_files as $org_file) {
                    $filePath = $temp_original_path."/".$org_file;
                    $destinationFilePath = $real_orginal_path."/".$org_file;
                    /* Copy File from images to copyImages folder */
                    copy($filePath, $destinationFilePath);

                }
            }

            $sil = deleteDirectory($temp_thumb_path);
            $sil = deleteDirectory($temp_original_path);

            $insert = $this->Catalog_model->add(
                array(
                    "contract_id" => $contract_id,
                    "dosya_no" => $file_name,
                    "catalog_ad" => $this->input->post('catalog_ad'),
                    "aciklama" => $this->input->post("aciklama"),
                    "master" => $master,
                    "createdAt" => date("Y-m-d"),
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_contract_id" => $contract_id,
                    "file_order" => $file_name,
                    "createdAt" => date("Y-m-d H:i:s"),
"createdBy" => active_user_id(),
                )
            );

            // TODO Alert sistemi eklenecek...
            if ($insert) {

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Katalog dosyası oluşturuldu",
                    "type" => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Katalog dosyası oluşturulması sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }

            // İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("Contract/file_form/$contract_id/catalog"));

        } else {


            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->contract_id = $contract_id;
            $viewData->project_id = $project_id;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update($id)
    {

        $this->load->library("form_validation");

        $this->form_validation->set_rules("catalog_ad", "Katalog Ad", "required|trim"); //2

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("master") == "on") {
                $master = 1;
            } else {
                $master = 0;
            }


            $update = $this->Catalog_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "catalog_ad" => $this->input->post('catalog_ad'),
                    "aciklama" => $this->input->post("aciklama"),
                    "master" => $master,
                )
            );

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
                    "title" => "İşlem Başarılı",
                    "text" => "Güncelleme sırasında bir problem oluştu",
                    "type" => "danger"
                );


            }

            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$id"));

        } else {


            $viewData = new stdClass();

            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Catalog_model->get(
                array(
                    "id" => $id,
                )
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

    public function delete($catalog_id)
    {

        $contract_id = contract_id_module("catalog","$catalog_id");
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $catalog_name = get_from_id("catalog", "dosya_no", "$catalog_id");

        $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Catalog/$catalog_name";

        $sil = deleteDirectory($path);

        $file_order_id = get_from_any_and("file_order", "connected_module_id", $catalog_id, "module", $this->Module_Name);
        $update_file_order = $this->Order_model->update(
            array(
                "id" => $file_order_id
            ),
            array(
                "deletedAt" => date("Y-m-d H:i:s"),
"deletedBy" => active_user_id(),
            )
        );

        $delete = $this->Catalog_model->delete(
            array(
                "id" => $catalog_id
            )
        );

        // TODO Alert Sistemi Eklenecek...
        if ($delete) {
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
        redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$contract_id"));
    }

    public function file_upload($contract_id, $catalog_number)
    {
        $catalog_name = "KAT-" . $catalog_number;
        $extention = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $contract_code = contract_code($contract_id);
        $project_id = get_from_id("contract", "proje_id", $contract_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);
        $original_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Catalog/$catalog_name";
        $temp_original_path = "$this->Upload_Folder/temp/Catalog/$catalog_name";
        $thumb_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Catalog/thumb";
        $temp_thumb_path = "$this->Upload_Folder/temp/Catalog/$catalog_name/thumb";

        $config["allowed_types"] = "*";
        $config["upload_path"] = "$temp_original_path";
        $config["file_name"] = $file_name;

        if (!is_dir($temp_original_path)) {
            mkdir("$temp_original_path", 0777, TRUE);
            mkdir("$temp_thumb_path", 0777, TRUE);
        }

        $allowed_types = array("jpg", "jpeg", "png");
        if (in_array($extention, $allowed_types)) {
            $this->load->library("upload", $config);
            $upload = $this->upload->do_upload("file");
        } else {
            $extention_warning = "Dosya Uzantısı Uygun Değil";
        }

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");
            $source_path = "$temp_original_path/$file_name";
            $file_name_thumb = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $config['image_library'] = 'gd2';
            $config['source_image'] = $source_path;
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 300;
            $config['height'] = 300;
            $config['new_image'] = $temp_thumb_path . "/" . $file_name_thumb;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->image_lib->display_errors();
        }
    }

    public function file_upload_update($catalog_id)
    {

        $catalog_name = get_from_id("catalog","dosya_no","$catalog_id");
        $contract_id = contract_id_module("catalog","$catalog_id");
        $contract_code = contract_code($contract_id);
        $project_id = get_from_id("contract", "proje_id", $contract_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);
        $original_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Catalog/$catalog_name";
        $thumb_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Catalog/$catalog_name/thumb";

                $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $extention = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

        $config["allowed_types"] = "*";
        $config["upload_path"] = "$original_path";
        $config["file_name"] = $file_name;

        if (!is_dir($original_path)) {
            mkdir("$original_path", 0777, TRUE);
            mkdir("$thumb_path", 0777, TRUE);
        }

        $allowed_types = array("jpg", "jpeg", "png");
        if (in_array($extention, $allowed_types)) {
            $this->load->library("upload", $config);
            $upload = $this->upload->do_upload("file");
        } else {
            $extention_warning = "Dosya Uzantısı Uygun Değil";
        }

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");
            $source_path = "$original_path/$file_name";
            $file_name_thumb = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $config['image_library'] = 'gd2';
            $config['source_image'] = $source_path;
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 300;
            $config['height'] = 300;
            $config['new_image'] = $thumb_path . "/" . $file_name_thumb;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->image_lib->display_errors();
        }
    }

    public function refresh_file_list($contract_id)
    {
        $viewData = new stdClass();

        $project_id = get_from_id("contract", "proje_id", $contract_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/temp_gallery", $viewData, true);

        echo $render_html;

    }

    public function refresh_file_list_update($catalog_id)
    {
        $viewData = new stdClass();
        $contract_id = contract_id_module("catalog","$catalog_id");
        $contract_code = contract_code($contract_id);
        $project_id = get_from_id("contract", "proje_id", $contract_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->contract_code = $contract_code;
        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;
        $viewData->project_code = $project_code;

        $item = $this->Catalog_model->get(
            array(
                "id" => $catalog_id,
            )
        );
        $viewData->item = $item;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/update/update_gallery", $viewData, true);

        echo $render_html;

    }

    public function TempfileDelete($file, $catalog_number)
    {

        $thumb_name = get_thumb_name($file);
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $thumb_path = "uploads/temp/Catalog/Kat-$catalog_number/thumb/$thumb_name";
        $original_path = "uploads/temp/Catalog/Kat-$catalog_number/$file";

        unlink($original_path);
        if (is_dir($thumb_path)){
            unlink($thumb_path);
        }

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/temp_gallery", $viewData, true);
        echo $render_html;

    }

    public function UpdatefileDelete($file, $catalog_id)
    {

        $viewData = new stdClass();

        $catalog_code = get_from_id("catalog","dosya_no","$catalog_id");
        $contract_id = contract_id_module("catalog","$catalog_id");
        $contract_code = contract_code($contract_id);
        $project_id = get_from_id("contract", "proje_id", $contract_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->contract_code = $contract_code;
        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;
        $viewData->project_code = $project_code;

        $item = $this->Catalog_model->get(
            array(
                "id" => $catalog_id,
            )
        );
        $viewData->item = $item;

        $thumb_name = get_thumb_name($file);


        $original_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Catalog/$catalog_code/$file";
        $thumb_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Catalog/$catalog_code/thumb/$thumb_name";

        unlink($original_path);
        if (is_file($thumb_path)){
            unlink($thumb_path);
        }

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/update/update_gallery", $viewData, true);
        echo $render_html;

    }

    public function fileDelete_all($id, $from)
    {

        $contract_id = get_from_id("catalog", "contract_id", $id);
        $project_id = get_from_id("contract", "proje_id", $contract_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);
        $catalog_code = get_from_id("catalog", "dosya_no", $id);


        if ($delete) {

            $dir_org_files = directory_map("$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$catalog_code");
            $dir_thb_files = directory_map("$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$catalog_code/thumb");

            foreach ($dir_org_files as $dir_org_file) {
                unlink("$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$catalog_code/$dir_org_file");
            }
            foreach ($dir_thb_files as $dir_thb_file) {
                unlink("$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$catalog_code/thumb/$dir_thb_file");
            }

            redirect(base_url("$this->Module_Name/$from/$id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$id"));

        }

    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "KAT-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
