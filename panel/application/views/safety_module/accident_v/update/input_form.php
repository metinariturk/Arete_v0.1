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
        <td><strong>Kaza Türü</strong></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="kaza_turu">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("kaza_turu") : "$item->kaza_turu"; ?>"><?php echo isset($form_error) ? set_value("kaza_turu") : "$item->kaza_turu"; ?>
                </option>
                <?php $kaza_turleri = get_as_array($settings->isg_education);
                foreach ($kaza_turleri as $kaza_turu) { ?>

                    <option value="<?php echo $kaza_turu; ?>"><?php echo $kaza_turu; ?></option>";
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("kaza_turu"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><strong>Kaza Tarihi</strong></td>
        <td>
            <input type="text" id="datetimepicker"
                   class="form-control"
                   name="kaza_tarihi"
                   value="<?php echo isset($form_error) ? set_value("kaza_tarihi") : dateFormat_dmy($item->kaza_tarihi); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("kaza_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><strong>Bildiri Tarihi</strong></td>
        <td>
            <input type="text" id="datetimepicker"
                   class="form-control"
                   name="gecerlilik_tarihi"
                   value="<?php echo isset($form_error) ? set_value("gecerlilik_tarihi") : dateFormat_dmy($item->bildiri_tarihi); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("gecerlilik_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Tespit Yapan</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="kaza_veren">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("tespit_yapan") : $item->tespit_yapan; ?>"><?php echo isset($form_error) ? full_name(set_value("tespit_yapan")) : full_name($item->tespit_yapan); ?></option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo $user->name . " " . $user->surname; ?></option>
                <?php } ?>
            </select>
            <br>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("kaza_veren"); ?></div>
            <?php } ?>
        </td>
    </tr>
    </tbody>
</table>
