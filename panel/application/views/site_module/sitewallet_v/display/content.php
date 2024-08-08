<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">

            <div class="row">
                <div class="widget">
                    <div class="widget-body">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/main"); ?>
                        <?php if (isset($item->expenses)) { ?>
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/expenses"); ?>
                        <?php } else { ?>
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/deposits"); ?>
                        <?php } ?>
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/gallery"); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">

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
</div>
