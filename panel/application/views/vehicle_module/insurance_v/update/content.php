<div class="container-fluid">
    <div class="row">
        <form action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>" method="post" autocomplete="off">
            <div class="col-md-10">
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
                <div class="row">
                    <div class="widget">
                        <div class="widget-body">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/button_group"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget">
                        <div class="widget-body">
                            <b>Fotoğraf</b>
                        </div>
                    </div>
                </div>
            </div>
            <?php $avatars = (directory_map("$this->File_Dir_Prefix/$item->id"));
            if (!empty($avatars)) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget">
                            <div class="widget-body">
                                <div class="avatar-circle">
                                    <a href="<?php echo base_url("$this->Module_Name/update_form/$item->id"); ?>">
                                        <img class="img-responsive"
                                             src="<?php $avatars = (directory_map("$this->File_Dir_Prefix/$item->id"));
                                             echo base_url("$this->File_Dir_Prefix/$item->id/$avatars[0]"); ?>"
                                             alt="avatar"/>
                                    </a>
                                    <div class="text-center">
                                        <a onclick="deleteConfirmationFile(this)" data-text="Bu Dosyayı"
                                           data-url="<?php echo base_url("$this->Module_Name/fileDelete/$item->id/update_form"); ?>">
                                            <i style="font-size: 25px; color: Tomato;" class="fa fa-times-circle-o"
                                               aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div><!-- .widget-body -->
                            </div><!-- .widget -->
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget">
                            <div class="widget-body">
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
                            </div><!-- .widget-body -->
                        </div><!-- .widget -->
                    </div>
                </div>
            <?php } ?>


        </div>
    </div>
</div>
