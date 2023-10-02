<div class="container-fluid">
    <div class="row">
        <h3 class="text-center"><?php echo site_name($sid); ?> <br>Personel Bilgi Düzenleme</h3>
        <div class="col-md-12">
            <div class="bg-color-op-blue">
                <div class="clearfix m-b-sm">
                    <div class="col-md-2">
                        <input type="text" class="form-control"
                               name="name"
                               value="<?php echo isset($form_error) ? set_value("name") : "$item->name"; ?>"
                               placeholder="Adı">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("name"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control"
                               name="surname"
                               value="<?php echo isset($form_error) ? set_value("surname") : "$item->surname"; ?>"
                               placeholder="Soyadı">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("surname"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="1" class="form-control"
                               name="social_id"
                               value="<?php echo isset($form_error) ? set_value("social_id") : "$item->social_id"; ?>"
                               placeholder="Kimlik No">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("social_id"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="datetimepicker" class="form-control"
                               name="birth_date"
                               value="<?php echo isset($form_error) ? set_value("birth_date") : "$item->birth_date"; ?>"
                               data-plugin="datetimepicker" data-options="{ format: 'YYYY' }">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="datetimepicker" class="form-control"
                               name="start_date" required
                               value="<?php echo isset($form_error) ? set_value("start_date") : dateFormat_dmy($item->start_date); ?>"
                               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("start_date"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" data-plugin="select2" name="group">
                            <option selected="selected"
                                    value="<?php echo isset($form_error) ? cms_if_echo(set_value("group"), null, "", set_value("group")) : "$item->group"; ?>">
                                <?php echo isset($form_error) ? cms_if_echo(set_value("group"), null, "Seçiniz", set_value("group")) : group_name($item->group); ?>
                            </option>

                            <?php foreach ($main_categories as $main_category) { ?>
                                <option value="<?php echo $main_category->id; ?>"><?php echo $main_category->name; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("group"); ?></div>
                        <?php } ?>
                    </div>

                </div>
            </div>
            <hr>
        </div>
    </div>
</div>