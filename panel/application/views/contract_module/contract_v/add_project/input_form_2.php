<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="row">
                <div class="col-6">
                    <div class="col-form-label">Sözleşme İmza Tarihi</div>
                    <input class="datepicker-here form-control digits <?php cms_isset(form_error("sozlesme_tarih"), "is-invalid", ""); ?>"
                           type="text"
                           name="sozlesme_tarih"
                           value="<?php echo isset($form_error) ? set_value("sozlesme_tarih") : ""; ?>"
                           data-options="{ format: 'DD-MM-YYYY' }"
                           data-language="tr">
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("sozlesme_tarih"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-6">
                    <div class="col-form-label">İşin Süresi (Gün)</div>
                    <input type="number" min="1" step="any" onblur=""
                           class="form-control <?php cms_isset(form_error("isin_suresi"), "is-invalid", ""); ?>"
                           name="isin_suresi"
                           value="<?php echo isset($form_error) ? set_value("isin_suresi") : ""; ?>"
                    >
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("isin_suresi"); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-6">
                    <div class="col-form-label">Sözleşme Bedel</div>
                    <input type="number" min="1" step="any" onblur=""
                           class="form-control <?php cms_isset(form_error("sozlesme_bedel"), "is-invalid", ""); ?>"
                           name="sozlesme_bedel"
                           value="<?php echo isset($form_error) ? set_value("sozlesme_bedel") : ""; ?>"
                    >
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("sozlesme_bedel"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-6">
                    <div class="col-form-label">Para Birimi</div>
                    <select id="select2-demo-1" style="width: 100%;"
                            class="form-control <?php cms_isset(form_error("sozlesme_tarih"), "is-invalid", ""); ?>"
                            data-plugin="select2"
                            name="para_birimi">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? set_value("para_birimi") : ""; ?>">
                            <?php echo isset($form_error) ? set_value("para_birimi") : ""; ?>
                        </option>
                        <?php
                        $para_birimleri = get_as_array($settings->para_birimi);
                        foreach ($para_birimleri as $para_birimi) {
                            echo "<option value='$para_birimi'>$para_birimi</option>";
                        }
                        ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("para_birimi"); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-8">
                    <div class="col-form-label">Teklif Yapan Kuruluş</div>
                    <select id="select2-demo-1"
                            class="form-control <?php cms_isset(form_error("isveren"), "is-invalid", ""); ?>"
                            data-plugin="select2" name="isveren">
                        <option value="<?php echo isset($form_error) ? set_value("isveren") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("isveren")) : ""; ?></option>
                        <?php foreach ($isverenler as $isveren) { ?>
                            <option value="<?php echo $isveren->id; ?>"><?php echo $isveren->company_name; ?></option>
                        <?php } ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("isveren"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-4">
                    <div class="col-form-label">İşveren Yetkili</div>
                    <select id="select2-demo-1"
                            class="form-control <?php cms_isset(form_error("isveren_yetkili"), "is-invalid", ""); ?>"
                            data-plugin="select2" name="isveren_yetkili">
                        <option value="<?php echo isset($form_error) ? set_value("isveren_yetkili") : ""; ?>"><?php echo isset($form_error) ? full_name(set_value("isveren_yetkili")) : ""; ?></option>
                        <?php foreach ($isveren_users as $isveren_user) { ?>
                            <option value="<?php echo $isveren_user->id; ?>"><?php echo full_name($isveren_user->id); ?></option>
                        <?php } ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("isveren_yetkili"); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-8">
                    <div class="col-form-label">Yüklenici</div>
                    <select id="select2-demo-1"
                            class="form-control <?php cms_isset(form_error("yuklenici"), "is-invalid", ""); ?>"
                            data-plugin="select2" name="yuklenici">
                        <option value="<?php echo isset($form_error) ? set_value("yuklenici") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("yuklenici")) : ""; ?></option>
                        <?php foreach ($yukleniciler as $yuklenici) { ?>
                            <option value="<?php echo $yuklenici->id; ?>"><?php echo company_name($yuklenici->id); ?></option>
                        <?php } ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("yuklenici"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-4">
                    <div class="col-form-label">Yüklenici Yetkili</div>
                    <select id="select2-demo-1"
                            class="form-control <?php cms_isset(form_error("yuklenici_yetkili"), "is-invalid", ""); ?>"
                            data-plugin="select2" name="yuklenici_yetkili">
                        <option value="<?php echo isset($form_error) ? set_value("yuklenici_yetkili") : ""; ?>"><?php echo isset($form_error) ? full_name(set_value("yuklenici_yetkili")) : ""; ?></option>
                        <?php foreach ($yuklenici_users as $yuklenici_user) { ?>
                            <option value="<?php echo $yuklenici_user->id; ?>"><?php echo full_name($yuklenici_user->id); ?></option>
                        <?php } ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("yuklenici_yetkili"); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-6">
                    <div class="col-form-label">Adres</div>
                    <input class="form-control" placeholder="Adres"
                           name="adres"
                           value="<?php echo isset($form_error) ? set_value("adres") : ""; ?>"/>
                </div>
                <div class="col-3">
                    <div class="col-form-label">İl</div>

                    <select name="adress_city" class="form-control">
                        <option id="adress_cityOption" selected
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
                </div>
                <div class="col-3">
                    <div class="col-form-label">İlçe</div>

                    <select name="adress_district" class="form-control">
                        <option id="adress_districtOption" selected
                                value="<?php echo isset($form_error) ? set_value("adress_district") : ""; ?>">
                            <?php echo isset($form_error) ? district_name(set_value("adress_district")) : ""; ?>
                        </option>
                        <?php if (set_value("adress_city") > 0) { ?>
                            <?php $error_districts = get_from_any_array("district", "city_id", set_value("adress_city")); ?>
                            <?php foreach ($error_districts as $error_district) { ?>
                                <option value="<?php echo $error_district->id; ?>"><?php echo district_name($error_district->id); ?></option>
                            <?php } ?>
                        <?php } else { ?>
                            <?php foreach ($distircts as $distirct) { ?>
                                <option value="<?php echo $distirct->id; ?>"><?php echo district_name($distirct->id); ?></option>
                            <?php } ?>
                        <?php } ?>


                    </select>
                </div>
            </div>
        </div>
    </div>
</div>