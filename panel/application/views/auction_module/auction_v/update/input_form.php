<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-12">
                <div class="file-sidebar">
                    <ul>
                        <li>
                            <div class="btn btn-light">
                                <a href="<?php echo base_url("project/file_form/$item->proje_id"); ?>">
                                    <i data-feather="home"></i>
                                    <?php echo project_code_name($item->proje_id); ?>
                                </a>

                            </div>
                        </li>
                        <li>
                            <div class="btn btn-light">
                                <span style="padding-left: 20px">
                                    <i class="icon-gallery"></i>
                                    <?php echo auction_code_name($item->id); ?>
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Teklif Adı</div>
            <input type="text"
                   class="form-control <?php cms_isset(form_error("ihale_ad"), "is-invalid", ""); ?>"
                   placeholder="Teklif Adı"
                   value="<?php echo isset($form_error) ? set_value("ihale_ad") : "$item->ihale_ad"; ?>"
                   name="ihale_ad">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("ihale_ad"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Teklif Verilecek Kuruluş</div>
            <select id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("isveren"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="isveren">
                <option value="<?php echo isset($form_error) ? set_value("isveren") : "$item->isveren"; ?>"><?php echo isset($form_error) ? company_name(set_value("isveren")) : company_name($item->isveren); ?></option>
                <?php foreach ($employers as $employer) { ?>
                    <option value="<?php echo $employer->id; ?>"><?php echo $employer->company_name; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("isveren"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-9">
                    <div class="col-form-label">Teklif Bütçe Bedel</div>
                    <input type="number" min="1" step="any" onblur=""
                           class="form-control <?php cms_isset(form_error("butce"), "is-invalid", ""); ?>"
                           name="butce"
                           value="<?php echo isset($form_error) ? set_value("butce") : "$item->butce"; ?>"
                    >
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("butce"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-3">
                    <div class="col-form-label">Para Birimi</div>
                    <select id="select2-demo-1" style="width: 100%;" class="form-control" data-plugin="select2"
                            name="para_birimi">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? set_value("para_birimi") : "$item->para_birimi"; ?>">
                            <?php echo isset($form_error) ? set_value("para_birimi") : "$item->para_birimi"; ?>
                        </option>
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
            <div class="col-form-label">Planlanan Teklif Tarihi</div>
            <input class="datepicker-here form-control digits <?php cms_isset(form_error("talep_tarih"), "is-invalid", ""); ?>"
                   type="text"
                   name="talep_tarih"
                   value="<?php echo isset($form_error) ? set_value("talep_tarih") : dateFormat_dmy($item->talep_tarih); ?>"
                   data-options="{ format: 'DD-MM-YYYY' }"
                   data-language="tr">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("talep_tarih"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Yetkili Personeller</div>
            <select class="js-example-placeholder-multiple <?php cms_isset(form_error("yetkili_personeller[]"), "is-invalid", ""); ?> col-sm-12"
                    multiple="multiple"
                    name="yetkili_personeller[]" multiple
                    data-options="{ tags: true, tokenSeparators: [',', ' '] }">
                <?php if (isset($form_error)) { ?>
                    <?php $returns = set_value("yetkili_personeller[]");
                    foreach ($returns as $return) { ?>
                        <option selected
                                value="<?php echo $return; ?>"><?php echo full_name($return); ?></option>
                    <?php } ?>
                <?php } ?>
                <?php if (!empty($item->yetkili_personeller)) {
                    $yetkililer = str_getcsv($item->yetkili_personeller);
                    foreach ($yetkililer as $yetkili) { ?>
                        <option selected value="<?php echo $yetkili; ?>"><?php echo full_name($yetkili); ?></option>
                    <?php }
                } ?>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo $user->name . " " . $user->surname; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("yetkili_personeller[]"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Teklif Genel Notları</div>
            <input type="text"
                   class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", ""); ?>"
                   placeholder="Teklif Adı"
                   value="<?php echo isset($form_error) ? set_value("aciklama") : "$item->aciklama"; ?>"
                   name="aciklama">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>

