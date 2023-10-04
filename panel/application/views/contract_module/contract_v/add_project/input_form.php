<div class="card">
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
            <div class="col-form-label">Teklif Adı</div>
            <select id="select2-demo-1" style="width: 100%;" class="form-control" data-plugin="select2"
                    name="auction_id">
                <option selected="selected"
                        value="0">Bağımsız Sözleşme
                </option>
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("auction_id") : ""; ?>">
                    <?php
                    if ((isset($form_error) and (set_value("auction_id") > 0))) {
                        echo auction_name(set_value("auction_id"));
                    } else {
                        echo "Seçiniz(İsteğe Bağlı)";
                    }
                    ?>
                </option>
                <?php
                foreach ($ihaleler as $ihale) { ?>
                    <option value="<?php echo $ihale->id; ?>"><?php echo auction_name($ihale->id); ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("auction_id"); ?></div>
            <?php } ?>
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
            <div class="col-form-label">Sözleşme Adı</div>
            <input type="text"
                   class="form-control <?php cms_isset(form_error("sozlesme_ad"), "is-invalid", ""); ?>"
                   placeholder="Sözleşme Adı"
                   value="<?php echo isset($form_error) ? set_value("sozlesme_ad") : ""; ?>"
                   name="sozlesme_ad">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sozlesme_ad"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>


