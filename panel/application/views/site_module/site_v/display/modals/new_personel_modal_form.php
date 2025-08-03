<form id="addPersonelForm"
      data-form-url="<?php echo base_url("Site/add_personel/$item->id"); ?>"
      method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="mb-3">
        <label class="col-form-label" for="name_surname">Adı Soyadı:</label>
        <input id="name_surname" type="text"
               class="form-control <?php cms_isset(form_error("name_surname"), "is-invalid", ""); ?>"
               name="name_surname" value="<?php echo set_value('name_surname'); ?>"
               placeholder="Adı Soyadı">
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error('name_surname'); ?></div>
        <?php } ?>
    </div>

    <div class="mb-3">
        <label class="col-form-label" for="social_id">TC Kimlik No:</label>
        <input id="social_id" type="text"
               class="form-control <?php cms_isset(form_error("social_id"), "is-invalid", ""); ?>"
               name="social_id" maxlength="11" minlength="11"
               pattern="[0-9]{11}"
               placeholder="TC NO"
               value="<?php echo set_value('social_id'); ?>">
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error('social_id'); ?></div>
        <?php } ?>
    </div>


    <!-- Tarih -->
    <div class="mb-3">
        <label for="start_date" class="form-label">Giriş Tarihi:</label>
        <input type="date" name="start_date" id="start_date"
               value="<?php echo date(set_value('start_date')); ?>"
               class="form-control <?php cms_isset(form_error("start_date"), "is-invalid", ""); ?>">
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error('start_date'); ?></div>
        <?php } ?>
    </div>
    <div class="mb-3">
        <label class="col-form-label" for="group">Meslek:</label>
        <select id="select2-demo-profession" style="width: 100%;"
                class="form-control <?php cms_isset(form_error("group"), "is-invalid", ""); ?>"
                data-plugin="select2" name="group">
            <?php if (isset($form_error)) { ?>
                <option selected
                        value="<?php echo set_value('group'); ?>"><?php echo(group_name(set_value('group'))); ?></option>
            <?php } else { ?>
                <option value="" disabled selected>Meslek Seçini</option>
            <?php } ?>
            <!-- Dynamic site options -->
            <?php if (!empty($workgroups)) { ?>}
                <?php foreach ($workgroups as $active_workgroup => $workgroups) {
                    foreach ($workgroups as $workgroup) { ?>
                        <option value="<?php echo $workgroup; ?>"> <?php echo group_name($workgroup); ?></option>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </select>
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error('group'); ?></div>
        <?php } ?>
    </div>
    <div class="mb-3">
        <label class="col-form-label" for="bank">Banka:</label>
        <select id="select2-demo-bank" style="width: 100%;"
                class="form-control <?php cms_isset(form_error("bank"), "is-invalid", ""); ?>"
                data-plugin="select2" name="bank">
            <?php if (isset($form_error)) { ?>
                <option selected><?php echo(set_value('bank')); ?></option>
            <?php } else { ?>
                <option value="" disabled selected>Banka Seçini</option>
            <?php } ?>
            <!-- Dynamic site options -->
            <?php $banks = get_as_array($this->settings->bankalar);
            foreach ($banks as $bank) { ?>
                <option><?php echo $bank; ?></option>
            <?php } ?>
        </select>
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error('bank'); ?></div>
        <?php } ?>
    </div>
    <div class="mb-3">
        <label class="col-form-label" for="IBAN">IBAN:</label>
        <input id="IBAN" type="text" name="IBAN"
               class="form-control <?php cms_isset(form_error("IBAN"), "is-invalid", ""); ?>"
               value="<?php echo set_value('IBAN'); ?>">
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error('IBAN'); ?></div>
        <?php } ?>
    </div>
    <!-- Açıklama -->
    <div class="mb-3">
        <label class="col-form-label" for="payment_notes">Açıklama:</label>
        <input id="personel_notes" type="text"
               class="form-control <?php cms_isset(form_error("personel_notes"), "is-invalid", ""); ?>"
               name="personel_notes" value="<?php echo set_value('personel_notes'); ?>"
               placeholder="Açıklama">
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error('personel_notes'); ?></div>
        <?php } ?>
    </div>
    <!-- Dosya Yükle -->
    <div class="mb-3">
        <label class="col-form-label" for="file-input">Dosya Yükle:</label>
        <input class="form-control" name="file" id="file-input" type="file">
    </div>
</form>