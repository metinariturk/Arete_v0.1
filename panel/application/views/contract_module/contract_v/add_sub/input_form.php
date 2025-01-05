<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Sözleşme Kodu</div>
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend">SZL</span>
                <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                       type="number" placeholder="Username" aria-describedby="inputGroupPrepend"
                       required="" data-bs-original-title="" title="" name="dosya_no" disabled
                       value="<?php echo isset($form_error) ? set_value("dosya_no") : $next_file_name ?>">

                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("dosya_no"); ?></div>
                    <div class="invalid-feedback">* Önerilen Proje Kodu
                        : <?php echo increase_code_suffix("Contract"); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="mb-2">
                <div class="col-form-label">Ana Sözleşme Adı</div>
                <input type="text"
                       class="form-control <?php cms_isset(form_error("main_contract"), "is-invalid", ""); ?>"
                       placeholder="Sözleşme Adı" readonly
                       value="<?php echo isset($form_error) ? set_value("main_contract") : contract_name($main_contract->id); ?>"
                       name="main_contract">
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("main_contract"); ?></div>
                <?php } ?>
            </div>
            <div class="mb-2">
                <div class="col-form-label">Sözleşme Adı</div>
                <input type="text"
                       class="form-control <?php cms_isset(form_error("contract_name"), "is-invalid", ""); ?>"
                       placeholder="Sözleşme Adı"
                       value="<?php echo isset($form_error) ? set_value("contract_name") : ""; ?>"
                       name="contract_name">
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("contract_name"); ?></div>
                <?php } ?>
            </div>
            <div class="mb-2">
                <div class="row">
                    <div class="col-12">
                        <div class="col-form-label">Sözleşme İşveren</div>
                        <input type="text"
                               class="form-control <?php cms_isset(form_error("isveren"), "is-invalid", ""); ?>"
                               readonly
                               value="<?php echo isset($form_error) ? set_value("isveren") : company_name($main_contract->yuklenici); ?>"
                               name="isveren">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("isveren"); ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <div class="row">
                    <div class="col-12">
                        <div class="col-form-label">Taşeron/Tedarikçi <i class="fa fa-plus-circle"></i></div>
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
</div>
