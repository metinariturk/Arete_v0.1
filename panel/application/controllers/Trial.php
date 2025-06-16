<?php
class Trial extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $models = [
            'Boq_model',
            'Payment_model',
            'Contract_model',
            'Contract_price_model',
            'Project_model',
        ];
        foreach ($models as $model) {
            $this->load->model($model);
        }


    }

    public function file_form()
    {

        $viewData = new stdClass();

        $this->load->view("trial_page/display/index", $viewData);
    }
}
