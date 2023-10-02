<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-2">
                    <div class="col-form-label">Teminat Türü</div>
                    <select id="select2-demo-1" style="width: 100%;"
                            class="form-control <?php cms_isset(form_error("teminat_turu"), "is-invalid", ""); ?>"
                            data-plugin="select2" name="teminat_turu">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? set_value("teminat_turu") : "$item->teminat_turu"; ?>"><?php echo isset($form_error) ? set_value("teminat_turu") : "$item->teminat_turu"; ?>
                        </option>
                        <?php $teminat_turleri = get_as_array($settings->teminat_turu);
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

                    <select id="select2-demo-1" style="width: 100%;"
                            class="form-control <?php cms_isset(form_error("teminat_banka"), "is-invalid", ""); ?>"
                            data-plugin="select2" name="teminat_banka">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? set_value("teminat_banka") : "$item->teminat_banka"; ?>"><?php echo isset($form_error) ? set_value("teminat_banka") : "$item->teminat_banka"; ?>
                        </option>
                        <?php $bankalar = get_as_array($settings->bankalar);
                        foreach ($bankalar as $banka) {
                            echo "<option value='$banka'>$banka</option>";
                        } ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("teminat_banka"); ?></div>
                    <?php } ?>
                </div>
                <div class="mb-2">
                    <div class="col-form-label">Teminat Tutar</div>
                    <input type="number" step="any" id="calA" onblur="calcular()" onfocus="calcular()"
                           onChange="myFunction(calA)"
                           class="form-control <?php cms_isset(form_error("teminat_miktar"), "is-invalid", ""); ?>"
                           name="teminat_miktar"
                           placeholder="Teminat Tutar"
                           value="<?php echo isset($form_error) ? set_value("teminat_miktar") : "$item->teminat_miktar"; ?>">

                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("teminat_miktar"); ?></div>
                    <?php } ?>
                </div>

                <div class="mb-2">
                    <div class="row">
                        <div class="col-sm-4 col-md-3">
                            <div class="col-form-label">Teminat Gerekçe</div>
                            <div>
                                <input hidden name="teminat_gerekce" value="advance">
                                <span>Avans Teminatı</span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <div class="col-form-label">Teminata Ait Avansın Tutarı</div>
                            <div>
                                <input hidden id="calB" onblur="calcular()" onfocus="calcular()"
                                       onChange="myFunction(calB)"
                                       name="avans_miktar"
                                       value="<?php echo get_from_id("advance", "avans_miktar", $item->teminat_avans_id); ?>"/>
                                <span><?php echo money_format(get_from_id("advance", "avans_miktar", $item->teminat_avans_id)) . " " . get_currency($contract_id); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <div class="col-form-label">Teminatın Avansa Oranı</div>
                            <input hidden type="text" id="calD" value="" name="sozlesme_oran">
                            %<span id="calC" onblur="calcular()" onfocus="calcular()"></span>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <div class="col-form-label">Teminat Başlangıç Tarihi</div>
                    <input class="datepicker-here form-control digits <?php cms_isset(form_error("teslim_tarihi"), "is-invalid", ""); ?>"
                           type="text"
                           name="teslim_tarihi"
                           value="<?php echo isset($form_error) ? set_value("teslim_tarihi") : dateFormat_dmy($item->teslim_tarihi); ?>"
                           data-options="{ format: 'DD-MM-YYYY' }"
                           data-language="tr">
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("teslim_tarihi"); ?></div>
                    <?php } ?>
                </div>

                <div class="mb-2">

                    <div class="col-form-label">Teminat Geçerlilik Süresi <br>
                        <input type="checkbox" <?php if (empty($item->gecerlilik_tarihi)) {
                            echo "checked";
                        } ?> name="sure_kontrol" onclick="enable()" id="bond_control"/>
                        <label for="custome-checkbox2">Süresiz Teminat</label>
                    </div>

                    <input type="number"
                           class="form-control <?php cms_isset(form_error("teminat_sure"), "is-invalid", ""); ?>"
                           id="bond_limit" placeholder="Geçerlilik Süre (Gün)"
                           name="teminat_sure" id="bond_limit" <?php if (empty($item->gecerlilik_tarihi)) {
                        echo "disabled";
                    } ?>
                           value="<?php echo isset($form_error) ? set_value("teminat_sure") : "$item->teminat_sure"; ?>"
                    >
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("teminat_sure"); ?></div>
                    <?php } ?>

                </div>

                <?php if (empty($item->iade_tarihi)) {
                    $iade_Tarihi = null;
                } else {
                    $iade_Tarihi = dateFormat_dmy($item->iade_tarihi);
                } ?>
                <div class="mb-2">
                    <div class="col-form-label">Teminat İade Tarihi</div>
                    <input class="datepicker-here form-control digits <?php cms_isset(form_error("iade_tarihi"), "is-invalid", ""); ?>"
                           type="text"
                           name="iade_tarihi" data-position="top left"
                           value="<?php echo isset($form_error) ? set_value("iade_tarihi") : $iade_Tarihi; ?>"
                           data-options="{ format: 'DD-MM-YYYY' }"
                           data-language="tr">
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("iade_tarihi"); ?></div>
                    <?php } ?>
                </div>

                <?php if (empty($item->iade_tarihi)) {
                    $iade_Tarihi = null;
                } else {
                    $iade_Tarihi = dateFormat_dmy($item->iade_tarihi);
                } ?>
                <div class="mb-2">
                    <div class="col-form-label">İade Gerekçesi</div>
                    <input class="form-control <?php cms_isset(form_error("iade_aciklama"), "is-invalid", ""); ?>"
                           placeholder="İade edilme sebebini belirtiniz"
                           name="iade_aciklama"
                           value="<?php echo isset($form_error) ? set_value("iade_aciklama") : "$item->iade_aciklama"; ?>"/>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("iade_aciklama"); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>



