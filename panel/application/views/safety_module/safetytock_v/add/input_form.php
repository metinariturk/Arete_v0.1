<div class="repeater">
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
                   value="<?php echo isset($form_error) ? set_value("arrival_date") : ""; ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("arrival_date"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="repeater">
    <div class="row">
        <div data-repeater-list="supplies">
            <input data-repeater-create type="button" class="btn btn-success" value="Malzeme Satırı Ekle"/>
            <hr>
            <div data-repeater-item>
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Kullanılacak Grup</label>
                    <select id="select2-demo-1" class="form-control" style="width: 100%" required
                            data-plugin="select2" name="product_group">
                        <option selected="selected[]"
                                value="<?php echo isset($form_error) ? cms_if_echo(set_value("product_group"), null, "", set_value("product_group")) : "" ?>">
                            <?php echo isset($form_error) ? cms_if_echo(set_value("product_group"), null, "Seçiniz", set_value("product_group")) : "Seçiniz"; ?>
                        </option>
                        <?php echo $active_groups = json_decode($site->active_group); ?>
                        <?php foreach ($active_groups as $active_group) { ?>
                            <option value="<?php echo $active_group; ?>"><?php echo group_name($active_group); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Gelen Malzeme</label>
                    <input type="text" class="form-control" required
                           name="product_name"
                           value="<?php echo isset($form_error) ? set_value("product_name") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("product_name"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Miktar</label>
                    <input type="number" min="1" step="any" class="form-control" required
                           name="product_qty"
                           value="<?php echo isset($form_error) ? set_value("product_qty") : "Birim"; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("product_qty"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-1" style="padding-bottom: 10px;">
                    <label>Birim</label>
                   <select name="unit" required class="form-control" >
                       <option>m²</option>
                       <option>m³</option>
                       <option>kg</option>
                       <option>ton</option>
                       <option>m</option>
                   </select>
                </div>
                <div class="col-sm-2" style="padding-bottom: 10px;">
                    <label>Tutar</label>
                    <input type="text" class="form-control"
                           name="price"
                           value="<?php echo isset($form_error) ? set_value("price") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("price"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-1" style="padding-bottom: 10px;">
                    <label>Birim</label>
                    <select name="currency" required class="form-control" >
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
                    <select class="form-control" data-plugin="select2" name="supplier" required>
                        <?php foreach ($suppliers as $supplier) { ?>
                            <option value="<?php echo $supplier->id; ?>"><?php echo $supplier->company_name; ?></option>
                        <?php } ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("supplier"); ?></div>
                    <?php } ?>
                    <hr>
                </div>
                <div class="col-sm-9" style="padding-bottom: 10px;">
                    <label>Açıklama</label>
                    <input type="text" class="form-control" required
                           name="supply_notes"
                           value="<?php echo isset($form_error) ? set_value("supply_notes") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("supply_notes"); ?></div>
                    <?php } ?>
                    <hr>
                </div>

                <div class="col-sm-1" style="padding-bottom: 10px;" required>
                    <label>&nbsp;</label>
                    <input data-repeater-delete type="button" class="btn btn-danger" value="Satır Sil"/>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>



