<div class="row">
    <div class="col-md-6">
        <div class="mb-2">
            <div class="col-form-label">Şantiye Kodu</div>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">SNT</span>
                <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                       type="number" placeholder="Dosya No" aria-describedby="inputGroupPrepend"
                       required="" data-bs-original-title="" title="" name="dosya_no" readonly
                       value="<?php echo isset($form_error) ? set_value("dosya_no") : $next_file_name ?>">

                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("dosya_no"); ?></div>
                <?php } ?>
            </div>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Bağlı Olduğu Sözleşme</div>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control <?php cms_isset(form_error("sozlesme_turu"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="contract_id">
                <?php foreach ($contracts as $contract) { ?>
                    <option value="<?php echo $contract->id; ?>"><?php echo contract_name($contract->id); ?></option>
                <?php } ?>
                <option value="0">Sözleşmesiz
                </option>
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
            <div class="col-form-label">Şantiye Sorumlusu</div>
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
    </div>
</div>
