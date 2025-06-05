<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class Boq extends MY_Controller
{
    public $viewFolder = "";
    public $moduleFolder = "";
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
        $this->rules = array(
            "new_form" => array('boq' => ['w']),
            "calculate_render" => array('boq' => ['r']),
            "rebar_render" => array('boq' => ['r']),
            "save" => array('boq' => ['w', 'u']),
            "save_total" => array('boq' => ['w', 'u']),
            "delete" => array('boq' => ['d', 'u']),
            "open_sub" => array('boq' => ['r', 'w', 'u']),
            "back_main" => array('boq' => ['r', 'w', 'u']),
            "template_download" => array('boq' => ['r']),
            "template_download_rebar" => array('boq' => ['r']),
        );

        $this->check_permissions();
    }

    protected function check_permissions()
    {
        $current_method = strtolower($this->router->method);

        if (!isset($this->rules[$current_method])) {
            show_error($current_method . "Yetki tanımı yapılmamış!", 403);
        }

        foreach ($this->rules[$current_method] as $module => $permissions) {
            if (!user_has_permission($module, $permissions)) {
                show_error('Bu sayfaya erişim yetkiniz yok!', 403);
            }
        }
    }

    public function new_form($contract_id = null, $payment_no = null, $boq_id = null)
    {

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
        $settings = $this->Settings_model->get();

        $viewData->viewModule = "contract_module";
        $viewData->viewFolder = "boq_v";
        $viewData->subViewFolder = "add";
        $viewData->payment_no = $payment_no;
        $viewData->main_groups = $main_groups;
        $viewData->payment_id = $payment_id;
        $viewData->payment = $payment;
        $viewData->contract = $contract;
        $viewData->boq_id = $boq_id;
        $viewData->settings = $settings;
        $viewData->contract_id = $contract_id;
        if ((!empty($this->input->post("contract_id"))) or !empty($contract_id)) {
            $project = $this->Project_model->get(array("id"=> $contract->project_id));
            $viewData->project = $project;
        }
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function calculate_render($contract_id, $payment_id, $boq_id)
    {

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

        $viewData->viewModule = "contract_module";
        $viewData->viewFolder = "boq_v";
        $viewData->subViewFolder = "display";
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

        $viewData->viewModule = "contract_module";
        $viewData->viewFolder = "boq_v";
        $viewData->subViewFolder = "display";
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

        $viewData->viewModule = "contract_module";
        $viewData->viewFolder = "boq_v";
        $viewData->subViewFolder = "display";
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

    public function save_total($contract_id, $payment_id)
    {

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
        $insert = $this->Boq_model->add(
            array(
                "contract_id" => $contract_id,
                "boq_id" => $boq_id,
                "sub_id" => $contract_item->sub_id,
                "leader_id" => $contract_item->leader_id,
                "main_id" => $contract_item->main_id,
                "payment_no" => $payment->hakedis_no,
                "total" => $boq_total,
                "createdAt" => date("Y-m-d H:i:s"),
            )
        );

        exit;

    }
    public function delete($contract_id, $payment_no, $boq_id)
    {

        $viewData = new stdClass();

        $viewData->viewModule = "contract_module";
        $viewData->viewFolder = "boq_v";
        $viewData->subViewFolder = "display";
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

        $viewData->viewFolder = "boq_v";
        $viewData->viewModule = "contract_module";
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

        $viewData->viewModule = "contract_module";
        $viewData->viewFolder = "boq_v";
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
        $this->load->model("Company_model");

        // Veritabanından gerekli verileri al
        $payment = $this->Payment_model->get(array('id' => $payment_id));
        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $company = $this->Company_model->get(array('id' => $contract->isveren));
        $boq = $this->Contract_price_model->get(array('id' => $boq_id));

        // BOQ hesaplama verilerini al
        $old_boq = $this->Boq_model->get(array(
            "boq_id" => $boq_id,
            "contract_id" => $contract_id,
            "payment_no" => $payment->hakedis_no
        ));

        if (isset($old_boq)) {
            $dataArray = json_decode($old_boq->calculation, true);
        } else {
            $dataArray = array();
        }

        // Yeni bir Excel dosyası oluştur
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $title_start_row = 2;

        // 1. satır: METRAJ CETVELİ
        $sheet->mergeCells("B$title_start_row:I$title_start_row");
        $sheet->setCellValue("B$title_start_row", "METRAJ CETVELİ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(20);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$title_start_row:I$title_start_row")->getFont()->setName('Verdana');

        $title_start_row++;
        $title_start_row++;


// 2. satır: İşin adı
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row",  "İşin Adı : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $contract->contract_name);
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $title_start_row++;

// 3. satır: Firma adı
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "Firma : " );
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $company->company_name);
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $title_start_row++;
        
        // 4. satır
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "İmalat Adı : " );
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        
        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $boq->name . "(" . $boq->unit .")" );
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $title_start_row++;
        $total_row = $title_start_row;
        
        // 5. satır
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "Toplam : " );
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", "");
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);



// Satırları doldurma kısmında
        $sheet->getStyle("A1:D$title_start_row")->getFont()->getColor()->setARGB('FF808080'); // Koyu gri için örnek

        $title_start_row++;
        $title_start_row++;
        $counter = 1;

        $table_start = $title_start_row;

        // Kolon başlıkları - A boş, B satır no
        $sheet->setCellValue("A$table_start", '');          // boş bırakıyoruz
        $sheet->setCellValue("B$table_start", 'No');        // Satır numarası
        $sheet->setCellValue("C$table_start", 'Mahal');
        $sheet->setCellValue("D$table_start", 'Açıklama');
        $sheet->setCellValue("E$table_start", 'Adet');
        $sheet->setCellValue("F$table_start", 'En');
        $sheet->setCellValue("G$table_start", 'Boy');
        $sheet->setCellValue("H$table_start", 'Yükseklik');
        $sheet->setCellValue("I$table_start", 'Toplam');

        $sheet->getStyle("E$table_start:I$table_start")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $title_start_row++;
        $sheet->freezePane("A$title_start_row");

        $reference_row = $title_start_row;


        foreach ($dataArray as $data) {
            $sheet->setCellValue('B' . $title_start_row, $counter);  // satır numarası
            $sheet->setCellValue('C' . $title_start_row, $data['s']);
            $sheet->setCellValue('D' . $title_start_row, $data['n']);
            $sheet->setCellValue('E' . $title_start_row, $data['q']);
            $sheet->setCellValue('F' . $title_start_row, $data['w']);
            $sheet->setCellValue('G' . $title_start_row, $data['h']);
            $sheet->setCellValue('H' . $title_start_row, $data['l']);
            $sheet->setCellValue('I' . $title_start_row, "=PRODUCT(E$title_start_row:H$title_start_row)"); // çarpım formülü

            $title_start_row++;
            $counter++;
        }

        $lastDataRow = $title_start_row - 1;

        $sheet->getStyle("B$table_start:I$table_start")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFC000');
        $sheet->getStyle("B$table_start:B$lastDataRow")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFC000');
        $sheet->getStyle("B$table_start:B$lastDataRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$table_start:I$table_start")->getFont()->setBold(true);
        $sheet->getStyle("B$table_start:B$lastDataRow")->getFont()->setBold(true);

        $sheet->setCellValue("D$total_row", "=SUM(I$total_row:I$lastDataRow)");

// Örneğin birim "kg" ise:
        $sheet->getStyle("D$total_row")
            ->getNumberFormat()
            ->setFormatCode('#,##0.00" ' . $boq->unit . '"');

        $sheet->getColumnDimension('A')->setWidth(5);     // boş sütun, biraz geniş bırakabiliriz
        $sheet->getColumnDimension('B')->setWidth(5);     // satır no için yeterli
        $sheet->getColumnDimension('C')->setWidth(14);    // Mahal ~100px
        $sheet->getColumnDimension('D')->setWidth(28);    // Açıklama ~195px
        $sheet->getColumnDimension('E')->setWidth(9);     // Adet ~60px
        $sheet->getColumnDimension('F')->setWidth(9);     // En ~60px
        $sheet->getColumnDimension('G')->setWidth(9);     // Boy ~60px
        $sheet->getColumnDimension('H')->setWidth(9);     // Yükseklik ~60px
        $sheet->getColumnDimension('I')->setWidth(11);    // Toplam ~70px

        $sheet->getStyle("E$reference_row:I$lastDataRow")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("E$reference_row:I$lastDataRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle("E$total_row:I$total_row")->getNumberFormat()->setFormatCode('#,##0.00');

        $allBorders = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle("B$table_start:I$lastDataRow")->applyFromArray($allBorders);


        for ($r = $table_start+1; $r <= $lastDataRow; $r++) {
            $fillColor = ($r % 2 == 1) ? 'CCCCCC' : 'A8A8A8';  // Açık gri ve koyu gri
            $sheet->getStyle("C$r:I$r")->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB($fillColor);

            // Metin sola yaslı (C:I)
            $sheet->getStyle("C$r:I$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            // Eğer gerekiyorsa B sütunu sola yaslı, zaten #FFC000 arka plan var, koruyor
            $sheet->getStyle("B$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        $sheet->getPageMargins()->setTop(0.25);    // Üst kenar boşluğu
        $sheet->getPageMargins()->setBottom(0.25); // Alt kenar boşluğu
        $sheet->getPageMargins()->setLeft(0.25);   // Sol kenar boşluğu
        $sheet->getPageMargins()->setRight(0.25);  // Sağ kenar boşluğu





        // Excel dosyasını indir
        $writer = new Xlsx($spreadsheet);
        $downloadFileName = "$boq->name - $payment->hakedis_no Nolu Hakediş.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $downloadFileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function template_download_rebar($contract_id, $payment_id, $boq_id)
    {
        $this->load->model("Company_model");

        // Veritabanından gerekli verileri al
        $payment = $this->Payment_model->get(array('id' => $payment_id));
        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $company = $this->Company_model->get(array('id' => $contract->isveren));
        $boq = $this->Contract_price_model->get(array('id' => $boq_id));

        // BOQ hesaplama verilerini al
        $old_boq = $this->Boq_model->get(array(
            "boq_id" => $boq_id,
            "contract_id" => $contract_id,
            "payment_no" => $payment->hakedis_no
        ));

        if (isset($old_boq)) {
            $dataArray = json_decode($old_boq->calculation, true);
        } else {
            $dataArray = array();
        }

        // Yeni bir Excel dosyası oluştur
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $title_start_row = 2;

        // 1. satır: METRAJ CETVELİ
        $sheet->mergeCells("B$title_start_row:I$title_start_row");
        $sheet->setCellValue("B$title_start_row", "METRAJ CETVELİ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(20);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$title_start_row:I$title_start_row")->getFont()->setName('Verdana');

        $title_start_row++;
        $title_start_row++;


// 2. satır: İşin adı
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row",  "İşin Adı : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $contract->contract_name);
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $title_start_row++;

// 3. satır: Firma adı
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "Firma : " );
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $company->company_name);
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $title_start_row++;

        // 4. satır
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "İmalat Adı : " );
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $boq->name . " (" . $boq->unit .")" );
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $title_start_row++;
        $total_row = $title_start_row;

        // 5. satır
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "Toplam : " );
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", "");
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

// Satırları doldurma kısmında
        $sheet->getStyle("A1:D$title_start_row")->getFont()->getColor()->setARGB('FF808080'); // Koyu gri için örnek

        $title_start_row++;
        $title_start_row++;
        $counter = 1;

        $table_start = $title_start_row;

        // Kolon başlıkları - A boş, B satır no
        $sheet->setCellValue("A$table_start", '');          // boş bırakıyoruz
        $sheet->setCellValue("B$table_start", 'No');        // Satır numarası
        $sheet->setCellValue("C$table_start", 'Mahal');
        $sheet->setCellValue("D$table_start", 'Açıklama');
        $sheet->setCellValue("E$table_start", 'Çap');
        $sheet->setCellValue("F$table_start", 'Benzer');
        $sheet->setCellValue("G$table_start", 'Adet');
        $sheet->setCellValue("H$table_start", 'Uzunluk');
        $sheet->setCellValue("I$table_start", 'Toplam');

        $sheet->getStyle("E$table_start:I$table_start")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);



        $title_start_row++;
        $sheet->freezePane("A$title_start_row");

        $reference_row = $title_start_row;

        $allowedValues = [8, 10, 12, 14, 16, 18,20,22,24,25, 26,28,30,32,34, 36,38,40,45,50];

        foreach ($dataArray as $data) {

            $validation = $sheet->getCell('E' . $title_start_row)->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_STOP);
            $validation->setAllowBlank(false);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setErrorTitle('Geçersiz Değer');
            $validation->setError('Sadece belirtilen çaplardan birini girin: 8, 10, 12, 14, 16, 18,20,22,24,25, 26,28,30,32,34, 36,38,40,45,50');
            $validation->setFormula1('"' . implode(',', $allowedValues) . '"');

            $sheet->setCellValue('B' . $title_start_row, $counter);  // satır numarası
            $sheet->setCellValue('C' . $title_start_row, $data['s']);
            $sheet->setCellValue('D' . $title_start_row, $data['n']);
            $sheet->setCellValue('E' . $title_start_row, $data['q']);
            $sheet->setCellValue('F' . $title_start_row, $data['w']);
            $sheet->setCellValue('G' . $title_start_row, $data['h']);
            $sheet->setCellValue('H' . $title_start_row, $data['l']);
            $formula = sprintf("=(E%d^2/162)*F%d*G%d*H%d", $title_start_row, $title_start_row, $title_start_row, $title_start_row);

            $sheet->setCellValue('I' . $title_start_row, $formula);
            $title_start_row++;
            $counter++;
        }

        $lastDataRow = $title_start_row - 1;

        $sheet->getStyle("B$table_start:I$table_start")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFC000');
        $sheet->getStyle("B$table_start:B$lastDataRow")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFC000');
        $sheet->getStyle("B$table_start:B$lastDataRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$table_start:I$table_start")->getFont()->setBold(true);
        $sheet->getStyle("B$table_start:B$lastDataRow")->getFont()->setBold(true);

        $sheet->setCellValue("D$total_row", "=SUM(I$total_row:I$lastDataRow)");

// Örneğin birim "kg" ise:
        $sheet->getStyle("D$total_row")
            ->getNumberFormat()
            ->setFormatCode('#,##0.00" ' . $boq->unit . '"');

        $sheet->getColumnDimension('A')->setWidth(5);     // boş sütun, biraz geniş bırakabiliriz
        $sheet->getColumnDimension('B')->setWidth(5);     // satır no için yeterli
        $sheet->getColumnDimension('C')->setWidth(14);    // Mahal ~100px
        $sheet->getColumnDimension('D')->setWidth(28);    // Açıklama ~195px
        $sheet->getColumnDimension('E')->setWidth(9);     // Adet ~60px
        $sheet->getColumnDimension('F')->setWidth(9);     // En ~60px
        $sheet->getColumnDimension('G')->setWidth(9);     // Boy ~60px
        $sheet->getColumnDimension('H')->setWidth(9);     // Yükseklik ~60px
        $sheet->getColumnDimension('I')->setWidth(11);    // Toplam ~70px

        $sheet->getStyle("E$reference_row:I$lastDataRow")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("E$reference_row:I$lastDataRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle("E$total_row:I$total_row")->getNumberFormat()->setFormatCode('#,##0.00');

        $allBorders = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle("B$table_start:I$lastDataRow")->applyFromArray($allBorders);



        for ($r = $table_start+1; $r <= $lastDataRow; $r++) {
            $fillColor = ($r % 2 == 1) ? 'CCCCCC' : 'A8A8A8';  // Açık gri ve koyu gri
            $sheet->getStyle("C$r:I$r")->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB($fillColor);

            // Metin sola yaslı (C:I)
            $sheet->getStyle("C$r:I$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            // Eğer gerekiyorsa B sütunu sola yaslı, zaten #FFC000 arka plan var, koruyor
            $sheet->getStyle("B$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->getStyle("E$r:E$lastDataRow")
                ->getNumberFormat()
                ->setFormatCode('"Ø"#');

        }

        $sheet->getPageMargins()->setTop(0.25);    // Üst kenar boşluğu
        $sheet->getPageMargins()->setBottom(0.25); // Alt kenar boşluğu
        $sheet->getPageMargins()->setLeft(0.25);   // Sol kenar boşluğu
        $sheet->getPageMargins()->setRight(0.25);  // Sağ kenar boşluğu


        // Excel dosyasını indir
        $writer = new Xlsx($spreadsheet);
        $downloadFileName = "$boq->name - $payment->hakedis_no Nolu Hakediş.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $downloadFileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

}
