<div class="repeater">
    <div class="row">
        <div class="form-group col-sm-12 text-center">
            <label><?php echo $site->santiye_ad; ?></label>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-3 text-center">
            <label>Rapor No</label>
            <div class="input-group">
                <span class="input-group-addon"><?php echo $item->dosya_no; ?></span>
            </div>
        </div>
        <div class="form-group col-sm-3 text-center">
            <label>Rapor Tarihi</label>
            <input type="text" id="datetimepicker" class="form-control"
                   name="report_date" required
                   value="<?php echo isset($form_error) ? set_value("baslangic_tarih") : dateFormat('d-m-Y',$item->report_date); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("report_date"); ?></div>
            <?php } ?>
        </div>

        <?php $temp_values = json_decode($item->weather); ?>
        <div class="form-group col-sm-2 text-center">
            <label>En Düşük Sıcaklık</label>
            <input type="number" min="1" step="any" class="form-control"
                   name="min_temp" required
                   value="<?php echo isset($form_error) ? set_value("min_temp") : "$temp_values->min_temp"; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("min_temp"); ?></div>
            <?php } ?>
        </div>
        <div class="form-group col-sm-2 text-center">
            <label>En Yüksek Sıcaklık</label>
            <input type="number" min="1" step="any" class="form-control"
                   name="max_temp" required
                   value="<?php echo isset($form_error) ? set_value("max_temp") : "$temp_values->max_temp"; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("max_temp"); ?></div>
            <?php } ?>
        </div>
        <div class="form-group col-sm-2 text-center">
            <label>Olay<?php echo $temp_values->event; ?></label>
            <select id="select2-demo-1" class="form-control" style="width: 100%"
                    data-plugin="select2" required name="event">
                <option selected="selected[]">
                <?php echo isset($form_error) ? set_value("max_temp") : "$temp_values->event"; ?></option>
                <option>Açık</option>
                <option>Kapalı</option>
                <option>Yağmurlu</option>
                <option>Kar Yağışlı</option>
                <option>Sisli</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="text-center"><h3>Çalışan Ekipler</h3></div>
    </div>
    <hr>
    <div class="row">
    <?php $work_groups = json_decode($item->workgroup);
    $i = 100;?>
    <?php foreach ($work_groups as $work_group){
       ?>
        <?php $group_name = group_name($work_group->workgroup); ?>
        <div class="col-sm-2">
            <label>Çalışan Ekip<?php echo $i--; ?></label>
            <select id="select2-demo-1" class="form-control" style="width: 100%"
                    data-plugin="select2" name="workgroups[<?php echo $i--; ?>][workgroup]">
                <option selected="selected[]"
                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("workgroup"), null, "", set_value("workgroup")) : "$work_group->workgroup" ?>">
                    <?php echo isset($form_error) ? cms_if_echo(set_value("workgroup"), null, "asd", set_value("workgroup")) : $group_name; ?>
                </option>
                <?php echo $active_groups = json_decode($site->active_group); ?>
                <?php foreach ($active_groups as $active_group) { ?>
                    <option value="<?php echo $active_group; ?>"><?php echo group_name($active_group); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-2">
            <label>Çalışan Sayı</label>
            <input type="number" min="1" step="any" class="form-control"
                   name="workgroups[<?php echo $i--; ?>][worker_count]"
                   value="<?php echo isset($form_error) ? set_value("worker_count") : $work_group->worker_count; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("worker_count"); ?></div>
            <?php } ?>
        </div>
        <div class="col-sm-2">
            <label>Mahal</label>
            <input type="text" class="form-control"
                   name="workgroups[<?php echo $i--; ?>][place]"
                   value="<?php echo isset($form_error) ? set_value("place") : "$work_group->place"; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("place"); ?></div>
            <?php } ?>
        </div>
        <div class="col-sm-5">
            <label>Açıklama</label>
            <input type="text" class="form-control"
                   name="workgroups[<?php echo $i--; ?>][notes]"
                   value="<?php echo isset($form_error) ? set_value("notes") : "$work_group->notes"; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("notes"); ?></div>
            <?php } ?>
        </div>
    <?php } ?>
    </div>

    <div class="row">
        <div data-repeater-list="workgroups">
            <input data-repeater-create type="button" class="btn btn-success" value="Ekip Satırı Ekle"/>
            <hr>
            <div data-repeater-item>
                <div class="col-sm-2">
                    <label>Çalışan Ekip</label>
                    <select id="select2-demo-1" class="form-control" style="width: 100%"
                            data-plugin="select2" name="workgroup">
                        <option selected="selected[]"
                                value="<?php echo isset($form_error) ? cms_if_echo(set_value("workgroup"), null, "", set_value("workgroup")) : "" ?>">
                            <?php echo isset($form_error) ? cms_if_echo(set_value("workgroup"), null, "Seçiniz", set_value("workgroup")) : "Seçiniz"; ?>
                        </option>
                        <?php echo $active_groups = json_decode($site->active_group); ?>
                        <?php foreach ($active_groups as $active_group) { ?>
                            <option value="<?php echo $active_group; ?>"><?php echo group_name($active_group); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Çalışan Sayı</label>
                    <input type="number" min="1" step="any" class="form-control"
                           name="worker_count"
                           value="<?php echo isset($form_error) ? set_value("worker_count") : "Çalışan Sayısı"; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("worker_count"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-2">
                    <label>Mahal</label>
                    <input type="text" class="form-control"
                           name="place"
                           value="<?php echo isset($form_error) ? set_value("place") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("place"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-5">
                    <label>Açıklama</label>
                    <input type="text" class="form-control"
                           name="notes"
                           value="<?php echo isset($form_error) ? set_value("notes") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("notes"); ?></div>
                    <?php } ?>
                </div>
                <label>&nbsp;</label>

                <div class="col-sm-1">
                    <input data-repeater-delete type="button" class="btn btn-danger" value="Satır Sil"/>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="text-center"><h3>Çalışan Makineler


        </h3></div>
</div>
<hr>
<div class="repeater">
    <div class="row">
        <div data-repeater-list="workmachine">
            <input data-repeater-create type="button" class="btn btn-success" value="Makine Satırı Ekle"/>
            <hr>
            <div data-repeater-item>
                <div class="col-sm-2">
                    <label>Çalışan Makine</label>
                    <select id="select2-demo-1" class="form-control" style="width: 100%"
                            data-plugin="select2" name="workmachine">
                        <option selected="selected[]"
                                value="<?php echo isset($form_error) ? cms_if_echo(set_value("workmachine"), null, "", set_value("workmachine")) : "" ?>">
                            <?php echo isset($form_error) ? cms_if_echo(set_value("workmachine"), null, "Seçiniz", set_value("workmachine")) : "Seçiniz"; ?>
                        </option>
                        <?php $active_machines = json_decode($site->active_machine); ?>
                        <?php foreach ($active_machines as $active_machine){ ?>
                            <option value="<?php echo $active_machine; ?>"> <?php echo machine_name($active_machine); ?></option>
                        <?php } ?>

                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Sayı</label>
                    <input type="number" min="1" step="any" class="form-control"
                           name="machine_count"
                           value="<?php echo isset($form_error) ? set_value("worker_count") : "Çalışan Sayısı"; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("worker_count"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-2">
                    <label>Mahal</label>
                    <input type="text" class="form-control"
                           name="machine_place"
                           value="<?php echo isset($form_error) ? set_value("place") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("place"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-5">
                    <label>Açıklama</label>
                    <input type="text" class="form-control"
                           name="machine_notes"
                           value="<?php echo isset($form_error) ? set_value("notes") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("notes"); ?></div>
                    <?php } ?>
                </div>
                <label>&nbsp;</label>
                <div class="col-sm-1">
                    <input data-repeater-delete type="button" class="btn btn-danger" value="Satır Sil"/>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="text-center"><h3>Gelen Malzemeler
        </h3></div>
</div>
<hr>
<div class="repeater">
    <div class="row">
        <div data-repeater-list="supplies">
            <input data-repeater-create type="button" class="btn btn-success" value="Makine Satırı Ekle"/>
            <hr>
            <div data-repeater-item>
                <div class="col-sm-2">
                    <label>Gelen Malzeme</label>
                    <input type="text" class="form-control"
                           name="supply"
                           value="<?php echo isset($form_error) ? set_value("place") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("place"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-2">
                    <label>Miktar</label>
                    <input type="number" min="1" step="any" class="form-control"
                           name="qty"
                           value="<?php echo isset($form_error) ? set_value("worker_count") : "Çalışan Sayısı"; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("worker_count"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-1">
                    <label>Birim</label>
                    <select name="unit" class="form-control" >
                        <option>m²</option>
                        <option>m³</option>
                        <option>kg</option>
                        <option>ton</option>
                        <option>m</option>
                    </select>
                </div>

                <div class="col-sm-6">
                    <label>Açıklama</label>
                    <input type="text" class="form-control"
                           name="supply_notes"
                           value="<?php echo isset($form_error) ? set_value("notes") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("notes"); ?></div>
                    <?php } ?>
                </div>
                <label>&nbsp;</label>
                <div class="col-sm-1">
                    <input data-repeater-delete type="button" class="btn btn-danger" value="Satır Sil"/>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-12">
        <label>Açıklama</label>
        <input type="text" name="note" class="form-control">
    </div>
</div>


