<?php $proje_id = get_from_id("auction", "proje_id", $auc_id); ?>
<div class="card">
    <?php if (!empty($istekliler)) { ?>
        <div class="card-body">
            <div class="mb-2">
                <div class="col-form-label">Dosya No</div>
                <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">TKL</span>
                    <?php if (!empty(get_last_fn("offer"))) { ?>
                        <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                               type="number" placeholder="Dosya No" aria-describedby="inputGroupPrepend"
                               data-bs-original-title="" title="" name="dosya_no"
                               value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("offer"); ?>">
                        <?php
                    } else { ?>
                        <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                               type="number" placeholder="Dosya No" aria-describedby="inputGroupPrepend"
                               required="" data-bs-original-title="" title="" name="dosya_no"
                               value="<?php echo isset($form_error) ? set_value("dosya_no") : fill_empty_digits() . "1" ?>">
                    <?php } ?>

                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("dosya_no"); ?></div>
                        <div class="invalid-feedback">* Önerilen Proje Kodu
                            : <?php echo increase_code_suffix("offer"); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-1">
                    <p>#</p>
                </div>
                <?php
                foreach ($istekliler as $istekli) { ?>
                    <div class="col-sm-2 text-center">
                        <h4><?php echo company_name($istekli); ?></h4>
                    </div>
                <?php } ?>
                <div class="repeater">
                    <div data-repeater-list="offers">
                        <hr>
                        <div data-repeater-item>
                            <div class="row">
                                <div class="col-sm-1">
                                    <p>#</p>
                                </div>
                                <?php
                                foreach ($istekliler as $istekli) { ?>
                                    <div class="col-sm-2">
                                        <input class="form-control" required type="number" step="any"
                                               name="offer[<?php echo $istekli; ?>]">
                                    </div>
                                <?php } ?>
                                <div class="col-sm-2">
                                    <input data-repeater-delete type="button" class="btn btn-danger" value="Satır Sil"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <input data-repeater-create type="button" class="btn btn-success" value="Satır Ekle"/>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-sm-8 offset-sm-2">
            <div class="alert alert-dark outline alert-dismissible fade show" role="alert"><i
                        data-feather="alert-triangle"></i>
                <p>
                    <b>İhaleye Ait İstekli ve Yeterlilik Kontrolü Yapmalısınız! </b>
                    <a href="<?php echo base_url("auction/file_form/$auc_id/bidder"); ?>">
                        Buradan istekli ekleyiniz
                    </a>
                </p>
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php } ?>
</div>

