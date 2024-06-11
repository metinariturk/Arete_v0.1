<?php

class Notice extends CI_Controller
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
        $this->viewFolder = "notice_v";
        $this->load->model("Notice_model");
        $this->load->model("Notice_file_model");
        $this->load->model("Auction_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");

        $this->Module_Name = "Notice";
        $this->Module_Title = "Teklif Yayınlama";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "auction";
        $this->Module_File_Dir = "Notice";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Dependet_id_key = "notice_id";
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Select_Folder = "select";
        $this->File_List = "file_list_v";
        $this->Common_Files = "common";
    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Notice_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->prep_auctions = $prep_auctions;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($auc_id = null, $notice_id = null)
    {
        if ($auc_id == null) {
            $auc_id = $this->input->post("auction_id");
        }
        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Notice_model->get_all(array());
        $users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));


        if (!empty($notice_id)) {
            $notice = $this->Notice_model->get(array("id" => $notice_id));
        }

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->auc_id = $auc_id;
        $viewData->prep_auctions = $prep_auctions;

        if (!empty($notice_id)) {
            $viewData->notice = $notice;
            $viewData->notice_id = $notice_id;
        }
        $viewData->users = $users;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }


    public function file_form($id)
    {
        $viewData = new stdClass();
        $auc_id = auction_id_module($this->Module_Name, $id);
        $project_id = project_id_auc($auc_id);
        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->project_id = $project_id;

        $viewData->item = $this->Notice_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Notice_file_model->get_all(
            array(
                "notice_id" => $id,
            ),
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($auc_id)
    {
        $notice_id = $this->input->post("notice_id");

        if (!empty($notice_id)) {
            $notice_ilan = dateFormat('d-m-Y', get_from_any("notice", "ilan_tarih", "id", "$notice_id"));
            $notice_son = dateFormat('d-m-Y', get_from_any("notice", "son_tarih", "id", "$notice_id"));
        }

        if ($this->input->post("ilan_tarih")) {
            $ilan_tarih = dateFormat('Y-m-d', $this->input->post("ilan_tarih"));
        } else {
            $ilan_tarih = null;
        }
        if ($this->input->post("son_tarih")) {
            $son_tarih = dateFormat('Y-m-d', $this->input->post("son_tarih"));
        } else {
            $son_tarih = null;
        }


        $file_name_len = file_name_digits();
        $file_name = "YYN-" . $this->input->post('dosya_no');

        $sure = datetime_minus($this->input->post("son_tarih"), $this->input->post("ilan_tarih")) / 60 / 60 / 24;

        $aski_sure = $this->input->post("aski_sure");

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[Notice.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");

        if (!empty($notice_id)) {
            $this->form_validation->set_rules("ilan_tarih", "İlan Tarih", "callback_addenum_notice_day[$notice_ilan]|required|trim");
            $this->form_validation->set_rules("son_tarih", "Son Tarih", "callback_addenum_last_day[$notice_son]|required|trim");
        } else {
            $this->form_validation->set_rules("ilan_tarih", "İlan Tarih", "required|trim");
            $this->form_validation->set_rules("son_tarih", "Son Tarih", "required|trim");
        }

        if (($this->input->post('control') != "on") and (!empty($ilan_tarih)) and (!empty($son_tarih)) and ($sure != null) and ($aski_sure != null)) {
            $this->form_validation->set_rules("aski_sure", "Yayın Süresi", "integer|required|trim|callback_sure_control[$sure]");
        } else {
            $this->form_validation->set_rules("aski_sure", "Yayın Süresi", "integer|required|trim");
        }

        $this->form_validation->set_rules("onay", "Onay", "required|trim");
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı tam sayı olmalıdır",
                "addenum_notice_day" => "<b>{field}</b> alanı teklif ilan tarihi olan <b>{param} dan daha önceki bir gün olamaz</b> ",
                "addenum_last_day" => "<b>{field}</b> alanı teklif son tarihi olan <b>{param} dan daha önceki bir gün olamaz</b> ",
                "sure_control" => "<b>{field}</b> dosyayı yayında kalmasını istediğiniz süre $aski_sure gün ancak <b>{param}</b> gün teklif ilanı askıda kalmış olacak. Eğer bu şekilde yayınlanmasını istiyorsanız yandaki kutucuktan girilen bilgilerin doğru olduğunu teyit ediniz",
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
            $project_id = get_from_id("auction", "proje_id", $auc_id);
            $project_code = project_code($project_id);
            $auction_code = get_from_id("auction", "dosya_no", $auc_id);

            $path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$file_name";
            $path_cond = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$file_name/Sartnameler";
            $path_draw = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$file_name/Projeler";
            $path_paper = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$file_name/Matbu";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                mkdir("$path_cond", 0777, TRUE);
                mkdir("$path_draw", 0777, TRUE);
                mkdir("$path_paper", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            if ($this->input->post("ilan_tarih")) {
                $ilan_tarih = dateFormat('Y-m-d H:i', $this->input->post("ilan_tarih"));
            } else {
                $ilan_tarih = null;
            }

            if ($this->input->post("son_tarih")) {
                $son_tarih = dateFormat('Y-m-d H:i', $this->input->post("son_tarih"));
            } else {
                $son_tarih = null;
            }

            if ($this->input->post('auto_air') == "on") {
                $auto_air = 1;
                $isActive = 1;
            } else {
                $auto_air = 0;
                $isActive = 0;
            }

            if ($this->input->post('auto_cancel_air') == "on") {
                $auto_cancel_air = 1;
            } else {
                $auto_cancel_air = 0;
            }


            if (!empty($notice_id)) {
                $insert = $this->Notice_model->add(
                    array(
                        "dosya_no" => $file_name,
                        "auction_id" => $auc_id,
                        "ilan_tarih" => $ilan_tarih,
                        "aski_sure" => $this->input->post("aski_sure"),
                        "son_tarih" => $son_tarih,
                        "onay" => $this->input->post("onay"),
                        "aciklama" => $this->input->post("aciklama"),
                        "auto_air" => $auto_air,
                        "original_notice" => $notice_id,
                        "auto_cancel_air" => $auto_cancel_air,
                        "iletisim" => $this->input->post("iletisim"),
                        "isActive" => $isActive,
                        "createdAt" => date("Y-m-d")
                    )
                );
            } else {
                $insert = $this->Notice_model->add(
                    array(
                        "dosya_no" => $file_name,
                        "auction_id" => $auc_id,
                        "ilan_tarih" => $ilan_tarih,
                        "aski_sure" => $this->input->post("aski_sure"),
                        "son_tarih" => $son_tarih,
                        "onay" => $this->input->post("onay"),
                        "aciklama" => $this->input->post("aciklama"),
                        "auto_air" => $auto_air,
                        "auto_cancel_air" => $auto_cancel_air,
                        "iletisim" => $this->input->post("iletisim"),
                        "isActive" => $isActive,
                        "createdAt" => date("Y-m-d")
                    )
                );
            }

            $record_id = $this->db->insert_id();

            if (!empty($notice_id)) {
                $update = $this->Notice_model->update(
                    array(
                        "id" => $notice_id
                    ),
                    array(
                        "son_tarih" => $son_tarih,
                    )
                );
            }

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_project_id" => $project_id,
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
                "text" => "Form verilerinde eksik veya hatalı giriş var.",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            $viewData = new stdClass();

            $users = $this->User_model->get_all(array(
                "user_role" => 1
            ));

            if (!empty($notice_id)) {
                $notice = $this->Notice_model->get(array("id" => $notice_id));
            }
            if (!empty($notice_id)) {
                $viewData->notice = $notice;
                $viewData->notice_id = $notice_id;
            }

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->auc_id = $auc_id;
            $viewData->users = $users;
            $viewData->notice_id = $notice_id;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function delete($id)
    {

        $isActive =get_from_id("notice", "isActive", $id);

        if ($isActive != 1) {
            $auction_id = get_from_id("notice", "auction_id", $id);
            $project_id = get_from_id("auction", "proje_id", $auction_id);
            $project_code = project_code($project_id);
            $auction_code = get_from_id("auction", "dosya_no", $auction_id);
            $Notice_code = get_from_id("notice", "dosya_no", $id);

            $path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Notice_code/";

            $sil = deleteDirectory($path);

            if ($sil) {
                echo '<br>deleted successfully';
            } else {
                echo '<br>errors occured';
            }

            $delete1 = $this->Notice_file_model->delete(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );

            $delete2 = $this->Notice_model->delete(
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
            redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$auction_id"));
        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Aktif İlanı Silemezsiniz",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("notice/file_form/$id"));
        }
    }

    public function file_upload($id)
    {

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];
        $auction_id = get_from_id("notice", "auction_id", $id);

        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", get_from_id("notice", "auction_id", $id));
        $Notice_code = get_from_id("notice", "dosya_no", $id);


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Notice_code";
        $config["file_name"] = $file_name;


        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Notice_file_model->add(
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

    public function file_download($id)
    {

        $fileName = $this->Notice_file_model->get(
            array(
                "id" => $id
            )
        );


        $notice_id = get_from_id("notice_files", "notice_id", $id);
        $auction_id = get_from_id("notice", "auction_id", $notice_id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);
        $Notice_code = get_from_id("notice", "dosya_no", $notice_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Notice_code/$fileName->img_url";


        if ($fileName) {
            if (file_exists($file_path)) {
                // get file content
                $data = file_get_contents($file_path);
                //force download
                force_download("$fileName->img_url", $data);
            } else {
                echo "Dosya veritabanında var ancak klasör içinden silinmiş, SİSTEM YÖNETİCİNİZE BAŞVURUN";
            }
        } else {
            echo "Dosya Yok";
        }
    }

    public function refresh_file_list($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->item = $this->Notice_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Notice_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $fileName = $this->Notice_file_model->get(
            array(
                "id" => $id
            )
        );

        $notice_id = get_from_id("notice_files", "notice_id", $id);
        $auction_id = get_from_id("notice", "auction_id", $notice_id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = get_from_id("projects", "project_code", $project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);
        $Notice_code = get_from_id("notice", "dosya_no", $notice_id);

        $delete = $this->Notice_file_model->delete(
            array(
                "id" => $id
            )
        );

        if ($delete) {

            $path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Notice_code/$fileName->img_url";

            unlink($path);

            $viewData->item = $this->Notice_model->get(
                array(
                    "id" => $notice_id
                )
            );

            $viewData->item_files = $this->Notice_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $notice_id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/notice_v/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;


        }
    }

    public function fileDelete_all($id)
    {
        $viewData = new stdClass();


        $auction_id = get_from_id("notice", "auction_id", $id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);
        $Notice_code = get_from_id("notice", "dosya_no", $id);

        $delete = $this->Notice_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Notice_code/");

            foreach ($dir_files as $dir_file) {
                unlink("$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Notice_code/$dir_file");
            }

            $viewData->item = $this->Notice_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Notice_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );

            $render_html = $this->load->view("auction_module/notice_v/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;

        }

    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "YYN-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function sure_control($field, $param)
    {

        $fark = $field - $param;

        if (($fark == 0)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function isActiveSetter($id)
    {
        $isActive = ($this->input->post("data") === "true") ? 1 : 0;

        if ($id) {
            $this->Notice_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "isActive" => $isActive
                )
            );
        }
    }

    public function download_group($id, $type)
    {
        if ($type == 1) {
            $subdir = "Sartnameler";
        } elseif ($type == 2) {
            $subdir = "Projeler";
        } elseif ($type == 3) {
            $subdir = "Matbu";
        } elseif ($type == null) {
            $subdir = "";
        }

        $this->load->library('zip');
        $this->zip->compression_level = 0;


        $auction_id = get_from_id("notice", "auction_id", $id);
        $project_id = get_from_id("auction", "proje_id", $auction_id);
        $project_code = project_code($project_id);
        $auction_code = get_from_id("auction", "dosya_no", $auction_id);
        $auction_name = get_from_id("auction", "ihale_ad", $auction_id);
        $Notice_code = get_from_id("notice", "dosya_no", $id);


        $path = "$this->File_Dir_Prefix/$project_code/$auction_code/$this->File_Dir_Suffix/$Notice_code/$subdir";

        $files = glob($path . '/*');
        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $subdir . "-" . $auction_name;
        $this->zip->download("$zip_name");

    }

    public function download_all($notice_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $auction = get_from_id("Notice", "auction_id", "$notice_id");
        $Notice_code = get_from_id("Notice", "dosya_no", "$notice_id");
        $project_id = project_id_auc($auction);
        $project_code = project_code($project_id);
        $auction_code = auction_code($auction);
        $auction_name = auction_name($auction);

        $path = "uploads/project_v/$project_code/$auction_code/Notice/$Notice_code";
        echo $path;
        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $auction_name . "-" . $Notice_code;
        $this->zip->download("$zip_name");
    }

    public function addenum_notice_day($notice, $addenum)
    {
        $date_diff = date_minus($notice, $addenum);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function addenum_last_day($notice, $addenum)
    {
        $date_diff = date_minus($notice, $addenum);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
