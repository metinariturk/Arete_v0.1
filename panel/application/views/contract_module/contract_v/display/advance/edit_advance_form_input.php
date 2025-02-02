<div class="mb-2">
    <div class="col-form-label">Avans Ödeme Tarihi</div>
    <input class="flatpickr form-control <?php cms_isset(form_error("avans_tarih"), "is-invalid", ""); ?>"
           type="text"
           name="avans_tarih"
           value="<?php echo isset($form_error) ? set_value("avans_tarih") : dateFormat_dmy($edit_advance->avans_tarih); ?>"
    >
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("avans_tarih"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Avans Türü</div>
    <select id="select2-demo-1" style="width: 100%;"
            class="form-control <?php cms_isset(form_error("avans_turu"), "is-invalid", ""); ?>"
            data-plugin="select2" name="avans_turu">
        <option selected="selected"
                value="<?php echo isset($form_error) ? set_value("avans_turu") : $edit_advance->avans_turu; ?>"><?php echo isset($form_error) ? set_value("avans_turu") : $edit_advance->avans_turu; ?>
        </option>
        <?php $odeme_turleri = get_as_array($settings->odeme_turu);
        foreach ($odeme_turleri as $odeme_turu) {
            echo "<option value='$odeme_turu'>$odeme_turu</option>";
        } ?>
    </select>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("avans_turu"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Avans Tutar</div>
    <?php if (isset($form_error)) { ?>
        <?php
        // Avans miktarı alanı boş değilse ve sözleşme bedelinden fazla girildiyse kontrol yap
        if (!empty(set_value("avans_miktar")) && form_error("avans_miktar")) { ?>
            <div style="color: red">
                *** Sözleşme bedelinden fazla avans ödemesi yapılamaz. Özel bir gerekçe ile fazla
                avans ödemesi yapılması gerekiyorsa aşağıdaki onay kutusunu işaretleyiniz.
                <br>
                <input name="onay" type="checkbox" id="cb-10"> Sözleşme bedelinden fazla tahsilat
                yapmak istiyorum!
            </div>
        <?php } ?>
    <?php } ?>
    <input id="avans_miktar"
           class="form-control <?php cms_isset(form_error("avans_miktar"), "is-invalid", ""); ?>"
           name="avans_miktar"
           placeholder="Avans Tutar"
           value="<?php echo isset($form_error) ? set_value("avans_miktar") : $edit_advance->avans_miktar; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("avans_miktar"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Vade Tarihi</div>
    <input class="flatpickr form-control <?php cms_isset(form_error("vade_tarih"), "is-invalid", ""); ?>"
           type="text"
           name="vade_tarih"
           value="<?php echo isset($form_error) ? set_value("vade_tarih") : dateFormat_dmy($edit_advance->vade_tarih); ?>"
    >
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("vade_tarih"); ?></div>
    <?php } ?>

</div>
<div class="mb-2">
    <div class="col-form-label">Açıklama</div>
    <textarea class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", ""); ?>"
              name="aciklama"
              placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : $edit_advance->aciklama; ?></textarea>

    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
    <?php } ?>
</div>
<?php
$file_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Advance/$edit_advance->id";

if (!is_dir($file_path)) {
    mkdir($file_path, 0777, true);
}

$files = glob("$file_path/*"); // glob ile tüm dosyaları al
?>
<div class="mb-2">
    <label class="col-form-label">Yüklenen Dosyalar</label>
    <div class="list-group">
        <?php foreach ($files as $file): ?>
            <?php
            // Dosya adını kısalt
            $filename = basename($file);
            $short_filename = strlen($filename) > 40 ? substr($filename, 0, 40) . '...' : $filename;
            ?>
            <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        <?php echo ext_img($file); // Dosya simgesi ?>
                    </div>
                    <div>
                        <!-- Kısaltılmış dosya adı -->
                        <p class="mb-0 small" title="<?php echo $filename; ?>">
                            <?php echo $short_filename; ?>
                        </p>
                    </div>
                </div>
                <div>
                    <a href="<?php echo base_url('contract/download_file/' . urlencode(base64_encode($file))); ?>">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>
                    <!-- Silme butonu: Dosya yolunu gönderecek -->
                    <a href="#"
                       onclick="deleteFile('<?php echo urlencode(base64_encode($file)); ?>')">
                        <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                           aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div id="file-upload-container" class="mb-3">
    <label class="col-form-label" for="file-input">Dosya Yükle:</label>
    <input class="form-control" name="file" id="file-input" type="file">
</div>