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

    public function __construct()
    {
        parent::__construct();

        // Türkçe fontları yükle
    }

    public function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('dejavusans', 'I', 8);
        $this->SetFooterMargin(20);
        $tableWidth = $this->getPageWidth() - $this->getMargins()['left'] - $this->getMargins()['right'];
        $cellHeight = 10;
        $total_key = count(array_keys($this->custom_footer));
        $cellWidth = $tableWidth * (1 / $total_key);
        foreach ($this->custom_footer as $rowLabel => $key) {
            $this->Cell($cellWidth, $cellHeight, $rowLabel, 0, 0, 'C');
        }
        $this->Ln();
        $this->SetY($this->GetY() - $this->getFontSize()); // Hücrenin başlangıç yüksekliğini sıfıra ayarla

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
        $this->Cell(25, 10, 'Sayfa ' . $this->PageNo() . ' / ' . $this->getNumPages(), 0, 0, 'R', 0, '', 0, false, '', '');
        $this->Image($image_file, 10, 10, 45, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->setFont('dejavusans', 'B', 16);
        $this->Cell($paymnet_no_location, 15, $this->headerText, 0, 1, 'C', 0, '', 0, false, '', '');
        $this->setFont('dejavusans', 'I', 9);
        $this->Cell($paymnet_no_location, 15, $this->headerSubText, 0, 0, 'L', 0); // headerSubText sola hizalı
        $this->Cell(25, 15, $this->headerPaymentNo, 0, 1, 'R', 0); // headerPa

    }
}
