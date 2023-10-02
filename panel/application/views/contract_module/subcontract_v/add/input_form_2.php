
    <div class="col-md-6 alert-sec">
        <div class="card bg-img">
            <div class="card-header <?php if (isset($error)){echo "bg-light-danger";} ?>">
                <div class="header-top">
                    <h5 class="m-0"><?php if (isset($error)){echo $error;} else {echo "Finansal Şartları"; }?>  </h5>
                    <div class="dot-right-icon"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="body-bottom">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="w25">KDV (%)</b></td>
                            <td>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("kdv_oran"), "is-invalid", ""); ?> float-right "
                                        data-plugin="select2" name="kdv_oran">
                                    <option selected="selected"
                                            value="<?php echo isset($form_error) ? cms_if_echo(set_value("kdv_oran"), null, "", set_value("kdv_oran")) : ""; ?>">
                                        <?php echo isset($form_error) ? cms_if_echo(set_value("kdv_oran"), null, "Seçiniz", set_value("kdv_oran")) : "Seçiniz"; ?></option>
                                    <?php
                                    $oranlar = str_getcsv($settings->KDV_oran);
                                    foreach ($oranlar as $oran) {
                                        echo "<option value='$oran'>%$oran</option>";
                                    }
                                    ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("kdv_oran"); ?></div>
                                <?php } ?>
                            </td>
                            <td>Tevkifat Oran</b></td>
                            <td>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("tevkifat_oran"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="tevkifat_oran">
                                    <option selected="selected"
                                            value="<?php echo isset($form_error) ? cms_if_echo(set_value("tevkifat_oran"), null, "", set_value("tevkifat_oran")) : ""; ?>">
                                        <?php echo isset($form_error) ? cms_if_echo(set_value("tevkifat_oran"), null, "Seçiniz", set_value("tevkifat_oran")) : "Seçiniz"; ?>
                                    </option>
                                    <?php
                                    $oranlar = str_getcsv($settings->kdv_tevkifat_oran);
                                    foreach ($oranlar as $oran) {
                                        echo "<option value='$oran'>$oran</option>";
                                    }
                                    ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("tevkifat_oran"); ?></div>

                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Damga Vergisi (Binde)</b></td>
                            <td>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("damga_oran"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="damga_oran">
                                    <option selected="selected"
                                            value="<?php echo isset($form_error) ? cms_if_echo(set_value("damga_oran"), null, "", set_value("damga_oran")) : ""; ?>">
                                        <?php echo isset($form_error) ? cms_if_echo(set_value("damga_oran"), null, "Seçiniz", set_value("damga_oran")) : "Seçiniz"; ?>
                                    </option>
                                    <?php
                                    $oranlar = str_getcsv($settings->damga_oran);
                                    foreach ($oranlar as $oran) {
                                        echo "<option value='$oran'>$oran</option>";
                                    }
                                    ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("damga_oran"); ?></div>
                                <?php } ?>
                            </td>
                            <td>Damga Vergisi Kesintisi Yapılacak Mı</b></td>
                            <td>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("damga_kesinti"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="damga_kesinti">

                                    <?php var_yok_option('damga_kesinti', $form_error); ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("damga_kesinti"); ?></div>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Stopaj (%)</b></td>
                            <td>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("stopaj_oran"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="stopaj_oran">
                                    <option selected="selected"
                                            value="<?php echo isset($form_error) ? cms_if_echo(set_value("stopaj_oran"), null, "", set_value("stopaj_oran")) : ""; ?>">
                                        <?php echo isset($form_error) ? cms_if_echo(set_value("stopaj_oran"), null, "Seçiniz", set_value("stopaj_oran")) : "Seçiniz"; ?>
                                    </option>
                                    <?php
                                    $oranlar = str_getcsv($settings->stopaj_oran);
                                    foreach ($oranlar as $oran) {
                                        echo "<option value='$oran'>$oran</option>";
                                    }
                                    ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("stopaj_oran"); ?></div>
                                <?php } ?>
                            </td>
                            <td>Stopaj Kesintisinde Avans Miktarı Mahsubu </b></td>
                            <td>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("avans_stopaj"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="avans_stopaj">

                                    <?php var_yok_option('avans_stopaj', $form_error); ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("avans_stopaj"); ?></div>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Avans</b></td>
                            <td>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("avans_durum"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="avans_durum">
                                    <?php var_yok_option("avans_durum", $form_error); ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("avans_durum"); ?></div>
                                <?php } ?>
                            </td>
                            <td>Avans Mahsup Oranı %</b></td>
                            <td>
                                <input class="form-control <?php cms_isset(form_error("avans_mahsup_oran"), "is-invalid", ""); ?>"
                                       placeholder="Mahsup Oranı %"
                                       name="avans_mahsup_oran"
                                       value="<?php echo isset($form_error) ? set_value("avans_mahsup_oran") : ""; ?>"/>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("avans_mahsup_oran"); ?></div>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>

                            <td>Hakedişte Avans Mahsubu</b></td>
                            <td>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("avans_mahsup_durum"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="avans_mahsup_durum">

                                    <?php var_yok_option("avans_mahsup_durum", $form_error); ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("avans_mahsup_durum"); ?></div>
                                <?php } ?>
                            </td>
                            <td>İhzarat Ödemesi</b></td>
                            <td>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("ihzarat"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="ihzarat">
                                    <?php var_yok_option('ihzarat', $form_error); ?>

                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("ihzarat"); ?></div>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>

                            <td>Fiyat Farkı</b></td>
                            <td>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("fiyat_fark"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="fiyat_fark">
                                    <?php var_yok_option('fiyat_fark', $form_error); ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("fiyat_fark"); ?></div>
                                <?php } ?>
                            </td>
                            <td>Fiyat Farkı</b></td>
                            <td>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("fiyat_fark_teminat"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="fiyat_fark_teminat">
                                    <?php var_yok_option('fiyat_fark_teminat', $form_error); ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("fiyat_fark_teminat"); ?></div>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Geçici Kabul Teminat</b></td>
                            <td>
                                <input class="form-control <?php cms_isset(form_error("teminat_oran"), "is-invalid", ""); ?>"
                                       placeholder="Teminat Oranı %"
                                       name="teminat_oran"
                                       value="<?php echo isset($form_error) ? set_value("teminat_oran") : ""; ?>"/>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("teminat_oran"); ?></div>
                                <?php } ?>
                            </td>
                            <td>Hakedişlerden Geçici Kabul Kesintisi</b></td>
                            <td><select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("gecici_kabul_kesinti"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="gecici_kabul_kesinti">
                                    <option selected="selected"
                                            value="<?php echo isset($form_error) ? cms_if_echo(set_value("gecici_kabul_kesinti"), null, "", set_value("gecici_kabul_kesinti")) : ""; ?>">
                                        <?php echo isset($form_error) ? cms_if_echo(set_value("gecici_kabul_kesinti"), null, "Seçiniz", set_value("gecici_kabul_kesinti")) : "Seçiniz"; ?>
                                    </option>
                                    <option value="0">Yok</option>
                                    <option value="1">Var</option>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("gecici_kabul_kesinti"); ?></div>
                                <?php } ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
