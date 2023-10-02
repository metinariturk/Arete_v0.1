<div class="container-fluid">
    <div class="row">
        <h3 class="text-center"><?php echo site_name($sid); ?> İşyerine Personel Ekleme</h3>
        <div class="col-md-12">
            <div class="bg-color-op-blue">
                <div class="clearfix m-b-sm">
                    <div class="col-md-2">
                        <label>Adı</label>
                        <input type="text" class="form-control"
                               name="name"
                               value="<?php echo isset($form_error) ? set_value("name") : ""; ?>"
                               placeholder="Adı">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("name"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <label>Soyadı</label>
                        <input type="text" class="form-control"
                               name="surname"
                               value="<?php echo isset($form_error) ? set_value("surname") : ""; ?>"
                               placeholder="Soyadı">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("surname"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <label>TC Kimlik No</label>
                        <input type="number" step="1" class="form-control"
                               name="social_id"
                               value="<?php echo isset($form_error) ? set_value("social_id") : ""; ?>"
                               placeholder="Kimlik No">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("social_id"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <label>Tel No</label>
                        <input type="number" step="1" class="form-control"
                               name="mobile"
                               value="<?php echo isset($form_error) ? set_value("mobile") : ""; ?>"
                               placeholder="Tel No">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("mobile"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <label>Acil Durum İrtibat</label>
                        <input type="number" step="1" class="form-control"
                               name="acil"
                               value="<?php echo isset($form_error) ? set_value("acil") : ""; ?>"
                               placeholder="Acil Durum Tel No">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("acil"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <label>Adres</label>
                        <input type="text" step="1" class="form-control"
                               name="adres"
                               value="<?php echo isset($form_error) ? set_value("adres") : ""; ?>"
                               placeholder="Acil Durum Tel No">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("adres"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <label>Doğum Yılı</label>
                        <input type="text" id="datetimepicker" class="form-control"
                               name="birth_date"
                               value="<?php echo isset($form_error) ? set_value("birth_date") : ""; ?>"
                               data-plugin="datetimepicker" data-options="{ format: 'YYYY' }">
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("birth_date"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <label>İş Başlama Tarihi</label>
                        <input type="text" id="datetimepicker" class="form-control"
                               name="start_date" required
                               value="<?php echo isset($form_error) ? set_value("start_date") : ""; ?>"
                               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("start_date"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <label>Çalıştığı Ekip</label>
                        <select class="form-control" style="width: 100%" data-plugin="select2" name="group">
                            <option selected="selected"
                                    value="<?php echo isset($form_error) ? cms_if_echo((set_value("group")), null, "", set_value("group")) : null; ?>">
                                <?php echo isset($form_error) ? cms_if_echo(set_value("group"), null, "Seçiniz", group_name(set_value("group"))) : "Seçiniz"; ?>
                            </option>

                            <?php foreach ($sub_categories as $sub_category) { ?>
                                <option value="<?php echo $sub_category->id; ?>"><?php echo $sub_category->name; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("group"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-12 m-t-lg">
                        <small class="input-form-error"> *<?php echo $hata; ?> </small>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>