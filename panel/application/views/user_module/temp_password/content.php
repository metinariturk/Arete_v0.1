<div class="page-wrapper">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="login-card">
                    <div>
                        <div>
                            <a class="logo" href="<?php echo base_url("ana-sayfa"); ?>">
                                <img class="img-fluid for-light" width="400px"
                                     src="<?php echo base_url("assets"); ?>/images/logo/login.png" alt="looginpage">
                                <img class="img-fluid for-dark" width="400px"
                                     src="<?php echo base_url("assets"); ?>/images/logo/logo_dark.png" alt="looginpage">
                            </a>
                        </div>

                        <div class="login-main">
                            <form class="theme-form" action="<?php echo base_url("login/renew_password"); ?>"
                                  method="post">
                                <h4>Şifrenizi Yenileyiniz</h4>
                                <p>En az 8 karakterli şifre oluşturunuz</p>
                                <div class="form-group">
                                    <label class="col-form-label">Yeni Şifre</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="user_password" required=""
                                               placeholder="*********">
                                        <div class="show-hide"><span class="show"></span></div>
                                    </div>
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"> <?php echo form_error("user_password"); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Şifre Tekrar</label>
                                    <input class="form-control" type="password" name="confirm_password" required=""
                                           placeholder="*********">
                                </div>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"> <?php echo form_error("confirm_password"); ?></div>
                                <?php } ?>
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="checkbox1" type="checkbox">
                                        <label class="text-muted" for="checkbox1">Şifremi Hatırla</label>
                                    </div>

                                    <button class="btn btn-primary btn-block w-100" type="submit">Şifremi Değiştir</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
