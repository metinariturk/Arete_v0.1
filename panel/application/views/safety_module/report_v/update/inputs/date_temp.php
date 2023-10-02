<div class="bg-color-op-blue">
    <div class="row">
        <div class="form-group col-sm-12 text-center">
            <div class="text-center"><h3><?php echo $site->santiye_ad; ?><br>Günlük Rapor Formu</h3></div>
        </div>
    </div>
    <div class="row" style="margin-left: 10px;
      margin-right: 10px;">
        <div class="form-group col-sm-3 text-center">
            <label>Rapor No</label>
            <div class="input-group">
                <span class="input-group-addon"><?php echo $item->dosya_no; ?></span>
            </div>
        </div>
        <div class="form-group col-sm-3 text-center">
            <label>Rapor Tarihi</label>
            <input type="text" id="datetimepicker" class="form-control"
                   name="report_date"
                   value="<?php echo isset($form_error) ? set_value("baslangic_tarih") : dateFormat('d-m-Y', $item->report_date); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("report_date"); ?></div>
            <?php } ?>
        </div>

        <?php $temp_values = json_decode($item->weather); ?>
        <div class="form-group col-sm-2 text-center">
            <label>En Düşük Sıcaklık</label>
            <input type="number" min="1" step="any" class="form-control"
                   name="min_temp"
                   value="<?php echo isset($form_error) ? set_value("min_temp") : "$temp_values->min_temp"; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("min_temp"); ?></div>
            <?php } ?>
        </div>
        <div class="form-group col-sm-2 text-center">
            <label>En Yüksek Sıcaklık</label>
            <input type="number" min="1" step="any" class="form-control"
                   name="max_temp"
                   value="<?php echo isset($form_error) ? set_value("max_temp") : "$temp_values->max_temp"; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("max_temp"); ?></div>
            <?php } ?>
        </div>
        <div class="form-group col-sm-2 text-center">
            <label>Olay</label>
            <select id="select2-demo-1" class="form-control" style="width: 100%"
                    data-plugin="select2" name="event">
                <option selected="selected[]">
                    <?php echo isset($form_error) ? set_value("event") : "$temp_values->event"; ?></option>
                <option>Açık</option>
                <option>Kapalı</option>
                <option>Yağmurlu</option>
                <option>Kar Yağışlı</option>
                <option>Sisli</option>
            </select>
        </div>
    </div>
</div>
<hr>
