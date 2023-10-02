<div class="bg-color-op-blue">
    <div class="row">
        <div class="text-center"><h3>Çalışan Ekipler</h3></div>
    </div>
    <table style="margin-left: 20px; margin-right: 20px;">
        <?php $work_groups = json_decode($item->workgroup);
        $i = 50; ?>
        <?php foreach ($work_groups as $work_group) {
            $line_number = $i--; ?>
            <?php $group_name = group_name($work_group->workgroup); ?>
            <tr id="<?php echo $line_number; ?>">
                <td>
                    <div class="col-sm-12">
                        <label>Çalışan Ekip</label>
                        <select id="select2-demo-1" class="form-control" style="width: 100%"
                                data-plugin="select2" name="workgroups[<?php echo $line_number; ?>][workgroup]">
                            <option selected="selected[]"
                                    value="<?php echo isset($form_error) ? cms_if_echo(set_value("workgroup"), null, "", set_value("workgroup")) : "$work_group->workgroup" ?>">
                                <?php echo isset($form_error) ? cms_if_echo(set_value("workgroup"), null, "asd", set_value("workgroup")) : $group_name; ?>
                            </option>
                            <?php $active_groups = json_decode($site->active_group); ?>
                            <?php foreach ($active_groups as $active_group) { ?>
                                <option value="<?php echo $active_group; ?>"><?php echo group_name($active_group); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <label>Çalışan Sayı</label>
                        <input type="number" min="1" step="any" class="form-control"
                               name="workgroups[<?php echo $line_number; ?>][worker_count]"
                               value="<?php echo isset($form_error) ? set_value("worker_count") : $work_group->worker_count; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("worker_count"); ?></div>
                        <?php } ?>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <label>Mahal</label>
                        <input type="text" class="form-control"
                               name="workgroups[<?php echo $line_number; ?>][place]"
                               value="<?php echo isset($form_error) ? set_value("place") : "$work_group->place"; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("place"); ?></div>
                        <?php } ?>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <label>Açıklama</label>
                        <input type="text" class="form-control"
                               name="workgroups[<?php echo $line_number; ?>][notes]"
                               value="<?php echo isset($form_error) ? set_value("notes") : "$work_group->notes"; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("notes"); ?></div>
                        <?php } ?>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <label>&nbsp;</label><br>
                        <input type="button" class="btn btn-danger" value="Delete"
                               onclick="deleteRow(<?php echo $line_number; ?>)">
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
    <hr>
    <div class="repeater">
        <div class="col-sm-12" style="margin-left: 20px; margin-right: 20px;">
            <input data-repeater-create type="button" class="btn btn-success" value="Ekip Satırı Ekle"/>
            <hr>
        </div>
        <div data-repeater-list="workgroups">
            <div data-repeater-item>
                <div class="row" style="margin-left: 20px; margin-right: 50px;">
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
                    <div class="col-sm-1">
                        <label>&nbsp;</label><br>
                        <input data-repeater-delete type="button" class="btn btn-danger" value="Satır Sil"/>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Workgorup -->
</div>
<hr>

