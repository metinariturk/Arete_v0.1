<div class="container-fluid">
    <div class="row">
        <form action="<?php echo base_url("$this->Module_Name/save"); ?>" method="post" enctype="multipart/form-data" autocomplete="off" >
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
        </form>
    </div>
</div>





