<?php

class Sitewallet extends CI_Controller
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
        $this->viewFolder = "sitewallet_v";
        $this->load->model("Sitewallet_model");
        $this->load->model("Sitewallet_file_model");
        $this->load->model("Auction_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");
        $this->load->model("Site_model");
        $this->load->model("Workgroup_model");

        $this->Module_Name = "Sitewallet";
        $this->Module_Title = "Şantiye Cüzdanı";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "site";
        $this->Module_File_Dir = "Wallet";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "sitewallet_id";
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
        $items = $this->Sitewallet_model->get_all(array());
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
        $items = $this->Sitewallet_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $viewData->prep_auctions = $prep_auctions;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($pid = null)
    {

        if ($pid == null) {
            $pid = $this->input->post("site_id");
        }
        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Sitewallet_model->get_all(array());
        $site = $this->Site_model->get(array("id" => $pid));
        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->site = $site;
        $viewData->pid = $pid;
        $viewData->settings = $settings;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function new_form_deposit($pid = null)
    {

        if ($pid == null) {
            $pid = $this->input->post("site_id");
        }
        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Sitewallet_model->get_all(array());
        $site = $this->Site_model->get(array("id" => $pid));
        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add_deposit";
        $viewData->items = $items;
        $viewData->site = $site;
        $viewData->pid = $pid;
        $viewData->settings = $settings;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {

        $viewData = new stdClass();

        $site = get_from_any("sitewallet", "site_id", "id", "$id");
$users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $site = $this->Site_model->get(array("id" => $site));
        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->users = $users;
        $viewData->site = $site;
        $viewData->settings = $settings;


        $viewData->item = $this->Sitewallet_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Sitewallet_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_deposit_form($id)
    {

        $viewData = new stdClass();

        $site = get_from_any("sitewallet", "site_id", "id", "$id");
$users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $site = $this->Site_model->get(array("id" => $site));
        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update_deposit";
        $viewData->users = $users;
        $viewData->site = $site;
        $viewData->settings = $settings;


        $viewData->item = $this->Sitewallet_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Sitewallet_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {

        $site_id = get_from_any("sitewallet", "site_id", "id", "$id");
        $site_code = get_from_any("site", "dosya_no", "id", "$site_id");
        $proje_id = get_from_any("site", "proje_id", "id", $site_id);
        $contract_id = get_from_any("site", "contract_id", "id", $site_id);
        $viewData = new stdClass();

        echo get_from_any("site", "proje_id", "id", "$id");

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->proje_id = $proje_id;
        $viewData->contract_id = $contract_id;
        $viewData->site_code = $site_code;
        $viewData->site_id = $site_id;


        $viewData->viewModule = $this->moduleFolder;

        $viewData->item = $this->Sitewallet_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Sitewallet_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save_expenses($site_id)
    {
        $site_code = get_from_id("site", "dosya_no", $site_id);
        $proje_id = project_id_site($site_id);
        $project_code = project_code($proje_id);

        $path = "$this->File_Dir_Prefix/$project_code/$site_code/Sitewallet/";

        if (!is_dir($path)) {
            mkdir("$path", 0777, TRUE);
            echo "oluştu";
        } else {
            echo "aynı isimde dosya mevcut";
        }

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $config["allowed_types"] = "*";
        $config["upload_path"] = "$path";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        echo "bak bakalım";
        die();

        $expenses = $this->input->post("expenses[]");

        $expenses_filter = array();
        $i = 1;
        foreach ($expenses as $expense) {
            $arr = array("id" => $i++);
            if (!empty($expense["tutar"])) {
                $expenses_filter[] = $arr + $expense;
            }
        }

        $sum = array_sum(array_column($expenses_filter, "tutar"));


        $file_name_len = file_name_digits();
        $file_name = "SH-" . $this->input->post('dosya_no');

        print_r($expenses_filter);

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
            $site_code = get_from_id("site", "dosya_no", $id);
            $proje_id = get_from_id("site", "proje_id", $id);
            $project_code = get_from_id("projects", "proje_kodu", $proje_id);
            $contract_id = get_from_id("site", "contract_id", $id);

            if ($contract_id != 0) {
                $contract_code = get_from_id("contract", "dosya_no", $contract_id);
                echo $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/wallet/$file_name";
            } else {
                echo $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/wallet/$file_name";
            }

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "Dosya Oluşturulamadı";
                echo $path;
            }

            $insert = $this->Sitewallet_model->add(
                array(
                    "dosya_no" => $file_name,
                    "site_id" => $id,
                    "expenses" => json_encode($expenses_filter),
                    "createdAt" => date("Y-m-d"),
                    "createdBy" => active_user_id(),
                    "total" => $sum,
                    "type" => 0,

                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_project_id" => $id,
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

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form verilerinde eksik veya hatalı giriş var.",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $site = $this->Site_model->get(array("site_id" => $id));

            $viewData->settings = $settings;

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->pid = $id;
            $viewData->site = $site;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function save_deposit($id)
    {

        $deposits = $this->input->post("deposits[]");

        $deposits_filter = array();
        $i = 1;
        foreach ($deposits as $deposit) {
            $arr = array("id" => $i++);
            if (!empty($deposit["tutar"])) {

                $deposits_filter[] = $arr + $deposit;
            }
        }


        $sum = array_sum(array_column($deposits_filter, "tutar"));

        $file_name_len = file_name_digits();
        $file_name = "SH-" . $this->input->post('dosya_no');

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

            $site_code = get_from_id("site", "dosya_no", $id);
            $proje_id = get_from_id("site", "proje_id", $id);
            $project_code = get_from_id("projects", "proje_kodu", $proje_id);
            $contract_id = get_from_id("site", "contract_id", $id);

            if ($contract_id != 0) {
                $contract_code = get_from_id("contract", "dosya_no", $contract_id);
                echo $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/wallet/$file_name";
            } else {
                echo $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/wallet/$file_name";
            }

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "Dosya Oluşturulamadı";
                echo $path;
            }

            $insert = $this->Sitewallet_model->add(
                array(
                    "dosya_no" => $file_name,
                    "site_id" => $id,
                    "deposits" => json_encode($deposits_filter),
                    "createdAt" => date("Y-m-d"),
                    "createdBy" => active_user_id(),
                    "total" => $sum,
                    "type" => 1,
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_project_id" => $id,
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

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form verilerinde eksik veya hatalı giriş var.",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $site = $this->Site_model->get(array("site_id" => $id));

            $viewData->settings = $settings;

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->pid = $id;
            $viewData->site = $site;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function update($id)
    {
        $expenses = $this->input->post("expenses[]");

        $expenses_filter = array();

        $i = 1;
        foreach ($expenses as $expense) {
            $arr = array("id" => $i++);
            if (!empty($expense["tutar"])) {
                $expenses_filter[] = $arr + $expense;
            }
        }

        $sum = array_sum(array_column($expenses_filter, "tutar"));

        $update = $this->Sitewallet_model->update(
            array(
                "id" => $id
            ),
            array(
                "expenses" => json_encode($expenses_filter),
                "createdAt" => date("Y-m-d"),
                "createdBy" => active_user_id(),
                "total" => $sum,
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
    }

    public function delete($id)
    {
        $wallet_id = $id;
        $dosya_no = get_from_any("sitewallet", "dosya_no", "id", $wallet_id);
        $site_id = get_from_any("sitewallet", "site_id", "id", $wallet_id);
        $contract_id = get_from_id("site", "contract_id", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/wallet/$dosya_no";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/wallet/$dosya_no";
        }

        $sil = deleteDirectory($path);


        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        $delete1 = $this->Sitewallet_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $delete2 = $this->Sitewallet_model->delete(
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
        redirect(base_url("project/$this->Display_route/$project_id"));
    }

    public function file_upload($id)
    {
        $dosya_no = get_from_any("sitewallet", "dosya_no", "id", $id);
        $site_id = get_from_any("sitewallet", "site_id", "id", $id);
        $contract_id = get_from_id("site", "contract_id", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/wallet/$dosya_no";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/wallet/$dosya_no";
        }

        if (!is_dir($path)) {
            mkdir("$path", 0777, TRUE);
            echo "oluştu";
        } else {
            echo "aynı isimde dosya mevcut";
        }

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $extention = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$path";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);


        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");


        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Sitewallet_file_model->add(
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

    public function file_download($id, $from)
    {
        $fileName = $this->Sitewallet_file_model->get(
            array(
                "id" => $id
            )
        );


        $wallet_id = get_from_any("sitewallet_files", "sitewallet_id", "id", $id);
        $dosya_no = get_from_any("sitewallet", "dosya_no", "id", $wallet_id);
        $site_id = get_from_any("sitewallet", "site_id", "id", $wallet_id);
        $contract_id = get_from_id("site", "contract_id", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/wallet/$dosya_no";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/wallet/$dosya_no";
        }

        $file_path = "$path/$file_path->img_url";

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

    public function refresh_file_list($id, $from)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$from";


        $viewData->item_files = $this->Sitewallet_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id, $from)
    {

        $fileName = $this->Sitewallet_file_model->get(
            array(
                "id" => $id
            )
        );

        $wallet_id = get_from_any("sitewallet_files", "sitewallet_id", "id", $id);
        $dosya_no = get_from_any("sitewallet", "dosya_no", "id", $wallet_id);
        $site_id = get_from_any("sitewallet", "site_id", "id", $wallet_id);
        $contract_id = get_from_id("site", "contract_id", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/wallet/$dosya_no";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/wallet/$dosya_no";
        }

        $delete = $this->Sitewallet_file_model->delete(
            array(
                "id" => $id
            )
        );

        if ($delete) {

            $path = "$path/$fileName->img_url";

            unlink($path);

            redirect(base_url("$this->Module_Name/$from/$wallet_id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$wallet_id"));

        }

    }

    public function fileDelete_all($id, $from)
    {

        $wallet_id = $id;
        $dosya_no = get_from_any("sitewallet", "dosya_no", "id", $wallet_id);
        $site_id = get_from_any("sitewallet", "site_id", "id", $wallet_id);
        $contract_id = get_from_id("site", "contract_id", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/wallet/$dosya_no";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/wallet/$dosya_no";
        }

        $delete = $this->Sitewallet_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$path");

            foreach ($dir_files as $dir_file) {
                unlink("$path/$dir_file");
            }

            redirect(base_url("$this->Module_Name/$from/$id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$id"));

        }

    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "SH-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
