<div class="container-fluid">
    <form action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>" method="post" autocomplete="off">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="widget">
                        <div class="widget-body">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/inputs/main"); ?>
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/inputs/expense"); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget">
                            <div class="widget-body">
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
                            </div><!-- .widget-body -->
                        </div><!-- .widget -->
                    </div>
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
    </form>
</div>
</div>

