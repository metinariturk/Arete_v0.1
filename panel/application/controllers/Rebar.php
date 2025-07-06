<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Rebar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('upload');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->helper('file');
        $this->load->helper('download');


        $models = [
            'Boq_model',
            'Payment_model',
            'Contract_model',
            'Contract_price_model',
            'Project_model',
        ];
        foreach ($models as $model) {
            $this->load->model($model);
        }


    }

    public function index()
    {

        $data = array(); // View'e gönderilecek tüm veriler için tek bir dizi

        $upload_path = './uploads/rebar/';

        if (is_dir($upload_path)) {
            $files = get_filenames($upload_path);
            $data['uploaded_files'] = $files;
            $data['upload_dir'] = $upload_path;
        } else {
            $data['uploaded_files'] = array();
            $data['upload_dir'] = $upload_path;
        }

        // Flashdata mesajlarını al
        if ($this->session->flashdata('error')) {
            $data['error'] = $this->session->flashdata('error');
        }
        if ($this->session->flashdata('success')) {
            $data['success'] = $this->session->flashdata('success');
        }

        $data['content_view'] = 'csv_yukleme_formu';
        $data['title'] = 'CSV Dosyası Yükle ve Yönet';

        $viewData = new stdClass();
        $viewData->uploaded_files = $files;
        $viewData->upload_dir = $upload_path;
        $viewData->date = $data;

        $this->load->view("contract_module/rebar_calculate/display/index", $viewData); // Burayı da kaldırmayı önermiştim
    }



    // public function yukle_csv()
    // Şeklinde kalması lazım veya rota ile düzeltmeliyiz.
    public function yukle_csv()
    {
        $upload_path = './uploads/rebar/';

        // Klasör oluşturma kontrolü
        if (!is_dir($upload_path)) {
            if (!mkdir($upload_path, 0777, TRUE)) { // İzinleri duruma göre 0755 yapabilirsin
                $this->session->set_flashdata('error', 'Yükleme dizini oluşturulamadı. Lütfen ' . $upload_path . ' dizininin yazılabilir olduğundan emin olun.');
                redirect('Rebar/index');
                return;
            }
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 2048;
        // Bu satırı FALSE yaparak dosyanın orijinal adıyla kaydedilmesini sağlıyoruz.
        $config['encrypt_name'] = FALSE;         // DOSYA ADINI ŞİFRELEME (RASTGELE YAPMA) KAPATILDI
        // Eğer aynı isimde dosya yüklenirse üzerine yazsın istiyorsanız:
        // $config['overwrite']     = TRUE; // Mevcut dosyaların üzerine yazsın mı? (Varsayılan FALSE)


        $this->upload->initialize($config);

        if (!$this->upload->do_upload('csv_dosyasi')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            redirect('contract_module/rebar_calculate/index');
        } else {
            $data = array('upload_data' => $this->upload->data());
            // Orijinal dosya adı korunmuş olacak
            $file_name = $data['upload_data']['file_name'];
            $file_path = $data['upload_data']['full_path'];

            $this->session->set_flashdata('success', 'Dosya başarıyla yüklendi: ' . $file_name);

            $this->islem_csv_dosyasi($file_path);

            redirect('Rebar/index');
        }
    }

    public function render_csv_table($encoded_path)
    {
        $decoded_url = urldecode($encoded_path);
        $file_path = base64_decode($decoded_url);
        $file_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file_path);

        error_log("DEBUG: PHP is attempting to read file at: " . $file_path);

        $allowed_dir = realpath('./uploads/rebar/');
        $real_file_path = realpath($file_path);

        $viewData = new stdClass();

        $debug_fgetcsv_rows = [];

        if ($real_file_path === FALSE || strpos($real_file_path, $allowed_dir) !== 0) {
            $viewData->error_message = 'Güvenlik hatası: Geçersiz dosya yolu veya erişim izni yok.';
            log_message('error', 'Güvenlik Uyarısı: Dizin dışı dosya görüntüleme denemesi veya geçersiz yol: ' . $file_path);
        } else if (file_exists($file_path) && is_readable($file_path)) {
            if (($handle = fopen($file_path, "r")) !== FALSE) {
                stream_filter_append($handle, 'convert.iconv.Windows-1254/UTF-8');

                $row_count = 0;
                $processed_csv_data = [];

                while (($raw_csv_row = fgetcsv($handle, 0, ",")) !== FALSE) {
                    $cleaned_raw_fgetcsv_row = array_map(function ($block) {
                        $block = trim($block);
                        if (substr($block, 0, 1) === '"' && substr( /* Line 173 */ $block, -1, 1) === '"' && strlen($block) > 1) {
                            $block = substr($block, 1, -1);
                        }
                        $block = str_replace('""', '"', $block);
                        return $block;
                    }, $raw_csv_row);

                    $debug_fgetcsv_rows[] = $cleaned_raw_fgetcsv_row;

                    if ($row_count == 0) {
                        // Başlık satırını atla.
                    } else {
                        $n_parts = [];
                        $qty = '';
                        $r = '';
                        $l = '';
                        $is_qty_missing = FALSE;
                        $is_r_missing = FALSE;
                        $is_l_missing = FALSE;

                        $raw_data_combined = implode(', ', array_map('trim', $raw_csv_row));

                        foreach ($cleaned_raw_fgetcsv_row as $block_original) {
                            $block = trim($block_original);

                            if (empty($block)) {
                                continue;
                            }

                            $assigned_to_data_field = FALSE;

                            // 1. Birleşik Donatı + Uzunluk + Açıklama Bloğu (örn: "55ø14/20 L=565 ÜST")
                            if (preg_match('/^((?:\d+[x*]\d+|\d+))([fQøƒ])(\d+)(?:\/?(\d+))?\s+L=\s*(\d+)\s*(.*)?$/iu', $block, $matches_all)) {
                                $raw_qty_string = $matches_all[1]; // `matches_all[1]` her zaman tanımlı olmalı, regex'in yapısından ötürü.
                                $r = $matches_all[3];
                                $l = $matches_all[5];
                                $assigned_to_data_field = TRUE;

                                // Adeti hesapla
                                if (strpos($raw_qty_string, '*') !== FALSE) {
                                    list($num1, $num2) = explode('*', $raw_qty_string);
                                    $qty = (int)$num1 * (int)$num2;
                                } elseif (strpos($raw_qty_string, 'x') !== FALSE) {
                                    list($num1, $num2) = explode('x', $raw_qty_string);
                                    $qty = (int)$num1 * (int)$num2;
                                } else {
                                    $qty = $raw_qty_string;
                                }

                                if (isset($matches_all[6]) && !empty(trim($matches_all[6]))) {
                                    $n_parts[] = trim($matches_all[6]);
                                }
                            }
                            // 2. Birleşik Donatı + Açıklama Bloğu (örn: "2x3ƒ12 (GÖVDE)") - YENİ KURAL
                            // L= içermeyen ama donatı ve ardından açıklama içeren blokları yakalar.
                            else if (preg_match('/^((?:\d+[x*]\d+|\d+))([fQøƒ])(\d+)(?:\/?(\d+))?\s*(.+)?$/iu', $block, $matches_qty_desc)) {
                                $raw_qty_string = $matches_qty_desc[1]; // `matches_qty_desc[1]` her zaman tanımlı olmalı.
                                $r = $matches_qty_desc[3];
                                $assigned_to_data_field = TRUE;

                                // Adeti hesapla
                                if (strpos($raw_qty_string, '*') !== FALSE) {
                                    list($num1, $num2) = explode('*', $raw_qty_string);
                                    $qty = (int)$num1 * (int)$num2;
                                } elseif (strpos($raw_qty_string, 'x') !== FALSE) {
                                    list($num1, $num2) = explode('x', $raw_qty_string);
                                    $qty = (int)$num1 * (int)$num2;
                                } else {
                                    $qty = $raw_qty_string;
                                }

                                // Kalan metni (açıklama) n_parts'a ekle
                                if (isset($matches_qty_desc[5]) && !empty(trim($matches_qty_desc[5]))) { // Grup 5, son yakalanan açıklama
                                    $n_parts[] = trim($matches_qty_desc[5]);
                                }
                            } // 3. Sadece Uzunluk ve kalan açıklama aynı blokta (örn: "L=89 Alt")
                            else if (preg_match('/^L=\s*(\d+)\s*(.*)?$/iu', $block, $matches_l_and_rest)) {
                                if (empty($l)) {
                                    $l = $matches_l_and_rest[1];
                                }
                                $assigned_to_data_field = TRUE;

                                if (isset($matches_l_and_rest[2]) && !empty(trim($matches_l_and_rest[2]))) {
                                    $n_parts[] = trim($matches_l_and_rest[2]);
                                }
                            }
                            // 4. Sadece Donatı bloğu (L= yok, Açıklama yok, örn: "22ƒ12/10")
                            // Bu kural, en son donatı kuralı olarak kalır.
                            else if (preg_match('/^((?:\d+[x*]\d+|\d+))([fQøƒ])(\d+)(?:\/?(\d+))?/iu', $block, $matches_qr_solo)) {
                                $raw_qty_string = $matches_qr_solo[1];
                                $r = $matches_qr_solo[3];

                                if (strpos($raw_qty_string, '*') !== FALSE) {
                                    list($num1, $num2) = explode('*', $raw_qty_string);
                                    $qty = (int)$num1 * (int)$num2;
                                } elseif (strpos($raw_qty_string, 'x') !== FALSE) {
                                    list($num1, $num2) = explode('x', $raw_qty_string);
                                    $qty = (int)$num1 * (int)$num2;
                                } else {
                                    $qty = $raw_qty_string;
                                }
                                $assigned_to_data_field = TRUE;
                            }
                            // 5. Kalanlar Açıklama olarak kabul edilir.
                            if (!$assigned_to_data_field) {
                                $n_parts[] = $block;
                            }
                        }

                        // Adet, Çap veya Uzunluk boş kaldıysa işaretle
                        if (empty($qty)) {
                            $is_qty_missing = TRUE;
                        }
                        if (empty($r)) {
                            $is_r_missing = TRUE;
                        }
                        if (empty($l)) {
                            $is_l_missing = TRUE;
                        }

                        // 'n' (açıklama) parçalarını birleştir ve temizle
                        $final_n = implode(' ', array_filter($n_parts, function ($part) {
                            $trimmed_part = trim($part);
                            return !empty($trimmed_part) || is_numeric($trimmed_part);
                        }));
                        $final_n = trim($final_n, '"');
                        $final_n = trim($final_n, '()');

                        $processed_csv_data[] = [
                            'raw_combined' => $raw_data_combined,
                            'n' => $final_n,
                            'qty' => $qty,
                            'r' => $r,
                            'l' => $l,
                            'is_qty_missing' => $is_qty_missing,
                            'is_r_missing' => $is_r_missing,
                            'is_l_missing' => $is_l_missing
                        ];
                    }
                    $row_count++;
                }
                fclose($handle);

                $viewData->csv_header_for_table = ['Ham Veri', 'Açıklama', 'Adet', 'Çap', 'Uzunluk'];
                $viewData->csv_data_for_table = $processed_csv_data;
                $viewData->total_rows = count($processed_csv_data);

            } else {
                $viewData->error_message = 'CSV dosyası açılamadı (fopen başarısız). İzinleri kontrol edin.';
                log_message('error', 'CSV dosyası açılamadı: ' . $file_path);
            }
        } else {
            $viewData->error_message = 'Dosya bulunamadı veya PHP tarafından okunamadı. Yol: ' . $file_path;
            log_message('error', 'Dosya görüntüleme hatası: Dosya yok veya okunamaz: ' . $file_path);
        }

        $viewData->file_name = basename($file_path);
        $viewData->debug_fgetcsv_rows = $debug_fgetcsv_rows;

        $html_output = $this->load->view('contract_module/rebar_calculate/display/rebar_table', $viewData, TRUE);
        $this->output->set_content_type('text/html')->set_output($html_output);
    }

    public function process_json_data()
    {
        $input = $this->input->raw_input_stream;
        $data = json_decode($input, TRUE);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Geçersiz JSON verisi: ' . json_last_error_msg()]));
            return;
        }

        if (isset($data['rows']) && is_array($data['rows']) && !empty($data['rows'][0][0])) {
            log_message('info', 'JSON ile gelen ilk hücre verisi: ' . $data['rows'][0][0]);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => count($data['rows']) . ' satır veri başarıyla işlendi.']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'JSON verisinde işlenecek satır bulunamadı.']));
        }
    }

    // islem_csv_dosyasi() fonksiyonu - aynı kalacak
    private function islem_csv_dosyasi($file_path)
    {
        $rows = [];
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            $row_count = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row_count == 0) {
                    $row_count++;
                    continue;
                }
                $rows[] = $data;
                $row_count++;
            }
            fclose($handle);
            log_message('info', 'CSV dosyası işlendi. Toplam satır: ' . count($rows) . ' (' . $file_path . ')');
            $this->session->set_flashdata('success', $this->session->flashdata('success') . '<br>Toplam ' . count($rows) . ' satır başarıyla işlendi.');

        } else {
            log_message('error', 'CSV dosyası açılamadı: ' . $file_path);
            $this->session->set_flashdata('error', 'CSV dosyası açılırken bir hata oluştu.');
        }
    }

    // delete_file() fonksiyonu - aynı kalacak
    public function delete_file($encoded_path)
    {
        $decoded_url = urldecode($encoded_path);
        $file_path = base64_decode($decoded_url);
        $file_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file_path);

        $allowed_dir = realpath('./uploads/rebar/');
        $real_file_path = realpath($file_path);

        if ($real_file_path === FALSE || strpos($real_file_path, $allowed_dir) !== 0) {
            $this->session->set_flashdata('error', 'Geçersiz dosya yolu veya silme yetkiniz yok.');
            log_message('error', 'Güvenlik Uyarısı: Dizin dışı dosya silme denemesi: ' . $file_path);
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Geçersiz dosya yolu veya silme yetkiniz yok.']));
                return;
            } else {
                redirect('contract_module/rebar_calculate/index');
            }
        }

        if (file_exists($file_path) && is_writable($file_path)) {
            if (unlink($file_path)) {
                $this->session->set_flashdata('success', basename($file_path) . ' dosyası başarıyla silindi.');
                log_message('info', 'Dosya silindi: ' . $file_path);
                if ($this->input->is_ajax_request()) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'message' => basename($file_path) . ' başarıyla silindi.']));
                } else {
                    redirect('contract_module/rebar_calculate/index');
                }
            } else {
                $this->session->set_flashdata('error', basename($file_path) . ' dosyası silinirken bir hata oluştu.');
                log_message('error', 'Dosya silme hatası: unlink() başarısız: ' . $file_path);
                if ($this->input->is_ajax_request()) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => basename($file_path) . ' silinemedi.']));
                } else {
                    redirect('contract_module/rebar_calculate/index');
                }
            }
        } else {
            $this->session->set_flashdata('error', basename($file_path) . ' dosyası bulunamadı veya silme izni yok.');
            log_message('error', 'Dosya silme hatası: Dosya yok veya yazılabilir değil: ' . $file_path);
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => basename($file_path) . ' bulunamadı veya silme izni yok.']));
            } else {
                redirect('contract_module/rebar_calculate/index');
            }
        }
    }

    public function download_file($encoded_path)
    {
        // 1. URL encoding'i çöz (boşluklar, özel karakterler vb.)
        $decoded_url = urldecode($encoded_path);

        // 2. Base64 encoding'i çözerek orijinal dosya yolunu al
        $file_path = base64_decode($decoded_url);

        // 3. Platforma uygun dosya yolunu normalize et (Windows/Linux uyumluluğu için)
        // Bu adım, dosya yolu karışıklıklarını önler.
        $file_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file_path);

        // 4. Dosyanın istenen güvenli dizinde (uploads/rebar) olup olmadığını kontrol et
        $allowed_dir = realpath('./uploads/rebar/'); // 'realpath' ile gerçek ve güvenli yolu al
        $real_file_path = realpath($file_path); // İndirilmek istenen dosyanın gerçek yolu


        // Önemli Güvenlik Kontrolü:
        // İndirilmek istenen dosyanın yolunun, izin verilen dizinin (uploads/rebar) içinde başladığından emin ol.
        // Bu, dizin atlama saldırılarını (directory traversal) engeller.
        if ($real_file_path === FALSE || strpos($real_file_path, $allowed_dir) !== 0) {
            $this->session->set_flashdata('error', 'Geçersiz dosya yolu veya erişim izni yok.');
            log_message('error', 'Güvenlik Uyarısı: Dizin dışı dosya indirme denemesi: ' . $file_path);
            redirect('contract_module/rebar_calculate/index');
            return;
        }

        if (file_exists($file_path)) {
            // Dosya indirmeye başla
            $this->load->helper('download');
            force_download($file_path, NULL);  // Dosyayı indir
        } else {
            echo "Dosya bulunamadı!";
        }

        log_message('info', 'Dosya indirildi: ' . $file_path);
    }

    public function export_table_to_excel()
    {
        $limit = $this->input->get('limit') ?? 100; // varsayılan 100

        $posted_rows_data = []; // Varsayılan olarak boş bir dizi tanımla

        if ($this->input->method() === 'post') {
            // Tüm POST verilerini $formData dizisine topluyoruz
            $formData = $this->input->post();

            // Formdan gelen 'rows' verilerini alıyoruz
            $posted_rows_data = $formData['rows'] ?? []; // Eğer boşsa boş dizi olsun

            // Bu kısım sadece debug için, Excel çıktısı alırken devre dışı bırakılmalı
            // print_r($posted_rows_data);
            // exit; // Bu satır Excel çıktısını engeller, debug bitince silinmeli

        } else {
            // Eğer GET isteği gelirse veya başka bir method gelirse
            // Bu kısım test veya doğrudan erişim için kullanılabilir.
            // Örnek statik veri ataması (gerçek POST gelmediğinde test etmek için)
            // Canlı ortamda bu kısım kaldırılabilir veya farklı bir hata mesajı verilebilir.
            // Bu test verisi, sizin daha önce verdiğiniz yapıya uygun olarak güncellenmiştir:
            $posted_rows_data = [
                0 => [ 'raw_combined' => '4ƒ16, L=480', 'n' => '', 'qty' => '4', 'r' => '16', 'l' => '480' ],
                1 => [ 'raw_combined' => '2x3ƒ12 (GÖVDE), L=385', 'n' => 'GÖVDE', 'qty' => '6', 'r' => '12', 'l' => '385' ],
                2 => [ 'raw_combined' => '4ƒ16, L=480', 'n' => '', 'qty' => '4', 'r' => '16', 'l' => '480' ],
                3 => [ 'raw_combined' => '22ƒ12/10, L=270', 'n' => '', 'qty' => '22', 'r' => '12', 'l' => '270' ],
                4 => [ 'raw_combined' => 'K-1002 (30/105)', 'n' => 'K-1002 (30/105', 'qty' => '', 'r' => '', 'l' => '' ],
                5 => [ 'raw_combined' => '4ƒ16, L=465', 'n' => '', 'qty' => '4', 'r' => '16', 'l' => '465' ],
                6 => [ 'raw_combined' => '2x3ƒ12 (GÖVDE), L=370', 'n' => 'GÖVDE', 'qty' => '6', 'r' => '12', 'l' => '370' ],
                7 => [ 'raw_combined' => '4ƒ16, L=465', 'n' => '', 'qty' => '4', 'r' => '16', 'l' => '465' ],
                8 => [ 'raw_combined' => '25ƒ12/10, L=270', 'n' => '', 'qty' => '25', 'r' => '12', 'l' => '270' ]
            ];
            // Eğer bu kısmı kullanmak istemiyorsanız, aşağıdaki hata mesajını bırakabilirsiniz:
            // echo 'Bu fonksiyon sadece POST isteği ile çalışır. Lütfen formu kullanarak veri gönderin.';
            // return; // Eğer POST gelmezse işlemi durdur
        }

        $dataArray = $posted_rows_data;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $title_start_row = 2;

        // METRAJ CETVELİ Başlıkları ve Bilgileri (Mevcut Kodunuz)
        // 1. satır: METRAJ CETVELİ
        $sheet->mergeCells("B$title_start_row:I$title_start_row");
        $sheet->setCellValue("B$title_start_row", "METRAJ CETVELİ (Donatı)");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(20);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$title_start_row:I$title_start_row")->getFont()->setName('Verdana');

        $title_start_row += 2; // 2 satır atlama

        // 2. satır: İşin adı
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "İşin Adı : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", "");
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $title_start_row++;

        // 3. satır: Firma adı
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "Firma : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", "");
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $title_start_row++;

        // 4. satır: İmalat Adı
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "İmalat Adı : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        $sheet->setCellValue("D$title_start_row", "Betonarme Donatı Metrajı");
        $sheet->getStyle("D$title_start_row")->getFont()->setSize(11);
        $sheet->getStyle("D$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $title_start_row++;
        $total_row_display = $title_start_row; // Toplam bilgisinin görüneceği satır

        // 5. satır: Toplam etiketi
        $sheet->mergeCells("B$title_start_row:C$title_start_row");
        $sheet->setCellValue("B$title_start_row", "Toplam : ");
        $sheet->getStyle("B$title_start_row")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("B$title_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("D$title_start_row:I$title_start_row");
        // Değer daha sonra hesaplanıp buraya atanacak

        $sheet->getStyle("A1:D$title_start_row")->getFont()->getColor()->setARGB('FF808080');

        $title_start_row += 2;
        $counter = 1;

        $table_start_row = $title_start_row; // Metraj cetveli başlıklarının başladığı satır

        // Kolon başlıkları
        $sheet->setCellValue("A$table_start_row", '');
        $sheet->setCellValue("B$table_start_row", 'No');
        $sheet->setCellValue("C$table_start_row", 'Mahal');
        $sheet->setCellValue("D$table_start_row", 'Açıklama');
        $sheet->setCellValue("E$table_start_row", 'Çap');
        $sheet->setCellValue("F$table_start_row", 'Benzer');
        $sheet->setCellValue("G$table_start_row", 'Adet');
        $sheet->setCellValue("H$table_start_row", 'Uzunluk');
        $sheet->setCellValue("I$table_start_row", 'Toplam (kg)');

        $sheet->getStyle("E$table_start_row:I$table_start_row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $maxRows = $limit;

        $dataStartRow = $table_start_row + 1;
        $sheet->freezePane("A$dataStartRow");

        $allowedValues = [8, 10, 12, 14, 16, 18, 20, 22, 24, 25, 26, 28, 30, 32, 34, 36, 38, 40, 45, 50];

        $hiddenListStartRow = 10;
        $hiddenListColumn = 'K';

        foreach ($allowedValues as $index => $value) {
            $sheet->setCellValue($hiddenListColumn . ($hiddenListStartRow + $index), $value);
            $sheet->getStyle($hiddenListColumn . ($hiddenListStartRow + $index))->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        }

        $hiddenListEndRow = $hiddenListStartRow + count($allowedValues) - 1;
        $hiddenListRange = '$' . $hiddenListColumn . '$' . $hiddenListStartRow . ':$' . $hiddenListColumn . '$' . $hiddenListEndRow;

        $dataCount = !empty($dataArray) ? count($dataArray) : 0;
        $rowsToGenerate = max($dataCount + 1, $maxRows);

        // Veriyi döngüye alıp Excel'e yazma
        for ($i = 0; $i < $rowsToGenerate; $i++) { // Döngüyü 0'dan başlatıyoruz çünkü array indeksleri 0'dan başlar
            $currentRow = $dataStartRow + $i; // satır indeksi $i'ye göre ayarlanır

            $validation = $sheet->getCell('E' . $currentRow)->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_STOP);
            $validation->setAllowBlank(true);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setErrorTitle('Geçersiz Değer');
            $validation->setError('Sadece belirtilen çaplardan birini girin.');
            $validation->setFormula1($hiddenListRange);

            $sheet->setCellValue('B' . $currentRow, $counter); // No sütunu

            if (isset($dataArray[$i])) { // $dataArray[$i] var mı kontrol et
                $data = $dataArray[$i];
                // Verilerinizi $dataArray yapısına göre eşleştiriyoruz:
                // Sizin $posted_rows_data yapınızdaki anahtarlar: raw_combined, n, qty, r, l
                // Kodunuzdaki kullanılan anahtarlar: s, n, q, w, h, l (Bunlar uyuşmuyor!)

                // Mevcut $posted_rows_data yapınıza göre eşleştirme yapalım:
                // C: Mahal (s) -> sizde yok, boş bırakalım veya 'raw_combined' kullanabilirsiniz
                // D: Açıklama (n) -> sizde 'n' var
                // E: Çap (q) -> sizde 'r' var (çapı temsil ediyor olmalı)
                // F: Benzer (w) -> sizde yok, boş bırakalım
                // G: Adet (h) -> sizde 'qty' var
                // H: Uzunluk (l) -> sizde 'l' var

                $sheet->setCellValue('C' . $currentRow, $data['raw_combined'] ?? ''); // Mahal için raw_combined kullandım, ihtiyaca göre değiştirin
                $sheet->setCellValue('D' . $currentRow, $data['n'] ?? ''); // Açıklama

                $r_value = trim($data['r'] ?? '');
                if (empty($r_value) || (is_numeric($r_value) && (float)$r_value == 0)) {
                    $sheet->setCellValue('E' . $currentRow, ''); // Çap
                } else {
                    $sheet->setCellValue('E' . $currentRow, (int)$r_value);
                }

                $sheet->setCellValue('F' . $currentRow, ''); // Benzer (Verinizde karşılığı yok, boş bırakıldı)

                $qty_value = trim($data['qty'] ?? '');
                if (empty($qty_value) || (is_numeric($qty_value) && (float)$qty_value == 0)) {
                    $sheet->setCellValue('G' . $currentRow, ''); // Adet
                } else {
                    $sheet->setCellValue('G' . $currentRow, (int)$qty_value);
                }

                $l_value = trim($data['l'] ?? '');
                if (empty($l_value) || (is_numeric($l_value) && (float)$l_value == 0)) {
                    $sheet->setCellValue('H' . $currentRow, ''); // Uzunluk
                } else {
                    $sheet->setCellValue('H' . $currentRow, (int)$l_value/100);
                }

            } else {
                // Eğer veri yoksa, boş hücrelerin varsayılan değerleri veya boş stringler
                $sheet->setCellValue('C' . $currentRow, '');
                $sheet->setCellValue('D' . $currentRow, '');
                $sheet->setCellValue('E' . $currentRow, '');
                $sheet->setCellValue('F' . $currentRow, '');
                $sheet->setCellValue('G' . $currentRow, '');
                $sheet->setCellValue('H' . $currentRow, '');
            }

            // Formül aynı kalabilir, çünkü Excel hücre referansları (E, F, G, H, I) değişmiyor
            $formula = sprintf(
                '=IF(OR(ISNUMBER(SEARCH("minha",LOWER(D%d))), ISNUMBER(SEARCH("mihna",LOWER(D%d))), ISNUMBER(SEARCH("minah",LOWER(D%d)))), ' .
                // D sütununda "minha" benzeri kelime varsa (Negatif Hesaplama Durumu)
                'IF(AND(ISNUMBER(G%d),ISNUMBER(H%d)), ' . // Adet ve Uzunluk sayı mı?
                '-1 * ((E%d^2/162) * (IF(ISNUMBER(F%d),F%d,1)) * G%d * H%d), ' . // Benzer doluysa onu, boşsa 1 al; sonra adet ve uzunlukla çarp, sonucu negatife çevir
                '"HATA: Adet/Uzunluk Eksik"' . // Adet veya Uzunluk sayı değilse hata mesajı
                '), ' .
                // D sütununda "minha" benzeri kelime yoksa (Pozitif Hesaplama veya Açıklama Satırı Durumu)
                'IF(AND(ISNUMBER(G%d),ISNUMBER(H%d)), ' . // Adet ve Uzunluk sayı mı?
                // Adet ve Uzunluk doluysa (Pozitif Hesaplama Durumu)
                '((E%d^2/162) * (IF(ISNUMBER(F%d),F%d,1)) * G%d * H%d), ' .
                // Adet veya Uzunluk boşsa, ve "minha" yok (Açıklama Satırı veya Hata Mesajı ayrımı)
                'IF(AND(ISBLANK(E%d), ISBLANK(F%d), ISBLANK(G%d), ISBLANK(H%d)), ' . // E,F,G,H hepsi boş mu?
                '"", ' . // Evet, açıklama satırı: boş bırak
                '"HATA: Adet/Uzunluk Eksik"' . // Hayır, E,F,G,H hepsi boş değilse bu bir hata
                ')' .
                ')' .
                ')',
                $currentRow, $currentRow, $currentRow, // D (SEARCH)
                $currentRow, $currentRow, // G, H (AND) - Negatif kısım için
                $currentRow, $currentRow, $currentRow, $currentRow, $currentRow, // E, F, G, H (negatif çarpım)

                $currentRow, $currentRow, // G, H (AND) - Pozitif kısım için
                $currentRow, $currentRow, $currentRow, $currentRow, $currentRow, // E, F, G, H (pozitif çarpım)

                $currentRow, $currentRow, $currentRow, $currentRow // E, F, G, H (ISBLANK AND)
            );
            $sheet->setCellValue('I' . $currentRow, $formula);

            $counter++;
        }

        $lastDataRow = $currentRow; // Son veri satırını doğru şekilde ayarla

        $sheet->getColumnDimension($hiddenListColumn)->setVisible(false);

        $headerStyle = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFC000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle("B$table_start_row:I$table_start_row")->applyFromArray($headerStyle);

        $numberColumnStyle = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFC000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle("B" . ($table_start_row + 1) . ":B$lastDataRow")->applyFromArray($numberColumnStyle);

        $first_value_row = $table_start_row + 1;
        $sheet->setCellValue("D$total_row_display", "=SUM(I$first_value_row:I$lastDataRow)/1000");

        $sheet->getStyle("D$total_row_display")
            ->getNumberFormat()
            ->setFormatCode('#,##0.00" ' . "ton");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(5);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setWidth(9);
        $sheet->getColumnDimension('F')->setWidth(9);
        $sheet->getColumnDimension('G')->setWidth(9);
        $sheet->getColumnDimension('H')->setWidth(9);
        $sheet->getColumnDimension('I')->setWidth(11);

        $sheet->getStyle("E$dataStartRow:I$lastDataRow")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("E$dataStartRow:I$lastDataRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle("D$total_row_display")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $allBorders = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle("B$table_start_row:I$lastDataRow")->applyFromArray($allBorders);

        for ($r = $dataStartRow; $r <= $lastDataRow; $r++) {
            try {
                $iValue = $sheet->getCell('I' . $r)->getCalculatedValue();
            } catch (\PhpOffice\PhpSpreadsheet\CalculationException $e) {
                $iValue = 0;
                error_log("Excel formül hesaplama hatası (I$r): " . $e->getMessage());
            }

            $isNegative = is_numeric($iValue) && $iValue < 0;

            if ($isNegative) {
                $sheet->getStyle("B$r:I$r")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFCCCC');

                $sheet->getStyle("B$r:I$r")->getFont()->setBold(true);
                $sheet->getStyle("B$r:I$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            } else {
                $fillColor = ($r % 2 == 0) ? 'FFEEEEEE' : 'FFDDDDDD';
                $sheet->getStyle("C$r:I$r")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB($fillColor);

                $sheet->getStyle("C$r:I$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("B$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        $sheet->getPageMargins()->setTop(0.75);
        $sheet->getPageMargins()->setBottom(0.75);
        $sheet->getPageMargins()->setLeft(0.70);
        $sheet->getPageMargins()->setRight(0.70);
        $sheet->getPageSetup()->setHorizontalCentered(true);

        // --- GENEL İCMAL TABLOSU BAŞLANGICI ---
        $icmal_start_column = 'M';
        $icmal_start_row = 2; // Bu, METRAJ CETVELİ başlığıyla aynı satırda başlayacak

        // "GENEL İCMAL" başlığı
        $icmal_header_start_cell = $icmal_start_column . $icmal_start_row;
        $icmal_header_end_column = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($icmal_start_column) + count($allowedValues) - 1);
        $icmal_header_end_cell = $icmal_header_end_column . $icmal_start_row;

        $sheet->mergeCells("$icmal_header_start_cell:$icmal_header_end_cell");
        $sheet->setCellValue($icmal_header_start_cell, "GENEL İCMAL");
        $sheet->getStyle($icmal_header_start_cell)->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle($icmal_header_start_cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($icmal_header_start_cell)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($icmal_header_start_cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDAEEF3');

        $icmal_current_row = $icmal_start_row + 2;
        $icmal_total_values_row = $icmal_current_row + 1;

        // Çap başlıkları ve formüller
        $colIndex = Coordinate::columnIndexFromString($icmal_start_column);
        foreach ($allowedValues as $index => $value) {
            $currentCol = Coordinate::stringFromColumnIndex($colIndex + $index);
            // Çap başlığı (Ø8, Ø10 vb.)
            $sheet->setCellValue($currentCol . $icmal_current_row, $value);
            $sheet->getStyle($currentCol . $icmal_current_row)->getNumberFormat()->setFormatCode('"Ø "#');
            $sheet->getStyle($currentCol . $icmal_current_row)->getFont()->setBold(true);
            $sheet->getStyle($currentCol . $icmal_current_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($currentCol . $icmal_current_row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($currentCol . $icmal_current_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDDEBF7');

            $sheet->getColumnDimension($currentCol)->setAutoSize(true);

            $sumif_formula = sprintf(
                '=SUMIF($E$%d:$E$%d,%s%d,$I$%d:$I$%d)/1000',
                $dataStartRow,
                $lastDataRow,
                $currentCol,
                $icmal_current_row,
                $dataStartRow,
                $lastDataRow
            );
            $sheet->setCellValue($currentCol . $icmal_total_values_row, $sumif_formula);
            $sheet->getStyle($currentCol . $icmal_total_values_row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle($currentCol . $icmal_total_values_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDDEBF7');
            $sheet->getStyle($currentCol . $icmal_total_values_row)->getFont()->setBold(true);
            $sheet->getStyle($currentCol . $icmal_total_values_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        $icmal_table_range = "$icmal_header_start_cell:$icmal_header_end_column" . $icmal_total_values_row;
        $sheet->getStyle($icmal_table_range)->applyFromArray($allBorders);

        // --- GENEL İCMAL TABLOSU SONU ---


        // Excel dosyasını indir
        $writer = new Xlsx($spreadsheet);
        $downloadFileName = "Tespit 12 Nolu Hakediş.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . rawurlencode($downloadFileName) . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit; // İşlem bitince çıkış yap
    }
}
