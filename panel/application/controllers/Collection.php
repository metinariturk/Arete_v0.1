<?php

class Collection extends CI_Controller
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

        $this->moduleFolder = "contract_module";
        $this->viewFolder = "collection_v";
        $this->load->model("Contract_model");
        $this->load->model("Collection_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");

        $this->Module_Name = "collection";
        $this->Module_Title = "Tahsilat";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "contract";
        $this->Module_File_Dir = "collection";
        $this->Module_Table = "collection";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "collection_id";
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";
        
        $this->Common_Files = "common";
    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Collection_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "isACtive" => 1
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

    public function new_form($contract_id = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        if ($contract_id == null) {
            $contract_id = $this->input->post("contract_id");
        }

        $active_contracts = $this->Contract_model->get_all(array(
                "isActive" => 1
            )
        );

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */

        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->active_contracts = $active_contracts;
        if ((!empty($this->input->post("contract_id"))) or !empty($contract_id)) {
            $viewData->project_id = project_id_cont($contract_id);
        }
        $viewData->contract_id = $contract_id;
        $viewData->settings = $settings;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_form($id)
    {

        $contract_id = contract_id_module("collection", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = project_id_cont("$contract_id");

        $viewData = new stdClass();
        $settings = $this->Settings_model->get();


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;
        $viewData->settings = $settings;

        $viewData->item = $this->Collection_model->get(
            array(
                "id" => $id
            )
        );

        
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);


    }

    public function file_form($id)
    {

        $contract_id = contract_id_module("collection", $id);

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = project_id_cont("$contract_id");

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $viewData->item = $this->Collection_model->get(
            array(
                "id" => $id
            )
        );

        

        $viewData->contract_id = $contract_id;
        $viewData->project_id = $project_id;


        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($contract_id)
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $this->load->library("form_validation");

        $file_name_len = file_name_digits();
        $file_name = "TA-" . $this->input->post('dosya_no');

        $contract_price = get_from_id("contract", "sozlesme_bedel", $contract_id);
        $sozlesme_tarih = dateFormat_dmy(get_from_any("contract", "sozlesme_tarih", "id", "$contract_id"));

        $this->form_validation->set_rules("dosya_no", "Dosya No", "is_unique[collection.dosya_no]|exact_length[$file_name_len]|trim|callback_duplicate_code_check"); //2
        $this->form_validation->set_rules("tahsilat_tarih", "Tahsilat Tarihi", "callback_contract_collection[$sozlesme_tarih]|required|trim");
        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_collection[$sozlesme_tarih]|trim");
        }
        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "less_than_equal_to[$contract_price]|numeric|required|trim");
        } else {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "contract_collection" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
                "exact_length" => "<b>{field}</b> en az $file_name_len karakter uzunluğunda, rakamlardan oluşmalıdır.
                                           <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.
                                           <br> Özel bir gerekçe yoksa değiştirmeyiniz.",
                "duplicate_name_check" => "<b>{field}</b> $file_name daha önce kullanılmış.
                                            <br> Sistem sıradaki dosya numarasını otomatik atamaktadır.<br> Özel bir gerekçe yoksa değiştirmeyiniz.",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $project_id = project_id_cont("$contract_id");
            $project_code = project_code("$project_id");
            $contract_code = contract_code($contract_id);

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Collection/$file_name";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "oluştu";
            } else {
                echo "aynı isimde dosya mevcut";
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
                    "dosya_no" => $file_name,
                    "contract_id" => $contract_id,
                    "tahsilat_tarih" => $tahsilat_tarihi,
                    "vade_tarih" => $vade_tarihi,
                    "tahsilat_miktar" => $this->input->post("tahsilat_miktar"),
                    "tahsilat_turu" => $this->input->post("tahsilat_turu"),
                    "aciklama" => $this->input->post("aciklama"),
                )
            );
            $record_id = $this->db->insert_id();
            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_contract_id" => $contract_id,
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
            //kaydedilen elemanın id nosunu döküman ekleme
            // sına post ediyoruz
        } else {

            $viewData = new stdClass();

            $project_id = project_id_cont("$contract_id");

            $viewData->contract_id = $contract_id;
            $viewData->project_id = $project_id;
            $settings = $this->Settings_model->get();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->contract_id = $contract_id;
            $viewData->project_id = $project_id;
            $viewData->settings = $settings;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update($id)
    {

        $this->load->library("form_validation");

        $contract_id = contract_id_module("collection", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $contract_id = contract_id_module("collection", $id);
        $contract_price = get_from_id("contract", "sozlesme_bedel", $contract_id);

        $sozlesme_tarihi = dateFormat('d-m-Y', get_from_any("contract", "sozlesme_tarih", "id", "$contract_id"));


        $this->form_validation->set_rules("dosya_no", "Dosya No", "is_unique[collection.dosya_no]|exact_length[$file_name_len]|trim|callback_duplicate_code_check"); //2
        $this->form_validation->set_rules("tahsilat_tarih", "Tahsilat Tarihi", "callback_contract_collection[$sozlesme_tarih]|required|trim");
        if (!empty($this->input->post('vade_tarih'))) {
            $this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_collection[$sozlesme_tarih]|trim");
        }
        if ($this->input->post('onay') != "on") {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "less_than_equal_to[$contract_price]|numeric|required|trim");
        } else {
            $this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "numeric|required|trim");
        }
        $this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "contract_collection" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
                "is_natural_no_zero" => "<b>{field}</b> alanı '0' dan farklı bir tamsayı olmalıdır",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
                "is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

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
                    "id" => $id
                ),
                array(
                    "tahsilat_tarih" => $tahsilat_tarihi,
                    "vade_tarih" => $vade_tarihi,
                    "tahsilat_miktar" => $this->input->post("tahsilat_miktar"),
                    "tahsilat_turu" => $this->input->post("tahsilat_turu"),
                    "aciklama" => $this->input->post("aciklama"),
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


            $viewData = new stdClass();
            $contract_id = contract_id_module("collection", $id);
            $project_id = project_id_cont("$contract_id");


            /** Tablodan Verilerin Getirilmesi.. */



            $settings = $this->Settings_model->get();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->form_error = true;

            $viewData->settings = $settings;

            $viewData->item = $this->Collection_model->get(
                array(
                    "id" => $id
                )
            );

            

            $viewData->contract_id = $contract_id;
            $viewData->project_id = $project_id;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {
        //Bağlı teminat silme işlemleri
        $contract_id = contract_id_module("collection", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);

        $file_order_id = get_from_any_and("file_order", "connected_module_id", $id, "module", $this->Module_Name);
        $collection_code = get_from_id("collection", "dosya_no", $id);

        $collection_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Collection/$collection_code/";

        $sil_collection = deleteDirectory($collection_path);

        if ($sil_collection) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>Hata Oluştu';
        }

        $update_file_order = $this->Order_model->update(
            array("id" => $file_order_id),
            array("deletedAt" => date("Y-m-d H:i:s"),
                "deletedBy" => active_user_id(),
            )
        );



        $delete_collection = $this->Collection_model->delete(
            array("id" => $id)
        );

        // TODO Alert Sistemi Eklenecek...
        if ($update_file_order and $delete_collection) {

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

        $contract_id = contract_id_module("collection", $id);
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $collection_code = get_from_id("collection", "dosya_no", $id);


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$contract_code/Collection/$collection_code";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");




        } else {
            echo "islem basarisiz";
            echo $config["upload_path"];
        }

    }


    public function download_all($collection_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $contract_id = get_from_id("collection", "contract_id", "$collection_id");
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $collection_code = get_from_id("collection", "dosya_no", "$collection_id");
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $contract_name = contract_name($contract_id);

        $path = "uploads/project_v/$project_code/$contract_code/Collection/$collection_code";
        echo $path;

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $contract_name . "-" . $collection_code;
        $this->zip->download("$zip_name");

    }






    public function duplicate_code_check($file_name)
    {
        $file_name = "TA-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
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

    function print($collection_id, $P_or_D = null)
    {
        $this->load->model("Company_model");

        $collection = $this->Collection_model->get(array("id" => $collection_id));

        $viewData = new stdClass();

        $contract = $this->Contract_model->get(array("id" => $collection->contract_id));

        $viewData->contract = $contract;

        $contractor = $this->Company_model->get(array("id" => $contract->yuklenici));


        $this->load->library('pdf_creator');


        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->addTOCPage('L',"A5");

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

// Metin eklemek (örnek olarak ilk satır)
        $pdf->SetY(19);
        $pdf->SetFont('dejavusans', 'B', 17);

        $pdf->Cell(0, 10, 'Tahsilat Makbuzu', 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetY(35);

        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->Cell(160, 6, "Tahsilat Tarihi", 0, 0, "R", 0);
        $pdf->Cell(5, 6, ':', 0, 0, "C", 0);
        $pdf->SetFont('dejavusans', 'N', 9);
        $pdf->Cell(20, 6, dateFormat_dmy($collection->tahsilat_tarih), 0, 0, "R", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->Cell(160, 6, "Tahsilat No", 0, 0, "R", 0);
        $pdf->Cell(5, 6, ':', 0, 0, "C", 0);
        $pdf->SetFont('dejavusans', 'N', 9);
        $pdf->Cell(20, 6, "$collection->dosya_no", 0, 0, "R", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->Ln(); // Yeni satıra geç


        $pdf->SetY(35); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->Cell(10, 6, "", 0, 0, "R", 0);
        $pdf->Cell(35, 6, "Ödeyen Firma : ", 0, 0, "L", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'N', 9);
        $pdf->Cell(10, 6,"", 0, 0, "L", 0);
        $pdf->Cell(80, 6,company_name($contract->isveren), 0, 1, "L", 0);

        $pdf->SetCellPaddings("", 1);

        $pdf->SetY(60);
        $pdf->SetLineWidth(0.1); // Çizgi kalınlığı (ince çizgi)
        $pdf->SetFont('dejavusans', 'B', 8);
        $pdf->MultiCell(10, 8, "", 0, "C", 0, 0);
        $pdf->MultiCell(30, 8, "Ödeme Türü", 1, "C", 0, 0);
        $pdf->MultiCell(30, 8, "Tahsilat Miktar", 1, "C", 0, 0);
        $pdf->MultiCell(20, 8, "Vade Tarih", 1, "C", 0, 0);
        $pdf->MultiCell(20, 8, "Vade", 1, "C", 0, 0);
        $pdf->MultiCell(70, 8, "Açıklama", 1, "C", 0, 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetLineWidth(0.1); // Çizgi kalınlığı (ince çizgi)
        $pdf->SetFont('dejavusans', "", 8);
        $pdf->MultiCell(10, 5, "", 0, "C", 0, 0);
        $pdf->MultiCell(30, 5, "$collection->tahsilat_turu", 1, "L", 0, 0);
        $pdf->MultiCell(30, 5, money_format($collection->tahsilat_miktar), 1, "C", 0, 0);
        $pdf->MultiCell(20, 5, dateFormat_dmy($collection->vade_tarih), 1, "C", 0, 0);
        $pdf->MultiCell(20, 5, dateDifference($collection->tahsilat_tarih,$collection->vade_tarih)." Gün", 1, "C", 0, 0);
        $pdf->MultiCell(70, 5, $collection->aciklama, 1, "L", 0, 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetLineWidth(0.1); // Çizgi kalınlığı (ince çizgi)
        $pdf->SetFont('dejavusans', "", 8);
        $pdf->MultiCell(10, 5, "", 0, "C", 0, 0);
        $pdf->SetFont('dejavusans', 'B', 8);
        $pdf->MultiCell(17, 5, "Yazıyla :", 0, "L", 0, 0);
        $pdf->SetFont('dejavusans', 'N', 8);
        $pdf->MultiCell(140, 5, yaziyla_para($collection->tahsilat_miktar), 0, "L", 0, 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetY(90);
        $pdf->MultiCell(110, 5, "", 0, "C", 0, 0);
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->MultiCell(70, 5, "Ödeme Alan", 0, "C", 0, 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'N', 9);
        $pdf->SetY(100);
        $pdf->MultiCell(110, 5, "", 0, "C", 0, 0);
        $pdf->MultiCell(70, 5, company_name($contract->yuklenici), 0, "C", 0, 0);


        $file_name = "Tahsilat Makbuzu";

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }


}
