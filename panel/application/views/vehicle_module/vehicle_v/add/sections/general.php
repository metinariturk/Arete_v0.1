<h3>Genel Bilgiler</h3>

<div class="row">

    <div class="col-sm-1">
        <label>Kiralık</label><br>
        <input
                name="kiralik"
                class="isActive"
                type="checkbox"
                data-switchery
                data-color="#10c469"
        />
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("kiralik"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Yakıt</label>
        <select name="yakit" class="form-control">
            <option value="<?php echo isset($form_error) ? set_value("yakit") : "Seçiniz"; ?>">
                <?php echo isset($form_error) ? cms_if_echo(set_value("yakit"),"1","Dizel","Benzin") : "Seçiniz"; ?>
            </option>
            <option value="1">Dizel</option>
            <option value="0">Benzin</option>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("yakit"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Yakıt Takibi</label>
        <select name="yakit_takip" class="form-control">
            <option value="<?php echo isset($form_error) ? set_value("yakit_takip") : "Seçiniz"; ?>">
                <?php echo isset($form_error) ? km_saat(set_value("yakit_takip")) : "Seçiniz"; ?>
            </option>
            <option value="1">Saat</option>
            <option value="2">Km</option>
        </select>
        <small class="pull-left">*İş makineleri için motor saati, binek araçlar ve kamyonlar için KM önerilir.</small>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("yakit"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Aracın İlk Kilometresi</label>
        <input type="text" name="km" class="form-control"
               value="<?php echo isset($form_error) ? set_value("km") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("km"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Aracın İlk Saati</label>
        <input type="text" name="saat" class="form-control"
               value="<?php echo isset($form_error) ? set_value("saat") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("saat"); ?></div>
        <?php } ?>
    </div>
</div>
