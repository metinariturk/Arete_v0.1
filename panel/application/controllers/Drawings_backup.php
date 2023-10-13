<?php

class Drawings extends CI_Controller
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

        $this->moduleFolder = "contract_module";
        $this->viewFolder = "Drawings_v";
        $this->load->model("Drawings_model");
        $this->load->model("Drawings_file_model");
        $this->load->model("Contract_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->Module_Name = "Drawings";
        $this->Module_Title = "Teknik Dökümanlar";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "contract";
        $this->Module_File_Dir = "drawings";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "drawings_id";
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
        $items = $this->Drawings_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "durumu" => 1
            )
        );


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->active_contracts = $active_contracts;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function select()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Drawings_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "durumu" => 1
            )
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $viewData->active_contracts = $active_contracts;        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($from=null, $pid = null)
    {


        if ($pid == null) {
            $pid = $this->input->post("contract_id");
        }
        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Drawings_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "durumu" => 1
            )
        );
        $settings = $this->Settings_model->get();



        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->active_contracts = $active_contracts;
        $viewData->pid = $pid;
        $viewData->settings = $settings;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {

        $viewData = new stdClass();

        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->settings = $settings;


        $viewData->item = $this->Drawings_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Drawings_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $viewData->item = $this->Drawings_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Drawings_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($id)
    {

        $file_name_len = file_name_digits();
        $file_name = "TD-".$this->input->post('dosya_no');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[drawings.dosya_no]|required|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("cizim_grup", "Proje Çizim Grubu", "required|trim");
        $this->form_validation->set_rules("cizim_ad", "Çizim Ad", "required|trim");

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
            $project_id = get_from_id("contract", "proje_id",$id);
            $project_code = get_from_id("projects","proje_kodu",$project_id);
            $contract_code = get_from_id("contract","dosya_no",$id);

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
            }

            $insert = $this->Drawings_model->add(
                array(
                    "dosya_no"      => $file_name,
                    "contract_id"   => $id,
                    "cizim_grup"    => $this->input->post("cizim_grup"),
                    "cizim_ad"      => mb_convert_case(convertToSEO($this->input->post("cizim_ad")),MB_CASE_TITLE),
                    "muellif"       => $this->input->post("muellif"),
                    "kontrol"       => $this->input->post("kontrol"),
                    "onay"          => $this->input->post("onay"),
                    "aciklama"      => $this->input->post("aciklama"),
                    "createdAt"     => date("Y-m-d")
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module"                => $this->Module_Name,
                    "connected_module_id"   => $this->db->insert_id(),
                    "connected_contract_id" => $id,
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

    
        $viewData = new stdClass();
            $settings = $this->Settings_model->get();

            $viewData->settings = $settings;


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->pid = $id;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function update($id)
    {
        $this->load->library("form_validation");

        $this->form_validation->set_rules("cizim_grup", "Proje Çizim Grubu", "required|trim");
        $this->form_validation->set_rules("cizim_ad", "Çizim Ad", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $update = $this->Drawings_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "cizim_grup"    => $this->input->post("cizim_grup"),
                    "cizim_ad"      => mb_convert_case(convertToSEO($this->input->post("cizim_ad")),MB_CASE_TITLE),
                    "muellif"       => $this->input->post("muellif"),
                    "kontrol"       => $this->input->post("kontrol"),
                    "onay"          => $this->input->post("onay"),
                    "aciklama"      => $this->input->post("aciklama")
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


            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->form_error = true;
            $viewData->settings = $settings;


            $viewData->item = $this->Drawings_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Drawings_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                ),
            );

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {

        $contract_id = get_from_id("drawings", "contract_id",$id);
        $project_id = get_from_id("contract", "proje_id",$contract_id);
        $project_code = get_from_id("projects","proje_kodu",$project_id);
        $contract_code = get_from_id("contract","dosya_no",$contract_id);
        $drawings_code = get_from_id("drawings", "dosya_no",$id);

        $path = "$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$drawings_code/" ;

        $sil = deleteDirectory($path);

        if($sil) {
            echo '<br>deleted successfully';
        }
        else {
            echo '<br>errors occured';
        }

        $delete1 = $this->Drawings_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $delete2 = $this->Drawings_model->delete(
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
        redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$contract_id"));
    }

    public function file_upload($id)
    {
                $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $contract_id = get_from_id("drawings", "contract_id",$id);
        $project_id = get_from_id("contract", "proje_id",$contract_id);
        $project_code = get_from_id("projects","proje_kodu",$project_id);
        $contract_code = get_from_id("contract","dosya_no",get_from_id("drawings", "contract_id",$id));
        $drawings_code = get_from_id("drawings", "dosya_no",$id);

        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$drawings_code";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Drawings_file_model->add(
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

    public function file_download($id, $from)
    {
        $fileName = $this->Drawings_file_model->get(
            array(
                "id"    => $id
            )
        );


        $drawings_id = get_from_id("drawings_files","drawings_id", $id);
        $contract_id = get_from_id("drawings", "contract_id",$drawings_id);
        $project_id = get_from_id("contract", "proje_id",$contract_id);
        $project_code = get_from_id("projects","proje_kodu",$project_id);
        $contract_code = get_from_id("contract","dosya_no",$contract_id);
        $drawings_code = get_from_id("drawings", "dosya_no",$drawings_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$drawings_code/$fileName->img_url";

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


        $viewData->item_files = $this->Drawings_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

        echo $render_html;

    }

    public function fileDelete($id, $from){

        $fileName = $this->Drawings_file_model->get(
            array(
                "id"    => $id
            )
        );


        $drawings_id = get_from_id("drawings_files","drawings_id", $id);
        $contract_id = get_from_id("drawings", "contract_id",$drawings_id);
        $project_id = get_from_id("contract", "proje_id",$contract_id);
        $project_code = get_from_id("projects","proje_kodu",$project_id);
        $contract_code = get_from_id("contract","dosya_no",$contract_id);
        $drawings_code = get_from_id("drawings", "dosya_no",$drawings_id);

        $delete = $this->Drawings_file_model->delete(
            array(
                "id"    => $id
            )
        );

        if($delete){

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$drawings_code/$fileName->img_url";

            unlink($path);

            redirect(base_url("$this->Module_Name/$from/$drawings_id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$drawings_id"));

        }

    }

    public function fileDelete_all($id, $from){

        $contract_id = get_from_id("drawings", "contract_id",$id);
        $project_id = get_from_id("contract", "proje_id",$contract_id);
        $project_code = get_from_id("projects","proje_kodu",$project_id);
        $contract_code = get_from_id("contract","dosya_no",$contract_id);
        $drawings_code = get_from_id("drawings", "dosya_no",$id);

        $delete = $this->Drawings_file_model->delete(
            array(
                "$this->Dependet_id_key"    => $id
            )
        );

        if($delete){

            $dir_files = directory_map("$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$drawings_code");

            foreach($dir_files as $dir_file){
                unlink("$this->File_Dir_Prefix/$project_code/$contract_code/$this->File_Dir_Suffix/$drawings_code/$dir_file");
            }

            redirect(base_url("$this->Module_Name/$from/$id"));

        } else {
            redirect(base_url("$this->Module_Name/$from/$id"));

        }

    }

    public function duplicate_code_check($file_name)
    {
        $file_name = "TD-".$file_name;

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
