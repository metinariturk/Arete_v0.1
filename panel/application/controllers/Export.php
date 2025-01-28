<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Style;


$spreadsheet = new Spreadsheet();
$writer = new Xlsx($spreadsheet);

class Export extends CI_Controller
{
    public $viewFolder = "";

    public $moduleFolder = "";

    public function __construct()
    {
        parent::__construct();

        // Kullanıcı girişi kontrolü
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
        $this->Theme_mode = get_active_user()->mode;

        // Geçici şifre kontrolü
        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        // Modül ve görünüm klasörleri tanımlamaları
        $this->moduleFolder = "contract_module";
        $this->viewFolder = "contract_v";

        // Modelleri yükleme
        $this->load->model("Advance_model");
        $this->load->model("Bond_model");
        $this->load->model("City_model");
        $this->load->model("Company_model");
        $this->load->model("Contract_model");
        $this->load->model("Contract_price_model");
        $this->load->model("Costinc_model");
        $this->load->model("Collection_model");
        $this->load->model("Delete_model");
        $this->load->model("District_model");
        $this->load->model("Extime_model");
        $this->load->model("Favorite_model");
        $this->load->model("Newprice_model");
        $this->load->model("Order_model");
        $this->load->model("Payment_model");
        $this->load->model("Payment_model");
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Site_model");
        $this->load->model("User_model");
        $this->load->model("Sitestock_model");
        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");

        // Modül bilgileri
        $this->Module_Name = "Contract";
        $this->Module_Title = "Sözleşme";
        $this->Module_Main_Dir = "project_v";
        $this->Module_Depended_Dir = "main";
        $this->Module_File_Dir = "contract";
        $this->Display_route = "file_form";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        $this->Dependet_id_key = "contract_id";
        $this->Module_Parent_Name = "project";

        // Klasör yapıları
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->Display_offer_Folder = "display_offer";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";

        $this->Common_Files = "common";

        $this->File_Dir_Prefix = "$this->Upload_Folder/$this->Module_Main_Dir";

        // Ayarları al
        $this->Settings = get_settings();
    }


    function contract_report_pdf($contract_id, $P_or_D = null)
    {
        $contract = $this->Contract_model->get(array("id" => $contract_id));

        if ($contract->parent > 0) {
            $main_contract = $this->Contract_model->get(array("id" => $contract->parent));
        }

        $extimes = $this->Extime_model->get_all(array("contract_id" => $contract_id));
        $costincs = $this->Costinc_model->get_all(array("contract_id" => $contract_id));
        $payments = $this->Payment_model->get_all(array("contract_id" => $contract_id));
        $advances = $this->Advance_model->get_all(array("contract_id" => $contract_id));
        $bonds = $this->Bond_model->get_all(array("contract_id" => $contract_id));
        $collections = $this->Collection_model->get_all(array("contract_id" => $contract_id), "tahsilat_tarih ASC");

        $advance_given = sum_from_table("advance", "avans_miktar", $contract->id);

        $total_payment_A = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "A");
        $total_payment_B = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "B");
        $total_payment_F = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "F");
        $total_payment_G = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "G");
        $total_payment_H = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "H");
        $total_payment_I = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "I");
        $total_payment_Kes_e = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "Kes_e");
        $total_payment_balance = $this->Payment_model->sum_all(array('contract_id' => $contract->id), "balance");
        $total_collections = $this->Collection_model->sum_all(array('contract_id' => $contract->id), "tahsilat_miktar");

        $contractor = $this->Company_model->get(array("id" => $contract->yuklenici));
        $owner = $this->Company_model->get(array("id" => $contract->isveren));

        $yuklenici = company_name($contract->yuklenici);
        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        $page_width = $pdf->getPageWidth();


        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();


// Çerçeve için boşlukları belirleme
        $topMargin = 20;  // 4 cm yukarıdan
        $bottomMargin = 20;  // 4 cm aşağıdan
        $rightMargin = 10;  // 2 cm sağdan
        $leftMargin = 10;  // 2 cm soldan

// Çerçeve renk ve kalınlığını ayarla
        $pdf->SetDrawColor(0, 0, 0); // Siyah renk
        $pdf->SetLineWidth(0.5); // Çizgi kalınlığı

// Çerçeve çizme
        $pdf->Rect($leftMargin, $topMargin, $pdf->getPageWidth() - $rightMargin - $leftMargin, $pdf->getPageHeight() - $bottomMargin - $topMargin);

        $pdf->SetFont('dejavusans', 'B', 12);

// Metin eklemek (örnek olarak ilk satır)
        $yPosition = $topMargin; // 5 cm yukarıdan başla
        $xPosition = $leftMargin; // 2 cm soldan başla
        $pdf->SetXY($xPosition, $yPosition);
        $pdf->SetLineWidth(0.1); // Çizgi kalınlığı
        $pdf->Cell(190, 10, 'SÖZLEŞME RAPORU', 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetX(20);
        $pdf->SetFont('dejavusans', 'B', 8);

        if (!empty($main_contract)) {
            $pdf->Cell(170, 7, $main_contract->contract_name, 0, 1, "C", 0); // PDF'ye yazdır
        }
        $pdf->SetX(20);

        $pdf->Cell(170, 7, mb_strtoupper($contract->contract_name), 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetX(20);
        $pdf->Cell(170, 7, company_name($contract->yuklenici), 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetX(25);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(32, 5, "Sözleşme Bedeli", 1, 0, "C", 0);
        $pdf->Cell(32, 5, "Sözleşme Tarihi", 1, 0, "C", 0);
        $pdf->Cell(32, 5, "Yer Teslim Tarihi", 1, 0, "C", 0);
        $pdf->Cell(32, 5, "Süresi", 1, 0, "C", 0);
        $pdf->Cell(32, 5, "Bitiş Tarihi", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(25);
        $pdf->SetFont('dejavusans', 'N', 6);
        $pdf->Cell(32, 5, money_format($contract->sozlesme_bedel) . " " . $contract->para_birimi, 1, 0, "C", 0);
        $pdf->Cell(32, 5, dateFormat_dmy($contract->sozlesme_tarih), 1, 0, "C", 0);
        $pdf->Cell(32, 5, dateFormat_dmy($contract->sitedel_date), 1, 0, "C", 0);
        $pdf->Cell(32, 5, $contract->isin_suresi . " Gün", 1, 0, "C", 0);
        $pdf->Cell(32, 5, dateFormat_dmy($contract->sozlesme_bitis), 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(20);
        $pdf->Cell(170, 3, "", 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(20);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(170, 6, 'SÜREYE GÖRE İLERLEME', 0, 0, "C", 0);
        $pdf->SetFont('dejavusans', 'N', 6);
        $pdf->Ln(); // Yeni satıra geç

        $sonSatirY = $pdf->GetY();

        $contrac_start_y = $sonSatirY;
        $bar_height = 8;
        $start_x = 25;
        $bar_width = 70;
        $last_x = $start_x + $bar_width;
        $row_height = 8;

        $elapsed_Day = fark_gun($contract->sozlesme_tarih);
        $total_day = $contract->isin_suresi;
        $percantage = $elapsed_Day / $total_day * 100;
        $pdf->progress_bar($percantage, $bar_height, $bar_width, $contrac_start_y, $start_x, $last_x); // Yeni satıra geç
        $remain_day = ($total_day - $elapsed_Day);
        if ($elapsed_Day > $total_day) {
            $elapsed_Day = " -";
        }
        if ($remain_day < 0) {
            $remain_day = " -";
        }
        $pdf->SetY($contrac_start_y); // Yeni satıra geç
        $pdf->SetX(95); // Yeni satıra geç
        $pdf->Cell(30, 4, "Sözleşme Süresi", 1, 0, "C", 0);
        $pdf->Cell(30, 4, 'Geçen Süre', 1, 0, "C", 0);
        $pdf->Cell(30, 4, 'Kalan Süre', 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(95); // Yeni satıra geç
        $pdf->Cell(30, 4, $contract->isin_suresi . " Gün", 1, 0, "C", 0);
        $pdf->Cell(30, 4, $elapsed_Day . " Gün", 1, 0, "C", 0);
        $pdf->Cell(30, 4, $remain_day . " Gün", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(30, 2, "", 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $contract_time_end_Y = $pdf->GetY();

        $extime_start_y = $contract_time_end_Y;
        $i = 1;
        foreach ($extimes as $extime) {
            $elapsed_Day = fark_gun($extime->baslangic_tarih);
            $total_day = $extime->uzatim_miktar;
            $percantage = $elapsed_Day / $total_day * 100;
            $pdf->progress_bar($percantage, $bar_height, $bar_width, $extime_start_y, $start_x, $last_x); // Yeni satıra geç
            $remain_day = ($total_day - $elapsed_Day);
            if ($elapsed_Day > $total_day) {
                $elapsed_Day = " -";
            }
            if ($remain_day < 0) {
                $remain_day = " -";
            }
            $pdf->SetY($extime_start_y); // Yeni satıra geç
            $pdf->SetX(95); // Yeni satıra geç
            $pdf->Cell(30, 4, $i . "- Süre Uzatımı", 1, 0, "C", 0);
            $pdf->Cell(30, 4, 'Geçen Süre', 1, 0, "C", 0);
            $pdf->Cell(30, 4, 'Kalan Süre', 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(95); // Yeni satıra geç
            $pdf->Cell(30, 4, $extime->uzatim_miktar . " Gün", 1, 0, "C", 0);
            $pdf->Cell(30, 4, $elapsed_Day . " Gün", 1, 0, "C", 0);
            $pdf->Cell(30, 4, $remain_day . " Gün", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $extime_start_y += 10;

        }
        $pdf->Cell(30, 2, "", 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç


        $pdf->SetX(20); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(170, 6, 'FİNANSAL İLERLEME', 0, 0, "C", 0);
        $pdf->SetFont('dejavusans', 'N', 6);
        $pdf->Ln(); // Yeni satıra geç

        $extime_end_Y = $pdf->GetY();

        $contract_price_start_Y = $extime_end_Y;

        $total_payment = $total_payment_A;
        $contract_price = $contract->sozlesme_bedel;

        $percantage = $total_payment / $contract_price * 100;
        $pdf->progress_bar($percantage, $bar_height, $bar_width, $contract_price_start_Y, $start_x, $last_x); // Yeni satıra geç
        if ($total_payment > $contract_price) {
            $remain_contract = "0";
        } else {
            $remain_contract = $contract_price - $total_payment;
        }

        $pdf->SetY($contract_price_start_Y); // Yeni satıra geç
        $pdf->SetX(95); // Yeni satıra geç
        $pdf->Cell(30, 4, "Sözleşme Bedel", 1, 0, "C", 0);
        $pdf->Cell(30, 4, "Hakediş Toplam", 1, 0, "C", 0);
        $pdf->Cell(30, 4, "Sözleşmeden Kalan", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(95); // Yeni satıra geç
        $pdf->Cell(30, 4, money_format($contract->sozlesme_bedel) . " " . $contract->para_birimi, 1, 0, "C", 0);
        $pdf->Cell(30, 4, money_format($total_payment) . " " . $contract->para_birimi, 1, 0, "C", 0);
        $pdf->Cell(30, 4, money_format($remain_contract) . " " . $contract->para_birimi . " Gün", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(30, 2, "", 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç

        $contract_price_end_y = $pdf->GetY();

        $costinc_start_y = $contract_price_end_y;
        $i = 1;
        foreach ($costincs as $costinc) {
            $total_payment = $total_payment_A - $contract_price;
            $total_costinc = +$costinc->artis_miktar;
            $percantage = $total_payment / $total_costinc * 100;
            $pdf->progress_bar($percantage, $bar_height, $bar_width, $costinc_start_y, $start_x, $last_x); // Yeni satıra geç
            if ($total_payment > $total_costinc) {
                $used_costinc = $costinc->artis_miktar;
                $remain_costinc = "0";
            } else {
                $used_costinc = $contract_price + $total_costinc - $total_payment_A;
                $remain_costinc = $total_costinc - ($contract_price + $total_costinc - $total_payment_A);
            }
            $pdf->SetX(95); // Yeni satıra geç
            $pdf->Cell(30, 4, $i++ . " No'lu Keşif Artışı", 1, 0, "C", 0);
            $pdf->Cell(30, 4, "Hakediş Toplam", 1, 0, "C", 0);
            $pdf->Cell(30, 4, "Sözleşmeden Kalan", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(95); // Yeni satıra geç
            $pdf->Cell(30, 4, money_format($costinc->artis_miktar) . " " . $contract->para_birimi, 1, 0, "C", 0);
            $pdf->Cell(30, 4, money_format($used_costinc) . " " . $contract->para_birimi, 1, 0, "C", 0);
            $pdf->Cell(30, 4, money_format($remain_costinc) . " " . $contract->para_birimi . " Gün", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Ln(); // Yeni satıra geç
            $costinc_start_y += 10;
        }
        $costinc_end_y = $pdf->GetY();

        $graph_y_start = $costinc_end_y;
        $pdf->SetX(10); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(190, 6, 'HAKEDİŞ DURUMU', 0, 0, "C", 1);
        $pdf->SetFont('dejavusans', 'N', 6);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 6);
        $pdf->Cell(8, 5, "No", 1, 0, "C", 0);
        $pdf->Cell(28, 5, "Hakediş Tutar", 1, 0, "C",);
        $pdf->Cell(25, 5, "Fiyat Farkı", 1, 0, "C", 0);
        $pdf->Cell(25, 5, "Tahhuk Tutarı", 1, 0, "C", 0);
        $pdf->Cell(25, 5, "Teminat", 1, 0, "C", 0);
        $pdf->Cell(25, 5, "Kesinti", 1, 0, "C", 0);
        $pdf->Cell(25, 5, "Avans Mahsubu", 1, 0, "C", 0);
        $pdf->Cell(29, 5, "Net Bedel", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'N', 6);

        foreach ($payments as $payment) {
            $pdf->SetX(10);
            $pdf->Cell(8, 5, "$payment->hakedis_no", 1, 0, "C", 0);
            $pdf->Cell(28, 5, money_format($payment->A) . " " . $contract->para_birimi, 1, 0, "R",);
            $pdf->Cell(25, 5, money_format($payment->B) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 5, money_format($payment->G) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 5, money_format($payment->Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 5, money_format($payment->H - $payment->Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 5, money_format($payment->I) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(29, 5, money_format($payment->balance) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Ln(); // Yeni satıra geç
        }
        $pdf->SetFont('dejavusans', 'B', 6);

        $pdf->SetX(10);
        $pdf->Cell(8, 4, "∑", 1, 0, "C", 0);
        $pdf->Cell(28, 4, money_format($total_payment_A) . " " . $contract->para_birimi, 1, 0, "R",);
        $pdf->Cell(25, 4, money_format($total_payment_B) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 4, money_format($total_payment_G) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 4, money_format($total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 4, money_format($total_payment_H - $total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 4, money_format($total_payment_I) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(29, 4, money_format($total_payment_balance) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(32, 2, "", 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 5);

        $pdf->Cell(60, 4, "*Teminat Kesintisi : " . money_format($total_payment_Kes_e) . " " . $contract->para_birimi, 0, 0, "L", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->Cell(60, 4, "*Toplam KDV : " . money_format($total_payment_F) . " " . $contract->para_birimi, 0, 0, "L", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(60, 4, "", 0, 0, "L", 0);
        $pdf->Ln(); // Yeni satıra geç

        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);

        if (!empty($collections)) {
            $pdf->Cell(190, 6, 'ÖDEME DURUMU', 0, 0, "C", 1);
        }
        $pdf->Ln(); // Yeni satıra geç


        if (!empty($collections)) {
            $pdf->Cell(38, 5, "Toplam Alacak", 1, 0, "C", 0);
            $pdf->Cell(38, 5, "Yapılan Ödeme", 1, 0, "C", 0);
            $pdf->Cell(38, 5, "Teminat Kesinti", 1, 0, "C", 0);
            $pdf->Cell(38, 5, "Diğer Kesinti", 1, 0, "C", 0);
            $pdf->Cell(38, 5, "Kalan Bedel", 1, 0, "C", 0);

            $pdf->SetFont('dejavusans', 'N', 6);
            $pdf->Ln(); // Yeni satıra geç

            $pdf->Cell(38, 5, money_format($total_payment_G) . " " . $contract->para_birimi, 1, 0, "C", 0);
            $pdf->Cell(38, 5, money_format($total_collections) . " " . $contract->para_birimi, 1, 0, "C", 0);
            $pdf->Cell(38, 5, money_format($total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "C", 0);
            $pdf->Cell(38, 5, money_format($total_payment_H - $total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "C", 0);
            $pdf->SetFont('dejavusans', 'B', 6);

            $pdf->Cell(38, 5, money_format($total_payment_Kes_e + $total_payment_balance - $total_collections - $total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }

        $pdf->Ln(); // Yeni satıra geç

        $pdf->SetFont('dejavusans', 'B', 7);
        if (!empty($advances)) {
            $pdf->SetX(12);
            $pdf->Cell(50, 6, 'AVANS DURUMU', 0, 0, "C", 1);
        }

        if (!empty($bonds)) {
            $pdf->SetX(64);
            $pdf->Cell(134, 6, 'TEMİNAT DURUMU', 0, 0, "C", 1);
        }
        $pdf->SetFont('dejavusans', 'B', 6);
        $pdf->Ln(); // Yeni satıra geç
        $bonds_start_y = $pdf->GetY();
        if (!empty($advances)) {
            $pdf->SetFont('dejavusans', 'N', 6);

            $pdf->SetX(12);
            $pdf->SetFont('dejavusans', 'B', 6);

            $pdf->Cell(20, 4, "TOPLAM", 1, 0, "L", 0);
            $pdf->Cell(30, 4, money_format($advance_given) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(12);

            $pdf->Cell(20, 4, "Mahsup Edilen", 1, 0, "L", 0);
            $pdf->Cell(30, 4, money_format($total_payment_I) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(12);

            $pdf->Cell(20, 4, "Kalan Avans", 1, 0, "L", 0);
            $pdf->Cell(30, 4, money_format($advance_given - $total_payment_I) . " " . $contract->para_birimi, 1, 0, "R", 0);
        }
        $last_advance_y = $pdf->GetY();


        if (!empty($bonds)) {
            $pdf->SetFont('dejavusans', 'B', 6);
            if (empty($advances)) {
                $pdf->SetXY(12, $bonds_start_y);
            } else {
                $pdf->SetXY(64, $bonds_start_y);
            }
            $pdf->Cell(5, 5, 'No', 1, 0, "C", 0);
            $pdf->Cell(20, 5, 'Tür', 1, 0, "C", 0);
            $pdf->Cell(25, 5, 'Gerekçe', 1, 0, "C", 0);
            $pdf->Cell(21, 5, 'Teminat Miktar', 1, 0, "C", 0);
            $pdf->Cell(21, 5, 'Veriliş Tarihi', 1, 0, "C", 0);
            $pdf->Cell(21, 5, 'Vade Tarih', 1, 0, "C", 0);
            $pdf->Cell(21, 5, 'İade Durumu', 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 6);

            $i = 1;
            foreach ($bonds as $bond) {
                if (empty($advances)) {
                    $pdf->SetX(12);
                } else {
                    $pdf->SetX(64);
                }
                $pdf->Cell(5, 6, $i++, 1, 0, "C", 0);
                $pdf->Cell(20, 6, $bond->teminat_turu, 1, 0, "C", 0);
                $pdf->Cell(25, 6, module_name($bond->teminat_gerekce), 1, 0, "C", 0);
                $pdf->Cell(21, 6, money_format($bond->teminat_miktar) . " " . $contract->para_birimi, 1, 0, "C", 0);
                $pdf->Cell(21, 6, dateFormat_dmy($bond->teslim_tarih), 1, 0, "C", 0);
                $pdf->Cell(21, 6, dateFormat_dmy($bond->gecerlilik_tarih), 1, 0, "C", 0);
                if ($bond->teminat_durumu == 1) {
                    $durum = "İade Edildi";
                } else {
                    $durum = "İşveren";
                }
                $pdf->Cell(21, 6, $durum, 1, 0, "C", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
        }

        $last_bond_y = $pdf->GetY();
        if ($last_bond_y > $last_advance_y) {
            $pdf->SetY($last_bond_y); // Yeni satıra geç
        } else {
            $pdf->SetY($last_advance_y); // Yeni satıra geç
        }

        if (!empty($advances) and !empty($bonds) and (count($payments) > 5)) {
            $pdf->AddPage();
        }

        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->SetX(25);
        if (!empty($collections)) {
            $pdf->Cell(163, 6, 'ÖDEME TABLOSU', 0, 0, "C", 1);
        }
        $pdf->SetFont('dejavusans', 'B', 6);
        $pdf->Ln(); // Yeni satıra geç
        $bonds_start_y = $pdf->GetY();

        if (!empty($collections)) {
            $total_collections = 0;  // Tahsilat toplamı
            $pdf->SetX(25);
            $pdf->Cell(5, 6, 'No', 1, 0, "C", 0);
            $pdf->Cell(15, 6, 'Tarih', 1, 0, "C", 0);
            $pdf->Cell(25, 6, 'Miktar', 1, 0, "C", 0);
            $pdf->Cell(28, 6, 'Türü', 1, 0, "C", 0);
            $pdf->Cell(90, 6, 'Aciklama', 1, 0, "C", 0);
            $collection_y = $pdf->GetY();
            $pdf->Ln(); // Yeni satıra geç

            $pdf->SetFont('dejavusans', 'N', 6);

            $i = 1;
            foreach ($collections as $collection) {
                if ($collection->tahsilat_turu == "Çek") {
                    $notice_date = "/ " . dateFormat_dmy($collection->vade_tarih);
                } else {
                    $notice_date = "";
                }
                $pdf->SetX(25);
                $pdf->Cell(5, 4, $i++, 1, 0, "C", 0);
                $pdf->Cell(15, 4, dateFormat_dmy($collection->tahsilat_tarih), 1, 0, "C", 0);
                $pdf->Cell(25, 4, money_format($collection->tahsilat_miktar) . " " . $contract->para_birimi, 1, 0, "R", 0);
                $pdf->Cell(28, 4, $collection->tahsilat_turu . $notice_date, 1, 0, "C", 0);
                $pdf->Cell(90, 4, $collection->aciklama, 1, 0, "L", 0);
                $pdf->Cell(4, 4, "", 0, 0, "C", 0);
                $pdf->Ln(); // Yeni satıra geç

                // Tahsilat miktarını topla
                $total_collections += $collection->tahsilat_miktar;
            }

            // Avanslar kısmını ekleyelim
            if (!empty($advances)) {
                $total_advances = 0;  // Avans toplamı
                $pdf->SetX(25);
                $pdf->Cell(163, 6, "AVANS ÖDEMELERİ", 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
                $pdf->SetX(25);

                $pdf->SetFont('dejavusans', 'N', 6);

                $i = 1;
                foreach ($advances as $advance) {
                    $pdf->SetX(25);
                    $pdf->Cell(5, 4, $i++, 1, 0, "C", 0);
                    $pdf->Cell(15, 4, dateFormat_dmy($advance->avans_tarih), 1, 0, "C", 0);
                    $pdf->Cell(25, 4, money_format($advance->avans_miktar) . " " . $contract->para_birimi, 1, 0, "R", 0);
                    $pdf->Cell(28, 4, $advance->avans_turu, 1, 0, "C", 0);
                    $pdf->Cell(90, 4, $advance->aciklama, 1, 0, "L", 0);
                    $pdf->Cell(4, 4, "", 0, 0, "C", 0);
                    $pdf->Ln(); // Yeni satıra geç

                    // Avans miktarını topla
                    $total_advances += $advance->avans_miktar;
                }
                $pdf->Ln(); // Yeni satıra geç

                $pdf->SetX(25);
                $pdf->Cell(30, 4, "TOPLAM TAHSİLAT", 1, 0, "C", 0);
                $pdf->Cell(25, 4, money_format($total_collections) . " " . $contract->para_birimi, 1, 0, "R", 0);
                $pdf->Ln(); // Yeni satıra geç
                $pdf->SetX(25);
                $pdf->Cell(30, 4, "TOPLAM AVANS", 1, 0, "C", 0);
                $pdf->Cell(25, 4, money_format($total_advances) . " " . $contract->para_birimi, 1, 0, "R", 0);
                $pdf->Ln(); // Yeni satıra geç
                $pdf->SetFont('dejavusans', 'B', 6);

                $pdf->SetX(25);
                $pdf->Cell(30, 4, "TOPLAM ÖDEME", 1, 0, "C", 0);
                $pdf->Cell(25, 4, money_format($total_collections + $total_advances) . " " . $contract->para_birimi, 1, 0, "R", 0);
                $pdf->Ln(); // Yeni satıra geç

            }
        }


        $file_name = contract_name($contract->id) . "-İlerlerme Raporu";

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public function contract_report_excel($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $contract = $this->Contract_model->get(array("id" => $contract_id));

        if ($contract->parent > 0) {
            $main_contract = $this->Contract_model->get(array("id" => $contract->parent));
        }

        $extimes = $this->Extime_model->get_all(array("contract_id" => $contract_id));
        $costincs = $this->Costinc_model->get_all(array("contract_id" => $contract_id));
        $payments = $this->Payment_model->get_all(array("contract_id" => $contract_id));
        $advances = $this->Advance_model->get_all(array("contract_id" => $contract_id));
        $bonds = $this->Bond_model->get_all(array("contract_id" => $contract_id));
        $collections = $this->Collection_model->get_all(array("contract_id" => $contract_id), "tahsilat_tarih ASC");

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageMargins()->setTop(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setLeft(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setRight(0);     // 0 cm

        $sheet->getStyle('A1:Z1000')->applyFromArray([
            'font' => [
                'size' => 8, // Yazı büyüklüğü 8 punto
            ],
        ]);


        // Logo dosyasının yolu
        $logoPath = realpath("assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR . "logo.png");


// Logo'
//yu ekleyin
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is your logo');
        $drawing->setPath($logoPath); // Resim dosyasının yolu
        $drawing->setCoordinates('B1'); // Resmin yerleştirileceği hücre
        $drawing->setHeight(60); // Resmin yüksekliği (piksel)
        $drawing->setWorksheet($sheet);

        $rowNum = 2;

        $contract = $this->Contract_model->get(array('id' => $contract_id));

        $sheet->setCellValue("K{$rowNum}", "Tarih :");
        $sheet->getStyle("B{$rowNum}:F{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                // Yazıyı koyu yap
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);

        $sheet->setCellValue("L{$rowNum}", dateFormat_dmy($contract->sozlesme_tarih));

        $rowNum++;
        $rowNum++;

        foreach (range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setWidth(7.7);
        }


        // Başlık yazısı "SÖZLEŞME RAPORU"
        $sheet->setCellValue('A4', 'SÖZLEŞME RAPORU');
        $sheet->mergeCells('A4:L4');
        $sheet->getStyle('A4')->applyFromArray([
            'font' => [
                'size' => 12,
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);

// 2. satırda sözleşme adı ve şirket adı
        $rowNum = 5; // Başlık altında yerleşecek satır
        if (!empty($main_contract)) {
            $sheet->setCellValue("A{$rowNum}", $main_contract->contract_name);
            $sheet->mergeCells("A{$rowNum}:L{$rowNum}");
            $sheet->getStyle("A{$rowNum}")->applyFromArray([
                'font' => [
                    'size' => 10,
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ]
            ]);
        }
        $rowNum++;

// Ana sözleşme adı
        $sheet->setCellValue("A{$rowNum}", mb_strtoupper($contract->contract_name));
        $sheet->mergeCells("A{$rowNum}:L{$rowNum}");
        $sheet->getStyle("A{$rowNum}")->applyFromArray([
            'font' => [
                'size' => 10,
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);
        $rowNum++;

// Şirket adı
        $sheet->setCellValue("A{$rowNum}", company_name($contract->yuklenici));
        $sheet->mergeCells("A{$rowNum}:L{$rowNum}");
        $sheet->getStyle("A{$rowNum}")->applyFromArray([
            'font' => [
                'size' => 10,
                'bold' => false
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);
        $rowNum++;

// Başlık için "Sözleşme Bedeli", "Sözleşme Tarihi", vb. başlıkları ekleyelim
        $sheet->setCellValue("B{$rowNum}", "Sözleşme Bedeli");
        $sheet->mergeCells("B{$rowNum}:C{$rowNum}");
        $sheet->setCellValue("D{$rowNum}", "Sözleşme Tarihi");
        $sheet->mergeCells("D{$rowNum}:E{$rowNum}");
        $sheet->setCellValue("F{$rowNum}", "Yer Teslim Tarihi");
        $sheet->mergeCells("F{$rowNum}:G{$rowNum}");
        $sheet->setCellValue("H{$rowNum}", "Süresi");
        $sheet->mergeCells("H{$rowNum}:I{$rowNum}");
        $sheet->setCellValue("J{$rowNum}", "Bitiş Tarihi");
        $sheet->mergeCells("J{$rowNum}:K{$rowNum}");
        $sheet->getStyle("B{$rowNum}:K{$rowNum}")->applyFromArray([
            'font' => [
                'size' => 8,
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        $rowNum++;

// Sözleşme bilgilerini dolduralım
        $sheet->setCellValue("B{$rowNum}", money_format($contract->sozlesme_bedel) . " " . $contract->para_birimi);
        $sheet->mergeCells("B{$rowNum}:C{$rowNum}");
        $sheet->setCellValue("D{$rowNum}", dateFormat_dmy($contract->sozlesme_tarih));
        $sheet->mergeCells("D{$rowNum}:E{$rowNum}");
        $sheet->setCellValue("F{$rowNum}", dateFormat_dmy($contract->sitedel_date));
        $sheet->mergeCells("F{$rowNum}:G{$rowNum}");
        $sheet->setCellValue("H{$rowNum}", $contract->isin_suresi . " Gün");
        $sheet->mergeCells("H{$rowNum}:I{$rowNum}");
        $sheet->setCellValue("J{$rowNum}", dateFormat_dmy($contract->sozlesme_bitis));
        $sheet->mergeCells("J{$rowNum}:K{$rowNum}");
        $sheet->getStyle("B{$rowNum}:K{$rowNum}")->applyFromArray([
            'font' => [
                'size' => 8,
                'bold' => false
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        $rowNum++; // Yeni satıra geç

// Ayrım satır ekleyelim
        $sheet->setCellValue("A{$rowNum}", "");
        $sheet->mergeCells("A{$rowNum}:F{$rowNum}");
        $rowNum++;

// "SÜREYE GÖRE İLERLEME" başlığını ekleyelim
        $sheet->setCellValue("B{$rowNum}", "SÜREYE GÖRE İLERLEME");
        $sheet->mergeCells("B{$rowNum}:K{$rowNum}");
        $sheet->getStyle("B{$rowNum}")->applyFromArray([
            'font' => [
                'size' => 8,
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
        ]);

        $rowNum++;
        $elapsed_Day = fark_gun($contract->sozlesme_tarih);
        $total_day = $contract->isin_suresi;
        $percantage = 0;

        if ($total_day > 0) {
            $percantage = ($elapsed_Day / $total_day) * 100;
        }

        $percantage = min(max(round($percantage), 0), 100);

// Renk kodları dizisi
        $colorCodes = [
            '006400', '008000', '3bc43b', '88de37', 'bdbd51',
            'b49c1a', 'de9206', 'bd6217', '7a220e', '540202'
        ];

// Yüzdeyi B12 hücresine yazalım
        $sheet->setCellValue("B{$rowNum}", "$percantage%");
        $sheet->getStyle("B{$rowNum}")->applyFromArray([
            'font' => [
                'size' => 8,
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
        ]);

// 10'luk dilimlerde hücreleri renklendirelim ve birleştirelim
        $startColumn = 'B';
        $endColumn = 'K';
        $totalColumns = ord($endColumn) - ord($startColumn) + 1;

// Yüzde dilimlerine göre hücreleri birleştir ve renklendir
        $percentRange = floor($percantage / 10);

// Yüzde 100'e eşit veya büyükse, yüzdeyi 9'a ayarla
        $percentRange = min($percentRange, 9); // 9 ile sınırlandırıldı

// Renk kodunu al
        $color = $colorCodes[$percentRange];

// B12'dan başlayıp, 'B' ile 'K' arasındaki hücreleri dinamik olarak birleştir
        $mergedRange = $startColumn . "$rowNum:" . chr(ord($startColumn) + $percentRange) . "$rowNum";
        $sheet->mergeCells($mergedRange);
        $sheet->getStyle($mergedRange)->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => $color]
            ],
        ]);

// Kalan hücreleri gri renkle doldur
        if ($percentRange < $totalColumns - 1) {
            $remainingRange = chr(ord($startColumn) + $percentRange + 1) . "$rowNum:" . $endColumn . "$rowNum";
            $sheet->mergeCells($remainingRange);
            $sheet->getStyle($remainingRange)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D3D3D3']
                ],
            ]);
        }

        $rowNum++;
        $rowNum++;

        foreach ($extimes as $extime) {
              $elapsed_Day = fark_gun($extime->baslangic_tarih); // Başlangıç tarihinden geçen gün sayısını hesapla
            $total_day = dateDifference($extime->baslangic_tarih,$extime->bitis_tarih);  // Toplam süreyi al
             $percantage = $elapsed_Day / $total_day * 100;  // Yüzdeyi hesapla

            // Eğer süreyi aşmışsa, %100 yap
            if ($elapsed_Day >= $total_day) {
                $percantage = 100;
            } else {
                // Eğer süre tamamlanmamışsa, kalan günü hesapla
                $remain_day = $total_day - $elapsed_Day;
            }

            // Süre bitmişse, kalan günleri boş olarak göster
            if ($elapsed_Day > $total_day) {
                $elapsed_Day = "-";
                $remain_day = "-";
            }

            // Eğer kalan gün negatifse, onu "-"'a çevirelim
            if ($remain_day < 0) {
                $remain_day = "-";
            }

            // Yüzdeyi ve kalan günleri hücrelere yaz
            $sheet->setCellValue("B{$rowNum}", "$percantage%"); // Yüzdeyi B12 hücresine yaz
            $sheet->setCellValue("C{$rowNum}", "$remain_day gün kaldı"); // Kalan günleri C12 hücresine yaz

            // Grafik için renk kodları
            $colorCodes = [
                '006400', '008000', '3bc43b', '88de37', 'bdbd51',
                'b49c1a', 'de9206', 'bd6217', '7a220e', '540202'
            ];

            // Yüzdeyi 0-100 arasında sınırla
            $percantage = min(max(round($percantage), 0), 100);

            // Yüzde dilimini hesapla
            $percentRange = floor($percantage / 10);
            $percentRange = min($percentRange, 9); // 100%'yi geçmemek için

            // Renk kodunu al
            $color = $colorCodes[$percentRange];

            // Süreyi ve renkli grafik hücreleri için işlemleri yapalım
            $startColumn = 'B';
            $endColumn = 'K';
            $totalColumns = ord($endColumn) - ord($startColumn) + 1;

            // Yüzdeyi hesapladıktan sonra B12:K12 arasındaki hücreleri renklendir
            $mergedRange = $startColumn . "$rowNum:" . chr(ord($startColumn) + $percentRange) . "$rowNum";
            $sheet->mergeCells($mergedRange);
            $sheet->getStyle($mergedRange)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color]
                ],
            ]);

            // Kalan hücreleri gri renkle doldur
            if ($percentRange < $totalColumns - 1) {
                $remainingRange = chr(ord($startColumn) + $percentRange + 1) . "$rowNum:" . $endColumn . "$rowNum";
                $sheet->mergeCells($remainingRange);
                $sheet->getStyle($remainingRange)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D3D3D3'] // Gri renk
                    ],
                ]);
            }

            // Satırı bir artır (Bir sonraki satıra geç)
            $rowNum++;
        }

        $filename = "$contract->contract_name" . " Sözleşme Özeti.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }


    public function group_download_excel($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageMargins()->setTop(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setLeft(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setRight(0);     // 0 cm

        $sheet->getStyle('A1:Z1000')->applyFromArray([
            'font' => [
                'size' => 8, // Yazı büyüklüğü 8 punto
            ],
        ]);

        // Logo dosyasının yolu
        $logoPath = realpath("assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR . "logo.png");


// Logo'
//yu ekleyin
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is your logo');
        $drawing->setPath($logoPath); // Resim dosyasının yolu
        $drawing->setCoordinates('B1'); // Resmin yerleştirileceği hücre
        $drawing->setHeight(60); // Resmin yüksekliği (piksel)
        $drawing->setWorksheet($sheet);


        // Sütun genişlikleri ayarlanıyor
        $sheet->getColumnDimension('A')->setWidth(3); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('B')->setWidth(3); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('C')->setWidth(10); // 35 piksel (yaklaşık)
        $sheet->getColumnDimension('D')->setWidth(55); // 220 piksel (yaklaşık)
        $sheet->getColumnDimension('E')->setWidth(12); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('F')->setWidth(12); // 65 piksel (yaklaşık)
        $rowNum = 2;

        $contract = $this->Contract_model->get(array('id' => $contract_id));

        $sheet->setCellValue("E{$rowNum}", "Tarih :");
        $sheet->getStyle("B{$rowNum}:F{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                // Yazıyı koyu yap
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);

        $sheet->setCellValue("F{$rowNum}", dateFormat_dmy($contract->sozlesme_tarih));

        $rowNum++;
        $rowNum++;

        // Sözleşme ve ana grup bilgilerini al
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "main_group" => 1), "code ASC");

        $sheet->mergeCells("B{$rowNum}:F{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "SÖZLEŞME GRUPLAR ÖZETİ");
        // Satır yüksekliğini ayarlayın (örneğin, varsayılan yüksekliğin 2 katı)
        $sheet->getRowDimension($rowNum)->setRowHeight(30); // Varsayılan 15 px olduğu varsayımıyla 30 px

// Hücre stilini uygulayın
        $sheet->getStyle("B{$rowNum}:F{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 14,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);


        $rowNum++;
        $rowNum++;

        $sheet->mergeCells("B{$rowNum}:C{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "İşin Adı :");
        $sheet->getStyle("B{$rowNum}:C{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 12,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $sheet->mergeCells("D{$rowNum}:F{$rowNum}");  // B-F sütunları birleştirildi

        $sheet->setCellValue("D{$rowNum}", $contract->contract_name);
        $sheet->getStyle("D{$rowNum}:F{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 12,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $rowNum++;
        $rowNum++;


// Öncelikle tüm ana grupların genel toplamını bulalım
        $general_total = 0;

// Tüm ana ve alt grupları gezip genel toplamı hesaplayalım
        foreach ($prices_main_groups as $prices_main_group) {
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_group" => 1, "parent" => $prices_main_group->id), "code ASC");

            foreach ($sub_groups as $sub_group) {
                $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_id" => $sub_group->id), "code ASC");

                foreach ($boq_items as $boq_item) {
                    $general_total += $boq_item->qty * $boq_item->price;
                }
            }
        }

// Şimdi ana grup ve alt grupları tekrar gezerek her ana grup ve alt grup için yüzdelik oran hesaplayalım
        foreach ($prices_main_groups as $prices_main_group) {

            $main_groups_total = 0; // Ana grup toplamı

            // Ana grup satırını yazdır
            $sheet->mergeCells("B{$rowNum}:E{$rowNum}");  // B-F sütunları birleştirildi
            $sheet->setCellValue("B{$rowNum}", "{$prices_main_group->code} {$prices_main_group->name}");
            $sheet->setCellValue("F{$rowNum}", ""); // Toplamı en son dolduracağız
            $sheet->setCellValue("G{$rowNum}", ""); // Ana grubun yüzdesi buraya yazacağız
            $sheet->getStyle("B{$rowNum}:G{$rowNum}")->applyFromArray([  // B-G sütunları stil uygulanıyor
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '808080'],
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);

            $mainGroupRowNum = $rowNum; // Ana grup toplamını sonra yazmak için satır numarasını sakla
            $rowNum++;

            // Alt grupları al
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_group" => 1, "parent" => $prices_main_group->id), "code ASC");

            foreach ($sub_groups as $sub_group) {
                $sub_group_total = 0;
                // Alt grup içindeki BOQ öğelerini al
                $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_id" => $sub_group->id), "code ASC");

                foreach ($boq_items as $boq_item) {
                    // Alt grup toplamını hesapla
                    $sub_group_total += $boq_item->qty * $boq_item->price;
                }

                // Alt grup toplamını ana grup toplamına ekle
                $main_groups_total += $sub_group_total;

                // Alt grup satırını yazdır
                $sheet->mergeCells("B{$rowNum}:E{$rowNum}");  // B-F sütunları birleştirildi
                $sheet->setCellValue("B{$rowNum}", "{$prices_main_group->code}.{$sub_group->code} {$sub_group->name}");
                $sheet->setCellValue("F{$rowNum}", $sub_group_total);

                // Alt grup yüzdesini hesaplayıp yazdır
                $sub_group_percentage = ($sub_group_total / $general_total) * 100;
                $sheet->setCellValue("G{$rowNum}", round($sub_group_percentage, 2) . '%');

                $sheet->getStyle("F{$rowNum}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $sheet->getStyle("B{$rowNum}:G{$rowNum}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'D0CECE'],
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $rowNum++;
            }

            // Ana grup toplamını ilgili hücreye yazdır
            $sheet->setCellValue("F{$mainGroupRowNum}", $main_groups_total);
            $sheet->getStyle("F{$mainGroupRowNum}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            // Ana grup yüzdesini hesaplayıp yazdır
            $main_group_percentage = ($main_groups_total / $general_total) * 100;
            $sheet->setCellValue("G{$mainGroupRowNum}", round($main_group_percentage, 2) . '%');

            $rowNum++; // Boş satır için bir satır ekleyelim (isteğe bağlı)
        }

        $filename = "$contract->contract_name" . " Sözleşme Grup İcmali.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    function group_download_pdf($contract_id)
    {
        $this->load->model("Company_model");

        // Sözleşme ve ana grup bilgilerini al
        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));

        $viewData = new stdClass();
        $viewData->contract = $contract;

        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        // Sayfa Ayarları
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();

        // Font Ayarları
        $pdf->SetFont('dejavusans', '', 8);

        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $pdf->Cell(0, 3, 'Tarih : ' . dateFormat_dmy($contract->sozlesme_tarih), 0, 1, 'R');
        $pdf->Ln();

        // Başlık
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(0, 3, 'SÖZLEŞME İŞ GRUPLARI', 0, 1, 'C');
        $pdf->Ln();

        // İşin Adı
        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(30, 3, 'İşin Adı :', 0, 0, 'L');
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Cell(0, 3, $contract->contract_name, 0, 1, 'L');
        $pdf->Ln();
        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(30, 3, 'İşveren :', 0, 0, 'L');
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Cell(0, 3, company_name($contract->isveren), 0, 1, 'L');
        $pdf->Ln();

        // Çerçeve çizme
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.5);

        $pdf->SetFont('dejavusans', 'B', 12);

        // Ana grup fontu
        $mainGroupFont = [
            'style' => 'B',
            'size' => 11,
            'fillColor' => [211, 211, 211],
        ];

        // Alt grup fontu
        $subGroupFont = [
            'style' => 'I',
            'size' => 9,
        ];

        // Ana grup ve alt grup yazdırma
        foreach ($main_groups as $main_group) {
            // Ana grup yazdırma
            $pdf->SetFont('dejavusans', $mainGroupFont['style'], $mainGroupFont['size']);
            $pdf->SetFillColorArray($mainGroupFont['fillColor']);
            $pdf->Cell(0, 6, $main_group->code . ' - ' . $main_group->name, 0, 1, 'L', 1);

            // Alt grupları yazdırma
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1, "parent" => $main_group->id));

            if (!empty($sub_groups)) {
                foreach ($sub_groups as $sub_group) {
                    $pdf->SetFont('dejavusans', $subGroupFont['style'], $subGroupFont['size']);
                    $pdf->Cell(10, 6, '', 0, 0); // 10 birimlik boşluk ekler
                    $pdf->Cell(0, 6, $main_group->code . '.' . $sub_group->code . ' - ' . $sub_group->name, 0, 1, 'L');
                }
            } else {
                // Alt grup yoksa 3 boş satır ekleyelim
                for ($i = 0; $i < 3; $i++) {
                    $pdf->Ln();
                }
            }

            // Ana grup ile alt gruplar arasında bir boşluk bırak
            $pdf->Ln();
        }

        // PDF çıktısını ver
        $pdf->Output('İmalat Grubu Raporu.pdf', 'I');
    }

    public function book_download_excel($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        // Model yükleme
        $this->load->model("Company_model");

        // Sözleşme ve ana grup bilgilerini al
        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "leader" => 1));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageMargins()->setTop(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setLeft(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setRight(0);     // 0 cm

        $sheet->getStyle('A1:Z1000')->applyFromArray([
            'font' => [
                'size' => 8, // Yazı büyüklüğü 8 punto
            ],
        ]);

        // Logo dosyasının yolu
        $logoPath = realpath("assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR . "logo.png");


// Logo'
//yu ekleyin
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is your logo');
        $drawing->setPath($logoPath); // Resim dosyasının yolu
        $drawing->setCoordinates('B1'); // Resmin yerleştirileceği hücre
        $drawing->setHeight(60); // Resmin yüksekliği (piksel)
        $drawing->setWorksheet($sheet);


        // Sütun genişlikleri ayarlanıyor
        $sheet->getColumnDimension('A')->setWidth(3); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('B')->setWidth(5); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('C')->setWidth(10); // 35 piksel (yaklaşık)
        $sheet->getColumnDimension('D')->setWidth(62); // 220 piksel (yaklaşık)
        $sheet->getColumnDimension('E')->setWidth(7); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('F')->setWidth(12); // 65 piksel (yaklaşık)
        $rowNum = 2;

        $contract = $this->Contract_model->get(array('id' => $contract_id));

        $sheet->setCellValue("E{$rowNum}", "Tarih :");
        $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);

        $sheet->setCellValue("F{$rowNum}", dateFormat_dmy($contract->sozlesme_tarih));

        $rowNum++;
        $rowNum++;

        // Sözleşme ve ana grup bilgilerini al
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "main_group" => 1), "code ASC");

        $sheet->mergeCells("B{$rowNum}:F{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "POZ LİSTESİ");
        // Satır yüksekliğini ayarlayın (örneğin, varsayılan yüksekliğin 2 katı)
        $sheet->getRowDimension($rowNum)->setRowHeight(30); // Varsayılan 15 px olduğu varsayımıyla 30 px

// Hücre stilini uygulayın
        $sheet->getStyle("B{$rowNum}:F{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 12,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);


        $rowNum++;
        $rowNum++;

        $sheet->mergeCells("B{$rowNum}:C{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "İşin Adı :");
        $sheet->getStyle("B{$rowNum}:C{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 10,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $sheet->mergeCells("D{$rowNum}:H{$rowNum}");  // B-F sütunları birleştirildi

        $sheet->setCellValue("D{$rowNum}", $contract->contract_name);
        $sheet->getStyle("D{$rowNum}:H{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 10,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $rowNum++;
        $rowNum++;

        $sheet->setCellValue('B' . $rowNum, "No");
        $sheet->setCellValue('C' . $rowNum, "Poz No");
        $sheet->setCellValue('D' . $rowNum, "İmalat Adı");
        $sheet->setCellValue('E' . $rowNum, "Birim");
        $sheet->setCellValue('F' . $rowNum, "Fiyat");

        $sheet->getStyle("B{$rowNum}:F{$rowNum}")->applyFromArray([  // B-H sütunları stil uygulanıyor
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '808080'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        $rowNum++;


// Başlangıç satır numarasını belirleyelim
        $i = 1;

        foreach ($leaders as $leader) {
            // Ana grup bilgilerini ekleyelim
            $sheet->setCellValue('B' . $rowNum, $i++);
            $sheet->setCellValueExplicit('C' . $rowNum, $leader->code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowNum, $leader->name);
            $sheet->setCellValue('E' . $rowNum, $leader->unit);
            $sheet->setCellValue('F' . $rowNum, $leader->price);

            // Kenarlık stili oluştur
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ];

            // Hücrelere kenarlık uygula
            $sheet->getStyle('B' . $rowNum . ':F' . $rowNum)->applyFromArray($styleArray);

            // Para birimi formatını belirle
            $currencyFormat = '';
            switch ($contract->para_birimi) {
                case 'Dolar':
                    $currencyFormat = '$#,##0.00'; // ABD Doları formatı
                    break;
                case 'Euro':
                    $currencyFormat = '€#,##0.00'; // Euro formatı
                    break;
                case 'TL':
                    $currencyFormat = '₺#,##0.00'; // Türk Lirası formatı
                    break;
                default:
                    $currencyFormat = '#,##0.00'; // Varsayılan format (para birimi sembolü olmadan)
                    break;
            }

            // F sütunundaki hücrelere para birimi formatı uygula
            $sheet->getStyle('F' . $rowNum)->getNumberFormat()->setFormatCode($currencyFormat);

            // Satır numarasını artır
            $rowNum++;
        }


        // Dosyayı indirme işlemi
        $writer = new Xlsx($spreadsheet);
        $downloadFileName = "$contract->contract_name - Poz Listesi.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $downloadFileName . '"');
        header('Cache-Control: max-age=0');

        try {
            $writer->save('php://output');
        } catch (\Exception $e) {
            die('Dosya yazma hatası: ' . $e->getMessage());
        }
    }

    function book_download_pdf($contract_id)
    {
        $this->load->model("Company_model");

        // Sözleşme ve ana grup bilgilerini al
        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $leaders = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "leader" => 1));

        $viewData = new stdClass();
        $viewData->contract = $contract;

        $this->load->library('pdf_creator');
        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        // Sayfa Ayarları
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();

        // Font Ayarları
        $pdf->SetFont('dejavusans', '', 8);

        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $pdf->Cell(0, 3, 'Tarih : ' . dateFormat_dmy($contract->sozlesme_tarih), 0, 1, 'R');
        $pdf->Ln();

        // Başlık
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(0, 3, 'SÖZLEŞME BİRİM FİYATLARI', 0, 1, 'C');
        $pdf->Ln();

        // İşin Adı
        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(30, 3, 'İşin Adı :', 0, 0, 'L');
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Cell(0, 3, $contract->contract_name, 0, 1, 'L');
        $pdf->Ln();

        $default_line_height = 6;

        // Table header
        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(10, $default_line_height, 'No', 1);
        $pdf->Cell(20, $default_line_height, 'Poz No', 1);
        $pdf->Cell(125, $default_line_height, 'İmalat Adı', 1);
        $pdf->Cell(12, $default_line_height, 'Birim', 1);
        $pdf->Cell(22, $default_line_height, 'Fiyat', 1);
        $pdf->Ln();

// Table data
        $pdf->SetFont('dejavusans', '', 8);

        $i = 1;
        foreach ($leaders as $leader) {
            $pdf->Cell(10, $default_line_height, $i++, 1);
            $pdf->Cell(20, $default_line_height, $leader->code, 1);
            $pdf->Cell(125, $default_line_height, $leader->name, 1);
            $pdf->Cell(12, $default_line_height, $leader->unit, 1);

            // Format price
            $price = $leader->price;
            switch ($contract->para_birimi) {
                case 'Dolar':
                    $price = '$' . number_format($price, 2);
                    break;
                case 'Euro':
                    $price = '€' . number_format($price, 2);
                    break;
                case 'TL':
                    $price = '₺' . number_format($price, 2);
                    break;
                default:
                    $price = number_format($price, 2);
                    break;
            }

            $pdf->Cell(22, $default_line_height, $price, 1);
            $pdf->Ln();
        }

        // Ana grup ile alt gruplar arasında bir boşluk bırak
        $pdf->Ln();

        // PDF çıktısını ver
        $pdf->Output('İmalat Grubu Raporu.pdf', 'I');
    }

    public function group_boq_download_excel($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageMargins()->setTop(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setLeft(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setRight(0);     // 0 cm

        $sheet->getStyle('A1:Z1000')->applyFromArray([
            'font' => [
                'size' => 8, // Yazı büyüklüğü 8 punto
            ],
        ]);

        // Logo dosyasının yolu
        $logoPath = realpath("assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR . "logo.png");


// Logo'
//yu ekleyin
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is your logo');
        $drawing->setPath($logoPath); // Resim dosyasının yolu
        $drawing->setCoordinates('B1'); // Resmin yerleştirileceği hücre
        $drawing->setHeight(60); // Resmin yüksekliği (piksel)
        $drawing->setWorksheet($sheet);


        // Sütun genişlikleri ayarlanıyor
        $sheet->getColumnDimension('A')->setWidth(3); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('B')->setWidth(3); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('C')->setWidth(10); // 35 piksel (yaklaşık)
        $sheet->getColumnDimension('D')->setWidth(65); // 220 piksel (yaklaşık)
        $sheet->getColumnDimension('E')->setWidth(7); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('F')->setWidth(9); // 65 piksel (yaklaşık)
        $rowNum = 2;

        $contract = $this->Contract_model->get(array('id' => $contract_id));

        $sheet->setCellValue("E{$rowNum}", "Tarih :");
        $sheet->getStyle("B{$rowNum}:F{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);

        $sheet->setCellValue("F{$rowNum}", dateFormat_dmy($contract->sozlesme_tarih));

        $rowNum++;
        $rowNum++;

        // Sözleşme ve ana grup bilgilerini al
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "main_group" => 1), "code ASC");

        $sheet->mergeCells("B{$rowNum}:F{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "İŞ GRUPLARINA GÖRE İMALAT LİSTESİ");
        // Satır yüksekliğini ayarlayın (örneğin, varsayılan yüksekliğin 2 katı)
        $sheet->getRowDimension($rowNum)->setRowHeight(30); // Varsayılan 15 px olduğu varsayımıyla 30 px

// Hücre stilini uygulayın
        $sheet->getStyle("B{$rowNum}:F{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 12,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);


        $rowNum++;
        $rowNum++;

        $sheet->mergeCells("B{$rowNum}:C{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "İşin Adı :");
        $sheet->getStyle("B{$rowNum}:C{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 10,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $sheet->mergeCells("D{$rowNum}:F{$rowNum}");  // B-F sütunları birleştirildi

        $sheet->setCellValue("D{$rowNum}", $contract->contract_name);
        $sheet->getStyle("D{$rowNum}:F{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 10,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $rowNum++;
        $rowNum++;


        foreach ($prices_main_groups as $prices_main_group) {
            // Ana grup satırı
            $sheet->mergeCells("B{$rowNum}:F{$rowNum}");  // B-F sütunları birleştirildi
            $sheet->setCellValue("B{$rowNum}", "{$prices_main_group->code} {$prices_main_group->name}");
            $sheet->getStyle("B{$rowNum}:F{$rowNum}")->applyFromArray([  // B-H sütunları stil uygulanıyor
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '808080'],
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);
            $rowNum++;

            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_group" => 1, "parent" => $prices_main_group->id), "code ASC");

            foreach ($sub_groups as $sub_group) {
                // Alt grup satırı
                $sheet->mergeCells("B{$rowNum}:F{$rowNum}");  // B-F sütunları birleştirildi
                $sheet->setCellValue("B{$rowNum}", "{$prices_main_group->code}.{$sub_group->code} {$sub_group->name}");
                $sheet->getStyle("B{$rowNum}:F{$rowNum}")->applyFromArray([  // B-F sütunları stil uygulanıyor
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'D0CECE'],
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $rowNum++;

                // Başlık satırı
                $sheet->setCellValue("B{$rowNum}", 'No');
                $sheet->setCellValue("C{$rowNum}", 'Kod');
                $sheet->setCellValue("D{$rowNum}", 'İsim');
                $sheet->setCellValue("E{$rowNum}", 'Birim');
                $sheet->setCellValue("F{$rowNum}", 'Birim Fiyat');
                $sheet->getStyle("B{$rowNum}:F{$rowNum}")->applyFromArray([  // B-F sütunları stil uygulanıyor
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $rowNum++;

                // Alt grup ürünleri ve alt grup toplamını hesaplamak için toplam değişkeni
                // Alt grup ürünleri ve alt grup toplamını hesaplamak için toplam değişkeni
                $sub_group_total = 0;
                $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_id" => $sub_group->id), "code ASC");
                $i = 1;
                $startRow = $rowNum; // Alt grup ürünlerinin başladığı satır numarası

                foreach ($boq_items as $boq_item) {
                    $sheet->setCellValue("B{$rowNum}", $i++);
                    $sheet->setCellValue("C{$rowNum}", $boq_item->code);
                    $sheet->setCellValue("D{$rowNum}", $boq_item->name);
                    $sheet->setCellValue("E{$rowNum}", $boq_item->unit);
                    $sheet->setCellValue("F{$rowNum}", $boq_item->price);

                    // H hücresinde qty * price formülü
                    $sheet->getStyle("F{$rowNum}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                    $sheet->getStyle("B{$rowNum}:F{$rowNum}")->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ]);

                    $rowNum++;
                }
                $rowNum++;
            }
        }

        $filename = "$contract->contract_name" . "- Poz Listesi (Gruplara Göre).xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function group_boq_download_pdf($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        // Sayfa Ayarları
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();

        // Font Ayarları
        $pdf->SetFont('dejavusans', '', 8);

        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $pdf->Cell(0, 3, 'Tarih : ' . dateFormat_dmy($contract->sozlesme_tarih), 0, 1, 'R');
        $pdf->Ln();

        // Başlık
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(0, 3, 'İŞ GRUPLARINA GÖRE İMALAT LİSTESİ', 0, 1, 'C');
        $pdf->Ln();

        // İşin Adı
        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(30, 3, 'İşin Adı :', 0, 0, 'L');
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Cell(0, 3, $contract->contract_name, 0, 1, 'L');
        $pdf->Ln();

        // Başlık Satırı

        // Veri Satırları
        $this->load->model('Contract_price_model');
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "main_group" => 1), "code ASC");

        foreach ($prices_main_groups as $prices_main_group) {
            $pdf->SetFont('dejavusans', 'B', 8);
            $pdf->SetFillColor(128, 128, 128);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(185, 6, "{$prices_main_group->code} {$prices_main_group->name}", 1, 0, 'L', 1);
            $pdf->Ln();

            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_group" => 1, "parent" => $prices_main_group->id), "code ASC");

            foreach ($sub_groups as $sub_group) {


                $pdf->SetFont('dejavusans', 'B', 8);
                $pdf->SetFillColor(208, 206, 206);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(185, 6, "{$prices_main_group->code}.{$sub_group->code} {$sub_group->name}", 1, 0, 'L', 1);
                $pdf->Ln();

                $pdf->SetFont('dejavusans', 'B', 8);
                $pdf->Cell(10, 6, 'No', 1, 0, 'C');
                $pdf->Cell(20, 6, 'Kod', 1, 0, 'C');
                $pdf->Cell(123, 6, 'İsim', 1, 0, 'C');
                $pdf->Cell(12, 6, 'Birim', 1, 0, 'C');
                $pdf->Cell(20, 6, 'Birim Fiyat', 1, 0, 'C');
                $pdf->Ln();

                // Alt grup ürünlerini ekle
                $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_id" => $sub_group->id), "code ASC");

                $pdf->SetFont('dejavusans', '', 8);
                $sub_group_total = 0;
                foreach ($boq_items as $index => $boq_item) {
                    $pdf->Cell(10, 6, $index + 1, 1);
                    $pdf->Cell(20, 6, $boq_item->code, 1);
                    $pdf->Cell(123, 6, $boq_item->name, 1);
                    $pdf->Cell(12, 6, $boq_item->unit, 1, "", "C");
                    $pdf->Cell(20, 6, number_format($boq_item->price, 2), 1, 0, 'R');
                    $pdf->Ln();

                }
            }
            $pdf->Ln();
        }

        // PDF'yi gönder

        $filename = "$contract->contract_name" . "- Poz Listesi (Gruplara Göre).pdf";
        $pdf->Output($filename, 'I');
    }

    public function contract_price_download_excel($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageMargins()->setTop(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setLeft(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setRight(0);     // 0 cm

        $sheet->getStyle('A1:Z1000')->applyFromArray([
            'font' => [
                'size' => 8, // Yazı büyüklüğü 8 punto
            ],
        ]);

        // Logo dosyasının yolu
        $logoPath = realpath("assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR . "logo.png");


// Logo'
//yu ekleyin
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is your logo');
        $drawing->setPath($logoPath); // Resim dosyasının yolu
        $drawing->setCoordinates('B1'); // Resmin yerleştirileceği hücre
        $drawing->setHeight(60); // Resmin yüksekliği (piksel)
        $drawing->setWorksheet($sheet);


        // Sütun genişlikleri ayarlanıyor
        $sheet->getColumnDimension('A')->setWidth(3); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('B')->setWidth(3); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('C')->setWidth(10); // 35 piksel (yaklaşık)
        $sheet->getColumnDimension('D')->setWidth(45); // 220 piksel (yaklaşık)
        $sheet->getColumnDimension('E')->setWidth(7); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('F')->setWidth(9); // 65 piksel (yaklaşık)
        $sheet->getColumnDimension('G')->setWidth(12); // 105 piksel (yaklaşık)
        $sheet->getColumnDimension('H')->setWidth(12); // 105 piksel (yaklaşık)
        $rowNum = 2;

        $contract = $this->Contract_model->get(array('id' => $contract_id));

        $sheet->setCellValue("G{$rowNum}", "Tarih :");
        $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);

        $sheet->setCellValue("H{$rowNum}", dateFormat_dmy($contract->sozlesme_tarih));

        $rowNum++;
        $rowNum++;

        // Sözleşme ve ana grup bilgilerini al
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "main_group" => 1), "code ASC");

        $sheet->mergeCells("B{$rowNum}:H{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "SÖZLEŞME BİRİM FİYAT VE MİKTARLARI");
        // Satır yüksekliğini ayarlayın (örneğin, varsayılan yüksekliğin 2 katı)
        $sheet->getRowDimension($rowNum)->setRowHeight(30); // Varsayılan 15 px olduğu varsayımıyla 30 px

// Hücre stilini uygulayın
        $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 12,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);


        $rowNum++;
        $rowNum++;

        $sheet->mergeCells("B{$rowNum}:C{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "İşin Adı :");
        $sheet->getStyle("B{$rowNum}:C{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 10,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $sheet->mergeCells("D{$rowNum}:H{$rowNum}");  // B-F sütunları birleştirildi

        $sheet->setCellValue("D{$rowNum}", $contract->contract_name);
        $sheet->getStyle("D{$rowNum}:H{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 10,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $rowNum++;
        $rowNum++;


        foreach ($prices_main_groups as $prices_main_group) {
            // Ana grup satırı
            $sheet->mergeCells("B{$rowNum}:H{$rowNum}");  // B-F sütunları birleştirildi
            $sheet->setCellValue("B{$rowNum}", "{$prices_main_group->code} {$prices_main_group->name}");
            $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([  // B-H sütunları stil uygulanıyor
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '808080'],
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);
            $rowNum++;

            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_group" => 1, "parent" => $prices_main_group->id), "code ASC");

            foreach ($sub_groups as $sub_group) {
                // Alt grup satırı
                $sheet->mergeCells("B{$rowNum}:H{$rowNum}");  // B-F sütunları birleştirildi
                $sheet->setCellValue("B{$rowNum}", "{$prices_main_group->code}.{$sub_group->code} {$sub_group->name}");
                $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([  // B-F sütunları stil uygulanıyor
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'D0CECE'],
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $rowNum++;

                // Başlık satırı
                $sheet->setCellValue("B{$rowNum}", 'No');
                $sheet->setCellValue("C{$rowNum}", 'Kod');
                $sheet->setCellValue("D{$rowNum}", 'İsim');
                $sheet->setCellValue("E{$rowNum}", 'Birim');
                $sheet->setCellValue("F{$rowNum}", 'Miktar');
                $sheet->setCellValue("G{$rowNum}", 'Birim Fiyat');
                $sheet->setCellValue("H{$rowNum}", 'Toplam');
                $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([  // B-F sütunları stil uygulanıyor
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $rowNum++;

                // Alt grup ürünleri ve alt grup toplamını hesaplamak için toplam değişkeni
                // Alt grup ürünleri ve alt grup toplamını hesaplamak için toplam değişkeni
                $sub_group_total = 0;
                $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_id" => $sub_group->id), "code ASC");
                $i = 1;
                $startRow = $rowNum; // Alt grup ürünlerinin başladığı satır numarası

                foreach ($boq_items as $boq_item) {
                    $sheet->setCellValue("B{$rowNum}", $i++);
                    $sheet->setCellValue("C{$rowNum}", $boq_item->code);
                    $sheet->setCellValue("D{$rowNum}", $boq_item->name);
                    $sheet->setCellValue("E{$rowNum}", $boq_item->unit);
                    $sheet->setCellValue("F{$rowNum}", $boq_item->qty);
                    $sheet->getStyle("F{$rowNum}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $sheet->setCellValue("G{$rowNum}", $boq_item->price);
                    $sheet->getStyle("G{$rowNum}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                    // H hücresinde qty * price formülü
                    $sheet->setCellValue("H{$rowNum}", "=F{$rowNum}*G{$rowNum}");
                    $sheet->getStyle("H{$rowNum}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                    $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ]);

                    // Alt grup toplamına ekleme
                    $sub_group_total += $boq_item->qty * $boq_item->price;

                    $rowNum++;
                }

// Formülü yazma
                $endRow = $rowNum - 1; // Alt grup ürünlerinin bittiği satır numarası
                $sheet->mergeCells("B{$rowNum}:G{$rowNum}");  // B-F sütunları birleştirildi
                $sheet->setCellValue("B{$rowNum}", "TOPLAM");
                $sheet->setCellValue("H{$rowNum}", "=SUM(H{$startRow}:H{$endRow})"); // Formülü ekleme
                $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

// Sağ kenarlığı sadece H sütununa uygulama
                $sheet->getStyle("H{$rowNum}")->applyFromArray([
                    'borders' => [
                        'right' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                        'bottom' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

// Alt kenarlığı tüm birleşik hücreler için uygulama
                $sheet->getStyle("B{$rowNum}:G{$rowNum}")->applyFromArray([
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

// Alt grup toplamını yazma
                $sheet->setCellValue("H{$rowNum}", "=SUM(H{$startRow}:H{$endRow})");
                $sheet->getStyle("H{$rowNum}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $rowNum++;
                $rowNum++;
            }
        }

        $filename = 'Contract_Price_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function contract_price_download_pdf($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('P');

        // Sayfa Ayarları
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();

        // Font Ayarları
        $pdf->SetFont('dejavusans', '', 8);

        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $pdf->Cell(0, 3, 'Tarih : ' . dateFormat_dmy($contract->sozlesme_tarih), 0, 1, 'R');
        $pdf->Ln();

        // Başlık
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(0, 3, 'SÖZLEŞME BİRİM FİYAT VE MİKTARLARI', 0, 1, 'C');
        $pdf->Ln();

        // İşin Adı
        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(30, 3, 'İşin Adı :', 0, 0, 'L');
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Cell(0, 3, $contract->contract_name, 0, 1, 'L');
        $pdf->Ln();

        // Başlık Satırı

        // Veri Satırları
        $this->load->model('Contract_price_model');
        $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "main_group" => 1), "code ASC");

        foreach ($prices_main_groups as $prices_main_group) {
            $pdf->SetFont('dejavusans', 'B', 8);
            $pdf->SetFillColor(128, 128, 128);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(185, 6, "{$prices_main_group->code} {$prices_main_group->name}", 1, 0, 'L', 1);
            $pdf->Ln();

            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_group" => 1, "parent" => $prices_main_group->id), "code ASC");

            foreach ($sub_groups as $sub_group) {


                $pdf->SetFont('dejavusans', 'B', 8);
                $pdf->SetFillColor(208, 206, 206);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(185, 6, "{$prices_main_group->code}.{$sub_group->code} {$sub_group->name}", 1, 0, 'L', 1);
                $pdf->Ln();

                $pdf->SetFont('dejavusans', 'B', 8);
                $pdf->Cell(10, 6, 'No', 1, 0, 'C');
                $pdf->Cell(20, 6, 'Kod', 1, 0, 'C');
                $pdf->Cell(90, 6, 'İsim', 1, 0, 'C');
                $pdf->Cell(12, 6, 'Birim', 1, 0, 'C');
                $pdf->Cell(12, 6, 'Miktar', 1, 0, 'C');
                $pdf->Cell(20, 6, 'Birim Fiyat', 1, 0, 'C');
                $pdf->Cell(21, 6, 'Toplam', 1, 0, 'C');
                $pdf->Ln();

                // Alt grup ürünlerini ekle
                $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_id" => $sub_group->id), "code ASC");

                $pdf->SetFont('dejavusans', '', 8);
                $sub_group_total = 0;
                foreach ($boq_items as $index => $boq_item) {
                    $pdf->Cell(10, 6, $index + 1, 1);
                    $pdf->Cell(20, 6, $boq_item->code, 1);
                    $pdf->Cell(90, 6, $boq_item->name, 1);
                    $pdf->Cell(12, 6, $boq_item->unit, 1, "", "C");
                    $pdf->Cell(12, 6, number_format($boq_item->qty, 2), 1, 0, 'C');
                    $pdf->Cell(20, 6, number_format($boq_item->price, 2), 1, 0, 'R');
                    $total = $boq_item->qty * $boq_item->price;
                    $pdf->Cell(21, 6, number_format($total, 2), 1, 1, 'R');

                    $sub_group_total += $total;
                }


                // Alt grup toplamını yazma
                $pdf->SetFont('dejavusans', 'B', 8);
                $pdf->Cell(164, 6, 'TOPLAM', 1, "0", "R");
                $pdf->Cell(21, 6, number_format($sub_group_total, 2), 1, 0, 'R');
                $pdf->Ln();
                $pdf->Ln();

            }
            $pdf->Ln();

        }

        // PDF'yi gönder
        $filename = 'Contract_Price_' . date('Y-m-d') . '.pdf';
        $pdf->Output($filename, 'I');
    }


    public function sitestock_download_excel($site_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $site = $this->Site_model->get(array("id" => $site_id));
        $contract = $this->Contract_model->get(array("id" => $site->contract_id));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageMargins()->setTop(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setLeft(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setRight(0);     // 0 cm

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->getStyle('A1:Z1000')->applyFromArray([
            'font' => [
                'size' => 8, // Yazı büyüklüğü 8 punto
            ],
        ]);

        // Logo dosyasının yolu
        $logoPath = realpath("assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR . "logo.png");


// Logo'
//yu ekleyin
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is your logo');
        $drawing->setPath($logoPath); // Resim dosyasının yolu
        $drawing->setCoordinates('B1'); // Resmin yerleştirileceği hücre
        $drawing->setHeight(60); // Resmin yüksekliği (piksel)
        $drawing->setWorksheet($sheet);


        // Sütun genişlikleri ayarlanıyor
        $sheet->getColumnDimension('A')->setWidth(3); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('B')->setWidth(5); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('C')->setWidth(40); // 35 piksel (yaklaşık)
        $sheet->getColumnDimension('D')->setWidth(10); // 220 piksel (yaklaşık)
        $sheet->getColumnDimension('E')->setWidth(10); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('F')->setWidth(10); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('G')->setWidth(10); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('H')->setWidth(40); // 65 piksel (yaklaşık)
        $rowNum = 2;


        $sheet->setCellValue("H{$rowNum}", "Tarih :" . dateFormat_dmy($contract->sozlesme_tarih));
        $sheet->getStyle("H{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);


        $rowNum++;
        $rowNum++;

        // Sözleşme ve ana grup bilgilerini al
        $site_stocks = $this->Sitestock_model->get_all(array("site_id" => $site->id, "parent_id" => null));

        $sheet->mergeCells("B{$rowNum}:H{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "ŞANTİYE STOK/DEPO ENVANTERİ");
        // Satır yüksekliğini ayarlayın (örneğin, varsayılan yüksekliğin 2 katı)
        $sheet->getRowDimension($rowNum)->setRowHeight(30); // Varsayılan 15 px olduğu varsayımıyla 30 px

// Hücre stilini uygulayın
        $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 12,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);


        $rowNum++;
        $rowNum++;

        $sheet->mergeCells("B{$rowNum}:H{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "İşin Adı : " . $site->santiye_ad);
        $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 10,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $rowNum++;
        $rowNum++;


        $sheet->setCellValue("B{$rowNum}", '#');
        $sheet->setCellValue("C{$rowNum}", 'Stok Adı');
        $sheet->setCellValue("D{$rowNum}", 'Birim');
        $sheet->setCellValue("E{$rowNum}", 'Gelen Miktar');
        $sheet->setCellValue("F{$rowNum}", 'Kalan Miktar');
        $sheet->setCellValue("G{$rowNum}", 'İşlem Tarihi');
        $sheet->setCellValue("H{$rowNum}", 'Açıklama');

        $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        $rowNum++; // Sonraki satıra geçiyoruz

        $i = 1;
        foreach ($site_stocks as $site_stock) {
            $kalan = $site_stock->stock_in - sum_anything("sitestock", "stock_out", "parent_id", "$site_stock->id");

            // Verileri Excel'e ekleyelim
            $sheet->setCellValue("B{$rowNum}", $i++); // İşlem kısmı
            $sheet->setCellValue("C{$rowNum}", $site_stock->stock_name); // Stok Adı
            $sheet->setCellValue("D{$rowNum}", $site_stock->unit); // Birim
            $sheet->setCellValue("E{$rowNum}", $site_stock->stock_in); // Miktarı
            $sheet->setCellValue("F{$rowNum}", number_format($kalan)); // Kalan
            $sheet->setCellValue("G{$rowNum}", dateFormat_dmy($site_stock->arrival_date)); // Tarihi
            $sheet->setCellValue("H{$rowNum}", !empty($site_stock->from) ? site_name($site_stock->from) . ' Şantiyesinden Transfer' : $site_stock->notes); // Açıklama

            // Stil ekleyelim
            $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);

            $rowNum++;

            // Hareket satırlarını ekleyelim
            $stock_movements = $this->Sitestock_model->get_all(array("site_id" => $site->id, "parent_id" => $site_stock->id));
            foreach ($stock_movements as $stock_movement) {
                $sheet->setCellValue("B{$rowNum}", $i++); // Hareket sütunları
                $sheet->setCellValue("C{$rowNum}", ''); // Boş stok adı
                $sheet->setCellValue("C{$rowNum}", ''); // Boş stok adı
                $sheet->setCellValue("D{$rowNum}", ''); // Miktarı
                $sheet->setCellValue("E{$rowNum}", '-' . $stock_movement->stock_out); // Boş kalan
                $sheet->setCellValue("F{$rowNum}", ''); // Boş kalan
                $sheet->setCellValue("G{$rowNum}", dateFormat_dmy($stock_movement->exit_date)); // Hareket tarihi
                $sheet->setCellValue("H{$rowNum}", $stock_movement->notes); // Hareket açıklaması

                $sheet->getStyle("B{$rowNum}:H{$rowNum}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $rowNum++;
            }
        }


        $filename = "$site->santiye_ad" . "- Depo Stok Raporu.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function sitestock_download_pdf($site_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $site = $this->Site_model->get(array("id" => $site_id));
        $contract = $this->Contract_model->get(array("id" => $site->contract_id));

        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('L');

        // PDF Bilgilerini ayarla
        $pdf->SetAuthor('Şirket İsmi');
        $pdf->SetTitle('Depo Stok Raporu');
        $pdf->SetSubject('Stok');
        $pdf->SetKeywords('stok, depo, envanter, rapor');

        // Margin ayarları
        $pdf->SetMargins(10, 6, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);

        // Sayfa ekle
        $pdf->AddPage();


        // Yazı tipi ayarla
        $pdf->SetFont('dejavusans', 'B', 12);

        // Başlık
        $pdf->Cell(0, 6, 'ŞANTİYE STOK/DEPO ENVANTERİ', 0, 1, 'C');

        // Sözleşme Bilgileri
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Cell(30, 6, 'Tarih: ' . dateFormat_dmy($contract->sozlesme_tarih), 0, 1);
        $pdf->Cell(30, 6, 'İşin Adı: ' . $site->santiye_ad, 0, 1);

        // Boşluk bırak
        $pdf->Ln(10);

        // Tablo başlıkları
        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->SetFillColor(200, 200, 200);
        $pdf->Cell(10, 9, '#', 1, 0, 'C', 1);
        $pdf->Cell(90, 9, 'Stok Adı', 1, 0, 'C', 1);
        $pdf->Cell(20, 9, 'Birim', 1, 0, 'C', 1);
        $pdf->MultiCell(20, 9, 'Gelen' . "\n" . 'Miktar', 1, 'C', 1, 0);
        $pdf->MultiCell(20, 9, 'Kalan' . "\n" . 'Miktar', 1, 'C', 1, 0);
        $pdf->Cell(25, 9, 'İşlem Tarihi', 1, 0, 'C', 1);
        $pdf->Cell(90, 9, 'Açıklama', 1, 1, 'C', 1);

        // Stok verilerini al
        $site_stocks = $this->Sitestock_model->get_all(array("site_id" => $site->id, "parent_id" => null));

        $pdf->SetFont('dejavusans', '', 9); // Veriler için yazı tipi
        $i = 1;

        foreach ($site_stocks as $site_stock) {
            $kalan = $site_stock->stock_in - sum_anything("sitestock", "stock_out", "parent_id", "$site_stock->id");

            // Stok verilerini tabloya ekle
            $pdf->Cell(10, 6, $i++, 1);
            $pdf->Cell(90, 6, $site_stock->stock_name, 1);
            $pdf->Cell(20, 6, $site_stock->unit, 1, "", "C");
            $pdf->Cell(20, 6, money_format($site_stock->stock_in), 1, "", "R");
            $pdf->Cell(20, 6, money_format($kalan), 1, "", "R");
            $pdf->Cell(25, 6, dateFormat_dmy($site_stock->arrival_date), 1, "", "C");
            $pdf->Cell(90, 6, !empty($site_stock->from) ? site_name($site_stock->from) . ' Şantiyesinden Transfer' : $site_stock->notes, 1, 1);

            // Hareket satırlarını ekleyelim
            $stock_movements = $this->Sitestock_model->get_all(array("site_id" => $site->id, "parent_id" => $site_stock->id));

            foreach ($stock_movements as $stock_movement) {
                $pdf->Cell(10, 6, $i++, 1);
                $pdf->SetFillColor(255, 0, 0); // Kırmızı renk
                $pdf->SetAlpha(0.2); // %50 şeffaflık

                $pdf->Cell(110, 6, 'Çıkış', 1, 0, 'R', 1); // Transparan kırmızı dolgu ile hücre

                $pdf->SetAlpha(1); // Transparanlığı sıfırla (Normal opaklık)                $pdf->Cell(110, 6, 'Çıkış', 1,"","L","1");
                $pdf->Cell(20, 6, money_format(($stock_movement->stock_out) * -1), 1, "", "R");
                $pdf->Cell(20, 6, '', 1);
                $pdf->Cell(25, 6, dateFormat_dmy($stock_movement->exit_date), 1, "", "C");
                $pdf->Cell(90, 6, $stock_movement->notes, 1, 1);
            }
        }

        // PDF dosyasını oluştur ve kullanıcıya gönder
        $pdf->Output($site->santiye_ad . '- Depo Stok Raporu.pdf', 'D');
    }

    public function report_download_excel($site_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $this->load->model("Workman_model");
        $this->load->model("Report_model");
        $site = $this->Site_model->get(array("id" => $site_id));
        $contract = $this->Contract_model->get(array("id" => $site->contract_id));
        $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1));
        $all_workgroups = $this->Report_workgroup_model->get_unique_workgroups($site->id);
        $all_workmachines = $this->Report_workmachine_model->get_unique_workmachine($site->id);
        $reports = $this->Report_model->get_all(array("site_id" => $site->id));


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()
            ->setPaperSize(PageSetup::PAPERSIZE_A4)  // A4 boyutunda yapar
            ->setOrientation(PageSetup::ORIENTATION_DEFAULT);  // Dikey olarak ayarlar

        $sheet->getPageMargins()->setTop(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setLeft(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setRight(0);     // 0 cm

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->getStyle('A1:Z1000')->applyFromArray([
            'font' => [
                'size' => 8, // Yazı büyüklüğü 8 punto
            ],
        ]);

        // Logo dosyasının yolu
        $logoPath = realpath("assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR . "logo.png");


// Logo'
//yu ekleyin
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is your logo');
        $drawing->setPath($logoPath); // Resim dosyasının yolu
        $drawing->setCoordinates('B1'); // Resmin yerleştirileceği hücre
        $drawing->setHeight(60); // Resmin yüksekliği (piksel)
        $drawing->setWorksheet($sheet);


        // Sütun genişlikleri ayarlanıyor
        $sheet->getColumnDimension('A')->setWidth(3); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('B')->setWidth(7); // 8 piksel (yaklaşık)
        $sheet->getColumnDimension('C')->setWidth(30); // 35 piksel (yaklaşık)
        $sheet->getColumnDimension('D')->setWidth(15); // 220 piksel (yaklaşık)
        $sheet->getColumnDimension('E')->setWidth(5); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('F')->setWidth(17); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('G')->setWidth(5); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('H')->setWidth(5); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('I')->setWidth(17); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('J')->setWidth(5); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('K')->setWidth(5); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('L')->setWidth(17); // 45 piksel (yaklaşık)
        $sheet->getColumnDimension('M')->setWidth(5); // 45 piksel (yaklaşık)

        $rowNum = 2;
        $sheet->mergeCells("L{$rowNum}:M{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("L{$rowNum}", "Tarih: " . date('d.m.Y'));
        $sheet->getStyle("L{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);


        $rowNum++;
        $rowNum++;


        $sheet->mergeCells("B{$rowNum}:M{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "Çalışma Özeti");
        // Satır yüksekliğini ayarlayın (örneğin, varsayılan yüksekliğin 2 katı)
        $sheet->getRowDimension($rowNum)->setRowHeight(40); // Varsayılan 15 px olduğu varsayımıyla 30 px

// Hücre stilini uygulayın
        $sheet->getStyle("B{$rowNum}:D{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 16,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],

        ]);


        $rowNum++;
        $rowNum++;

        $sheet->mergeCells("B{$rowNum}:M{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "İşin Adı : " . $site->santiye_ad);
        $sheet->getStyle("B{$rowNum}:M{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 12,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $rowNum++;
        $rowNum++;

        $sheet->mergeCells("B{$rowNum}:C{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", 'Toplam Günlük Rapor Sayısı');

        $sheet->setCellValue("D{$rowNum}", count($reports));
        $sheet->getStyle("B{$rowNum}:D{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,    // Yazıyı koyu yapar
                'size' => 12,      // 12 punto yapar
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,  // İnce çizgi
                    'color' => ['argb' => 'FF000000'],     // Siyah renk
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Dolu arka plan
                'startColor' => [
                    'argb' => 'FFD9D9D9', // Açık gri rengi
                ],
            ],
        ]);

        $rowNum++;
        $rowNum++;


        $sheet->setCellValue("B{$rowNum}", '#');
        $sheet->setCellValue("C{$rowNum}", 'Ekip');
        $sheet->setCellValue("D{$rowNum}", 'Çalışma (Gün)');

        $sheet->getStyle("B{$rowNum}:D{$rowNum}")->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Dolu arka plan
                'startColor' => [
                    'argb' => 'FFD9D9D9', // Açık gri rengi
                ],
            ],
            'font' => [
                'bold' => true,    // Yazıyı koyu yapar
                'size' => 12,      // 12 punto yapar
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,  // İnce çizgi
                    'color' => ['argb' => 'FF000000'],     // Siyah renk
                ],
            ],
        ]);

        $rowNum++;

// Verileri ekle
        $i = 1;
// Çalışma Gruplarını ekle
        foreach ($all_workgroups as $subgroup) {
            $group_total = sum_anything_and("report_workgroup", "number", "site_id", $site->id, "workgroup", $subgroup['workgroup']);
            $sheet->setCellValue('B' . $rowNum, $i++);
            $sheet->setCellValue('C' . $rowNum, htmlspecialchars(group_name($subgroup['workgroup'])));
            $sheet->setCellValue('D' . $rowNum, $group_total);
            $sheet->getStyle("B{$rowNum}:D{$rowNum}")->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                    'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                    'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,  // İnce çizgi
                        'color' => ['argb' => 'FF000000'],     // Siyah renk
                    ],
                ],
            ]);
            $rowNum++;
        }


        $total_group_total = 0;
        foreach ($all_workgroups as $subgroup) {
            $group_total = sum_anything_and("report_workgroup", "number", "site_id", $site->id, "workgroup", $subgroup['workgroup']);
            $total_group_total += $group_total;
        }

        $sheet->mergeCells("B{$rowNum}:C{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", 'Toplam');

        $sheet->setCellValue("D{$rowNum}", $total_group_total);

        $sheet->getStyle("B{$rowNum}:D{$rowNum}")->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Dolu arka plan
                'startColor' => [
                    'argb' => 'FFEFEFEF', // Açık gri rengi
                ],
            ],
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,  // İnce çizgi
                    'color' => ['argb' => 'FF000000'],     // Siyah renk
                ],
            ],
        ]);


        $rowNum++;
        $rowNum++;

        $sheet->setCellValue("B{$rowNum}", '#');
        $sheet->setCellValue("C{$rowNum}", 'Makine');
        $sheet->setCellValue("D{$rowNum}", 'Çalışma (Gün)');

        $sheet->getStyle("B{$rowNum}:D{$rowNum}")->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Dolu arka plan
                'startColor' => [
                    'argb' => 'FFD9D9D9', // Açık gri rengi
                ],
            ],
            'font' => [
                'bold' => true,    // Yazıyı koyu yapar
                'size' => 12,      // 12 punto yapar
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,  // İnce çizgi
                    'color' => ['argb' => 'FF000000'],     // Siyah renk
                ],
            ],
        ]);

        $rowNum++;
        $i = 1;

// Çalışma Makinelerini ekle
        $total_submachine_total = 0;

        foreach ($all_workmachines as $submachine) {
            $submachine_total = sum_anything_and("report_workmachine", "number", "site_id", $site->id, "workmachine", $submachine['workmachine']);
            $total_submachine_total += $submachine_total;

            $sheet->setCellValue('B' . $rowNum, $i++);
            $sheet->setCellValue('C' . $rowNum, htmlspecialchars(machine_name($submachine['workmachine'])));
            $sheet->setCellValue('D' . $rowNum, $submachine_total);
            $sheet->getStyle("B{$rowNum}:D{$rowNum}")->applyFromArray([


                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                    'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                    'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,  // İnce çizgi
                        'color' => ['argb' => 'FF000000'],     // Siyah renk
                    ],
                ],
            ]);
            $rowNum++;
        }

        $sheet->mergeCells("B{$rowNum}:C{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", 'Toplam');
        $sheet->setCellValue("D{$rowNum}", $total_submachine_total);

        $sheet->getStyle("B{$rowNum}:D{$rowNum}")->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Dolu arka plan
                'startColor' => [
                    'argb' => 'FFEFEFEF', // Açık gri rengi
                ],
            ],
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,  // İnce çizgi
                    'color' => ['argb' => 'FF000000'],     // Siyah renk
                ],
            ],
        ]);

        $rowNum++;
        $rowNum++;


        // Aktif, pasif ve tüm personel listelerini alalım
        $active_personel_counts = $this->Workman_model->get_all(array("site_id" => $site->id, "isActive" => 1));
        $passive_personel_counts = $this->Workman_model->get_all(array("site_id" => $site->id, "isActive" => 0));
        $all_personel_counts = $this->Workman_model->get_all(array("site_id" => $site->id));

        // Grup sayımı için boş dizi başlatalım
        $group_counts = [];

        // Aktif personelleri grup sayısına göre sayalım
        foreach ($active_personel_counts as $personel) {
            $group = $personel->group;

            // Eğer grup daha önce sayılmadıysa, yeni bir giriş başlat
            if (!isset($group_counts[$group])) {
                $group_counts[$group] = 0;
            }

            // İlgili grubu bir artır
            $group_counts[$group]++;
        }

        $active_group_row = 8;
        $passive_group_row = 8;
        $all_group_row = 8;

        $sheet->mergeCells("F{$active_group_row}:G{$active_group_row}");
        $sheet->setCellValue('F' . $active_group_row, "Çalışan Personel");

        $sheet->getStyle("F{$active_group_row}:G{$active_group_row}")
            ->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Dolu arka plan
                    'startColor' => [
                        'argb' => 'FFD9D9D9', // Açık gri rengi
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                    'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                    'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
                ],
                'font' => ['bold' => true], // Kalın yazı
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Siyah kenarlık
                    ],
                ],
            ]);

// Grup sayımlarını ekleme ve kenarlık/kalın yazı ayarlama
        foreach ($group_counts as $group => $count) {
            $active_group_row++;
            $sheet->setCellValue('F' . $active_group_row, group_name($group));
            $sheet->setCellValue('G' . $active_group_row, $count);

            // group_name ve count hücrelerine kalın yazı ve kenarlık ekleme
            $sheet->getStyle("F{$active_group_row}:G{$active_group_row}")
                ->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                        'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                        'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
                    ],
                    'font' => ['bold' => true], // Kalın yazı
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
        }


        $active_group_row++;
        $sheet->setCellValue('F' . $active_group_row, "Toplam");
        $sheet->setCellValue('G' . $active_group_row, array_sum($group_counts)); // Toplam pasif personel sayısı

        $sheet->getStyle("F{$active_group_row}:G{$active_group_row}")
            ->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Dolu arka plan
                    'startColor' => [
                        'argb' => 'FFEFEFEF', // Açık gri rengi
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                    'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                    'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
                ],
                'font' => ['bold' => true], // Kalın yazı
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Siyah kenarlık
                    ],
                ],
            ]);


// Pasif personel sayımlarını hesaplama
        $passive_group_counts = [];
        foreach ($passive_personel_counts as $personel) {
            $group = $personel->group;
            if (!isset($passive_group_counts[$group])) {
                $passive_group_counts[$group] = 0;
            }
            $passive_group_counts[$group]++;
        }

// Pasif personel başlığı ekleme ve biçimlendirme
        $sheet->mergeCells("I{$passive_group_row}:J{$passive_group_row}");  // B-F sütunları birleştirildi

        $sheet->setCellValue('I' . $passive_group_row, "Çalışmayan Personel");
        $sheet->getStyle("I{$passive_group_row}:J{$all_group_row}")
            ->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Dolu arka plan
                    'startColor' => [
                        'argb' => 'FFD9D9D9', // Açık gri rengi
                    ],
                ],
                'font' => ['bold' => true], // Kalın yazı
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Siyah kenarlık
                    ],
                ],
            ]);

// Pasif grupların listesi ve biçimlendirme
        foreach ($passive_group_counts as $group => $count) {
            $passive_group_row++;
            $sheet->setCellValue('I' . $passive_group_row, group_name($group));
            $sheet->setCellValue('J' . $passive_group_row, $count);

            // Kenarlık ve kalın yazı uygulama
            $sheet->getStyle("I{$passive_group_row}:J{$passive_group_row}")
                ->applyFromArray([
                    'font' => ['bold' => true], // Kalın yazı
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                        'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                        'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
        }

        $passive_group_row++;
        $sheet->setCellValue('I' . $passive_group_row, "Toplam");
        $sheet->setCellValue('J' . $passive_group_row, array_sum($passive_group_counts)); // Toplam pasif personel sayısı

        $sheet->getStyle("I{$passive_group_row}:J{$passive_group_row}")
            ->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Dolu arka plan
                    'startColor' => [
                        'argb' => 'FFEFEFEF', // Açık gri rengi
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                    'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                    'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
                ],
                'font' => ['bold' => true], // Kalın yazı
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Siyah kenarlık
                    ],
                ],
            ]);


        // Tüm personel sayımlarını hesaplama
        $all_group_counts = [];
        foreach ($all_personel_counts as $personel) {
            $group = $personel->group;
            if (!isset($all_group_counts[$group])) {
                $all_group_counts[$group] = 0;
            }
            $all_group_counts[$group]++;
        }

// "Tüm Personel" başlığını ekleme ve biçimlendirme
        $sheet->mergeCells("L{$all_group_row}:M{$all_group_row}");  // B-F sütunları birleştirildi

        $sheet->setCellValue('L' . $all_group_row, "Tüm Personel");
        $sheet->getStyle("L{$all_group_row}:M{$all_group_row}")
            ->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Dolu arka plan
                    'startColor' => [
                        'argb' => 'FFD9D9D9', // Açık gri rengi
                    ],
                ],
                'font' => ['bold' => true], // Kalın yazı
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Siyah kenarlık
                    ],
                ],
            ]);

// Tüm personel gruplarının sayımını ekleme ve biçimlendirme
        foreach ($all_group_counts as $group => $count) {
            $all_group_row++;
            $sheet->setCellValue('L' . $all_group_row, group_name($group));
            $sheet->setCellValue('M' . $all_group_row, $count);

            // Kenarlık ve kalın yazı uygulama
            $sheet->getStyle("L{$all_group_row}:M{$all_group_row}")
                ->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                        'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                        'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
                    ],
                    'font' => ['bold' => true], // Kalın yazı
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'], // Siyah kenarlık
                        ],
                    ],
                ]);
        }

        $all_group_row++;
        $sheet->setCellValue('L' . $all_group_row, "Toplam");
        $sheet->setCellValue('M' . $all_group_row, array_sum($all_group_counts)); // Tüm personelin toplamı

        $sheet->getStyle("L{$all_group_row}:M{$all_group_row}")
            ->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Dolu arka plan
                    'startColor' => [
                        'argb' => 'FFEFEFEF', // Açık gri rengi
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER, // Yatayda ortalar
                    'vertical' => Alignment::VERTICAL_CENTER,     // Dikeyde ortalar
                    'wrapText' => true,  // Metni kaydır (hücreye sığdırmak için)
                ],
                'font' => ['bold' => true], // Kalın yazı
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Siyah kenarlık
                    ],
                ],
            ]);


        $filename = "$site->santiye_ad" . "- Şantiye Çalışma Raporu.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function report_download_pdf($site_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        $this->load->model("Workman_model");
        $this->load->model("Report_model");
        $site = $this->Site_model->get(array("id" => $site_id));
        $contract = $this->Contract_model->get(array("id" => $site->contract_id));
        $all_workgroups = $this->Report_workgroup_model->get_unique_workgroups($site->id);
        $all_workmachines = $this->Report_workmachine_model->get_unique_workmachine($site->id);

        $this->load->library('pdf_creator');

        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın
        $pdf->SetPageOrientation('L');

        // PDF Bilgilerini ayarla
        $pdf->SetAuthor('Şirket İsmi');
        $pdf->SetTitle('Depo Stok Raporu');
        $pdf->SetSubject('Stok');
        $pdf->SetKeywords('stok, depo, envanter, rapor');

        // Margin ayarları
        $pdf->SetMargins(10, 3, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);

        // Sayfa ekle
        $pdf->AddPage();


        // Yazı tipi ayarla
        $pdf->SetFont('dejavusans', 'B', 12);

        // Başlık
        $pdf->Cell(0, 6, 'ÇALIŞMA ÖZETİ', 0, 1, 'C');

        // Sözleşme Bilgileri
        $pdf->SetFont('dejavusans', '', 8);
        $pdf->Cell(30, 6, 'Tarih: ' . dateFormat_dmy($contract->sozlesme_tarih), 0, 1);
        $pdf->Cell(30, 6, 'İşin Adı: ' . $site->santiye_ad, 0, 1);

        // Boşluk bırak
        $pdf->Ln(10);

        // Tablo başlıkları
        $pdf->SetFont('dejavusans', 'B', 8);
        $pdf->Cell(10, 7, '#', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Ekip', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Çalışma Gün', 1, 1, 'C');

        // Verileri ekle
        $pdf->SetFont('dejavusans', '', 8);

        // Çalışma Gruplarını ekle

        $i = 1;
        foreach ($all_workgroups as $subgroup) {
            $group_total = sum_anything_and("report_workgroup", "number", "site_id", $site->id, "workgroup", $subgroup['workgroup']);
            $pdf->Cell(10, 7, $i++, 1, "", 'C');
            $pdf->Cell(40, 7, htmlspecialchars(group_name($subgroup['workgroup'])), 1);
            $pdf->Cell(30, 7, $group_total, 1, 1, "C");
        }
        $total_group_total = 0;
        foreach ($all_workgroups as $subgroup) {
            $group_total = sum_anything_and("report_workgroup", "number", "site_id", $site->id, "workgroup", $subgroup['workgroup']);
            $total_group_total += $group_total;
        }
        $pdf->SetFont('dejavusans', 'B', 8);

        $pdf->Cell(50, 7, "Toplam", 1);
        $pdf->Cell(30, 7, $total_group_total, 1, 1, "C");

        // Boşluk bırak
        $pdf->Ln(10);

        // Tablo başlıkları
        $pdf->Cell(10, 7, '#', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Makine', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Çalışma Gün', 1, 1, 'C');

        // Verileri ekle
        $pdf->SetFont('dejavusans', '', 8);

        // Çalışma Gruplarını ekle

        $i = 1;
        $total_submachine_total = 0;

        foreach ($all_workmachines as $submachine) {
            $submachine_total = sum_anything_and("report_workmachine", "number", "site_id", $site->id, "workmachine", $submachine['workmachine']);
            $total_group_total += $group_total;
            $total_submachine_total += $submachine_total;
            $pdf->Cell(10, 7, $i++, 1, "", 'C');
            $pdf->Cell(40, 7, htmlspecialchars(machine_name($submachine['workmachine'])), 1);
            $pdf->Cell(30, 7, $submachine_total, 1, 1, "C");
        }

        $pdf->SetFont('dejavusans', 'B', 8);

        $pdf->Cell(50, 7, "Toplam", 1);
        $pdf->Cell(30, 7, $total_submachine_total, 1, 1, "C");

        $active_personel_counts = $this->Workman_model->get_all(array("site_id" => $site->id, "isActive" => 1));
        $passive_personel_counts = $this->Workman_model->get_all(array("site_id" => $site->id, "isActive" => 0));
        $all_personel_counts = $this->Workman_model->get_all(array("site_id" => $site->id));


        // Grup sayımı için boş dizi başlatalım
        $group_counts = [];

        // Aktif personelleri grup sayısına göre sayalım
        foreach ($active_personel_counts as $personel) {
            $group = $personel->group;

            // Eğer grup daha önce sayılmadıysa, yeni bir giriş başlat
            if (!isset($group_counts[$group])) {
                $group_counts[$group] = 0;
            }

            // İlgili grubu bir artır
            $group_counts[$group]++;
        }

        $pdf->SetXY(95, 68);
        $pdf->Cell(60, 7, "Çalışan Personel", 1);

        $i = 1; // Sayaç başlangıcı
        $pdf->Ln(); // İlk satırdan sonra alt satıra geç
        $pdf->SetFont('dejavusans', 'N', 8);

        foreach ($group_counts as $group => $count) {

            $pdf->SetX(95); // X pozisyonunu korumak için
            $pdf->Cell(10, 7, $i++, 1, "", 'C');
            $pdf->Cell(40, 7, group_name($group), 1);
            $pdf->Cell(10, 7, $count, 1, "", "C");
            $pdf->Ln(); // İlk satırdan sonra alt satıra geç
        }

        $pdf->SetFont('dejavusans', 'B', 8);


        $pdf->SetX(95); // X pozisyonunu korumak için
        $pdf->Cell(50, 7, "Toplam", 1);
        $pdf->Cell(10, 7, array_sum($group_counts), 1);
        $pdf->Ln(); // İlk satırdan sonra alt satıra geç


        $pdf->SetXY(160, 68);
        $pdf->Cell(60, 7, "Çalışmayan Personel", 1);
        $pdf->Ln(); // İlk satırdan sonra alt satıra geç

        $passive_group_counts = [];
        foreach ($passive_personel_counts as $personel) {
            $group = $personel->group;
            if (!isset($passive_group_counts[$group])) {
                $passive_group_counts[$group] = 0;
            }
            $passive_group_counts[$group]++;
        }

        $pdf->SetFont('dejavusans', 'N', 8);

        $i = 1;
        foreach ($passive_group_counts as $group => $count) {
            $pdf->SetX(160); // X pozisyonunu korumak için
            $pdf->Cell(10, 7, $i++, 1, "", 'C');
            $pdf->Cell(40, 7, group_name($group), 1);
            $pdf->Cell(10, 7, $count, 1, "", "C");
            $pdf->Ln(); // İlk satırdan sonra alt satıra geç
        }

        $pdf->SetFont('dejavusans', 'B', 8);


        $pdf->SetX(160); // X pozisyonunu korumak için
        $pdf->Cell(50, 7, "Toplam", 1);
        $pdf->Cell(10, 7, array_sum($passive_group_counts), 1, "", "C");
        $pdf->Ln(); // İlk satırdan sonra alt satıra geç


        $pdf->SetXY(225, 68);
        $pdf->Cell(60, 7, "Çalışmayan Personel", 1);
        $pdf->Ln(); // İlk satırdan sonra alt satıra geç

        $all_group_counts = [];
        foreach ($all_personel_counts as $personel) {
            $group = $personel->group;
            if (!isset($all_group_counts[$group])) {
                $all_group_counts[$group] = 0;
            }
            $all_group_counts[$group]++;
        }

        $i = 1;

        $pdf->SetFont('dejavusans', 'N', 8);

        foreach ($all_group_counts as $group => $count) {
            $pdf->SetX(225); // X pozisyonunu korumak için
            $pdf->Cell(10, 7, $i++, 1, "", 'C');
            $pdf->Cell(40, 7, group_name($group), 1);
            $pdf->Cell(10, 7, $count, 1, "", "C");
            $pdf->Ln(); // İlk satırdan sonra alt satıra geç
        }

        $pdf->SetX(225); // X pozisyonunu korumak için
        $pdf->SetFont('dejavusans', 'B', 8);

        $pdf->Cell(50, 7, "Toplam", 1);
        $pdf->Cell(10, 7, array_sum($all_group_counts), 1, "", "C");
        $pdf->Ln(); // İlk satırdan sonra alt satıra geç


        // PDF dosyasını oluştur ve kullanıcıya gönder
        $pdf->Output($site->santiye_ad . '- Depo Stok Raporu.pdf', 'I');
    }

    public
    function puantaj_print($site_id, $month, $year)
    {
        $month = date($month);
        $year = date($year);
        $year_month = $year . "-" . $month;
        $month_name = ay_isimleri($month);

        $year_month = dateFormat('Y-m', $year_month);

        $this->load->model("Attendance_model");
        $this->load->model("Workman_model");
        $puantaj = $this->Attendance_model->get(array("site_id" => $site_id, "year_month" => "$year_month"));
        $site = $this->Site_model->get(array("id" => $site_id));

        if (isset($puantaj)) {
            $puantaj_data = json_decode($puantaj->puantaj, true);
        } else {
            $puantaj_data = null;
        }

        $this->load->library('pdf_creator');

        // Yeni bir TCPDF nesnesi oluşturun
        $pdf = new Pdf_creator(); // PdfCreator sınıfını doğru şekilde çağırın

        $pdf->SetPageOrientation('L');

        $pdf->headerSubText = "Şantiye Adı : $site->santiye_ad";

        $pdf->headerText = "$month_name $year Puantaj Tablosu";

        $pdf->SetPrintFooter(false);
        $pdf->AddPage();

        $personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1), "group DESC");

        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(7, 6, '#', 1);
        $pdf->Cell(40, 6, 'Adı Soyadı', 1);
        $pdf->Cell(30, 6, 'Ekip', 1);
        for ($j = 1; $j <= gun_sayisi(); $j++) {
            $pdf->Cell(6, 6, $j, 1, "", "C");
        }
        $pdf->Cell(16, 6, 'Toplam', 1);
        $pdf->Ln(); // Bir sonraki satıra geç

// Tablo verilerini oluştur
        $pdf->SetFont('dejavusans', '', 10);
        $i = 1;
        foreach ($personel_datas as $personel_data) {
            $pdf->Cell(7, 6, $i++, 1);
            $pdf->Cell(40, 6, $personel_data->name_surname, 1);
            $pdf->Cell(30, 6, group_name($personel_data->group), 1);

            for ($j = 1; $j <= gun_sayisi(); $j++) {
                $j_double_digit = str_pad($j, 2, "0", STR_PAD_LEFT);
                $isChecked = (isset($puantaj_data[$j_double_digit]) && in_array($personel_data->id, $puantaj_data[$j_double_digit])) ? 'X' : '';
                $pdf->Cell(6, 6, $isChecked, 1, "", "C");
            }

            $count_of_value = 0;
            if (isset($puantaj_data)) {
                $value_to_count = $personel_data->id;
                foreach ($puantaj_data as $sub_array) {
                    if (in_array($value_to_count, $sub_array)) {
                        $count_of_value += array_count_values($sub_array)[$value_to_count];
                    }
                }
            }
            $pdf->SetFont('dejavusans', 'B', 10);

            $pdf->Cell(16, 6, $count_of_value, 1);
            $pdf->SetFont('dejavusans', '', 10);


            $pdf->Ln(); // Bir sonraki satıra geç
        }


        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(77, 10, 'Toplam', 1, 0, 'C');
        for ($j = 1; $j <= gun_sayisi(); $j++) {
            $j_double_digit = str_pad($j, 2, "0", STR_PAD_LEFT);
            if (array_key_exists($j_double_digit, $puantaj_data)) {
                $pdf->Cell(6, 10, count($puantaj_data[$j_double_digit]), 1, 0, 'C');
            } else {
                $pdf->Cell(6, 10, '0', 1, 0, 'C');
            }
        }
        $total_keys = 0;
        foreach ($puantaj_data as $sub_array) {
            $total_keys += count($sub_array);
        }
        $pdf->Cell(16, 10, $total_keys, 1, 1, 'C'); // Yeni satıra geç

        // PDF'yi görüntüleme veya indirme
        $pdf->Output("$site->santiye_ad" . "-" . $month_name . " " . $year . ".pdf");

    }

    public function puantaj_print_excel($site_id, $month, $year)
    {
        $month = date($month);
        $year = date($year);
        $year_month = $year . "-" . $month;
        $month_name = ay_isimleri($month);

        $year_month = dateFormat('Y-m', $year_month);

        $last_day_of_month = date('t', strtotime("$year-$month-01"));
        $count_of_days = (int)$last_day_of_month;


        $this->load->model("Attendance_model");
        $this->load->model("Workman_model");
        $this->load->model("Site_model");
        $this->load->model("Contract_model");
        $puantaj = $this->Attendance_model->get(array("site_id" => $site_id, "year_month" => "$year_month"));
        $site = $this->Site_model->get(array("id" => $site_id));
        $contract = $this->Contract_model->get(array("id" => $site->contract_id));

        if (isset($puantaj)) {
            $puantaj_data = json_decode($puantaj->puantaj, true);
        } else {
            $puantaj_data = null;
        }

        $personel_datas = $this->Workman_model->get_all(array("site_id" => $site_id, "isActive" => 1), "group DESC");

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()
            ->setPaperSize(PageSetup::PAPERSIZE_A4)  // A4 boyutunda yapar
            ->setOrientation(PageSetup::ORIENTATION_DEFAULT);  // Dikey olarak ayarlar

        $sheet->getPageMargins()->setTop(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setLeft(0.3937); // 1 cm = 0.3937 inch
        $sheet->getPageMargins()->setRight(0);     // 0 cm

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->getStyle('A1:Z1000')->applyFromArray([
            'font' => [
                'size' => 12, // Yazı büyüklüğü 8 punto
            ],
        ]);

        // Logo dosyasının yolu
        $logoPath = realpath("assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR . "logo.png");

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is your logo');
        $drawing->setPath($logoPath); // Resim dosyasının yolu
        $drawing->setCoordinates('B1'); // Resmin yerleştirileceği hücre
        $drawing->setHeight(60); // Resmin yüksekliği (piksel)
        $drawing->setWorksheet($sheet);

        $sheet->getColumnDimension('A')->setWidth(3);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(13);
        for ($col = 4; $col <= 34; $col++) {
            $column = getExcelColumn($col);  // Kolon ismini alıyoruz (A, B, C, ..., AH)
            $sheet->getColumnDimension($column)->setWidth(3);
        }


        $rowNum = 2;
        $sheet->mergeCells("Z{$rowNum}:AH{$rowNum}");  // Z ile AH sütunları birleştirildi
        $sheet->setCellValue("Z{$rowNum}", "Tarih: " . date('d.m.Y'));

// Sağ hizalama ve kalın yazı stili eklemek
        $sheet->getStyle("Z{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,  // Yazıyı koyu yap
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,  // Sağ hizalama
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,    // Dikeyde ortala
            ],
        ]);


        $rowNum++;
        $rowNum++;


        $sheet->mergeCells("B{$rowNum}:AH{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "$year $month_name Puantaj Listesi");
        // Satır yüksekliğini ayarlayın (örneğin, varsayılan yüksekliğin 2 katı)
        $sheet->getRowDimension($rowNum)->setRowHeight(40); // Varsayılan 15 px olduğu varsayımıyla 30 px

// Hücre stilini uygulayın
        $sheet->getStyle("B{$rowNum}:D{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 16,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);


        $rowNum++;
        $rowNum++;

        $sheet->mergeCells("B{$rowNum}:M{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "Şantiye Adı : " . $site->santiye_ad);
        $sheet->getStyle("B{$rowNum}:M{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 12,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $rowNum++;

        $sheet->mergeCells("B{$rowNum}:M{$rowNum}");  // B-F sütunları birleştirildi
        $sheet->setCellValue("B{$rowNum}", "Sözleşme Adı : " . $contract->contract_name);
        $sheet->getStyle("B{$rowNum}:M{$rowNum}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
                'size' => 12,         // Yazı büyüklüğü 12 punto
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Ortala (isteğe bağlı)
                'vertical' => Alignment::VERTICAL_CENTER,     // Ortala (isteğe bağlı)
            ],
        ]);
        $rowNum++;
        $rowNum++;

// Başlangıç kolonu 'D'
        $columnIndex = 4;

// Excel kolon isimlerini hesaplayan fonksiyon


        $row = $rowNum++;

        $sheet->setCellValue("A9", "#");  // Hücreye sayıyı yazıyoruz
        $sheet->setCellValue("B9", "Ad Soyad");  // Hücreye sayıyı yazıyoruz
        $sheet->setCellValue("C9", "Meslek");  // Hücreye sayıyı yazıyoruz


// $count_of_days kadar döngü oluşturuyoruz
        for ($i = 1; $i <= $count_of_days; $i++) {
            // Excel kolon ismini alıyoruz
            $column = getExcelColumn($columnIndex);  // Kolon ismini hesaplıyoruz

            // Hücreyi oluşturuyoruz
            $cell = $column . $row;  // Hücre ismini oluşturuyoruz (örneğin: D3, E3, F3, ...)

            // Hücreye değeri set ediyoruz
            $sheet->setCellValue($cell, $i);  // Hücreye sayıyı yazıyoruz

            $columnIndex++;  // Bir sonraki kolona geçiyoruz
        }

// Son sütundan bir sonraki kolona "TOPLAM" yazdırıyoruz
        $lastColumn = getExcelColumn($columnIndex);  // Son kolonun ismini alıyoruz
        $sheet->setCellValue($lastColumn . $row, "TOPLAM");  // "TOPLAM" yazıyoruz

// Personel verilerini ekle
        $row = $rowNum++; // Başlık sonrası başlar
        $t = 1;
        $totalZ = 0;  // Toplam sayacı başlatıyoruz

        foreach ($personel_datas as $personel_data) {
            $sheet->setCellValue('A' . $row, $t++);
            $sheet->setCellValue('B' . $row, $personel_data->name_surname);
            $sheet->setCellValue('C' . $row, group_name($personel_data->group));

            $columnIndex_A = 4;
            $z = 0;  // Personel başına sayacı sıfırlıyoruz

            for ($i = 1; $i <= $count_of_days; $i++) {
                // Excel kolon ismini alıyoruz
                $column = getExcelColumn($columnIndex_A);  // Kolon ismini hesaplıyoruz

                // Hücreyi oluşturuyoruz
                $cell = $column . $row;  // Hücre ismini oluşturuyoruz (örneğin: D3, E3, F3, ...)

                $j_double_digit = str_pad($i, 2, "0", STR_PAD_LEFT);

                if (isset($puantaj_data[$j_double_digit]) && in_array($personel_data->id, $puantaj_data[$j_double_digit])) {
                    $isChecked = 'X';
                    $z++;  // Personel ID'si varsa $z sayacını 1 artırıyoruz
                } else {
                    $isChecked = '';
                }

                // Hücreye sayıyı yazıyoruz
                $sheet->setCellValue($cell, $isChecked);

                // Hücre içeriğini ortalıyoruz
                $sheet->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // Kolon index'ini artırıyoruz
                $columnIndex_A++;  // Bir sonraki kolona geçiyoruz
            }

            // Son satırda toplam "X" sayısını yazıyoruz
            $column_total = getExcelColumn($columnIndex_A);  // Son kolonu buluyoruz
            $sheet->setCellValue($column_total . $row, $z);  // Son hücreye $z yazıyoruz

            // Toplam $z'yi global toplam değere ekliyoruz
            $totalZ += $z;

            $row++;  // Personel satırını artırıyoruz
        }

// Toplam sayıyı son sütuna yazıyoruz
        $lastColumn = getExcelColumn($columnIndex_A - 1);  // Son kolonu buluyoruz
        $previousColumn = getExcelColumn($columnIndex_A - 7);  // Son sütundan bir önceki sütunu alıyoruz

// Hücreleri birleştiriyoruz, "TOPLAM" yazısını bir önceki sütuna yerleştiriyoruz
        $mergeRange = "D{$row}:{$lastColumn}{$row}";  // Birleştirilecek hücre aralığı
        $sheet->mergeCells($mergeRange);  // Hücreleri birleştiriyoruz

// "TOPLAM" yazısını birleştirilen hücreye yazıyoruz
        $sheet->setCellValue("D{$row}", "TOPLAM");

// Stil uygulaması
        $sheet->getStyle("D{$row}")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT, // Sağda hizalama
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,     // Ortada dikey hizalama
            ],
        ]);

// Son olarak, toplam "X" sayısını yazıyoruz
        $total_column = getExcelColumn($columnIndex_A);
        $sheet->setCellValue($total_column . $row, $totalZ);  // Toplam sayıyı yazıyoruz

        $sheet->getStyle('A9:AI1000')->applyFromArray([
            'font' => [
                'name' => 'Calibri',    // Font olarak Calibri
                'size' => 12,           // Font boyutu 12 punto
            ]
        ]);

        // İnce çizgiler eklemek için
        $sheet->getStyle('A9:' . $total_column . $row)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // İnce çizgi
                    'color' => ['argb' => '000000'], // Siyah renk
                ],
            ],
        ]);

// $total_column . $row etrafına kalın çerçeve eklemek için
        $sheet->getStyle($total_column . $row)->applyFromArray([
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, // Kalın üst kenar
                    'color' => ['argb' => '000000'], // Siyah renk
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, // Kalın sağ kenar
                    'color' => ['argb' => '000000'], // Siyah renk
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, // Kalın alt kenar
                    'color' => ['argb' => '000000'], // Siyah renk
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, // Kalın sol kenar
                    'color' => ['argb' => '000000'], // Siyah renk
                ],
            ],
        ]);

        $sheet->getStyle("A9:AI9")->applyFromArray([
            'font' => [
                'bold' => true,       // Yazıyı koyu yap
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Ortada yatay hizalama
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,   // Ortada dikey hizalama
            ],
        ]);

        $filename = "Puantaj Raporu.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

}





