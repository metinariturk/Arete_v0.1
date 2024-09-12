<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

use PhpOffice\PhpSpreadsheet\Style\Alignment;

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
        $this->load->model("Project_model");
        $this->load->model("Settings_model");
        $this->load->model("Site_model");
        $this->load->model("User_model");

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


    function print_report($contract_id, $P_or_D = null)
    {
        $contract = $this->Contract_model->get(array("id" => $contract_id));
        $extimes = $this->Extime_model->get_all(array("contract_id" => $contract_id));
        $costincs = $this->Costinc_model->get_all(array("contract_id" => $contract_id));
        $payments = $this->Payment_model->get_all(array("contract_id" => $contract_id));
        $advances = $this->Advance_model->get_all(array("contract_id" => $contract_id));
        $bonds = $this->Bond_model->get_all(array("contract_id" => $contract_id));
        $collections = $this->Collection_model->get_all(array("contract_id" => $contract_id), "tahsilat_tarih ASC");

        $viewData = new stdClass();

        $viewData->contract = $contract;

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

        $viewData->contractor = $contractor;
        $viewData->owner = $owner;

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
        $pdf->Cell(170, 7, mb_strtoupper($contract->contract_name), 0, 0, "C", 0);
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
        $pdf->Cell(8, 5, "∑", 1, 0, "C", 0);
        $pdf->Cell(28, 5, money_format($total_payment_A) . " " . $contract->para_birimi, 1, 0, "R",);
        $pdf->Cell(25, 5, money_format($total_payment_B) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 5, money_format($total_payment_G) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 5, money_format($total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 5, money_format($total_payment_H - $total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(25, 5, money_format($total_payment_I) . " " . $contract->para_birimi, 1, 0, "R", 0);
        $pdf->Cell(29, 5, money_format($total_payment_balance) . " " . $contract->para_birimi, 1, 0, "R", 0);
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

        $pdf->SetX(25); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        if (!empty($advances)) {
            $pdf->Cell(40, 6, 'AVANS DURUMU', 0, 0, "C", 0);
        }
        $pdf->Cell(9, 6, "", 0, 0, "C", 0);

        if (!empty($bonds)) {
            $pdf->Cell(111, 6, 'TEMİNAT DURUMU', 0, 0, "C", 0);
        }
        $pdf->SetFont('dejavusans', 'B', 6);
        $pdf->Ln(); // Yeni satıra geç
        $bonds_start_y = $pdf->GetY();
        if (!empty($advances)) {
            $pdf->SetX(25);
            $pdf->Cell(5, 6, 'No', 1, 0, "C", 0);
            $pdf->Cell(15, 6, 'Avans Tarih', 1, 0, "C", 0);
            $pdf->Cell(20, 6, 'Avans Miktar', 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç

            $pdf->SetFont('dejavusans', 'N', 6);

            $i = 1;
            foreach ($advances as $advance) {
                $pdf->SetX(25);
                $pdf->Cell(5, 6, $i++, 1, 0, "C", 0);
                $pdf->Cell(15, 6, dateFormat_dmy($advance->avans_tarih), 1, 0, "C", 0);
                $pdf->Cell(20, 6, money_format($advance->avans_miktar) . " " . $contract->para_birimi, 1, 0, "R", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
            $pdf->SetX(25);
            $pdf->SetFont('dejavusans', 'B', 6);

            $pdf->Cell(20, 4, "TOPLAM", 1, 0, "L", 0);
            $pdf->Cell(20, 4, money_format($advance_given) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(25);

            $pdf->Cell(20, 4, "Mahsup Edilen", 1, 0, "L", 0);
            $pdf->Cell(20, 4, money_format($total_payment_I) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(25);

            $pdf->Cell(20, 4, "Kalan Avans", 1, 0, "L", 0);
            $pdf->Cell(20, 4, money_format($advance_given - $total_payment_I) . " " . $contract->para_birimi, 1, 0, "R", 0);
        }
        $last_advance_y = $pdf->GetY();


        if (!empty($bonds)) {
            $pdf->SetFont('dejavusans', 'B', 6);
            if (empty($advancesi)) {
                $pdf->SetXY(25, $bonds_start_y);
            } else {
                $pdf->SetXY(74, $bonds_start_y);
            }
            $pdf->Cell(5, 6, 'No', 1, 0, "C", 0);
            $pdf->Cell(18, 6, 'Tür', 1, 0, "C", 0);
            $pdf->Cell(12, 6, 'Gerekçe', 1, 0, "C", 0);
            $pdf->Cell(19, 6, 'Teminat Miktar', 1, 0, "C", 0);
            $pdf->Cell(19, 6, 'Veriliş Tarihi', 1, 0, "C", 0);
            $pdf->Cell(19, 6, 'Vade Tarih', 1, 0, "C", 0);
            $pdf->Cell(19, 6, 'İade Durumu', 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 6);

            $i = 1;
            foreach ($bonds as $bond) {
                if (empty($advancesi)) {
                    $pdf->SetX(25);
                } else {
                    $pdf->SetX(74);
                }
                $pdf->Cell(5, 6, $i++, 1, 0, "C", 0);
                $pdf->Cell(18, 6, $bond->teminat_turu, 1, 0, "C", 0);
                $pdf->Cell(12, 6, module_name($bond->teminat_gerekce), 1, 0, "C", 0);
                $pdf->Cell(19, 6, money_format($bond->teminat_miktar) . " " . $contract->para_birimi, 1, 0, "C", 0);
                $pdf->Cell(19, 6, dateFormat_dmy($bond->teslim_tarihi), 1, 0, "C", 0);
                $pdf->Cell(19, 6, dateFormat_dmy($bond->gecerlilik_tarihi), 1, 0, "C", 0);
                if ($bond->teminat_durumu == 1) {
                    $durum = "İade Edildi";
                } else {
                    $durum = "İşveren";
                }
                $pdf->Cell(19, 6, $durum, 1, 0, "C", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
        }

        $last_bond_y = $pdf->GetY();
        if ($last_bond_y > $last_advance_y) {
            $pdf->SetY($last_bond_y); // Yeni satıra geç
        } else {
            $pdf->SetY($last_advance_y); // Yeni satıra geç
        }

        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->SetX(25);
        if (!empty($collections)) {
            $pdf->Cell(160, 6, 'ÖDEME DURUMU', 0, 0, "C", 0);
        }
        $pdf->SetFont('dejavusans', 'B', 6);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->Cell(160, 4, '', 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $bonds_start_y = $pdf->GetY();
        if (!empty($collections)) {
            $pdf->SetX(25);
            $pdf->Cell(5, 6, 'No', 1, 0, "C", 0);
            $pdf->Cell(15, 6, 'Tarih', 1, 0, "C", 0);
            $pdf->Cell(25, 6, 'Miktar', 1, 0, "C", 0);
            $pdf->Cell(35, 6, 'Türü', 1, 0, "C", 0);
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
                $pdf->Cell(5, 6, $i++, 1, 0, "C", 0);
                $pdf->Cell(15, 6, dateFormat_dmy($collection->tahsilat_tarih), 1, 0, "C", 0);
                $pdf->Cell(25, 6, money_format($collection->tahsilat_miktar) . " " . $contract->para_birimi, 1, 0, "R", 0);
                $pdf->Cell(35, 6, $collection->tahsilat_turu . $notice_date, 1, 0, "C", 0);
                $pdf->Cell(90, 6, $collection->aciklama, 1, 0, "L", 0);
                $pdf->Cell(4, 6, "", 0, 0, "C", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
        }
        $pdf->Ln(); // Yeni satıra geç

        $last_collection_y = $pdf->GetY();

        $pdf->SetY($last_collection_y); // Yeni satıra geç

        if (!empty($collections)) {
            $pdf->SetX(25);
            $pdf->Cell(25, 6, "ALACAK", 1, 0, "C", 0);
            $pdf->Cell(25, 6, "TAHSİLAT", 1, 0, "C", 0);
            $pdf->Cell(25, 6, "TEMİNAT", 1, 0, "C", 0);
            $pdf->Cell(25, 6, "DİĞER KESİNTİ", 1, 0, "C", 0);
            $pdf->Cell(25, 6, "KALAN", 1, 0, "C", 0);

            $pdf->SetFont('dejavusans', 'N', 6);
            $pdf->Ln(); // Yeni satıra geç

            $pdf->SetX(25);
            $pdf->Cell(25, 6, money_format($total_payment_G) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 6, money_format($total_collections) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 6, money_format($total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 6, money_format($total_payment_H - $total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Cell(25, 6, money_format($total_payment_Kes_e + $total_payment_balance - $total_collections - $total_payment_Kes_e) . " " . $contract->para_birimi, 1, 0, "R", 0);
            $pdf->Ln(); // Yeni satıra geç
        }


        $file_name = contract_name($contract->id) . "-İlerlerme Raporu";

        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }

    public function group_download_excel($contract_id)
    {
        if (!isAdmin()) {
            redirect(base_url("error"));
        }

        // Model yükleme
        $this->load->model("Company_model");

        // Sözleşme ve ana grup bilgilerini al
        $contract = $this->Contract_model->get(array('id' => $contract_id));
        $main_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "main_group" => 1));

        // Excel şablonunu yükle
        $templatePath = 'uploads/Templates/Excel_Group_Template.xlsx';


        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();
        } catch (\Exception $e) {
            die('Şablon dosyası yüklenemedi: ' . $e->getMessage());
        }


        // Sözleşme bilgilerini başlık kısmına ekleyelim
        $sheet->setCellValue('B1', company_name($contract->isveren));
        $sheet->setCellValue('B2', $contract->contract_name);

// Başlangıç satır numarasını belirleyelim
        $currentRow = 3;

// Stil tanımlamaları
        $mainGroupStyle = [
            'font' => [
                'bold' => true,
                'size' => 12, // Büyük font boyutu
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF808080'] // Koyu gri arka plan
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
            ]
        ];

        $subGroupStyle = [
            'font' => [
                'italic' => true,
                'size' => 10, // Küçük font boyutu
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD3D3D3'] // Açık gri arka plan
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
            ]
        ];

        foreach ($main_groups as $main_group) {
            // Ana grup bilgilerini ekleyelim
            $sheet->setCellValue('A' . $currentRow, $main_group->id);
            $sheet->setCellValue('C' . $currentRow, $main_group->code);
            $sheet->setCellValue('D' . $currentRow, $main_group->name);

            // Ana grup için stil uygula
            $sheet->getStyle('A' . $currentRow . ':D' . $currentRow)->applyFromArray($mainGroupStyle);

            $currentRow += 1; // Ana grup bilgileri eklenince 1 satır aşağı iniyoruz

            // Alt grupları al
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1, "parent" => $main_group->id));

            if (!empty($sub_groups)) {
                foreach ($sub_groups as $sub_group) {
                    // Alt grup bilgilerini ekleyelim
                    $sheet->setCellValue('A' . $currentRow, $sub_group->id);
                    $sheet->setCellValue('C' . $currentRow, $main_group->code . "." . $sub_group->code);
                    $sheet->setCellValue('D' . $currentRow, $sub_group->name);

                    // Alt grup için stil uygula
                    $sheet->getStyle('A' . $currentRow . ':D' . $currentRow)->applyFromArray($subGroupStyle);

                    $currentRow += 1; // Her alt grup için 1 satır aşağı iniyoruz
                }
            } else {
                // Alt grup yoksa 3 satır boşluk bırak
                $currentRow += 3;
            }

            // Bir sonraki ana grup öncesi bir satır boşluk bırak
            $currentRow++;
        }

        // Dosyayı indirme işlemi
        $writer = new Xlsx($spreadsheet);
        $downloadFileName = "$contract->contract_name - Ödeme Raporu.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $downloadFileName . '"');
        header('Cache-Control: max-age=0');

        try {
            $writer->save('php://output');
        } catch (\Exception $e) {
            die('Dosya yazma hatası: ' . $e->getMessage());
        }
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
        $pdf = new Pdf_creator();
        $pdf->SetPageOrientation('P');
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();

        // Çerçeve boşlukları
        $topMargin = 20;  // 4 cm yukarıdan
        $bottomMargin = 20;  // 4 cm aşağıdan
        $rightMargin = 10;  // 2 cm sağdan
        $leftMargin = 10;  // 2 cm soldan

        // Çerçeve çizme
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.5);
        $pdf->Rect($leftMargin, $topMargin, $pdf->getPageWidth() - $rightMargin - $leftMargin, $pdf->getPageHeight() - $bottomMargin - $topMargin);

        $pdf->SetFont('dejavusans', 'B', 12);

        // İlk satır (şirket adı)
        $yPosition = $topMargin;
        $xPosition = $leftMargin;
        $pdf->SetXY($xPosition, $yPosition);
        $pdf->SetLineWidth(0.1);
        $pdf->Cell(190, 8, company_name($contract->isveren), 1, 0, "C", 0);
        $pdf->Ln();

        // Ana grup fontu
        $mainGroupFont = [
            'style' => 'B',
            'size' => 11,
            'fillColor' => [128, 128, 128],
        ];

        // Alt grup fontu
        $subGroupFont = [
            'style' => 'I',
            'size' => 9,
            'fillColor' => [211, 211, 211],
        ];

        // Ana grup ve alt gruplar için boşluk ayarları
        $mainGroupX = $leftMargin + 10; // Ana grup için 1 cm boşluk ekliyoruz
        $subGroupX = $mainGroupX + 10;  // Alt gruplar için 1 cm daha boşluk

        $pdf->SetLineWidth(0.1);
        $pdf->Cell(190, 6, $contract->contract_name, 1, 0, "C", 0);
        $pdf->Ln();
        $pdf->SetLineWidth(0.1);
        $pdf->Cell(190, 6, "İmalat Grupları", 1, 0, "C", 0);
        $pdf->Ln();

        // Ana grup ve alt grup yazdırma
        foreach ($main_groups as $main_group) {
            // Ana grup yazdırma
            $pdf->SetX($mainGroupX);  // 1 cm boşluk ekliyoruz
            $pdf->SetFont('dejavusans', $mainGroupFont['style'], $mainGroupFont['size']);
            $pdf->SetFillColorArray($mainGroupFont['fillColor']);
            $pdf->Cell(0, 6, $main_group->code . ' - ' . $main_group->name, 0, 1, 'L', 1);

            // Alt grupları yazdırma
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract_id, "sub_group" => 1, "parent" => $main_group->id));

            if (!empty($sub_groups)) {
                foreach ($sub_groups as $sub_group) {
                    $pdf->SetX($subGroupX);  // Alt grup için 1 cm daha sağa kaydırıyoruz
                    $pdf->SetFont('dejavusans', $subGroupFont['style'], $subGroupFont['size']);
                    $pdf->SetFillColorArray($subGroupFont['fillColor']);
                    $pdf->Cell(0, 6, $main_group->code . '.' . $sub_group->code . ' - ' . $sub_group->name, 0, 1, 'L', 1);
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

        // Excel şablonunu yükle
        $templatePath = 'uploads/Templates/Excel_Book_Template.xlsx';


        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();
        } catch (\Exception $e) {
            die('Şablon dosyası yüklenemedi: ' . $e->getMessage());
        }


        // Sözleşme bilgilerini başlık kısmına ekleyelim
        $sheet->setCellValue('B1', company_name($contract->isveren));
        $sheet->setCellValue('B2', $contract->contract_name);
        $sheet->setCellValue('F4', "Birim Fiyat (" . $contract->para_birimi . ")");

// Başlangıç satır numarasını belirleyelim
        $currentRow = 5;
        $i = 1;

        foreach ($leaders as $leader) {
            // Ana grup bilgilerini ekleyelim
            $sheet->setCellValue('B' . $currentRow, $i++);
            $sheet->setCellValueExplicit('C' . $currentRow, $leader->code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $currentRow, $leader->name);
            $sheet->setCellValue('E' . $currentRow, $leader->unit);
            $sheet->setCellValue('F' . $currentRow, $leader->price);

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
            $sheet->getStyle('B' . $currentRow . ':F' . $currentRow)->applyFromArray($styleArray);

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
            $sheet->getStyle('F' . $currentRow)->getNumberFormat()->setFormatCode($currencyFormat);

            // Satır numarasını artır
            $currentRow++;
        }


        // Dosyayı indirme işlemi
        $writer = new Xlsx($spreadsheet);
        $downloadFileName = "$contract->contract_name - Ödeme Raporu.xlsx";

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
        $pdf = new Pdf_creator();
        $pdf->SetPageOrientation('P');
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();

        // Çerçeve boşlukları
        $topMargin = 20;  // 4 cm yukarıdan
        $bottomMargin = 20;  // 4 cm aşağıdan
        $rightMargin = 10;  // 2 cm sağdan
        $leftMargin = 10;  // 2 cm soldan

        // Çerçeve çizme
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.5);
        $pdf->Rect($leftMargin, $topMargin, $pdf->getPageWidth() - $rightMargin - $leftMargin, $pdf->getPageHeight() - $bottomMargin - $topMargin);

        $pdf->SetFont('dejavusans', 'B', 8);

        $set_height = 6;
        // İlk satır (şirket adı)
        $yPosition = $topMargin;
        $xPosition = $leftMargin;
        $pdf->SetXY($xPosition, $yPosition);
        $pdf->SetLineWidth(0.1);
        $pdf->Cell(190, $set_height, company_name($contract->isveren), 1, 0, "C", 0);
        $pdf->Ln();
        $pdf->Cell(190, $set_height, $contract->contract_name, 1, 0, "C", 0);
        $pdf->Ln();
        $pdf->Cell(190, $set_height, "İmalat Poz Listesi", 1, 0, "C", 0);
        $pdf->Ln();

        $headers = ['No', 'Kod', 'Ad', 'Birim', 'Birim Fiyat'];
        $widths = [8, 17, 127, 15, 23]; // Sütun genişlikleri

// Tablo başlıklarını dejavusans
        $pdf->SetFont('dejavusans', 'B', 8);
        $pdf->SetFillColor(192, 192, 192);
        $pdf->Cell($widths[0], $set_height, $headers[0], 1, 0, 'C', 1);
        $pdf->Cell($widths[1], $set_height, $headers[1], 1, 0, 'C', 1);
        $pdf->Cell($widths[2], $set_height, $headers[2], 1, 0, 'C', 1);
        $pdf->Cell($widths[3], $set_height, $headers[3], 1, 0, 'C', 1);
        $pdf->Cell($widths[4], $set_height, $headers[4], 1, 1, 'C', 1);

// Verileri ekle
        $pdf->SetFont('dejavusans', '', 8);
        $i = 1;

        foreach ($leaders as $leader) {
            $pdf->Cell($widths[0], $set_height, $i++, 1, 0, 'C');
            $pdf->Cell($widths[1], $set_height, $leader->code, 1);
            $pdf->Cell($widths[2], $set_height, $leader->name, 1);
            $pdf->Cell($widths[3], $set_height, $leader->unit, 1, 0, 'C');
            $pdf->Cell($widths[4], $set_height, number_format($leader->price, 2), 1, 1, 'R');
        }

        // Ana grup ile alt gruplar arasında bir boşluk bırak
        $pdf->Ln();

        // PDF çıktısını ver
        $pdf->Output('İmalat Grubu Raporu.pdf', 'I');
    }

}




