<?php

class Report extends CI_Controller
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

        $this->moduleFolder = "site_module";
        $this->viewFolder = "report_v";
        $this->load->model("Report_model");
        $this->load->model("Report_file_model");
        $this->load->model("Auction_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");
        $this->load->model("Site_model");
        $this->load->model("Workgroup_model");
        $this->load->model("Contract_model");

        $this->Module_Name = "Report";
        $this->Module_Title = "Şantiye Günlük Raporu";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "site";
        $this->Module_File_Dir = "Report";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "report_id";
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
        $items = $this->Report_model->get_all(array());
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
        $items = $this->Report_model->get_all(array());
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

        $project_id = project_id_site($site_id);


        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $active_sites = $this->Site_model->get_all(array());
        $site = $this->Site_model->get(array("id" => $site_id));

        $active_machines = json_decode($site->active_machine, true);
        $active_workgroups = json_decode($site->active_group, true);


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";

        $viewData->project_id = $project_id;
        $viewData->active_sites = $active_sites;
        $viewData->active_machines = $active_machines;
        $viewData->active_workgroups = $active_workgroups;

        $viewData->site = $site;
        $viewData->site_id = $site_id;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function update_form($id)
    {
        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Report_supply_model");

        $viewData = new stdClass();
        $workgroups = $this->Report_workgroup_model->get_all(array("report_id" => $id));
        $workmachines = $this->Report_workmachine_model->get_all(array("report_id" => $id));
        $site_id = get_from_any("report", "site_id", "id", "$id");
        $project_id = project_id_site($site_id);
        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $site = $this->Site_model->get(array("id" => $site_id));

        $active_machines = json_decode($site->active_machine, true);
        $active_workgroups = json_decode($site->active_group, true);

        $supplies = $this->Report_supply_model->get_all(array("report_id" => $id));

        $active_sites = $this->Site_model->get_all(array());


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->users = $users;
        $viewData->site = $site;
        $viewData->active_machines = $active_machines;
        $viewData->active_workgroups = $active_workgroups;
        $viewData->project_id = $project_id;
        $viewData->active_sites = $active_sites;
        $viewData->workgroups = $workgroups;
        $viewData->workmachines = $workmachines;
        $viewData->supplies = $supplies;
        $viewData->item = $this->Report_model->get(
            array(
                "id" => $id
            )
        );


        $viewData->item_files = $this->Report_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {

        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Report_supply_model");
        $this->load->model("Report_weather_model");

        $item = $this->Report_model->get(array("id" => $id));


        $site_id = get_from_any("report", "site_id", "id", "$id");
        $proje_id = get_from_any("site", "proje_id", "id", $site_id);

        $workgroups = $this->Report_workgroup_model->get_all(array("report_id" => $id));
        $weather = $this->Report_weather_model->get(array("date" => $item->report_date));
        $workmachines = $this->Report_workmachine_model->get_all(array("report_id" => $id));
        $supplies = $this->Report_supply_model->get_all(array("report_id" => $id));

        $site = $this->Site_model->get(array(
            "id" => $site_id
        ));

        $project = $this->Project_model->get(array(
            "id" => $proje_id
        ));

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->item = $item;
        $viewData->proje_id = $proje_id;
        $viewData->weather = $weather;
        $viewData->workgroups = $workgroups;
        $viewData->workmachines = $workmachines;
        $viewData->supplies = $supplies;
        $viewData->site = $site;
        $viewData->project = $project;

        $viewData->item = $this->Report_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Report_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($site_id)
    {
        $site = $this->Site_model->get(array("id" => $site_id));

        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Report_supply_model");

        $workgroups = $this->input->post("workgroups[]");
        $workmachine = $this->input->post("workmachine[]");
        $supplies = $this->input->post("supplies[]");

        $workgroups_filter = array();
        foreach ($workgroups as $workgroup) {
            if (!empty($workgroup["workgroup"])) {
                $workgroups_filter[] = $workgroup;
            }
        }

        $workmachine_filter = array();
        foreach ($workmachine as $workmachine) {
            if (!empty($workmachine["workmachine"])) {
                $workmachine_filter[] = $workmachine;
            }
        }

        $supplies_filter = array();
        foreach ($supplies as $supply) {
            if (!empty($supply["supply"])) {
                $supplies_filter[] = $supply;
            }
        }

        $file_name_len = file_name_digits();
        $file_name = "GR-" . $this->input->post('dosya_no');

        if ($this->input->post("report_date")) {
            $report_date = dateFormat('Y-m-d', $this->input->post("report_date"));
        } else {
            $report_date = null;
        }

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[report.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("report_date", "Rapor Tarihi", "required|trim");

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

            $rep_date = $this->input->post("report_date");

            $project_code = project_code($site->project_id);
            $path = "$this->File_Dir_Prefix/$project_code/$site->dosya_no/Reports/$rep_date";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "Dosya Oluşturulamadı";
                echo $path;
            }

            $off_days = ($this->input->post("off_days") == 0) ? "1" : "";

            $insert_report = $this->Report_model->add(
                array(
                    "site_id" => $site_id,
                    "project_id" => $site->proje_id,
                    "contract_id" => $site->contract_id,
                    "report_date" => $report_date,
                    "createdAt" => date("Y-m-d"),
                    "createdBy" => active_user_id(),
                    "off_days" => $off_days,
                )
            );

            $report_id = $this->db->insert_id();

            foreach ($workgroups_filter as $workgroup) {
                $insert_workgroup = $this->Report_workgroup_model->add(
                    array(
                        "site_id" => $site_id,
                        "report_id" => $report_id,
                        "project_id" => $site->proje_id,
                        "contract_id" => $site->contract_id,
                        "workgroup" => $workgroup['workgroup'],
                        "number" => $workgroup['worker_count'],
                        "notes" => $workgroup['notes'],
                        "place" => $workgroup['place'],
                        "createdBy" => active_user_id(),
                    )
                );
            }

            foreach ($workmachine_filter as $workmachine) {
                $insert_workmachine = $this->Report_workmachine_model->add(
                    array(
                        "site_id" => $site_id,
                        "report_id" => $report_id,
                        "project_id" => $site->proje_id,
                        "contract_id" => $site->contract_id,
                        "workmachine" => $workmachine['workmachine'],
                        "number" => $workmachine['machine_count'],
                        "notes" => $workmachine['machine_notes'],
                        "place" => $workmachine['machine_place'],
                        "createdBy" => active_user_id(),
                    )
                );
            }

            foreach ($supplies_filter as $supplies) {
                $insert_workmachine = $this->Report_supply_model->add(
                    array(
                        "site_id" => $site_id,
                        "report_id" => $report_id,
                        "project_id" => $site->proje_id,
                        "contract_id" => $site->contract_id,
                        "supply" => $supplies['supply'],
                        "qty" => $supplies['qty'],
                        "unit" => $supplies['unit'],
                        "place" => null,
                        "notes" => $supplies['supply_notes'],
                        "createdBy" => active_user_id(),
                    )
                );
            }

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $report_id,
                    "connected_project_id" => $site->proje_id,
                    "file_order" => $file_name,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                )
            );

            // TODO Alert sistemi eklenecek...
            if ($insert_report) {

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

            $this->load->model("Weather_model");

            $weather = $this->Weather_model->get(array('date' => $report_date));

            if (isset($weather)) {
                redirect(base_url("$this->Module_Name/$this->Display_route/$report_id"));
            } else {
                redirect(base_url("weather"));
            }

            redirect(base_url("$this->Module_Name/$this->Display_route/$report_id"));

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

            $viewData->settings = $settings;

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->site = $site;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update($id)
    {
        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Report_supply_model");

        $workgroups = $this->input->post("workgroups[]");
        $workmachine = $this->input->post("workmachine[]");
        $supplies = $this->input->post("supplies[]");

        $workgroups_filter = array();
        foreach ($workgroups as $workgroup) {
            if (!empty($workgroup["workgroup"])) {
                $workgroups_filter[] = $workgroup;
            }
        }

        $workmachine_filter = array();
        foreach ($workmachine as $workmachine) {
            if (!empty($workmachine["workmachine"])) {
                $workmachine_filter[] = $workmachine;
            }
        }

        $supplies_filter = array();
        foreach ($supplies as $supply) {
            if (!empty($supply["supply"])) {
                $supplies_filter[] = $supply;
            }
        }


        if ($this->input->post("report_date")) {
            $report_date = dateFormat('Y-m-d', $this->input->post("report_date"));
        } else {
            $report_date = null;
        }

        $off_days = ($this->input->post("off_days") == 0) ? "1" : "";

        $report = $this->Report_model->get(array("id" => $id));

        $update = $this->Report_model->update(
            array(
                "id" => $id
            ),
            array(
                "report_date" => $report_date,
                "aciklama" => $this->input->post("note"),
                "createdAt" => date("Y-m-d"),
                "createdBy" => active_user_id(),
                "off_days" => $off_days

            )
        );

        foreach ($workgroups_filter as $workgroup) {
            $update_workgroup = $this->Report_workgroup_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "workgroup" => $workgroup['workgroup'],
                    "number" => $workgroup['worker_count'],
                    "notes" => $workgroup['notes'],
                    "place" => $workgroup['place'],
                    "createdBy" => active_user_id(),
                )
            );
        }

        foreach ($workmachine_filter as $workmachine) {
            $update_workmachine = $this->Report_workmachine_model->update(
                array(
                    "id" => $id
                ), array(
                    "workmachine" => $workmachine['workmachine'],
                    "number" => $workmachine['machine_count'],
                    "notes" => $workmachine['machine_notes'],
                    "place" => $workmachine['machine_place'],
                    "createdBy" => active_user_id(),
                )
            );
        }

        foreach ($supplies_filter as $supplies) {
            $update_workmachine = $this->Report_supply_model->update(
                array(
                    "id" => $id
                ), array(
                    "supply" => $supplies['supply'],
                    "qty" => $supplies['qty'],
                    "unit" => $supplies['unit'],
                    "place" => null,
                    "notes" => $supplies['supply_notes'],
                    "createdBy" => active_user_id(),
                )
            );
        }

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

    public function delete($report_id)
    {
        $report_date = dateFormat_dmy(get_from_any("report", "report_date", "id", $report_id));
        $site_id = get_from_any("report", "site_id", "id", $report_id);

        $project_id = get_from_id("site", "proje_id", $site_id);
        $project_code = project_code($project_id);
        $site_code = get_from_id("site", "dosya_no", $site_id);
        $path = "$this->File_Dir_Prefix/$project_code/$site_code/Reports/$report_date";

        $sil = deleteDirectory($path);

        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        $delete1 = $this->Report_file_model->delete(
            array(
                "$this->Dependet_id_key" => $report_id
            )
        );

        $delete2 = $this->Report_model->delete(
            array(
                "id" => $report_id
            )
        );

        $file_order_id = get_from_any_and("file_order", "connected_module_id", $report_id, "module", $this->Module_Name);
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
        redirect(base_url("site/$this->Display_route/$site_id"));
    }

    public function file_upload($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $report = $this->Report_model->get(array("id" => $id));
        $site = $this->Site_model->get(array("id" => $report->site_id));
        $old_file = $this->Report_file_model->get_last(array("report_id" => $id));
        $extention = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

        $file_name = $report->report_date . '-' . ($old_file->rank + 1) . "." . $extention;

        $size = $_FILES["file"]["size"];

        $site_code = $site->dosya_no;
        $project_id = project_id_site($site->id);
        $project_code = project_code($project_id);
        $date = dateFormat_dmy($report->report_date);

        $config["file_name"] = $file_name;
        $config["upload_path"] = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$site_code/Reports/$date";
        if (!is_dir($config["upload_path"])) {
            mkdir($config["upload_path"], 0777, TRUE);
        }
        $folder = $config["upload_path"];
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['overwrite'] = TRUE; // Eğer dosya zaten varsa üzerine yaz

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");
        $file_path = $folder . "/" . $file_name;

        $thumbnail_folder = $folder . "/thumbnails";

        if (!is_dir($thumbnail_folder)) {
            // "thumbnails" klasörü yoksa oluştur
            if (!mkdir($thumbnail_folder, 0777, true)) {
                echo "Failed to create thumbnails folder...";
            }
        }

        chmod($folder, 0777);

        if ($upload) {
            if ($size > 3000000) {

                $config['image_library'] = 'gd2';
                $config['source_image'] = $file_path;
                $config['new_image'] = $file_path;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 1920;
                $config['height'] = 1080;

                $this->load->library('image_lib', $config);

                if (!$this->image_lib->resize()) {
                    // Display any errors that occurred during the resize process
                    echo "Image resize error: " . $this->image_lib->display_errors();
                } else {
                    echo "Image resized successfully.";
                }

            } else {
                echo "Dosya yükleme başarılı, ancak boyut küçültmeye gerek yok.";
            }

            $thumbnail_config['image_library'] = 'gd2';
            $thumbnail_config['source_image'] = $file_path;
            $thumbnail_config['new_image'] = $thumbnail_folder . "/" . $file_name; // Thumbnail'ı belirtilen yere kaydet
            $thumbnail_config['create_thumb'] = TRUE;
            $thumbnail_config['maintain_ratio'] = TRUE;
            $thumbnail_config['thumb_marker'] = NULL; // Thumbnail dosyasının adına eklenecek özel işaret, NULL kullanılarak devre dışı bırakılır
            $thumbnail_config['width'] = 800; // Thumbnail için özel genişlik
            $thumbnail_config['height'] = 600; // Thumbnail için özel yükseklik

            $this->load->library('image_lib', $config);

            $this->image_lib->initialize($thumbnail_config);

            if (!$this->image_lib->resize()) {
                // İşlem sırasında oluşan hataları görüntüleyin
                echo "Thumbnail resize error: " . $this->image_lib->display_errors();
            } else {
                echo "Thumbnail resized successfully.";
            }

            $this->Report_file_model->add(
                array(
                    "img_url" => $file_name,
                    "report_id" => $id,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                    "$this->Dependet_id_key" => $id,
                    "size" => filesize($file_path),
                    "rank" => ($old_file->rank + 1)
                )
            );

        } else {
            echo "Dosya yükleme hatası: " . $this->upload->display_errors();
        }

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");


        } else {
            echo "islem basarisiz";
            echo $config["upload_path"];
        }

    }

    public function file_download($id)
    {
        $fileName = $this->Report_file_model->get(
            array(
                "id" => $id
            )
        );

        $report_file = $this->Report_file_model->get(array("id" => $id));
        $report = $this->Report_model->get(array("id" => $report_file->report_id));
        $date = dateFormat_dmy($report->report_date);
        $site = $this->Site_model->get(array("id" => $report->site_id));

        $project_code = project_code("$site->proje_id");


        $file_path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$site->dosya_no/Reports/$date/$fileName->img_url";

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

    public function download_all($report_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $report = $this->Report_model->get(array("id" => $report_id));
        $date = dateFormat_dmy($report->report_date);
        $site = $this->Site_model->get(array("id" => $report->site_id));

        $project_code = project_code("$site->proje_id");
        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$site->dosya_no/Reports/$date";

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = "Foto-" . $date;
        $this->zip->download("$zip_name");

    }

    public function refresh_file_list($id)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $item = $this->Report_model->get(array("id" => $id));

        $viewData->item_files = $this->Report_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $site = $this->Site_model->get(array("id" => $item->site_id));
        $project = $this->Project_model->get(array("id" => $site->proje_id));
        $viewData->project = $project;
        $viewData->site = $site;
        $viewData->item = $item;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $fileName = $this->Report_file_model->get(
            array(
                "id" => $id
            )
        );

        $report_file = $this->Report_file_model->get(array("id" => $id));
        $report = $this->Report_model->get(array("id" => $report_file->report_id));
        $site = $this->Site_model->get(array("id" => $report->site_id));
        $project = $this->Project_model->get(array("id" => $report->site_id));
        $viewData->project = $project;
        $viewData->site = $site;

        $date = dateFormat_dmy($report->report_date);

        $project_code = project_code("$site->proje_id");

        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$site->dosya_no/Reports/$date";


        $delete = $this->Report_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            $file_path = "$path/$fileName->img_url";
            $file_path_thumb = "$path/thumbnails/$fileName->img_url";

            unlink($file_path);
            unlink($file_path_thumb);

            $viewData->item = $this->Report_model->get(
                array(
                    "id" => $report->id
                )
            );

            $viewData->item_files = $this->Report_file_model->get_all(
                array(
                    "report_id" => $report->id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;

        }
    }

    public function fileDelete_all($id)
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $fileName = $this->Report_file_model->get(
            array(
                "id" => $id
            )
        );

        $report = $this->Report_model->get(array("id" => $id));
        $site = $this->Site_model->get(array("id" => $report->site_id));
        $project = $this->Project_model->get(array("id" => $report->site_id));
        $viewData->project = $project;
        $viewData->site = $site;


        $project_code = project_code("$site->proje_id");

        $date = dateFormat_dmy($report->report_date);


        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$site->dosya_no/Reports/$date";

        $delete = $this->Report_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $this->load->helper('file');
            delete_files($path, true);

            $viewData->item = $this->Report_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Report_file_model->get_all(
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
        $file_name = "GR-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public
    function print_report($report_id, $P_or_D = null)
    {
        $this->load->model("Company_model");
        $this->load->model("Report_file_model");
        $this->load->model("Report_weather_model");
        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Report_supply_model");
        $this->load->model("Report_sign_model");

        $report = $this->Report_model->get(array("id" => $report_id));
        $site = $this->Site_model->get(array("id" => $report->site_id));

        $contractor_sign = $this->Report_sign_model->get(array("site_id" => $site->id, "module" => "contractor_sign"));
        $contractor_staff = $this->Report_sign_model->get_all(array("site_id" => $site->id, "module" => "contractor_staff"));
        $owner_sign = $this->Report_sign_model->get(array("site_id" => $site->id, "module" => "owner_sign"));
        $owner_staff = $this->Report_sign_model->get_all(array("site_id" => $site->id, "module" => "owner_staff"));

        $workgroups = $this->Report_workgroup_model->get_all(array("report_id" => $report_id));
        $workmachines = $this->Report_workmachine_model->get_all(array("report_id" => $report_id));
        $supplies = $this->Report_supply_model->get_all(array("report_id" => $report_id));

        $viewData = new stdClass();
        $weather = $this->Report_weather_model->get(array("date" => $report->report_date));
        $contract = $this->Contract_model->get(array("id" => $report->contract_id));
        $project = $this->Project_model->get(array("id" => $report->project_id));

        $viewData->contract = $contract;

        $contractor = $this->Company_model->get(array("id" => $contract->yuklenici));
        $owner = $this->Company_model->get(array("id" => $contract->isveren));
        $viewData->contractor = $contractor;
        $viewData->owner = $owner;

        $yuklenici = company_name($contract->yuklenici);
        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        $page_width = $pdf->getPageWidth();

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();

        $logoPath = K_PATH_IMAGES . 'logo_example.jpg';
        $logoWidth = 50; // Logo genişliği

        $pdf->Image($logoPath, 20, 10, $logoWidth);

        $pdf->SetFont('dejavusans', 'B', 8);
        $pdf->SetXY(150, 30);
        $pdf->Cell(50, 6, "Rapor Tarihi : " . dateFormat_dmy($report->report_date), 0, 0, "R", 0);
// Çerçeve için boşlukları belirleme
        $topMargin = 30;  // 4 cm yukarıdan
        $bottomMargin = 10;  // 4 cm aşağıdan
        $rightMargin = 10;  // 2 cm sağdan
        $leftMargin = 10;  // 2 cm soldan

// Çerçeve renk ve kalınlığını ayarla
        $pdf->SetDrawColor(0, 0, 0); // Siyah renk
        $pdf->SetLineWidth(0.5); // Çizgi kalınlığı

// Çerçeve çizme
        $pdf->Rect($leftMargin, $topMargin, $pdf->getPageWidth() - $rightMargin - $leftMargin, $pdf->getPageHeight() - $bottomMargin - $topMargin);

        $pdf->SetFont('dejavusans', 'B', 12);

// Metin eklemek (örnek olarak ilk satır)
        $yPosition = $topMargin; // 5 cm yukarıdan başla
        $xPosition = $leftMargin; // 2 cm soldan başla
        $pdf->SetXY($xPosition, $yPosition);
        $pdf->SetLineWidth(0.1); // Çizgi kalınlığı
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(190, 10, 'GÜNLÜK RAPOR', 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'N', 9);
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);

        $pdf->Cell(30, 5, "Proje Adı", 0, 0, "L", 0);
        $pdf->Cell(80, 5, mb_strtoupper($project->proje_ad), 0, 0, "L", 0);
        $pdf->Cell(50, 5, "", 0, 0, "L", 0);
        if (isset($weather)) {
            $pdf->Cell(30, 5, "En Yüksek : $weather->max °C", 0, 0, "R", 0);
        }

        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);

        $pdf->Cell(30, 5, "Sözleşme Adı", 0, 0, "L", 0);
        $pdf->Cell(80, 5, mb_strtoupper($contract->sozlesme_ad), 0, 0, "L", 0);
        $pdf->Cell(50, 5, "", 0, 0, "L", 0);
        if (isset($weather)) {
            $pdf->Cell(30, 5, "En Düşük : $weather->min °C", 0, 0, "R", 0);
        }
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);

        $pdf->Cell(30, 5, "İşveren", 0, 0, "L", 0);
        $pdf->Cell(80, 5, $owner->company_name, 0, 0, "L", 0);
        $pdf->Cell(50, 5, "", 0, 0, "L", 0);
        if (isset($weather)) {
            $pdf->Cell(30, 5, "$weather->event", 0, 0, "R", 0);
        }

        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        if ($report->off_days == 1) {
            $stuation = "Çalışılabilir";
        } else {
            $stuation = "Çalışılamaz";
        }

        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetFillColor(160, 160, 160);
        $table_y = $pdf->getY();

        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(95, 5, "İşveren Teknik Personeller", 1, 0, "C", 1);

        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(55, 5, "Unvanı", 1, 0, "C", 0);
        $pdf->Cell(40, 5, "Ad Soyad", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        foreach ($owner_staff as $staff) {
            $pdf->Cell(55, 5, $staff->position, 1, 0, "C", 0);
            $pdf->Cell(40, 5, $staff->name, 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }
        $table_end_owner = $pdf->getY();

        $pdf->SetXY(105, $table_y);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(95, 5, "Yüklenici/Taşeron Teknik Personeller", 1, 0, "C", 1);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(105);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(55, 5, "Unvanı", 1, 0, "C", 0);
        $pdf->Cell(40, 5, "Ad Soyad", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        foreach ($contractor_staff as $staff) {
            $pdf->SetX(105);
            $pdf->Cell(55, 5, $staff->position, 1, 0, "C", 0);
            $pdf->Cell(40, 5, $staff->name, 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç

        }
        $table_end_contract = $pdf->getY();


        $pdf->SetFont('dejavusans', 'N', 7);

        if ($table_end_owner > $table_end_contract) {
            $pdf->SetY($table_end_owner);
        } else {
            $pdf->SetY($table_end_contract);
        }

        $pdf->Ln(); // Yeni satıra geç


        if (!empty($workgroups)) {
            $pdf->SetX(10);
            $pdf->SetFillColor(160, 160, 160);

            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "Çalışan Ekipler", 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(30, 5, "Ekip Adı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Çalıştığı Mahal", 1, 0, "C", 0);
            $pdf->Cell(100, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);

            foreach ($workgroups as $workgroup) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);

                $pdf->Cell(30, 5, group_name($workgroup->workgroup), 1, 0, "L", 0);
                $pdf->Cell(30, 5, $workgroup->number, 1, 0, "C", 0);
                $pdf->Cell(30, 5, yazim_duzen($workgroup->place), 1, 0, "L", 0);
                $pdf->Cell(100, 5, yazim_duzen($workgroup->notes), 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);

            $pdf->Cell(30, 5, "TOPLAM", 1, 0, "L", 0);
            $pdf->Cell(30, 5, $this->Report_workgroup_model->sum_all(array("report_id" => $report->id), "number"), 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        } else {
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Cell(80, 5, "", 0, 0, "R", 0);

            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "EKİP ÇALIŞMASI YOK", 0, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }

        $pdf->Ln(); // Yeni satıra geç


        if (!empty($workmachines)) {
            $pdf->SetFillColor(160, 160, 160);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "Çalışan Makineler", 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(30, 5, "Makine Adı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Çalıştığı Mahal", 1, 0, "C", 0);
            $pdf->Cell(100, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);

            foreach ($workmachines as $workmachine) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);

                $pdf->Cell(30, 5, machine_name($workmachine->workmachine), 1, 0, "L", 0);
                $pdf->Cell(30, 5, $workmachine->number, 1, 0, "C", 0);
                $pdf->Cell(30, 5, yazim_duzen($workmachine->place), 1, 0, "L", 0);
                $pdf->Cell(100, 5, yazim_duzen($workmachine->notes), 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);

            $pdf->Cell(30, 5, "TOPLAM", 1, 0, "L", 0);
            $pdf->Cell(30, 5, $this->Report_workmachine_model->sum_all(array("report_id" => $report->id), "number"), 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        } else {
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Cell(80, 5, "", 0, 0, "R", 0);

            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "MAKİNE ÇALIŞMASI YOK", 0, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }
        $pdf->Ln(); // Yeni satıra geç

        if (!empty($supplies)) {
            $pdf->SetFillColor(160, 160, 160);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "Gelen Malzemeler", 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(30, 5, "Makine Adı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Çalıştığı Mahal", 1, 0, "C", 0);
            $pdf->Cell(100, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);

            foreach ($supplies as $supply) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);

                $pdf->Cell(30, 5, yazim_duzen($supply->supply), 1, 0, "L", 0);
                $pdf->Cell(30, 5, $supply->qty, 1, 0, "C", 0);
                $pdf->Cell(30, 5, $supply->unit, 1, 0, "L", 0);
                $pdf->Cell(100, 5, $supply->notes, 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
        } else {
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Cell(80, 5, "", 0, 0, "R", 0);

            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "GELEN MALZEME YOK", 0, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }

        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'N', 7);


        $pdf->SetXY(10, 265);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(95, 5, "İşveren", 1, 0, "C", 1);
        $pdf->Cell(95, 5, "Taşeron/Yüklenici", 1, 0, "C", 1);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(95, 5, $owner_sign->name, 1, 0, "C", 0);
        if (isset($contractor_sign)) {
            $pdf->Cell(95, 5, $contractor_sign->name, 1, 0, "C", 0);
        }
        $pdf->Ln(); // Yeni satıra geç

        $file_name = "02 - Hakediş Raporu(Hesap Cetveli)-" . contract_name($contract->id) . "-Günlük Rapor ";

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public
    function date_range_report($site_id, $P_or_D = null)
    {
        $this->load->model("Company_model");
        $this->load->model("Report_file_model");
        $this->load->model("Report_weather_model");
        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Report_supply_model");
        $this->load->model("Report_sign_model");


        $report = $this->Report_model->get(array("id" => $report_id));
        $site = $this->Site_model->get(array("id" => $report->site_id));

        $contractor_sign = $this->Report_sign_model->get(array("site_id" => $site->id, "module" => "contractor_sign"));
        $contractor_staff = $this->Report_sign_model->get_all(array("site_id" => $site->id, "module" => "contractor_staff"));
        $owner_sign = $this->Report_sign_model->get(array("site_id" => $site->id, "module" => "owner_sign"));
        $owner_staff = $this->Report_sign_model->get_all(array("site_id" => $site->id, "module" => "owner_staff"));

        $workgroups = $this->Report_workgroup_model->get_all(array("report_id" => $report_id));
        $workmachines = $this->Report_workmachine_model->get_all(array("report_id" => $report_id));
        $supplies = $this->Report_supply_model->get_all(array("report_id" => $report_id));


        $viewData = new stdClass();
        $weather = $this->Report_weather_model->get(array("date" => $report->report_date));
        $contract = $this->Contract_model->get(array("id" => $report->contract_id));
        $project = $this->Project_model->get(array("id" => $report->project_id));

        $viewData->contract = $contract;

        $contractor = $this->Company_model->get(array("id" => $contract->yuklenici));
        $owner = $this->Company_model->get(array("id" => $contract->isveren));
        $viewData->contractor = $contractor;
        $viewData->owner = $owner;


        $yuklenici = company_name($contract->yuklenici);
        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        $page_width = $pdf->getPageWidth();


        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', 'B', 8);
        $pdf->SetXY(150, 13);
        $pdf->Cell(50, 6, "Rapor Tarihi : " . dateFormat_dmy($report->report_date), 0, 0, "R", 0);
// Çerçeve için boşlukları belirleme
        $topMargin = 10;  // 4 cm yukarıdan
        $bottomMargin = 10;  // 4 cm aşağıdan
        $rightMargin = 10;  // 2 cm sağdan
        $leftMargin = 10;  // 2 cm soldan

// Çerçeve renk ve kalınlığını ayarla
        $pdf->SetDrawColor(0, 0, 0); // Siyah renk
        $pdf->SetLineWidth(0.5); // Çizgi kalınlığı

// Çerçeve çizme
        $pdf->Rect($leftMargin, $topMargin, $pdf->getPageWidth() - $rightMargin - $leftMargin, $pdf->getPageHeight() - $bottomMargin - $topMargin);

        $pdf->SetFont('dejavusans', 'B', 12);

// Metin eklemek (örnek olarak ilk satır)
        $yPosition = $topMargin; // 5 cm yukarıdan başla
        $xPosition = $leftMargin; // 2 cm soldan başla
        $pdf->SetXY($xPosition, $yPosition);
        $pdf->SetLineWidth(0.1); // Çizgi kalınlığı
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(190, 10, 'GÜNLÜK RAPOR', 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'N', 9);
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);

        $pdf->Cell(30, 5, "Proje Adı", 0, 0, "L", 0);
        $pdf->Cell(80, 5, mb_strtoupper($project->proje_ad), 0, 0, "L", 0);
        $pdf->Cell(50, 5, "", 0, 0, "L", 0);
        if (isset($weather)) {
            $pdf->Cell(30, 5, "En Yüksek : $weather->max °C", 0, 0, "R", 0);
        }

        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);

        $pdf->Cell(30, 5, "Sözleşme Adı", 0, 0, "L", 0);
        $pdf->Cell(80, 5, mb_strtoupper($contract->sozlesme_ad), 0, 0, "L", 0);
        $pdf->Cell(50, 5, "", 0, 0, "L", 0);
        if (isset($weather)) {
            $pdf->Cell(30, 5, "En Düşük : $weather->min °C", 0, 0, "R", 0);
        }
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);

        $pdf->Cell(30, 5, "İşveren", 0, 0, "L", 0);
        $pdf->Cell(80, 5, $owner->company_name, 0, 0, "L", 0);
        $pdf->Cell(50, 5, "", 0, 0, "L", 0);
        if (isset($weather)) {
            $pdf->Cell(30, 5, "$weather->event", 0, 0, "R", 0);
        }

        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        if ($report->off_days == 1) {
            $stuation = "Çalışılabilir";
        } else {
            $stuation = "Çalışılamaz";
        }

        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetFillColor(160, 160, 160);
        $table_y = $pdf->getY();

        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(95, 5, "İşveren Teknik Personeller", 1, 0, "C", 1);

        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(55, 5, "Unvanı", 1, 0, "C", 0);
        $pdf->Cell(40, 5, "Ad Soyad", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        foreach ($owner_staff as $staff) {
            $pdf->Cell(55, 5, $staff->position, 1, 0, "C", 0);
            $pdf->Cell(40, 5, $staff->name, 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $table_end_owner = $pdf->getY();
        }

        $pdf->SetXY(105, $table_y);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(95, 5, "Yüklenici/Taşeron Teknik Personeller", 1, 0, "C", 1);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(105);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(55, 5, "Unvanı", 1, 0, "C", 0);
        $pdf->Cell(40, 5, "Ad Soyad", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        foreach ($contractor_staff as $staff) {
            $pdf->SetX(105);
            $pdf->Cell(55, 5, $staff->position, 1, 0, "C", 0);
            $pdf->Cell(40, 5, $staff->name, 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $table_end_contract = $pdf->getY();

        }

        $pdf->SetFont('dejavusans', 'N', 7);

        if ($table_end_owner > $table_end_contract) {
            $pdf->SetY($table_end_owner);
        } else {
            $pdf->SetY($table_end_contract);
        }

        $pdf->Ln(); // Yeni satıra geç


        if (!empty($workgroups)) {
            $pdf->SetX(10);
            $pdf->SetFillColor(160, 160, 160);

            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "Çalışan Ekipler", 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(30, 5, "Ekip Adı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Çalıştığı Mahal", 1, 0, "C", 0);
            $pdf->Cell(100, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);

            foreach ($workgroups as $workgroup) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);

                $pdf->Cell(30, 5, group_name($workgroup->workgroup), 1, 0, "L", 0);
                $pdf->Cell(30, 5, $workgroup->number, 1, 0, "C", 0);
                $pdf->Cell(30, 5, yazim_duzen($workgroup->place), 1, 0, "L", 0);
                $pdf->Cell(100, 5, yazim_duzen($workgroup->notes), 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);

            $pdf->Cell(30, 5, "TOPLAM", 1, 0, "L", 0);
            $pdf->Cell(30, 5, $this->Report_workgroup_model->sum_all(array("report_id" => $report->id), "number"), 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        } else {
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Cell(80, 5, "", 0, 0, "R", 0);

            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "EKİP ÇALIŞMASI YOK", 0, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }

        $pdf->Ln(); // Yeni satıra geç


        if (!empty($workmachines)) {
            $pdf->SetFillColor(160, 160, 160);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "Çalışan Makineler", 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(30, 5, "Makine Adı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Çalıştığı Mahal", 1, 0, "C", 0);
            $pdf->Cell(100, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);

            foreach ($workmachines as $workmachine) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);

                $pdf->Cell(30, 5, machine_name($workmachine->workmachine), 1, 0, "L", 0);
                $pdf->Cell(30, 5, $workmachine->number, 1, 0, "C", 0);
                $pdf->Cell(30, 5, yazim_duzen($workmachine->place), 1, 0, "L", 0);
                $pdf->Cell(100, 5, yazim_duzen($workmachine->notes), 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);

            $pdf->Cell(30, 5, "TOPLAM", 1, 0, "L", 0);
            $pdf->Cell(30, 5, $this->Report_workmachine_model->sum_all(array("report_id" => $report->id), "number"), 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        } else {
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Cell(80, 5, "", 0, 0, "R", 0);

            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "MAKİNE ÇALIŞMASI YOK", 0, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }
        $pdf->Ln(); // Yeni satıra geç

        if (!empty($supplies)) {
            $pdf->SetFillColor(160, 160, 160);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "Gelen Malzemeler", 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(30, 5, "Makine Adı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Çalıştığı Mahal", 1, 0, "C", 0);
            $pdf->Cell(100, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);

            foreach ($supplies as $supply) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);

                $pdf->Cell(30, 5, yazim_duzen($supply->supply), 1, 0, "L", 0);
                $pdf->Cell(30, 5, $supply->qty, 1, 0, "C", 0);
                $pdf->Cell(30, 5, $supply->unit, 1, 0, "L", 0);
                $pdf->Cell(100, 5, $supply->notes, 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
        } else {
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Cell(80, 5, "", 0, 0, "R", 0);

            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "GELEN MALZEME YOK", 0, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }

        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'N', 7);


        $pdf->SetXY(10, 265);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(95, 5, "İşveren Temsilcisi", 1, 0, "C", 1);
        $pdf->Cell(95, 5, "Taşeron-Yüklenici Temsilcisi", 1, 0, "C", 1);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(95, 5, $owner_sign->name, 1, 0, "C", 0);
        $pdf->Cell(95, 5, $contractor_sign->name, 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $file_name = "02 - Hakediş Raporu(Hesap Cetveli)-" . contract_name($contract->id) . "-Günlük Rapor ";

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }


}
