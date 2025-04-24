<div class="mb-2">
    <div class="col-form-label">Alt Sözleşme Kodu - <?php echo $next_contract_name; ?></div>
    <div class="input-group">
        <span class="input-group-text"><?php echo $item->contract_name; ?> - </span>
        <input type="text"
               class="form-control <?php cms_isset(form_error("sub_contract_name"), "is-invalid", ""); ?>"
               placeholder="Alt Sözleşme Adı"
               value="<?php echo isset($form_error) ? set_value("sub_contract_name") : ""; ?>"
               name="sub_contract_name">
    </div>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("sub_contract_name"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="row">
        <div class="col-12">
            <div class="col-form-label">Alt Sözleşme İşveren</div>
            <select id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("sub_isveren"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="sub_isveren">
                <option value="<?php echo isset($form_error) ? set_value("sub_isveren") : $item->yuklenici; ?>"><?php echo isset($form_error) ? company_name(set_value("sub_isveren")) : company_name($item->yuklenici); ?></option>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_isveren"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="mb-2">
    <div class="row">
        <div class="col-12">
            <div class="col-form-label">Taşeron/Tedarikçi</div>
            <select id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("sub_yuklenici"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="sub_yuklenici">
                <option value="<?php echo isset($form_error) ? set_value("sub_yuklenici") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("sub_yuklenici")) : "Seçiniz"; ?></option>
                <?php foreach ($companys as $company) { ?>
                    <option value="<?php echo $company->id; ?>"><?php echo $company->company_name; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_yuklenici"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="mb-2">
    <div class="row">
        <div class="col-6">
            <div class="col-form-label">Sözleşme Bedel</div>
            <input type="number" min="1" step="any" onblur=""
                   class="form-control <?php cms_isset(form_error("sub_sozlesme_bedel"), "is-invalid", ""); ?>"
                   name="sub_sozlesme_bedel"
                   value="<?php echo isset($form_error) ? set_value("sub_sozlesme_bedel") : ""; ?>"
            >
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_sozlesme_bedel"); ?></div>
            <?php } ?>
        </div>
        <div class="col-6">
            <div class="col-form-label">Para Birimi</div>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control <?php cms_isset(form_error("sub_para_birimi"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="sub_para_birimi">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("sub_para_birimi") : ""; ?>">
                    <?php echo isset($form_error) ? set_value("sub_para_birimi") : ""; ?>
                </option>
                <?php
                $para_birimleri = get_as_array($this->settings->para_birimi);
                foreach ($para_birimleri as $para_birimi) {
                    echo "<option value='$para_birimi'>$para_birimi</option>";
                }
                ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_para_birimi"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="mb-2">
    <div class="row">
        <div class="col-6">
            <div class="col-form-label">Teklif Türü</div>
            <select id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("sub_sozlesme_turu"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="sub_sozlesme_turu">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("sub_sozlesme_turu"), null, "", set_value("sub_sozlesme_turu")) : ""; ?>">
                    <?php echo isset($form_error) ? cms_if_echo(set_value("sub_sozlesme_turu"), null, "Seçiniz", set_value("sub_sozlesme_turu")) : ""; ?>
                </option>
                <?php
                $teklif_turleri = get_as_array($this->settings->sozlesme_turu);
                foreach ($teklif_turleri as $teklif_tur) { ?>
                    <option value="<?php echo $teklif_tur; ?>"><?php echo $teklif_tur; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_sozlesme_turu"); ?></div>
            <?php } ?>
        </div>
        <div class="col-6">
            <div class="col-form-label">İşin Türü</div>
            <select id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("sub_isin_turu"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="sub_isin_turu">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("sub_isin_turu"), null, "", set_value("sub_isin_turu")) : ""; ?>">
                    <?php echo isset($form_error) ? cms_if_echo(set_value("sub_isin_turu"), null, "Seçiniz", set_value("sub_isin_turu")) : ""; ?>
                </option>
                <?php
                $is_turleri = get_as_array($this->settings->isin_turu);
                foreach ($is_turleri as $is_turu) { ?>
                    <option value="<?php echo $is_turu; ?>"><?php echo $is_turu; ?></option>";
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_isin_turu"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="mb-2">
    <div class="row">
        <div class="col-6">
            <div class="col-form-label">Sözleşme İmza Tarihi</div>
            <input class="flatpickr form-control <?php cms_isset(form_error("sub_sozlesme_tarih"), "is-invalid", ""); ?>"
                   type="text" id="flatpickr"
                   name="sub_sozlesme_tarih"
                   value="<?php echo isset($form_error) ? set_value("sub_sozlesme_tarih") : ""; ?>"
            >
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_sozlesme_tarih"); ?></div>
            <?php } ?>
        </div>
        <div class="col-6">
            <div class="col-form-label">İşin Süresi (Gün)</div>
            <input type="number" min="1" step="any" onblur=""
                   class="form-control <?php cms_isset(form_error("sub_isin_suresi"), "is-invalid", ""); ?>"
                   name="sub_isin_suresi"
                   value="<?php echo isset($form_error) ? set_value("sub_isin_suresi") : ""; ?>"
            >
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_isin_suresi"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>