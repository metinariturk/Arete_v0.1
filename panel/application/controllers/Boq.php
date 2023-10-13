<?php

class Boq extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

               if (!get_active_user()) {
            redirect(base_url("login"));
        }
 $this->Theme_mode = get_active_user()->mode;        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        $this->load->model("Boq_model");
        $this->load->model("Contract_model");
        $this->load->model("Project_model");
        $this->load->model("Order_model");

        $this->moduleFolder = "contract_module";
        $this->viewFolder = "boq_v";
        $this->Module_Title = "Metraj";


        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";

        $this->Module_Name = "Boq";

    }

    public function index()
    {
        $viewData = new stdClass();

        $items = $this->Boq_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array('durumu' => 1));

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = $this->List_Folder;
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->active_contracts = $active_contracts;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($contract_id = null, $payment_no = null)
    {
        $viewData = new stdClass();

        $this_control = get_from_any_and("boq", "contract_id", "$contract_id", "payment_no", "$payment_no");

        $this_boq = $this_control ? $this->Boq_model->get(array("id" => $this_control)) : null;
        $viewData->this_boq = $this_boq;
        $viewData->boq_calculate = $this_boq ? json_decode($this_boq->calculation, true) : null;

        $old_select = get_from_any_array("boq", "contract_id", "$contract_id");

        if ($old_select) {
            $last_payment = array_column($old_select, 'payment_no');
            rsort($last_payment);
            if (count($last_payment) > 1) {
                $last_payment_no = $last_payment[1];
                $old_control = get_from_any_and("boq", "contract_id", "$contract_id", "payment_no", "$last_payment_no");
                $old = $old_control ? $this->Boq_model->get(array("id" => $old_control)) : null;
                $viewData->old_boq = $old;
                $viewData->boq_calculate = $old ? json_decode($old->calculation, true) : null;
            }
        }

        $this_boq = null;
        $viewData->boq = $this_boq;

        $old_select = get_from_any_array("boq", "contract_id", "$contract_id");

        if ($old_select) {
            $last_payment = max(array_column($old_select, 'payment_no'));
            $old_control = get_from_any_and("boq", "contract_id", "$contract_id", "payment_no", "$last_payment");
            $old = $old_control ? $this->Boq_model->get(array("id" => $old_control)) : null;
            $viewData->old_boq = $old;
            $viewData->boq_calculate = $old ? json_decode($old->calculation, true) : null;
        }

        $contract = $this->Contract_model->get(array("id" => $contract_id));

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = $this->Add_Folder;
        $viewData->contract = $contract;
        $viewData->payment_no = $payment_no;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function file_form($id)
    {
        $viewData = new stdClass();

        $contract_id = contract_id_module("boq", $id);
        $project_id = project_id_cont($contract_id);

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = $this->Display_Folder;
        $viewData->project_id = $project_id;
        $viewData->contract_id = $contract_id;
        $viewData->item = $this->Boq_model->get(array("id" => $id));

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save($contract_id, $payment_no)
    {
        $calculates = json_encode($this->input->post("calculate[]"));
        $remove_space = str_replace(' ', '', $calculates);
        $sayi = str_replace(',', '.', str_replace(' ', '', $this->input->post("this_payment")));

        $boq_control = get_from_any_and("boq", "contract_id", "$contract_id", "payment_no", "$payment_no");

        if ($boq_control) {
            $update = $this->Boq_model->update(array("id" => $boq_control), array("calculation" => $remove_space, "total" => $sayi));
        } else {
            $insert = $this->Boq_model->add(array("contract_id" => $contract_id, "payment_no" => $payment_no, "calculation" => $remove_space, "total" => $sayi));
        }

        $record_id = $this->db->insert_id();

        $insert2 = $this->Order_model->add(array(
            "module" => $this->Module_Name,
            "connected_module_id" => $record_id,
            "connected_contract_id" => $contract_id,
            "createdAt" => date("Y-m-d H:i:s"),
            "createdBy" => active_user_id()
        ));

        $alert = ($insert || $update) ? array("title" => "İşlem Başarılı", "text" => "Kayıt başarılı bir şekilde eklendi/güncellendi", "type" => "success") : array("title" => "İşlem Başarısız", "text" => "Kayıt Ekleme sırasında bir problem oluştu", "type" => "danger");
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("payment/new_form/$contract_id/$record_id"));
    }
}
