<div class="card">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/common/books"); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 refresh_list">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/common/list"); ?>
                    </div>
                    <div class="col-md-6 refresh_poz">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/common/poz"); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 refresh_explain">
                <div class="row">
                    <div class="col-md-12">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/common/explain"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



