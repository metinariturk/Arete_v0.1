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

        $this->load->model("Contract_model");
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
        $items = $this->Payment_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "durumu" => 1
            )
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "select";
        $viewData->items = $items;
        $viewData->active_contracts = $active_contracts;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($contract_id = null, $boq_id = null)
    {
        if ($contract_id == null) {
            $contract_id = $this->input->post("contract_id");
        }

        if (count_payments($contract_id) == 0) {
            $payment_no = 1;
        } else {
            $payment_no = last_payment($contract_id) + 1;
        }
        //Önceki Metraj Kontrolü
        $boq_control = get_from_any_and("boq", "contract_id", "$contract_id", "payment_no", "$payment_no");

        $error = array();
        $fiyat_fark = get_from_id("contract", "fiyat_fark", "$contract_id");
        $fiyat_fark_teminat = get_from_id("contract", "fiyat_fark_teminat", "$contract_id");
        $final_date = get_from_id("contract", "final_date", "$contract_id");
        $sitedel_date = get_from_id("contract", "sitedel_date", "$contract_id");
        $workplan = get_from_id("contract", "workplan_payment", "$contract_id");
        $teminat_oran = get_from_id("contract", "teminat_oran", "$contract_id");
        $advances = get_from_any_array("advance", "contract_id", "$contract_id");
        $costincs = get_from_any_array("costinc", "contract_id", "$contract_id");

        $fiyat_fark_error = null;

        if ($fiyat_fark == 1) {
            if ($fiyat_fark_teminat != 1) {
                $payment_fiyat_fark = sum_anything("payment", "bu_fiyat_fark", "contract_id", "$contract_id");
                $bond_fiyat_fark = sum_anything_and("bond", "teminat_miktar", "contract_id", "$contract_id", "teminat_gerekce", "price_diff");
                $min_bond = $payment_fiyat_fark * $teminat_oran / 100;
                if ($bond_fiyat_fark < $min_bond) {
                    $fiyat_fark_error = "Fiyat Farkı Teminat Mektubu Giriniz veya Hakediş Ayarlarından Teminat Bedeli Hakedişten Düşülmesini Ayarlayınız.*" . base_url("bond/new_form_contract/$contract_id");
                } else {
                    $fiyat_fark_error = null;
                }
            } else {
                $fiyat_fark_error = null;
            }
        } else {
            $fiyat_fark_error = null;
        }


        if (!empty($final_date)) {
            $error_final = "Kesin Kabul Yapılmış Olan İşe Hakediş Girilemez*" . base_url("contract/file_form/$contract_id/final");
        } else {
            $error_final = null;
        }

        $error_advance = null;

        if (isset($advances)) {
            foreach ($advances as $advance) {
                $teminat = get_from_any_and("bond", "contract_id", "$contract_id", "teminat_avans_id", "$advance->id");
                if (empty($teminat)) {
                    $error_advance = "Verilen avansa ait teminat mektubu bulunamadı. Avans teminatı girilmeden hakediş yapılamaz.*" . base_url("bond/new_form_advance/$advance->id");
                } else {
                    $error_advance = null;
                }
            }
        } else {
            $error_advance = null;
        }


        $error_costinc = null;

        if (isset($costincs)) {
            foreach ($costincs as $costinc) {
                $constinc_bond = get_from_any_and("bond", "contract_id", "$contract_id", "teminat_kesif_id", "$costinc->id");
                if (empty($constinc_bond)) {
                    $error_costinc = $costinc->dosya_no . "Verilen keşif artışına ait teminat mektubu bulunamadı. Keşif artışı teminatı girilmeden hakediş yapılamaz.*" . base_url("bond/new_form_costinc/$costinc->id");
                } else {
                    $error_costinc = null;
                }
            }
        } else {
            $error_costinc = null;
        }

        if (empty($sitedel_date)) {
            $error_sitedel = "Yer Teslimi Yapılmamış Olan İşe Hakediş Girilemez*" . base_url("contract/file_form/$contract_id/sitedel");
        } else {
            $error_sitedel = null;
        }

        if (empty($workplan)) {
            $error_workplan = "Ödeme Planı Oluşturulmadan Hakediş Girilemez*" . base_url("contract/file_form/$contract_id/workplan");
        } else {
            $error_workplan = null;
        }

        $teminat = get_from_any_and("bond", "contract_id", "$contract_id", "teminat_gerekce", "contract");

        if (empty($teminat)) {
            $error_bond = "Sözleşme Teminatı Olmadan Hakediş Girilemez?*" . base_url("Bond/new_form_contract/$contract_id");
        } else {
            $error_bond = null;
        }

        $error_array = array(
            $fiyat_fark_error,
            $error_final,
            $error_advance,
            $error_costinc,
            $error_sitedel,
            $error_workplan,
            $error_bond
        );

        $error_empty = !array_filter($error_array, function ($value) {
            return !empty($value);
        });

        $contract_type = get_from_id("contract", "official", "$contract_id");

        if ($contract_type == 1) {
            if ($error_empty) {
                $error_isset = true;
            } else {
                $error_isset = false;
            }
        } else {
            echo $error_isset = true;
        }

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */
        $items = $this->Payment_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
                "durumu" => 1
            )
        );

        $settings = $this->Settings_model->get();
        $contract = $this->Contract_model->get(array(
                "id" => $contract_id
            )
        );
        $payments = $this->Payment_model->get_all(array(
                "contract_id" => $contract_id
            )
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->payment_no = $payment_no;

        if ($boq_control) {
            $boq = $this->Boq_model->get(array(
                    "id" => $boq_control
                )
            );
        } else {
            $boq = null;
        }

        $viewData->boq = $boq;

        $viewData->payment_no = $payment_no;
        $viewData->error_array = $error_array;
        $viewData->error_isset = $error_isset;
        $viewData->active_contracts = $active_contracts;
        $viewData->contract_id = $contract_id;
        if ((!empty($this->input->post("contract_id"))) or !empty($contract_id)) {
            $viewData->project_id = project_id_cont($contract_id);
        }
        $viewData->contract = $contract;
        $viewData->settings = $settings;
        $viewData->payments = $payments;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public
    function file_form($id, $active_tab = null)
    {

        $contract_id = contract_id_module("payment", $id);
        $payment_no = get_from_id("payment", "hakedis_no", "$id");
        $main_groups = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => 1), "rank ASC");
        $active_boqs = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "main_group" => null, "sub_group" => null,), "rank ASC");
        $prices = get_from_id("contract", "price", "$contract_id");
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
        $viewData->prices = json_decode($prices, true);


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


            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_report", $viewData, true);

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

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/display/tabs/tab_report", $viewData, true);
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

            $delete3 = $this->Boq_model->delete(
                array(
                    "contract" => $contract_id,
                    "payment_no" => $hakedis_no
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
    function print_green($payment_id, $hide_zero = null)
    {
        $contract_id = get_from_id("payment", "contract_id", "$payment_id");
        $active_boqs_json = get_from_id("contract", "active_boq", "$contract_id");
        $active_boqs = json_decode($active_boqs_json, true);
        $payment_no = get_from_id("payment", "hakedis_no", "$payment_id");
        $calculates = $this->Boq_model->get_all(array(
            "contract_id" => $contract_id,
            "payment_no" => $payment_no,
        ));

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

        $pdf->module = "green";
        $pdf->headerSubText = "İşin Adı : " . contract_name($contract_id);
        $pdf->headerPaymentNo = "Hakediş No :" . $payment_no;

        $pdf->headerText = "METRAJ İCMALİ";
        $pdf->parametre = 1; // Parametreyi belirleyin (1 veya 2)

        $pdf->custom_footer = array(
            "Firma Adı" => "Biberci İnşaat",
            "İnşaat Mühendisi" => "Musab ÖZKAĞNICI",
            "Mimar" => "Buse ÖZÜPAK",
            "Elk Mühendisi" => "Caner Özüpak",
            "Mak Mühendisi" => "Abdullah KIRIŞKA",
            "Haberleşme Müh" => "Abdullah KIRIŞKA"
        );
        $page_width = $pdf->getPageWidth();
        $pdf->AddPage();
        $pdf->SetFontSize(10);
        $pdf->Cell($page_width, 5, "", 0, 0, "L", 0);
        $pdf->SetFillColor(150, 150, 150); // Gri rengi ayarlayın (RGB renk kodu)

        $i = 0;
        $j = 0;
        foreach ($active_boqs as $group_key => $boq_ids) {
            $i = $i + 2;
            $j = $j + 1;
            $k = 0;

            $say = count($boq_ids);

            $last_cell = $i + $say;
            if ($last_cell > 24) {
                $pdf->AddPage(); // Yeni bir sayfa ekleyin
                $i = 1;
            }
            $pdf->Ln();
            $pdf->SetFont('dejavusans', 'B', 9); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır

            $group_name = boq_name($group_key);
            $pdf->SetFillColor(192, 192, 192);
            $pdf->Cell(15, 5, intToRoman($j), 1, 0, "C", 1);
            $pdf->Cell(265, 5, mb_strtoupper($group_name), 1, 0, "L", 1);
            $pdf->Ln();
            foreach ($boq_ids as $boq_id) {
                $k = $k + 1;
                $foundItems = array_filter($calculates, function ($item) use ($boq_id) {
                    return $item->boq_id == $boq_id;
                });
                $old_total_array = $this->Boq_model->get_all(
                    array(
                        "contract_id" => $item->contract_id,
                        "payment_no <" => $item->hakedis_no,
                        "boq_id" => $boq_id,
                    )
                );
                if (!empty($old_total_array)) {
                    $old_total = sum_anything_and_and("boq", "total", "contract_id", $item->contract_id, "payment_no <", $item->hakedis_no, "boq_id", "$boq_id");
                } else {
                    $old_total = 0;
                }
                if (!empty($foundItems)) {
                    foreach ($foundItems as $foundItem) {
                        $i = $i + 1;
                        $name = yazim_duzeni(boq_name($boq_id));
                        $unit = mb_strtolower(boq_unit($boq_id));
                        $total = $foundItem->total + $old_total;
                    }
                } else {
                    $i = $i + 1;
                    $name = yazim_duzeni(boq_name($boq_id));
                    $unit = mb_strtolower(boq_unit($boq_id));
                    $total = $old_total;
                }
                $pdf->SetFont('dejavusans', '', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                $now = (!empty($foundItems)) ? $foundItem->total : "0.00";


                if ($hide_zero == 1) {
                    if ($total != 0) {
                        $pdf->Cell(15, 5, $k, 1, 0, "C", 0);
                        $pdf->Cell(25, 5, $boq_id, 1, 0, "L", 0);
                        $pdf->Cell(140, 5, $name, 1, 0, "L", 0);
                        $pdf->Cell(16, 5, $unit, 1, 0, "C", 0);
                        $pdf->Cell(28, 5, money_format($total), 1, 0, "R", 0);
                        $pdf->Cell(28, 5, money_format($old_total), 1, 0, "R", 0);
                        $pdf->Cell(28, 5, money_format($now), 1, 0, "R", 0);
                        $pdf->Ln();
                    }
                } elseif ($hide_zero == 0) {
                    $pdf->Cell(15, 5, $k, 1, 0, "C", 0);
                    $pdf->Cell(25, 5, $boq_id, 1, 0, "L", 0);
                    $pdf->Cell(140, 5, $name, 1, 0, "L", 0);
                    $pdf->Cell(16, 5, $unit, 1, 0, "C", 0);
                    $pdf->Cell(28, 5, money_format($total), 1, 0, "R", 0);
                    $pdf->Cell(28, 5, money_format($old_total), 1, 0, "R", 0);
                    $pdf->Cell(28, 5, money_format($now), 1, 0, "R", 0);
                    $pdf->Ln();
                } elseif ($hide_zero == 2) {
                    if (!empty($foundItems)) {
                        $pdf->Cell(15, 5, $k, 1, 0, "C", 0);
                        $pdf->Cell(25, 5, $boq_id, 1, 0, "L", 0);
                        $pdf->Cell(140, 5, $name, 1, 0, "L", 0);
                        $pdf->Cell(16, 5, $unit, 1, 0, "C", 0);
                        $pdf->Cell(28, 5, money_format($total), 1, 0, "R", 0);
                        $pdf->Cell(28, 5, money_format($old_total), 1, 0, "R", 0);
                        $pdf->Cell(28, 5, money_format($now), 1, 0, "R", 0);
                        $pdf->Ln();
                    }
                }
            }
        }
        $pdf->Output('example.pdf');
    }

    public
    function print_calculate($payment_id, $seperate_group = null)
    {
        $contract_id = get_from_id("payment", "contract_id", "$payment_id");
        $active_boqs_json = get_from_id("contract", "active_boq", "$contract_id");
        $active_boqs = json_decode($active_boqs_json, true);
        $payment_no = get_from_id("payment", "hakedis_no", "$payment_id");
        $calculates = $this->Boq_model->get_all(array(
            "contract_id" => $contract_id,
            "payment_no" => $payment_no,
        ));

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

        $pdf->custom_footer = array(
            "Firma Adı" => "Biberci İnşaat",
            "İnşaat Mühendisi" => "Musab ÖZKAĞNICI",
            "Mimar" => "Buse ÖZÜPAK",
            "Elk Mühendisi" => "Caner Özüpak",
            "Mak Mühendisi" => "Abdullah KIRIŞKA",
            "Haberleşme Müh" => "Abdullah KIRIŞKA"
        );

        if ($seperate_group != 1) {
            $pdf->AddPage();
        }

        $page_width = $pdf->getPageWidth() - $pdf->getMargins()['left'] - $pdf->getMargins()['right'];

        $k = 1;

        foreach ($active_boqs as $group_key => $boq_ids) {
            if ($seperate_group == 1) {
                $pdf->AddPage();
            }
            $pdf->setLineWidth(0.1);
            $pdf->SetFillColor(139, 139, 139);
            $pdf->SetFont('dejavusans', '', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
            $pdf->Cell($page_width * 10 / 100, 5, $group_key, 1, 0, "L", 1);
            $pdf->Cell($page_width * 90 / 100, 5, mb_strtoupper(boq_name($group_key)), 1, 0, "L", 1);
            $pdf->Ln();
            $k = $k + 1;
            foreach ($boq_ids as $boq_id) {
                foreach ($calculates as $calculation_item) {
                    if ($calculation_item->boq_id == $boq_id) {
                        $calculation_datas = json_decode($calculation_item->calculation, true);
                        $pdf->SetFillColor(192, 192, 192);
                        $pdf->setLineWidth(0.1);
                        $pdf->Cell($page_width * 10 / 100, 5, $boq_id, 1, 0, "L", 1);
                        $pdf->Cell($page_width * 90 / 100, 5, mb_strtoupper(boq_name($boq_id)) . " - " . boq_unit($boq_id), 1, 0, "L", 1);
                        $pdf->Ln();
                        $k = $k + 1;
                        $pdf->SetFillColor(224, 224, 224);

                        $pdf->setLineWidth(0.1);
                        $pdf->SetDrawColor(0, 0, 0); // Çizgi rengi (Siyah: RGB 0,0,0)
                        $pdf->Cell($page_width * 10 / 100, 5, "Bölüm", 1, 0, "L", 1);
                        $pdf->Cell($page_width * 45 / 100, 5, "Açıklama", 1, 0, "L", 1);
                        $pdf->Cell($page_width * 8 / 100, 5, "Miktar", 1, 0, "C", 1);
                        $pdf->Cell($page_width * 8 / 100, 5, "En", 1, 0, "C", 1);
                        $pdf->Cell($page_width * 8 / 100, 5, "Boy", 1, 0, "C", 1);
                        $pdf->Cell($page_width * 8 / 100, 5, "Yükseklik", 1, 0, "C", 1);
                        $pdf->Cell($page_width * 13 / 100, 5, "Toplam", 1, 0, "C", 1);
                        $pdf->Ln();
                        $k = $k + 1;
                        $pdf->SetFillColor();
                        foreach ($calculation_datas as $calculation_data) {
                            $pdf->SetFont('dejavusans', '', 8); // İkinci parametre olarak boş bir dize ile boyut 8 ayarlanır
                            $pdf->setLineWidth(0.1);

                            $pdf->Cell($page_width * 10 / 100, 5, $calculation_data["s"], 1, 0, "L", 0);
                            $pdf->Cell($page_width * 45 / 100, 5, $calculation_data["n"], 1, 0, "L", 0);
                            $pdf->Cell($page_width * 8 / 100, 5, money_format($calculation_data["q"]), 1, 0, "R", 0);
                            $pdf->Cell($page_width * 8 / 100, 5, money_format($calculation_data["w"]), 1, 0, "R", 0);
                            $pdf->Cell($page_width * 8 / 100, 5, money_format($calculation_data["h"]), 1, 0, "R", 0);
                            $pdf->Cell($page_width * 8 / 100, 5, money_format($calculation_data["l"]), 1, 0, "R", 0);
                            $pdf->Cell($page_width * 13 / 100, 5, money_format($calculation_data["t"]), 1, 0, "R", 0);
                            $pdf->Ln();
                            $k = $k + 1;
                        }

                        $pdf->Cell($page_width * 79 / 100, 5, "", 0, 0, "R", 0);
                        $pdf->Cell($page_width * 8 / 100, 5, "Toplam", 1, 0, "R", 0);
                        $pdf->Cell($page_width * 13 / 100, 5, money_format($calculation_item->total), 1, 0, "L", 0);
                        $pdf->Ln();
                        $k = $k + 1;
                    }
                }
                $pdf->Ln();
                $k = $k + 1;
            }


        }
        $pdf->Output('example.pdf');
    }

    public function update_payment($id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }
        $contract_id = contract_id_module("payment", "$id");
        $settings_id = get_from_any("payment_settings", "id", "contract_id", "$contract_id");
        $gecici_teminat = ($this->input->post("gecici_teminat") == "on") ? 1 : 0;
        $gecici_teminat_oran = $this->input->post("gecici_teminat_oran");
        $fiyat_fark = ($this->input->post("fiyat_fark") == "on") ? 1 : 0;
        $fiyat_fark_kes = ($this->input->post("fiyat_fark_kes") == "on") ? 1 : 0;
        $damga_vergisi = ($this->input->post("damga_vergisi") == "on") ? 1 : 0;
        $damga_oran = $this->input->post("damga_oran");
        $stopaj = ($this->input->post("stopaj") == "on") ? 1 : 0;
        $stopaj_oran = $this->input->post("stopaj_oran");
        $kdv = ($this->input->post("kdv") == "on") ? 1 : 0;
        $kdv_oran = $this->input->post("kdv_oran");
        $tevkifat_oran = $this->input->post("tevkifat_oran");
        $avans = ($this->input->post("avans") == "on") ? 1 : 0;
        $avans_oran = $this->input->post("avans_oran");
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

    public function sign_options($id, $module)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $contract_id = contract_id_module("payment", $id);
        $payment_settings = $this->Payment_settings_model->get(array("contract_id" => $contract_id));


        $old_signs = json_decode($payment_settings->$module, true);

        $position = $this->input->post("position");
        $name = $this->input->post("name");

        $this->load->library("form_validation");

        $this->form_validation->set_rules("position", "Ünvan", "min_length[3]|required|alpha|trim"); //2
        $this->form_validation->set_rules("name", "Ad-Soyad", "min_length[3]|required|alpha|trim"); //2

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "alpha" => "<b>{field}</b> harflerden oluşmalıdır",
                "min_length" => "<b>{field}</b> en az <b>{param}</b> uzunluğunda olmalıdır.",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {
            $newData = array(
                'position' => $position,
                'name' => $name
            );

            $old_signs[] = $newData;

            $newJsonData = json_encode($old_signs);

            $update = $this->Payment_settings_model->update(
                array(
                    "id" => $payment_settings->id
                ),
                array(
                    $module => $newJsonData
                )
            );
            // TODO Alert sistemi eklenecek...
            if ($update) {
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
            $payment_settings = $this->Payment_settings_model->get(array("contract_id" => $contract_id));

            $viewData->payment_settings = $payment_settings;

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
            $payment_settings = $this->Payment_settings_model->get(array("contract_id" => $contract_id));

            $viewData->payment_settings = $payment_settings;
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

    public function delete_sign($id, $module)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $contract_id = contract_id_module("payment", $id);
        $payment_settings = $this->Payment_settings_model->get(array("contract_id" => $contract_id));


        $delete = $this->Payment_settings_model->update(
            array(
                "id" => $payment_settings->id
            ),
            array(
                $module => null
    )
    );
        // TODO Alert sistemi eklenecek...
        if ($delete) {
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
        $payment_settings = $this->Payment_settings_model->get(array("contract_id" => $contract_id));

        $viewData->payment_settings = $payment_settings;

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
    }


}

