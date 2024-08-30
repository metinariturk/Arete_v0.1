<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Teklif Kodu</div>
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
            <input type="text"
                   class="form-control <?php cms_isset(form_error("contract_name"), "is-invalid", ""); ?>"
                   placeholder="Teklif Adı"
                   value="<?php echo isset($form_error) ? set_value("contract_name") : ""; ?>"
                   name="contract_name">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("contract_name"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-12">
                    <div class="col-form-label">Teklif Verilen Firma/Kişi</div>
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
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-12">
                    <div class="col-form-label">Teklif Veren</div>
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
                </div>
            </div>
        </div>


    </div>
</div>


