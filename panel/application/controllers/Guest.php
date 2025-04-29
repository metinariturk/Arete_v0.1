<?php
class Guest extends MY_Controller
{
    public $viewFolder = "";
    public $moduleFolder = "";
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Settings_model");
        $this->load->model("Project_model");
        $this->load->model("Payment_model");
        $this->load->model("Contract_model");
        $this->load->model("User_model");
        $this->load->model("Site_model");
        $this->load->model("Report_model");
        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->viewFolder = "guest_v";
        $this->Module_Name = "guest";
        $this->Module_Title = "Misafir";
        $this->Module_Main_Dir = "project_v";
        $this->Module_File_Dir = "main";
        $this->Display_Folder = "display";
        $this->Update_route = "update_form";
        $this->Upload_Folder = "uploads";
        
        $this->List_Folder = "list";
        $this->Common_Files = "common";
        $this->Settings = get_settings();
        $this->display_route = "file_form";
    }
    public function index()
    {
        redirect(base_url("login"));
    }
    public function file_form($guest_code=null)
    {
        if ($guest_code == null ){
            redirect(base_url("Errors"));
        }
        $viewData = new stdClass();
        $sites = $this->Site_model->get_all(array("guest_code" => $guest_code));
        if (empty($sites)){
            redirect(base_url("Errors"));
        }
        
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->sites = $sites;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    function print_report($report_id, $print_pic = null, $P_or_D = null)
    {
        $this->load->model("Company_model");
        $this->load->model("Report_weather_model");
        $this->load->model("Report_workgroup_model");
        $this->load->model("Report_workmachine_model");
        $this->load->model("Report_supply_model");
        $this->load->model("Report_sign_model");
        $report = $this->Report_model->get(array("id" => $report_id));
        $site = $this->Site_model->get(array("id" => $report->site_id));
        $contractor_sign = $this->Report_sign_model->get(array("site_id" => $site->id, "module" => "contractor_sign"));
        $contractor_staff = $this->Report_sign_model->get_all(array("site_id" => $site->id, "module" => "contractor_staff"));
        $owner_sign = $this->Report_sign_model->get(array("site_id" => $site->id, "module" => "owner_sign"));
        $owner_staff = $this->Report_sign_model->get_all(array("site_id" => $site->id, "module" => "owner_staff"));
        $workgroups = $this->Report_workgroup_model->get_all(array("report_id" => $report_id));
        $workmachines = $this->Report_workmachine_model->get_all(array("report_id" => $report_id));
        $supplies = $this->Report_supply_model->get_all(array("report_id" => $report_id));
        $viewData = new stdClass();
        $weather = $this->Report_weather_model->get(array("date" => $report->report_date));
        $contract = $this->Contract_model->get(array("id" => $report->contract_id));
        $project = $this->Project_model->get(array("id" => $report->project_id));
        $viewData->contract = $contract;
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
        $logoPath = K_PATH_IMAGES . 'logo_example.jpg';
        $logoWidth = 50; // Logo genişliği
        $pdf->Image($logoPath, 20, 10, $logoWidth);
        $pdf->SetFont('dejavusans', 'B', 8);
        $pdf->SetXY(150, 30);
        $pdf->Cell(50, 6, "Rapor Tarihi : " . dateFormat_dmy($report->report_date), 0, 0, "R", 0);
// Çerçeve için boşlukları belirleme
        $topMargin = 30;  // 4 cm yukarıdan
        $bottomMargin = 10;  // 4 cm aşağıdan
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
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(190, 10, 'GÜNLÜK RAPOR', 0, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'N', 9);
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(30, 5, "Proje Adı", 0, 0, "L", 0);
        $pdf->Cell(80, 5, mb_strtoupper($project->project_name), 0, 0, "L", 0);
        $pdf->Cell(50, 5, "", 0, 0, "L", 0);
        if (isset($weather)) {
            $pdf->Cell(30, 5, "En Yüksek : $weather->max °C", 0, 0, "R", 0);
        }
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(30, 5, "Sözleşme Adı", 0, 0, "L", 0);
        $pdf->Cell(80, 5, mb_strtoupper($contract->contract_name), 0, 0, "L", 0);
        $pdf->Cell(50, 5, "", 0, 0, "L", 0);
        if (isset($weather)) {
            $pdf->Cell(30, 5, "En Düşük : $weather->min °C", 0, 0, "R", 0);
        }
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(30, 5, "İşveren", 0, 0, "L", 0);
        $pdf->Cell(80, 5, $owner->company_name, 0, 0, "L", 0);
        $pdf->Cell(50, 5, "", 0, 0, "L", 0);
        if (isset($weather)) {
            $pdf->Cell(30, 5, "$weather->event", 0, 0, "R", 0);
        }
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFont('dejavusans', 'B', 7);
        if ($report->off_days == 1) {
            $stuation = "Çalışılabilir";
        } else {
            $stuation = "Çalışılamaz";
        }
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetFillColor(160, 160, 160);
        $table_y = $pdf->getY();
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(95, 5, "İşveren Teknik Personeller", 1, 0, "C", 1);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(55, 5, "Unvanı", 1, 0, "C", 0);
        $pdf->Cell(40, 5, "Ad Soyad", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        foreach ($owner_staff as $staff) {
            $pdf->Cell(55, 5, $staff->position, 1, 0, "C", 0);
            $pdf->Cell(40, 5, $staff->name, 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }
        $table_end_owner = $pdf->getY();
        $pdf->SetXY(105, $table_y);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(95, 5, "Yüklenici/Taşeron Teknik Personeller", 1, 0, "C", 1);
        $pdf->Ln(); // Yeni satıra geç
        $pdf->SetX(105);
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(55, 5, "Unvanı", 1, 0, "C", 0);
        $pdf->Cell(40, 5, "Ad Soyad", 1, 0, "C", 0);
        $pdf->Ln(); // Yeni satıra geç
        foreach ($contractor_staff as $staff) {
            $pdf->SetX(105);
            $pdf->Cell(55, 5, $staff->position, 1, 0, "C", 0);
            $pdf->Cell(40, 5, $staff->name, 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }
        $table_end_contract = $pdf->getY();
        $pdf->SetFont('dejavusans', 'N', 7);
        if ($table_end_owner > $table_end_contract) {
            $pdf->SetY($table_end_owner);
        } else {
            $pdf->SetY($table_end_contract);
        }
        $pdf->Ln(); // Yeni satıra geç
        if (!empty($workgroups)) {
            $pdf->SetX(10);
            $pdf->SetFillColor(160, 160, 160);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "Çalışan Ekipler", 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(30, 5, "Ekip Adı", 1, 0, "C", 0);
            $pdf->Cell(15, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(35, 5, "Çalıştığı Mahal", 1, 0, "C", 0);
            $pdf->Cell(110, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);
            foreach ($workgroups as $workgroup) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);
                $pdf->Cell(30, 5, group_name($workgroup->workgroup), 1, 0, "L", 0);
                $pdf->Cell(15, 5, $workgroup->number, 1, 0, "C", 0);
                $pdf->Cell(35, 5, yazim_duzen($workgroup->place), 1, 0, "L", 0);
                $pdf->Cell(110, 5, yazim_duzen($workgroup->notes), 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(30, 5, "TOPLAM", 1, 0, "L", 0);
            $pdf->Cell(15, 5, $this->Report_workgroup_model->sum_all(array("report_id" => $report->id), "number"), 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        } else {
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Cell(80, 5, "", 0, 0, "R", 0);
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "EKİP ÇALIŞMASI YOK", 0, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }
        $pdf->Ln(); // Yeni satıra geç
        if (!empty($workmachines)) {
            $pdf->SetFillColor(160, 160, 160);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "Çalışan Makineler", 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(30, 5, "Makine Adı", 1, 0, "C", 0);
            $pdf->Cell(15, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(35, 5, "Çalıştığı Mahal", 1, 0, "C", 0);
            $pdf->Cell(110, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);
            foreach ($workmachines as $workmachine) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);
                $pdf->Cell(30, 5, machine_name($workmachine->workmachine), 1, 0, "L", 0);
                $pdf->Cell(15, 5, $workmachine->number, 1, 0, "C", 0);
                $pdf->Cell(35, 5, yazim_duzen($workmachine->place), 1, 0, "L", 0);
                $pdf->Cell(110, 5, yazim_duzen($workmachine->notes), 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(30, 5, "TOPLAM", 1, 0, "L", 0);
            $pdf->Cell(15, 5, $this->Report_workmachine_model->sum_all(array("report_id" => $report->id), "number"), 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        } else {
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Cell(80, 5, "", 0, 0, "R", 0);
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "MAKİNE ÇALIŞMASI YOK", 0, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }
        $pdf->Ln(); // Yeni satıra geç
        if (!empty($supplies)) {
            $pdf->SetFillColor(160, 160, 160);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "Gelen Malzemeler", 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(30, 5, "Malzeme Adı", 1, 0, "C", 0);
            $pdf->Cell(15, 5, "Sayısı", 1, 0, "C", 0);
            $pdf->Cell(25, 5, "Birim", 1, 0, "C", 0);
            $pdf->Cell(120, 5, "Açıklama", 1, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetFont('dejavusans', 'N', 7);
            foreach ($supplies as $supply) {
                $pdf->SetX(10);
                $pdf->SetFont('dejavusans', 'N', 7);
                $pdf->Cell(30, 5, yazim_duzen($supply->supply), 1, 0, "L", 0);
                $pdf->Cell(15, 5, $supply->qty, 1, 0, "C", 0);
                $pdf->Cell(25, 5, $supply->unit, 1, 0, "C", 0);
                $pdf->Cell(120, 5, $supply->notes, 1, 0, "L", 0);
                $pdf->Ln(); // Yeni satıra geç
            }
        } else {
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Cell(80, 5, "", 0, 0, "R", 0);
            $pdf->SetX(10);
            $pdf->SetFont('dejavusans', 'B', 7);
            $pdf->Cell(190, 5, "GELEN MALZEME YOK", 0, 0, "C", 0);
            $pdf->Ln(); // Yeni satıra geç
        }
        $pdf->SetX(10);
        $pdf->SetFont('dejavusans', 'N', 7);
        $pdf->SetXY(10, 265);
        $pdf->SetFont('dejavusans', 'B', 7);
        if (isset($owner_sign)) {
            $pdf->Cell(95, 5, $owner_sign->position, 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->Cell(95, 5, $owner_sign->name, 1, 0, "C", 0);
        }
        $pdf->SetXY(105, 265);
        if (isset($contractor_sign)) {
            $pdf->Cell(95, 5, $contractor_sign->position, 1, 0, "C", 1);
            $pdf->Ln(); // Yeni satıra geç
            $pdf->SetX(105);
            $pdf->Cell(95, 5, $contractor_sign->name, 1, 0, "C", 0);
        }
        $pdf->Ln(); // Yeni satıra geç
        if ($print_pic == 1) {
            $pdf->AddPage();
            $offset = 10; // 1 cm = 10 mm
            $pageWidth = $pdf->getPageWidth() - $offset;
            $pageHeight = $pdf->getPageHeight() - $offset;
// Kutucuk özellikleri
            $boxWidth = ($pageWidth - $offset) / 2;
            $boxHeight = ($pageHeight - $offset) / 2;
            $date = dateFormat_dmy($report->report_date);
            $project_code = project_code($site->project_id);
            $imageDirectory = "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$site->dosya_no/Reports/$date/thumbnails";
            $originalPath = K_PATH_MAIN;
            if (DIRECTORY_SEPARATOR == "\\") {
                $removePart = 'application' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'tcpdf/';
            } else {
                $removePart = 'application' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'tcpdf' . DIRECTORY_SEPARATOR;
            }
            $newPath = str_replace($removePart, '', $originalPath);
            $path = $newPath . $imageDirectory;
            $baseDirectory = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
            $files = glob($baseDirectory . '/*');
            $x = 10;
            // Kenarlardan 1 cm offset
            $offset = 10; // 1 cm = 10 mm
            $pageWidth = $pdf->getPageWidth() - 2 * $offset;
            $pageHeight = $pdf->getPageHeight() - 2 * $offset;
// Kutucuk özellikleri
            $boxWidth = ($pageWidth - 2 * $offset) / 2;
            $boxHeight = ($pageHeight - 2 * $offset) / 2;
// Başlangıç X ve Y koordinatları
            $x = $offset;
            $y = $offset;
// İşlenen dosya sayısı
            $fileCount = 0;
            if (count($files) > 4) {
                $randomIndexes = array_rand($files, 4);
                $selectedFiles = array();
                // Seçilen rastgele görselleri al
                foreach ($randomIndexes as $index) {
                    $selectedFiles[] = $files[$index];
                }
                // Seçilen görselleri kullanarak işlem yap
                foreach ($selectedFiles as $file) {
                    if (is_file($file) && $fileCount < 4) {
                        // Dosyanın boyutlarını al
                        list($imgWidth, $imgHeight) = getimagesize($file);
                        // En-boy oranını koruyarak resmi yerleştir
                        if ($imgWidth > $imgHeight) {
                            // Yüksekliği oranı ile ayarla
                            $pdf->Image($file, $x, $y + 30, $boxWidth + 10, 0, 'JPG');
                        } else {
                            // Genişliği oranı ile ayarla
                            $pdf->Image($file, $x + 20, $y, 0, $boxHeight, 'JPG');
                        }
                        // X koordinatını güncelle
                        $x += $boxWidth + $offset;
                        // Dosya sayısını artır
                        $fileCount++;
                        // İlk iki resim tamamlandıysa, ikinci satıra geç
                        if ($fileCount % 2 == 0) {
                            $x = $offset;
                            $y += $boxHeight - 1 + $offset;
                        }
                    }
                }
            } else {
                foreach ($files as $file) {
                    if (is_file($file) && $fileCount < 4) {
                        // Dosyanın boyutlarını al
                        list($imgWidth, $imgHeight) = getimagesize($file);
                        // En-boy oranını koruyarak resmi yerleştir
                        if ($imgWidth > $imgHeight) {
                            // Yüksekliği oranı ile ayarla
                            $pdf->Image($file, $x, $y + 30, $boxWidth + 10, 0, 'JPG');
                        } else {
                            // Genişliği oranı ile ayarla
                            $pdf->Image($file, $x + 20, $y, 0, $boxHeight, 'JPG');
                        }
                        // X koordinatını güncelle
                        $x += $boxWidth + $offset;
                        // Dosya sayısını artır
                        $fileCount++;
                        // İlk iki resim tamamlandıysa, ikinci satıra geç
                        if ($fileCount % 2 == 0) {
                            $x = $offset;
                            $y += $boxHeight - 1 + $offset;
                        }
                    }
                }
            }
        }
        $file_name = dateFormat_dmy($report->report_date) . "_" . site_name($site->id) . "_" . "Günlük Rapor";
        if ($P_or_D == 0) {
            $pdf->Output("$file_name.pdf");
        } else {
            $pdf->Output("$file_name.pdf", "D");
        }
    }
}
