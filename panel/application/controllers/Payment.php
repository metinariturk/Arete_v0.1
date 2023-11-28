<?php


class Payment extends CI_Controller
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
        $this->viewFolder = "payment_v";
        $this->load->model("Payment_model");
        $this->load->model("Payment_file_model");
        $this->load->model("Payment_settings_model");
        $this->load->model("Payment_sign_model");

        $this->load->model("Contract_model");
        $this->load->model("Company_model");
        $this->load->model("Contract_price_model");
        $this->load->model("Books_main_model");
        $this->load->model("Project_model");
        $this->load->model("Boq_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");

        $this->Module_Name = "payment";
        $this->Module_Title = "Hakediş";

        // Folder Structure
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "contract";
        $this->Module_File_Dir = "payment";
        $this->Module_Table = "payment";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir";
        // Folder Structure

        $this->Display_route = "file_form";
        $this->Dependet_id_key = "payment_id";
        //Folder Structure
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Select_Folder = "select";

        $this->File_List = "file_list_v";
        $this->Common_Files = "common";
        $module_unique_name = module_name($this->Module_Name);
    }

    public function index()
    {
        $viewData = new stdClass();

        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Payment_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array()
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
        $items = $this->Payment_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array()
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $viewData->active_contracts = $active_contracts;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public
    function file_form($id, $active_tab = null)
    {

        $contract_id = contract_id_module("payment", $id);
        $main_groups = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => 1), "rank ASC");
        $active_boqs = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => null, "sub_group" => null,), "rank ASC");
        $settings = $this->Settings_model->get();
        $payment_settings = $this->Payment_settings_model->get(array("contract_id" => $contract_id));
        $viewData = new stdClass();
        $contract = $this->Contract_model->get(array(
            "id" => $contract_id
        ));


        $project_id = project_id_cont($contract_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->contract = $contract;
        $viewData->main_groups = $main_groups;
        $viewData->active_boqs = $active_boqs;
        $viewData->project_id = $project_id;
        $viewData->active_tab = $active_tab;
        $viewData->settings = $settings;
        $viewData->payment_settings = $payment_settings;


        $item = $this->Payment_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item = $item;


        $viewData->item_files = $this->Payment_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public
    function create($contract_id)
    {
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);

        $contract = $this->Contract_model->get(array(
                "id" => $contract_id
            )
        );

        $hak_no = $this->input->post('hakedis_no');

        if ($hak_no != 1) {
            $imalat_tarihi = dateFormat('Y-m-d', $this->input->post("imalat_tarihi"));
            $last_payment_id = get_from_any_and("payment", "contract_id", "$contract_id", "hakedis_no", last_payment($contract_id));
            $last_payment_day = dateFormat('d-m-Y', get_from_any("payment", "imalat_tarihi", "id", "$last_payment_id"));
            $last_payment_no = get_from_id("payment", "hakedis_no", "$last_payment_id");
            $warning = "son hakediş <b>" . "$last_payment_no" . " nolu </b> hakedişin tarihi olan";
        }

        if ($hak_no == 1) {
            $imalat_tarihi = dateFormat('Y-m-d', $this->input->post("imalat_tarihi"));
            $yer_teslimi_tarihi = dateFormat('d-m-Y', get_from_any("contract", "sitedel_date", "id", "$contract_id"));
            $warning = "yer teslimi tarihi olan";
        }

        $this->load->library("form_validation");

        $this->form_validation->set_rules("hakedis_no", "Hakediş No", "required|numeric|trim"); //2
        if ($hak_no == 1) {
            $this->form_validation->set_rules("imalat_tarihi", "İmalat Tarihi", "trim|callback_sitedel_paymentday[$yer_teslimi_tarihi]"); //2
        }
        if ($hak_no != 1) {
            $this->form_validation->set_rules("imalat_tarihi", "İmalat Tarihi", "trim|callback_sitedel_paymentday[$last_payment_day]"); //2
        }

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "numeric" => "<b>{field}</b> rakamlardan oluşmalıdır",
                "limit_advance" => "<b>{field}</b> en fazla kadar olmalıdır.",
                "sitedel_paymentday" => "Uygulama <b>{field}</b>  $warning <b>{param}</b> tarhihinden daha ileri bir tarih olmalı",
                "greater_than_equal_to" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Payment/$hak_no";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
                echo "Dosya Yolu Oluşturuldu: " . $path;
            } else {
                echo "<p>Aynı İsimde Dosya Mevcut: " . $path . "</p>";
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

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_contract_id" => $contract_id,
                    "file_order" => $hak_no,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                )
            );

            // TODO Alert sistemi eklenecek...
            if ($insert) {

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Hakediş başarılı bir şekilde eklendi",
                    "type" => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Hakediş Ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }

            // İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);

            $this->session->unset_userdata('form_errors');

            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));

        } else {

            $viewData = new stdClass();

            $contract = $this->Contract_model->get(array(
                    "id" => $contract_id
                )
            );

            $settings = $this->Settings_model->get();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Add_Folder";
            $viewData->form_error = true;
            $viewData->contract = $contract;
            $viewData->payment_no = $this->input->post('hakedis_no');
            $viewData->contract_id = $contract_id;
            $viewData->project_id = $project_id;
            $viewData->settings = $settings;

            if ($this->form_validation->run() === false) {
                $form_errors = validation_errors();
                $this->session->set_flashdata('form_errors', $form_errors);
                redirect(base_url("contract/file_form/$contract_id/payment/payment"));
            }
        }
    }

    public
    function save($payment_id)
    {

        $payment = $this->Payment_model->get(array("id" => $payment_id));
        $contract_id = contract_id_module("payment", $payment_id);
        $contract_code = contract_code($contract_id);
        $project_id = project_id_cont($payment->contract_id);
        $project_code = project_code($project_id);
        $this->load->library("form_validation");

        $this->form_validation->run();

        $this->form_validation->set_rules("A", "Bu Hakediş Sözleşme Fiyatları İle Yapılan İşin Tutarı", "required|numeric|trim"); //2
        $this->form_validation->set_rules("A1", "Önceki Hakediş Sözleşme Fiyatları İle Yapılan İşin Tutarı", "required|numeric|trim"); //2
        $this->form_validation->set_rules("B", "Fiyat Farkı Tutarı", "numeric|trim"); //2
        $this->form_validation->set_rules("B1", "Önceki Fiyat Farkı Toplamı", "numeric|trim"); //2
        $this->form_validation->set_rules("C", "Toplam Tutar (A+B)", "required|numeric|trim"); //2
        $this->form_validation->set_rules("D", "Bir Önceki Hakedişin Toplam Tutarı", "numeric|trim"); //2
        $this->form_validation->set_rules("E", "Bu Hakedişin Tutarı (C-D)", "required|numeric|trim"); //2
        $this->form_validation->set_rules("F_", "KDV Oran", "numeric|trim"); //2
        $this->form_validation->set_rules("F", "KDV", "numeric|trim"); //2
        $this->form_validation->set_rules("G", "Tahakkuk Tutarı", "required|numeric|trim"); //2
        $this->form_validation->set_rules("KES_a_s", "a)Gelir / Kurumlar Vergisi Oranı", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_a", "a)Gelir / Kurumlar Vergisi", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_b_s", "b)Damga Vergisi Oranı", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_b", "b)Damga Vergisi", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_c_s", "c)KDV Tevkifatı Oranı", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_c", "c)KDV Tevkifatı", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_d", "d)Sosyal Sigortalar Kurumu Kesintisi", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_e_s", "e)Geçici Kabul Kesintisi Oranı", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_e", "e)Geçici Kabul Kesintisi Oranı", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_f", "e)Geçici Kabul Kesintisi", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_g", " g)Gecikme Cezası", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_h", "h)İş Sağlığı ve Güvenliği Cezası", "numeric|trim"); //2
        $this->form_validation->set_rules("KES_i", "i)Diğer", "numeric|trim"); //2
        $this->form_validation->set_rules("H", "Kesinti ve Mahsuplar Toplamı", "numeric|trim"); //2
        $this->form_validation->set_rules("I_s", "Avans Mahsup Oranı", "numeric|trim"); //2
        $this->form_validation->set_rules("I", "Avans Mahsup Tutarı", "numeric|trim"); //2
        $this->form_validation->set_rules("balance", "Ödenecek Tutar", "required|numeric|trim"); //2
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "numeric" => "<b>{field}</b> rakamlardan oluşmalıdır"
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Payment/$payment->hakedis_no";

            if (!is_dir($path)) {
                mkdir("$path", 0777, TRUE);
            }

            if ($this->input->post('final') == "on") {
                $final = 1;
            } else {
                $final = 0;
            }

            $update = $this->Payment_model->update(
                array(
                    "id" => $payment_id
                ),
                array(
                    "A" => $this->input->post('A'),
                    "A1" => $this->input->post('A1'),
                    "B" => $this->input->post('B'),
                    "B1" => $this->input->post('B1'),
                    "C" => $this->input->post('C'),
                    "D" => $this->input->post('D'),
                    "E" => $this->input->post('E'),
                    "F_a" => $this->input->post('F_a'),
                    "F" => $this->input->post('F'),
                    "G" => $this->input->post('G'),
                    "KES_a_s" => $this->input->post('KES_a_s'),
                    "KES_a" => $this->input->post('KES_a'),
                    "KES_b_s" => $this->input->post('KES_b_s'),
                    "KES_b" => $this->input->post('KES_b'),
                    "KES_c_s" => $this->input->post('KES_c_s'),
                    "KES_c" => $this->input->post('KES_c'),
                    "KES_d" => $this->input->post('KES_d'),
                    "KES_e_s" => $this->input->post('KES_e_s'),
                    "KES_e" => $this->input->post('KES_e'),
                    "KES_f" => $this->input->post('KES_f'),
                    "KES_g" => $this->input->post('KES_g'),
                    "KES_h" => $this->input->post('KES_h'),
                    "KES_i" => $this->input->post('KES_i'),
                    "H" => $this->input->post('H'),
                    "I_s" => $this->input->post('I_s'),
                    "I" => $this->input->post('I'),
                    "balance" => $this->input->post('balance'),
                    "final" => $final,
                )
            );

            $record_id = $this->db->insert_id();

            $insert2 = $this->Order_model->add(
                array(
                    "module" => $this->Module_Name,
                    "connected_module_id" => $this->db->insert_id(),
                    "connected_contract_id" => $payment->contract_id,
                    "file_order" => "",
                    "createdAt" => date("Y-m-d H:i:s"),
                    "createdBy" => active_user_id(),
                )
            );

            // TODO Alert sistemi eklenecek...
            if ($update) {
                $alert = array(
                    "title" => "Hakediş Bilgileri Eklendi",
                    "text" => "Çıktı Almak İçin Butonları Kullanabilirsiniz",
                    "type" => "success"
                );
            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Hakediş Ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }

            // İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);


            $active_tab = "report";
            $payment_settings = $this->db->where(array("contract_id" => $contract_id))->get("payment_settings")->row();
            $contract = $this->Contract_model->get(array("id" => $contract_id));


            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->active_tab = $active_tab;
            $viewData->payment_settings = $payment_settings;
            $viewData->contract = $contract;


            $item = $this->Payment_model->get(
                array(
                    "id" => $payment_id
                )
            );

            $viewData->item = $item;


            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/06_tab_report", $viewData, true);

            echo $render_html;

        } else {

            $active_tab = "report";
            $payment_settings = $this->db->where(array("contract_id" => $contract_id))->get("payment_settings")->row();
            $contract = $this->Contract_model->get(array("id" => $contract_id));


            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->active_tab = $active_tab;
            $viewData->payment_settings = $payment_settings;
            $viewData->contract = $contract;


            $item = $this->Payment_model->get(
                array(
                    "id" => $payment_id
                )
            );

            $viewData->item = $item;


            $viewData->form_error = true;

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/06_tab_report", $viewData, true);
            echo $render_html;

        }
    }

    public
    function delete($id)
    {

        $hakedis_no = get_from_id("payment", "hakedis_no", "$id");
        $last_payment = last_payment(get_from_any("payment", "contract_id", "id", $id));

        if ($hakedis_no == $last_payment) {

            $contract_id = get_from_id($this->Module_Table, "contract_id", $id);
            $project_id = project_id_cont($contract_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", get_from_id($this->Module_Table, "contract_id", $id));

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Payment/";

            $sil = deleteDirectory($path);

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
            $delete1 = $this->Payment_file_model->delete(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );
            $delete2 = $this->Payment_model->delete(
                array(
                    "id" => $id
                )
            );


            // TODO Alert Sistemi Eklenecek...
            if ($delete1 and $delete2) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Hakediş başarılı bir şekilde silindi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Hakeiş silme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$contract_id"));

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Bu hakedişten sonra yapılan hakedişleri silmeden bu işlemi gerçekleştiremezsiniz",
                "type" => "alert"
            );

            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$id"));
        }
    }

    public
    function empty_report($payment_id)
    {

        $payment = $this->Payment_model->get(array("id" => $payment_id));
        $contract_id = contract_id_module("payment", $payment_id);

        $update = $this->Payment_model->update(
            array(
                "id" => $payment_id
            ),
            array(
                "A" => null,
                "A1" => null,
                "B" => null,
                "B1" => null,
                "C" => null,
                "D" => null,
                "E" => null,
                "F_a" => null,
                "F" => null,
                "G" => null,
                "KES_a_s" => null,
                "KES_a" => null,
                "KES_b_s" => null,
                "KES_b" => null,
                "KES_c_s" => null,
                "KES_c" => null,
                "KES_d" => null,
                "KES_e_s" => null,
                "KES_e" => null,
                "KES_f" => null,
                "KES_g" => null,
                "KES_h" => null,
                "KES_i" => null,
                "H" => null,
                "I_s" => null,
                "I" => null,
                "balance" => null,
            )
        );

        $active_tab = "report";
        $payment_settings = $this->db->where(array("contract_id" => $contract_id))->get("payment_settings")->row();
        $contract = $this->Contract_model->get(array("id" => $contract_id));


        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->active_tab = $active_tab;
        $viewData->payment_settings = $payment_settings;
        $viewData->contract = $contract;


        $item = $this->Payment_model->get(
            array(
                "id" => $payment_id
            )
        );

        $viewData->item = $item;


        $viewData->form_error = true;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/06_tab_report", $viewData, true);
        echo $render_html;

    }

    public
    function delete_calc($id)
    {

        $hakedis_no = get_from_id("payment", "hakedis_no", "$id");
        $last_payment = last_payment(get_from_any("payment", "contract_id", "id", $id));

        if ($hakedis_no == $last_payment) {

            $contract_id = get_from_id($this->Module_Table, "contract_id", $id);
            $project_id = project_id_cont($contract_id);
            $project_code = project_code($project_id);
            $contract_code = get_from_id("contract", "dosya_no", get_from_id($this->Module_Table, "contract_id", $id));

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Payment/";

            $sil = deleteDirectory($path);

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
            $delete3 = $this->Boq_model->delete(
                array(
                    "contract_id" => $contract_id,
                    "payment_no" => $hakedis_no
                )
            );

            $delete1 = $this->Payment_file_model->delete(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );
            $delete2 = $this->Payment_model->delete(
                array(
                    "id" => $id
                )
            );


            // TODO Alert Sistemi Eklenecek...
            if ($delete1 and $delete2 and $delete3) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Hakediş ve Metrajları başarılı bir şekilde silindi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Hakediş ve Metrajları silme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Depended_Dir/$this->Display_route/$contract_id"));

        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Bu hakedişten sonra yapılan hakedişleri silmeden bu işlemi gerçekleştiremezsiniz",
                "type" => "alert"
            );
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/$this->Display_route/$id"));
        }
    }

    public
    function file_upload($id)
    {

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $contract_id = contract_id_module("payment", $id);
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $hak_no = get_from_id("payment", "hakedis_no", $id);


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$contract_code/Payment/$hak_no";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);
        if (!is_dir($config["upload_path"])) {
            mkdir($config["upload_path"], 0777, TRUE);
            echo "Dosya Yolu Oluşturuldu: " . $config["upload_path"];
        } else {
            echo "<p>Aynı İsimde Dosya Mevcut: " . $config["upload_path"] . "</p>";
        }


        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Payment_file_model->add(
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

    public
    function file_download($id)
    {
        $fileName = $this->Payment_file_model->get(
            array(
                "id" => $id
            )
        );

        $payment_id = get_from_id("payment_files", "payment_id", $id);
        $contract_id = contract_id_module("payment", $payment_id);
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $hak_no = get_from_id("payment", "hakedis_no", $payment_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Payment/$hak_no/$fileName->img_url";

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
    function download_all($payment_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $contract_id = get_from_id("payment", "contract_id", "$payment_id");
        $hak_no = get_from_id("payment", "hakedis_no", "$payment_id");
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $contract_name = contract_name($contract_id);

        $path = "uploads/project_v/$project_code/$contract_code/Payment/$hak_no";
        echo $path;

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $contract_name . "-" . $hak_no . " Hakediş";
        $this->zip->download("$zip_name");

    }

    public
    function refresh_file_list($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->item = $this->Payment_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Payment_file_model->get_all(
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

        $fileName = $this->Payment_file_model->get(
            array(
                "id" => $id
            )
        );


        $payment_id = get_from_id("payment_files", "payment_id", $id);
        $contract_id = contract_id_module("payment", $payment_id);
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $hak_no = get_from_id("payment", "hakedis_no", $payment_id);

        $delete = $this->Payment_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Payment/$hak_no/$fileName->img_url";

            unlink($path);

            $viewData->item = $this->Payment_model->get(
                array(
                    "id" => $payment_id
                )
            );

            $viewData->item_files = $this->Payment_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $payment_id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);
            echo $render_html;

        }
    }

    public
    function fileDelete_all($id)
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $contract_id = contract_id_module("payment", $id);
        $project_id = project_id_cont("$contract_id");
        $project_code = project_code("$project_id");
        $contract_code = contract_code($contract_id);
        $hak_no = get_from_id("payment", "hakedis_no", $id);

        $delete = $this->Payment_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->File_Dir_Prefix/$project_code/$contract_code/Payment/$hak_no");

            foreach ($dir_files as $dir_file) {
                unlink("$this->File_Dir_Prefix/$project_code/$contract_code/Payment/$hak_no/$dir_file");
            }

            $viewData->item = $this->Payment_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Payment_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$this->Common_Files/$this->File_List", $viewData, true);

            echo $render_html;


        }
    }

    public
    function duplicate_code_check($file_name)
    {
        $file_name = "HAK-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public
    function sitedel_paymentday($payment_day, $sitedal_day)
    {
        $date_diff = date_minus($payment_day, $sitedal_day);
        if (($date_diff <= 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public
    function print_calculate($payment_id, $seperate_group = null, $P_or_D = null)
    {
        $contract_id = get_from_id("payment", "contract_id", "$payment_id");

        $main_groups = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => 1), "rank ASC");

        $payment_no = get_from_id("payment", "hakedis_no", "$payment_id");
        $contractor_sign = (array)$this->Payment_sign_model->get(array("contract_id" => $contract_id, "sign_page" => "contractor_sign"));
        $calculate_sings = $this->Payment_sign_model->get_all(array("contract_id" => $contract_id, "sign_page" => "calculate_sign"), "rank ASC");

        $signs = array_merge([$contractor_sign], $calculate_sings);

        foreach ($signs as $item) {
            if (is_object($item)) {
                // Eğer öğe bir stdClass nesnesi ise, diziye çevir
                $item = (array)$item;
            }

            $footer_sign[$item["position"]] = $item["name"];
        }

        $item = $this->Payment_model->get(
            array(
                "id" => $payment_id
            )
        );
        $viewData = new stdClass();
        $viewData->item = $item;


        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');


        $pdf->module = "calculate";
        $pdf->headerSubText = "İşin Adı : " . contract_name($contract_id);
        $pdf->headerPaymentNo = "Hakediş No :" . $payment_no;

        $pdf->headerText = "METRAJ CETVELİ";
        $pdf->parametre = 1; // Parametreyi belirleyin (1 veya 2)

        $pdf->custom_footer = $footer_sign;

        if ($seperate_group != 1) {
            $pdf->AddPage();
        }

        $page_width = $pdf->getPageWidth() - $pdf->getMargins()['left'] - $pdf->getMargins()['right'];

        $k = 1;

        foreach ($main_groups as $main_group) {
            $isset_main = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "main_id" => $main_group->id));
            if (!empty($isset_main)) {
                if ($seperate_group == 1) {
                    $pdf->AddPage();
                }
                $pdf->setLineWidth(0.1);
                $pdf->SetFillColor(160, 160, 160);
                $pdf->SetFont('dejavusans', 'B', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $pdf->Cell($page_width, 5, $main_group->code . " - " . upper_tr($main_group->name), 0, 0, "L", 0);
                $pdf->Ln();


                $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id));
                foreach ($sub_groups as $sub_group) {

                    $isset_sub = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "sub_id" => $sub_group->id));
                    if (!empty($isset_sub)) {
                        $pdf->setLineWidth(0.1);
                        $pdf->SetFont('dejavusans', 'BI', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                        $pdf->Cell($page_width / 100, 4, $main_group->code . "." . $sub_group->code . " - " . upper_tr($sub_group->name), 0, 0, "L", 0);
                        $pdf->Ln();
                        $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id));
                        foreach ($contract_items as $contract_item) {
                            $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id));
                            if (isset($calculate)) {
                                $pdf->SetFont('dejavusans', 'BI', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                                $pdf->SetFillColor(210, 210, 210);
                                $pdf->setLineWidth(0.1);
                                $pdf->Cell($page_width * 15 / 100, 5, $contract_item->code, 1, 0, "L", 1);
                                $pdf->Cell($page_width * 85 / 100, 5, $contract_item->name . " - " . $contract_item->unit, 1, 0, "L", 1);
                                $pdf->Ln();
                                $k = $k + 1;
                                $pdf->SetFillColor(240, 240, 240);
                                $pdf->SetFont('dejavusans', 'B', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                                $pdf->setLineWidth(0.1);
                                $pdf->SetDrawColor(0, 0, 0); // Çizgi rengi (Siyah: RGB 0,0,0)
                                $pdf->Cell($page_width * 15 / 100, 5, "Bölüm", 1, 0, "L", 1);
                                $pdf->Cell($page_width * 35 / 100, 5, "Açıklama", 1, 0, "L", 1);
                                $pdf->Cell($page_width * 9 / 100, 5, "Miktar", 1, 0, "C", 1);
                                $pdf->Cell($page_width * 9 / 100, 5, "En", 1, 0, "C", 1);
                                $pdf->Cell($page_width * 9 / 100, 5, "Boy", 1, 0, "C", 1);
                                $pdf->Cell($page_width * 9 / 100, 5, "Yükseklik", 1, 0, "C", 1);
                                $pdf->Cell($page_width * 14 / 100, 5, "Toplam", 1, 0, "C", 1);
                                $pdf->Ln();
                                $k = $k + 1;
                                $pdf->SetFillColor();

                                foreach (json_decode($calculate->calculation, true) as $calculation_data) {
                                    $pdf->SetFont('dejavusans', '', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                                    $pdf->setLineWidth(0.1);

                                    $pdf->Cell($page_width * 15 / 100, 5, $calculation_data["s"], 1, 0, "L", 0);
                                    $pdf->Cell($page_width * 35 / 100, 5, $calculation_data["n"], 1, 0, "L", 0);
                                    $pdf->Cell($page_width * 9 / 100, 5, money_format($calculation_data["q"]), 1, 0, "R", 0);
                                    $pdf->Cell($page_width * 9 / 100, 5, money_format($calculation_data["w"]), 1, 0, "R", 0);
                                    $pdf->Cell($page_width * 9 / 100, 5, money_format($calculation_data["h"]), 1, 0, "R", 0);
                                    $pdf->Cell($page_width * 9 / 100, 5, money_format($calculation_data["l"]), 1, 0, "R", 0);
                                    $pdf->Cell($page_width * 14 / 100, 5, money_format($calculation_data["t"]), 1, 0, "R", 0);
                                    $pdf->Ln();
                                    $k = $k + 1;

                                }
                                $pdf->SetFont('dejavusans', 'BI', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

                                $pdf->Cell($page_width * 86 / 100, 5, "Toplam", 1, 0, "R", 0);
                                $pdf->Cell($page_width * 14 / 100, 5, money_format($calculate->total), 1, 0, "R", 0);
                                $pdf->Ln();
                                $pdf->Cell($page_width, 1, "", 0, 0, "L",);
                                $pdf->Ln();
                                $k = $k + 1;

                            }

                        }
                        if ($seperate_group == 2) {
                            $pdf->AddPage();
                            $pdf->SetFont('dejavusans', 'BI', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                            $pdf->Cell($page_width / 100, 4, $main_group->code . "." . upper_tr($main_group->name), 0, 0, "L", 0);
                        }
                        $pdf->Ln();
                        $k = $k + 1;
                    }
                }

            }
        }

        $file_name = "07 - Metraj Cetveli-" . contract_name($contract_id) . "-Hak " . $payment_no;

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public
    function print_green_hide_zero($payment_id, $P_or_D = null)
    {
        $contract_id = get_from_id("payment", "contract_id", "$payment_id");

        $main_groups = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => 1), "rank ASC");

        $payment_no = get_from_id("payment", "hakedis_no", "$payment_id");
        $contractor_sign = (array)$this->Payment_sign_model->get(array("contract_id" => $contract_id, "sign_page" => "contractor_sign"));
        $green_signs = $this->Payment_sign_model->get_all(array("contract_id" => $contract_id, "sign_page" => "green_sign"), "rank ASC");

        $signs = array_merge([$contractor_sign], $green_signs);

        foreach ($signs as $item) {
            if (is_object($item)) {
                // Eğer öğe bir stdClass nesnesi ise, diziye çevir
                $item = (array)$item;
            }
            $footer_sign[$item["position"]] = $item["name"];
        }

        $item = $this->Payment_model->get(
            array(
                "id" => $payment_id
            )
        );
        $viewData = new stdClass();
        $viewData->item = $item;


        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('L');

        $pdf->headerSubText = "İşin Adı : " . contract_name($contract_id);
        $pdf->headerPaymentNo = "Hakediş No :" . $payment_no;

        $pdf->headerText = "METRAJ İCMALİ";
        $pdf->parametre = 1; // Parametreyi belirleyin (1 veya 2)

        $pdf->custom_footer = $footer_sign;

        $page_width = $pdf->getPageWidth();
        $pdf->AddPage();
        $pdf->SetFontSize(10);
        $pdf->Cell($page_width, 5, "", 0, 0, "L", 0);
        $pdf->SetFillColor(150, 150, 150); // Gri rengi ayarlayın (RGB renk kodu)

        $i = 0;
        foreach ($main_groups as $main_group) {
            $isset_main = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "main_id" => $main_group->id));
            if (!empty($isset_main)) {
                $i = $i + 2;
                $k = 1;

                $count_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no));
                $say = count($count_items);

                $last_cell = $i + $say;
                if ($last_cell > 24) {
                    $pdf->AddPage(); // Yeni bir sayfa ekleyin
                    $i = 1;
                }
                $pdf->Ln();
                $pdf->SetFont('dejavusans', 'B', 9); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

                $pdf->setLineWidth(0.1);
                $pdf->SetFillColor(160, 160, 160);
                $pdf->SetFont('dejavusans', 'B', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $pdf->Cell($page_width, 5, $main_group->code . " - " . upper_tr($main_group->name), 0, 0, "L", 0);
                $pdf->Ln();


                $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id));

                foreach ($sub_groups as $sub_group) {
                    $isset_sub = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "sub_id" => $sub_group->id));
                    if (!empty($isset_sub)) {
                        $pdf->setLineWidth(0.1);
                        $pdf->SetFont('dejavusans', 'BI', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                        $pdf->Cell($page_width, 4, $main_group->code . "." . $sub_group->code . " - " . upper_tr($sub_group->name), 0, 0, "L", 0);
                        $pdf->Ln();
                        $pdf->SetFillColor(210, 210, 210);
                        $pdf->SetFont('dejavusans', 'B', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                        $pdf->setLineWidth(0.1);
                        $pdf->SetDrawColor(0, 0, 0); // Çizgi rengi (Siyah: RGB 0,0,0)
                        $pdf->Cell(13, 10, "Sıra No", 1, 0, "C", 1);
                        $pdf->Cell(32, 10, "Poz No", 1, 0, "C", 1);
                        $pdf->Cell(138, 10, "Yapılan İşin Cinsi", 1, 0, "L", 1);
                        $pdf->Cell(13, 10, "Birimi", 1, 0, "C", 1);
                        $pdf->Cell(84, 5, "Hakediş Miktarları", 1, 0, "C", 1);
                        $pdf->Ln();
                        $pdf->Cell(196, 5, "", 0, 0, "C", 0);
                        $pdf->Cell(28, 5, "Toplam", 1, 0, "C", 1);
                        $pdf->Cell(28, 5, "Önceki Hak.", 1, 0, "C", 1);
                        $pdf->Cell(28, 5, "Bu Hak.", 1, 1, "C", 1);


                        $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id));
                        $i = 1;
                        foreach ($contract_items as $contract_item) {
                            $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id));
                            $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "boq_id" => $contract_item->id), "total");
                            $this_total = isset($calculate->total) ? $calculate->total : 0;
                            $pdf->SetFont('dejavusans', '', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                            $pdf->setLineWidth(0.1);
                            $pdf->Cell(13, 5, $k++, 1, 0, "C", 0);
                            $pdf->Cell(32, 5, $contract_item->code, 1, 0, "L", 0);
                            $pdf->Cell(138, 5, $contract_item->name, 1, 0, "L", 0);
                            $pdf->Cell(13, 5, $contract_item->unit, 1, 0, "C", 0);
                            $pdf->Cell(28, 5, money_format($old_total + $this_total), 1, 0, "R", 0);
                            $pdf->Cell(28, 5, money_format($old_total), 1, 0, "R", 0);
                            $pdf->Cell(28, 5, money_format($this_total), 1, 0, "R", 0);
                            $pdf->Ln();
                        }
                        $pdf->Cell(265, 2, '', 0, 1); // 0 genişlik, 10 yükseklik, boş içerik
                    }
                }
            }
        }

        $file_name = "02 - Metraj İcmali-" . contract_name($contract_id) . "-Hak " . $payment_no;

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public
    function print_green_all($payment_id, $P_or_D = null)
    {
        $contract_id = get_from_id("payment", "contract_id", "$payment_id");

        $main_groups = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => 1), "rank ASC");

        $payment_no = get_from_id("payment", "hakedis_no", "$payment_id");
        $contractor_sign = (array)$this->Payment_sign_model->get(array("contract_id" => $contract_id, "sign_page" => "contractor_sign"));
        $green_signs = $this->Payment_sign_model->get_all(array("contract_id" => $contract_id, "sign_page" => "green_sign"), "rank ASC");

        $signs = array_merge([$contractor_sign], $green_signs);

        foreach ($signs as $item) {
            if (is_object($item)) {
                // Eğer öğe bir stdClass nesnesi ise, diziye çevir
                $item = (array)$item;
            }
            $footer_sign[$item["position"]] = $item["name"];
        }

        $item = $this->Payment_model->get(
            array(
                "id" => $payment_id
            )
        );
        $viewData = new stdClass();
        $viewData->item = $item;


        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('L');

        $pdf->headerSubText = "İşin Adı : " . contract_name($contract_id);
        $pdf->headerPaymentNo = "Hakediş No :" . $payment_no;

        $pdf->headerText = "METRAJ İCMALİ";
        $pdf->parametre = 1; // Parametreyi belirleyin (1 veya 2)

        $pdf->custom_footer = $footer_sign;

        $page_width = $pdf->getPageWidth();
        $pdf->AddPage();
        $pdf->SetFontSize(10);
        $pdf->Cell($page_width, 5, "", 0, 0, "L", 0);
        $pdf->SetFillColor(150, 150, 150); // Gri rengi ayarlayın (RGB renk kodu)

        $i = 0;
        foreach ($main_groups as $main_group) {
            $i = $i + 2;
            $k = 1;

            $count_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no));
            $say = count($count_items);

            $last_cell = $i + $say;
            if ($last_cell > 24) {
                $pdf->AddPage(); // Yeni bir sayfa ekleyin
                $i = 1;
            }
            $pdf->Ln();
            $pdf->SetFont('dejavusans', 'B', 9); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
            $pdf->setLineWidth(0.1);
            $pdf->SetFillColor(160, 160, 160);
            $pdf->SetFont('dejavusans', 'B', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
            $pdf->Cell($page_width, 5, $main_group->code . " - " . upper_tr($main_group->name), 0, 0, "L", 0);
            $pdf->Ln();

            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id));

            foreach ($sub_groups as $sub_group) {
                $pdf->setLineWidth(0.1);
                $pdf->SetFont('dejavusans', 'BI', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $pdf->Cell($page_width, 4, $main_group->code . "." . $sub_group->code . " - " . upper_tr($sub_group->name), 0, 0, "L", 0);
                $pdf->Ln();
                $pdf->SetFillColor(210, 210, 210);
                $pdf->SetFont('dejavusans', 'B', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $pdf->setLineWidth(0.1);
                $pdf->SetDrawColor(0, 0, 0); // Çizgi rengi (Siyah: RGB 0,0,0)
                $pdf->Ln();
                $pdf->Cell(15, 10, "Sıra No", 1, 0, "C", 1);
                $pdf->Cell(35, 10, "Poz No", 1, 0, "C", 1);
                $pdf->Cell(130, 10, "Yapılan İşin Cinsi", 1, 0, "L", 1);
                $pdf->Cell(16, 10, "Birimi", 1, 0, "C", 1);
                $pdf->Cell(84, 5, "Hakediş Miktarları", 1, 0, "C", 1);
                $pdf->Ln();
                $pdf->Cell(196, 5, "", 0, 0, "C", 0);
                $pdf->Cell(28, 5, "Toplam", 1, 0, "C", 1);
                $pdf->Cell(28, 5, "Önceki Hak.", 1, 0, "C", 1);
                $pdf->Cell(28, 5, "Bu Hak.", 1, 1, "C", 1);


                $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id));
                $i = 1;
                foreach ($contract_items as $contract_item) {
                    $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id));
                    $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "boq_id" => $contract_item->id), "total");
                    $this_total = isset($calculate->total) ? $calculate->total : 0;
                    $pdf->SetFont('dejavusans', '', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                    $pdf->setLineWidth(0.1);
                    $pdf->Cell(15, 5, $k++, 1, 0, "C", 0);
                    $pdf->Cell(35, 5, $contract_item->code, 1, 0, "L", 0);
                    $pdf->Cell(130, 5, $contract_item->name, 1, 0, "L", 0);
                    $pdf->Cell(16, 5, $contract_item->unit, 1, 0, "C", 0);
                    $pdf->Cell(28, 5, money_format($old_total + $this_total), 1, 0, "R", 0);
                    $pdf->Cell(28, 5, money_format($old_total), 1, 0, "R", 0);
                    $pdf->Cell(28, 5, money_format($this_total), 1, 0, "R", 0);
                    $pdf->Ln();

                }
                $pdf->Cell(265, 2, '', 0, 1); // 0 genişlik, 10 yükseklik, boş içerik

            }

        }

        $file_name = "06 - Metraj İcmali-" . contract_name($contract_id) . "-Hak " . $payment_no;

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public
    function print_works_done_hide_zero($payment_id, $P_or_D = null)
    {
        $contract_id = get_from_id("payment", "contract_id", "$payment_id");

        $main_groups = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => 1), "rank ASC");

        $payment_no = get_from_id("payment", "hakedis_no", "$payment_id");
        $contractor_sign = (array)$this->Payment_sign_model->get(array("contract_id" => $contract_id, "sign_page" => "contractor_sign"));
        $works_done = $this->Payment_sign_model->get_all(array("contract_id" => $contract_id, "sign_page" => "works_done_sign"), "rank ASC");

        $signs = array_merge([$contractor_sign], $works_done);

        foreach ($signs as $item) {
            if (is_object($item)) {
                // Eğer öğe bir stdClass nesnesi ise, diziye çevir
                $item = (array)$item;
            }
            $footer_sign[$item["position"]] = $item["name"];
        }

        $item = $this->Payment_model->get(
            array(
                "id" => $payment_id
            )
        );
        $viewData = new stdClass();
        $viewData->item = $item;


        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('L');

        $pdf->headerSubText = "İşin Adı : " . contract_name($contract_id);
        $pdf->headerPaymentNo = "Hakediş No :" . $payment_no;

        $pdf->headerText = "YAPILAN İŞLER LİSTESİ";
        $pdf->parametre = 1; // Parametreyi belirleyin (1 veya 2)

        $pdf->custom_footer = $footer_sign;

        $page_width = $pdf->getPageWidth();
        $pdf->AddPage();
        $pdf->SetFontSize(10);
        $pdf->Cell($page_width, 5, "", 0, 0, "L", 0);
        $pdf->SetFillColor(150, 150, 150); // Gri rengi ayarlayın (RGB renk kodu)

        $i = 0;
        foreach ($main_groups as $main_group) {
            $is_item_in_main = $this->Boq_model->get(array('contract_id' => $item->contract_id, "main_id" => $main_group->id));
            if (!empty($is_item_in_main)) {
                $i = $i + 2;
                $k = 1;

                $count_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no));
                $say = count($count_items);

                $last_cell = $i + $say;
                if ($last_cell > 24) {
                    $pdf->AddPage(); // Yeni bir sayfa ekleyin
                    $i = 1;
                }
                $pdf->Ln();
                $pdf->SetFont('dejavusans', 'B', 9); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $pdf->setLineWidth(0.1);
                $pdf->SetFillColor(160, 160, 160);
                $pdf->SetFont('dejavusans', 'B', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $pdf->Cell($page_width, 5, $main_group->code . " - " . upper_tr($main_group->name), 0, 0, "L", 0);
                $pdf->Ln();

                $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id));
                foreach ($sub_groups as $sub_group) {

                    $is_item_in_sub = $this->Boq_model->get(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id));
                    if (!empty($is_item_in_sub)) {
                        $pdf->setLineWidth(0.1);
                        $pdf->SetFont('dejavusans', 'BI', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                        $pdf->Cell($page_width, 4, $main_group->code . "." . $sub_group->code . " - " . upper_tr($sub_group->name), 0, 0, "L", 0);
                        $pdf->Ln();
                        $pdf->SetFillColor(210, 210, 210);
                        $pdf->SetFont('dejavusans', 'B', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                        $pdf->setLineWidth(0.1);
                        $pdf->SetDrawColor(0, 0, 0); // Çizgi rengi (Siyah: RGB 0,0,0)
                        $pdf->Ln();

                        $pdf->Cell(15, 10, "Sıra No", 1, 0, "C", 1);
                        $pdf->Cell(32, 10, "Poz No", 1, 0, "C", 1);
                        $pdf->Cell(70, 10, "Yapılan İşin Cinsi", 1, 0, "L", 1);
                        $pdf->Cell(16, 10, "Birimi", 1, 0, "C", 1);

                        $pdf->Cell(21, 5, "A", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "B", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "C", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "D=B-C", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "E=AxB", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "F=AxC", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "G=E-F", 1, 0, "C", 1);
                        $pdf->Ln();
                        $pdf->Cell(133, 5, "", 0, 0, "C", 0);
                        $pdf->SetFont('dejavusans', 'B', 6); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

                        $pdf->Cell(21, 5, "Birim Fiyat", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "Toplam Miktar", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "Önceki Hakediş", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "Bu Hakediş", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "Toplam İmalat", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "Önceki Tutar", 1, 0, "C", 1);
                        $pdf->Cell(21, 5, "Bu Hakediş", 1, 0, "C", 1);

                        $pdf->Ln();

                        $pdf->SetFont('dejavusans', 'N', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

                        $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id));
                        $i = 1;
                        foreach ($contract_items as $contract_item) {
                            $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id));
                            $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "boq_id" => $contract_item->id), "total");
                            $this_total = isset($calculate->total) ? $calculate->total : 0;
                            if (($old_total + $this_total) != 0) {
                                $pdf->Cell(15, 5, $k++, 1, 0, "C", 0);
                                $pdf->Cell(32, 5, $contract_item->code, 1, 0, "L", 0);
                                $pdf->Cell(70, 5, $contract_item->name, 1, 0, "L", 0);
                                $pdf->Cell(16, 5, $contract_item->unit, 1, 0, "C", 0);
                                $pdf->Cell(21, 5, money_format($contract_item->price), 1, 0, "R", 0);
                                $pdf->Cell(21, 5, money_format($old_total + $this_total), 1, 0, "R", 0);
                                $pdf->Cell(21, 5, money_format($old_total), 1, 0, "R", 0);
                                $pdf->Cell(21, 5, money_format($this_total), 1, 0, "R", 0);
                                $pdf->Cell(21, 5, money_format(($old_total + $this_total) * $contract_item->price), 1, 0, "R", 0);
                                $pdf->Cell(21, 5, money_format($old_total * $contract_item->price), 1, 0, "R", 0);
                                $pdf->Cell(21, 5, money_format($this_total * $contract_item->price), 1, 0, "R", 0);
                                $pdf->Ln();
                            }
                        }
                    }
                    $pdf->Cell(265, 2, '', 0, 1); // 0 genişlik, 10 yükseklik, boş içerik
                }
            }
        }

        $file_name = "05 - Yapılan İşler Listesi-" . contract_name($contract_id) . "-Hak " . $payment_no;

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public
    function print_works_done_print_all($payment_id, $P_or_D = null)
    {
        $contract_id = get_from_id("payment", "contract_id", "$payment_id");

        $main_groups = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => 1), "rank ASC");

        $payment_no = get_from_id("payment", "hakedis_no", "$payment_id");
        $contractor_sign = (array)$this->Payment_sign_model->get(array("contract_id" => $contract_id, "sign_page" => "contractor_sign"));
        $works_done = $this->Payment_sign_model->get_all(array("contract_id" => $contract_id, "sign_page" => "works_done_sign"), "rank ASC");

        $signs = array_merge([$contractor_sign], $works_done);

        foreach ($signs as $item) {
            if (is_object($item)) {
                // Eğer öğe bir stdClass nesnesi ise, diziye çevir
                $item = (array)$item;
            }
            $footer_sign[$item["position"]] = $item["name"];
        }

        $item = $this->Payment_model->get(
            array(
                "id" => $payment_id
            )
        );
        $viewData = new stdClass();
        $viewData->item = $item;


        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('L');

        $pdf->headerSubText = "İşin Adı : " . contract_name($contract_id);
        $pdf->headerPaymentNo = "Hakediş No :" . $payment_no;

        $pdf->headerText = "YAPILAN İŞLER LİSTESİ";
        $pdf->parametre = 1; // Parametreyi belirleyin (1 veya 2)

        $pdf->custom_footer = $footer_sign;

        $page_width = $pdf->getPageWidth();
        $pdf->AddPage();
        $pdf->SetFontSize(10);
        $pdf->Cell($page_width, 5, "", 0, 0, "L", 0);
        $pdf->SetFillColor(150, 150, 150); // Gri rengi ayarlayın (RGB renk kodu)

        $i = 0;
        foreach ($main_groups as $main_group) {
            $is_item_in_main = $this->Boq_model->get(array('contract_id' => $item->contract_id, "main_id" => $main_group->id));
            if (!empty($is_item_in_main)) {
                $i = $i + 2;
                $k = 1;

                $count_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no));
                $say = count($count_items);

                $last_cell = $i + $say;
                if ($last_cell > 24) {
                    $pdf->AddPage(); // Yeni bir sayfa ekleyin
                    $i = 1;
                }
                $pdf->Ln();
                $pdf->SetFont('dejavusans', 'B', 9); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $pdf->setLineWidth(0.1);
                $pdf->SetFillColor(160, 160, 160);
                $pdf->SetFont('dejavusans', 'B', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $pdf->Cell($page_width, 5, $main_group->code . " - " . upper_tr($main_group->name), 0, 0, "L", 0);
                $pdf->Ln();

                $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id));
                foreach ($sub_groups as $sub_group) {
                    $pdf->setLineWidth(0.1);
                    $pdf->SetFont('dejavusans', 'BI', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                    $pdf->Cell($page_width, 4, $main_group->code . "." . $sub_group->code . " - " . upper_tr($sub_group->name), 0, 0, "L", 0);
                    $pdf->Ln();
                    $pdf->SetFillColor(210, 210, 210);
                    $pdf->SetFont('dejavusans', 'B', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                    $pdf->setLineWidth(0.1);
                    $pdf->SetDrawColor(0, 0, 0); // Çizgi rengi (Siyah: RGB 0,0,0)
                    $pdf->Ln();


                    $pdf->Cell(15, 10, "Sıra No", 1, 0, "C", 1);
                    $pdf->Cell(32, 10, "Poz No", 1, 0, "C", 1);
                    $pdf->Cell(70, 10, "Yapılan İşin Cinsi", 1, 0, "L", 1);
                    $pdf->Cell(16, 10, "Birimi", 1, 0, "C", 1);

                    $pdf->Cell(21, 5, "A", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "B", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "C", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "D=B-C", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "E=AxB", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "F=AxC", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "G=E-F", 1, 0, "C", 1);
                    $pdf->Ln();
                    $pdf->Cell(133, 5, "", 0, 0, "C", 0);
                    $pdf->SetFont('dejavusans', 'B', 6); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

                    $pdf->Cell(21, 5, "Birim Fiyat", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "Toplam Miktar", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "Önceki Hakediş", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "Bu Hakediş", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "Toplam İmalat", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "Önceki Tutar", 1, 0, "C", 1);
                    $pdf->Cell(21, 5, "Bu Hakediş", 1, 0, "C", 1);

                    $pdf->Ln();

                    $pdf->SetFont('dejavusans', 'N', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

                    $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id));
                    $i = 1;
                    foreach ($contract_items as $contract_item) {
                        $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id));
                        $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "boq_id" => $contract_item->id), "total");
                        $this_total = isset($calculate->total) ? $calculate->total : 0;

                        $pdf->Cell(15, 5, $k++, 1, 0, "C", 0);
                        $pdf->Cell(32, 5, $contract_item->code, 1, 0, "L", 0);
                        $pdf->Cell(70, 5, $contract_item->name, 1, 0, "L", 0);
                        $pdf->Cell(16, 5, $contract_item->unit, 1, 0, "C", 0);
                        $pdf->Cell(21, 5, money_format($contract_item->price), 1, 0, "R", 0);
                        $pdf->Cell(21, 5, money_format($old_total + $this_total), 1, 0, "R", 0);
                        $pdf->Cell(21, 5, money_format($old_total), 1, 0, "R", 0);
                        $pdf->Cell(21, 5, money_format($this_total), 1, 0, "R", 0);
                        $pdf->Cell(21, 5, money_format(($old_total + $this_total) * $contract_item->price), 1, 0, "R", 0);
                        $pdf->Cell(21, 5, money_format($old_total * $contract_item->price), 1, 0, "R", 0);
                        $pdf->Cell(21, 5, money_format($this_total * $contract_item->price), 1, 0, "R", 0);
                        $pdf->Ln();
                    }
                    $pdf->Cell(265, 2, '', 0, 1); // 0 genişlik, 10 yükseklik, boş içerik

                }

            }
        }

        $file_name = "03 - Yapılan İşler Listesi-" . contract_name($contract_id) . "-Hak " . $payment_no;

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public
    function print_group_total($payment_id, $P_or_D = null)
    {
        $contract_id = get_from_id("payment", "contract_id", "$payment_id");

        $main_groups = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => 1), "rank ASC");

        $payment_no = get_from_id("payment", "hakedis_no", "$payment_id");
        $contractor_sign = (array)$this->Payment_sign_model->get(array("contract_id" => $contract_id, "sign_page" => "contractor_sign"));
        $works_done = $this->Payment_sign_model->get_all(array("contract_id" => $contract_id, "sign_page" => "works_done_sign"), "rank ASC");

        $signs = array_merge([$contractor_sign], $works_done);

        foreach ($signs as $item) {
            if (is_object($item)) {
                // Eğer öğe bir stdClass nesnesi ise, diziye çevir
                $item = (array)$item;
            }
            $footer_sign[$item["position"]] = $item["name"];
        }

        $item = $this->Payment_model->get(
            array(
                "id" => $payment_id
            )
        );
        $viewData = new stdClass();
        $viewData->item = $item;


        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        $pdf->headerSubText = "İşin Adı : " . contract_name($contract_id);
        $pdf->headerPaymentNo = "Hakediş No :" . $payment_no;

        $pdf->headerText = "YAPILAN İŞLER GRUP İCMALLERİ";
        $pdf->parametre = 1; // Parametreyi belirleyin (1 veya 2)

        $pdf->custom_footer = $footer_sign;

        $page_width = $pdf->getPageWidth();
        $pdf->AddPage();
        $pdf->SetFontSize(8);
        $pdf->Cell($page_width, 5, "", 0, 0, "L", 0);
        $pdf->SetFillColor(150, 150, 150); // Gri rengi ayarlayın (RGB renk kodu)

        $i = 0;
        foreach ($main_groups as $main_group) {
            $is_item_in_main = $this->Boq_model->get(array('contract_id' => $item->contract_id, "main_id" => $main_group->id));
            if (!empty($is_item_in_main)) {
                $i = $i + 2;
                $k = 1;

                $count_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no));
                $say = count($count_items);

                $last_cell = $i + $say;
                if ($last_cell > 24) {
                    $pdf->AddPage(); // Yeni bir sayfa ekleyin
                    $i = 1;
                }
                $pdf->Ln();

                $pdf->SetFont('dejavusans', 'B', 9); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $pdf->setLineWidth(0.1);
                $pdf->SetFillColor(160, 160, 160);
                $pdf->SetFont('dejavusans', 'B', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $pdf->Cell($page_width, 5, $main_group->code . " - " . upper_tr($main_group->name), 0, 0, "L", 0);
                $pdf->Ln();
                $pdf->SetFillColor(210, 210, 210);
                $pdf->SetFont('dejavusans', 'B', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $pdf->setLineWidth(0.1);
                $pdf->SetDrawColor(0, 0, 0); // Çizgi rengi (Siyah: RGB 0,0,0)
                $pdf->Cell(15, 5, "Sıra No", 1, 0, "C", 1);
                $pdf->Cell(20, 5, "Grup No", 1, 0, "C", 1);
                $pdf->Cell(56, 5, "Grup Adı", 1, 0, "L", 1);
                $pdf->SetFont('dejavusans', 'B', 6.5); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

                $pdf->Cell(33, 5, "Yapılan İşler Toplamı", 1, 0, "C", 1);
                $pdf->Cell(33, 5, "Önceki Hakediş Toplamı", 1, 0, "C", 1);
                $pdf->Cell(33, 5, "Bu Hakediş Toplamı", 1, 0, "C", 1);

                $pdf->Ln();
                $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id));
                $i = 1;

                $c = 0;
                $d = 0;
                foreach ($sub_groups as $sub_group) :

                    $sum_group_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "sub_id" => $sub_group->id));
                    $a = array_reduce($sum_group_items, function ($carry, $sum_group_item) {
                        $contract_price = get_from_any("contract_price", "price", "id", "$sum_group_item->boq_id");
                        return $carry + $sum_group_item->total * $contract_price;
                    }, 0);


                    $sum_group_old_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "sub_id" => $sub_group->id));
                    $b = array_reduce($sum_group_old_items, function ($carry, $sum_group_old_item) {
                        $contract_price = get_from_any("contract_price", "price", "id", "$sum_group_old_item->boq_id");
                        return $carry + $sum_group_old_item->total * $contract_price;
                    }, 0);
                    $pdf->SetFont('dejavusans', 'N', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

                    $pdf->Cell(15, 5, $i++, 1, 0, "C", 0);
                    $pdf->Cell(20, 5, $main_group->code . "." . $sub_group->code, 1, 0, "L", 0);
                    $pdf->Cell(56, 5, upper_tr($sub_group->name), 1, 0, "L", 0);
                    $pdf->Cell(33, 5, money_format($a + $b), 1, 0, "R", 0);
                    $pdf->Cell(33, 5, money_format($b), 1, 0, "R", 0);
                    $pdf->Cell(33, 5, money_format($a), 1, 0, "R", 0);
                    $pdf->Ln();
                    $c += $a;
                    $d += $b;
                endforeach;
            }

            $pdf->SetFont('dejavusans', 'B', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

            $pdf->Cell($page_width - 119, 5, "TOPLAM", 1, 0, "R", 0);
            $pdf->Cell(33, 5, money_format($d + $c), 1, 0, "R", 0);
            $pdf->Cell(33, 5, money_format($d), 1, 0, "R", 0);
            $pdf->Cell(33, 5, money_format($c), 1, 0, "R", 0);

            $pdf->Ln();
            $pdf->Cell($page_width, 5, "", 0, 0, "R", 0);

        }

        $file_name = "04 - Yapılan İşler Grup İcmalleri" . contract_name($contract_id) . "-Hak " . $payment_no;

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public
    function print_main_total($payment_id, $P_or_D = null)
    {
        $contract_id = get_from_id("payment", "contract_id", "$payment_id");

        $main_groups = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => 1), "rank ASC");

        $payment_no = get_from_id("payment", "hakedis_no", "$payment_id");
        $contractor_sign = (array)$this->Payment_sign_model->get(array("contract_id" => $contract_id, "sign_page" => "contractor_sign"));
        $works_done = $this->Payment_sign_model->get_all(array("contract_id" => $contract_id, "sign_page" => "works_done_sign"), "rank ASC");

        $signs = array_merge([$contractor_sign], $works_done);

        foreach ($signs as $item) {
            if (is_object($item)) {
                // Eğer öğe bir stdClass nesnesi ise, diziye çevir
                $item = (array)$item;
            }
            $footer_sign[$item["position"]] = $item["name"];
        }

        $item = $this->Payment_model->get(
            array(
                "id" => $payment_id
            )
        );
        $viewData = new stdClass();
        $viewData->item = $item;


        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        $pdf->headerSubText = "İşin Adı : " . contract_name($contract_id);
        $pdf->headerPaymentNo = "Hakediş No :" . $payment_no;

        $pdf->headerText = "YAPILAN İŞLER İCMALİ";
        $pdf->parametre = 1; // Parametreyi belirleyin (1 veya 2)

        $pdf->custom_footer = $footer_sign;

        $page_width = $pdf->getPageWidth();
        $pdf->AddPage();
        $pdf->SetFontSize(8);
        $pdf->SetFillColor(150, 150, 150); // Gri rengi ayarlayın (RGB renk kodu)

        $pdf->Ln();
        $pdf->SetFillColor(210, 210, 210);
        $pdf->SetFont('dejavusans', 'B', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
        $pdf->setLineWidth(0.1);
        $pdf->SetDrawColor(0, 0, 0); // Çizgi rengi (Siyah: RGB 0,0,0)
        $pdf->Cell(15, 5, "Sıra No", 1, 0, "C", 1);
        $pdf->Cell(20, 5, "Grup No", 1, 0, "C", 1);
        $pdf->Cell(56, 5, "Grup Adı", 1, 0, "L", 1);
        $pdf->SetFont('dejavusans', 'B', 6.5); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
        $pdf->Cell(33, 5, "Yapılan İşler Toplamı", 1, 0, "C", 1);
        $pdf->Cell(33, 5, "Önceki Hakediş Toplamı", 1, 0, "C", 1);
        $pdf->Cell(33, 5, "Bu Hakediş Toplamı", 1, 0, "C", 1);


        $i = 1;
        $x = 0;
        $y = 0;
        foreach ($main_groups as $main_group) {
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id));
            $c = 0;
            $d = 0;
            foreach ($sub_groups as $sub_group) {
                $sum_group_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "sub_id" => $sub_group->id));
                $a = array_reduce($sum_group_items, function ($carry, $sum_group_item) {
                    $contract_price = get_from_any("contract_price", "price", "id", "$sum_group_item->boq_id");
                    return $carry + $sum_group_item->total * $contract_price;
                }, 0);
                $sum_group_old_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "sub_id" => $sub_group->id));
                $b = array_reduce($sum_group_old_items, function ($carry, $sum_group_old_item) {
                    $contract_price = get_from_any("contract_price", "price", "id", "$sum_group_old_item->boq_id");
                    return $carry + $sum_group_old_item->total * $contract_price;
                }, 0);
                $c += $a;
                $d += $b;
            }
            $pdf->Ln();

            $pdf->SetFont('dejavusans', 'N', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

            $pdf->Cell(15, 5, $i++, 1, 0, "C", 0);
            $pdf->Cell(20, 5, $main_group->code, 1, 0, "L", 0);
            $pdf->Cell(56, 5, upper_tr($main_group->name), 1, 0, "L", 0);
            $pdf->Cell(33, 5, money_format($c + $d), 1, 0, "R", 0);
            $pdf->Cell(33, 5, money_format($d), 1, 0, "R", 0);
            $pdf->Cell(33, 5, money_format($c), 1, 0, "R", 0);
            $x += $d;
            $y += $c;
        }
        $pdf->Ln();

        $pdf->SetFont('dejavusans', 'B', 7); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

        $pdf->Cell(91, 5, "TOPLAM", 1, 0, "R", 0);
        $pdf->Cell(33, 5, money_format($x + $y), 1, 0, "R", 0);
        $pdf->Cell(33, 5, money_format($x), 1, 0, "R", 0);
        $pdf->Cell(33, 5, money_format($y), 1, 0, "R", 0);

        $file_name = "03 - Yapılan İşler İcmali-" . contract_name($contract_id) . "-Hak " . $payment_no;

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public
    function print_cover($payment_id, $P_or_D = null)
    {


        $payment = $this->Payment_model->get(array("id" => $payment_id));

        $viewData = new stdClass();
        $contract = $this->Contract_model->get(array("id" => $payment->contract_id));


        $viewData->payment = $payment;
        $viewData->contract = $contract;

        $advance_given = sum_from_table("advance", "avans_miktar", $contract->id);
        $sum_old_advance = $this->Payment_model->sum_all(array('contract_id' => $payment->contract_id, "hakedis_no" => $payment->hakedis_no), "I");

        $contractor = $this->Company_model->get(array("id" => $contract->yuklenici));
        $owner = $this->Company_model->get(array("id" => $contract->isveren));
        $viewData->contractor = $contractor;
        $viewData->owner = $owner;


        $yuklenici = company_name($contract->yuklenici);
        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        $page_width = $pdf->getPageWidth();


        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();


        $logoPath = K_PATH_IMAGES . 'logo_example.jpg';
        $logoWidth = 50; // Logo genişliği

        $pdf->Image($logoPath, 20, 10, $logoWidth);
// Çerçeve için boşlukları belirleme
        $topMargin = 40;  // 4 cm yukarıdan
        $bottomMargin = 40;  // 4 cm aşağıdan
        $rightMargin = 20;  // 2 cm sağdan
        $leftMargin = 20;  // 2 cm soldan

// Çerçeve renk ve kalınlığını ayarla
        $pdf->SetDrawColor(0, 0, 0); // Siyah renk
        $pdf->SetLineWidth(0.5); // Çizgi kalınlığı

// Çerçeve çizme
        $pdf->Rect($leftMargin, $topMargin, $pdf->getPageWidth() - $rightMargin - $leftMargin, $pdf->getPageHeight() - $bottomMargin - $topMargin);

        $pdf->SetFont('dejavusans', 'B', 12);

// Metin eklemek (örnek olarak ilk satır)
        $yPosition = $topMargin + 5; // 5 cm yukarıdan başla
        $xPosition = $leftMargin + 2; // 2 cm soldan başla
        $pdf->SetY($yPosition);

        $pdf->Cell(0, 10, 'HAKEDİŞ RAPORU', 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetX($xPosition);
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->Cell(72, 6, "Tarih", 0, 0, "R", 0);
        $pdf->Cell(5, 6, ':', 0, 0, "C", 0);
        $pdf->SetFont('dejavusans', 'N', 9);
        $pdf->Cell(72, 6, "$payment->imalat_tarihi", 0, 0, "L", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX($xPosition);
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->Cell(72, 6, "No", 0, 0, "R", 0);
        $pdf->Cell(5, 6, ':', 0, 0, "C", 0);
        $pdf->SetFont('dejavusans', 'N', 9);
        $pdf->Cell(72, 6, "$payment->hakedis_no", 0, 0, "L", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(72, 8, "", 0, 0, "L", 0);
        $pdf->Ln(); // Yeni satıra geç
        $rows = array(
            "Yapılan İşin Adı" => $contract->sozlesme_ad,
            "Yüklenicinin Adı" => $contractor->company_name,
            "Sözleşme Bedeli" => money_format($contract->sozlesme_bedel) . " " . $contract->para_birimi,
            "İhale Tarihi" => "",
            "İhale Kom. Karar Tarihi ve No.su" => "",
            "Sözleşme Tarihi" => dateFormat_dmy($contract->sozlesme_tarih),
            "İşyeri Teslim Tarihi" => dateFormat_dmy($contract->sitedel_date),
            "Sözleşmeye Göre İşin Süresi" => $contract->isin_suresi,
            "Sözleşmeye Göre İşin Bitim Tarihi" => dateFormat_dmy($contract->sozlesme_bitis),
            "Verilen Avanslar Toplamı" => money_format($advance_given) . " " . $contract->para_birimi,
            "Mahsubu Yapılan Avansın Toplam Tutarı" => money_format($sum_old_advance) . " " . $contract->para_birimi,
        );


        foreach ($rows as $row => $value) {
            $pdf->SetX($xPosition);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Cell(72, 8, $row, 0, 0, "L", 0);
            $pdf->Cell(5, 8, ':', 0, 0, "C", 0);
            $pdf->SetFont('dejavusans', 'N', 9);
            $pdf->Cell(72, 8, $value, 0, 0, "L", 0);
            $pdf->Ln(); // Yeni satıra geç
        }

        $pdf->Cell("", 8, "", 0, 0, "L", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX($xPosition);
        $pdf->SetLineWidth(0.1); // Çizgi kalınlığı (ince çizgi)
        $pdf->SetFont('dejavusans', 'B', 8);
        $pdf->MultiCell(41, 10, "Sözleşme Bedeli", 1, "C", 0, 0);
        $pdf->MultiCell(41, 10, "Sözleşme Artış \n Onayının Tarih ve Nosu", 1, "C", 0, 0);
        $pdf->MultiCell(41, 10, "Ek Sözleşme \n Bedeli", 1, "C", 0, 0);
        $pdf->MultiCell(41, 10, "Toplam Sözleşme \n Bedeli", 1, "C", 0, 0);
        $pdf->Ln(); // Yeni satıra geç
        $row_numbers = range(1, 4);
        foreach ($row_numbers as $row_number) {
            $pdf->SetX($xPosition);
            $pdf->SetLineWidth(0.1); // Çizgi kalınlığı (ince çizgi)
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(41, 6, "", 1, 0, "L", 0);
            $pdf->Cell(41, 6, "", 1, 0, "L", 0);
            $pdf->Cell(41, 6, "", 1, 0, "L", 0);
            $pdf->Cell(41, 6, "", 1, 0, "L", 0);
            $pdf->Ln(); // Yeni satıra geç
        }

        $pdf->SetX($xPosition);
        $pdf->SetLineWidth(0.1); // Çizgi kalınlığı (ince çizgi)
        $pdf->SetFont('dejavusans', 'B', 8);
        $pdf->MultiCell(41, 11, "Süre Uzatım Kararlarının \n Karar Tarihi | Sayısı", 1, "C", 0, 0);
        $pdf->MultiCell(41, 11, "Verilen Süre", 1, "C", 0, 0);
        $pdf->MultiCell(41, 11, "İş Bitim Tarihi", 1, "C", 0, 0);
        $pdf->MultiCell(41, 11, "Uzatım Sebebi", 1, "C", 0, 0);
        $pdf->Ln(); // Yeni satıra geç
        $row_numbers = range(1, 4);
        foreach ($row_numbers as $row_number) {
            $pdf->SetX($xPosition);
            $pdf->SetLineWidth(0.1); // Çizgi kalınlığı (ince çizgi)
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(41, 6, "", 1, 0, "L", 0);
            $pdf->Cell(41, 6, "", 1, 0, "L", 0);
            $pdf->Cell(41, 6, "", 1, 0, "L", 0);
            $pdf->Cell(41, 6, "", 1, 0, "L", 0);
            $pdf->Ln(); // Yeni satıra geç
        }

        $file_name = "01 - Hakediş Raporu(Kapak)-" . contract_name($contract->id) . "-Hak " . $payment->hakedis_no;

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public
    function print_report($payment_id, $P_or_D = null)
    {


        $payment = $this->Payment_model->get(array("id" => $payment_id));

        $viewData = new stdClass();
        $contract = $this->Contract_model->get(array("id" => $payment->contract_id));


        $viewData->payment = $payment;
        $viewData->contract = $contract;

        $advance_given = sum_from_table("advance", "avans_miktar", $contract->id);
        $sum_old_advance = $this->Payment_model->sum_all(array('contract_id' => $payment->contract_id, "hakedis_no" => $payment->hakedis_no), "I");

        $contractor = $this->Company_model->get(array("id" => $contract->yuklenici));
        $owner = $this->Company_model->get(array("id" => $contract->isveren));
        $viewData->contractor = $contractor;
        $viewData->owner = $owner;


        $yuklenici = company_name($contract->yuklenici);
        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        $page_width = $pdf->getPageWidth();


        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();


// Çerçeve için boşlukları belirleme
        $topMargin = 20;  // 4 cm yukarıdan
        $bottomMargin = 20;  // 4 cm aşağıdan
        $rightMargin = 20;  // 2 cm sağdan
        $leftMargin = 20;  // 2 cm soldan

// Çerçeve renk ve kalınlığını ayarla
        $pdf->SetDrawColor(0, 0, 0); // Siyah renk
        $pdf->SetLineWidth(0.5); // Çizgi kalınlığı

// Çerçeve çizme
        $pdf->Rect($leftMargin, $topMargin, $pdf->getPageWidth() - $rightMargin - $leftMargin, $pdf->getPageHeight() - $bottomMargin - $topMargin);

        $pdf->SetFont('dejavusans', 'B', 12);

// Metin eklemek (örnek olarak ilk satır)
        $yPosition = $topMargin; // 5 cm yukarıdan başla
        $xPosition = $leftMargin; // 2 cm soldan başla
        $pdf->SetXY($xPosition, $yPosition);
        $pdf->SetLineWidth(0.1); // Çizgi kalınlığı

        $pdf->Cell(170, 10, 'HAKEDİŞ RAPORU', 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetX(20);
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->Cell(120, 7, mb_strtoupper($contract->sozlesme_ad), 1, 0, "L", 0);
        $pdf->Cell(50, 7, "Hakediş No : " . $payment->hakedis_no, 1, 0, "R", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(20);
        $pdf->SetFont('dejavusans', 'N', 9);
        $pdf->Cell(170, 7, dateFormat_dmy($payment->imalat_tarihi) . " TARİHİNE KADR YAPILAN İŞİN", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $cells = array(
            array(
                array("text" => "A", "width" => "10", "font_size" => "N", "justify" => "C", "border" => 1),
                array("text" => "Sözleşme Fiyatları ile Yapılan İşin Tutarı", "width" => "110", "font_size" => "N", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->A) . " " . $contract->para_birimi, "width" => "50", "font_size" => "N", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "B", "width" => "10", "font_size" => "N", "justify" => "C", "border" => 1),
                array("text" => "Fiyat Farkı Tutarı", "width" => "110", "font_size" => "N", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->B) . " " . $contract->para_birimi, "width" => "50", "font_size" => "N", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "C", "width" => "10", "font_size" => "B", "justify" => "C", "border" => 1),
                array("text" => "Toplam Tutar (A+B)", "width" => "110", "font_size" => "B", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->C) . " " . $contract->para_birimi, "width" => "50", "font_size" => "B", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "170", "font_size" => "B", "justify" => "C", "border" => 1)
            ),
            array(
                array("text" => "D", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 1),
                array("text" => "Bir Önceki Hakedişin Toplam Tutarı", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->D) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "E", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 1),
                array("text" => "Bu Hakedişin Tutarı (C-D)", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->E) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "F", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 1),
                array("text" => "KDV (E x %" . $payment->F_a . ")", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->E) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "G", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 1),
                array("text" => "Taahhuk Tutarı", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->G) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 0),
                array("text" => "a) Gelir / Kurumlar Vergisi (E X %" . $payment->Kes_a_s . ")", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->Kes_a) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 0),
                array("text" => "b) Damga Vergisi (E X %" . $payment->Kes_b_s . ")", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->Kes_b) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 0),
                array("text" => "c) KDV Tevkifatı (F X (" . ($payment->Kes_c_s * 10) . "/10))", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->Kes_c) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 0),
                array("text" => "d) Sosyal Sigortalar Kurumu Kesintisi", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->Kes_d) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 0),
                array("text" => "e) Geçici Kabul Kesintisi (G x %" . $payment->Kes_e_s . ")", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->Kes_e) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 0),
                array("text" => "f) İş Makinesi Kiraları", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->Kes_f) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 0),
                array("text" => "g) Gecikme Cezası", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->Kes_g) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 0),
                array("text" => "h) İş Sağlığı ve Güvenliği Cezası", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->Kes_h) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 0),
                array("text" => "i) Diğer", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->Kes_i) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 0),
                array("text" => "j) Bu Hakedişte Ödenen Fiyat Farkı Teminatı Kesintisi (B X %" . $payment->Kes_j_s . ")", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->Kes_j) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "H", "width" => "10", "font_size" => "b", "justify" => "C", "border" => 1),
                array("text" => "Kesinti ve Mahsuplar Toplamı", "width" => "110", "font_size" => "b", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->H) . " " . $contract->para_birimi, "width" => "50", "font_size" => "b", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "I", "width" => "10", "font_size" => "n", "justify" => "C", "border" => 1),
                array("text" => "Avans Mahsubu (A X %" . "$payment->I_s" . ")", "width" => "110", "font_size" => "n", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->I) . " " . $contract->para_birimi, "width" => "50", "font_size" => "n", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "", "width" => "10", "font_size" => "B", "justify" => "C", "border" => 1),
                array("text" => "Yükleniciye Ödenecek Tutar (G-H-I)", "width" => "110", "font_size" => "B", "justify" => "L", "border" => 1),
                array("text" => money_format($payment->balance) . " " . $contract->para_birimi, "width" => "50", "font_size" => "B", "justify" => "R", "border" => 1)
            ),
            array(
                array("text" => "Yazıyla : " . yaziyla_para($payment->balance) . " " . $contract->para_birimi, "width" => "170", "font_size" => "B", "justify" => "R", "border" => 1),
            ),
        );


        foreach ($cells as $row) {
            $pdf->SetX(20);

            foreach ($row as $cell) {
                $text = $cell["text"];
                $width = $cell["width"];
                $justify = $cell["justify"];
                $font_size = $cell["font_size"];
                $border = $cell["border"];
                $pdf->SetFont('dejavusans', $font_size, 9);
                $pdf->Cell($width, 6, $text, $border, 0, $justify, 0);
            }
            $pdf->Ln(); // Bir alt satıra geç
        }

        $pdf->SetXY(20, 176);
        $pdf->SetFont('dejavusans', "B", 9);
        $pdf->Cell(50, 10, "YÜKLENİCİ", 0, 0, "C", 0);
        $pdf->Cell(120, 10, "KONTROL", 0, 0, "C", 0);
        $pdf->Rect(20, 176, 50, 101);
        $pdf->Rect(70, 176, 120, 101);
        $pdf->SetFont('dejavusans', "N", 8);

        $pdf->Ln(); // Bir alt satıra geç
        $pdf->SetXY(20, 200);
        $pdf->SetFont('dejavusans', "N", 8);
        $pdf->MultiCell(50, 20, "\n" . upper_tr($contractor->company_name), 0, "C", "0", 0);
        $pdf->Ln(); // Bir alt satıra geç
        $pdf->SetXY(70, 203);

        $signs = $this->Payment_sign_model->get_all(array("contract_id" => $contract->id, "sign_page" => "report_sign", "approved" => null), "rank ASC");

        $sign_number = count($signs);

        foreach ($signs as $key => $sign) {
            if ($sign_number == 1) {
                $pdf->MultiCell(120, 20, $sign->name . "\n" . $sign->position, 0, "C", 0, 0);
            } elseif ($sign_number == 2) {
                $pdf->MultiCell(60, 20, $sign->name . "\n" . $sign->position, 0, "C", 0, 0);
            } elseif ($sign_number == 3) {
                $pdf->MultiCell(40, 20, $sign->name . "\n" . $sign->position, 0, "C", 0, 0);
            } elseif ($sign_number == 4) {
                if ($key == 2) {
                    $pdf->Ln(30);
                    $pdf->SetX(70);
                }
                $pdf->MultiCell(60, 20, $sign->name . "\n" . $sign->position, 0, "C", 0, 0);
            } elseif ($sign_number == 5) {
                if ($key == 3) {
                    $pdf->Ln(30);
                    $pdf->SetX(70);
                }
                if ($key > 2) {
                    $pdf->MultiCell(60, 20, $sign->name . "\n" . $sign->position, 0, "C", 0, 0);
                } else {
                    $pdf->MultiCell(40, 20, $sign->name . "\n" . $sign->position, 0, "C", 0, 0);
                }
            } elseif ($sign_number == 6) {
                if ($key == 3) {
                    $pdf->Ln(30);
                    $pdf->SetX(70);
                }
                $pdf->MultiCell(40, 20, $sign->name . "\n" . $sign->position, 0, "C", 0, 0);
            }
        }

        $approved_signs = $this->Payment_sign_model->get_all(array("contract_id" => $contract->id, "sign_page" => "report_sign", "approved !=" => null), "rank ASC");

        $approved_signs_number = count($approved_signs);

        $pdf->SetXY(70, 260);

        foreach ($approved_signs as $key => $sign) {
            if ($approved_signs_number == 1) {
                $pdf->MultiCell(120, 10, ". . / . . / . . . . " . "\n" . $sign->approved . "\n" . $sign->name . "\n" . $sign->position, 0, "C", 0, 0);
            } elseif ($approved_signs_number == 2) {
                $pdf->MultiCell(60, 10, ". . / . . / . . . ." . "\n" . $sign->approved . "\n" . $sign->name . "\n" . $sign->position, 0, "C", 0, 0);
            }
        }

        $file_name = "02 - Hakediş Raporu(Hesap Cetveli)-" . contract_name($contract->id) . "-Hak " . $payment->hakedis_no;

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public
    function update_payment($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $payment = $this->Payment_model->get(
            array(
                "id" => "$id",
            )
        );

        $contract_id = $payment->contract_id;
        $settings_id = get_from_any("payment_settings", "id", "contract_id", "$contract_id");

        $gecici_teminat = ($this->input->post("gecici_teminat") == "on") ? 1 : 0;
        if ($gecici_teminat == 1) {
            $gecici_teminat_oran = $this->input->post("gecici_teminat_oran");
        } else {
            $gecici_teminat_oran = 0;
        }

        $fiyat_fark = ($this->input->post("fiyat_fark") == "on") ? 1 : 0;
        $fiyat_fark_kes = ($this->input->post("fiyat_fark_kes") == "on") ? 1 : 0;

        $damga_vergisi = ($this->input->post("damga_vergisi") == "on") ? 1 : 0;
        if ($damga_vergisi == 1) {
            $damga_oran = $this->input->post("damga_oran");
        } else {
            $damga_oran = 0;
        }

        $stopaj = ($this->input->post("stopaj") == "on") ? 1 : 0;
        if ($stopaj == 1) {
            $stopaj_oran = $this->input->post("stopaj_oran");
        } else {
            $stopaj_oran = 0;
        }

        $kdv = ($this->input->post("kdv") == "on") ? 1 : 0;
        if ($kdv == 1) {
            $kdv_oran = $this->input->post("kdv_oran");
            $tevkifat_oran = $this->input->post("tevkifat_oran");
        } else {
            $kdv_oran = 0;
            $tevkifat_oran = 0;
        }

        $avans = ($this->input->post("avans") == "on") ? 1 : 0;
        if ($avans == 1) {
            $avans_oran = $this->input->post("avans_oran");
        } else {
            $avans_oran = 0;
        }

        $avans_mahsup = ($this->input->post("avans_mahsup") == "on") ? 1 : 0;
        $avans_stopaj = ($this->input->post("avans_stopaj") == "on") ? 1 : 0;

        if (empty($settings_id)) {
            $insert = $this->Payment_settings_model->add(
                array(
                    "contract_id" => $contract_id,
                    "gecici_teminat" => $gecici_teminat,
                    "gecici_teminat_oran" => $gecici_teminat_oran,
                    "fiyat_fark" => $fiyat_fark,
                    "fiyat_fark_kesintisi" => $fiyat_fark_kes,
                    "damga_vergisi" => $damga_vergisi,
                    "damga_vergisi_oran" => $damga_oran,
                    "stopaj" => $stopaj,
                    "stopaj_oran" => $stopaj_oran,
                    "kdv" => $kdv,
                    "kdv_oran" => $kdv_oran,
                    "tevkifat_oran" => $tevkifat_oran,
                    "avans" => $avans,
                    "avans_oran" => $avans_oran,
                    "avans_mahsup" => $avans_mahsup,
                    "avans_stopaj" => $avans_stopaj,
                )
            );
        } else {
            $update = $this->Payment_settings_model->update(
                array(
                    "id" => $settings_id,
                ),
                array(
                    "contract_id" => $contract_id,
                    "gecici_teminat" => $gecici_teminat,
                    "gecici_teminat_oran" => $gecici_teminat_oran,
                    "fiyat_fark" => $fiyat_fark,
                    "fiyat_fark_kesintisi" => $fiyat_fark_kes,
                    "damga_vergisi" => $damga_vergisi,
                    "damga_vergisi_oran" => $damga_oran,
                    "stopaj" => $stopaj,
                    "stopaj_oran" => $stopaj_oran,
                    "kdv" => $kdv,
                    "kdv_oran" => $kdv_oran,
                    "tevkifat_oran" => $tevkifat_oran,
                    "avans" => $avans,
                    "avans_oran" => $avans_oran,
                    "avans_mahsup" => $avans_mahsup,
                    "avans_stopaj" => $avans_stopaj
                )
            );
        }
        // TODO Alert sistemi eklenecek...
        if ($insert) {
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Hakediş Ayarları Yapıldı, Hakediş Girişi Yapabilirsiniz",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Hakediş Ayarları Güncellendi",
                "type" => "success"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("$this->Module_Name/$this->Display_route/$id/settings"));
    }

    public
    function sign_options($id, $module)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $contract_id = contract_id_module("payment", $id);
        $approved = $this->input->post("approved");
        $position = $this->input->post("position");
        $name = $this->input->post("name");

        $this->load->library("form_validation");

        if (!empty($approved)) {
            $this->form_validation->set_rules("approved", "Üst Yazı", "min_length[3]|alpha_tr|trim"); //2
        } else {
            $approved = null;
        }
        $this->form_validation->set_rules("position", "Ünvan", "min_length[3]|required|alpha_tr|trim"); //2
        $this->form_validation->set_rules("name", "Ad-Soyad", "min_length[3]|required|alpha_tr|trim"); //2

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "alpha_tr" => "<b>{field}</b> harflerden oluşmalıdır",
                "min_length" => "<b>{field}</b> en az <b>{param}</b> uzunluğunda olmalıdır.",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {
            $insert = $this->Payment_sign_model->add(
                array(
                    "contract_id" => $contract_id,
                    "sign_page" => $module,
                    "position" => $position,
                    "approved" => $approved,
                    "name" => $name,
                )
            );
            // TODO Alert sistemi eklenecek...
            if ($insert) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "İmza Ayarları Yapıldı",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "İmza Ayarları Güncellendi",
                    "type" => "success"
                );
            }
            $this->session->set_flashdata("alert", $alert);

            $viewData = new stdClass();
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;

            $viewData->item = $this->Payment_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Payment_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/signs/$module", $viewData, true);
            echo $render_html;
        } else {
            $alert = array(
                "title" => "İsim veya Ünvan Bilgilerinde Eksik Var",
                "text" => "İmza Ayarları Güncellenemedi",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;

            $viewData->form_error = true;

            $viewData->item = $this->Payment_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Payment_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                )
            );

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/signs/$module", $viewData, true);
            print_r(validation_errors());
            echo $render_html;
        }
    }

    public
    function delete_sign($id, $module, $payment_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $delete = $this->Payment_sign_model->delete(
            array(
                "id" => $id
            )
        );
        // TODO Alert sistemi eklenecek...
        if ($delete) {
            $alert = array(
                "title" => "İmza Sütunu Silindi",
                "text" => "İmza Ayarları Yapıldı",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İmza Sütunu Silinemedi",
                "text" => "İmza Ayarları Güncellendi",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->item = $this->Payment_model->get(
            array(
                "id" => $payment_id
            )
        );

        $viewData->item_files = $this->Payment_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $payment_id
            )
        );

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/signs/$module", $viewData, true);
        echo $render_html;
    }

    public
    function sign_rankSetter()
    {
        $data = $this->input->post("data");

        parse_str($data, $order);
        $items = $order['sub'];

        foreach ($items as $rank => $id) {
            $this->Payment_sign_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "rank" => $rank,
                )
            );
        }
    }


}

