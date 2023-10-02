<table class="table">
    <tbody>
    <tr>
        <td class="w20"><strong>Dosya No</strong></td>
        <td>
            <div class="input-group">
                <span class="input-group-addon">EDU</span>
                <?php if (!empty(get_last_fn("debit"))) { ?>
                    <input type="number" name="dosya_no" class="form-control"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("debit"); ?>">
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
        <td class="w15"><strong>Zimmet Belge No</strong></td>
        <td>
            <input type="text" class="form-control" name="belge_no"
                   value="<?php echo isset($form_error) ? set_value("belge_no") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("belge_no"); ?></div>
            <?php } ?>
        </td>
    </tr>


    <?php if (isset($debit_type)) { ?>
        <?php $zimmet_turleri = get_as_array($settings->isg_debit); ?>
        <?php foreach ($zimmet_turleri as $zimmet_turu) {
            $system_type = convertToSEO($zimmet_turu);
            if ($system_type == $debit_type) { ?>
                <tr>
                    <td><strong>Zimmet Türü</strong></td>
                    <td>
                        <input readonly class="form-control" name="zimmet_turu" value="<?php echo $zimmet_turu; ?>">
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td><strong>Zimmet Türü</strong></td>
            <td>
                <select id="select2-demo-1" style="width: 100%;" class="form-control"
                        data-plugin="select2" name="zimmet_turu">
                    <option selected="selected"
                            value="<?php echo isset($form_error) ? set_value("zimmet_turu") : ""; ?>"><?php echo isset($form_error) ? set_value("zimmet_turu") : "Seçiniz"; ?>
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
    <?php } ?>


    <tr>
        <td><strong>Zimmet Tarihi</strong></td>
        <td>
            <input type="text" id="datetimepicker"
                   class="form-control"
                   name="zimmet_tarihi"
                   value="<?php echo isset($form_error) ? set_value("zimmet_tarihi") : ""; ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("zimmet_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><strong>Zimmet Malzemeler</strong></td>
        <td>
            <input type="text" name="zimmet_malzeme" data-plugin="tagsinput" data-role="tagsinput" class="form-control" placeholder="Malzemeleri Virgül ile Ayırınız" />

            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("zimmet_malzeme"); ?></div>
            <?php } ?>
        </td>
    </tr>

    <div class="row">
        <div class="form-group col-sm-6">
            <label >İSG Zimmet Grupları</label>
        </div>
    </div><!-- Süreç -->
    <tr>
        <td><b>Teslim Eden</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="zimmet_veren">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("zimmet_veren") : ""; ?>"><?php echo isset($form_error) ? full_name(set_value("zimmet_veren")) : "Seçiniz"; ?></option>
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
