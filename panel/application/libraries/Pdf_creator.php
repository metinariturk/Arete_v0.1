<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'helpers/tcpdf/tcpdf.php';

class Pdf_creator extends TCPDF
{
    public $headerText = "";
    public $headerSubText = "";
    public $headerPaymentNo = "";
    public $signature = "";
    public $custom_footer = "";
    public $module = "";
    private $progress = 0; // İlerleme yüzdesi

    public function __construct()
    {
        parent::__construct();

        // Türkçe fontları yükle
    }

    public function Footer()
    {
        $orientation = $this->CurOrientation;
        if ($orientation === 'L') {
            $this->SetAutoPageBreak(true, 1); // Son 3 cm'yi kullanmak için alt kenar boşluğunu 30 mm olarak ayarla
            $this->SetY(180);
        }
        else {
            $this->SetAutoPageBreak(true, 1); // Son 3 cm'yi kullanmak için alt kenar boşluğunu 30 mm olarak ayarla
            $this->SetY(270);
        }

        $this->SetFont('dejavusans', 'I', 8);
        $tableWidth = $this->getPageWidth() - $this->getMargins()['left'] - $this->getMargins()['right'];
        $cellHeight = 10;
        $total_key = count(array_keys($this->custom_footer));
        if ($total_key == 0){
            $total_key = 1;
        }
        $cellWidth = $tableWidth * (1 / $total_key);
        foreach ($this->custom_footer as $rowLabel => $key) {
            $this->Cell($cellWidth, $cellHeight, $rowLabel, 0, 0, 'C');
        }
        $this->Ln();

        foreach ($this->custom_footer as $rowLabel => $key) {
            $this->Cell($cellWidth, $cellHeight, $key, 0, 0, 'C');
        }

    }



    public function Header()
    {
        $this->SetFont('dejavusans', '', 9);
        $this->SetMargins(10, 40, 10);
        $page_number_location = $this->getPageWidth() - 32;
        $paymnet_no_location = $this->getPageWidth() - 42;
        $image_file = K_PATH_IMAGES . 'logo_example.jpg';
        $this->SetY(20); // Sayfa numarasını sayfanın en üstüne eklemek için yüksekliği ayarlayın
        $this->SetX($page_number_location); // Sayfa numarasını sayfanın en üstüne eklemek için yüksekliği ayarlayın
        $this->Cell(25, 10, 'Sayfa : ' . $this->PageNo(), 0, 0, 'R', 0, '', 0, false, '', '');
        $this->Image($image_file, 10, 10, 45, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->setFont('dejavusans', 'B', 16);
        $this->Cell($paymnet_no_location, 15, $this->headerText, 0, 1, 'C', 0, '', 0, false, '', '');
        $this->setFont('dejavusans', 'I', 9);
        $this->Cell($paymnet_no_location, 15, $this->headerSubText, 0, 0, 'L', 0); // headerSubText sola hizalı
        $this->Cell(25, 15, $this->headerPaymentNo, 0, 1, 'R', 0); // headerPa

    }


    public function progress_bar($percentage,$bar_height,$bar_width,$start_y,$start_x,$last_x){
        if ($percentage > 100){
            $percentage = 100;
        }
        $complete_width = round($percentage) * $bar_width / 100;
        $remain_width = $bar_width*(100 - $percentage)/100;
        $remain_start_x = $start_x + (($last_x - $start_x)/100 * $percentage);

        $this->SetFillColor(0, 128, 0); // Yeşil renk
        $this->Rect($start_x, $start_y, $complete_width, $bar_height, 'F');

        $this->Ln(); // Yeni satıra geç

        // İlerleme çubuğunu doldur
        $this->SetFillColor(150, 150, 150); // Gri renk
        $this->Rect($remain_start_x, $start_y, $remain_width, $bar_height, 'F');
        $this->SetXY($remain_start_x-12,$start_y);
        $this->Cell(1, $bar_height, "% ".round($percentage) , 0, 0, "L", 0);
        $this->SetX($last_x);

    }

    // PDF sayfa içeriğini oluşturmak için metod

}
