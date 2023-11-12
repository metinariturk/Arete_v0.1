<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 box-col-2">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/navtab"); ?>
            </div>
            <div class="col-xxl-10 col-xl-9 col-lg-8 col-md-8 box-col-10">
                <div class="email-right-aside bookmark-tabcontent">
                    <div class="card email-body radius-left">
                        <div class="ps-0">
                            <div class="tab-content">
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_calculate"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_green"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_works_done"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_group_total"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_main_total"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_report"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_info"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_settings"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


