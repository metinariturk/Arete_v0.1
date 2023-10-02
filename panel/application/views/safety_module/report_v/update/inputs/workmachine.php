<div class="bg-color-op-green">
    <div class="row">
        <div class="text-center"><h3>Çalışan Makineler</h3></div>
    </div>
    <table style="margin-left: 20px; margin-right: 20px;">
        <?php $work_machines = json_decode($item->workmachine);
        $j = 100; ?>
        <?php foreach ($work_machines

                       as $work_machine) {
            $line_number = $j--; ?>
            <?php $group_name = machine_name($work_machine->workmachine); ?>
            <tr id="<?php echo $line_number; ?>">
                <td>
                    <div class="col-sm-12">
                        <label>Çalışan Makine</label>
                        <select id="select2-demo-1" class="form-control" style="width: 100%"
                                data-plugin="select2" name="workmachine[<?php echo $line_number; ?>][workmachine]">
                            <option selected="selected[]"
                                    value="<?php echo isset($form_error) ? cms_if_echo(set_value("workmachine"), null, "", set_value("workmachine")) : "$work_machine->workmachine" ?>">
                                <?php echo isset($form_error) ? cms_if_echo(set_value("workmachine"), null, "asd", set_value("workmachine")) : $group_name; ?>
                            </option>
                            <?php $active_machines = json_decode($site->active_machine); ?>
                            <?php foreach ($active_machines as $active_machine) { ?>
                                <option value="<?php echo $active_machine; ?>"><?php echo machine_name($active_machine); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <label>Çalışan Sayı</label>
                        <input type="number" min="1" step="any" class="form-control"
                               name="workmachine[<?php echo $line_number; ?>][machine_count]"
                               value="<?php echo isset($form_error) ? set_value("machine_count") : $work_machine->machine_count; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("machine_count"); ?></div>
                        <?php } ?>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <label>Mahal</label>
                        <input type="text" class="form-control"
                               name="workmachine[<?php echo $line_number; ?>][machine_place]"
                               value="<?php echo isset($form_error) ? set_value("machine_place") : "$work_machine->machine_place"; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("machine_place"); ?></div>
                        <?php } ?>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <label>Açıklama</label>
                        <input type="text" class="form-control"
                               name="workmachine[<?php echo $line_number; ?>][machine_notes]"
                               value="<?php echo isset($form_error) ? set_value("machine_notes") : "$work_machine->machine_notes"; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("machine_notes"); ?></div>
                        <?php } ?>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <label>&nbsp;</label><br>
                        <input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(<?php echo $line_number; ?>)">
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
    <hr>
    <div class="repeater">
        <div class="col-sm-12" style="margin-left: 20px;
      margin-right: 20px;">
            <input data-repeater-create type="button" class="btn btn-success" value="Makine Satırı Ekle"/>
            <hr>
        </div>
        <div data-repeater-list="workmachine">
            <div data-repeater-item>
                <div class="row" style="margin-left: 20px; margin-right: 50px;">
                    <div class="col-sm-2">
                        <label>Çalışan Makine</label>
                        <select id="select2-demo-1" class="form-control" style="width: 100%"
                                data-plugin="select2" name="workmachine">
                            <option selected="selected[]"
                                    value="<?php echo isset($form_error) ? cms_if_echo(set_value("workmachine"), null, "", set_value("workmachine")) : "" ?>">
                                <?php echo isset($form_error) ? cms_if_echo(set_value("workmachine"), null, "Seçiniz", set_value("workmachine")) : "Seçiniz"; ?>
                            </option>
                            <?php $active_machines = json_decode($site->active_machine); ?>
                            <?php foreach ($active_machines as $active_machine) { ?>
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
                    <div class="col-sm-1">
                        <label>&nbsp;</label><br>
                        <input data-repeater-delete type="button" class="btn btn-danger" value="Satır Sil"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
