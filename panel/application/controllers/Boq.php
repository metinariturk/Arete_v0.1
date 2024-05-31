<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


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

        $update = $this->Contract_price_model->update(
            array(
                "id" => $boq_id
            ),
            array(
                "type" => null,
            )
        );


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

        if (empty($payment->A)){
            $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/calculate", $viewData, true);
        } else {
            $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/show_calculate", $viewData, true);
        }

        echo $render_calculate;
    }

    public function rebar_render($contract_id, $payment_id, $boq_id)
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $update = $this->Contract_price_model->update(
            array(
                "id" => $boq_id
            ),
            array(
                "type" => "rebar",
            )
        );

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

        if (empty($payment->A)){
            $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/rebar", $viewData, true);
        } else {
            $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/show_rebar", $viewData, true);
        }

        echo $render_calculate;
    }

    public function save($contract_id, $payment_id, $stay = null)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $payment = $this->Payment_model->get(array('id' => $payment_id));

        $boq_id = ($this->input->post('boq_id'));
        $boq_array = ($this->input->post('boq[]'));

        if (empty($boq_array)){
            redirect(base_url("payment/file_form/$payment->id"));
        }

        $contract_item = $this->Contract_price_model->get(array("id" => $boq_id));

        $boq_total = ($this->input->post("total_$boq_id"));

        foreach ($boq_array as $key => $sub_array) {
            if (empty(array_filter($sub_array))) {
                unset($boq_array[$key]);
            }
        }


        $old_boq = $this->Boq_model->get(
            array(
                "boq_id" => $boq_id,
                "contract_id" => $contract_id,
                "payment_no" => $payment->hakedis_no
            )
        );

        if (isset($old_boq)) {
            $delete = $this->Boq_model->delete(
                array(
                    "boq_id" => $boq_id,
                    "contract_id" => $contract_id,
                    "payment_no" => $payment->hakedis_no
                )
            );
        }

        if (!empty($_FILES['excelDosyasi']['name'])) {
            $tempFolderPath = 'uploads/temp/';

// Temp klasör yoksa oluştur
            if (!is_dir($tempFolderPath)) {
                if (!mkdir($tempFolderPath, 0777, true)) {
                    die('Temp klasör oluşturulamadı...');
                }
            }

            $tempFilePath = $_FILES['excelDosyasi']['tmp_name'];

            $targetFilePath = 'uploads/temp/' . $_FILES['excelDosyasi']['name'];
            move_uploaded_file($tempFilePath, $targetFilePath);

            $workbook = IOFactory::load($targetFilePath);

            $worksheet = $workbook->getActiveSheet();


            $dataArray = array();
            $startRow = 7;
            $endRow = 3000; // 3000 satır daha eklendiğini varsayıyorum

// Boş satır sayacını tanımlayın
            $emptyRowCount = 0;

// Her bir satır için döngü oluşturun
            for ($row = $startRow; $row <= $endRow; $row++) {
                // Her bir satırdaki B'den G'ye kadar olan hücrelerden veriyi alarak bir dizi oluşturun
                $rowData = array(
                    's' => $worksheet->getCell('B' . $row)->getValue(),
                    'n' => $worksheet->getCell('C' . $row)->getValue(),
                    'q' => $worksheet->getCell('D' . $row)->getValue(),
                    'w' => $worksheet->getCell('E' . $row)->getValue(),
                    'h' => $worksheet->getCell('F' . $row)->getValue(),
                    'l' => $worksheet->getCell('G' . $row)->getValue()
                );

                // Satırın boş olup olmadığını kontrol edin
                $isEmptyRow = true;
                foreach ($rowData as $cellValue) {
                    if (!empty($cellValue)) {
                        $isEmptyRow = false;
                        break;
                    }
                }

                // Eğer satır boşsa boş satır sayacını artır, aksi takdirde sıfırla
                if ($isEmptyRow) {
                    $emptyRowCount++;
                } else {
                    $emptyRowCount = 0;
                }

                // Boş satır sayacı 10 ise döngüyü durdur
                if ($emptyRowCount >= 5) {
                    break;
                }

                // Oluşturulan dizi, ana diziye eklenir
                $dataArray[] = $rowData;
            }

            $boq_array = ($this->input->post('boq[]'));

            $mergedArray = array_merge($dataArray, $boq_array);

            foreach ($mergedArray as $key => $sub_array) {
                if (empty(array_filter($sub_array))) {
                    unset($mergedArray[$key]);
                }
            }



            $insert = $this->Boq_model->add(
                array(
                    "contract_id" => $contract_id,
                    "boq_id" => $boq_id,
                    "sub_id" => $contract_item->sub_id,
                    "leader_id" => $contract_item->leader_id,
                    "main_id" => $contract_item->main_id,
                    "payment_no" => $payment->hakedis_no,
                    "calculation" => json_encode($mergedArray),
                    "total" => $boq_total,
                    "createdAt" => date("Y-m-d H:i:s"),
                )
            );
        } else {
            $insert = $this->Boq_model->add(
                array(
                    "contract_id" => $contract_id,
                    "boq_id" => $boq_id,
                    "sub_id" => $contract_item->sub_id,
                    "main_id" => $contract_item->main_id,
                    "leader_id" => $contract_item->leader_id,
                    "payment_no" => $payment->hakedis_no,
                    "calculation" => json_encode($boq_array),
                    "total" => $boq_total,
                    "createdAt" => date("Y-m-d H:i:s"),
                )
            );
        }

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


        // İşlemin Sonucunu Session'a yazma işlemi...
        $this->session->set_flashdata("alert", $alert);

        if ($stay != null) {
            redirect(base_url("payment/file_form/$payment_id"));
        }

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

        if ($contract_item->type == "rebar"){
            $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/rebar", $viewData, true);
        } else {
            $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/calculate", $viewData, true);
        }

        echo $render_calculate;



    }

    public function delete($contract_id, $payment_no, $boq_id)
    {


        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $boq = $this->Boq_model->get(array("boq_id" => $boq_id,
                "contract_id" => $contract_id,
                "payment_no" => $payment_no)
        );

        $delete = $this->Boq_model->delete(
            array(
                "id" => $boq->id,
                "contract_id" => $contract_id,
                "payment_no" => $payment_no
            )
        );

        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $payment = $this->Payment_model->get(array('contract_id' => $contract_id, "hakedis_no" => $payment_no));

        $viewData->payment = $payment;
        $viewData->contract = $contract;

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

    public function template_download($contract_id, $payment_id, $boq_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        // Ödeme bilgilerini al
        $this->load->model("Company_model");

        $payment = $this->Payment_model->get(array('id' => $payment_id));
        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $company = $this->Company_model->get(array('id' => $contract->isveren));
        $boq = $this->Contract_price_model->get(array('id' => $boq_id));

        // BOQ verilerini al
        $old_boq = $this->Boq_model->get(
            array(
                "boq_id" => $boq_id,
                "contract_id" => $contract_id,
                "payment_no" => $payment->hakedis_no
            )
        );

        // Excel şablonunu yükle
        $templatePath = 'uploads/Excel_Template.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A2', "$company->company_name" );
        $sheet->setCellValue('A3', "$contract->sozlesme_ad" );
        $sheet->setCellValue('A4', "$boq->name" );
        $sheet->setCellValue('H4', "$boq->unit" );

        // BOQ hesaplama verilerini al
        if (isset($old_boq)) {
            $dataArray = json_decode($old_boq->calculation, true);
        } else {
            $dataArray = array();
        }
        // Hücrelere veriyi yaz
        $row = 7;
        foreach ($dataArray as $data) {
            $sheet->setCellValue('B' . $row, $data['s']);
            $sheet->setCellValue('C' . $row, $data['n']);
            $sheet->setCellValue('D' . $row, $data['q']);
            $sheet->setCellValue('E' . $row, $data['w']);
            $sheet->setCellValue('F' . $row, $data['h']);
            $sheet->setCellValue('G' . $row, $data['l']);
            $row++;
        }

        // Dosyayı indirme
        $writer = new Xlsx($spreadsheet);
        $downloadFileName = "$boq->name - $payment->hakedis_no Nolu Hakediş.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $downloadFileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function template_download_rebar($contract_id, $payment_id, $boq_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        // Ödeme bilgilerini al
        $this->load->model("Company_model");

        $payment = $this->Payment_model->get(array('id' => $payment_id));
        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $company = $this->Company_model->get(array('id' => $contract->isveren));
        $boq = $this->Contract_price_model->get(array('id' => $boq_id));

        // BOQ verilerini al
        $old_boq = $this->Boq_model->get(
            array(
                "boq_id" => $boq_id,
                "contract_id" => $contract_id,
                "payment_no" => $payment->hakedis_no
            )
        );



        // BOQ hesaplama verilerini al
        if (isset($old_boq)) {
            $dataArray = json_decode($old_boq->calculation, true);
        } else {
            $dataArray = array();
        }


        $dataArrayCount = count($dataArray);
        $nearestValues = array(100, 200, 300, 400, 500, 600, 750, 1000, 1500, 2000);
        $roundedCount = roundToNearest($dataArrayCount, $nearestValues);


        // Excel şablonunu yükle
        $templatePath = "uploads/Excel_Template_Rebar_$roundedCount.xlsx";
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A2', "$company->company_name" );
        $sheet->setCellValue('A3', "$contract->sozlesme_ad" );
        $sheet->setCellValue('A4', "$boq->name" );
        $sheet->setCellValue('H4', "$boq->unit" );

        // Hücrelere veriyi yaz
        $row = 7;
        foreach ($dataArray as $data) {
            $sheet->setCellValue('B' . $row, $data['s']);
            $sheet->setCellValue('C' . $row, $data['n']);
            $sheet->setCellValue('D' . $row, $data['q']);
            $sheet->setCellValue('E' . $row, $data['w']);
            $sheet->setCellValue('F' . $row, $data['h']);
            $sheet->setCellValue('G' . $row, $data['l']);
            $row++;
        }

        // Dosyayı indirme
        $writer = new Xlsx($spreadsheet);
        $downloadFileName = "$boq->name - $payment->hakedis_no Nolu Hakediş.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $downloadFileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
