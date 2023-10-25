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
        $this->SetMargins(10, 50, 10);
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

        if ($this->module == "green") {
            $table_header_1 = array(
                "Sıra No" => array(15, 10, 1, "C", 1),
                "Poz No" => array(25, 10, 1, "C", 1),
                " Yapılan İşin Cinsi" => array(140, 10, 1, "L", 1),
                "Birimi" => array(16, 10, 1, "C", 1),
                "Hakediş Miktarları" => array(84, 5, 1, "C", 1),
            );
            $this->SetFillColor(192, 192, 192);
            $this->SetDrawColor(0, 0, 0); // Çizgi rengi (Siyah: RGB 0,0,0)
            foreach ($table_header_1 as $header => $properties) {
                $this->SetLineWidth(0.2); // Çizgi kalınlığını 0.2 mm olarak ayarlayın (varsayılan değer 0.2'dir)

                $this->SetFont('dejavusans', 'B', 9);
                $this->Cell($properties[0], $properties[1], $header, $properties[2], 0, $properties[3], $properties[4]);

                if ($header == "Hakediş Miktarları") {
                    $this->Ln();

                    $this->Cell(196, 5, "", 0, 0, "C", 0);
                    $this->Cell(28, 5, "Toplam", 1, 0, "C", 1);
                    $this->Cell(28, 5, "Önceki Hak.", 1, 0, "C", 1);
                    $this->Cell(28, 5, "Bu Hak.", 1, 1, "C", 1);
                }
            }
        }
    }
}
