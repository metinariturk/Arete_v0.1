<?php

class Condition extends CI_Controller
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

        $this->moduleFolder = "auction_module";
        $this->viewFolder = "condition_v";
        $this->load->model("Condition_model");
        $this->load->model("Auction_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");

        $this->Module_Name = "Condition";
        $this->Module_Title = "Şartname";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "auction";
        $this->Module_File_Dir = "Condition";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "cond_id";
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
        $items = $this->Condition_model->get_all(array());
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
        $items = $this->Condition_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $viewData->prep_auctions = $prep_auctions;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($auc_id = null)
    {

        if ($auc_id == null) {
            $auc_id = $this->input->post("auction_id");
        }

        if (isset($auc_id)) {
            $project_id = project_id_auc($auc_id);
        }


        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Condition_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));
        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        if (isset($auc_id)) {
            $viewData->project_id = $project_id;
        }
        $viewData->prep_auctions = $prep_auctions;
        $viewData->auc_id = $auc_id;
        $viewData->users = $users;
        $viewData->settings = $settings;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {

        $viewData = new stdClass();

        $auc_id = auction_id_module($this->Module_Name, $id);
        $project_id = project_id_auc($auc_id);

        $viewData->project_id = $project_id;

        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->users = $users;
        $viewData->project_id = $project_id;
        $viewData->settings = $settings;


        $viewData->item = $this->Condition_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $auc_id = auction_id_module($this->Module_Name, $id);
        $project_id = project_id_auc($auc_id);

        $viewData->item = $this->Condition_model->get(
            array(
                "id" => $id
            )
        );
        $viewData->project_id = $project_id;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($auc_id)
    {
        $auction_code = auction_code($auc_id);
        $project_id = project_id_auc($auc_id);
        $project_code = get_from_id("projects", "proje_kodu", $project_id);

        $this->load->library("form_validation");

        $this->form_validation->set_rules("fiyat_fark", "Fiyat Farkı", "required|trim");
        $this->form_validation->set_rules("isin_turu", "İşin Türü", "required|trim");
        $this->form_validation->set_rules("teklif_turu", "Teklif Türü", "required|trim");
        $this->form_validation->set_rules("isin_suresi", "İşin Süresi", "greater_than[0]|required|trim|integer");
        $this->form_validation->set_rules("is_bitirme", "İş Bitirme Kriteri", "greater_than[0]|trim|numeric");
        if (($this->input->post('is_bitirme')) > 0) {
            $this->form_validation->set_rules("para_birimi", "Para Birimi", "required|trim");
        }

        $this->form_validation->set_rules("benzer_is", "Benzer İş", "trim");
        $this->form_validation->set_rules("muteahhit_sinif", "Müteahhitlik Sınıfı", "trim");


        $this->form_validation->set_rules("kdv_oran", "KDV Oran", "trim|numeric|required");
        if (($this->input->post('kdv_oran')) > 0) {
            $this->form_validation->set_rules("tevkifat_oran", "Tevkifat Oran", "trim|required");
        }
        $this->form_validation->set_rules("damga_oran", "Damga Oran", "trim|numeric|required");
        $this->form_validation->set_rules("stopaj_oran", "Stopaj Oran", "trim|numeric|required");
        $this->form_validation->set_rules("avans_durum", "Avans Durum", "trim|numeric|required|less_than_equal_to[1]");

        if (($this->input->post('avans_mahsup_durum')) == 1) {
            $this->form_validation->set_rules("avans_mahsup_oran", "Avans Mahsup Oranı", "greater_than_equal_to[0]|trim|numeric|required");
        }
        $this->form_validation->set_rules("fiyat_fark", "Fiyat Fark", "less_than_equal_to[1]|trim|numeric|required");

        $this->form_validation->set_rules("ihzarat", "İhzarat", "trim|numeric|required|less_than_equal_to[1]");

        $this->form_validation->set_rules("teminat_oran", "Teminat Oran", "trim|numeric|required");
        $this->form_validation->set_rules("gecici_kabul_kesinti", "Geçici Kabul Kesinti", "trim|numeric|required|less_than_equal_to[1]");

        $this->form_validation->set_rules("onay", "Evrakları İnceleyen", "trim|numeric|required");
        $this->form_validation->set_rules("aciklama", "Açıklama", "trim|required");


        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "in_list" => "Avans olmadığı için <b>{field}</b> alanı <b>{param}</b> olmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "less_than_equal_to" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );

        $validate = $this->form_validation->run();
        $errors = $this->form_validation->error_array();


        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project_code/$auction_code/Condition";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            $insert = $this->Condition_model->add(
                array(
                    "auction_id" => $auc_id,
                    "teklif_turu" => $this->input->post("teklif_turu"),
                    "isin_turu" => $this->input->post("isin_turu"),
                    "isin_suresi" => $this->input->post("isin_suresi"),
                    "is_bitirme" => $this->input->post("is_bitirme"),
                    "para_birimi" => $this->input->post("para_birimi"),
                    "benzer_is" => $this->input->post("benzer_is"),
                    "muteahhit_sinif" => $this->input->post("muteahhit_sinif"),
                    "kdv_oran" => $this->input->post("kdv_oran"),
                    "tevkifat_oran" => $this->input->post("tevkifat_oran"),
                    "damga_oran" => $this->input->post("damga_oran"),
                    "stopaj_oran" => $this->input->post("stopaj_oran"),
                    "avans_durum" => $this->input->post("avans_durum"),
                    "avans_mahsup_oran" => $this->input->post("avans_mahsup_oran"),
                    "ihzarat" => $this->input->post("ihzarat"),
                    "fiyat_fark" => $this->input->post("fiyat_fark"),
                    "teminat_oran" => $this->input->post("teminat_oran"),
                    "gecici_kabul_kesinti" => $this->input->post("gecici_kabul_kesinti"),

                    "onay" => $this->input->post("onay"),
                    "aciklama" => $this->input->post("aciklama"),

                    "createdAt" => date("Y-m-d")
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_project_id" => $auc_id,
                    "connected_auction_id" => $project_id,
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

            $viewData->settings = $settings;
            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->auc_id = $auc_id;
            $viewData->users = $users;
            $viewData->project_id = $project_id;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function update($id)
    {
        $auc_id = auction_id_module($this->Module_Name, $id);
        $project_id = project_id_auc($auc_id);

        $this->load->library("form_validation");


        $this->form_validation->set_rules("fiyat_fark", "Fiyat Farkı", "required|trim");
        $this->form_validation->set_rules("isin_turu", "İşin Türü", "required|trim");
        $this->form_validation->set_rules("teklif_turu", "Teklif Türü", "required|trim");
        $this->form_validation->set_rules("isin_suresi", "İşin Süresi", "greater_than[0]|required|trim|integer");
        $this->form_validation->set_rules("is_bitirme", "İş Bitirme Kriteri", "greater_than[0]|trim|numeric");
        if (($this->input->post('is_bitirme')) > 0) {
            $this->form_validation->set_rules("para_birimi", "Para Birimi", "required|trim");
        }

        $this->form_validation->set_rules("benzer_is", "Benzer İş", "trim");
        $this->form_validation->set_rules("muteahhit_sinif", "Müteahhitlik Sınıfı", "trim");


        $this->form_validation->set_rules("kdv_oran", "KDV Oran", "trim|numeric|required");
        if (($this->input->post('kdv_oran')) > 0) {
            $this->form_validation->set_rules("tevkifat_oran", "Tevkifat Oran", "trim|required");
        }
        $this->form_validation->set_rules("damga_oran", "Damga Oran", "trim|numeric|required");
        $this->form_validation->set_rules("stopaj_oran", "Stopaj Oran", "trim|numeric|required");
        $this->form_validation->set_rules("avans_durum", "Avans Durum", "trim|numeric|required|less_than_equal_to[1]");

        if (($this->input->post('avans_mahsup_durum')) == 1) {
            $this->form_validation->set_rules("avans_mahsup_oran", "Avans Mahsup Oranı", "greater_than_equal_to[0]|trim|numeric|required");
        }
        $this->form_validation->set_rules("fiyat_fark", "Fiyat Fark", "less_than_equal_to[1]|trim|numeric|required");

        $this->form_validation->set_rules("ihzarat", "İhzarat", "trim|numeric|required|less_than_equal_to[1]");

        $this->form_validation->set_rules("teminat_oran", "Teminat Oran", "trim|numeric|required");
        $this->form_validation->set_rules("gecici_kabul_kesinti", "Geçici Kabul Kesinti", "trim|numeric|required|less_than_equal_to[1]");

        $this->form_validation->set_rules("onay", "Evrakları İnceleyen", "trim|numeric|required");
        $this->form_validation->set_rules("aciklama", "Açıklama", "trim|required");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "less_than_equal_to" => "<b>{field}</b> alanı doldurulmalıdır",

            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $update = $this->Condition_model->update(
                array(
                    "id" => $id
                ),
                array(

                    "teklif_turu" => $this->input->post("teklif_turu"),
                    "isin_turu" => $this->input->post("isin_turu"),
                    "isin_suresi" => $this->input->post("isin_suresi"),
                    "is_bitirme" => $this->input->post("is_bitirme"),
                    "para_birimi" => $this->input->post("para_birimi"),
                    "benzer_is" => $this->input->post("benzer_is"),
                    "muteahhit_sinif" => $this->input->post("muteahhit_sinif"),
                    "kdv_oran" => $this->input->post("kdv_oran"),
                    "tevkifat_oran" => $this->input->post("tevkifat_oran"),
                    "damga_oran" => $this->input->post("damga_oran"),
                    "stopaj_oran" => $this->input->post("stopaj_oran"),
                    "avans_durum" => $this->input->post("avans_durum"),
                    "avans_mahsup_oran" => $this->input->post("avans_mahsup_oran"),
                    "ihzarat" => $this->input->post("ihzarat"),
                    "fiyat_fark" => $this->input->post("fiyat_fark"),
                    "teminat_oran" => $this->input->post("teminat_oran"),
                    "gecici_kabul_kesinti" => $this->input->post("gecici_kabul_kesinti"),

                    "onay" => $this->input->post("onay"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );

            $record_id = $this->db->insert_id();

            $file_order_id = get_from_any_and("file_order", "connected_auction_id", $auc_id, "module", $this->Module_Name);

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
            $val_err = validation_errors();
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Bazı Bilgi Girişlerinde Hata Oluştu",
                "type" => "danger"
            );

            $this->session->set_flashdata("alert", $alert);

            $viewData = new stdClass();

            $settings = $this->Settings_model->get();
            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->form_error = true;
            $viewData->settings = $settings;
            $viewData->project_id = $project_id;
            $viewData->auc_id = $auc_id;
            $viewData->val_err = $val_err;
            $viewData->users = $users;

            $viewData->item = $this->Condition_model->get(
                array(
                    "id" => $id
                )
            );


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {
        $auction_id = auction_id_module("Condition", "$id");
        $auction_code = auction_code($auction_id);
        $project_id = project_id_auc($auction_id);
        $project_code = project_code($project_id);

        $path = "$this->File_Dir_Prefix/$project_code/$auction_code/Condition";

        $sil = deleteDirectory($path);

        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        $delete = $this->Condition_model->delete(
            array(
                "id" => $id
            )
        );

        $file_order_id = get_from_any_and("file_order", "connected_auction_id", $auction_id, "module", $this->Module_Name);

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
        if ($delete) {
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
        redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$auction_id"));
    }

}
