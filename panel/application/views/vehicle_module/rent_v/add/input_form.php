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
        <label>Kiralama Şekli</label>
        <select name="kiralama_turu" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? kiralama_turu(set_value("kiralama_turu")) : ""; ?>"><?php echo isset($form_error) ? kiralama_turu(set_value("kiralama_turu")) : "Seçiniz"; ?></option>
            <option value="1">Aylık</option>
            <option value="2">Yıllık</option>
            <option value="3">Günlük</option>
            <option value="4">Saatlik</option>
            <option value="5">Götürü Bedel</option>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("kiralama_turu"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Kiralama Başlangıç Tarih</label>
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
        <label>Kiralama Bitiş Tarih</label>
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
        <label>Kiralama Süresi</label>
        <input type="text" class="form-control"
               name="sure" placeholder="Saat / Gün / Ay / Yıl"
               value="<?php echo isset($form_error) ? set_value("sure") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("sure"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Fiyat</label>
        <input type="number"
               min="1" step="any"
               class="form-control"
               name="fiyat"
               placeholder="Fiyat"
               value="<?php echo isset($form_error) ? set_value("fiyat") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("fiyat"); ?></div>
        <?php } ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-2">
        <label>Kiralayan Firma</label>
        <select name="kiralayan_firma" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("kiralayan_firma") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("kiralayan_firma")) : "Seçiniz"; ?></option>
            <?php foreach ($employers as $employer) { ?>
                    <option value="<?php echo $employer->id; ?>"><?php echo $employer->company_name; ?></option>
                <?php } ?>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("kiralayan_firma"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Kiralanan Firma</label>
        <select name="kiralanan_firma" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("kiralanan_firma") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("kiralanan_firma")) : "Seçiniz"; ?></option>
             <?php foreach ($not_employers as $not_employer) { ?>
                    <option value="<?php echo $not_employer->id; ?>"><?php echo $not_employer->company_name; ?></option>
                <?php } ?>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("kiralanan_firma"); ?></div>
        <?php } ?>
    </div>

    <div class="col-sm-2">
        <label>Yakıt Bedeli</label>
        <select name="yakit" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("yakit") : ""; ?>"><?php echo isset($form_error) ? liability(set_value("yakit")) : "Seçiniz"; ?></option>
            <option value="1">Kiralayan'a Ait</option>
            <option value="2">Kiraya Veren'e Ait</option>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("yakit"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Operatör Bedeli</label>
        <select name="operator" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("operator") : ""; ?>"><?php echo isset($form_error) ? liability(set_value("operator")) : "Seçiniz"; ?></option>
            <option value="1">Kiralayan'a Ait</option>
            <option value="2">Kiraya Veren'e Ait</option>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("operator"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Bakım/Servis/Arıza Bedeli</label>
        <select name="bakim_servis" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("bakim_servis") : ""; ?>"><?php echo isset($form_error) ? liability(set_value("bakim_servis")) : "Seçiniz"; ?></option>
            <option value="1">Kiralayan'a Ait</option>
            <option value="2">Kiraya Veren'e Ait</option>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("bakim_servis"); ?></div>
        <?php } ?>
    </div>

</div>