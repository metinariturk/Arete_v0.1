<table class="table">
    <tbody>
    <tr>
        <td class="w20"><strong>Dosya No</strong></td>
        <td>
            <div class="input-group">
                <span class="input-group-addon">KZA</span>
                <?php if (!empty(get_last_fn("accident"))) { ?>
                    <input type="number" name="dosya_no" class="form-control"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("accident"); ?>">
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
        <td class="w15"><strong>Belge/Tutanak No</strong></td>
        <td>
            <input type="text" class="form-control" name="belge_no"
                   value="<?php echo isset($form_error) ? set_value("belge_no") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("belge_no"); ?></div>
            <?php } ?>
        </td>
    </tr>


    <?php if (isset($edu_type)) { ?>
        <?php $kaza_turleri = get_as_array($settings->isg_accident); ?>
        <?php foreach ($kaza_turleri as $kaza_turu) {
            $system_type = convertToSEO($kaza_turu);
            if ($system_type == $edu_type) { ?>
                <tr>
                    <td><strong>Kaza Türü</strong></td>
                    <td>
                        <input readonly class="form-control" name="kaza_turu" value="<?php echo $kaza_turu; ?>">
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td><strong>Kaza Türü</strong></td>
            <td>
                <select id="select2-demo-1" style="width: 100%;" class="form-control"
                        data-plugin="select2" name="kaza_turu">
                    <option selected="selected"
                            value="<?php echo isset($form_error) ? set_value("kaza_turu") : ""; ?>"><?php echo isset($form_error) ? set_value("kaza_turu") : "Seçiniz"; ?>
                    </option>
                    <?php $kaza_turleri = get_as_array($settings->isg_accident);
                    foreach ($kaza_turleri as $kaza_turu) { ?>

                        <option value="<?php echo $kaza_turu; ?>"><?php echo $kaza_turu; ?></option>";
                    <?php } ?>
                </select>
                <?php if (isset($form_error)) { ?>
                    <small class="pull-left input-form-error"> <?php echo form_error("kaza_turu"); ?></div>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>


    <tr>
        <td><strong>Kaza Tarihi</strong></td>
        <td>
            <input type="text" id="datetimepicker"
                   class="form-control"
                   name="kaza_tarihi"
                   value="<?php echo isset($form_error) ? set_value("kaza_tarihi") : ""; ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("kaza_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>

    <tr>
        <td><b>Tespit Yapan</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="tespit_yapan">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("tespit_yapan") : ""; ?>"><?php echo isset($form_error) ? full_name(set_value("tespit_yapan")) : "Seçiniz"; ?></option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo $user->name . " " . $user->surname; ?></option>
                <?php } ?>
            </select>
            <br>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("tespit_yapan"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Etiketler</b>
        </td>
        <td>
            <input type="text" name="etiketler" data-plugin="tagsinput"
                   data-role="tagsinput" class="form-control" placeholder="Kaza anahtar kelimeler"/>
        </td>
    </tr>
    <tr>
        <td>
            <b>Kaza Genel Açıklamaları</b>
        </td>
        <td>
            <textarea class="form-control" name="aciklama"
                      placeholder="Sözleşme özel notlarınızı ekleyiniz"><?php echo isset($form_error) ? set_value("aciklama") : ""; ?></textarea>
        </td>
    </tr>
    </tbody>
</table>
