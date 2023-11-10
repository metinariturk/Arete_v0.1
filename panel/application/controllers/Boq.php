<?php

class Boq extends CI_Controller
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
        $this->viewFolder = "boq_v";
        $this->load->model("Boq_model");
        $this->load->model("Boq_file_model");
        $this->load->model("Payment_model");
        $this->load->model("Contract_model");
        $this->load->model("Contract_price_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("Bond_model");
        $this->load->model("Bond_file_model");

        $this->Module_Name = "boq";
        $this->Module_Title = "Metraj";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "contract";
        $this->Module_File_Dir = "boq";
        $this->Module_Table = "boq";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "boq_id";
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";
        $this->File_List = "file_list_v";
        $this->Common_Files = "common";
    }

    public function new_form($contract_id = null, $payment_no = null, $boq_id = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        if (empty($payment_no)) {
            if (empty($contract_id)) {
                $contract_id = $this->input->post("contract_id");
                if (empty($contract_id)) {
                    redirect(base_url("dashboard"));
                } else {
                    redirect(base_url("contract/file_form/$contract_id/payment"));
                }
            } elseif (count_payments($contract_id) == 0) {
                $payment_no = 1;
            } else {
                $payment_no = last_payment($contract_id) + 1;
            }
        }

        $contract = $this->Contract_model->get(array(
                "id" => $contract_id
            )
        );

        $payment_id = get_from_any_and("payment", "contract_id", "$contract_id", "hakedis_no", "$payment_no");

        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        $payment = $this->Payment_model->get(array('id' => $payment_id));

        $viewData = new stdClass();
        /** Tablodan Verilerin Getirilmesi.. */

        $settings = $this->Settings_model->get();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->payment_no = $payment_no;
        $viewData->main_groups = $main_groups;
        $viewData->payment_id = $payment_id;
        $viewData->payment = $payment;
        $viewData->contract = $contract;
        $viewData->boq_id = $boq_id;
        $viewData->settings = $settings;
        $viewData->contract_id = $contract_id;

        if ((!empty($this->input->post("contract_id"))) or !empty($contract_id)) {
            $viewData->project_id = project_id_cont($contract_id);
        }
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function calculate_render($contract_id, $payment_id, $boq_id)
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }


        $payment = $this->Payment_model->get(array('id' => $payment_id));
        $viewData = new stdClass();
        $isset_boq =
            get_from_any_and_and("boq",
                "contract_id", "$contract_id",
                "payment_no", "$payment->hakedis_no",
                "boq_id", $boq_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $viewData->income = $boq_id;
        $viewData->payment = $payment;

        if (isset($isset_boq)) {
            $old_boq = $this->Boq_model->get(
                array(
                    "id" => $isset_boq,
                )
            );
            $viewData->old_boq = $old_boq;
        }
        $viewData->contract_id = $contract_id;

        $group_id = get_from_id("book", "parent", "$boq_id");
        $viewData->group_id = $group_id;


        $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/calculate", $viewData, true);

        echo $render_calculate;
    }

    public function save($contract_id = null, $payment_id = null, $stay = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $payment = $this->Payment_model->get(array('id' => $payment_id));

        $total_bypass = $this->input->post('bypass_total');

        $boq_id = ($this->input->post('boq_id'));

        $contract_item = $this->Contract_price_model->get(array("id"=> $boq_id));


        $old_record = get_from_any_and_and(
            "boq",
            "contract_id", "$contract_id",
            "payment_no", "$payment->hakedis_no",
            "boq_id", "$boq_id"
        );


        $boq_array = ($this->input->post('boq[]'));

        if ($total_bypass == "on") {
            $boq_total = ($this->input->post("total_$boq_id"));
        } else {
            $boq_total = 0.0;
            foreach ($boq_array as $item) {
                if (isset($item['t'])) {
                    $boq_total += (float)$item['t'];
                }
            }
        }

        foreach ($boq_array as $key => $sub_array) {
            if (empty(array_filter($sub_array))) {
                unset($boq_array[$key]);
            }
        }

        if (isset($old_record)) {
            $update = $this->Boq_model->update(
                array(
                    "id" => $old_record
                ),
                array(
                    "calculation" => json_encode($boq_array),
                    "total" => $boq_total,
                    "createdAt" => date("Y-m-d H:i:s"),
                    "sub_id" => $contract_item->sub_id,
                    "main_id" => $contract_item->main_id,
                )
            );
            if ($update) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Metraj başarılı bir şekilde güncellendi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Metraj Güncelleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }

        } else {
            $insert = $this->Boq_model->add(
                array(
                    "contract_id" => $contract_id,
                    "boq_id" => $boq_id,
                    "sub_id" => $contract_item->sub_id,
                    "main_id" => $contract_item->main_id,
                    "payment_no" => $payment->hakedis_no,
                    "calculation" => json_encode($boq_array),
                    "total" => $boq_total,
                    "createdAt" => date("Y-m-d H:i:s"),
                )
            );
            if ($insert) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Metraj başarılı bir şekilde eklendi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Metraj Ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }

        }

        // İşlemin Sonucunu Session'a yazma işlemi...
        $this->session->set_flashdata("alert", $alert);

        $viewData = new stdClass();

        $viewData->payment = $payment;

        $isset_boq =
            get_from_any_and_and("boq",
                "contract_id", "$contract_id",
                "payment_no", "$payment->hakedis_no",
                "boq_id", $boq_id);


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $viewData->income = $boq_id;
        if (isset($isset_boq)) {
            $old_boq = $this->Boq_model->get(
                array(
                    "id" => $isset_boq,
                )
            );
            $viewData->old_boq = $old_boq;

        }
        $viewData->contract_id = $contract_id;

        $group_id = get_from_id("book", "parent", "$boq_id");
        $viewData->group_id = $group_id;


        if ($stay != null) {
            redirect(base_url("payment/file_form/$payment_id"));
        }

        $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/calculate", $viewData, true);

        echo $render_calculate;

        //kaydedilen elemanın id nosunu döküman ekleme sayfasına post ediyoruz
    }


    public function delete($boq_id)
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $delete = $this->Boq_model->delete(
            array(
                "id" => $boq_id
            )
        );

        $viewData->payment_no = get_from_id("boq", "payment_no", "$boq_id");
        $viewData->contract_id = get_from_id("boq", "contract_id", "$boq_id");

        $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/calculate", $viewData, true);

        echo $render_calculate;
    }

    public function open_sub($contract_id, $sub_id, $payment_id)
    {
        $sub_cont_items = $this->Contract_price_model->get_all(array("contract_id" => $contract_id, "sub_id" => $sub_id));
        $main_group = $this->Contract_price_model->get(array("contract_id" => $contract_id));
        $sub_group = $this->Contract_price_model->get(array("id" => $sub_id));
        $item = $this->Contract_model->get(array('id' => $contract_id));
        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $payment = $this->Payment_model->get(array('id' => $payment_id));

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "add";
        $viewData->item = $item;
        $viewData->contract = $contract;
        $viewData->payment = $payment;

        $viewData->sub_cont_items = $sub_cont_items;
        $viewData->main_group = $main_group;
        $viewData->sub_id = $sub_id;
        $viewData->sub_group = $sub_group;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/renderSubList", $viewData, true);

        echo $render_html;

    }

    public function back_main($contract_id, $payment_id)
    {

        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));
        $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1));
        $payment = $this->Payment_model->get(array('id' => $payment_id));

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->contract = $contract;
        $viewData->payment = $payment;

        $viewData->main_groups = $main_groups;
        $viewData->sub_groups = $sub_groups;


        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/renderList", $viewData, true);
        echo $render_html;

    }
}
