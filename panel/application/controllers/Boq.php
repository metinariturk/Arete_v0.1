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
        $this->Theme_mode = get_active_user()->mode;
        if (temp_pass_control()) {
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

    public function new_form($contract_id = null, $payment_no = null, $boq_id = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        if (empty($payment_no)) {
            if (empty($contract_id)) {
                $contract_id = $this->input->post("contract_id");
                if (empty($contract_id)) {
                    redirect(base_url("dashboard"));
                } else {
                    redirect(base_url("contract/file_form/$contract_id/payment"));
                }
            } elseif (count_payments($contract_id) == 0) {
                $payment_no = 1;
            } else {
                $payment_no = last_payment($contract_id) + 1;
            }
        }


        $contract = $this->Contract_model->get(array(
                "id" => $contract_id
            )
        );

        $payment_id = get_from_any_and("payment","contract_id","$contract_id","hakedis_no","$payment_no");

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */

        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->payment_no = $payment_no;
        $viewData->payment_id = $payment_id;
        $viewData->contract = $contract;
        $viewData->boq_id = $boq_id;
        $viewData->settings = $settings;
        $viewData->contract_id = $contract_id;

        if ((!empty($this->input->post("contract_id"))) or !empty($contract_id)) {
            $viewData->project_id = project_id_cont($contract_id);
        }
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }


    public function file_form($id, $active_tab = null)
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

        $viewData->active_tab = $active_tab;

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

    public function calculate_render($contract_id, $payment_no, $boq_id)
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();


        $isset_boq =
            get_from_any_and_and("boq",
                "contract_id", "$contract_id",
                "payment_no", "$payment_no",
                "boq_id", $boq_id);


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $viewData->income = $boq_id;
        if (isset($isset_boq)) {
            $old_boq = $this->Boq_model->get(
                array(
                    "id" => $isset_boq,
                )
            );
            $viewData->old_boq = $old_boq;

        }
        $viewData->payment_no = $payment_no;
        $viewData->contract_id = $contract_id;

        $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/calculate", $viewData, true);

        echo $render_calculate;
    }

    public function select_group($contract_id, $payment_no, $group_id = null)
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        $contract = $this->Contract_model->get(
            array(
                "id" => $contract_id
            ),
        );

        $active_boq = $contract->active_boq;
        $active_boqs = json_decode($active_boq, true);

        if (!empty($group_id)){
            $gorup_items = ($active_boqs[$group_id]);
            $viewData->gorup_items = $gorup_items;
        } else {
            $gorup_items = null;
            $viewData->gorup_items = $gorup_items;
        }

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";


        $viewData->payment_no = $payment_no;
        $viewData->contract = $contract;
        $viewData->contract_id = $contract_id;



        if (!empty($group_id)){
            $renderGroup = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/renderGroup", $viewData, true);
        } else {
            $renderGroup = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/renderList", $viewData, true);
        }

        echo $renderGroup;
    }

    public function save($contract_id = null, $payment_no = null, $stay = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $total_bypass = $this->input->post('bypass_total');

        $boq_id = ($this->input->post('boq_id'));

        $old_record = get_from_any_and_and(
            "boq",
            "contract_id", "$contract_id",
            "payment_no", "$payment_no",
            "boq_id", "$boq_id"
        );


        $boq_array = ($this->input->post('boq[]'));

        if ($total_bypass == "on") {
            $boq_total = ($this->input->post("total_$boq_id"));
            echo $boq_total;
        } else {
            $boq_total = 0.0;
            foreach ($boq_array as $item) {
                if (isset($item['t'])) {
                    $boq_total += (float)$item['t'];
                }
            }
        }

        foreach ($boq_array as $key => $sub_array) {
            if (empty(array_filter($sub_array))) {
                unset($boq_array[$key]);
            }
        }

        if (isset($old_record)) {
            $update = $this->Boq_model->update(
                array(
                    "id" => $old_record
                ),
                array(
                    "calculation" => json_encode($boq_array),
                    "total" => $boq_total,
                    "createdAt" => date("Y-m-d H:i:s"),
                )
            );
            if ($update) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Metraj başarılı bir şekilde güncellendi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Metraj Güncelleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }

        } else {
            $insert = $this->Boq_model->add(
                array(
                    "contract_id" => $contract_id,
                    "boq_id" => $boq_id,
                    "payment_no" => $payment_no,
                    "calculation" => json_encode($boq_array),
                    "total" => $boq_total,
                    "createdAt" => date("Y-m-d H:i:s"),
                )
            );
            if ($insert) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Metraj başarılı bir şekilde eklendi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Metraj Ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }

        }

        // İşlemin Sonucunu Session'a yazma işlemi...
        $this->session->set_flashdata("alert", $alert);

        $viewData = new stdClass();


        $isset_boq =
            get_from_any_and_and("boq",
                "contract_id", "$contract_id",
                "payment_no", "$payment_no",
                "boq_id", $boq_id);


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $viewData->income = $boq_id;
        if (isset($isset_boq)) {
            $old_boq = $this->Boq_model->get(
                array(
                    "id" => $isset_boq,
                )
            );
            $viewData->old_boq = $old_boq;

        }
        $viewData->payment_no = $payment_no;
        $viewData->contract_id = $contract_id;

        if ($stay != null){
            $payment_id = get_from_any_and("payment","contract_id","$contract_id","hakedis_no","$payment_no");
            redirect(base_url("payment/file_form/$payment_id"));
        }

        $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/calculate", $viewData, true);

        echo $render_calculate;
        //kaydedilen elemanın id nosunu döküman ekleme sayfasına post ediyoruz
    }


    public
    function delete($id)
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

    public
    function file_upload($id)
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

    public
    function file_download($id)
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

    public
    function download_all($boq_id)
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

    public
    function refresh_file_list($id)
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

    public
    function fileDelete($id)
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

    public
    function fileDelete_all($id)
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

    public
    function duplicate_code_check($file_name)
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
