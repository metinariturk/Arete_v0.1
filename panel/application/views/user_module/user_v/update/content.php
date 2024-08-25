<div class="container-fluid">
    <div class="edit-profile">
        <form id="update_user"
              action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>" method="post"
              enctype="multipart/form-data" autocomplete="off">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Kullanıcı Profili</h4>
                            <div class="card-options"><a class="card-options-collapse" href="#"
                                                         data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="profile-title">
                                    <div class="media">
                                        <img class="img-70 rounded-circle" alt="" <?php echo get_avatar($item->id); ?>>
                                        <div class="media-body">
                                            <h5 class="mb-1">
                                                <a href="<?php echo base_url("user/file_form/$item->id"); ?>"> <?php echo full_name($item->id); ?></a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Kullanıcı Adı
                                    <span data-tooltip-location="bottom"
                                          data-tooltip="Bu karakterleri kullanamazsınız ?*:/@|<-çÇğĞüÜöÖıİşŞ.!'?*|=()[]{}>">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                </label>
                                <input class="form-control <?php cms_isset(form_error("user_name"), "is-invalid", ""); ?>"
                                       name="user_name"
                                       value="<?php echo isset($form_error) ? set_value("user_name") : $item->user_name; ?>"/>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("user_name"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-Posta Adresi</label>
                                <input class="form-control <?php cms_isset(form_error("email"), "is-invalid", ""); ?>"
                                       name="email"
                                       value="<?php echo isset($form_error) ? set_value("email") : $item->email; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("email"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Şifreyi Değiştir</label>
                                <input class="form-control <?php cms_isset(form_error("password"), "is-invalid", ""); ?>"
                                       name="password" type="password" value="<?php echo isset($form_error) ? set_value("password") : ""; ?>" autocomplete="new-password">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("password"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Şifreyi Tekrar</label>
                                <input class="form-control <?php cms_isset(form_error("password_check"), "is-invalid", ""); ?>"
                                       name="password_check" type="password"  autocomplete="new-password">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("password_check"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Adı</label>
                                <input class="form-control <?php cms_isset(form_error("name"), "is-invalid", ""); ?>"
                                       type="text" name="name"
                                       value="<?php echo isset($form_error) ? set_value("name") : "$item->name"; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("name"); ?></div>
                                <?php } ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Soyadı</label>
                                <input class="form-control <?php cms_isset(form_error("surname"), "is-invalid", ""); ?>"
                                       type="text" name="surname"
                                       value="<?php echo isset($form_error) ? set_value("surname") : "$item->surname"; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("surname"); ?></div>
                                <?php } ?>
                            </div>



                            <div class="mb-3">
                                <label class="form-label">Ünvan</label>
                                <input type="text" name="unvan"
                                       class="form-control <?php cms_isset(form_error("unvan"), "is-invalid", ""); ?>"
                                       value="<?php echo isset($form_error) ? set_value("unvan") : "$item->unvan"; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("unvan"); ?></div>
                                <?php } ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Meslek</label>
                                <select class="form-control <?php cms_isset(form_error("profession"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="profession">
                                    <option value="<?php echo isset($form_error) ? set_value("profession") : "$item->profession"; ?>">
                                        <?php echo isset($form_error) ? set_value("profession") : "$item->profession"; ?>
                                    </option>
                                    <?php foreach (str_getcsv($settings->meslek) as $profession) { ?>
                                        <option value="<?php echo $profession; ?>"><?php echo $profession; ?></option>
                                    <?php } ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("profession"); ?></div>
                                <?php } ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Firma</label>
                                <select class="form-control" data-plugin="select2" name="company">
                                    <option value="<?php echo isset($form_error) ? set_value("company") : $item->company; ?>"><?php echo isset($form_error) ? company_name(set_value("company")) : company_name($item->company); ?></option>
                                    <?php foreach ($companys as $company) { ?>
                                        <option value="<?php echo $company->id; ?>"><?php echo $company->company_name; ?></option>
                                    <?php } ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("company"); ?></div>
                                <?php } ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Telefon</label> <span id="formattedPhoneNumber"><?php echo formatPhoneNumber($item->phone); ?></span>
                                <input type="text" name="phone" placeholder="5XX XXX XX XX" id="phoneInput" maxlength="11"
                                       class="form-control <?php cms_isset(form_error("phone"), "is-invalid", ""); ?>"
                                       value="<?php echo isset($form_error) ? set_value("phone") : "$item->phone"; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("phone"); ?></div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/permission"); ?>
            </div>
        </form>
    </div>
</div>

<button class="btn btn-danger" type="button" onclick="cancelConfirmationModule(this)"
        url="<?php echo base_url("User/file_form/$item->id"); ?>">
    <i class="menu-icon fa fa-close fa-lg" aria-hidden="true"></i> İptal
</button>
<button type="submit" form="update_user" class="btn btn-success">
    <i class="fa fa-floppy-o fa-lg"></i> Kaydet
</button>
