<?php
class Workmachine extends CI_Controller
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
        $this->moduleFolder = "site_module";
        $this->viewFolder = "workmachine_v";
        $this->load->model("Workmachine_model");
        $this->load->model("Settings_model");
        $this->load->model("Site_model");
        $this->Module_Name = "workmachine";
        $this->Module_Title = "İş Grupları";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "workmachine_id";
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
        
        $items = $this->Workmachine_model->get_all(array());
        $main_categories = $this->Workmachine_model->get_all(array(
            'main_category' => 1
        ));
        
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->items = $items;
        $viewData->main_categories = $main_categories;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function file_form()
    {
        $viewData = new stdClass();
        
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $main_categories = $this->Workmachine_model->get_all(array(
            'main_category' => 1
        ));
        $viewData->main_categories = $main_categories;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function add_sub()
    {
        $parent_id = $this->input->post('main_group');
        $sub_group_name = $this->input->post('sub_group');
        if ((!empty($sub_group_name)) and (!ctype_digit($sub_group_name))) {
            $insert = $this->Workmachine_model->add(
                array(
                    "parent" => "$parent_id",
                    "name" => "$sub_group_name",
                    "sub_category" => 1,
                )
            );
        }
        $viewData = new stdClass();
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $main_categories = $this->Workmachine_model->get_all(array(
            'main_category' => 1
        ));
        $viewData->main_categories = $main_categories;
        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/list", $viewData, true);
        echo $render_html;
    }
    public function add_main()
    {
        $parent_name = $this->input->post('main_group');
        if ((!empty($parent_name)) and (!ctype_digit($parent_name))) {
            $insert = $this->Workmachine_model->add(
                array(
                    "name" => "$parent_name",
                    "main_category" => 1,
                )
            );
        }
        $viewData = new stdClass();
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $main_categories = $this->Workmachine_model->get_all(array(
            'main_category' => 1
        ));
        $viewData->main_categories = $main_categories;
        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/list", $viewData, true);
        echo $render_html;
    }
    public function delete_sub($id)
    {
        $delete = $this->Workmachine_model->delete(
            array(
                "id" => $id
            )
        );
        $viewData = new stdClass();
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $main_categories = $this->Workmachine_model->get_all(array(
            'main_category' => 1
        ));
        $viewData->main_categories = $main_categories;
        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/list", $viewData, true);
        echo $render_html;
    }
    public function delete_main($id)
    {
        $delete = $this->Workmachine_model->delete(
            array(
                "id" => $id
            )
        );
        $delete = $this->Workmachine_model->delete(
            array(
                "parent" => $id
            )
        );
        $viewData = new stdClass();
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $main_categories = $this->Workmachine_model->get_all(array(
            'main_category' => 1
        ));
        $viewData->main_categories = $main_categories;
        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/list", $viewData, true);
        echo $render_html;
    }
}
