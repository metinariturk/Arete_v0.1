<div class="fade tab-pane <?php if ($active_tab == "payment") {
    echo "active show";
} ?>"
     id="payment" role="tabpanel"
     aria-labelledby="payment-tab">

    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6>Hakediş</h6>
            <ul>
                <li>
                    <div class="container-fluid">
                        <div class="page-title">
                            <div class="row">
                                <ol class="breadcrumb">
                                    <li>
                                        <button class="btn btn-primary"
                                                type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_payment"
                                                data-whatever="@getbootstrap">
                                            <i class="menu-icon fa fa-edit fa-lg"></i>
                                            Yeni Hakediş
                                            Oluştur
                                        </button>

                                        <div class="modal fade" id="modal_payment" tabindex="-1"
                                             role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Yeni <?php echo $this->Module_Title; ?></h5>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="payment_form"
                                                              action="<?php echo base_url("payment/create/$item->id"); ?>"
                                                              method="post"
                                                              enctype="multipart">
                                                            <div class="mb-3">
                                                                <label class="col-form-label" for="recipient-name">Hakediş
                                                                    Bilgileri</label>
                                                                <?php print_r($form_errors); ?>
                                                                <div class="row">
                                                                    <div class="col-sm-5">
                                                                        <div class="col-form-label">Son İmalat
                                                                            Tarihi<br>
                                                                            <label for="customer-checkbox2">&nbsp;</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-7">
                                                                        <input class="form-control" type="number" name="hakedis_no"
                                                                               value="<?php echo last_payment($item->id); ?>" onblur="calcular()"
                                                                               onfocus="calcular()">
                                                                        <input class="datepicker-here form-control digits <?php cms_isset(form_error("imalat_tarihi"), "is-invalid", ""); ?>"
                                                                               type="text" style="width: 100%"
                                                                               name="imalat_tarihi"
                                                                               value="<?php echo isset($form_error) ? set_value("imalat_tarihi") : ""; ?>"
                                                                               data-options="{ format: 'DD-MM-YYYY' }"
                                                                               data-language="tr">
                                                                        <?php if (isset($form_error)) { ?>
                                                                            <div class="invalid-feedback"><?php echo form_error("imalat_tarihi"); ?></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button"
                                                                data-bs-dismiss="modal">
                                                            Kapat
                                                        </button>
                                                        <button class="btn btn-primary" form="payment_form"
                                                                type="submit">
                                                            Oluştur
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/payment"); ?>
        </div>
    </div>
</div>