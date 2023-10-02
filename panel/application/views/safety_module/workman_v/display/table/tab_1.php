<?php $contract_id = get_from_id("site", "contract_id", "$item->site_id") ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tickets/main_ticket"); ?>
        </div>
        <div class="col-md-3">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tickets/education_ticket"); ?>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tickets/debit_ticket"); ?>
        </div>
        <div class="col-md-3">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tickets/accident_ticket"); ?>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tickets/checkup_ticket"); ?>
        </div>
        <div class="col-md-3">
            <div class="bg-color-op-green">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
            </div>
            <hr>
            <div class="bg-color-op-blue image_list_container">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
            </div>
        </div>
    </div>
</div>