<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <div class="col-form-label">KDV (%)</div>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("kdv_oran"), "is-invalid", ""); ?>"
                                    data-plugin="select2" name="kdv_oran">
                                <option selected="selected"
                                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("kdv_oran"), null, "", set_value("kdv_oran")) : "$item->kdv_oran"; ?>">
                                    <?php echo isset($form_error) ? cms_if_echo(set_value("kdv_oran"), null, "Seçiniz", "%" . set_value("kdv_oran")) : "$item->kdv_oran"; ?>
                                </option>
                                <?php
                                $kdv_oranlar = get_as_array($settings->KDV_oran);
                                foreach ($kdv_oranlar as $kdv_oran) { ?>
                                    <option value="<?php echo $kdv_oran; ?>">% <?php echo $kdv_oran; ?></option>
                                <?php } ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("kdv_oran"); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <div class="col-form-label">Tevkifat Oran</div>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("tevkifat_oran"), "is-invalid", ""); ?>"
                                    data-plugin="select2" name="tevkifat_oran">
                                <?php
                                $tevkifat_oranlar = get_as_array($settings->kdv_tevkifat_oran); ?>
                                <option selected="selected"
                                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("tevkifat_oran"), null, "", set_value("tevkifat_oran")) : "$item->tevkifat_oran"; ?>">
                                    <?php echo isset($form_error) ? cms_if_echo(set_value("tevkifat_oran"), null, "Seçiniz", set_value("tevkifat_oran")) : "$item->tevkifat_oran"; ?>
                                </option>
                                <?php
                                foreach ($tevkifat_oranlar as $tevkifat_oran) { ?>
                                    <option value=<?php echo $tevkifat_oran; ?>><?php echo $tevkifat_oran; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("tevkifat_oran"); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <div class="col-form-label">Damga Vergisi (Binde)</div>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("damga_oran"), "is-invalid", ""); ?>"
                                    data-plugin="select2" name="damga_oran">
                                <option selected="selected"
                                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("damga_oran"), null, "", set_value("damga_oran")) : "$item->damga_oran"; ?>">
                                    <?php echo isset($form_error) ? cms_if_echo(set_value("damga_oran"), null, "Seçiniz", set_value("damga_oran")) : "$item->damga_oran"; ?>
                                </option>
                                <?php
                                $oranlar = str_getcsv($settings->damga_oran);
                                foreach ($oranlar as $oran) {
                                    echo "<option value='$oran'>$oran</option>";
                                }
                                ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("damga_oran"); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <div class="col-form-label">Stopaj (%)</div>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("stopaj_oran"), "is-invalid", ""); ?>"
                                    data-plugin="select2" name="stopaj_oran">
                                <option selected="selected"
                                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("stopaj_oran"), null, "", set_value("stopaj_oran")) : "$item->stopaj_oran"; ?>">
                                    <?php echo isset($form_error) ? cms_if_echo(set_value("stopaj_oran"), null, "Seçiniz", set_value("stopaj_oran")) : "%$item->stopaj_oran"; ?>
                                </option>
                                <?php
                                $oranlar = str_getcsv($settings->stopaj_oran);
                                foreach ($oranlar as $oran) {
                                    echo "<option value='$oran'>%$oran</option>";
                                }
                                ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("stopaj_oran"); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <div class="col-form-label">Avans Durum</div>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("avans_durum"), "is-invalid", ""); ?>"
                                    data-plugin="select2" name="avans_durum">
                                <option selected
                                        value="<?php echo $item->avans_durum; ?>"><?php echo var_yok_name($item->avans_durum); ?>
                                </option>
                                <?php var_yok_option("avans_durum", $form_error); ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("avans_durum"); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <div class="col-form-label">Mahsup Oran</div>
                            <input class="form-control <?php cms_isset(form_error("avans_mahsup_oran"), "is-invalid", ""); ?>"
                                   placeholder="Mahsup Oranı %"
                                   name="avans_mahsup_oran"
                                   value="<?php echo isset($form_error) ? set_value("avans_mahsup_oran") : "$item->avans_mahsup_oran"; ?>"/>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("avans_mahsup_oran"); ?></div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <div class="col-form-label">Hakedişte Otomatik Avans Mahsubu</div>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("avans_mahsup_durum"), "is-invalid", ""); ?>"
                                    data-plugin="select2" name="avans_mahsup_durum">
                                <option selected
                                        value="<?php echo $item->avans_mahsup_durum; ?>"><?php echo var_yok_name($item->avans_mahsup_durum); ?>
                                </option>
                                <?php var_yok_option("avans_mahsup_durum", $form_error); ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("avans_mahsup_durum"); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <div class="col-form-label">Stopaj Hesabında Avans Mahsubu Miktarı Düşülmesi</div>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("avans_stopaj"), "is-invalid", ""); ?>"
                                    data-plugin="select2" name="avans_stopaj">
                                <option selected
                                        value="<?php echo $item->avans_stopaj; ?>"><?php echo var_yok_name($item->avans_stopaj); ?>
                                </option>
                                <?php var_yok_option('avans_stopaj', $form_error); ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("avans_stopaj"); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
        </div>
    </div>
</div>


