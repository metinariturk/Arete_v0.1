<?php

class Boq extends CI_Controller
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
        $this->viewFolder = "boq_v";
        $this->load->model("Boq_model");
        $this->load->model("Boq_file_model");
        $this->load->model("Contract_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("Bond_model");
        $this->load->model("Bond_file_model");

        $this->Module_Name = "boq";
        $this->Module_Title = "Metraj";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "contract";
        $this->Module_File_Dir = "boq";
        $this->Module_Table = "boq";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "boq_id";
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
        $items = $this->Boq_model->get_all(array());
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

    public function new_form($contract_id = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        if ($contract_id == null) {
            $contract_id = $this->input->post("contract_id");
        }

        $contract = $this->Contract_model->get(array(
                "id" => $contract_id
            )
        );

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */

        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->contract = $contract;

        if ((!empty($this->input->post("contract_id"))) or !empty($contract_id)) {
            $viewData->project_id = project_id_cont($contract_id);
        }
        $viewData->contract_id = $contract_id;
        $viewData->settings = $settings;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {

        $contract_id = contract_id_module("boq", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = project_id_cont("$contract_id");

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;

        $viewData->item = $this->Boq_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Boq_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);


    }

    public function file_form($id)
    {

        $contract_id = contract_id_module("boq", $id);

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = project_id_cont("$contract_id");

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $viewData->item = $this->Boq_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Boq_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );

        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($contract_id)
    {
        $contract_id = contract_id_module("boq", $id);

        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $this->load->library("form_validation");

        $file_name_len = file_name_digits();
        $file_name = "AV-" . $this->input->post('dosya_no');

        $contract_price = get_from_id("contract", "sozlesme_bedel", $contract_id);
        $sozlesme_tarih = dateFormat_dmy(get_from_any("contract", "sozlesme_tarih", "id", "$contract_id"));

        $this->form_validation->set_rules("dosya_no", "Dosya No", "is_unique[boq.dosya_no]|exact_length[$file_name_len]|trim|callback_duplicate_code_check"); //2
        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("metraj_miktar", "Metraj Miktarı", "less_than_equal_to[$contract_price]|numeric|required|trim");
        } else {
            $this->form_validation->set_rules("metraj_miktar", "Metraj Miktarı", "numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "duplicate_name_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $project_id = project_id_cont("$contract_id");
            $project_code = project_code("$project_id");
            $contract_code = contract_code($contract_id);

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/$this->Module_Name/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            $metraj_tarihi = dateFormat('Y-m-d', $this->input->post("metraj_tarih"));


            $insert = $this->Boq_model->add(
                array(
                    "dosya_no" => $file_name,
                    "contract_id" => $contract_id,
                    "metraj_tarih" => $metraj_tarihi,
                    "metraj_miktar" => $this->input->post("metraj_miktar"),
                    "metraj_oran" => $this->input->post("metraj_oran"),
                    "aciklama" => $this->input->post("aciklama"),
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
            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));
            //kaydedilen elemanın id nosunu döküman ekleme sayfasına post ediyoruz
        } else {

            $project_id = project_id_cont("$contract_id");

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

        $contract_id = contract_id_module("boq", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $contract_id = contract_id_module("boq", $id);
        $contract_price = get_from_id("contract", "sozlesme_bedel", $contract_id);

        $sozlesme_tarihi = dateFormat('d-m-Y', get_from_any("contract", "sozlesme_tarih", "id", "$contract_id"));


        $this->form_validation->set_rules("metraj_tarih", "Metraj Tarihi", "required|trim");
        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("metraj_miktar", "Metraj Miktarı", "less_than_equal_to[$contract_price]|numeric|required|trim");
        } else {
            $this->form_validation->set_rules("metraj_miktar", "Metraj Miktarı", "numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "is_natural_no_zero" => "<b>{field}</b> alanı '0' dan farklı bir tamsayı olmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("metraj_tarih")) {
                $metraj_tarihi = dateFormat('Y-m-d', $this->input->post("metraj_tarih"));
            } else {
                $metraj_tarihi = null;
            }

            $update = $this->Boq_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "metraj_tarih" => $metraj_tarihi,
                    "metraj_miktar" => $this->input->post("metraj_miktar"),
                    "metraj_oran" => $this->input->post("metraj_oran"),
                    "aciklama" => $this->input->post("aciklama"),
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
                    "title" => "İşlem Başarısız",
                    "text" => "Güncelleme sırasında bir problem oluştu",
                    "type" => "danger"
                );


            }

            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$id"));

        } else {


            $viewData = new stdClass();
            $contract_id = contract_id_module("boq", $id);
            $project_id = project_id_cont("$contract_id");


            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Boq_model->get(
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
            $viewData->contract_id = $contract_id;
            $viewData->project_id = $project_id;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {
        //Bağlı teminat silme işlemleri
        $contract_id = contract_id_module("boq", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);

        $bond_id = get_from_any_and("bond", "contract_id", $contract_id, "teminat_metraj_id", $id);

        if (!empty($bond_id)) {

            $bond_file_name = get_from_id("bond", "dosya_no", $bond_id);
            $bond_file_order_id = get_from_any_and("file_order", "connected_module_id", $bond_id, "module", "bond");

            $bond_path = "$this->File_Dir_Prefix/$project_code/$contract_code/contract/bond/$bond_file_name/";

            $sil_bond = deleteDirectory($bond_path);

            $update_bond_order = $this->Order_model->update(
                array(
                    "id" => $bond_file_order_id
                ),
                array(
                    "deletedAt" => date("Y-m-d H:i:s"),
                    "deletedBy" => active_user_id(),
                )
            );

            $delete_bond_file = $this->Bond_file_model->delete(
                array(
                    "bond_id" => $bond_id
                )
            );

            $delete_bond = $this->Bond_model->delete(
                array(
                    "id" => $bond_id
                )
            );
        }

        $file_order_id = get_from_any_and("file_order", "connected_module_id", $id, "module", $this->Module_Name);
        $boq_code = get_from_id("boq", "dosya_no", $id);

        $boq_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Boq/$boq_code/";

        $delete_boq = deleteDirectory($boq_path);

        if ($delete_boq) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>Hata Oluştu';
        }

        $update_file_order = $this->Order_model->update(
            array("id" => $file_order_id),
            array("deletedAt" => date("Y-m-d H:i:s"),
                "deletedBy" => active_user_id(),
            )
        );

        $delete_boq_file = $this->Boq_file_model->delete(
            array("$this->Dependet_id_key" => $id)
        );

        $delete_boq = $this->Boq_model->delete(
            array("id" => $id)
        );

        // TODO Alert Sistemi Eklenecek...
        if ($update_file_order and $delete_boq_file and $delete_boq) {

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
        redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$contract_id"));

    }

    public function file_upload($id)
    {

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $contract_id = contract_id_module("boq", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $boq_code = get_from_id("boq", "dosya_no", $id);


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$contract_code/boq/$boq_code";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Boq_file_model->add(
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
        $fileName = $this->Boq_file_model->get(
            array(
                "id" => $id
            )
        );

        $boq_id = get_from_id("boq_files", "boq_id", $id);
        $contract_id = contract_id_module("boq", $boq_id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $contract_code = contract_code($contract_id);
        $boq_code = get_from_id("boq", "dosya_no", $boq_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Boq/$boq_code/$fileName->img_url";

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

    public function download_all($boq_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $contract_id = get_from_id("boq", "contract_id", "$boq_id");
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $Boq_code = get_from_id("boq", "dosya_no", "$boq_id");
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $contract_name = contract_name($contract_id);

        $path = "uploads/project_v/$project_code/$contract_code/Boq/$Boq_code";
        echo $path;

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $contract_name . "-" . $Boq_code;
        $this->zip->download("$zip_name");

    }

    public function refresh_file_list($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->item = $this->Boq_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Boq_file_model->get_all(
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

        $fileName = $this->Boq_file_model->get(
            array(
                "id" => $id
            )
        );


        $boq_id = get_from_id("boq_files", "boq_id", $id);
        $contract_id = contract_id_module("boq", $boq_id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $boq_code = get_from_id("boq", "dosya_no", $boq_id);

        $delete = $this->Boq_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Boq/$boq_code/$fileName->img_url";

            unlink($path);

            $viewData->item = $this->Boq_model->get(
                array(
                    "id" => $boq_id
                )
            );

            $viewData->item_files = $this->Boq_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $boq_id
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

        $contract_id = contract_id_module("boq", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $boq_code = get_from_id("boq", "dosya_no", $id);

        $delete = $this->Boq_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->File_Dir_Prefix/$project_code/$contract_code/Boq/$boq_code");

            foreach ($dir_files as $dir_file) {
                unlink("$this->File_Dir_Prefix/$project_code/$contract_code/Boq/$boq_code/$dir_file");
            }

            $viewData->item = $this->Boq_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Boq_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

            echo $render_html;


        }
    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "MTJ-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
