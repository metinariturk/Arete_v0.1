<?php print_r(validation_errors()); ?>
<h3 class="text-center">
    Personel Güncelle
</h3>
<?php if (isset($worker)) { ?>
    <form id="update_form"
          action="<?php echo base_url("$this->Module_Name/update_personel/$worker->id/$item->id"); ?>"
          method="post"
          enctype="multipart/form-data"
          autocomplete="off">
        <div class="mb-3">
            <label for="name_surname" class="form-label">Ad Soyad:</label>
            <input type="text" class="form-control" name="name_surname"
                   value="<?php if (isset($worker)) {
                       echo $worker->name_surname;
                   } ?>"
                   placeholder="Adınız ve Soyadınız">
        </div>
        <div class="mb-3">
            <label for="group" class="form-label">Meslek:</label>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control <?php cms_isset(form_error("group"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="group">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("group") : $worker->group; ?>"> <?php echo isset($form_error) ? group_name(set_value("group")) : group_name($worker->group); ?>
                </option>
                <?php foreach ($workgroups as $active_workgroup => $workgroups) {
                    foreach ($workgroups as $workgroup) { ?>
                        <option value="<?php echo $workgroup; ?>"> <?php echo group_name($workgroup); ?></option>
                    <?php } ?>
                <?php } ?>

            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("group"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="social_id" class="form-label">TC Kimlik No:</label>
            <input type="number"
                   class="form-control <?php cms_isset(form_error("social_id"), "is-invalid", ""); ?>"
                   name="social_id"
                   placeholder="TC Kimlik No"
                   value="<?php echo isset($form_error) ? set_value("social_id") : "$worker->social_id"; ?>">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("social_id"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="bank" class="form-label">Banka Adı:</label>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control <?php cms_isset(form_error("bank"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="bank">
                <option selected="selected"> <?php echo isset($form_error) ? (set_value("bank")) : $worker->bank; ?></option>
                <?php $banks = get_as_array($settings->bankalar);
                foreach ($banks as $bank) { ?>
                    <option><?php echo $bank; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("bank"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="IBAN" class="form-label">Banka Hesap No:</label>
            <input class="form-control <?php cms_isset(form_error("IBAN"), "is-invalid", ""); ?>"
                   name="IBAN"
                   placeholder="IBAN"
                   value="<?php echo isset($form_error) ? set_value("IBAN") : "$worker->IBAN"; ?>">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("IBAN"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Giriş Tarihi:</label>
            <input class="datepicker-here form-control digits <?php cms_isset(form_error("start_date"), "is-invalid", ""); ?>"
                   type="text"
                   name="start_date"
                   value="<?php echo isset($form_error) ? set_value("start_date") : dateFormat('d-m-Y', $worker->start_date); ?>"
                   data-options="{ format: 'DD-MM-YYYY' }"
                   data-language="tr">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("start_date"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">Çıkış Tarihi:</label>
            <input class="datepicker-here form-control digits <?php cms_isset(form_error("end_date"), "is-invalid", ""); ?>"
                   type="text"
                   name="end_date"
                <?php if (!empty($worker->end_date)) { ?>
                    value="<?php echo isset($form_error) ? set_value("end_date") : dateFormat('d-m-Y', $worker->end_date); ?>"
                <?php } else { ?>
                    value="<?php echo isset($form_error) ? set_value("end_date") : "" ?>"
                <?php } ?>
                   data-options="{ format: 'DD-MM-YYYY' }"
                   data-language="tr">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("end_date"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <a class="btn btn-success" onclick="updatePersonel(this)" form_id="update_form" url="<?php echo base_url("$this->Module_Name/update_personel/$worker->id/$item->id"); ?>">
                <i class="menu-icon fa fa-floppy-o fa-lg" aria-hidden="true"></i> Güncelle
            </a>
        </div>
    </form>
<?php } ?>


