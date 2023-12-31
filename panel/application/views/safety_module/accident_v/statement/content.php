<div class="container-fluid">
    <div class="row">
        <form action="<?php echo base_url("$this->Module_Name/statement/$item->id"); ?>" method="post" autocomplete="off">
            <div class="col-md-6">
                <div class="row">
                    <div class="widget">
                        <div class="widget-body">
                            <b>Genel Bilgiler</b>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="widget">
                        <div class="widget-body">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget">
                            <div class="widget-body">
                                <b>Dosya Yönetimi</b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget">
                            <div class="widget-body">
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
                            </div><!-- .widget-body -->
                        </div><!-- .widget -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="widget">
                            <div class="widget-body image_list_container">
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
                            </div><!-- .widget-body -->
                        </div><!-- .widget -->
                    </div>
                    <div class="col-md-5">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/necessary_papers"); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
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