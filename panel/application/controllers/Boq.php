<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// Add this for number formatting


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
            'Company_model',
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
            $project = $this->Project_model->get(array("id" => $contract->project_id));
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
        if (empty($payment->A)) {
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
        if (empty($payment->A)) {
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
        if (empty($boq_array)) {
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
            $startRow = 10;
            $endRow = 3000; // 3000 satır daha eklendiğini varsayıyorum
// Boş satır sayacını tanımlayın
            $emptyRowCount = 0;
// Her bir satır için döngü oluşturun
            for ($row = $startRow; $row <= $endRow; $row++) {
                // Her bir satırdaki B'den G'ye kadar olan hücrelerden veriyi alarak bir dizi oluşturun
                $rowData = array(
                    's' => $worksheet->getCell('C' . $row)->getValue(),
                    'n' => $worksheet->getCell('D' . $row)->getValue(),
                    'q' => $worksheet->getCell('E' . $row)->getValue(),
                    'w' => $worksheet->getCell('F' . $row)->getValue(),
                    'h' => $worksheet->getCell('G' . $row)->getValue(),
                    'l' => $worksheet->getCell('H' . $row)->getValue()
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
        if ($contract_item->type == "rebar") {
            $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/rebar", $viewData, true);
        } else {
            $render_calculate = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/add/calculate", $viewData, true);
        }
        echo $render_calculate;
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

    public
    function save_total($contract_id, $payment_id)
    {

        $payment = $this->Payment_model->get(array('id' => $payment_id));
        $boq_id = ($this->input->post('boq_id'));
        $boq_array = ($this->input->post('boq[]'));
        if (empty($boq_array)) {
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


    public
    function open_sub($contract_id, $sub_id, $payment_id)
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

    public
    function back_main($contract_id, $payment_id)
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

    public
    function template_download($contract_id, $payment_id, $boq_id)
    {
        $limit = $this->input->get('limit') ?? 100; // varsayılan 100

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
        $sheet->setCellValue("B$title_start_row", "İşin Adı : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $contract->contract_name);
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $title_start_row++;

// 3. satır: Firma adı
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "Firma : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $company->company_name);
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $title_start_row++;

        // 4. satır
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "İmalat Adı : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $boq->name . "(" . $boq->unit . ")");
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $title_start_row++;
        $total_row = $title_start_row;

        // 5. satır
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "Toplam : ");
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

        $maxRows = $limit; // her durumda 1000 satır üretilecek

        if (!empty($dataArray)) {
            foreach ($dataArray as $data) {
                $sheet->setCellValue('B' . $title_start_row, $counter);
                $sheet->setCellValue('C' . $title_start_row, $data['s']);
                $sheet->setCellValue('D' . $title_start_row, $data['n']);
                $sheet->setCellValue('E' . $title_start_row, $data['q']);
                $sheet->setCellValue('F' . $title_start_row, $data['w']);
                $sheet->setCellValue('G' . $title_start_row, $data['h']);
                $sheet->setCellValue('H' . $title_start_row, $data['l']);

                // D hücresindeki değere göre formül belirle
                $isMinha = false;
                if (isset($data['n'])) {
                    $lower = strtolower($data['n']);
                    $isMinha = (strpos($lower, 'minha') !== false || strpos($lower, 'mihna') !== false || strpos($lower, 'minah') !== false);
                }

                $formula = $isMinha
                    ? "=PRODUCT(E$title_start_row:H$title_start_row)*-1"
                    : "=PRODUCT(E$title_start_row:H$title_start_row)";

                $sheet->setCellValue('I' . $title_start_row, $formula);

                $title_start_row++;
                $counter++;
            }

            // Kalan satırlar için (boş satırlar)
            $remainingRows = $maxRows - count($dataArray);
            for ($i = 0; $i < $remainingRows; $i++) {
                $sheet->setCellValue('B' . $title_start_row, $counter);
                $sheet->setCellValue('I' . $title_start_row, "=PRODUCT(E$title_start_row:H$title_start_row)");

                $title_start_row++;
                $counter++;
            }
        } else {
            // Hiç veri yoksa tüm satırlar boş
            for ($i = 0; $i < $maxRows; $i++) {
                $sheet->setCellValue('B' . $title_start_row, $counter);
                $sheet->setCellValue('I' . $title_start_row, "=PRODUCT(E$title_start_row:H$title_start_row)");

                $title_start_row++;
                $counter++;
            }
        }


// Son satır tespiti
        $lastDataRow = $title_start_row - 1;

// Biçimlendirme ve toplam satırı
        $sheet->getStyle("B$table_start:I$table_start")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFC000');
        $sheet->getStyle("B$table_start:B$lastDataRow")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFC000');
        $sheet->getStyle("B$table_start:B$lastDataRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$table_start:I$table_start")->getFont()->setBold(true);
        $sheet->getStyle("B$table_start:B$lastDataRow")->getFont()->setBold(true);

// TOPLAM hücresi
        $first_value = $table_start + 1;
        $sheet->setCellValue("D$total_row", "=SUM(I$first_value:I$lastDataRow)");

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


        $ivalues = array();
        for ($r = 10; $r <= $lastDataRow; $r++) {
            $iValue = $sheet->getCell('I' . $r)->getCalculatedValue(); // Formül varsa hesaplanmış değer al
            $isNegative = is_numeric($iValue) && $iValue < 0;
            $ivalues[] = $iValue;

            if ($isNegative) {
                // Pastel kırmızı: FF + FFCCCC
                $sheet->getStyle("C$r:I$r")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFCCCC');

                $sheet->getStyle("B$r:I$r")->getFont()->setBold(true);
                $sheet->getStyle("B$r:I$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            } else {
                // Gri zemin
                $fillColor = ($r % 2 == 1) ? 'FFCCCCCC' : 'FFA8A8A8';

                $sheet->getStyle("C$r:I$r")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB($fillColor);

                $sheet->getStyle("B$r:I$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            }
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


        $limit = $this->input->get('limit') ?? 100;

        $payment = $this->Payment_model->get(array('id' => $payment_id));
        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $company = $this->Company_model->get(array('id' => $contract->isveren));
        $boq = $this->Contract_price_model->get(array('id' => $boq_id));

        if (!$payment || !$contract || !$company || !$boq) {
            show_error('Gerekli veriler bulunamadı.', 404);
            return;
        }

        $old_boq = $this->Boq_model->get(array(
            "boq_id" => $boq_id,
            "contract_id" => $contract_id,
            "payment_no" => $payment->hakedis_no
        ));

        $dataArray = array();
        if (isset($old_boq)) {
            $dataArray = json_decode($old_boq->calculation, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log('JSON Decode Error: ' . json_last_error_msg());
                $dataArray = [];
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $title_start_row = 2;

        // METRAJ CETVELİ Başlıkları ve Bilgileri (Mevcut Kodunuz)
        // 1. satır: METRAJ CETVELİ
        $sheet->mergeCells("B$title_start_row:I$title_start_row");
        $sheet->setCellValue("B$title_start_row", "METRAJ CETVELİ (Donatı)");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(20);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$title_start_row:I$title_start_row")->getFont()->setName('Verdana');

        $title_start_row += 2; // 2 satır atlama

        // 2. satır: İşin adı
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "İşin Adı : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $contract->contract_name);
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $title_start_row++;

        // 3. satır: Firma adı
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "Firma : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $company->company_name);
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $title_start_row++;

        // 4. satır: İmalat Adı
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "İmalat Adı : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", $boq->name . " (" . $boq->unit . ")");
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $title_start_row++;
        $total_row_display = $title_start_row; // Toplam bilgisinin görüneceği satır

        // 5. satır: Toplam etiketi
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "Toplam : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        // Değer daha sonra hesaplanıp buraya atanacak

        $sheet->getStyle("A1:D$title_start_row")->getFont()->getColor()->setARGB('FF808080');

        $title_start_row += 2;
        $counter = 1;

        $table_start_row = $title_start_row; // Metraj cetveli başlıklarının başladığı satır

        // Kolon başlıkları
        $sheet->setCellValue("A$table_start_row", '');
        $sheet->setCellValue("B$table_start_row", 'No');
        $sheet->setCellValue("C$table_start_row", 'Mahal');
        $sheet->setCellValue("D$table_start_row", 'Açıklama');
        $sheet->setCellValue("E$table_start_row", 'Çap');
        $sheet->setCellValue("F$table_start_row", 'Benzer');
        $sheet->setCellValue("G$table_start_row", 'Adet');
        $sheet->setCellValue("H$table_start_row", 'Uzunluk');
        $sheet->setCellValue("I$table_start_row", 'Toplam (kg)');

        $sheet->getStyle("E$table_start_row:I$table_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $maxRows = $limit;

        $dataStartRow = $table_start_row + 1;
        $sheet->freezePane("A$dataStartRow");

        $allowedValues = [8, 10, 12, 14, 16, 18, 20, 22, 24, 25, 26, 28, 30, 32, 34, 36, 38, 40, 45, 50];

        $hiddenListStartRow = 10;
        $hiddenListColumn = 'K';

        foreach ($allowedValues as $index => $value) {
            $sheet->setCellValue($hiddenListColumn . ($hiddenListStartRow + $index), $value);
            $sheet->getStyle($hiddenListColumn . ($hiddenListStartRow + $index))->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        }

        $hiddenListEndRow = $hiddenListStartRow + count($allowedValues) - 1;
        $hiddenListRange = '$' . $hiddenListColumn . '$' . $hiddenListStartRow . ':$' . $hiddenListColumn . '$' . $hiddenListEndRow;

        $dataCount = !empty($dataArray) ? count($dataArray) : 0;
        $rowsToGenerate = max($dataCount + 1, $maxRows);

        for ($i = 1; $i <= $rowsToGenerate; $i++) {
            $currentRow = $dataStartRow + ($i - 1);

            $validation = $sheet->getCell('E' . $currentRow)->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_STOP);
            $validation->setAllowBlank(true);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setErrorTitle('Geçersiz Değer');
            $validation->setError('Sadece belirtilen çaplardan birini girin.');
            $validation->setFormula1($hiddenListRange);

            $sheet->setCellValue('B' . $currentRow, $counter);

            if (!empty($dataArray) && isset($dataArray[$i])) {
                $data = $dataArray[$i];
                $sheet->setCellValue('C' . $currentRow, $data['s'] ?? '');
                $sheet->setCellValue('D' . $currentRow, $data['n'] ?? '');
                $q_value = trim($data['q'] ?? ''); // İlk önce string olarak al
                if (empty($q_value) || (is_numeric($q_value) && (float)$q_value == 0)) {
                    // Eğer boşsa veya sayısal olarak 0 ise, hücreyi boş bırak
                    $sheet->setCellValue('E' . $currentRow, '');
                } else {
                    // Aksi takdirde, tam sayıya çevirerek yaz
                    $sheet->setCellValue('E' . $currentRow, (int)$q_value);
                }
                $sheet->setCellValue('F' . $currentRow, $data['w'] ?? ''); // Boş string ise boş hücre kalır
                $sheet->setCellValue('G' . $currentRow, $data['h'] ?? ''); // Boş string ise boş hücre kalır
                $sheet->setCellValue('H' . $currentRow, $data['l'] ?? ''); // Boş string ise boş hücre kalır
            } else {
                // Eğer veri yoksa, boş hücrelerin varsayılan değerleri veya boş stringler
                // Bu hücreler boş kalacak, formül bunu algılayıp boş gösterecek
                $sheet->setCellValue('C' . $currentRow, '');
                $sheet->setCellValue('D' . $currentRow, '');
                $sheet->setCellValue('E' . $currentRow, '');
                $sheet->setCellValue('F' . $currentRow, '');
                $sheet->setCellValue('G' . $currentRow, '');
                $sheet->setCellValue('H' . $currentRow, '');
            }

            $formula = sprintf(
                '=IF(OR(ISNUMBER(SEARCH("minha",LOWER(D%d))), ISNUMBER(SEARCH("mihna",LOWER(D%d))), ISNUMBER(SEARCH("minah",LOWER(D%d)))), ' .
                // D sütununda "minha" benzeri kelime varsa (Negatif Hesaplama Durumu)
                'IF(AND(ISNUMBER(G%d),ISNUMBER(H%d)), ' . // Adet ve Uzunluk sayı mı?
                '-1 * ((E%d^2/162) * (IF(ISNUMBER(F%d),F%d,1)) * G%d * H%d), ' . // Benzer doluysa onu, boşsa 1 al; sonra adet ve uzunlukla çarp, sonucu negatife çevir
                '"HATA: Adet/Uzunluk Eksik"' . // Adet veya Uzunluk sayı değilse hata mesajı
                '), ' .
                // D sütununda "minha" benzeri kelime yoksa (Pozitif Hesaplama veya Açıklama Satırı Durumu)
                'IF(AND(ISNUMBER(G%d),ISNUMBER(H%d)), ' . // Adet ve Uzunluk sayı mı?
                // Adet ve Uzunluk doluysa (Pozitif Hesaplama Durumu)
                '((E%d^2/162) * (IF(ISNUMBER(F%d),F%d,1)) * G%d * H%d), ' .
                // Adet veya Uzunluk boşsa, ve "minha" yok (Açıklama Satırı veya Hata Mesajı ayrımı)
                'IF(AND(ISBLANK(E%d), ISBLANK(F%d), ISBLANK(G%d), ISBLANK(H%d)), ' . // E,F,G,H hepsi boş mu?
                '"", ' . // Evet, açıklama satırı: boş bırak
                '"HATA: Adet/Uzunluk Eksik"' . // Hayır, E,F,G,H hepsi boş değilse bu bir hata
                ')' .
                ')' .
                ')',
                $currentRow, $currentRow, $currentRow, // D (SEARCH)
                $currentRow, $currentRow, // G, H (AND) - Negatif kısım için
                $currentRow, $currentRow, $currentRow, $currentRow, $currentRow, // E, F, G, H (negatif çarpım)

                $currentRow, $currentRow, // G, H (AND) - Pozitif kısım için
                $currentRow, $currentRow, $currentRow, $currentRow, $currentRow, // E, F, G, H (pozitif çarpım)

                $currentRow, $currentRow, $currentRow, $currentRow // E, F, G, H (ISBLANK AND)
            );
            $sheet->setCellValue('I' . $currentRow, $formula);

            $counter++;
        }

        $lastDataRow = $currentRow;

        $sheet->getColumnDimension($hiddenListColumn)->setVisible(false);

        $headerStyle = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFC000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle("B$table_start_row:I$table_start_row")->applyFromArray($headerStyle);

        $numberColumnStyle = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFC000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle("B" . ($table_start_row + 1) . ":B$lastDataRow")->applyFromArray($numberColumnStyle);

        $first_value_row = $table_start_row + 1;
        $sheet->setCellValue("D$total_row_display", "=SUM(I$first_value_row:I$lastDataRow)/1000");

        $sheet->getStyle("D$total_row_display")
            ->getNumberFormat()
            ->setFormatCode('#,##0.00" ' . $boq->unit . '"');

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(5);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setWidth(9);
        $sheet->getColumnDimension('F')->setWidth(9);
        $sheet->getColumnDimension('G')->setWidth(9);
        $sheet->getColumnDimension('H')->setWidth(9);
        $sheet->getColumnDimension('I')->setWidth(11);

        $sheet->getStyle("E$dataStartRow:I$lastDataRow")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("E$dataStartRow:I$lastDataRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle("D$total_row_display")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $allBorders = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle("B$table_start_row:I$lastDataRow")->applyFromArray($allBorders);

        for ($r = $dataStartRow; $r <= $lastDataRow; $r++) {
            try {
                $iValue = $sheet->getCell('I' . $r)->getCalculatedValue();
            } catch (\PhpOffice\PhpSpreadsheet\CalculationException $e) {
                $iValue = 0;
                error_log("Excel formül hesaplama hatası (I$r): " . $e->getMessage());
            }

            $isNegative = is_numeric($iValue) && $iValue < 0;

            if ($isNegative) {
                $sheet->getStyle("B$r:I$r")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFCCCC');

                $sheet->getStyle("B$r:I$r")->getFont()->setBold(true);
                $sheet->getStyle("B$r:I$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            } else {
                $fillColor = ($r % 2 == 0) ? 'FFEEEEEE' : 'FFDDDDDD';
                $sheet->getStyle("C$r:I$r")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB($fillColor);

                $sheet->getStyle("C$r:I$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("B$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        $sheet->getPageMargins()->setTop(0.75);
        $sheet->getPageMargins()->setBottom(0.75);
        $sheet->getPageMargins()->setLeft(0.70);
        $sheet->getPageMargins()->setRight(0.70);
        $sheet->getPageSetup()->setHorizontalCentered(true);

        // --- GENEL İCMAL TABLOSU BAŞLANGICI ---
        $icmal_start_column = 'M'; // M sütunundan başlasın
        $icmal_start_row = $title_start_row - 7; // M2 hücresi için: Metraj Başlık satırı (B2) ile aynı hizaya getirilmişti, title_start_row 2'den başlıyor.
        // M2 için icmal_start_row = 2 olmalı.
        // Metraj cetveli başlığınızın başladığı ilk $title_start_row değeri = 2
        // İcmal başlığı da o hizadan başlasın istiyorsanız:
        // $icmal_start_row = 2; // Bu, B2 ile M2'yi aynı satıra getirir.

        // Görseldeki gibi B2 ve M2'nin hizalı olması için:
        $icmal_start_row = 2; // Bu, METRAJ CETVELİ başlığıyla aynı satırda başlayacak

        // "GENEL İCMAL" başlığı
        $icmal_header_start_cell = $icmal_start_column . $icmal_start_row;
        // Çap sayısı kadar sütunu birleştirmek için son sütunu bulalım
        $icmal_header_end_column = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($icmal_start_column) + count($allowedValues) - 1);
        $icmal_header_end_cell = $icmal_header_end_column . $icmal_start_row;

        $sheet->mergeCells("$icmal_header_start_cell:$icmal_header_end_cell");
        $sheet->setCellValue($icmal_header_start_cell, "GENEL İCMAL");
        $sheet->getStyle($icmal_header_start_cell)->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle($icmal_header_start_cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($icmal_header_start_cell)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($icmal_header_start_cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDAEEF3'); // Açık mavi arka plan

        $icmal_current_row = $icmal_start_row + 2; // Çap başlıklarının geleceği satır (Görselde M5)
        $icmal_total_values_row = $icmal_current_row + 1; // Toplamların geleceği satır (Görselde M6)

        // Çap başlıkları ve formüller
        $colIndex = Coordinate::columnIndexFromString($icmal_start_column);
        foreach ($allowedValues as $index => $value) {
            $currentCol = Coordinate::stringFromColumnIndex($colIndex + $index);
            // Çap başlığı (Ø8, Ø10 vb.)
            $sheet->setCellValue($currentCol . $icmal_current_row, $value);
            $sheet->getStyle($currentCol . $icmal_current_row)->getNumberFormat()->setFormatCode('"Ø "#'); // "Ø " metni ve sayıyı göster
            $sheet->getStyle($currentCol . $icmal_current_row)->getFont()->setBold(true);
            $sheet->getStyle($currentCol . $icmal_current_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($currentCol . $icmal_current_row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($currentCol . $icmal_current_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDDEBF7'); // Başlık arka plan rengi

            // Çap sütunu otomatik genişlik
            $sheet->getColumnDimension($currentCol)->setAutoSize(true);

            // Her çap için SUMIF formülü: =ETOPLA($E$9:$E$1008;M5;$I$9:$I$1008)/1000
            // $E$9:$E$1008 -> Çapların bulunduğu aralık (metraj cetvelindeki 'E' sütunu)
            // M5 -> Kriter (o anki çap değeri, örn: M5'teki 8)
            // $I$9:$I$1008 -> Toplamların bulunduğu aralık (metraj cetvelindeki 'I' sütunu)
            // /1000 -> Sonucun birimini dönüştürmek için

            $sumif_formula = sprintf(
                '=SUMIF($E$%d:$E$%d,%s%d,$I$%d:$I$%d)/1000',
                $dataStartRow, // E sütunu başlangıç satırı
                $lastDataRow,  // E sütunu bitiş satırı
                $currentCol,   // Kriter olarak o anki çap başlığının hücresi (örn: M5)
                $icmal_current_row, // Kriter hücresinin satırı (örn: 5)
                $dataStartRow, // I sütunu başlangıç satırı
                $lastDataRow   // I sütunu bitiş satırı
            );
            $sheet->setCellValue($currentCol . $icmal_total_values_row, $sumif_formula);
            $sheet->getStyle($currentCol . $icmal_total_values_row)->getNumberFormat()->setFormatCode('#,##0.00'); // Sayı formatı
            $sheet->getStyle($currentCol . $icmal_total_values_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDDEBF7'); // Toplam arka plan rengi
            $sheet->getStyle($currentCol . $icmal_total_values_row)->getFont()->setBold(true); // Kalın font
            $sheet->getStyle($currentCol . $icmal_total_values_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Sağa hizalı
        }

        // Genel İcmal tablosuna kenarlıklar uygulama
        $icmal_table_range = "$icmal_header_start_cell:$icmal_header_end_column" . $icmal_total_values_row;
        $sheet->getStyle($icmal_table_range)->applyFromArray($allBorders);

        // --- GENEL İCMAL TABLOSU SONU ---


        // Excel dosyasını indir
        $writer = new Xlsx($spreadsheet);
        $downloadFileName = "$boq->name - $payment->hakedis_no Nolu Hakediş.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . rawurlencode($downloadFileName) . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

}
