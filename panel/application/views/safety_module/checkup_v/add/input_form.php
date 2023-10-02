<table class="table">
    <tbody>
    <tr>
        <td class="w20"><strong>Dosya No</strong></td>
        <td>
            <div class="input-group">
                <span class="input-group-addon">CKP</span>
                <?php if (!empty(get_last_fn("checkup"))) { ?>
                    <input type="number" name="dosya_no" class="form-control"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("checkup"); ?>">
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
        <td class="w15"><strong>Belge/Rapor No</strong></td>
        <td>
            <input type="text" class="form-control" name="belge_no"
                   value="<?php echo isset($form_error) ? set_value("belge_no") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("belge_no"); ?></div>
            <?php } ?>
        </td>
    </tr>


    <?php if (isset($ckp_type)) { ?>
        <?php $rapor_turleri = get_as_array($settings->isg_checkup); ?>
        <?php foreach ($rapor_turleri as $rapor_turu) {
            $system_type = convertToSEO($rapor_turu);
            if ($system_type == $ckp_type) { ?>
                <tr>
                    <td><strong>Sağlık Raporu Türü</strong></td>
                    <td>
                        <input readonly class="form-control" name="checkup_turu" value="<?php echo $rapor_turu; ?>">
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td><strong>Sağlık Raporu Türü</strong></td>
            <td>
                <select id="select2-demo-1" style="width: 100%;" class="form-control"
                        data-plugin="select2" name="checkup_turu">
                    <option selected="selected"
                            value="<?php echo isset($form_error) ? set_value("checkup_turu") : ""; ?>"><?php echo isset($form_error) ? set_value("checkup_turu") : "Seçiniz"; ?>
                    </option>
                    <?php $rapor_turleri = get_as_array($settings->isg_checkup);
                    foreach ($rapor_turleri as $rapor_turu) { ?>

                        <option value="<?php echo $rapor_turu; ?>"><?php echo $rapor_turu; ?></option>";
                    <?php } ?>
                </select>
                <?php if (isset($form_error)) { ?>
                    <small class="pull-left input-form-error"> <?php echo form_error("checkup_turu"); ?></div>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td><strong>Sağlık Raporu Tarihi</strong></td>
        <td>
            <input type="text" id="datetimepicker"
                   class="form-control"
                   name="checkup_tarihi"
                   value="<?php echo isset($form_error) ? set_value("checkup_tarihi") : ""; ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("checkup_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td class="w15"><strong>Geçerlilik Süresi (Gün)</strong></td>
        <td>
            <input type="number" class="form-control" name="gecerlilik_sure"
                   value="<?php echo isset($form_error) ? set_value("gecerlilik_sure") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("gecerlilik_sure"); ?></div>
            <?php } ?>
        </td>
    </tr>

    <tr>
        <td><b>Tespit Yapan</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="rapor_duzenleyen">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("rapor_duzenleyen") : ""; ?>"><?php echo isset($form_error) ? full_name(set_value("rapor_duzenleyen")) : "Seçiniz"; ?></option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo $user->name . " " . $user->surname; ?></option>
                <?php } ?>
            </select>
            <br>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("rapor_duzenleyen"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Etiketler</b>
        </td>
        <td>
            <input type="text" name="etiketler" data-plugin="tagsinput"
                   data-role="tagsinput" class="form-control" placeholder="Sağlık Raporu anahtar kelimeler"/>
        </td>
    </tr>
    <tr>
        <td>
            <b>Sağlık Raporu Genel Açıklamaları</b>
        </td>
        <td>
            <textarea class="form-control" name="aciklama"
                      placeholder="Sözleşme özel notlarınızı ekleyiniz"><?php echo isset($form_error) ? set_value("aciklama") : ""; ?></textarea>
        </td>
    </tr>
    </tbody>
</table>
