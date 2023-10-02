<h3>Yakıt İkmal Bilgileri</h3>
<div class="row">
    <div class="col-sm-2">
        <label>Araç Plaka</label>
        <h3><span><?php echo get_from_any("vehicle","plaka","id","$item->vehicle_id"); ?></span></h3>
    </div>
    <div class="col-sm-3">
        <label>İkmal Tarihi</label>
        <input type="text" id="datetimepicker" class="form-control"
               name="ikmal_tarih"
               value="<?php echo isset($form_error) ? set_value("ikmal_tarih") : dateFormat('d-m-Y',$item->ikmal_tarih); ?>"
               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ikmal_tarih"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-3">
        <label>İkmal Anında Km/Saat</label>
        <input type="number" step=".01" name="ikmal_km_saat" class="form-control"
               value="<?php echo isset($form_error) ? set_value("ikmal_km_saat") : $item->ikmal_km_saat; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ikmal_km_saat"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-3">
        <label>Saat/Km</label>
        <select name="km_saat" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("km_saat") : $item->km_saat; ?>"><?php echo isset($form_error) ? km_saat(set_value("km_saat")) : km_saat($item->km_saat);; ?></option>
            <option value="1">Saat</option>
            <option value="2">Km</option>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("km_saat"); ?></div>
        <?php } ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-3">
        <label>Yakıt</label>
        <select name="fuel_type" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("fuel_type") : $item->fuel_type; ?>"><?php echo isset($form_error) ? fuel(set_value("fuel_type")) : fuel($item->fuel_type);; ?></option>
            <option value="1">Dizel</option>
            <option value="2">Benzin</option>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("fuel_type"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-3">
        <label>İkmal Miktar (Lt)</label>
        <input type="number" step=".01" id="A" name="ikmal_miktar" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("ikmal_miktar") : $item->ikmal_miktar; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ikmal_miktar"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-3">
        <label>Birim Fiyat (KDV Dahil)</label>
        <input type="number" step=".01" id="B" name="ikmal_bf" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("ikmal_bf") : $item->ikmal_bf; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ikmal_bf"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-3">
        <label>Toplam Tutar (KDV Dahil)</label>
        <input type="number" step=".01" id="C" name="ikmal_tutar" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("ikmal_tutar") : $item->ikmal_tutar; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ikmal_tutar"); ?></div>
        <?php } ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-12">
        <label>Açıklama</label>
        <input class="form-control" name="aciklama" placeholder="Varsa özel notunuzu ekleyiniz" value="<?php echo isset($form_error) ? set_value("aciklama") : $item->aciklama; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("aciklama"); ?></div>
        <?php } ?>
    </div>

</div>
