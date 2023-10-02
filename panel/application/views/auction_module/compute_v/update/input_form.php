<?php $proje_id = get_from_id("auction", "proje_id", $item->auction_id); ?>
<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Metraj Grubu</div>
            <select style="width: 100%" id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("metraj_grup"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="metraj_grup">
                <option selected value="<?php echo isset($form_error) ? set_value("metraj_grup") : $item->metraj_grup; ?>"><?php echo isset($form_error) ? set_value("metraj_grup") : $item->metraj_grup; ?></option>
                <?php
                $teknik_cizimler = str_getcsv($settings->teknik_cizim);
                foreach ($teknik_cizimler as $teknik_cizim) {
                    echo "<option value='$teknik_cizim'>$teknik_cizim</option>";
                }
                ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("metraj_grup"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">Metraj Ad</div>
            <input class="form-control <?php cms_isset(form_error("metraj_ad"), "is-invalid", ""); ?>"
                   placeholder="Avan, Revizyon, Onaylı Vs."
                   name="metraj_ad"
                   value="<?php echo isset($form_error) ? set_value("metraj_ad") : $item->metraj_ad; ?>"/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("metraj_ad"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">Onay</div>
            <select style="width: 100%" id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("onay"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="onay">
                <option selected="selected"
                <option value="<?php echo isset($form_error) ? set_value("onay") : $item->onay; ?>"><?php echo isset($form_error) ? set_value("onay") :  full_name($item->onay); ?></option>

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
            <textarea class="form-control" name="aciklama"
                      placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : $item->aciklama; ?></textarea>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>


