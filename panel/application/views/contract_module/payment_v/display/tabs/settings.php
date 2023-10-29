<div class="fade tab-pane <?php if ($active_tab == "settings") {
    echo "active show";
} ?>"
     id="settings" role="tabpanel"
     aria-labelledby="settings-tab">
    <form id="update_payment"
          action="<?php echo base_url("$this->Module_Name/update_payment/$item->id"); ?>" method="post"
          enctype="multipart/form-data" autocomplete="off">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-form-label">Hakedişte Geçici Kabul Kesintisi</div>
                            </div>
                            <div class="col-md-4">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input id="gecici_teminat" type="checkbox" name="gecici_teminat"
                                            <?= isset($payment_settings) && $payment_settings->gecici_teminat == 1 ? 'checked' : '' ?>
                                               onclick="toggleSectionVisibility('gecici_teminat','section1','section2')"
                                               data-bs-original-title=""
                                               title="">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8" id="section1"
                                 style="display:<?= isset($payment_settings) && $payment_settings->gecici_teminat == 1 ? 'block' : 'none' ?>;">
                                <div class="col-form-label">Geçici Kabul Teminat Oran</div>
                            </div>
                            <div class="col-md-4" id="section2"
                                 style="display:<?= isset($payment_settings) && $payment_settings->gecici_teminat == 1 ? 'block' : 'none' ?>;">
                                <input class="form-control" type="number"
                                       placeholder="Teminat Oranı %"
                                       name="gecici_teminat_oran"
                                       value="<?php echo isset($payment_settings) ? $payment_settings->gecici_teminat_oran : 0; ?>"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-form-label">Fiyat Farkı</div>
                            </div>
                            <div class="col-md-4">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input id="fiyat_fark" type="checkbox" name="fiyat_fark"
                                            <?= isset($payment_settings) && $payment_settings->fiyat_fark == 1 ? 'checked' : '' ?>
                                               onclick="toggleSectionVisibility('fiyat_fark','section3','section4')"
                                               data-bs-original-title=""
                                               title="">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8" id="section3"
                                 style="display:<?= isset($payment_settings) && $payment_settings->fiyat_fark == 1 ? 'block' : 'none' ?>;">
                                <div class="col-form-label">Fiyat Farkı Teminatını Hakedişten Düş</div>
                            </div>
                            <div class="col-md-4" id="section4"
                                 style="display:<?= isset($payment_settings) && $payment_settings->fiyat_fark == 1 ? 'block' : 'none' ?>;">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input <?= isset($payment_settings) && $payment_settings->fiyat_fark_kesintisi == 1 ? 'checked' : '' ?>
                                                id="fiyat_fark_kes" type="checkbox">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-form-label">Damga Vergisi</div>
                            </div>
                            <div class="col-md-4">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input id="damga_vergisi" type="checkbox" name="damga_vergisi"
                                            <?= isset($payment_settings) && $payment_settings->damga_vergisi == 1 ? 'checked' : '' ?>
                                               onclick="toggleSectionVisibility('damga_vergisi','section5','section6')"
                                               data-bs-original-title=""
                                               title="">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8" id="section5"
                                 style="display:<?= isset($payment_settings) && $payment_settings->damga_vergisi == 1 ? 'block' : 'none' ?>;">
                                <div class="col-form-label">Damga Vergisi Oranı</div>
                            </div>
                            <div class="col-md-4" id="section6"
                                 style="display:<?= isset($payment_settings) && $payment_settings->damga_vergisi == 1 ? 'block' : 'none' ?>;">
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control"
                                        data-plugin="select2" name="damga_oran">
                                    <?php if (!empty($payment_settings->damga_vergisi_oran)) { ?>
                                        <option selected="selected"
                                                value="<?php echo $payment_settings->damga_vergisi_oran; ?>"><?php echo $payment_settings->damga_vergisi_oran; ?>
                                        </option>
                                    <?php } ?>
                                    <?php
                                    $oranlar = str_getcsv($settings->damga_oran);
                                    foreach ($oranlar as $oran) { ?>
                                        <option value="<?php echo $oran; ?>"><?php echo money_format($oran); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-form-label">Stopaj Kesintisi</div>
                            </div>
                            <div class="col-md-4">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input id="stopaj" type="checkbox" name="stopaj"
                                            <?= isset($payment_settings) && $payment_settings->stopaj == 1 ? 'checked' : '' ?>
                                               onclick="toggleSectionVisibility('stopaj','section7','section8')"
                                               data-bs-original-title=""
                                               title="">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8" id="section7"
                                 style="display:<?= isset($payment_settings) && $payment_settings->stopaj == 1 ? 'block' : 'none' ?>;">
                                <div class="col-form-label">Stopaj Oranı</div>
                            </div>
                            <div class="col-md-4" id="section8"
                                 style="display:<?= isset($payment_settings) && $payment_settings->stopaj == 1 ? 'block' : 'none' ?>;">
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control"
                                        data-plugin="select2" name="stopaj_oran">
                                    <?php if (!empty($payment_settings->stopaj_oran)) { ?>
                                        <option selected="selected"
                                                value="<?php echo $payment_settings->stopaj_oran; ?>"><?php echo $payment_settings->stopaj_oran; ?>
                                        </option>
                                    <?php } ?>
                                    <?php
                                    $oranlar = str_getcsv($settings->stopaj_oran);
                                    foreach ($oranlar as $oran) { ?>
                                        <option value="<?php echo $oran; ?>"><?php echo money_format($oran); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-form-label">KDV</div>
                            </div>
                            <div class="col-md-4">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input id="kdv" type="checkbox" name="kdv"
                                            <?= isset($payment_settings) && $payment_settings->kdv == 1 ? 'checked' : '' ?>
                                               onclick="toggleSectionVisibility('kdv','section9','section10','section11','section12')"
                                               data-bs-original-title=""
                                               title="">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8" id="section9"
                                 style="display:<?= isset($payment_settings) && $payment_settings->kdv == 1 ? 'block' : 'none' ?>;">
                                <div class="col-form-label">KDV Oranı</div>
                            </div>
                            <div class="col-md-4" id="section10"
                                 style="display:<?= isset($payment_settings) && $payment_settings->kdv == 1 ? 'block' : 'none' ?>;">
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control"
                                        data-plugin="select2" name="kdv_oran">
                                    <?php if (!empty($payment_settings->kdv_oran)) { ?>
                                        <option selected="selected"
                                                value="<?php echo $payment_settings->kdv_oran; ?>"><?php echo $payment_settings->kdv_oran; ?>
                                        </option>
                                    <?php } ?>
                                    <?php
                                    $oranlar = str_getcsv($settings->KDV_oran);
                                    foreach ($oranlar as $oran) { ?>
                                        <option value="<?php echo $oran; ?>"><?php echo money_format($oran); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8" id="section11"
                                 style="display:<?= isset($payment_settings) && $payment_settings->kdv == 1 ? 'block' : 'none' ?>;">
                                Tevkifat Oran
                            </div>
                            <div class="col-md-4" id="section12"
                                 style="display:<?= isset($payment_settings) && $payment_settings->kdv == 1 ? 'block' : 'none' ?>;">
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control"
                                        data-plugin="select2" name="tevkifat_oran">
                                    <?php if (!empty($payment_settings->tevkifat_oran)) { ?>
                                        <option selected="selected"
                                                value="<?php echo $payment_settings->tevkifat_oran; ?>"><?php echo $payment_settings->tevkifat_oran; ?>
                                        </option>
                                    <?php } ?>
                                    <?php
                                    $oranlar = str_getcsv($settings->kdv_tevkifat_oran);
                                    foreach ($oranlar as $oran) { ?>
                                        <option value="<?php echo $oran; ?>"><?php echo $oran; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-form-label">Avans</div>
                            </div>
                            <div class="col-md-4">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input id="avans" type="checkbox" name="avans"
                                            <?= isset($payment_settings) && $payment_settings->avans == 1 ? 'checked' : '' ?>
                                               onclick="toggleSectionVisibility('avans','section13','section14')"
                                               data-bs-original-title=""
                                               title="">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8" id="section13"
                                 style="display:<?= isset($payment_settings) && $payment_settings->avans == 1 ? 'block' : 'none' ?>;">
                                <div class="col-form-label">Hakedişte Otomatik Avans Mahsubu</div>
                            </div>
                            <div class="col-md-4" id="section14"
                                 style="display:<?= isset($payment_settings) && $payment_settings->avans == 1 ? 'block' : 'none' ?>;">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input id="avans_mahsup" type="checkbox" name="avans_mahsup"
                                            <?= isset($payment_settings) && $payment_settings->avans_mahsup == 1 ? 'checked' : '' ?>
                                               onclick="toggleSectionVisibility('avans_mahsup','section15','section16','section17','section18')"
                                               data-bs-original-title=""
                                               title="">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8" id="section15"
                                 style="display:<?= isset($payment_settings) && $payment_settings->avans_mahsup == 1 ? 'block' : 'none' ?>;">
                                <div class="col-form-label">Mahsup Oranı</div>
                            </div>
                            <div class="col-md-4" id="section16"
                                 style="display:<?= isset($payment_settings) && $payment_settings->gecici_teminat == 1 ? 'block' : 'none' ?>;">
                                <input class="form-control" type="number"
                                       placeholder="Avans Oranı %"
                                       name="avans_oran"
                                       value="<?php echo isset($payment_settings) ? $payment_settings->avans_oran : 0; ?>"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8" id="section17"
                                 style="display:<?= isset($payment_settings) && $payment_settings->avans_mahsup == 1 ? 'block' : 'none' ?>;">
                                <div class="col-form-label">Stopaj Hesabında Avans Mahsubu Dikkate Alınsın</div>
                            </div>
                            <div class="col-md-4" id="section18"
                                 style="display:<?= isset($payment_settings) && $payment_settings->avans_mahsup == 1 ? 'block' : 'none' ?>;">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input id="avans_stopaj" type="checkbox" name="avans_stopaj"
                                        <?= isset($payment_settings) && $payment_settings->avans_stopaj == 1 ? 'checked' : '' ?>
                                        ">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body d-flex justify-content-center align-items-center">
            <button type="submit" form="update_payment" class="btn btn-success">
                <i class="fa fa-floppy-o fa-lg"></i> Hakediş Ayarlarını Kaydet
            </button>
        </div>
    </form>
</div>


