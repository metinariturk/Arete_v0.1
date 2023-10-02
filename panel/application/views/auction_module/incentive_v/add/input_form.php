<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Dosya No</div>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">TES</span>
                <?php if (!empty(get_last_fn("incentive"))) { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                           data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("incentive"); ?>">
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
                        : <?php echo increase_code_suffix("incentive"); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Teşvik Grubu</div>
            <select style="width: 100%" id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("tesvik_grup"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="tesvik_grup">
                <option value="<?php echo isset($form_error) ? set_value("tesvik_grup") : ""; ?>"><?php echo isset($form_error) ? set_value("tesvik_grup") : ""; ?></option>
                <?php
                $tesvik_grupler = str_getcsv($settings->tesvik);
                foreach ($tesvik_grupler as $tesvik_grup) {
                    echo "<option value='$tesvik_grup'>$tesvik_grup</option>";
                }
                ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("tesvik_grup"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Teşvik/Hibe Veren Kurum</div>
            <input class="form-control <?php cms_isset(form_error("tesvik_kurum"), "is-invalid", ""); ?>"
                   placeholder="Teşvik Veren Kurum Adı"
                   name="tesvik_kurum"
                   value="<?php echo isset($form_error) ? set_value("tesvik_kurum") : ""; ?>"/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("tesvik_kurum"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Teşvik Kapsamı</div>
            <textarea class="form-control <?php cms_isset(form_error("kapsam"), "is-invalid", ""); ?>"
                      name="kapsam"
                      placeholder="Teşvik Kapsamı"></textarea>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("kapsam"); ?></div>
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

