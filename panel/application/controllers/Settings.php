<?php
class Settings extends MY_Controller
{
    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();

        $this->Module_Title = "Sistem Ayarları";
        $this->viewFolder = "settings_v";
        $this->Module_Name = "settings";
        $this->load->model("Settings_model");
    }
    public function index()
    {
        $viewData = new stdClass();
        
        $item = $this->Settings_model->get();
        $viewData->subViewFolder = "display";
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $item;
        $viewData->default_groups = json_decode($item->default_groups, true);
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function new_form()
    {
        $viewData = new stdClass();
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function save()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("sirket_adi", "Şirket Adı", "required|trim");
        $this->form_validation->set_rules("vergi_no", "Vergi No", "required|trim|min_length[10]|max_length[10]|numeric");
        $this->form_validation->set_rules("vergi_daire", "Vergi Dairesi", "required|trim");
        $this->form_validation->set_rules("email", "E-Posta Adresi", "required|trim|valid_email");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "valid_email" => "Lütfen geçerli vir <b>{field}</b> giriniz",
                "min_length" => "<b>{field}</b> en az <b>{param}</b> Karakter Olmalıdır",
                "max_length" => "<b>{field}</b> en fazla <b>{param}</b> Karakter Olmalıdır",
                "numeric" => "<b>{field}</b> sadece rakamlardan oluşmalı"
            )
        );
        $validate = $this->form_validation->run();
        if ($validate) {
            $insert = $this->Settings_model->add(
                array(
                    "sirket_adi" => $this->input->post("sirket_adi"), //1
                    "faaliyet" => $this->input->post("faaliyet"), //2
                    "vergi_no" => $this->input->post("vergi_no"), //3
                    "vergi_daire" => $this->input->post("vergi_daire"), //4
                    "adres" => $this->input->post("adres"), //5
                    "tel_no_1" => $this->input->post("tel_no_1"), //6
                    "tel_no_2" => $this->input->post("tel_no_2"), //7
                    "email" => $this->input->post("email"), //8
                    "KDV_oran" => $this->input->post("KDV_oran"), //9
                    "kdv_tevkifat_oran" => $this->input->post("kdv_tevkifat_oran"), //10
                    "damga_oran" => $this->input->post("damga_oran"), //11
                    "stopaj_oran" => $this->input->post("stopaj_oran"), //12
                    "para_birimi" => $this->input->post("para_birimi"), //13
                    "gecici" => $this->input->post("gecici"), //14
                    "teminat_turu" => $this->input->post("teminat_turu"), //15
                    "odeme_turu" => $this->input->post("odeme_turu"), //16
                    "meslek" => $this->input->post("meslek"), //17
                    "surec_durum" => durum_name($this->input->post("surec_durum")), //18
                    "department" => $this->input->post("department"), //20
                    "is_grubu" => $this->input->post("is_grubu"), //21
                    "sozlesme_turu" => $this->input->post("sozlesme_turu"), //22
                    "isin_turu" => $this->input->post("isin_turu"), //23
                    "sure_uzatim" => $this->input->post("sure_uzatim"), //24
                    "teminat_esas_isler" => $this->input->post("teminat_esas_isler"), //25
                    "bankalar" => $this->input->post("bankalar"), //26
                    "sozlesme_taraflari" => $this->input->post("sozlesme_taraflari"), //27
                    "teknik_cizim" => $this->input->post("teknik_cizim"), //28
                    "isg_main" => $this->input->post("isg_main"), //28
                    "units" => $this->input->post("units"), //28
                    "createdAt" => date("Y-m-d H:i:s") //29
                )
            );
            $insert_unique = $this->Settings_model->add_scheme(
                array(
                    "file_order" => $this->input->post("on_ek") . "-" . $this->input->post("son_ek"), //1
                    "module" => $this->Module_Name, //2
                    "createdAt" => date("Y-m-d H:i:s") //3
                )
            );
            
            if ($insert) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt başarılı bir şekilde eklendi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }
            redirect(base_url("settings"));
        } else {
    
        $viewData = new stdClass();
            
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->form_error = true;
            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
        // Başarılı ise
        // Kayit işlemi baslar
        // Başarısız ise
        // Hata ekranda gösterilir...
    }
    public function update($id)
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("sirket_adi", "Şirket Adı", "required|trim");
        $this->form_validation->set_rules("vergi_no", "Vergi No", "required|trim|min_length[10]|max_length[10]|numeric");
        $this->form_validation->set_rules("vergi_daire", "Vergi Dairesi", "required|trim");
        $this->form_validation->set_rules("email", "E-Posta Adresi", "required|trim|valid_email");
        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "valid_email" => "Lütfen geçerli vir <b>{field}</b> giriniz",
                "min_length" => "<b>{field}</b> en az <b>{param}</b> Karakter Olmalıdır",
                "max_length" => "<b>{field}</b> en fazla <b>{param}</b> Karakter Olmalıdır",
                "numeric" => "<b>{field}</b> sadece rakamlardan oluşmalı"
            )
        );
        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();
        if ($validate) {
            $data = array(
                "sirket_adi" => $this->input->post("sirket_adi"), //1
                "faaliyet" => $this->input->post("faaliyet"), //2
                "vergi_no" => $this->input->post("vergi_no"), //3
                "vergi_daire" => $this->input->post("vergi_daire"), //4
                "adres" => $this->input->post("adres"), //5
                "tel_no_1" => $this->input->post("tel_no_1"), //6
                "tel_no_2" => $this->input->post("tel_no_2"), //7
                "email" => $this->input->post("email"), //8
                "KDV_oran" => $this->input->post("KDV_oran"), //9
                "kdv_tevkifat_oran" => $this->input->post("kdv_tevkifat_oran"), //10
                "damga_oran" => $this->input->post("damga_oran"), //11
                "stopaj_oran" => $this->input->post("stopaj_oran"), //12
                "para_birimi" => $this->input->post("para_birimi"), //13
                "gecici" => $this->input->post("gecici"), //14
                "teminat_turu" => $this->input->post("teminat_turu"), //15
                "odeme_turu" => $this->input->post("odeme_turu"), //16
                "meslek" => $this->input->post("meslek"), //17
                "surec_durum" => durum_name($this->input->post("surec_durum")), //18
                "default_table" => $this->input->post("default_table"), //19
                "department" => $this->input->post("department"), //20
                "is_grubu" => $this->input->post("is_grubu"), //21
                "sozlesme_turu" => $this->input->post("sozlesme_turu"), //22
                "sure_uzatim" => $this->input->post("sure_uzatim"), //23
                "isin_turu" => $this->input->post("isin_turu"), //24
                "teminat_esas_isler" => $this->input->post("teminat_esas_isler"), //25
                "bankalar" => $this->input->post("bankalar"), //26
                "sigorta" => $this->input->post("sigorta"), //26
                "benzer_is" => $this->input->post("benzer_is"), //26
                "sozlesme_taraflari" => $this->input->post("sozlesme_taraflari"), //27
                "teknik_cizim" => $this->input->post("teknik_cizim"), //28
                "tesvik" => $this->input->post("tesvik"), //28
                "yeterlilik" => delete_comma_spaces($this->input->post("yeterlilik")), //28
                "updatedAt" => date("Y-m-d H:i:s"), //29
                "file_name_digits" => strlen($this->input->post("digits")), //30
                "member" => $this->input->post("member"), //30
                "harcama_tur" => $this->input->post("harcama_tur"), //30
                "odeme_tur" => $this->input->post("odeme_tur"), //30
                "belge_tur" => $this->input->post("belge_tur"), //30
                "units" => $this->input->post("units"), //30
                "theme_colour" => $this->input->post("theme_colour"), //28
                "theme_panelfold" => $this->input->post("theme_panelfold"), //28
            );
            $update = $this->Settings_model->update(array("id" => $id), $data);
            
            if ($update) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt başarılı bir şekilde güncellendi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Kayıt Güncelleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }
            redirect(base_url("settings"));
        } else {
    
        $viewData = new stdClass();
            
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "display";
            $viewData->form_error = true;
            
            $viewData->item = $this->Settings_model->get(
                array(
                    "id" => $id,
                )
            );
            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }
    public function update_form($id)
    {
        $viewData = new stdClass();
        
        $item = $this->Settings_model->get(
            array(
                "id" => $id,
            )
        );
        $main_groups = $item->main_groups;
        
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "display";
        $viewData->item = $item;
        $viewData->main_groups = $main_groups;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function update_default_group()
    {
      echo "burda";
    }
}
