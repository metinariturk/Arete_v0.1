<div class="bg-color-op-purple">
    <div class="row">
        <div class="text-center"><h3>Gelen Malzemeler</h3></div>
    </div>

    <table style="margin-left: 20px; margin-right: 20px;">
        <?php $supplies = json_decode($item->supplies);
        $j = 150; ?>
        <?php foreach ($supplies as $supply) {
            $line_number = $j--; ?>
            <tr id="<?php echo $line_number; ?>">
                <td>
                    <div class="col-sm-12">
                        <label>Gelen Malzeme</label>
                        <input type="text" class="form-control"
                               name="supplies[<?php echo $line_number; ?>][supply]"
                               value="<?php echo isset($form_error) ? set_value("supply") : "$supply->supply"; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("supply"); ?></div>
                        <?php } ?>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <label>Miktar</label>
                        <input type="number" min="1" step="any" class="form-control"
                               name="supplies[<?php echo $line_number; ?>][qty]"
                               value="<?php echo isset($form_error) ? set_value("qty") : "$supply->qty"; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("qty"); ?></div>
                        <?php } ?>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <label>Birim</label>
                        <select id="select2-demo-1" class="form-control" style="width: 100%"
                                name="supplies[<?php echo $line_number; ?>][unit]"
                                data-plugin="select2">
                            <option selected="selected[]">
                                <?php echo isset($form_error) ? cms_if_echo(set_value("unit"), null, "asd", set_value("unit")) : $supply->unit; ?>
                            </option>
                            <option>m²</option>
                            <option>m³</option>
                            <option>kg</option>
                            <option>ton</option>
                            <option>m</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <label>Açıklama</label>
                        <input type="text" class="form-control"
                               name="supplies[<?php echo $line_number; ?>][supply_notes]"
                               value="<?php echo isset($form_error) ? set_value("supply_notes") : "$supply->supply_notes"; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("supply_notes"); ?></div>
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
            <input data-repeater-create type="button" class="btn btn-success" value="Malzeme Satırı Ekle"/>
            <hr>
        </div>
        <div data-repeater-list="supplies">
            <div data-repeater-item>
                <div class="row" style="margin-left: 20px; margin-right: 50px;">
                    <div class="col-sm-3">
                        <label>Gelen Malzeme</label>
                        <input type="text" class="form-control"
                               name="supply"
                               value="<?php echo isset($form_error) ? set_value("supply") : ""; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("supply"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-2">
                        <label>Miktar</label>
                        <input type="number" min="1" step="any" class="form-control"
                               name="qty"
                               value="<?php echo isset($form_error) ? set_value("qty") : "Çalışan Sayısı"; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("qty"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-2">
                        <label>Birim</label>
                        <select name="unit" class="form-control">
                            <option>m²</option>
                            <option>m³</option>
                            <option>kg</option>
                            <option>ton</option>
                            <option>m</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label>Açıklama</label>
                        <input type="text" class="form-control"
                               name="supply_notes"
                               value="<?php echo isset($form_error) ? set_value("supply_notes") : ""; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("supply_notes"); ?></div>
                        <?php } ?>
                    </div>
                    <label>&nbsp;</label>
                    <div class="col-sm-1">
                        <label>&nbsp;</label><br>
                        <input data-repeater-delete type="button" class="btn btn-danger" value="Satır Sil"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
