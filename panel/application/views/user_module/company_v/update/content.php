<div class="container-fluid">
    <div class="edit-profile">
        <form id="update_company"
              action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>" method="post"
              enctype="multipart/form-data" autocomplete="off">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            Firma Genel Bilgileri
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <div class="col-form-label">Firma Adı</div>
                                <input type="text" name="company_name"
                                       class="form-control <?php cms_isset(form_error("company_name"), "is-invalid", ""); ?>"
                                       value="<?php echo isset($form_error) ? set_value("company_name") : "$item->company_name"; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("profession"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="col-form-label">Firma Rolü</div>
                                        <select
                                                class="form-control <?php cms_isset(form_error("company_role"), "is-invalid", ""); ?>"
                                                data-plugin="select2"
                                                name="company_role">
                                            <option selected="selected"
                                                    value="<?php echo isset($form_error) ? set_value("company_role") : "$item->company_role"; ?>">
                                                <?php echo isset($form_error) ? set_value("company_role") : "$item->company_role"; ?>
                                            </option>

                                            <?php
                                            $sozlesme_taraflari = get_as_array($settings->sozlesme_taraflari);
                                            foreach ($sozlesme_taraflari as $sozlesme_tarafi) { ?>
                                                <option value="<?php echo $sozlesme_tarafi; ?>"><?php echo $sozlesme_tarafi; ?></option>";
                                            <?php } ?>

                                        </select>
                                        <?php if (isset($form_error)) { ?>
                                            <div class="invalid-feedback"><?php echo form_error("company_role"); ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-6">
                                        <div class="col-form-label">İş Grubu</div>
                                        <select style="width: 100%" id="select2-demo-1"
                                                class="form-control <?php cms_isset(form_error("profession"), "is-invalid", ""); ?>"
                                                data-plugin="select2" name="profession">
                                            <option value="<?php echo isset($form_error) ? set_value("profession") : "$item->profession"; ?>"><?php echo isset($form_error) ? set_value("profession") : "$item->profession"; ?></option>
                                            <?php work_groups(); ?>
                                        </select>
                                        <?php if (isset($form_error)) { ?>
                                            <div class="invalid-feedback"><?php echo form_error("profession"); ?></div>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-3">
                                        <label>Vergi Dairesi İl</label>
                                        <select name="tax_city"
                                                class="form-control <?php cms_isset(form_error("tax_city"), "is-invalid", ""); ?>">
                                            <option id="tax_cityOption"
                                                    value="<?php echo isset($form_error) ? set_value("tax_city") : "$item->tax_city"; ?>"
                                                    data-url="<?php echo base_url("$this->Module_Name/get_tax_office/"); ?>"
                                            >
                                                <?php echo isset($form_error) ? city_name(set_value("tax_city")) : city_name($item->tax_city); ?>
                                            </option>
                                            <?php foreach ($cities as $city) { ?>
                                                <option id="tax_cityOption"
                                                        data-url="<?php echo base_url("$this->Module_Name/get_tax_office/"); ?>"
                                                        value="<?php echo $city->id; ?>"><?php echo $city->city_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php if (isset($form_error)) { ?>
                                            <small class="pull-left input-form-error"><?php echo form_error("tax_city"); ?></small>
                                        <?php } ?>
                                    </div>
                                    <div class="col-4">
                                        <label>Vergi Dairesi</label>
                                        <select name="tax_office"
                                                class="form-control <?php cms_isset(form_error("tax_office"), "is-invalid", ""); ?>">
                                            <option value="<?php echo isset($form_error) ? set_value("tax_office") : "$item->tax_office"; ?>">
                                                <?php echo isset($form_error) ? tax_office_name(set_value("tax_office")) : tax_office_name($item->tax_office); ?>
                                            </option>
                                        </select>
                                        <?php if (isset($form_error)) { ?>
                                            <small class="pull-left input-form-error"><?php echo form_error("tax_office"); ?></small>
                                        <?php } ?>
                                    </div>
                                    <div class="col-5">
                                        <label>Vergi No</label>
                                        <input type="text" name="tax_no"
                                               class="form-control <?php cms_isset(form_error("tax_no"), "is-invalid", ""); ?>"
                                               value="<?php echo isset($form_error) ? set_value("tax_no") : "$item->tax_no"; ?>">
                                        <?php if (isset($form_error)) { ?>
                                            <small class="pull-left input-form-error"><?php echo form_error("tax_no"); ?></small>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-3">
                                        <label>Adres İl</label>
                                        <select name="adress_city"
                                                class="form-control <?php cms_isset(form_error("adress_city"), "is-invalid", ""); ?>">
                                            <option id="adress_cityOption"
                                                    value="<?php echo isset($form_error) ? set_value("adress_city") : "$item->adress_city"; ?>"
                                                    data-url="<?php echo base_url("$this->Module_Name/get_district/"); ?>"
                                            >
                                                <?php echo isset($form_error) ? city_name(set_value("adress_city")) : city_name($item->adress_city); ?>
                                            </option>
                                            <?php foreach ($cities as $city) { ?>
                                                <option id="tax_cityOption"
                                                        data-url="<?php echo base_url("$this->Module_Name/get_district/"); ?>"
                                                        value="<?php echo $city->id; ?>"><?php echo $city->city_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php if (isset($form_error)) { ?>
                                            <small class="pull-left input-form-error"><?php echo form_error("tax_city"); ?></small>
                                        <?php } ?>
                                    </div>
                                    <div class="col-4">
                                        <label>Adres İlçe</label>
                                        <select name="adress_district"
                                                class="form-control <?php cms_isset(form_error("adress_district"), "is-invalid", ""); ?>">
                                            <option value="<?php echo isset($form_error) ? set_value("adress_district") : "$item->adress_district"; ?>">
                                                <?php echo isset($form_error) ? district_name(set_value("adress_district")) : district_name($item->adress_district); ?>
                                            </option>
                                        </select>
                                        <?php if (isset($form_error)) { ?>
                                            <small class="pull-left input-form-error"><?php echo form_error("adress_district"); ?></small>
                                        <?php } ?>
                                    </div>
                                    <div class="col-5">
                                        <label>Adres</label>
                                        <input type="text" name="adress"
                                               class="form-control <?php cms_isset(form_error("adress"), "is-invalid", ""); ?>"
                                               value="<?php echo isset($form_error) ? set_value("adress") : "$item->adress"; ?>">
                                        <?php if (isset($form_error)) { ?>
                                            <small class="pull-left input-form-error"><?php echo form_error("tax_no"); ?></small>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-3">
                                        <label>Banka</label>
                                        <select name="bank"
                                                class="form-control <?php cms_isset(form_error("bank"), "is-invalid", ""); ?>">
                                            <option selected="selected"
                                                    value="<?php echo isset($form_error) ? set_value("bank") : "$item->bank"; ?>">
                                                <?php echo isset($form_error) ? set_value("bank") : "$item->bank"; ?>
                                            </option>

                                            <?php
                                            $bankalar = get_as_array($settings->bankalar);
                                            foreach ($bankalar as $banka) { ?>
                                                <option value="<?php echo $banka; ?>"><?php echo $banka; ?></option>";
                                            <?php } ?>
                                        </select>
                                        <?php if (isset($form_error)) { ?>
                                            <small class="pull-left input-form-error"><?php echo form_error("bank"); ?></small>
                                        <?php } ?>
                                    </div>

                                    <div class="col-5">
                                        <label>IBAN</label>
                                        <div class="input-group">
                                            <span class="input-group-text">TR</span>
                                            <input name="IBAN" class="form-control <?php cms_isset(form_error("IBAN"), "is-invalid", ""); ?>"
                                                   type="number" aria-label="Sadece Sayılar" maxlength="26" minlength="26"
                                                   value="<?php echo isset($form_error) ? set_value("IBAN") : "$item->IBAN"; ?>">
                                        </div>
                                        <?php if (isset($form_error)) { ?>
                                            <small class="pull-left input-form-error"><?php echo form_error("IBAN"); ?></small>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-4">
                                        <label>E Posta</label>
                                        <input type="text" name="email"
                                               class="form-control <?php cms_isset(form_error("email"), "is-invalid", ""); ?>""
                                        value="<?php echo isset($form_error) ? set_value("email") : "$item->email"; ?>">
                                        <?php if (isset($form_error)) { ?>
                                            <small class="pull-left input-form-error"><?php echo form_error("email"); ?></small>
                                        <?php } ?>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">Telefon</label> <span
                                                id="formattedPhoneNumber"><?php echo formatPhoneNumber($item->phone); ?></span>
                                        <input type="text" name="phone" placeholder="5XX XXX XX XX" id="phoneInput"
                                               oninput="formatAndDisplayPhoneNumber()" maxlength="10"
                                               class="form-control <?php cms_isset(form_error("phone"), "is-invalid", ""); ?>"
                                               value="<?php echo isset($form_error) ? set_value("phone") : "$item->phone"; ?>">
                                        <?php if (isset($form_error)) { ?>
                                            <div class="invalid-feedback"><?php echo form_error("phone"); ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-4">
                                        <label>Yetkili</label>
                                        <select style="width: 100%" id="select2-demo-1"
                                                class="form-control <?php cms_isset(form_error("executive"), "is-invalid", ""); ?>"
                                                data-plugin="select2" name="executive">
                                            <option selected="selected"
                                                    value="<?php echo isset($form_error) ? set_value("executive") : "$item->executive"; ?>"><?php echo isset($form_error) ? full_name(set_value("executive")) : full_name($item->executive); ?></option>
                                            <?php foreach ($executive_users as $executive_user) { ?>
                                                <option value="<?php echo $executive_user->id; ?>"><?php echo full_name($executive_user->id); ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php if (isset($form_error)) { ?>
                                            <small class="pull-left input-form-error"><?php echo form_error("executive"); ?></small>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            Logo
                        </div>

                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="card hovercard text-center">
                                    <div class="cardheader">
                                        <div class="avatar_list_container">
                                            <div class="content-container">
                                                <?php if (company_avatar_isset($item->id)) { ?>
                                                    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/avatar"); ?>
                                                <?php } else { ?>
                                                    <div data-url="<?php echo base_url("$this->Module_Name/refresh_file_list/$item->id"); ?>"
                                                         action="<?php echo base_url("$this->Module_Name/file_upload/$item->id"); ?>"
                                                         id="dropzone_avatar" class="dropzone"
                                                         data-plugin="dropzone"
                                                         data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id"); ?>'}">
                                                        <div class="dz-message">
                                                            <i class="fa-solid fa-cloud-arrow-up fa-4x"></i>
                                                            <h3>Firma Logosunu Buraya Bırakınız</h3>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php echo validation_errors(); ?>