<table class="table" style="height: 400px">
    <tbody>
    <tr>
        <td style="width: 15%"><b>Adres</b></td>
        <td>
            <input class="form-control" placeholder="Adres"
                   name="adres"
                   value="<?php echo isset($form_error) ? set_value("adres") : "$item->adres"; ?>"/>
        </td>
    <tr>
    <tr>
        <td style="width: 15%"><b>İl</b></td>
        <td>
            <select name="adress_city" class="form-control">
                <option value="">Seçiniz</option>
                <option selected id="adress_cityOption"
                        value="<?php echo isset($form_error) ? set_value("adress_city") : "$item->adres_il"; ?>"
                        data-url="<?php echo base_url("$this->Module_Name/get_district/"); ?>">
                    <?php echo isset($form_error) ? city_name(set_value("adress_city")) : city_name($item->adres_il); ?>
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
        </td>
    </tr>
    <tr>
        <td style="width: 15%"><b>İlçe</b></td>
        <td>
            <select name="adress_district" class="form-control">
                <option value="">Seçiniz</option>
                <option selected value="<?php echo isset($form_error) ? set_value("adress_district") : $item->adres_ilce; ?>">
                    <?php echo isset($form_error) ? district_name(set_value("adress_district")) : district_name($item->adres_ilce); ?>
                </option>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("adress_district"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Ada/Pafta/Parsel</b></td>
        <td>
            <div class="row">
                <div class="col-sm-4 col-md-12">
                    <input class="form-control" placeholder="Ada"
                           name="ada"
                           value="<?php echo isset($form_error) ? set_value("ada") : "$item->ada"; ?>"/>
                </div>
                <div class="col-sm-4 col-md-12">
                    <input class="form-control" placeholder="Pafta"
                           name="pafta"
                           value="<?php echo isset($form_error) ? set_value("pafta") : "$item->pafta"; ?>"/>
                </div>
                <div class="col-sm-4 col-md-12">
                    <input class="form-control" placeholder="Parsel"
                           name="parsel"
                           value="<?php echo isset($form_error) ? set_value("parsel") : "$item->parsel"; ?>"/>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>

