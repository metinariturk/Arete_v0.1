<h3>Poliçe Bilgileri</h3>
<div class="row">
    <div class="col-sm-2">
        <label>Araç Plaka</label>
        <?php if ($vehicle_id == null) { ?>
            <select name="vehicle_id" class="form-control" data-plugin="select2">
                <option value="">Seçiniz</option>
                <?php foreach ($vehicles as $vehicle) { ?>
                    <option value="<?php echo $vehicle->id; ?>"><?php echo $vehicle->plaka; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("vehicle_id"); ?></div>
            <?php } ?>
        <?php } else { ?>
            <h4>
                    <span>
                        <?php echo get_from_any("vehicle", "plaka", "id", "$vehicle_id"); ?>
                    </span>
            </h4>
            <input type="text" hidden
                   name="vehicle_id"
                   value="<?php echo $vehicle_id; ?>">
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Sigorta/Kasko Kapsamı</label>
        <?php if (!isset($kapsam)){ ?>
        <select name="kapsam" class="form-control" style="width: %100" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? kapsam(set_value("kapsam")) : ""; ?>"><?php echo isset($form_error) ? kapsam(set_value("kapsam")) : "Seçiniz"; ?></option>
            <option value="1">Zorunlu Trafik Sigortası</option>
            <option value="2">Kasko</option>
        </select>
        <?php } else { ?>
            <select name="kapsam" class="form-control" style="width: %100" data-plugin="select2">
                <option value="<?php echo $kapsam; ?>"><?php echo kapsam($kapsam); ?></option>
            </select>
        <?php } ?>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("kapsam"); ?></div>
        <?php } ?>
    </div>



    <div class="col-sm-2">
        <label>Sigorta/Kasko Başlangıç Tarih</label>
        <input type="text" id="datetimepicker" class="form-control"
               name="baslangic"
               value="<?php echo isset($form_error) ? set_value("baslangic") : ""; ?>"
               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("baslangic"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Sigorta/Kasko Bitiş Tarih</label>
        <input type="text" id="datetimepicker" class="form-control"
               name="bitis"
               value="<?php echo isset($form_error) ? set_value("bitis") : ""; ?>"
               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("bitis"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Poliçe Düzenlenme Tarihi</label>
        <input type="text" id="datetimepicker" class="form-control"
               name="duzenlenme"
               value="<?php echo isset($form_error) ? set_value("duzenlenme") : ""; ?>"
               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("duzenlenme"); ?></div>
        <?php } ?>
    </div>

    <div class="col-sm-2">
        <label>Poliçe No</label>
        <input type="text" class="form-control"
               name="police_no" placeholder="İnce İşler, Kaba İşler, Elektrik vs..."
               value="<?php echo isset($form_error) ? set_value("police_no") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("police_no"); ?></div>
        <?php } ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-2">
        <label>Sigorta/Kasko Firma</label>
        <select name="sigorta_firma" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("sigorta_firma") : ""; ?>"><?php echo isset($form_error) ? set_value("sigorta_firma") : "Seçiniz"; ?></option>
            <?php $sigortalar = str_getcsv($settings->sigorta);
            foreach ($sigortalar as $sigorta) {
                echo "<option value='$sigorta'>$sigorta</option>";
            } ?>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("sigorta_firma"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Prim Tutar</label>
        <input type="number"
               min="1" step="any"
               class="form-control"
               name="prim_bedel"
               placeholder="Prim Tutarı"
               value="<?php echo isset($form_error) ? set_value("prim_bedel") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("prim_bedel"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Acente Adı</label>
        <input type="text" class="form-control"
               name="acente_ad" placeholder="Acente Adı"
               value="<?php echo isset($form_error) ? set_value("acente_ad") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("acente_ad"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Acente Telefon</label>
        <input type="number" class="form-control"
               name="acente_tel" placeholder="05452344264"
               value="<?php echo isset($form_error) ? set_value("acente_tel") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("acente_tel"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Acente Adres</label>
        <input type="text" class="form-control"
               name="acente_adres" placeholder="Adres"
               value="<?php echo isset($form_error) ? set_value("acente_adres") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("acente_adres"); ?></div>
        <?php } ?>
    </div>

</div>