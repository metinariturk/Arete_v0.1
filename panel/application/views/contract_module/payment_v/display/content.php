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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


