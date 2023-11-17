<div class="card">
    <div class="card-body">
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
                <div class="col-6">
                    <div class="col-form-label">Teklif Türü</div>
                    <select id="select2-demo-1"
                            class="form-control <?php cms_isset(form_error("sozlesme_turu"), "is-invalid", ""); ?>"
                            data-plugin="select2"
                            name="sozlesme_turu">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? cms_if_echo(set_value("sozlesme_turu"), null, "", set_value("sozlesme_turu")) : ""; ?>">
                            <?php echo isset($form_error) ? cms_if_echo(set_value("sozlesme_turu"), null, "Seçiniz", set_value("sozlesme_turu")) : ""; ?>
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
                                value="<?php echo isset($form_error) ? cms_if_echo(set_value("isin_turu"), null, "", set_value("isin_turu")) : ""; ?>">
                            <?php echo isset($form_error) ? cms_if_echo(set_value("isin_turu"), null, "Seçiniz", set_value("isin_turu")) : ""; ?>
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
    </div>
</div>