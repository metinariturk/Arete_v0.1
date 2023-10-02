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
        <td><strong>Eğitim Türü</strong></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="zimmet_turu">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("zimmet_turu") : "$item->zimmet_turu"; ?>"><?php echo isset($form_error) ? set_value("zimmet_turu") : "$item->zimmet_turu"; ?>
                </option>
                <?php $zimmet_turleri = get_as_array($settings->isg_debit);
                foreach ($zimmet_turleri as $zimmet_turu) { ?>

                    <option value="<?php echo $zimmet_turu; ?>"><?php echo $zimmet_turu; ?></option>";
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("zimmet_turu"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><strong>Eğitim Tarihi</strong></td>
        <td>
            <input type="text" id="datetimepicker"
                   class="form-control"
                   name="zimmet_tarihi"
                   value="<?php echo isset($form_error) ? set_value("zimmet_tarihi") : dateFormat_dmy($item->zimmet_tarihi); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("zimmet_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><strong>Zimmet Malzemeler</strong></td>
        <td>
            <input type="text" name="zimmet_malzeme" value="<?php echo "$item->zimmet_malzeme"; ?>" data-plugin="tagsinput" data-role="tagsinput" class="form-control" placeholder="Malzemeleri Virgül ile Ayırınız" />

            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("zimmet_malzeme"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Eğitim Veren</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="zimmet_veren">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("zimmet_veren") : $item->zimmet_veren; ?>"><?php echo isset($form_error) ? full_name(set_value("zimmet_veren")) : full_name($item->zimmet_veren); ?></option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo $user->name . " " . $user->surname; ?></option>
                <?php } ?>
            </select>
            <br>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("zimmet_veren"); ?></div>
            <?php } ?>
        </td>
    </tr>
    </tbody>
</table>
