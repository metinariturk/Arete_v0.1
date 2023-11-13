<div class="fade tab-pane <?php if ($active_tab == "sign") {
    echo "active show";
} ?>"
     id="sign" role="tabpanel"
     aria-labelledby="sign-tab">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 refresh_calculate_sign">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/signs/calculate_sign"); ?>
            </div>
            <div class="col-md-4 refresh_green_sign">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/signs/green_sign"); ?>
            </div>
            <div class="col-md-4 refresh_works_done_sign">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/signs/works_done_sign"); ?>
            </div>
            <div class="col-md-4 refresh_group_sign">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/signs/group_sign"); ?>
            </div>
            <div class="col-md-4 refresh_main_sign">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/signs/main_sign"); ?>
            </div>
            <div class="col-md-4 refresh_report_sign">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/signs/report_sign"); ?>
            </div>
        </div>
    </div>
</div>


