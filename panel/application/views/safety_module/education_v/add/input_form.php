<table class="table">
    <tbody>
    <tr>
        <td class="w20"><strong>Dosya No</strong></td>
        <td>
            <div class="input-group">
                <span class="input-group-addon">EDU</span>
                <?php if (!empty(get_last_fn("education"))) { ?>
                    <input type="number" name="dosya_no" class="form-control"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("education"); ?>">
                    <?php
                } else { ?>
                    <input type="number" name="dosya_no" class="form-control"
                           value="<?php echo isset($form_error) ? fill_empty_digits() . "1" : fill_empty_digits() . "1" ?>">
                <?php } ?>
            </div>
            <?php if ((isset($form_error)) and (!empty(form_error("dosya_no")))) { ?>
                <small class="pull-left input-form-error"> <?php echo "'" . set_value("dosya_no") . "'" . " Dosya adını kullanamazsınız"; ?><?php echo form_error("dosya_no"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td class="w15"><strong>Belge No</strong></td>
        <td>
            <input type="text" class="form-control" name="belge_no"
                   value="<?php echo isset($form_error) ? set_value("belge_no") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("belge_no"); ?></div>
            <?php } ?>
        </td>
    </tr>


    <?php if (isset($edu_type)) { ?>
        <?php $egitim_turleri = get_as_array($settings->isg_education); ?>
        <?php foreach ($egitim_turleri as $egitim_turu) {
            $system_type = convertToSEO($egitim_turu);
            if ($system_type == $edu_type) { ?>
                <tr>
                    <td><strong>Eğitim Türü</strong></td>
                    <td>
                        <input readonly class="form-control" name="egitim_turu" value="<?php echo $egitim_turu; ?>">
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td><strong>Eğitim Türü</strong></td>
            <td>
                <select id="select2-demo-1" style="width: 100%;" class="form-control"
                        data-plugin="select2" name="egitim_turu">
                    <option selected="selected"
                            value="<?php echo isset($form_error) ? set_value("egitim_turu") : ""; ?>"><?php echo isset($form_error) ? set_value("egitim_turu") : "Seçiniz"; ?>
                    </option>
                    <?php $egitim_turleri = get_as_array($settings->isg_education);
                    foreach ($egitim_turleri as $egitim_turu) { ?>

                        <option value="<?php echo $egitim_turu; ?>"><?php echo $egitim_turu; ?></option>";
                    <?php } ?>
                </select>
                <?php if (isset($form_error)) { ?>
                    <small class="pull-left input-form-error"> <?php echo form_error("egitim_turu"); ?></div>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>


    <tr>
        <td><strong>Eğitim Tarihi</strong></td>
        <td>
            <input type="text" id="datetimepicker"
                   class="form-control"
                   name="egitim_tarihi"
                   value="<?php echo isset($form_error) ? set_value("egitim_tarihi") : ""; ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("egitim_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><strong>Geçerlilik Tarihi</strong></td>
        <td>
            <input type="text" id="datetimepicker"
                   class="form-control"
                   name="gecerlilik_tarihi"
                   value="<?php echo isset($form_error) ? set_value("gecerlilik_tarihi") : ""; ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("gecerlilik_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Eğitim Veren</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="egitim_veren">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("egitim_veren") : ""; ?>"><?php echo isset($form_error) ? full_name(set_value("egitim_veren")) : "Seçiniz"; ?></option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo $user->name . " " . $user->surname; ?></option>
                <?php } ?>
            </select>
            <br>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("egitim_veren"); ?></div>
            <?php } ?>
        </td>
    </tr>
    </tbody>
</table>
