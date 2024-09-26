<div class="container-fluid">
    <div class="row">
        <div class="row">
            <div class="col-md-6 refresh_owner_sign">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/signs/owner_sign"); ?>
            </div>
            <div class="col-md-6 refresh_owner_staff">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/signs/owner_staff"); ?>
            </div>
            <div class="col-md-6 refresh_contractor_sign">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/signs/contractor_sign"); ?>
            </div>
            <div class="col-md-6 refresh_contractor_staff">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/signs/contractor_staff"); ?>
            </div>
        </div>
    </div>
</div>