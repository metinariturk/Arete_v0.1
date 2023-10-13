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
 $this->Theme_mode = get_active_user()->mode;        if (temp_pass_control()) {
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

        $viewData = new stdClass();

        $site_id = get_from_any("report", "site_id", "id", "$id");
        $project_id = project_id_site($site_id);
        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $site = $this->Site_model->get(array("id" => $site_id));

        $active_machines = json_decode($site->active_machine, true);
        $active_workgroups = json_decode($site->active_group, true);

        $active_sites = $this->Site_model->get_all(array());

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->users = $users;
        $viewData->site = $site;
        $viewData->project_id = $project_id;
        $viewData->active_machines = $active_machines;
        $viewData->active_workgroups = $active_workgroups;
        $viewData->active_sites = $active_sites;

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
        $this->load->library("form_validation");
        $site_id = get_from_any("report", "site_id", "id", "$id");
        $contract_id = get_from_any("site", "contract_id", "id", $site_id);
        $proje_id = get_from_any("site", "proje_id", "id", $site_id);

        $site = $this->Site_model->get(array(
            "id" => $site_id
        ));

        $contract = $this->Contract_model->get(array(
            "id" => $contract_id
        ));

        $project = $this->Project_model->get(array(
            "id" => $proje_id
        ));

        $site_code = get_from_any("site", "dosya_no", "id", "$site_id");
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->proje_id = $proje_id;
        $viewData->contract_id = $contract_id;
        $viewData->site = $site;
        $viewData->contract = $contract;
        $viewData->project = $project;

        $viewData->viewModule = $this->moduleFolder;

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

    public function save($id)
    {

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

        $min_temp = $this->input->post("min_temp[]");
        $max_temp = $this->input->post("max_temp[]");
        $event = $this->input->post("event[]");

        $weather_data = array("min_temp" => "$min_temp",
            "max_temp" => "$max_temp",
            "event" => "$event");

        $weather = json_encode($weather_data);

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
        $this->form_validation->set_rules("min_temp", "En Düşük Sıcaklık", "required|trim");
        $this->form_validation->set_rules("max_temp", "Yüksek Sıcaklık", "required|trim");

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
            $site_code = get_from_id("site", "dosya_no", $id);
            $proje_id = get_from_id("site", "proje_id", $id);
            $project_code = get_from_id("projects", "proje_kodu", $proje_id);

            $rep_date = $this->input->post("report_date");

            $path = "$this->File_Dir_Prefix/$project_code/$site_code/Reports/$rep_date";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                mkdir("$path/thumb", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "Dosya Oluşturulamadı";
                echo $path;
            }

            $off_days = ($this->input->post("off_days") == 0) ? "1" : "";

            $insert = $this->Report_model->add(
                array(
                    "dosya_no" => $file_name,
                    "site_id" => $id,
                    "report_date" => $report_date,
                    "weather" => $weather,
                    "workgroup" => json_encode($workgroups_filter),
                    "workmachine" => json_encode($workmachine_filter),
                    "supplies" => json_encode($supplies_filter),
                    "aciklama" => $this->input->post("note"),
                    "createdAt" => date("Y-m-d"),
                    "createdBy" => active_user_id(),
                    "off_days" => $off_days,
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

        echo "<pre>";
        print_r($workgroups_filter);
        echo "</pre>";
        echo "<pre>";
        print_r($workmachine_filter);
        echo "</pre>";
        echo "<pre>";
        print_r($supplies_filter);
        echo "</pre>";

        $min_temp = $this->input->post("min_temp[]");
        $max_temp = $this->input->post("max_temp[]");
        $event = $this->input->post("event[]");

        $weather_data = array("min_temp" => "$min_temp",
            "max_temp" => "$max_temp",
            "event" => "$event");

        $weather = json_encode($weather_data);

        if ($this->input->post("report_date")) {
            $report_date = dateFormat('Y-m-d', $this->input->post("report_date"));
        } else {
            $report_date = null;
        }

        $off_days = ($this->input->post("off_days") == 0) ? "1" : "";

        $update = $this->Report_model->update(
            array(
                "id" => $id
            ),
            array(
                "report_date" => $report_date,
                "weather" => $weather,
                "workgroup" => json_encode($workgroups_filter),
                "workmachine" => json_encode($workmachine_filter),
                "supplies" => json_encode($supplies_filter),
                "aciklama" => $this->input->post("note"),
                "createdAt" => date("Y-m-d"),
                "createdBy" => active_user_id(),
                "off_days" => $off_days

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

public
function delete($report_id)
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

public
function file_upload($id)
{
    $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $size = $_FILES["file"]["size"];

    $extention = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    $report_date = dateFormat_dmy(get_from_any("report", "report_date", "id", $id));
    $site_id = get_from_any("report", "site_id", "id", $id);

    $project_id = get_from_id("site", "proje_id", $site_id);
    $project_code = project_code($project_id);
    $site_code = site_code($site_id);
    $path = "$this->File_Dir_Prefix/$project_code/$site_code/Reports/$report_date";
    $thumb_path = "$path/thumb";

    if (!is_dir($path)) {
        mkdir("$path", 0777, TRUE);
    }
    if (!is_dir($thumb_path)) {
        mkdir("$thumb_path", 0777, TRUE);
    }

    $extention = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    $allowed_types = array("jpg", "jpeg", "png", "gif");
    if (in_array($extention, $allowed_types)) {
        $config["allowed_types"] = "*";
        $config["upload_path"] = "$path";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");


        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Report_file_model->add(
                array(
                    "img_url" => $uploaded_file,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                    "$this->Dependet_id_key" => $id
                )
            );

            $source_path = "$path/$file_name";

            if (class_exists('image_lab')) {
                echo "asd";
            }

            $config['image_library'] = 'gd2';
            $config['source_image'] = $source_path;
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = "";
            $config['height'] = 600;
            echo $config['new_image'] = $path . "/thumb/" . $file_name;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            echo $this->image_lib->display_errors();
        } else {
            echo "islem basarisiz";
            echo $config["upload_path"];
        }
    } else {
        $config["allowed_types"] = "*";
        $config["upload_path"] = "$path";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);


        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");


        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Report_file_model->add(
                array(
                    "img_url" => $uploaded_file,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                    "$this->Dependet_id_key" => $id
                )
            );

        } else {
            echo "islem basarisiz";
            echo $config["upload_path"];
        }
    }
}

public
function file_download($id)
{
    $fileName = $this->Report_file_model->get(
        array(
            "id" => $id
        )
    );

    $report_id = get_from_any("report_files", "report_id", "id", $id);
    $report_date = dateFormat_dmy(get_from_any("report", "report_date", "id", $report_id));
    $site_id = get_from_any("report", "site_id", "id", $report_id);
    $project_id = get_from_id("site", "proje_id", $site_id);
    $project_code = project_code($project_id);
    $site_code = get_from_id("site", "dosya_no", $site_id);
    $path = "$this->File_Dir_Prefix/$project_code/$site_code/Reports/$report_date";

    $file_path = "$path/$fileName->img_url";

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
function download_all($report_id)
{
    $this->load->library('zip');
    $this->zip->compression_level = 0;

    $report_date = dateFormat_dmy(get_from_any("report", "report_date", "id", $report_id));
    $site_id = get_from_any("report", "site_id", "id", $report_id);
    $project_id = get_from_id("site", "proje_id", $site_id);
    $project_code = project_code($project_id);
    $site_code = get_from_id("site", "dosya_no", $site_id);
    $path = "$this->File_Dir_Prefix/$project_code/$site_code/Reports/$report_date";

    $files = glob($path . '/*');

    foreach ($files as $file) {
        $this->zip->read_file($file, FALSE);
    }

    $zip_name = $report_date . "- Rapor";
    $this->zip->download("$zip_name");

}

public
function refresh_file_list($id)
{

    $viewData = new stdClass();

    /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
    $viewData->viewFolder = $this->viewFolder;
    $viewData->viewModule = $this->moduleFolder;

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

public
function fileDelete($id)
{
    $viewData = new stdClass();

    /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
    $viewData->viewModule = $this->moduleFolder;
    $viewData->viewFolder = $this->viewFolder;

    $fileName = $this->Report_file_model->get(
        array(
            "id" => $id
        )
    );

    $report_id = get_from_id("report_files", "report_id", $id);
    $report_date = dateFormat_dmy(get_from_any("report", "report_date", "id", $report_id));
    $site_id = get_from_any("report", "site_id", "id", $report_id);
    $project_id = get_from_id("site", "proje_id", $site_id);
    $project_code = project_code($project_id);
    $site_code = get_from_id("site", "dosya_no", $site_id);

    $path = "$this->File_Dir_Prefix/$project_code/$site_code/Reports/$report_date";
    $thumb_path = "$this->File_Dir_Prefix/$project_code/$site_code/Reports/$report_date/thumb";

    $delete = $this->Report_file_model->delete(
        array(
            "id" => $id
        )
    );

    if ($delete) {

        $path = "$path/$fileName->img_url";
        $thumb_path = "$thumb_path/" . get_thumb_name($fileName->img_url);

        unlink($path);
        if (!empty($thumb_path)) {
            unlink($thumb_path);
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->item = $this->Report_model->get(
            array(
                "id" => $report_id
            )
        );

        $viewData->item_files = $this->Report_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $report_id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }
}

public
function fileDelete_all($report_id)
{

    $viewData = new stdClass();

    /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
    $viewData->viewModule = $this->moduleFolder;
    $viewData->viewFolder = $this->viewFolder;

    $report_date = dateFormat_dmy(get_from_any("report", "report_date", "id", $report_id));
    $site_id = get_from_any("report", "site_id", "id", $report_id);
    $project_id = get_from_id("site", "proje_id", $site_id);
    $project_code = project_code($project_id);
    $site_code = get_from_id("site", "dosya_no", $site_id);

    $path = "$this->File_Dir_Prefix/$project_code/$site_code/Reports/$report_date";

    $delete = $this->Report_file_model->delete(
        array(
            "$this->Dependet_id_key" => $report_id
        )
    );

    if ($delete) {

        delete_files($path, true);

        if (is_dir($path)) {
            if (count(scandir($path)) === 2) { // Klasör boşsa
                rmdir($path);
            }
        }

        $viewData->item = $this->Report_model->get(
            array(
                "id" => $report_id
            )
        );

        $viewData->item_files = $this->Report_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $report_id
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

}
