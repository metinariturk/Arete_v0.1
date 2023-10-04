<?php $proje_id = get_from_id("auction", "proje_id", $auc_id); ?>
<?php if (empty($notice_id)){
    $title = "Teklif";
} else {
    $title = "Zeyilname";
} ?>
<div class="card">
    <div class="card-header">
        <div class="col-9">
            <h6 class="mb-0">
                <a href="<?php echo base_url("project/file_form/$proje_id"); ?>">
                    <?php echo project_code($proje_id); ?>
                    / <?php echo project_name($proje_id); ?>
                </a>
                <a href="<?php echo base_url("auction/file_form/$auc_id"); ?>">
                    <p class="mb-0">
                        <?php echo auction_code($auc_id); ?>
                        / <?php echo auction_name($auc_id); ?>
                    </p>
                </a>
            </h6>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Dosya No</div>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">YYN</span>
                <?php if (!empty(get_last_fn("notice"))) { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                           data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("notice"); ?>">
                    <?php
                } else { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Username" aria-describedby="inputGroupPrepend"
                           required="" data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : fill_empty_digits() . "1" ?>">
                <?php } ?>

                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("dosya_no"); ?></div>
                    <div class="invalid-feedback">* Önerilen Proje Kodu
                        : <?php echo increase_code_suffix("notice"); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="mb-2">
            <div class="col-form-label"><?php echo $title; ?> İlan Tarihi</div>
            <input class="datepicker-here form-control digits <?php cms_isset(form_error("ilan_tarih"), "is-invalid", ""); ?>"
                   type="text"
                   name="ilan_tarih"
                   value="<?php echo isset($form_error) ? set_value("ilan_tarih") : ""; ?>"
                   data-options="{ format: 'DD-MM-YYYY' }"
                   data-language="tr">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("ilan_tarih"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">Yayından Kalkacağı Tarih</div>
            <input class="datepicker-here form-control digits <?php cms_isset(form_error("son_tarih"), "is-invalid", ""); ?>"
                   type="text"
                   name="son_tarih"
                   value="<?php echo isset($form_error) ? set_value("son_tarih") : ""; ?>"
                   data-options="{ format: 'DD-MM-YYYY' }"
                   data-language="tr">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("son_tarih"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">İlan Yayın Süresi</div>

            <?php if (isset($form_error)) { ?>
                <?php if (!empty(form_error("aski_sure"))) { ?>
                    <br>
                    <input name="control" type="checkbox" id="cb-10"> <strong><i><?php echo $title; ?> Askı Süresini Kontrol
                            Ettim</i></strong>
                <?php } ?>
            <?php } ?>

            <input type="number" min="1" step="any"
                   class="form-control <?php cms_isset(form_error("aski_sure"), "is-invalid", ""); ?>"
                   name="aski_sure"
                   value="<?php echo isset($form_error) ? set_value("aski_sure") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aski_sure"); ?></div>
            <?php } ?>
        </div>



        <div class="mb-2">
            <div class="col-form-label">Otomatik Yayınlama</div>
            <input name="auto_air" type="checkbox"
                   <?php if (set_value("auto_air") == "on") {
                    echo "checked";
                } elseif (set_value("auto_air") == null) {
                    echo null;
                }
                ?>
                   id="cb-10"> <strong><i>Yayın Tarihinde Otomatik Olarak
                    Yayınlansın</i></strong><br>
            <input name="auto_cancel_air" type="checkbox"
                <?php if (set_value("auto_cancel_air") == "on") {
                    echo "checked";
                } elseif (set_value("auto_cancel_air") == null) {
                    echo null;
                }
                ?>
                   id="cb-10"> <strong><i>Dosya Toplama Tarihinde
                    Otomatik
                    Olarak Yayından Kalksın</i></strong>
        </div>


        <div class="mb-2">
            <div class="col-form-label">Onay</div>
            <select style="width: 100%" id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("onay"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="onay">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("onay") : ""; ?>"><?php echo isset($form_error) ? full_name(set_value("onay")) : "Seçiniz"; ?></option>

                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo full_name($user->id); ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("onay"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">Açıklama</div>
            <textarea class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", ""); ?>"
                      name="aciklama"
                      placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : ""; ?></textarea>

            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">İletişim</div>

            <textarea
                    class="form-control <?php cms_isset(form_error("iletisim"), "is-invalid", ""); ?>"
                      name="iletisim"
                      placeholder="<?php echo $title; ?> Detayları İçin İletişim Bilgileri"><?php echo isset($form_error) ? set_value("iletisim") : ""; ?></textarea>

            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("iletisim"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>


