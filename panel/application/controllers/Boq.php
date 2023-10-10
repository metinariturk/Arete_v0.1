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

        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        $this->moduleFolder = "contract_module";
        $this->viewFolder = "boq_v";
        $this->load->model("Boq_model");
        $this->load->model("Contract_model");
        $this->load->model("Payment_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Order_model");
        $this->load->model("Bond_model");
        $this->load->model("Bond_file_model");

        $this->Module_Name = "Boq";
        $this->Module_Title = "Metraj";
        $this->Upload_Folder = "uploads";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "contract";
        $this->Module_File_Dir = "boq";
        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir/";
        $this->File_Dir_Suffix = "$this->Module_Depended_Dir/$this->Module_File_Dir/";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Dependet_id_key = "Boq_id";
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
        $items = $this->Boq_model->get_all(array());
        $projects = $this->Project_model->get_all(array());
        $active_contracts = $this->Contract_model->get_all(array(
            'durumu' => 1
        ));


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->List_Folder";
        $viewData->items = $items;
        $viewData->projects = $projects;
        $viewData->active_contracts = $active_contracts;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form($contract_id = null, $payment_no = null)
    {
        $viewData = new stdClass();


        $this_control = get_from_any_and("boq", "contract_id", "$contract_id", "payment_no", "$payment_no");


        if ($this_control) {
            $this_boq = $this->Boq_model->get(array(
                    "id" => $this_control
                )
            );
            $viewData->this_boq = $this_boq;
            $viewData->boq_calculate = json_decode($this_boq->calculation, true);

            $old_select = get_from_any_array("boq", "contract_id", "$contract_id");


            if (isset($old_select)) {
                $last_payment = (array_column($old_select, 'payment_no'));
                rsort($last_payment);
                if ((count($last_payment)) > 1) {
                    $last_payment_no = $last_payment[1];
                    $old_control = get_from_any_and("boq", "contract_id", "$contract_id", "payment_no", "$last_payment_no");
                    if ($old_control) {
                        $old = $this->Boq_model->get(array(
                                "id" => $old_control
                            )
                        );
                        $viewData->old_boq = $old;
                        $viewData->boq_calculate = json_decode($old->calculation, true);
                    } else {
                        $old = null;
                        $viewData->old_boq = $old;
                    }
                }
            }

        } else {
            $this_boq = null;
            $viewData->boq = $this_boq;

            $old_select = get_from_any_array("boq", "contract_id", "$contract_id");


            if (isset($old_select)) {
                $last_payment = (max(array_column($old_select, 'payment_no')));
                $old_control = get_from_any_and("boq", "contract_id", "$contract_id", "payment_no", "$last_payment");
                if ($old_control) {
                    $old = $this->Boq_model->get(array(
                            "id" => $old_control
                        )
                    );
                    $viewData->old_boq = $old;
                    $viewData->boq_calculate = json_decode($old->calculation, true);
                } else {
                    $old = null;
                    $viewData->old_boq = $old;
                }
            }

        }

        /** Tablodan Verilerin Getirilmesi.. */
        $contract = $this->Contract_model->get(array("id" => $contract_id));

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Add_Folder";
        $viewData->contract = $contract;
        $viewData->payment_no = $payment_no;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public
    function update_form($id)
    {

        $viewData = new stdClass();


        $contract_id = contract_id_module("newprice", $id);
        $project_id = project_id_cont($contract_id);


        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Update_Folder";
        $viewData->project_id = $project_id;
        $viewData->contract_id = $contract_id;

        $viewData->item = $this->Boq_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Boq_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public
    function file_form($id)
    {

        $viewData = new stdClass();

        echo $contract_id = contract_id_module("newprice", $id);
        echo $project_id = project_id_cont($contract_id);

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $viewData->project_id = $project_id;
        $viewData->contract_id = $contract_id;

        $viewData->item = $this->Boq_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Boq_file_model->get_all(
            array(
                "$this->Dependet_id_key" => $id
            ),
        );
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public
    function save($contract_id, $payment_no)
    {

        $calculates = json_encode($this->input->post("calculate[]"));
        $remove_space = str_replace(' ', '', $calculates);

        $sayi = $this->input->post("this_payment");
        $sayi = str_replace(' ', '', $sayi);
        $sayi = str_replace(',', '.', $sayi);


        $boq_control = get_from_any_and("boq", "contract_id", "$contract_id", "payment_no", "$payment_no");

        if ($boq_control) {
            $update = $this->Boq_model->update(
                array(
                    "id" => $boq_control
                ),
                array(
                    "calculation" => $calculates,
                    "total" => $sayi,
                )
            );

        } else {
            $insert = $this->Boq_model->add(
                array(
                    "contract_id" => $contract_id,
                    "payment_no" => $payment_no,
                    "calculation" => $remove_space,
                    "total" => $sayi,
                )
            );
        }


        $record_id = $this->db->insert_id();

        $insert2 = $this->Order_model->add(
            array(
                "module" => $this->Module_Name,
                "connected_module_id" => $record_id,
                "connected_contract_id" => $contract_id,
                "createdAt" => date("Y-m-d H:i:s"),
                "createdBy" => active_user_id(),
            )
        );

        if ($insert or $update) {
            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Kayıt başarılı bir şekilde eklendi/güncellendi",
                "type" => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                "type" => "danger"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("payment/new_form/$contract_id/$record_id"));
    }


    public
    function update($id)
    {
        $contract_id = contract_id_module("newprice", "$id");
        $contract_day = dateFormat_dmy(get_from_id("contract", "sozlesme_tarih", "$contract_id"));

        $this->load->library("form_validation");

        $this->form_validation->set_rules("ybf_tarih", "Verildiği Tarih", "callback_newprice_contractday[$contract_day]|required|trim");
        $this->form_validation->set_rules("karar_no", "Karar No", "required|trim");
        $this->form_validation->set_rules("ybf_tutar", "YBF Tutar", "greater_than[0]|required|trim|numeric");
        if ($this->input->post('ybf_oran') >= 20) {
            if ($this->input->post('onay') != "on") {
                $this->form_validation->set_rules("ybf_oran", "YBF Oran", "less_than_equal_to[20]|required|trim");
            } else {
                $this->form_validation->set_rules("ybf_oran", "YBF Oran", "numeric|required|trim");
            }
        }
        $this->form_validation->set_rules("aciklama", "Yeni Birim Fiyat Notları", "required|trim"); //4

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "integer" => "<b>{field}</b> alanı pozitif tam sayı olmalıdır",
                "numeric" => "<b>{field}</b> alanı rakamlardan oluşmalıdır",
                "greater_than" => "<b>{field}</b> <b>{param}</b> 'den büyük bir sayı olmalıdır",
                "newprice_contractday" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
                "less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den fazla Yeni Birim Fiyat veriyorsunuz. İşlem doğru ise yandaki kutucuğu işaretleyerek devam ediniz.",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            if ($this->input->post("ybf_tarih")) {
                $ybf_tarihi = dateFormat('Y-m-d', $this->input->post("ybf_tarih"));
            } else {
                $ybf_tarihi = null;
            }

            $update = $this->Boq_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "karar_no" => $this->input->post("karar_no"),
                    "ybf_tarih" => $ybf_tarihi,
                    "ybf_tutar" => $this->input->post("ybf_tutar"),
                    "ybf_oran" => $this->input->post("ybf_oran"),
                    "aciklama" => $this->input->post("aciklama"),
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
            $contract_id = contract_id_module("newprice", $id);
            $project_id = project_id_cont($contract_id);


            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->Boq_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Boq_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $id
                ),
            );

            $contract_id = get_from_any("newprice", "contract_id", "id", "$id");

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "$this->Update_Folder";
            $viewData->project_id = $project_id;
            $viewData->contract_id = $contract_id;
            $viewData->form_error = true;


            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public
    function delete($id)
    {
        //Bağlı teminat silme işlemleri
        $contract_id = contract_id_module("newprice", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);

        if (!empty(get_from_any_and("bond", "contract_id", $contract_id, "teminat_kesif_id", $id))) {
            $bond_id = get_from_any_and("bond", "contract_id", $contract_id, "teminat_kesif_id", $id);
            $bond_file_name = get_from_id("bond", "dosya_no", $bond_id);
            $bond_file_order_id = get_from_any_and("file_order", "connected_module_id", $bond_id, "module", "bond");

            $bond_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Bond/$bond_file_name/";

            $sil_bond = deleteDirectory($bond_path);

            $update_bond_order = $this->Order_model->update(
                array(
                    "id" => $bond_file_order_id
                ),
                array(
                    "deletedAt" => date("Y-m-d H:i:s"),
                    "deletedBy" => active_user_id(),
                )
            );

            $delete_bond_file = $this->Bond_file_model->delete(
                array(
                    "bond_id" => $bond_id
                )
            );

            $delete_bond = $this->Bond_model->delete(
                array(
                    "id" => $bond_id
                )
            );
        }

        $newprice_code = get_from_id("newprice", "dosya_no", $id);

        $newprice_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Boq/$newprice_code/";

        $sil_newprice = deleteDirectory($newprice_path);

        if ($sil) {
            echo '<br>deleted successfully';
        } else {
            echo '<br>errors occured';
        }

        $delete1 = $this->Boq_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        $delete2 = $this->Boq_model->delete(
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

    public
    function file_upload($id)
    {

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $size = $_FILES["file"]["size"];

        $contract_id = contract_id_module("newprice", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = contract_code($contract_id);
        $newprice_code = get_from_id("newprice", "dosya_no", $id);


        $config["allowed_types"] = "*";
        $config["upload_path"] = "$this->File_Dir_Prefix/$project_code/$contract_code/Boq/$newprice_code";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if ($upload) {

            $uploaded_file = $this->upload->data("file_name");

            $this->Boq_file_model->add(
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
    function download_all($newprice_id)
    {
        $this->load->library('zip');
        $this->zip->compression_level = 0;

        $contract_id = contract_id_module("newprice", $newprice_id);
        $project_id = project_id_cont($contract_id);
        $Boq_code = get_from_id("Boq", "dosya_no", "$newprice_id");
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);
        $contract_name = get_from_id("contract", "sozlesme_ad", $contract_id);

        $path = "uploads/project_v/$project_code/$contract_code/Boq/$Boq_code";
        echo $path;

        $files = glob($path . '/*');

        foreach ($files as $file) {
            $this->zip->read_file($file, FALSE);
        }

        $zip_name = $contract_name . "-" . $Boq_code;
        $this->zip->download("$zip_name");

    }

    public
    function file_download($id)
    {
        $fileName = $this->Boq_file_model->get(
            array(
                "id" => $id
            )
        );


        $newprice_id = get_from_id("newprice_files", "newprice_id", $id);
        $contract_id = contract_id_module("newprice", $newprice_id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);
        $newprice_code = get_from_id("newprice", "dosya_no", $newprice_id);

        $file_path = "$this->File_Dir_Prefix/$project_code/$contract_code/Boq/$newprice_code/$fileName->img_url";

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
    function refresh_file_list($id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $viewData->item = $this->Boq_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_files = $this->Boq_file_model->get_all(
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

        $fileName = $this->Boq_file_model->get(
            array(
                "id" => $id
            )
        );

        $newprice_id = get_from_id("newprice_files", "newprice_id", $id);
        $contract_id = contract_id_module("newprice", $newprice_id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);
        $newprice_code = get_from_id("newprice", "dosya_no", $newprice_id);

        $delete = $this->Boq_file_model->delete(
            array(
                "id" => $id
            )
        );


        if ($delete) {

            $path = "$this->File_Dir_Prefix/$project_code/$contract_code/Boq/$newprice_code/$fileName->img_url";

            unlink($path);

            $viewData->item = $this->Boq_model->get(
                array(
                    "id" => $newprice_id
                )
            );

            $viewData->item_files = $this->Boq_file_model->get_all(
                array(
                    "$this->Dependet_id_key" => $newprice_id
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

        $contract_id = get_from_id("newprice", "contract_id", $id);
        $project_id = project_id_cont($contract_id);
        $project_code = project_code($project_id);
        $contract_code = get_from_id("contract", "dosya_no", $contract_id);
        $newprice_code = get_from_id("newprice", "dosya_no", $id);

        $delete = $this->Boq_file_model->delete(
            array(
                "$this->Dependet_id_key" => $id
            )
        );

        if ($delete) {

            $dir_files = directory_map("$this->File_Dir_Prefix/$project_code/$contract_code/Boq/$newprice_code");

            foreach ($dir_files as $dir_file) {
                unlink("$this->File_Dir_Prefix/$project_code/$contract_code/Boq/$newprice_code/$dir_file");
            }

            $viewData->item = $this->Boq_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->item_files = $this->Boq_file_model->get_all(
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
        $file_name = "YBF-" . $file_name;

        $var = count_data("file_order", "file_order", $file_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public
    function newprice_contractday($newprice_day, $contract_day)
    {
        $date_diff = date_minus($newprice_day, $contract_day);
        if (($date_diff < 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
