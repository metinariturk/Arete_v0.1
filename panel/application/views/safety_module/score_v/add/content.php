<?php
if (empty($safety->id)) { ?>
    <div class="alert alert-info text-center">
        <p>Lütfen Yeni <?php echo $this->Module_Title; ?> Ekle Menüsünden Proje Seçiniz <a
                    href="<?php echo base_url("$this->Module_Name/select"); ?>">tıklayınız</a></p>
    </div>
<?php } else { ?>
    <!-- END column -->
    <div class="container-fluid">
        <div class="row">
            <form action="<?php echo base_url("$this->Module_Name/save/$safety->id/$date"); ?>" method="post" enctype="multipart/form-data" autocomplete="on">
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
<?php } ?>






