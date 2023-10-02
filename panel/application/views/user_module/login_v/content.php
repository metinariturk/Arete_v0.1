<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-card">
                <div>
                    <div>
                        <a class="logo" href="index.html">
                            <img class="img-fluid for-light"
                                 src="<?php echo base_url("assets"); ?>/images/logo/login.png"
                                 alt="looginpage">
                            <img class="img-fluid for-dark"
                                 src="<?php echo base_url("assets"); ?>/images/logo/logo_dark.png"
                                 alt="looginpage"></a>
                    </div>
                    <form action="<?php echo base_url("login/do_login"); ?>" method="post">
                        <div class="login-main">
                            <h4>Hesabınızla Oturum Açın</h4>
                            <p>Kullanıcı ve Şifrenizle Oturum Açınız</p>
                            <div class="form-group">
                                <label class="col-form-label">Kullanıcı Adı</label>
                                <input id="sign-in-email" type="text" class="form-control <?php cms_isset(form_error("user_name"), "is-invalid", ""); ?>"
                                       placeholder="Kullanıcı Adı"
                                       name="user_name"
                                       value="<?php if (isset($form_error)) {
                                           echo set_value("user_name");
                                       } ?>"
                                >
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("user_name"); ?></div>
                                <?php } ?>
                                <?php if (isset($unw)) { ?>
                                    <small class="pull-left input-form-error"> <?php echo "$unw"; ?></small>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Şifre</label>
                                <div class="form-input position-relative">
                                    <input id="sign-in-password" type="password" class="form-control <?php cms_isset(form_error("user_password"), "is-invalid", ""); ?>"
                                           placeholder="Şifre"
                                           name="user_password">
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"><?php echo form_error("user_password"); ?></div>
                                    <?php } ?>
                                    <?php if (isset($unr_pw)) { ?>
                                        <div class="invalid-feedback"> <?php echo "$unr_pw"; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <div class="checkbox p-0">
                                    <input id="checkbox1" type="checkbox">
                                </div>
                                <a class="link" href="<?php echo base_url("sifremi-unuttum"); ?>">Şifremi
                                Unuttum</a>
                                <div class="text-end mt-3">
                                    <button class="btn btn-primary btn-block w-100" type="submit">Oturum Aç</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>