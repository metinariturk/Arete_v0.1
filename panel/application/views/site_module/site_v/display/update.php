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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <div class="col-form-label">Şantiye Kodu</div>
                                    <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">SNT</span>
                                        <?php if (!empty(get_last_fn("site"))) { ?>
                                            <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                                                   type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                                                   data-bs-original-title="" title="" name="dosya_no"
                                                   value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("site"); ?>">
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
                                                : <?php echo increase_code_suffix("site"); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="col-form-label">Şantiye Adı</div>
                                    <input type="text"
                                           class="form-control <?php cms_isset(form_error("santiye_ad"), "is-invalid", ""); ?>"
                                           placeholder="Şantiye Adı"
                                           value="<?php echo isset($form_error) ? set_value("santiye_ad") : ""; ?>"
                                           name="santiye_ad">
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"><?php echo form_error("santiye_ad"); ?></div>
                                    <?php } ?>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <div class="col-form-label">Şantiye Sorumlusu</div>
                                    <select id="select2-demo-1" style="width: 100%;"
                                            class="form-control <?php cms_isset(form_error("santiye_sefi"), "is-invalid", ""); ?>"
                                            data-plugin="select2"
                                            name="santiye_sefi">
                                        <option selected
                                                value="<?php echo isset($form_error) ? set_value("santiye_sefi") : ""; ?>"><?php echo isset($form_error) ? full_name(set_value("santiye_sefi")) : "Seçiniz"; ?></option>
                                        <?php
                                        foreach ($users as $user) { ?>
                                            <option value="<?php echo $user->id; ?>"><?php echo full_name($user->id); ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"><?php echo form_error("santiye_sefi"); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-2">
                                    <div class="col-form-label">Yetkili Personeller</div>
                                    <select class="js-example-placeholder-multiple col-sm-12  <?php cms_isset(form_error("teknik_personeller"), "is-invalid", ""); ?>"
                                            multiple="multiple" name="teknik_personeller[]" multiple
                                            data-options="{ tags: true, tokenSeparators: [',', ' '] }">
                                        <?php if (isset($form_error)) { ?>
                                            <?php $returns = set_value("teknik_personeller[]");
                                            foreach ($returns as $return) { ?>
                                                <option selected
                                                        value="<?php echo $return; ?>"><?php echo full_name($return); ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php foreach ($users as $user) { ?>
                                            <option value="<?php echo $user->id; ?>"><?php echo $user->name . " " . $user->surname; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"><?php echo form_error("teknik_personeller"); ?></div>
                                    <?php } ?>
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
