<div class="row">
    <div class="col-md-6">
        <div class="mb-2">
            <div class="col-form-label">Şantiye Kodu</div>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">SNT</span>
                <?php if (!empty(get_last_fn("site"))) { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                           data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("site"); ?>">
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
                        : <?php echo increase_code_suffix("site"); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Bağlı Olduğu Sözleşme</div>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control <?php cms_isset(form_error("sozlesme_turu"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="contract_id">
                <option selected="selected"
                        value="0">Sözleşmesiz
                </option>
                <?php
                foreach ($contracts as $contract) { ?>
                    <option value="<?php echo $contract->id; ?>"><?php echo contract_name($contract->id); ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("contract_id"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Şantiye Adı</div>
            <input type="text"
                   class="form-control <?php cms_isset(form_error("santiye_ad"), "is-invalid", ""); ?>"
                   placeholder="Şantiye Adı"
                   value="<?php echo isset($form_error) ? set_value("santiye_ad") : ""; ?>"
                   name="santiye_ad">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("santiye_ad"); ?></div>
            <?php } ?>
        </div>

    </div>
    <div class="col-md-6">
        <div class="mb-2">
            <div class="col-form-label">Şantiye Şefi</div>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control <?php cms_isset(form_error("santiye_sefi"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="santiye_sefi">
                <option selected
                        value="<?php echo isset($form_error) ? set_value("santiye_sefi") : ""; ?>"><?php echo isset($form_error) ? full_name(set_value("santiye_sefi")) : "Seçiniz"; ?></option>
                <?php
                foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo full_name($user->id); ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("santiye_sefi"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Yetkili Personeller</div>
            <select class="js-example-placeholder-multiple col-sm-12  <?php cms_isset(form_error("teknik_personeller"), "is-invalid", ""); ?>"
                    multiple="multiple" name="teknik_personeller[]" multiple
                    data-options="{ tags: true, tokenSeparators: [',', ' '] }">
                <?php if (isset($form_error)) { ?>
                    <?php $returns = set_value("teknik_personeller[]");
                    foreach ($returns as $return) { ?>
                        <option selected
                                value="<?php echo $return; ?>"><?php echo full_name($return); ?></option>
                    <?php } ?>
                <?php } ?>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo $user->name . " " . $user->surname; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("teknik_personeller"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Şantiye Araçları</div>
            <select class="js-example-placeholder-multiple col-sm-12 <?php cms_isset(form_error("araclar"), "is-invalid", ""); ?>"
                    multiple="multiple" name="araclar[]" multiple
                    data-options="{ tags: true, tokenSeparators: [',', ' '] }">
                <?php if (isset($form_error)) { ?>
                    <?php $returns = set_value("araclar[]");
                    foreach ($returns as $return) { ?>
                        <option selected
                                value="<?php echo $return; ?>"><?php echo vehicle_plate($return); ?></option>
                    <?php } ?>
                <?php } ?>
                <?php foreach ($vehicles as $vehicle) { ?>
                    <option value="<?php echo $vehicle->id; ?>"><?php echo $vehicle->plaka . "-" . $vehicle->marka . "-" . $vehicle->ticari_ad; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("araclar"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>
