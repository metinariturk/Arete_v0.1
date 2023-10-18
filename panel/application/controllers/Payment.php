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
 $this->Theme_mode = get_active_user()->mode;        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        $this->moduleFolder = "contract_module";
        $this->viewFolder = "payment_v";
        $this->load->model("Payment_model");
        $this->load->model("Payment_file_model");

        $this->load->model("Contract_model");
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
    function file_form($id, $active_tab = null) {


        $contract_id = contract_id_module("payment", $id);
        $payment_no = get_from_id("payment","hakedis_no","$id");
        $active_boqs = get_from_id("contract","active_boq","$contract_id");

        $viewData = new stdClass();
        $contract = $this->Contract_model->get(array(
            "id" => $contract_id
        ));

        $calculates = $this->Boq_model->get_all(array(
            "contract_id" => $contract_id,
            "payment_no" => $payment_no,
        ));

        $project_id = project_id_cont($contract_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->contract = $contract;
        $viewData->calculates = $calculates;
        $viewData->active_boqs = json_decode($active_boqs,true);
        $viewData->project_id = $project_id;
        $viewData->active_tab = $active_tab;



        $item = $this->Payment_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item = $item;


        $boq_control = get_from_any_and("boq", "contract_id", "$contract_id", "payment_no", "$item->hakedis_no");

        if ($boq_control) {
            $boq = $this->Boq_model->get(array(
                    "id" => $boq_control
                )
            );
            $viewData->boq = $boq;

        } else {
            $boq = null;
            $viewData->boq = null;

        }


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

        $file_name_len = file_name_digits();
        $file_name = "HAK-" . $this->input->post('dosya_no');
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

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[payment.dosya_no]|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
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
                    "dosya_no" => $file_name,
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
                    "file_order" => $file_name,
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
    function save($contract_id)
    {

        $is_negative = $this->input->post("is_negative");

        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);

        $contract = $this->Contract_model->get(array(
                "id" => $contract_id
            )
        );

        $file_name_len = file_name_digits();
        $file_name = "HAK-" . $this->input->post('dosya_no');
        $hak_no = $this->input->post('hakedis_no');

        $a = $this->input->post('toplam_imalat');
        $last_total_imalat = sum_payments("bu_imalat", $contract_id);
        $b = $this->input->post('toplam_ihzarat');


        $c = $a + $b;
        $last_total_ihzarat = sum_payments("bu_ihzarat", $contract_id);


        $limit = limit_cost($contract_id);

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

        $limit_advance = limit_advance($contract_id);
        $setoff_advance = sum_payments("avans_mahsup_miktar", $contract_id);

        $currency = get_currency($contract_id);

        $this->load->library("form_validation");

        $this->form_validation->set_rules("dosya_no", "Dosya No", "greater_than[0]|is_unique[payment.dosya_no]|trim|exact_length[$file_name_len]|callback_duplicate_code_check");
        $this->form_validation->set_rules("hakedis_no", "Hakediş No", "required|numeric|trim"); //2
        if ($hak_no == 1) {
            $this->form_validation->set_rules("imalat_tarihi", "İmalat Tarihi", "trim|callback_sitedel_paymentday[$yer_teslimi_tarihi]"); //2
        }
        if ($hak_no != 1) {
            $this->form_validation->set_rules("imalat_tarihi", "İmalat Tarihi", "trim|callback_sitedel_paymentday[$last_payment_day]"); //2
        }

        $this->form_validation->set_rules("bu_imalat", "Bu İmalat Bedeli", "required|numeric|trim"); //2
        if ($is_negative != "on") {
            $this->form_validation->set_rules("toplam_imalat", "Toplam İmalat Bedeli", "required|greater_than_equal_to[$last_total_imalat]|less_than_equal_to[$c]|numeric|trim"); //2
        }
        $this->form_validation->set_rules("bu_ihzarat", "Bu İhzarat Bedeli", "numeric|trim"); //2
        $this->form_validation->set_rules("toplam_ihzarat", "Toplam İhzarat Bedeli", "greater_than_equal_to[$last_total_ihzarat]|less_than_equal_to[$c]|numeric|trim"); //2

        if ($contract->fiyat_fark == 1) {
            $this->form_validation->set_rules("bu_fiyat_fark", "Fiyat Farkı", "required|numeric|trim"); //2
            $this->form_validation->set_rules("toplam_fiyat_fark", "Toplam Fiyat Farkı", "required|numeric|trim"); //2
        }
        $this->form_validation->set_rules("iif", "İmalat İhzarat ve Fiyat Farkı Toplamı", "numeric|trim"); //2
        $this->form_validation->set_rules("ara_toplam", "Toplam Bedel", "numeric|trim"); //2
        $this->form_validation->set_rules("bu_imalat_ihzarat", "Bu Hakediş Tutarı", "numeric|trim"); //2
        $this->form_validation->set_rules("kdv_oran", "KDV Oran", "trim"); //2
        $this->form_validation->set_rules("kdv_tutar", "KDV Tutar", "numeric|trim"); //2
        $this->form_validation->set_rules("taahhuk", "Taahhuk Tutar", "numeric|trim"); //2
        $this->form_validation->set_rules("stopaj_oran", "Stopaj Oranı", "numeric|trim"); //2
        $this->form_validation->set_rules("stopaj_tutar", "Stopaj Tutar", "numeric|trim"); //2
        $this->form_validation->set_rules("damga_oran", "Damga Vergisi Oranı", "numeric|trim"); //2
        $this->form_validation->set_rules("damga_tutar", "Damga Vergisi Tutarı", "numeric|trim"); //2
        $this->form_validation->set_rules("tevkifat_oran", "KDV Tevkifat Oranı", "numeric|trim"); //2
        $this->form_validation->set_rules("tevkifat_tutar", "Tevkifat Tutar", "numeric|trim"); //2
        $this->form_validation->set_rules("sgk", "SGK Kesintisi", "numeric|trim"); //2
        $this->form_validation->set_rules("makine", "İş Makinesi Kesintisi", "numeric|trim"); //2
        $this->form_validation->set_rules("gecikme", "Gecikme Cezası", "numeric|trim"); //2
        $this->form_validation->set_rules("avans_mahsup_miktar", "Avans Mahsup", "numeric|trim"); //2
        $this->form_validation->set_rules("gecici_kabul_kesinti", "Nakit Geçici Kabul Kesintisi", "numeric|trim"); //2
        $this->form_validation->set_rules("diger_1", "Diğer Kesinti", "numeric|trim"); //2
        $this->form_validation->set_rules("diger_2", "Diğer Kesinti", "numeric|trim"); //2
        $this->form_validation->set_rules("kesinti_toplam", "Kesinti Toplamı", "numeric|trim"); //2
        $this->form_validation->set_rules("fiyat_fark_teminat", "Fiyat Farkı Teminatı", "numeric|trim"); //2
        $this->form_validation->set_rules("net_bedel", "Ödenecek Net Bedel", "numeric|trim"); //2
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "numeric" => "<b>{field}</b> rakamlardan oluşmalıdır",
                "limit_advance" => "<b>{field}</b> en fazla kadar olmalıdır.",
                "sitedel_paymentday" => "Uygulama <b>{field}</b>  $warning <b>{param}</b> tarhihinden daha ileri bir tarih olmalı",
                "greater_than_equal_to" => "<b>{field}</b> alanı <b>{param}</b> dan büyük bir sayı olmalıdır",
                "less_than_equal_to" => "<b>{field}</b> sözleşme ve keşif artışları dahil <b>{param}</b> $currency'den fazla hakediş girişi yapılamaz . Keşif artışı tanımlamak için sözleşme ekranından keşif artışı verebilirsiniz.",
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

            if ($this->input->post('toplam_ihzarat') == null) {
                $ihzarat = 0;
            }

            $insert = $this->Payment_model->add(
                array(
                    "contract_id" => $contract_id,
                    "dosya_no" => $file_name,
                    "hakedis_no" => $this->input->post('hakedis_no'),
                    "imalat_tarihi" => $imalat_tarihi,
                    "toplam_imalat" => $this->input->post('toplam_imalat'),
                    "toplam_ihzarat" => $this->input->post('toplam_ihzarat'),
                    "toplam_imalat_ihzarat" => $this->input->post('toplam_imalat') + $ihzarat,
                    "bu_imalat" => $this->input->post('bu_imalat'),
                    "bu_ihzarat" => $this->input->post('bu_ihzarat'),
                    "bu_imalat_ihzarat" => $this->input->post('bu_imalat') + $this->input->post('bu_ihzarat'),
                    "bu_fiyat_fark" => $this->input->post('bu_fiyat_fark'),
                    "toplam_fiyat_fark" => $this->input->post('toplam_fiyat_fark'),
                    "ara_toplam" => $this->input->post('ara_toplam'),
                    "onceki_iif" => $this->input->post('onceki_iif'),
                    "bu_iif" => $this->input->post('bu_iif'),
                    "kdv_oran" => $this->input->post('kdv_oran'),
                    "kdv_tutar" => $this->input->post('kdv_tutar'),
                    "taahhuk" => $this->input->post('taahhuk'),
                    "stopaj_oran" => $this->input->post('stopaj_oran'),
                    "stopaj_tutar" => $this->input->post('stopaj_tutar'),
                    "damga_oran" => $this->input->post('damga_oran'),
                    "damga_tutar" => $this->input->post('damga_tutar'),
                    "tevkifat_oran" => $this->input->post('tevkifat_oran'),
                    "tevkifat_tutar" => $this->input->post('tevkifat_tutar'),
                    "sgk" => $this->input->post('sgk'),
                    "makine" => $this->input->post('makine'),
                    "gecikme" => $this->input->post('gecikme'),
                    "avans_mahsup_miktar" => $this->input->post('avans_mahsup_miktar'),
                    "avans_mahsup_oran" => $this->input->post('avans_mahsup_oran'),
                    "gecici_kabul_kesinti" => $this->input->post('gecici_kabul_kesinti'),
                    "diger_1" => $this->input->post('diger_1'),
                    "diger_2" => $this->input->post('diger_2'),
                    "fiyat_fark_teminat" => $this->input->post('fiyat_fark_teminat'),
                    "kesinti_toplam" => $this->input->post('kesinti_toplam'),
                    "net_bedel" => $this->input->post('net_bedel'),
                    "currency" => get_from_any("contract", "para_birimi", "id", "$contract_id"),
                    "final" => $final,
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
            redirect(base_url("$this->Module_Name/$this->Display_route/$record_id"));

        } else {


            $error = array();


            $fiyat_fark = get_from_id("contract", "fiyat_fark", "$contract_id");
            $fiyat_fark_teminat = get_from_id("contract", "fiyat_fark_teminat", "$contract_id");
            $final_date = get_from_id("contract", "final_date", "$contract_id");
            $sitedel_date = get_from_id("contract", "sitedel_date", "$contract_id");
            $workplan = get_from_id("contract", "workplan_payment", "$contract_id");
            $teminat_oran = get_from_id("contract", "teminat_oran", "$contract_id");
            $advances = get_from_any_array("advance", "contract_id", "$contract_id");
            $costincs = get_from_any_array("costinc", "contract_id", "$contract_id");

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
                $error_bond = "Sözleşme Teminatı Olmadan Hakediş Girilemez*" . base_url("bond/new_form_contract/$contract_id");
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

            if (count_payments($contract_id) == 0) {
                $payment_no = 1;
            } else {
                $payment_no = last_payment($contract_id) + 1;
            }

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
            $viewData->error_array = $error_array;
            $viewData->error_isset = $error_isset;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public
    function delete($id, $boq = null)
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

            if ($boq != null) {
                $delete_boq = $this->Boq_model->delete(
                    array(
                        "contract_id" => $contract_id,
                        "payment_no" => $hakedis_no
                    )
                );
            }

            // TODO Alert Sistemi Eklenecek...
            if ($delete1 and $delete2) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "$module_unique_name başarılı bir şekilde silindi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "$module_unique_name silme sırasında bir problem oluştu",
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

}
