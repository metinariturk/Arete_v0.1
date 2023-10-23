<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'helpers/tcpdf/tcpdf.php';

class Pdf_creator extends TCPDF
{
    public $headerText = '<ol><li>TCPDF Example Header >></li><li>TCPDF Example Header >></li></ol>';
    public $headerSubText = '<ol><li>TCPDF Example Header >></li><li>TCPDF Example Header >></li></ol>';
    public $headerPaymentNo = '<ol><li>TCPDF Example Header >></li><li>TCPDF Example Header >></li></ol>';
    public $signature = '<ol><li>TCPDF Example Header >></li><li>TCPDF Example Header >></li></ol>';

    public function __construct()
    {
        parent::__construct();

        // Türkçe fontları yükle
    }

    public function Footer()
    {
        // Tabloyu altbilgiye ekleyin
        // Footer'ın yüksekliğini belirleyin (örneğin, 50 mm = 5 cm)
        $footerHeight = 60; // 50 mm olarak ayarlandı

// Sayfanın altından 50 mm yukarıda başlayın
        $this->SetY(-$footerHeight);

// Tabloyu altbilgiye ekleyin
        $html = '<table border="0" align="center" width="100%">
                <tr>
                    <td>YÜKLENİCİ</td>
                    <td colspan="3">KONTROL</td>
                </tr>
            </table>';
        $this->writeHTML($html);

// Sayfa numarasını ekleyin
        $this->SetFont('dejavusans', 'I', 8);
        $this->Cell(0, 0, 'Sayfa ' . $this->getAliasNumPage(), 0, 0, 'C');

    }

    public function Header()
    {
        if ($this->CurOrientation == "L") {
            // Header içeriği ve stilini özelleştirin
            $this->SetFont('helvetica', 'B', 8);
            $this->Cell(0, 10, 'Header', 0, 1, 'C');
            } else {
            $this->SetMargins(10, 50, 10);

            // Logo
            $image_file = K_PATH_IMAGES . 'logo_example.jpg';
            $this->Image($image_file, 20, 10, 45, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
            $this->SetLineWidth(0.1); // Çizgi kalınlığı
            $this->SetDrawColor(0, 0, 0); // Çizgi rengi (Siyah: RGB 0,0,0)

            // Çizgiyi çizin
            $this->Line(0, $this->GetY(), 210, $this->GetY()); // X koordinatları, Y koordinatı
        }

    }

}
