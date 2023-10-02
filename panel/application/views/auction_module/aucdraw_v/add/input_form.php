<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Dosya No</div>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">ITD</span>
                <?php if (!empty(get_last_fn("aucdraw"))) { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                           data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("aucdraw"); ?>">
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
                        : <?php echo increase_code_suffix("aucdraw"); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Teknik Çizim Grubu</div>
            <select style="width: 100%" id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("cizim_grup"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="cizim_grup">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("cizim_grup") : ""; ?>"><?php echo isset($form_error) ? set_value("cizim_grup") : "Seçiniz"; ?></option>

                <?php
                $teknik_cizimler = str_getcsv($settings->teknik_cizim);
                foreach ($teknik_cizimler as $teknik_cizim) {
                    echo "<option value='$teknik_cizim'>$teknik_cizim</option>";
                }
                ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("cizim_grup"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">Çizim Ad</div>
            <input class="form-control <?php cms_isset(form_error("cizim_ad"), "is-invalid", ""); ?>"
                   placeholder="Avan, Revizyon, Onaylı Vs."
                   name="cizim_ad"
                   value="<?php echo isset($form_error) ? set_value("cizim_ad") : ""; ?>"/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("cizim_ad"); ?></div>
            <?php } ?>
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
                      placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."></textarea>

            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>
