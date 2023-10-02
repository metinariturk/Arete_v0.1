<h3>Servis/Bakım Bilgileri</h3>
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
        <label>Servis/Bakım Gerekçesi</label>
        <select name="gerekce" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("gerekce") : ""; ?>"><?php echo isset($form_error) ? servis_gerekce(set_value("gerekce")) : "Seçiniz"; ?></option>
            <option value="1">Periyodik Bakım</option>
            <option value="2">Arıza</option>
            <option value="3">Muayene (TÜV)</option>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("gerekce"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Servis/Bakım Tarihi</label>
        <input type="text" id="datetimepicker" class="form-control"
               name="servis_tarih"
               value="<?php echo isset($form_error) ? set_value("servis_tarih") : ""; ?>"
               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("servis_tarih"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Servis/Bakım (Saat-Km)</label>
        <input type="text" class="form-control"
               name="servis_km_saat" placeholder="Saat ya da Km"
               value="<?php echo isset($form_error) ? set_value("servis_km_saat") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("servis_km_saat"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Saat/Km</label>
        <select name="km_saat" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("km_saat") : null; ?>"><?php echo isset($form_error) ? km_saat(set_value("km_saat")) : "Seçiniz"; ?></option>
            <option value="1">Saat</option>
            <option value="2">Km</option>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("km_saat"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Servis/Bakım/Muayene İşlemi</label>
        <select name="islem_turu" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("islem_turu") : ""; ?>"><?php echo isset($form_error) ? islem_turu(set_value("islem_turu")) : "Seçiniz"; ?></option>
            <option value="1">Lastik Hasar</option>
            <option value="2">Motor Hasar</option>
            <option value="3">Kaporta Hasar</option>
            <option value="4">Genel Bakım</option>
            <option value="5">Periyodik Kontrol</option>
            <option value="6">Hidrolik</option>
            <option value="7">Şanzuman</option>
            <option value="8">Diğer</option>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("islem_turu"); ?></div>
        <?php } ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-2">
        <label>Servis Sağlayan Firma</label>
        <select name="servis_firma" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("servis_firma") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("servis_firma")) : "Seçiniz"; ?></option>
            <?php foreach ($not_employers as $not_employer) { ?>
                <option value="<?php echo $not_employer->id; ?>"><?php echo $not_employer->company_name; ?></option>
            <?php } ?>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("servis_firma"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-4">
        <label>Servis/Bakım Açıklama</label>
        <textarea class="form-control" id="textarea1" name="genel_bilgi" placeholder="Açıklama"><?php echo isset($form_error) ? set_value("fiyat") : ""; ?>
        </textarea>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("genel_bilgi"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Tutar (KDV Dahil)</label>
        <input type="number"
               min="1" step="any"
               class="form-control"
               name="fiyat"
               placeholder="Servis Tutarı"
               value="<?php echo isset($form_error) ? set_value("fiyat") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("fiyat"); ?></div>
        <?php } ?>
    </div>
</div>