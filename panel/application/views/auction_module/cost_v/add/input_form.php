
<?php $proje_id = get_from_id("auction", "proje_id", $auc_id); ?>
<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Dosya No</div>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">YM</span>
                <?php if (!empty(get_last_fn("cost"))) { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                           data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("cost"); ?>">
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
                        : <?php echo increase_code_suffix("cost"); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Yaklaşık Maliyet Grubu</div>
            <select style="width: 100%" id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("ym_grup"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="ym_grup">
                <option value="<?php echo isset($form_error) ? set_value("ym_grup") : ""; ?>"><?php echo isset($form_error) ? set_value("ym_grup") : ""; ?></option>
                <?php
                $teknik_cizimler = str_getcsv($settings->teknik_cizim);
                foreach ($teknik_cizimler as $teknik_cizim) {
                    echo "<option value='$teknik_cizim'>$teknik_cizim</option>";
                }
                ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("ym_grup"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">Yaklaşık Maliyet Ad</div>
            <input class="form-control <?php cms_isset(form_error("ym_ad"), "is-invalid", ""); ?>"
                   placeholder="Teklif Alma, Sıhhi Tesisar, Mukayese vs."
                   name="ym_ad"
                   value="<?php echo isset($form_error) ? set_value("ym_ad") : ""; ?>"/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("ym_ad"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">Kapsadığı Pozlar</div>
            <input type="text" name="poz_no" data-plugin="tagsinput"
                   data-role="tagsinput" style="  width: 100%;
  max-width: 100%;  "
                   placeholder="Poz Ekleyin.."
                   value="<?php echo isset($form_error) ? set_value("poz_no") : ""; ?>"
            />
        </div>

        <div class="mb-2">
            <div class="col-form-label">Yaklaşık Maliyet</div>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend"><?php echo get_currency_auc($auc_id); ?></span>
                <input type="number" min="1" step="any"
                       class="form-control <?php cms_isset(form_error("cost"), "is-invalid", ""); ?>"
                       name="cost"
                       value="<?php echo isset($form_error) ? set_value("cost") : ""; ?>">
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("cost"); ?></div>
                <?php } ?>
            </div>

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
    </div>
</div>

