<div class="card">
    <div class="card-header">
        <div class="mb-2">
            <div class="row">
                <div class="col-12">
                    <div class="col-form-label">Sözleşme Ad</div>
                    <input class="form-control <?php cms_isset(form_error("sozlesme_ad"), "is-invalid", ""); ?>"
                           name="sozlesme_ad"
                           value="<?php echo isset($form_error) ? set_value("sozlesme_ad") : $item->sozlesme_ad; ?>"/>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("sozlesme_ad"); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-6">
                    <div class="col-form-label">Teklif Türü</div>
                    <select id="select2-demo-1"
                            class="form-control <?php cms_isset(form_error("sozlesme_turu"), "is-invalid", ""); ?>"
                            data-plugin="select2"
                            name="sozlesme_turu">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? cms_if_echo(set_value("sozlesme_turu"), null, "", set_value("sozlesme_turu")) : $item->sozlesme_turu; ?>">
                            <?php echo isset($form_error) ? cms_if_echo(set_value("sozlesme_turu"), null, "Seçiniz", set_value("sozlesme_turu")) : $item->sozlesme_turu; ?>
                        </option>
                        <?php
                        $teklif_turleri = get_as_array($settings->sozlesme_turu);
                        foreach ($teklif_turleri as $teklif_tur) { ?>
                            <option value="<?php echo $teklif_tur; ?>"><?php echo $teklif_tur; ?></option>";
                        <?php } ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("sozlesme_turu"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-6">
                    <div class="col-form-label">İşin Türü</div>
                    <select id="select2-demo-1"
                            class="form-control <?php cms_isset(form_error("isin_turu"), "is-invalid", ""); ?>"
                            data-plugin="select2"
                            name="isin_turu">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? cms_if_echo(set_value("isin_turu"), null, "", set_value("isin_turu")) : $item->isin_turu; ?>">
                            <?php echo isset($form_error) ? cms_if_echo(set_value("isin_turu"), null, "Seçiniz", set_value("isin_turu")) : $item->isin_turu; ?>
                        </option>
                        <?php
                        $is_turleri = get_as_array($settings->isin_turu);
                        foreach ($is_turleri as $is_turu) { ?>
                            <option value="<?php echo $is_turu; ?>"><?php echo $is_turu; ?></option>";
                        <?php } ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("isin_turu"); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-4">
                    <div class="col-form-label">Sözleşme İmza Tarihi</div>
                    <input class="datepicker-here form-control digits <?php cms_isset(form_error("sozlesme_tarih"), "is-invalid", ""); ?>"
                           type="text"
                           name="sozlesme_tarih"
                           value="<?php echo isset($form_error) ? set_value("sozlesme_tarih") : dateFormat_dmy($item->sozlesme_tarih); ?>"
                           data-options="{ format: 'DD-MM-YYYY' }"
                           data-language="tr">
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("sozlesme_tarih"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-4">
                    <div class="col-form-label">Yer Teslimi Tarihi</div>
                    <input class="datepicker-here form-control digits <?php cms_isset(form_error("sitedel_date"), "is-invalid", ""); ?>"
                           type="text"
                           name="sitedel_date"
                           value="<?php echo isset($form_error) ? set_value("sitedel_date") : dateFormat_dmy($item->sitedel_date); ?>"
                           data-options="{ format: 'DD-MM-YYYY' }"
                           data-language="tr">
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("sitedel_date"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-4">
                    <div class="col-form-label">İşin Süresi (Gün)</div>
                    <input class="form-control <?php cms_isset(form_error("isin_suresi"), "is-invalid", ""); ?>"
                           name="isin_suresi" type="number"
                           value="<?php echo isset($form_error) ? set_value("isin_suresi") : $item->isin_suresi; ?>"/>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("isin_suresi"); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-5">
                    <div class="col-form-label">Sözleşme Bedel</div>
                    <input type="number" min="1" step="any" onblur=""
                           class="form-control <?php cms_isset(form_error("sozlesme_bedel"), "is-invalid", ""); ?>"
                           name="sozlesme_bedel"
                           value="<?php echo isset($form_error) ? set_value("sozlesme_bedel") : $item->sozlesme_bedel; ?>"
                    >
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("sozlesme_bedel"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-3">
                    <div class="col-form-label">Para Birimi</div>
                    <select id="select2-demo-1" style="width: 100%;" class="form-control" data-plugin="select2"
                            name="para_birimi">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? set_value("para_birimi") : "$item->para_birimi"; ?>">
                            <?php echo isset($form_error) ? set_value("para_birimi") : "$item->para_birimi"; ?>
                        </option>
                        <?php
                        $para_birimleri = str_getcsv($settings->para_birimi);
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
                    <div class="col-form-label">Teklif Verilecek Kuruluş</div>
                    <select id="select2-demo-1"
                            class="form-control <?php cms_isset(form_error("isveren"), "is-invalid", ""); ?>"
                            data-plugin="select2" name="isveren">
                        <option value="<?php echo isset($form_error) ? set_value("isveren") : "$item->isveren"; ?>"><?php echo isset($form_error) ? company_name(set_value("isveren")) : company_name($item->isveren); ?></option>
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
                        <option selected
                                value="<?php echo isset($form_error) ? set_value("isveren_yetkili") : $item->isveren_yetkili; ?>"><?php echo isset($form_error) ? full_name(set_value("isveren_yetkili")) : full_name($item->isveren_yetkili); ?></option>
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
                        <option value="<?php echo isset($form_error) ? set_value("yuklenici") : "$item->yuklenici"; ?>"><?php echo isset($form_error) ? company_name(set_value("yuklenici")) : company_name($item->yuklenici); ?></option>
                        <?php foreach ($yukleniciler as $yuklenici) { ?>
                            <option value="<?php echo $yuklenici->id; ?>"><?php echo $yuklenici->company_name; ?></option>
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
                        <option value="<?php echo isset($form_error) ? set_value("yuklenici_yetkili") : $item->yuklenici_yetkili; ?>"><?php echo isset($form_error) ? full_name(set_value("yuklenici_yetkili")) : full_name($item->yuklenici_yetkili); ?></option>
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
                           value="<?php echo isset($form_error) ? set_value("adres") : "$item->adres"; ?>"/>
                </div>
                <div class="col-3">
                    <div class="col-form-label">İl</div>

                    <select name="adress_city" class="form-control">
                        <option id="adress_cityOption" selected
                                value="<?php echo isset($form_error) ? set_value("adress_city") : $item->adres_il; ?>"
                                data-url="<?php echo base_url("$this->Module_Name/get_district/"); ?>"
                        >
                            <?php echo isset($form_error) ? city_name(set_value("adress_city")) : city_name($item->adres_il); ?>
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
                                value="<?php echo isset($form_error) ? set_value("adress_district") : $item->adres_ilce; ?>">
                            <?php echo isset($form_error) ? district_name(set_value("adress_district")) : district_name($item->adres_ilce); ?>
                        </option>
                        <?php foreach ($distircts as $distirct) { ?>
                            <?php if ($distirct->city_id == $item->adres_il) { ?>
                                <option value="<?php echo $distirct->id; ?>"><?php echo district_name($distirct->id); ?></option>
                            <?php } ?>
                        <?php } ?>


                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

