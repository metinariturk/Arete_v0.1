<div class="authentication-main mt-0">
    <div class="row">
        <div class="col-12">
            <div class="login-card">
                <div>
                    <div><a class="logo" href="<?php echo base_url("ana-sayfa"); ?>">
                            <img class="img-fluid for-light" src="<?php echo base_url("assets"); ?>/images/logo/login.png" width="400px" alt="looginpage">
                            <img class="img-fluid for-dark" src="<?php echo base_url("assets"); ?>/images/logo/logo_dark.png" width="400px" alt="looginpage">
                        </a></div>
                    <div class="login-main">
                        <form action="<?php echo base_url("reset-password"); ?>" method="post">
                            <h4>Şifrenizi mi unuttunuz?</h4>
                            <div class="form-group">
                                <label class="col-form-label">E-Posta Adresinizi Giriniz</label>
                                <div class="form-input position-relative">
                                    <input
                                            type="email"
                                            class="form-control"
                                            placeholder="E-posta Adresi"
                                            name="email"
                                            value="<?php echo isset($form_error) ? set_value("email") : ""; ?>">

                                    <?php if(isset($form_error)){ ?>
                                        <div class="invalid-feedback"> <?php echo form_error("email"); ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group mb-0">

                                <button class="btn btn-primary btn-block w-100" type="submit">Şifremi Sıfırla</button>
                            </div>
                            <p class="mt-4 mb-0">Giriş Yapmak İçin?<a class="ms-2" href="<?php echo base_url("login"); ?>">Oturum Aç</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>