<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'helpers/tcpdf/tcpdf.php';

class Pdf_creator extends TCPDF {
    public function __construct() {
        parent::__construct();

        // Türkçe fontları yükle
        $this->SetFont('dejavusans', '', 14);

        // Diğer ayarlar
        $this->SetAutoPageBreak(true, 10);
    }

    public function Header(){
        $baslik = null;
        // Dinamik başlık içeriğini burada kullanabilirsiniz.
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 10, $baslik, 0, false, 'C', 0, '', 0, false, 'M', 'M');

    }

}
