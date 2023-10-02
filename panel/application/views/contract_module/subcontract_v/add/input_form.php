<div class="col-md-6">
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
                        <div class="invalid-feedback">* Önerilen Sözleşme Kodu
                            : <?php echo increase_code_suffix("contract"); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if (isset($contract)) { ?>
            <div class="mb-2">
                <div class="col-form-label">Poje Adı : <?php echo project_code_name(project_id_cont($contract->id)); ?></div>
                <div class="col-form-label">Sözleşme Adı : <?php echo contract_code_name($contract->id); ?></div>
                <input name="contract_id" hidden value="<?php echo $contract->id; ?>">
            </div>
            <?php } else { ?>
            <div class=" text-center" ><span class="text-danger"> Bu Alt Sözleşme herhangi bir proje veya sözleşmeye bağlı olmadığı için raporlamalarda görünmeyecektir.</span></div>
            <?php } ?>
            <div class="mb-2">
                <div class="col-form-label">Alt Sözleşme Adı</div>
                <input type="text"
                       class="form-control <?php cms_isset(form_error("sozlesme_ad"), "is-invalid", ""); ?>"
                       placeholder="Sözleşme Adı"
                       value="<?php echo isset($form_error) ? set_value("sozlesme_ad") : ""; ?>"
                       name="sozlesme_ad">
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("sozlesme_ad"); ?></div>
                <?php } ?>
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
                    <div class="col-4">
                        <div class="col-form-label">Sözleşme Süresi</div>
                        <input type="number" step="any"
                               class="form-control <?php cms_isset(form_error("isin_suresi"), "is-invalid", ""); ?>"
                               name="isin_suresi"
                               value="<?php echo isset($form_error) ? set_value("isin_suresi") : ""; ?>">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"> <?php echo form_error("isin_suresi"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-5">
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
                    <div class="col-3">
                        <div class="col-form-label">Para Birimi</div>
                        <select id="select2-demo-1" style="width: 100%;" class="form-control" data-plugin="select2"
                                name="para_birimi">

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
                        <div class="col-form-label">Taşeron/Tedarikçi</div>
                        <select id="select2-demo-1"
                                class="form-control <?php cms_isset(form_error("contractor"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="contractor">
                            <option value="<?php echo isset($form_error) ? set_value("contractor") : ""; ?>">
                                <?php echo isset($form_error) ? company_name(set_value("contractor")) : ""; ?>
                            </option>

                            <?php foreach ($companys as $company) { ?>
                                <option value="<?php echo $company->id; ?>"><?php echo $company->company_name; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("contractor"); ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <div class="row">
                    <div class="col-4">
                        <div class="col-form-label">İşin Süresi</div>
                        <input type="number" step="any"
                               class="form-control <?php cms_isset(form_error("isin_suresi"), "is-invalid", ""); ?>"
                               name="isin_suresi"
                               value="<?php echo isset($form_error) ? set_value("isin_suresi") : ""; ?>">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"> <?php echo form_error("isin_suresi"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-5">
                        <div class="col-form-label">Sözleşme Türü</div>
                        <select class="form-control <?php cms_isset(form_error("sozlesme_turu"), "is-invalid", ""); ?>"
                                data-plugin="select2" style="width: 100%"
                                name="sozlesme_turu">
                            <option selected="selected"
                                    value="<?php echo isset($form_error) ? cms_if_echo(set_value("sozlesme_turu"), null, "", set_value("sozlesme_turu")) : ""; ?>">
                                <?php echo isset($form_error) ? cms_if_echo(set_value("sozlesme_turu"), null, "Seçiniz", set_value("sozlesme_turu")) : "Seçiniz"; ?>
                            </option>
                            <?php
                            $is_turleri = str_getcsv($settings->isin_turu);
                            foreach ($is_turleri as $is_tur) {
                                echo "<option value='$is_tur'>$is_tur</option>";
                            }
                            ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"> <?php echo form_error("sozlesme_turu"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-3">
                        <div class="col-form-label">İşin Türü</div>
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
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

