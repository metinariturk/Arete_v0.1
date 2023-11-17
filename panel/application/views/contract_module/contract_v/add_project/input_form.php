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

        <?php if (!$is_sub) { ?>

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
        <?php } else { ?>
            <div class="mb-2">
                <input type="number" min="1" step="any" onblur=""
                       class="form-control" hidden
                       name="is_sub"
                       value="<?= $is_sub ? "1" : "" ?>">
            </div>
            <div class="mb-2">
                <span>Atl Sözleşme</span>
            </div>
            <div class="mb-2">
                <div class="col-form-label">Bağlı Olduğu Ana Sözleşme Adı</div>
                <select id="select2-demo-1" style="width: 100%;" class="form-control" data-plugin="select2"
                        name="main_contract">
                    <option selected="selected"
                            value="0">Bağımsız Sözleşme
                    </option>
                    <option selected="selected"
                            value="<?php echo isset($form_error) ? set_value("main_contract") : ""; ?>">
                        <?php
                        if ((isset($form_error) and (set_value("main_contract") > 0))) {
                            echo contract_name(set_value("main_contract"));
                        } else {
                            echo "Seçiniz(İsteğe Bağlı)";
                        }
                        ?>
                    </option>
                    <?php
                    foreach ($main_contracts as $main_contract) { ?>
                        <?php if ($main_contract->subcont != 1) { ?>
                            <option value="<?php echo $main_contract->id; ?>"><?php echo contract_name($main_contract->id); ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("main_contract"); ?></div>
                <?php } ?>
            </div>
        <?php } ?>
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
        <div class="mb-2">
            <div class="row">
                <div class="col-12">
                    <div class="col-form-label">Sözleşme İşveren</div>
                    <?php if (!$is_sub) { ?>
                        <select id="select2-demo-1"
                                class="form-control <?php cms_isset(form_error("isveren"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="isveren">
                            <option value="<?php echo isset($form_error) ? set_value("isveren") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("isveren")) : ""; ?></option>
                            <?php foreach ($companys as $company) { ?>
                                <option value="<?php echo $company->id; ?>"><?php echo $company->company_name; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("isveren"); ?></div>
                        <?php } ?>
                    <?php } else { ?>
                        <select id="select2-demo-1"
                                class="form-control <?php cms_isset(form_error("isveren"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="isveren">
                            <option value="<?php echo isset($form_error) ? set_value("isveren") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("isveren")) : ""; ?></option>
                            <?php foreach ($companys as $company) { ?>
                                <option value="<?php echo $company->id; ?>"><?php echo $company->company_name; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("isveren"); ?></div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-12">
                    <div class="col-form-label">Taşeron/Tedarikçi</div>
                    <?php if (!$is_sub) { ?>

                        <select id="select2-demo-1"
                                class="form-control <?php cms_isset(form_error("yuklenici"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="yuklenici">
                            <option value="<?php echo isset($form_error) ? set_value("yuklenici") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("yuklenici")) : ""; ?></option>
                            <?php foreach ($companys as $company) { ?>
                                <option value="<?php echo $company->id; ?>"><?php echo $company->company_name; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("yuklenici"); ?></div>
                        <?php } ?>
                    <?php } else { ?>
                        <select id="select2-demo-1"
                                class="form-control <?php cms_isset(form_error("yuklenici"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="yuklenici">
                            <option value="<?php echo isset($form_error) ? set_value("yuklenici") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("yuklenici")) : ""; ?></option>
                            <?php foreach ($companys as $company) { ?>
                                <option value="<?php echo $company->id; ?>"><?php echo $company->company_name; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("yuklenici"); ?></div>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>
        </div>



    </div>
</div>


