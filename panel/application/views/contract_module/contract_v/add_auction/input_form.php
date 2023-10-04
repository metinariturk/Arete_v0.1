<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <a href="<?php echo base_url("project/file_form/$project->id"); ?>"><h6
                        class="mb-0"><?php echo project_code_name($project->id); ?></h6></a>
            <a href="<?php echo base_url("auction/file_form/$auction->id"); ?>">
                <p><?php echo $auction->dosya_no . " / " . $auction->ihale_ad; ?></p></a>
        </div>
        <div class="card-body">
            <div class="mb-2">
                <div class="col-form-label">Sözleşme Kodu</div>
                <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">SZL</span>
                    <?php if (!empty(get_last_fn("contract"))) { ?>
                        <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                               type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                               data-bs-original-title="" title="" name="dosya_no"
                               value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("contract"); ?>">
                        <?php
                    } else { ?>
                        <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                               type="number" placeholder="Username" aria-describedby="inputGroupPrepend"
                               required="" data-bs-original-title="" title="" name="dosya_no"
                               value="<?php echo isset($form_error) ? set_value("dosya_no") : fill_empty_digits() . "1" ?>">
                    <?php } ?>

                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("dosya_no"); ?></div>
                        <div class="invalid-feedback">* Önerilen Proje Kodu
                            : <?php echo increase_code_suffix("contract"); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="mb-2">
                <div class="col-form-label">Sözleşme Adı</div>
                <input type="text"
                       class="form-control <?php cms_isset(form_error("sozlesme_ad"), "is-invalid", ""); ?>"
                       placeholder="Sözleşme Adı"
                       value="<?php echo isset($form_error) ? set_value("sozlesme_ad") : "$auction->ihale_ad"; ?>"
                       name="sozlesme_ad">
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("sozlesme_ad"); ?></div>
                <?php } ?>
            </div>


            <div class="mb-2">

            </div>

            <div class="mb-2">
                <div class="row">
                    <div class="col-4">
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
                    <div class="col-5">
                        <div class="col-form-label">Sözleşme Bedel</div>
                        <input type="number" min="1" step="any" onblur=""
                               class="form-control <?php cms_isset(form_error("sozlesme_bedel"), "is-invalid", ""); ?>"
                               name="sozlesme_bedel"
                               value="<?php echo isset($form_error) ? set_value("sozlesme_bedel") : "$price"; ?>"
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
                                    value="<?php echo isset($form_error) ? set_value("para_birimi") : "$auction->para_birimi"; ?>">
                                <?php echo isset($form_error) ? set_value("para_birimi") : "$auction->para_birimi"; ?>
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
                        <div class="col-form-label">Teklif Yapan Kuruluş</div>
                        <select id="select2-demo-1"
                                class="form-control <?php cms_isset(form_error("isveren"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="isveren">
                            <option value="<?php echo isset($form_error) ? set_value("isveren") : "$auction->isveren"; ?>"><?php echo isset($form_error) ? company_name(set_value("isveren")) : company_name($auction->isveren); ?></option>
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
                        <select id="select2-demo-1" readonly=""
                                class="form-control <?php cms_isset(form_error("yuklenici"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="yuklenici">
                            <option selected
                                    value="<?php echo $yuklenici_id; ?>"><?php echo company_name($yuklenici_id); ?></option>
                        </select>
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
                            <option value="">Seçiniz</option>
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
                    </div>
                    <div class="col-3">
                        <div class="col-form-label">İlçe</div>

                        <select name="adress_district" class="form-control">
                            <option value="">Seçiniz</option>
                            <option value="<?php echo isset($form_error) ? set_value("adress_district") : ""; ?>">
                                <?php echo isset($form_error) ? district_name(set_value("adress_district")) : ""; ?>
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

