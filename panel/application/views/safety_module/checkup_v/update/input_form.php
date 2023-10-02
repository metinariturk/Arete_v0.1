<table class="table">
    <tbody>
    <tr>
        <td class="w20"><strong>Dosya No</strong></td>
        <td>
            <?php echo "$item->dosya_no"; ?>
        </td>
    </tr>
    <tr>
        <td class="w15"><strong>Belge No</strong></td>
        <td>
            <input type="text" class="form-control" name="belge_no"
                   value="<?php echo isset($form_error) ? set_value("belge_no") : "$item->belge_no"; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("belge_no"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><strong>Sağlık Raporu Türü</strong></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="checkup_turu">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("checkup_turu") : "$item->checkup_turu"; ?>"><?php echo isset($form_error) ? set_value("checkup_turu") : "$item->checkup_turu"; ?>
                </option>
                <?php $checkup_turleri = get_as_array($settings->isg_education);
                foreach ($checkup_turleri as $checkup_turu) { ?>

                    <option value="<?php echo $checkup_turu; ?>"><?php echo $checkup_turu; ?></option>";
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("checkup_turu"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><strong>Sağlık Raporu Tarihi</strong></td>
        <td>
            <input type="text" id="datetimepicker"
                   class="form-control"
                   name="checkup_tarihi"
                   value="<?php echo isset($form_error) ? set_value("checkup_tarihi") : dateFormat_dmy($item->checkup_tarihi); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("checkup_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td class="w15"><strong>Geçerlilik Süresi (Gün)</strong></td>
        <td>
            <input type="text" class="form-control" name="gecerlilik_suresi"
                   <?php $gecerlilik = date_minus_day($item->gecerlilik_tarihi,$item->checkup_tarihi); ?>
                   value="<?php echo isset($form_error) ? set_value("gecerlilik_suresi") : $gecerlilik; ?>">

            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("gecerlilik_suresi"); ?></div>
            <?php } ?>
        </td>
    </tr>

    <tr>
        <td><strong>Geçerlilik Tarihi</strong></td>
        <td>
            <?php echo  dateFormat_dmy($item->gecerlilik_tarihi); ?>
        </td>
    </tr>
    <tr>
        <td><b>Rapor Hazırlayan</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="rapor_duzenleyen">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("rapor_duzenleyen") : $item->rapor_duzenleyen; ?>"><?php echo isset($form_error) ? full_name(set_value("rapor_duzenleyen")) : full_name($item->rapor_duzenleyen); ?></option>
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
        <td><b>Etiketler</b></td>
        <td>
            <input type="text" value="<?php echo isset($form_error) ? set_value("etiketler") : $item->etiketler; ?>" name="etiketler" data-plugin="tagsinput"
                   data-role="tagsinput" class="form-control" placeholder="Değerleri Virgül ile Ayırınız"/>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("etiketler"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Açıklama</b></td>
        <td>
            <input type="text" class="form-control" name="aciklama"
                   value="<?php echo isset($form_error) ? set_value("aciklama") : "$item->aciklama"; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </td>
    </tr>
    </tbody>
</table>
