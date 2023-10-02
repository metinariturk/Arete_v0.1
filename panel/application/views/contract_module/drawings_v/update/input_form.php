<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Teknik Doküman Grubu</div>
            <select style="width: 100%" id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("cizim_grup"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="cizim_grup">
                <option value="<?php echo isset($form_error) ? set_value("cizim_grup") : $item->cizim_grup; ?>"><?php echo isset($form_error) ? set_value("cizim_grup") : $item->cizim_grup; ?></option>
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
            <div class="col-form-label">Doküman Ad</div>

            <input class="form-control <?php cms_isset(form_error("cizim_ad"), "is-invalid", ""); ?>"
                   placeholder="Avan, Revizyon, Onaylı Vs."
                   name="cizim_ad"
                   value="<?php echo isset($form_error) ? set_value("cizim_ad") : $item->cizim_ad; ?>"/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("cizim_ad"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">Onaylayan Yetkili</div>
            <select id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("onay"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="onay">
                <option value="<?php echo isset($form_error) ? set_value("onay") : $item->onay; ?>"><?php echo isset($form_error) ? full_name(set_value("onay")) : full_name($item->onay); ?></option>
                <?php foreach ($system_users as $system_user) { ?>
                    <option value="<?php echo $system_user->id; ?>"><?php echo full_name($system_user->id); ?></option>
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
                      placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : "$item->aciklama"; ?></textarea>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>