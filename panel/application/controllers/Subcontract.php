<?php

class Subcontract extends CI_Controller
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

        $this->moduleFolder = "contract_module";
        $this->viewFolder = "subcontract_v";

        $this->load->model("Contract_model");
        $this->load->model("Contract_file_model");
        $this->load->model("Drawings_model");
        $this->load->model("Drawings_file_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Company_model");
        $this->load->model("User_model");
        $this->load->model("City_model");
        $this->load->model("Payment_model");
        $this->load->model("Bond_model");
        $this->load->model("Favorite_model");
        $this->load->model("Order_model");
        $this->load->model("Advance_model");
        $this->load->model("Costinc_model");
        $this->load->model("Extime_model");
        $this->load->model("Catalog_model");
        $this->load->model("Auction_model");
        $this->load->model("Condition_model");
        $this->load->model("Site_model");

        $this->Module_Name = "Subcontract";
        $this->Module_Title = "Alt Sözleşme";

        $this->Module_Main_Dir = "project_v";

        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        $this->Dependet_id_key = "contract_id";
        $this->Module_Parent_Name = "project";

        //Folder Structure
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Update_Folder = "update";

        $this->File_List = "file_list_v";
        $this->Common_Files = "common";

        $this->Settings = get_settings();

    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $active_items = $this->Contract_model->get_all(array(
            "durumu" => 1,
            "subcont" => 1
        ));
        $passive_items = $this->Contract_model->get_all(array(
            "durumu" => !1,
            "subcont" => 1
        ));
        $active_contracts = $this->Contract_model->get_all(array(
            "durumu" => 1
        ));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->active_items = $active_items;
        $viewData->active_contracts = $active_contracts;
        $viewData->passive_items = $passive_items;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form()
    {
        $contract_id = $this->input->post('contract_id');


        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Contract_model->get_all(array(
            "durumu" => 1
        ));
        $projects = $this->Project_model->get_all(array());
        $active_projects = $this->Project_model->get_all(array(
            "durumu" => default_table()
        ));
        $settings = $this->Settings_model->get();
        $companys = $this->Company_model->get_all(array());
        $contract = $this->Contract_model->get(array("id" => $contract_id));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->active_projects = $active_projects;
        $viewData->settings = $settings;
        if (isset($contract_id)) {
            $viewData->contract = $contract;
        }

        $viewData->companys = $companys;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        $alert = array(
            "title" => "Sözleşme",
            "text" => "Yeni Oluştur Sayfası ",
            "type" => "success"
        );

        $this->session->set_flashdata("alert", $alert);

    }

    public function save($contract_id = null)
    {
        if ($contract_id == null) {
            $contract_id = $this->input->post('contract_id');
        }

        $file_name_len = file_name_digits();
        $file_name = "ASOZ-" . $this->input->post('dosya_no');
        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[contract.dosya_no]|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("sozlesme_ad", "Sözleşme Ad", "required|trim");
        $this->form_validation->set_rules("contractor", "Taşeron/Tedarikçi", "required|trim");
        $this->form_validation->set_rules("sozlesme_tarih", "Sözleşme Tarih", "required|trim");
        $this->form_validation->set_rules("sozlesme_turu", "Sözleşme Türü", "required|trim");
        $this->form_validation->set_rules("teklif_turu", "İşin Türü", "required|trim");
        $this->form_validation->set_rules("isin_suresi", "İşin Süresi", "greater_than[0]|required|trim|integer");
        $this->form_validation->set_rules("sozlesme_bedel", "Sözleşme Bedel", "greater_than[0]|required|trim|numeric");
        $this->form_validation->set_rules("para_birimi", "Para Birimi", "required|trim");
        $this->form_validation->set_rules("fiyat_fark", "Fiyat Farkı", "required|trim");
        $this->form_validation->set_rules("kdv_oran", "KDV Oran", "trim|numeric|required");
        if (($this->input->post('kdv_oran')) > 0) {
            $this->form_validation->set_rules("tevkifat_oran", "Tevkifat Oran", "trim|required");
        }
        $this->form_validation->set_rules("damga_oran", "Damga Oran", "trim|numeric|required");
        $this->form_validation->set_rules("damga_kesinti", "Damga Vergisi Kesintisi", "trim|numeric|required|less_than_equal_to[1]");
        $this->form_validation->set_rules("stopaj_oran", "Stopaj Oran", "trim|numeric|required");
        $this->form_validation->set_rules("avans_durum", "Avans Durum", "trim|numeric|required|less_than_equal_to[1]");
        if (($this->input->post('avans_durum')) == 1) {
            $this->form_validation->set_rules("avans_stopaj", "Stopaj Kesintisinde Avans Miktarı Mahsubu", "trim|numeric|required|less_than_equal_to[1]");
            $this->form_validation->set_rules("avans_mahsup_durum", "Hakedişte Avans Mahsubu", "trim|numeric|required|less_than_equal_to[1]");
        }
        if (($this->input->post('avans_mahsup_durum')) == 1) {
            $this->form_validation->set_rules("avans_mahsup_oran", "Avans Mahsup Oranı", "greater_than[0]|trim|numeric|required");
        }
        $this->form_validation->set_rules("fiyat_fark", "Fiyat Fark", "trim|numeric|required|less_than_equal_to[1]");
        $this->form_validation->set_rules("ihzarat", "İhzarat", "trim|numeric|required|less_than_equal_to[1]");
        if ($this->input->post("fiyat_fark") == 1) {
            $this->form_validation->set_rules("fiyat_fark_teminat", "Hakedişte Fiyat Farkı Teminatı Kesintisi", "trim|numeric|required|less_than_equal_to[1]");
        }
        $this->form_validation->set_rules("teminat_oran", "Teminat Oran", "trim|numeric|required");
        $this->form_validation->set_rules("gecici_kabul_kesinti", "Geçici Kabul Kesinti", "trim|numeric|required|less_than_equal_to[1]");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "differs" => "<b>{field}</b> sıkıntılı",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük olmalıdır",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "less_than_equal_to" => "<b>{field}</b> alanı doldurulmalıdır",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            if ($contract_id == null) {
                $project_id = project_id_cont($contract_id);
                $project_code = project_code($project_id);

                $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$file_name";
                if (!is_dir($path)) {
                    mkdir($path, 0777, TRUE); // Subcontract Ana Klasörü Oluşut
                }
            } else {
                $path = "$this->Upload_Folder/$this->Module_Main_Dir/subcontract/$file_name";
                if (!is_dir($path)) {
                    mkdir($path, 0777, TRUE); // Subcontract Ana Klasörü Oluşut
                }
            }


            if ($this->input->post("sozlesme_tarih")) {
                $sozlesme_tarih = dateFormat('Y-m-d', $this->input->post("sozlesme_tarih"));
            } else {
                $project_id = null;

                $sozlesme_tarih = null;
            }

            $sozlesme_bitis = dateFormat('Y-m-d', (date_plus_days($this->input->post("sozlesme_tarih"), ($this->input->post("isin_suresi") - 1))));

            $sozlesme_ad = mb_convert_case($this->input->post("sozlesme_ad"), MB_CASE_TITLE, "UTF-8");

            $insert = $this->Contract_model->add(
                array(
                    "proje_id" => $project_id,
                    "dosya_no" => $file_name,
                    "sozlesme_ad" => $sozlesme_ad,
                    "yuklenici" => $this->input->post("contractor"),
                    "aciklama" => $this->input->post("aciklama"),

                    "sozlesme_tarih" => $sozlesme_tarih,
                    "sozlesme_turu" => $this->input->post("sozlesme_turu"),
                    "isin_turu" => $this->input->post("teklif_turu"),
                    "isin_suresi" => $this->input->post("isin_suresi"),
                    "sozlesme_bitis" => $sozlesme_bitis,
                    "sozlesme_bedel" => $this->input->post("sozlesme_bedel"),
                    "para_birimi" => $this->input->post("para_birimi"),

                    "kdv_oran" => $this->input->post("kdv_oran"),
                    "tevkifat_oran" => $this->input->post("tevkifat_oran"),
                    "damga_oran" => $this->input->post("damga_oran"),
                    "damga_kesinti" => $this->input->post("damga_kesinti"),
                    "stopaj_oran" => $this->input->post("stopaj_oran"),
                    "avans_durum" => $this->input->post("avans_durum"),
                    "avans_mahsup_durum" => $this->input->post("avans_mahsup_durum"),
                    "avans_mahsup_oran" => $this->input->post("avans_mahsup_oran"),
                    "avans_stopaj" => $this->input->post("avans_stopaj"),
                    "ihzarat" => $this->input->post("ihzarat"),
                    "fiyat_fark" => $this->input->post("fiyat_fark"),
                    "fiyat_fark_teminat" => $this->input->post("fiyat_fark_teminat"),
                    "teminat_oran" => $this->input->post("teminat_oran"),
                    "gecici_kabul_kesinti" => $this->input->post("gecici_kabul_kesinti"),
                    "durumu" => "1",
                    "subcont" => "1",
                )
            );

            $record_id = $this->db->insert_id();
            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $record_id,
                    "connected_project_id" => $record_id,
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
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));
        } else {

            $viewData = new stdClass();

            /** Tablodan Verilerin Getirilmesi.. */
            $items = $this->Contract_model->get_all(array(
                "durumu" => 1
            ));
            $projects = $this->Project_model->get_all(array());
            $active_projects = $this->Project_model->get_all(array(
                "durumu" => default_table()
            ));
            $settings = $this->Settings_model->get();
            $companys = $this->Company_model->get_all(array());
            $contract = $this->Contract_model->get(array("id" => $contract_id));

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->items = $items;
            $viewData->projects = $projects;
            $viewData->active_projects = $active_projects;
            $viewData->settings = $settings;
            if (isset($contract_id)) {
                $viewData->contract = $contract;
            }
            $viewData->form_error = true;
            $viewData->companys = $companys;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function file_form($id, $active_tab = null)
    {
        $viewData = new stdClass();
        $payments = $this->Payment_model->get_all(array('contract_id' => $id));
        $pid = get_from_any("contract", "proje_id", "id", $id);

        $fav = $this->Favorite_model->get(array(
            "user_id" => active_user_id(),
            "module" => "contract",
            "view" => "file_form",
            "module_id" => $id,
        ));
        $drawings = $this->Drawings_model->get_all(array('contract_id' => $id));
        $settings = $this->Settings_model->get();
        $advances = $this->Advance_model->get_all(array('contract_id' => $id));


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->payments = $payments;
        $viewData->pid = $pid;
        $viewData->drawings = $drawings;
        $viewData->fav = $fav;
        $viewData->settings = $settings;

        $viewData->active_tab = $active_tab;
        $viewData->advances = $advances;


        $viewData->item = $this->Contract_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Contract_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function update_form($id, $from = null)
    {
        $viewData = new stdClass();

        $settings = $this->Settings_model->get();
        $employers = $this->Company_model->get_all(array());
        $not_employers = $this->Company_model->get_all(array());
        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $yuklenici_users = $this->User_model->get_all(array(
            "user_role" => 2
        ));
        $cities = $this->City_model->get_all(array());
        $active_tab = $from;
        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->settings = $settings;
        $viewData->employers = $employers;
        $viewData->not_employers = $not_employers;
        $viewData->users = $users;
        $viewData->yuklenici_users = $yuklenici_users;
        $viewData->cities = $cities;
        $viewData->active_tab = $active_tab;
        $viewData->item = $this->Contract_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Contract_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update($id)
    {
        $this->load->library("form_validation");

        $this->form_validation->set_rules("sozlesme_ad", "Sözleşme Ad", "required|trim");
        $this->form_validation->set_rules("isveren", "İşveren", "required|trim");
        $this->form_validation->set_rules("yuklenici", "Yüklenici", "required|trim");
        $this->form_validation->set_rules("fiyat_fark", "Fiyat Farkı", "required|trim");
        $this->form_validation->set_rules("sozlesme_tarih", "Sözleşme Tarih", "required|trim");
        $this->form_validation->set_rules("sozlesme_turu", "Sözleşme Türü", "required|trim");
        $this->form_validation->set_rules("isin_turu", "İşin Türü", "required|trim");
        $this->form_validation->set_rules("isin_suresi", "İşin Süresi", "greater_than[0]|required|trim|integer");
        $this->form_validation->set_rules("sozlesme_bedel", "Sözleşme Bedel", "greater_than[0]|required|trim|numeric");
        $this->form_validation->set_rules("para_birimi", "Para Birimi", "required|trim");
        $this->form_validation->set_rules("adres", "Adres", "trim");
        if (!empty($this->input->post('adres'))) {
            $this->form_validation->set_rules("adress_city", "İl", "required|trim");
            $this->form_validation->set_rules("adress_district", "İlçe", "required|trim");
        }

        $this->form_validation->set_rules("kdv_oran", "KDV Oran", "trim|numeric|required");
        if (($this->input->post('kdv_oran')) > 0) {
            $this->form_validation->set_rules("tevkifat_oran", "Tevkifat Oran", "trim|required");
        }
        $this->form_validation->set_rules("damga_oran", "Damga Oran", "trim|numeric|required");
        $this->form_validation->set_rules("damga_kesinti", "Damga Vergisi Kesintisi", "trim|numeric|required");
        $this->form_validation->set_rules("stopaj_oran", "Stopaj Oran", "trim|numeric|required");
        $this->form_validation->set_rules("avans_durum", "Avans Durum", "trim|numeric|required");
        if (($this->input->post('avans_durum')) == 1) {
            $this->form_validation->set_rules("avans_stopaj", "Stopaj Kesintisinde Avans Miktarı Mahsubu", "trim|numeric|required");
            $this->form_validation->set_rules("avans_mahsup_durum", "Hakedişte Avans Mahsubu", "trim|numeric|required");
        }
        if (($this->input->post('avans_mahsup_durum')) == 1) {
            $this->form_validation->set_rules("avans_mahsup_oran", "Avans Mahsup Oranı", "greater_than[0]|trim|numeric|required");
        }
        $this->form_validation->set_rules("fiyat_fark", "Fiyat Fark", "trim|numeric|required");

        $this->form_validation->set_rules("ihzarat", "İhzarat", "trim|numeric|required");
        if ($this->input->post("fiyat_fark") != 0) {
            $this->form_validation->set_rules("fiyat_fark_teminat", "Hakedişte Fiyat Farkı Teminatı Kesintisi", "trim|numeric|required");
        }
        $this->form_validation->set_rules("teminat_oran", "Teminat Oran", "trim|numeric|required");
        $this->form_validation->set_rules("gecici_kabul_kesinti", "Geçici Kabul Kesinti", "trim|numeric|required");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük olmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("sozlesme_tarih")) {
                $sozlesme_tarih = dateFormat('Y-m-d', $this->input->post("sozlesme_tarih"));
            } else {
                $sozlesme_tarih = null;
            }

            $sozlesme_bitis = dateFormat('Y-m-d', (date_plus_days($this->input->post("sozlesme_tarih"), ($this->input->post("isin_suresi") - 1))));

            $sozlesme_ad = mb_convert_case($this->input->post("sozlesme_ad"), MB_CASE_TITLE, "UTF-8");

            $update = $this->Contract_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "sozlesme_ad" => $sozlesme_ad,
                    "isveren" => $this->input->post("isveren"),
                    "yuklenici" => $this->input->post("yuklenici"),
                    "aciklama" => $this->input->post("aciklama"),

                    "sozlesme_tarih" => $sozlesme_tarih,
                    "sozlesme_turu" => $this->input->post("sozlesme_turu"),
                    "isin_turu" => $this->input->post("isin_turu"),
                    "isin_suresi" => $this->input->post("isin_suresi"),
                    "sozlesme_bitis" => $sozlesme_bitis,
                    "sozlesme_bedel" => $this->input->post("sozlesme_bedel"),
                    "para_birimi" => $this->input->post("para_birimi"),

                    "adres" => $this->input->post("adres"),
                    "adres_il" => $this->input->post("adress_city"),
                    "adres_ilce" => $this->input->post("adress_district"),
                    "ada" => $this->input->post("ada"),
                    "pafta" => $this->input->post("pafta"),
                    "parsel" => $this->input->post("parsel"),

                    "isveren_yetkili" => $this->input->post("isveren_yetkili"),
                    "isveren_sorumlu" => $this->input->post("isveren_sorumlu"),
                    "yuklenici_yetkili" => $this->input->post("yuklenici_yetkili"),
                    "yuklenici_sorumlu" => $this->input->post("yuklenici_sorumlu"),

                    "kdv_oran" => $this->input->post("kdv_oran"),
                    "tevkifat_oran" => $this->input->post("tevkifat_oran"),
                    "damga_oran" => $this->input->post("damga_oran"),
                    "damga_kesinti" => $this->input->post("damga_kesinti"),
                    "stopaj_oran" => $this->input->post("stopaj_oran"),
                    "avans_durum" => $this->input->post("avans_durum"),
                    "avans_mahsup_durum" => $this->input->post("avans_mahsup_durum"),
                    "avans_mahsup_oran" => $this->input->post("avans_mahsup_oran"),
                    "avans_stopaj" => $this->input->post("avans_stopaj"),
                    "ihzarat" => $this->input->post("ihzarat"),
                    "fiyat_fark" => $this->input->post("fiyat_fark"),
                    "fiyat_fark_teminat" => $this->input->post("fiyat_fark_teminat"),
                    "teminat_oran" => $this->input->post("teminat_oran"),
                    "gecici_kabul_kesinti" => $this->input->post("gecici_kabul_kesinti"),
                    "durumu" => "1",
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
            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->Contract_model->get(
                array(
                    "id" => $id,
                )
            );


            $viewData = new stdClass();
            $employers = $this->Company_model->get_all(array());

            $not_employers = $this->Company_model->get_all(array());
            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));
            $yuklenici_users = $this->User_model->get_all(array(
                "user_role" => 2
            ));
            $cities = $this->City_model->get_all(array());
            $settings = $this->Settings_model->get();
            $active_tab = null;
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->form_error = true;
            $viewData->item = $item;
            $viewData->settings = $settings;
            $viewData->employers = $employers;
            $viewData->not_employers = $not_employers;
            $viewData->users = $users;
            $viewData->yuklenici_users = $yuklenici_users;
            $viewData->cities = $cities;
            $viewData->active_tab = $active_tab;
            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {
        $project_id = get_from_id("contract", "proje_id", $id);
        $project_code = project_code($project_id);
        echo $project_code;
        echo $sub_folder = get_from_id("contract", "dosya_no", $id);
        echo $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$sub_folder";
        $sil = deleteDirectory($path);

        $delete_module_list = array("accept", "advance", "bond", "costinc", "drawings", "extime", "sitedel", "subcomp", "payment", "catalog");
        foreach ($delete_module_list as $module) {
            if (!empty($module_ids = get_from_any_array_select_ci("id", "$module", "contract_id", $id))) {
                foreach ($module_ids as $module_id) {
                    $this->db->where(array("id" => $module_id))->delete($module);
                    $module_file = $module . "_files";
                    $module_name_id = $module . "_id";
                    $this->db->where(array($module_name_id => $module_id))->delete($module_file);
                }
            }
        }

        $delete_contract_files = $this->Contract_file_model->delete(array("$this->Dependet_id_key" => $id));
        $delete_contract = $this->Contract_model->delete(array("id" => $id));

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

        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        if ($delete_contract) {
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Sözleşme tüm alt işleri ile birlikte, başarılı bir şekilde silindi",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Sözleşme silme sırasında bir problem oluştu",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("$this->Module_Parent_Name/$this->Display_route/$project_id"));
    }

    public function file_upload($id)
    {

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $contract_id = $id;
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $id);

        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code";

        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Contract_file_model->add(
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
        $fileName = $this->Contract_file_model->get(
            array(
                "id" => $id
            )
        );


        $contract_id = get_from_id("contract_files", "contract_id", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $sub_folder = get_from_id("contract", "dosya_no", ($contract_id));

        $file_path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$sub_folder/$fileName->img_url";

        if ($file_path) {

            if (file_exists($file_path)) {
                // get file content
                $data = file_get_contents($file_path);
                //force download
                force_download($fileName->img_url, $data);
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Dosya indirildi",
                    "type" => "success"
                );

                $this->session->set_flashdata("alert", $alert);
                redirect(base_url("$this->Module_Name/$this->Display_route/$contract_id"));
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Dosya veritabanında var ancak klasör içinden silinmiş, SİSTEM YÖNETİCİNİZE BAŞVURUN",
                    "type" => "danger"
                );
                redirect(base_url("$this->Module_Name/$this->Display_route/$contract_id"));

                $this->session->set_flashdata("alert", $alert);
            }
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Dosya yok",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$contract_id"));
        }
    }

    public function refresh_file_list($id, $from)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "$from";


        $viewData->item_files = $this->Contract_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        $alert = array(
            "title" => "Dosya Yüklendi",
            "text" => "Dosya Yükleme Başarılı",
            "type" => "success"
        );
        $this->session->set_flashdata("alert", $alert);

        echo $render_html;

    }

    public function fileDelete($id, $from)
    {

        $fileName = $this->Contract_file_model->get(
            array(
                "id" => $id
            )
        );


        $contract_id = get_from_id("contract_files", "contract_id", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $sub_folder = get_from_id("contract", "dosya_no", ($contract_id));

        $delete = $this->Contract_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$sub_folder/$fileName->img_url";


            unlink($path);

            $alert = array(
                "title" => "Dosya Silindi",
                "text" => " $fileName->img_url Dosyası Silme Başarılı",
                "type" => "success"
            );

            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("$this->Module_Name/$from/$contract_id"));

        } else {

            $alert = array(
                "title" => "Dosya Silinemedi",
                "text" => " $fileName->img_url Dosyası Silme Başarısz",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("$this->Module_Name/$from/$contract_id"));

        }

    }

    public function fileDelete_all($id, $from)
    {

        $project_id = get_from_id("contract", "proje_id", $id);
        $project_code = project_code($project_id);
        $sub_folder = get_from_id("contract", "dosya_no", $id);

        $delete = $this->Contract_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$sub_folder");

            foreach ($dir_files as $dir_file) {
                unlink("$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$sub_folder/$dir_file");
            }

            $alert = array(
                "title" => "Tüm Dosyalar Silindi",
                "text" => " Tüm Dosyaları Silme Başarılı",
                "type" => "success"
            );

            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("$this->Module_Name/$from/$id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$id"));

            $alert = array(
                "title" => "Dosyalar Silinemedi",
                "text" => " Tüm Dosyaları Silme Başarısız",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);

        }

    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "ASOZ-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_district($id)
    {
        $result = $this->db->where("city_id", $id)->get("district")->result();
        echo json_encode($result);
    }

}

