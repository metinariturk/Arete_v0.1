<?php

class Report extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $models = [
            'Report_model',
            'Project_model',
            'Settings_model',
            'User_model',
            'Site_model',
            'Workgroup_model',
            'Contract_model',
            'Report_workgroup_model',
            'Report_workmachine_model',
            'Report_supply_model',
            'Report_weather_model',
        ];
        foreach ($models as $model) {
            $this->load->model($model);
        }
        $this->rules = array(
            "index" => array('report' => ['r']),
            "select" => array('report' => ['r']),
            "new_form" => array('report' => ['w']),
            "update_form" => array('report' => ['u']),
            "file_form" => array('report' => ['r']),
            "refresh_day" => array('report' => ['r']),
            "save" => array('report' => ['w', 'u']),
            "update" => array('report' => ['w', 'u']),
            "delete" => array('report' => ['d']),
            "file_upload" => array('report' => ['r', 'w', 'u']),
            "filedelete_java" => array('report' => ['d', 'u']),
            "download_all" => array('report' => ['r']),
            "print_report" => array('report' => ['r'])
        );
        $this->check_permissions();


    }

    protected function check_permissions()
    {
        $current_method = strtolower($this->router->method);

        if (!isset($this->rules[$current_method])) {
            show_error($current_method . "Yetki tanımı yapılmamış!", 403);
        }

        foreach ($this->rules[$current_method] as $module => $permissions) {
            if (!user_has_permission($module, $permissions)) {
                show_error('Bu sayfaya erişim yetkiniz yok!', 403);
            }
        }
    }

    public function index()
    {
        $viewData = new stdClass();

        $items = $this->Report_model->get_all(array());
        $active_sites = $this->Site_model->get_all();
        $viewData->items = $items;
        $viewData->active_sites = $active_sites;
        $this->load->view("site_module/report_v/list/index", $viewData);
    }

    public function select()
    {
        $viewData = new stdClass();

        $items = $this->Report_model->get_all(array());
        $viewData->items = $items;
        $this->load->view("site_module/report_v/select/index", $viewData);
    }

    public function new_form($site_id = null, $report_date = null)
    {

        if (empty($report_date)) {
            $report_date = date('d-m-Y'); // 'YYYY-MM-DD' formatında bugünün tarihi
        } else {
            $report_date = dateFormat_dmy($report_date);
        }

        $site = $this->Site_model->get(array("id" => $site_id));
        $project = $this->Project_model->get(array("id" => $site->project_id));
        if ($site->contract_id) {
            $contract = $this->Contract_model->get(array("id" => $site->contract_id));
        }
        $viewData = new stdClass();

        $reports = $this->Report_model->get_all(array("site_id" => $site->id));

// Tarihleri PHP'den JavaScript'e uygun hale getirme
        $dates = [];
        foreach ($reports as $report) {
            // 'Y-m-d' formatındaki tarihi JavaScript'e uyumlu hale getiriyoruz
            $dates[] = $report->report_date;
        }

        $this->viewData->settings = $this->settings;
        $active_machines = json_decode($site->active_machine, true);
        $active_workgroups = json_decode($site->active_group, true);
        $viewData->active_machines = $active_machines;
        $viewData->active_workgroups = $active_workgroups;
        $viewData->site = $site;
        $viewData->dates = $dates;
        $viewData->report_date = $report_date;
        $viewData->project = $project;
        if ($site->contract_id) {
            $viewData->contract = $contract;
        }

        $this->load->view("site_module/report_v/add/index", $viewData);


    }

    public function update_form($id)
    {
        $report = $this->Report_model->get(array("id" => $id));
        $site = $this->Site_model->get(array("id" => $report->site_id));
        $project = $this->Project_model->get(array("id" => $site->project_id));
        $weather = $this->Report_weather_model->get(array("date" => $report->report_date, "location" => $site->location));

        if ($site->contract_id) {
            $contract = $this->Contract_model->get(array("id" => $site->contract_id));
        }

        $viewData = new stdClass();

        $reports = $this->Report_model->get_all(array("site_id" => $site->id));

        $dates = [];
        foreach ($reports as $report) {
            // 'Y-m-d' formatındaki tarihi JavaScript'e uyumlu hale getiriyoruz
            $dates[] = $report->report_date;
        }

        $workgroups = $this->Report_workgroup_model->get_all(array("report_id" => $id));
        $workmachines = $this->Report_workmachine_model->get_all(array("report_id" => $id));
        $supplies = $this->Report_supply_model->get_all(array("report_id" => $id));

        $this->viewData->settings = $this->settings;
        $active_machines = json_decode($site->active_machine, true);
        $active_workgroups = json_decode($site->active_group, true);
        $viewData->active_machines = $active_machines;
        $viewData->active_workgroups = $active_workgroups;
        $viewData->report = $report;

        $viewData->workgroups = $workgroups;
        $viewData->workmachines = $workmachines;
        $viewData->supplies = $supplies;
        $viewData->weather = $weather;

        $viewData->site = $site;
        $viewData->dates = $dates;
        $viewData->project = $project;
        if ($site->contract_id) {
            $viewData->contract = $contract;
        }

        $this->load->view("site_module/report_v/update/index", $viewData);

    }

    public function file_form($id)
    {
        $item = $this->Report_model->get(array("id" => $id));
        $site = $this->Site_model->get(array("id" => $item->site_id));
        $project = $this->Project_model->get(array("id" => $site->project_id));
        $upload_function = base_url("Report/file_upload/$item->id");
        $date = dateFormat_dmy($item->report_date);
        $path = "uploads/project_v/$project->dosya_no/$site->dosya_no/Reports/$date/";
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
        $weather = $this->Report_weather_model->get(array("date" => $item->report_date, "location" => $site->location));
        $workmachines = $this->Report_workmachine_model->get_all(array("report_id" => $id));
        $supplies = $this->Report_supply_model->get_all(array("report_id" => $id));
        $site = $this->Site_model->get(array(
            "id" => $site->id
        ));
        $viewData = new stdClass();
        $viewData->path = $path;
        $viewData->upload_function = $upload_function;
        $viewData->item = $item;
        $viewData->project_id = $project->id;
        $viewData->weather = $weather;
        $viewData->workgroups = $workgroups;
        $viewData->previous_report = $previous_report;
        $viewData->next_report = $next_report;
        $viewData->reports = $reports;
        $viewData->workmachines = $workmachines;
        $viewData->supplies = $supplies;
        $viewData->site = $site;
        $viewData->project = $project;
        $viewData->item = $this->Report_model->get(
            array(
                "id" => $id
            )
        );
        $this->load->view("site_module/report_v/display/index", $viewData);
    }

    public function refresh_day($id)
    {
        $item = $this->Report_model->get(array("id" => $id));
        $site = $this->Site_model->get(array("id" => $item->site_id));
        $project = $this->Project_model->get(array("id" => $site->project_id));
        $upload_function = base_url("Report/file_upload/$item->id");
        $date = dateFormat_dmy($item->report_date);
        $path = "uploads/project_v/$project->dosya_no/$site->dosya_no/Reports/$date/";
        $reports = $this->Report_model->get_all(array("site_id" => $item->site_id), "report_date ASC");
        $current_report_index = array_search($id, array_column($reports, 'id'));

        $workgroups = $this->Report_workgroup_model->get_all(array("report_id" => $id));
        $weather = $this->Report_weather_model->get(array("date" => $item->report_date));
        $workmachines = $this->Report_workmachine_model->get_all(array("report_id" => $id));
        $supplies = $this->Report_supply_model->get_all(array("report_id" => $id));
        $site = $this->Site_model->get(array(
            "id" => $site->id
        ));
        $viewData = new stdClass();
        $viewData->path = $path;
        $viewData->upload_function = $upload_function;
        $viewData->item = $item;
        $viewData->project_id = $project->id;
        $viewData->weather = $weather;
        $viewData->workgroups = $workgroups;
        $viewData->reports = $reports;
        $viewData->workmachines = $workmachines;
        $viewData->supplies = $supplies;
        $viewData->site = $site;
        $viewData->project = $project;
        $viewData->item = $this->Report_model->get(
            array(
                "id" => $id
            )
        );

        $html = $this->load->view("site_module/report_v/display/modules/report_body", $viewData, true);

        echo json_encode([
            "success" => true,
            "form_html" => $html
        ]);
    }

    public function save($site_id)
    {
        $site = $this->Site_model->get(array("id" => $site_id));
        $project = $this->Project_model->get(array("id" => $site->project_id));

        $report_date = $this->input->post("report_date");

        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Report_supply_model");


        // Form validation kurallarını ayarlıyoruz
        $this->load->library('form_validation');
        $this->form_validation->set_rules("report_date", "Rapor Tarihi", "required|callback_unique_report_date[$site->id]");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );

        $workgroups = $this->input->post("workgroups[]") ?? [];
        $workmachine = $this->input->post("workmachines[]") ?? [];
        $supplies = $this->input->post("supplies[]") ?? [];

        $workgroups_filter = filter_array($workgroups, "workgroup");
        $workmachine_filter = filter_array($workmachine, "workmachine");
        $supplies_filter = filter_array($supplies, "supply");

        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("report_date")) {
                $report_date = dateFormat('Y-m-d', $this->input->post("report_date"));
            } else {
                $report_date = null;
            }

            $path = "uploads/project_v/$project->dosya_no/$site->dosya_no/Reports/$report_date";
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }
            $off_days = ($this->input->post("off_days") == 0) ? "1" : "";

            $insert_report = $this->Report_model->add(
                array(
                    "site_id" => $site_id,
                    "project_id" => $project->id,
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
                        "project_id" => $site->project_id,
                        "contract_id" => $site->contract_id,
                        "workgroup" => $workgroup['workgroup'],
                        "number" => $workgroup['worker_count'],
                        "notes" => $workgroup['notes'],
                        "place" => $workgroup['place'],
                        "production" => $workgroup['production'],
                        "createdBy" => active_user_id(),
                    )
                );
            }
            foreach ($workmachine_filter as $workmachine) {
                $insert_workmachine = $this->Report_workmachine_model->add(
                    array(
                        "site_id" => $site_id,
                        "report_id" => $report_id,
                        "project_id" => $site->project_id,
                        "contract_id" => $site->contract_id,
                        "workmachine" => $workmachine['workmachine'],
                        "number" => $workmachine['machine_count'],
                        "notes" => $workmachine['machine_notes'],
                        "place" => $workmachine['machine_place'],
                        "production" => $workmachine['machine_production'],
                        "createdBy" => active_user_id(),
                    )
                );
            }
            foreach ($supplies_filter as $supplies) {
                $insert_workmachine = $this->Report_supply_model->add(
                    array(
                        "site_id" => $site_id,
                        "report_id" => $report_id,
                        "project_id" => $site->project_id,
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

            echo json_encode([
                "success" => true,
                "redirect" => base_url("Report/file_form/$report_id") // Sadece URL stringi
            ]);


        } else {

            $site = $this->Site_model->get(array("id" => $site_id));
            $project = $this->Project_model->get(array("id" => $site->project_id));
            if ($site->contract_id) {
                $contract = $this->Contract_model->get(array("id" => $site->contract_id));
            }
            $reports = $this->Report_model->get_all(array("site_id" => $site->id));
            $dates = [];
            foreach ($reports as $report) {
                // 'Y-m-d' formatındaki tarihi JavaScript'e uyumlu hale getiriyoruz
                $dates[] = $report->report_date;
            }


            $viewData = new stdClass();

            $active_machines = json_decode($site->active_machine, true);
            $active_workgroups = json_decode($site->active_group, true);
            $viewData->active_machines = $active_machines;
            $viewData->active_workgroups = $active_workgroups;
            $viewData->site = $site;
            $viewData->dates = $dates;
            $viewData->report_date = $report_date;
            $viewData->project = $project;
            $viewData->workgroups_filter = $workgroups_filter;
            $viewData->workmachine_filter = $workmachine_filter;
            $viewData->supplies_filter = $supplies_filter;
            $viewData->form_error = true;
            if ($site->contract_id) {
                $viewData->contract = $contract;
            }

            $html = $this->load->view("site_module/report_v/add/content", $viewData, true);

            echo json_encode([
                "success" => false,
                "form_html" => $html
            ]);

        }

    }

    public function update($report_id)
    {
        $report = $this->Report_model->get(array("id" => $report_id));
        $site = $this->Site_model->get(array("id" => $report->site_id));
        $project = $this->Project_model->get(array("id" => $site->project_id));

        $report_date = $report->report_date;

        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Report_supply_model");

        $workgroups = $this->input->post("workgroups[]") ?? [];
        $workmachine = $this->input->post("workmachines[]") ?? [];
        $supplies = $this->input->post("supplies[]") ?? [];

        $workgroups_filter = filter_array($workgroups, "workgroup");
        $workmachine_filter = filter_array($workmachine, "workmachine");
        $supplies_filter = filter_array($supplies, "supply");

        $off_days = ($this->input->post("off_days") == 0) ? "1" : "";

        $update_report = $this->Report_model->update(
            array(
                "id"=>$report_id
            ),
            array(
                "off_days" => $off_days,
                "aciklama" => $this->input->post("note"),
                "updatedAt" => date("Y-m-d"),
                "updatedBy" => active_user_id(),
             )
        );

        $delete_old_workgroup = $this->Report_workgroup_model->delete(array("report_id"=>$report_id));
        $delete_old_workmachine = $this->Report_workmachine_model->delete(array("report_id"=>$report_id));
        $delete_old_supplies = $this->Report_supply_model->delete(array("report_id"=>$report_id));

        foreach ($workgroups_filter as $workgroup) {
            $insert_workgroup = $this->Report_workgroup_model->add(
                array(
                    "site_id" => $site->id,
                    "report_id" => $report_id,
                    "project_id" => $site->project_id,
                    "contract_id" => $site->contract_id,
                    "workgroup" => $workgroup['workgroup'],
                    "number" => $workgroup['worker_count'],
                    "notes" => $workgroup['notes'],
                    "place" => $workgroup['place'],
                    "production" => $workgroup['production'],
                    "createdBy" => active_user_id(),
                )
            );
        }
        foreach ($workmachine_filter as $workmachine) {
            $insert_workmachine = $this->Report_workmachine_model->add(
                array(
                    "site_id" => $site->id,
                    "report_id" => $report_id,
                    "project_id" => $site->project_id,
                    "contract_id" => $site->contract_id,
                    "workmachine" => $workmachine['workmachine'],
                    "number" => $workmachine['machine_count'],
                    "notes" => $workmachine['machine_notes'],
                    "place" => $workmachine['machine_place'],
                    "production" => $workmachine['machine_production'],
                    "createdBy" => active_user_id(),
                )
            );
        }
        foreach ($supplies_filter as $supplies) {
            $insert_workmachine = $this->Report_supply_model->add(
                array(
                    "site_id" => $site_id,
                    "report_id" => $report_id,
                    "project_id" => $site->project_id,
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

        echo json_encode([
            "success" => true,
            "redirect" => base_url("Report/file_form/$report_id") // Sadece URL stringi
        ]);

    }

    public function delete($report_id)
    {
        $report = $this->Report_model->get(array("id" => $report_id));
        $report_date = dateFormat_dmy($report->report_date);
        $site = $this->Site_model->get(array("id" => $report->site_id));
        $project = $this->Project_model->get(array("id" => $site->project_id));
        $path = "uploads/project_v/$project->dosya_no/$site->dosya_no/Reports/$report_date";

        $delete_old_workgroup = $this->Report_workgroup_model->delete(array("report_id"=>$report_id));
        $delete_old_workmachine = $this->Report_workmachine_model->delete(array("report_id"=>$report_id));
        $delete_old_supplies = $this->Report_supply_model->delete(array("report_id"=>$report_id));


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
        redirect(base_url("site/file_form/$site->id"));
    }

    public function file_upload($id)
    {

        $item = $this->Report_model->get(array("id" => $id));
        $site = $this->Site_model->get(array("id" => $item->site_id));
        $project = $this->Project_model->get(array("id" => $site->project_id));
        $date = dateFormat_dmy($item->report_date);
        $path = 'uploads' . DIRECTORY_SEPARATOR .
            'project_v' . DIRECTORY_SEPARATOR .
            $project->dosya_no . DIRECTORY_SEPARATOR .
            $site->dosya_no . DIRECTORY_SEPARATOR .
            'Reports' . DIRECTORY_SEPARATOR .
            dateFormat_dmy($item->report_date) . DIRECTORY_SEPARATOR;

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

    public function filedelete_java($id)
    {

        $item = $this->Report_model->get(array("id" => $id));
        $site = $this->Site_model->get(array("id" => $item->site_id));
        $project = $this->Project_model->get(array("id" => $site->project_id));
        $date = dateFormat_dmy($item->report_date);
        $path = "uploads/project_v/$project->dosya_no/$site->dosya_no/Reports/$date";
        $thumb_path = "uploads/project_v/$project->dosya_no/$site->dosya_no/Reports/$date/thumbnails";
        $fileName = $this->input->post('fileName');
        unlink("$path/$fileName");
        unlink("$thumb_path/$fileName");
    }

    public function download_all($report_id)
    {

        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $report = $this->Report_model->get(array("id" => $report_id));
        $report_date = dateFormat_dmy($report->report_date);
        $site = $this->Site_model->get(array("id" => $report->site_id));
        $project = $this->Project_model->get(array("id" => $site->project_id));
        $path = "uploads/project_v/$project->dosya_no/$site->dosya_no/Reports/$report_date";
        $files = glob($path . '/*');
        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }
        $zip_name = "Foto-" . $report_date;
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
        $project = $this->Project_model->get(array("id" => $report->project_id));
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
        if (!empty($contract)){
            $pdf->Cell(80, 5, mb_strtoupper($contract->contract_name), 0, 0, "L", 0);
        }
        $pdf->Cell(50, 5, "", 0, 0, "L", 0);
        if (isset($weather)) {
            $pdf->Cell(30, 5, "En Düşük : $weather->min °C", 0, 0, "R", 0);
        }
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(30, 5, "İşveren", 0, 0, "L", 0);
        if (!empty($owner)) {
            $pdf->Cell(80, 5, $owner->company_name, 0, 0, "L", 0);
        }
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
        $imageDirectory = "uploads/project_v/$project->dosya_no/$site->dosya_no/Reports/$date/thumbnails";
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

    function getDailyForecastByCityName($city_name)
    {
        $api_key = 'hJA0Edlt4yr3aaQTe2V2b0i43R3A5LX5';

        // 1. Şehir adına göre location key al
        $location_url = "http://dataservice.accuweather.com/locations/v1/cities/search?apikey={$api_key}&q=" . urlencode($city_name) . "&language=tr";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $location_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $location_response = curl_exec($ch);

        if ($location_response === false) {
            echo 'Konum sorgusunda cURL Hatası: ' . curl_error($ch);
            curl_close($ch);
            return;
        }

        $location_data = json_decode($location_response, true);

        if (empty($location_data) || !isset($location_data[0]['Key'])) {
            echo "Şehir bulunamadı veya geçersiz: $city_name";
            curl_close($ch);
            return;
        }

        $city_key = $location_data[0]['Key'];
        $localized_city = $location_data[0]['LocalizedName'];
        $country = $location_data[0]['Country']['LocalizedName'];
        $region = $location_data[0]['AdministrativeArea']['LocalizedName'];

        // 2. Location key ile günlük hava durumu al
        $forecast_url = "http://dataservice.accuweather.com/forecasts/v1/daily/1day/{$city_key}?apikey={$api_key}&language=tr&metric=true";
        curl_setopt($ch, CURLOPT_URL, $forecast_url);
        $forecast_response = curl_exec($ch);

        if ($forecast_response === false) {
            echo 'Hava durumu sorgusunda cURL Hatası: ' . curl_error($ch);
            curl_close($ch);
            return;
        }

        $forecast_data = json_decode($forecast_response, true);
        curl_close($ch);

        if (!empty($forecast_data['DailyForecasts'])) {
            foreach ($forecast_data['DailyForecasts'] as $forecast) {
                $date = $forecast['Date'];
                $temperature_max = $forecast['Temperature']['Maximum']['Value'];
                $temperature_min = $forecast['Temperature']['Minimum']['Value'];
                $condition = $forecast['Day']['IconPhrase'];

                echo "Şehir: $localized_city<br>";
                echo "Ülke: $country<br>";
                echo "Bölge: $region<br>";
                echo "Tarih: " . date('d-m-Y', strtotime($date)) . "<br>";
                echo "Maksimum Sıcaklık: " . $temperature_max . "°C<br>";
                echo "Minimum Sıcaklık: " . $temperature_min . "°C<br>";
                echo "Hava Durumu: " . $condition . "<br><br>";
            }
        } else {
            echo "Hava durumu verisi alınamadı.";
        }
    }

    public function unique_report_date($report_date, $site_id)
    {
        // 1. Gelen tarihi YYYY-MM-DD formatına dönüştür
        $ymd_report_date = dateFormat('Y-m-d', $report_date);

        // 2. İleri tarih kontrolü
        $today_ymd = date('Y-m-d'); // Bugünün tarihi YYYY-MM-DD formatında

        if ($ymd_report_date > $today_ymd) {
            // Tarih bugünden ileriyse hata mesajı ayarla ve FALSE döndür
            $this->form_validation->set_message('unique_report_date', 'Rapor tarihi ileri bir tarih olamaz.');
            return FALSE;
        }

        // 3. Veritabanında benzersizlik kontrolü
        $this->load->model('Report_model'); // Modeli yüklüyoruz

        $record = $this->Report_model->get(array("site_id" => $site_id, "report_date" => $ymd_report_date));

        // Eğer bu tarih ve site_id için zaten bir kayıt varsa
        if ($record) {
            // Hata mesajını ayarla ve FALSE döndür
            $this->form_validation->set_message('unique_report_date', 'Bu tarihe ait rapor zaten bulunmaktadır.');
            return FALSE;
        }

        // Her iki kontrol de geçtiyse, TRUE döndür
        return TRUE;
    }


}
