<?php

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
                    $cleaned_raw_fgetcsv_row = array_map(function($block) {
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
                            }
                            // 3. Sadece Uzunluk ve kalan açıklama aynı blokta (örn: "L=89 Alt")
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
                        if (empty($qty)) { $is_qty_missing = TRUE; }
                        if (empty($r))   { $is_r_missing = TRUE; }
                        if (empty($l))   { $is_l_missing = TRUE; }

                        // 'n' (açıklama) parçalarını birleştir ve temizle
                        $final_n = implode(' ', array_filter($n_parts, function($part) {
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

}
