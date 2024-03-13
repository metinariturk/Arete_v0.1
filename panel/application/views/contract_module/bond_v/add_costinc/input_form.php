<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <div class="col-9">
                    <h6 class="mb-0">
                        <a href="<?php echo base_url("project/file_form/$project_id"); ?>" target="_blank">
                            <?php echo project_code($project_id); ?>
                            / <?php echo project_name($project_id); ?>
                        </a>
                        <a href="<?php echo base_url("contract/file_form/$contract_id"); ?>>
                            <p class="mb-0">
                                <?php echo contract_code($contract_id); ?>
                                / <?php echo contract_name($contract_id); ?>
                            </p>
                        </a>
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <div class="col-form-label">Dosya No</div>
                    <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">TM</span>
                        <?php if (!empty(get_last_fn("bond"))) { ?>
                            <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                                   type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                                   data-bs-original-title="" title="" name="dosya_no"
                                   value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("bond"); ?>">
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
                                : <?php echo increase_code_suffix("bond"); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="col-form-label">Teminat Türü</div>

                    <select id="select2-demo-1" style="width: 100%;"
                            class="form-control <?php cms_isset(form_error("teminat_turu"), "is-invalid", ""); ?>"
                            data-plugin="select2" name="teminat_turu">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? set_value("teminat_turu") : ""; ?>"><?php echo isset($form_error) ? set_value("teminat_turu") : "Seçiniz"; ?>
                        </option>
                        <?php $teminat_turleri = str_getcsv($settings->teminat_turu);
                        foreach ($teminat_turleri as $teminat_turu) {
                            echo "<option value='$teminat_turu'>$teminat_turu</option>";
                        } ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("teminat_turu"); ?></div>
                    <?php } ?>
                </div>

                <div class="mb-2">
                    <div class="col-form-label">Teminat Veren Banka</div>
                    <select id="select2-demo-1" style="width: 100%;" class="form-control <?php cms_isset(form_error("teminat_banka"), "is-invalid", ""); ?>"
                            data-plugin="select2" name="teminat_banka">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? set_value("teminat_banka") : ""; ?>"><?php echo isset($form_error) ? set_value("teminat_banka") : "Seçiniz"; ?>
                        </option>
                        <?php $bankalar = str_getcsv($settings->bankalar);
                        foreach ($bankalar as $banka) {
                            echo "<option value='$banka'>$banka</option>";
                        } ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("teminat_banka"); ?></div>
                    <?php } ?>
                </div>



            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">

            <div class="card-body">
                <div class="mb-2">
                    <div class="col-form-label">Teminat Tutar</div>
                    <input type="number" step="any" id="calA" onblur="calcular()" onfocus="calcular()"
                           onChange="myFunction(calA)"
                           class="form-control <?php cms_isset(form_error("teminat_miktar"), "is-invalid", ""); ?>"
                           name="teminat_miktar"
                           placeholder="Teminat Tutar"
                           value="<?php echo isset($form_error) ? set_value("teminat_miktar") : ""; ?>">

                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("teminat_miktar"); ?></div>
                    <?php } ?>
                </div>

                <div class="mb-2">
                    <div class="row">
                        <div class="col-sm-4 col-md-3">
                            <div class="col-form-label">Teminat Gerekçe</div>
                            <div>
                                <input hidden name="teminat_gerekce" value="costinc">
                                <span>Keşif Artışı Teminatı</span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <div class="col-form-label">Teminata Ait Keşif Artışının Tutarı</div>
                            <div>
                                <input hidden id="calB" onblur="calcular()" onfocus="calcular()"
                                       onChange="myFunction(calB)"
                                       name="artis_miktar"
                                       value="<?php echo get_from_id("costinc", "artis_miktar", $costinc_id); ?>"/>
                                <span><?php echo money_format(get_from_id("costinc", "artis_miktar", $costinc_id)) . " " . get_currency($contract_id); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <div class="col-form-label">Teminatın Keşif Artışına Oranı</div>
                            <input hidden type="text" id="calD" value="" name="sozlesme_oran">
                            %<span id="calC" onblur="calcular()" onfocus="calcular()"></span>
                        </div>
                    </div>
                </div>


                <div class="mb-2">
                    <div class="col-form-label">Teminat Başlangıç Tarihi<?php echo $limit_check; ?></div>
                    <input class="datepicker-here form-control digits <?php cms_isset(form_error("teslim_tarihi"), "is-invalid", ""); ?>"
                           type="text"
                           name="teslim_tarihi"
                           value="<?php echo isset($form_error) ? set_value("teslim_tarihi") : ""; ?>"
                           data-options="{ format: 'DD-MM-YYYY' }"
                           data-language="tr">
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("teslim_tarihi"); ?></div>
                    <?php } ?>
                </div>

                <div class="mb-2">
                    <div class="col-form-label">Teminat Geçerlilik Süresi <br>
                        <input type="checkbox" name="sure_kontrol" onclick="enable()" id="bond_control" <?php echo $limit_check; ?>/>
                        <label for="custome-checkbox2">Süresiz Teminat</label>
                    </div>

                    <input type="number"
                           class="form-control <?php cms_isset(form_error("teminat_sure"), "is-invalid", ""); ?>"
                           id="bond_limit" placeholder="Geçerlilik Süre (Gün)"
                           name="teminat_sure" id="bond_limit"
                           value="<?php echo isset($form_error) ? set_value("teminat_sure") : ""; ?>"
                        <?php echo $limit_input; ?>>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("teminat_sure"); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>




