<div class="row">
    <div class="col-md-12">
        <h4 class="m-b-lg">
            Yeni E-posta Hesabı Ekle
        </h4>
    </div><!-- END column -->
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-body">
                <form action="<?php echo base_url("$this->Module_Name/save"); ?>" method="post" enctype="multipart/form-data" autocomplete="off">

                    <div class="form-group">
                        <label>Protokol</label>
                        <input class="form-control" placeholder="Protokol" name="protocol" value="<?php echo isset($form_error) ? set_value("protocol") : ""; ?>">
                        <?php if(isset($form_error)){ ?>
                            <div class="invalid-feedback"> <?php echo form_error("protocol"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label>E-posta Sunucu Bilgisi</label>
                        <input class="form-control" placeholder="Hostname" name="host" value="<?php echo isset($form_error) ? set_value("host") : ""; ?>">
                        <?php if(isset($form_error)){ ?>
                            <div class="invalid-feedback"> <?php echo form_error("host"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label>Port Numarası</label>
                        <input class="form-control" type="text" placeholder="Port" name="port" value="<?php echo isset($form_error) ? set_value("port") : ""; ?>">
                        <?php if(isset($form_error)){ ?>
                            <div class="invalid-feedback"> <?php echo form_error("port"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label>E-posta Adresi (User)</label>
                        <input class="form-control" type="email" placeholder="User" name="user" value="<?php echo isset($form_error) ? set_value("user") : ""; ?>">
                        <?php if(isset($form_error)){ ?>
                            <div class="invalid-feedback"> <?php echo form_error("user"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label>E-posta Adresine ait Şifre</label>
                        <input class="form-control" type="password" placeholder="Şifre" name="password">
                        <?php if(isset($form_error)){ ?>
                            <div class="invalid-feedback"> <?php echo form_error("password"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label>Kimden Gidecek (from)</label>
                        <input class="form-control" type="email" placeholder="From" name="from" value="<?php echo isset($form_error) ? set_value("from") : ""; ?>">
                        <?php if(isset($form_error)){ ?>
                            <div class="invalid-feedback"> <?php echo form_error("from"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label>Kime Gidecek (to)</label>
                        <input class="form-control" type="email" placeholder="to" name="to" value="<?php echo isset($form_error) ? set_value("to") : ""; ?>">
                        <?php if(isset($form_error)){ ?>
                            <div class="invalid-feedback"> <?php echo form_error("to"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label>E-posta Başlık</label>
                        <input class="form-control" type="text" placeholder="E-posta başlık" name="user_name" value="<?php echo isset($form_error) ? set_value("user_name") : ""; ?>">
                        <?php if(isset($form_error)){ ?>
                            <div class="invalid-feedback"> <?php echo form_error("user_name"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="row content-container">
                        <div id="left" class="text-left">
                            <a class="pager-btn btn btn-purple btn-outline"
                               href="<?php echo base_url("$this->Module_Name"); ?>">
                                <i class="fas fa-arrow-left"></i>
                                E Posta Listesine Geri Dön
                            </a>
                        </div>
                        <div id="right" class="text-right">
                            <button type="submit"class="pager-btn btn btn-info btn-outline"><i class="fa fa-floppy-o" aria-hidden="true"></i> Kaydet</button>
                        </div>
                    </div>
                </form>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->
</div>