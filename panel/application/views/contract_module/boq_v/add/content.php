<?php
if (empty($contract_id)) { ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Sözleşme Seçimi Yapmadan Bu İşleme Devam Edemezsiniz</h4>
                </div>
            </div>
            <div class="card">
                <form id="contract_id"
                      action="<?php echo base_url("Boq/new_form/"); ?>"
                      method="post"
                      enctype="multipart">
                    <div class="card-body">
                        <div class="mb-2 col-sm-6">
                            <label class="col-form-label" for="recipient-name">Sözleşme Seçiniz</label>
                            <select class="form-control" name="contract_id">
                                <?php foreach ($active_contracts as $active_contract) { ?>
                                    <option value="<?php echo "$active_contract->id"; ?>">
                                        <?php echo "$active_contract->contract_name"; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="col-sm-12 col-md-12">
        <form id="save_<?php echo Boq; ?>"
              action="<?php echo base_url("Boq/save/$contract_id/$payment->id/exit"); ?>" method="post"
              enctype="multipart/form-data" autocomplete="off">
            <?php $this->load->view("contract_module/boq_v/add/input_form"); ?>
        </form>
    </div>
<?php } ?>






