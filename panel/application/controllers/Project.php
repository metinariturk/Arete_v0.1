<?php

class Project extends CI_Controller
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

        $models = [
            'Settings_model',
            'Project_model',
            'Payment_model',
            'Report_model',
            'Report_supply_model',
            'Report_workgroup_model',
            'Report_workmachine_model',
            'Contract_model',
            'Company_model',
            'Workman_model',
            'User_model',
            'Order_model',
            'Site_model',
            'Favorite_model'
        ];
        foreach ($models as $model) {
            $this->load->model($model);
        }

        $this->Settings = get_settings();

        $this->rules = array(
            "index" => array('project' => ['r', 'u', 'w', 'd']),
            "file_form" => array('project' => ['r', 'u', 'w', 'd']),
            "delete_form" => array('project' => ['u']),
            "save" => array('project' => ['w']),
            "update" => array('project' => ['u']),
            "hard_delete" => array('project' => ['d']),
            "file_upload" => array('project' => ['r', 'u']),
            "filedelete_java" => array('project' => ['u', 'd']),
            "download_all" => array('project' => ['w', 'r']),
            "duplicate_code_check" => array(),
            "duplicate_name_check" => array(),
            "favorite" => array(),
            "create_contract" => array('contract' => ['w']),
            "create_site" => array('site' => ['w']),

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


        $active_items = $this->Project_model->get_all(array("isActive" => 1));

        $inactive_items = $this->Project_model->get_all(array( "isActive" => 2));

        $all_items = $this->Project_model->get_all(array());


        $viewData = new stdClass();


        $items = $this->Project_model->get_all(array());
        $settings = $this->Settings_model->get();
        $users = $this->User_model->get_all();
        $next_project_name = get_next_file_code("Project");


        $viewData->active_items = $active_items;
        $viewData->inactive_items = $inactive_items;
        $viewData->all_items = $all_items;
        $viewData->next_project_name = $next_project_name;
        $viewData->items = $items;
        $viewData->users = $users;
        $viewData->settings = $settings;
        $this->load->view("project_v/list/index", $viewData);
    }

    public function file_form($id)
    {
        $item = $this->Project_model->get(array("id" => $id));
        $companys = $this->Company_model->get_all(array(), "company_name ASC");
        $main_contracts = $this->Contract_model->get_all(array("project_id" => $id, "parent" => 0));
        $sites = $this->Site_model->get_all(array("project_id" => $id));
        $next_contract_name = get_next_file_code("Contract");
        $next_site_name = get_next_file_code("Site");
        $users = $this->User_model->get_all(array());
        $upload_function = base_url("project/file_upload/$item->id");
        $path = "uploads/project_v/$item->dosya_no/main/";
        !is_dir($path) && mkdir($path, 0777, TRUE);
        $fav = $this->Favorite_model->get(array(
            "user_id" => active_user_id(),
            "module" => "project",
            "view" => "file_form",
            "module_id" => $id,
        ));
        $viewData = new stdClass();
        $settings = $this->Settings_model->get();


        $viewData->settings = $settings;
        $viewData->next_contract_name = $next_contract_name;
        $viewData->next_site_name = $next_site_name;
        $viewData->users = $users;
        $viewData->companys = $companys;
        $viewData->upload_function = $upload_function;
        $viewData->path = $path;
        $viewData->sites = $sites;
        $viewData->main_contracts = $main_contracts;
        $viewData->fav = $fav;

        $viewData->item = $item;

        $this->load->view("project_v/display/index", $viewData);
        $alert = null;
    }

    public function delete_form($id)
    {

        $item = $this->Project_model->get(array("id" => $id));
        $main_contracts = $this->Contract_model->get_all(array("project_id" => $id, "parent" => 0));
        $sites = $this->Site_model->get_all(array("project_id" => $id));
        $viewData = new stdClass();


        $viewData->sites = $sites;
        $viewData->main_contracts = $main_contracts;
        $viewData->item = $item;

        $this->load->view("project_v/delete_form/index", $viewData);
    }

    public function save()
    {

        $next_project_name = get_next_file_code("Project");
        $this->load->library("form_validation");
        $this->form_validation->set_rules("project_code", "Proje Kodu", "numeric|required|trim|callback_duplicate_code_check");
        $this->form_validation->set_rules("project_name", "Proje Adı", "required|trim|is_unique[project.project_name]");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> boş bırakılamaz",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
                "numeric" => "<b>{field}</b> alanı bir sayı olmalıdır",
                "is_unique" => "<b>{field}</b> 'na sahip başka bir proje mevcut",
                "duplicate_code_check" => "<b>{field}</b> - '$next_project_name' daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
            )
        );
        $validate = $this->form_validation->run();
        if ($validate) {
            $project_code = "PRJ-" . $next_project_name;
            $path = "uploads/project_v/$project_code";
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $insert = $this->Project_model->add(
                array(
                    "dosya_no" => $project_code,
                    "project_name" => yazim_duzen($this->input->post("project_name")),
                    "notes" => $this->input->post("notes"),
                    "createdAt" => date("Y-m-d H:i:s"),
                    "isActive" => 1
                )
            );
            $record_id = $this->db->insert_id();
            redirect(base_url("project/file_form/$record_id"));
        } else {
            $viewData = new stdClass();
            $items = $this->Project_model->get_all();
            $settings = $this->Settings_model->get();
            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));


            $viewData->form_error = true;
            $viewData->items = $items;
            $viewData->settings = $settings;
            $viewData->users = $users;
            $this->load->view("project_v/list/index", $viewData);
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form Kontrol Hatalarını İnceleyiniz",
                "type" => "danger"
            );


        }
    }

    public function update($id)
    {

        $project = $this->Project_model->get(array("id" => $id));
        $updated_name = $this->input->post("project_name");
        $this->load->library("form_validation");
        if ($updated_name != $project->project_name) {
            $this->form_validation->set_rules("project_name", "Proje Adı", "required|trim|is_unique[project.project_name]");
        } else {
            $this->form_validation->set_rules("project_name", "Proje Adı", "required|trim");
        }
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> boş bırakılamaz",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
                "numeric" => "<b>{field}</b> alanı bir sayı olmalıdır",
                "is_unique" => "<b>{field}</b> 'na sahip başka bir proje mevcut",
            )
        );
        $validate = $this->form_validation->run();
        if ($validate) {
            $update = $this->Project_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "project_name" => $this->input->post("project_name"),
                    "notes" => $this->input->post("notes"),
                )
            );

            redirect(base_url("Project/file_form/$id"));
        } else {
            $item = $this->Project_model->get(
                array(
                    "id" => $id
                )
            );
            $upload_function = base_url("Project/file_upload/$item->id");
            $path = "uploads/project_v/$item->dosya_no/main/";
            !is_dir($path) && mkdir($path, 0777, TRUE);
            $fav = $this->Favorite_model->get(array(
                "user_id" => active_user_id(),
                "module" => "project",
                "view" => "file_form",
                "module_id" => $id,
            ));
            $sites = $this->Site_model->get_all(array('project_id' => $id));
            $contracts = $this->Contract_model->get_all(array("project_id" => $id,));
            $viewData = new stdClass();
            $settings = $this->Settings_model->get();


            $viewData->settings = $settings;
            $viewData->form_error = true;
            $viewData->upload_function = $upload_function;
            $viewData->path = $path;
            $viewData->sites = $sites;
            $viewData->contracts = $contracts;
            $viewData->fav = $fav;

            $viewData->item = $item;

            $this->load->view("project_v/display/index", $viewData);
            $alert = null;

        }
    }

    public function hard_delete($id)
    {

        $project = $this->Project_model->get(array("id" => $id));
        if (!$project) {
            redirect(base_url("error"));
        }
        // Silme işlemini engelleyecek kayıtları kontrol et
        $contracts = $this->Contract_model->get_all(array("project_id" => $id));
        $sites = $this->Site_model->get(array("project_id" => $id));
        $reports = $this->Report_model->get(array("project_id" => $id));
        $report_supply = $this->Report_supply_model->get(array("project_id" => $id));
        $report_workgroup = $this->Report_workgroup_model->get(array("project_id" => $id));
        $report_workmachine = $this->Report_workmachine_model->get(array("project_id" => $id));
        if ($contracts || $sites || $reports || $report_supply || $report_workgroup || $report_workmachine) {
            redirect(base_url("project/file_form/$project->id"));
        }
        $path = "uploads/project_v/$project->dosya_no";
        if (!deleteDirectory($path)) {
            log_message('error', "Klasör silinemedi: $path");
        }
        // Projeyi ve ilişkili tüm verileri sil
        $this->db->trans_start(); // Transaction başlat
        $this->Project_model->delete(array("id" => $id));
        $this->Favorite_model->delete(array("module" => "project", "module_id" => $id));
        $this->db->trans_complete(); // Transaction tamamla
        if ($this->db->trans_status() === FALSE) {
            redirect(base_url("error"));
        }
        redirect(base_url("project"));
    }

    public function file_upload($id)
    {
        if (isAdmin() || permission_control("project", "u")) {
            $project = $this->Project_model->get(array("id" => $id));
            $path = "uploads/project_v/$project->dosya_no/main/";
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
                // Yüklenen dosyaları işleyin
                foreach ($uploadedFiles['files'] as $file) {
                    // Dosya boyutunu kontrol edin ve yeniden boyutlandırma işlemlerini gerçekleştirin
                    if ($file['size'] > 2097152) {
                        // Yeniden boyutlandırma işlemi için uygun genişlik ve yükseklik değerlerini belirleyin
                        $newWidth = null; // Örnek olarak 500 piksel genişlik
                        $newHeight = 1080; // Yüksekliği belirtmediğiniz takdirde orijinal oran korunur
                        // Yeniden boyutlandırma işlemi
                        FileUploader::resize($path . $file['name'], $newWidth, $newHeight, $destination = null, $crop = false, $quality = 75);
                    }
                }
            }
            header('Content-Type: application/json');
            echo json_encode($uploadedFiles);
            exit;
        } else {
            echo "Bu İşlemi Yapma Yetkiniz Yok";
        }
    }

    public function filedelete_java($id)
    {
        if (isAdmin() && permission_control("project", "d")) {
            $fileName = $this->input->post('fileName');
            $project = $this->Project_model->get(array("id" => $id));
            $path = "uploads/project_v/$project->dosya_no/main/";
            unlink("$path/$fileName");
        } else {
            echo "Bu İşlemi Yapma Yetkiniz Yok";
        }
    }

    public
    function download_all($project_id)
    {
        if (isAdmin() && permission_control("project", "u")) {
            $this->load->library('zip');
            $this->zip->compression_level = 0;
            $project_code = project_code($project_id);
            $project_name = get_from_id("project", "project_name", $project_id);
            $path = "uploads/project_v/$project_code/main";
            $files = glob($path . '/*');
            foreach ($files as $file) {
                $this->zip->read_file($file, FALSE);
            }
            $zip_name = $project_name;
            $this->zip->download("$zip_name");
        } else {
            echo "Bu İşlemi Yapma Yetkiniz Yok";
        }
    }

    public
    function duplicate_code_check($str)
    {

        $file_name = "PRJ-" . $str;
        $var = count_data("project", "dosya_no", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public
    function duplicate_name_check($str)
    {
        $var = count_data("project", "project_name", $str);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public
    function favorite($id)
    {
        $fav_id = get_from_any_and_and("favorite", "module", "project", "user_id", active_user_id(), "module_id", "$id");
        if (!empty($fav_id)) {
            $this->Favorite_model->delete(
                array(
                    "id" => $fav_id
                )
            );
            echo "favoriden çıktı";
        } else {
            $insert = $this->Favorite_model->add(
                array(
                    "module" => "project",
                    "view" => "file_form",
                    "module_id" => $id,
                    "user_id" => active_user_id(),
                    "title" => project_code($id) . " - " . project_name($id),
                )
            );
            echo "favoriye eklendi";
        }
    }

    public function create_contract($project_id = null, $parent_contract = null)
    {

        $project_code = project_code($project_id);
        $file_name = "SOZ-" . get_next_file_code("Contract");
        $this->load->library("form_validation");
        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|trim");
        $this->form_validation->set_rules("contract_name", "Sözleşme Ad", "required|trim");
        $this->form_validation->set_rules("isveren", "İşveren", "required|trim");
        $this->form_validation->set_rules("yuklenici", "Yüklenici", "required|trim");
        $this->form_validation->set_rules("sozlesme_tarih", "Sözleşme Tarih", "required|trim");
        $this->form_validation->set_rules("sozlesme_turu", "Sözleşme Türü", "required|trim");
        $this->form_validation->set_rules("isin_turu", "İşin Türü", "required|trim");
        $this->form_validation->set_rules("isin_suresi", "İşin Süresi", "greater_than[0]|required|trim|integer");
        $this->form_validation->set_rules("sozlesme_bedel", "Sözleşme Bedel", "greater_than[0]|required|trim|numeric");
        $this->form_validation->set_rules("para_birimi", "Para Birimi", "required|trim");
        // Form Validation Hatalarını Tanımla
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük olmalıdır",
                "less_than_equal_to" => "<b>{field}</b> uygulaması seçilmelidir",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );
        // Form Validation'u Çalıştır
        $validate = $this->form_validation->run();
        if ($validate) {
            // Dizin oluşturma işlemi
            $path = "uploads/project_v/$project_code/$file_name";
            !is_dir($path) || mkdir($path, 0777, TRUE);
            // Tarih ve adı biçimlendirme işlemleri
            $sozlesme_tarih = $this->input->post("sozlesme_tarih") ? dateFormat('Y-m-d', $this->input->post("sozlesme_tarih")) : null;
            $sozlesme_bitis = dateFormat('Y-m-d', date_plus_days($this->input->post("sozlesme_tarih"), $this->input->post("isin_suresi") - 1));
            $contract_name = mb_convert_case($this->input->post("contract_name"), MB_CASE_TITLE, "UTF-8");
            // Veritabanına Ekleme İşlemi
            $insert = $this->Contract_model->add(
                array(
                    "project_id" => $project_id,
                    "dosya_no" => $file_name,
                    "contract_name" => $contract_name,
                    "isveren" => $this->input->post("isveren"),
                    "yuklenici" => $this->input->post("yuklenici"),
                    "sozlesme_tarih" => $sozlesme_tarih,
                    "sozlesme_turu" => $this->input->post("sozlesme_turu"),
                    "isin_turu" => $this->input->post("isin_turu"),
                    "isin_suresi" => $this->input->post("isin_suresi"),
                    "sozlesme_bitis" => $sozlesme_bitis,
                    "sozlesme_bedel" => $this->input->post("sozlesme_bedel"),
                    "para_birimi" => $this->input->post("para_birimi"),
                    "isActive" => "1",
                )
            );
            $viewData = new stdClass();
            $item = $this->Project_model->get(array("id" => $project_id));
            $main_contracts = $this->Contract_model->get_all(array("project_id" => $project_id, "parent" => 0));
            $settings = $this->Settings_model->get();
            // View'e gönderilecek Değişkenlerin Set Edilmesi
            $viewData->item = $item;
            $viewData->main_contracts = $main_contracts;
            $viewData->settings = $settings;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("project_v/display/contract/contract_table", $viewData, true)
            );
            echo json_encode($response);
        } else {
            // Form Validation Başarısız, hata mesajları ile birlikte görüntüyü yükle
            $viewData = new stdClass();
            $item = $this->Project_model->get(array("id" => $project_id));
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all(array(), "company_name ASC");
            $main_contracts = $this->Contract_model->get_all(array("project_id" => $project_id, "parent" => 0));
            $next_contract_name = get_next_file_code("Contract");


            $viewData->companys = $companys;
            $viewData->next_contract_name = $next_contract_name;
            $viewData->main_contracts = $main_contracts;
            $viewData->item = $item;
            $viewData->settings = $settings;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("project_v/display/contract/add_contract_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public function create_site($project_id = null)
    {

        $next_site_name = get_next_file_code("Site");
        $file_name = "SNT-" . $next_site_name;
        $this->load->library("form_validation");
        $this->form_validation->set_rules("contract_id", "Sözleşme", "required|trim|integer");
        $this->form_validation->set_rules("santiye_sefi", "Şantiye Şefi", "greater_than[0]|required|trim");
        $this->form_validation->set_rules("santiye_ad", "Şantiye Adı", "required|trim|is_unique[site.santiye_ad]");
        $this->form_validation->set_message(
            array(
                "integer" => "<b>{field}</b> alanı doldurulmalıdır",
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> Seçilmelidir",
                "is_unique" => "<b>Aynı İsimde Şanitye Mevcut</b> Farklı İsim Seçiniz",
            )
        );
        $validate = $this->form_validation->run();
        if ($validate) {
            $project_code = project_code($project_id);
            $path = "uploads/project_v/$project_code/$file_name/Main/";
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }
            if ($this->input->post("teslim_tarihi")) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarihi"));
            } else {
                $teslim_tarihi = null;
            }
            $personeller = $this->input->post('teknik_personeller');
            if (!empty($personeller)) {
                $data_personel = implode(",", array_unique($personeller));
            } else {
                $data_personel = null;
            }
            $sub_contracts = $this->input->post('sub_contract');
            $insert = $this->Site_model->add(
                array(
                    "project_id" => $project_id,
                    "contract_id" => $this->input->post('contract_id'),
                    "dosya_no" => $file_name,
                    "santiye_ad" => $this->input->post("santiye_ad"),
                    "santiye_sefi" => $this->input->post("santiye_sefi"),
                    "teknik_personel" => $data_personel,
                    "is_Active" => "1",
                )
            );
            $viewData = new stdClass();
            $item = $this->Project_model->get(array("id" => $project_id));
            $main_contracts = $this->Contract_model->get_all(array("project_id" => $project_id, "parent" => 0));
            $settings = $this->Settings_model->get();
            $sites = $this->Site_model->get_all(array("project_id" => $project_id));
            // View'e gönderilecek Değişkenlerin Set Edilmesi
            $viewData->item = $item;
            $viewData->main_contracts = $main_contracts;
            $viewData->settings = $settings;
            $viewData->sites = $sites;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("project_v/display/site/site_table", $viewData, true)
            );
            echo json_encode($response);
        } else {
            // Form Validation Başarısız, hata mesajları ile birlikte görüntüyü yükle
            $viewData = new stdClass();
            $item = $this->Project_model->get(array("id" => $project_id));
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all(array(), "company_name ASC");
            $sites = $this->Site_model->get_all(array("project_id" => $project_id));
            $main_contracts = $this->Contract_model->get_all(array("project_id" => $project_id, "parent" => 0));
            $next_site_name = get_next_file_code("Site");
            $users = $this->User_model->get_all();


            $viewData->companys = $companys;
            $viewData->sites = $sites;
            $viewData->next_site_name = $next_site_name;
            $viewData->main_contracts = $main_contracts;
            $viewData->item = $item;
            $viewData->settings = $settings;
            $viewData->users = $users;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("project_v/display/site/add_site_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public function changestatus($id)
    {
        $item = $this->Project_model->get(array("id" => $id));
        if (!$item) {
            echo "Kayıt bulunamadı.";
            return false;
        }

        // Güncelleme işlemi
        if ($item->isActive == 0 || $item->isActive == 1) {
            $update = $this->Project_model->update(
                array("id" => $id),
                array("isActive" => 2)
            );
        } elseif ($item->isActive == 2) {
            $update = $this->Project_model->update(
                array("id" => $id),
                array("isActive" => 1)
            );
        } else {
            echo "Geçerli bir durum güncellemesi yapılamadı.";
            return false;
        }

        // Güncelleme sonucu kontrolü
        if ($update) {
            echo "Durum başarıyla güncellendi.";
        } else {
            echo "Güncelleme sırasında bir hata oluştu.";
        }
    }


}
