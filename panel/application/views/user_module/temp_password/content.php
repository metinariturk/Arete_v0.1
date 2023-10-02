<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-card">
                <div>
                    <div>
                        <a class="logo" href="<?php echo base_url("ana-sayfa"); ?>">
                            <img class="img-fluid for-light"
                                 src="<?php echo base_url("assets"); ?>/images/logo/login.png"
                                 alt="looginpage">
                            <img class="img-fluid for-dark"
                                 src="<?php echo base_url("assets"); ?>/images/logo/logo_dark.png"
                                 alt="looginpage"></a>
                    </div>
                    <form action="<?php echo base_url("login/renew_password"); ?>" method="post">
                        <div class="login-main">
                            <h4>Şifrenizi Yenileyiniz</h4>
                            <p>En az 8 karakterli şifre oluşturunuz</p>
                            <div class="form-group">
                                <label class="col-form-label">Şifre</label>
                                <input id="sign-in-password" type="password" class="form-control" placeholder="Şifre"
                                       name="user_password">
                                <small class="pull-left input-form-success">*En Az 8 Karakter Şifre Belirleyiniz</div>
                                <br>

                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("user_password"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Şifre Tekrar</label>
                                <input id="sign-in-password" type="password" class="form-control" placeholder="Şifre Tekrar"
                                       name="confirm_password">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("confirm_password"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="form-group mb-0">
                                <div class="text-end mt-3">
                                    <button class="btn btn-primary btn-block w-100" type="submit">Şifremi Değiştir</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>