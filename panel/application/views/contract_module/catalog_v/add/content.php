<?php
if (empty($contract_id)) { ?>
    <form id="contract_id"
          action="<?php echo base_url("$this->Module_Name/new_form/"); ?>"
          method="post"
          enctype="multipart">
        <div class="mb-3">
            <label class="col-form-label" for="recipient-name">Sözleşme Seçiniz</label>
            <select class="form-control" name="contract_id">
                <?php foreach ($active_contracts as $active_contract) { ?>
                    <option value="<?php echo "$active_contract->id"; ?>">
                        <?php echo "$active_contract->sozlesme_ad"; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </form>
<?php } else { ?>
    <form id="save_catalog"
          action="<?php echo base_url("$this->Module_Name/save/$contract_id"); ?>" method="post"
          enctype="multipart/form-data" autocomplete="off">
        <div class="row">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>

        </div>

    </form>
<?php } ?>






