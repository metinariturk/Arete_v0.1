function edit_bond($bond_id)
{
if (!isAdmin()) {
redirect(base_url("error"));
}

$this->load->model("Contract_model");
$this->load->model("Settings_model");

$edit_bond = $this->Bond_model->get(array("id" => $bond_id));
$item = $this->Contract_model->get(array("id" => $edit_bond->contract_id));
$project = $this->Project_model->get(array("id" => $item->proje_id));
$settings = $this->Settings_model->get();
$bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");

$viewData = new stdClass();

$viewData->viewModule = $this->moduleFolder;
$viewData->viewFolder = "contract_v";
$viewData->subViewFolder = "display";

$viewData->project = $project;
$viewData->bonds = $bonds;
$viewData->settings = $settings;
$viewData->item = $item;

$this->load->library("form_validation");

$contract_price = $item->sozlesme_bedel;
$sozlesme_tarih = dateFormat_dmy($item->sozlesme_tarih);

$this->form_validation->set_rules("tahsilat_tarih", "Tahsilat Tarihi", "callback_contract_bond[$sozlesme_tarih]|required|trim");
$this->form_validation->set_rules("tahsilat_turu", "Tahsilat Türü", "required|trim");

if (!empty($this->input->post('vade_tarih'))) {
$this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_bond[$sozlesme_tarih]|trim");
}

if ($this->input->post('tahsilat_turu') == "Çek") {
$this->form_validation->set_rules("vade_tarih", "Vade Tarihi", "callback_contract_bond[$sozlesme_tarih]|trim|required");
}

$this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|numeric|required|trim");

if ($this->input->post('onay') != "on") {
$this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|less_than_equal_to[$contract_price]|numeric|trim");
} else {
$this->form_validation->set_rules("tahsilat_miktar", "Tahsilat Miktarı", "required|numeric|required|trim");
}
$this->form_validation->set_rules("aciklama", "Açıklama", "required|trim");

$this->form_validation->set_message(
array(
"required" => "<b>{field}</b> alanı doldurulmalıdır",
"less_than_equal_to" => "<b>{field}</b> <b>{param}</b> 'den küçük olmalıdır",
"is_natural" => "<b>{field}</b> netural alanı rakamlardan oluşmalıdır",
"numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
"contract_bond" => "<b>{field}</b> sözleşme tarihi olan <b>{param}</b> tarhihinden önce olamaz",
)
);

// Form Validation Calistirilir..
$validate = $this->form_validation->run();

if ($validate) {

$path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Bond";

if ($this->input->post("tahsilat_tarih")) {
$tahsilat_tarihi = dateFormat('Y-m-d', $this->input->post("tahsilat_tarih"));
} else {
$tahsilat_tarihi = null;
}
if ($this->input->post("vade_tarih")) {
$vade_tarihi = dateFormat('Y-m-d', $this->input->post("vade_tarih"));
} else {
$vade_tarihi = null;
}

$update = $this->Bond_model->update(
array(
"id" => $bond_id
),
array(
"tahsilat_tarih" => $tahsilat_tarihi,
"vade_tarih" => $vade_tarihi,
"tahsilat_miktar" => $this->input->post("tahsilat_miktar"),
"tahsilat_turu" => $this->input->post("tahsilat_turu"),
"aciklama" => $this->input->post("aciklama"),
)
);

// Yükleme yapılacak dosya yolu oluşturuluyor
$path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Bond/$bond_id";
// Dosya yolu mevcut değilse, yeni bir klasör oluşturuluyor
if (!is_dir($path)) {
mkdir("$path", 0777, TRUE);
}

$file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);


// Yükleme ayarları belirleniyor
$config["allowed_types"] = "*"; // Her tür dosya yüklemeye izin veriliyor
$config["upload_path"] = "$path"; // Dosya yolu belirleniyor
$config["file_name"] = $file_name; // Dosya adı kaydın ID'si olarak belirleniyor
$config["max_size"] = 10000; // Maksimum dosya boyutu 10 MB (10000 KB)

// Yükleme kütüphanesi yükleniyor
$this->load->library("upload", $config);


// Dosya yükleme işlemi
if (!$this->upload->do_upload("file")) {
// Yükleme başarısız olduysa hata mesajı döndürülüyor
$error = $this->upload->display_errors();
} else {
// Yükleme başarılıysa devam eden işlemler
$data = $this->upload->data();
}

$edit_bond = $this->Bond_model->get(array("id" => $bond_id));
$item = $this->Contract_model->get(array("id" => $edit_bond->contract_id));
$project = $this->Project_model->get(array("id" => $item->proje_id));
$settings = $this->Settings_model->get();
$bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");

$viewData = new stdClass();

$viewData->viewModule = $this->moduleFolder;
$viewData->viewFolder = "contract_v";
$viewData->subViewFolder = "display";

$viewData->project = $project;
$viewData->bonds = $bonds;
$viewData->settings = $settings;
$viewData->item = $item;

$this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_4_c_bond", $viewData);

//kaydedilen elemanın id nosunu döküman ekleme
// sına post ediyoruz

} else {

$edit_bond = $this->Bond_model->get(array("id" => $bond_id));
$item = $this->Contract_model->get(array("id" => $edit_bond->contract_id));
$project = $this->Project_model->get(array("id" => $item->proje_id));
$settings = $this->Settings_model->get();
$bonds = $this->Bond_model->get_all(array('contract_id' => $item->id), "tahsilat_tarih ASC");

$viewData = new stdClass();

$viewData->viewModule = $this->moduleFolder;
$viewData->viewFolder = "contract_v";
$viewData->subViewFolder = "display";

$viewData->edit_bond = $edit_bond;
$viewData->project = $project;
$viewData->bonds = $bonds;
$viewData->settings = $settings;
$viewData->item = $item;

$viewData->form_error = true;
$viewData->error_modal = "EditBondModal"; // Hata modali için set edilen değişken

if (!empty($form_errors)) {
$viewData->form_errors = $form_errors;
} else {
$viewData->form_errors = null;
}

$this->load->view("{$viewData->viewModule}/contract_v/display/tabs/tab_4_c_bond", $viewData);

}
}