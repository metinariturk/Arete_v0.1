<form id="update_auction" action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="row">
        <div class="col-6">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="file-content">
                    <div class="card-header">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
                    </div>
                    <div class="image_list_container">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>






