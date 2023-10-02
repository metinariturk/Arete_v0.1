<?php

class Safetystock extends CI_Controller
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
        $items = $this->Sitestock_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->prep_auctions = $prep_auctions;        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
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
        $viewData->prep_auctions = $prep_auctions;        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($pid = null)
    {

        if ($pid == null) {
            $pid = $this->input->post("site_id");
        }
        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Sitestock_model->get_all(array());
        $site = $this->Site_model->get(array("id" => $pid));
        $settings = $this->Settings_model->get();
        $suppliers = $this->Company_model->get_all(array(
            "company_role" => 3
        ));


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->site = $site;
        $viewData->pid = $pid;
        $viewData->settings = $settings;
        $viewData->suppliers = $suppliers;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {
        $viewData = new stdClass();

        $site = get_from_any("sitestock", "site_id", "id", "$id");
$users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $site = $this->Site_model->get_site($site);
        $suppliers = $this->Company_model->get_all(array(
            "company_role" => 3
        ));
        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->users = $users;
        $viewData->site = $site;
        $viewData->settings = $settings;

        $viewData->suppliers = $suppliers;


        $viewData->item = $this->Sitestock_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Sitestock_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function expensing_form($id)
    {

        $viewData = new stdClass();

        $site = get_from_any("sitestock", "site_id", "id", "$id");
$users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $site = $this->Site_model->get_site($site);
        $suppliers = $this->Company_model->get_all(array(
            "company_role" => 3
        ));
        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "expencing";
        $viewData->users = $users;
        $viewData->site = $site;
        $viewData->settings = $settings;

        $viewData->suppliers = $suppliers;


        $viewData->item = $this->Sitestock_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Sitestock_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {

        $site_id = get_from_any("sitestock", "site_id", "id", "$id");
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

        $viewData->item = $this->Sitestock_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Sitestock_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );

        $viewData->viewModule = $this->moduleFolder;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($id)
    {
        $supplies = $this->input->post("supplies[]");

        $supplies_filter = array();
        $i = 1;
        foreach ($supplies as $supply) {
            $arr = array("id" => $i++);
            if (!empty($supply["product_name"])) {
                $supplies_filter[] = $arr + $supply;
            }
        }


        $file_name_len = file_name_digits();
        $file_name = "ST-" . $this->input->post('dosya_no');

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

            echo $site_code = get_from_id("site", "dosya_no", $id);
            echo "<br>";
            echo $proje_id = get_from_id("site", "proje_id", $id);
            echo "<br>";
            echo $project_code = get_from_id("projects", "proje_kodu", $proje_id);
            echo "<br>";
            echo $contract_id = get_from_id("site", "contract_id", $id);
            echo "<br>";

            $stock_date = $this->input->post("arrival_date");
            if ($contract_id != 0) {
                $contract_code = get_from_id("contract", "dosya_no", $contract_id);
                echo $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/sitestocks/$stock_date";
            } else {
                echo $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/sitestocks/$stock_date";
            }

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "Dosya Oluşturulamadı";
                echo $path;
            }

            $insert = $this->Sitestock_model->add(
                array(
                    "dosya_no" => $file_name,
                    "arrival_date" => $sitestock_date,
                    "site_id" => $id,
                    "supplies" => json_encode($supplies_filter),
                    "createdAt" => date("Y-m-d H:i:s"),
"createdBy" => active_user_id(),
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
            $site = $this->Site_model->get(array("id" => $id));
            $suppliers = $this->Company_model->get_all(array(
            "company_role" => 3
        ));


            $viewData->settings = $settings;

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->pid = $id;
            $viewData->site = $site;
            $viewData->suppliers = $suppliers;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function update($id)
    {
        $supplies = $this->input->post("supplies[]");

        $supplies_filter = array();
        $this->load->library("form_validation");

        $i = 101;
        foreach ($supplies as $supply) {

            $arr = array("id" => $i++);
            if (empty($supply["id"])) {
                if (!empty($supply["product_name"])) {
                    $supplies_filter[] = $arr + $supply;
                }
            } elseif (!empty($supply["id"])) {
                $supplies_filter[] = $supply;
            }
        }

        if ($this->input->post("arrival_date")) {
            $sitestock_date = dateFormat('Y-m-d', $this->input->post("arrival_date"));
        } else {
            $sitestock_date = null;
        }


        $this->form_validation->set_rules("arrival_date", "Stok Giriş Tarihi", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $update = $this->Sitestock_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "arrival_date" => $sitestock_date,
                    "supplies" => json_encode($supplies_filter),
                    "createdBy" => active_user_id(),
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


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->form_error = true;
            $viewData->settings = $settings;


            $viewData->item = $this->Sitestock_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Sitestock_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                ),
            );

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function expencing($id)
    {
        $old_consume = get_from_any("sitestock", "consume", "id", "$id");

        $consumes = $this->input->post("consume[]");

        $old_consume_array = (json_decode($old_consume, true));


        $array_filter = array();
        foreach ($consumes as $consume) {
            if ((!empty($consume["qty"])) and ($consume["qty"] > 0)) {
                array_push($array_filter, $consume);
            }
        }

        if (!empty($old_consume_array)) {
            $a = $array_filter + $old_consume_array;
            $b = array_merge($array_filter, $old_consume_array);
        } else {
            $b = $array_filter;
        }



        $update = $this->Sitestock_model->update(
            array(
                "id" => $id
            ),
            array(
                "consume" => json_encode($b),
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
        $sitestock_id = $id;
        $sitestock_date = dateFormat_dmy(get_from_any("sitestock", "arrival_date", "id", $sitestock_id));
        $site_id = get_from_any("sitestock", "site_id", "id", $sitestock_id);
        $contract_id = get_from_id("site", "contract_id", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/sitestocks/$sitestock_date";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/sitestocks/$sitestock_date";
        }

        $sil = deleteDirectory($path);


        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        $delete1 = $this->Sitestock_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $delete2 = $this->Sitestock_model->delete(
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
        $sitestock_date = dateFormat_dmy(get_from_any("sitestock", "arrival_date", "id", $id));
        $site_id = get_from_any("sitestock", "site_id", "id", $id);
        $contract_id = get_from_id("site", "contract_id", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/sitestocks/$sitestock_date";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/sitestocks/$sitestock_date";
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

            $this->Sitestock_file_model->add(
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
        $fileName = $this->Sitestock_file_model->get(
            array(
                "id" => $id
            )
        );

        

        $sitestock_id = get_from_any("sitestock_files", "sitestock_id", "id", $id);
        $sitestock_date = dateFormat_dmy(get_from_any("sitestock", "arrival_date", "id", $sitestock_id));
        $site_id = get_from_any("sitestock", "site_id", "id", $sitestock_id);
        $contract_id = get_from_id("site", "contract_id", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/sitestocks/$sitestock_date";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/sitestocks/$sitestock_date";
        }

        $file_path = "$path/$fileName->img_url";

        if ($file_path) {

            if (file_exists($file_path)) {
                $data = file_get_contents($file_path);
                force_download($fileName->img_url, $data); }
                 else {
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


        $viewData->item_files = $this->Sitestock_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id, $from)
    {

        $fileName = $this->Sitestock_file_model->get(
            array(
                "id" => $id
            )
        );

        $sitestock_id = get_from_any("sitestock_files", "sitestock_id", "id", $id);
        $sitestock_date = dateFormat_dmy(get_from_any("sitestock", "arrival_date", "id", $sitestock_id));
        $site_id = get_from_any("sitestock", "site_id", "id", $sitestock_id);
        $contract_id = get_from_id("site", "contract_id", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/sitestocks/$sitestock_date";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/sitestocks/$sitestock_date";
        }

        $delete = $this->Sitestock_file_model->delete(
            array(
                "id" => $id
            )
        );

        if ($delete) {

            $path = "$path/$fileName->img_url";

            unlink($path);

            redirect(base_url("$this->Module_Name/$from/$sitestock_id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$sitestock_id"));

        }

    }

    public function fileDelete_all($id, $from)
    {

        $sitestock_id = $id;
        $sitestock_date = dateFormat_dmy(get_from_any("sitestock", "arrival_date", "id", $sitestock_id));
        $site_id = get_from_any("sitestock", "site_id", "id", $sitestock_id);
        $contract_id = get_from_id("site", "contract_id", $site_id);

        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/site/$site_code/sitestocks/$sitestock_date";
        } else {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $site_code = get_from_id("site", "dosya_no", $site_id);
            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/site/$site_code/sitestocks/$sitestock_date";
        }

        $delete = $this->Sitestock_file_model->delete(
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
        $file_name = "ST-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
