<div class="fade tab-pane <?php if ($active_tab == "condition") {
    echo "active show";
} ?>"

     id="sartname" role="tabpanel"
     aria-labelledby="sartname-tab">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-4 col-lg-12 col-md-12 box-col-10">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/condition"); ?>
                </div>
                <div class="col-xl-4 col-lg-12 col-md-12 box-col-10">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/technical"); ?>
                </div>
                <div class="col-xl-4 col-lg-12 col-md-12 box-col-10">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/safety"); ?>
                </div>
            </div>
        </div>
    </div>
</div>
