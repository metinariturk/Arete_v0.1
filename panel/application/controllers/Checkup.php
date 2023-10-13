<?php

class Checkup extends CI_Controller
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

        $this->moduleFolder = "safety_module";
        $this->viewFolder = "checkup_v";
        $this->load->model("Checkup_model");
        $this->load->model("Checkup_file_model");
        $this->load->model("Auction_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("User_model");
        $this->load->model("Workman_model");

        $this->Module_Name = "Checkup";
        $this->Module_Title = "İSG Sağlık Raporuler";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "workman";
        $this->Module_File_Dir = "Checkup";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "checkup_id";
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
        $items = $this->Checkup_model->get_all(array());

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function select()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Checkup_model->get_all(array());
        $prep_auctions = $this->Auction_model->get_all(array('durumu' => 0));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $viewData->prep_auctions = $prep_auctions;        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($wid = null, $ckp_type = null)
    {

        if ($wid == null) {
            $wid = $this->input->post("worker_id");
        }
        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Checkup_model->get_all(array());
$users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $worker = $this->Workman_model->get(array('id' => $wid));
        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->wid = $wid;
        $viewData->ckp_type = $ckp_type;
        $viewData->users = $users;
        $viewData->worker = $worker;
        $viewData->settings = $settings;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function save($id)
    {

        $file_name_len = file_name_digits();
        $file_name = "CKP-".$this->input->post('dosya_no');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[checkup.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("belge_no", "Belge/Rapor Numarası", "required|trim");
        $this->form_validation->set_rules("checkup_turu", "Sağlık Raporu Türü", "required|trim");
        $this->form_validation->set_rules("checkup_tarihi", "Raport Tarihi", "required|trim");
        $this->form_validation->set_rules("gecerlilik_sure", "Geçerlilik Süresi", "required|trim");
        $this->form_validation->set_rules("rapor_duzenleyen", "Raporu Düzenleyen", "required|trim");
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "greater_than"  => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "exact_length"  => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "duplicate_code_check"  => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",

            )
        );
        $validate = $this->form_validation->run();

        if ($validate) {

            $site_id = get_from_id("workman","site_id","$id");
            $contract_id = get_from_id("site","contract_id","$site_id");
            $site_code = get_from_id("site","dosya_no","$site_id");
            $safety_id = get_from_id("workman","safety_id","$id");
            $safety_code = get_from_id("safety","dosya_no","$safety_id");
            $personel_folder = convertToSEO(worker_name($id));

            if ($contract_id == 0) {
                $contract_id = $this->input->post('contract_id');
                $project_id = get_from_id("site", "proje_id", $site_id);
                $project_code = project_code($project_id);
                $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$file_name";
            } else {
                $project_id = project_id_cont($contract_id);
                $contract_code = get_from_id("contract", "dosya_no", $contract_id);
                $project_code = project_code($project_id);
                $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$file_name";
            }

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            $checkup_tarihi = dateFormat('Y-m-d', $this->input->post("checkup_tarihi"));
            $gecerlilik_tarihi = date_plus_days($this->input->post("checkup_tarihi"), $this->input->post("gecerlilik_sure"));

            $safety_id = get_from_id("workman","safety_id","$id");
            $site_id = get_from_id("safety","site_id","$safety_id");

            $insert = $this->Checkup_model->add(
                array(
                    "worker_id"         => $id,
                    "safety_id"         => $safety_id,
                    "site_id"           => $site_id,
                    "dosya_no"          => $file_name,
                    "belge_no"          => $this->input->post("belge_no"),
                    "checkup_turu"      => $this->input->post("checkup_turu"),
                    "checkup_tarihi"    => $checkup_tarihi,
                    "gecerlilik_tarihi" => dateFormat('Y-m-d',"$gecerlilik_tarihi"),
                    "rapor_duzenleyen"  => $this->input->post("rapor_duzenleyen"),
                    "aciklama"          => $this->input->post("aciklama"),
                    "etiketler"         => $this->input->post("etiketler"),
                    "createdAt"         => date("Y-m-d")
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module"                => $this->Module_Name,
                    "connected_module_id"   => $this->db->insert_id(),
                    "connected_project_id" => $id,
                    "file_order"            => $file_name,
                    "createdAt"             => date("Y-m-d H:i:s"),
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
$users = $this->User_model->get_all(array(
            "user_role" => 1
        ));

            $viewData->settings = $settings;


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->users = $users;
            $viewData->wid = $id;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function update_form($id)
    {

        $viewData = new stdClass();

$users = $this->User_model->get_all(array(
            "user_role" => 1
        ));
        $settings = $this->Settings_model->get();




        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->users = $users;
        $viewData->settings = $settings;




        $viewData->item = $this->Checkup_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Checkup_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update($id)
    {
        $this->load->library("form_validation");

        $this->form_validation->set_rules("belge_no", "Belge/Rapor Numarası", "required|trim");
        $this->form_validation->set_rules("checkup_turu", "Sağlık Raporu Türü", "required|trim");
        $this->form_validation->set_rules("checkup_tarihi", "Sağlık Raporunun Verildiği Tarih", "required|trim");
        $this->form_validation->set_rules("gecerlilik_suresi", "Geçerlilik Süresi", "numeric|required|trim");
        $this->form_validation->set_rules("rapor_duzenleyen", "Tespit Yapan", "required|trim");
        $this->form_validation->set_rules("etiketler", "Tespit Yapan", "required|trim");
        $this->form_validation->set_rules("aciklama", "Tespit Yapan", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
            )
        );
        $validate = $this->form_validation->run();

        $checkup_tarihi = dateFormat('Y-m-d', $this->input->post("checkup_tarihi"));
        $gecerlilik_tarihi = date_plus_days($this->input->post("checkup_tarihi"), $this->input->post("gecerlilik_suresi"));

        if ($validate) {

            $update = $this->Checkup_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "belge_no"              => $this->input->post("belge_no"),
                    "checkup_turu"          => $this->input->post("checkup_turu"),
                    "checkup_tarihi"        => $checkup_tarihi,
                    "gecerlilik_tarihi"     => dateFormat('Y-m-d',"$gecerlilik_tarihi"),
                    "rapor_duzenleyen"      => $this->input->post("rapor_duzenleyen"),
                    "etiketler"             => $this->input->post("etiketler"),
                    "aciklama"              => $this->input->post("aciklama"),
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
            $viewData->users = $users;


            $viewData->item = $this->Checkup_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Checkup_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                ),
            );

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $viewData->item = $this->Checkup_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Checkup_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function delete($id)
    {

        echo $id;

        $worker_id = get_from_id("checkup","worker_id",$id);
        $checkup_code = get_from_id("checkup","dosya_no","$id");
        $site_id = get_from_id("checkup","site_id","$id");
        $contract_id = get_from_id("site","contract_id","$site_id");
        $site_code = get_from_id("site","dosya_no","$site_id");
        $safety_id = get_from_id("checkup","safety_id","$id");
        $safety_code = get_from_id("safety","dosya_no","$safety_id");
        $personel_folder = convertToSEO(worker_name($worker_id));


        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$checkup_code";
        } else {
            $project_id = project_id_cont($contract_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$checkup_code";
        }

        $sil = deleteDirectory($path);

        if($sil) {
            echo '<br>deleted successfully';
        }
        else {
            echo '<br>errors occured';
        }

        $delete1 = $this->Checkup_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $delete2 = $this->Checkup_model->delete(
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
        redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$worker_id/3"));
    }

    public function file_upload($id)
    {
                $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $checkup_code = get_from_id("checkup","dosya_no","$id");
        $site_id = get_from_id("checkup","site_id","$id");
        $contract_id = get_from_id("site","contract_id","$site_id");
        $site_code = get_from_id("site","dosya_no","$site_id");
        $safety_id = get_from_id("checkup","safety_id","$id");
        $safety_code = get_from_id("safety","dosya_no","$safety_id");
        $worman_id = get_from_id("checkup","worker_id","$id");
        $personel_folder = convertToSEO(worker_name($worman_id));


        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$checkup_code";
        } else {
            $project_id = project_id_cont($contract_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$checkup_code";
        }


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$path";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Checkup_file_model->add(
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
            echo  $config["upload_path"];
        }
    }

    public function file_download($id)
    {
        $fileName = $this->Checkup_file_model->get(
            array(
                "id"    => $id
            )
        );

        $checkup_id= $fileName->checkup_id;

        $checkup_code = get_from_id("checkup","dosya_no","$checkup_id");
        $site_id = get_from_id("checkup","site_id","$checkup_id");
        $contract_id = get_from_id("site","contract_id","$site_id");
        $site_code = get_from_id("site","dosya_no","$site_id");
        $safety_id = get_from_id("checkup","safety_id","$checkup_id");
        $safety_code = get_from_id("safety","dosya_no","$safety_id");
        $worman_id = get_from_id("checkup","worker_id","$checkup_id");
        $personel_folder = convertToSEO(worker_name($worman_id));


        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$checkup_code";
        } else {
            $project_id = project_id_cont($contract_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$checkup_code";
        }

        $file_path = "$path/$fileName->img_url";

        if ($file_path) {

            if (file_exists($file_path)) {
                $data = file_get_contents($file_path);
                force_download($fileName->img_url, $data); }
            else {
                echo "Dosya veritabanında var ancak klasör içinden silinmiş, SİSTEM YÖNETİCİNİZE BAŞVURUN";
            }
        }
        else {
            echo "Dosya Yok";
        }

    }

    public function refresh_file_list($id, $from)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$from";


        $viewData->item_files = $this->Checkup_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id, $from){

        $fileName = $this->Checkup_file_model->get(
            array(
                "id"    => $id
            )
        );

        $checkup_id= $fileName->checkup_id;

        $checkup_code = get_from_id("checkup","dosya_no","$checkup_id");
        $site_id = get_from_id("checkup","site_id","$checkup_id");
        $contract_id = get_from_id("site","contract_id","$site_id");
        $site_code = get_from_id("site","dosya_no","$site_id");
        $safety_id = get_from_id("checkup","safety_id","$checkup_id");
        $safety_code = get_from_id("safety","dosya_no","$safety_id");
        $worman_id = get_from_id("checkup","worker_id","$checkup_id");
        $personel_folder = convertToSEO(worker_name($worman_id));


        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$checkup_code/$fileName->img_url";
        } else {
            $project_id = project_id_cont($contract_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$checkup_code/$fileName->img_url";
        }


        $delete = $this->Checkup_file_model->delete(
            array(
                "id"    => $id
            )
        );

        if($delete){

            unlink($path);

            redirect(base_url("$this->Module_Name/$from/$checkup_id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$checkup_id"));

        }

    }

    public function fileDelete_all($id, $from){

        $checkup_code = get_from_id("checkup","dosya_no","$id");
        $site_id = get_from_id("checkup","site_id","$id");
        $contract_id = get_from_id("site","contract_id","$site_id");
        $site_code = get_from_id("site","dosya_no","$site_id");
        $safety_id = get_from_id("checkup","safety_id","$id");
        $safety_code = get_from_id("safety","dosya_no","$safety_id");
        $worman_id = get_from_id("checkup","worker_id","$id");
        $personel_folder = convertToSEO(worker_name($worman_id));


        if ($contract_id == 0) {
            $project_id = get_from_id("site", "proje_id", $site_id);
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$checkup_code";
        } else {
            $project_id = project_id_cont($contract_id);
            $contract_code = get_from_id("contract", "dosya_no", $contract_id);
            $project_code = project_code($project_id);
            $path = "$this->Upload_Folder/project_v/$project_code/$contract_code/site/$site_code/safety/$safety_code/personel/$personel_folder/checkups/$checkup_code";
        }


        $delete = $this->Checkup_file_model->delete(
            array(
                "$this->Dependet_id_key"    => $id
            )
        );

        if($delete){

            $dir_files = directory_map("$path");

            foreach($dir_files as $dir_file){
                unlink("$path/$dir_file");
            }

            redirect(base_url("$this->Module_Name/$from/$id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$id"));

        }

    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "CKP-".$file_name;

        $var = count_data("file_order","file_order",$file_name);
        if (($var > 0))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}
