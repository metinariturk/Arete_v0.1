<h3>Ruhsat Bilgileri</h3>

<div class="row">
    <div class="col-sm-3">
        <label>Plaka/Tescil Plaka No
            <span data-tooltip-location="bottom"
                  data-tooltip="Bu karakterleri kullanamazsınız
?*:/@|<-çÇğĞüÜöÖıİşŞ.!'?*|=()[]{}>"><i class="fas fa-info-circle"></i></span>
        </label>
        <input type="text" name="plaka" class="form-control" placeholder="34 AAA 111 veya 40-00-52-11-3214"
               value="<?php echo isset($form_error) ? set_value("plaka") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("plaka"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Motor No</label>
        <input type="text" name="motor_no" class="form-control"
               value="<?php echo isset($form_error) ? set_value("motor_no") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("motor_no"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Şase No</label>
        <input type="text" name="sase_no" class="form-control"
               value="<?php echo isset($form_error) ? set_value("sase_no") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("sase_no"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-1">
        <label>Model Yılı</label>
        <input type="text" id="datetimepicker" class="form-control"
               name="model"
               value="<?php echo isset($form_error) ? set_value("model") : ""; ?>"
               data-plugin="datetimepicker" data-options="{ format: 'YYYY' }">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("model"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Markası</label>
        <input type="text" name="marka" class="form-control" placeholder="Volvo - Skoda vs."
               value="<?php echo isset($form_error) ? set_value("marka") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("marka"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Ticari Adı</label>
        <input type="text" name="ticari_ad" class="form-control" placeholder="Superb - 4CX - 950H vs."
               value="<?php echo isset($form_error) ? set_value("ticari_ad") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ticari_ad"); ?></div>
        <?php } ?>
    </div>

</div>
<div class="row">
    <div class="col-sm-2">
        <label>İlk Tescil Tarihi</label>
        <input type="text" id="datetimepicker" class="form-control"
               name="ilk_tescil"
               value="<?php echo isset($form_error) ? set_value("ilk_tescil") : ""; ?>"
               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("ilk_tescil"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Tescil Tarihi</label>
        <input type="text" id="datetimepicker" class="form-control"
               name="tescil_tarih"
               value="<?php echo isset($form_error) ? set_value("tescil_tarih") : ""; ?>"
               data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("tescil_tarih"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Tescil Sıra No</label>
        <input type="text" name="tescil_no" class="form-control"
               value="<?php echo isset($form_error) ? set_value("tescil_no") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("tescil_no"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Tipi</label>
        <input type="text" name="tipi" class="form-control"
               value="<?php echo isset($form_error) ? set_value("tipi") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("tipi"); ?></div>
        <?php } ?>
    </div>


    <div class="col-sm-2">
        <label>Araç Sınıfı</label>
        <input type="text" name="sinif" class="form-control"
               value="<?php echo isset($form_error) ? set_value("sinif") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("sinif"); ?></div>
        <?php } ?>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("sinif"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Cinsi</label>
        <input type="text" name="cins" class="form-control"
               value="<?php echo isset($form_error) ? set_value("cins") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("cins"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Rengi</label>
        <input type="text" name="renk" class="form-control"
               value="<?php echo isset($form_error) ? set_value("renk") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("renk"); ?></div>
        <?php } ?>
    </div>

    <div class="col-sm-2">
        <label>Kullanım Amacı</label>
        <input type="text" name="amac" class="form-control"
               value="<?php echo isset($form_error) ? set_value("amac") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("amac"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Vergi No</label>
        <input type="text" name="vergi_no" class="form-control"
               value="<?php echo isset($form_error) ? set_value("vergi_no") : null; ?>">
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("vergi_no"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Araç Sahibi</label>
        <select name="sahibi" class="form-control" data-plugin="select2">
            <option value="<?php echo isset($form_error) ? set_value("sahibi") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("sahibi")) : "Seçiniz"; ?></option>
            <?php foreach ($companys as $company) { ?>
                <option value="<?php echo $company->id; ?>"><?php echo $company->company_name; ?></option>
            <?php } ?>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("kiralayan_firma"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Adres İl</label>
        <select name="adress_city" class="form-control">
            <option id="adress_cityOption"
                    value="<?php echo isset($form_error) ? set_value("adress_city") : ""; ?>"
                    data-url="<?php echo base_url("$this->Module_Name/get_district/"); ?>"
            >
                <?php echo isset($form_error) ? city_name(set_value("adress_city")) : ""; ?>
            </option>
            <?php foreach ($cities as $city) { ?>
                <option id="tax_cityOption"
                        data-url="<?php echo base_url("$this->Module_Name/get_district/"); ?>"
                        value="<?php echo $city->id; ?>"><?php echo $city->city_name; ?></option>
            <?php } ?>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("adress_city"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-2">
        <label>Adres İlçe</label>
        <select name="adress_district" class="form-control">
            <option value="<?php echo isset($form_error) ? set_value("adress_district") : ""; ?>">
                <?php echo isset($form_error) ? district_name(set_value("adress_district")) : ""; ?>
            </option>
        </select>
        <?php if (isset($form_error)) { ?>
            <small class="pull-left input-form-error"> <?php echo form_error("adress_district"); ?></div>
        <?php } ?>
    </div>
</div>
