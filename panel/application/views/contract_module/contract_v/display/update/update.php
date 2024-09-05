<a style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#updateFormModal"
   data-whatever="@getbootstrap"><i class="fa fa-edit"></i><?php echo $item->dosya_no; ?></a>
<div class="modal fade" id="updateFormModal" tabindex="-1" role="dialog" aria-labelledby="updateFormModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Burada modal-lg sınıfını ekledik -->
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0">Sözleşme Bilgilerini Düzenle</h3>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" novalidate=""
                          action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>" method="post"
                          enctype="multipart/form-data">
                        <div class="card-header">
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-form-label">Ana Sözleşme Ad</div>

                                        <div class="input-group">
                                                <span class="input-group-text"
                                                      id="inputGroupPrepend"><?php echo $item->dosya_no; ?></span>
                                            <input class="form-control <?php cms_isset(form_error("contract_name"), "is-invalid", ""); ?>"
                                                   name="contract_name"
                                                   value="<?php echo isset($form_error) ? set_value("contract_name") : $item->contract_name; ?>"/>
                                        </div>
                                        <?php if (isset($form_error)) { ?>
                                            <div class="invalid-feedback"><?php echo form_error("contract_name"); ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-form-label">Sözleşme İşveren</div>
                                        <select id="select2-demo-1"
                                                class="form-control <?php cms_isset(form_error("isveren"), "is-invalid", ""); ?>"
                                                data-plugin="select2" name="isveren">
                                            <option value="<?php echo isset($form_error) ? set_value("isveren") : "$item->isveren"; ?>"><?php echo isset($form_error) ? company_name(set_value("isveren")) : company_name($item->isveren); ?></option>
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
                                        <div class="col-form-label">Taşeron/Tedarikçi</div>
                                        <select id="select2-demo-1"
                                                class="form-control <?php cms_isset(form_error("yuklenici"), "is-invalid", ""); ?>"
                                                data-plugin="select2" name="yuklenici">
                                            <option value="<?php echo isset($form_error) ? set_value("yuklenici") : "$item->yuklenici"; ?>"><?php echo isset($form_error) ? company_name(set_value("yuklenici")) : company_name($item->yuklenici); ?></option>
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
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="col-form-label">Teklif Türü</div>
                                        <select id="select2-demo-1"
                                                class="form-control <?php cms_isset(form_error("sozlesme_turu"), "is-invalid", ""); ?>"
                                                data-plugin="select2"
                                                name="sozlesme_turu">
                                            <option selected="selected"
                                                    value="<?php echo isset($form_error) ? cms_if_echo(set_value("sozlesme_turu"), null, "", set_value("sozlesme_turu")) : $item->sozlesme_turu; ?>">
                                                <?php echo isset($form_error) ? cms_if_echo(set_value("sozlesme_turu"), null, "Seçiniz", set_value("sozlesme_turu")) : $item->sozlesme_turu; ?>
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
                                                    value="<?php echo isset($form_error) ? cms_if_echo(set_value("isin_turu"), null, "", set_value("isin_turu")) : $item->isin_turu; ?>">
                                                <?php echo isset($form_error) ? cms_if_echo(set_value("isin_turu"), null, "Seçiniz", set_value("isin_turu")) : $item->isin_turu; ?>
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
                                               value="<?php echo isset($form_error) ? set_value("sozlesme_tarih") : dateFormat_dmy($item->sozlesme_tarih); ?>"
                                               data-options="{ format: 'DD-MM-YYYY' }"
                                               data-language="tr">
                                        <?php if (isset($form_error)) { ?>
                                            <div class="invalid-feedback"><?php echo form_error("sozlesme_tarih"); ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-6">
                                        <div class="col-form-label">İşin Süresi (Gün)</div>
                                        <input class="form-control <?php cms_isset(form_error("isin_suresi"), "is-invalid", ""); ?>"
                                               name="isin_suresi" type="number"
                                               value="<?php echo isset($form_error) ? set_value("isin_suresi") : $item->isin_suresi; ?>"/>
                                        <?php if (isset($form_error)) { ?>
                                            <div class="invalid-feedback"><?php echo form_error("isin_suresi"); ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="col-form-label">Sözleşme Bedel</div>
                                        <input type="number" min="1" step="any" onblur=""
                                               class="form-control <?php cms_isset(form_error("sozlesme_bedel"), "is-invalid", ""); ?>"
                                               name="sozlesme_bedel"
                                               value="<?php echo isset($form_error) ? set_value("sozlesme_bedel") : $item->sozlesme_bedel; ?>"
                                        >
                                        <?php if (isset($form_error)) { ?>
                                            <div class="invalid-feedback"><?php echo form_error("sozlesme_bedel"); ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-6">
                                        <div class="col-form-label">Para Birimi</div>
                                        <select id="select2-demo-1" style="width: 100%;"
                                                class="form-control  <?php cms_isset(form_error("para_birimi"), "is-invalid", ""); ?>"
                                                data-plugin="select2"
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
                        </div>
                        <div class="btn-toolbar justify-content-between" role="toolbar"
                             aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="First group">
                                <button class="btn btn-primary" type="submit">Değişiklikleri Kaydet</button>
                            </div>
                            <div class="input-group">

                                <button class="btn btn-danger" type="button"
                                        onclick="deleteConfirmationModule(this)"
                                        data-text="<?php echo $this->Module_Title; ?>"
                                        data-url="<?php echo base_url("$this->Module_Name/delete_form/$item->id"); ?>"
                                        url="<?php echo base_url("$this->Module_Name/delete_form/$item->id"); ?>">
                                    <i class="menu-icon fa fa-trash fa-xl" aria-hidden="true"></i> Sil
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
