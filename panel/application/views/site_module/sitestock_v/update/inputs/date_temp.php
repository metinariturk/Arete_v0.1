<div class="repeater" style="margin-left: 30px;">

    <div class="row">
        <div class="form-group col-sm-12 text-center">
            <label><h3><?php echo $site->santiye_ad; ?> Şantiyesi Depo Stok Girişi</h3></label>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-2 text-center">
            <label>Stok No</label>
            <div class="input-group">
                <span class="input-group-addon">ST</span>
                <?php if (!empty(get_last_fn("sitestock"))) { ?>
                    <input type="number" name="dosya_no" class="form-control" required
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("sitestock"); ?>">
                    <?php
                } else { ?>
                    <input type="number" name="dosya_no" class="form-control"
                           value="<?php echo isset($form_error) ? fill_empty_digits() . "1" : fill_empty_digits() . "1" ?>">
                <?php } ?>
            </div>
            <?php if ((isset($form_error)) and (!empty(form_error("dosya_no")))) { ?>
                <small class="pull-left input-form-error"> <?php echo "'" . set_value("dosya_no") . "'" . " Dosya adını kullanamazsınız"; ?><?php echo form_error("dosya_no"); ?></div>
            <?php } ?>
        </div>
        <div class="form-group col-sm-2 text-center">
            <label>Sevkiyat Tarihi</label>
            <input type="text" id="datetimepicker" class="form-control"
                   name="arrival_date" required
                   value="<?php echo isset($form_error) ? set_value("arrival_date") : dateFormat('d-m-Y', $item->arrival_date); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("arrival_date"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>