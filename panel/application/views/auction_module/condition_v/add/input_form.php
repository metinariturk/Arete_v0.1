<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <table class="table">
                    <tbody>
                    <tr>
                        <td class="w25">Teklif Türü</td>
                        <td>
                            <select id="select2-demo-1"
                                    class="form-control <?php cms_isset(form_error("teklif_turu"), "is-invalid", ""); ?>"
                                    style="width: 100%"
                                    data-plugin="select2" name="teklif_turu">
                                <option selected="selected"
                                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("teklif_turu"), null, "", set_value("teklif_turu")) : ""; ?>">
                                    <?php echo isset($form_error) ? cms_if_echo(set_value("teklif_turu"), null, "Seçiniz", set_value("teklif_turu")) : "Seçiniz"; ?>
                                </option>
                                <?php
                                $teklif_turleri = get_as_array($settings->sozlesme_turu);
                                print_r($teklif_turleri);
                                foreach ($teklif_turleri as $teklif_tur) { ?>
                                    <option value="<?php echo $teklif_tur; ?>"><?php echo $teklif_tur; ?></option>";
                                <?php } ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"> <?php echo form_error("teklif_turu"); ?></div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>İşin Türü</td>
                        <td>
                            <select class="form-control <?php cms_isset(form_error("isin_turu"), "is-invalid", ""); ?>"
                                    data-plugin="select2" style="width: 100%"
                                    name="isin_turu">
                                <option selected="selected"
                                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("isin_turu"), null, "", set_value("isin_turu")) : ""; ?>">
                                    <?php echo isset($form_error) ? cms_if_echo(set_value("isin_turu"), null, "Seçiniz", set_value("isin_turu")) : "Seçiniz"; ?>
                                </option>
                                <?php
                                $is_turleri = str_getcsv($settings->isin_turu);
                                foreach ($is_turleri as $is_tur) {
                                    echo "<option value='$is_tur'>$is_tur</option>";
                                }
                                ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"> <?php echo form_error("isin_turu"); ?></div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>İşin Süresi</td>
                        <td>
                            <input type="number" step="any"
                                   class="form-control <?php cms_isset(form_error("isin_suresi"), "is-invalid", ""); ?>"
                                   name="isin_suresi"
                                   value="<?php echo isset($form_error) ? set_value("isin_suresi") : ""; ?>">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"> <?php echo form_error("isin_suresi"); ?></div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="w15">İş Bitirme Bedeli</b></td>
                        <td class="w85">
                            <div class="row">
                                <div class="col-sm-7">
                                    <input type="number" step="any"
                                           class="form-control <?php cms_isset(form_error("is_bitirme"), "is-invalid", ""); ?>"
                                           name="is_bitirme"
                                           value="<?php echo isset($form_error) ? set_value("is_bitirme") : ""; ?>"/>
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"> <?php echo form_error("is_bitirme"); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-5">
                                    <select id="select2-demo-1" style="width: 100%;"
                                            class="form-control <?php cms_isset(form_error("para_birimi"), "is-invalid", ""); ?>"
                                            data-plugin="select2" name="para_birimi">
                                        <option value="TL">TL</option>
                                        <option selected="selected"
                                                value="<?php echo isset($form_error) ? cms_if_echo(set_value("para_birimi"), null, "", set_value("para_birimi")) : ""; ?>">
                                            <?php echo isset($form_error) ? cms_if_echo(set_value("para_birimi"), null, "Seçiniz", set_value("para_birimi")) : "Seçiniz"; ?>
                                        </option>
                                        <?php
                                        $para_birimleri = str_getcsv($settings->para_birimi);
                                        foreach ($para_birimleri as $para_birimi) {
                                            echo "<option value='$para_birimi'>$para_birimi</option>";
                                        }
                                        ?>
                                        <option value="pct">% Yüzde</option>
                                    </select>
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"> <?php echo form_error("para_birimi"); ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Benzer İş Grubu</b></td>
                        <td>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("benzer_is"), "is-invalid", ""); ?> float-right "
                                    data-plugin="select2" name="benzer_is">
                                <option selected="selected"
                                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("benzer_is"), null, "", set_value("benzer_is")) : ""; ?>">
                                    <?php echo isset($form_error) ? cms_if_echo(set_value("benzer_is"), null, "Seçiniz", set_value("benzer_is")) : "Seçiniz"; ?></option>
                                <?php
                                $benzerler = str_getcsv($settings->benzer_is);
                                foreach ($benzerler as $benzer) {
                                    echo "<option value='$benzer'>$benzer</option>";
                                }
                                ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"> <?php echo form_error("benzer_is"); ?></div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Müteahhitlik Sınıfı</b></td>
                        <td>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("muteahhit_sinif"), "is-invalid", ""); ?> float-right "
                                    data-plugin="select2" name="muteahhit_sinif">
                                <option selected="selected"
                                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("muteahhit_sinif"), null, "", set_value("muteahhit_sinif")) : ""; ?>">
                                    <?php echo isset($form_error) ? cms_if_echo(set_value("muteahhit_sinif"), null, "Seçiniz", set_value("muteahhit_sinif")) : "Seçiniz"; ?></option>
                                <?php
                                $mut_siniflar = str_getcsv($settings->muteahhit_sinif);
                                foreach ($mut_siniflar as $mut_sinif) {
                                    echo "<option value='$mut_sinif'>$mut_sinif</option>";
                                }
                                ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"> <?php echo form_error("muteahhit_sinif"); ?></div>
                            <?php } ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
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
                    </tr>
                    <tr>
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
                    </tr>
                    <tr>
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
                    </tr>
                    <tr>
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
        <div class="mb-2">
            <div class="col-form-label">Onay</div>
            <select style="width: 100%" id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("onay"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="onay">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("onay") : ""; ?>"><?php echo isset($form_error) ? full_name(set_value("onay")) : "Seçiniz"; ?></option>

                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo full_name($user->id); ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("onay"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">Açıklama</div>
            <textarea class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", ""); ?>"
                      name="aciklama"
                      placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : ""; ?></textarea>

            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>





