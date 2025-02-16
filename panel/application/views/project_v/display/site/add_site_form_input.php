
<div class="mb-2">
    <div class="col-form-label">Bağlı Olduğu Sözleşme</div>
    <select id="select2-demo-1" style="width: 100%;"
            class="form-control <?php cms_isset(form_error("sozlesme_turu"), "is-invalid", ""); ?>"
            data-plugin="select2"
            name="contract_id">
        <option value="0">Sözleşmesiz</option>


        <?php foreach ($main_contracts as $main_contract) { ?>
            <option value="<?php echo $main_contract->id; ?>"><?php echo contract_name($main_contract->id); ?></option>
        <?php } ?>
    </select>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("contract_id"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Şantiye Adı - <?php echo $next_site_name; ?></div>
    <input type="text"
           class="form-control <?php cms_isset(form_error("santiye_ad"), "is-invalid", ""); ?>"
           placeholder="Şantiye Adı"
           value="<?php echo isset($form_error) ? set_value("santiye_ad") : ""; ?>"
           name="santiye_ad">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("santiye_ad"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Şantiye Şefi/Sorumlusu</div>
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
    <select id="teknik_personeller"
            class="js-choices-multiple col-sm-12 <?php cms_isset(form_error("teknik_personeller"), "is-invalid", ""); ?>"
            name="teknik_personeller[]" multiple>

        <?php
        // Eğer form hatası varsa eski seçilen değerleri al
        $selected_values = isset($form_error) ? set_value("teknik_personeller[]") : [];
        ?>

        <?php foreach ($users as $user) { ?>
            <option value="<?php echo $user->id; ?>"
                <?php echo (!empty($selected_values) && in_array($user->id, $selected_values)) ? 'selected' : ''; ?>>
                <?php echo $user->name . " " . $user->surname; ?>
            </option>
        <?php } ?>
    </select>

    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("teknik_personeller"); ?></div>
    <?php } ?>
</div>