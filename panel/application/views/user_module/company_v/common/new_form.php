<form id="new_company"
      action="<?php echo base_url("$this->Module_Name/save"); ?>"
      method="post"
      enctype="multipart">
    <div class="row g-3">
        <div class="col-md-12">
            <label class="form-label" for="company_name">Firma Adı</label>
            <input type="text" required name="company_name" id="company_name"
                   class="form-control">
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label" for="taraf">Firma Rolü</label>
            <select class="form-control" id="taraf"
                    data-plugin="select2"
                    name="company_role">
                <option value="">Seçiniz</option>

                <?php
                $sozlesme_taraflari = get_as_array($settings->sozlesme_taraflari);
                foreach ($sozlesme_taraflari as $sozlesme_tarafi) { ?>
                    <option value="<?php echo $sozlesme_tarafi; ?>"><?php echo $sozlesme_tarafi; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="workgroup">İş Grubu</label>
            <select id="select2-demo-1" id="workgroup"
                    class="form-control"
                    data-plugin="select2" name="profession">
                <option value="">Seçiniz</option>

                <?php work_groups(); ?>
            </select>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label" for="email">E Posta</label>
            <input type="text" name="email" id="email"
                   class="form-control"
                   value="">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="phoneInput">Telefon</label>
            <input type="text" name="phone" placeholder="5XX XXX XX XX" id="phoneInput"
                   oninput="formatAndDisplayPhoneNumber()" maxlength="10"
                   class="form-control"
                   value="">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="select2-demo-1">Yetkili</label>
            <select id="select2-demo-1"
                    class="form-control"
                    data-plugin="select2" name="executive">
                <option selected="selected"
                        value=""></option>
                <?php foreach ($users as $users) { ?>
                    <option value="<?php echo $users->id; ?>"><?php echo full_name($users->id); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</form>
