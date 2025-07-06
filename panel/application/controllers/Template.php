<?php

class Template extends MY_Controller
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

        $upload_path = './uploads/template/';

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

        $data['content_view'] = 'template_upload';
        $data['title'] = 'CSV Dosyası Yükle ve Yönet';

        $viewData = new stdClass();
        $viewData->uploaded_files = $files;
        $viewData->upload_dir = $upload_path;
        $viewData->date = $data;

        $this->load->view("template/display/index", $viewData); // Burayı da kaldırmayı önermiştim
    }

    // Şeklinde kalması lazım veya rota ile düzeltmeliyiz.
    public function template_upload()
    {
        $upload_path = './uploads/template/';

        // Klasör oluşturma kontrolü
        if (!is_dir($upload_path)) {
            if (!mkdir($upload_path, 0777, TRUE)) { // İzinleri duruma göre 0755 yapabilirsin
                $this->session->set_flashdata('error', 'Yükleme dizini oluşturulamadı. Lütfen ' . $upload_path . ' dizininin yazılabilir olduğundan emin olun.');
                redirect('template/index');
                return;
            }
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = '*';
        $config['max_size'] = 2048;
        // Bu satırı FALSE yaparak dosyanın orijinal adıyla kaydedilmesini sağlıyoruz.
        $config['encrypt_name'] = FALSE;         // DOSYA ADINI ŞİFRELEME (RASTGELE YAPMA) KAPATILDI
        // Eğer aynı isimde dosya yüklenirse üzerine yazsın istiyorsanız:
        // $config['overwrite']     = TRUE; // Mevcut dosyaların üzerine yazsın mı? (Varsayılan FALSE)


        $this->upload->initialize($config);

        if (!$this->upload->do_upload('template_file')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            redirect('template/index');
        } else {
            $data = array('upload_data' => $this->upload->data());
            // Orijinal dosya adı korunmuş olacak
            $file_name = $data['upload_data']['file_name'];

            $this->session->set_flashdata('success', 'Dosya başarıyla yüklendi: ' . $file_name);

            redirect('template/index');
        }
    }

    // delete_file() fonksiyonu - aynı kalacak
    public function delete_file($encoded_path)
    {
        $decoded_url = urldecode($encoded_path);
        $file_path = base64_decode($decoded_url);
        $file_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file_path);

        $allowed_dir = realpath('./uploads/template/');
        $real_file_path = realpath($file_path);

        if ($real_file_path === FALSE || strpos($real_file_path, $allowed_dir) !== 0) {
            $this->session->set_flashdata('error', 'Geçersiz dosya yolu veya silme yetkiniz yok.');
            log_message('error', 'Güvenlik Uyarısı: Dizin dışı dosya silme denemesi: ' . $file_path);
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Geçersiz dosya yolu veya silme yetkiniz yok.']));
                return;
            } else {
                redirect('template/index');
            }
        }

        if (file_exists($file_path) && is_writable($file_path)) {
            if (unlink($file_path)) {
                $this->session->set_flashdata('success', basename($file_path) . ' dosyası başarıyla silindi.');
                log_message('info', 'Dosya silindi: ' . $file_path);
                if ($this->input->is_ajax_request()) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'message' => basename($file_path) . ' başarıyla silindi.']));
                } else {
                    redirect('template/index');
                }
            } else {
                $this->session->set_flashdata('error', basename($file_path) . ' dosyası silinirken bir hata oluştu.');
                log_message('error', 'Dosya silme hatası: unlink() başarısız: ' . $file_path);
                if ($this->input->is_ajax_request()) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => basename($file_path) . ' silinemedi.']));
                } else {
                    redirect('template/index');
                }
            }
        } else {
            $this->session->set_flashdata('error', basename($file_path) . ' dosyası bulunamadı veya silme izni yok.');
            log_message('error', 'Dosya silme hatası: Dosya yok veya yazılabilir değil: ' . $file_path);
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => basename($file_path) . ' bulunamadı veya silme izni yok.']));
            } else {
                redirect('template/index');
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

        // 4. Dosyanın istenen güvenli dizinde (uploads/template) olup olmadığını kontrol et
        $allowed_dir = realpath('./uploads/template/'); // 'realpath' ile gerçek ve güvenli yolu al
        $real_file_path = realpath($file_path); // İndirilmek istenen dosyanın gerçek yolu


        // Önemli Güvenlik Kontrolü:
        // İndirilmek istenen dosyanın yolunun, izin verilen dizinin (uploads/template) içinde başladığından emin ol.
        // Bu, dizin atlama saldırılarını (directory traversal) engeller.
        if ($real_file_path === FALSE || strpos($real_file_path, $allowed_dir) !== 0) {
            $this->session->set_flashdata('error', 'Geçersiz dosya yolu veya erişim izni yok.');
            log_message('error', 'Güvenlik Uyarısı: Dizin dışı dosya indirme denemesi: ' . $file_path);
            redirect('template/index');
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
