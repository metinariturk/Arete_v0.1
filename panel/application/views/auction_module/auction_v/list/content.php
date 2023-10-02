<div class="container-fluid">
    <div class="row project-cards">
        <div class="col-md-12 project-list">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabnav"); ?>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="top-tabContent">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_1"); ?>
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_2"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>