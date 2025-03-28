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

        $uploader = APPPATH . 'libraries/FileUploader.php';
        include($uploader);


        $this->moduleFolder = "site_module";
        $this->viewFolder = "report_v";
        $this->load->model("Report_model");

        $this->load->model("Project_model");
        $this->load->model("Settings_model");
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

        $this->Common_Files = "common";
    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Report_model->get_all(array());
        $active_sites = $this->Site_model->get_all();


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


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($site_id = null)
    {

        if (!isAdmin() && !permission_control("site", "write")) {
            redirect(base_url("error"));
        }


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


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {

        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Report_supply_model");
        $this->load->model("Report_weather_model");

        $item = $this->Report_model->get(array("id" => $id));
        $site = $this->Site_model->get(array("id" => $item->site_id));

        $project = $this->Project_model->get(array("id" => $site->proje_id));

        $upload_function = base_url("$this->Module_Name/file_upload/$item->id");

        $date = dateFormat_dmy($item->report_date);

        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->dosya_no/$site->dosya_no/Reports/$date/";

        $reports = $this->Report_model->get_all(array("site_id" => $item->site_id), "report_date ASC");

        $current_report_index = array_search($id, array_column($reports, 'id'));

        $previous_report = null;
        $next_report = null;

        if ($current_report_index !== false) {
            if ($current_report_index > 0) {
                $previous_report = $reports[$current_report_index - 1];
            }

            if ($current_report_index < count($reports) - 1) {
                $next_report = $reports[$current_report_index + 1];
            }
        }


        $workgroups = $this->Report_workgroup_model->get_all(array("report_id" => $id));
        $weather = $this->Report_weather_model->get(array("date" => $item->report_date));
        $workmachines = $this->Report_workmachine_model->get_all(array("report_id" => $id));
        $supplies = $this->Report_supply_model->get_all(array("report_id" => $id));

        $site = $this->Site_model->get(array(
            "id" => $site->id
        ));


        $viewData = new stdClass();


        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->path = $path;
        $viewData->upload_function = $upload_function;
        $viewData->item = $item;
        $viewData->proje_id = $project->id;
        $viewData->weather = $weather;
        $viewData->workgroups = $workgroups;
        $viewData->previous_report = $previous_report;
        $viewData->next_report = $next_report;
        $viewData->workmachines = $workmachines;
        $viewData->supplies = $supplies;
        $viewData->site = $site;
        $viewData->project = $project;

        $viewData->item = $this->Report_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($site_id)
    {

        if (!isAdmin() && !permission_control("site", "write")) {
            redirect(base_url("error"));
        }

        if ($this->input->post("report_date")) {
            $report_date = dateFormat('Y-m-d', $this->input->post("report_date"));
        } else {
            $report_date = null;
        }

        $record_control = $this->Report_model->get(array("site_id" => $site_id, "report_date" => $report_date));

        if ($record_control) {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Bu tarihte başka bir günlük rapor var işlem yapılamaz",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("$this->Module_Name/new_form/$site_id"));

        } else {
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


            $this->load->library("form_validation");

            $this->form_validation->set_rules("report_date", "Rapor Tarihi", "required|trim");

            $this->form_validation->set_message(
                array(
                    "required" => "<b>{field}</b> alanı doldurulmalıdır",
                    "greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
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
                        "aciklama" => $this->input->post("note"),
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

                $this->load->model("Weather_model");

                $weather = $this->Weather_model->get(array('date' => $report_date));

                if (isset($weather)) {
                    redirect(base_url("$this->Module_Name/$this->Display_route/$report_id"));
                } else {
                    redirect(base_url("Weather/add_date/$report_id"));
                }

            } else {

                $viewData = new stdClass();
                $settings = $this->Settings_model->get();
                $site = $this->Site_model->get(array("id" => $site_id));

                $viewData->settings = $settings;

                $viewData->viewModule = $this->moduleFolder;
                $viewData->viewFolder = $this->viewFolder;
                $viewData->subViewFolder = "$this->Add_Folder";
                $viewData->form_error = true;
                $viewData->site = $site;

                $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
            }
        }
    }

    public function update($id)
    {

        $report = $this->Report_model->get(array("id" => $id));

        $site = $this->Site_model->get(array("id" => $report->site_id));


        $project = $this->Project_model->get(array("id" => $site->proje_id));

        $old_report_date = dateFormat('d-m-Y', $report->report_date);
        $new_report_date = dateFormat('d-m-Y', $this->input->post("report_date"));

        $control_new_date = dateFormat("Y-m-d", $this->input->post("report_date"));

        $record_control = $this->Report_model->get(array("site_id" => $report->site_id, "report_date" => $control_new_date));

        if ($record_control and $old_report_date != $new_report_date) {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Bu tarihte başka bir günlük rapor var işlem yapılamaz",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("$this->Module_Name/$this->Display_route/$id"));

        } else {

            $old_folder_dir = "$this->Upload_Folder/$this->Module_Main_Dir/$project->dosya_no/$site->dosya_no/Reports/";

            if ($this->input->post("report_date")) {
                if (rename($old_folder_dir . $old_report_date, $old_folder_dir . $new_report_date)) {
                    echo 'Klasör adı başarıyla değiştirildi.';
                } else {
                    echo 'Klasör adı değiştirilirken bir hata oluştu.';
                }
            }

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

            $off_days = ($this->input->post("off_days") == 0) ? "1" : "";

            if ($this->input->post("report_date")) {
                $update_date = dateFormat('Y-m-d', $this->input->post("report_date"));
            } else {
                $update_date = null;
            }

            $update = $this->Report_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "report_date" => $update_date,
                    "aciklama" => $this->input->post("note"),
                    "createdAt" => date("Y-m-d"),
                    "createdBy" => active_user_id(),
                    "off_days" => $off_days
                )
            );

            $delete_old = $this->Report_workgroup_model->delete(array("report_id" => $id));
            $delete_old = $this->Report_workmachine_model->delete(array("report_id" => $id));
            $delete_old = $this->Report_supply_model->delete(array("report_id" => $id));

            foreach ($workgroups_filter as $workgroup) {
                $insert_workgroup = $this->Report_workgroup_model->add(
                    array(
                        "site_id" => $site->id,
                        "report_id" => $report->id,
                        "project_id" => $project->id,
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
                        "site_id" => $site->id,
                        "report_id" => $report->id,
                        "project_id" => $project->id,
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
                        "site_id" => $site->id,
                        "report_id" => $report->id,
                        "project_id" => $project->id,
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

            $this->load->model("Weather_model");

            $weather = $this->Weather_model->get(array('date' => $update_date));

            if (isset($weather)) {
                redirect(base_url("$this->Module_Name/$this->Display_route/$id"));
            } else {
                redirect(base_url("Weather/add_date/$id"));
            }
        }
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

        $delete2 = $this->Report_model->delete(
            array(
                "id" => $report_id
            )
        );

        redirect(base_url("site/$this->Display_route/$site_id"));
    }

    public function file_upload($id)
    {
        $session_user = $this->session->userdata("user");

        if ($session_user->user_role != 2) {
            if (!isAdmin()) {
                redirect(base_url("error"));
            }
        }

        $item = $this->Report_model->get(array("id" => $id));
        $site = $this->Site_model->get(array("id" => $item->site_id));

        $project = $this->Project_model->get(array("id" => $site->proje_id));

        $date = dateFormat_dmy($item->report_date);

        $path = rtrim($this->Upload_Folder, '/') . '/' . $this->Module_Main_Dir . "/$project->dosya_no/$site->dosya_no/Reports/$date/";

        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }

        $FileUploader = new FileUploader('files', array(
            'limit' => null,
            'maxSize' => null,
            'extensions' => null,
            'uploadDir' => $path,
            'title' => 'name'
        ));

        // call to upload the files

        $uploadedFiles = $FileUploader->upload();

        $files = ($uploadedFiles['files']);

        if ($uploadedFiles['isSuccess'] && count($uploadedFiles['files']) > 0) {

            $thumbnailDir = $path . 'thumbnails/';
            if (!is_dir($thumbnailDir)) {
                mkdir($thumbnailDir, 0777, true); // Thumbnail klasörünü oluştur
            }

            // Yüklenen dosyaları işleyin
            foreach ($uploadedFiles['files'] as $file) {
                $filePath = $path . $file['name'];

                // HEIC dosyasını kontrol et ve JPG formatına dönüştür
                $fileExtension = strtolower(pathinfo(realpath($filePath), PATHINFO_EXTENSION));
                if ($fileExtension === 'heic') {
                    $jpgFilePath = str_replace('.heic', '.jpg', realpath($filePath));


                    try {
                        $imagick = new Imagick(realpath($filePath));
                        $imagick->setImageFormat('jpg');
                        $imagick->writeImage($jpgFilePath);
                    } catch (ImagickException $e) {
                        error_log('Dönüştürme hatası: ' . $e->getMessage());
                        echo $e->getMessage();
                    }

                    // HEIC dosyasını sil
                    unlink($filePath);

                    // Dosya adını güncelle
                    $file['name'] = basename($jpgFilePath);
                }

                // Dosya boyutunu kontrol edin ve yeniden boyutlandırma işlemlerini gerçekleştirin
                if ($file['size'] > 2097152) {
                    // Yeniden boyutlandırma işlemi için uygun genişlik ve yükseklik değerlerini belirleyin
                    $newWidth = null; // Örnek olarak 500 piksel genişlik
                    $newHeight = 1080; // Yüksekliği belirtmediğiniz takdirde orijinal oran korunur

                    // Yeniden boyutlandırma işlemi
                    FileUploader::resize($path . $file['name'], $newWidth, $newHeight, $destination = null, $crop = false, $quality = 75);
                }

                // Thumbnail oluştur
                $thumbnailPath = $thumbnailDir . $file['name'];
                $thumbnailWidth = 750; // Thumbnail genişliği (örnek değer)
                $thumbnailHeight = 750; // Thumbnail yüksekliği (örnek değer)

                // Thumbnail oluşturma ve kaydetme
                FileUploader::resize($path . $file['name'], $thumbnailWidth, $thumbnailHeight, $thumbnailPath, $crop = true, $quality = 75);
            }


        }

        header('Content-Type: application/json');
        echo json_encode($uploadedFiles);
        exit;
    }

    public function fileDelete_java($id)
    {
        $session_user = $this->session->userdata("user");

        if ($session_user->user_role != 2) {
            if (!isAdmin()) {
                redirect(base_url("error"));
            }
        }

        $item = $this->Report_model->get(array("id" => $id));
        $site = $this->Site_model->get(array("id" => $item->site_id));

        $project = $this->Project_model->get(array("id" => $site->proje_id));

        $date = dateFormat_dmy($item->report_date);

        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->dosya_no/$site->dosya_no/Reports/$date";
        $thumb_path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->dosya_no/$site->dosya_no/Reports/$date/thumbnails";

        $fileName = $this->input->post('fileName');

        unlink("$path/$fileName");
        unlink("$thumb_path/$fileName");
    }


    public function download_all($report_id)
    {
        $session_user = $this->session->userdata("user");

        if ($session_user->user_role != 2) {
            if (!isAdmin()) {
                redirect(base_url("error"));
            }
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



    public
    function print_report($report_id, $print_pic = null, $P_or_D = null)
    {
        $this->load->model("Company_model");
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
        $pdf->Cell(80, 5, mb_strtoupper($project->project_name), 0, 0, "L", 0);
        $pdf->Cell(50, 5, "", 0, 0, "L", 0);
        if (isset($weather)) {
            $pdf->Cell(30, 5, "En Yüksek : $weather->max °C", 0, 0, "R", 0);
        }

        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);

        $pdf->Cell(30, 5, "Sözleşme Adı", 0, 0, "L", 0);
        $pdf->Cell(80, 5, mb_strtoupper($contract->contract_name), 0, 0, "L", 0);
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
            $pdf->SetFont('dejavusans', 'I', 7);
            $pdf->Cell(55, 5, $staff->position, 1, 0, "C", 0);
            $pdf->Cell(40, 5, $staff->name, 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }
        $table_end_owner = $pdf->getY();

        $pdf->SetXY(105, $table_y);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(95, 5, "Taşeron Teknik Personeller", 1, 0, "C", 1);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(105);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(55, 5, "Unvanı", 1, 0, "C", 0);
        $pdf->Cell(40, 5, "Ad Soyad", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        foreach ($contractor_staff as $staff) {
            $pdf->SetFont('dejavusans', 'I', 7);
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
            $pdf->Cell(10, 5, "#", 1, 0, "C", 0);
            $pdf->Cell(35, 5, "Ekip Adı", 1, 0, "C", 0);
            $pdf->Cell(13, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Çalıştığı Mahal", 1, 0, "C", 0);
            $pdf->Cell(102, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);
            $wg = 1;
            foreach ($workgroups as $workgroup) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);

                $pdf->Cell(10, 5, $wg++, 1, 0, "C", 0);
                $pdf->Cell(35, 5, group_name($workgroup->workgroup), 1, 0, "L", 0);
                $pdf->Cell(13, 5, $workgroup->number, 1, 0, "C", 0);
                $pdf->Cell(30, 5, yazim_duzen($workgroup->place), 1, 0, "L", 0);
                $pdf->Cell(102, 5, yazim_duzen($workgroup->notes), 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);

            $pdf->Cell(10, 5, "#", 1, 0, "C", 0);
            $pdf->Cell(35, 5, "TOPLAM", 1, 0, "L", 0);
            $pdf->Cell(13, 5, $this->Report_workgroup_model->sum_all(array("report_id" => $report->id), "number"), 1, 0, "C", 0);
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
            $pdf->Cell(10, 5, "#", 1, 0, "C", 0);
            $pdf->Cell(35, 5, "Makine Adı", 1, 0, "C", 0);
            $pdf->Cell(13, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(30, 5, "Çalıştığı Mahal", 1, 0, "C", 0);
            $pdf->Cell(102, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);
            $wm = 1;
            foreach ($workmachines as $workmachine) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);
                $pdf->Cell(10, 5, $wm++, 1, 0, "C", 0);
                $pdf->Cell(35, 5, machine_name($workmachine->workmachine), 1, 0, "L", 0);
                $pdf->Cell(13, 5, $workmachine->number, 1, 0, "C", 0);
                $pdf->Cell(30, 5, yazim_duzen($workmachine->place), 1, 0, "L", 0);
                $pdf->Cell(102, 5, yazim_duzen($workmachine->notes), 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(10, 5, "#", 1, 0, "C", 0);
            $pdf->Cell(35, 5, "TOPLAM", 1, 0, "L", 0);
            $pdf->Cell(13, 5, $this->Report_workmachine_model->sum_all(array("report_id" => $report->id), "number"), 1, 0, "C", 0);
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
            $pdf->Cell(10, 5, "#", 1, 0, "C", 0);
            $pdf->Cell(35, 5, "Malzeme Adı", 1, 0, "C", 0);
            $pdf->Cell(13, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(13, 5, "Birim", 1, 0, "C", 0);
            $pdf->Cell(119, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);
            $sp = 1;
            foreach ($supplies as $supply) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);

                $pdf->Cell(10, 5, $sp++, 1, 0, "C", 0);
                $pdf->Cell(35, 5, yazim_duzen($supply->supply), 1, 0, "L", 0);
                $pdf->Cell(13, 5, $supply->qty, 1, 0, "C", 0);
                $pdf->Cell(13, 5, yazim_duzen($supply->unit), 1, 0, "C", 0);
                $pdf->Cell(119, 5, yazim_duzen($supply->notes), 1, 0, "L", 0);
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
        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetFillColor(160, 160, 160);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(190, 5, "Genel Notlar", 1, 0, "C", 1);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', '', 7);
        $notes = array_filter((explode(".", $report->aciklama)), 'strlen');
        $n = 1;
        foreach ($notes as $note) {
            $pdf->Cell(10, 5, $n++, 1, 0, "C", 0);
            $pdf->Cell(180, 5, yazim_duzen(ltrim($note)), 1, 0, "L", 0);
            $pdf->Ln(); // Yeni satıra geç
        }


        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'N', 7);

        $pdf->SetXY(10, 265);
        $pdf->SetFont('dejavusans', 'B', 7);
        if (isset($owner_sign)) {
            $pdf->Cell(95, 5, $owner_sign->position, 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Cell(95, 5, $owner_sign->name, 1, 0, "C", 0);
        }
        $pdf->SetXY(105, 265);
        if (isset($contractor_sign)) {
            $pdf->Cell(95, 5, $contractor_sign->position, 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(105);
            $pdf->Cell(95, 5, $contractor_sign->name, 1, 0, "C", 0);
        }
        $pdf->Ln(); // Yeni satıra geç


        $date = dateFormat_dmy($report->report_date);
        $project_code = project_code($site->proje_id);


        $imageDirectory = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$site->dosya_no/Reports/$date/thumbnails";

        $originalPath = K_PATH_MAIN;
        if (DIRECTORY_SEPARATOR == "\\") {
            $removePart = 'application' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'tcpdf/';
        } else {
            $removePart = 'application' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'tcpdf' . DIRECTORY_SEPARATOR;
        }
        $newPath = str_replace($removePart, '', $originalPath);
        $path = $newPath . $imageDirectory;


        $baseDirectory = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);

        $files = glob($baseDirectory . '/*');

        if ($print_pic == 1 and count($files) > 0) {
            $pdf->AddPage();

            if (count($files) > 6) {
                $files = array_rand(array_flip($files), 6); // 6 rastgele dosya seç
            } else {
                $files = array_slice($files, 0, 6); // Tüm dosyaları al
            }

// Maksimum yükseklik
            $maxHeight = 90;

            switch (count($files)) {
                case 6:
                    $positions = [
                        // Üst iki
                        ['x' => 10, 'y' => 5, 'w' => 90, 'h' => 90], ['x' => 110, 'y' => 5, 'w' => 90, 'h' => 90],
                        // Ortada iki
                        ['x' => 10, 'y' => 95, 'w' => 90, 'h' => 90], ['x' => 110, 'y' => 95, 'w' => 90, 'h' => 90],
                        // Altta iki
                        ['x' => 10, 'y' => 185, 'w' => 90, 'h' => 90], ['x' => 110, 'y' => 185, 'w' => 90, 'h' => 90],
                    ];
                    break;
                case 5:
                    $positions = [
                        // Üst iki
                        ['x' => 10, 'y' => 5, 'w' => 90, 'h' => 90], ['x' => 115, 'y' => 5, 'w' => 90, 'h' => 90],
                        // Ortada iki
                        ['x' => 10, 'y' => 95, 'w' => 90, 'h' => 90], ['x' => 115, 'y' => 95, 'w' => 90, 'h' => 90],
                        // Altta ortada bir
                        ['x' => 62, 'y' => 185, 'w' => 90, 'h' => 90]
                    ];
                    break;
                case 4:
                    $positions = [
                        // Üst iki
                        ['x' => 10, 'y' => 10, 'w' => 100, 'h' => 100], ['x' => 105, 'y' => 10, 'w' => 100, 'h' => 100],
                        // Altta iki
                        ['x' => 10, 'y' => 115, 'w' => 100, 'h' => 100], ['x' => 105, 'y' => 115, 'w' => 100, 'h' => 100]
                    ];
                    break;
                case 3:
                    $positions = [
                        // Üst iki
                        ['x' => 10, 'y' => 10, 'w' => 100, 'h' => 100], ['x' => 115, 'y' => 10, 'w' => 100, 'h' => 100],
                        // Altta ortada bir
                        ['x' => 35, 'y' => 120, 'w' => 155, 'h' => 155]
                    ];
                    break;
                case 2:
                    $positions = [
                        // Üstte bir
                        ['x' => 40, 'y' => 10, 'w' => 130, 'h' => 130],
                        // Altta bir
                        ['x' => 40, 'y' => 145, 'w' => 130, 'h' => 130]
                    ];
                    break;
                case 1:
                    $positions = [
                        ['x' => 15, 'y' => 10, 'w' => 180, 'h' => 180]
                    ];
                    break;
            }

            foreach ($files as $index => $file) {
                // Görselin yüksekliğini sınırlandırın, en boy oranını koruyarak genişliği ayarlayın
                $imageSize = getimagesize($file);
                $origWidth = $imageSize[0];
                $origHeight = $imageSize[1];

                if ($origHeight > $maxHeight) {
                    $height = $maxHeight;
                    $width = ($maxHeight / $origHeight) * $origWidth;
                } else {
                    $width = $origWidth;
                    $height = $origHeight;
                }


                $pdf->Image($file, $positions[$index]['x'], $positions[$index]['y'], $positions[$index]['w'], $positions[$index]['h'], '', '', '', true, 150, '', false, false, 1, false, false, false);

            }
        }

        $file_name = dateFormat_dmy($report->report_date) . "_" . site_name($site->id) . "_" . "Günlük Rapor";

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

}
