<div class="repeater">
    <div class="row">
        <div class="form-group col-sm-12 text-center">
            <label><h3><?php echo $site->santiye_ad; ?> Şantiyesi<br> Harcama Girişi</h3></label>
        </div>
        <div class="form-group col-sm-4 col-sm-offset-4 text-center">
            <div class="form-group">
                <label>Dosya No</label>
                <div class="input-group col-sm-6 col-sm-offset-3">
                    <span class="input-group-addon">SH</span>
                    <?php if (!empty(get_last_fn("sitewallet"))) { ?>
                        <input type="number" name="dosya_no" class="form-control" required
                               value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("sitewallet"); ?>">
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
        </div>

    </div>
</div>


<div class="repeater">
    <div class="row">
        <div data-repeater-list="expenses">
            <input data-repeater-create type="button" class="btn btn-success" value="Harcama Satırı Ekle"/>
            <hr>
            <div data-repeater-item>
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



