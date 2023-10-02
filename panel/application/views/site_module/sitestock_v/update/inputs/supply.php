<div class="bg-color-op-blue" style="margin-left: 20px;">
    <table>
        <?php $supplies = json_decode($item->supplies);
        $i = 50; ?>
        <?php foreach ($supplies as $supply) { ?>
            <?php $line_number = $i--; ?>
            <tr id="<?php echo $line_number; ?>">
                <td>
                    <input name="supplies[<?php echo $line_number; ?>][id]" hidden value="<?php echo $supply->id; ?>">
                    <div class="col-sm-2">
                        <label>Kullanılacak Grup</label>
                        <select id="select2-demo-1" class="form-control" style="width: 100%"
                                data-plugin="select2" name="supplies[<?php echo $line_number; ?>][product_group]">
                            <option selected="selected[]"
                                    value="<?php echo isset($form_error) ? cms_if_echo(set_value("product_group"), null, "", set_value("product_group")) : "$supply->product_group" ?>">
                                <?php echo isset($form_error) ? cms_if_echo(set_value("product_group"), null, "Seçiniz", set_value("product_group")) : group_name($supply->product_group); ?>
                            </option>
                            <?php $active_groups = json_decode($site->active_group); ?>
                            <?php foreach ($active_groups as $active_group) { ?>
                                <option value="<?php echo $active_group; ?>"><?php echo group_name($active_group); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Gelen Malzeme</label>
                        <input type="text" class="form-control"
                               name="supplies[<?php echo $line_number; ?>][product_name]"
                               value="<?php echo isset($form_error) ? set_value("product_name") : $supply->product_name; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("product_name"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-2">
                        <label>Miktar</label>
                        <input type="number" min="1" step="any" class="form-control"
                               name="supplies[<?php echo $line_number; ?>][product_qty]"
                               value="<?php echo isset($form_error) ? set_value("product_qty") : $supply->product_qty; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("product_qty"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-2">
                        <label>Birim</label>
                        <select name="supplies[<?php echo $line_number; ?>][unit]" class="form-control">
                            <option selected><?php echo $supply->unit; ?></option>
                            <option>m²</option>
                            <option>m³</option>
                            <option>kg</option>
                            <option>ton</option>
                            <option>m</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Tutar</label>
                        <input type="number" class="form-control"
                               name="supplies[<?php echo $line_number; ?>][price]"
                               value="<?php echo isset($form_error) ? set_value("price") : $supply->price; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("price"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-2">
                        <label>Birim</label>
                        <select name="supplies[<?php echo $line_number; ?>][currency]" class="form-control">
                            <option selected><?php echo $supply->currency; ?></option>
                            <?php
                            $para_birimleri = get_as_array($settings->para_birimi);
                            foreach ($para_birimleri as $para_birimi) {
                                echo "<option value='$para_birimi'>$para_birimi</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Fatura/İrsaliye No</label>
                        <input type="text" class="form-control"
                               name="supplies[<?php echo $line_number; ?>][bill_code]"
                               value="<?php echo isset($form_error) ? set_value("bill_code") : "$supply->bill_code"; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("bill_code"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-2">
                        <label>Tedarikçi</label>
                        <select class="form-control" data-plugin="select2"
                                name="supplies[<?php echo $line_number; ?>][supplier]">
                            <option selected
                                    value="<?php echo $supply->supplier; ?>"><?php echo company_name($supply->supplier); ?></option>

                            <?php foreach ($suppliers as $supplier) { ?>
                                <option value="<?php echo $supplier->id; ?>"><?php echo $supplier->company_name; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("supplier"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-6">
                        <label>Açıklama</label>
                        <input type="text" class="form-control"
                               name="supplies[<?php echo $line_number; ?>][supply_notes]"
                               value="<?php echo isset($form_error) ? set_value("supply_notes") : "$supply->supply_notes"; ?>">
                        <?php if (isset($form_error)) { ?>
                            <small class="pull-left input-form-error"> <?php echo form_error("supply_notes"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-1">
                        <label>&nbsp;</label><br>
                        <input type="button" class="btn btn-danger" value="Satır Sil"
                               onclick="deleteRow(<?php echo $line_number; ?>)">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <hr>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<hr>
<div class="row bg-color-op-green" style="margin-left: 20px; margin-right: 0px;">
    <div class="repeater">
        <div class="col-sm-12" style="margin-left: 20px; margin-right: 20px;">
            <input data-repeater-create type="button" class="btn btn-success" value="Malzeme Satırı Ekle"/>
            <hr>
        </div>
        <div data-repeater-list="supplies" >
            <div data-repeater-item>
                <input type="text" class="form-control" name="id" style="display: none">
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Kullanılacak Grup</label>
                    <select id="select2-demo-1" class="form-control" style="width: 100%"
                            data-plugin="select2" name="product_group">
                        <option selected="selected[]"
                                value="<?php echo isset($form_error) ? cms_if_echo(set_value("product_group"), null, "", set_value("product_group")) : "" ?>">
                            <?php echo isset($form_error) ? cms_if_echo(set_value("product_group"), null, "Seçiniz", set_value("product_group")) : "Seçiniz"; ?>
                        </option>
                        <?php $active_groups = json_decode($site->active_group); ?>
                        <?php foreach ($active_groups as $active_group) { ?>
                            <option value="<?php echo $active_group; ?>"><?php echo group_name($active_group); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Gelen Malzeme</label>
                    <input type="text" class="form-control"
                           name="product_name"
                           value="<?php echo isset($form_error) ? set_value("product_name") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("product_name"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Miktar</label>
                    <input type="number" min="1" step="any" class="form-control"
                           name="product_qty"
                           value="<?php echo isset($form_error) ? set_value("product_qty") : "Birim"; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("product_qty"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Birim</label>
                    <select name="unit" class="form-control">
                        <option>m²</option>
                        <option>m³</option>
                        <option>kg</option>
                        <option>ton</option>
                        <option>m</option>
                    </select>
                </div>
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Tutar</label>
                    <input type="number" class="form-control"
                           name="price"
                           value="<?php echo isset($form_error) ? set_value("price") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("price"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Birim</label>
                    <select name="currency" class="form-control">
                        <?php
                        $para_birimleri = get_as_array($settings->para_birimi);
                        foreach ($para_birimleri as $para_birimi) {
                            echo "<option value='$para_birimi'>$para_birimi</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Fatura/İrsaliye No</label>
                    <input type="text" class="form-control"
                           name="bill_code"
                           value="<?php echo isset($form_error) ? set_value("bill_code") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("bill_code"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Tedarikçi</label>
                    <select class="form-control" data-plugin="select2" name="supplier">
                        <?php foreach ($suppliers as $supplier) { ?>
                            <option value="<?php echo $supplier->id; ?>"><?php echo $supplier->company_name; ?></option>
                        <?php } ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("supplier"); ?></div>
                    <?php } ?>
                    <hr>
                </div>
                <div class="col-sm-6" style="padding-bottom: 10px;">
                    <label>Açıklama</label>
                    <input type="text" class="form-control"
                           name="supply_notes"
                           value="<?php echo isset($form_error) ? set_value("supply_notes") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("supply_notes"); ?></div>
                    <?php } ?>
                    <hr>
                </div>
                <div class="col-sm-1" style="padding-bottom: 10px;">
                    <label>&nbsp;</label>
                    <input data-repeater-delete type="button" class="btn btn-danger" value="Satır Sil"/>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
