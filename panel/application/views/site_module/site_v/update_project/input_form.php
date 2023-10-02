<div class="row">
    <div class="col-md-6">
        <div class="mb-2">
            <div class="col-form-label">Bağlı Olduğu Sözleşme</div>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control <?php cms_isset(form_error("contract_id"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="contract_id">
                <option selected="selected"
                        value="<?php echo $item->contract_id; ?>"><?php echo contract_name($item->contract_id); ?>
                </option>
                <?php
                foreach ($active_conn_contracts as $contract) { ?>
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
                   value="<?php echo isset($form_error) ? set_value("santiye_ad") : "$item->santiye_ad"; ?>"
                   name="santiye_ad">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("santiye_ad"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Şantiye Şefi</div>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control <?php cms_isset(form_error("santiye_sefi"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="santiye_sefi">
                <option selected
                        value="<?php echo isset($form_error) ? set_value("santiye_sefi") : $item->santiye_sefi; ?>"><?php echo isset($form_error) ? full_name(set_value("santiye_sefi")) : full_name($item->santiye_sefi); ?></option>
                <?php
                foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo full_name($user->id); ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("santiye_sefi"); ?></div>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-2">
            <div class="col-form-label">Yetkili Personeller</div>
            <select class="js-example-basic-multiple col-sm-12 <?php cms_isset(form_error("teknik_personel"), "is-invalid", ""); ?> "
                    multiple="multiple" name="teknik_personel[]"
                    data-options="{ tags: true, tokenSeparators: [',', ' '] }"">
            <?php
            if (!empty($item->teknik_personel)) { ?>
                <?php $yetkililer = get_as_array($item->teknik_personel);
                foreach ($yetkililer as $yetkili) { ?>
                    <option selected='selected'
                            value='<?php echo $yetkili; ?>'><?php echo full_name($yetkili); ?></option>";
                <?php } ?>
            <?php } ?>
            <?php if (isset($form_error)) { ?>
                <?php $returns = set_value("teknik_personel[]");
                foreach ($returns as $return) { ?>
                    <option selected value="<?php echo $return; ?>"><?php echo full_name($return); ?></option>
                <?php } ?>
            <?php } ?>
            <?php foreach ($users as $user) { ?>
                <option value="<?php echo $user->id; ?>"><?php echo $user->name . " " . $user->surname; ?></option>
            <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("teknik_personel"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Şantiye Araçları</div>
            <select class="js-example-placeholder-multiple col-sm-12 <?php cms_isset(form_error("araclar"), "is-invalid", ""); ?>"
                    multiple="multiple" name="araclar[]" multiple
                    data-options="{ tags: true, tokenSeparators: [',', ' '] }">
                <?php
                if (!empty($item->araclar)) { ?>
                    <?php $araclar = get_as_array($item->araclar);
                    foreach ($araclar as $arac) { ?>
                        <option selected='selected'
                                value='<?php echo $arac; ?>'><?php echo vehicle_plate($arac); ?></option>";
                    <?php } ?>
                <?php } ?>
                <?php if (isset($form_error)) { ?>
                    <?php $returns = set_value("araclar[]");
                    foreach ($return_vehicles as $return_vehicle) { ?>
                        <option selected value="<?php echo $return_vehicle; ?>"><?php echo vehicle_plate($return_vehicle); ?></option>
                    <?php } ?>
                <?php } ?>
                <?php foreach ($vehicles as $vehicle) { ?>
                    <option value="<?php echo $vehicle->id; ?>"><?php echo vehicle_plate($vehicle->id); ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("araclar"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>
<?php echo validation_errors(); ?>
