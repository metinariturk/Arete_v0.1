<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'helpers/tcpdf/tcpdf.php';

class Pdf_creator extends TCPDF
{
    public $headerText = "";
    public $headerSubText = "";
    public $headerPaymentNo = "";
    public $signature = "";

    public function __construct()
    {
        parent::__construct();

        // Türkçe fontları yükle
    }

    public function Footer()
    {
        $this->SetFont('dejavusans', 'I', 8);
        $this->Cell("", 0, 'Sayfa ' . $this->getAliasNumPage(), 0, 0, 'C');
    }

    public function Header()
    {
        $this->SetFont('helvetica', 'B', 8);
        $this->SetMargins(10, 50, 10);
        // Logo
        $image_file = K_PATH_IMAGES . 'logo_example.jpg';
        $this->Image($image_file, 15, 10, 45, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->setFont('dejavusans', 'B', 16);
        // Birinci hücreyi ekleyin
        $this->Cell(0, 15, $this->headerText, 0, 1, 'C', 0, '', 0, false, '', '');
        $this->setFont('dejavusans', 'I', 11);
        $this->Cell(5); // 5 piksellik boşluk ekler
        $this->Cell(0, 15, $this->headerSubText, 0, 0, 'L', 0); // headerSubText sola hizalı
        $this->SetX(150); // X konumunu ayarlayarak headerPaymentNo metnini sağa kaydırın (örnek değer)
        $this->Cell(0, 15, $this->headerPaymentNo, 0, 1, 'R', 0); // headerPa
        // Düz çizgi eklemek için SetY ile alt satıra geçin
        $this->SetY(40); // Çizgiyi ekleyeceğiniz yükseklik (örneğin 30 piksel)






        // Çizgi rengini ve kalınlığını ayarlayın
        $this->SetLineWidth(0.5); // Çizgi kalınlığı
        $this->SetDrawColor(163, 163, 168); // Çizgi rengi (Siyah: RGB 0,0,0)
        // Çizgiyi çizin
        $this->Line(0, $this->GetY(), 300, $this->GetY()); // X koordinatları, Y koordinatı
    }

}
