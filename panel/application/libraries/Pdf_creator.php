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

    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo_example.jpg';
        $this->Image($image_file, 20, 10, 45, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->setFont('helvetica', 'B', 20);

            // Title using the $header parameter
            $this->Cell(0, 15, "", 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // Title
    }

}
