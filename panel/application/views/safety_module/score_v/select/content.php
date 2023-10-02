<form action="<?php echo base_url("$this->Module_Name/new_form/score_newform"); ?>" method="post" enctype="multipart">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="widget">
                        <div class="widget-body">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="widget">
                        <div class="widget-body">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/button_group"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


