<div class="bg-color-op-blue">
    <div class="repeater">
        <div class="col-sm-12">
            <input data-repeater-create type="button" class="btn btn-success" value="Ekip Satırı Ekle"/>
            <hr>
        </div>
        <div data-repeater-list="workgroups">
            <div data-repeater-item>
                <div class="row">
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
                    <div class="col-sm-4">
                        <label>Açıklama</label>
                        <input type="text" class="form-control"
                               name="notes"
                               value="<?php echo isset($form_error) ? set_value("notes") : ""; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("notes"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-1">
                        <label>&nbsp;</label><br>
                        <input data-repeater-delete type="button" class="btn btn-danger" value="Satır Sil"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

