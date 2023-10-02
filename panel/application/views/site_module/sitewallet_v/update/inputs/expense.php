<div class="bg-color-op-blue" style="margin-left: 20px;">
    <table>
        <?php $expenses = json_decode($item->expenses); ?>
        <?php if ($expenses != null) { ?>
        <?php foreach ($expenses as $expense) { ?>
            <?php $i = 50; ?>
            <?php $line_number = $i--; ?>
            <tr id="<?php echo $line_number; ?>">
                <td>
                    <input name="expenses[<?php echo $line_number; ?>][id]" hidden value="<?php echo $expense->id; ?>">
                    <div class="col-sm-2">
                        <label>Harcama Tarihi</label>
                        <input type="text" id="datetimepicker" class="form-control"
                               name="expenses[<?php echo $line_number; ?>][harcama_tarih]" required
                               value="<?php echo dateFormat('d-m-Y', $expense->harcama_tarih); ?>"
                               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
                    </div>
                    <div class="col-sm-2">
                        <label>Gider Türü</label>
                        <select id="select2-demo-1" class="form-control" style="width: 100%" required
                                data-plugin="select2" name="expenses[<?php echo $line_number; ?>][gider_turu]">
                            <option selected="selected[]"><?php echo $expense->gider_turu; ?></option>
                            <?php foreach (get_as_array($settings->harcama_tur) as $harcama_tur) { ?>
                                <option value="<?php echo $harcama_tur; ?>"><?php echo $harcama_tur; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Tutar</label>
                        <div class="input-group">
                            <input type="number" step="any" name="expenses[<?php echo $line_number; ?>][tutar]"
                                   value="<?php echo $expense->tutar; ?>" class="form-control">
                            <span class="input-group-addon">TL</span>
                        </div>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Ödeme Türü</label>
                        <select id="select2-demo-1" class="form-control" style="width: 100%" required
                                data-plugin="select2" name="expenses[<?php echo $line_number; ?>][odeme_tur]">
                            <option selected="selected[]"><?php echo $expense->odeme_tur; ?></option>
                            <?php foreach (get_as_array($settings->odeme_tur) as $odeme_tur) { ?>
                                <option value="<?php echo $odeme_tur; ?>"><?php echo $odeme_tur; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Belge Türü</label>
                        <select id="select2-demo-1" class="form-control" style="width: 100%" required
                                data-plugin="select2" name="expenses[<?php echo $line_number; ?>][belge_tur]">
                            <option selected="selected[]"><?php echo $expense->belge_tur; ?></option>
                            <?php foreach (get_as_array($settings->belge_tur) as $belge_tur) { ?>
                                <option value="<?php echo $belge_tur; ?>"><?php echo $belge_tur; ?></option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="col-sm-2">
                        <label>Açıklama</label>
                        <input type="text" class="form-control" required
                               name="expenses[<?php echo $line_number; ?>][aciklama]"
                               value="<?php echo $expense->aciklama; ?>">
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
<?php } ?>

<div class="bg-color-op-blue" style="margin-left: 20px;">
    <div class="repeater">
        <div data-repeater-list="expenses">
            <input data-repeater-create type="button" class="btn btn-success m-l-sm" value="Harcama Satırı Ekle"/>
            <hr>
            <div data-repeater-item class="m-l-sm">
                <div class="row">
                    <div class="col-sm-2" style="padding-bottom: 10px;">
                        <label>Harcama Tarihi</label>
                        <input type="text" id="datetimepicker" class="form-control"
                               name="harcama_tarih" required
                               value="<?php echo isset($form_error) ? set_value("harcama_tarih") : ""; ?>"
                               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
                    </div>
                    <div class="col-sm-2" style="padding-bottom: 10px;">
                        <label>Gider Türü</label>
                        <select id="select2-demo-1" class="form-control" style="width: 100%" required
                                data-plugin="select2" name="gider_turu">
                            <option selected="selected[]">Seçiniz</option>
                            <?php foreach (get_as_array($settings->harcama_tur) as $harcama_tur) { ?>
                                <option value="<?php echo $harcama_tur; ?>"><?php echo $harcama_tur; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2" style="padding-bottom: 10px;">
                        <label>Tutar</label>
                        <div class="input-group">
                            <input type="number" step="any" name="tutar" class="form-control">
                            <span class="input-group-addon">TL</span>
                        </div>
                    </div>

                    <div class="col-sm-2" style="padding-bottom: 10px;">
                        <label>Ödeme Türü</label>
                        <select id="select2-demo-1" class="form-control" style="width: 100%" required
                                data-plugin="select2" name="odeme_tur">
                            <option selected="selected[]">Seçiniz</option>
                            <?php foreach (get_as_array($settings->odeme_tur) as $odeme_tur) { ?>
                                <option value="<?php echo $odeme_tur; ?>"><?php echo $odeme_tur; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-sm-2" style="padding-bottom: 10px;">
                        <label>Belge Türü</label>
                        <select id="select2-demo-1" class="form-control" style="width: 100%" required
                                data-plugin="select2" name="belge_tur">
                            <option selected="selected[]"
                                    value="<?php echo isset($form_error) ? cms_if_echo(set_value("belge_tur"), null, "", set_value("belge_tur")) : "" ?>">
                                <?php echo isset($form_error) ? cms_if_echo(set_value("belge_tur"), null, "Seçiniz", set_value("belge_tur")) : "Seçiniz"; ?>
                            </option>
                            <?php foreach (get_as_array($settings->belge_tur) as $belge_tur) { ?>
                                <option value="<?php echo $belge_tur; ?>"><?php echo $belge_tur; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-sm-3" style="padding-bottom: 10px;">
                        <label>Açıklama</label>
                        <input type="text" class="form-control" required name="aciklama">
                    </div>
                    <div class="col-sm-1" style="padding-bottom: 10px;" required>
                        <label>&nbsp;</label>
                        <input data-repeater-delete type="button" class="btn btn-danger form-control"
                               value="Satır Sil"/>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>
