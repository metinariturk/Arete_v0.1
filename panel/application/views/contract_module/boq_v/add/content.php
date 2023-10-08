<?php
if (empty($contract->id or $payment_no)) { ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Sözleşme Seçimi Yapmadan Bu İşleme Devam Edemezsiniz</h4>
                </div>
            </div>
            <div class="card">
                <form id="contract_id"
                      action="<?php echo base_url("$this->Module_Name/new_form/"); ?>"
                      method="post"
                      enctype="multipart">
                    <div class="card-body">
                        <div class="mb-2 col-sm-6">
                            <label class="col-form-label" for="recipient-name">Sözleşme Seçiniz</label>
                            <select class="form-control" name="contract_id">
                                Hakediş oluşturma ekranından metraj yap
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h3>
                                    <?php echo contract_name($contract->id); ?><br> <?php echo $payment_no; ?> No'lu
                                    Hakediş Metrajlarını Yapıyorsunuz
                                </h3>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card">
                <button type="submit" form="save_<?php echo $this->Module_Name; ?>" class="btn btn-success" id="saveButton">
                    <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                </button>
                <form id="save_<?php echo $this->Module_Name; ?>"
                      action="<?php echo base_url("$this->Module_Name/save/$contract->id/$payment_no"); ?>" method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <h5 class="text-center">Önceki Toplam</h5>
                                    <input class="form-control" readonly id="old_payment">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <h5 class="text-center">Bu Toplam</h5>
                                    <input class="form-control" readonly id="this_payment" name="this_payment">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <h5 class="text-center">Genel Toplam</h5>
                                    <input class="form-control" readonly id="total_payment">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
                </form>
                <button id="saveButton">Kaydet</button>
            </div>
        </div>
    </div>
<?php } ?>






