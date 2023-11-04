<div class="card">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/book_table"); ?>
                    </div>
                    <div class="col-md-3 refresh_addmain">
                        <?php if (!empty($book_id)) { ?>
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/main_group"); ?>
                        <?php } ?>
                    </div>
                    <div class="col-md-3 refresh_addsub">
                        <?php if (!empty($main_id)) { ?>
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sub_group"); ?>
                        <?php } ?>
                    </div>
                    <div class="col-md-3 refresh_addtitle">
                        <?php if (!empty($sub_id)) { ?>
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/title"); ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 refresh_additem">
                        <?php if (!empty($sub_id)) { ?>
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/item"); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


