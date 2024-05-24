<?php

class Auction extends CI_Controller
{
    public $viewFolder = "";

    public $moduleFolder = "";

    public function __construct()
    {

        parent::__construct();

        $uploader = APPPATH . 'libraries/FileUploader.php';
        include($uploader);

        if (!get_active_user()) {
            redirect(base_url("login"));
        }
        $this->Theme_mode = get_active_user()->mode;
        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        $this->moduleFolder = "auction_module";
        $this->viewFolder = "auction_v";

        $this->load->model("Auction_model");
        $this->load->model("Auction_file_model");
        $this->load->model("Aucdraw_file_model");
        $this->load->model("Aucdraw_model");
        $this->load->model("Cost_model");
        $this->load->model("Notice_model");
        $this->load->model("Condition_model");
        $this->load->model("Compute_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Company_model");
        $this->load->model("Incentive_model");
        $this->load->model("Incentive_file_model");
        $this->load->model("User_model");
        $this->load->model("Order_model");
        $this->load->model("Delete_model");
        $this->load->model("Contract_model");
        $this->load->model("Offer_model");
        $this->load->model("Favorite_model");

        $this->Module_Name = "auction";
        $this->Module_Title = "Teklif";

        $this->Module_Main_Dir = "project_v";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "auction";
        $this->Module_File_Dir = "auction";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        $this->Dependet_id_key = "auction_id";
        $this->Module_Parent_Name = "project";
        $this->table_name = "auction";

        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";


        //Folder Structure
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";

        $this->File_List = "file_list_v";
        $this->Common_Files = "common";

        $this->Settings = get_settings();


    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $active_items = $this->Auction_model->get_all(array("durumu" => 1));
        $passive_items = $this->Auction_model->get_all(array("durumu" => !1));
        $projects = $this->Project_model->get_all(array());


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->active_items = $active_items;
        $viewData->passive_items = $passive_items;
        $viewData->projects = $projects;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($project_id = null)
    {
        if (!isAdmin()) {
            $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$project_id"));
            if (!in_array(active_user_id(), $yetkili)) {
                redirect(base_url("error"));
            }
        }


        if (!empty($this->input->post("proje_id"))) {
            $project_id = $this->input->post("proje_id");
        }

        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Auction_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_projects = $this->Project_model->get_all(array(
            "durumu" => default_table()
        ));
        $settings = $this->Settings_model->get();
        $employers = $this->Company_model->get_all(array());
        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = $this->Add_Folder;
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->active_projects = $active_projects;
        $viewData->settings = $settings;
        $viewData->project_id = $project_id;
        $viewData->employers = $employers;
        $viewData->users = $users;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        $alert = array(
            "title" => "Yeni Teklif Hazırlığı",
            "text" => "",
            "type" => "success"
        );

        $this->session->set_flashdata("alert", $alert);

    }

    public function file_form($id, $active_tab = null)
    {


        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        $auction = $this->Auction_model->get(array("id"=>$id));
        $project = $this->Project_model->get(array("id"=>$auction->proje_id));
        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->proje_kodu/$auction->dosya_no/Main/";

        $settings = $this->Settings_model->get();

        $fav = $this->Favorite_model->get(array(
            "user_id" => active_user_id(),
            "module" => "auction",
            "view" => "file_form",
            "module_id" => $id,
        ));

        $idari_sart = $this->Condition_model->get(array(
            'auction_id' => $id
        ));

        $viewData->safety_files = $this->Auction_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id,
                "type" => "Safety"
            ),
        );

        $viewData->technical_files = $this->Auction_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id,
                "type" => "Technical"
            ),
        );

        $viewData->qualify_files = $this->Auction_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id,
                "type" => "qualify"
            ),
        );

        $viewData->condition_files = $this->Auction_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id,
                "type" => "Condition"
            ),
        );

        $ymler = $this->Cost_model->get_all(array(
            "auction_id" => $id
        ));

        $tesvikler = $this->Incentive_model->get_all(array('auction_id' => $id));
        $cizimler = $this->Aucdraw_model->get_all(array('auction_id' => $id));
        $metrajlar = $this->Compute_model->get_all(array('auction_id' => $id));
        $ihale_ilan = $this->Notice_model->get(array('auction_id' => $id, 'original_notice' => null));
        $ilanlar = $this->Notice_model->get_all(array('auction_id' => $id));
        $viewData->settings = $settings;
        $viewData->fav = $fav;

        $offers = $this->Offer_model->get_all(array("auction_id" => $id));
        $yukleniciler = $this->Company_model->get_all();
        $istekliler = get_from_id("auction", "istekliler", $id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->path = $path;
        $viewData->idari = $idari_sart;
        $viewData->ymler = $ymler;
        $viewData->tesvikler = $tesvikler;
        $viewData->cizimler = $cizimler;
        $viewData->metrajlar = $metrajlar;
        $viewData->project = $project;
        $viewData->ilanlar = $ilanlar;
        $viewData->ihale_ilan = $ihale_ilan;
        $viewData->offers = $offers;
        $viewData->yukleniciler = $yukleniciler;
        $viewData->istekliler = $istekliler;
        $viewData->active_tab = $active_tab;

        $this->load->helper('array');

        $viewData->item = $this->Auction_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Auction_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id,
                "type" => "Main"
            ),
        );


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function update_form($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        $settings = $this->Settings_model->get();
        $employers = $this->Company_model->get_all(array());
        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->settings = $settings;
        $viewData->employers = $employers;
        $viewData->users = $users;
        $viewData->settings = $settings;


        $viewData->item = $this->Auction_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Auction_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function save($project_id)
    {
        $settings = get_settings();

        $file_name_len = file_name_digits();
        $file_name = "IHL-" . $this->input->post('dosya_no');
        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "required|greater_than[0]|is_unique[auction.dosya_no]|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("ihale_ad", "Teklif Ad", "required|trim");
        $this->form_validation->set_rules("isveren", "İşveren", "required|trim");
        $this->form_validation->set_rules("butce", "Bütçe Bedeli", "required|trim");
        $this->form_validation->set_rules("para_birimi", "Para Birimi", "required|trim");
        $this->form_validation->set_rules("talep_tarih", "Ön Görülen Teklif Tarihi", "required|trim");
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük olmalıdır",
                "duplicate_code_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "exact_length" => "<b>{field}</b> <b>{param}</b> karakterden oluşmalıdır",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {
            $project_code = get_from_id("projects", "proje_kodu", $project_id);
            $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$file_name/main";
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }

            if ($this->input->post("talep_tarih")) {
                $talep_tarih = dateFormat('Y-m-d', $this->input->post("talep_tarih"));
            } else {
                $talep_tarih = null;
            }


            $yetkili = $this->input->post('yetkili_personeller');

            if (!empty($yetkili)) {
                $data_yetkili = implode(",", array_unique($yetkili));
            } else {
                $data_yetkili = null;
            }

            $ihale_ad = mb_convert_case($this->input->post("ihale_ad"), MB_CASE_TITLE, "UTF-8");

            $insert = $this->Auction_model->add(
                array(
                    "proje_id" => $project_id,
                    "dosya_no" => $file_name,
                    "ihale_ad" => $ihale_ad,
                    "isveren" => $this->input->post("isveren"),
                    "butce" => $this->input->post("butce"),
                    "para_birimi" => $this->input->post("para_birimi"),
                    "aciklama" => $this->input->post("aciklama"),
                    "yetkili_personeller" => $data_yetkili,
                    "talep_tarih" => $talep_tarih,

                    "durumu" => "1",
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

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Formu kontrol ediniz.",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);


            $viewData = new stdClass();
            $settings = $this->Settings_model->get();
            $employers = $this->Company_model->get_all(array());
            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->project_id = $project_id;
            $viewData->settings = $settings;
            $viewData->employers = $employers;
            $viewData->users = $users;
            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update($id)
    {
        $this->load->library("form_validation");

        $this->form_validation->set_rules("ihale_ad", "Teklif Ad", "required|trim");
        $this->form_validation->set_rules("isveren", "İşveren", "required|trim");
        $this->form_validation->set_rules("butce", "Bütçe Bedeli", "required|trim");
        $this->form_validation->set_rules("para_birimi", "Para Birimi", "required|trim");
        $this->form_validation->set_rules("talep_tarih", "Ön Görülen Teklif Tarihi", "required|trim");
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("talep_tarih")) {
                $talep_tarih = dateFormat('Y-m-d', $this->input->post("talep_tarih"));
            } else {
                $talep_tarih = null;
            }

            $yetkili = $this->input->post('yetkili_personeller');

            if (!empty($yetkili)) {
                $data_yetkili = implode(",", array_unique($yetkili));
            } else {
                $data_yetkili = null;
            }

            $ihale_ad = mb_convert_case($this->input->post("ihale_ad"), MB_CASE_TITLE, "UTF-8");

            $update = $this->Auction_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "ihale_ad" => $ihale_ad,
                    "isveren" => $this->input->post("isveren"),
                    "aciklama" => $this->input->post("aciklama"),
                    "butce" => $this->input->post("butce"),
                    "para_birimi" => $this->input->post("para_birimi"),
                    "yetkili_personeller" => $data_yetkili,
                    "talep_tarih" => $talep_tarih,
                )
            );

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
            $item = $this->Auction_model->get(
                array(
                    "id" => $id,
                )
            );


            $viewData = new stdClass();
            $employers = $this->Company_model->get_all(array());
            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));
            $yuklenici_users = $this->User_model->get_all(array(
                "user_role" => 2
            ));
            $settings = $this->Settings_model->get();
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->form_error = true;
            $viewData->item = $item;
            $viewData->settings = $settings;
            $viewData->employers = $employers;
            $viewData->users = $users;
            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete_form($error_list_id)
    {

        $viewData = new stdClass();

        $auction_id = get_from_any("delete_error", "module_id", "id", "$error_list_id");
        $project_id = project_id_auc($auction_id);
        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "delete_form";
        $viewData->auction_id = $auction_id;
        $viewData->project_id = $project_id;

        $viewData->item = $this->Delete_model->get(
            array(
                "id" => $error_list_id
            )
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);


    }

    public function delete($id)
    {
        $project_id = get_from_id("auction", "proje_id", $id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", $id);

        $cizimler = $this->Aucdraw_model->get_all(array('auction_id' => $id));
        $file_ids = array();
        foreach ($cizimler as $cizim) {
            $file_ids[] = "Aucdraw*" . $cizim->id;
        }

        $contracts = $this->Contract_model->get_all(array('auction_id' => $id));
        $file_ids = array();
        foreach ($contracts as $contract) {
            $file_ids[] = "Contract*" . $contract->id;
        }

        $metrajlar = $this->Compute_model->get_all(array('auction_id' => $id));
        foreach ($metrajlar as $metraj) {
            $file_ids[] = "Compute*" . $metraj->id;
        }


        $ymler = $this->Cost_model->get_all(array("auction_id" => $id));
        foreach ($ymler as $ym) {
            $file_ids[] = "Cost*" . $ym->id;
        }

        $tesvikler = $this->Incentive_model->get_all(array('auction_id' => $id));
        foreach ($tesvikler as $tesvik) {
            $file_ids[] = "Incentive*" . $tesvik->id;
        }

        $ilanlar = $this->Notice_model->get_all(array('auction_id' => $id));
        foreach ($ilanlar as $ilan) {
            $file_ids[] = "Notice*" . $ilan->id;
        }

        $teklifler = $this->Offer_model->get_all(array("auction_id" => $id));
        foreach ($teklifler as $teklif) {
            $file_ids[] = "Offer*" . $teklif->id;
        }

        $error_log = $this->Delete_model->get(
            array(
                "module_name" => "auction",
                "module_id" => "$id",
            )
        );

        if (!empty($file_ids)) {

            $viewData = new stdClass();

            if (isset($error_log)) {
                $update_error = $this->Delete_model->update(
                    array(
                        "id" => $error_log->id
                    ),
                    array(
                        "error_list" => json_encode($file_ids),
                    )
                );

            } else {
                $add_error = $this->Delete_model->add(
                    array(
                        "module_name" => "auction",
                        "module_id" => "$id",
                        "error_list" => json_encode($file_ids)
                    )
                );
            }

            $delete_error_id = get_from_any_and("delete_error", "module_name", "auction", "module_id", $id);

            redirect(base_url("Auction/delete_form/$delete_error_id"));

        } else {
            $viewData = new stdClass();

            $viewData->item = $this->Delete_model->delete(
                array(
                    "id" => $error_log->id
                )
            );

            $sartnameler = $this->Condition_model->delete(array('auction_id' => $id));
            $delete_auction_files = $this->Auction_file_model->delete(array("$this->Dependet_id_key" => $id));
            $delete_auction = $this->Auction_model->delete(array("id" => $id));

            $this->Favorite_model->delete(
                array(
                    "module" => "auction",
                    "module_id" => $id,
                    "user_id" => active_user_id()
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

            $path = "$this->File_Dir_Prefix/$project_code/$auction_code";

            $sil = deleteDirectory($path);


            if ($sil) {
                echo '<br>deleted successfully';
            } else {
                echo '<br>errors occured';
            }

            if ($delete_auction) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Teklif tüm alt süreçleri ile birlikte, başarılı bir şekilde silindi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Teklif silme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Parent_Name/$this->Display_route/$project_id"));
        }
    }

    public function hard_delete($id)
    {
        $project_id = get_from_id("auction", "proje_id", $id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", $id);

        $cizimler = $this->Aucdraw_model->get_all(array('auction_id' => $id));
        $metrajlar = $this->Compute_model->get_all(array('auction_id' => $id));
        $sartnameler = $this->Condition_model->get_all(array('auction_id' => $id,));
        $ymler = $this->Cost_model->get_all(array("auction_id" => $id));
        $tesvikler = $this->Incentive_model->get_all(array('auction_id' => $id));
        $ilanlar = $this->Notice_model->get_all(array('auction_id' => $id));
        $teklifler = $this->Offer_model->get_all(array("auction_id" => $id));

        $Controller_Names = array(
            "aucdraw" => $cizimler,
            "compute" => $metrajlar,
            "Condition" => $sartnameler,
            "Cost" => $ymler,
            "Incentive" => $tesvikler,
            "Notice" => $ilanlar,
            "Offer" => $teklifler
        );

        $modules = array_keys($Controller_Names);
        foreach ($modules as $module) {
            echo $module;
            $ids = get_ids_for_delete($Controller_Names["$module"]);
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $this->db->where(array("id" => $id))->delete($module);
                    $module_file = $module . "_files";
                    $module_name_id = $module . "_id";
                    $this->db->where(array($module_name_id => $id))->delete($module_file);
                    $file_order_id = get_from_any_and("file_order", "connected_auction_id", $id, "module", $module);
                    $update_file_order = $this->Order_model->update(
                        array(
                            "id" => $file_order_id
                        ),
                        array(
                            "deletedAt" => date("Y-m-d H:i:s"),
                            "deletedBy" => active_user_id(),
                        )
                    );
                }
            }
        }

        $delete_auction_files = $this->Auction_file_model->delete(array("$this->Dependet_id_key" => $id));
        $delete_auction = $this->Auction_model->delete(array("id" => $id));

        $this->Favorite_model->delete(
            array(
                "module" => "auction",
                "module_id" => $id
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

        $path = "$this->File_Dir_Prefix/$project_code/$auction_code";

        $sil = deleteDirectory($path);


        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        if ($delete_auction) {
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Teklif tüm alt süreçleri ile birlikte, başarılı bir şekilde silindi",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Teklif silme sırasında bir problem oluştu",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("$this->Module_Parent_Name/$this->Display_route/$project_id"));
    }


    public function file_upload($id, $type = null)
    {
        $auction_id = $id;
        $auction_code = auction_code($auction_id);
        $project_id = project_id_auc($auction_id);
        $project_code = project_code($project_id);
        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$auction_code/$type/";

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
                    FileUploader::resize($path . $file['name'], $newWidth,$newHeight,$destination = null, $crop = false, $quality = 75);
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($uploadedFiles);
        exit;
    }

    public function fileDelete_java($id)
    {
        $fileName = $this->input->post('fileName');

        $auction = $this->Auction_model->get(array("id"=>$id));
        $project = $this->Project_model->get(array("id"=>$auction->proje_id));
        $path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->proje_kodu/$auction->dosya_no/Main/";

        unlink("$path/$fileName");
    }


    public function download_all($auc_id, $where = null)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $project_id = project_id_auc($auc_id);
        $project_code = project_code($project_id);
        $auc_code = auction_code($auc_id);
        $auc_name = auction_name($auc_id);

        $path = "uploads/project_v/$project_code/$auc_code/$where";

        $where_types =
            array(
                'Genel' => 'main',
                'İdari Şartname' => 'Condition',
                'ISG Şartname' => 'Safety',
                'Teknik Şartname' => 'Technical',
                'Geçici Kabul' => 'provision',
                'Kesin Kabul' => 'final',
            );

        $ext = array_search($where, $where_types);


        $files = glob($path . '/*');
        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $auc_name . "_" . $ext;
        $this->zip->download("$zip_name");

    }


    public function duplicate_code_check($file_name)
    {
        $file_name = "IHL-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    public function favorite($id)
    {
        $fav_id = get_from_any_and_and("favorite", "module", "auction", "user_id", active_user_id(), "module_id", "$id");
        if (!empty($fav_id)) {
            $this->Favorite_model->delete(
                array(
                    "id" => $fav_id
                )
            );
            echo "favoriden çıktı";
        } else {
            $title = get_from_id("auction", "dosya_no", "$id");

            $insert = $this->Favorite_model->add(
                array(
                    "module" => "auction",
                    "view" => "file_form",
                    "module_id" => $id,
                    "user_id" => active_user_id(),
                    "title" => project_name(project_id_auc($id)) . " / " . auction_name($id)
                )
            );
            echo "favoriye eklendi";
        }
    }

    public function limit_cost($type, $auction_id, $value)
    {

        if ($type == "min") {
            $update = $this->Auction_model->update(
                array(
                    "id" => $auction_id
                ),
                array(
                    "min_cost" => $value
                )
            );
        } elseif ($type == "max") {
            $update = $this->Auction_model->update(
                array(
                    "id" => $auction_id
                ),
                array(
                    "max_cost" => $value
                )
            );
        }
    }

}

