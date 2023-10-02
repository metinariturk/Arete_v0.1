<h3>Yakıt Dolum Bilgileri</h3>
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
    <div class="col-sm-3">
        <label>İkmal Tarihi</label>
        <input type="text" id="datetimepicker" class="form-control"
               name="ikmal_tarih"
               value="<?php echo isset($form_error) ? set_value("ikmal_tarih") : ""; ?>"
               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ikmal_tarih"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-3">
        <?php $last_km_saat = get_last_fuel($vehicle_id, "ikmal_km_saat"); ?>
        <label>İkmal Anında Km/Saat</label>
        <input type="text" id="X" onblur="calcular()" onfocus="calcular()" hidden
               value="<?php echo $last_km_saat; ?>">
        <input type="number" step=".01" id="Y" name="ikmal_km_saat" class="form-control" onblur="calcular()" onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("ikmal_km_saat") : ""; ?>">
        <label>*Son İkmal <?php echo $last_km_saat; ?></label>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ikmal_km_saat"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-3">
        <label>Son İkmalden Sonra</label>
        <input type="number" step=".01" id="Q" name="fark" class="form-control" onblur="calcular()" onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("fark") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("fark"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-1">
        <label>Saat/Km</label>
        <?php if ($vehicle_id == null) { ?>
            <select name="km_saat" class="form-control" data-plugin="select2">
                <option value="<?php echo isset($form_error) ? set_value("km_saat") : null; ?>"><?php echo isset($form_error) ? km_saat(set_value("km_saat")) : "Seçiniz"; ?></option>
                <option value="1">Saat</option>
                <option value="2">Km</option>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("km_saat"); ?></div>
            <?php } ?>
        <?php } else { ?>
            <h4>
                    <span>
                        <?php $yakit_takip = get_from_any("vehicle", "yakit_takip", "id", "$vehicle_id");
                        echo km_saat($yakit_takip);?>
                    </span>
            </h4>
            <input type="text" hidden
                   name="km_saat"
                   value="<?php echo $yakit_takip; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("km_saat"); ?></div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-2">
        <label>Yakıt</label>
        <?php if ($vehicle_id == null) { ?>
            <select name="fuel_type" class="form-control" data-plugin="select2">
                <option value="<?php echo isset($form_error) ? set_value("fuel_type") : ""; ?>"><?php echo isset($form_error) ? fuel(set_value("fuel_type")) : "Seçiniz"; ?></option>
                <option value="1">Dizel</option>
                <option value="2">Benzin</option>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("vehicle_id"); ?></div>
            <?php } ?>
        <?php } else { ?>
            <h4>
                    <span>
                        <?php $yakit = get_from_any("vehicle", "yakit", "id", "$vehicle_id");
                        echo fuel($yakit);?>
                    </span>
            </h4>
            <input type="text" hidden
                   name="fuel_type"
                   value="<?php echo $yakit; ?>">
        <?php } ?>
    </div>


    <div class="col-sm-3">
        <label>İkmal Miktar (Lt)</label>
        <input type="number" step=".01" id="A" name="ikmal_miktar" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("ikmal_miktar") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ikmal_miktar"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-3">
        <label>Birim Fiyat (KDV Dahil)</label>
        <input type="number" step=".01" id="B" name="ikmal_bf" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("ikmal_bf") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ikmal_bf"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Toplam Tutar (KDV Dahil)</label>
        <input type="number" step=".01" id="C" name="ikmal_tutar" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("ikmal_tutar") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ikmal_tutar"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Ortalama Tüketim</label>
        <input type="number" step="any" id="Z" name="ortalama" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("ortalama") : ""; ?>">
        <label>(Lire/Km_Saat)</label>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ortalama"); ?></div>
        <?php } ?>
    </div>
</div>
<hr>
<div class="row">

    <div class="col-sm-12">
        <label>Açıklama</label>
        <input class="form-control" name="aciklama" placeholder="Varsa özel notunuzu ekleyiniz">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("aciklama"); ?></div>
        <?php } ?>
    </div>

</div>

