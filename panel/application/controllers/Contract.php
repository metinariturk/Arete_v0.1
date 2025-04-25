<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class Contract extends MY_Controller
{

    public function __construct()
    {

        parent::__construct();
        // Kullanıcı girişi kontrolü

        $models = [
            'Advance_model',
            'Attendance_model',
            'Boq_model',
            'Bond_model',
            'City_model',
            'Payment_settings_model',
            'Payment_sign_model',
            'Company_model',
            'Contract_model',
            'Contract_price_model',
            'Costinc_model',
            'Collection_model',
            'District_model',
            'Extime_model',
            'Favorite_model',
            'Newprice_model',
            'Payment_model',
            'Project_model',
            'Report_model',
            'Report_supply_model',
            'Report_workgroup_model',
            'Report_workmachine_model',
            'Settings_model',
            'Site_model',
            'User_model',
        ];
        foreach ($models as $model) {
            $this->load->model($model);
        }

        $this->rules = array(
            "add_leader" => array('payment' => ['u']),
            "add_main_group" => array('payment' => ['u', 'w', 'd']),
            "add_sub_contract" => array('contract' => ['w']),
            "back_main" => array('payment' => ['r']),
            "changestatus" => array('contract' => ['u']),
            "create_advance" => array('payment' => ['w', 'u']),
            "create_bond" => array('payment' => ['w', 'u']),
            "create_collection" => array('payment' => ['w', 'u']),
            "create_contract" => array('contract' => ['w']),
            "create_folder" => array('contract' => ['w', 'u']),
            "create_payment" => array('payment' => ['w']),
            "delete_advance" => array('payment' => ['d']),
            "delete_bond" => array('payment' => ['d']),
            "delete_collection" => array('payment' => ['d']),
            "delete_contract_price" => array('payment' => ['d']),
            "delete_file" => array('contract' => ['u', 'd']),
            "delete_folder" => array('contract' => ['u', 'd']),
            "delete_form" => array('contract' => ['d']),
            "delete_group" => array('payment' => ['u', 'd']),
            "delete_item" => array('payment' => ['u', 'd']),
            "delete_main" => array('payment' => ['u', 'd']),
            "delete_sub" => array('payment' => ['u', 'd']),
            "download_all" => array('contract' => ['r', 'u', 'w']),
            "download_backup" => array('contract' => ['r', 'u', 'w', 'd']),
            "download_file" => array('contract' => ['r', 'u', 'w', 'd']),
            "edit_advance" => array('payment' => ['u', 'd']),
            "edit_bond" => array('payment' => ['u', 'd']),
            "edit_collection" => array('payment' => ['u', 'd']),
            "edit_contract" => array('contract' => ['u', 'd']),
            "edit_payment" => array('payment' => ['u', 'd']),
            "favorite" => array('contract' => ['r', 'u']),
            "file_form" => array('contract' => ['r']),
            "file_upload" => array('contract' => ['w', 'r', 'u']),
            "filedelete_java" => array('contract' => ['u', 'd']),
            "folder_open" => array('contract' => ['r', 'w', 'u', 'd']),
            "hard_delete" => array('contract' => ['d']),
            "index" => array('contract' => ['w', 'r', 'u']),
            "open_add_sub_contract_modal" => array('contract' => ['w', 'r', 'u']),
            "open_edit_advance_modal" => array('contract' => ['w', 'r', 'u']),
            "open_edit_bond_modal" => array('contract' => ['w', 'r', 'u']),
            "open_edit_collection_modal" => array('payment' => ['w', 'u']),
            "open_edit_contract_modal" => array('contract' => ['w', 'r', 'u']),
            "open_edit_payment_modal" => array('payment' => ['w', 'u']),
            "open_edit_pricegroup_modal" => array('payment' => ['w', 'u']),
            "open_sub" => array('payment' => ['w', 'u']),
            "refresh_contract_price" => array('payment' => ['w', 'u']),
            "refresh_leader_group" => array('payment' => ['w', 'u']),
            "update_boqs" => array('payment' => ['w', 'r', 'u', 'd']),
            "update_leader" => array('payment' => ['u', 'd']),
            "update_leader_selection" => array('payment' => ['u', 'd']),
            "update_sub_group" => array('payment' => ['u', 'd']),
            "upload_book_excel" => array('payment' => ['u', 'd']),

            "date_greater_than" => array(),
            "date_greater_than_equal" => array(),
            "date_less_than" => array(),
            "date_less_than_equal" => array(),
            "sitedel_contractday" => array(),
            "sitedel_date" => array(),
            "unique_folder_name" => array(),
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

        // Devam Eden Sözleşmeler (isActive = 1), tarihe göre yeni başta
        $active_items = $this->Contract_model->get_all([
            "isActive" => 1
        ], "sozlesme_tarih DESC");

        // Biten Sözleşmeler (isActive = 0)
        $inactive_items = $this->Contract_model->get_all([
            "isActive" => 2
        ], "sozlesme_tarih DESC");

        // Tüm Sözleşmeler
        $all_items = $this->Contract_model->get_all([], "sozlesme_tarih DESC");

        $viewData = new stdClass();
        $viewData->active_items = $active_items;
        $viewData->inactive_items = $inactive_items;
        $viewData->all_items = $all_items;
        

        $this->load->view("contract_module/contract_v/list/index", $viewData);
    }

    public function file_form($id = null)
    {
        null_parameter_error($id);


        $fav = $this->Favorite_model->get(array(
            "user_id" => active_user_id(),
            "module" => "contract",
            "view" => "file_form",
            "module_id" => $id,
        ));

        // Değişken tanımları
        $advances = $this->Advance_model->get_all(array('contract_id' => $id));
        $bonds = $this->Bond_model->get_all(array('contract_id' => $id));
        $collections = $this->Collection_model->get_all(array('contract_id' => $id), "tahsilat_tarih ASC");
        $companys = $this->Company_model->get_all(array(), "company_name ASC");
        $costincs = $this->Costinc_model->get_all(array('contract_id' => $id));
        $extimes = $this->Extime_model->get_all(array('contract_id' => $id));
        $item = $this->Contract_model->get(array("id" => $id));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $id, 'leader' => 1));
        $main_bond = $this->Bond_model->get(array('contract_id' => $id, 'teminat_gerekce' => 'contract'));
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1));
        $newprices = $this->Newprice_model->get_all(array('contract_id' => $id));
        $payments = $this->Payment_model->get_all(array('contract_id' => $id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $id, "main_group" => 1), "code ASC");
        $project = $this->Project_model->get(array("id" => $item->project_id));
        $site = $this->Site_model->get(array("project_id" => $item->project_id));
        $sub_contracts = $this->Contract_model->get_all(array('parent' => $item->id));
        $upload_function = base_url("Contract/file_upload/$item->id");
        $main_path = "uploads/project_v/$project->dosya_no/$item->dosya_no";
        $subdirs = ['Contract', 'Collection', 'Advance', 'Offer', 'Payment'];
        createDirectories($main_path, $subdirs);
        $main_folders = get_dir_contents($main_path, 'dir');
        $viewData = new stdClass();
        // View'e gönderilecek Değişkenlerin Set Edilmesi
        $viewData->advances = $advances;
        $viewData->bonds = $bonds;
        $viewData->collections = $collections;
        $viewData->companys = $companys;
        $viewData->costincs = $costincs;
        $viewData->extimes = $extimes;
        $viewData->fav = $fav;
        $viewData->form_error = null;
        $viewData->item = $item;
        $viewData->leaders = $leaders;
        $viewData->main_bond = $main_bond;
        $viewData->main_folders = $main_folders;
        $viewData->sub_contracts = $sub_contracts;
        $viewData->main_groups = $main_groups;
        $viewData->main_path = $main_path;
        $viewData->newprices = $newprices;
        $viewData->payments = $payments;
        $viewData->prices_main_groups = $prices_main_groups;
        $viewData->project = $project;
        $viewData->site = $site;

        $viewData->upload_function = $upload_function;

        try {
            $this->load->view("contract_module/contract_v/display/index", $viewData);
        } catch (Exception $e) {
            log_message('error', 'Görünüm yüklenirken hata oluştu: ' . $e->getMessage());
            echo "Görünüm yüklenirken bir hata oluştu."; // Kullanıcıya genel bir hata mesajı
        }

    }

    public function create_contract($project_id = null, $parent_contract = null)
    {


        $project_code = project_code($project_id);
        $file_name = "SOZ-" . $this->input->post('dosya_no');
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
            $path = "uploads/$this->Module_Main_Dir/$project_code/$file_name";
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

            $record_id = $this->db->insert_id();
            redirect(base_url("Contract/file_form/$record_id"));
        } else {
            // Form Validation Başarısız, hata mesajları ile birlikte görüntüyü yükle

            $viewData = new stdClass();
            $project = $this->Project_model->get(array("id" => $project_id));
            $companys = $this->Company_model->get_all(array(), "company_name ASC");
            

            
            $viewData->project = $project;
            $viewData->companys = $companys;
            $viewData->project_id = $project_id;
            $viewData->form_error = true;
            $this->load->view("contract_module/contract_v/add_main/index", $viewData);
        }
    }

    public function add_sub_contract($parent_contract)
    {


        $item = $this->Contract_model->get(array("id" => $parent_contract));
        $project = $this->Project_model->get(array("id" => $item->project_id));
        $next_contract_name = get_next_file_code("Contract");
        $file_name = "SOZ-" . $next_contract_name;
        $this->load->library("form_validation");
        $this->form_validation->set_rules("sub_dosya_no", "Dosya No", "greater_than[0]|trim");
        $this->form_validation->set_rules("sub_contract_name", "Sözleşme Ad", "required|trim");
        $this->form_validation->set_rules("sub_isveren", "İşveren", "required|trim");
        $this->form_validation->set_rules("sub_yuklenici", "Yüklenici", "required|trim");
        $this->form_validation->set_rules("sub_sozlesme_tarih", "Sözleşme Tarih", "required|trim");
        $this->form_validation->set_rules("sub_sozlesme_turu", "Sözleşme Türü", "required|trim");
        $this->form_validation->set_rules("sub_isin_turu", "İşin Türü", "required|trim");
        $this->form_validation->set_rules("sub_isin_suresi", "İşin Süresi", "greater_than[0]|required|trim|integer");
        $this->form_validation->set_rules("sub_sozlesme_bedel", "Sözleşme Bedel", "greater_than[0]|required|trim|numeric");
        $this->form_validation->set_rules("sub_para_birimi", "Para Birimi", "required|trim");
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
            $path = "uploads/$this->Module_Main_Dir/$project->dosya_no/$file_name";
            if (!is_dir($path)) {
                try {
                    mkdir($path, 0777, TRUE);
                } catch (Exception $e) {
                    log_message('error', 'Dizin oluşturulamadı: ' . $e->getMessage());
                }
            }
            // Tarih ve adı biçimlendirme işlemleri
            $sozlesme_tarih = $this->input->post("sub_sozlesme_tarih") ? dateFormat('Y-m-d', $this->input->post("sub_sozlesme_tarih")) : null;
            $sozlesme_bitis = dateFormat('Y-m-d', date_plus_days($this->input->post("sub_sozlesme_tarih"), $this->input->post("sub_isin_suresi") - 1));
            $contract_name = mb_convert_case($this->input->post("sub_contract_name"), MB_CASE_TITLE, "UTF-8");
            // Veritabanına Ekleme İşlemi
            $insert = $this->Contract_model->add(
                array(
                    "project_id" => $project->id,
                    "dosya_no" => $file_name,
                    "contract_name" => $contract_name,
                    "isveren" => $item->yuklenici,
                    "yuklenici" => $this->input->post("sub_yuklenici"),
                    "sozlesme_tarih" => $sozlesme_tarih,
                    "sozlesme_turu" => $this->input->post("sub_sozlesme_turu"),
                    "isin_turu" => $this->input->post("sub_isin_turu"),
                    "isin_suresi" => $this->input->post("sub_isin_suresi"),
                    "sozlesme_bitis" => $sozlesme_bitis,
                    "sozlesme_bedel" => $this->input->post("sub_sozlesme_bedel"),
                    "para_birimi" => $this->input->post("sub_para_birimi"),
                    "parent" => $item->id,
                    "isActive" => "1",
                )
            );
            $viewData = new stdClass();
            
            
            $item = $this->Contract_model->get(array("id" => $parent_contract));
            $sub_contracts = $this->Contract_model->get_all(array("parent" => $item->id));
            // View'e gönderilecek Değişkenlerin Set Edilmesi
            $viewData->item = $item;
            $viewData->sub_contracts = $sub_contracts;

            $response = array(
                'status' => 'success',
                'html' => $this->load->view("contract_module/contract_v/display/sub_contract/sub_contract_table", $viewData, true)
            );
            echo json_encode($response);
        } else {
            // Form Validation Başarısız, hata mesajları ile birlikte görüntüyü yükle
            $viewData = new stdClass();
            $item = $this->Contract_model->get(array("id" => $parent_contract));

            $companys = $this->Company_model->get_all(array(), "company_name ASC");
            $next_contract_name = get_next_file_code("Contract");
            $sub_contracts = $this->Contract_model->get_all(array("parent" => $item->id));
            $viewData->companys = $companys;
            $viewData->next_contract_name = $next_contract_name;
            $viewData->item = $item;
            $viewData->sub_contracts = $sub_contracts;

            $viewData->form_error = true;


            $response = array(
                'status' => 'error',
                'html' => $this->load->view("contract_module/contract_v/display/sub_contract/add_sub_contract_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public function sitedel_date($id)
    {

        $sozlesme_tarihi = dateFormat('d-m-Y', get_from_any("contract", "sozlesme_tarih", "id", "$id"));
        $isin_suresi = get_from_any("contract", "isin_suresi", "id", "$id");
        $this->load->library("form_validation");
        $this->form_validation->set_rules("teslim_tarih", "Teslim Tarihi", "callback_sitedel_contractday[$sozlesme_tarihi]|required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );
        $validate = $this->form_validation->run();
        if ($validate) {
            $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarih"));
            $sozlesme_bitis = dateFormat('Y-m-d', (date_plus_days($teslim_tarihi, ($isin_suresi - 1))));
            $update = $this->Contract_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "sitedel_date" => $teslim_tarihi,
                    "sozlesme_bitis" => $sozlesme_bitis,
                )
            );
            redirect(base_url("Contract/file_form/$id/sitedel"));
        } else {
            redirect(base_url("Contract/file_form/$id/sitedel/error"));
        }
    }

    public function delete_form($id)
    {

        $item = $this->Contract_model->get(array("id" => $id));
        $sub_contracts = $this->Contract_model->get_all(array("parent" => $id));
        $sites = $this->Site_model->get_all(array("contract_id" => $id));
        $advances = $this->Advance_model->get_all(array('contract_id' => $id));
        $bonds = $this->Bond_model->get_all(array('contract_id' => $id));
        $costincs = $this->Costinc_model->get_all(array('contract_id' => $id));
        $collections = $this->Collection_model->get_all(array('contract_id' => $id));
        $extimes = $this->Extime_model->get_all(array('contract_id' => $id));
        $newprices = $this->Newprice_model->get_all(array('contract_id' => $id));
        $payments = $this->Payment_model->get_all(array('contract_id' => $id));
        $viewData = new stdClass();


        $viewData->item = $item;
        $viewData->sub_contracts = $sub_contracts;
        $viewData->sites = $sites;
        $viewData->advances = $advances;
        $viewData->bonds = $bonds;
        $viewData->costincs = $costincs;
        $viewData->collections = $collections;
        $viewData->extimes = $extimes;
        $viewData->newprices = $newprices;
        $viewData->payments = $payments;
        $this->load->view("contract_module/contract_v/delete_form/index", $viewData);
    }

    public function hard_delete($id)
    {


        // Sözleşme verisini al
        $contract = $this->Contract_model->get(array("id" => $id));
        // Sözleşme bulunamazsa hata sayfasına yönlendir
        if (!$contract) {
            redirect(base_url("error"));
        }
        // Proje ve şantiye verilerini al
        $sub_contract = $this->Contract_model->get(array("parent" => $id));
        if (!empty($sub_contract)) {
            redirect(base_url("error"));
        }
        $project = $this->Project_model->get(array("id" => $contract->project_id));
        $site = $this->Site_model->get(array("contract_id" => $id));
        $path = "uploads/$this->Module_Main_Dir/$project->dosya_no/$contract->dosya_no";
        $site_path = '';
        if (isset($site)) {
            $site_path = "uploads/$this->Module_Main_Dir/$project->dosya_no/$site->dosya_no";
        }
        // Klasör silme işlemi - Sözleşme yolu
        if (!deleteDirectory($path)) {
            log_message('error', "Sözleşme klasörü silinemedi: $path");
        } else {
            log_message('info', "Sözleşme klasörü silindi: $path");
        }
        // Şantiye varsa, şantiye klasörünü sil
        if ($site_path && !deleteDirectory($site_path)) {
            log_message('error', "Şantiye klasörü silinemedi: $site_path");
        } elseif ($site_path) {
            log_message('info', "Şantiye klasörü silindi: $site_path");
        }
        // Transaction başlat
        $this->db->trans_start();
        // Tüm ilgili kayıtları sil
        $delete_status = [
            $this->Advance_model->delete(array("contract_id" => $id)),
            $this->Attendance_model->delete(array("contract_id" => $id)),
            $this->Bond_model->delete(array("contract_id" => $id)),
            $this->Boq_model->delete(array("contract_id" => $id)),
            $this->Collection_model->delete(array("contract_id" => $id)),
            $this->Contract_price_model->delete(array("contract_id" => $id)),
            $this->Costinc_model->delete(array("contract_id" => $id)),
            $this->Extime_model->delete(array("contract_id" => $id)),
            $this->Newprice_model->delete(array("contract_id" => $id)),
            $this->Payment_model->delete(array("contract_id" => $id)),
            $this->Payment_settings_model->delete(array("contract_id" => $id)),
            $this->Payment_sign_model->delete(array("contract_id" => $id)),
            $this->Contract_model->delete(array("parent" => $id)), // Alt sözleşmeleri sil
            $this->Favorite_model->delete(array("module" => "contract", "module_id" => $id)),
            $this->Report_model->delete(array("contract_id" => $id)), //
            $this->Report_supply_model->delete(array("contract_id" => $id)),
            $this->Report_workgroup_model->delete(array("contract_id" => $id)),
            $this->Report_workmachine_model->delete(array("contract_id" => $id)),
            $this->Site_model->delete(array("contract_id" => $id)),
        ];
        // Eğer herhangi bir silme işlemi başarısız olursa, transaction'ı geri al
        if (in_array(false, $delete_status, true)) {
            $this->db->trans_rollback();
            redirect(base_url("error"));
        }
        // Transaction'ı tamamla
        $this->db->trans_complete();
        // Eğer işlemde bir hata varsa, hata sayfasına yönlendir
        if ($this->db->trans_status() === FALSE) {
            redirect(base_url("error"));
        }
        // Başarılıysa, proje sayfasına yönlendir
        $this->Contract_model->delete(array("id" => $id));
        redirect(base_url("project/file_form/$project->id"));
    }

    public function file_upload($type, $contract_id, $sub_folder = null)
    {

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));
        $path = "uploads" . DIRECTORY_SEPARATOR . "project_v" . DIRECTORY_SEPARATOR . $project->dosya_no . DIRECTORY_SEPARATOR . $item->dosya_no . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR;
        if ($sub_folder !== null) {
            $path .= $sub_folder . DIRECTORY_SEPARATOR;
        }
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        $FileUploader = new FileUploader("files_$type", array(
            'limit' => null,
            'maxSize' => null,
            'extensions' => null,
            'uploadDir' => $path,
            'title' => 'name'
        ));
        $uploadedFiles = $FileUploader->upload();
        $file = ($uploadedFiles['files']);
        $maxFileSize = 2 * 1024 * 1024; // 2 MB
        if ($uploadedFiles['isSuccess'] || count($uploadedFiles["files"]) > 0) {
            // Yüklenen dosyaları işleyin
            foreach ($uploadedFiles["files"] as $file) {
                // Dosya boyutunu kontrol edin ve yeniden boyutlandırma işlemlerini gerçekleştirin
                if ($file['size'] > $maxFileSize) {
                    // Yeniden boyutlandırma işlemi için uygun genişlik ve yükseklik değerlerini belirleyin
                    $newWidth = null; // Örnek olarak 500 piksel genişlik
                    $newHeight = 1080; // Yüksekliği belirtmediğiniz takdirde orijinal oran korunur
                    // Yeniden boyutlandırma işlemi
                    FileUploader::resize($path . $file['name'], $newWidth, $newHeight, $destination = null, $crop = false, $quality = 75);
                }
            }
        }
        if (!$uploadedFiles['isSuccess']) {
            error_log(print_r($uploadedFiles['warnings'], true));
            echo json_encode(['isSuccess' => false, 'warnings' => $uploadedFiles['warnings']]);
            exit;
        }
        header('Content-Type: application/json');
        echo json_encode($uploadedFiles);
        exit;
    }

    public function filedelete_java($contract_id, $folder_name, $folder_id = null)
    {
        $fileName = $this->input->post('fileName');
        $contract = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $contract->project_id));
        $path = "uploads" . DIRECTORY_SEPARATOR .
            "project_v" . DIRECTORY_SEPARATOR .
            $project->dosya_no . DIRECTORY_SEPARATOR .
            $contract->dosya_no . DIRECTORY_SEPARATOR .
            $folder_name . DIRECTORY_SEPARATOR .
            $folder_id . DIRECTORY_SEPARATOR .
            $fileName;
        echo $path;
        unlink($path);
    }

    public function download_all($cont_id, $where = null)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;
        $project_id = get_from_id("contract", "project_id", $cont_id);
        $project_code = project_code($project_id);
        $cont_code = get_from_id("contract", "dosya_no", $cont_id);
        $cont_name = get_from_id("contract", "contract_name", $cont_id);
        $path = "uploads/project_v/$project_code/$cont_code/$where";
        $where_types =
            array(
                'Genel' => 'Contract',
                'Yer_Teslimi' => 'sitedel',
                'İş Programı' => 'workplan',
                'Geçici Kabul' => 'provision',
                'Kesin Kabul' => 'final',
            );
        $ext = array_search($where, $where_types);
        $files = glob($path . '/*');
        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }
        $zip_name = $cont_name . "_" . $ext;
        $this->zip->download("$zip_name");
    }

    public function download_backup($cont_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 1;
        $contract = $this->Contract_model->get(array("id" => $cont_id));
        $project_code = project_code($contract->project_id);
        $path = FCPATH . "uploads/project_v/$project_code/$contract->dosya_no/";
        $this->zip->read_dir($path, FALSE);
        $zip_name = $contract->contract_name . "_Backup.zip";
        $this->zip->download($zip_name);
    }

    public function sitedel_contractday($sitedal_day, $contract_day)
    {
        $date_diff = date_minus($sitedal_day, $contract_day);

        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function favorite($id)
    {
        $fav_id = get_from_any_and_and("favorite", "module", "contract", "user_id", active_user_id(), "module_id", "$id");
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
                    "module" => "contract",
                    "view" => "file_form",
                    "module_id" => $id,
                    "user_id" => active_user_id(),
                    "title" => contract_code($id) . " - " . contract_name($id)
                )
            );
            echo "favoriye eklendi";
        }
    }


    public function add_main_group($contract_id)
    {


        $group_name = $this->input->post('main_group');
        $group_code = $this->input->post('main_code');
        $this->load->library("form_validation");
        $this->form_validation->set_rules("main_group", "Grup Kodu", "min_length[3]|max_length[30]|required|trim");
        $this->form_validation->set_rules("main_code", "Grup Kodu", "min_length[1]|max_length[3]|required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "max_length" => "<b>{field}</b> en fazla <b>{param}</b> karakter uzunluğunda olmalıdır",
                "min_length" => "<b>{field}</b> en az <b>{param}</b> karakter uzunluğunda olmalıdır",
                "alpha_numeric" => "<b>{field}</b> geçersiz karakter içeriyor üğişçö gibi",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            $insert = $this->Contract_price_model->add(
                array(
                    "contract_id" => $contract_id,
                    "main_group" => 1,
                    "name" => upper_tr($group_name),
                    "code" => $group_code,
                )
            );
            $item = $this->Contract_model->get(array("id" => $contract_id));
            $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));
            $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));
            $viewData = new stdClass();


            $viewData->item = $item;

            $viewData->main_groups = $main_groups;
            $viewData->sub_groups = $sub_groups;
            $viewData->leaders = $leaders;
        } else {
            $item = $this->Contract_model->get(array("id" => $contract_id));
            $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));
            $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));
            $viewData = new stdClass();

            $viewData->leaders = $leaders;


            $viewData->item = $item;
            $viewData->main_groups = $main_groups;
            $viewData->sub_groups = $sub_groups;
            $viewData->form_error = true;
        }
        $render_boq = $this->load->view("contract_module/contract_v/display/tabs/tab_5_d_work_group", $viewData, true);
        echo $render_boq;
    }

    public function back_main($contract_id)
    {

        $item = $this->Contract_model->get(array('id' => $contract_id));
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));
        $viewData = new stdClass();


        $viewData->item = $item;

        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;
        $render_boq = $this->load->view("contract_module/contract_v/display/modules/contract_group", $viewData, true);
        echo $render_boq;
    }

    public function update_sub_group($contract_id)
    {


        $groups = $this->input->post("groups[]");
        $filtered_boqs = array_filter($groups, function ($value) {
            return !empty($value['code']) || !empty($value['name']);
        });
        foreach ($filtered_boqs as $boq_id => $values) {
            if (isset($values['id'])) {
                $update = $this->Contract_price_model->update(
                    array(
                        "id" => $values['id']
                    ),
                    array(
                        "code" => $values['code'],
                        "name" => $values['name'],
                    ));
            }
            if ($boq_id == "new_main") {
                $insert = $this->Contract_price_model->add(
                    array(
                        "contract_id" => $contract_id,
                        "main_group" => 1,
                        "code" => $values['code'],
                        "name" => $values['name'],
                    )
                );
            }
            if (isset($values['new_sub'])) {
                if (!empty($values['new_sub']['code'] || !empty($values['new_sub']['name']))) {
                    $insert = $this->Contract_price_model->add(
                        array(
                            "contract_id" => $contract_id,
                            "parent" => $values['new_sub']['main_id'],
                            "sub_group" => 1,
                            "code" => $values['new_sub']['code'],
                            "name" => $values['new_sub']['name'],
                        )
                    );
                }
            }
        }
        $item = $this->Contract_model->get(array("id" => $contract_id));
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1), "code ASC");
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));
        $viewData = new stdClass();
        $viewData->leaders = $leaders;


        $viewData->item = $item;
        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;
        $viewData->prices_main_groups = $prices_main_groups;

        $response = [
            'subgroup' => $this->load->view("contract_module/contract_v/display/tabs/tab_5_d_work_group", $viewData, true),
            'pricegroup' => $this->load->view("contract_module/contract_v/display/pricegroup/pricegroup_table", $viewData, true),
            'contractprice' => $this->load->view("contract_module/contract_v/display/tabs/tab_5_a_contract_price_table", $viewData, true),
        ];
        echo json_encode($response);
    }

    public function refresh_leader_group($contract_id)
    {


        $item = $this->Contract_model->get(array("id" => $contract_id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1), "code ASC");
        $viewData = new stdClass();


        $viewData->item = $item;
        $viewData->prices_main_groups = $prices_main_groups;

        $render_boq = $this->load->view("contract_module/contract_v/display/tabs/tab_5_b_contract_price_group", $viewData, true);
        echo $render_boq;
    }

    public function refresh_contract_price($contract_id)
    {


        $item = $this->Contract_model->get(array("id" => $contract_id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1), "code ASC");
        $viewData = new stdClass();


        $viewData->item = $item;
        $viewData->prices_main_groups = $prices_main_groups;

        $render_boq = $this->load->view("contract_module/contract_v/display/tabs/tab_5_a_contract_price_table", $viewData, true);
        echo $render_boq;
    }

    public function delete_group($group_id)
    {


        $group = $this->Contract_price_model->get(array("id" => $group_id));
        $delete = $this->Contract_price_model->delete(
            array(
                "id" => $group_id,
            )
        );
        $item = $this->Contract_model->get(array("id" => $group->contract_id));
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $group->contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $group->contract_id, "sub_group" => 1));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $group->contract_id, 'leader' => 1));
        $viewData = new stdClass();
        $viewData->leaders = $leaders;


        $viewData->item = $item;
        $viewData->main_groups = $main_groups;
        $viewData->prices_main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;

        $response = [
            'subgroup' => $this->load->view("contract_module/contract_v/display/tabs/tab_5_d_work_group", $viewData, true),
            'pricegroup' => $this->load->view("contract_module/contract_v/display/pricegroup/pricegroup_table", $viewData, true),
            'contractprice' => $this->load->view("contract_module/contract_v/display/tabs/tab_5_a_contract_price_table", $viewData, true),
        ];
        echo json_encode($response);
    }

    public function add_leader($contract_id)
    {


        $this->load->library("form_validation");
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        // Form Validation Kuralları
        $this->form_validation->set_rules("leader_code", "İmalat Kodu", "required|trim");
        $this->form_validation->set_rules("leader_name", "İmalat Adı", "required|trim");
        $this->form_validation->set_rules("leader_unit", "İmalat Birim", "required|trim");
        $this->form_validation->set_rules("leader_price", "Fiyat", "required|trim");
        // Form Validation Hatalarını Tanımla
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );
        $validate = $this->form_validation->run();
        if ($validate) {
            // Form verilerini doğru şekilde alma
            $leader_code = $this->input->post('leader_code');
            $leader_name = $this->input->post('leader_name');
            $leader_unit = $this->input->post('leader_unit');
            $leader_price = $this->input->post('leader_price');
            // Lider bilgilerini ekleyin
            $update = $this->Contract_price_model->add(
                array(
                    "contract_id" => $contract_id,
                    "code" => $leader_code,
                    "name" => $leader_name,
                    "unit" => $leader_unit,
                    "price" => $leader_price,
                    "leader" => 1,
                )
            );
            $item = $this->Contract_model->get(array("id" => $contract_id));
            $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));
            $viewData = new stdClass();
            $viewData->leaders = $leaders;


            $viewData->item = $item;
            $viewData->main_groups = $main_groups;

            $render_html = $this->load->view("contract_module/contract_v/display/tabs/tab_5_c_price_book", $viewData, true);
            echo $render_html;
        } else {
            $item = $this->Contract_model->get(array("id" => $contract_id));
            $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));
            $viewData = new stdClass();
            $viewData->leaders = $leaders;


            $viewData->item = $item;
            $viewData->main_groups = $main_groups;
            $viewData->form_error = true;

            $render_html = $this->load->view("contract_module/contract_v/display/tabs/tab_5_c_price_book", $viewData, true);
            echo $render_html;
        }
    }

    public function update_leader()
    {

        $leader_id = $this->input->post('leader_id');

        $this->load->library("form_validation");
        $leader = $this->Contract_price_model->get(array("id" => $leader_id));
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $leader->contract_id, "main_group" => 1));
        $validate = $this->form_validation->run();
        // Form verilerini doğru şekilde alma
        $leader_code = $this->input->post('leader_code');
        $leader_name = $this->input->post('leader_name');
        $leader_unit = $this->input->post('leader_unit');
        $leader_price = $this->input->post('leader_price');
        // Lider bilgilerini ekleyin
        $update = $this->Contract_price_model->update(
            array(
                "id" => $leader_id
            ),
            array(
                "code" => $leader_code,
                "name" => $leader_name,
                "unit" => $leader_unit,
                "price" => $leader_price,
            )
        );
        $item = $this->Contract_model->get(array("id" => $leader->contract_id));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $leader->contract_id, 'leader' => 1));
        $viewData = new stdClass();
        $viewData->leaders = $leaders;


        $viewData->item = $item;
        $viewData->main_groups = $main_groups;

        $render_html = $this->load->view("contract_module/contract_v/display/tabs/tab_5_c_price_book", $viewData, true);
        echo $render_html;
    }

    public
    function update_leader_selection($sub_group_id)
    {


        $this->load->model("Boq_model");
        $sub_group = $this->Contract_price_model->get(array("id" => $sub_group_id));
        $main_group = $this->Contract_price_model->get(array("id" => $sub_group->parent));
        $updated_leaders = $this->input->post('leaders') ?? []; // Eğer boş ise boş bir dizi olarak ayarla
        $existing_leaders = $this->Contract_price_model->get_all(
            array("sub_id" => $sub_group_id),
            "leader_id"
        );
        $existing_leader_ids = array_map(function ($existing_leader) {
            return $existing_leader->leader_id;
        }, $existing_leaders);
        $leaders_to_remove = array_diff($existing_leader_ids, $updated_leaders);
        foreach ($leaders_to_remove as $leader_id_to_remove) {
            $boq = $this->Contract_price_model->get(array("leader_id" => $leader_id_to_remove, "sub_id" => $sub_group_id));
            $delete = $this->Contract_price_model->delete(
                array(
                    "id" => $boq->id,
                ));
            $delete_boq = $this->Boq_model->delete(
                array(
                    "boq_id" => $boq->id,
                    "contract_id" => $sub_group->contract_id,
                ));
        }
        // Eklenecek liderler: Yeni listede olup eski listede olmayanlar
        $leaders_to_add = array_diff($updated_leaders, $existing_leader_ids);
        foreach ($leaders_to_add as $leader_id_to_add) {
            $leader = $this->Contract_price_model->get(array("id" => $leader_id_to_add));
            if ($leader) {
                $this->Contract_price_model->add(array(
                    "contract_id" => $sub_group->contract_id,
                    "code" => $main_group->code . "." . $sub_group->code . "." . $leader->code,
                    "sub_id" => $sub_group->id,
                    "main_id" => $main_group->id,
                    "leader_id" => $leader->id,
                    "name" => $leader->name,
                    "unit" => $leader->unit,
                    "price" => $leader->price,
                ));
            }
        }
        $item = $this->Contract_model->get(array("id" => $sub_group->contract_id));
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $sub_group->contract_id, "main_group" => 1), "code ASC");
        $viewData = new stdClass();


        $viewData->item = $item;
        $viewData->prices_main_groups = $prices_main_groups;

        $response = [
            'firstDivHtml' => $this->load->view("contract_module/contract_v/display/pricegroup/pricegroup_table", $viewData, true),
            'secondDivHtml' => $this->load->view("contract_module/contract_v/display/tabs/tab_5_a_contract_price_table", $viewData, true),
        ];
        echo json_encode($response);
    }

    public function delete_contract_price($boq_id)
    {


        $this->load->model("Boq_model");
        $contract_price = $this->Contract_price_model->get(array("id" => $boq_id));
        $contract_id = $contract_price->contract_id;
        $delete = $this->Contract_price_model->delete(array("id" => $boq_id));
        $delete_leader = $this->Contract_price_model->delete(array("leader_id" => $boq_id));
        $delete_boq = $this->Boq_model->delete(array("leader_id" => $boq_id));
        // Yeniden render edilecek HTML'yi oluştur
        $item = $this->Contract_model->get(array("id" => $contract_id));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, 'leader' => 1));
        $viewData = new stdClass();
        $viewData->leaders = $leaders;


        $viewData->item = $item;
        $render_html = $this->load->view("contract_module/contract_v/display/tabs/tab_5_c_price_book", $viewData, true);
        echo $render_html;
    }

    public
    function open_sub($contract_id, $sub_id)
    {


        $sub_cont_items = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "sub_id" => $sub_id));
        $main_group = $this->Contract_price_model->get(array("contract_id" => $contract_id));
        $sub_group = $this->Contract_price_model->get(array("id" => $sub_id));
        $item = $this->Contract_model->get(array('id' => $contract_id));
        $viewData = new stdClass();


        $viewData->item = $item;
        $viewData->sub_cont_items = $sub_cont_items;
        $viewData->main_group = $main_group;
        $viewData->sub_id = $sub_id;
        $viewData->sub_group = $sub_group;
        $render_html = $this->load->view("contract_module/contract_v/display/modules/contract_group", $viewData, true);
        echo $render_html;
    }

    public
    function delete_item($contract_id, $item_id)
    {


        $item = $this->Contract_model->get(array('id' => $contract_id));
        $book_item = $this->Contract_price_model->get(array('id' => $item_id));
        $sub_group = $this->Contract_price_model->get(array('id' => $book_item->sub_id));
        $main_group = $this->Contract_price_model->get(array('id' => $sub_group->parent));
        $delete = $this->Contract_price_model->delete(
            array(
                "id" => $item_id,
            )
        );
        $sub_cont_items = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_id" => $sub_group->id));
        $viewData = new stdClass();


        $viewData->item = $item;
        $viewData->main_group = $main_group;
        $viewData->sub_group = $sub_group;
        $viewData->sub_cont_items = $sub_cont_items;
        $viewData->sub_id = $sub_group->id;
        $render_html = $this->load->view("contract_module/contract_v/display/modules/contract_group", $viewData, true);
        echo $render_html;
    }

    public
    function delete_sub($contract_id, $sub_id)
    {


        $item = $this->Contract_model->get(array("id" => $contract_id));
        $delete_sub = $this->Contract_price_model->delete(
            array(
                "contract_id" => $contract_id,
                "sub_id" => $sub_id,
            )
        );
        $delete_sub = $this->Contract_price_model->delete(
            array(
                "id" => $sub_id,
            )
        );
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));
        $viewData = new stdClass();


        $viewData->item = $item;
        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;
        $render_html = $this->load->view("contract_module/contract_v/display/modules/contract_group", $viewData, true);
        echo $render_html;
    }

    public
    function delete_main($contract_id, $main_id)
    {


        $item = $this->Contract_model->get(array("id" => $contract_id));
        $delete_item = $this->Contract_price_model->delete(
            array(
                "contract_id" => $contract_id,
                "main_id" => $main_id,
            )
        );
        $delete_sub = $this->Contract_price_model->delete(
            array(
                "contract_id" => $contract_id,
                "parent" => $main_id,
            )
        );
        $delete_main = $this->Contract_price_model->delete(
            array(
                "id" => $main_id,
            )
        );
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));
        $viewData = new stdClass();


        $viewData->item = $item;
        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;
        $render_html = $this->load->view("contract_module/contract_v/display/modules/contract_group", $viewData, true);
        echo $render_html;
    }

    public function upload_book_excel($contract_id)
    {

        $tempFolderPath = 'uploads/temp/';
        // Temp klasör yoksa oluştur
        if (!is_dir($tempFolderPath)) {
            if (!mkdir($tempFolderPath, 0777, true)) {
                die('Temp klasör oluşturulamadı...');
            }
        }
        // Dosya yükleme
        if (!empty($_FILES['excel_file']['name'])) {
            $tempFilePath = $_FILES['excel_file']['tmp_name'];
            $targetFilePath = $tempFolderPath . $_FILES['excel_file']['name'];
            // Dosyayı yükle
            if (move_uploaded_file($tempFilePath, $targetFilePath)) {
                $workbook = IOFactory::load($targetFilePath);
                $worksheet = $workbook->getActiveSheet();
                $dataArray = array();
                $startRow = 5;
                $endRow = 1500; // 3000 satır daha eklendiğini varsayıyorum
                // Boş satır sayacını tanımlayın
                $emptyRowCount = 0;
                // Her bir satır için döngü oluşturun
                for ($row = $startRow; $row <= $endRow; $row++) {
                    // Her bir satırdaki C'den F'ye kadar olan hücrelerden veriyi alarak bir dizi oluşturun
                    $rowData = array(
                        'code' => $worksheet->getCell('C' . $row)->getValue(),
                        'name' => $worksheet->getCell('D' . $row)->getValue(),
                        'unit' => $worksheet->getCell('E' . $row)->getValue(),
                        'price' => $worksheet->getCell('F' . $row)->getValue(),
                    );
                    // Satırın boş olup olmadığını kontrol edin
                    $isEmptyRow = true;
                    foreach ($rowData as $cellValue) {
                        if (!empty($cellValue)) {
                            $isEmptyRow = false;
                            break;
                        }
                    }
                    // Eğer satır boşsa boş satır sayacını artır, aksi takdirde sıfırla
                    if ($isEmptyRow) {
                        $emptyRowCount++;
                    } else {
                        $emptyRowCount = 0;
                    }
                    // Boş satır sayacı 5 ise döngüyü durdur
                    if ($emptyRowCount >= 5) {
                        break;
                    }
                    // Eğer herhangi bir veri boşsa bu satırı atla
                    if (empty($rowData['code']) || empty($rowData['name']) || empty($rowData['unit']) || empty($rowData['price'])) {
                        continue;
                    }
                    // Oluşturulan dizi, ana diziye eklenir
                    $dataArray[] = $rowData;
                }
                // Verileri veritabanına ekleme
                foreach ($dataArray as $data) {
                    $exist_leader = $this->Contract_price_model->get(array(
                            "contract_id" => $contract_id,
                            "name" => $data['name'],
                            "unit" => $data['unit']
                        )
                    );
                    if (!$exist_leader) {
                        $insert = $this->Contract_price_model->add(
                            array(
                                "contract_id" => $contract_id,
                                "code" => $data['code'],
                                "name" => $data['name'],
                                "unit" => $data['unit'],
                                "price" => $data['price'],
                                "leader" => 1, // 'leader' değeri her zaman 1 olarak ayarlanmış
                            )
                        );
                        if ($insert) {
                            $updateCount++;
                        }
                    }
                }
                redirect(base_url("contract/file_form/$contract_id/Price")); // Başarılı işlem sonrası yönlendirme
            } else {
                die('Dosya yüklenemedi...');
            }
        } else {
            die('Dosya bulunamadı...');
        }
    }

    public function update_boqs()
    {
        // JSON verilerini al
        $data = file_get_contents('php://input');
        // JSON verilerini diziye dönüştür
        $data_array = json_decode($data, true);
        // Verileri kontrol etmek için
        if ($data_array) {
            // Her bir öğeyi güncelle
            foreach ($data_array as $values) {
                // Veritabanında güncelleme yapmak için model metodunu kullanın
                $update = $this->Contract_price_model->update(
                    array("id" => $values['id']), // Güncellenecek satırın ID'si
                    array("qty" => $values['qty']) // Güncellenecek veriler
                );
                // Güncellemenin başarılı olup olmadığını kontrol et (Opsiyonel)
                if ($update) {
                    log_message('info', 'Güncelleme başarılı: ID ' . $values['id']);
                } else {
                    log_message('error', 'Güncelleme başarısız: ID ' . $values['id']);
                }
            }
            // JSON yanıt
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gelen veri boş veya geçersiz formatta.'));
        }
    }

    public
    function create_payment($contract_id)
    {

        $contract = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $contract->project_id));
        $last_payment = $this->Payment_model->last_payment(array("contract_id" => $contract_id));
        $start_date = ($contract->sitedel_date != null)
            ? dateFormat('d-m-Y', $contract->sitedel_date)
            : dateFormat('d-m-Y', $contract->sozlesme_tarih);
        $hak_no = $this->input->post('hakedis_no');
        $this->load->library("form_validation");
        $this->form_validation->set_rules("hakedis_no", "Hakediş No", "required|numeric|trim"); //2
        if ($hak_no == 1) {
            $this->form_validation->set_rules("imalat_tarihi", "İmalat Tarihi", "trim|callback_date_greater_than[$start_date]");
        } else {
            $last_payment_day = dateFormat('d-m-Y', $last_payment->imalat_tarihi);
            $this->form_validation->set_rules("imalat_tarihi", "İmalat Tarihi", "trim|callback_date_greater_than[$last_payment_day]");
        }
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "numeric" => "<b>{field}</b> rakamlardan oluşmalıdır",
                "limit_advance" => "<b>{field}</b> en fazla kadar olmalıdır.",
                "date_greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            $path = "uploads/project_v/$project->dosya_no/$contract->dosya_no/Payment/$hak_no";
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }
            if ($this->input->post('hakedis_no') == "on") {
                $final = 1;
            } else {
                $final = 0;
            }
            $imalat_tarihi = dateFormat('Y-m-d', $this->input->post("imalat_tarihi"));
            $insert = $this->Payment_model->add(
                array(
                    "contract_id" => $contract_id,
                    "hakedis_no" => $this->input->post('hakedis_no'),
                    "imalat_tarihi" => $imalat_tarihi,
                )
            );
            $viewData = new stdClass();
            $payments = $this->Payment_model->get_all(array('contract_id' => $contract_id));
            $item = $this->Contract_model->get(array('id' => $contract_id));
            // View'e gönderilecek Değişkenlerin Set Edilmesi


            $viewData->payments = $payments;
            $viewData->item = $item;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("contract_module/contract_v/display/payment/payment_table", $viewData, true)
            );
            echo json_encode($response);
        } else {
            $payments = $this->Payment_model->get_all(array('contract_id' => $contract_id));
            $item = $this->Contract_model->get(array('id' => $contract_id));
            $viewData = new stdClass();


            $viewData->payments = $payments;
            $viewData->item = $item;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("contract_module/contract_v/display/payment/add_payment_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public
    function create_collection($contract_id)
    {

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));

        $this->load->library("form_validation");
        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);
        $this->form_validation->set_rules("tahsilat_tarih", "Tahsilat Tarihi", "callback_contract_collection[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("tahsilat_turu", "Tahsilat Türü", "required|trim");
        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_collection[$sozlesme_tarih]|trim");
        }
        if ($this->input->post('tahsilat_turu') == "Çek" || $this->input->post('tahsilat_turu') == "Senet") {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_collection[$sozlesme_tarih]|trim|required");
        }
        $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|numeric|required|trim");
        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|less_than_equal_to[$contract_price]|numeric|trim");
        } else {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_collection" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Collection";
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }
            if ($this->input->post("tahsilat_tarih")) {
                $tahsilat_tarihi = dateFormat('Y-m-d', $this->input->post("tahsilat_tarih"));
            } else {
                $tahsilat_tarihi = null;
            }
            if ($this->input->post("vade_tarih")) {
                $vade_tarihi = dateFormat('Y-m-d', $this->input->post("vade_tarih"));
            } else {
                $vade_tarihi = null;
            }
            $insert = $this->Collection_model->add(
                array(
                    "contract_id" => $contract_id,
                    "tahsilat_tarih" => $tahsilat_tarihi,
                    "vade_tarih" => $vade_tarihi,
                    "tahsilat_miktar" => $this->input->post("tahsilat_miktar"),
                    "tahsilat_turu" => $this->input->post("tahsilat_turu"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );
            $record_id = $this->db->insert_id();
            // Yükleme yapılacak dosya yolu oluşturuluyor
            if ($_FILES["file"]["error"] === UPLOAD_ERR_OK) {
                // Yükleme yapılacak dosya yolu oluşturuluyor
                $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Bond/$record_id";
                // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
                if (!is_dir($path)) {
                    mkdir("$path", 0777, TRUE);
                }
                $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                // Yükleme ayarları belirleniyor
                $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
                $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
                $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
                $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)
                // Yükleme kütüphanesi yükleniyor
                $this->load->library("upload", $config);
                // Dosya yükleme işlemi
                if (!$this->upload->do_upload("file")) {
                    // Yükleme başarısız olduysa hata mesajı döndürülüyor
                    $error = $this->upload->display_errors();
                } else {
                    // Yükleme başarılıysa devam eden işlemler
                    $data = $this->upload->data();
                }
            } else {
                // Dosya gönderilmemişse hata mesajı veya işlem yapılabilir
                $error = "Dosya gönderilmedi!";
            }
            $collections = $this->Collection_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");

            

            $viewData = new stdClass();

            
            $viewData->project = $project;
            $viewData->collections = $collections;
            $viewData->item = $item;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("contract_module/contract_v/display/collection/collection_table", $viewData, true)
            );
            echo json_encode($response);
        } else {
            

            $collections = $this->Collection_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");
            $viewData = new stdClass();
            
            $viewData->project = $project;
            $viewData->collections = $collections;
            $viewData->item = $item;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("contract_module/contract_v/display/collection/add_collection_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public
    function create_advance($contract_id)
    {


        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));

        $this->load->library("form_validation");
        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);
        $this->form_validation->set_rules("avans_tarih", "Avans Tarihi", "callback_contract_advance[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("avans_turu", "Avans Türü", "required|trim");
        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_advance[$sozlesme_tarih]|trim");
        }
        if ($this->input->post('avans_turu') == "Çek" || $this->input->post('avans_turu') == "Senet") {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_advance[$sozlesme_tarih]|trim|required");
        }
        $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|numeric|required|trim");
        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|less_than_equal_to[$contract_price]|numeric|trim");
        } else {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_advance" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Advance";
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }
            if ($this->input->post("avans_tarih")) {
                $avans_tarih = dateFormat('Y-m-d', $this->input->post("avans_tarih"));
            } else {
                $avans_tarih = null;
            }
            if ($this->input->post("vade_tarih")) {
                $vade_tarihi = dateFormat('Y-m-d', $this->input->post("vade_tarih"));
            } else {
                $vade_tarihi = null;
            }
            $insert = $this->Advance_model->add(
                array(
                    "contract_id" => $contract_id,
                    "avans_tarih" => $avans_tarih,
                    "vade_tarih" => $vade_tarihi,
                    "avans_miktar" => $this->input->post("avans_miktar"),
                    "avans_turu" => $this->input->post("avans_turu"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );
            $record_id = $this->db->insert_id();
            if ($_FILES["file"]["error"] === UPLOAD_ERR_OK) {
                // Yükleme yapılacak dosya yolu oluşturuluyor
                $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Bond/$record_id";
                // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
                if (!is_dir($path)) {
                    mkdir("$path", 0777, TRUE);
                }
                $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                // Yükleme ayarları belirleniyor
                $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
                $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
                $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
                $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)
                // Yükleme kütüphanesi yükleniyor
                $this->load->library("upload", $config);
                // Dosya yükleme işlemi
                if (!$this->upload->do_upload("file")) {
                    // Yükleme başarısız olduysa hata mesajı döndürülüyor
                    $error = $this->upload->display_errors();
                } else {
                    // Yükleme başarılıysa devam eden işlemler
                    $data = $this->upload->data();
                }
            } else {
                // Dosya gönderilmemişse hata mesajı veya işlem yapılabilir
                $error = "Dosya gönderilmedi!";
            }
            $advances = $this->Advance_model->get_all(array('contract_id' => $item->id), "avans_tarih ASC");
            $viewData = new stdClass();


            $viewData->project = $project;
            $viewData->advances = $advances;

            $viewData->item = $item;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("contract_module/contract_v/display/advance/advance_table", $viewData, true)
            );
            echo json_encode($response);
            //kaydedilen elemanın id nosunu döküman ekleme
            // sına post ediyoruz
        } else {
            $advances = $this->Advance_model->get_all(array('contract_id' => $item->id), "avans_tarih ASC");
            $viewData = new stdClass();


            $viewData->project = $project;
            $viewData->advances = $advances;

            $viewData->item = $item;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("contract_module/contract_v/display/advance/add_advance_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public
    function create_bond($contract_id)
    {


        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));

        $this->load->library("form_validation");
        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);
        $this->form_validation->set_rules("teslim_tarih", "Teminat Tarihi", "callback_contract_bond[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("teminat_turu", "Teminat Türü", "required|trim");
        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("teslim_tarih", "Vade Tarihi", "callback_contract_bond[$sozlesme_tarih]|trim");
        }
        if ($this->input->post('teminat_turu') != "Nakit") {
            $this->form_validation->set_rules("gecerlilik_tarih", "Vade Tarihi", "callback_contract_bond[$sozlesme_tarih]|trim|required");
        }
        if ($this->input->post('teminat_turu') == "Çek") {
            $this->form_validation->set_rules("teminat_banka", "Banka Adı", "trim|required");
        }
        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "required|numeric|required|trim");
        $this->form_validation->set_rules("teminat_gerekce", "Gerekçe", "required|trim");
        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "required|numeric|trim");
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_bond" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );
// Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            if ($this->input->post("teslim_tarih")) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarih"));
            } else {
                $teslim_tarihi = null;
            }
            if ($this->input->post("gecerlilik_tarih")) {
                $gecerlilik_tarihi = dateFormat('Y-m-d', $this->input->post("gecerlilik_tarih"));
            } else {
                $gecerlilik_tarihi = null;
            }
            $insert = $this->Bond_model->add(
                array(
                    "contract_id" => $contract_id,
                    "teminat_gerekce" => $this->input->post("teminat_gerekce"),
                    "teminat_turu" => $this->input->post("teminat_turu"),
                    "teminat_miktar" => $this->input->post("teminat_miktar"),
                    "teminat_banka" => $this->input->post("teminat_banka"),
                    "teslim_tarih" => $teslim_tarihi,
                    "gecerlilik_tarih" => $gecerlilik_tarihi,
                    "aciklama" => $this->input->post("aciklama"),
                )
            );
            $record_id = $this->db->insert_id();
            if ($_FILES["file"]["error"] === UPLOAD_ERR_OK) {
                // Yükleme yapılacak dosya yolu oluşturuluyor
                $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Bond/$record_id";
                // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
                if (!is_dir($path)) {
                    mkdir("$path", 0777, TRUE);
                }
                $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                // Yükleme ayarları belirleniyor
                $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
                $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
                $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
                $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)
                // Yükleme kütüphanesi yükleniyor
                $this->load->library("upload", $config);
                // Dosya yükleme işlemi
                if (!$this->upload->do_upload("file")) {
                    // Yükleme başarısız olduysa hata mesajı döndürülüyor
                    $error = $this->upload->display_errors();
                } else {
                    // Yükleme başarılıysa devam eden işlemler
                    $data = $this->upload->data();
                }
            } else {
                // Dosya gönderilmemişse hata mesajı veya işlem yapılabilir
                $error = "Dosya gönderilmedi!";
            }
            $bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "teslim_tarih ASC");
            $viewData = new stdClass();


            $viewData->project = $project;
            $viewData->bonds = $bonds;

            $viewData->item = $item;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("contract_module/contract_v/display/bond/bond_table", $viewData, true)
            );
            echo json_encode($response);
//kaydedilen elemanın id nosunu döküman ekleme
// sına post ediyoruz
        } else {
            $bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "teslim_tarih ASC");
            $viewData = new stdClass();


            $viewData->project = $project;
            $viewData->bonds = $bonds;

            $viewData->item = $item;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("contract_module/contract_v/display/bond/add_bond_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public function create_folder($contract_id)
    {


        // Gelen ID'ye göre veriyi al
        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));
        // Eğer $item bulunamazsa işlem durdurulur
        if (!$item) {
            echo "Geçersiz Contract ID!";
            return;
        }
        // Formdan gelen klasör adı
        $folderName = convertToSEO($this->input->post('new_folder_name'));
        $new_folder = "{uploads/project_v}/{$project->dosya_no}/{$item->dosya_no}/$folderName";
        $this->load->library("form_validation");
        $this->form_validation->set_rules('new_folder_name', 'Klasör Adı', "required|callback_unique_folder_name[$new_folder]");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );
        $validate = $this->form_validation->run();
        if ($validate) {
            if (!is_dir($new_folder)) {
                mkdir($new_folder, 0777, TRUE);
            }
            $main_path = "uploads/project_v/$project->dosya_no/$item->dosya_no/";
            $filter_main = scandir($main_path);
            $main_folders = array_filter($filter_main, function ($item) use ($main_path) {
                // . ve ..'i hariç tutuyoruz ve sadece dizinleri alıyoruz
                return $item !== '.' && $item !== '..' && is_dir($main_path . DIRECTORY_SEPARATOR . $item);
            });
            $viewData = new stdClass();

            $viewData->item = $item;
            $viewData->main_folders = $main_folders;
            $viewData->main_path = $main_path;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("contract_module/contract_v/display/folder/sub_folder", $viewData, true)
            );
            echo json_encode($response);
        } else {
            $main_path = "uploads/project_v/$project->dosya_no/$item->dosya_no/";
            $filter_main = scandir($main_path);
            $main_folders = array_filter($filter_main, function ($item) use ($main_path) {
                // . ve ..'i hariç tutuyoruz ve sadece dizinleri alıyoruz
                return $item !== '.' && $item !== '..' && is_dir($main_path . DIRECTORY_SEPARATOR . $item);
            });
            $viewData = new stdClass();

            $viewData->main_folders = $main_folders;
            $viewData->main_path = $main_path;
            $viewData->item = $item;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("contract_module/contract_v/display/folder/add_folder_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public function open_edit_contract_modal($contract_id)
    {

        $edit_item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $edit_item->project_id));
        $companys = $this->Company_model->get_all(array(), "company_name ASC");

        $viewData = new stdClass();


        $viewData->edit_item = $edit_item;
        $viewData->companys = $companys;
        $viewData->project = $project;
        $this->load->view("contract_module/contract_v/display/contract/edit_contract_modal_form", $viewData);
    }

    public function open_add_sub_contract_modal($contract_id)
    {
        // Verilerin getirilmesi
        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));
        $companys = $this->Company_model->get_all(array(), "company_name ASC");
        $next_contract_name = get_next_file_code("Contract");

        $viewData = new stdClass();


        $viewData->next_contract_name = $next_contract_name;
        $viewData->item = $item;
        $viewData->companys = $companys;
        $viewData->project = $project;
        $this->load->view("contract_module/contract_v/display/sub_contract/add_sub_contract_modal_form", $viewData);
    }

    public function open_edit_collection_modal($collection_id)
    {
        // Verilerin getirilmesi
        $edit_collection = $this->Collection_model->get(array("id" => $collection_id));
        $item = $this->Contract_model->get(array("id" => $edit_collection->contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));

        $viewData = new stdClass();


        $viewData->item = $item;
        $viewData->project = $project;
        $viewData->edit_collection = $edit_collection;
        $this->load->view("contract_module/contract_v/display/collection/edit_collection_modal_form", $viewData);
    }

    public function open_edit_advance_modal($advance)
    {
        // Verilerin getirilmesi
        $edit_advance = $this->Advance_model->get(array("id" => $advance));
        $item = $this->Contract_model->get(array("id" => $edit_advance->contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));


        $viewData = new stdClass();

        $viewData->item = $item;
        $viewData->project = $project;
        $viewData->edit_advance = $edit_advance;
        $this->load->view("contract_module/contract_v/display/advance/edit_advance_modal_form", $viewData);
    }

    public function open_edit_bond_modal($bond)
    {
        // Verilerin getirilmesi
        $edit_bond = $this->Bond_model->get(array("id" => $bond));
        $item = $this->Contract_model->get(array("id" => $edit_bond->contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));

        $viewData = new stdClass();


        $viewData->item = $item;
        $viewData->project = $project;
        $viewData->edit_bond = $edit_bond;
        $this->load->view("contract_module/contract_v/display/bond/edit_bond_modal_form", $viewData);
    }

    public function open_edit_pricegroup_modal($pricegroup)
    {
        // Verilerin getirilmesi
        $edit_pricegroup = $this->Contract_price_model->get(array("id" => $pricegroup));
        $main_group = $this->Contract_price_model->get(array("id" => $edit_pricegroup->parent));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $edit_pricegroup->contract_id, 'leader' => 1));
        $item = $this->Contract_model->get(array("id" => $edit_pricegroup->contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));

        $viewData = new stdClass();


        $viewData->main_group = $main_group;
        $viewData->leaders = $leaders;

        $viewData->item = $item;
        $viewData->project = $project;
        $viewData->edit_pricegroup = $edit_pricegroup;
        $this->load->view("contract_module/contract_v/display/pricegroup/edit_pricegroup_modal_form", $viewData);
    }

    public function open_edit_payment_modal($payment)
    {
        // Verilerin getirilmesi
        $edit_payment = $this->Payment_model->get(array("id" => $payment));
        $item = $this->Contract_model->get(array("id" => $edit_payment->contract_id));
        $viewData = new stdClass();


        $viewData->item = $item;
        $viewData->edit_payment = $edit_payment;
        $this->load->view("contract_module/contract_v/display/payment/edit_payment_modal_form", $viewData);
    }

    function edit_collection($collection_id)
    {


        $edit_collection = $this->Collection_model->get(array("id" => $collection_id));
        $item = $this->Contract_model->get(array("id" => $edit_collection->contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));

        $this->load->library("form_validation");
        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);
        $this->form_validation->set_rules("tahsilat_tarih", "Tahsilat Tarihi", "callback_contract_collection[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("tahsilat_turu", "Tahsilat Türü", "required|trim");
        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_collection[$sozlesme_tarih]|trim");
        }
        if ($this->input->post('tahsilat_turu') == "Çek") {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_collection[$sozlesme_tarih]|trim|required");
        }
        $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|numeric|required|trim");
        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|less_than_equal_to[$contract_price]|numeric|trim");
        } else {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_collection" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Collection";
            if ($this->input->post("tahsilat_tarih")) {
                $tahsilat_tarihi = dateFormat('Y-m-d', $this->input->post("tahsilat_tarih"));
            } else {
                $tahsilat_tarihi = null;
            }
            if ($this->input->post("vade_tarih")) {
                $vade_tarihi = dateFormat('Y-m-d', $this->input->post("vade_tarih"));
            } else {
                $vade_tarihi = null;
            }
            $update = $this->Collection_model->update(
                array(
                    "id" => $collection_id
                ),
                array(
                    "tahsilat_tarih" => $tahsilat_tarihi,
                    "vade_tarih" => $vade_tarihi,
                    "tahsilat_miktar" => $this->input->post("tahsilat_miktar"),
                    "tahsilat_turu" => $this->input->post("tahsilat_turu"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );
            // Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Collection/$collection_id";
            // Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }
            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            // Yükleme ayarları belirleniyor
            $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
            $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
            $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
            $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)
            // Yükleme kütüphanesi yükleniyor
            $this->load->library("upload", $config);
            // Dosya yükleme işlemi
            if (!$this->upload->do_upload("file")) {
                // Yükleme başarısız olduysa hata mesajı döndürülüyor
                $error = $this->upload->display_errors();
            } else {
                // Yükleme başarılıysa devam eden işlemler
                $data = $this->upload->data();
            }
            $collections = $this->Collection_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");
            $viewData = new stdClass();


            $viewData->project = $project;
            $viewData->item = $item;
            $viewData->collections = $collections;

            $response = array(
                'status' => 'success',
                'html' => $this->load->view("contract_module/contract_v/display/collection/collection_table", $viewData, true)
            );
            echo json_encode($response);
        } else {
            $edit_collection = $this->Collection_model->get(array("id" => $collection_id));
            $item = $this->Contract_model->get(array("id" => $edit_collection->contract_id));
            $project = $this->Project_model->get(array("id" => $item->project_id));

            $collections = $this->Collection_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");
            $viewData = new stdClass();


            $viewData->edit_collection = $edit_collection;
            $viewData->project = $project;
            $viewData->collections = $collections;

            $viewData->item = $item;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("contract_module/contract_v/display/collection/edit_collection_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    function edit_payment($payment_id)
    {
        $edit_payment = $this->Payment_model->get(array("id" => $payment_id));
        $item = $this->Contract_model->get(array("id" => $edit_payment->contract_id));
        $before_payment = $this->Payment_model->get(array("contract_id" => $edit_payment->contract_id, "hakedis_no" => ($edit_payment->hakedis_no - 1)));
        $this->load->library("form_validation");
        $start_date = ($item->sitedel_date != null)
            ? dateFormat('d-m-Y', $item->sitedel_date)
            : dateFormat('d-m-Y', $item->sozlesme_tarih);
        $hak_no = $this->input->post('hakedis_no');
        $this->load->library("form_validation");
        $this->form_validation->set_rules("hakedis_no", "Hakediş No", "required|numeric|trim"); //2
        if ($hak_no == 1) {
            $this->form_validation->set_rules("imalat_tarihi", "İmalat Tarihi", "trim|callback_date_greater_than[$start_date]");
        } else {
            $last_payment_day = dateFormat('d-m-Y', $before_payment->imalat_tarihi);
            $this->form_validation->set_rules("imalat_tarihi", "İmalat Tarihi", "trim|callback_date_greater_than[$last_payment_day]");
        }
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "numeric" => "<b>{field}</b> rakamlardan oluşmalıdır",
                "limit_advance" => "<b>{field}</b> en fazla kadar olmalıdır.",
                "date_greater_than" => "<b>{field}</b> alanı <b>$before_payment->hakedis_no nolu hakediş tarihi olan</b> <b>{param}</b> dan ileri bir tarih olmalıdır",
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            $imalat_tarihi = dateFormat('Y-m-d', $this->input->post("imalat_tarihi"));
            $update = $this->Payment_model->update(
                array(
                    "id" => $payment_id
                ),
                array(
                    "imalat_tarihi" => $imalat_tarihi
                )
            );
            $payments = $this->Payment_model->get_all(array('contract_id' => $item->id), "imalat_tarihi ASC");
            $viewData = new stdClass();


            $viewData->item = $item;
            $viewData->payments = $payments;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("contract_module/contract_v/display/payment/payment_table", $viewData, true)
            );
            echo json_encode($response);
        } else {
            $edit_payment = $this->Payment_model->get(array("id" => $payment_id));
            $item = $this->Contract_model->get(array("id" => $edit_payment->contract_id));
            $viewData = new stdClass();


            $viewData->edit_payment = $edit_payment;
            $viewData->item = $item;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("contract_module/contract_v/display/payment/edit_payment_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public function delete_collection($collection_id)
    {


        $delete_collection = $this->Collection_model->get(array("id" => $collection_id));
        $item = $this->Contract_model->get(array("id" => $delete_collection->contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));
        $delete = $this->Collection_model->delete(array("id" => $collection_id));
        $this->load->helper('file'); // File helper'ını yükle
        $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Collection/$collection_id";
        delete_files($path, true); // İkinci parametre (true), klasörün kendisini de siler
        if (is_dir($path)) {
            rmdir($path);
        }

        $collections = $this->Collection_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");
        $viewData = new stdClass();


        $viewData->project = $project;
        $viewData->collections = $collections;

        $viewData->item = $item;
        $formErrorHtml = $this->load->view("contract_module/contract_v/display/collection/collection_table", $viewData, true);
        echo json_encode([
            'html' => $formErrorHtml, // Form hatalarını içeren HTML
        ]);
    }

    public function delete_advance($advance_id)
    {


        $this->load->model("Advance_model");
        $delete_advance = $this->Advance_model->get(array("id" => $advance_id));
        $item = $this->Contract_model->get(array("id" => $delete_advance->contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));
        $delete = $this->Advance_model->delete(array("id" => $advance_id));
        $this->load->helper('file'); // File helper'ını yükle
        $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Advance/$advance_id";
        delete_files($path, true); // İkinci parametre (true), klasörün kendisini de siler
        if (is_dir($path)) {
            rmdir($path);
        }

        $advances = $this->Advance_model->get_all(array('contract_id' => $item->id), "avans_tarih ASC");
        $viewData = new stdClass();


        $viewData->project = $project;
        $viewData->advances = $advances;

        $viewData->item = $item;
        $html = $this->load->view("contract_module/contract_v/display/advance/advance_table", $viewData, true);
        echo json_encode([
            'html' => $html, // Form hatalarını içeren HTML
        ]);
    }

    public function delete_folder($contract_id, $module, $folder_name = null)
    {

        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));
        $this->load->helper('file'); // File helper'ını yükle
        $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/$module/$folder_name";
        delete_files($path, true); // İkinci parametre (true), klasörün kendisini de siler
        if (is_dir($path)) {
            rmdir($path);
        }
        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));
        $main_path = "uploads/project_v/$project->dosya_no/$item->dosya_no/";
        $filter_main = scandir($main_path);
        $main_folders = array_filter($filter_main, function ($item) use ($main_path) {
            // . ve ..'i hariç tutuyoruz ve sadece dizinleri alıyoruz
            return $item !== '.' && $item !== '..' && is_dir($main_path . DIRECTORY_SEPARATOR . $item);
        });
        $viewData = new stdClass();

        $viewData->item = $item;
        $viewData->main_folders = $main_folders;
        $viewData->main_path = $main_path;
        $html = $this->load->view("contract_module/contract_v/display/folder/sub_folder", $viewData, true);
        echo json_encode([
            'html' => "$html", // Form hatalarını içeren HTML
        ]);
    }

    public function delete_bond($bond_id)
    {


        $this->load->model("Advance_model");
        $delete_bond = $this->Bond_model->get(array("id" => $bond_id));
        $item = $this->Contract_model->get(array("id" => $delete_bond->contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));
        $delete = $this->Advance_model->delete(array("id" => $bond_id));
        $this->load->helper('file'); // File helper'ını yükle
        $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Bond/$bond_id";
        delete_files($path, true); // İkinci parametre (true), klasörün kendisini de siler
        if (is_dir($path)) {
            rmdir($path);
        }

        $bonds = $this->Advance_model->get_all(array('contract_id' => $item->id), "teslim_tarih ASC");
        $viewData = new stdClass();


        $viewData->project = $project;
        $viewData->bonds = $bonds;

        $viewData->item = $item;
        $html = $this->load->view("contract_module/contract_v/display/bond/bond_table", $viewData, true);
        echo json_encode([
            'html' => $html, // Form hatalarını içeren HTML
        ]);
    }

    function edit_contract($contract_id)
    {
        $this->load->library("form_validation");
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
            $sozlesme_tarih = $this->input->post("sozlesme_tarih") ? dateFormat('Y-m-d', $this->input->post("sozlesme_tarih")) : null;
            $sozlesme_bitis = dateFormat('Y-m-d', date_plus_days($this->input->post("sozlesme_tarih"), $this->input->post("isin_suresi") - 1));
            $contract_name = mb_convert_case($this->input->post("contract_name"), MB_CASE_TITLE, "UTF-8");
            // Veritabanına Ekleme İşlemi
            $update = $this->Contract_model->update(
                array("id" => $contract_id),
                array(
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
                )
            );
            $item = $this->Contract_model->get(array("id" => $contract_id));
            $companys = $this->Company_model->get_all(array(), "company_name ASC");
            if ($item->parent > 0) {
                $main_contract = $this->Contract_model->get(array("id" => $item->parent));
            } else {
                $sub_contracts = $this->Contract_model->get_all(array('parent' => $item->id));
            }
            

            $viewData = new stdClass();
            $viewData->edit_item = $item;
            


            $viewData->companys = $companys;
            $viewData->item = $item;
            if ($item->parent > 0) {
                $viewData->main_contract = $main_contract;
            } else {
                $viewData->sub_contracts = $sub_contracts;
            }
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("contract_module/contract_v/display/contract/contract_table", $viewData, true)
            );
            echo json_encode($response);
        } else {
            
            $item = $this->Contract_model->get(array("id" => $contract_id));
            $companys = $this->Company_model->get_all(array(), "company_name ASC");
            if ($item->parent > 0) {
                $main_contract = $this->Contract_model->get(array("id" => $item->parent));
            } else {
                $sub_contracts = $this->Contract_model->get_all(array('parent' => $item->id));
            }


            $viewData = new stdClass();
            
            $viewData->companys = $companys;
            $viewData->item = $item;
            $viewData->edit_item = $item;
            $viewData->item = $item;
            if ($item->parent > 0) {
                $viewData->main_contract = $main_contract;
            } else {
                $viewData->sub_contracts = $sub_contracts;
            }
            $viewData->form_error = true;
            // Form hatalarını içeren HTML oluştur
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("contract_module/contract_v/display/contract/edit_contract_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    function edit_bond($bond_id)
    {


        $edit_bond = $this->Bond_model->get(array("id" => $bond_id));
        $item = $this->Contract_model->get(array("id" => $edit_bond->contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));

        $bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "teslim_tarih ASC");
        $viewData = new stdClass();


        $viewData->project = $project;
        $viewData->bonds = $bonds;

        $viewData->item = $item;
        $this->load->library("form_validation");
        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);
        $this->form_validation->set_rules("teslim_tarih", "Teminat Tarihi", "callback_contract_bond[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("teminat_turu", "Teminat Türü", "required|trim");
        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("teslim_tarih", "Vade Tarihi", "callback_contract_bond[$sozlesme_tarih]|trim");
        }
        if ($this->input->post('teminat_turu') != "Nakit") {
            $this->form_validation->set_rules("gecerlilik_tarih", "Vade Tarihi", "callback_contract_bond[$sozlesme_tarih]|trim|required");
        }
        if ($this->input->post('teminat_turu') == "Çek") {
            $this->form_validation->set_rules("teminat_banka", "Banka Adı", "trim|required");
        }
        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "required|numeric|required|trim");
        $this->form_validation->set_rules("teminat_gerekce", "Gerekçe", "required|trim");
        $this->form_validation->set_rules("teminat_miktar", "Teminat Miktarı", "required|numeric|trim");
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_bond" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );
// Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Bond";
            if ($this->input->post("teslim_tarih")) {
                $teslim_tarihi = dateFormat('Y-m-d', $this->input->post("teslim_tarih"));
            } else {
                $teslim_tarihi = null;
            }
            if ($this->input->post("gecerlilik_tarih")) {
                $gecerlilik_tarihi = dateFormat('Y-m-d', $this->input->post("gecerlilik_tarih"));
            } else {
                $gecerlilik_tarihi = null;
            }
            $update = $this->Bond_model->update(
                array(
                    "id" => $bond_id
                ),
                array(
                    "teminat_gerekce" => $this->input->post("teminat_gerekce"),
                    "teminat_turu" => $this->input->post("teminat_turu"),
                    "teminat_miktar" => $this->input->post("teminat_miktar"),
                    "teminat_banka" => $this->input->post("teminat_banka"),
                    "teslim_tarih" => $teslim_tarihi,
                    "gecerlilik_tarih" => $gecerlilik_tarihi,
                    "aciklama" => $this->input->post("aciklama"),
                )
            );
// Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Bond/$bond_id";
// Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }
            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
// Yükleme ayarları belirleniyor
            $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
            $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
            $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
            $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)
// Yükleme kütüphanesi yükleniyor
            $this->load->library("upload", $config);
// Dosya yükleme işlemi
            if (!$this->upload->do_upload("file")) {
// Yükleme başarısız olduysa hata mesajı döndürülüyor
                $error = $this->upload->display_errors();
            } else {
// Yükleme başarılıysa devam eden işlemler
                $data = $this->upload->data();
            }
            $edit_bond = $this->Bond_model->get(array("id" => $bond_id));
            $item = $this->Contract_model->get(array("id" => $edit_bond->contract_id));
            $project = $this->Project_model->get(array("id" => $item->project_id));

            $bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "teslim_tarih ASC");
            $viewData = new stdClass();


            $viewData->project = $project;
            $viewData->bonds = $bonds;

            $viewData->item = $item;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("contract_module/contract_v/display/bond/bond_table", $viewData, true)
            );
            echo json_encode($response);
//kaydedilen elemanın id nosunu döküman ekleme
// sına post ediyoruz
        } else {
            $edit_bond = $this->Bond_model->get(array("id" => $bond_id));
            $item = $this->Contract_model->get(array("id" => $edit_bond->contract_id));
            $project = $this->Project_model->get(array("id" => $item->project_id));

            $bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "teslim_tarih ASC");
            $viewData = new stdClass();


            $viewData->edit_bond = $edit_bond;
            $viewData->project = $project;
            $viewData->bonds = $bonds;

            $viewData->item = $item;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("contract_module/contract_v/display/bond/edit_bond_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    function edit_advance($advance_id)
    {


        $edit_advance = $this->Advance_model->get(array("id" => $advance_id));
        $item = $this->Contract_model->get(array("id" => $edit_advance->contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));

        $advances = $this->Advance_model->get_all(array('contract_id' => $item->id), "avans_tarih ASC");
        $viewData = new stdClass();


        $viewData->project = $project;
        $viewData->advances = $advances;

        $viewData->item = $item;
        $this->load->library("form_validation");
        $contract_price = $item->sozlesme_bedel;
        $sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);
        $this->form_validation->set_rules("avans_tarih", "Avans Tarihi", "callback_contract_advance[$sozlesme_tarih]|required|trim");
        $this->form_validation->set_rules("avans_turu", "Avans Türü", "required|trim");
        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_advance[$sozlesme_tarih]|trim");
        }
        if ($this->input->post('avans_turu') == "Çek") {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_advance[$sozlesme_tarih]|trim|required");
        }
        $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|numeric|required|trim");
        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|less_than_equal_to[$contract_price]|numeric|trim");
        } else {
            $this->form_validation->set_rules("avans_miktar", "Avans Miktarı", "required|numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_advance" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
            )
        );
// Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            if ($this->input->post("avans_tarih")) {
                $avans_tarihi = dateFormat('Y-m-d', $this->input->post("avans_tarih"));
            } else {
                $avans_tarihi = null;
            }
            if ($this->input->post("vade_tarih")) {
                $vade_tarihi = dateFormat('Y-m-d', $this->input->post("vade_tarih"));
            } else {
                $vade_tarihi = null;
            }
            $update = $this->Advance_model->update(
                array(
                    "id" => $advance_id
                ),
                array(
                    "avans_tarih" => $avans_tarihi,
                    "vade_tarih" => $vade_tarihi,
                    "avans_miktar" => $this->input->post("avans_miktar"),
                    "avans_turu" => $this->input->post("avans_turu"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );
// Yükleme yapılacak dosya yolu oluşturuluyor
            $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Advance/$advance_id";
// Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }
            $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
// Yükleme ayarları belirleniyor
            $config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
            $config["upload_path"] = "$path"; // Dosya yolu belirleniyor
            $config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
            $config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)
// Yükleme kütüphanesi yükleniyor
            $this->load->library("upload", $config);
// Dosya yükleme işlemi
            if (!$this->upload->do_upload("file")) {
// Yükleme başarısız olduysa hata mesajı döndürülüyor
                $error = $this->upload->display_errors();
            } else {
// Yükleme başarılıysa devam eden işlemler
                $data = $this->upload->data();
            }
            $edit_advance = $this->Advance_model->get(array("id" => $advance_id));
            $item = $this->Contract_model->get(array("id" => $edit_advance->contract_id));
            $project = $this->Project_model->get(array("id" => $item->project_id));

            $advances = $this->Advance_model->get_all(array('contract_id' => $item->id), "avans_tarih ASC");
            $viewData = new stdClass();


            $viewData->project = $project;
            $viewData->advances = $advances;

            $viewData->item = $item;
            $response = array(
                'status' => 'success',
                'html' => $this->load->view("contract_module/contract_v/display/advance/advance_table", $viewData, true)
            );
            echo json_encode($response);
        } else {
            $edit_advance = $this->Advance_model->get(array("id" => $advance_id));
            $item = $this->Contract_model->get(array("id" => $edit_advance->contract_id));
            $project = $this->Project_model->get(array("id" => $item->project_id));

            $advances = $this->Advance_model->get_all(array('contract_id' => $item->id), "avans_tarih ASC");
            $viewData = new stdClass();


            $viewData->edit_advance = $edit_advance;
            $viewData->project = $project;
            $viewData->advances = $advances;

            $viewData->item = $item;
            $viewData->form_error = true;
            $response = array(
                'status' => 'error',
                'html' => $this->load->view("contract_module/contract_v/display/advance/edit_advance_form_input", $viewData, true)
            );
            echo json_encode($response);
        }
    }

    public function contract_collection($collection_day, $contract_day)
    {
        $date_diff = date_minus($collection_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function contract_advance($advance_day, $contract_day)
    {
        $date_diff = date_minus($advance_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function contract_bond($bond_day, $contract_day)
    {
        $date_diff = date_minus($bond_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function date_greater_than($date1, $date2_field)
    {
        $format_date1 = dateFormat('Y-m-d', "$date1");
        $format_date2 = dateFormat('Y-m-d', "$date2_field");
        if (strtotime($format_date1) > strtotime($format_date2)) {
            return TRUE; // Karşılaştırma doğruysa TRUE döner
        }
        return FALSE; // Karşılaştırma yanlışsa FALSE döner
    }

    public function date_greater_than_equal($date1, $date2_field)
    {
        $format_date1 = dateFormat('Y-m-d', "$date1");
        $format_date2 = dateFormat('Y-m-d', "$date2_field");
        if (strtotime($format_date1) >= strtotime($format_date2)) {
            return TRUE;
        }
        return FALSE;
    }

    public function date_less_than($date1, $date2_field)
    {
        $format_date1 = dateFormat('Y-m-d', "$date1");
        $format_date2 = dateFormat('Y-m-d', "$date2_field");
        if (strtotime($format_date1) < strtotime($format_date2)) {
            return TRUE;
        }
        return FALSE;
    }

    public function date_less_than_equal($date1, $date2_field)
    {
        $format_date1 = dateFormat('Y-m-d', "$date1");
        $format_date2 = dateFormat('Y-m-d', "$date2_field");
        if (strtotime($format_date1) <= strtotime($format_date2)) {
            return TRUE;
        }
        return FALSE;
    }

    public function folder_open()
    {
        $folder_name = $this->input->post('folder_name');
        $contract_id = $this->input->post('contractID');
        $parent_name = $this->input->post('parent_name');
        $item = $this->Contract_model->get(array("id" => $contract_id));
        $project = $this->Project_model->get(array("id" => $item->project_id));
        $main_path = "uploads/project_v/$project->dosya_no/$item->dosya_no/";
        if ($parent_name != null) {
            $sub_path = "uploads/project_v/$project->dosya_no/$item->dosya_no/$folder_name/$parent_name";
            $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/$folder_name/$parent_name/";
        } else {
            $sub_path = "uploads/project_v/$project->dosya_no/$item->dosya_no/$folder_name";
            $path = "uploads/project_v/$project->dosya_no/$item->dosya_no/$folder_name/";
        }
        $filter = scandir($sub_path);
        $filter_main = scandir($main_path);
// . ve .. hariç tutarak, sadece klasörleri ve dosyaları alıyoruz
        $files = array_filter($filter, function ($item) use ($sub_path) {
            // . ve ..'i hariç tutuyoruz ve sadece dosya ya da klasörleri alıyoruz
            return $item !== '.' && $item !== '..' && !is_dir($sub_path . DIRECTORY_SEPARATOR . $item);
        });
        $folders = array_filter($filter, function ($item) use ($sub_path) {
            // . ve ..'i hariç tutuyoruz ve sadece dizinleri alıyoruz
            return $item !== '.' && $item !== '..' && is_dir($sub_path . DIRECTORY_SEPARATOR . $item);
        });
        $main_folders = array_filter($filter_main, function ($item) use ($main_path) {
            // . ve ..'i hariç tutuyoruz ve sadece dizinleri alıyoruz
            return $item !== '.' && $item !== '..' && is_dir($main_path . DIRECTORY_SEPARATOR . $item);
        });
        $viewData = new stdClass();

        $viewData->item = $item;
        $viewData->path = $path;
        $viewData->main_folders = $main_folders;
        $viewData->folder_id = $parent_name;
        $viewData->main_path = $main_path;
        $viewData->sub_path = $sub_path;
        $viewData->folder_name = $folder_name;
        $viewData->folders = $folders;
        $viewData->folder_count = count($folders);
        $viewData->files = $files;
        $html = $this->load->view("contract_module/contract_v/display/folder/sub_folder", $viewData);
        echo json_encode([
            'html' => $html, // Form hatalarını içeren HTML
        ]);
    }

    public function download_file($encoded_path)
    {
        // Dosya yolunu decode et
        $file_path = base64_decode(urldecode($encoded_path));
        // Platforma uygun dosya yolunu normalize et
        $file_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file_path);  // / ve \'yi platforma uygun şekilde değiştir
        // Dosyanın var olup olmadığını kontrol et
        if (file_exists($file_path)) {
            // Dosya indirmeye başla
            $this->load->helper('download');
            force_download($file_path, NULL);  // Dosyayı indir
        } else {
            echo "Dosya bulunamadı!";
        }
    }

    public function delete_file($encoded_path)
    {
        // Dosya yolunu decode et
        $file_path = base64_decode(urldecode($encoded_path));
        // Platforma uygun dosya yolunu normalize et
        $file_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file_path);  // / ve \'yi platforma uygun şekilde değiştir
        // Dosyanın var olup olmadığını kontrol et
        if (file_exists($file_path)) {
            // Dosyayı sil
            if (unlink($file_path)) {
                echo "Dosya başarıyla silindi.";
            } else {
                echo "Dosya silinirken bir hata oluştu.";
            }
        } else {
            echo "Dosya bulunamadı!";
        }
    }

    public function unique_folder_name($folder_name, $new_folder)
    {
        // $new_folder'dan bir üst dizini al
        $parent_folder = dirname($new_folder);
        // Eğer parent_folder mevcut değilse, kontrol yapmaya gerek yok
        if (!is_dir($parent_folder)) {
            return TRUE;
        }
        // Klasör içindeki tüm alt klasörleri al (sadece dizinler)
        $existing_folders = array_filter(scandir($parent_folder), function ($item) use ($parent_folder) {
            return $item !== '.' && $item !== '..' && is_dir($parent_folder . DIRECTORY_SEPARATOR . $item);
        });
        // Mevcut klasör isimlerini küçük harfe çevir ve kontrol et
        if (in_array(strtolower($folder_name), array_map('strtolower', $existing_folders))) {
            $this->form_validation->set_message('unique_folder_name', 'Bu klasör adı zaten kullanılıyor.');
            return FALSE;
        }
        return TRUE;
    }
}